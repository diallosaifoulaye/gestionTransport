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

class servicesTransferTo extends ApiServer
{
    private $homeModels;
    private $serviceModels;
    private $model;
    private $transaction;
    public function __construct()
    {
        parent::__construct(__CLASS__);
        $this->model = $this->model("partenaire");
        $this->homeModels = $this->model("home");
        $this->serviceModels = $this->model("service");
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
     * @url POST /verifNumTel
     */
    public function verifNumTel()
    {
        $verif_token = TokenJWT::decode($this->token, TOKEN_KEY);

        $id_partenaire = $verif_token->{'id'};
        $service = $this->serviceModels->getIdService('verifNumTel');
        if ($id_partenaire > 0){

            $checkPart = $this->model->checkPartenaireAccess($id_partenaire,$service);

                    if($checkPart === 1){
                        $id = 2;
                        $api = $this->serviceModels->getApi(["condition" => ["rowid = " => $id]]);

                        $login = $api->{'username'};
                        $password = $api->{'password'};

                        $tel= parent::$paramPOST['tel'];
                        $this->apiClient->setMethod("get");
                        $this->apiClient->setService("topup");
                        $time = time();
                        $data = [
                            "topup" => [
                                "login"=>$login,
                                "key"=>$time,
                                "md5"=>md5($login.$password.$time),
                                "action"=>"msisdn_info",
                                "destination_msisdn"=>$tel
                            ]
                        ];
                        $this->apiClient->setData($data);
                        $data = $this->apiClient->transferTo();
                        $responses = explode("\r\n", $data);
                        foreach ($responses as $response)
                        {
                            $tab = explode("=", $response);
                            $key = $tab[0];
                            $value= $tab[1];
                            if($key != "" && $value != "") {
                                $data1[$key] = $value;
                            }
                        }
                        $resultat = json_encode($data1);
                        $parsed_json = json_decode($resultat);
                        if ($parsed_json->error_code == 0){

                            return array("erreurCode" => $parsed_json->error_code, "erreurMessage" => "Vérification effectuée avec succès", "Pays" => $parsed_json->country, "Opérateur"=>$parsed_json->operator,
                                "Numéro téléphone destinataire" => $parsed_json->destination_msisdn, "Devise"=>$parsed_json->destination_currency, "Liste des montants" => $parsed_json->product_list,
                                "liste des prix en détail"=>$parsed_json->retail_price_list, "liste des prix en gros" =>$parsed_json->wholesale_price_list);
                        }
                        else if ($parsed_json->error_code == 101){

                            return array("erreurCode" => $parsed_json->error_code, "erreurMessage" => "Numéro de téléphone incorrect");

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
     * @url POST /achatCredit
     */
    public function achatCredit()
    {
        $montant = "";
        $tel = "";
        $user = 1;
        $verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $user_partenaire = 1;
        $id_partenaire = $verif_token->{'id'};
        $service = $this->serviceModels->getIdService('achatCredit');
        $fournisseur = $this->serviceModels->getIdFournisseur('achatCredit');

        if ($id_partenaire > 0){

            $checkPart = $this->model->checkPartenaireAccess($id_partenaire,$service);

            if($checkPart === 1) {

                $soldePartenaire = $this->model->getSoldePartenaire($id_partenaire);
                $commission_total = $this->transaction->getFraisService($service, $montant);

                $num_transac = $this->serviceModels->Generer_numtransaction();

                $commission_partager = $this->transaction->getCommissionUnitaire($service,$id_partenaire);

                $commission_sva = ((int)$commission_total * (int)$commission_partager->{'pourcentage_sva'}) / 100;
                $commission_partenaire = ((int)$commission_total * (int)$commission_partager->{'pourcentage_partenaire'}) / 100;
                $commission_fournisseur = ((int)$commission_total * (int)$commission_partager->{'pourcentage_fournisseur'}) / 100;

                $montant_total = (int)$montant + $commission_sva + $commission_fournisseur;

                if ($soldePartenaire >=  $montant_total){

                    $id = 2;
                    $api = $this->serviceModels->getApi(["condition" => ["rowid = " => $id]]);

                    $login = $api->{'username'};
                    $password = $api->{'password'};

                    $sms = 'Felicitation! Vous avez recu ' . $montant . ' du ' . $tel . '. Numherit vous remercie';
                    $this->apiClient->setMethod("get");
                    $this->apiClient->setService("topup");
                    $time = time();
                    $data = [
                        "topup" => [
                            "login" => $login,
                            "key" => $time,
                            "md5" => md5($login . $password . $time),
                            "action" => "topup",
                            "destination_msisdn" => $tel,
                            "msisdn" => $sms,
                            "product" => $montant
                        ]
                    ];

                    $this->apiClient->setData($data);
                    $data['rstApi'] = $this->apiClient->transferTo();
                    $responses = explode("\r\n", $data['rstApi']);

                    foreach ($responses as $response) {
                        $tab = explode("=", $response);
                        $key = $tab[0];
                        $value = $tab[1];
                        if ($key != "" && $value != "") {
                            $data1[$key] = $value;
                        }
                    }

                    $resultat = json_encode($data1);
                    $parsed_json = json_decode($resultat);

                    if ($parsed_json->error_code == 0) {

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
                            $fk_transaction = $this->transaction->saveTransaction($user_partenaire, $service, $id_partenaire, $montant, $commission_total, $num_transac, "Achat Credit", $statut, 0);
                            //$this->transaction->saveDetailTransaction($commission_sva, $commission_partenaire, $fk_transaction, $date_transaction);
                            $this->transaction->saveDetailTransaction($commission_sva, $commission_partenaire, $commission_fournisseur ,$fk_transaction,$id_partenaire,$service, $date_transaction);
                            $solde_apres = $this->model->getSoldePartenaire($id_partenaire);
                            $this->transaction->saveRelevePartenaire($num_transac, $soldePartenaire, $solde_apres, $montant, $service, $id_partenaire);
                            $this->transaction->saveRetourWebservice($parsed_json->error_code, 'Numéro de téléphone incorrect', 'achatCredit', $login.$time.$tel.$montant."topup", $id_partenaire);

                            return array("erreurCode" => $parsed_json->error_code, "erreurMessage" => "Vérification effectuée avec succès", "Pays" => $parsed_json->country, "Opérateur" => $parsed_json->operator,
                                "Numéro téléphone destinataire" => $parsed_json->destination_msisdn, "Devise" => $parsed_json->destination_currency, "Liste des montants" => $parsed_json->product_list,
                                "liste des prix en détail" => $parsed_json->retail_price_list, "liste des prix en gros" => $parsed_json->wholesale_price_list);
                        }else{
                            $this->model->__rollBack();
                            $statut = 0;
                            $this->transaction->saveTransaction($user_partenaire, $service, $id_partenaire, $montant, $commission_total, $num_transac, "Achat Credit", $statut, 0);
                            $this->transaction->saveRetourWebservice($parsed_json->error_code, 'Numéro de téléphone incorrect', 'achatCredit', $login.$time.$tel.$montant."topup", $id_partenaire);

                            return array("erreurCode" => $parsed_json->error_code, "erreurMessage" => "Vérification non effectuée", "Pays" => $parsed_json->country, "Opérateur" => $parsed_json->operator,
                                "Numéro téléphone destinataire" => $parsed_json->destination_msisdn, "Devise" => $parsed_json->destination_currency);
                        }

                    } else if ($parsed_json->error_code == 101) {

                        $this->transaction->saveRetourWebservice($parsed_json->error_code, 'Numéro de téléphone incorrect', 'achatCredit', $login.$time.$tel.$montant."topup", $id_partenaire);
                        return array("erreurCode" => $parsed_json->error_code, "erreurMessage" => "Numéro de téléphone incorrect");

                    }
                }else{
                    $statut = 0;
                    //$this->->saveTransaction($user_partenaire, $service, 2, $montant, $commission_total, $num_transac, "Solde marchand insuffisant.", $statut, $rs->errorCode);
                    return  array('errorCode' => '1002','errorMessage' => 'Solde marchand insuffisant.');
                }
            }else{
                return array('errorCode' => '#001','errorMessage' => 'Partenaire non autoriser.');
            }
        }else{
            return  array('errorCode' => '2000','errorMessage' => 'Token expire ou invalide .');
        }
    }
}