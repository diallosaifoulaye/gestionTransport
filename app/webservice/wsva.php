<?php
/**
 * Created by PhpStorm.
 * User: Seyni Faye
 * Date: 02/07/2018
 * Time: 11:49
 */

namespace app\webservice;

use app\core\ApiServer;
use app\core\TokenJWT;
use Jacwright\RestServer\RestException;

class wsva extends ApiServer
{
    private $partenaireModel;
    private $serviceModel;
    private $transactionModel;
    public function __construct()
    {
        parent::__construct(__CLASS__);
        $this->partenaireModel = $this->model("partenaire");
        $this->serviceModel = $this->model("service");
        $this->transactionModel = $this->model("transaction");
    }

    /********************verification token***********************************/
    function authorize()
    {
        $result = intval(TokenJWT::verif($this->token, TOKEN_KEY));
        if($result == -1){
            throw new RestException(401, "Token expiré");
            return false;
        }elseif($result == -2){
            throw new RestException(401, "Token invalide");
            return false;
        }else return true;
    }

    /**
     * Authentification d'un partenaire
     *
     * params : username et password
     *
     * @url POST /authentifier
     *
     * @noAuth
     */
    /********************* AUTHENTIFICATION PARTENAIRE **************************/
    public function authentifier()
    {
        $username = parent::$paramPOST['username'];
        $password = parent::$paramPOST['password'];
        $verif_partenaire = $this->partenaireModel->checkPartenaireExiste($username, $password);
        if(intval($verif_partenaire) > 0)
        {
            $param = [
                "id"=>intval($verif_partenaire),
                "username"=>$username,
                "password"=>$password
            ];
            $new_token = TokenJWT::encode($param,TOKEN_KEY,1);
            return array('token'=>$new_token);
        }
        elseif($verif_partenaire == -1)
        {
            return array('erreurCode'=>9003, 'erreurMessage'=>'Partenaire non activé');
        }
        else return array('erreurCode'=>9004, 'erreurMessage'=>'username ou mot de passe incorrect');
    }


    /**
     * Achat Code Neosurf
     *
     * @url POST /AchatCodeNeosurf
     *
     */
    public function AchatCodeNeosurf()
    {
        $montant = parent::$paramPOST['montant'];
        $idtransaction = parent::$paramPOST['idtransaction'];
        $verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $partenaire = $verif_token->{'id'};
        $service = $this->serviceModel->getIdService('AchatCodeNeosurf');
        $fournisseur = $this->serviceModel->getIdFournisseur('AchatCodeNeosurf');
        $checkPartAccess = $this->partenaireModel->checkPartenaireAccess($partenaire, $service);

        if($checkPartAccess == 1)
        {
            $user_partenaire = $this->partenaireModel->getUserPartenaire($partenaire);
            $soldePartenaire = $this->partenaireModel->getSoldePartenaire($partenaire);
            $commission = $this->transactionModel->getFraisService($service, $montant);
            $partage_commission = $this->transactionModel->getCommissionUnitaire($service, $partenaire);
            $commission_sva = ($commission * $partage_commission->pourcentage_sva)/100;
            $commission_fournisseur = ($commission * $partage_commission->pourcentage_fournisseur)/100;
            $montant_total = intval($montant + $commission_sva + $commission_fournisseur);

            if($soldePartenaire >= $montant_total)
            {
                $statut = 0;
                $num_transac = $this->serviceModel->Generer_numtransaction();
                if(gethostbyname($_SERVER['SERVER_NAME']) === '104.20.252.2' || $_SERVER['HTTP_HOST'] === 'pmp-admin.com')
                {
                    $hach = sha1('EUR'.$montant.'bocar@numherit.com+P@sser123'.$idtransaction.'193'.'1'.'c221diodofdf5g432dfh4ds2s65g1gh6');
                    $parameters = array(
                        'currency'=>'EUR',
                        'hash'=>$hach,
                        'IDProduct'=>$montant,
                        'IDReseller'=>'bocar@numherit.com+P@sser123',
                        'IDTransaction'=>$idtransaction,
                        'IDUser'=>193,
                        'quantity'=>1
                    );
                    $instance = $this->apiClient->neosurfAchat();
                    $instance->service = 'get_dtickets';
                    $instance->params = $parameters;
                    $instance->call();
                    $obj = $instance->response;
                    if($obj['faultcode'] == 2)
                    {
                        $commentaire = 'Adresse IP de connexion non autorisée';
                        $this->transactionModel->saveTransaction($user_partenaire, $service, $partenaire, $montant, $commission, $num_transac, $commentaire, $statut, $obj['faultcode']);
                        $this->transactionModel->saveRetourWebservice('3001', $commentaire, 'AchatCodeNeosurf', $montant.'-'.$idtransaction.'-'.$partenaire, $partenaire);
                        return array('erreurCode'=>3001, 'erreurMessage'=>'Adresse IP de connexion non autorisée');
                    }
                    elseif($obj['faultcode'] == -100 || $obj['faultcode'] == 105 || $obj['faultcode'] == 112 || $obj['faultcode'] == 6)
                    {
                        $commentaire = 'Echec achat code neosurf';
                        $this->transactionModel->saveTransaction($user_partenaire, $service, $partenaire, $montant, $commission, $num_transac, $commentaire, $statut, $obj['faultcode']);
                        $this->transactionModel->saveRetourWebservice('3002', $commentaire, 'AchatCodeNeosurf', $montant.'-'.$idtransaction.'-'.$partenaire, $partenaire);
                        return array('erreurCode'=>3002, 'erreurMessage'=>'Echec achat code neosurf :'.$obj['faultcode']);
                    }
                    else
                    {
                        $statut = 1;
                        $tab_return = $obj['dtickets'];
                        $dticket = $tab_return[0];
                        $pincode = $dticket['pincode'];
                        $date_expiry = $dticket['date_expiry'];
                        $serial_nb = $dticket['serial_nb'];

                        $this->transactionModel->__beginTransaction();
                        $dsp = $this->partenaireModel->debiterSoldePartenaire($montant_total, $partenaire);
                        $ccs = $this->transactionModel->crediterCompteSVA($montant);
                        $ccsc = $this->transactionModel->crediterCompteSVACommission($commission_sva);

                        return $dsp.' - '.$ccs.' -  '.$ccsc;

                        if($dsp == true && $ccs == true && $ccsc == true)
                        {
                            if($commission_fournisseur > 0) $this->transactionModel->crediterCompteFournisseur($commission_fournisseur, $fournisseur);
                            $commentaire='Achat Neosurf avec succès';
                            $this->transactionModel->saveTransaction($user_partenaire, $service, $partenaire, $montant, $commission, $num_transac, $commentaire, $statut, $pincode);
                            $this->transactionModel->saveRetourWebservice('200', $commentaire, 'AchatCodeNeosurf', $montant.'-'.$idtransaction.'-'.$pincode, $partenaire);
                            return array('pincode'=>$pincode, 'date_expiry'=>$date_expiry, 'serial_number'=>$serial_nb);
                            $this->transactionModel->__commit();
                        }
                        else{
                            $this->transactionModel->__rollBack();
                            $commentaire='Achat Neosurf avec succès';
                            $this->transactionModel->saveTransaction($user_partenaire, $service, $partenaire, $montant, $commission, $num_transac, $commentaire, $statut, $pincode);
                            $this->transactionModel->saveRetourWebservice('200', $commentaire, 'AchatCodeNeosurf', $montant.'-'.$idtransaction.'-'.$pincode, $partenaire);
                            return array('pincode'=>$pincode, 'date_expiry'=>$date_expiry, 'serial_number'=>$serial_nb);
                        }
                    }
                }
                else{
                    $this->transactionModel->__beginTransaction();
                    $dsp = $this->partenaireModel->debiterSoldePartenaire($montant_total, $partenaire);
                    $ccs = $this->transactionModel->crediterCompteSVA($montant);
                    $ccf = $this->transactionModel->crediterCompteFournisseur($commission_fournisseur, $fournisseur);
                    $ccsc = $this->transactionModel->crediterCompteSVACommission($commission_sva);
                    if($dsp == true && $ccs == true && $ccf == true && $ccsc == true)
                    {
                        $this->transactionModel->__commit();
                    }
                    else{
                        $this->transactionModel->__rollBack();
                    }
                }
            }
            else{
                $commentaire = 'Votre solde est insuffisant';
                $this->transactionModel->saveRetourWebservice('3003', $commentaire, 'AchatCodeNeosurf', $montant.'-'.$idtransaction.'-'.$partenaire, $partenaire);
                return array('erreurCode'=>3003, 'erreurMessage'=>'Votre solde est insuffisant');
            }
        }
        else{
            $commentaire = 'Vous n\'avez pas l\'autorisation pour ce service';
            $this->transactionModel->saveRetourWebservice('3004', $commentaire, 'AchatCodeNeosurf', $montant.'-'.$idtransaction.'-'.$partenaire, $partenaire);
            return array('erreurCode'=>3004, 'erreurMessage'=>'Vous n\'avez pas l\'autorisation pour ce service');
        }
    }
}