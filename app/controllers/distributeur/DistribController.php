<?php


namespace app\controllers\distributeur;

use app\core\BaseController;
use app\core\Session;
use app\core\Utils;
use app\models\AgentModel;
use app\models\DistributeurModel ;
use app\models\ClientModel;


class DistribController extends BaseController
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



    /*************activer Distributeur***********/
    public function updatePasswordDistributeur__()
    {
        //var_dump($this->_USER);die;
        $data['condition'] = ["id = " => $this->_USER->id];
        unset($this->paramPOST['ancienpass']);
        unset($this->paramPOST['mot_de_passe1']);
        $this->paramPOST['password'] = sha1($this->paramPOST['password']);

        $data['champs'] = $this->paramPOST;

        if($this->paramPOST['type']==1){
            $result = $this->distributeur->updatePassDistributeur($data);
            $result1 = $this->agentModels->updatePassAgent($data);


        }elseif($this->paramPOST['type']==2){
            $result = $this->agentModels->updatePassAgent($data);

        }
        if ($result !== false) {
            Session::destroySession();
            Utils::setMessageALert(["success", "Modification mot de passe avec succès"]);
            Utils::redirect("home", "index");
        }
        else {
            Utils::setMessageALert(["danger", "Echec de la modification du mot de passe"]);
            Utils::redirect("home", "firstConnect");
        }

    }

    /*********************** FIN*********************/


    public function operationIndex__()
    {
        $this->views->getTemplate('operations');
    }
    public function ajoutClientModal()
    {

        $data['professions'] = $this->clientModels->get(["table"=>"profession","champs"=>["rowid , libelle"]]);
        $data['montant'] = $this->clientModels->get(["table"=>"commission_carte","champs"=>["id , montant_carte"]]);

        $this->views->setData($data);
        $this->views->getPage('ajoutClientModal');
    }
    public function verifExistenceCarte__($numSerie='',$type='')
    {
        if ($numSerie == '')
            $numSerie = $this->paramPOST['numcarte'] ;

        $param1 = [
            "table"=>"carte c",
            "champs"=>["c.numero_serie"],
            "condition"=>["c.numero_serie = " => $numSerie]
        ];
        $carte = $this->clientModels->get($param1);
        if($carte){
            $param = [
                "table"=>"carte c",
                "champs"=>["u.id","u.nom", "u.prenom","telephone", "c.numero_serie"],
                "jointure" => ["INNER JOIN client u on u.id = c.client"],

                "condition"=>["c.numero_serie = " => $numSerie]
            ];
            $client = $this->clientModels->get($param);
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

    public function ajoutClient__()
    {
        $this->paramPOST['gie'] = $this->_USER->gie;
        $montant_carte = (int) $this->paramPOST['montant'];
        $email =  $this->paramPOST['email'];
        try{
            $this->clientModels->__beginTransaction() ;


            $commission =  (int) $this->distributeur->getCommissionEnrollement($montant_carte);
            $param1 = [
                "table"=>"carte c",
                "champs"=>["c.id", "c.part_distributeur" ,"c.client","c.date_creation","c.part_nta"],
                "condition"=>["c.user_creation = " => $this->_USER->id]
            ];
            $part_Nta = $montant_carte - $commission;
            //$nouvelle_commission = $ancien_commission+$commission;
            $numserie = $this->paramPOST['numcarte'] ;
            $login = $this->paramPOST['telephone'] ;
            $cleSecrete = Utils::getIntegerUnique(4) ;
            $email = $this->paramPOST['email'] ;
            $password = 'admin' ;

            $this->paramPOST['password'] = sha1($password) ;
            $this->paramPOST['cle_secrete'] = sha1($cleSecrete) ;
            $this->paramPOST['login'] = $login ;

            $this->paramPOST['telephone'] = str_replace('+','00',$this->paramPOST['telephone']);
            $this->paramPOST['date_naissance'] =  Utils::date_aaaa_mm_jj($this->paramPOST['date_naissance']) ;
            unset($this->paramPOST['numcarte']);
            unset($this->paramPOST['montant']);

            $retour = $this->verifExistenceCarte__($numserie,1)  ;
            if ($retour['code'] == 1){

                if (Utils::validateMail($this->paramPOST["email"])) {

                    if (!$this->clientModels->VerifEmail(['client', 'email'], $this->paramPOST["email"])) {


                        $this->paramPOST["user_creation"]= $this->_USER->id;
                        $result = $this->clientModels->insertClient(["champs" => $this->paramPOST]);

                        if (!($result))
                            throw new \Exception($this->lang["echec_add_client"].' table client') ;

                        $resultUpdateCarte = $this->clientModels->set([
                            "table"=>"carte", "champs"=>["client =  "=>$result, "statut = "=> 1, "date_creation = "=>date("Y-m-d H:i:s"), "user_creation = "=>$this->_USER->id, "montant_enrole ="=>$montant_carte,"solde ="=>$montant_carte, "fk_distributeur ="=>$this->_USER->fk_distributeur, "part_nta ="=>$part_Nta, "part_distributeur ="=>$commission],
                            "condition"=>["numero_serie ="=>$numserie]]);

                        if (!$resultUpdateCarte)
                            throw new \Exception($this->lang["echec_add_client"].' table carte') ;

                    } else
                        throw new \Exception($this->lang["email_existe"]) ;

                } else
                    throw new \Exception($this->lang["emailInvalide"]) ;

            }else
                throw new \Exception($retour['message']) ;

            $prenom = $this->paramPOST['prenom'] ;
            $nom = $this->paramPOST['nom'] ;

            Utils::envoiparametreClient($prenom.' '.$nom, $email, $login, $password, $cleSecrete, $numserie);

            $this->clientModels->__commit() ;


            Utils::setMessageALert(["success", $this->lang["client_ajoute_avec_succes"]]);

        }catch (\Exception $exception){

            $this->clientModels->__rollBack() ;
            Utils::setMessageALert(["danger", $exception->getMessage()]);
        }
        $param2 = [
            "table"=>"client cl",
            "champs"=>["cl.id"],
            "condition"=>["cl.user_creation = " => $this->_USER->id, "cl.email ="=> $email ]
        ];
        $idclient = (int) ($this->clientModels->get($param2)[0])->id;
        //$idclient = (int) ($this->clientModels->get($param)[0])->client;
       // var_dump($idclient);die;

        Utils::redirect("distrib", "detailClient/".$idclient);

    }

    public function verifExistenceEmail__()
    {
        $verif = $this->clientModels->verifEmailModel($this->paramPOST['email']);
        if($verif==1) echo 1;
        else echo -1;
    }

    /**
     * GESTION RECHARGEMENT CARTE
     */
    public function ajoutRechargementModal()
    {
        $this->views->getPage('ajoutRechargementModal');
    }

    public function ajoutRechargement__()
    {
       $this->clientModels->__beginTransaction() ;

        $numSerie = $this->paramPOST['numcarte'] ;
        $numSerie = (int) $numSerie;
        $montant =  $this->paramPOST['montant'] ;
        $montant =  (int) ($montant) ;
        $param = [
            "table"=>" commission_rechargement c",
            "champs"=>["c.id","c.commission"],
            "condition"=>["c.recharge_min <= " => $montant, "c.recharge_max >= " => $montant]
        ];
        $commission = (int) $this->clientModels->get($param)[0]->commission;
        $param1 = [
            "table"=>"carte c",
            "champs"=>["c.id", "c.client","c.solde"/*, "h.solde_avant"*/],
            "jointure" => [
                "INNER JOIN client cl ON cl.id = c.client"
             //   "INNER JOIN histo_rechargement h ON h.carte_id = c.id"
            ],
            "condition"=>["c.numero_serie = " => $numSerie]
        ];
        $carte = $this->clientModels->get($param1)[0];
        $ancien_solde = (int) $carte->solde ;
        $updateSolde = $ancien_solde+$montant;
        $idClient = (int) $carte->client ;
        $idCarte = (int) $carte->id ;

        $param2 = [
            "table"=>"histo_rechargement h",
            "champs"=>["h.id","h.part_distributeur", "h.part_nta","c.client", ("h.date_transac")],
            "jointure" => [
                "INNER JOIN carte c on h.carte_id = c.id",
                "INNER JOIN client cl on cl.id = c.client"
            ],
            "condition"=>[ "h.user_id =" =>$this->_USER->id ]
        ];
        $partNta = $montant-$commission;
        //$ancien_partNta = end($this->clientModels->get($param2))->part_nta;
        //$ancien_commission =  end($this->clientModels->get($param2))->part_distributeur;

        try{
            if ($idCarte){

                $champs = array();
                $champs['user_id'] =  $this->_USER->id;
                $champs['fk_distributeur'] = $this->_USER->fk_distributeur;
                $champs['carte_id'] = $idCarte ;
                $champs['etat'] = 1 ;
                $champs['date_transac'] = date("Y-m-d H:i:s") ;
                $champs['num_transac'] = $this->clientModels->Generer_numtransaction() ;
                $champs['montant'] = $montant;
                $champs['solde_avant'] = $ancien_solde;
                $champs['solde_apres'] = intval($montant + $ancien_solde);
                $champs['part_distributeur'] = $commission ;
                $champs['part_nta'] = $partNta ;
                $resultHisto = $this->clientModels->set(["table"=>"histo_rechargement","champs" => $champs]);
                if (!($resultHisto))
                    throw new \Exception($this->lang["echec_add_element"].' table histo_rechargement') ;


                $resultUpdateCarte = $this->clientModels->set(["table"=>"carte", "champs"=>["solde =" => $updateSolde], "condition"=>["id ="=>$idCarte]]);

                if (!$resultUpdateCarte)
                    throw new \Exception('echec insert table carte') ;

            }else
                throw new \Exception($this->lang["carte_inexsistante"]) ;


            $this->clientModels->__commit() ;
            Utils::setMessageALert(["success", $this->lang["succes_add_element"]]);
           // Utils::redirect("distib", "historiqueRechargement");


        }catch (\Exception $e){
            $this->clientModels->__rollBack() ;
            Utils::setMessageALert(["danger",  $this->lang["echec_add_element"]." ".$e->getMessage()]);
           // Utils::redirect("distrib", "historiqueRechargement");

        }
        //$this->views->getTemplate('historiqueRechargement');

        Utils::redirect("distrib", "detailClient/".$idClient);

    }
    public function ajoutRechargementDetail__()
    {
        $this->clientModels->__beginTransaction() ;
        try{
            $idClient = (int) ($this->paramPOST['idClient']) ;
            $montant =  (int) ($this->paramPOST['montant']) ;

            $param1 = [
                "table"=>" carte c",
                "champs"=>["c.id","c.numero_serie", "c.client", "c.solde"],
                "condition"=>[ "c.client =" =>$idClient ]
            ];
            $carte = $this->clientModels->get($param1)[0];
            $idCarte = (int) ($carte->id) ;
            $ancienSolde = (int) ($carte->solde) ;
            $param = [
                "table"=>" commission_rechargement c",
                "champs"=>["c.id","c.commission"],
                "condition"=>["c.recharge_min <= " => $montant, "c.recharge_max >= " => $montant]
            ];
            $commission = (int) $this->clientModels->get($param)[0]->commission;
            $param2 = [
                "table"=>"histo_rechargement h",
                "champs"=>["h.id","h.part_distributeur", "c.client", ("h.date_transac")],
                "jointure" => [
                    "INNER JOIN carte c on h.carte_id = c.id",
                    "INNER JOIN client cl on cl.id = c.client"
                ],
                "condition"=>[ "h.user_id =" =>$this->_USER->id ]
            ];
            $updateSolde = $ancienSolde+$montant;

            if ($idCarte){
                $champs = array();
                $champs['user_id'] =  $this->_USER->id;
                $champs['fk_distributeur'] = $this->_USER->fk_distributeur;
                $champs['carte_id'] = $idCarte ;
                $champs['etat'] = 1 ;
                $champs['date_transac'] = date("Y-m-d H:i:s") ;

                $champs['num_transac'] = $this->clientModels->Generer_numtransaction() ;
                $champs['montant'] = $montant;
                $champs['solde_avant'] = $ancienSolde;
                $champs['solde_apres'] = intval($montant + $ancienSolde);
                $champs['part_distributeur'] = $commission ;
                $champs['part_nta'] = $montant-$commission;


                $resultHisto = $this->clientModels->set(["table"=>"histo_rechargement","champs" => $champs]);
                if (!($resultHisto))
                    throw new \Exception($this->lang["echec_add_element"].' table histo_rechargement') ;


                $resultUpdateCarte = $this->clientModels->set(["table"=>"carte", "champs"=>["solde =" => $updateSolde], "condition"=>["id ="=>$idCarte]]);

                if (!$resultUpdateCarte)
                    throw new \Exception('echec insert table carte') ;

            }else
                throw new \Exception($this->lang["carte_inexsistante"]) ;


            $this->clientModels->__commit() ;
            Utils::setMessageALert(["success", $this->lang["succes_add_element"]]);

        }catch (\Exception $e){
            $this->clientModels->__rollBack() ;
            Utils::setMessageALert(["danger",  $this->lang["echec_add_element"]." ".$e->getMessage()]);
        }

        Utils::redirect("distrib", "detailClient/".$idClient);

    }

    public function historiqueRechargementByNum__(){
            $this->views->getTemplate('historiqueRechargement');
    }

    public function rechargementByNumPro__()
    {
        $param = [
            "button" => [
                "modal" => [
                    ["client/modifClientModal", "client/modifClientModal", "fa fa-edit"]
                ],
                "default" => [
                    ["champ" => "etat","val" => ["0" => ["client/activateClient/","fa fa-toggle-off"],"1" => ["client/desactivateClient/", "fa fa-toggle-on"]]],
                    ["client/detailClient/", "fa fa-search"],
                ]
                //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
            ],
            "tooltip" => [
                "modal" => [$this->lang['Modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],
                "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['Detail']]
            ],
            "classCss" => [
                "modal" => [],
                "default" => ["confirm"]
            ],
            "attribut" => [],
            "args" => $this->paramGET,
            "dataVal" => [
                ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
            ],
            "fonction" => ["montant"=>"getMontant","solde_avant"=>"getMontant","solde_apres"=>"getMontant"]
        ];

        $this->processing($this->distributeur, 'getRechargementByClient', $param);

    }

    public function historiqueRechargementAll__(){
        $this->views->getTemplate('operations');
    }

    public function rechargementAll__()
    {
        $param = [
            "button" => [
                "modal" => [
                    ["client/modifClientModal", "client/modifClientModal", "fa fa-edit"]
                ],
                "default" => [
                    ["champ" => "etat","val" => ["0" => ["client/activateClient/","fa fa-toggle-off"],"1" => ["client/desactivateClient/", "fa fa-toggle-on"]]],
                    ["client/detailClient/", "fa fa-search"],
                ]
                //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
            ],
            "tooltip" => [
                "modal" => [$this->lang['Modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],
                "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['Detail']]
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
            "fonction" => ["montant"=>"getMontant","solde_avant"=>"getMontant","solde_apres"=>"getMontant"]
        ];

        $this->processing($this->distributeur, 'getAllRechargementClient', $param);

    }


    public function listeClient__()
    {
        $this->views->getTemplate("listeClient");
    }
    public function listePro__()
    {
        if ($this->_USER) {
            if ($this->_USER->type == 1 || \app\core\Utils::getModel('client')->__authorized($this->_USER->idprofil, 'client', 'modifClientModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            /*["client/modifClientModal", "client/modifClientModal", "fa fa-edit"]*/
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["distrib/activateClient/","fa fa-toggle-off"],"1" => ["distrib/desactivateClient/", "fa fa-toggle-on"]]],
                            ["distrib/detailClient/", "fa fa-search"],
                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => [$this->lang['Modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],
                        "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['Detail']]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => $this->_USER,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
                    ],
                    "fonction" => ["solde"=>"getMontant"]
                ];
                $this->processing($this->clientModels, 'getAllClient', $param);

            }else{
                $param = [
                    "button" => [
                        "modal" => [
                            /*["client/modifClientModal", "client/modifClientModal", "fa fa-edit"]*/
                        ],
                        "default" => [
                          //  ["champ" => "etat","val" => ["0" => ["client/activateClient/","fa fa-toggle-off"],"1" => ["client/desactivateClient/", "fa fa-toggle-on"]]],
                            ["distrib/detailClient/", "fa fa-search"],
                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => [$this->lang['Modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],
                        "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['Detail']]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => $this->_USER,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
                    ],
                    "fonction" => ["solde"=>"getMontant"]
                ];
                $this->processing($this->clientModels, 'getAllClient', $param);

            }
        }
    }

    public function detailClient__(){

        $data['client'] = $this->clientModels->get(["table"=>"client c","champs"=>["c.* "," ca.id as idCarte" ,"ca.solde" , "ca.numero_serie","ca.statut"],"jointure"=>[" LEFT JOIN carte ca on  c.id = ca.client  "],"condition" => ["c.id = " => $this->paramGET[0]]])[0];

        $this->views->setData($data);
        $this->views->getTemplate('detailClient');

    }
    public function ajoutBlocageOrActivation__()
    {
        //var_dump($this->paramPOST); exit;
        try{
            $idClient = $this->paramPOST['fk_client'];
            $idCarte = $this->paramPOST['fk_carte'];
            $type = $this->paramPOST['type'] ;
            $this->clientModels->__beginTransaction() ;

            $resultUpdateCarte = $this->clientModels->set(["table"=>"carte", "champs"=>["statut =  "=> $type], "condition"=>["id =" => $idCarte]]);

            if (!$resultUpdateCarte)
                throw new \Exception($this->lang["echec_update"].' table carte') ;

            $result = $this->clientModels->set(["table"=>"carte_commentaires", "champs" => $this->paramPOST]);
            if (!$result)
                throw new \Exception($this->lang["echec_add"].' table carte commentaire') ;


            $this->clientModels->__commit() ;
            Utils::setMessageALert(["success", $this->lang["succes_operation_element"]]);

        }catch (\Exception $exception){
            $this->clientModels->__rollBack() ;
            Utils::setMessageALert(["danger", $exception->getMessage()]);
        }

        Utils::redirect("distrib", "detailClient/".$idClient);
    }
    public function compteBlocked__()
    {
        $this->views->getTemplate("compteBlocked");
    }
    public function listeClientBlocked__()
    {
        if ($this->_USER) {
            if ($this->_USER->type == 1 || \app\core\Utils::getModel('client')->__authorized($this->_USER->idprofil, 'client', 'modifClientModal') > 0) {
                $param = [
                    "button" => [
                        "modal" => [
                            /*["client/modifClientModal", "client/modifClientModal", "fa fa-edit"]*/
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["0" => ["client/activateClient/","fa fa-toggle-off"],"1" => ["client/desactivateClient/", "fa fa-toggle-on"]]],
                            ["client/detailClient/", "fa fa-search"],
                        ]
                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => [$this->lang['Modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],
                        "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['Detail']]
                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm"]
                    ],
                    "attribut" => [],
                    "args" => $this->_USER,
                    "dataVal" => [
                        ["champ" => "statut", "val" => ["2" => ["<i class='text-danger'>".$this->lang['comptes_blocked']." </i>"]]]
                    ],
                    "fonction" => ["solde"=>"getMontant"]
                ];
            }
            $this->processing($this->distributeur, 'getAllCompteBloked', $param);
        }else{
            $param = [
                "button" => [
                    "modal" => [
                        /*["client/modifClientModal", "client/modifClientModal", "fa fa-edit"]*/
                    ],
                    "default" => [
                        ["champ" => "etat","val" => ["0" => ["client/activateClient/","fa fa-toggle-off"],"1" => ["client/desactivateClient/", "fa fa-toggle-on"]]],
                        ["client/detailClient/", "fa fa-search"],
                    ]
                    //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                ],
                "tooltip" => [
                    "modal" => [$this->lang['Modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],
                    "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['Detail']]
                ],
                "classCss" => [
                    "modal" => [],
                    "default" => ["confirm"]
                ],
                "attribut" => [],
                "args" => $this->_USER,
                "dataVal" => [
                    ["champ" => "statut", "val" => ["2" => ["<i class='text-danger'>".$this->lang['comptes_blocked']." </i>"]]]
                ],
                "fonction" => ["solde"=>"getMontant"]
            ];
            $this->processing($this->distributeur, 'getAllCompteBloked', $param);
        }
    }

    public function reenrolement__(){
        $idCarte = $this->paramPOST['idCarte'];
        $oldCard = $this->paramPOST['numSerie'];
        $newCard = $this->paramPOST['numcarte'];
        $idClient = $this->paramPOST['idClient'];
        $param = [
            "table"=>"carte c",
            "champs"=>["c.id", "c.numero_serie", "c.client", "c.statut"],
            "condition"=>["c.numero_serie ="=> $newCard, "c.client ="=>0, "c.statut ="=>0]
        ];
        $param1 = [
            "table"=>"carte c",
            "champs"=>["c.id", "c.numero_serie", "c.client", "c.statut", "c.fk_distributeur", "c.solde","verse", "part_nta", "part_distributeur"],
            "jointure" => [
                "INNER JOIN client cl on cl.id = c.client"
            ],
            "condition"=>["c.id = " => $idCarte, "c.numero_serie ="=> $oldCard, "c.client ="=>$idClient]
        ];


        $carteAReenroller = $this->clientModels->get($param1);
        $carteDisponible = $this->clientModels->get($param);
        if($carteDisponible){
            $UpdateCarteDisponible = $this->clientModels->set([
                "table"=>"carte", "champs"=>["client ="=>$carteAReenroller[0]->client, "statut = "=> 1, "user_creation ="=>$this->_USER->id,"date_creation = "=>date("Y-m-d H:i:s"), "solde ="=>$carteAReenroller[0]->solde, "fk_distributeur ="=>$this->_USER->fk_distributeur, "verse ="=>$carteAReenroller[0]->verse, "part_nta ="=>$carteAReenroller[0]->part_nta, "part_distributeur ="=>$carteAReenroller[0]->part_distributeur],
                "condition"=>["id =" => $carteDisponible[0]->id]]);
            $UpdateCarteAReenroler = $this->clientModels->set([
                "table"=>"carte", "champs"=>["statut = "=> 2],
                "condition"=>["id =" => $carteAReenroller[0]->id]]);
            if($UpdateCarteDisponible){
                $param3 = [
                    "table"=>"carte c",
                    "champs"=>["c.id", "c.numero_serie", "c.client", "c.statut", "c.fk_distributeur", "c.solde"],
                    "jointure" => [
                        "INNER JOIN client cl on cl.id = c.client"
                    ],
                    "condition"=>["c.id = " => $idCarte, "c.numero_serie ="=> $oldCard, "c.client ="=>$idClient]
                ];
            }
        }
        Utils::redirect("distrib", "detailClient/".$idClient);

    }

    public function activateClient__()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->clientModels->set(["table"=>"client","champs" => ["etat" => 1], "condition" => ["id = " => intval($this->paramGET[0])]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_element"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_element"]]);
        } else Utils::setMessageALert(["danger",  $this->lang["echec_activate_element"]]);
        Utils::redirect("distrib", "listeClient");
    }

    public function desactivateClient__()
    {
        //var_dump($this->paramGET[0]);exit;
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->clientModels->set(["table"=>"client","champs" => ["etat" => 0], "condition" => ["id = " => intval($this->paramGET[0])]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_deactivate_element"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_element"]]);
        } else Utils::setMessageALert(["danger",  $this->lang["echec_activate_element"]]);
        Utils::redirect("distrib", "listeClient");
    }

    public function activationBlocagePro__()
    {
        $param = [
            "args" => $this->paramGET,
            "fonction" => ["type"=>"getType"]
        ];

        $this->processing($this->clientModels, 'activationBlocage', $param);

    }

    public function reportingRechargement__()
    {
        if (isset($this->paramPOST["datedebut"]) && isset($this->paramPOST["datefin"])) {
            $data['datedebut'] = $this->paramPOST['datedebut'];
            $data['datefin'] = $this->paramPOST['datefin'];

        }else{
            //echo 65465645; exit;
            $beginEnd = date('Y-m-d', strtotime('Jan 01'));
            $yearEnd = date('Y-m-d', strtotime('12/31'));

            $data['datedebut'] = $beginEnd;
            $data['datefin'] = $yearEnd;
        }

        $data['dataRechargement'] = $this->distributeur->getDataRechargement($data['datedebut'] ,$data['datefin']);
        $data['commissionDistributeur'] = ($this->distributeur->getCommissionRechargement($data['datedebut'] ,$data['datefin']))[0]->commissionDistributeur;
        $this->views->setData($data);

        $this->views->getTemplate('reportingRechargement');

    }
    public function reportingRechargementProcessing__()
    {
        $param = [
            "button"=> [
                "modal" => [],
                "default" => [
                    [],
                    []
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [],
                $this->lang["detail"]
            ],
            "classCss"=> [
                "modal" => [],
                "default" => []
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>$this->paramGET,
            "dataVal"=>[
                ["champ"=>"statut","val"=>[0=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>". $this->lang['echoue'] ."</span>"],1=>["<span  class='temp text-success' >". $this->lang['reussi'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                //'nb_ticket'=>'alignCenter',
                'montant'=>'alignRightCenter',
                //'com_numherit'=>'alignRightCenter'
            ]
        ];
        /* if($this->appConfig->profile_level == 2)
             array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->distributeur, "reportintRechargementProcessing", $param);
    }

    public function reportingCarte__(){

        if (isset($this->paramPOST["datedebut"]) && isset($this->paramPOST["datefin"])) {
            $data['datedebut'] = $this->paramPOST['datedebut'];
            $data['datefin'] = $this->paramPOST['datefin'];

        }else{
            //echo 65465645; exit;
            $beginEnd = date('Y-m-d', strtotime('Jan 01'));
            $yearEnd = date('Y-m-d', strtotime('12/31'));

            $data['datedebut'] = $beginEnd;
            $data['datefin'] = $yearEnd;
        }

        $data['dataCarte'] = $this->distributeur->getDataCarte($data['datedebut'] ,$data['datefin']);
        /*$data['dataRechargement'] = $this->distributeur->getDataRechargement($data['datedebut'] ,$data['datefin']);
        $data['commission'] = ($this->distributeur->getCommissionRechargement($data['datedebut'] ,$data['datefin']))[0]->commission;
        //var_dump($data['commission']);die;*/
        $this->views->setData($data);
        $this->views->getTemplate('reportingCarte');
    }
    public function reportingCarteProcessing__(){
        $param = [
            "button"=> [
                "modal" => [],
                "default" => [
                    [],
                    []
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [],
                $this->lang["detail"]
            ],
            "classCss"=> [
                "modal" => [],
                "default" => []
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>$this->paramGET,
            "dataVal"=>[
                ["champ"=>"statut","val"=>[0=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>". $this->lang['echoue'] ."</span>"],1=>["<span  class='temp text-success' >". $this->lang['reussi'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                //'nb_ticket'=>'alignCenter',
                'montant'=>'alignRightCenter',
                //'com_numherit'=>'alignRightCenter'
            ]
        ];
        /* if($this->appConfig->profile_level == 2)
             array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->distributeur, "reportintCarteProcessing", $param);
    }


}
