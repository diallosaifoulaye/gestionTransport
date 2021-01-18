<?php
/**
 * Created by PhpStorm.
 * User: bayedame
 * Date: 19/10/2018
 * Time: 09:48
 */

namespace app\webservice;


use app\core\ApiServer;
use app\core\TokenJWT;
use app\core\Utils;
use Spipu\Html2Pdf\Parsing\Token;

class servicesWoyofal extends ApiServer
{

    private $model;
    private $service ;
    private $transaction ;
    public function __construct()
    {
        parent::__construct(__CLASS__);
        $this->model = $this->model("partenaire");
        $this->service = $this->model("service");
        $this->transaction = $this->model("transaction");
    }

    /********************verification token***********************************/
    function authorize(){
        //return (TokenJWT::verif($this->token, TOKEN_KEY));
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
     * Gets user list
     *
     * @url POST /achatCodeWoyofal
     */
    public function achatCodeWoyofal()
    {
        $id = 8;
        $api = $this->service->getApi(["condition" => ["rowid = " => $id]]);
        $id = $api->{'identification'};
        $key = $api->{'cle'};
        //$token =parent::$paramPOST['token'];
        $compteur = parent::$paramPOST['compteur'];
        $montant = parent::$paramPOST['montant'];
        $user = 1;
        $service = $this->service->getIdService('achatCodeWoyofal');
        $fournisseur = $this->service->getIdFournisseur('achatCodeWoyofal');
        $user_partenaire = 1;
        $verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $id_partenaire = $verif_token->{'id'};


        if ($id_partenaire != 0){

            $checkPart = $this->model->checkPartenaireAccess($id_partenaire,$service);

            if($checkPart === 1){

                if((int)$montant >= 1000 && (int)$montant <= 150000){

                    $soldePartenaire = $this->model->getSoldePartenaire($id_partenaire);
                    $commission_total = $this->transaction->getFraisService($service, $montant);

                    $num_transac = $this->service->Generer_numtransaction();

                    $commission_partager = $this->transaction->getCommissionUnitaire($service,$id_partenaire);

                    $commission_sva = ((int)$commission_total * (int)$commission_partager->{'pourcentage_sva'}) / 100;
                    $commission_partenaire = ((int)$commission_total * (int)$commission_partager->{'pourcentage_partenaire'}) / 100;
                    $commission_fournisseur = ((int)$commission_total * (int)$commission_partager->{'pourcentage_fournisseur'}) / 100;

                    $montant_total = (int)$montant + $commission_sva + $commission_fournisseur;

                    if ($soldePartenaire >=  $montant_total){

                        if(gethostbyname($_SERVER['SERVER_NAME']) === '104.20.252.2' || $_SERVER['HTTP_HOST'] === 'pmp-admin.com'){
                            $instance = $this->apiClient->woyofal();
                            $instance->service = 'AchatCodeWoyofal';
                            $instance->params = [
                                "id"=>$id,
                                "key"=>$key,
                                "compteur_number"=>$compteur,
                                "montant"=>$montant
                            ];
                            $ResulatRenvoye = $instance->call();
                            $error = $instance->getError();
                        }
                        else{
                            if($compteur === '1111111111'){
                                $ResulatRenvoye = json_encode(array('statut' => 'OK', 'token' => time(), 'order_number'=> mt_rand(0, 999999)));
                                $error = false;
                            }
                            else{
                                $error = true;
                            }
                        }

                        if ($error) {
                            $this->transaction->saveRetourWebservice(1005, 'Erreur serveur rapido', 'AchatCodeWoyofal', $compteur.$montant.$num_transac.$user.$_SERVER['REMOTE_ADDR'], $id_partenaire);
                            return  array('errorCode' => '1005','errorMessage' => 'Erreur de connexion au serveur Woyofal.');
                        }
                        else {

                            $object = json_decode($ResulatRenvoye);
                            if(is_object($object)) {
                                if ($object->{'statut'} === 'OK') {

                                    $code = $object->{'token'};
                                    $order_number = $object->{'order_number'};

                                    $total_trans = $montant + $commission_partager;
                                    $statut = 1;
                                    $date_transaction = date('Y-m-d H:i:s');

                                    $dsp = $this->model->debiterSoldePartenaire($montant_total,$id_partenaire);
                                    $ccsva = $this->transaction->crediterCompteSVA($montant);
                                    $ccsvacom = $this->transaction->crediterCompteSVACommission($commission_sva);
                                    $ccfour = $this->transaction->crediterCompteFournisseur($commission_fournisseur, $fournisseur);

                                    if ($dsp == true && $ccsva == true && $ccsvacom == true && $ccfour == true) {
                                        $this->model->__commit();
                                        $statut = 1;
                                        $fk_transaction = $this->transaction->saveTransaction($user_partenaire, $service, $id_partenaire, $montant, $commission_total, $num_transac, "Achat de code woyofal par partenaire", $statut, 0);
                                        //$this->transaction->saveDetailTransaction($commission_sva, $commission_partenaire, $fk_transaction, $date_transaction);
                                        $this->transaction->saveDetailTransaction($commission_sva, $commission_partenaire, $commission_fournisseur ,$fk_transaction,$id_partenaire,$service, $date_transaction);
                                        $solde_apres = $this->model->getSoldePartenaire($id_partenaire);
                                        $this->transaction->saveRelevePartenaire($num_transac, $soldePartenaire, $solde_apres, $montant, $service, $id_partenaire);
                                        $this->transaction->saveRetourWebservice(0, 'SuccessFull', 'achatCodeWoyofal', $compteur.$montant.$num_transac.$user.$_SERVER['REMOTE_ADDR'], $id_partenaire);

                                        return array('result' => '1','code' => $code,'order_number' => $order_number,'errorCode' => '0','errorMessage' => '', 'transactionId' => $num_transac, 'montant_facial' => $total_trans, 'montant_reel' => $montant_total);
                                    }else{
                                        $this->model->__rollBack();
                                        $statut = 0;
                                        $this->transaction->saveTransaction($user_partenaire, $service, $id_partenaire, $montant, $commission_total, $num_transac, "Achat de code woyofal par partenaire", $statut, 0);
                                        return array('result' => '1','errorCode' => '-1','errorMessage' => 'Erreur transaction', 'transactionId' => $num_transac, 'montant_facial' => $total_trans, 'montant_reel' => $montant_total);
                                    }
                                }
                                else {
                                    $error_code=$object->{'error_code'};
                                    /*if($error_code==102){
                                        envoimail2('Youssef Destefani', 'fatou.diagne@numherit.com','Le VPN est deconnecte. Merci de faire le necessaire SVP.');
                                    }*/
                                    $this->transaction->saveRetourWebservice(1005, 'Erreur de connexion au serveur Woyofal2.', 'AchatCodeWoyofal', $compteur.$montant.$num_transac.$user.$_SERVER['REMOTE_ADDR'], $id_partenaire);
                                    return json_encode( array('errorCode' => '1005','errorMessage' => 'Erreur de connexion au serveur Woyofal.')); //Check appel webservice.
                                }
                            }else{
                                $this->transaction->saveRetourWebservice(1005, 'Erreur de connexion au serveur Woyofal3.', 'AchatCodeWoyofal', $compteur.$montant.$num_transac.$user.$_SERVER['REMOTE_ADDR'], $id_partenaire);
                                return json_encode( array('errorCode' => '1005','errorMessage' => 'Erreur de connexion au serveur Woyofal.')); //Check appel webservice.
                            }
                        }

                    }else{
                        $statut = 0;
                        //$this->->saveTransaction($user_partenaire, $service, 2, $montant, $commission_total, $num_transac, "Solde marchand insuffisant.", $statut, $rs->errorCode);
                        return  array('errorCode' => '1002','errorMessage' => 'Solde marchand insuffisant.');
                    }
                }else{
                    return  array('errorCode' => '1001','errorMessage' => 'Montant non autorise.');
                }
            }else{
                return  array('errorCode' => '1000','errorMessage' => 'Partenaire non autoriser.');
            }
        }else{
            return  array('errorCode' => '2000','errorMessage' => 'Token expire ou invalide .');
        }
    }
}