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

class AdministrationController extends BaseController
{
    private $utilisateurModels;
    private $profilModels;
    private $droitModels;
    private $typeprofilModels;
    private $moduleModels;
    private $paysModels;
    private $fournisseurModels;
    private $apifournisseurModels;
    private $webserviceModels;
    private $coderetourModels;
    private $categorieServiceModels;
    private $serviceModels;
    private $disponibiliteModels;
    private $messageModels;
    private $typeWebServiceModels;
    private $typeInterconnexionModels;

    private $tariffraisModels;
    private $erreurwebserviceModels;
    private $partenaireModels;
    private $parametreModels;

    private $sidebar;

    public function __construct()
    {

        parent::__construct();
        $this->utilisateurModels = $this->model("utilisateur");
        $this->droitModels = $this->model("droit");
        $this->profilModels = $this->model("profil");
        $this->typeprofilModels = $this->model("typeprofil");
        $this->moduleModels = $this->model("module");
        $this->paysModels = $this->model("pays");
        $this->fournisseurModels = $this->model("fournisseur");
        $this->apifournisseurModels = $this->model("apifournisseur");
        $this->webserviceModels = $this->model("webservice");
        $this->coderetourModels = $this->model("coderetour");
        $this->categorieServiceModels = $this->model("categorieService");
        $this->serviceModels = $this->model("service");
        $this->disponibiliteModels = $this->model("disponibilite");
        $this->messageModels = $this->model("message");
        $this->typeWebServiceModels = $this->model("typeWebService");
        $this->typeInterconnexionModels = $this->model("typeinterconnexion");

        $this->tariffraisModels = $this->model("tariffrais");
        $this->erreurwebserviceModels = $this->model("erreurwebservice");
        $this->partenaireModels = $this->model("partenaire");
        $this->parametreModels = $this->model("parametre");

        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_admin"]);

    }

    public function index__()
    {
        $this->views->getTemplate('administration/admin');

    }


    /**************************************************************** DEBUT UTILISATEURS ET PROFILS ********************************************************/

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
    public function profilUser()
    {
        $etat =1;
        $data['allProfil'] = $this->profilModels->AllProfil(["condition" => ["etat = " => $etat]]);
        $data['user'] = $this->utilisateurModels->getOneUtilisateur(["condition" => ["u.id = " => $this->_USER->id]]);
        $this->views->setData($data);
        $this->views->getTemplate('administration/profilUser');
    }

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

    // Liste utilisateur
    public function listeUtilisateur()
    {
        $this->views->getTemplate('administration/listeUtilisateur');
    }

    public function detailUser(){

        $etat = 1;
        $data['user'] = $this->utilisateurModels->getOneUtilisateur(["condition" => ["u.id = " => $this->paramGET[0]]]);
        $data['allProfil'] = $this->profilModels->AllProfil(["condition" => ["etat = " => $etat]]);
        //echo '<pre>'; var_dump($data['user']);die();
        $this->views->setData($data);
        $this->views->getTemplate('administration/detailUser');
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
    }

    /***********************FIN Gestion des utilisateurs*********************/


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
        $this->views->getTemplate("administration/listeProfil");

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
        $this->views->getTemplate("administration/listeGroupe");

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

    /**************************************************************** FIN UTILISATEURS ET PROFILS ********************************************************/




    /**************************************************************** DEBUT PARAMETRAGE ******************************************************************/

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
        $this->views->getTemplate("administration/listeDroit");
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
        $this->views->getTemplate('administration/listeModule');
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


    /******************** DEBUT Gestion Pays *******************************/
    // Liste Pays
    public function listePays()
    {
        $this->views->getTemplate('administration/listePays');
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


    /**************************************************************** FIN PARAMETRAGE ******************************************************************/




    /**************************************************************** DEBUT GESTION DES FOURNISSEURS ***************************************************/

    /*****************  Gestion des Fournisseurs  ************************/
    // Ajout Fournisseur
    public function ajoutFournisseurModal()
    {
        $data['pays'] = $this->paysModels->getPays($param);
        //var_dump($data['pays']); die();
        $this->views->setData($data);
        $this->modal();
    }

    // Ajout Fournisseur
    public function ajoutFournisseur()
    {
        $result = $this->fournisseurModels->insertFournisseur(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_four"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_four"]]);
        Utils::redirect("administration", "listeFournisseur");
    }

    // Modification Fournisseur
    public function modifFournisseurModal()
    {
        $data['four'] = $this->fournisseurModels->getFournisseur(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
        $data['pays'] = $this->paysModels->getPays();
        $this->views->setData($data);
        $this->modal();
    }

    // Update Fournisseur
    public function updateFournisseur()
    {
        //parent::validateToken("administration", "listeFournisseur");

        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        unset($this->paramPOST['rowid']);
        $data['champs'] = $this->paramPOST;
        //var_dump($data['champs']); die();
        $result = $this->fournisseurModels->updateFournisseur($data);
        //var_dump($result); die();
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_four"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_four"]]);
        Utils::redirect("administration", "listeFournisseur");
    }

    // Supression Fournisseur
    public function removeFournisseur()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->fournisseurModels->deleteFournisseur(["condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_four"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_four"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_four"]]);
        Utils::redirect("administration", "listeFournisseur");
    }

    //  Liste Fournisseur
    public function listeFournisseur__()
    {
        $this->views->getTemplate("administration/listeFournisseur");
    }

    // Processing Fournisseur
    public function listeFournisseurPro()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('administration')->__authorized($this->_USER->idprofil, 'administration', 'modifFournisseurModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["administration/modifFournisseurModal", "administration/modifFournisseurModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["administration/activateFournisseur/","fa fa-toggle-off"],"1" => ["administration/deactivateFournisseur/", "fa fa-toggle-on"]]]
                            ,
                            ["administration/detailFournisseur/", "fa fa-eye"]
                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => ["Modifier",["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Desactiver"]]],
                        "default" => [["champ"=>"etat","val"=>["0"=>"Activer","1"=>"Désactiver"]], "Détails"]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm",""]
                    ],
                    "attribut" => [],
                    "args" => null,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>Désactivé</i>"], "1" => ["<i class='text-success'>Activé</i>"]]]
                    ],
                    "fonction" => []
                ];
                $this->processing($this->fournisseurModels, 'getAllFournisseur', $param);


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
                $this->processing($this->fournisseurModels, 'getAllFournisseur', $param);

            }

        }
    }

    // Activation Fournisseur
    public function activateFournisseur()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->fournisseurModels->updateFournisseur(["champs" => ["etat" => 1], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_four"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_four"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_four"]]);
        Utils::redirect("administration", "listeFournisseur");
    }

    // Desactivation Fournisseur
    public function deactivateFournisseur()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->fournisseurModels->updateFournisseur(["champs" => ["etat" => 0], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_four"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_four"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_four"]]);
        Utils::redirect("administration", "listeFournisseur");
    }

    // Détail Fournisseur
    public function detailFournisseur()
    {
        $data['fk_fournisseur'] = $this->paramGET[0];
        $data['service'] = $this->fournisseurModels->getOneFournisseur(["condition" =>["f.rowid = " => $this->paramGET[0]]]);
        $this->views->setData($data);
        $this->views->getTemplate('administration/detailFournisseur');
    }

    /**********************  FIN Gestion des Fournisseurs  **********************/


    /*********************** DEBUT Gestion API Fournisseurs *********************/
    // Ajout API Fournisseur
    public function ajoutApiFournisseurModal()
    {
        $data['fk_fournisseur'] = $this->paramGET[2];
        $data['typewebservice'] = $this->fournisseurModels->getTypeWebservice();
        $data['typeinterconnexion'] = $this->fournisseurModels->getTypeInterconnexion();
        //var_dump($data); die();
        $this->views->setData($data);
        $this->modal();
    }

    // Ajout API Fournisseur
    public function ajoutApiFournisseur()
    {
        $id = base64_encode($this->paramPOST['fk_fournisseur']);
        $dossier_photo = ROOT."app/pictures/";
        $file_photo = basename($_FILES['documentation']['name']);

        if($file_photo != null)
        {
            if (move_uploaded_file($_FILES['documentation']['tmp_name'], $dossier_photo.$file_photo)) //Si la fonction renvoie TRUE, c'est que &ccedil;a a fonctionn&eacute;...
            {
                $info = new \SplFileInfo($file_photo);
                $new_name = date("YmdHis") . '.' . $info->getExtension();
                rename($dossier_photo . $file_photo, $dossier_photo . $new_name);
                $file_photo = $new_name;
            }
            $this->paramPOST['documentation'] = $file_photo;
        }

        //var_dump($this->paramPOST); die();

        $result = $this->apifournisseurModels->insertApiFournisseur(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_api_four"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_api_four"]]);
        Utils::redirect("administration", "detailFournisseur/".$id);
    }

    // Modification API Fournisseur
    public function modifApiFournisseurModal()
    {
        $data['api_four'] = $this->apifournisseurModels->getApiFournisseur(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
        $data['typewebservice'] = $this->fournisseurModels->getTypeWebservice();
        $data['typeinterconnexion'] = $this->fournisseurModels->getTypeInterconnexion();
        $this->views->setData($data);
        $this->modal();
    }

    // Update API Fournisseur
    public function updateApiFournisseur()
    {
        $fk_fournisseur = base64_encode($this->paramPOST['fk_fournisseur']);
        //var_dump($fk_fournisseur); die();
        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        unset($this->paramPOST['rowid']);
        unset($this->paramPOST['fk_fournisseur']);
        $data['champs'] = $this->paramPOST;
        $result = $this->apifournisseurModels->updateApiFournisseur($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_api_four"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_api_four"]]);
        Utils::redirect("administration", "detailFournisseur/".$fk_fournisseur);
    }

    // Supression API Fournisseur
    public function removeApiFournisseur()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->apifournisseurModels->deleteApiFournisseur(["condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_api_four"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_api_four"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_api_four"]]);
        Utils::redirect("administration", "listeApiFournisseur");
    }

    //  Liste API Fournisseur
    public function listeApiFournisseur__()
    {
        $this->views->getTemplate("administration/listeApiFournisseur");
    }

    // Processing API Fournisseur
    public function listeApiFournisseurPro()
    {
        $a = $this->apifournisseurModels->getApiFournisseur(["condition" => ["rowid = " => $this->paramGET[2]]]);

        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('administration')->__authorized($this->_USER->idprofil, 'administration', 'modifApiFournisseurModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["administration/modifApiFournisseurModal", "administration/modifApiFournisseurModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["administration/activateApiFournisseur/","fa fa-toggle-off"],"1" => ["administration/deactivateApiFournisseur/", "fa fa-toggle-on"]]],
                            ["administration/removeApiFournisseur/", "fa fa-eye"],
                            ["administration/detailApiFour/", "fa fa-search"]
                        ]
                        /*,
                        "custom" => ["<a href='".ROOT."app/pictures/".$this."' target='_blank' style='color: red;'><li class='fa fa-eye'></li></a>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]*/
                    ],
                    "tooltip" => [
                        "modal" => ["Modifier",["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Desactiver"]]],
                        "default" => [["champ"=>"etat","val"=>["0"=>"Activer","1"=>"Désactiver"]], "Visualiser la documentation", "Détail"]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm","confirm"]
                    ],
                    "attribut" => [],
                    "args" => $this->paramGET,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>Désactivé</i>"], "1" => ["<i class='text-success'>Activé</i>"]]]
                    ],
                    "fonction" => []
                ];
                $this->processing($this->apifournisseurModels, 'getAllApiFournisseur', $param);


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
                $this->processing($this->apifournisseurModels, 'getAllApiFournisseur', $param);

            }

        }
    }

    // Activation API Fournisseur
    public function activateApiFournisseur()
    {

        $id = base64_encode($this->paramGET[0]);
        $api_fournisseur = $this->apifournisseurModels->getOneApiFournisseur(["condition" => ["a.rowid = " => $this->paramGET[0]]]);
        $fk_fournisseur = base64_encode($api_fournisseur->fk_fournisseur);



        if (intval($this->paramGET[0]) > 0) {
            $result = $this->apifournisseurModels->updateApiFournisseur(["champs" => ["etat" => 1], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_api_four"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_api_four"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_api_four"]]);
        Utils::redirect("administration", "detailFournisseur/".$fk_fournisseur);
    }

    // Desactivation API Fournisseur
    public function deactivateApiFournisseur()
    {
        $api_fournisseur = $this->apifournisseurModels->getOneApiFournisseur(["condition" => ["a.rowid = " => $this->paramGET[0]]]);
        $fk_fournisseur = base64_encode($api_fournisseur->fk_fournisseur);
        $id = base64_encode($this->paramGET[0]);
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->apifournisseurModels->updateApiFournisseur(["champs" => ["etat" => 0], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_api_four"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_api_four"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_api_four"]]);
        Utils::redirect("administration", "detailFournisseur/".$fk_fournisseur);
    }

    // Détail Api Four
    public function detailApiFour()
    {
        $data['fk_api'] = $this->paramGET[0];
        //echo '<pre>'; var_dump($data['fk_api']);die();
        $data['api_four'] = $this->apifournisseurModels->getOneApiFournisseur(["condition" => ["a.rowid = " => $this->paramGET[0]]]);
        //echo '<pre>'; var_dump($data['api_four']);die();
        $this->views->setData($data);
        $this->views->getTemplate('administration/detailApiFour');
    }

    /*********************** FIN Gestion API Fournisseurs *********************/


    /*********************** DEBUT Gestion Web Service *********************/
    // Ajout Web Service
    public function ajoutWebServiceModal()
    {
        $data['fk_api'] = $this->paramGET[2];
        $this->views->setData($data);
        $this->modal();
    }

    // Ajout Web Service
    public function ajoutWebService()
    {
        $fk_api = base64_encode($this->paramPOST['fk_api']);
        $result = $this->webserviceModels->insertWebService(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_ws"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_ws"]]);
        Utils::redirect("administration", "detailApiFour/".$fk_api);
    }

    // Modification Web Service
    public function modifWebServiceModal()
    {
        $data['web_service'] = $this->webserviceModels->getWebService(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
        //var_dump($data['web_service']);
        //$data['api_four'] = $this->apifournisseurModels->getApiFournisseur();
        $this->views->setData($data);
        $this->modal();
    }

    // Update Web Service
    public function updateWebService()
    {
        $fk_api = $this->paramPOST['fk_api'];
        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        unset($this->paramPOST['rowid']);
        unset($this->paramPOST['fk_api']);
        $data['champs'] = $this->paramPOST;
        $result = $this->webserviceModels->updateWebService($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_ws"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_ws"]]);
        Utils::redirect("administration", "detailApiFour/".$fk_api);
    }

    // Supression Web Service
    public function removeWebService()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->webserviceModels->deleteWebService(["condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_ws"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_ws"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_ws"]]);
        Utils::redirect("administration", "listeWebService");
    }

    //  Liste Web Service
    public function listeWebService__()
    {
        $this->views->getTemplate("administration/listeWebService");
    }

    // Processing Web Service
    public function listeWebServicePro()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('administration')->__authorized($this->_USER->idprofil, 'administration', 'modifWebServiceModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["administration/modifWebServiceModal", "administration/modifWebServiceModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["administration/activateWebService/","fa fa-toggle-off"],"1" => ["administration/deactivateWebService/", "fa fa-toggle-on"]]],
                            ["administration/detailWebService/", "fa fa-search"]
                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => ["Modifier",["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Desactiver"]]],
                        "default" => [["champ"=>"etat","val"=>["0"=>"Activer","1"=>"Désactiver"]], "Détail"]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => $this->paramGET,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>Désactivé</i>"], "1" => ["<i class='text-success'>Activé</i>"]]]
                    ],
                    "fonction" => []
                ];
                $this->processing($this->webserviceModels, 'getAllWebService', $param);


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
                $this->processing($this->webserviceModels, 'getAllWebService', $param);

            }

        }
    }

    // Activation Web Service
    public function activateWebService()
    {
        $ws = $this->webserviceModels->getOneWebService(["condition" => ["ws.rowid = " => $this->paramGET[0]]]);
        $fk_api = base64_encode($ws->fk_api);
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->webserviceModels->updateWebService(["champs" => ["etat" => 1], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_ws"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_ws"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_ws"]]);
        Utils::redirect("administration", "detailApiFour/".$fk_api);
    }

    // Desactivation Web Service
    public function deactivateWebService()
    {
        $ws = $this->webserviceModels->getOneWebService(["condition" => ["ws.rowid = " => $this->paramGET[0]]]);
        $fk_api = base64_encode($ws->fk_api);
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->webserviceModels->updateWebService(["champs" => ["etat" => 0], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_ws"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_ws"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_ws"]]);
        Utils::redirect("administration", "detailApiFour/".$fk_api);
    }

    // Détail Web Service
    public function detailWebService()
    {
        $data['fk_webservice'] = $this->paramGET[0];
        //echo '<pre>'; var_dump($data['fk_webservice']);die();
        $data['ws'] = $this->webserviceModels->getOneWebService(["condition" => ["ws.rowid = " => $this->paramGET[0]]]);
        //echo '<pre>'; var_dump($data['ws']);die();
        $this->views->setData($data);
        $this->views->getTemplate('administration/detailWebService');
    }

    /*********************** FIN Gestion Web Service *********************/


    /*********************** DEBUT Gestion Code Retour Web Service *********************/
    // Ajout Code retour Web Service
    public function ajoutCodeRetourModal()
    {
        //$data['ws'] = $this->webserviceModels->getWebService($param);
        $data['fk_webservice'] = $this->paramGET[2];
        //var_dump($data['fk_webservice']); die();
        $this->views->setData($data);
        $this->modal();
    }

    // Ajout Code retour Web Service
    public function ajoutCodeRetour()
    {
        //var_dump($this->paramPOST); die();
        $id = base64_encode($this->paramPOST['fk_webservice']);
        $result = $this->coderetourModels->insertCodeRetour(["champs" => $this->paramPOST]);
        //var_dump($result); die();
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_cr"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_cr"]]);
        Utils::redirect("administration", "detailWebService/".$id);
    }

    /******* verifier Code de Retour ****/
    public function verifCodeRetour()
    {
        $verif = $this->coderetourModels->verifCodeModel($this->paramPOST['code']);
        if($verif==1) echo 1;
        else echo -1;
    }

    // Modification Code retour Web Service
    public function modifCodeRetourModal()
    {
        $data['fk_webservice'] = $this->paramGET[2];
        $data['code_retour'] = $this->coderetourModels->getCodeRetour(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal();
    }

    // Update Code retour Web Service
    public function updateCodeRetour()
    {
        $fk_webservice = $this->paramPOST['fk_webservice'];
        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        unset($this->paramPOST['rowid']);
        unset($this->paramPOST['fk_webservice']);
        $data['champs'] = $this->paramPOST;
        $result = $this->coderetourModels->updateCodeRetour($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_cr"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_cr"]]);
        Utils::redirect("administration", "detailWebService/".$fk_webservice);
    }

    //  Liste Code retour Web Service
    public function listeCodeRetour__()
    {
        $this->views->getTemplate("administration/listeCodeRetour");
    }

    // Processing Code retour Web Service
    public function listeCodeRetourPro()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('administration')->__authorized($this->_USER->idprofil, 'administration', 'modifCodeRetourModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["administration/modifCodeRetourModal", "administration/modifCodeRetourModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["administration/activateCodeRetour/","fa fa-toggle-off"],"1" => ["administration/deactivateCodeRetour/", "fa fa-toggle-on"]]]

                        ]
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
                    "args" => $this->paramGET,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>Désactivé</i>"], "1" => ["<i class='text-success'>Activé</i>"]]]
                    ],
                    "fonction" => []
                ];
                $this->processing($this->coderetourModels, 'getAllCodeRetour', $param);


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
                $this->processing($this->coderetourModels, 'getAllCodeRetour', $param);

            }

        }
    }

    // Supression Code retour Web Service
    public function removeCodeRetour()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->coderetourModels->deleteCodeRetour(["condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_cr"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_cr"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_cr"]]);
        Utils::redirect("administration", "listeCodeRetour");
    }

    // Activation Code retour Web Service
    public function activateCodeRetour()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->coderetourModels->updateCodeRetour(["champs" => ["etat" => 1], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_cr"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_cr"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_cr"]]);
        Utils::redirect("administration", "listeCodeRetour");
    }

    // Desactivation Code retour Web Service
    public function deactivateCodeRetour()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->coderetourModels->updateCodeRetour(["champs" => ["etat" => 0], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_cr"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_cr"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_cr"]]);
        Utils::redirect("administration", "listeCodeRetour");
    }

    /*********************** FIN Gestion Code Retour Web Service *********************/

    /*********************** DEBUT Paramètre Web Service *********************/

    // Modification Parametre
    public function modifParametreModal()
    {
        $data['fk_webservice'] = $this->paramGET[2];
        //var_dump($data['fk_webservice']); die();
        $data['parametre'] = $this->parametreModels->getParametre(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal();
    }

    // Update Parametre
    public function updateParametre()
    {
        $id = $this->paramPOST['fk_webservice'];
        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        unset($this->paramPOST['rowid']);
        unset($this->paramPOST['fk_webservice']);
        $data['champs'] = $this->paramPOST;
        $result = $this->parametreModels->updateParametre($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_par"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_par"]]);
        Utils::redirect("administration", "detailWebService/".$id);
    }

    // Supression Parametre
    public function removeParametre()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->parametreModels->deleteParametre(["condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_cr"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_cr"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_cr"]]);
        Utils::redirect("administration", "listeParametre");
    }

    //  Liste Parametre
    public function listeParametre__()
    {
        $this->views->getTemplate("administration/listeParametre");
    }

    // Processing Parametre
    public function listeParametrePro()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('administration')->__authorized($this->_USER->idprofil, 'administration', 'modifParametreModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["administration/modifParametreModal", "administration/modifParametreModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["administration/activateParametre/","fa fa-toggle-off"],"1" => ["administration/deactivateParametre/", "fa fa-toggle-on"]]]
                        ]
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
                    "args" => $this->paramGET,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>Désactivé</i>"], "1" => ["<i class='text-success'>Activé</i>"]]]
                    ],
                    "fonction" => []
                ];
                $this->processing($this->parametreModels, 'getAllParametre', $param);


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
                $this->processing($this->parametreModels, 'getAllParametre', $param);

            }

        }
    }

    // Activation Parametre
    public function activateParametre()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->parametreModels->updateParametre(["champs" => ["etat" => 1], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_cr"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_cr"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_cr"]]);
        Utils::redirect("administration", "listeParametre");
    }

    // Desactivation Parametre
    public function deactivateParametre()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->parametreModels->updateParametre(["champs" => ["etat" => 0], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_cr"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_cr"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_cr"]]);
        Utils::redirect("administration", "listeParametre");
    }

    // Modal Parametrage Web Service
    public function parametrageWSModal()
    {
        $data['fk_webservice'] = $this->paramGET[2];
        //var_dump($data['fk_webservice']); die();
        $this->views->setData($data);
        $this->modal();
    }

    // Ajout Parametre Web Service
    public function addParamWS()
    {
        $id = base64_encode($this->paramPOST['fk_webservice']);
        $par = $this->paramPOST['parametre'];
        unset($this->paramPOST['parametre1']);
        $concat = '';
        for ($i=0; $i<sizeof($par); $i++){
            if($i == sizeof($par)-1) $concat = $concat.$par[$i];
            else $concat = $concat.$par[$i].'#';
        }
        $param = [
            "champs" => [
                "parametre"=>$concat,
                "nbre_parametre"=>count($this->paramPOST["parametre"]),
                "fk_webservice"=> $this->paramPOST["fk_webservice"]
            ]
        ];
        //echo '<pre>'; var_dump($concat);die();
        //echo '<pre>'; var_dump(count($this->paramPOST['parametre']));die();

        $rst = $this->parametreModels->insertParametre($param);

        if($rst != false)
        {
            Utils::setMessageALert(["success",$this->lang["succes_add_par"]]);
        }
        else
        {
            Utils::setMessageALert(["danger",$this->lang["echec_add_par"]]);
        }
        Utils::redirect('administration', 'detailWebService/'.$id);
    }

    /*********************** FIN Paramètre Web Service *********************/

    /**************************************************************** FIN GESTION DES FOURNISSEURS ***************************************************/




    /**************************************************************** DEBUT GESTION DES SERVICES ***************************************************/

    /*********************** DEBUT Catégorie Service *********************/
    //  Liste categorie Service
    public function listeCatService__()
    {
        $this->views->getTemplate("administration/listeCategorieService");
    }

    // Processing categorie Service
    public function listeCatServicePro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifCatServiceModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["administration/modifCatServiceModal", "administration/modifCatServiceModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["administration/activateCatService/","fa fa-toggle-off"],"1" => ["administration/deactivateCatService/", "fa fa-toggle-on"]]]
                            /*,
                            ["administration/removeCatService/", "fa fa-trash"]*/
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
                $this->processing($this->categorieServiceModels, 'getAllCatService', $param);

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
                $this->processing($this->categorieServiceModels, 'getAllCatService', $param);

            }

        }
    }

    // Modal Ajout categorie Service
    public function ajoutCatServiceModal()
    {
        $this->modal();
    }

    // Ajout categorie Service
    public function ajoutCatService()
    {
        //parent::validateToken("administration", "listeCatService");
        $result = $this->categorieServiceModels->insertCatService(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_catservice"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_catservice"]]);
        Utils::redirect("administration", "listeCatService");
    }

    /******* verifier Code Categorie Service ****/
    public function verifCodeCatSerice()
    {
        $verif = $this->categorieServiceModels->verifCodeModel($this->paramPOST['code']);
        if($verif==1) echo 1;
        else echo -1;
    }

    // Modal Modification Catégorie Service
    public function modifCatServiceModal()
    {
        $data['cat_serv'] = $this->categorieServiceModels->getCatService(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal();
    }

    // Update Catégorie Service
    public function updateCatService()
    {
        //parent::validateToken("administration", "listeWebService");
        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        unset($this->paramPOST['rowid']);
        $data['champs'] = $this->paramPOST;
        $result = $this->categorieServiceModels->updateCatService($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_catservice"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_catservice"]]);
        Utils::redirect("administration", "listeCatService");
    }

    // Activation categorie Service
    public function activateCatService()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->categorieServiceModels->updateCatService(["champs" => ["etat" => 1], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_catservice"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_catservice"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_catservice"]]);
        Utils::redirect("administration", "listeCatService");
    }

    // Desactivation categorie Service
    public function deactivateCatService()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->categorieServiceModels->updateCatService(["champs" => ["etat" => 0], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_catservice"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_catservice"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_catservice"]]);
        Utils::redirect("administration", "listeCatService");
    }

    // Supression categorie Service
    public function removeCatService()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->categorieServiceModels->deleteCatService(["condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_catservice"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_catservice"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_catservice"]]);
        Utils::redirect("administration", "listeCatService");
    }

    /*********************** FIN Catégorie Service *********************/


    /*********************** DEBUT Service *********************/

    // Détail Service
    public function detailService()
    {
        $data['fk_service'] = $this->paramGET[0];
        $data['service'] = $this->serviceModels->getOneService(["condition" => ["s.rowid = " => $this->paramGET[0]]]);
        $data['categ_serv'] = $this->categorieServiceModels->getCatService();
        //echo '<pre>'; var_dump($data['service']);die();
        $this->views->setData($data);
        $this->views->getTemplate('administration/detailService');
    }

    // Liste Service
    public function listeService__()
    {
        $this->views->getTemplate("administration/listeService");
    }

    // Processing Service
    public function listeServicePro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->fk_profil, 'administration', 'modifServiceModal') > 0) {
                $param = [

                    "button" => [
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["administration/activateService/","fa fa-toggle-off"],"1" => ["administration/deactivateService/", "fa fa-toggle-on"]]]
                            , ["administration/detailService/", "fa fa-eye"]
                        ],
                        "modal" => [
                            ["administration/modifServiceModal", "administration/modifServiceModal", "fa fa-edit"],
                            ["administration/parametrageComServiceModal", "administration/parametrageComServiceModal", "fa fa-sitemap"],
                            ["champ"=>"_disponibilite_","val"=>["0"=>["administration/dispoServiceModal","administration/dispoServiceModal","fa fa-tag"],"1"=>[null]]]
                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],

                    "tooltip" => [
                        "modal" => ["Modifier", "Paramétrage Commission", "Disponibilité Service",["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Desactiver"]]],
                        "default" => [["champ"=>"etat","val"=>["0"=>"Activer","1"=>"Désactiver"]], "Détail"]
                    ],
                    "classCss" => [
                        "modal" => [],
                        // "default" => ["confirm","confirm"]
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => null,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>Désactivé</i>"], "1" => ["<i class='text-success'>Activé</i>"]]]
                    ],
                    "fonction" => []
                ];
                $this->processing($this->serviceModels, 'getAllService', $param);

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
                $this->processing($this->serviceModels, 'getAllService', $param);

            }

        }
    }

    // Modal Ajout Service
    public function ajoutServiceModal()
    {
        $data['cat_serv'] = $this->categorieServiceModels->getCatService($param);
        $data['fournisseur'] = $this->fournisseurModels->getFournisseur($param);
        //var_dump($data['serv']); die();
        $this->views->setData($data);
        $this->modal();
    }

    // Ajout Service
    public function ajoutService()
    {
        //echo '<pre>'; var_dump($this->paramPOST); die();
        $result = $this->serviceModels->insertService(["champs" => $this->paramPOST]);
        //echo '<pre>'; var_dump($result); die();
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_service"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_service"]]);
        Utils::redirect("administration", "listeService");
    }

    // Modal Modification Service
    public function modifServiceModal()
    {
        $data['serv'] = $this->serviceModels->getService(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
        $data['categ_serv'] = $this->categorieServiceModels->getCatService();
        $data['fournisseur'] = $this->fournisseurModels->getFournisseur($param);
        $this->views->setData($data);
        $this->modal();
    }

    // Update Service
    public function updateService()
    {
        //parent::validateToken("administration", "listeService");
        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        unset($this->paramPOST['rowid']);
        $data['champs'] = $this->paramPOST;
        //var_dump($this->paramPOST); die();
        $result = $this->serviceModels->updateService($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_service"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_service"]]);
        Utils::redirect("administration", "listeService");
    }

    // Vérifier Nom méthode
    public function verifNomMethode()
    {
        $verif = $this->serviceModels->verifMethodeModel($this->paramPOST['methode']);
        if($verif==1) echo 1;
        else echo -1;
    }

    // Activation Service
    public function activateService()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->serviceModels->updateService(["champs" => ["etat" => 1], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_service"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_service"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_service"]]);
        Utils::redirect("administration", "listeService");
    }

    // Desactivation Service
    public function deactivateService()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->serviceModels->updateService(["champs" => ["etat" => 0], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_service"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_service"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_service"]]);
        Utils::redirect("administration", "listeService");
    }

    // Supression Service
    public function removeService()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->serviceModels->deleteService(["condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_service"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_service"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_service"]]);
        Utils::redirect("administration", "listeService");
    }

    // Modal Parametrage Commission Service
    public function parametrageComServiceModal()
    {
        $data['fk_service'] = $this->paramGET[2];
        $this->views->setData($data);
        $this->modal();
    }

    // Ajout Service
    public function addParamService()
    {


        foreach ($this->paramPOST["montant_deb"] as $key => $item) {
            $param = [
                "champs" => [
                    "montant_deb"=>$item,
                    "montant_fin"=>$this->paramPOST["montant_fin"][$key],
                    "valeur"=>$this->paramPOST["valeur"][$key],
                    "fk_service"=> $this->paramPOST["fk_service"]
                ]
            ];
            $rst = $this->serviceModels->insertParamService($param);
        }

        if($rst != false)
        {
            Utils::setMessageALert(["success",$this->lang["succes_add_service"]]);
        }
        else
        {
            Utils::setMessageALert(["danger",$this->lang["echec_add_service"]]);
        }
        Utils::redirect('administration', 'listeService');
    }

    /*********************** FIN Service *********************/

    /*********************** DEBUT Disponibilité Service *********************/

    //Gestion disponibilité Service
    public function dispoServiceModal()
    {
        $etat = 1;

        //$data['service']= $this->disponibiliteModels->allService(["condition" => ["rowid = " => $etat]]);

        $data['pays'] = $this->disponibiliteModels->getPays($param);

        $data['service_disponibles'] = $this->disponibiliteModels->allServiceDispoParPays(["condition" => ["fk_service = " => $this->paramGET[2], "etat =" => $etat]]);
        //var_dump($data['service_disponibles']);die;

        $data['dispo'] = $this->serviceModels->getService(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
        //var_dump($data['dispo']);

        $this->views->setData($data);

        $this->modal();
    }

    // Ajouter un service dans un pays
    public function ajoutDispoService()
    {

        $user_creation = $this->_USER->id;
        $id = $this->paramPOST['rowid'];
        $lesactionscoches = array();
        $lesactionscoches = $this->paramPOST['fk_pays'];
        $nbre = sizeof($lesactionscoches);



        $rst= $this->disponibiliteModels->deleteDisponibiliteService(["condition" => ["fk_service = " => $id]]);
        if($rst)
        {
            $i = 0;
        }

        foreach($lesactionscoches as $uneaction)
        {
            $result1 = $this->disponibiliteModels->addService($uneaction, $id, $user_creation);
            if($result1)
            {
                $i++;
            }
        }
        if($nbre == $i)
        {
            Utils::setMessageALert(["success", $this->lang["action_success"]]);
            //$this->profilModels->log_journal('Affectation droit profil', 'profil affecté : '.$id, 'affectation droit succes', 1, $this->_USER->id);
            Utils::redirect('administration', 'listeService');
        }
    }

    // Processing Disponibilité d'un Service dans un pays
    public function listeDispoServiceInCountryPro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifTarifFraisModal') > 0) {
                $param = [
                    "button" => [
                        "default" => [],
                        "modal" => []
                    ],
                    "tooltip" => [
                        "modal" => []
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => $this->paramGET,
                    "dataVal" => [],
                    "fonction" => []
                ];
                $this->processing($this->disponibiliteModels, 'getServiceDispoInCountry', $param);

            } else {
                $param = [
                    "button" => [
                        "modal" => [],
                        "default" => []
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
                $this->processing($this->disponibiliteModels, 'getServiceDispoInCountry', $param);

            }

        }
    }

    // Processing Tarif Frais
    public function listeTarifFraisPro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifTarifFraisModal') > 0) {
                $param = [
                    "button" => [
                        "default" => [],
                        "modal" => [
                            ["administration/modifTarifFraisModal", "administration/modifTarifFraisModal", "fa fa-edit"]
                        ]
                    ],
                    "tooltip" => [
                        "modal" => ["Modifier"]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => $this->paramGET,
                    "dataVal" => [],
                    "fonction" => ["montant_deb"=>'getFormatMoney', "montant_fin"=>'getFormatMoney', "valeur"=>'getFormatMoney']
                ];
                $this->processing($this->tariffraisModels, 'getAllTarifFrais', $param);

            } else {
                $param = [
                    "button" => [
                        "modal" => [],
                        "default" => []
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
                $this->processing($this->tariffraisModels, 'getAllTarifFrais', $param);

            }

        }
    }

    // Modal Modification Tarif Frais
    public function modifTarifFraisModal()
    {
        $data['tarif_frais'] = $this->tariffraisModels->getTarifFrais(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
        //var_dump($data['tarif_frais']); die();
        $this->views->setData($data);
        $this->modal();
    }

    // Update Tarif Frais
    public function updateTarifFrais()
    {
        //parent::validateToken("administration", "listeTarifFrais");
        $id = $this->paramPOST['fk_service'];
        //var_dump($id); die();
        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        unset($this->paramPOST['rowid']);
        unset($this->paramPOST['fk_service']);
        $data['champs'] = $this->paramPOST;
        $result = $this->tariffraisModels->updateTarifFrais($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_tarif_frais"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_tarif_frais"]]);
        Utils::redirect("administration", "detailService/".$id);
    }

    // Modal Ajout Erreur Web Service
    public function ajoutErrorWSModal()
    {
        //var_dump($this->paramGET); die();
        $data['service'] = $this->serviceModels->getService($param);
        //var_dump($data['service']); die();

        // $data['fk_service'] = $this->paramGET[0];
        $this->views->setData($data);
        $this->modal();
    }

    // Ajout Erreur Web Service
    public function ajoutErrorWS()
    {
        $id = base64_encode($this->paramPOST['fk_service']);
        $result = $this->erreurwebserviceModels->insertErreurWebService(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_error_ws"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_error_ws"]]);
        Utils::redirect("administration", "detailService/".$id);
    }

    // Processing Erreur Web Service
    public function listeErrorWSPro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifErrorWSModal') > 0) {
                $param = [
                    "button" => [
                        "default" => [],
                        "modal" => [
                            ["administration/modifErrorWSModal", "administration/modifErrorWSModal", "fa fa-edit"]
                        ]
                    ],
                    "tooltip" => [
                        "modal" => ["Modifier"]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => $this->paramGET,
                    "dataVal" => [],
                    "fonction" => []
                ];
                $this->processing($this->erreurwebserviceModels, 'getAllErreurWebService', $param);

            } else {
                $param = [
                    "button" => [
                        "modal" => [],
                        "default" => []
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
                $this->processing($this->erreurwebserviceModels, 'getAllErreurWebService', $param);

            }

        }
    }

    // Modal Modification Erreur Web Service
    public function modifErrorWSModal()
    {
        $data['error_ws'] = $this->erreurwebserviceModels->getErreurWebService(["condition" => ["id = " => $this->paramGET[2]]])[0];
        //var_dump($data['error_ws']); die();
        $data['serv'] = $this->serviceModels->getService();
        $this->views->setData($data);
        $this->modal();
    }

    // Update Erreur Web Service
    public function updateErrorWS()
    {
        //parent::validateToken("administration", "listeTarifFrais");
        $id = base64_encode($this->paramPOST['fk_service']);
        //var_dump($id); die();
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        unset($this->paramPOST['fk_service']);
        $data['champs'] = $this->paramPOST;
        $result = $this->erreurwebserviceModels->updateErreurWebService($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_error_ws"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_error_ws"]]);
        Utils::redirect("administration", "detailService/".$id);
    }
    /*********************** FIN Service *********************/



    /**************************************************************** FIN GESTION DES SERVICES ***************************************************/

    /******* Action verifier Ancien Mot Passe ********/
    public function verifAncienMotPasse()
    {
        $verif = $this->utilisateurModels->verifAncienPass(["condition" => ["u.password = " => sha1($this->paramPOST["ancienpasse"])]]);
        if($verif == 1) echo 1;
        if($verif == -1) echo -1;
    }

    /*************activer User***********/
    public function updatePasswordUser__()
    {
        //var_dump($this->paramPOST); die();

        $data['condition'] = ["id = " => $this->_USER->id];
        unset($this->paramPOST['ancienpass']);
        unset($this->paramPOST['mot_de_passe1']);
        $this->paramPOST['password'] = sha1($this->paramPOST['password']);

        //var_dump($data['condition']);die();

        $data['champs'] = $this->paramPOST;

        $result = $this->utilisateurModels->updatePassUser($data);
        //var_dump($result); die();
        if ($result !== false) {
            Session::destroySession();
            Utils::setMessageALert(["success", "Modification mot de passe avec succès"]);
            Utils::redirect("home", "index");
        }
        else {
            Utils::setMessageALert(["danger", "Echec de la modification du mot de passe"]);
            Utils::redirect("menu", "firstConnect");
        }

    }

    /*****************  Gestion des Message Entete  ************************/
    // Ajout Message
    public function ajoutMessageModal()
    {
        $etat = 1;
        $data['module']= $this->profilModels->allModule(["condition" => ["etat = " => $etat]]);
        $this->views->setData($data);
        $this->modal();
    }

    // Ajout Message
    public function ajoutMessage()
    {
        //parent::validateToken("administration", "listeFournisseur");
        $this->paramPOST["user_creation"] = $this->_USER->id;
        $result = $this->messageModels->insertMessage(["champs" => $this->paramPOST]);
        if($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_message"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_message"]]);
        Utils::redirect("administration", "listeMessage");
    }

    // Modification Message
    public function modifMessageModal()
    {
        $data['message'] = $this->messageModels->getMessage(["condition" => ["id = " => $this->paramGET[2]]])[0];
        $data['module']= $this->profilModels->allModule(["condition" => ["etat = " => 1]]);
        $this->views->setData($data);
        $this->modal();
    }

    // Update Message
    public function updateMessage()
    {
        //parent::validateToken("administration", "listeFournisseur");
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->messageModels->updateMessage($data);

        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_message"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_message"]]);
        Utils::redirect("administration", "listeMessage");
    }

    // Supression Message
    public function removeMessage()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->fournisseurModels->deleteFournisseur(["condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_four"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_four"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_four"]]);
        Utils::redirect("administration", "listeFournisseur");
    }

    //  Liste Message
    public function listeMessage__()
    {
        $this->views->getTemplate("administration/listeMessage");
    }

    // Processing Message
    public function listeMessagePro()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('administration')->__authorized($this->_USER->idprofil, 'administration', 'modifMessageModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["administration/modifMessageModal", "administration/modifMessageModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["administration/activateMessage/","fa fa-toggle-off"],"1" => ["administration/deactivateMessage/", "fa fa-toggle-on"]]]
                            /*,
                            ["administration/removeFournisseur/", "fa fa-trash"]*/
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
                $this->processing($this->messageModels, 'getAllMessage', $param);


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
                $this->processing($this->fournisseurModels, 'getAllMessage', $param);

            }

        }
    }

    // Activation Message
    public function activateMessage()
    {
        if (intval($this->paramGET[0]) > 0)
        {
            $result = $this->messageModels->updateMessage(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if($result !== false)
            {
                Utils::setMessageALert(["success", $this->lang["succes_activate_message"]]);
            }
            else {
                Utils::setMessageALert(["danger", $this->lang["echec_activate_message"]]);
            }
        }
        else {
            Utils::setMessageALert(["danger", $this->lang["echec_activate_message"]]);
        }
        Utils::redirect("administration", "listeMessage");
    }

    // Desactivation Message
    public function deactivateMessage()
    {
        if (intval($this->paramGET[0]) > 0)
        {
            $result = $this->messageModels->updateMessage(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);

            if($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_message"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_message"]]);
        }
        else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_message"]]);
        Utils::redirect("administration", "listeMessage");
    }

    /**********************  FIN Gestion des Message  **********************/




    /*********************** DEBUT TYPE WEBSERVICE *********************/
    //  Liste type web Service
    public function listeTypeWebservice__()
    {
        $this->views->getTemplate("administration/listeTypeWebService");
    }

    // Processing type web Service
    public function listeTypeWebservicePro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->fk_profil, 'administration', 'modifTypeWebServiceModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["administration/modifTypeWebServiceModal", "administration/modifTypeWebServiceModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["administration/activateTypeWebService/","fa fa-toggle-off"],"1" => ["administration/deactivateTypeWebService/", "fa fa-toggle-on"]]]
                        ]
                    ],
                    "tooltip" => [
                        "modal" => ["Modifier",["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Desactiver"]]],
                        "default" => [["champ"=>"etat","val"=>["0"=>"Activer","1"=>"Désactiver"]]]
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
                $this->processing($this->typeWebServiceModels, 'getAllTypeWebService', $param);

            } else {
                $param = [
                    "button" => [
                        "modal" => [],
                        "default" => []
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
                $this->processing($this->typeWebServiceModels, 'getAllTypeWebService', $param);

            }

        }
    }

    // Modal Ajout Type Web Service
    public function ajoutTypeWebServiceModal()
    {
        $this->modal();
    }

    // Ajout Type Web Service
    public function ajoutTypeWebService()
    {
        //parent::validateToken("administration", "listeCatService");

        $result = $this->typeWebServiceModels->insertTypeWebService(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_typewebservice"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_typewebservice"]]);
        Utils::redirect("administration", "listeTypeWebService");
    }

    //Modal Modification Type Web Service
    public function modifTypeWebServiceModal()
    {
        $data['cat_serv'] = $this->typeWebServiceModels->getTypeWebService(["condition" => ["id = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal();
    }

    //Update Type Web Service
    public function updateTypeWebService()
    {
        //parent::validateToken("administration", "listeWebService");

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['rowid'])];
        unset($this->paramPOST['rowid']);
        $data['champs'] = $this->paramPOST;
        $result = $this->typeWebServiceModels->updateTypeWebService($data);

        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_catservice"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_catservice"]]);
        Utils::redirect("administration", "listeTypeWebService");
    }

    //Activation Type Web Service
    public function activateTypeWebService()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->typeWebServiceModels->updateTypeWebService(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_catservice"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_catservice"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_catservice"]]);
        Utils::redirect("administration", "listeTypeWebService");
    }

    //Desactivation Type Web Service
    public function deactivateTypeWebService()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->typeWebServiceModels->updateTypeWebService(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_catservice"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_catservice"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_catservice"]]);
        Utils::redirect("administration", "listeTypeWebService");
    }

    /*********************** FIN TYPE WEB SERVICE *********************/


    /*********************** DEBUT TYPE INTERCONNEXION *********************/

    //  Liste type interconnexion
    public function listeTypeInterconnexion__()
    {
        $this->views->getTemplate("administration/listeTypeInterconnexion");
    }

    // Processing type interconnexion
    public function listeTypeInterconnexionPro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->fk_profil, 'administration', 'modifInterconnexionModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["administration/modifTypeInterconnexionModal", "administration/modifTypeInterconnexionModal", "fa fa-edit"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["administration/activateTypeInterconnexion/","fa fa-toggle-off"],"1" => ["administration/deactivateTypeInterconnexion/", "fa fa-toggle-on"]]]
                        ]
                    ],
                    "tooltip" => [
                        "modal" => ["Modifier",["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Desactiver"]]],
                        "default" => [["champ"=>"etat","val"=>["0"=>"Activer","1"=>"Désactiver"]]]
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
                $this->processing($this->typeInterconnexionModels, 'getAllTypeInterconnexion', $param);

            } else {
                $param = [
                    "button" => [
                        "modal" => [],
                        "default" => []
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
                $this->processing($this->typeInterconnexionModels, 'getAllTypeInterconnexion', $param);

            }

        }
    }

    // Modal Ajout Type Interconnexion
    public function ajoutTypeInterconnexionModal()
    {
        $this->modal();
    }

    // Ajout Type Interconnexion
    public function ajoutTypeInterconnexion()
    {
        //parent::validateToken("administration", "listeCatService");

        $result = $this->typeInterconnexionModels->insertTypeInterconnexion(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_typeinterconnexion"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_typeinterconnexion"]]);
        Utils::redirect("administration", "listeTypeInterconnexion");
    }

    //Modal Modification Type Interconnexion
    public function modifTypeInterconnexionModal()
    {
        $data['cat_serv'] = $this->typeInterconnexionModels->getTypeInterconnexion(["condition" => ["id = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal();
    }

    //Update Type Interconnexion
    public function updateTypeInterconnexion()
    {
        //parent::validateToken("administration", "listeWebService");

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['rowid'])];
        unset($this->paramPOST['rowid']);
        $data['champs'] = $this->paramPOST;
        $result = $this->typeInterconnexionModels->updateTypeInterconnexion($data);

        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_typeinterconnexion"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_typeinterconnexion"]]);
        Utils::redirect("administration", "listeTypeInterconnexion");
    }

    //Activation Type Interconnexion
    public function activateTypeInterconnexion()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->typeInterconnexionModels->updateTypeInterconnexion(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_typeinterconnexion"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_typeinterconnexion"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_typeinterconnexion"]]);
        Utils::redirect("administration", "listeTypeInterconnexion");
    }

    //Desactivation Type Interconnexion
    public function deactivateTypeInterconnexion()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->typeInterconnexionModels->updateTypeInterconnexion(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_typeinterconnexion"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_typeinterconnexion\""]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_typeinterconnexion\""]]);
        Utils::redirect("administration", "listeTypeInterconnexion");
    }

    public  function getSolde(){
        $service = $this->serviceModels->getIdService('RechargeJula');
        $solde = $this->partenaireModels->checkPartenaireAccess(2, $service);
        var_dump($solde);
    }
    /***********************FIN TYPE INTERCONNEXION*********************/

}