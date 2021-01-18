<?php
/**
 * Created by PhpStorm.
 * User: bayedame
 * Date: 03/10/2018
 * Time: 10:36
 */

namespace app\webservice;

use app\core\ApiServer;
use app\core\TokenJWT;
use app\core\Utils;
use Spipu\Html2Pdf\Parsing\Token;

class servicesRapido extends ApiServer
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
     * @url POST /soldeBadgeRapido
     */
    public function soldeBadgeRapido()
    {
        $id = 2017;
        $key = "postecash-rapido@2017";
        //var_dump(parent::$paramPOST['badge']);die();
        $id = 4;
        $api = $this->service->getApi(["condition" => ["rowid = " => $id]]);
        $id = $api->{'identification'};
        $key = $api->{'cle'};

        $user = 1;
        $badge = parent::$paramPOST['badge'];
        $service = $this->service->getIdService('soldeBadgeRapido');
        $verif_token = TokenJWT::decode($this->token, TOKEN_KEY);

        $id_partenaire = $verif_token->{'id'};

        if ($id_partenaire > 0){

            $checkPart = $this->model->checkPartenaireAccess($id_partenaire,$service);
            if($checkPart === 1){
                if(gethostbyname($_SERVER['SERVER_NAME']) === '104.20.252.2' || $_SERVER['HTTP_HOST'] === 'pmp-admin.com'){
                    $instance = $this->apiClient->rapido();
                    $instance->service = 'GetSoldeRapido';
                    $instance->params = [
                        "id"=>$id,
                        "key"=>$key,
                        "badge"=>$badge,
                        "tel"=>'',
                        "user"=>$user,
                        "ip"=>$_SERVER["REMOTE_ADDR"]
                    ];
                    $ResulatRenvoye = $instance->call();
                    $error = $instance->getError();
                }
                else{
                    $cartes = ['00129923', '00129924', '00129925', '00129926', '00129927'];

                    if(in_array($badge, $cartes)){
                        $data = [27000, 100000,2000, 5000, 0, 500, 0, 34000, 50000, 78000];
                        $ResulatRenvoye = ($data[mt_rand(0, 9)]);
                    }
                    else{
                        $ResulatRenvoye = (array('errorCode' => '1001'));
                    }

                }

                if ($error) {
                    return array('errorCode' => '1002', 'errorMessage' => 'une erreure est survenue');
                }
                else {
                    $rs = json_decode($ResulatRenvoye);
                    if ($rs->errorCode == '1001' || $rs->errorCode == '1000') {
                        return array('errorCode' => '1001', 'errorMessage' => 'badge innexistant');
                    }
                    else {
                        return array('errorCode' => '0', 'errorMessage' => '', 'result' => $rs);
                    }
                }
            }else{
                return array('errorCode' => '#001','errorMessage' => 'Partenaire non autoriser.');
            }
        }else{
            return  array('errorCode' => '2000','errorMessage' => 'Token expire ou invalide .');
        }

    }

    /**
     * Gets user list
     *
     * @url POST /rechargeBadgeRapido
     */
    public function rechargeBadgeRapido()
    {
        $id = 4;
        $api = $this->service->getApi(["condition" => ["rowid = " => $id]]);
        $id = $api->{'identification'};
        $key = $api->{'cle'};
        //$token =parent::$paramPOST['token'];
        $badge = parent::$paramPOST['badge'];
        $montant = parent::$paramPOST['montant'];
        $user = 1;
        $service = $this->service->getIdService('rechargeBadgeRapido');
        $fournisseur = $this->service->getIdFournisseur('rechargeBadgeRapido');
        $user_partenaire = 1;
        $verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $id_partenaire = $verif_token->{'id'};


        if ($id_partenaire != 0){

            $checkPart = $this->model->checkPartenaireAccess($id_partenaire,$service);

            if($checkPart === 1){

                if((int)$montant >= 100){

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
                            $instance = $this->apiClient->rapido();
                            $instance->service = 'RechargerRapido';
                            $instance->params = [
                                "id"=>$id,
                                "key"=>$key,
                                "badge"=>$badge,
                                "montant"=>$montant,
                                "transaction"=>$num_transac,
                                "user"=>$user,
                                "ip"=>$_SERVER["REMOTE_ADDR"]
                            ];
                            $ResulatRenvoye = $instance->call();
                            $error = $instance->getError();
                        }
                        else{
                            $cartes = ['00129923', '00129924', '00129925', '00129926', '00129927'];
                            if(in_array($badge, $cartes)){
                                $ResulatRenvoye = json_encode(array('code' => '1'));
                            }
                            else{
                                $ResulatRenvoye = json_encode(array('errorCode' => '1001'));
                            }
                        }

                        if ($error) {
                            $code = -10;
                            return $code;
                        }

                        else {
                            $code=-1;
                            $rs = json_decode($ResulatRenvoye);
                            if ($rs->errorCode == '1001' || $rs->errorCode == '1002' || $rs->errorCode == '1000') {
                                $statut = 0;
                                if($rs->code == '202')
                                {
                                    $statut = 0;
                                    $this->transaction->saveTransaction($user_partenaire, $service, $id_partenaire, $montant, $commission_total, $num_transac, "Erreur serveur rapido", $statut, 202);
                                    $this->transaction->saveRetourWebservice($rs->errorCode, 'Erreur serveur rapido', 'rechargeBadgeRapido', $badge.$montant.$num_transac.$user.$_SERVER['REMOTE_ADDR'], $id_partenaire);
                                    return array('errorCode'=>'1007','errorMessage'=>'Erreur serveur rapido');
                                }
                                elseif($rs->code == '203')
                                {
                                    $statut = 0;
                                    $this->transaction->saveTransaction($user_partenaire, $service, $id_partenaire, $montant, $commission_total, $num_transac, "Erreur serveur rapido", $statut, 203);
                                    $this->transaction->saveRetourWebservice($rs->errorCode, 'Erreur serveur rapido', 'rechargeBadgeRapido', $badge.$montant.$num_transac.$user.$_SERVER['REMOTE_ADDR'], $id_partenaire);
                                    return array('errorCode'=>'1008','errorMessage'=>'Erreur serveur rapido');
                                }
                                elseif($rs->code == '204')
                                {
                                    $statut = 0;
                                    $this->transaction->saveTransaction($user_partenaire, $service, $id_partenaire, $montant, $commission_total, $num_transac, "Erreur serveur rapido", $statut, 204);
                                    $this->transaction->saveRetourWebservice($rs->errorCode, 'Erreur serveur rapido', 'rechargeBadgeRapido', $badge.$montant.$num_transac.$user.$_SERVER['REMOTE_ADDR'], $id_partenaire);
                                    return array('errorCode'=>'1009','errorMessage'=>'Erreur serveur rapido');
                                }
                                else
                                {
                                    $statut = 0;
                                    $this->transaction->saveTransaction($user_partenaire, $service, $id_partenaire, $montant, $commission_total, $num_transac, "Erreur serveur rapido", $statut, 204);
                                    $this->transaction->saveRetourWebservice($rs->errorCode, 'Erreur serveur rapido', 'rechargeBadgeRapido', $badge.$montant.$num_transac.$user.$_SERVER['REMOTE_ADDR'], $id_partenaire);
                                    return array('errorCode'=>'1010','errorMessage'=>'Erreur serveur rapido');
                                }
                            }
                            else{
                                $statut = 1;
                                $date_transaction = date('Y-m-d H:i:s');
                                $this->model->__beginTransaction();
                                $dsp = $this->model->debiterSoldePartenaire($montant_total,$id_partenaire);
                                $ccsva = $this->transaction->crediterCompteSVA($montant);
                                $ccsvacom = $this->transaction->crediterCompteSVACommission($commission_sva);
                                $ccfour = $this->transaction->crediterCompteFournisseur($commission_fournisseur, $fournisseur);

                                if ($dsp == true && $ccsva == true && $ccsvacom == true && $ccfour == true)
                                {
                                    $this->model->__commit();
                                    $statut = 1;
                                    $fk_transaction = $this->transaction->saveTransaction($user_partenaire, $service, $id_partenaire, $montant, $commission_total, $num_transac, "Recharge rapido", $statut, 0);
                                    $this->transaction->saveDetailTransaction($commission_sva, $commission_partenaire, $commission_fournisseur ,$fk_transaction,$id_partenaire,$service, $date_transaction);
                                    $solde_apres = $this->model->getSoldePartenaire($id_partenaire);
                                    $this->transaction->saveRelevePartenaire($num_transac, $soldePartenaire, $solde_apres, $montant, $service, $id_partenaire);
                                    $this->transaction->saveRetourWebservice($rs->errorCode, 'SuccessFull', 'rechargeBadgeRapido', $badge.$montant.$num_transac.$user.$_SERVER['REMOTE_ADDR'], $id_partenaire);
                                    return array('errorCode'=>'0','errorMessage'=>'Transaction effectuee avec Succes','transactionId'=>$num_transac);
                                }else{
                                    $this->model->__rollBack();
                                    $statut = 0;
                                    $this->transaction->saveTransaction($user_partenaire, $service, $id_partenaire, $montant, $commission_total, $num_transac, "Recharge rapido", $statut, 0);
                                    $this->transaction->saveRetourWebservice($rs->errorCode, 'SuccessFull', 'rechargeBadgeRapido', $badge.$montant.$num_transac.$user.$_SERVER['REMOTE_ADDR'], $id_partenaire);
                                    return array('errorCode'=>'-1','errorMessage'=>'Transaction non effectuee','transactionId'=>$num_transac);
                                }
                            }
                            return $code;
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