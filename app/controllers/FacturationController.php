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
use app\models\FacturationModel;

class FacturationController extends BaseController
{
    private $facturationModels;

    public function __construct()
    {

        parent::__construct();
        $this->facturationModels = new FacturationModel();
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_facturation"]);
    }


    /**
     * @droit billing in progress - 10
     */
    public function factures()
    {
        $this->views->getTemplate('facturation/factures');

    }


    public function facturesProcessing__(){
        Utils::setDefaultSort(1, "DESC");
        $param = [
            "button" => [
                "default" => [
                    ["facturation/detailFacture/","fa fa-search"],
                ],
                "modal" => [
                    ["facturation/addReglementModal", "facturation/addReglementModal", "fa fa-money"],

                ]
            ],

            "tooltip"=> [
                "default" => [$this->lang["detail"]],
                "modal" => [$this->lang["add_reglement"]]

            ],
            "classCss"=> [
                "modal" => [],
                "default" => []
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>$this->paramGET ,
            "dataVal"=>[
                ["champ"=>"statut","val"=>[0=>["<span style='.temp::before{text-align: right;}' class='temp text-danger'>". $this->lang['non_regle'] ."</span>"],1=>["<span  class='temp text-success' >". $this->lang['regle'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                'montant'=>'alignRightCenter',
                'montant_regle'=>'alignRightCenter',
                'date_reglement'=>'afficherDateReglement',
                'date_creation'=>'getDateFR'

            ]
        ];
        $this->processing($this->facturationModels, "factures", $param);

    }


    public function ajoutReglement(){

        //var_dump($this->paramPOST); exit;

        $idFacture = floatval($this->paramPOST['idFacture']) ;
        $montantFacture =  floatval($this->paramPOST['montant']) ;
        $montantReglement = floatval($this->paramPOST['montant_regle']) ;
        $reliquat = $this->paramPOST['reliquat'] ;
        $champs = [] ;
        $champs["montant_regle =  montant_regle + "] =  $montantReglement ;
        $nouveauReliquat = $montantFacture - ($reliquat + $montantReglement ) ;
        $champs["reliquat = part_numherit - montant_regle - "] = 0 ;
        if ( $nouveauReliquat == 0){
            $champs["statut"] = 1 ;
        }

        $resultUpdateUser = $this->facturationModels->set(["table"=>"facture", "champs"=>$champs, "condition"=>["rowid =" => $idFacture]]);


        if ($resultUpdateUser !== false)
            Utils::setMessageALert(["success", $this->lang['actionsuccess']]);
        else
            Utils::setMessageALert(["danger", $this->lang['actionerror']]);
        Utils::redirect("facturation", "factures");
    }

    public function addReglementModal(){
        $idFacture = $this->paramGET[2] ;
        $facture = $this->facturationModels->getFacture($idFacture) ;
        $data['facture'] = $facture;
        //var_dump($data['facture']); exit;
        $this->views->setData($data);
        $this->modal();

    }


    /**
     * @droit to bill - 10
     */
    public function facturation()
    {
        Utils::setDefaultSort(1, "DESC");

        $dateDebutFacturation = $this->getDateDebutFacturation() ;
        if (isset($this->paramPOST["datefin"])) {
            $data['datefin'] = Utils::date_aaaa_mm_jj($this->paramPOST['datefin']) ;
        }else{
            $beginEnd = date('Y-m-d', strtotime(' -1 day'));
            $data['datefin'] = $beginEnd;
        }

        $data['datedebut'] = $dateDebutFacturation ;

        $dateDebutEn = $data['datedebut'] ;
        $dateFinEn = $data['datefin'];
        //echo $dateDebutEn.' '.$dateFinEn; exit;


        $this->views->setData($data + $this->makeElementsFacture($dateDebutEn, $dateFinEn));
        $this->views->getTemplate("facturation/facturation");
    }

    private function getDateDebutFacturation(){
        $maxRowid = $this->facturationModels->get(["table"=>"facture","champs"=>["Max(rowid) as idMax"]])[0]->idMax;
        if($maxRowid){
            $dateFin = $this->facturationModels->getLastDateFinFacture($maxRowid)->date_fin ;
            $dateDebutFacturation = date('Y-m-d', strtotime('+1 day', strtotime($dateFin)));
        }else{
            $dateDebutFacturation = $this->facturationModels->getFirstDate()->datefin;
        }

        return $dateDebutFacturation ;
    }


    /**
     * @droit generate bill - 10
     */
    public function genererFacture(){

        $dateDebutFacturation = $this->paramPOST['dateDebutFacturation'];
        $dateFinFacturation = $this->paramPOST['dateFinFacturation'];
        $elements = $this->makeElementsFacture($dateDebutFacturation, $dateFinFacturation);
        $transactions = $elements['transactions'] ;
        $nombre = count($transactions) ;
        if ($nombre > 0){
            $data = array();
            $user_creation = $this->_USER->id ;
            $date_debut = date('y-m-d:H:i:s');
            $gie = $this->_USER->gie ;

            $data['nombre_transaction'] = $elements['nbTransactionTotal'];
            $data['part_nta'] = $elements['partNTATotal'];
            $data['part_numherit'] = $elements['partNumheritTotal'];
            $data['reliquat'] = $this->paramPOST['reliquat'];
            $data['montant'] = $elements['montantTotal'];
            $data['montant_total'] = $elements['montantTotal'] + $this->paramPOST['reliquat'];
            $data['date_debut'] = $dateDebutFacturation ;
            $data['date_fin'] = $dateFinFacturation ;
            $data['fk_gie'] =  $gie ;
            $data['user_creation'] = $user_creation;
            $data['date_creation'] = $date_debut ;
            //var_dump($data); exit;

            $data['statut'] = 0 ;
            $insertEtat = 0 ;

            try{

                $this->facturationModels->__beginTransaction();

                $insertFacture = $this->facturationModels->insertFacture($data);
                if (!($insertFacture > 0))
                    throw new \Exception("Erreur insertion table facture :");

                for($i=0; $i < $nombre ; $i++){
                    $data1['fk_facture'] = $insertFacture;
                    $data1['nombre_transaction'] = $transactions[$i]['nombre'];
                    $data1['fk_type_transaction'] = $transactions[$i]['idService'];
                    $data1['part_numherit'] = $transactions[$i]['partNumherit'];
                    $data1['part_nta'] = $transactions[$i]['partNTA'] ;
                    $data1['montant'] = $transactions[$i]['montant'] ;
                    $data1['date_debut'] = $dateDebutFacturation ;
                    $data1['date_fin'] = $dateFinFacturation ;
                    $data1['user_creation'] = $user_creation;
                    $data1['date_creation'] = $date_debut ;
                    $insertEtat = $this->facturationModels->insertDetailFacture($data1) ;
                    if (!($insertEtat > 0))
                        throw new \Exception("Erreur insertion table detail_facture :");
                }

                $this->facturationModels->__commit();
                Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
                Utils::redirect("facturation", "detailFacture", [0 => $insertFacture]);
                return ;

            }catch(Exception $e){
                $this->facturationModels->__rollBack() ;
                Utils::setMessageALert(["danger",$this->lang["actionechec"]].$e->getMessage());
            }

        }else{
            Utils::setMessageALert(["danger",'Aucune transaction disponible']);
            Utils::redirect('facturation','facturation',[0 => 1]);
        }


    }

    private function makeElementsFacture($dateDebutEn, $dateFinEn){
        $transactions = $this->facturationModels->getTransactionsDetails($dateDebutEn, $dateFinEn);

        $arrayTotal = [];
        $partNumheritTotal = 0 ;
        $partNTATotal = 0 ;
        $nbTransactionTotal = 0 ;
        $montantTotal = 0 ;
        $data = [];
        if ($transactions){
            $compteur = 0 ;
            foreach ($transactions as $transaction){
                $array =    array();
                $array['idService'] = $transaction->id ;
                $array['nomService'] = $transaction->libelle ;
                $array['nombre'] = $transaction->nombre ;
                $array['montant'] = $transaction->montant ;
                $montantTotal +=  $transaction->montant ;
                $nbTransactionTotal += $transaction->nombre ;
                $partNTA = $transaction->montant * $transaction->part_nta ;
                $partNumherit = $transaction->montant * $transaction->part_numherit ;
                $partNumheritTotal += $partNumherit ;
                $partNTATotal += $partNTA ;
                $array['partNTA'] = $partNTA ;
                $array['partNumherit'] = $partNumherit ;
                $arrayTotal[$compteur] = $array ;
                $compteur++ ;
            }
        }
        $data['transactions'] = $arrayTotal ;
        $data['montantTotal'] = $montantTotal ;
        $data['nbTransactionTotal'] = $nbTransactionTotal ;
        $data['partNumheritTotal'] = $partNumheritTotal ;
        $data['partNTATotal'] = $partNTATotal ;
        $reliquat = 0 ;
        $data['reliquat'] = $reliquat ;
        //var_dump($data); exit;
        return ($data) ? $data : null ;
    }



    public function index__()
    {
        $this->views->getTemplate("facturation/index");

    }
   public function menu__()
    {

        if (isset($this->paramPOST["datedebut"]) && isset($this->paramPOST["datefin"])) {
            $data['datedebut'] = $this->paramPOST['datedebut'];
            $data['datefin'] =$this->paramPOST['datefin'];

        }else{
            //echo 65465645; exit;
            $beginEnd = date('Y-m-d');
            $yearEnd = date('Y-m-d');

            $data['datedebut'] = $beginEnd;
            $data['datefin'] = $yearEnd;
        }


       $data['types'] = $this->menuModels->getTransactionsDetails($data['datedebut'], $data['datefin']);
        $data['nbreVoyage'] = $this->menuModels->getNbreVoyages($data['datedebut'], $data['datefin'])->nbreVoyage;
        $data['transactions'] = $this->menuModels->getTransactions($data['datedebut'], $data['datefin']);

        $data['montant'] = $this->menuModels->getAllTransactionsJournalieres();


        $this->views->setData($data);

        $this->views->getPage('espace/home/menu');

    }

    public function firstConnect__()
    {
        $this->views->getPage('espace/home/first');

    }

    public function exportRecuVirement()
    {
        //var_dump(1);die;

        $this->views->exportToPdf('facturation/printRecuFacturation');

    }

    /**
     * @droit details bill - 10
     */
    public function detailFacture(){
        $id = $this->paramGET[0] ;
        $data['id'] = $id;
        $this->views->setData($data);
        $this->views->getTemplate('facturation/detail');
    }

    public function detailFactureProcess(){
        Utils::setDefaultSort(1, "DESC");
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
                "default" => [
                    $this->lang["exporter_pdf"]
                ]
            ],
            "classCss"=> [
                "modal" => [],
                "default" => []
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>$this->paramGET ,
            "dataVal"=>[
            ],
            "fonction"=>[

                'nombre_transaction'=>'alignRightCenter',
                'montant'=>'alignRightCenter',
                'part_numherit'=>'alignRightCenter',
                'part_nta'=>'alignRightCenter'

            ]
        ];
        $this->processing($this->facturationModels, "detailFactures", $param);

    }

    public function imprimerFacture()
    {

        $id = $this->paramGET[0];
        $data['impression'] = $this->facturationModels->getImpressionFacture($id);
        $this->views->setData($data);
        $this->views->exportToPdf("facturation/imprimerFacture");



    }

    /**
     * @droit Imprim bill - 10
     */
    public function exportRecuDetail()
    {

        $id = $this->paramGET[0];
        $data['impression'] = $this->facturationModels->getImpressionFacture($id);
        $this->views->setData($data);
        $this->views->exportToPdf('facturation/printRecuFacturation');

    }



}