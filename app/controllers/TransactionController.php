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

class TransactionController extends BaseController
{
    private $transactionModels;
    private $busModels;
    private $serviceModels;
    private $clientModels;


    public function __construct()
    {
        parent::__construct();

        $this->reportingModels = $this->model("reporting");
        $this->clientModels = $this->model("client");
        $this->transactionModels = $this->model("transaction");
        $this->busModels = $this->model("bus");
        $this->serviceModels = $this->model("service");
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_reporting"]);
    }

    public function index__()
    {
        $data['nbreClient'] = $this->clientModels->nbreClient();
        $data['nbreClientActif'] = $this->clientModels->nbreClientActif();
        $data['nbreClientDesactive'] = $this->clientModels->nbreClientDesactive();
        $data['caJournalierCarte'] = $this->clientModels->caJournalierCarte();
        $data['caMensuelCarte'] = $this->clientModels->caMensuelCarte();
        $data['caAnnuelCarte'] = $this->clientModels->caAnnuelCarte();
        $data['caJournalierTicket'] = $this->clientModels->caJournalierTicket();
        $data['caMensuelTicket'] = $this->clientModels->caMensuelTicket();
        $data['caAnnuelTicket'] = $this->clientModels->caAnnuelTicket();
        $data['carteDispo'] = $this->clientModels->carteDisponible();
        $data['carteActive'] = $this->clientModels->carteActive();
        $data['carteBloquee'] = $this->clientModels->carteBloquee();

        $data['nbreTickets'] = $this->reportingModels->nbreTicketParMonth();
        $data['reportByMonth'] = $this->reportingModels->reportingByMonth();
        foreach($data['reportByMonth'] as $index => $month){
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
        }

        $this->views->setData($data);
        $this->views->getTemplate('reporting/transaction');


    }


    /**************************************************************** DEBUT GESTION DES Reporting ********************************************************/

    /************************ Liste des Transactions  **********************/

    // Liste Transactions par Partenaire
    public function listeTransaction__()
    {
        //var_dump($this->paramPOST);
        //die();
        $data['bus'] = $this->busModels->getBus();
        //$this->views->setData($data);

        $data['liste'] = (isset($this->paramPOST['bus']))? $this->paramPOST['bus']:0;
        $data['datedeb'] = (isset($this->paramPOST['datedeb']))?Utils::date_aaaa_mm_jj($this->paramPOST['datedeb']):0;
        $data['datefin'] = (isset($this->paramPOST['datefin']))?Utils::date_aaaa_mm_jj($this->paramPOST['datefin']):0;

        $data['datedeb1'] = (isset($this->paramPOST['datedeb']))?$this->paramPOST['datedeb']:0;
        $data['datefin1'] = (isset($this->paramPOST['datefin']))?$this->paramPOST['datefin']:0;
        //var_dump($this->transactionModels->getAllListeTransaction());exit;
       // echo "<pre>";var_dump($data['transaction']);exit;
        //$this->views->setData($);
        //$param['bus1'] = $this->paramPOST['bus'];

       // var_dump($data);




        //$this->views->setData($param);
        $this->views->setData($data);
        $this->views->getTemplate('transaction/listeTransaction');
    }


    // Processing Transactions Partenaires
    public function listeTransactionPro__()
    {
       //var_dump( $this->paramGET);
        $param = [
                    "button" => [
                        "modal" => [

                        ],
                        "default" => [
                            ["transaction/detailListeTransaction/","fa fa-search"],
                        ]

                    ],
                    "tooltip" => [
                        "default" => [$this->lang['Detail']]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" =>  $this->paramGET,
                    "dataVal" => [["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Echoué']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Succes']." </i>"]]]
                    ],
                    "fonction" => ["date"=>"getDateFR","montant"=>"getFormatMoney"]
                ];
                $this->processing($this->transactionModels, 'getAllListeTransaction', $param);
    }

    // Détail Transaction Partenaire
    public function detailListeTransaction()
    {
        //var_dump(111);

        $data['transaction'] = $this->transactionModels->getOneTransaction(["condition" => ["t.id = " => $this->paramGET[0]]]);
       // var_dump($data['transaction']);exit();
        $this->views->setData($data);
        //$this->modal();
        $this->views->getTemplate('transaction/detailListeTransaction');
    }

    // Impression transaction Par Service
    public function printListeTransaction()
    {
        $datedeb = $this->paramPOST['datedeb'];
        $datefin = $this->paramPOST['datefin'];
        $bus = $this->paramPOST['bus'];
        $param = [
            "condition"=>["id ="=>$bus]
        ];
        $data['bus'] = $this->transactionModels->getUnTransaction($param)[0]->matricule;

        $data['transaction'] = $this->transactionModels->getListeTransaction(["condition" =>["t.bus=" => $bus, "DATE(t.date>=" => $datedeb, "DATE(t.date)<=" => $datefin]]);
        
        $this->views->setData($data);
        $this->views->exportToPdf("transaction/printListeTransaction");

    }

    /************************ Reporting Par Partenaire **********************/


    /************************ Transaction par jour **********************/

    public function transactionsJournalieres__()
    {
        //var_dump($data['bus']);die();
        $data['bus'] = $this->busModels->getBus();
        //$this->views->setData($data);

        $data['liste'] = (isset($this->paramPOST['bus']))? $this->paramPOST['bus']:0;
        $data['datedeb'] = (isset($this->paramPOST['datedeb']))?Utils::date_aaaa_mm_jj($this->paramPOST['datedeb']):0;
        $data['datefin'] = (isset($this->paramPOST['datefin']))?Utils::date_aaaa_mm_jj($this->paramPOST['datefin']):0;

        $data['datedeb2'] = (isset($this->paramPOST['datedeb']))?$this->paramPOST['datedeb']:0;
        $data['datefin2'] = (isset($this->paramPOST['datefin']))?$this->paramPOST['datefin']:0;
        //var_dump($this->transactionModels->getAllTransactionsJournalieres());exit;
        //echo "<pre>";var_dump($data['transaction']);exit;
        //$this->views->setData($);
        //$param['bus1'] = $this->paramPOST['bus'];getAllTransactionsJournalieres

        //var_dump($data);die();

        $this->views->setData($data);
        $this->views->getTemplate('transaction/transactionsJournalieres');
    }

    // Processing Transactions Partenaires
    public function transactionsJournalieresPro__()
    {
        //var_dump($this->paramGET); die();
        $param =[
            "button" => [
                "modal" => [

                ],
                "default" => [
                    ["transaction/detailTransactionsJournalieres/","fa fa-search"],
                ]

            ],
            "tooltip" => [
                "default" => [$this->lang['Detail']]
            ],
            "classCss" => [
                "modal" => [],
                "default" => ["confirm"]
            ],
            "attribut" => [],
            "args" =>  $this->paramGET,
            "dataVal" => [
            ],
            "fonction" => ["date"=>"getDateFR","montant"=>"getFormatMoney"]
        ];
        $this->processing($this->transactionModels, 'getAllTransactionsJournalieres', $param);
    }

    public function detailTransactionsJournalieresPro__()
    {

        $param =[
            "button" => [
                "modal" => [

                ],
                "default" => [
                    ["transaction/detailJournalieres/","fa fa-search"],
                ]

            ],
            "tooltip" => [
                "default" => [$this->lang['Detail']]
            ],
            "classCss" => [
                "modal" => [],
                "default" => ["confirm"]
            ],
            "attribut" => [],
            "args" =>  $this->paramGET,
            "dataVal" => [
            ],
            "fonction" => ["date"=>"getDateFR","montant"=>"getFormatMoney"]
        ];
        $this->processing($this->transactionModels, 'getAllDetailTransactionsJournalieres', $param);
    }


    // Détail Transaction Partenaire
    public function detailTransactionsJournalieres__()
    {
       //var_dump($this->paramGET[0]); die();
        $data['bus'] = $this->busModels->getBus();
        $data['dateBus'] = $this->paramGET[0];
        //$this->views->setData($data);

        $data['liste'] = (isset($this->paramPOST['bus']))? $this->paramPOST['bus']:0;
        $data['datedeb'] = (isset($this->paramPOST['datedeb']))?Utils::date_aaaa_mm_jj($this->paramPOST['datedeb']):0;
        $data['datefin'] = (isset($this->paramPOST['datefin']))?Utils::date_aaaa_mm_jj($this->paramPOST['datefin']):0;


        $data['transaction'] = $this->transactionModels->getAllDetailTransactionsJournalieres(["condition" => ["t.id = " => $this->paramGET[0]]]);
        //var_dump($data['transaction']);exit();
        $this->views->setData($data);
       // var_dump($data);die;
        $this->views->getTemplate('transaction/detailTransactionsJournalieres');
    }

    public function detailJournalieres()
    {
        $donne = explode('_',$this->paramGET[0])  ;

        //var_dump($donne);die;
        $data['bus'] = $this->busModels->getBus();
        $data['matriBus'] = $donne[0];
        $data['dateBus'] = $donne[1];


        //$this->views->setData($data);

        $data['liste'] = (isset($this->paramPOST['bus']))? $this->paramPOST['bus']:0;
        $data['datedeb'] = (isset($this->paramPOST['datedeb']))?Utils::date_aaaa_mm_jj($this->paramPOST['datedeb']):0;
        $data['datefin'] = (isset($this->paramPOST['datefin']))?Utils::date_aaaa_mm_jj($this->paramPOST['datefin']):0;

       // $data['transaction'] = $this->transactionModels->getAllDetailJournalieres($donne);
         //var_dump($data['transaction']);exit();
        $this->views->setData($data);
        //$this->modal();
        //var_dump($data);die;
        $this->views->getTemplate('transaction/detailJournalieres');
    }


    public function detailJournalieresPro__()
    {
        // var_dump($this->paramGET);
        $param =[
            "button" => [
                "modal" => []
            ],
            "tooltip" => [
                "default" => []
            ],
            "classCss" => [
                "modal" => [],
                "default" => ["confirm"]
            ],
            "attribut" => [],
            "args" =>  $this->paramGET,
            "dataVal" => [
            ],
            "fonction" => ["date"=>"getDateFR","montant"=>"getFormatMoney"]
        ];
        $this->processing($this->transactionModels, 'getAllDetailJournalieres', $param);
    }

    // Impression transaction Par Service
    public function printTransactionsJournalieres()
    {
        $datedeb = $this->paramPOST['datedeb'];
        $datefin = $this->paramPOST['datefin'];
        $bus = $this->paramPOST['bus'];
        $param = [
            "condition"=>["id ="=>$bus]
        ];
        /*$data['bus'] = $this->transactionModels->getUnTransaction($param)[0]->matricule;

        $data['transaction'] = $this->transactionModels->getListeTransaction(["condition" =>["t.etat="=>1,"t.bus=" => $bus, "DATE(t.date>=" => $datedebut, "DATE(t.date)<=" => $datefin]]);*/
        $data['bus'] = $this->transactionModels->getUnTransaction($param)[0]->matricule;

        $data['transaction'] = $this->transactionModels->getTransactionsJournalieres(["condition" =>["t.bus=" => $bus, "DATE(t.date>=" => $datedeb, "DATE(t.date)<=" => $datefin]]);
        $this->views->setData($data);
        $this->views->exportToPdf("transaction/printTransactionsJournalieres");

    }
    public function printDetailTransactionsJournalieres()
    {
        $datedeb = $this->paramPOST['datedeb'];
        $datefin = $this->paramPOST['datefin'];
        $bus = $this->paramPOST['bus'];
        $param = [
            "condition"=>["id ="=>$bus]
        ];
        /*$data['bus'] = $this->transactionModels->getUnTransaction($param)[0]->matricule;

        $data['transaction'] = $this->transactionModels->getListeTransaction(["condition" =>["t.etat="=>1,"t.bus=" => $bus, "DATE(t.date>=" => $datedebut, "DATE(t.date)<=" => $datefin]]);*/
        $data['bus'] = $this->transactionModels->getUnTransaction($param)[0]->matricule;

        $data['transaction'] = $this->transactionModels->getDetailTransactionsJournalieres(["condition" =>["t.bus=" => $bus, "DATE(t.date>=" => $datedeb, "DATE(t.date)<=" => $datefin]]);
        $this->views->setData($data);
        $this->views->exportToPdf("transaction/printDetailTransactionsJournalieres");

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


    /************************ Commission Partenaire **********************/


    /**************************************************************** FIN GESTION DES Reporting ********************************************************/




}