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

class AdminController extends BaseController
{
    private $profilModels;
    private $utilisateurModels;
    private $gieModels;
    private $resModels;




    public function __construct()
    {
        parent::__construct();

        $this->utilisateurModels = $this->model("utilisateur");
        $this->profilModels = $this->model("profil");
        $this->gieModels = $this->model("gie");
        $this->resModels = $this->model("responsableGie");
        $this->profilModels = $this->model("profil");


        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_admin"]);

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
        $this->views->getTemplate('admin');

    }
    public function administration__()
    {
        //echo 'yes';exit();
        //echo ROOT." ".WEBROOT ;exit;
        $this->views->getTemplate('administration');

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

    public function listeUtilisateur()
    {
        $this->views->getTemplate('admin/listeUtilisateur');
    }

    /********Gestion Gie********/
    public function listeGiePro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
                $param = [

                    "button" => [
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["admin/activateGie/","fa fa-toggle-off"],"1" => ["admin/deactivateGie/", "fa fa-toggle-on"]]],
                            ["admin/removeGie/", "fa fa-trash"],
                            ["admin/detailGie/", "fa fa-search"]
                        ],
                        "modal" => [
                            ["admin/modifGieModal", "admin/modifGieModal", "fa fa-edit"],

                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => [$this->lang['Modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],

                        "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['Supprimer'],$this->lang['Detail']]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => null,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
                    ],
                    "fonction" => []
                ];
                $this->processing($this->gieModels, 'getAllGie', $param);

            } else {
                $param = [
                    "button" => [
                        "modal" => [
                            ["admin/modifGieModal", "admin/modifGieModal", "fa fa-edit"],

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
                $this->processing($this->gieModels, 'getAllGie', $param);

            }

        }

    }
    public function liste__()
    {

        $this->views->getTemplate("liste");

    }


    public function activateGie()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gieModels->updateGie(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_gie"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_gie"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_gie"]]);
        Utils::redirect("admin", "liste");
    }

    public function deactivateGie()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gieModels->updateGie(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_gie"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_gie"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_gie"]]);
        Utils::redirect("admin", "liste");
    }

    public function removeGie()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->gieModels->deleteGie(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_gie"]]);
            else Utils::setMessageALert(["danger",$this->lang["echec_delete_gie"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_gie"]]);
        Utils::redirect("admin", "liste");
    }


    public function ajoutGieModal()
    {
        //$data['utilisateur'] = $this->utilisateurModels->getUtilisateur($param);
        //$this->views->setData($data);
//var_dump($data);die;
        $this->modal();

    }

    public function ajoutGie()
    {

        $result = $this->gieModels->insertGie(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_gie"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_gie"]]);
        Utils::redirect("admin", "liste");


    }

    public function verifExistenceEmailGie()
    {
        $verif = $this->gieModels->verifEmailModel($this->paramPOST['email']);
        if($verif==1) echo 1;
        else echo -1;
    }

    public function modifGieModal()

  {
//   $data['bus'] = $this->busModels->getBus(["condition" => ["id = " => $this->paramGET[2]]])[0];
//        $data['categorie'] = $this->busCategorieModels->getTypeCategorie();

        $data['gie'] = $this->gieModels->getGie(["condition" => ["id = " => $this->paramGET[2]]])[0];
        //$data['utilisateur'] = $this->utilisateurModels->getUtilisateur();
        $this->views->setData($data);

        $this->modal();
    }

    public function updateGie()
    {
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->gieModels->updateGie($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_gie"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_gie"]]);
        Utils::redirect("admin", "liste");

    }

    public function detailGie(){

        //$etat = 1;
        //var_dump($this->paramGET);die();
        $data['gie'] = $this->gieModels->getOneGie(["condition" => ["g.id = " => $this->paramGET[0]]]);
        //$data['utilisateur'] = $this->utilisateurModels->getUtilisateur(["condition" => ["etat = " => $etat]]);
        //var_dump($data['gie']);die;
        $this->views->setData($data);
        $this->views->getTemplate('detailGie');

        //$this->modal();
    }


    public function updateEtatGie()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->gieModels->updateGie($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_gie"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_gie"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("admin", "detailGie"."/".$id);
        }else{Utils::redirect("admin",  "detailGie"."/".$id);}
    }

    public function updateGieDetail()
    {


        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->gieModels->updateGieDetail($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_gie"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_gie"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("bus", "detailBus"."/".$id);
        }else{Utils::redirect("admin",  "detailGie"."/".$id);}
    }



    /********Gestion Responsable Gie********/

//    public function listeResPro__()
//    {
//        if ($this->_USER) {
//            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
//                $param = [
//
//                    "button" => [
//                        "default" => [
//                            ["champ" => "etat","val" => ["0" => ["admin/activate/","fa fa-toggle-off"],"1" => ["admin/deactivate/", "fa fa-toggle-on"]]],
//                            ["admin/removeRespo/", "fa fa-trash"],
//                            ["admin/detailRespon/", "fa fa-search"]
//                        ],
//                        "modal" => [
//                            ["admin/modifResponModal", "admin/modifResponModal", "fa fa-edit"],
//
//                        ]
//                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
//                    ],
//                    "tooltip" => [
//                        "modal" => ["Modifier",["champ"=>"_etat_","val"=>["0"=>"Activer","1"=>"Desactiver"]]],
//                        "default" => [["champ"=>"etat","val"=>["0"=>"Activer","1"=>"Désactiver"]], "Supprimer","Detail"],
//
//
//                    ],
//                    "classCss" => [
//                        "modal" => [],
//                        "default" => ["confirm"]
//                    ],
//                    "attribut" => [],
//                    "args" => null,
//                    "dataVal" => [
//                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>Désactivé</i>"], "1" => ["<i class='text-success'>Activé</i>"]]]
//                  ],
//                    "fonction" => []
//                ];
//                $this->processing($this->resModels, 'getAllRes', $param);
//
//            } else {
//                $param = [
//                    "button" => [
//                        "modal" => [
//                            ["admin/modifRespoModal", "admin/modifRespoModal", "fa fa-edit"],
//
//                        ],
//                        "default" => [
//                            ["bus/detailBus/", "fa fa-search"]
//                        ]
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
//                $this->processing($this->resModels, 'getAllRes', $param);
//
//            }
//
//        }
//
//    }
    public function listeResGiePro__()
    {

        $this->views->getTemplate("listeRespo");

    }

    public function ajoutResponModal()
    {
        $data['typep'] = $this->profilModels->getidprofil($param);
        $data['gie'] = $this->gieModels->AllGie($param);
        $this->views->setData($data);
        $this->modal();
    }

//    public function ajoutRespon()
//    {
//
//        $dossier_photo = ROOT."assets/pictures/";
//        $file_photo = basename($_FILES['photo']['name']);
//        if ($file_photo != null) {
//
//            if (move_uploaded_file($_FILES['photo']['tmp_name'], $dossier_photo.$file_photo)) //Si la fonction renvoie TRUE, c'est que &ccedil;a a fonctionn&eacute;...
//            {
//                $info = new \SplFileInfo($file_photo);
//                $new_name = date("YmdHis") . '.' . $info->getExtension();
//                rename($dossier_photo . $file_photo, $dossier_photo . $new_name);
//                $file_photo = $new_name;
//            }
//        }
//        $this->paramPOST['photo'] = $file_photo;
//
//        $result = $this->resModels->insertRespo(["champs" => $this->paramPOST]);
//        if ($result !== false) Utils::setMessageALert(["success", "Responsable ajouté avec succes"]);
//        else Utils::setMessageALert(["danger", "Echec de l'ajout du responsable"]);
//        Utils::redirect("admin", "listeResGiePro");
//
//
//    }
    public function ajoutRespon()
    {
        //$pass = Utils::getGeneratePassword(12);
        //$pwd = $pass['pass'];
        $password = $this->paramPOST["password"];

        $this->paramPOST["password"] = sha1($password);
        $prenom = $this->paramPOST["prenom"];
        $nom = $this->paramPOST["nom"];
        $email = $this->paramPOST["email"];
        $login = $this->paramPOST["login"];

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

        if (Utils::validateMail($this->paramPOST["email"])) {

            if (!$this->utilisateurModels->VerifEmail(['utilisateur', 'email'], $this->paramPOST["email"])) {

                $this->paramPOST["user_creation"]= $this->_USER->id;
                $result = $this->utilisateurModels->insertUtilisateur(["champs" => $this->paramPOST]);

                if ($result !== false){
                    Utils::envoiparametre($prenom.' '.$nom, $email, $login, $password);
                    Utils::setMessageALert(["success", $this->lang["utilisateur_ajouté_avec_succes"]]);
                    //mail($email,'test','mon gars c est bon', 'Votre mot de passe est'. $password);
                }

                else Utils::setMessageALert(["danger", $this->lang["Echec_de_lajout_du_utilisateur"]]);

            } else Utils::setMessageALert(["danger", $this->lang["email_existe"]]);


        } else Utils::setMessageALert(["warning", $this->lang["email_invalide"]]);

        Utils::redirect("admin", "listeResGiePro");

    }


//    public function detailRespon(){
//
//        $etat = 1;
//        //var_dump($this->paramGET);die();
//        $data['responsableGie'] = $this->resModels->getOneRespo(["condition" => ["r.id = " => $this->paramGET[0]]]);
//        //echo '<pre>'; var_dump($data['bus']);die();
//        $this->views->setData($data);
//        $this->views->getTemplate('detailRespon');
//
//        //$this->modal();
//    }

    public function updateEtatRespon()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->resModels->updateRespo($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_responsable"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_responsable"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("admin", "detailRespon"."/".$id);
        }else{Utils::redirect("admin",  "detailRespon"."/".$id);}
    }

    public function updateResponDetail()
    {


        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->resModels->updateResponDetail($data);
        if ($result !== false) Utils::setMessageALert(["success",$this->lang["succes_update_responsable"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_responsable"]]);

        if($this->paramGET[0]=="r"){Utils::redirect("admin", "detailRespon"."/".$id);
        }else{Utils::redirect("admin",  "detailRespon"."/".$id);}
    }



    public function verifExistenceEmail()
    {
        $verif = $this->resModels->verifEmailModel($this->paramPOST['email']);
        if($verif==1) echo 1;
        else echo -1;
    }

    public function listeResPro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
                $param = [
                    "button" => [

                        "modal" => [
                            ["admin/modifUtilisateurModal", "admin/modifUtilisateurModal", "fa fa-edit"]
                        ],

                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["admin/activate/","fa fa-toggle-off"],"1" => ["admin/deactivate/", "fa fa-toggle-on"]]],
                            ["admin/removeRespo/", "fa fa-trash"],
                            ["admin/detailUser/", "fa fa-search"]
                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => [$this->lang['Modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],

                        "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['Supprimer'],$this->lang['Detail']]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => null,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
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


    public function activate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->utilisateurModels->updateUtilisateur(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_active_responsable"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_active_responsable"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_active_responsable"]]);
        Utils::redirect("admin", "listeResGiePro");
    }

    public function deactivate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->utilisateurModels->updateUtilisateur(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactive_responsable"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactive_responsable"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactive_responsable"]]);
        Utils::redirect("admin", "listeResGiePro");
    }


    public function removeRespo()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->utilisateurModels->deleteUtilisateur(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_responsable"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_responsable"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_responsable"]]);
        Utils::redirect("admin", "listeResGiePro");
    }

    public function modifUtilisateurModal()

    {
//        $data['retour']=$this->paramGET[3];
//        var_dump($data);die;
        $data['utilisateur'] = $this->utilisateurModels->getUtilisateur(["condition" => ["id = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal();
    }

//    public function updateUtilisateur()
//    {
//        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
//        unset($this->paramPOST['id']);
//        $data['champs'] = $this->paramPOST;
//        $result = $this->utilisateurModels->updateUtilisateur($data);
//        if ($result !== false) Utils::setMessageALert(["success", "Responsable modifié avec succes"]);
//        else Utils::setMessageALert(["danger", "Echec de la modification du responsable"]);
//        Utils::redirect("admin", "listeResGiePro");
//
//    }

    public function detailUser(){

        $etat = 1;
        $data['user'] = $this->utilisateurModels->getOneUtilisateur(["condition" => ["u.id = " => $this->paramGET[0]]]);
        $data['allProfil'] = $this->profilModels->AllProfil(["condition" => ["etat = " => $etat]]);
        //echo '<pre>'; var_dump($data['user']);die();
        $this->views->setData($data);
        $this->views->getTemplate('detailUser');
    }

    public function updateUtilisateur()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        if (Utils::validateMail($this->paramPOST["email"])) {
            $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
            //$id = $this->paramPOST['id'];
            unset($this->paramPOST['id']);
            $data['champs'] = $this->paramPOST;
            $result = $this->utilisateurModels->updateUtilisateur($data);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_responsable"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_update_responsable"]]);
        } else Utils::setMessageALert(["warning",$this->lang["email_invalide"]]);
        Utils::redirect("admin", "listeResGiePro");
    }
    public function updateUtilisateurDetail()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        if (Utils::validateMail($this->paramPOST["email"])) {
            $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
            $id = $this->paramPOST['id'];
            unset($this->paramPOST['id']);
            $data['champs'] = $this->paramPOST;
            $result = $this->utilisateurModels->updateUtilisateur($data);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_utilisateur"]]);
            else Utils::setMessageALert(["danger",  $this->lang["echec_update_utilisateur"]]);
        } else Utils::setMessageALert(["warning", $this->lang["email_invalide"]]);
        Utils::redirect("admin",  "detailUser"."/".$id);
    }

    public function updateEtatUser()
    {
        //parent::validateToken("administration", "listeUtilisateur");

        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->utilisateurModels->updateUtilisateur($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_utilisateur"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_utilisateur"]]);

        Utils::redirect("admin",  "detailUser"."/".$id);

    }


    public function updatePhoto()
    {
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        $id = $this->paramPOST['id'];
        unset($this->paramPOST['id']);
        $dossier_photo =  /*ROOT."app/pictures/";*/ROOT."assets/pictures/";
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
        Utils::redirect('admin', "detailUser"."/".$id);
    }



}