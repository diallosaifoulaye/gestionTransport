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
use app\models\GestionModel ;

class GestionController extends BaseController
{
    private $gestionModels;


    public function __construct()
    {

        parent::__construct();
        $this->gestionModels = new GestionModel();



        //var_dump($this->_USER);die;

        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_admin"]);

    }

    public function index__()
    {
        $this->views->getTemplate('administration/admin');

    }



    /**************************************************************** DEBUT Gestion ******************************************************************/

    /*********************** DEBUT Gestion des types de materiels ************************/

    // Ajout Droit
    public function ajoutTypeModal()
    {
        //$data['employe'] = $this->employeModels->getChauffeur();
        //$this->views->setData($data);
        $this->modal();
    }

    // Ajout Droit
    public function insertType__()
    {
        $this->paramPOST['numGie'] = $this->_USER->gie;

        $result = $this->gestionModels->insertType(["champs" => $this->paramPOST]);

        if ($result !== false) Utils::setMessageALert(["success", $this->lang["type_add_succes"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_type"]]);
        Utils::redirect("gestion", "listeType");

    }

    // Modification Droit
    public function modifTypeModal()

    {//var_dump($this->paramGET[2]);die();
        $data['type_materiel'] = $this->gestionModels->getType(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
        // $data['module'] = $this->moduleModels->getModule();

        $this->views->setData($data);
        $this->modal();

    }

    // Update Droit
    public function updateType()
    {
        //parent::validateToken("administration", "listeDroit");
        //var_dump($this->paramPOST['id']);die();
        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];

        unset($this->paramPOST['rowid']);
        $data['champs'] = $this->paramPOST;

        $result = $this->gestionModels->updateType($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_type"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_type"]]);
        Utils::redirect("gestion", "listeType");
    }
    public function updateTypeDetail()
    {
        //parent::validateToken("administration", "listeDroit");
        //var_dump($this->paramPOST['id']);die();
        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        $rowid = $this->paramPOST['rowid'];
        unset($this->paramPOST['rowid']);
        $data['champs'] = $this->paramPOST;
        $result = $this->gestionModels->updateTypeDetail($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_type"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_type"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("gestion", "detailType");
        }else{Utils::redirect("gestion",  "detailType"."/".$rowid);}
    }
    // Supression droit
    public function removeType()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gestionModels->deleteType(["condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_type"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_type"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_type"]]);
        Utils::redirect("gestion", "listeType");
    }

    //  Liste droit
    public function listeType__()
    {
        $this->views->getTemplate("gestion/listeType");
    }

    // Processing Droit
    public function listeTypePro__()
    { //var_dump($this->_USER);die;
        if ($this->_USER) {
           // if ($this->_USER->admin == 1 || \app\core\Utils::getModel('gestion')->__authorized($this->_USER->idprofil, 'gestion', 'modifTypeModal') > 0) {
                $param = [

                    "button" => [
                        "modal" => [
                            ["gestion/modifTypeModal", "gestion/modifTypeModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["gestion/activateType/","fa fa-toggle-off"],"1" => ["gestion/deactivateType/", "fa fa-toggle-on"]]],
                            ["gestion/removeType/", "fa fa-trash"],
                            ["gestion/detailType/", "fa fa-search"],
                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                       "modal" => [$this->lang['modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],
                        "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['Supprimer'],$this->lang['Detail']]
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
                $this->processing($this->gestionModels, 'getAllType', $param);


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
                $this->processing($this->gestionModels, 'getAllType', $param);


            }

        }
  //  }

    public function detailType(){

        $etat = 1;

        $data['type_materiel'] = $this->gestionModels->getOneType(["condition" => ["t.rowid = " => $this->paramGET[0]]]);
        //var_dump($data['employe']);die();

        $this->views->setData($data);
        $this->views->getTemplate('gestion/detailType');

    }


    // Activation droit
    public function activateType()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gestionModels->updateType(["champs" => ["etat" => 1], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_type"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_type"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_type"]]);
        Utils::redirect("gestion", "listeType");
    }

    // Desactivation droit
    public function deactivateType()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gestionModels->updateType(["champs" => ["etat" => 0], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_type"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_type"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_type"]]);
        Utils::redirect("gestion", "listeType");
    }
    public function updateTypeUser()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        $rowid = $this->paramPOST['rowid'];
        unset($this->paramPOST['rowid']);
        $data['champs'] = $this->paramPOST;
        $result = $this->gestionModels->updateType($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_type"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_type"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("gestion", "detailType");
        }else{Utils::redirect("gestion",  "detailType"."/".$rowid);}
    }
    public function updateEtatType()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        $rowid= $this->paramPOST['rowid'];
        unset($this->paramPOST['rowid']);
        $data['champs'] = $this->paramPOST;
        $result = $this->gestionModels->updateType($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_type"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_type"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("gestion", "detailType");
        }else{Utils::redirect("gestion",  "detailType"."/".$rowid);}
    }

    // Update utilisateur



    /*********************** FIN Gestion des Types materiels*********************/
    /*******************************************************************************************************************************************************************************************
     *
     */
    /************************ Gestion des Materiels  **********************/


    /**
     * @droit List of devices - 2
     */
    public function listeMateriel()
    {
        $this->views->getTemplate("gestion/listeMateriel");

    }

    public function listeMaterielPro__()
    {
        //var_dump(1);die;
        if ($this->_USER) {
            //if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
                $param = [
                    "button" => [

                        "modal" => [
                            ["gestion/modifMaterielModal", "gestion/modifMaterielModal", "fa fa-edit"],
                            ["gestion/removeMaterielModal", "gestion/removeMaterielModal", "fa fa-trash"],
                            ["champ" => "etat", "val" => ["0" => ["gestion/activateMaterielModal", "gestion/activateMaterielModal", "fa fa-toggle-off"], "1" => ["gestion/desactivateMaterielModal", "gestion/desactivateMaterielModal", "fa fa-toggle-on"]]],


                        ],
                        "default" => [
                            /*["champ" => "etat", "val" => ["0" => ["gestion/activate/", "fa fa-toggle-off"], "1" => ["gestion/deactivate/", "fa fa-toggle-on"]]],
                            ["gestion/removeMateriel/", "fa fa-trash"],
                            ["gestion/detailMateriel/", "fa fa-search"]*/
                        ]

                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                       "modal" => [$this->lang['modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]],],
                        "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['Supprimer'],$this->lang['Detail']]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm", "confirm"]
                    ],
                    "attribut" => [],
                    "args" => $this->_USER,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
                    ],
                    "fonction" => ["affecte_to"=>"getUserAjout",
                                    "date_creation" => "getDateFR",
                    ]
                ];
                $this->processing($this->gestionModels, 'getAllMateriel', $param);

            }
        }

    public function ajoutMaterielModal()
    {
        $param = [
            "table"=>"devices",
            "champs"=>["count(rowid) as nombre"]
        ];
        $device = $this->gestionModels->get($param)[0];
        $data['nombreDevice'] = $device->nombre;
        $this->views->setData($data);
        $this->modal();

    }


    /**
     * @droit Add devices - 2
     */
    public function ajoutMateriel()
    {
        //parent::validateToken("administration", "listeProfil");
        /*$dossier_photo = ROOT."assets/pictures/";
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
        $this->paramPOST['numGie'] = $this->_USER->gie;*/
        //var_dump($this->paramPOST);die;
        $result = $this->gestionModels->insertMateriel(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["materiel_add_succes"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_materiel"]]);
        Utils::redirect("gestion", "listeMateriel");

    }


    /**
     * @droit On devices - 2
     */
    public function activate()
    {

        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gestionModels->updateMateriel(["champs" => ["etat" => 1], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success",   $this->lang["succes_activate_materiel"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_materiel"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_materiel"]]);
        Utils::redirect("gestion", "listeMateriel");
    }


    /**
     * @droit Off devices - 2
     */
    public function deactivate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gestionModels->updateMateriel(["champs" => ["etat" => 0], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_materiel"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_materiel"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_materiel"]]);
        Utils::redirect("gestion", "listeMateriel");
    }


    /**
     * @droit Remove devices - 2
     */
    public function removeMateriel()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gestionModels->deleteMateriel(["condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_materiel"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_materiel"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_materiel"]]);
        Utils::redirect("gestion", "listeMateriel");

        /*$data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        unset($this->paramPOST['rowid']);
        $data['champs'] = ["etat = " => (int)base64_decode($this->paramPOST['etat'])];
        $result = $this->gestionModels->updateMateriel($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_materiel"]]);
        else Utils::setMessageALert(["danger",  $this->lang["echec_delete_materiel"]]);
        Utils::redirect("gestion", "listeMateriel");*/
    }

    public function removeMaterielModal()
    {
        //$data['materiel'] = $this->gestionModels->getMateriel(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
      //  $data['type_materiel'] = $this->gestionModels->AllMateriel();
        $data['materiel'] = $this->paramGET[2];
        $this->views->setData($data);

        $this->modal();

    }

    public function activateMaterielModal()
    {

        $data['materiel'] = $this->gestionModels->getMateriel(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
        //  $data['type_materiel'] = $this->gestionModels->AllMateriel();
        $data['materiel'] = $this->paramGET[2];
        $this->views->setData($data);

        $this->modal();

    }

    public function desactivateMaterielModal()
    {
        $data['materiel'] = $this->paramGET[2];
        $this->views->setData($data);

        $this->modal();

    }

    public function modifMaterielModal()
    {
        $data['materiel'] = $this->gestionModels->getOneMateriel(["condition" => ["rowid = " => $this->paramGET[2]]]);
        $this->views->setData($data);
        $this->modal();

    }


    /**
     * @droit Update devices - 2
     */
    public function updateMateriel()
    {
        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        unset($this->paramPOST['rowid']);
        //$this->paramPOST['user_modification'] = base64_decode($this->paramPOST['user_modification']);
        $data['champs'] = $this->paramPOST;
        //var_dump($data);die;
        $result = $this->gestionModels->updateMateriel($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_materiel"]]);
        else Utils::setMessageALert(["danger",  $this->lang["echec_update_materiel"]]);
        Utils::redirect("gestion", "listeMateriel");

    }

    /**
     * @droit Details devices - 2
     */
    public function detailMateriel(){

        $etat = 1;
        //var_dump($this->paramGET);die();
        $data['materiel'] = $this->gestionModels->getOneMateriel(["condition" => ["m.rowid = " => $this->paramGET[0]]]);
       // $data['type_materiel'] = $this->gestionModels->AllMateriel(["condition" => ["etat = " => $etat]]);
        //echo '<pre>'; var_dump($data['bus']);die();
        $this->views->setData($data);
        $this->views->getTemplate('gestion/detailMateriel');

        //$this->modal();
    }

    public function updateMaterielDetail()
    {


        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        $rowid = $this->paramPOST['rowid'];
        unset($this->paramPOST['rowid']);
        $data['champs'] = $this->paramPOST;
        $result = $this->gestionModels->updateMaterielDetail($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_materiel"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_materiel"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("gestion", "detailMateriel"."/".$rowid);
        }else{Utils::redirect("gestion",  "detailMateriel"."/".$rowid);}
    }


    public function updateEtatMateriel()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        $rowid = $this->paramPOST['rowid'];
        unset($this->paramPOST['rowid']);
        $data['champs'] = $this->paramPOST;
        $result = $this->gestionModels->updateMateriel($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_materiel"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_materiel"]]);
        if($this->paramGET[0]=="r"){Utils::redirect("gestion", "detailMateriel"."/".$rowid);
        }else{Utils::redirect("gestion",  "detailMateriel"."/".$rowid);}
    }

    public function updatePhoto()
    {
        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];

        $rowid = $this->paramPOST['rowid'];
        unset($this->paramPOST['rowid']);
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



        $rst= $this->gestionModels->updatePhoto($data);


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
        Utils::redirect('gestion', "detailMateriel"."/".$rowid);
    }

    /**************************************************************** FIN GESTION MATERIELS ******************************************************************/

    /**************************************************************** DEBUT GESTION AFFECTATION ******************************************************************/



    /**
     * @droit Devices assignements list - 2
     */
    public function affectMateriel()
    {
        $this->views->getTemplate("gestion/affectMateriel");
    }

// Processing Droit
    public function affectMaterielPro__()
{ //var_dump($this->_USER);die;
    if ($this->_USER) {
        // if ($this->_USER->admin == 1 || \app\core\Utils::getModel('gestion')->__authorized($this->_USER->idprofil, 'gestion', 'modifTypeModal') > 0) {
        $param = [

            "button" => [
                "modal" => [
                    [],

                    ["gestion/modifAffectMaterielModal", "gestion/modifAffectMaterielModal", "fa fa-edit"],
                ],
                "default" => [
                    ["champ" => "etat","val" => ["0" => ["gestion/affecte/","fa fa-toggle-off"],"1" => ["gestion/desaffecte/", "fa fa-toggle-on"]]],
                    ["gestion/desaffecter/", "fa fa-arrows-alt"],
                   // ["gestion/detailAffectMateriel/", "fa fa-search"],
                ]
                //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
            ],
            "tooltip" => [
                "modal" => [$this->lang['modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],
                "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['desaffecter']]
            ],
            "classCss" => [
                "modal" => [],
                "default" => ["confirm"]
            ],
            "attribut" => [],
            "args" =>  $this->_USER,
            "dataVal" => [
                ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"],"2" => ["<i class='text-success'>".$this->lang['desaffecter']."</i>"]]]
            ],
            "fonction" => [
                "date_debut_affect" => "getDateFR",
                "date_fin_affect" => "getDateFR",
            ]
        ];
        $this->processing($this->gestionModels, 'getAllAffectMateriel', $param);


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
        $this->processing($this->gestionModels, 'getAllAffectMateriel', $param);


    }

}
    public function affecte()
    {

        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gestionModels->updateAffectMateriel(["champs" => ["etat" => 1], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_affecte_materiel"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_affecte_materiel"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_affecte_materiel"]]);
        Utils::redirect("gestion", "affectMateriel");
    }

    public function desaffecte()
    {
        //var_dump($this->paramGET[0]); exit;
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gestionModels->updateAffectMateriel(["champs" => ["etat" => 0], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success",  $this->lang["succes_desaffecte_materiel"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desaffecte_materiel"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desaffecte_materiel"]]);
        Utils::redirect("gestion", "affectMateriel");
    }

    public function ajoutAffectMaterielModal()
    {



        $data['receveur'] = $this->gestionModels->getReceveursDisponible();

        $data['materiel'] = $this->gestionModels->getMaterielsDisponible($this->_USER->gie);

        $data['bus'] = $this->gestionModels->getBusDisponible($this->_USER->gie);

        $data['trajet'] = $this->gestionModels->getTrajet($this->_USER->gie);

        $data['carteReceveur'] = $this->gestionModels->getCarteReceveur();

        $data['carteChauffeur'] = $this->gestionModels->getCarteChauffeur();

        $data['chauffeur'] = $this->gestionModels->getChauffeursDisponible($this->_USER->gie);

        $this->views->setData($data);
        //$data['employe'] = $this->employeModels->getChauffeur();
        //$this->views->setData($data);
        $this->modal();
    }
    public function ajoutAffectMaterielAncienModal()
    {



        $data['receveur'] = $this->gestionModels->getReceveur2($this->_USER->gie);

        $data['materiel'] = $this->gestionModels->getMateriel2($this->_USER->gie);

        $data['bus'] = $this->gestionModels->getBus2($this->_USER->gie);

        $data['trajet'] = $this->gestionModels->getTrajet($this->_USER->gie);

        $data['carteReceveur'] = $this->gestionModels->getCarteReceveur();

        $data['carteChauffeur'] = $this->gestionModels->getCarteChauffeur();

        $data['chauffeur'] = $this->gestionModels->getChauffeur($this->_USER->gie);

        $this->views->setData($data);
        //$data['employe'] = $this->employeModels->getChauffeur();
        //$this->views->setData($data);
        $this->modal();
    }



    /**
     * @droit Add devices assignements - 2
     */
    public function insertAffectMateriel__()
    {
        try{

            $this->gestionModels->__beginTransaction() ;

            $device = explode('-' ,$this->paramPOST['materiel']);
            $trajet_id = $this->paramPOST['trajet_id'];
            $chauffeur_id = $this->paramPOST['chauffeur_id'];
            $id_carte_receveur = $this->paramPOST['id_carte_receveur'];
            $id_carte_chauffeur = $this->paramPOST['id_carte_chauffeur'];

            if (!(count($device) == 2))
                throw new \Exception($this->lang["device_required"]) ;

            $affectatationData = [] ;
            $affectatationData['trajet_id'] = $trajet_id ;
            $affectatationData['chauffeur_id'] = $this->paramPOST['chauffeur_id'] ;
            $affectatationData['id_carte_chauffeur'] = $this->paramPOST['id_carte_chauffeur'] ;
            $affectatationData['id_carte_receveur'] = $this->paramPOST['id_carte_receveur'] ;
            $affectatationData['bus_id'] = $this->paramPOST['bus_id'] ;
            $affectatationData['receveur_id'] = $this->paramPOST['receveur_rowid'] ;
            $affectatationData['device_id'] = $device[0] ;
            $affectatationData['date_debut'] = Utils::date_aaaa_mm_jj($this->paramPOST['date_debut_affect']) ;
            $affectatationData['date_fin'] = Utils::date_aaaa_mm_jj($this->paramPOST['date_fin_affect']) ;
            $affectatationData['date_creation'] = date('Y-m-d H:i:s') ;
            $affectatationData['etat'] = 1 ;
            $affectatationData['gie'] = $this->_USER->gie ;
            $affectatationData['user_creation'] = $this->_USER->id ;


            $resultInsertAffectation = $this->gestionModels->insertAffectMateriel(["champs" => $affectatationData]);
            if (!($resultInsertAffectation))
                throw new \Exception('Table bus_affectaion: Erreur insertion') ;


            $voyageData = [] ;
            $voyageData['conducteur_id'] = $chauffeur_id  ;
            $voyageData['bus_id'] = $this->paramPOST['bus_id']  ;
            $voyageData['receveur_id'] = $this->paramPOST['receveur_rowid']  ;
            $voyageData['date_voyage'] = date("Y-m-d H:i:s")  ;
            $voyageData['num_voyage'] = $this->gestionModels->Generer_numtransaction()  ;
            $voyageData['user_creation'] = $this->_USER->id  ;
            $voyageData['date_creation'] = date('Y-m-d H:i:s')  ;
            $voyageData['trajet_id'] = $trajet_id  ;
            $voyageData['affectation_id'] = $resultInsertAffectation  ;

            $resultInsertVoyage = $this->gestionModels->insertVoyage(["champs" => $voyageData]);
            if (!($resultInsertVoyage))
                throw new \Exception('Table voyage: Erreur insertion') ;

            $resultUpdateCarteReceveur = $this->gestionModels->updateCarteReceveurChauffeur($this->paramPOST['receveur_rowid'],$id_carte_receveur);
            if (!($resultUpdateCarteReceveur))
                throw new \Exception('Table carte_receveur_chauffeur: modification carte receveur') ;


            $resultUpdateCarteChauffeur = $this->gestionModels->updateCarteReceveurChauffeur($chauffeur_id, $id_carte_chauffeur);
            if (!($resultUpdateCarteChauffeur))
                throw new \Exception('Table carte_receveur_chauffeur: modification carte chauffeur') ;

            $resultUpdateDevice = $this->gestionModels->updateDevice($this->paramPOST['receveur_rowid'],$device[0]);
            if (!($resultUpdateDevice))
                throw new \Exception('Table devices: modification device') ;


            $resultUpdateBus = $this->gestionModels->set(["table"=>"bus", "champs"=>["affecte_to = "=>$chauffeur_id], "condition"=>["id ="=>$this->paramPOST['bus_id']]]);
            if (!($resultUpdateBus))
                throw new \Exception('Echec update dans bus') ;


            $resultUpdateUserReceveur = $this->gestionModels->set(["table"=>"utilisateur", "champs"=>["uuid = "=>$device[1],"activite="=>1], "condition"=>["id ="=>$this->paramPOST['receveur_rowid']]]);

            if (!($resultUpdateUserReceveur))
                throw new \Exception('Echec update dans utilisateur: receveur');


            $resultUpdateUserChauffeur = $this->gestionModels->set(["table"=>"utilisateur", "champs"=>["activite="=>1], "condition"=>["id ="=>$this->paramPOST['chauffeur_id']]]);

            if (!($resultUpdateUserChauffeur))
                throw new \Exception('Echec update dans utilisateur: chauffeur');


            $this->gestionModels->__commit() ;

            Utils::setMessageALert(["success", $this->lang["succes_update_affectation"]]);

        }catch (\Exception $ex){
            $this->gestionModels->__rollBack() ;
            Utils::setMessageALert(["danger", $this->lang["echec_add_affecte"]." ".$ex->getMessage()]);
        }


        Utils::redirect("gestion", "affectMateriel");

    }

    public function removeAffectMateriel()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gestionModels->deleteAffectMateriel(["condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_affecte"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_affecte"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_affecte"]]);
        Utils::redirect("gestion", "affectMateriel");
    }

    public function modifAffectMaterielModal()

    {
        $data['receveur'] = $this->gestionModels->getReceveursDisponible();

        $data['materiel'] = $this->gestionModels->getMaterielsDisponible($this->_USER->gie);

        $data['bus'] = $this->gestionModels->getBusDisponible($this->_USER->gie);

        $data['trajet'] = $this->gestionModels->getTrajet($this->_USER->gie);

        $data['carteReceveur'] = $this->gestionModels->getCarteReceveur();

        $data['carteChauffeur'] = $this->gestionModels->getCarteChauffeur();

        $data['chauffeur'] = $this->gestionModels->getChauffeursDisponible($this->_USER->gie);



        //var_dump("salut");die();

        $id = $this->paramGET[2];
        $data['affectation'] = $this->gestionModels->getAffectMateriel($id)[0];
        $this->views->setData($data);
        $this->modal();

    }

    public function modifierAffectMateriel()
    {
        //echo "<pre>"; var_dump($this->paramPOST);die();


        try{
            $this->gestionModels->__beginTransaction();
            $device = explode('-' ,$this->paramPOST['materiel']);
            $chauffeur_id = $this->paramPOST['chauffeur_id'];
            $receveur_id = $this->paramPOST['receveur_id'];
            $id_carte_receveur = $this->paramPOST['id_carte_receveur'];
            $id_carte_chauffeur = $this->paramPOST['id_carte_chauffeur'];
            $trajet_id = $this->paramPOST['trajet_id'];
            $bus_id = $this->paramPOST['bus_id'];
            $this->paramPOST['etat']= 1 ;

            $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
            $rowid= $this->paramPOST['rowid'];
            unset($this->paramPOST['rowid'],$this->paramPOST['trajet_id']);
            $data['champs'] = $this->paramPOST;
            $result = $this->gestionModels->updateAffectMateriel($data);


            if ($result !== false){
                unset($this->paramPOST['date_debut'], $this->paramPOST['date_fin'],$this->paramPOST['device_id'], $this->paramPOST['id_carte_receveur'],$this->paramPOST['id_carte_chauffeur'], $this->paramPOST['etat']);

                $resultUpdateVoyage = $this->gestionModels->updateVoyage(["champs" =>['conducteur_id' =>$chauffeur_id,'bus_id' => $bus_id, 'receveur_id' =>$receveur_id,'trajet_id' =>$trajet_id], "condition" =>["affectation_id = " => $rowid]]);
                if (!($resultUpdateVoyage))
                    throw new \Exception('Table voyage: modification voyage') ;

                $resultUpdateCarteReceveur = $this->gestionModels->updateCarteReceveurChauffeur($receveur_id,$id_carte_receveur);
                if (!($resultUpdateCarteReceveur))
                    throw new \Exception('Table carte_receveur_chauffeur: modification carte receveur') ;


                $resultUpdateCarteChauffeur = $this->gestionModels->updateCarteReceveurChauffeur($chauffeur_id, $id_carte_chauffeur);
                //var_dump($resultUpdateCarteChauffeur);die();
                if (!($resultUpdateCarteChauffeur))
                    throw new \Exception('Table carte_receveur_chauffeur: modification carte chauffeur') ;

                $resultUpdateDevice = $this->gestionModels->updateDevice($receveur_id,$device[0]);
                if (!($resultUpdateDevice))
                    throw new \Exception('Table devices: modification device') ;


                $resultUpdateBus = $this->gestionModels->set(["table"=>"bus", "champs"=>["affecte_to = "=>$chauffeur_id], "condition"=>["id ="=>$bus_id]]);
                if (!($resultUpdateBus))
                    throw new \Exception('Echec update dans bus') ;


                $resultUpdateUserReceveur = $this->gestionModels->set(["table"=>"utilisateur", "champs"=>["uuid = "=>$device[1],"activite="=>1], "condition"=>["id ="=>$receveur_id]]);

                if (!($resultUpdateUserReceveur))
                    throw new \Exception('Echec update dans utilisateur: receveur');


                $resultUpdateUserChauffeur = $this->gestionModels->set(["table"=>"utilisateur", "champs"=>["activite="=>1], "condition"=>["id ="=>$chauffeur_id]]);

                if (!($resultUpdateUserChauffeur))
                    throw new \Exception('Echec update dans utilisateur: chauffeur');


                $this->gestionModels->__commit() ;

                Utils::setMessageALert(["success", $this->lang["succes_update_affectation"]]);


                //$result2 = $this->gestionModels->updateVoyage(["champs" =>['conducteur_id' =>$this->paramPOST['chauffeur_id'],'bus_id' => $this->paramPOST['bus_id'], 'receveur_id' =>$this->paramPOST['receveur_id'],'trajet_id' =>$trajet_id], "condition" =>["affectation_id = " => $rowid]]);
                //$result3 = $this->gestionModels->updateCarteReceveurChauffeur($this->paramPOST['receveur_rowid'],$id_carte_receveur);
                //$result4 = $this->gestionModels->updateCarteReceveurChauffeur($chauffeur_id,$id_carte_chauffeur);
                //$result5 = $this->gestionModels->updateDevice($this->paramPOST['receveur_rowid'],$device[0]);



                Utils::setMessageALert(["success", $this->lang["succes_update_affectation"]]);

            }
            else{
                Utils::setMessageALert(["danger", $this->lang["echec_update_affectation"]]);
            }

        }catch (\Exception $e){
            $this->gestionModels->__rollBack() ;
            Utils::setMessageALert(["danger", $this->lang["echec_update_affectation"]]);
        }


        Utils::redirect("gestion", "affectMateriel");
    }



    /**
     * @droit List card staff - 2
     */
    public function listeCarteEmploye()
    {

        $this->views->getTemplate("gestion/listeCarteEmploye");
    }

    public function carteEmployeModal()
    {

        $this->modal();
    }

    public function listeCarteProcessing()
    {

            $param = [

                "button" => [
                    "modal" => [
                        ["gestion/modifCarteEmployeModal", "gestion/modifCarteEmployeModal", "fa fa-edit"]
                    ],
                    "default" => [
                        ["champ" => "etat","val" => ["0" => ["gestion/activateCarte/","fa fa-toggle-off"],"1" => ["gestion/desactivateCarte/", "fa fa-toggle-on"]]],
                        ["gestion/removeCarteEmploye/", "fa fa-trash"],

                    ]
                ],
                "tooltip" => [
                    "modal" => [$this->lang['modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],
                    "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['Supprimer'],$this->lang['Detail']]
                ],
                "classCss" => [
                    "modal" => [],
                    "default" => ["confirm","confirm"]
                ],
                "attribut" => [],
                "args" =>  $this->_USER,
                "dataVal" => [
                    ["champ" => "type", "val" => ["1" => ["<i class='text-warning'>".$this->lang['carte_receveur']." </i>"], "2" => ["<i class='text-success'>".$this->lang['carte_chauffeur']."</i>"]]],
                    ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
                ],
                "fonction" => [
                    "id_user"=>"getAffecteUser",
                ]
            ];
            $this->processing($this->gestionModels, 'getListeCarte', $param);



    }

    /**
     * @droit Add card staff - 2
     */
        public function insertCarteEmploye()
        {
            $result = $this->gestionModels->insertCarteEmploye(["champs" => $this->paramPOST]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["carte_employe_add_succes"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_carte_employe"]]);
            Utils::redirect("gestion", "listeCarteEmploye");

        }


        public function modifCarteEmployeModal()

        {
            $data['carte'] = $this->gestionModels->getCarteEmploye(["condition" => ["id = " => $this->paramGET[2]]])[0];
            $this->views->setData($data);
            $this->modal();

        }


    /**
     * @droit Update card staff - 2
     */
    public function modifierCarteEmploye()
    {
        //var_dump($this->paramPOST); die();

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];

        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;

        $result = $this->gestionModels->updateCarteEmploye($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_operation_element"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_operation_element"]]);
        Utils::redirect("gestion", "listeCarteEmploye");
    }


    /**
     * @droit Remove card staff - 2
     */
    public function removeCarteEmploye()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gestionModels->deleteCarte(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_carte"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_carte"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_carte"]]);
        Utils::redirect("gestion", "listeCarteEmploye");
    }

    /**
     * @droit On card staff - 2
     */
    public function activateCarte()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gestionModels->updateCarteEmploye(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_carte"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_carte"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_carte"]]);
        Utils::redirect("gestion", "listeCarteEmploye");
    }

    /**
     * @droit Off card staff - 2
     */
    public function desactivateCarte()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gestionModels->updateCarteEmploye(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_carte"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_carte"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_carte"]]);
        Utils::redirect("gestion", "listeCarteEmploye");
    }

    public function desaffecter()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gestionModels->getAffectMateriel($this->paramGET[0])[0];
        }
        else {
            Utils::setMessageALert(["danger", $this->lang["echec_add_affecte"]]);
        }


        $id_affectation = $result->rowid;
        $receveur_id = $result->receveur_id;
        $bus_id = $result->bus_id;
        $device_id = $result->device_id;
        $chauffeur_id = $result->chauffeur_id;
        $id_carte_chauffeur = $result->id_carte_chauffeur;
        $id_carte_receveur = $result->id_carte_receveur;

        try{

        $this->gestionModels->__beginTransaction() ;

            $resultUpdateVoyage = $this->gestionModels->updateAffectationBus($id_affectation);
            if (!($resultUpdateVoyage))
                throw new \Exception('Table voyage: modification voyage') ;



            $resultUpdateVoyage = $this->gestionModels->updateAffectationVoyage($id_affectation);
            if (!($resultUpdateVoyage))
                throw new \Exception('Table affectation_bus: modification voyage') ;


            $resultUpdateCarteReceveur = $this->gestionModels->updateCarteReceveurChauffeur("",$id_carte_receveur);
            if (!($resultUpdateCarteReceveur))
                throw new \Exception('Table carte_receveur_chauffeur: modification carte receveur') ;


        $resultUpdateCarteChauffeur = $this->gestionModels->updateCarteReceveurChauffeur("", $id_carte_chauffeur);
        if (!($resultUpdateCarteChauffeur))
            throw new \Exception('Table carte_receveur_chauffeur: modification carte chauffeur') ;

        $resultUpdateDevice = $this->gestionModels->updateDevice("",$device_id);
        if (!($resultUpdateDevice))
            throw new \Exception('Table devices: modification device') ;


        $resultUpdateBus = $this->gestionModels->set(["table"=>"bus", "champs"=>["affecte_to = "=>""], "condition"=>["id ="=>$bus_id]]);
        if (!($resultUpdateBus))
            throw new \Exception('Echec update dans bus') ;


        $resultUpdateUserReceveur = $this->gestionModels->set(["table"=>"utilisateur", "champs"=>["activite="=>0], "condition"=>["id ="=>$receveur_id]]);

        if (!($resultUpdateUserReceveur))
            throw new \Exception('Echec update dans utilisateur: receveur');


        $resultUpdateUserChauffeur = $this->gestionModels->set(["table"=>"utilisateur", "champs"=>["activite="=>0], "condition"=>["id ="=>$chauffeur_id]]);

        if (!($resultUpdateUserChauffeur))
            throw new \Exception('Echec update dans utilisateur: chauffeur');


        $this->gestionModels->__commit() ;

        Utils::setMessageALert(["success", $this->lang["succes_update_affectation"]]);

        }catch (\Exception $ex){
       $this->gestionModels->__rollBack() ;
    Utils::setMessageALert(["danger", $this->lang["echec_add_affecte"]." ".$ex->getMessage()]);
    }


        Utils::redirect("gestion", "affectMateriel");
    }



}






