<?php
/**
 * Created by PhpStorm.
 * User: Seyni Faye
 * Date: 02/07/2018
 * Time: 11:49
 */

namespace app\webservice;

use app\core\ApiServer;
class servicesJula extends ApiServer
{

    private $model;
    public function __construct()
    {
        parent::__construct(__CLASS__);
        //$this->model = $this->model("services");
    }

    /**
     * Gets user list
     *
     * @url GET /ConsultationSolde
     */
    public function getSoldeCarteJULA()
    {
        $idmarchand = 20;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $code_carte = 592919195311436;
        $cle_hachage = sha1($code_carte.$idmarchand.$key_marchand);

        $instance = $this->apiClient->jula();
        $instance->service = 'ConsultationSolde';
        $instance->params = [
            "idmarchand"=>$idmarchand,
            "code_carte"=>$code_carte,
            "cle_hachage"=>$cle_hachage
        ];
        $instance->call();

        if ($instance->response == 103){
            return json_encode(array('erreurCode'=>1003, 'erreurMessage'=>'Code jula incorrect ou deja utilise'));
        }
        elseif ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        else {
            return json_encode(array('erreurCode'=>0, 'solde'=>json_decode($instance->response)));
        }
    }

    /**
     * Gets user list
     *
     * @url GET /debiterCarte
     */
    public function debiterCarteJula()
    {
        $idmarchand = 20;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $code_carte = 592919195311436;
        $montant = 1000;
        $num_transaction = "PosteCashSn" . date("YmdHis");
        $cle_hachage = sha1($code_carte.$montant.$idmarchand.$key_marchand);

        $instance = $this->apiClient->jula();
        $instance->service = 'debiterCarte';
        $instance->params = [
            "idmarchand"=>$idmarchand,
            "code_carte"=>$code_carte,
            "cle_hachage"=>$cle_hachage,
            "montant"=>$montant,
            "num_transaction"=>$num_transaction
        ];
        $instance->call();

        if ($instance->response == 101){
            return json_encode(array('erreurCode'=>0, 'message'=>'Carte debitee avec succes'));
        }
        elseif ($instance->response == 103){
            return json_encode(array('erreurCode'=>1003, 'erreurMessage'=>'Mauvaise carte'));
        }
        elseif ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        elseif ($instance->response == 105){
            return json_encode(array('erreurCode'=>1005, 'erreurMessage'=>'Id marchand incorrect'));
        }
        elseif ($instance->response == 106){
            return json_encode(array('erreurCode'=>1006, 'erreurMessage'=>'Erreur survenue, Carte non debitee'));
        }
    }

    /**
     * Gets user list
     *
     * @url GET /crediterCarte
     */
    public function crediterCarteJula()
    {
        $idmarchand = 20;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $code_carte = 592919195311436;
        $montant = 5000;
        $num_transaction = "PosteCashSn" . date("YmdHis");
        $cle_hachage = sha1($code_carte.$montant.$idmarchand.$key_marchand);

        $instance = $this->apiClient->jula();
        $instance->service = 'crediterCarte';
        $instance->params = [
            "idmarchand"=>$idmarchand,
            "code_carte"=>$code_carte,
            "cle_hachage"=>$cle_hachage,
            "montant"=>$montant,
            "num_transaction"=>$num_transaction
        ];
        $instance->call();

        if ($instance->response == 101){
            return json_encode(array('erreurCode'=>0, 'message'=>'Carte creditee avec succes'));

        }
        elseif ($instance->response == 103){
            return json_encode(array('erreurCode'=>1003, 'erreurMessage'=>'Mauvaise carte'));
        }
        elseif ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        elseif ($instance->response == 105){
            return json_encode(array('erreurCode'=>1005, 'erreurMessage'=>'Id marchand incorrect'));
        }
        elseif ($instance->response == 106){
            return json_encode(array('erreurCode'=>1006, 'erreurMessage'=>'Carte non creditee'));
        }
    }

    /**
     * Gets user list
     *
     * @url GET /ActivationCarteJula
     */
    public function activationCarteJula()
    {
        $idmarchand = 20;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $code_carte = 592919195311436;
        $montant = 5000;
        $num_serie = 1000000001171;

        $cle_hachage=sha1($code_carte.$num_serie.$montant.$idmarchand.$key_marchand);


        $instance = $this->apiClient->jula();
        $instance->service = 'ActivationCarteJula';
        $instance->params = [
            "idmarchand"=>$idmarchand,
            "code_carte"=>$code_carte,
            "cle_hachage"=>$cle_hachage,
            "montant"=>$montant,
            "num_serie"=>$num_serie
        ];
        $instance->call();

        if ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        elseif ($instance->response == 105){
            return json_encode(array('erreurCode'=>1005, 'erreurMessage'=>'Id marchand incorrect'));
        }
        else{
            if ($instance->response == false){
                return json_encode(array('erreurCode'=>1006, 'erreurMessage'=>'Carte deja activee'));
            }
            else{
                return json_encode(array('erreurCode'=>0, 'message'=>'Carte activee avec succes'));
            }
        }
    }

    /**
     * Gets user list
     *
     * @url GET /ConsulterSoldeCompteJula
     */
    public function getSoldeCompteJula()
    {
        $idmarchand = 20;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $cle_hachage = sha1($idmarchand.$key_marchand);

        $instance = $this->apiClient->jula();
        $instance->service = 'ConsulterSoldeCompteJula';
        $instance->params = [
            "idmarchand"=>$idmarchand,
            "cle_hachage"=>$cle_hachage
        ];
        $instance->call();

        if ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        elseif ($instance->response == 105){
            return json_encode(array('erreurCode'=>1005, 'erreurMessage'=>'Id marchand incorrect'));
        }
        elseif ($instance->response == 001){
            return json_encode(array('erreurCode'=>1006, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        elseif ($instance->response == 002){
            return json_encode(array('erreurCode'=>1007, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        elseif ($instance->response == 003){
            return json_encode(array('erreurCode'=>1008, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        else {
            
            return json_encode(array('erreurCode'=>0, 'solde'=>json_decode($instance->response)));
        }
    }

    /**
     * Gets user list
     *
     * @url GET /infosCarteJula
     */
    public function getInfosCarteJula()
    {
        $code_carte = 592919195311436;
        $idmarchand = 20;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $cle_hachage = sha1($code_carte.$idmarchand.$key_marchand);

        $instance = $this->apiClient->jula();
        $instance->service = 'infosCarteJula';
        $instance->params = [
            "idmarchand"=>$idmarchand,
            "code_carte"=>$code_carte,
            "cle_hachage"=>$cle_hachage
        ];
        $instance->call();

        //var_dump($instance->response); die();

        if ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        elseif ($instance->response == 105){
            return json_encode(array('erreurCode'=>1005, 'erreurMessage'=>'Id marchand incorrect'));
        }
        elseif ($instance->response == 101){
            return json_encode(array('erreurCode'=>1006, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        elseif ($instance->response == 102){
            return json_encode(array('erreurCode'=>1007, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        elseif ($instance->response == 103){
            return json_encode(array('erreurCode'=>1008, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        else {
            return json_encode(array('erreurCode'=>0, 'info'=>json_decode($instance->response)));
        }

    }

    /**
     * Gets user list
     *
     * @url GET /getPartenaire
     */
    public function getInfosPartenaire()
    {
        $code_carte = 592919195311436;
        $idmarchand = 20;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $cle_hachage = sha1($idmarchand.$code_carte.$key_marchand);

        $instance = $this->apiClient->jula();
        $instance->service = 'getPartenaire';
        $instance->params = [
            "idmarchand"=>$idmarchand,
            "code"=>$code_carte,
            "cle"=>$key_marchand,
            "cle_hachage"=>$cle_hachage
        ];
        $instance->call();

        //var_dump($instance->response); die();

        if ($instance->response == 103){
            return json_encode(array('erreurCode'=>1003, 'erreurMessage'=>'Code Jula n existe pas'));
        }
        elseif ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        elseif ($instance->response == 105){
            return json_encode(array('erreurCode'=>1005, 'erreurMessage'=>'Id marchand incorrect'));
        }
        else {
            return json_encode(array('erreurCode'=>0, 'info'=>$instance->response));
        }

    }

    /**
     * Gets user list
     *
     * @url GET /ReturnTypeClient
     */
    public function getTypeClient()
    {
        $idpartenaire = 10;
        $idmarchand = 20;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $cle_hachage = sha1($idmarchand.$idpartenaire.$key_marchand);

        $instance = $this->apiClient->jula();
        $instance->service = 'ReturnTypeClient';
        $instance->params = [
            "idmarchand"=>$idmarchand,
            "idpartenaire"=>$idpartenaire,
            "cle_hachage"=>$cle_hachage
        ];
        $instance->call();

        if ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        elseif ($instance->response == 105){
            return json_encode(array('erreurCode'=>1005, 'erreurMessage'=>'Id marchand incorrect'));
        }
        elseif ($instance->response == -1){
            return json_encode(array('erreurCode'=>1006, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        else {
            return json_encode(array('erreurCode'=>0, 'typeClient'=>json_decode($instance->response)));
        }

    }

    /**
     * Gets user list
     *
     * @url GET /ReturnTypeCarte
     */
    public function getTypeCarte()
    {
        $idpartenaire = 10;
        $idmarchand = 20;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $cle_hachage = sha1($idmarchand.$idpartenaire.$key_marchand);

        $instance = $this->apiClient->jula();
        $instance->service = 'ReturnTypeCarte';
        $instance->params = [
            "idmarchand"=>$idmarchand,
            "idpartenaire"=>$idpartenaire,
            "cle_hachage"=>$cle_hachage
        ];
        $instance->call();
        //return $instance->response;

        if ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        elseif ($instance->response == -14){
            return json_encode(array('erreurCode'=>1005, 'erreurMessage'=>'Id marchand incorrect'));
        }
        elseif ($instance->response == -13){
            return json_encode(array('erreurCode'=>1006, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        elseif ($instance->response == -12){
            return json_encode(array('erreurCode'=>1007, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        elseif ($instance->response == -11){
            return json_encode(array('erreurCode'=>1008, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        else {
           return json_encode(array('erreurCode'=>0, 'infoCarte'=>json_decode($instance->response)));
        }

    }

    /**
     * Gets user list
     *
     * @url GET /ReturnNumserieCarte
     */
    public function getNumserieCarte()
    {
        $code_carte = 592919195311436;
        $idmarchand = 20;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $cle_hachage = sha1($idmarchand.$code_carte.$key_marchand);

        $instance = $this->apiClient->jula();
        $instance->service = 'ReturnNumserieCarte';
        $instance->params = [
            "idmarchand"=>$idmarchand,
            "carte"=>$code_carte,
            "cle_hachage"=>$cle_hachage
        ];
        $instance->call();

        //var_dump($instance->response); die();

        if ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        elseif ($instance->response == 105){
            return json_encode(array('erreurCode'=>1005, 'erreurMessage'=>'Id marchand incorrect'));
        }
        elseif ($instance->response == 001){
            return json_encode(array('erreurCode'=>1006, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        elseif ($instance->response == 002){
            return json_encode(array('erreurCode'=>1007, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        elseif ($instance->response == 003){
            return json_encode(array('erreurCode'=>1008, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        else {
            return json_encode(array('erreurCode'=>0, 'info'=>json_decode($instance->response)));
        }

    }

    /**
     * Gets user list
     *
     * @url GET /CrediterCompteJula
     */
    public function crediterCompte()
    {
        $idmarchand = 20;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $solde = 10000;
        $cle_hachage = sha1($idmarchand.$solde.$key_marchand);

        $instance = $this->apiClient->jula();
        $instance->service = 'CrediterCompteJula';
        $instance->params = [
            "idmarchand"=>$idmarchand,
            "solde"=>$solde,
            "cle_hachage"=>$cle_hachage
        ];
        $instance->call();

        if ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        elseif ($instance->response == 105){
            return json_encode(array('erreurCode'=>1005, 'erreurMessage'=>'Id marchand incorrect'));
        }
        elseif ($instance->response == 101){
            return json_encode(array('erreurCode'=>1006, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        elseif ($instance->response == 102){
            return json_encode(array('erreurCode'=>1007, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        elseif ($instance->response == 103){
            return json_encode(array('erreurCode'=>1008, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        else {
            return json_encode(array('erreurCode'=>0, 'message'=>'Compte credite avec succes'));
        }

    }

    /**
     * Gets user list
     *
     * @url GET /ConsulterSoldeCompteJulaPartenaire
     */
    public function getSoldeCompteJulaPartenaire()
    {
        $idpartenaire = 10;
        $idmarchand = 20;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $cle_hachage = sha1($idmarchand.$idpartenaire.$key_marchand);

        $instance = $this->apiClient->jula();
        $instance->service = 'ConsulterSoldeCompteJulaPartenaire';
        $instance->params = [
            "idmarchand"=>$idmarchand,
            "idPartenaire"=>$idpartenaire,
            "cle_hachage"=>$cle_hachage
        ];
        $instance->call();

        if ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        elseif ($instance->response == 105){
            return json_encode(array('erreurCode'=>1005, 'erreurMessage'=>'Id marchand incorrect'));
        }
        elseif ($instance->response == -1){
            return json_encode(array('erreurCode'=>1006, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        else {
            return json_encode(array('erreurCode'=>0, 'soldePartenaire'=>json_decode($instance->response)));
        }

    }

    /**
     * Gets user list
     *
     * @url GET /codeOwo
     */
    public function getCodeOwo()
    {
        $idmarchand = 20;
        $idpartenaire = 10;
        $iduser = 1;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $cle_hachage = sha1($idmarchand.$idpartenaire.$iduser.$key_marchand);

        $instance = $this->apiClient->jula();
        $instance->service = 'codeOwo';
        $instance->params = [
            "idmarchand"=>$idmarchand,
            "idPartenaire"=>$idpartenaire,
            "iduser"=>$iduser,
            "cle_hachage"=>$cle_hachage
        ];
        $instance->call();

        if ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        elseif ($instance->response == 105){
            return json_encode(array('erreurCode'=>1005, 'erreurMessage'=>'Id marchand incorrect'));
        }
        elseif ($instance->response == 101){
            return json_encode(array('erreurCode'=>1006, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        elseif ($instance->response == 102){
            return json_encode(array('erreurCode'=>1007, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        elseif ($instance->response == 103){
            return json_encode(array('erreurCode'=>1008, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        else {
            return json_encode(array('erreurCode'=>0, 'code'=>json_decode($instance->response)));
        }

    }

    /**
     * Gets user list
     *
     * @url GET /genererCodeJula
     */
    public function getCodeJula()
    {
        $montant = 10000;
        $statut = 1;
        $user = 1;
        $commission = 200;
        $commission_part = 100;
        $diff = 100;
        $frais_com = 50;
        $service = 4;
        $montant_achat = 5000;
        $idpartenaire = 10;
        $idmarchand = 20;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $cle_hachage = sha1($key_marchand.$montant.$user.$commission.$commission_part.$idpartenaire.$diff.$frais_com.$service.$montant_achat);
        //$cle_hachage = "557d3d1a58bd311e4378de23fc3400ae3508365a";

        $instance = $this->apiClient->jula();
        $instance->service = 'genererCodeJula';

        $instance->params = [
            "idmarchand"=>$idmarchand,
            "montant"=>$montant,
            "statut"=>$statut,
            "user"=>$user,
            "com"=>$commission,
            "com_part"=>$commission_part,
            "idpartenaire"=>$idpartenaire,
            "diff"=>$diff,
            "frais_com"=>$frais_com,
            "service"=>$service,
            "montant_achat"=>$montant_achat,
            "hachage"=>$cle_hachage
        ];
        $instance->call();

        //return ($instance->response);

        if ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        elseif ($instance->response == 105){
            return json_encode(array('erreurCode'=>1005, 'erreurMessage'=>'Id marchand incorrect'));
        }
        elseif ($instance->response == -1){
            return json_encode(array('erreurCode'=>1006, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        else {
            return json_encode(array('erreurCode'=>0, 'codeGenere'=>$instance->response));
        }
    }

    /**
     * Gets user list
     *
     * @url GET /VerificationCode
     */
    public function verifCode()
    {
        $code = 592919195311436;
        $idmarchand = 20;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $cle_hachage = sha1($code.$idmarchand.$key_marchand);

        $instance = $this->apiClient->jula();
        $instance->service = 'VerificationCode';

        $instance->params = [
            "code_carte"=>$code,
            "idmarchand"=>$idmarchand,
            "cle_hachage"=>$cle_hachage
        ];
        $instance->call();
        //return ($instance->response);

        if ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        else {
            return json_encode(array('erreurCode'=>0, 'message'=>$instance->response));
        }
    }

    /**
     * Gets user list
     *
     * @url GET /creerMarchandJula
     */
    public function creerMarchandJula()
    {
        $idmarchand = 133;
        $nom_marchand = 'Manou MARCHAND';
        $code_marchand = 'SMT2222';
        $cle_marchand = '738303JSHSNSLNSNS';
        $email_marchand = 'mansour@numherit.com';
        $date_adhesion = '2018-10-30 12:08:29';
        $adresse = 'Nord Foire pres de la brioche doree';
        $telephone = '00221779952222';
        $logo = '';
        $site_web = '';
        $idtype_activite = 0;
        $idtype_marchand = 0;
        $num_carte = 11902287540;
        $distributeur = 0;
        $idtype_distributeur = 0;
        $statut = 1;
        $key_marchand = "6bdcaf4bb572c48f62e93d462a62c06978c5df92";
        $cle_hachage = sha1($idmarchand.$nom_marchand.$code_marchand.$cle_marchand.$email_marchand.$date_adhesion.$adresse.$telephone.$logo
            .$site_web.$idtype_activite.$idtype_marchand.$num_carte.$distributeur.$idtype_distributeur.$statut.$key_marchand);

        $instance = $this->apiClient->jula();
        $instance->service = 'creerMarchandJula';

        $instance->params = [
            "idmarchand"=>$idmarchand,
            "nom_marchand"=>$nom_marchand,
            "code_marchand"=>$code_marchand,
            "cle_marchand"=>$cle_marchand,
            "email_marchand"=>$email_marchand,
            "date_adhesion"=>$date_adhesion,
            "adresse"=>$adresse,
            "telephone"=>$telephone,
            "logo"=>$logo,
            "site_web"=>$site_web,
            "idtype_activite"=>$idtype_activite,
            "idtype_marchand"=>$idtype_marchand,
            "num_carte"=>$num_carte,
            "distributeur"=>$distributeur,
            "idtype_distributeur"=>$idtype_distributeur,
            "statut"=>$statut,
            "cle_hachage"=>$cle_hachage
        ];
        $instance->call();
        //return ($instance->response);

        if ($instance->response == 104){
            return json_encode(array('erreurCode'=>1004, 'erreurMessage'=>'Cle de hachage incorrect'));
        }
        elseif ($instance->response == 105){
            return json_encode(array('erreurCode'=>1005, 'erreurMessage'=>'Id marchand incorrect'));
        }
        elseif ($instance->response == 1){
            return json_encode(array('erreurCode'=>1006, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        elseif ($instance->response == 0){
            return json_encode(array('erreurCode'=>1007, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        elseif ($instance->response == -1){
            return json_encode(array('erreurCode'=>1008, 'erreurMessage'=>'Une erreur est survenue, veuillez reesayer plutard'));
        }
        else {
            return json_encode(array('erreurCode'=>0, 'message'=>$instance->response));
        }
    }
}