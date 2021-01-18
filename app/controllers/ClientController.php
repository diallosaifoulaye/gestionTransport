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
use app\models\ClientModel;
use app\models\DistributeurModel;

class ClientController extends BaseController
{
    private $clientModels;


    public function __construct()
    {

        parent::__construct();
        $this->clientModels = new ClientModel();
        $this->distributeur = new DistributeurModel();

        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_client"]);

    }

    /**************************************************************** DEBUT EMPLOYE ******************************************************************/



    /************************ Gestion des Receveurs  **********************/
    // Modal Ajout Receveur

    public function ajoutClientModal()
    {
        $data['professions'] = $this->clientModels->get(["table"=>"profession","champs"=>["rowid , libelle"]]);
        $data['montant'] = $this->clientModels->get(["table"=>"commission_carte","champs"=>["id , montant_carte"]]);
        $this->views->setData($data);
        $this->modal();
    }

    public function ajoutRechargementModal()
    {
        //var_dump($this->paramGET);exit;

        $data['idcarte'] = $this->paramGET[0];
        $this->views->setData($data);
        $this->modal();
    }



    /**
     * @droit Update  costumer - 7
     */
    public function updateClient()
    {
        $id = $this->paramPOST['id'] ;
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        //var_dump($data); exit;

        $resultUpdate = $this->clientModels->set(["table"=>"client","champs" => $data['champs'], "condition"=>["id ="=>base64_decode($id)]]);
        if ($resultUpdate !== false) Utils::setMessageALert(["success",$this->lang["succes_update"]]);
        else Utils::setMessageALert(["danger", $this->lang["echec_update"]]);
        Utils::redirect("client", "liste");
    }



    public function verifExistenceEmail()
    {
        $verif = $this->clientModels->verifEmailModel($this->paramPOST['email']);
        if($verif==1) echo 1;
        else echo -1;
    }

    public function verifExistenceCarte($numSerie='',$type='')
    {
        if ($numSerie == '')
            $numSerie = $this->paramPOST['numcarte'] ;

        $param1 = [
            "table"=>"carte c",
            "champs"=>["c.numero_serie"],
            "condition"=>["c.numero_serie = " => $numSerie]
        ];
        $carte = $this->clientModels->get($param1);
        //var_dump($carte);

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

    /**
     * @droit Add  costumer - 7
     */
    public function ajoutClient()
    {
        $this->paramPOST['gie'] = $this->_USER->gie;
        $montant_carte = (int) $this->paramPOST['montant'];

        try{
            $this->clientModels->__beginTransaction() ;
            $commission =  (int) $this->distributeur->getCommissionEnrollement($montant_carte);
            $part_Nta = $montant_carte - $commission;
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


            $retour = $this->verifExistenceCarte($numserie,1)  ;
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

        Utils::redirect("client", "liste");

    }

    // Vérifier si email existe déjà


    // Vérifier si email existe déjà
    public function verifExistenceLogin()
    {
        $verif = $this->utilisateurModels->verifLoginModel($this->paramPOST['login']);
        if($verif==1) echo 1;
        else echo -1;
    }

    // Modification Droit
    public function modifClientModal()
    {
        $data['client'] = $this->clientModels->get(["table"=>"client","champs"=>["*"],"condition" => ["id = " => $this->paramGET[2]]])[0];
        $this->views->setData($data);
        $this->modal();

    }

    /**
     * @droit List  costumers - 7
     */
    public function liste()
    {
        $this->views->getTemplate("client/liste");
    }

    // Processing Droit
    public function listePro__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('client')->__authorized($this->_USER->idprofil, 'client', 'modifClientModal') > 0) {
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
                        "default" => []
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
                           // ["champ" => "etat","val" => ["0" => ["client/activateClient/","fa fa-toggle-off"],"1" => ["client/desactivateClient/", "fa fa-toggle-on"]]],
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
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
                    ],
                    "fonction" => ["solde"=>"getMontant"]
                ];
                $this->processing($this->clientModels, 'getAllClient', $param);
            }
        }
    }



    /**
     * @droit List Blocked card costumer - 7
     */
    public function compteBlocked()
    {
        $this->views->getTemplate("client/compteBlocked");
    }

    // Processing Droit
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





    public function rechargementPro__()
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

            $this->processing($this->clientModels, 'getAllRechargementClient', $param);

    }

    public function activationBlocagePro__()
    {
              $param = [
                  "args" => $this->paramGET,
                  "fonction" => ["type"=>"getType"]
              ];

            $this->processing($this->clientModels, 'activationBlocage', $param);

    }

    public function detailClient(){

        $data['client'] = $this->clientModels->get(["table"=>"client c","champs"=>["c.* "," ca.id as idCarte" ,"ca.solde" , "ca.numero_serie","ca.statut"],"jointure"=>[" LEFT JOIN carte ca on  c.id = ca.client  "],"condition" => ["c.id = " => $this->paramGET[0]]])[0];

        $this->views->setData($data);
        $this->views->getTemplate('client/detailClient');

    }


    /**
     * @droit Add activation/bloced card - 7
     */
    public function ajoutBlocageOrActivation()
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

        Utils::redirect("client", "detailClient/".$idClient);
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


    /**
     * @droit Activate costumer card - 7
     */
    public function activateClient()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->clientModels->set(["table"=>"client","champs" => ["etat" => 1], "condition" => ["id = " => intval($this->paramGET[0])]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_element"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_element"]]);
        } else Utils::setMessageALert(["danger",  $this->lang["echec_activate_element"]]);
        Utils::redirect("client", "liste");
    }

    /**
     * @droit Desactivate costumer card - 7
     */
    public function desactivateClient()
    {
        //var_dump($this->paramGET[0]);exit;
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->clientModels->set(["table"=>"client","champs" => ["etat" => 0], "condition" => ["id = " => intval($this->paramGET[0])]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_element"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_activate_element"]]);
        } else Utils::setMessageALert(["danger",  $this->lang["echec_activate_element"]]);
        Utils::redirect("client", "liste");
    }


    /**
     * @droit Add reload card - 7
     */
    public function ajoutRechargement()
    {
    $this->clientModels->__beginTransaction() ;
        try{
            $idCarte = $this->paramPOST['idCarte'] ;
            $idClient = $this->paramPOST['idClient'] ;


            if ($idCarte){

                $montant = $this->paramPOST['montant'] ;
                $ancien_solde = $this->paramPOST['ancien_solde'] ;

                $champs = array();
                $champs['user_id'] = $this->_USER->id ;
                $champs['carte_id'] = $idCarte ;
                $champs['date_transac'] = date("Y-m-d H:i:s") ;

                $champs['num_transac'] = $this->clientModels->Generer_numtransaction() ;
                $champs['montant'] = $montant;
                $champs['solde_avant'] = $ancien_solde;
                $champs['solde_apres'] = intval($montant + $ancien_solde);

                $resultHisto = $this->clientModels->set(["table"=>"histo_rechargement","champs" => $champs]);
                if (!($resultHisto))
                    throw new \Exception($this->lang["echec_add_element"].' table histo_rechargement') ;


                $resultUpdateCarte = $this->clientModels->set(["table"=>"carte", "champs"=>["solde = solde +  " => $montant], "condition"=>["id ="=>$idCarte]]);
                $champs['numGIE'] = $this->_USER->gie;
                //$champs['bus'] = 1;
                $champs['receveur'] = $this->_USER->id ;
                $champs['date'] = date("Y-m-d H:i:s");
                $champs['type'] = 3;
                $champs['num_transaction'] = $this->clientModels->Generer_numtransaction() ;
                unset($this->paramPOST["ancien_solde"],$this->paramPOST["idCarte"],$this->paramPOST ["idClient"],$champs['user_id'],$champs['date_transac'],$champs['num_transac'],$champs['solde_avant'],$champs['solde_apres'] );
                //echo "<pre>"; var_dump($champs);die();
                $result2 = $this->clientModels->insertTransaction(["champs" => $champs]);
                //var_dump($result2);die();
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

        Utils::redirect("client", "detailClient/".$idClient);

    }

    public function reenrolementModal(){
        $data['idClient']=$this->paramGET[2];
        $carte = $this->clientModels->getLineCard($this->paramPOST['numero_serie']);
        $this->views->setData($data);
        return $this->modal();
    }

    public function verifNumSerie(){
        $carteDisponible = $this->clientModels->getLineCard($this->paramPOST['numero_serie']);
        $carteBloque = $this->clientModels->getCardBloque($this->paramPOST['numero_serie']);
        $carteActive = $this->clientModels->getCardActive($this->paramPOST['numero_serie']);

        if(count($carteDisponible)>0){
            //$message = $this->lang['carte_disponible'] ;
            $message = "carte dispo" ;

          //  echo json_encode(array('ok'=>1)) ;
            echo json_encode(array('ok'=>1,'message'=>$message)) ;

        }
        elseif (count($carteBloque)>0){
            $message = "carte bloquee" ;
            //echo json_encode(array('ok'=>2)) ;
            echo json_encode(array('ok'=>2,'message'=>$message)) ;

        }
        elseif (count($carteActive)>0){
            $message = "carte active" ;
            //echo json_encode(array('ok'=>3)) ;
            echo json_encode(array('ok'=>3,'message'=>$message)) ;

        }
        else{
            $message = "carte non dispo" ;
           // echo json_encode(array('no'=>0)) ;
            echo json_encode(array('ok'=>0,'message'=>$message)) ;

        }
    }

    /**
     * @droit Re-roll costumer - 7
     */
    public function reenrolement(){
        $idCarte = $this->paramPOST['idCarte'];
        $oldCard = $this->paramPOST['numSerie'];
        $newCard = $this->paramPOST['numero_serie'];
        $idClient = $this->paramPOST['idClient'];
        $param = [
            "table"=>"carte c",
            "champs"=>["c.id", "c.numero_serie", "c.client", "c.statut"],
            "condition"=>["c.numero_serie ="=> $newCard, "c.client ="=>0, "c.statut ="=>0]
        ];
        $param1 = [
            "table"=>"carte c",
            "champs"=>["c.id", "c.numero_serie", "c.client", "c.statut", "c.fk_distributeur","verse", "c.solde", "part_nta", "part_distributeur"],
            "jointure" => [
                "INNER JOIN client cl on cl.id = c.client"
            ],
            "condition"=>["c.id = " => $idCarte, "c.numero_serie ="=> $oldCard, "c.client ="=>$idClient]
        ];


        $carteAReenroller = $this->clientModels->get($param1);
        $carteDisponible = $this->clientModels->get($param);
        if($carteDisponible){
            $UpdateCarteDisponible = $this->clientModels->set([
                "table"=>"carte", "champs"=>["
                client ="=>$carteAReenroller[0]->client, "statut = "=> 1, "user_creation ="=>$this->_USER->id,"date_creation = "=>date("Y-m-d H:i:s"), "solde ="=>$carteAReenroller[0]->solde, "fk_distributeur ="=>$carteAReenroller[0]->fk_distributeur, "verse ="=>$carteAReenroller[0]->verse, "part_nta ="=>$carteAReenroller[0]->part_nta, "part_distributeur ="=>$carteAReenroller[0]->part_distributeur
                ],
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
        Utils::redirect("client", "detailClient/".$idClient);

    }




    /************************ Gestion des Controleurs  **********************/
    // Modal Ajout Controleur


    /******************** FIN Gestion Controleur ******************************/


    /**************************************************************** FIN PARAMETRAGE ******************************************************************/





}