<?php


namespace app\controllers\distributeur;

use app\core\BaseController;
use app\core\Session;
use app\core\Utils;
use app\models\AgentModel;
use app\models\DistributeurModel ;
use app\models\ClientModel;


class AgentController extends BaseController
{

    private $distributeur;
    private $clientModels;
    private $agentModels;

    public function __construct()
    {

        parent::__construct();

        $this->distributeur = new DistributeurModel();
        $this->clientModels = new ClientModel();
        $this->agentModels = new AgentModel();
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_operations"]);

        //var_dump($this->_USER);die;

    }

    public function agentIndex__(){
        $this->views->getTemplate('agentDistributeur');
    }

    public function ajoutAgentModal__(){
        $this->views->getPage('ajoutAgentModal');
    }
    public function ajoutAgent__()
    {

        $this->paramPOST['login'] = $this->paramPOST["email_agent"];;
        $pass = Utils::getGeneratePassword(12);
        $pwd = $pass['pass'];
        $this->paramPOST["password"] = sha1($pwd);
        $this->paramPOST['gie'] = $this->_USER->gie;
        $this->paramPOST['fk_distributeur'] = $this->_USER->fk_distributeur;
        if (Utils::validateMail($this->paramPOST["email_agent"])) {

            $result = $this->agentModels->insertAgent(["champs" => $this->paramPOST]);
            if ($result !== false){
                Utils::envoiparametreDistributeur($this->paramPOST['prenom_agent'] . ' ' . $this->paramPOST['nom_agent'], $this->paramPOST['email_agent'], $this->paramPOST['login'], $pwd );
                Utils::setMessageALert(["success", $this->lang["distributeurAdded"]]);
                echo 'YES';
            }

            else Utils::setMessageALert(["danger", $this->lang["echecAjoutDistributeur"]]);
            echo 'NO';

        } else Utils::setMessageALert(["warning", $this->lang["email_invalide"]]);

        Utils::redirect("agent", "listeAgent");

    }

    public function getIdDistributeur($nom_point, $email, $login)
    {
        $this->table = "distributeur d";
        $this->champs = ["d.id as idDistri"];
        $this->condition=["d.nom_point) ="=> $nom_point,"d.email_agent ="=>$email, "d.email_login ="=> $login, "d.etat ="=> 1];
        return $this->__detail()->idDistri;
    }

    public function verifExistenceEmail__()
    {
        $verif = $this->clientModels->verifEmailModel($this->paramPOST['email_agent']);
        if($verif==1) echo 1;
        else echo -1;
    }

    public function listeAgent__(){

        $this->views->getTemplate('listeAgent');
    }


    public function getAllAgent__()
    {
        if ($this->_USER) {
           // if ($this->_USER->type == 1 || \app\core\Utils::getModel('agent')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
                $param = [

                    "button" => [
                        "default" => [
                            ["champ" => "etat", "val" => ["0" => ["agent/activateAgent/", "fa fa-toggle-off"], "1" => ["agent/desactivateAgent/", "fa fa-toggle-on"]]],
                            //["bus/detailBus/", "fa fa-search"]
                        ],
                        "modal" => [
                           // ["distri/modifCommissionRechargeModal", "distributeur/modifCommissionRechargeModal", "fa fa-edit"],

                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => [$this->lang['Modifier'], ["champ" => "_etat_", "val" => ["0" => $this->lang['Activer'], "1" => $this->lang['Désactiver']]]],
                        "default" => [["champ" => "etat", "val" => ["0" => $this->lang['Activer'], "1" => $this->lang['Désactiver']]], $this->lang['Supprimer'], $this->lang['Detail']]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm", "confirm"]
                    ],
                    "attribut" => [],
                    "args" => null,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>" . $this->lang['Desactive'] . " </i>"], "1" => ["<i class='text-success'>" . $this->lang['Active'] . "</i>"]]]
                    ],
                    "fonction" => []
                ];
                $this->processing($this->agentModels, 'getAListAgent', $param);
            //}
        }

    }
    public function activateAgent__()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->agentModels->set(["table"=>"agent_distributeur","champs" => ["etat" => 1], "condition" => ["id = " => intval($this->paramGET[0])]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_element"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_element"]]);
        } else Utils::setMessageALert(["danger",  $this->lang["echec_activate_element"]]);
        Utils::redirect("agent", "listeAgent");
    }

    public function desactivateAgent__()
    {
        //var_dump($this->paramGET[0]);exit;
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->clientModels->set(["table"=>"agent_distributeur","champs" => ["etat" => 0], "condition" => ["id = " => intval($this->paramGET[0])]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_deactivate_element"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_element"]]);
        } else Utils::setMessageALert(["danger",  $this->lang["echec_activate_element"]]);
        Utils::redirect("agent", "listeAgent");
    }

}
