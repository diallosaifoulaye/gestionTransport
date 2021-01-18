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

class neosurf extends ApiServer
{

    private $partenaireModel;
    private $serviceModel;
    public function __construct()
    {
        parent::__construct(__CLASS__);
        $this->partenaireModel = $this->model("partenaire");
        $this->serviceModel = $this->model("service");

    }

    function authorize(){
        return (TokenJWT::verif($this->token, TOKEN_KEY));
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
        $verif_token = $verif_token->{'id'};

            $service = $this->serviceModel->getIdService('AchatCodeNeosurf');
            $checkPartAccess = $this->partenaireModel->checkPartenaireAccess($verif_token, $service);
            if($checkPartAccess == 1)
            {
                $soldePartenaire = $this->partenaireModel->getSoldePartenaire($verif_token);
                if($soldePartenaire > $montant)
                {
                    /*if(gethostbyname($_SERVER['SERVER_NAME']) === '104.20.252.2' || $_SERVER['HTTP_HOST'] === 'pmp-admin.com')
                    {*/
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
                            return array('erreurCode'=>1002, 'erreurMessage'=>'Adresse IP de connexion non autorisée');
                        }
                        elseif($obj->{'faultcode'} == 2)
                        {
                            $tab_return = $obj['dtickets'];
                            $pincode = $obj['auth_nb'];
                            $dticket = $tab_return[0];
                            $pincode = $dticket['pincode'];
                            $date_expiry = $dticket['date_expiry'];
                            $duration_expiry = $dticket['duration_expiry'];
                            $serial_nb = $dticket['serial_nb'];
                            return array('pincode'=>$pincode, 'date_expiry'=>$date_expiry, 'serial_number'=>$serial_nb);
                        }
                    /*}
                    else{
                        $Date = date('Ymd');
                        $returnCode = 'NEOTEST'.mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9).'-'.mt_rand(10000000, 999999999).'-'.date('Ymd', strtotime($Date. ' + 30 days'));
                        return $returnCode;
                    }*/
                }
                else{
                    return array('erreurCode'=>3001, 'erreurMessage'=>'Votre solde est insuffisant');
                }
            }
            else{
                return array('erreurCode'=>3002, 'erreurMessage'=>'Vous n\'avez pas l\'autorisation pour ce service');
            }
//        }
//        else{
//            return array('erreurCode'=>3003, 'erreurMessage'=>'Votre token est invalide');
//        }
    }
}