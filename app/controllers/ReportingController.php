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
use app\models\ReportingModel ;

class ReportingController extends BaseController
{
    private $reportingModels;
    private $partenaireModels;
    private $serviceModels;

    public function __construct()
    {
        parent::__construct();
        $this->reportingModels = new ReportingModel();
        $this->partenaireModels = $this->model("partenaire");
        $this->serviceModels = $this->model("service");
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_reporting"]);
    }

    public function index__()
    {
        $this->views->getTemplate('reporting/reporting');

    }



    public function commission__()
    {
        if (isset($this->paramPOST["datedebut"]) && isset($this->paramPOST["datefin"])) {
            $data['datedebut'] = $this->paramPOST['datedebut'];
            $data['datefin'] = $this->paramPOST['datefin'];
        }else{
            //echo 65465645; exit;
            $beginEnd = date('Y-m-d', strtotime('Jan 01'));
            $yearEnd = date('Y-m-d', strtotime('12/31'));

            $data['datedebut'] = $beginEnd;
            $data['datefin'] = $yearEnd;
        }
        //var_dump( $data);exit;
        $data['commission'] = $this->reportingModels->getCommission($data['datedebut'] ,$data['datefin']);

        $this->views->setData($data);

        $this->views->getTemplate('reporting/commission');

    }

    public function enrolement__()
    {
        Utils::setDefaultSort(1, "DESC");
        $distributeurSelected = '';
        if (isset($this->paramPOST["datedebut"]) && isset($this->paramPOST["datefin"]) && isset($this->paramPOST["distributeurSelected"])) {
            $data['datedebut'] = $this->paramPOST['datedebut'];
            $data['datefin'] = $this->paramPOST['datefin'];
            $data['distributeurSelected'] = intval($this->paramPOST['distributeurSelected']);
            $distributeurSelected = $data['distributeurSelected'] ;
        }else{
            $beginEnd = date('Y-m-d', strtotime('Jan 01'));
            $yearEnd = date('Y-m-d', strtotime('12/31'));

            $data['datedebut'] = $beginEnd;
            $data['datefin'] = $yearEnd;
        }
        $data['enrolement'] = $this->reportingModels->getEtatEnrolement(intval($distributeurSelected), $data['datedebut'] ,$data['datefin']);
        $data['distributeurs'] = $this->reportingModels->getDistributeurs();

        $this->views->setData($data);

        $this->views->getTemplate('reporting/enrolement');

    }

    public function rechargement__()
    {


        Utils::setDefaultSort(1, "DESC");
        $distributeurSelected = '';
        if (isset($this->paramPOST["datedebut"]) && isset($this->paramPOST["datefin"]) && isset($this->paramPOST["distributeurSelected"])) {
            $data['datedebut'] = $this->paramPOST['datedebut'];
            $data['datefin'] = $this->paramPOST['datefin'];
            $data['distributeurSelected'] = intval($this->paramPOST['distributeurSelected']);
            $distributeurSelected = $data['distributeurSelected'] ;
        }else{
            $beginEnd = date('Y-m-d', strtotime('Jan 01'));
            $yearEnd = date('Y-m-d', strtotime('12/31'));

            $data['datedebut'] = $beginEnd;
            $data['datefin'] = $yearEnd;
        }
        $data['rechargement'] = $this->reportingModels->getEtatRechargement(intval($distributeurSelected), $data['datedebut'] ,$data['datefin']);
        $data['distributeurs'] = $this->reportingModels->getDistributeurs();

        $this->views->setData($data);

        $this->views->getTemplate('reporting/rechargement');

    }

    public function rechargementProcessing__()
    {
        $param = [
            "button"=> [
                "modal" => [],
                "default" => [
                    [],
                    []
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [],
                $this->lang["detail"]
            ],
            "classCss"=> [
                "modal" => [],
                "default" => []
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>$this->paramGET,
            "dataVal"=>[
                ["champ"=>"statut","val"=>[0=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>". $this->lang['echoue'] ."</span>"],1=>["<span  class='temp text-success' >". $this->lang['reussi'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                'montant'=>'alignRightCenter'
            ]
        ];
        /* if($this->appConfig->profile_level == 2)
             array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->reportingModels, "rechargement", $param);
    }

    public function enrolementProcessing__()
    {
        $param = [
            "button"=> [
                "modal" => [],
                "default" => [
                    [],
                    []
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [],
                $this->lang["detail"]
            ],
            "classCss"=> [
                "modal" => [],
                "default" => []
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>$this->paramGET,
            "dataVal"=>[
                ["champ"=>"statut","val"=>[0=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>". $this->lang['echoue'] ."</span>"],1=>["<span  class='temp text-success' >". $this->lang['reussi'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                'solde'=>'alignRightCenter'
            ]
        ];
        /* if($this->appConfig->profile_level == 2)
             array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->reportingModels, "enrolement", $param);
    }

    public function commissionProcessing__()
    {
        $param = [
            "button"=> [
                "modal" => [],
                "default" => [
                    [],
                    ["versement/detailVersement/","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [],
                $this->lang["detail"]
            ],
            "classCss"=> [
                "modal" => [],
                "default" => []
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>$this->paramGET,
            "dataVal"=>[
                ["champ"=>"statut","val"=>[0=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>". $this->lang['echoue'] ."</span>"],1=>["<span  class='temp text-success' >". $this->lang['reussi'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                'nb_ticket'=>'alignCenter',
                'montant_total'=>'alignRightCenter',
                'com_numherit'=>'alignRightCenter'
            ]
        ];
        /* if($this->appConfig->profile_level == 2)
             array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->reportingModels, "CommissionProcess", $param);
    }





    /**************************************************************** DEBUT GESTION DES Reporting ********************************************************/

    /************************ Reporting Par Partenaire **********************/

    // Liste Transactions par Partenaire
    public function transactPartenaire()
    {
        $data['liste_part'] = $this->partenaireModels->getPartenaire();
        $this->views->setData($data);
        $param['part'] = $this->paramPOST['fk_partenaire'];

        if (isset($this->paramPOST["datedeb"]) & isset($this->paramPOST["datefin"])) {

            $param['datedeb'] = Utils::date_aaaa_mm_jj($this->paramPOST['datedeb']) ;
            $param['datefin'] = Utils::date_aaaa_mm_jj($this->paramPOST['datefin']);

        }else{
            $param['datedeb'] = date('Y-m-d');
            $param['datefin'] = date('Y-m-d');
        }

        $this->views->setData($param);
        $this->views->getTemplate('reporting/transactPartenaire');
    }

    // Processing Transactions Partenaires
    public function transactPartenairePro__()
    {
       // var_dump($this->paramGET); die();
        $param = [
                    "button" => [
                        "modal" => [
                            ["reporting/detailTransactPartModal", "reporting/detailTransactPartModal", "fa fa-search"],
                        ],
                        "default" => [
                        ]
                    ],
                    "tooltip" => [
                        "modal" => ["Détail"]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => $this->paramGET,
                    "dataVal" => [
                    ],
                    "fonction" => ["date_transaction"=>"getDateFR","montant"=>"getFormatMoney","commission"=>"getFormatMoney"]
                ];
                $this->processing($this->reportingModels, 'getAllTransactionPartenaire', $param);
    }

    // Détail Transaction Partenaire
    public function detailTransactPartModal()
    {
        $data['transactPart'] = $this->reportingModels->getOneTransaction(["condition" => ["t.rowid = " => $this->paramGET[2]]]);
        $this->views->setData($data);
        $this->modal();
    }

    // Impression transaction Par Service
    public function impressionTransactionPart()
    {
        $datedebut = $this->paramPOST['datedeb'];
        $datefin = $this->paramPOST['datefin'];
        $partenaire = $this->paramPOST['fk_partenaire'];
        $param = [
            "condition"=>["rowid ="=>$partenaire]
        ];
        $data['parte'] = $this->reportingModels->getUnPartenaire($param)[0]->raison_sociale;

        $data['transac'] = $this->reportingModels->getTransactionPartenaire(["condition" =>["t.statut="=>1,"t.fk_partenaire=" => $partenaire, "DATE(t.date_transaction)>=" => $datedebut, "DATE(t.date_transaction)<=" => $datefin]]);
        
        $this->views->setData($data);
        $this->views->exportToPdf("reporting/printTransactionsPart");

    }

    /************************ Reporting Par Partenaire **********************/


    /************************ Reporting Par Service **********************/

    // Liste Transactions par Service
    public function transactService()
    {
        $data['liste_serv'] = $this->serviceModels->getService();
        $this->views->setData($data);
        $param['serv'] = $this->paramPOST['fk_service'];

        if (isset($this->paramPOST["datedeb"]) & isset($this->paramPOST["datefin"])) {

            $param['datedeb'] = Utils::date_aaaa_mm_jj($this->paramPOST['datedeb']) ;
            $param['datefin'] = Utils::date_aaaa_mm_jj($this->paramPOST['datefin']);

        }else{
            $param['datedeb'] = date('Y-m-d');
            $param['datefin'] = date('Y-m-d');
        }

        $this->views->setData($param);
        $this->views->getTemplate('reporting/transactService');
    }

    // Processing Transactions pour un Service
    public function transactServicePro__()
    {
        //var_dump($this->paramGET); die();
        $param = [
            "button" => [
                "modal" => [
                    ["reporting/detailTransactServModal", "reporting/detailTransactServModal", "fa fa-search"],
                ],
                "default" => [
                ]
            ],
            "tooltip" => [
                "modal" => ["Détail"]
            ],
            "classCss" => [
                "modal" => [],
                "default" => ["confirm"]
            ],
            "attribut" => [],
            "args" => $this->paramGET,
            "dataVal" => [
            ],
            "fonction" => ["date_transaction"=>"getDateFR","montant"=>"getFormatMoney","commission"=>"getFormatMoney"]
        ];
        $this->processing($this->reportingModels, 'getAllTransactionService', $param);
    }

    // Détail Transaction d'un Service
    public function detailTransactServModal()
    {
        $data['transactServ'] = $this->reportingModels->getOneService(["condition" => ["t.rowid = " => $this->paramGET[2]]]);
        $this->views->setData($data);
        $this->modal();
    }

    // Impression transaction Par Service
    public function impressionTransactionServ()
    {
        $datedebut = $this->paramPOST['datedeb'];
        $datefin = $this->paramPOST['datefin'];
        $service = $this->paramPOST['fk_service'];

        $param = [
            "condition"=>["rowid ="=>$service]
        ];
        $data['service'] = $this->reportingModels->getUnService($param)[0]->label;

        $data['transact'] = $this->reportingModels->getTransactionService(["condition" =>["t.statut="=>1,"t.fk_service=" => $service, "DATE(t.date_transaction)>=" => $datedebut, "DATE(t.date_transaction)<=" => $datefin]]);
        $this->views->setData($data);
        $this->views->exportToPdf('reporting/printTransactionsServ');
    }

    /************************ Reporting par Service **********************/


    /************************ Commission Partenaire **********************/

    public function commissionPartenaire()
    {
        $data['liste_part'] = $this->partenaireModels->getPartenaire();
        $this->views->setData($data);

        $this->views->getTemplate('reporting/commissionPartenaire');
    }

    public function reportingParPart()
    {

        $data['part'] = $this->paramPOST['fk_partenaire'];

        if (isset($this->paramPOST["datedeb"]) & isset($this->paramPOST["datefin"])) {

            $data['datedeb'] = Utils::date_aaaa_mm_jj($this->paramPOST['datedeb']) ;
            $data['datefin'] = Utils::date_aaaa_mm_jj($this->paramPOST['datefin']);

        }else{
            $data['datedeb'] = date('Y-m-d');
            $data['datefin'] = date('Y-m-d');
        }

        $data['res'] = $this->reportingModels->getComParPart($data['datedeb'],$data['datefin'],$data['part']);

        $data['liste_part'] = $this->partenaireModels->getPartenaire();
        $this->views->setData($data);
        $this->views->getTemplate('reporting/comParPartenaire');
    }

    public function printCommissionPart()
    {
        //var_dump($this->paramPOST); die();

        $datedebut = $this->paramPOST['datedeb'];
        $datefin = $this->paramPOST['datefin'];
        $partenaire = $this->paramPOST['fk_partenaire'];
        $param = [
            "condition"=>["rowid ="=>$partenaire]
        ];
        $data['parte'] = $this->reportingModels->getUnPartenaire($param)[0]->raison_sociale;

        $data['trans'] = $this->reportingModels->getComParPart($datedebut,$datefin,$partenaire);
        //var_dump($data['trans']); die();

        $this->views->setData($data);
        $this->views->exportToPdf('reporting/printCommissionPart');
    }

    public function clientReporting__()
    {
        $data['reportByMonth'] = $this->reportingModels->reportingByMonth();
       // var_dump( $data['reportByMonth']);die;
       // $data['reportByMonth_']=[];

        foreach($data['reportByMonth'] as $index => &$month){
            $mois = '';
            switch ($month->mois) {
                case 1:
                    $mois = "Janvier";
                    break;
                case 2:
                    $mois = "Fevrier";
                    break;
                case 3:
                    $mois = "Mars";
                    break;
                case 4:
                    $mois = "Avril";
                    break;
                case 5:
                    $mois = "Mai";
                    break;
                case 6:
                    $mois = "Juin";
                    break;
                case 7:
                    $mois = "Juillet";
                    break;
                case 8:
                    $mois = "Aout";
                    break;
                case 9:
                    $mois = "Septembre";
                    break;
                case 10:
                    $mois = "Octobre";
                    break;
                case 11:
                    $mois = "Novembre";
                    break;
                case 12:
                    $mois = "Decembre";
                    break;
                default:

            }
            $data['reportByMonth'][$index]->mois = $mois ;
          // $data['reportByMonth_'][]=$mois;


        }
//var_dump($data['reportByMonth']);die;

        //$data['reportByMonth']=$data['reportByMonth_'];
        //var_dump($data['reportByMonth']);die;
        $this->views->setData($data);
        $this->views->getTemplate("reporting/clientReporting");
        //$this->views->getTemplate("transaction/transaction");
    }

    public function reportingTicket(){
        $data['nbreTicketCash'] = $this->reportingModels->ticketTotalPerCash();
        $data['ticketVenduCash'] = $this->reportingModels->ticketVenduCash();
        $data['nbreTicketCard'] = $this->reportingModels->ticketTotalPerCard();
        $data['ticketVenduCard'] = $this->reportingModels->ticketVenduCard();
        $data['ticketCashByMonth'] = $this->reportingModels->ticketCashByMonth();
        foreach($data['ticketCashByMonth'] as $index => $month){
            $mois = '';
            switch ($month->mois) {
                case 1:
                    $mois = "Janvier";
                    break;
                case 2:
                    $mois = "Fevrier";
                    break;
                case 3:
                    $mois = "Mars";
                    break;
                case 4:
                    $mois = "Avril";
                    break;
                case 5:
                    $mois = "Mai";
                    break;
                case 6:
                    $mois = "Juin";
                    break;
                case 7:
                    $mois = "Juillet";
                    break;
                case 8:
                    $mois = "Aout";
                    break;
                case 9:
                    $mois = "Septembre";
                    break;
                case 10:
                    $mois = "Octobre";
                    break;
                case 11:
                    $mois = "Novembre";
                    break;
                case 12:
                    $mois = "Decembre";
                    break;
                default:

            }
            $data['ticketCashByMonth'][$index]->mois = $mois ;
        }
        $data['ticketCardByMonth'] = $this->reportingModels->ticketCardByMonth();
        foreach($data['ticketCardByMonth'] as $index => $month){
            $mois = '';
            switch ($month->mois) {
                case 1:
                    $mois = "Janvier";
                    break;
                case 2:
                    $mois = "Fevrier";
                    break;
                case 3:
                    $mois = "Mars";
                    break;
                case 4:
                    $mois = "Avril";
                    break;
                case 5:
                    $mois = "Mai";
                    break;
                case 6:
                    $mois = "Juin";
                    break;
                case 7:
                    $mois = "Juillet";
                    break;
                case 8:
                    $mois = "Aout";
                    break;
                case 9:
                    $mois = "Septembre";
                    break;
                case 10:
                    $mois = "Octobre";
                    break;
                case 11:
                    $mois = "Novembre";
                    break;
                case 12:
                    $mois = "Decembre";
                    break;
                default:

            }
            $data['ticketCardByMonth'][$index]->mois = $mois ;
        }
        $this->views->setData($data);
        $this->views->getTemplate("reporting/reportingTicket");
    }


    /************************ Commission Partenaire **********************/


    /**************************************************************** FIN GESTION DES Reporting ********************************************************/




}