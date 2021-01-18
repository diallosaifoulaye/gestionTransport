<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 21:11
 */

namespace app\controllers\admin;

use app\core\BaseController;
use app\core\Session;
use app\core\Utils;

class AdministrationController extends BaseController
{
    private $profilModels;
    private $utilisateurModels;
    private $moduleModels;
    private $droitModels;
    private $paysModels;
    private $typeprofilModels;






    public function __construct()
    {
        parent::__construct();

        $this->moduleModels = $this->model("module");
        $this->droitModels = $this->model("droit");
        $this->paysModels = $this->model("pays");
        $this->typeprofilModels = $this->model("typeprofil");
        $this->profilModels = $this->model("profil");
        $this->utilisateurModels = $this->model("utilisateur");



        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_administration"]);

    }

    public function index__()
    {

        //echo 'yes';exit();
        $this->views->getTemplate('admin');

    }

    public function indexx__()
    {
        //echo 'yes';exit();
        //echo ROOT." ".WEBROOT ;exit;
        $this->views->getTemplate('administration');

    }

    public function location__()
    {
        //echo 'yes';exit();
        //echo ROOT." ".WEBROOT ;exit;
        $this->views->getTemplate('location');

    }


    public function accueil__()
    {
        $this->views->getPage('home/accueil');
    }
    public function menu__()
    {
        $this->views->getPage('home/menu');
    }

    /********Connection à la plateforme sunusva si ok********/

    public function unlogin__()
    {
        Session::destroySession();
        Utils::redirect("home", "index");
    }

    public function auth2()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("connexion");
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function profilUser()
    {
        $etat =1;
        $data['allProfil'] = $this->profilModels->AllProfil(["condition" => ["etat = " => $etat]]);
        $data['user'] = $this->utilisateurModels->getOneUtilisateur(["condition" => ["u.id = " => $this->_USER->id]]);
        $this->views->setData($data);
        $this->views->getTemplate('profilUser');
    }


    /************************ Gestion des Modules  **********************/
    // Modal Ajout Module
    public function ajoutModuleModal()
    {
        $this->modal();
    }

    // Ajout Module
    public function ajoutModule()
    {
        //parent::validateToken("administration", "listeModule");
        //var_dump($this->paramPOST);exit;
        $result = $this->moduleModels->insertModule(["champs" => $this->paramPOST]);

        //var_dump($result);exit;
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_module"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_module"]]);
        Utils::redirect("administration", "listeModule");
    }

    // Modal Modification Module
    public function modifModuleModal()
    {
        $data['module'] = $this->moduleModels->getModule(["condition" => ["id = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal();
    }

    // Modification Module
    public function updateModule()
    {
        //parent::validateToken("administration", "listeModule");
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        //var_dump($data['champs']); die();
        $result = $this->moduleModels->updateModule($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_module"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_module"]]);
        Utils::redirect("administration", "listeModule");
    }

    // Supression Module
    public function removeModule()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->moduleModels->deleteModule(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_module"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_module"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_module"]]);
        Utils::redirect("administration", "listeModule");
    }

    // Liste Module
    public function listeModule()
    {
        if ($this->_USER->admin == 1){
            $this->views->getTemplate('listeModule');
        }else{

        }

    }

    // Processing Module
    public function listeModulePro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifModuleModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["administration/modifModuleModal", "administration/modifModuleModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["administration/activateModule/","fa fa-toggle-off"],"1" => ["administration/deactivateModule/", "fa fa-toggle-on"]]]
                            /*,["administration/removeModule/", "fa fa-trash"]*/
                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => ["Modifier",["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Desactiver"]]],
                        "default" => [["champ"=>"etat","val"=>["0"=>"Activer","1"=>"Désactiver"]], "supprimer"]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm","confirm"]
                    ],
                    "attribut" => [],
                    "args" => null,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>Désactivé</i>"], "1" => ["<i class='text-success'>Activé</i>"]]]
                    ],
                    "fonction" => []
                ];
                $this->processing($this->moduleModels, 'getAllModule', $param);

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
                $this->processing($this->moduleModels, 'getAllModule', $param);

            }

        }
    }

    // Activation module
    public function activateModule()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->moduleModels->updateModule(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_module"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_module"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_module"]]);
        Utils::redirect("administration", "listeModule");
    }

    // Desactivation module
    public function deactivateModule()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->moduleModels->updateModule(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_module"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_module"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_module"]]);
        Utils::redirect("administration", "listeModule");
    }

    /******************** FIN Gestion des Modules  *************************/

    /*********************** DEBUT Gestion des Droits ************************/

    // Ajout Droit
    public function ajoutDroitModal()
    {
        $data['module'] = $this->moduleModels->getModule($param);
        //var_dump($data['module']); die();
        $this->views->setData($data);
        $this->modal();


    }

    // Ajout Droit
    public function ajoutDroit()
    {
        //parent::validateToken("administration", "listeDroit");
        $result = $this->droitModels->insertDroit(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_droit"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_droit"]]);
        Utils::redirect("administration", "listeDroit");

    }

    // Modification Droit
    public function modifDroitModal()

    {
        $data['droit'] = $this->droitModels->getDroit(["condition" => ["id = " => $this->paramGET[2]]])[0];
        $data['module'] = $this->moduleModels->getModule();
        $this->views->setData($data);
        $this->modal();

    }

    // Update Droit
    public function updateDroit()
    {
        //parent::validateToken("administration", "listeDroit");

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->droitModels->updateDroit($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_droit"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_droit"]]);
        Utils::redirect("administration", "listeDroit");
    }

    // Supression droit
    public function removeDroit()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->droitModels->deleteDroit(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_droit"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_droit"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_droit"]]);
        Utils::redirect("administration", "listeDroit");
    }

    //  Liste droit
    public function listeDroit__()
    {
        $this->views->getTemplate("listeDroit");
    }

    // Processing Droit
    public function listeDroitPro()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('administration')->__authorized($this->_USER->idprofil, 'administration', 'modifDroitModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["administration/modifDroitModal", "administration/modifDroitModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["administration/activateDroit/","fa fa-toggle-off"],"1" => ["administration/deactivateDroit/", "fa fa-toggle-on"]]]
                            /*,["administration/removeDroit/", "fa fa-trash"]*/
                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => ["Modifier",["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Desactiver"]]],
                        "default" => [["champ"=>"etat","val"=>["0"=>"Activer","1"=>"Désactiver"]], "supprimer"]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm","confirm"]
                    ],
                    "attribut" => [],
                    "args" => null,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>Désactivé</i>"], "1" => ["<i class='text-success'>Activé</i>"]]]
                    ],
                    "fonction" => []
                ];
                $this->processing($this->droitModels, 'getAllDroit', $param);


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
                $this->processing($this->droitModels, 'getAllDroit', $param);


            }

        }
    }

    // Activation droit
    public function activateDroit()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->droitModels->updateDroit(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_droit"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_droit"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_droit"]]);
        Utils::redirect("administration", "listeDroit");
    }

    // Desactivation droit
    public function deactivateDroit()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->droitModels->updateDroit(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_droit"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_droit"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_droit"]]);
        Utils::redirect("administration", "listeDroit");
    }

    /*********************** FIN Gestion des Droits *********************/

    /******************** DEBUT Gestion Pays *******************************/
    // Liste Pays
    public function listePays()
    {
        $this->views->getTemplate('listePays');
    }

    // Processing Pays
    public function listePaysPro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifPaysModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["administration/modifPaysModal", "administration/modifPaysModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["administration/activatePays/","fa fa-toggle-off"],"1" => ["administration/deactivatePays/", "fa fa-toggle-on"]]]
                            /*, ["administration/removePays/", "fa fa-trash"]*/
                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => ["Modifier",["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Desactiver"]]],
                        "default" => [["champ"=>"etat","val"=>["0"=>"Activer","1"=>"Désactiver"]], "supprimer"]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm","confirm"]
                    ],
                    "attribut" => [],
                    "args" => null,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>Désactivé</i>"], "1" => ["<i class='text-success'>Activé</i>"]]]
                    ],
                    "fonction" => []
                ];
                $this->processing($this->paysModels, 'getAllPays', $param);

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
                $this->processing($this->paysModels, 'getAllPays', $param);

            }

        }
    }

    // Modal Ajout Pays
    public function ajoutPaysModal()
    {
        $this->modal();
    }

    // Modal Ajout Pays
    public function ajoutPays()
    {
        //parent::validateToken("administration", "listePays");
        //  var_dump("tets");exit;
        $this->paramPOST["user_creation"] = $this->_USER->id;
        //echo '<pre>'; var_dump($this->paramPOST); die();

        $result = $this->paysModels->insertPays(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_pays"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_pays"]]);
        Utils::redirect("administration", "listePays");
    }

    // Modification Pays
    public function modifPaysModal()
    {
        $data['pays'] = $this->paysModels->getPays(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal();
    }

    // Modification Pays
    public function updatePays()
    {
        //parent::validateToken("administration", "listePays");
        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        unset($this->paramPOST['rowid']);
        $data['champs'] = $this->paramPOST;
        //var_dump($this->paramPOST); die();
        $result = $this->paysModels->updatePays($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_pays"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_pays"]]);
        Utils::redirect("administration", "listePays");
    }

    // Supression Pays
    public function removePays()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->paysModels->deletePays(["condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_pays"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_pays"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_pays"]]);
        Utils::redirect("administration", "listePays");
    }

    // Activation Pays
    public function activatePays()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->paysModels->updatePays(["champs" => ["etat" => 1], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_pays"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_pays"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_pays"]]);
        Utils::redirect("administration", "listePays");
    }

    // Désactivation Pays
    public function deactivatePays()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->paysModels->updatePays(["champs" => ["etat" => 0], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_pays"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_pays"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_pays"]]);
        Utils::redirect("administration", "listePays");
    }

    /******************** FIN Gestion Pays ******************************/


    /********************* DEBUT Gestion des types de Profil ou groupes ******************/

    // Ajout groupe
    public function ajoutGroupeModal()
    {
        $this->modal();

    }

    // Ajout groupe
    public function ajoutGroupe()
    {
        //parent::validateToken("administration", "listeGroupe");
        $result = $this->typeprofilModels->insertTypeprofil(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", "Type Profil ajouté avec succes"]);
        else Utils::setMessageALert(["danger", "Echec de l'ajout du Type Profil"]);
        Utils::redirect("administration", "listeGroupe");


    }

    // Modification groupe
    public function modifGroupeModal()

    {
        $data['groupe'] = $this->typeprofilModels->getTypeprofil(["condition" => ["id = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal();

    }

    // Update groupe
    public function updateGroupe()
    {
        //parent::validateToken("administration", "listeGroupe");


        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->typeprofilModels->updateTypeprofil($data);
        if ($result !== false) Utils::setMessageALert(["success", "Type de Profil modifié avec succes"]);
        else Utils::setMessageALert(["danger", "Echec de la modification du type profil"]);
        Utils::redirect("administration", "listeGroupe");
    }

    // Supression groupe
    public function removeGroupe()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->typeprofilModels->deleteTypeprofil(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", "le type profil supprimé avec succes"]);
            else Utils::setMessageALert(["danger", "Echec de la suppression du type profil"]);
        } else Utils::setMessageALert(["danger", "Echec de la suppression du type de profil"]);
        Utils::redirect("administration", "listeGroupe");
    }

    // Liste groupe
    public function listeGroupe__()
    {
        $this->views->getTemplate("listeGroupe");

    }

    // Activation groupe
    public function activateGroupe()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->typeprofilModels->updateTypeprofil(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_groupe"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_groupe"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_groupe"]]);
        Utils::redirect("administration", "listeGroupe");
    }

    // Desactivation groupe
    public function deactivateGroupe()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->typeprofilModels->updateTypeprofil(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_groupe"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_groupe"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_groupe"]]);
        Utils::redirect("administration", "listeGroupe");
    }

    // Processing groupe
    public function listeGroupePro()
    {
        $param = [
            "button" => [
                "modal" => [
                    ["administration/modifGroupeModal", "administration/modifGroupeModal", "fa fa-edit"]
                ],
                "default" => [
                    ["champ" => "_etat_","val" => ["0" => ["administration/activateGroupe/","fa fa-toggle-off"],"1" => ["administration/deactivateGroupe/", "fa fa-toggle-on"]]],
                    /*["administration/removeGroupe/", "fa fa-trash"]*/
                ]
                //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
            ],
            "tooltip" => [
                "modal" => ["Modifier"],
                "default" => [["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Désactiver"]]]
            ],
            "classCss" => [
                "modal" => [],
                "default" => ["confirm"]
            ],
            "attribut" => [],
            "args" => null,
            "dataVal" => [
                ["champ" => "_etat_", "val" => ["0" => ["<i class='text-danger'>Désactivé</i>"], "1" => ["<i class='text-success'>Activé</i>"]]]
            ],
            "fonction" => []
        ];
        $this->processing($this->typeprofilModels, 'getAllTypeprofil', $param);

    }



    /******** FIN Gestion des types de  Profil ou groupes ********************/


    /*********************** DEBUT Gestion des Profil *********************/

    // Affectation droit
    public function affectation__()
    {
        $data['idProfil'] = $this->paramGET[0];

        $data['droit'] = $this->droitModels->getDroit($param);
        $data['droitprofil'] = $this->profilModels->getDroitprofil($data['idProfil']);

        $droitprofil = array();
        foreach ($data['droitprofil'] as $dp) {
            array_push($droitprofil, $dp->fk_droit);
        }

        //array_search(40489, array_column($userdb, 'uid'));

        foreach ($data['droit'] as $droit) {

            if (in_array($droit->id, $droitprofil)) {
                $droit->exite = 1;

            } else {
                $droit->exite = 0;

            }
        }

        //echo '<pre>'; var_dump($data['droit']);exit;
        $this->views->setData($data);
        $this->views->getTemplate("administration/affectation");

    }

    // Ajout Affectation
    public function ajoutaffectation()
    {
        //parent::validateToken("profil", "affectation");
        $profil = $this->paramPOST['idProfil'];
        $droit1 = $this->paramPOST['add'];
        $this->profilModels->deleteAffectDroit($profil);
        foreach ($droit1 as $item) {
            $this->profilModels->insertAffectDroit(["champs" => ['fk_profil' => $profil, 'fk_droit' => $item]]);

        }

        Utils::redirect("administration", "affectation", [$profil]);

    }

    // Ajout Profil
    public function ajoutProfilModal()
    {
        //var_dump($this->paramPOST);
        $data['typep'] = $this->typeprofilModels->getTypeprofil($param);
        $this->views->setData($data);
        $this->modal();

    }

    // Ajout Profil
    public function ajoutProfil()
    {
        //parent::validateToken("administration", "listeProfil");

        $result = $this->profilModels->insertProfil(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", "Profil ajouté avec succes"]);
        else Utils::setMessageALert(["danger", "Echec de l'ajout du profil"]);
        Utils::redirect("administration", "listeProfil");


    }

    //Modification Profil
    public function modifProfilModal()

    {
        $data['profil'] = $this->profilModels->getProfil(["condition" => ["id = " => $this->paramGET[2]]])[0];
        $data['typep'] = $this->typeprofilModels->getTypeprofil();
        $this->views->setData($data);

        $this->modal();

    }

    //Gestion actions Profil
    public function actionProfilModal()
    {

        $etat = 1;

        $data['module']= $this->profilModels->allModule(["condition" => ["id = " => $etat]]);

        $data['groupe']= $this->profilModels->allGroupe(["condition" => ["id = " => $etat]]);

        //$fk_groupe = $this->profilModels->getFKGroupe(["condition" => ["p.id = " => $this->paramGET[2]]]);

        $data['actions_autorisees'] = $this->profilModels->allActionsAutoriseByProfil(["condition" => ["fk_profil = " => $this->paramGET[2], "etat =" => $etat]]);
        //var_dump($data['actions_autorisees']);die;
        $data['profil']= $this->profilModels->getProfilByIdInteger(["condition" => ["p.id = " => $this->paramGET[2]]]);
        //var_dump($data['profil']);
        $this->views->setData($data);

        $this->modal();
    }

    // Affecter des actions à un profil
    public function ajoutDroitProfil()
    {

        $user_creation = $this->_USER->id;
        $id = $this->paramPOST['fk_profil'];
        $lesactionscoches = array();
        $lesactionscoches = $this->paramPOST['fk_droit'];
        $nbre = sizeof($lesactionscoches);



        $rst= $this->profilModels->deleteAutoriseAction(["condition" => ["fk_profil = " => $id]]);
        if($rst)
        {
            $i = 0;
        }

        foreach($lesactionscoches as $uneaction)
        {
            $result1 = $this->profilModels->autoriseAction($uneaction, $id, $user_creation);
            if($result1)
            {
                $i++;
            }
        }
        if($nbre == $i)
        {
            Utils::setMessageALert(["success", $this->lang["action_success"]]);
            //$this->profilModels->log_journal('Affectation droit profil', 'profil affecté : '.$id, 'affectation droit succes', 1, $this->_USER->id);
            Utils::redirect('administration', 'listeProfil');
        }
    }

    // Update Profil
    public function updateProfil()
    {
        //parent::validateToken("administration", "listeProfil");


        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->profilModels->updateProfil($data);
        if ($result !== false) Utils::setMessageALert(["success", "Profil modifié avec succes"]);
        else Utils::setMessageALert(["danger", "Echec de la modification du profil"]);
        Utils::redirect("administration", "listeProfil");
    }

    // Supression profil
    public function removeProfil()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->profilModels->deleteProfil(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", "profil supprimé avec succes"]);
            else Utils::setMessageALert(["danger", "Echec de la suppression du profil"]);
        } else Utils::setMessageALert(["danger", "Echec de la suppression du profil"]);
        Utils::redirect("administration", "listeProfil");
    }

    // Processing profil
    public function listeProfilPro__()
    {

        $param = [
            "button" => [
                "default" => [
                    ["champ" => "etat","val" => ["0" => ["administration/activate/","fa fa-toggle-off"],"1" => ["administration/deactivate/", "fa fa-toggle-on"]]],
                    /*["administration/removeProfil/", "fa fa-trash"]*/
                ],
                "modal" => [
                    ["administration/modifProfilModal", "administration/modifProfilModal", "fa fa-edit"],
                    ["administration/actionProfilModal", "administration/actionProfilModal", "fa fa-search"]
                ]
                //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
            ],
            "tooltip" => [
                "modal" => ["Modifier",["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Desactiver"]]],
                "default" => [["champ"=>"etat","val"=>["0"=>"Activer","1"=>"Désactiver"]], "supprimer"]
            ],
            "classCss" => [
                "modal" => [],
                "default" => ["confirm"]
            ],
            "attribut" => [],
            "args" => null,
            "dataVal" => [
                ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>Désactivé</i>"], "1" => ["<i class='text-success'>Activé</i>"]]]
            ],
            "fonction" => []
        ];
        $this->processing($this->profilModels, 'getAllProfil', $param);

    }

    // Liste profil
    public function listeProfil__()
    {
        $this->views->getTemplate("listeProfil");

    }

    // Activation profil & Desactivation profil//
    public function activate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->profilModels->updateProfil(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", "Profil activé avec succes"]);
            else Utils::setMessageALert(["danger", "Echec de l'activation du Profil"]);
        } else Utils::setMessageALert(["danger", "Echec de l'activation du profil"]);
        Utils::redirect("administration", "listeProfil");
    }

    public function deactivate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->profilModels->updateProfil(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", "Profil desactivé avec succes"]);
            else Utils::setMessageALert(["danger", "Echec de la desactivation du profil"]);
        } else Utils::setMessageALert(["danger", "Echec de la desactivation du profil"]);
        Utils::redirect("administration", "listeProfil");
    }

    /*********************** FIN Gestion des Profil *********************/

    /******************* DEBUT Gestion des utilisateurs *******************/
    // Modification utilisateur
    public function modifUtilisateurModal()

    {
        $data['retour']=$this->paramGET[3];
        $data['utilisateur'] = $this->utilisateurModels->getUtilisateur(["condition" => ["id = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal();

    }

    public function updateUtilisateur()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        if (Utils::validateMail($this->paramPOST["email"])) {
            $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
            $id = $this->paramPOST['id'];
            unset($this->paramPOST['id']);
            $data['champs'] = $this->paramPOST;
            $result = $this->utilisateurModels->updateUtilisateur($data);
            if ($result !== false) Utils::setMessageALert(["success", "Utilisateur modifié avec succes"]);
            else Utils::setMessageALert(["danger", "Echec de la modification du Utilisateur"]);
        } else Utils::setMessageALert(["warning", "email invalide"]);
        if($this->paramGET[0]=="r"){Utils::redirect("administration", "profilUser");
        }else{Utils::redirect("administration", "detailUser"."/".$id);}
    }

    // Activation Desactivation User
    public function updateEtatUser()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->utilisateurModels->updateUtilisateur($data);
        if ($result !== false) Utils::setMessageALert(["success", "Utilisateur modifié avec succes"]);
        else Utils::setMessageALert(["danger", "Echec de la modification du Utilisateur"]);

        if($this->paramGET[0]=="r"){Utils::redirect("administration", "profilUser");
        }else{Utils::redirect("administration",  "detailUser"."/".$id);}
    }

    // Update utilisateur
    public function updatePhoto()
    {
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $dossier_photo =  ROOT."assets/pictures/";
        //AJOUT PHOTO ET SIGNATURE
        $file_photo = basename($_FILES['photo']['name']);
        //var_dump($dossier_photo);exit;
        if ($file_photo != null) {

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $dossier_photo.$file_photo)) //Si la fonction renvoie TRUE, c'est que &ccedil;a a fonctionn&eacute;...
            {
                //var_dump($file_photo);exit;
                $info = new \SplFileInfo($file_photo);
                $new_name = date("YmdHis") . '.' . $info->getExtension();
                rename($dossier_photo . $file_photo, $dossier_photo . $new_name);
                $file_photo = $new_name;
            }
        }
        $this->paramPOST['photo'] = $file_photo;



        $data['champs'] = $this->paramPOST;

        //var_dump($data);die();

        $rst= $this->utilisateurModels->updatePhoto($data);
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
        Utils::redirect('administration', "detailUser"."/".$id);
    }

    // Ajout utilisateur/
    public function ajoutUtilisateurModal()
    {
        $data['typep'] = $this->profilModels->getidprofil($param);
        $this->views->setData($data);
        $this->modal();

    }

    // Ajout utilisateur
    public function ajoutUtilisateur()
    {
        $pass = Utils::getGeneratePassword(12);
        $pwd = $pass['pass'];
        $this->paramPOST["password"] = sha1($pwd);
        $prenom = $this->paramPOST["prenom"];
        $nom = $this->paramPOST["nom"];
        $email = $this->paramPOST["email"];
        $login = $this->paramPOST["login"];
        $password = $this->paramPOST["password"];

        $dossier_photo = ROOT."app/pictures/";
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

        if (Utils::validateMail($this->paramPOST["email"])) {

            if (!$this->utilisateurModels->VerifEmail(['utilisateur', 'email'], $this->paramPOST["email"])) {

                $this->paramPOST["user_creation"]= $this->_USER->id;
                $result = $this->utilisateurModels->insertUtilisateur(["champs" => $this->paramPOST]);

                if ($result !== false){
                    Utils::envoiparametre($prenom.' '.$nom, $email, $login, $pwd);
                    Utils::setMessageALert(["success", "Utilisateur ajouté avec succes"]);
                }

                else Utils::setMessageALert(["danger", "Echec de l'ajout du Utilisateur"]);

            } else Utils::setMessageALert(["danger", $this->lang["email_existe"]]);


        } else Utils::setMessageALert(["warning", "email invalide"]);

        Utils::redirect("administration", "listeUtilisateur");

    }

    // Vérifier si email existe déjà
    public function verifExistenceEmail()
    {
        $verif = $this->utilisateurModels->verifEmailModel($this->paramPOST['email']);
        if($verif==1) echo 1;
        else echo -1;
    }

    // Vérifier si email existe déjà
    public function verifExistenceLogin()
    {
        $verif = $this->utilisateurModels->verifLoginModel($this->paramPOST['login']);
        if($verif==1) echo 1;
        else echo -1;
    }

    // Mon Profil
//    public function profilUser()
//    {
//        $etat =1;
//        $data['allProfil'] = $this->profilModels->AllProfil(["condition" => ["etat = " => $etat]]);
//        $data['user'] = $this->utilisateurModels->getOneUtilisateur(["condition" => ["u.id = " => $this->_USER->id]]);
//        $this->views->setData($data);
//        $this->views->getTemplate('administration/profilUser');
//    }

    // Modification Password utilisateur
    public function modifpwdUtilisateurModal()
    {
        $this->modal();

    }

    // Modification Password utilisateur
    public function updatepwdUtilisateur()
    {
        parent::validateToken("administration", "profilUser");
        $data['user'] = $this->utilisateurModels->getOneUtilisateur(["condition" => ["id = " => $this->_USER->id]]);
        $this->views->setData($data);
        if (sha1($this->paramPOST["password"])== $data['user']->password) {
            if ($this->paramPOST["npassword"]== $this->paramPOST["cpassword"]) {
                $result = $this->utilisateurModels->updateUtilisateur(["champs" => ["password" => sha1($this->paramPOST["npassword"])], "condition" => ["id = " => $this->_USER->id]]);
                if ($result !== false) Utils::setMessageALert(["success", "Mot de passe modifié avec succes"]);
                else Utils::setMessageALert(["danger", "Echec de la modification du mot de passe"]);
            } else Utils::setMessageALert(["danger", "Echec de confirmation du mot de passe"]);

        }else Utils::setMessageALert(["danger", "Echec mot passe incorect"]);

        $this->views->getTemplate('administration/profilUser');


    }

    //  Supression utilisateur
    public function remove()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->utilisateurModels->deleteUtilisateur(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", "Utilisateur supprimé avec succes"]);
            else Utils::setMessageALert(["danger", "Echec de la suppression du Utilisateur"]);
        } else Utils::setMessageALert(["danger", "Echec de la suppression de l'utilisateur"]);
        Utils::redirect("administration", "listeUtilisateur");
    }

     //Liste utilisateur
    public function listeUtilisateur()
    {
        $this->views->getTemplate('listeUtilisateur');
    }

    public function detailUser(){

        $etat = 1;
        $data['user'] = $this->utilisateurModels->getOneUtilisateur(["condition" => ["u.id = " => $this->paramGET[0]]]);
        $data['allProfil'] = $this->profilModels->AllProfil(["condition" => ["etat = " => $etat]]);
        //echo '<pre>'; var_dump($data['user']);die();
        $this->views->setData($data);
        $this->views->getTemplate('administration/detailUser');
    }

    public function updateUtilisateurDetail()
    {


        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->utilisateurModels->updateUserDetail($data);
        if ($result !== false) Utils::setMessageALert(["success", "Responsable modifié avec succes"]);
        else Utils::setMessageALert(["danger", "Echec de la modification du Responsable"]);

        if($this->paramGET[0]=="r"){Utils::redirect("admin", "detailRespon"."/".$id);
        }else{Utils::redirect("administration",  "detailUser"."/".$id);}
    }



    // Processing utilisateur
    public function listeUtilisateurPro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            /*["administration/modifUtilisateurModal", "administration/modifUtilisateurModal", "fa fa-edit"]*/
                        ],
                        "default" => [
                            /*["administration/remove/", "fa fa-trash"],*/
                            ["administration/detailUser/", "fa fa-search"]
                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => ["Modifier"],
                        "default" => ["Détail"]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => null,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>Désactivé</i>"], "1" => ["<i class='text-success'>Activé</i>"]]]

                    ],
                    "fonction" => []
                ];
                $this->processing($this->utilisateurModels, 'getAllUtilisateur', $param);

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
                $this->processing($this->utilisateurModels, 'getAllUtilisateur', $param);

            }

        }
    }

    /***********************FIN Gestion des utilisateurs*********************/




}