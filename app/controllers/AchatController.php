<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 21:11
 */

namespace app\controllers;

use app\core\BaseController;
use app\core\Session;
use app\core\Utils;

class AchatController extends BaseController
{
    private $serviceModels;
    private $partenaireModels;
    private $transactionModels;

    public function __construct()
    {
        parent::__construct(false);
        $this->serviceModels = $this->model("service");
        $this->partenaireModels = $this->model("partenaire");
        $this->transactionModels = $this->model("transaction");
    }

    public function verifNumTel()
    {
        $id = 2;
        $api = $this->serviceModels->getApi(["condition" => ["rowid = " => $id]]);
        foreach ($api as $champ){
            $login = $champ->username;
            $password = $champ->password;
        }

        $tel= "00221706733402";
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
        $data['rstApi'] = $this->apiClient->transferTo();
        $responses = explode("\r\n", $data['rstApi']);

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

        //echo \GuzzleHttp\json_encode($this->lang["verif_success"]);die;

        if ($parsed_json->error_code == 0){

            echo json_encode(array("erreurCode" => $parsed_json->error_code, "erreurMessage" => $this->lang["verif_success"], "Pays" => $parsed_json->country, $this->lang["operator"]=>$parsed_json->operator,
                $this->lang["num_desti"] => $parsed_json->destination_msisdn, "Devise"=>$parsed_json->destination_currency, "Liste des montants" => $parsed_json->product_list,
                $this->lang["price_detail"]=>$parsed_json->retail_price_list, "liste des prix en gros" =>$parsed_json->wholesale_price_list));
        }
        else if ($parsed_json->error_code == 101){

            echo json_encode(array("erreurCode" => $parsed_json->error_code, "erreurMessage" => "Numéro de téléphone incorrect"));

        }
    }

    public function achatCredit()
    {
        $id = 2;
        $api = $this->serviceModels->getApi(["condition" => ["rowid = " => $id]]);
        foreach ($api as $champ){
            $login = $champ->username;
            $password = $champ->password;
        }

        $montant = "";
        $tel= "";
        $sms='Felicitation! Vous avez recu '.$montant.' du '.$tel.'. Numherit vous remercie';
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("topup");
        $time = time();
        $data = [
            "topup" => [
                "login"=>$login,
                "key"=>$time,
                "md5"=>md5($login.$password.$time),
                "action"=>"topup",
                "destination_msisdn"=>$tel,
                "msisdn"=>$sms,
                "product"=>$montant
            ]
        ];
        $this->apiClient->setData($data);
        $data['rstApi'] = $this->apiClient->transferTo();
        $responses = explode("\r\n", $data['rstApi']);
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

        //echo $resultat;die;

        if ($parsed_json->error_code == 0){

            echo json_encode(array("erreurCode" => $parsed_json->error_code, "erreurMessage" => $this->lang["verif_success"], "Pays" => $parsed_json->country, $this->lang["operator"]=>$parsed_json->operator,
                $this->lang["num_desti"] => $parsed_json->destination_msisdn, "Devise"=>$parsed_json->destination_currency, "Liste des montants" => $parsed_json->product_list,
                $this->lang["price_detail"]=>$parsed_json->retail_price_list, "liste des prix en gros" =>$parsed_json->wholesale_price_list));

        }else if ($parsed_json->error_code == 101){

            echo json_encode(array("erreurCode" => $parsed_json->error_code, "erreurMessage" => "Numéro de téléphone incorrect"));

        }
    }

    /************** Achat Code Neosurf ***************/
    public function AchatCodeNeosurf()
    {

        //echo sha1('EUR'.'100'.'bocar@numherit.com+P@sser123'.'YTR'.'193'.'1'.'c221diodofdf5g432dfh4ds2s65g1gh6');die();
       /* $idService = $this->serviceModels->getIdService('AchatCodeNeosurf');

        $checkPart = $this->partenaireModels->checkPartenaireAccess(2, $idService);
        if($checkPart === 1){

        }
        else{

        }*/

        /*if(gethostbyname($_SERVER['SERVER_NAME']) === '104.20.252.2' || $_SERVER['HTTP_HOST'] === 'pmp-admin.com')
        {*/
            $this->apiClient->setMethod("post");
            $this->apiClient->setService("AchatCodeNeosurf");
            $rstApi = $this->apiClient->serviceNeosurf();

            echo  $rstApi;


            $obj = json_decode($rstApi);

            if($obj->{'faultcode'} == 2)
            {
                echo json_encode(array('erreurCode'=>1002, 'erreurMessage'=>'Adresse IP de connexion non autorisée'));
            }
            elseif($obj->{'faultcode'} == 2) {
                $tab_return = $obj['dtickets'];

                $pincode = $obj['auth_nb'];

                $dticket = $tab_return[0];

                $pincode= $dticket['pincode'];
                $date_expiry= $dticket['date_expiry'];
                $duration_expiry= $dticket['duration_expiry'];
                $serial_nb= $dticket['serial_nb'];

                return json_encode(array('pincode'=>$pincode, 'date_expiry'=>$date_expiry, 'serial_number'=>$serial_nb));
            }


        /*}
        else{
            $Date = date('Ymd');
            $returnCode = 'NEOTEST'.mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9).'-'.mt_rand(10000000, 999999999).'-'.date('Ymd', strtotime($Date. ' + 30 days'));
            echo $returnCode;
        }*/
    }


    public function  test(){
        //$a = $this->partenaireModels->verifTokenPartenaire('$2y$10$OXYfvwg/ViSkeFuMZIqq6.Q49i0rqSqr7gPUpIe2cQ5lhGs2Pb2TO');

        $a = $this->transactionModels->crediterCompteSVA(1000);
        var_dump($a) ; die();
    }
}