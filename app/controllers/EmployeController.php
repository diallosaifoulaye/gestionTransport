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
use app\models\ControleurModel;
use app\models\EmployeModel;
use app\models\ReceveurModel;

class EmployeController extends BaseController
{
    private $employeModels;


    public function __construct()
    {

        parent::__construct();
        $this->employeModels = new EmployeModel();
        $this->receveurModels = new ReceveurModel();
        $this->controleurModels = new ControleurModel();


        //var_dump($this->_USER);die;

        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_admin"]);

    }

    public function index__()
    {
        $this->views->getTemplate('administration/admin');

    }



    /**************************************************************** DEBUT EMPLOYE ******************************************************************/

    /*********************** DEBUT Gestion des CHauffeur ************************/

    // Ajout Droit
    public function ajoutChauffeurModal()
    {
        //$data['employe'] = $this->employeModels->getChauffeur();
        //$this->views->setData($data);
        $this->modal();
    }

    // Ajout Droit
    public function insertChauffeur__()
    {
  // var_dump($this->paramPOST);die;
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
        $this->paramPOST['numGie'] = $this->_USER->gie;

        $result = $this->employeModels->insertChauffeur(["champs" => $this->paramPOST]);

        if ($result !== false) Utils::setMessageALert(["success", $this->lang["Chauffeur_ajouté_avec_succes"]]);
        else Utils::setMessageALert(["danger", $this->lang["Echec_de_lajout_du_chauffeur"]]);
        Utils::redirect("employe", "listeChauffeur");

    }

    // Modification Droit
    public function modifChauffeurModal()

    {//var_dump($this->paramGET[2]);die();
        $data['employe'] = $this->employeModels->getChauffeur(["condition" => ["id = " => $this->paramGET[2]]])[0];
       // $data['module'] = $this->moduleModels->getModule();

        $this->views->setData($data);
        $this->modal();

    }

    // Update Droit
    public function updateChauffeur()
    {
        //parent::validateToken("administration", "listeDroit");
        //var_dump($this->paramPOST['id']);die();
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];

        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;

        $result = $this->employeModels->updateChauffeur($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_chauffeur"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_chauffeur"]]);
        Utils::redirect("employe", "listeChauffeur");
    }
    public function updateChauffeurDetail()
    {
        //parent::validateToken("administration", "listeDroit");
        //var_dump($this->paramPOST['id']);die();
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->employeModels->updateChauffeurDetail($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_chauffeur"]]);
        else Utils::setMessageALert(["danger",$this->lang["echec_update_chauffeur"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("employe", "detailChauffeur");
        }else{Utils::redirect("employe",  "detailChauffeur"."/".$id);}
    }
    // Supression droit
    public function removeChauffeur()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->employeModels->deleteChauffeur(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_chauffeur"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_chauffeur"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_chauffeur"]]);
        Utils::redirect("employe", "listeChauffeur");
    }

    //  Liste droit
    public function listeChauffeur__()
    {
        $this->views->getTemplate("employe/listeChauffeur");
    }

    // Processing Droit
    public function listeChauffeurPro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1  || \app\core\Utils::getModel('employe')->__authorized($this->_USER->idprofil, 'employe', 'modifChauffeurModal') > 0) {
                $param = [

                "button" => [
                        "modal" => [
                            ["employe/modifChauffeurModal", "employe/modifChauffeurModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["employe/activateChauffeur/","fa fa-toggle-off"],"1" => ["employe/deactivateChauffeur/", "fa fa-toggle-on"]]],
                            ["employe/removeChauffeur/", "fa fa-trash"],
                            ["employe/detailChauffeur/", "fa fa-search"],
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
                    "args" =>  $this->_USER,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
                    ],
                    "fonction" => []
                ];
                $this->processing($this->employeModels, 'getAllChauffeur', $param);


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
                $this->processing($this->employeModels, 'getAllChauffeur', $param);


            }

        }
    }

    public function detailChauffeur(){

        $etat = 1;

        $data['employe'] = $this->employeModels->getOneChauffeur(["condition" => ["e.id = " => $this->paramGET[0]]]);
        ///var_dump($this->paramGET[0]);die();

        $this->views->setData($data);
        $this->views->getTemplate('employe/detailChauffeur');

    }


    // Activation droit
    public function activateChauffeur()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->employeModels->updateChauffeur(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_chauffeur"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_chauffeur"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_chauffeur"]]);
        Utils::redirect("employe", "listeChauffeur");
    }

    // Desactivation droit
    public function deactivateChauffeur()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->employeModels->updateChauffeur(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_chauffeur"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_chauffeur"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_chauffeur"]]);
        Utils::redirect("employe", "listeChauffeur");
    }
    public function updateChauffeurUser()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->employeModels->updateChauffeur($data);
        if ($result !== false) Utils::setMessageALert(["success",  $this->lang["succes_desactivate_chauffeur"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_chauffeur"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("employe", "detailChauffeur");
        }else{Utils::redirect("employe",  "detailChauffeur"."/".$id);}
    }
    public function updateEtatChauffeur()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->employeModels->updateChauffeur($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_chauffeur"]]);
        else Utils::setMessageALert(["danger",  $this->lang["echec_activate_chauffeur"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("employe", "detailChauffeur");
        }else{Utils::redirect("employe",  "detailChauffeur"."/".$id);}
    }

    // Update utilisateur
    public function updatePhotoChauffeur()
    {
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $dossier_photo = ROOT."assets/pictures/";
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

        $rst= $this->employeModels->updatePhotoChauffeur($data);
        //var_dump($rst);
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
        Utils::redirect('employe', "detailChauffeur"."/".$id);
    }

    /*********************** FIN Gestion des Chauffeurs*********************/


       /************************ Gestion des Receveurs  **********************/
    // Modal Ajout Receveur

    public function ajoutReceveurModal()
    {

//        $data['employe'] = $this->employeModels->getReceveur();
        $data['profil'] = $this->receveurModels->getProfil();
        $data['idGIE'] = $this->_USER->gie;
        $this->views->setData($data);
        $this->modal();
    }

    // Ajout Receveur
    public function ajoutReceveur__()
    {
        //var_dump($this->paramPOST);die;
        $pass['pass'] = "Passer@2019";
        //$pass = Utils::getGeneratePassword(12);
        $pwd = $pass['pass'];
        $this->paramPOST["password"] = sha1($pwd);
        $prenom = $this->paramPOST["prenom"];
        $nom = $this->paramPOST["nom"];
        $email = $this->paramPOST["email"];
        $login = $this->paramPOST["login"];


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
        $this->paramPOST['gie'] = $this->_USER->gie;
        $this->paramPOST['type'] = 3;

        if (Utils::validateMail($this->paramPOST["email"])) {

            if (!$this->receveurModels->VerifEmail(['utilisateur', 'email'], $this->paramPOST["email"])) {

                $this->paramPOST["user_creation"]= $this->_USER->id;
                $result = $this->employeModels->insertReceveur(["champs" => $this->paramPOST]);

                if ($result !== false){
                    Utils::envoiparametre($prenom.' '.$nom, $email, $login, $pwd);
                    Utils::setMessageALert(["success", $this->lang["receveur_ajouté_avec_succes"]]);
                }

                else Utils::setMessageALert(["danger", $this->lang["Echec_de_lajout_du_receveur"]]);

            } else Utils::setMessageALert(["danger", $this->lang["email_existe"]]);


        } else Utils::setMessageALert(["warning", $this->lang["emailInvalide"]]);

        Utils::redirect("employe", "listeReceveur");

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

    // Modification Droit
    public function modifReceveurModal()

    {//var_dump($this->paramGET[2]);die();
        $data['utilisateur'] = $this->receveurModels->getReceveur(["condition" => ["id = " => $this->paramGET[2]]])[0];

        // $data['module'] = $this->moduleModels->getModule();

        $this->views->setData($data);
        $this->modal();

    }

    // Update Droit
    public function updateReceveur()
    {
        //parent::validateToken("administration", "listeDroit");
//var_dump($this->paramPOST['id']);die();
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];

        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;

        $result = $this->receveurModels->updateReceveur($data);
        if ($result !== false) Utils::setMessageALert(["success",$this->lang["succes_update_receveur"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_receveur"]]);
        Utils::redirect("employe", "listeReceveur");
    }


    public function updateReceveurDetail()
    {
        //parent::validateToken("administration", "listeDroit");
        //var_dump($this->paramPOST['id']);die();
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->receveurModels->updateReceveurDetail($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_receveur"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_receveur"]]);
        if($this->paramGET[0]=="r"){Utils::redirect("employe", "detailReceveur"."/".$id);
        }else{Utils::redirect("employe",  "detailReceveur"."/".$id);}
    }
    // Supression droit
    public function removeReceveur()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->receveurModels->deleteReceveur(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_receveur"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_receveur"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_receveur"]]);
        Utils::redirect("employe", "listeReceveur");
    }

    //  Liste droit
    public function listeReceveur__()
    {
        $this->views->getTemplate("employe/listeReceveur");
    }

    // Processing Droit
    public function listeReceveurPro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('receveur')->__authorized($this->_USER->idprofil, 'receveur', 'modifReceveurModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["employe/modifReceveurModal", "employe/modifReceveurModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["employe/activateReceveur/","fa fa-toggle-off"],"1" => ["employe/deactivateReceveur/", "fa fa-toggle-on"]]],
                            ["employe/removeReceveur/", "fa fa-trash"],
                            ["employe/detailReceveur/", "fa fa-search"],
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
                $this->processing($this->receveurModels, 'getAllReceveur', $param);


//            } else {
//                $param = [
//                    "button" => [
//                        "modal" => [],
//                        "default" => []
//                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
//                    ],
//                    "tooltip" => [],
//                    "classCss" => [
//                        "modal" => [],
//                        "default" => ["confirm"]
//                    ],
//                    "attribut" => [],
//                    "args" => null,
//                    "dataVal" => [],
//                    "fonction" => []
//                ];
//                $this->processing($this->employeModels, 'getAllReceveur', $param);
//
//
//            }

        }
    }
    }


    public function detailReceveur(){

        $etat = 1;
        $data['user'] = $this->receveurModels->getOneReceveur(["condition" => ["u.id = " => $this->paramGET[0]]]);
        $data['profil'] = $this->receveurModels->getProfil(["condition" => ["etat = " => $etat]]);
        //echo '<pre>'; var_dump($data['user']);die();
        $this->views->setData($data);
        $this->views->getTemplate('employe/detailReceveur');

    }
    public function updatePhotoReceveur()
    {
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $dossier_photo = ROOT."assets/pictures/";
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

        $rst= $this->receveurModels->updatePhotoReceveur($data);

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
        Utils::redirect('employe', "detailReceveur"."/".$id);
    }
    public function updateEtatReceveur()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->receveurModels->updateReceveur($data);
        if ($result !== false) Utils::setMessageALert(["success",  $this->lang["succes_update_receveur"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_receveur"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("employe", "detailReceveur");
        }else{Utils::redirect("employe",  "detailReceveur"."/".$id);}
    }


    // Activation droit
    public function activateReceveur()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->receveurModels->updateReceveur(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_receveur"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_receveur"]]);
        } else Utils::setMessageALert(["danger",  $this->lang["echec_activate_receveur"]]);
        Utils::redirect("employe", "listeReceveur");
    }

    // Desactivation droit
    public function deactivateReceveur()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->receveurModels->updateReceveur(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_receveur"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_receveur"]]);
        } else Utils::setMessageALert(["danger",$this->lang["echec_desactivate_receveur"]]);
        Utils::redirect("employe", "listeReceveur");
    }
    /******************** FIN Gestion Receveur ******************************/

    /************************ Gestion des Controleurs  **********************/
    // Modal Ajout Controleur

    public function ajoutControleurModal()
    {
        $data['employe'] = $this->employeModels->getControleur();
        $this->views->setData($data);
        $this->modal();
    }

    // Ajout Controleur
    public function ajoutControleur()
    {
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
        $this->paramPOST['numGie'] = $this->_USER->gie;

        $result = $this->controleurModels->insertControleur(["champs" => $this->paramPOST]);

        if ($result !== false) Utils::setMessageALert(["success", $this->lang['controleurAjoute']]);
        else Utils::setMessageALert(["danger", "Echec_d'ajout_du_controleur"]);
        Utils::redirect("employe", "listeControleur");

    }

    // Modification Droit
    public function modifControleurModal()

    {
        $data['controleur'] = $this->controleurModels->getControleur(["condition" => ["id = " => $this->paramGET[2]]])[0];
        // $data['module'] = $this->moduleModels->getModule();

        $this->views->setData($data);
        $this->modal();

    }

    // Update Droit
    public function updateControleur()
    {
        //parent::validateToken("administration", "listeDroit");
//var_dump($this->paramPOST['id']);die();
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];

        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;

        $result = $this->controleurModels->updateControleur($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_controleur"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_controleur"]]);
        Utils::redirect("employe", "listeControleur");
    }
    public function updateControleurDetail()
    {
        //parent::validateToken("administration", "listeDroit");
        //var_dump($this->paramPOST['id']);die();
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->controleurModels->updateControleurDetail($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_controleur"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_controleur"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("employe", "detailControleur");
        }else{Utils::redirect("employe",  "detailControleur"."/".$id);}
    }
    public function updatePhotoControleur()
    {
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $dossier_photo = ROOT."assets/pictures/";
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

        $rst= $this->controleurModels->updatePhotoControleur($data);

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
        Utils::redirect('employe', "detailControleur"."/".$id);
    }

    // Supression droit
    public function removeControleur()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->controleurModels->deleteControleur(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_controleur"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_controleur"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_controleur"]]);
        Utils::redirect("employe", "listeControleur");
    }

    //  Liste droit
    public function listeControleur__()
    {
        $this->views->getTemplate("employe/listeControleur");
    }

    // Processing Droit
    public function listeControleurPro()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('employe')->__authorized($this->_USER->idprofil, 'employe', 'modifControleurmodal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["employe/modifControleurModal", "employe/modifControleurModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["employe/activateControleur/","fa fa-toggle-off"],"1" => ["employe/deactivateControleur/", "fa fa-toggle-on"]]],
                            ["employe/removeControleur/", "fa fa-trash"],
                            ["employe/detailControleur/", "fa fa-search"],
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
                $this->processing($this->controleurModels, 'getAllControleur', $param);


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
                $this->processing($this->employeModels, 'getAllControleur', $param);


            }

        }
    }

    public function detailControleur(){

        $data['controleur'] = $this->controleurModels->getOneControleur(["condition" => ["c.id = " => $this->paramGET[0]]]);
        //var_dump($data['controleur']);die();

        $this->views->setData($data);
        $this->views->getTemplate('employe/detailControleur');
    }
    public function updateEtatControleur()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->controleurModels->updateControleur($data);
        if ($result !== false) Utils::setMessageALert(["success",$this->lang["succes_update_controleur"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_controleur"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("employe", "detailControleur");
        }else{Utils::redirect("employe",  "detailControleur"."/".$id);}
    }

    // Activation droit
    public function activateControleur()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->controleurModels->updateControleur(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_controleur"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_controleur"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_controleur"]]);
        Utils::redirect("employe", "listeControleur");
    }

    // Desactivation droit
    public function deactivateControleur()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->controleurModels->updateControleur(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_controleur"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_controleur"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_controleur"]]);
        Utils::redirect("employe", "listeControleur");
    }
    /******************** FIN Gestion Controleur ******************************/


    /**************************************************************** FIN PARAMETRAGE ******************************************************************/





}