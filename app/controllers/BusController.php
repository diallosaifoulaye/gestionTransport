<?php


namespace app\controllers;

use app\core\BaseController;
use app\core\Session;
use app\core\Utils;
use app\models\admin\GieModel;
use app\models\admin\ProfilModel;
use app\models\admin\UtilisateurModel;
use app\models\BusModel ;
use app\models\BusCategorieModel;

class BusController extends BaseController
{
    private $busModels;
    private $busCategorieModels;
    private $utilisateurModels;
    private $profilModels;
    private $locationModels;
    public function __construct()
    {

        parent::__construct();

        $this->utilisateurModels = new UtilisateurModel();
        $this->profilModels = new ProfilModel();
        $this->busCategorieModels = new BusCategorieModel();
        $this->busModels = new BusModel();
        $this->utilisateurModels = new UtilisateurModel();
        $this->gieModels = new GieModel();
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_admin"]);
        //var_dump($this->_USER);die;

    }

    public function index__()
    {
        $this->views->getTemplate('administration/admin');

    }

    /*********************** DEBUT Gestion des Profil *********************/


public function listeBusPro__()
{
    if ($this->_USER) {
        //if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
            $param = [
        "button" => [
            "default" => [
                ["champ" => "etat","val" => ["0" => ["bus/activate/","fa fa-toggle-off"],"1" => ["bus/deactivate/", "fa fa-toggle-on"]]],
                ["bus/removeBus/", "fa fa-trash"],
                ["bus/detailBus/", "fa fa-search"]
            ],
            "modal" => [
                ["bus/modifBusModal", "bus/modifBusModal", "fa fa-edit"],

            ]
            //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
        ],
                "tooltip" => [
                    "modal" => [$this->lang['Modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],
                    "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['Supprimer'],$this->lang['Detail']]
                ],
        "classCss" => [
            "modal" => [],
            "default" => ["confirm","confirm"]
        ],
        "attribut" => [],
        "args" => $this->_USER,
        "dataVal" => [
            ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
        ],
        "fonction" => []
    ];
    $this->processing($this->busModels, 'getAllBus', $param);
//        } else {
//            $param = [
//                "button" => [
//                    "modal" => [
//                        ["bus/modifBusModal", "bus/modifBusModal", "fa fa-edit"],
//
//                    ],
//                    "default" => [
//                        ["bus/detailBus/", "fa fa-search"]
//                    ]
//                    //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
//                ],
//                "tooltip" => [],
//                "classCss" => [
//                    "modal" => [],
//                    "default" => ["confirm"]
//                ],
//                "attribut" => [],
//                "args" => null,
//                "dataVal" => [],
//                "fonction" => []
//            ];
//            $this->processing($this->busModels, 'getAllBus', $param);
//
//        }

}
}

// Liste bus
public function liste__()
{
    $this->views->getTemplate("bus/liste");

}



// Activation profil & Desactivation profil//
public function activate()
{

    if (intval($this->paramGET[0]) > 0) {
        $result = $this->busModels->updateBus(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_active_bus"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_active_bus"]]);
    } else Utils::setMessageALert(["danger", $this->lang["echec_active_bus"]]);
    Utils::redirect("bus", "liste");
}

public function deactivate()
{
    if (intval($this->paramGET[0]) > 0) {
        $result = $this->busModels->updateBus(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactive_bus"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_desactive_bus"]]);
    } else Utils::setMessageALert(["danger", $this->lang["echec_desactive_bus"]]);
    Utils::redirect("bus", "liste");
}

    public function ajoutBusModal()
    {
        $data['categorie'] = $this->busCategorieModels->getCategorie($param);
        $data['gie'] = $this->gieModels->AllGie($param);

        $this->views->setData($data);
        //var_dump($this->paramPOST);
       // $data['bus'] = $this->busModels->getBus($param);
        //$this->views->setData($data);
        $this->modal();

    }

    // Ajout Profil
    public function ajoutBus__()
    {
        //parent::validateToken("administration", "listeProfil");
        $dossier_photo = ROOT."assets/pictures/";
        $file_photo = basename($_FILES['photo']['name']);
        if ($file_photo != null) {

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $dossier_photo.$file_photo)) //Si la fonction renvoie TRUE, c'est que &ccedil;a a fonctionn&eacute;...
            {
                $info = new \SplFileInfo($file_photo);
                $new_name = date("YmdHis") . '.' . $info->getExtension();
                rename($dossier_photo . $file_photo, $dossier_photo . $new_name);
                $file_photo = $new_name;
            }
        }
        $this->paramPOST['photo'] = $file_photo;
        $this->paramPOST['numGIE'] = $this->_USER->gie;
      //var_dump($this->paramPOST);die;
        $result = $this->busModels->insertBus(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_bus"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_bus"]]);
        Utils::redirect("bus", "liste");


    }

    public function modifBusModal()

    {
        $data['bus'] = $this->busModels->getBus(["condition" => ["id = " => $this->paramGET[2]]])[0];
       // $data['categorie'] = $this->busCategorieModels->AllCategorie();
        $data['categorie'] = $this->busCategorieModels->AllCategorie();

        //$data['allCategorie'] = $this->busCategorieModels->AllCategorie(["condition" => ["etat = " => $etat]]);

        //$data['bus'] = $this->busModels->getBus();
        //var_dump($data);die();
        $this->views->setData($data);

        $this->modal();

    }

    public function updateBus()
    {
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->busModels->updateBus($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_bus"]]);
        else Utils::setMessageALert(["danger",$this->lang["echec_update_bus"]]);
        Utils::redirect("bus", "liste");

    }
    public function updateBusDetail()
    {


        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->busModels->updateBusDetail($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_bus"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_bus"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("bus", "detailBus"."/".$id);
        }else{Utils::redirect("bus",  "detailBus"."/".$id);}
    }
    public function profilBus()
    {
        $etat =1;
        //$data['allProfil'] = $this->profilModels->AllProfil(["condition" => ["etat = " => $etat]]);
        $data['bus'] = $this->busModels->getOneBus(["condition" => ["b.id = " => $this->_BUS->id]]);
        $this->views->setData($data);
        $this->views->getTemplate('bus/profilBus');
    }

    // Supression Bus
    public function removeBus()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->busModels->deleteBus(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang['succes_delete_bus']]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_bus"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_bus"]]);
        Utils::redirect("bus", "liste");
    }

    public function actionProfilModal()
    {

        $etat = 1;

        $data['module']= $this->busModels->allModule(["condition" => ["id = " => $etat]]);

        //$data['groupe']= $this->profilModels->allGroupe(["condition" => ["id = " => $etat]]);

        //$fk_groupe = $this->profilModels->getFKGroupe(["condition" => ["p.id = " => $this->paramGET[2]]]);

        //$data['actions_autorisees'] = $this->busModels->allActionsAutoriseByProfil(["condition" => ["fk_profil = " => $this->paramGET[2], "etat =" => $etat]]);
        //var_dump($data['actions_autorisees']);die;
        $data['bus']= $this->busModels->getBusByIdInteger(["condition" => ["b.id = " => $this->paramGET[2]]]);
        //var_dump($data['profil']);
        $this->views->setData($data);

        $this->modal();
    }
    //Detail
    public function detailBus(){

        $etat = 1;
        //var_dump($this->paramGET);die();
        $data['bus'] = $this->busModels->getOneBus(["condition" => ["b.id = " => $this->paramGET[0]]]);
        $data['allCategorie'] = $this->busCategorieModels->AllCategorie(["condition" => ["etat = " => $etat]]);
        //echo '<pre>'; var_dump($data['bus']);die();
        $this->views->setData($data);
        $this->views->getTemplate('bus/detailBus');

        //$this->modal();
    }

    // Update utilisateur
    public function updatePhoto()
    {
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];

        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $dossier_photo = ROOT."assets/pictures/";
        //AJOUT PHOTO ET SIGNATURE
        $file_photo = basename($_FILES['photo']['name']);

        //exit;
        if ($file_photo != null) {

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $dossier_photo.$file_photo)) //Si la fonction renvoie TRUE, c'est que &ccedil;a a fonctionn&eacute;...
            {

                $info = new \SplFileInfo($file_photo);
                $new_name = date("YmdHis") . '.' . $info->getExtension();
                rename($dossier_photo . $file_photo, $dossier_photo . $new_name);
                $file_photo = $new_name;
            }
        }


        $this->paramPOST['photo'] = $file_photo;



        $data['champs'] = $this->paramPOST;
        //var_dump($this->paramPOST);exit();



        $rst= $this->busModels->updatePhoto($data);


        if($rst >0)
        {
            Utils::setMessageALert(["type"=>"success","alert"=>$this->lang["action_success"]]);
            //$this->utilisateurModels->log_journal('Modification Photo', 'Photo : '.$_POST['photo'], 'modification avec succès', 1, $this->_USER->id);
        }
        else
        {
            Utils::setMessageALert(["type"=>"danger","alert"=>$this->lang["action_error"]]);
            //$this->utilisateurModels->log_journal('Modification Photo', 'Photo : '.$_POST['photo'], 'modification echouée', 1, $this->_USER->id);
        }
        Utils::redirect('bus', "detailBus"."/".$id);
    }

    // Activation Desactivation User
    public function updateEtatBus()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->busModels->updateBus($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_bus"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_bus"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("bus", "detailBus"."/".$id);
        }else{Utils::redirect("bus",  "detailBus"."/".$id);}
    }

/********************** FIN Gestion des Bus *********************/

/********************** DEBUT Gestion des Categories *********************/

// Processing profil
public function listeCategoriePro__()
{
    if ($this->_USER) {
    if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
        $param = [

            "button" => [
                "default" => [
                    ["champ" => "etat","val" => ["0" => ["bus/activateCat/","fa fa-toggle-off"],"1" => ["bus/deactivateCat/", "fa fa-toggle-on"]]],
                    ["bus/removeCategorie/", "fa fa-trash"],
                    //["bus/detailBus/", "fa fa-search"]
                ],
                "modal" => [
                    ["bus/modifCategorieModal", "bus/modifCategorieModal", "fa fa-edit"],

                ]
                //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
            ],
            "tooltip" => [
                "modal" => [$this->lang['Modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],
                "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['Supprimer'],$this->lang['Detail']]
            ],
            "classCss" => [
                "modal" => [],
                "default" => ["confirm","confirm"]
            ],
            "attribut" => [],
            "args" => null,
            "dataVal" => [
                ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
            ],
            "fonction" => []
        ];
        $this->processing($this->busCategorieModels, 'getAllCategorie', $param);
    } else {
        $param = [
            "button" => [
                "modal" => [
                    ["bus/modifCategorieModal", "bus/modifCategorieModal", "fa fa-edit"],

                ],
                "default" => [
                    ["bus/detailBus/", "fa fa-search"]
                ]
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
        $this->processing($this->busCategorieModels, 'getAllCategorie', $param);

    }

}
}
    public function listeCategorie__()
    {
        $this->views->getTemplate("bus/listeCategorie");

    }
    public function ajoutCategorieModal()
    {
        //var_dump($this->paramPOST);
        // $data['bus'] = $this->busModels->getBus($param);
        //$this->views->setData($data);
        $this->modal();

    }
    public function ajoutCategorie()
    {


        $result = $this->busCategorieModels->insertCategorie(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang['categorieAjoute']]);
        else Utils::setMessageALert(["danger", $this->lang['categorieNonAjoute']]);
        Utils::redirect("bus", "listeCategorie");

    }

    public function activateCat()
    {

        if (intval($this->paramGET[0]) > 0) {
            $result = $this->busCategorieModels->updateCategorie(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_active_categorie"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_active_categorie"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_active_categorie"]]);
        Utils::redirect("bus", "listeCategorie");
    }

    public function deactivateCat()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->busCategorieModels->updateCategorie(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactive_categorie"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactive_categorie"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactive_categorie"]]);
        Utils::redirect("bus", "listeCategorie");
    }

    public function removeCategorie()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->busCategorieModels->deleteCategorie(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_categorie"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_categorie"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_categorie"]]);
        Utils::redirect("bus", "listeCategorie");
    }

    public function modifCategorieModal()

    {
        $data['categorie'] = $this->busCategorieModels->getCategorie(["condition" => ["id = " => $this->paramGET[2]]])[0];
        //$data['bus'] = $this->busModels->getBus();
        //var_dump($data);die();
        $this->views->setData($data);

        $this->modal();
    }

    public function updateCategorie()
    {
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->busCategorieModels->updateCategorie($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_categorie"]]);
        else Utils::setMessageALert(["danger", $this->lang["succes_update_categorie"]]);
        Utils::redirect("bus", "listeCategorie");

    }


}
