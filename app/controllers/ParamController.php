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
use app\models\ParamModel ;
class ParamController extends BaseController
{
    private $utilisateurModels;
    private $paramModels;
    private $moduleModels;
    private $droitModels;
    private $typeprofilModels;
    private $profilModels;
    private $homeModels;




    public function __construct()
    {

        parent::__construct();
        $this->paramModels = new ParamModel();
        $this->moduleModels = $this->model("module");
        $this->droitModels = $this->model("droit");
        $this->typeprofilModels = $this->model("typeprofil");
        $this->profilModels = $this->model("profil");
        $this->utilisateurModels = $this->model("utilisateur");
        $this->homeModels = $this->model("admin");
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_admin"]);

    }

    public function quotepart(){
        $this->views->getTemplate('param/quotepart');

    }

    public function ajoutQuotePartModal()
    {
        $this->modal();

    }


    public function insertQuote()
    {
        try {

            $this->paramPOST['valeur'] = $this->paramPOST['valeur'] * 0.01 ;
            $this->paramPOST['user_creation'] = $this->_USER->id ;
            $result = $this->paramModels->insertQuote(["champs" => $this->paramPOST]);
            if (!$result)
                throw new \Exception("Erreur Insertion dans quote") ;
            Utils::setMessageALert(["success", $this->lang["succes_operation_element"]]);

        } catch (\Exception $exception) {
            Utils::setMessageALert(["danger",$exception->getMessage()]);
        }

        Utils::redirect("param", "quotepart");

    }

    public function modifQuoteModal()
    {
        $param = [
            "table"=>"quote_part",
            "champs"=>["*"],
            "condition"=>["rowid = " => $this->paramGET[2]]
        ];
        $quotePart = $this->paramModels->get($param)[0];
        $data['quote'] = $quotePart;
        $this->views->setData($data);
        $this->modal();
    }


    public function removeQuote()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->paramModels->deleteQuote(["condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false)
                Utils::setMessageALert(["success", $this->lang["succes_operation_element"]]);
            else
                Utils::setMessageALert(["danger", $this->lang["echec_operation_element"]]);
        } else
            Utils::setMessageALert(["danger", $this->lang["echec_operation_element"]]);
        Utils::redirect("param", "quotepart");
    }

    public function updateQuote()
    {
        try {

            $this->paramPOST['valeur'] = $this->paramPOST['valeur'] * 0.01 ;
            $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['id'])];
            unset($this->paramPOST['id']);
            $data['champs'] = $this->paramPOST;
            $result = $this->paramModels->updateQuote($data);

            if (!$result)
                throw new \Exception("Erreur Update dans la table quote") ;
            Utils::setMessageALert(["success", $this->lang["succes_operation_element"]]);

        } catch (\Exception $exception) {
            Utils::setMessageALert(["danger", $exception->getMessage()]);
        }
        Utils::redirect("param", "quotepart");

    }

    public function quotePartPro__()
    {
        if ($this->_USER) {
            // if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
            $param = [

                "button" => [
                    "default" => [
                        ["param/removeQuote/", "fa fa-trash"],
                    ],
                    "modal" => [
                        ["param/modifQuoteModal", "param/modifQuoteModal", "fa fa-edit"],

                    ]
                ],
                "tooltip" => [
                    "modal" => [$this->lang['Modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],
                    "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['Supprimer'],$this->lang['Detail']]
                ],
                "classCss" => [
                    "modal" => [],
                    "default" => ["confirm","confirm"]
                ],
                "fonction" => []
            ];
            $this->processing($this->paramModels, 'getAllQuotePart', $param);
            //  }
        }
    }
    /************************ Gestion des Modules  **********************/

    public function listeModule()
    {
            $this->views->getTemplate('param/listeModule');
    }

    // Processing Module
    public function listeModulePro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifModuleModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["param/modifModuleModal", "param/modifModuleModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["param/activateModule/","fa fa-toggle-off"],"1" => ["param/deactivateModule/", "fa fa-toggle-on"]]]
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

    // Modal Ajout Module
    public function ajoutModuleModal()
    {
        $this->modal('param/ajoutModuleModal');
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
        Utils::redirect("param", "listeModule");
    }

    // Modal Modification Module
    public function modifModuleModal()
    {
        $data['module'] = $this->moduleModels->getModule(["condition" => ["id = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal('param/modifModuleModal');
    }

    // Modification Module
    public function updateModule()
    {
        //var_dump($this->paramPOST);die;
        //parent::validateToken("administration", "listeModule");
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->moduleModels->updateModule($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_module"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_module"]]);
        Utils::redirect("param", "listeModule");
    }

    // Activation module
    public function activateModule()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->moduleModels->updateModule(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_module"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_module"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_module"]]);
        Utils::redirect("param", "listeModule");
    }

    // Desactivation module
    public function deactivateModule()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->moduleModels->updateModule(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_module"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_module"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_module"]]);
        Utils::redirect("param", "listeModule");
    }
    /************************ Gestion des actions  **********************/


    //  Liste droit
    public function listeDroit__()
    {
        $this->views->getTemplate("param/listeDroit");
    }

    // Processing Droit
    public function listeDroitPro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('administration')->__authorized($this->_USER->idprofil, 'administration', 'modifDroitModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["param/modifDroitModal", "param/modifDroitModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["param/activateDroit/","fa fa-toggle-off"],"1" => ["param/deactivateDroit/", "fa fa-toggle-on"]]]
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

    // Ajout Droit
    public function ajoutDroitModal()
    {
        $data['module'] = $this->moduleModels->getModule($param);
        //var_dump($data['module']); die();
        $this->views->setData($data);
        $this->modal('param/ajoutDroitModal');


    }

    // Ajout Droit
    public function ajoutDroit()
    {
        //parent::validateToken("administration", "listeDroit");
        $result = $this->droitModels->insertDroit(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_droit"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_droit"]]);
        Utils::redirect("param", "listeDroit");

    }

    // Modification Droit
    public function modifDroitModal()

    {
        $data['droit'] = $this->droitModels->getDroit(["condition" => ["id = " => $this->paramGET[2]]])[0];
        $data['module'] = $this->moduleModels->getModule();
        $this->views->setData($data);
        $this->modal('param/modifDroitModal');

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
        Utils::redirect("param", "listeDroit");
    }


    // Activation droit
    public function activateDroit()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->droitModels->updateDroit(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_droit"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_droit"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_droit"]]);
        Utils::redirect("param", "listeDroit");
    }

    // Desactivation droit
    public function deactivateDroit()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->droitModels->updateDroit(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_droit"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_droit"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_droit"]]);
        Utils::redirect("param", "listeDroit");
    }
    /********************* DEBUT Gestion des types de Profil ou groupes ******************/

    // Liste groupe
    public function listeGroupe__()
    {
        $this->views->getTemplate("param/listeGroupe");

    }

    // Processing groupe
    public function listeGroupePro()
    {
        $param = [
            "button" => [
                "modal" => [
                    ["param/modifGroupeModal", "param/modifGroupeModal", "fa fa-edit"]
                ],
                "default" => [
                    ["champ" => "_etat_","val" => ["0" => ["param/activateGroupe/","fa fa-toggle-off"],"1" => ["param/deactivateGroupe/", "fa fa-toggle-on"]]],
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

    // Ajout groupe
    public function ajoutGroupeModal()
    {
        $this->modal('param/ajoutGroupeModal');

    }

    // Ajout groupe
    public function ajoutGroupe()
    {
        //parent::validateToken("administration", "listeGroupe");
        $result = $this->typeprofilModels->insertTypeprofil(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", "Type Profil ajouté avec succes"]);
        else Utils::setMessageALert(["danger", "Echec de l'ajout du Type Profil"]);
        Utils::redirect("param", "listeGroupe");

    }

    // Modification groupe
    public function modifGroupeModal()

    {
        $data['groupe'] = $this->typeprofilModels->getTypeprofil(["condition" => ["id = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal('param/modifGroupeModal');

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

    // Activation groupe
    public function activateGroupe()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->typeprofilModels->updateTypeprofil(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_groupe"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_groupe"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_groupe"]]);
        Utils::redirect("param", "listeGroupe");
    }

    // Desactivation groupe
    public function deactivateGroupe()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->typeprofilModels->updateTypeprofil(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_groupe"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_groupe"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_groupe"]]);
        Utils::redirect("param", "listeGroupe");
    }

    // Liste profil
    public function listeProfil__()
    {
        $this->views->getTemplate("param/listeProfil");

    }

    // Processing profil
    public function listeProfilPro__()
    {

        $param = [
            "button" => [
                "default" => [
                    ["champ" => "etat","val" => ["0" => ["param/activate/","fa fa-toggle-off"],"1" => ["param/deactivate/", "fa fa-toggle-on"]]],
                    /*["administration/removeProfil/", "fa fa-trash"]*/
                ],
                "modal" => [
                    ["param/modifProfilModal", "param/modifProfilModal", "fa fa-edit"],
                    ["param/actionProfilModal", "param/actionProfilModal", "fa fa-search"]
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

    // Ajout Profil
    public function ajoutProfilModal()
    {
        //var_dump($this->paramPOST);
        $data['typep'] = $this->typeprofilModels->getTypeprofil($param);
        $this->views->setData($data);
        $this->modal('param/ajoutProfilModal');

    }

    // Ajout Profil
    public function ajoutProfil()
    {
        //parent::validateToken("administration", "listeProfil");

        $result = $this->profilModels->insertProfil(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", "Profil ajouté avec succes"]);
        else Utils::setMessageALert(["danger", "Echec de l'ajout du profil"]);
        Utils::redirect("param", "listeProfil");

    }

    // Activation profil & Desactivation profil//
    public function activate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->profilModels->updateProfil(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", "Profil activé avec succes"]);
            else Utils::setMessageALert(["danger", "Echec de l'activation du Profil"]);
        } else Utils::setMessageALert(["danger", "Echec de l'activation du profil"]);
        Utils::redirect("param", "listeProfil");
    }

    public function deactivate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->profilModels->updateProfil(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", "Profil desactivé avec succes"]);
            else Utils::setMessageALert(["danger", "Echec de la desactivation du profil"]);
        } else Utils::setMessageALert(["danger", "Echec de la desactivation du profil"]);
        Utils::redirect("param", "listeProfil");
    }

    //Modification Profil
    public function modifProfilModal()

    {
        $data['profil'] = $this->profilModels->getProfil(["condition" => ["id = " => $this->paramGET[2]]])[0];
        $data['typep'] = $this->typeprofilModels->getTypeprofil();
        $this->views->setData($data);

        $this->modal('param/modifProfilModal');
    }

    // Update Profil
    public function updateProfil()
    {
        //var_dump($this->paramPOST['id']);die;

        //parent::validateToken("administration", "listeProfil");
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->profilModels->updateProfil($data);
        if ($result !== false) Utils::setMessageALert(["success", "Profil modifié avec succes"]);
        else Utils::setMessageALert(["danger", "Echec de la modification du profil"]);
        Utils::redirect("param", "listeProfil");
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

        $this->modal('param/actionProfilModal');
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
            Utils::redirect('param', 'listeProfil');
        }
    }

    // Liste utilisateur
    public function listeUtilisateur__()
    {
        //var_dump($this->_USER);die;
        $this->views->getTemplate('param/listeUtilisateur');
    }

    // Processing utilisateur
    public function listeUtilisateurPro__()
    {

      //  if ($this->_USER) {
            if ($this->_USER->admin == 1/* || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0*/) {
                $param = [
                    "button" => [
                        "modal" => [
                            /*["administration/modifUtilisateurModal", "administration/modifUtilisateurModal", "fa fa-edit"]*/
                        ],
                        "default" => [
                            /*["administration/remove/", "fa fa-trash"],*/
                            ["param/detailUser/", "fa fa-search"]
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
                    "dataVal" => [],
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
   // }

    public function ajoutUtilisateurModal()
    {
        $data['typep'] = $this->profilModels->getidprofil($param);
        $this->views->setData($data);
        $this->modal('param/ajoutUtilisateurModal');

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

        Utils::redirect("param", "listeUtilisateur");

    }

    public function detailUser(){

        $etat = 1;
        $data['user'] = $this->utilisateurModels->getOneUtilisateur(["condition" => ["u.id = " => $this->paramGET[0]]]);
        $data['allProfil'] = $this->profilModels->AllProfil(["condition" => ["etat = " => $etat]]);
        //echo '<pre>'; var_dump($data['user']);die();
        $this->views->setData($data);
        $this->views->getTemplate('param/detailUser');
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
        }else{Utils::redirect("param",  "detailUser"."/".$id);}
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
        }else{Utils::redirect("param", "detailUser"."/".$id);}
    }

    // Update utilisateur
    public function updatePhoto()
    {
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $dossier_photo =  ROOT."app/pictures/";
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
        Utils::redirect('param', "detailUser"."/".$id);
    }
    public function envoieMail() {
        $id = $this->paramPOST['id'];
        $email = $this->paramPOST['email'];
        $nom = $this->paramPOST['nom'];
        $login = $this->paramPOST['login'];
        $pass = Utils::getGeneratePassword(12);
        $password = $pass["pass"];

        $passwordHache = sha1($pass["pass"]);
        $updatePwd = $this->homeModels->updateReinitialisationPassword($id,$passwordHache);

        Utils::envoiparametre($nom,$email,$login,$password);
        //Utils::redirect("home", "index");
        Utils::redirect("param",  "detailUser"."/".$id);



    }

}