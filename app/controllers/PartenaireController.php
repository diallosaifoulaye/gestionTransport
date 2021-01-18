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

class PartenaireController extends BaseController
{
    private $partenaireModels;
    private $sidebar;

    public function __construct()
    {
        parent::__construct();
        $this->partenaireModels = $this->model("partenaire");
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_partenaire"]);
    }

    public function index__()
    {
        $this->views->getTemplate('partenaire/part');

    }


    /**************************************************************** DEBUT GESTION DES PARTENAIRES ********************************************************/

    /************************ Gestion des Partenaires  **********************/
    // Modal Ajout Partenaire
    public function ajoutPartenaireModal()
    {
        $this->modal();
    }

    // Ajout Partenaire
    public function ajoutPartenaireOld()
    {
        $cle = Utils::getGeneratePassword(12);
        $login = Utils::genererReference(8);
        $this->paramPOST["password"] = $cle["crypt"];
        //$this->paramPOST["login"] = $login;
        $result = $this->partenaireModels->insertPartenaire(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_add_partenaire"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_add_partenaire"]]);
        Utils::redirect("partenaire", "listePartenaire");
    }

    public function ajoutPartenaire()
    {
        $pass = Utils::getGeneratePassword(12);
        $pwd = $pass['pass'];
        $this->paramPOST["password"] = sha1($pwd);
        $rs = $this->paramPOST["raison_sociale"];
        $email = $this->paramPOST["email"];
        $login = $this->paramPOST["login"];

        //var_dump($this->paramPOST); die();

        if (Utils::validateMail($this->paramPOST["email"])) {

            if (!$this->partenaireModels->VerifEmail($this->paramPOST["email"])) {

                $this->paramPOST["user_creation"]= $this->_USER->id;
                $result = $this->partenaireModels->insertPartenaire(["champs" => $this->paramPOST]);

                if ($result !== false){
                    Utils::envoiparametrePartenaire($rs, $email, $login, $pwd);
                    Utils::setMessageALert(["success", $this->lang["succes_add_partenaire"]]);
                }
                else Utils::setMessageALert(["danger", $this->lang["echec_add_partenaire"]]);

            } else Utils::setMessageALert(["danger", $this->lang["email_existe"]]);

        } else Utils::setMessageALert(["warning", $this->lang["email_invalide"]]);

        Utils::redirect("partenaire", "listePartenaire");

    }

    // Vérifier si email existe déjà
    public function verifExistenceEmail()
    {
        $verif = $this->partenaireModels->verifEmailModel($this->paramPOST['email']);
        if($verif==1) echo 1;
        else echo -1;
    }

    // Vérifier si email existe déjà
    public function verifExistenceLogin()
    {
        $verif = $this->partenaireModels->verifLoginModel($this->paramPOST['login']);
        if($verif==1) echo 1;
        else echo -1;
    }

    // Modal Modification Partenaire
    public function modifPartenaireModal()
    {
        $data['partenaire'] = $this->partenaireModels->getPartenaire(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal();
    }

    // Modification Partenaire
    public function updatePartenaire()
    {
        //parent::validateToken("partenaire", "listePartenaire");
        $data['condition'] = ["rowid = " => base64_decode($this->paramPOST['rowid'])];
        unset($this->paramPOST['rowid']);
        $data['champs'] = $this->paramPOST;
        //var_dump($data['champs']); die();
        $result = $this->partenaireModels->updatePartenaire($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_partenaire"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update_partenaire"]]);
        Utils::redirect("partenaire", "listePartenaire");
    }

    // Supression Partenaire
    public function removePartenaire()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->partenaireModels->deletePartenaire(["condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_delete_partenaire"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_delete_partenaire"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_delete_partenaire"]]);
        Utils::redirect("partenaire", "listePartenaire");
    }

    // Liste Partenaire
    public function listePartenaire()
    {
        $this->views->getTemplate('partenaire/listePartenaire');
    }

    // Processing Partenaire
    public function listePartenairePro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'partenaire', 'modifPartenaireModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            ["partenaire/modifPartenaireModal", "partenaire/modifPartenaireModal", "fa fa-edit"],
                            ["partenaire/configPartenaireModal", "partenaire/configPartenaireModal", "fa fa-cogs"],
                            ["partenaire/voirPartenaireModal", "partenaire/voirPartenaireModal", "fa fa-eye"]
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["partenaire/activatePartenaire/","fa fa-toggle-off"],"1" => ["partenaire/deactivatePartenaire/", "fa fa-toggle-on"]]]
                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => [$this->lang['Modifier'],$this->lang['Configurer'],$this->lang['Voirdetail'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],
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
                $this->processing($this->partenaireModels, 'getAllPartenaire', $param);

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
                $this->processing($this->partenaireModels, 'getAllPartenaire', $param);

            }

        }
    }

    // Activation Partenaire
    public function activatePartenaire()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->partenaireModels->updatePartenaire(["champs" => ["etat" => 1], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_partenaire"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_partenaire"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_activate_partenaire"]]);
        Utils::redirect("partenaire", "listePartenaire");
    }

    // Desactivation Partenaire
    public function deactivatePartenaire()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->partenaireModels->updatePartenaire(["champs" => ["etat" => 0], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_partenaire"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_partenaire"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_partenaire"]]);
        Utils::redirect("partenaire", "listePartenaire");
    }

    //Gestion service Partenaire
    public function configPartenaireModal()
    {
        $etat = 1;
        $data['fk_partenaire']= $this->paramGET[2];
        $data['allCatServices']= $this->partenaireModels->allCatServices();
        $data['actions_autorisees'] = $this->partenaireModels->allActionsAutoriseByPartenaire(["condition" => ["fk_partenaire = " => $this->paramGET[2], "etat =" => $etat]]);
        $data['partenaire'] = $this->partenaireModels->getPartenaire(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal();
    }

    // Affecter des services à un Partenaire
    public function ajoutServicePartenaire()
    {
       // echo '<pre>';var_dump($this->paramPOST);die();

        $id = $this->paramPOST['fk_partenaire'];
        $lesactionscoches = array();
        $lesactionscoches = $this->paramPOST['fk_service'];
        $nbre = sizeof($lesactionscoches);
        $rst= $this->partenaireModels->deleteAutoriseService(["condition" => ["fk_partenaire = " => $id]]);
        for($i = 0 ; $i < count($this->paramPOST["fk_service"]) ; $i++){
            $total = intval($this->paramPOST["pourcentage_partenaire"][$i])+intval($this->paramPOST["pourcentage_sva"][$i])+intval($this->paramPOST["pourcentage_fournisseur"][$i]);
            if($total == 100)
            {
                $this->paramPOST["user_creation"]=$this->_USER->id;
                $rst1= $this->partenaireModels->autoriseService($this->paramPOST["fk_service"][$i],$id,$this->paramPOST["pourcentage_partenaire"][$i],$this->paramPOST["pourcentage_sva"][$i],$this->paramPOST["pourcentage_fournisseur"][$i], $this->_USER->id);
            }
        }
        if($nbre == $i)
        {
            Utils::setMessageALert(["success", $this->lang["sous_action_success"]]);
            Utils::redirect('partenaire', 'listePartenaire');
        }
    }
    // Modal Modification Partenaire
    public function voirPartenaireModal()
    {
        $etat = 1;
        $data['fk_partenaire']= $this->paramGET[2];
        $data['allCatServices']= $this->partenaireModels->allCatServices();
        $data['actions_autorisees'] = $this->partenaireModels->allActionsAutoriseByPartenaire(["condition" => ["fk_partenaire = " => $this->paramGET[2], "etat =" => $etat]]);
        $data['partenaire'] = $this->partenaireModels->getPartenaire(["condition" => ["rowid = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal();
    }

    /******************** FIN Gestion des Partenaires  *************************/


    /**************************************************************** FIN GESTION DES PARTENAIRES ********************************************************/




}