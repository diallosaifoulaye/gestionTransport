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

class VoyagesController extends BaseController
{
    private $voyagesModels;

    public function __construct()
    {
        parent::__construct(false);
        $this->voyagesModels = new VoyagesModel();
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_admin"]);

        // $this->views->initTemplate(["header"=>"header","footer"=>"footer"]);
    }

    public function voyages__()
    {
        $this->views->getTemplate('voyages/voyages');
    }

    public function voyagesPro__()
    { //var_dump($this->_USER);die;
        if ($this->_USER) {
            // if ($this->_USER->admin == 1 || \app\core\Utils::getModel('gestion')->__authorized($this->_USER->idprofil, 'gestion', 'modifTypeModal') > 0) {
            $param = [

                "button" => [
                    "modal" => [
                        ["voyages/modifVoyagesModal", "voyages/modifVoyagesModal", "fa fa-edit"]
                    ],
                    "default" => [
                        ["champ" => "etat","val" => ["0" => ["voyages/activate/","fa fa-toggle-off"],"1" => ["voyages/deactivate/", "fa fa-toggle-on"]]],
                        ["voyages/removeVoyages/", "fa fa-trash"],
                        ["voyages/detailVoyages/", "fa fa-search"],
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
                    ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>Désactivé</i>"], "1" => ["<i class='text-success'>Activé</i>"]]]
                ],
                "fonction" => []
            ];
            $this->processing($this->voyagesModels, 'getAllTrajets', $param);


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
            $this->processing($this->voyagesModels, 'getAllVoyages', $param);


        }

    }

    public function ajoutVoyagesModal()
    {
        //$data['employe'] = $this->employeModels->getChauffeur();
        //$this->views->setData($data);
        $this->modal();
    }

    // Ajout Droit
    public function insertVoyages__()
    {
        $this->paramPOST['numGie'] = $this->_USER->gie;

        $result = $this->voyagesModels->insertVoyages(["champs" => $this->paramPOST]);

        if ($result !== false) Utils::setMessageALert(["success", "Voyages ajouté avec succes"]);
        else Utils::setMessageALert(["danger", "Echec de l'ajout du trajet"]);
        Utils::redirect("voyages", "voyages");

    }
    public function activate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->voyagesModels->updateVoyages(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_voyages"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_voyages"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_voyages"]]);
        Utils::redirect("voyages", "voyages");
    }

    // Desactivation droit
    public function deactivate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->voyagesModels->updateVoyages(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_voyages"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_voyages"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_voyages"]]);
        Utils::redirect("voyages", "voyages");
    }

    public function removeVoyages()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->voyagesModels->deleteVoyages(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_voyages"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_voyages"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_voyages"]]);
        Utils::redirect("voyages", "voyages");
    }


    public function modifVoyagesModal()

    {//var_dump($this->paramGET[2]);die();
        $data['trajet'] = $this->voyagesModels->getVoyages(["condition" => ["id = " => $this->paramGET[2]]])[0];
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

        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;

        $result = $this->voyagesModels->updateVoyages($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_voyages"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_voyages"]]);
        Utils::redirect("voyages", "voyages");
    }
    public function updateVoyagesDetail()
    {
        //parent::validateToken("administration", "listeDroit");
        //var_dump($this->paramPOST['id']);die();
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->voyagesModels->updateVoyages($data);
        if ($result !== false) Utils::setMessageALert(["success", "Voyages modifié avec succes"]);
        else Utils::setMessageALert(["danger", "Echec de la modification du voyage"]);

        if($this->paramGET[0]=="r"){Utils::redirect("voyages", "detailVoyages");
        }else{Utils::redirect("voyages",  "detailVoyages"."/".$id);}
    }

    public function detailVoyages(){

        $etat = 1;

        $data['trajet'] = $this->voyagesModels->getOneVoyages(["condition" => ["t.id = " => $this->paramGET[0]]]);
        //var_dump($data['employe']);die();

        $this->views->setData($data);
        $this->views->getTemplate('voyages/detailVoyages');

    }
    public function updateEtatVoyages()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id= $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->voyagesModels->updateVoyages($data);
        if ($result !== false) Utils::setMessageALert(["success", "Voyages activé avec succes"]);
        else Utils::setMessageALert(["danger", "Echec de la desactivation du voyage"]);

        if($this->paramGET[0]=="r"){Utils::redirect("voyages", "detailVoyages");
        }else{Utils::redirect("voyages",  "detailVoyages"."/".$id);}
    }


    public function menu__()
    {
        $this->views->getPage('home/menu');
    }

}