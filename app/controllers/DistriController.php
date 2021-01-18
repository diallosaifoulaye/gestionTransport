<?php


namespace app\controllers;

use app\core\BaseController;
use app\core\Session;
use app\core\Utils;
use app\models\AgentModel;
use app\models\DistributeurModel ;


class DistriController extends BaseController
{

    private $distributeur;
    private $agentModels;

    public function __construct()
    {

        parent::__construct();

        $this->distributeur = new DistributeurModel();
        $this->agentModels = new AgentModel();

        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_admin"]);
        //var_dump($this->_USER);die;

    }



    /*********************** DEBUT Gestion des Distributeurs *********************/

    public function index__()
    {
        $this->views->getTemplate('distributeur/listeDistributeur');

    }

    public function listeDistributeur__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
                $param = [

                    "button" => [
                        "modal" => [
                            ["distri/modifDistributeurModal", "distributeur/modifDistributeurModal", "fa fa-edit"],

                        ],
                        "default" => [
                            ["champ" => "etat", "val" => ["0" => ["distri/activate/", "fa fa-toggle-off"], "1" => ["distri/deactivate/", "fa fa-toggle-on"]]],
                            /*["bus/removeCategorie/", "fa fa-trash"],*/
                            ["distri/detailDistributeur/", "fa fa-search"]
                        ],

                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => [$this->lang['Modifier'], ["champ" => "_etat_", "val" => ["0" => $this->lang['Activer'], "1" => $this->lang['Désactiver']]]],
                        "default" => [["champ" => "etat", "val" => ["0" => $this->lang['Activer'], "1" => $this->lang['Désactiver']]], $this->lang['Detail']]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => null,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>" . $this->lang['Desactive'] . " </i>"], "1" => ["<i class='text-success'>" . $this->lang['Active'] . "</i>"]]]
                    ],
                    "fonction" => []
                ];
                $this->processing($this->distributeur, 'getAllDistributeur', $param);
            } else {
                $param = [
                    "button" => [
                        "modal" => [
                            //["bus/modifCategorieModal", "bus/modifCategorieModal", "fa fa-edit"],

                        ],
                        "default" => [
                            //["bus/detailBus/", "fa fa-search"]
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
                $this->processing($this->distributeur, 'getAllDistributeur', $param);

            }

        }
    }


    public function ajoutDistributeurModal()
    {
        $data['regions'] = $this->distributeur->get(["table"=>"region"]);
        $this->views->setData($data);
        $this->views->getTemplate("distributeur/ajoutDistributeurModal");
    }


    public function getDepartementByRegion__()
    {
        $idOrcav = $this->paramPOST['idRegion'];
        $data['departements'] = $this->distributeur->getDepartementByRegion($idOrcav);
        print_r(json_encode($data['departements'])) ;

    }


    public function verifExistenceEmail()
    {
        $verif = $this->distributeur->verifEmailModel($this->paramPOST['email_agent']);
        if ($verif == 1) echo 1;
        else echo -1;
    }

    public function verifExistenceLogin()
    {
        $verif = $this->distributeur->verifLoginModel($this->paramPOST['login']);
        if ($verif == 1) echo 1;
        else echo -1;
    }

    public function ajoutDistributeur()
    {
        //var_dump( );die;

        /* $this->paramPOST['nom_point'] = $this->paramPOST["nom_point"];
         $this->paramPOST['email_point'] = $this->paramPOST["email_point"];
         $this->paramPOST['adresse_point'] = $this->paramPOST["adresse_point"];
         $this->paramPOST['region'] = $this->paramPOST["region"];
         $this->paramPOST['departement'] = $this->paramPOST["departement"];
         $this->paramPOST['telephone_point'] = $this->paramPOST["telephone_point"];
         $this->paramPOST['nom_agent'] = $this->paramPOST["nom_agent"];
         $this->paramPOST['prenom_agent'] = $this->paramPOST["prenom_agent"];
         $this->paramPOST['email_agent'] = $this->paramPOST["email_agent"];
         $this->paramPOST['adresse_agent'] = $this->paramPOST["adresse_agent"];
         $this->paramPOST['telephone_agent'] = $this->paramPOST["telephone_agent"];*/
        $this->paramPOST['login'] = $this->paramPOST["email_agent"];;
        $pass = Utils::getGeneratePassword(12);
        $pwd = $pass['pass'];
        $this->paramPOST["password"] = sha1($pwd);
        //$this->paramPOST['password'] = sha1($this->paramPOST["password"]);
        $this->paramPOST['gie'] = $this->_USER->gie;
        $this->paramPOST['user_creation'] = $this->_USER->id;

        //AGENT
        $data['prenom_agent'] =  $this->paramPOST['prenom_agent'];
        $data['nom_agent'] =  $this->paramPOST['nom_agent'];
        $data['email_agent'] =  $this->paramPOST['email_agent'];
        $data['telephone_agent'] =  $this->paramPOST['telephone_agent'];
        $data['adresse_agent'] =  $this->paramPOST['adresse_agent'];
        $data['login'] =  $this->paramPOST['email_agent'];
        $data['password'] =  sha1($pwd);;
        $data['gie'] =  $this->paramPOST['gie'];
        $data['type'] =  1;

        if (Utils::validateMail($this->paramPOST["email_agent"])) {

            $result = $this->distributeur->insertDistributeur(["champs" => $this->paramPOST]);
            if($result){
                $data['fk_distributeur'] = $this->distributeur->getIdDistributeur($this->paramPOST["nom_point"], $this->paramPOST['email_agent'], $this->paramPOST['login']);
                $resultAgent = $this->agentModels->insertAgent(["champs" => $data]);

            }

            if ($result !== false && $resultAgent !== false){
                Utils::envoiparametreDistributeur($this->paramPOST['prenom_agent'] . ' ' . $this->paramPOST['nom_agent'], $this->paramPOST['email_agent'], $this->paramPOST['login'], $pwd );
                Utils::setMessageALert(["success", $this->lang["distributeurAdded"]]);
            }

            else Utils::setMessageALert(["danger", $this->lang["echecAjoutDistributeur"]]);

        } else Utils::setMessageALert(["warning", $this->lang["email_invalide"]]);

        Utils::redirect("distri", "index");

    }

    public function activate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->distributeur->updateDistributeur(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", "Profil activé avec succes"]);
            else Utils::setMessageALert(["danger", "Echec de l'activation du Profil"]);
        } else Utils::setMessageALert(["danger", "Echec de l'activation du profil"]);
        Utils::redirect("distri", "index");
    }

    public function deactivate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->distributeur->updateDistributeur(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", "Profil desactivé avec succes"]);
            else Utils::setMessageALert(["danger", "Echec de la desactivation du profil"]);
        } else Utils::setMessageALert(["danger", "Echec de la desactivation du profil"]);
        Utils::redirect("distri", "index");
    }

    public function modifDistributeurModal(){
        $data['distributeur'] = $this->distributeur->getOneDistributeur(["condition" => ["id = " => $this->paramGET[2]]]);
        $this->views->setData($data);
        $this->modal();

    }

    public function updateDistributeur()
    {
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->distributeur->updateDistributeur($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["distributeurModif"]]);
        else Utils::setMessageALert(["danger",$this->lang["distributeurEchec"]]);
        Utils::redirect("distri", "index");

    }


    public function detailDistributeur(){

        if (isset($this->paramPOST["datedebut"]) && isset($this->paramPOST["datefin"])) {
            $data['datedebut'] = $this->paramPOST['datedebut'];
            $data['datefin'] = $this->paramPOST['datefin'];
        }
        //CARTE
        $data['distributeur'] = $this->distributeur->getOneDistributeur(["condition" => ["id = " => $this->paramGET[0]]]);
        $data['nbreCarte'] = $this->distributeur->nbreCarteVendueByDistributeurMonth($data['distributeur']->id);
        $data['montantTotal'] = $this->distributeur->montantSoldeCarteVenduByDistributeurMonth($data['distributeur']->id);
        $data['montantVerse'] = $this->distributeur->montantVerseByDistributeurMonth($data['distributeur']->id);
        $data['montantNonVerse'] = $this->distributeur->montantNonVerseByDistributeurMonth($data['distributeur']->id);
        //RECHARGE
        $data['nbreRecharge'] = $this->distributeur->nbreRechargeVendueByDistributeurMonth($data['distributeur']->id);
        $data['montantTotalRecharge'] = $this->distributeur->montantSoldeRechargeVenduByDistributeurMonth($data['distributeur']->id);
        $data['montantRechargeVerse'] = $this->distributeur->montantVerseRechargeByDistributeurMonth($data['distributeur']->id);
        $data['montantRechargeNonVerse'] = $this->distributeur->montantNonVerseRechargeByDistributeurMonth($data['distributeur']->id);


        $this->views->setData($data);
        $this->views->getTemplate('distributeur/detailDistributeur');
    }
    public function venteCarteByDate()
    {

        $data['date_deb'] = (isset($this->paramPOST['date_deb']))? $this->paramPOST['date_deb']:'';
        $data['date_fin'] = (isset($this->paramPOST['date_fin']))? $this->paramPOST['date_fin']:'';
        //var_dump($data['date_deb']);die;
        $this->views->setData($data);
        $this->views->getTemplate('distributeur/detailDistributeur');
    }
    public function getAllCardByDistributeurMonthEnCours(){
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
                $param = [

                    "button" => [
                        "modal" => [
                            ["distri/modifDistributeurModal", "distributeur/modifDistributeurModal", "fa fa-edit"],

                        ],
                        "default" => [
                            ["champ" => "etat", "val" => ["0" => ["distri/activate/", "fa fa-toggle-off"], "1" => ["distri/deactivate/", "fa fa-toggle-on"]]],
                            /*["bus/removeCategorie/", "fa fa-trash"],*/
                            ["distri/detailDistributeur/", "fa fa-search"]
                        ],

                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => [$this->lang['Modifier'], ["champ" => "_etat_", "val" => ["0" => $this->lang['Activer'], "1" => $this->lang['Désactiver']]]],
                        "default" => [["champ" => "etat", "val" => ["0" => $this->lang['Activer'], "1" => $this->lang['Désactiver']]], $this->lang['Supprimer'], $this->lang['Detail']]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => $this->paramGET,
                    "dataVal" => [
                        ["champ" => "statut", "val" => ["0" => ["<i class='text-dark'>" . $this->lang['nonVendue'] . " </i>"], "1" => ["<i class='text-success'>" . $this->lang['vendue'] . "</i>"], "2" => ["<i class='text-danger'>" . $this->lang['bloquee'] . "</i>"]]]

                    ],
                    "fonction" => []
                ];
                $this->processing($this->distributeur, 'getAllCardByDistributeurMonthEnCours', $param);
            } else {
                $param = [
                    "button" => [
                        "modal" => [
                            //["bus/modifCategorieModal", "bus/modifCategorieModal", "fa fa-edit"],

                        ],
                        "default" => [
                            //["bus/detailBus/", "fa fa-search"]
                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => $this->paramGET,
                    "dataVal" => [],
                    "fonction" => []
                ];
                $this->processing($this->distributeur, 'getAllCardByDistributeurMonthEnCours', $param);

            }

        }
    }

    public function getAllRechargeByDistributeurMonthEnCours(){
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
                $param = [

                    "button" => [
                        "modal" => [
                            ["distri/modifDistributeurModal", "distributeur/modifDistributeurModal", "fa fa-edit"],

                        ],
                        "default" => [
                            ["champ" => "etat", "val" => ["0" => ["distri/activate/", "fa fa-toggle-off"], "1" => ["distri/deactivate/", "fa fa-toggle-on"]]],
                            /*["bus/removeCategorie/", "fa fa-trash"],*/
                            ["distri/detailDistributeur/", "fa fa-search"]
                        ],

                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => [$this->lang['Modifier'], ["champ" => "_etat_", "val" => ["0" => $this->lang['Activer'], "1" => $this->lang['Désactiver']]]],
                        "default" => [["champ" => "etat", "val" => ["0" => $this->lang['Activer'], "1" => $this->lang['Désactiver']]], $this->lang['Supprimer'], $this->lang['Detail']]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => $this->paramGET,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>" . $this->lang['nonVendue'] . " </i>"], "1" => ["<i class='text-success'>" . $this->lang['vendue'] . "</i>"]]]

                    ],
                    "fonction" => []
                ];
                $this->processing($this->distributeur, 'getAllRechargeByDistributeurMonthEnCours', $param);
            } else {
                $param = [
                    "button" => [
                        "modal" => [
                            //["bus/modifCategorieModal", "bus/modifCategorieModal", "fa fa-edit"],

                        ],
                        "default" => [
                            //["bus/detailBus/", "fa fa-search"]
                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => $this->paramGET,
                    "dataVal" => [],
                    "fonction" => []
                ];
                $this->processing($this->distributeur, 'getAllRechargeByDistributeurMonthEnCours', $param);

            }

        }
    }



    /*********************** DEBUT Gestion des Commissions *********************/

    public function listeCommissionCarte__()
    {
        $this->views->getTemplate('distributeur/listeCarteCommission');

    }

    public function listeCommission__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
                $param = [

                    "button" => [
                        "default" => [
                            ["champ" => "etat", "val" => ["0" => ["distri/activateCommissionCarte/", "fa fa-toggle-off"], "1" => ["distri/deactivateCommissionCarte/", "fa fa-toggle-on"]]],
                            //["bus/detailBus/", "fa fa-search"]
                        ],
                        "modal" => [
                            ["distri/modifCommissionCarteModal", "distributeur/modifCommissionCarteModal", "fa fa-edit"],

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
                $this->processing($this->distributeur, 'getAllCommissionCarte', $param);
            } else {
                $param = [
                    "button" => [
                        "modal" => [
                            ["distri/modifCommissionCarteModal", "distributeur/modifCommissionCarteModal", "fa fa-edit"],

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
                $this->processing($this->distributeur, 'getAllCommissionCarte', $param);

            }

        }
    }

    public function nouvelleCommissionModal(){
        $this->modal();
    }
    public function insertCommission(){
        $result = $this->distributeur->insertCommissionCarte(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang['enregistrementCommssionS']]);
        else Utils::setMessageALert(["danger", $this->lang['echecEnregistrementCommission']]);
        Utils::redirect("distri", "listeCommissionCarte");
    }

    public function modifCommissionCarteModal(){
        $data['commission'] = $this->distributeur->getOneCommissionCarte(["condition" => ["id = " => $this->paramGET[2]]]);
        $this->views->setData($data);
        $this->modal();
    }

    public function updateCommissionCarte(){
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $this->paramPOST['user_modification'] = $this->_USER->id;
        $this->paramPOST['date_modification'] = date("Y-m-d H:i:s");
        $data['champs'] = $this->paramPOST;
        $result = $this->distributeur->updateCommissionCarte($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["commissionModifiee"]]);
        else Utils::setMessageALert(["danger",$this->lang["echecDeLaModification"]]);
        Utils::redirect("distri", "listeCommissionCarte");
    }

    public function activateCommissionCarte(){
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->distributeur->updateCommissionCarte(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang['commissionActive']]);
            else Utils::setMessageALert(["danger", $this->lang['commissionEchecActivation']]);
        } else Utils::setMessageALert(["danger", $this->lang['commissionEchecActivation']]);
        Utils::redirect("distri", "listeCommissionCarte");
    }
    public function deactivateCommissionCarte(){
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->distributeur->updateCommissionCarte(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang['commissionDesactive']]);
            else Utils::setMessageALert(["danger", $this->lang['commissionEhec']]);
        } else Utils::setMessageALert(["danger", $this->lang['commissionEhec']]);
        Utils::redirect("distri", "listeCommissionCarte");
    }


    public function listeCommissionRechargement__()
    {
        $this->views->getTemplate('distributeur/listeCommissionRechargement');

    }

    public function listeCommissionRecharge__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
                $param = [

                    "button" => [
                        "default" => [
                            ["champ" => "etat", "val" => ["0" => ["distri/activateCommissionRecharge/", "fa fa-toggle-off"], "1" => ["distri/deactivateCommissionRecharge/", "fa fa-toggle-on"]]],
                            //["bus/detailBus/", "fa fa-search"]
                        ],
                        "modal" => [
                            ["distri/modifCommissionRechargeModal", "distributeur/modifCommissionRechargeModal", "fa fa-edit"],

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
                $this->processing($this->distributeur, 'getAllCommissionRechargement', $param);
            } else {
                $param = [
                    "button" => [
                        "modal" => [
                            ["distri/modifCommissionCarteModal", "distributeur/modifCommissionCarteModal", "fa fa-edit"],

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
                $this->processing($this->distributeur, 'getAllCommissionRechargement', $param);

            }

        }
    }

    public function ajoutCommissionRechargementModal(){
        $this->modal();
    }

    public function insertCommissionRecharge(){
        $result = $this->distributeur->insertRechargeCommission(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang['enregistrementCommssionS']]);
        else Utils::setMessageALert(["danger", $this->lang['echecEnregistrementCommission']]);
        Utils::redirect("distri", "listeCommissionRechargement");
    }
    public function modifCommissionRechargeModal(){
        $data['commission'] = $this->distributeur->getOneCommissionRecharge(["condition" => ["id = " => $this->paramGET[2]]]);
        $this->views->setData($data);
        $this->modal();
    }

    public function updateCommissionRechargement(){
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $this->paramPOST['user_modification'] = $this->_USER->id;
        $this->paramPOST['date_modification'] = date("Y-m-d H:i:s");
        $data['champs'] = $this->paramPOST;
        $result = $this->distributeur->updateCommissionRecharge($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["commissionModifiee"]]);
        else Utils::setMessageALert(["danger",$this->lang["echecDeLaModification"]]);
        Utils::redirect("distri", "listeCommissionRechargement");
    }

    public function activateCommissionRecharge(){
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->distributeur->updateCommissionRecharge(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang['commissionActive']]);
            else Utils::setMessageALert(["danger", $this->lang['commissionEchecActivation']]);
        } else Utils::setMessageALert(["danger", $this->lang['commissionEchecActivation']]);
        Utils::redirect("distri", "listeCommissionRechargement");
    }
    public function deactivateCommissionRecharge(){
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->distributeur->updateCommissionRecharge(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang['commissionDesactive']]);
            else Utils::setMessageALert(["danger", $this->lang['commissionEhec']]);
        } else Utils::setMessageALert(["danger", $this->lang['commissionEhec']]);
        Utils::redirect("distri", "listeCommissionCarte");
    }

    public function verifExistenceCarte__($numSerie='',$type='')
    {
        if ($numSerie == '')
            $numSerie = $this->paramPOST['debut_numeroSerie'] ;

        $param1 = [
            "table"=>"carte c",
            "champs"=>["c.numero_serie"],
            "condition"=>["c.numero_serie = " => $numSerie]
        ];
        $carte = $this->agentModels->get($param1);
        if($carte){
            $param = [
                "table"=>"carte c",
                "champs"=>["u.id","u.nom", "u.prenom","telephone", "c.numero_serie"],
                "jointure" => ["INNER JOIN client u on u.id = c.client"],

                "condition"=>["c.numero_serie = " => $numSerie]
            ];
            $client = $this->agentModels->get($param);
            if ($client){
                $message = $this->lang['carte_deja_attribue_a']." ".$client[0]->prenom.' '.$client[0]->nom.' Telephone '.$client[0]->telephone ;
                if ($type != '')
                    return array('code'=>-2,'message'=>$message) ;
                else
                    echo json_encode(array('code'=>-2,'message'=>$message)) ;
            }else{
                $message = $this->lang['carte_disponible'] ;

                if ($type != '')
                    return array('code'=>1,'message'=>$message) ;
                else
                    echo json_encode(array('code'=>1,'message'=>$message)) ;
            }
        }else{
            $message = $this->lang['carte_inexsistante'] ;

            if ($type != '')
                return array('code'=>-1,'message'=>$message) ;
            else
                echo json_encode(array('code'=>-1,'message'=>$message)) ;
        }

    }

    public function ajoutDistributionModal__()
    {
        $data['distributeur'] = $this->distributeur->allDistributeur();
        $this->views->setData($data);
        return $this->modal();
    }
    public function insertDistribution__(){
        $numSerie = $this->paramPOST['debut_numeroSerie'];
        $fk_distributeur = $this->paramPOST['distribution'];
        $nbre_carte = $this->paramPOST['nbre_carte'];
        $limiteCarte = (int) $numSerie+ (int) $nbre_carte;
        //var_dump($numSerie.' '.$limiteCarte);die;
        $this->paramPOST['fin_numeroSerie'] = $limiteCarte;

        $result = $this->distributeur->insertDistribution(["champs" => $this->paramPOST]);
        if ($result !== false) {
            $liste = $this->distributeur->listeNumeroSerie();

            $UpdateCarte = $this->distributeur->set([
                "table"=>"carte", "champs"=>["distribue_A = "=> $fk_distributeur],
                "condition"=>["numero_serie >=" =>$numSerie, "numero_serie <=" =>$limiteCarte]]);
            Utils::setMessageALert(["success", $this->lang['enregistrementCommssionS']]);
        }
        else Utils::setMessageALert(["danger", $this->lang['echecEnregistrementCommission']]);
        Utils::redirect("distri", "listeDistributionCarte");
    }
    public function listeDistributionCarte__(){
        $this->views->getTemplate('distributeur/listeDistributionCarte');
    }
    public function listeDistributionCarteProcess__(){
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
                $param = [

                    "button" => [
                        "default" => [
                            // ["champ" => "etat", "val" => ["0" => ["distri/activateCommissionCarte/", "fa fa-toggle-off"], "1" => ["distri/deactivateCommissionCarte/", "fa fa-toggle-on"]]],
                            //["bus/detailBus/", "fa fa-search"]
                        ],
                        "modal" => [
                            // ["distri/modifCommissionCarteModal", "distributeur/modifCommissionCarteModal", "fa fa-edit"],

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
                $this->processing($this->distributeur, 'getAllDistributionCarte', $param);
            }
        }


    }
}
