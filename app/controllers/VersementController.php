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
use app\models\VersementModel ;
use app\models\AgentModel ;

class VersementController extends BaseController
{
    private $versement;
    private $agentModels;

    public function __construct()
    {

        parent::__construct();
        $this->versement = new VersementModel();
        $this->agentModels = new AgentModel();
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_versement"]);
    }



    public function insertVersement(){
        $nombre = count($this->paramPOST['lesids']) ;
        $id = intval($this->paramPOST['fk_collecteur']) ;
        if ($nombre > 0){
            $data = array();
            $user_creation = $this->_USER->id ;
            $date_debut = date('y-m-d:H:i:s');
            $gie = $this->_USER->gie ;

            $data['fk_collecteur'] = $id;
            $data['fk_gie'] =  $gie ;
            $data['user_crea'] = $user_creation;
            $data['date_versement'] = $date_debut ;
            $data['montant_collect'] = $this->paramPOST['montant_collect'];
            $data['montant_verse'] = $this->paramPOST['montant_collect'];
            $data['manquant'] = $data['montant_collect'] - $data['montant_verse'] ;
            $data['etat'] = 1 ;
            $data['nb_collecte'] = $nombre ;
            $insertEtat = 0 ;
            $updateEtat = 0 ;

            try{

                $this->versement->beginTransaction();

                $insertVersement = $this->versement->insertVersement($data);
                if ($insertVersement > 0){


                    for($i=0; $i<$nombre;$i++){

                        $data1['fk_agence'] = $gie ;
                        $data1['fk_versement'] = $insertVersement;
                        $data1['fk_collecteur'] = $id;
                        $data1['date_versement'] = $this->paramPOST['date'.$i];
                        $data1['montant_verse'] = intval($this->paramPOST['montant_collect'.$i]);
                        $data1['montant_collect'] = intval($this->paramPOST['montant_collect'.$i]);
                        $data1['manquant'] = intval($this->paramPOST['montant_collect'.$i]-$this->paramPOST['montant_collect'.$i]);
                        $data1['date_creation'] = date("Y-m-d H:i:s");
                        $insertEtat = $this->versement->insertDetailVersement($data1) ;
                        $updateEtat = $this->versement->updateTransaction($id,$data1['date_versement']) ;
                    }

                }

                if(($insertEtat > 0) && ($updateEtat > 0)){
                    $this->versement->commit();
                    Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
                    $a[0] = $insertVersement;
                    Utils::redirect("versement", "detailVersement", $a);
                    return ;
                }
            }catch(Exception $e){
                $this->versement->rollBack() ;
                Utils::setMessageALert(["danger",$this->lang["actionechec"]].$e->getMessage());
            }

        }else{
            $this->versement->rollBack() ;
        }
        Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        Utils::redirect('versement','detailCollect',[0 => $id]);

    }


    /**
     * @droit Liste transaction - 17
     */
    public function insertUnVersement(){
        $nombre = count($this->paramPOST['lid']) ;
        $id = intval($this->paramPOST['fk_collecteur']) ;
        if ($nombre > 0){
            $data = array();
            $user_creation = $this->_USER->id ;
            $date_debut = date('y-m-d:H:i:s');
            $gie = $this->_USER->gie ;

            $data['fk_collecteur'] = $id;
            $data['fk_gie'] =  $gie ;
            $data['user_crea'] = $user_creation;
            $data['date_versement'] = $date_debut ;
            $data['montant_collect'] = $this->paramPOST['montant_collect'];
            $data['montant_verse'] = $this->paramPOST['montant_verse'];
            $data['manquant'] = $data['montant_collect'] - $data['montant_verse'] ;
            $data['etat'] = 1 ;
            $data['nb_collecte'] = $nombre ;
            $insertEtat = 0 ;
            $updateEtat = 0 ;

            try{

                $this->versement->__beginTransaction();

                $insertVersement = $this->versement->insertVersement($data);
                //echo 'INSET: '.$insertVersement ;
                if ($insertVersement > 0){
                    $data1['fk_gie'] = $gie ;
                    $data1['fk_versement'] = $insertVersement;
                    $data1['fk_collecteur'] = $id;
                    $data1['date_versement'] = $this->paramPOST['date'];
                    $data1['montant_verse'] = intval($this->paramPOST['montant_collect']);
                    $data1['montant_collect'] = intval($this->paramPOST['montant_collect']);
                    $data1['manquant'] = intval($this->paramPOST['montant_collect'] - $this->paramPOST['montant_verse']);
                    $data1['date_creation'] = date("Y-m-d H:i:s");
                    $insertEtat = $this->versement->insertDetailVersement($data1) ;
                    $updateEtat = $this->versement->updateTransaction($id , $data1['date_versement']) ;
                    // echo "IN_DET :".$insertEtat." UPDAT_TR".$updateEtat ; exit;

                }

                if(($insertEtat > 0) && ($updateEtat > 0)){
                    $this->versement->__commit();
                    Utils::setMessageALert(["success",$this->lang["action_success"]]);
                    $a[0] = $insertVersement;
                    Utils::redirect("versement", "detailVersement", $a);
                    return ;
                }
            }catch(Exception $e){
                $this->versement->__rollBack() ;
                Utils::setMessageALert(["danger",$this->lang["action_echec"]].$e->getMessage());
            }

        }else{
            $this->versement->__rollBack() ;
        }
        Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        Utils::redirect('versement','detailCollect',[0 => $id]);

    }

    public function export()
    {
        //var_dump($this->paramGET); exit;
        $versements = $this->versement->historique($this->paramGET);
        $data['versements'] = $versements ;
        $data['debut']=$this->paramGET[0];
        $data['fin']=$this->paramGET[1];
        $data['collecteur']=$this->paramGET[2];
        $this->views->setData($data);
        if ($versements) {
            $this->views->exportToPdf('versement/printVersement');
        } else{
            Utils::setMessageALert(["danger",$this->lang["repech"]]);
            Utils::redirect("transaction", "liste");
        }


    }

    public function exportRecu()
    {
        $id = $this->paramPOST['rowid'] ;
        $param['condition'] = ["v.rowid = "=>$id];
        $versement = $this->versement->getVersementById($param);
        $data['versement'] = $versement;

        $details = $this->versement->detailsVersements([0=>$id]);
        $data['details'] = $details ;

        $this->views->setData($data);
        if ($details && $versement ) {
            $this->views->exportToPdf('versement/printRecu');
        } else{
            Utils::setMessageALert(["danger",$this->lang["repech"]]);
            Utils::redirect("transaction", "liste");
        }


    }



    //--------------------------TRANSACTION------------------------

    /**
     * @authorize
     */
    public function collectEncours__(){
        $this->views->getTemplate('versement/collectencours');

    }

    /**
     * @authorize
     */
    public function manquements__(){
        $this->views->getTemplate('versement/manquements');

    }

    public function manquementsReceveur__(){
        $this->views->getTemplate('versement/manquementsReceveur');

    }

    public function manquementsReceveurProcessing__()
    {
        $param = [
            "button"=> [
                "modal" => [],
                "default" => [
                    [],
                    ["versement/detailReceveur/","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [],
                "default" => ["Détails manquements"]
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
                ["champ"=>"etat","val"=>[0=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>". $this->lang['echoue'] ."</span>"],1=>["<span  class='temp text-success' >". $this->lang['reussi'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                'manquant'=>'alignRightMontantRed'

            ]
        ];
        $this->processing($this->versement, "manquementsRecveurProcess", $param);
    }

    public function manquementProcessing__()
    {
        $param = [
            "button"=> [
                "modal" => [],
                "default" => [
                    [],
                    ["versement/detailManquement/","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [],
                "default" => ["Détails manquements"]
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
                ["champ"=>"etat","val"=>[0=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>". $this->lang['echoue'] ."</span>"],1=>["<span  class='temp text-success' >". $this->lang['reussi'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                'nbManquement'=>'alignCenter',
                'montant_c'=>'alignRightCenter',
                'montant_v'=>'alignRightCenter',
                'manquant'=>'alignRightMontantRed'

            ]
        ];
        $this->processing($this->versement, "manquementProcess", $param);
    }

    public function remboursementPro__()
    {
        $param = [
            "button"=> [
                "modal" => [],
                "default" => [
                    [],
                    ["versement/detailManquement/","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [],
                "default" => ["Détails manquements"]
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
                ["champ"=>"etat","val"=>[0=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>". $this->lang['echoue'] ."</span>"],1=>["<span  class='temp text-success' >". $this->lang['reussi'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                'manquant_avant'=>'alignRightCenter',
                'manquant_apres'=>'alignRightCenter',
                'montant_rembourse'=>'alignRightMontantRed'

            ]
        ];
        $this->processing($this->versement, "remboursementProcess", $param);
    }

    public function ajoutRemboursement()
    {
        $this->versement->__beginTransaction() ;
        try{

            $idReceveur = $this->paramPOST['fk_receveur'] ;


            if ($idReceveur){

                $montant_rembourse = $this->paramPOST['montant_rembourse'] ;
                $manquant_avant = $this->paramPOST['manquant_avant'] ;

                $champs = array();
                $champs['user_crea'] = $this->_USER->id ;
                $champs['date_remboursement'] = date("Y-m-d H:i:s") ;

                $champs['montant_rembourse'] = $montant_rembourse;
                $champs['manquant_avant'] = $manquant_avant;
                $champs['fk_receveur'] = $idReceveur ;
                $champs['manquant_apres'] =  intval($manquant_avant - $manquant_avant) ;


                $resultHisto = $this->versement->set(["table"=>"remboursement","champs" => $champs]);
                if (!($resultHisto))
                    throw new \Exception($this->lang["echec_add_element"].' table remboursement') ;


                $resultUpdateCarte = $this->versement->set(["table"=>"utilisateur", "champs"=>["solde_manquement = solde_manquement -  " => $montant_rembourse], "condition"=>["id ="=>$idReceveur]]);

                if (!$resultUpdateCarte)
                    throw new \Exception('echec insert table utilisateur') ;

            }else
                throw new \Exception($this->lang["receveur_inexistant"]) ;


            $this->versement->__commit() ;
            Utils::setMessageALert(["success", $this->lang["succes_add_element"]]);

        }catch (\Exception $e){
            $this->versement->__rollBack() ;
            Utils::setMessageALert(["danger",  $this->lang["echec_add_element"]." ".$e->getMessage()]);
        }

        Utils::redirect("versement", "detailReceveur/".base64_encode($idReceveur));

    }


    public function detailReceveur(){
        if (isset($this->paramPOST["datedebut"]) && isset($this->paramPOST["datefin"])) {
            $data['datedebut'] = $this->paramPOST['datedebut'];
            $data['datefin'] = $this->paramPOST['datefin'];
            $idReceveur = $this->paramPOST['idReceveur'] ;

        }else{
            //echo 65465645; exit;
            $beginEnd = date('Y-m-d', strtotime('Jan 01'));
            $yearEnd = date('Y-m-d', strtotime('12/31'));
            $idReceveur = $this->paramGET[0] ;

            $data['datedebut'] = $beginEnd;
            $data['datefin'] = $yearEnd;
        }

        $data['manquant'] = $this->versement->getManquementReceveur($idReceveur,$data['datedebut'] ,$data['datefin']);
        $data['collecteur'] = $this->versement->get(["table"=>"utilisateur","champs"=>["nom , prenom ,email, telephone, solde_manquement, etat, id"],"condition" => ["id = " => $idReceveur]])[0];
        $this->views->setData($data);

        $this->views->getTemplate('versement/detailReceveur');
    }

    public function detailManquement(){

        $data['manquant'] = $this->versement->getManquementReceveur($this->paramGET[0]);
        $data['collecteur'] = $this->versement->get(["table"=>"utilisateur","champs"=>["nom , prenom , etat, id"],"condition" => ["id = " => $this->paramGET[0]]])[0];
        $this->views->setData($data);

        $this->views->getTemplate('versement/detailManquement');
    }

    public function detailManquementProcessing__()
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
            "args"=>$this->paramGET ,
            "dataVal"=>[
                ["champ"=>"statut","val"=>[0=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>". $this->lang['echoue'] ."</span>"],1=>["<span  class='temp text-success' >". $this->lang['reussi'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                'montant_c'=>'alignRightCenter',
                'montant_v'=>'alignRightCenter',
                'manquant'=>'alignRightMontantRed'
            ]
        ];
        /* if($this->appConfig->profile_level == 2)
             array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->versement, "detailManquementProcessing", $param);
    }

    /* Va falloir qu'on fasse les tests sur les variables
     sont nulles*/


    /**
     * @authorize
     *
     */
    public function detailVersement(){
        $id = $this->paramGET[0] ;
        $param['condition'] = ["v.rowid = "=>$id];
        $versement = $this->versement->getVersementById($param);
        $data['versement'] = $versement;
        $this->views->setData($data);
        $this->views->getTemplate('versement/detail');
    }


    /**
     * @authorize
     *
     */
    public function detailCollect__(){


        $id = $this->paramGET[0] ;

        $valeur = ($id!= null) ? $id : null ;

        $dates = $this->versement->getDateCollect($valeur);


        $param = [
            "condition" => ["id = " => $valeur]
        ];
        $data['collecteur'] = $this->versement->getUser($param)[0];
        //var_dump($dates);

        foreach ($dates as $item => $date){
            $text=str_replace('-','',$date->date);
            $data['collect'.$text] = $this->versement->getCollectByIdCollecteur($valeur,$date->date);
        }
        $data['collects'] = $this->versement->getCollectById($valeur);
        $this->views->setData($data);
        $this->views->getTemplate('versement/collect-detail');

    }


    // Update Droit
    public function desactiverReceveur()
    {//var_dump($this->paramPOST); die;

        $id = $this->paramPOST['id'] ;
        $etat = ($this->paramPOST['etat'] == 1) ? 0 : 1 ;
        unset($this->paramPOST['id']);

        $result = $this->versement->set(["table"=>"utilisateur", "champs"=>['etat'=>$etat], "condition"=>["id =" => base64_decode($id)]]);

        if ($result !== false) Utils::setMessageALert(["success",$this->lang["action_success"]]);
        else Utils::setMessageALert(["danger", $this->lang["action_echec"]]);

        if (isset($this->paramPOST['manquant']))
            Utils::redirect("versement", "detailReceveur/".$id);
        else
            Utils::redirect("versement", "detailCollect/".$id);
    }
    public function versementProcessing__()
    {
        $param = [
            "button"=> [
                "modal" => [],
                "default" => [
                    [],
                    ["versement/detailCollect/","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [],
                "default" => ["Faire versement"]
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
                ["champ"=>"etat","val"=>[0=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>". $this->lang['echoue'] ."</span>"],1=>["<span  class='temp text-success' >". $this->lang['reussi'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                'nb_jour'=>'alignCenter',
                'nbTransaction'=>'alignCenter',
                'montant_v'=>'alignRightCenter'
            ]
        ];
        $this->processing($this->versement, "collectesProcess", $param);
    }
    public function historique__(){

        $data["collecteurs"] = $this->versement->getCollecteurs() ;
        // var_dump($data["collecteurs"]); exit;

        //$beginEnd = date('Y-m-d', strtotime('Jan 01'));

        //$yearEnd = date('Y-m-d', strtotime('12/31'));
        //echo $beginEnd." ".$yearEnd ; exit;
        Utils::setDefaultSort(1, "DESC");
        // var_dump($this->paramPOST);

        if (isset($this->paramPOST["datedebut"]) && isset($this->paramPOST["datefin"]) && isset($this->paramPOST["collecteurT"])) {
            $data['datedebut'] = $this->paramPOST['datedebut'];
            $data['datefin'] = $this->paramPOST['datefin'];
            $data['collecteurT'] = intval($this->paramPOST['collecteurT']);
        }else{
            //echo 65465645; exit;
            $beginEnd = date('Y-m-d', strtotime('Jan 01'));
            $yearEnd = date('Y-m-d', strtotime('12/31'));

            $data['datedebut'] = $beginEnd;
            $data['datefin'] = $yearEnd;
            $data['collecteurT'] = '';
        }
        //var_dump( $data);exit;
        $this->views->setData($data);
        $this->views->getTemplate('versement/historique');

    }
    public function historiqueProcessing__()
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
                'date_versement'=>'getDateFR',
                'nb_collecte'=>'alignCenter',
                'montant'=>'alignRightMontant'
            ]
        ];
        /* if($this->appConfig->profile_level == 2)
             array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->versement, "historiqueProcess", $param);
    }
    public function historiqueProcessingReceveur__()
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
                'date_versement'=>'getDateFR',
                'nb_collecte'=>'alignCenter',
                'montant'=>'alignCenter',
                'manquant'=>'alignRightMontantRed'
            ]
        ];
        /* if($this->appConfig->profile_level == 2)
             array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->versement, "historiqueReceveurProcess", $param);
    }
    public function detailsProcess__()
    {
        $param = [
            "button"=> [
                "modal" => [],
                "default" => [
                    [],
                    ["versement/detailVersement","fa fa-search"]
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
                'date_versement'=>'getDateFR',
                'nb_collecte'=>'alignCenter',
                'montant'=>'alignRightMontant'
            ]
        ];
        /* if($this->appConfig->profile_level == 2)
             array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->versement, "detailsReceveurProcess", $param);
    }

    /**
     * VERSEMENT AGENT DISTRIBUTEUR
     */
    //CARTE
    public function versementAgent__(){
        $this->views->getTemplate("distributeur/versementAgent");
    }
    public function listeAgent__(){
        if ($this->_USER) {
            $param = [

                "button" => [
                    "default" => [
                        [],
                        ["versement/detailVersementAgent/","fa fa-search"]
                    ],
                    "modal" => [
                        // ["distri/modifCommissionRechargeModal", "distributeur/modifCommissionRechargeModal", "fa fa-edit"],

                    ]
                    //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                ],
                "tooltip" => [
                    "modal" => [$this->lang['Modifier'], ["champ" => "_etat_", "val" => ["0" => $this->lang['Activer'], "1" => $this->lang['Désactiver']]]],
                    "default" => [["champ" => "etat", "val" => ["0" => $this->lang['Activer'], "1" => $this->lang['Désactiver']]], $this->lang['Supprimer'], $this->lang['Detail']]
                ],
                "classCss" => [
                    "modal" => [],
                    "default" => ["confirm", "confirm"]
                ],
                "attribut" => [],
                "args" => null,
                "dataVal" => [
                    ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>" . $this->lang['Desactive'] . " </i>"], "1" => ["<i class='text-success'>" . $this->lang['Active'] . "</i>"]]]
                ],
                "fonction" => [
                   "nbreTransaction"=>"nombreTransaction",
                    "montantTotal"=>"montantTransaction"
                ]
            ];
            $this->processing($this->agentModels, 'getAllAgent', $param);
        }

    }

    public function detailVersementAgent__(){
        $data['agent'] = $this->agentModels->getOneDistributeur(["condition" => ["a.id = " => $this->paramGET[0]]]);
        $fk_distributeur = (int) $data['agent']->id;
        ////CARTES
        $dates = $this->agentModels->getDateCollect($fk_distributeur);
        foreach ($dates as $item => $date){
            $text=str_replace('-','',$date->date_creation);
            $data['collect'.$text] = $this->agentModels->getCollectByIdAgent($fk_distributeur,$date->date_creation);
        }
        $data['collects'] = $this->agentModels->getCollectByAgent($fk_distributeur);
        //var_dump($data);die;
        ////RECHARGEMENT
        $datesRechargement = $this->agentModels->getDateCollectRechargement($fk_distributeur);
        foreach ($datesRechargement as $item => $date){
            $text=str_replace('-','',$date->date_transac);
            $data['collecte'.$text] = $this->agentModels->getCollectByIdAgentRechargement($fk_distributeur,$datesRechargement->date_transac);
        }
        $data['collectes'] = $this->agentModels->getCollectByAgentRechargement($fk_distributeur);
        $this->views->setData($data);
        $this->views->getTemplate("distributeur/detailVersement");
    }
    public function insertUnVirementCarte(){
        //var_dump($this->paramPOST);die;
        $nombre = count($this->paramPOST['id']) ;

        $id = intval($this->paramPOST['id_agent']) ;
        if ($nombre > 0){
            $data = array();
            $data['user_creation'] = $this->_USER->id ;
            $data['montant_verse'] = $this->paramPOST['montant_collect'];
            $data['fk_distributeur'] = $this->paramPOST['fk_distributeur'];
            //$idAgent = (int) $data['fk_agent'];
            try{
                $this->agentModels->__beginTransaction();
                $insertVersement = $this->agentModels->insertVirementCarte($data);
                if ($insertVersement > 0){
                    $updateEtat = $this->agentModels->updateTransaction($data['fk_distributeur']) ;
                }
                if($updateEtat > 0){
                    $this->agentModels->__commit();
                    Utils::setMessageALert(["success",$this->lang["action_success"]]);
                    $a[0] = $insertVersement;

                    Utils::redirect("versement", "detailVirementCarte",$a);
                    return ;
                }
            }catch(Exception $e){
                $this->versement->__rollBack() ;
                Utils::setMessageALert(["danger",$this->lang["action_echec"]].$e->getMessage());
            }

        }else{
            $this->versement->__rollBack() ;
        }
        Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        Utils::redirect("versement", "detailVirementCarte");
    }
    public function detailVirementCarte(){
        $id = $this->paramGET[0] ;
        $param['condition'] = ["v.id = "=>$id];
        $versement = $this->agentModels->getVirementCarteById($param);
        $data['versement'] = $versement;
        $this->views->setData($data);
        $this->views->getTemplate('versement/detailVirement');
    }
    public function exportRecuVirementCarte()
    {
        $id = $this->paramPOST['id'] ;
        $param['condition'] = ["v.id = "=>$id];
        $versement = $this->agentModels->getVirementCarteById($param);
        $data['versement'] = $versement;
        $details = $this->agentModels->detailsVersements([0=>$id]);
        $data['details'] = $details ;
        $this->views->setData($data);
        if ($details && $versement ) {
            $this->views->exportToPdf('versement/printRecuVirement');
        } else{
            Utils::setMessageALert(["danger",$this->lang["repech"]]);
            Utils::redirect("versement", "versementAgent");
        }


    }

    //RECHARGEMENT
    public function insertUnVirementRechargement(){
        $nombre = count($this->paramPOST['fk_distributeur']) ;
        $id = intval($this->paramPOST['fk_distributeur']) ;
        if ($nombre > 0){
            $data = array();
            $data['user_creation'] = $this->_USER->id ;
            $data['montant_verse'] = $this->paramPOST['montant_collect'];
            $data['fk_distributeur'] = $this->paramPOST['fk_distributeur'];
            //var_dump($data);die;
            try{
                $this->agentModels->__beginTransaction();
                $insertVersement = $this->agentModels->insertVirementRechargement($data);
                if ($insertVersement > 0){
                    $updateEtat = $this->agentModels->updateTransactionRechargement($data['fk_distributeur']) ;
                }
                if($updateEtat > 0){
                    $this->agentModels->__commit();
                    Utils::setMessageALert(["success",$this->lang["action_success"]]);
                    $a[0] = $insertVersement;
                    Utils::redirect("versement", "detailVirementRechargement",$a);
                    return ;
                }
            }catch(Exception $e){
                $this->versement->__rollBack() ;
                Utils::setMessageALert(["danger",$this->lang["action_echec"]].$e->getMessage());
            }

        }else{
            $this->versement->__rollBack() ;
        }
        Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        Utils::redirect("versement", "detailVirementRechargement");

    }
    public function detailVirementRechargement(){
        $id = $this->paramGET[0] ;
        $param['condition'] = ["v.id = "=>$id];
        $versement = $this->agentModels->getVirementRechargementId($param);
        $data['versement'] = $versement;
        $this->views->setData($data);
        $this->views->getTemplate('versement/detailVirementRechargement');
    }
    public function exportRecuVirementRechargement()
    {
        $id = $this->paramPOST['id'] ;
        $param['condition'] = ["v.id = "=>$id];
        $versement = $this->agentModels->getVirementRechargementId($param);
        $data['versement'] = $versement;
        $details = $this->agentModels->detailsVersementsRechargement([0=>$id]);
        $data['details'] = $details ;
        $this->views->setData($data);
        if ($details && $versement ) {
            $this->views->exportToPdf('versement/printRecuVirementRechargement');
        } else{
            Utils::setMessageALert(["danger",$this->lang["repech"]]);
            Utils::redirect("versement", "versementAgent");
        }


    }





}