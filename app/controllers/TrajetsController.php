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
use app\models\TrajetsModel ;

class TrajetsController extends BaseController
{
    private $trajetsModels;
   // private $voyagesModels;

    public function __construct()
    {
        parent::__construct(false);
        $this->trajetsModels = $this->model("trajets");
      //  $this->trajetsModels = $this->model("voyages");
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_admin"]);

        // $this->views->initTemplate(["header"=>"header","footer"=>"footer"]);
    }

    public function trajets__()
    {
        $this->views->getTemplate('trajets/trajets');
    }

    public function trajetsPro__()
    { //var_dump($this->_USER);die;
        if ($this->_USER) {
            // if ($this->_USER->admin == 1 || \app\core\Utils::getModel('gestion')->__authorized($this->_USER->idprofil, 'gestion', 'modifTypeModal') > 0) {
            $param = [

                "button" => [
                    "modal" => [
                        ["trajets/modifTrajetsModal", "trajets/modifTrajetsModal", "fa fa-edit"]
                    ],
                    "default" => [
                        ["champ" => "etat","val" => ["0" => ["trajets/activate/","fa fa-toggle-off"],"1" => ["trajets/deactivate/", "fa fa-toggle-on"]]],
                        ["trajets/removeTrajets/", "fa fa-trash"],
                        ["trajets/detailTrajets/", "fa fa-search"],
                        ["trajets/getTrajet/", "fa fa-map-marker"]
                    ]
                    //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                ],
                "tooltip" => [
                    "modal" => ["Modifier",["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Desactiver"]]],
                    "default" => [["champ"=>"etat","val"=>["0"=>"Activer","1"=>"Désactiver"]], "supprimer","Detail"]
                ],
                "classCss" => [
                    "modal" => [],
                    "default" => ["confirm","confirm"]
                ],
                "attribut" => [],
                "args" =>  $this->_USER,
                "dataVal" => [
                    ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
                ],
                "fonction" => []
            ];
            $this->processing($this->trajetsModels, 'getAllTrajets', $param);


        } else {
            $param = [
                "button" => [
                    "modal" => [],
                    "default" => []
                    //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                ],
                "tooltip" => [],
                "classCss" => [
                    "modal" => [],
                    "default" => ["confirm"]
                ],
                "attribut" => [],
                "args" => null,
                "dataVal" => [],
                "fonction" => []
            ];
            $this->processing($this->trajetsModels, 'getAllTrajets', $param);


        }

    }

    public function ajoutTrajetsModal()
    {
        $data['ligne'] = $this->trajetsModels->getligne();
        $this->views->setData($data);
        $this->modal();
    }

    // Ajout Droit
    public function insertTrajets__()
    {
        $this->paramPOST['gie'] = $this->_USER->gie;
        $this->paramPOST['user_creation'] = $this->_USER->id;
        //var_dump($this->paramPOST);die;
        $result = $this->trajetsModels->insertTrajets(["champs" => $this->paramPOST]);

        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_trajet"]]);
        else Utils::setMessageALert(["danger",  $this->lang["echec_add_trajet"]]);
        Utils::redirect("trajets", "trajets");

    }
    public function activate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->trajetsModels->updateTrajets(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_trajet"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_type"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_type"]]);
        Utils::redirect("trajets", "trajets");
    }

    // Desactivation droit
    public function deactivate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->trajetsModels->updateTrajets(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_trajet"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_trajet"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_trajet"]]);
        Utils::redirect("trajets", "trajets");
    }

    public function removeTrajets()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->trajetsModels->deleteTrajets(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_trajet"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_trajet"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_trajet"]]);
        Utils::redirect("trajets", "trajets");
    }


    public function modifTrajetsModal()

    {//var_dump( $this->paramGET[2][0]);die();
        $data['trajet'] = $this->trajetsModels->getTrajets(["condition" => ["id = " => $this->paramGET[2]]])[0];
        $data['ligne'] = $this->trajetsModels->getligne();

        $this->views->setData($data);
        $this->modal();

    }

    // Update Droit
    public function updateTrajets()
    {
        //parent::validateToken("administration", "listeDroit");
        //var_dump($this->paramPOST['id']);die();
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];

        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;

        $result = $this->trajetsModels->updateTrajets($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_trajet"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_trajet"]]);
        Utils::redirect("trajets", "trajets");
    }
    public function updateTrajetsDetail()
    {
        //parent::validateToken("administration", "listeDroit");
        //var_dump($this->paramPOST['id']);die();
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->trajetsModels->updateTrajets($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_trajet"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_trajet"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("trajets", "detailTrajets");
        }else{Utils::redirect("trajets",  "detailTrajets"."/".$id);}
    }

    public function detailTrajets(){
        $data['trajet'] = $this->trajetsModels->getOneTrajets(["condition" => ["t.id = " => $this->paramGET[0]]]);
        $data['ligne'] = $this->trajetsModels->getOneLigne(["condition" => ["id = " => $this->paramGET[0]]]);
        $data['lignes'] = $this->trajetsModels->getligne();

        //var_dump( $data['ligne']);die;
        $this->views->setData($data);
        $this->views->getTemplate('trajets/detailTrajets');

    }
    public function updateEtatTrajets()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id= $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->trajetsModels->updateTrajets($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_trajet"]]);
        else Utils::setMessageALert(["danger",$this->lang["echec_desactivate_trajet"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("trajets", "detailTrajets");
        }else{Utils::redirect("trajets",  "detailTrajets"."/".$id);}
    }

    public function getTrajet__()
    {
        $data['trajet'] = $this->trajetsModels->getOneTrajets(["condition" => ["t.id = " => $this->paramGET[0]]]);
        //var_dump($data['trajet']);die;
        $this->views->setData($data);
        $this->views->getTemplate('trajets/itineraire');
    }

    public function itineraire__(){

        if ($this->_USER) {
            // if ($this->_USER->admin == 1 || \app\core\Utils::getModel('gestion')->__authorized($this->_USER->idprofil, 'gestion', 'modifTypeModal') > 0) {
            $param = [

                "button" => [
                    "modal" => [
                        ["trajets/modifPointModal", "trajets/modifPointModal", "fa fa-edit"]

                    ],
                    "default" => [
                        //["champ" => "etat","val" => ["0" => ["trajets/activate/","fa fa-toggle-off"],"1" => ["trajets/deactivate/", "fa fa-toggle-on"]]],
                        ["trajets/removePoint/", "fa fa-trash"],
                        ["trajets/pointsMap/", "fa fa-search"]
                    ]
                    //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                ],
                "tooltip" => [
                    "modal" => ["modifier"],
                    "default" => ["supprimer","Detail"]
                ],
                "classCss" => [
                    "modal" => [],
                    "default" => ["confirm"]
                ],
                "attribut" => [],
                "args" =>  $this->paramGET,
                "dataVal" => [
                    ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
                ],
                "fonction" => []
            ];
            $this->processing($this->trajetsModels, 'getPoints', $param);


        }

    }

    public function modifPointModal(){
        $data['points'] = $this->trajetsModels->getOnePoint(["condition" => ["rowid = " => $this->paramGET[2]]]);
        $this->views->setData($data);
        return $this->modal();
    }

    public function updatePoint(){

        $rowid = base64_decode($this->paramPOST['rowid']);
        unset($this->paramPOST['rowid']);
        $data['condition'] = ["rowid = " => $rowid];
        $idTrajet= base64_decode($this->paramPOST['id_trajet']);
        $this->paramPOST['id_trajet'] = base64_decode($this->paramPOST['id_trajet']);
        $this->paramPOST['gie'] = $this->_USER->gie;
        $this->paramPOST['user_creation'] = $this->_USER->id;
       // $this->paramPOST['date_creation'] = Utils::getDateNow();
        $data['champs'] = $this->paramPOST;
        $result = $this->trajetsModels->updateOnePoint($data);


        if ($result !== false) Utils::setMessageALert(["success", $this->lang["pointS"]]);
        else Utils::setMessageALert(["danger",$this->lang["pointE"]]);
        if($this->paramGET[0]=="r"){Utils::redirect("trajets", "getTrajet");
        }else{Utils::redirect("trajets",  "getTrajet"."/".$idTrajet);
        }
    }

    public function removePoint(){
        $data['points'] = $this->trajetsModels->getOnePoint(["condition" => ["rowid = " => $this->paramGET[0]]]);
        $idTrajet = $data['points']->ligne;
        $result = $this->trajetsModels->deletePoint(["condition" => ["rowid = " => $this->paramGET[0]]]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["poitDeleteS"]]);
        else Utils::setMessageALert(["danger", $this->lang["poitDeleteE"]]);
        Utils::redirect("trajets", "getTrajet"."/".$idTrajet);
    }

    public function nouveauPointModal(){
       $data['idTrajet'] = $this->paramGET[2];
        $this->views->setData($data);
        return$this->modal();
    }

    public function insertPoint(){
        $idTrajet = base64_decode($this->paramPOST['id_trajet']);
        $this->paramPOST['id_trajet'] = base64_decode($this->paramPOST['id_trajet']);
        $this->paramPOST['gie'] = $this->_USER->gie;
        $this->paramPOST['user_creation'] = $this->_USER->id;
        //var_dump($this->paramPOST);die;
        $result = $this->trajetsModels->insertPoint(["champs" => $this->paramPOST]);

        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_trajet"]]);
        else Utils::setMessageALert(["danger",  $this->lang["echec_add_trajet"]]);
        Utils::redirect("trajets", "getTrajet"."/".$idTrajet);
    }

    public function pointsMap(){
        $this->views->getPage('trajets/pointsMap');
    }

    public function menu__()
    {
        $this->views->getPage('home/menu');
    }


    /*******************************************************************************Debut Voyage************************************************************************************/
    public function voyages__()
    {
        $this->views->getTemplate('trajets/voyages');
    }

    public function voyagesPro__()
    {/// var_dump(1111);die;
        if ($this->_USER) {
          //  if ($this->_USER->admin == 1 || \app\core\Utils::getModel('gestion')->__authorized($this->_USER->idprofil, 'gestion', 'modifTypeModal') > 0) {
            $param = [

                "button" => [
                    "modal" => [
                        ["trajets/modifVoyagesModal", "trajets/modifVoyagesModal", "fa fa-edit"]
                    ],
                    "default" => [
                        ["champ" => "etat","val" => ["0" => ["trajets/activateVoyages/","fa fa-toggle-off"],"1" => ["trajets/deactivateVoyages/", "fa fa-toggle-on"]]],
                        ["trajets/removeVoyages/", "fa fa-trash"],
                        ["trajets/detailVoyages/", "fa fa-search"],
                    ]
                    //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                ],
                "tooltip" => [
                    "modal" => ["Modifier",["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Desactiver"]]],
                    "default" => [["champ"=>"etat","val"=>["0"=>"Activer","1"=>"Désactiver"]], "supprimer","Detail"]
                ],
                "classCss" => [
                    "modal" => [],
                    "default" => ["confirm","confirm"]
                ],
                "attribut" => [],
                "args" =>  $this->_USER,
                "dataVal" => [
                    ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
                ],
                "fonction" => []
            ];
            $this->processing($this->trajetsModels, 'getAllVoyages', $param);


        } else {
            $param = [
                "button" => [
                    "modal" => [],
                    "default" => []
                    //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                ],
                "tooltip" => [],
                "classCss" => [
                    "modal" => [],
                    "default" => ["confirm"]
                ],
                "attribut" => [],
                "args" => null,
                "dataVal" => [],
                "fonction" => []
            ];
            $this->processing($this->trajetsModels, 'getAllVoyages', $param);


        }

    //}
    }

    public function ajoutVoyagesModal()
    {


        //var_dump(setData($data));die;
        $data['code_voyage'] = 'NTA'.mt_rand(100, 999).date('d').date('W').date('Y');
        $data['affectation'] = $this->trajetsModels->getAffectation();
        //var_dump($data['affectation']);die;
        $data['employe'] = $this->trajetsModels->getChauffeur();
        $data['controleur'] = $this->trajetsModels->getControleur();
        $data['trajet'] = $this->trajetsModels->getTrajets();
        //  echo "<pre>";var_dump($data);die;

        $this->views->setData($data);
        $this->modal();
    }

    // Ajout Droit
    public function insertVoyages__()
    {
        //var_dump($this->paramPOST); exit;
        $this->paramPOST['gie'] = $this->_USER->gie;
        $affectation = explode('-',$this->paramPOST['affectation']) ;
        unset($this->paramPOST['affectation']) ;
        $affectationId = $affectation[0] ;
        $bus = $affectation[1];
        $device = $affectation[2];
        $receveur = $affectation[3] ;

        $this->paramPOST['bus_id'] = $bus ;
        $this->paramPOST['user_creation'] = $this->_USER->id ;
        $this->paramPOST['affectation_id'] = $affectationId ;
        $this->paramPOST['receveur_id'] = $receveur ;

        $this->paramPOST['date_voyage'] = Utils::date_aaaa_mm_jj($this->paramPOST['date_voyage']) ;

///var_dump($this->paramPOST);die;
        $result = $this->trajetsModels->insertVoyages(["champs" => $this->paramPOST]);

        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_voyage"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_voyage"]]);
        Utils::redirect("trajets", "voyages");

    }
    public function activateVoyages()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->trajetsModels->updateVoyages(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_voyages"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_voyages"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_voyages"]]);
        Utils::redirect("trajets", "voyages");
    }

    // Desactivation droit
    public function deactivateVoyages()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->trajetsModels->updateVoyages(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_voyages"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_voyages"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_voyages"]]);
        Utils::redirect("trajets", "voyages");
    }

    public function removeVoyages()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->trajetsModels->deleteVoyages(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_voyages"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_voyages"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_voyages"]]);
        Utils::redirect("trajets", "voyages");
    }


    public function modifVoyagesModal()

    {//var_dump($this->paramGET[2]);die();
        $data['voyage'] = $this->trajetsModels->getVoyages(["condition" => ["id = " => $this->paramGET[2]]])[0];
        //var_dump($data['voyage']);die;

        $data['bus'] = $this->trajetsModels->getBus();
        $data['employe'] = $this->trajetsModels->getChauffeur();
        $data['utilisateur'] = $this->trajetsModels->getReceveur();
        $data['controleur'] = $this->trajetsModels->getControleur();
        $data['trajet'] = $this->trajetsModels->getTrajetsVoy();
        //var_dump($data['trajet']);die;
        // $data['module'] = $this->moduleModels->getModule();

        $this->views->setData($data);
        $this->modal();

    }

    // Update Droit
    public function updateVoyages()
    {
        //parent::validateToken("administration", "listeDroit");
        //var_dump($this->paramPOST['id']);die();
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $this->paramPOST['date_voyage'] = Utils::date_aaaa_mm_jj($this->paramPOST['date_voyage']) ;
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;

        $result = $this->trajetsModels->updateVoyages($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_voyages"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_voyages"]]);
        Utils::redirect("trajets", "voyages");
    }
    public function updateVoyagesDetail()
    {
        //parent::validateToken("administration", "listeDroit");
        //var_dump($this->paramPOST['id']);die();
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $this->paramPOST['date_voyage'] = Utils::date_aaaa_mm_jj($this->paramPOST['date_voyage']) ;
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->trajetsModels->updateVoyages($data);
        if ($result !== false) Utils::setMessageALert(["success",  $this->lang["succes_update_voyages"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_voyages"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("trajets", "detailVoyages");
        }else{Utils::redirect("trajets",  "detailVoyages"."/".$id);}
    }

    public function detailVoyages(){

        $etat = 1;

        $data['voyage'] = $this->trajetsModels->getOneVoyages(["condition" => ["v.id = " => $this->paramGET[0]]]);
        $data['bus'] = $this->trajetsModels->getBus();
        $data['employe'] = $this->trajetsModels->getChauffeur();
        $data['utilisateur'] = $this->trajetsModels->getReceveur();
        $data['controleur'] = $this->trajetsModels->getControleur();
        $data['trajet'] = $this->trajetsModels->getTrajetsVoy();
        //var_dump($data['employe']);die();

        $this->views->setData($data);
        $this->views->getTemplate('trajets/detailVoyages');

    }
    public function updateEtatVoyages()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id= $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->trajetsModels->updateVoyages($data);
        if ($result !== false) Utils::setMessageALert(["success",  $this->lang["succes_activate_voyages"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_voyages"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("trajets", "detailVoyages");
        }else{Utils::redirect("trajets",  "detailVoyages"."/".$id);}
    }

/*******************************************************Debut ligne****************************************************************************************************/
    public function lignes__()
    {
        $this->views->getTemplate('trajets/lignes');
    }

    public function lignesPro__()
    {/// var_dump(1111);die;
        if ($this->_USER) {
            //  if ($this->_USER->admin == 1 || \app\core\Utils::getModel('gestion')->__authorized($this->_USER->idprofil, 'gestion', 'modifTypeModal') > 0) {
            $param = [

                "button" => [
                    "modal" => [
                       ["trajets/modifLignesModal", "trajets/modifLignesModal", "fa fa-edit"]
                    ],
                    "default" => [
                        ["champ" => "etat","val" => ["0" => ["trajets/activateLignes/","fa fa-toggle-off"],"1" => ["trajets/deactivateLignes/", "fa fa-toggle-on"]]],
                        ["trajets/removeLignes/", "fa fa-trash"],
                       // ["trajets/detailVoyages/", "fa fa-search"],
                    ]
                    //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                ],
                "tooltip" => [
                    "modal" => ["Modifier",["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Desactiver"]]],
                    "default" => [["champ"=>"etat","val"=>["0"=>"Activer","1"=>"Désactiver"]], "supprimer","Detail"]
                ],
                "classCss" => [
                    "modal" => [],
                    "default" => ["confirm","confirm"]
                ],
                "attribut" => [],
                "args" =>  $this->paramGET,
                "dataVal" => [
                    ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
                ],
                "fonction" => []
            ];
            $this->processing($this->trajetsModels, 'getAllLignes', $param);


        } else {
            $param = [
                "button" => [
                    "modal" => [],
                    "default" => []
                    //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                ],
                "tooltip" => [],
                "classCss" => [
                    "modal" => [],
                    "default" => ["confirm"]
                ],
                "attribut" => [],
                "args" => null,
                "dataVal" => [],
                "fonction" => []
            ];
            $this->processing($this->trajetsModels, 'getAllLignes', $param);


        }

        //}
    }

    public function ajoutLignesModal()
    {
        $result = $this->trajetsModels->insertLignes(["champs" => $this->paramPOST]);

        $this->modal();
    }

    public function modifLignesModal()
    {
        $data['ligne'] = $this->trajetsModels->getOneLigne(["condition" => ["id = " => $this->paramGET[2]]]);
        $this->views->setData($data);
        $this->modal();
    }

    // Ajout Droit
    public function insertLignes__()
    {
       // $this->paramPOST['numGie'] = $this->_USER->gie;
       // $this->paramPOST['date_voyage'] = Utils::date_aaaa_mm_jj($this->paramPOST['date_voyage']) ;

      ///var_dump($this->paramPOST);die;
        $result = $this->trajetsModels->insertLignes(["champs" => $this->paramPOST]);

        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_ligne"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_ligne"]]);
        Utils::redirect("trajets", "lignes");

    }
    public function activateLignes()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->trajetsModels->updateLignes(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_ligne"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_ligne"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_ligne"]]);
        Utils::redirect("trajets", "lignes");
    }

    // Desactivation droit
    public function deactivateLignes()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->trajetsModels->updateLignes(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_ligne"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_ligne"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_ligne"]]);
        Utils::redirect("trajets", "lignes");
    }
    public function updateLignes()
    {
        //parent::validateToken("administration", "listeDroit");
        //var_dump($this->paramPOST['id']);die();
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];

        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;

        $result = $this->trajetsModels->updatelignes($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_ligne"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_ligne"]]);
        Utils::redirect("trajets", "lignes");
    }
    public function removeLignes()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->trajetsModels->deleteLignes(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_ligne"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_ligne"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_ligne"]]);
        Utils::redirect("trajets", "lignes");
    }

    /*******************************************************Debut ligne****************************************************************************************************/

    public function tickets__()
    {
        $this->views->getTemplate('trajets/tickets');
    }

    public function ticketsPro__()
    {/// var_dump(1111);die;
        if ($this->_USER) {
            //  if ($this->_USER->admin == 1 || \app\core\Utils::getModel('gestion')->__authorized($this->_USER->idprofil, 'gestion', 'modifTypeModal') > 0) {
            $param = [

                "button" => [
                    "modal" => [
                        ["trajets/modifTicketsModal", "trajets/modifTicketsModal", "fa fa-edit"]
                    ],
                    "default" => [
                        ["champ" => "etat","val" => ["0" => ["trajets/activateTickets/","fa fa-toggle-off"],"1" => ["trajets/deactivateTickets/", "fa fa-toggle-on"]]],
                       // ["trajets/removeTickets/", "fa fa-trash"],
                       // ["trajets/detailTickets/", "fa fa-search"],
                    ]
                    //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                ],
                "tooltip" => [
                    "modal" => ["Modifier",["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Desactiver"]]],
                    "default" => [["champ"=>"etat","val"=>["0"=>"Activer","1"=>"Désactiver"]], "supprimer","Detail"]
                ],
                "classCss" => [
                    "modal" => [],
                    "default" => ["confirm","confirm"]
                ],
                "attribut" => [],
                "args" =>  $this->_USER,
                "dataVal" => [
                    ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
                ],
                "fonction" => []
            ];
            $this->processing($this->trajetsModels, 'getAllTickets', $param);


        } else {
            $param = [
                "button" => [
                    "modal" => [],
                    "default" => []
                    //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                ],
                "tooltip" => [],
                "classCss" => [
                    "modal" => [],
                    "default" => ["confirm"]
                ],
                "attribut" => [],
                "args" => null,
                "dataVal" => [],
                "fonction" => []
            ];
            $this->processing($this->trajetsModels, 'getAllTickets', $param);


        }

        //}
    }

    public function ajoutTicketsModal()
    {
        //var_dump(setData($data));die;

        $this->modal();
    }

    // Ajout Droit
    public function insertTickets__()
    {
        $this->paramPOST['numGIE'] = $this->_USER->gie;
        $this->paramPOST['date_ticket'] = Utils::date_aaaa_mm_jj($this->paramPOST['date_ticket']) ;

      //var_dump($this->paramPOST);die;
        $result = $this->trajetsModels->insertTickets(["champs" => $this->paramPOST]);

        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_ticket"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_ticket"]]);
        Utils::redirect("trajets", "tickets");

    }


    public function activateTickets()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->trajetsModels->updateTickets(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_ticket"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_ticket"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_ticket"]]);
        Utils::redirect("trajets", "tickets");
    }

    // Desactivation droit
    public function deactivateTickets()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->trajetsModels->updateTickets(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_ticket"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_ticket"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_ticket"]]);
        Utils::redirect("trajets", "tickets");
    }
    public function modifTicketsModal()
    {
        $data['ticket'] = $this->trajetsModels->getOneTicket(["condition" => ["id = " => $this->paramGET[2]]]);
        //var_dump($data['trajet']);die;
        $this->views->setData($data);
        $this->modal();

    }
    public function updateTickets()
    {
        //parent::validateToken("administration", "listeDroit");
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $this->paramPOST['date_ticket']=Utils::date_aaaa_mm_jj($this->paramPOST['date_ticket']) ;
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        //var_dump($data);die();
        $result = $this->trajetsModels->updateTickets($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_ticket"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_ticket"]]);
        Utils::redirect("trajets", "tickets");
    }


}
