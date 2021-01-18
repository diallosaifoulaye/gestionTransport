<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 21:11
 */

namespace app\controllers;
use app\models\LocationModel;


use app\core\BaseController;
use app\core\Session;
use app\core\Utils;

class LocationController extends BaseController
{

    public function __construct()
    {

        parent::__construct();

        $this->locationModels = new LocationModel();
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_location"]);

    }
    public function index__()
    {
        $this->views->getTemplate('location');

    }


    public function newLocation()
    {

        $this->views->getTemplate("newLocation");

    }

    /**
     * @droit List rental - 8
     */
    public function nouvelleLocation__()
    {
        $data['location'] = $this->locationModels->getBus();
        $data['places'] = $this->locationModels->getPlaces();
        $this->views->setData($data);
        //var_dump($data['location']);die();
        $this->views->getTemplate("bus/newLocation");

    }



    /**
     * @droit Add rental - 8
     */

    public function ajoutNouvelleLocation()
    {

        //$this->paramPOST['montant_total'] =\app\core\Utils::getFormatMoney($this->paramPOST['montant_total']);
        $this->paramPOST['numGie'] = $this->_USER->gie;
        $dateDeb = strtotime($this->paramPOST['date_deb']);
        $dateFin = strtotime($this->paramPOST['date_fin']);
        $nbJoursTimestamp = $dateFin - $dateDeb;
        $nbJours = $nbJoursTimestamp/86400;
        $prix = $this->paramPOST['price_by_day'];
        $this->paramPOST['montant_total'] = $nbJours*$prix;

        try{

            $this->locationModels->__beginTransaction();
            $result = $this->locationModels->insertLocation(["champs" => $this->paramPOST]);
            if ($result > 0){
                $this->paramPOST['receveur'] = $this->_USER->id;
                $this->paramPOST['bus'] = $this->paramPOST['select_bus'];
                $this->paramPOST['numGIE'] = $this->paramPOST['numGie'];
                $this->paramPOST['montant'] = $this->paramPOST['montant_total'];
                $this->paramPOST['date'] = $this->paramPOST['date_reservation'];
                unset($this->paramPOST["select_bus"],$this->paramPOST['numGie'],$this->paramPOST['montant_total'],$this->paramPOST["nom_locataire"],$this->paramPOST["prenom_locataire"],$this->paramPOST["piece_identite"],$this->paramPOST["adresse"],$this->paramPOST["telephone"],$this->paramPOST['date_deb'],$this->paramPOST["intermediaire"],$this->paramPOST["nom_entreprise"],$this->paramPOST["price_by_day"],$this->paramPOST["date_fin"],$this->paramPOST["date_reservation"]);
                $this->paramPOST['fk_location'] = $result ;
                $this->paramPOST['num_transaction'] = $this->locationModels->Generer_numtransaction() ;
                $result2 = $this->locationModels->insertTransaction(["champs" => $this->paramPOST]);
                $this->locationModels->__commit();
                Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);

            }

        }
        catch(Exception $e){
            $this->locationModels->__rollBack() ;
            Utils::setMessageALert(["danger",$this->lang["actionechec"]].$e->getMessage());
        }


        Utils::redirect("location", "listeBusL");

    }



    /**
     * @droit Historic rental - 8
     */
    public function listeBusL()
    {
        $this->views->getTemplate("bus/historiqueLocation");

    }

    public function listeBusLoues__()
    {
        if ($this->_USER) {
            if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
                $param = [

                    "button" => [
                        "modal" => [
                            ["location/modifBusLoue", "bus/modifBusLoue", "fa fa-edit"],
                        ],
                        "default" => [
                            ["champ" => "etat","val" => ["2" => ["location/traiteBusLoue/","fa fa-toggle-on"],"3" => ["location/coursBusLoue/", "fa fa-toggle-off"]]],
                            ["location/deactivateBusLoue/", "glyphicon glyphicon-off"],
                            ["location/detailBusLoue/", "fa fa-search"]
                        ],


                        //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                    ],
                    "tooltip" => [
                        "modal" => [$this->lang['Modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],
                        "default" => [
                            ["champ"=>"etat","val"=>["2"=>$this->lang['traite'],"3"=>$this->lang['cours']]],
                            $this->lang['Desactive'],$this->lang['Detail']
                        ]

                    ],
                    "classCss" => [
                        "modal" => [],
                        "default" => ["confirm","confirm"]
                    ],
                    "attribut" => [],
                    "args" => null,//$this->_USER,
                    "dataVal" => [
                        ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['annule']." </i>"], "1" => ["<i class='text-success'>".$this->lang['reserve']."</i>"], "2" => ["<i class='text-success'>".$this->lang['valide']."</i>"],"3" => ["<i class='text-info'>".$this->lang['traite']."</i>"]]],
                    ],
                    "fonction" => [
                        "montant_total" => "getFormatMoney",
                        "date_deb" => "getDateFR",
                        "date_fin" => "getDateFR",
                    ]
                ];
                $this->processing($this->locationModels, 'getAllBusLoues', $param);
            }
        }
    }



    /**
     * @droit Make done rental - 8
     */
    public function traiteBusLoue()
    {

        if (intval($this->paramGET[0]) > 0) {
            $result = $this->locationModels->updateBusLoue(["champs" => ["etat" => 3], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success",$this->lang["traiteS"]]);
            else Utils::setMessageALert(["danger",$this->lang["traiteE"]]);
        } else Utils::setMessageALert(["danger", $this->lang["traiteE"]]);
        Utils::redirect("location", "listeBusL");
    }


    //Gestion des boutons Annulé Valider Traité au niveau de detail
    //Annulé = Désactivé pour la lecture un peu plut haut j ai utilisé désactivé au lieu d annuler

    public function traiteBusLoueDetail()
    {

        $result = $this->locationModels->updateBusLoue(["champs" => ["etat" => 3], "condition" => ["id = " =>  base64_decode($this->paramPOST['id'])]]);
        $id = base64_decode($this->paramPOST['id']);
        if ($result !== false) Utils::setMessageALert(["success",$this->lang["traiteS"]]);
        else Utils::setMessageALert(["danger",$this->lang["traiteE"]]);
        Utils::redirect("location", "detailBusLoue"."/".$id);
    }


    /**
     * @droit Validate rental - 8
     */
    public function valideBusLoueDetail()
    {

        $result = $this->locationModels->updateBusLoue(["champs" => ["etat" => 2], "condition" => ["id = " =>  base64_decode($this->paramPOST['id'])]]);
        $id = base64_decode($this->paramPOST['id']);
        if ($result !== false) Utils::setMessageALert(["success",$this->lang["valideS"]]);
        else Utils::setMessageALert(["danger",$this->lang["valideE"]]);
        Utils::redirect("location", "detailBusLoue"."/".$id);
    }


    /**
     * @droit Cancel rental - 8
     */
    Public function annuleBusLoueDetail()
    {
        $result = $this->locationModels->updateBusLoue(["champs" => ["etat" => 0], "condition" => ["id = " =>  base64_decode($this->paramPOST['id'])]]);
        $id = base64_decode($this->paramPOST['id']);
        if ($result !== false) Utils::setMessageALert(["success",$this->lang["activeS"]]);
        else Utils::setMessageALert(["danger",$this->lang["activeE"]]);
        Utils::redirect("location", "detailBusLoue"."/".$id);
    }




    /**
     * @droit Rental in progress - 8
     */
    public function coursBusLoue()
    {

        if (intval($this->paramGET[0]) > 0) {
            $result = $this->locationModels->updateBusLoue(["champs" => ["etat" => 2], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success",$this->lang["coursS"]]);
            else Utils::setMessageALert(["danger",$this->lang["coursE"]]);
        } else Utils::setMessageALert(["danger", $this->lang["coursE"]]);
        Utils::redirect("location", "listeBusL");
    }

    public function deactivateBusLoue()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->locationModels->updateBusLoue(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["desactiveS"]]);
            else Utils::setMessageALert(["danger", $this->lang["desactiveE"]]);
        } else Utils::setMessageALert(["danger", $this->lang["desactiveE"]]);
        Utils::redirect("location", "listeBusL"."/".$id);
    }


    public function parametrageFacture(){
        $this->views->getTemplate("bus/parametrageFactureLocation");
    }



    /**
     * @droit parametrage invoice rental - 8
     */
    public function parametrageFactures__()
    {
        if ($this->_USER) {
            // if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
            $param = [

                "button" => [
                    "default" => [
                        ["champ" => "etat","val" => ["0" => ["location/activateFact/","fa fa-toggle-off"],"1" => ["location/deactivateFact/", "fa fa-toggle-on"]]],
                        ["location/removeParamFact/", "fa fa-trash"],
                        //["bus/detailBus/", "fa fa-search"]
                    ],
                    "modal" => [
                        ["location/modifFactureModal", "bus/modifFactureModal", "fa fa-edit"],

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
                "args" => null,
                "dataVal" => [
                    ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
                ],
                "fonction" => [
                    "price_by_day" => "getFormatMoney"
                ]
            ];
            $this->processing($this->locationModels, 'getPrice', $param);
            //  }
        }
    }

    public function activateFact()
    {

        if (intval($this->paramGET[0]) > 0) {
            $result = $this->locationModels->updateFacture(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success",$this->lang["activeS"]]);
            else Utils::setMessageALert(["danger",$this->lang["activeE"]]);
        } else Utils::setMessageALert(["danger", $this->lang["activeE"]]);
        Utils::redirect("location", "parametrageFacture");
    }

    public function deactivateFact()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->locationModels->updateFacture(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success",$this->lang["activeE"]]);
            else Utils::setMessageALert(["danger", $this->lang["activeE"]]);
        } else Utils::setMessageALert(["danger", $this->lang["activeE"]]);
        Utils::redirect("location", "parametrageFacture");
    }

    public function modifFactureModal()

    {
        //var_dump($this->paramGET[2])[0];die;
        $data['parametrage'] = $this->locationModels->getParametrageFacture(["condition" => ["id = " => $this->paramGET[2]]])[0];
        //$data['bus'] = $this->busModels->getBus();
        //var_dump($data);die();
        $this->views->setData($data);

        $this->modal();
    }

    public function updateFacture()
    {
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->locationModels->updateFacture($data);
        if ($result !== false) Utils::setMessageALert(["success",  $this->lang["modifParamR"]]);
        else Utils::setMessageALert(["danger", $this->lang["modifParamE"]]);
        Utils::redirect("location", "parametrageFacture");

    }

    public function removeParamFact()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->locationModels->deleteParamFact(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["suppressionR"]]);
            else Utils::setMessageALert(["danger", $this->lang["suppressionE"]]);
        } else Utils::setMessageALert(["danger", $this->lang["suppressionE"]]);
        Utils::redirect("location", "parametrageFacture");
    }

    public function ajoutParamFact()
    {

        $this->modal();

    }

    /**
     * @droit Add settings rental - 8
     */
    public function insertParamFact()
    {

        $result = $this->locationModels->insertParam(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["ajoutR"]]);
        else Utils::setMessageALert(["danger", $this->lang["ajoutE"]]);
        Utils::redirect("location", "parametrageFacture");

    }

    public function removeBusLoue()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->locationModels->deleteBusLoue(["condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["suppressionS"]]);
            else Utils::setMessageALert(["danger", $this->lang["suppressionE"]]);
        } else Utils::setMessageALert(["danger", $this->lang["suppressionE"]]);
        Utils::redirect("location", "listeBusL");
    }


    public function modifBusLoue()

    {

        $data['busLoue'] = $this->locationModels->getBusLoue(["condition" => ["id = " => $this->paramGET[2]]])[0];
        //$data['bus'] = $this->busModels->getBus();
        //var_dump($data);die();
        $this->views->setData($data);
        $this->modal();
    }

    /**
     * @droit update rental - 8
     */
    public function updateBusLoue()
    {
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $dateDeb = strtotime($this->paramPOST['date_deb']);
        $dateFin = strtotime($this->paramPOST['date_fin']);
        $nbJoursTimestamp = $dateFin - $dateDeb;
        $nbJours = $nbJoursTimestamp/86400;
        $price_by_day = $this->paramPOST['price_by_day'];
        $this->paramPOST['montant_total'] = $nbJours*$price_by_day;
        $data['champs'] = $this->paramPOST;
        $result = $this->locationModels->updateBusLoue($data);
        if ($result !== false) Utils::setMessageALert(["success",  $this->lang["modifParamR"]]);
        else Utils::setMessageALert(["danger", $this->lang["modifParamE"]]);
        Utils::redirect("location", "listeBusL");

    }

    public function detailBusLoue(){

        $dateDeb = strtotime($this->locationModels->getOneBusLoue(["condition" => ["l.id = " => $this->paramGET[0]]])->date_deb);
        $datefin = strtotime($this->locationModels->getOneBusLoue(["condition" => ["l.id = " => $this->paramGET[0]]])->date_fin);
        $nbJoursTimestamp = $datefin - $dateDeb;
        $data['nbJours'] = round($nbJoursTimestamp/86400);
        $data['busLoue'] = $this->locationModels->getOneBusLoue(["condition" => ["l.id = " => $this->paramGET[0]]]);
        //var_dump($this->locationModels->nombreReservationAnnule());die;
        $this->views->setData($data);
        $this->views->getTemplate('bus/detailBusLoue');


    }

    public function detailReportingBusLoue(){

        $dateDeb = strtotime($this->locationModels->getOneBusLoue(["condition" => ["l.id = " => $this->paramGET[0]]])->date_deb);
        $datefin = strtotime($this->locationModels->getOneBusLoue(["condition" => ["l.id = " => $this->paramGET[0]]])->date_fin);
        $nbJoursTimestamp = $datefin - $dateDeb;
        $data['nbJours'] = $nbJoursTimestamp/86400;
        $data['busLoue'] = $this->locationModels->getOneBusLoue(["condition" => ["l.id = " => $this->paramGET[0]]]);
        //var_dump($this->locationModels->nombreReservationAnnule());die;
        $this->views->setData($data);
        $this->views->getTemplate('bus/detailReporting');


    }
    public function imprimerDetailBusLoue(){
        $idBus = base64_decode($this->paramPOST['id']);
        //var_dump($idBus);die;
        $data['busLoue'] = $this->locationModels->getOneBusLoue(["condition" => ["l.id = " => $idBus]]);
        $this->views->setData($data);
        $this->views->exportToPdf('bus/recuLocationBus');
        //$this->views->getTemplate('bus/recuLocationBus');

    }
    public function imprimerHistoriqueBusLoueExcel(){
        $data['busLoue'] = $this->locationModels->getBusLoue();
        //var_dump($data['busLoue']);die;
       $this->views->setData($data);
       $this->views->exportToExcel('bus/printHistoriqueBusLoue');
        //$this->views->getTemplate('bus/printHistoriqueBusLoue');

    }
    public function imprimerHistoriqueBusLouePdf(){
        $data['busLoue'] = $this->locationModels->getBusLoue();
        //var_dump($data['busLoue']);die;
       $this->views->setData($data);
       $this->views->exportToPdf('bus/printHistoriqueBusLouePdf');
        //$this->views->getTemplate('bus/printHistoriqueBusLoue');

    }

    /**
     * @droit reporting rental - 8
     */
    public function reporting()
    {
        $data['location'] = $this->locationModels->getBus();
        //$data['etat'] = $this->locationModels->getEtatBusLoue();
        //var_dump($data['etat']);die;
        $data['liste'] = (isset($this->paramPOST['select_bus']))? $this->paramPOST['select_bus']:'';
        $data['date_deb'] = (isset($this->paramPOST['date_deb']))? $this->paramPOST['date_deb']:'';
        $data['date_fin'] = (isset($this->paramPOST['date_fin']))? $this->paramPOST['date_fin']:'';
        $data['etatBus'] = (isset($this->paramPOST['etat']))? $this->paramPOST['etat']:'';
        $data['montantTotalBus'] = $this->locationModels->getAmountBus();
        $data['montantBusReserve'] = $this->locationModels->getAmountBusReserve();
        $data['nbreBusLoue'] = $this->locationModels->getCountBusLocation();
        $data['montantBusTraite'] = $this->locationModels->getAmountBusLocation();
        $data['nbreReservation'] = $this->locationModels->getNbreReservation();
        $this->views->setData($data);
        $this->views->getTemplate('bus/reporting');
    }

    public function reportingByDate()
    {
        $data['location'] = $this->locationModels->getBus();
        //$data['etat'] = $this->locationModels->getEtatBusLoue();
        $data['liste'] = (isset($this->paramPOST['select_bus']))? $this->paramPOST['select_bus']:'';
        $data['date_deb'] = (isset($this->paramPOST['date_deb']))? $this->paramPOST['date_deb']:'';
        $data['date_fin'] = (isset($this->paramPOST['date_fin']))? $this->paramPOST['date_fin']:'';
        $data['etatBus'] = (isset($this->paramPOST['etat']))? $this->paramPOST['etat']:'';
        $data['nbreBusLoueFiltre'] = $this->locationModels->getCountBusLocationApresFiltre([$data['date_deb'], $data['date_fin'], $data['liste'], $data['etatBus']]);
        //var_dump($data['nbreBusLoueFiltre']);
        $data['nbreBusReserveFiltre'] = $this->locationModels->getNbreReservationApresFiltre([$data['date_deb'], $data['date_fin'], $data['liste']]);
        $data['montantBusReserveFiltre'] = $this->locationModels->getAmountBusReserveApresFiltre([$data['date_deb'], $data['date_fin'], $data['liste']]);
        $data['montantBusTraite'] = $this->locationModels->getAmountBusLocation();
        $data['montantBusApresFiltre'] = $this->locationModels->getAmountBusLocationApresFiltre([$data['date_deb'], $data['date_fin'], $data['liste']]);
        //var_dump( $data['etatBus']);die;
        $this->views->setData($data);
        $this->views->getTemplate('bus/reporting');
    }

    public function getLocationByDate__()
    {
        //var_dump( $this->paramGET);die();
        $param = [
            "button" => [
                "modal" => [

                ],
                "default" => [
                    ["location/detailReportingBusLoue/","fa fa-search"],
                ]

            ],
            "tooltip" => [
                "default" => [$this->lang['Detail']]
            ],
            "classCss" => [
                "modal" => [],
                "default" => ["confirm"]
            ],
            "attribut" => [],
            "args" =>  null,
            "dataVal" => [
                ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['annule']." </i>"],"1" => ["<i class='text-info'>".$this->lang['reserve']." </i>"] ,"2" => ["<i class='text-success'>".$this->lang['valide']."</i>"],"3" => ["<i class='text-info'>".$this->lang['traite']."</i>"]]],
            ],
            "fonction" => [
                "montant_total" => "getFormatMoney",
                "date_deb" => "getDateFR",
                "date_fin" => "getDateFR",
            ]
        ];
        $this->processing($this->locationModels, 'getLocationByDate', $param);
    }


    //Liste des clients

    public function listeClient(){

        $this->views->getTemplate("bus/listeClients");
    }

    public function listeclients__()
    {
        if ($this->_USER) {
            // if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
            $param = [

                "button" => [
                    "default" => [
                        ["champ" => "etat","val" => ["0" => ["location/activateFact/","fa fa-toggle-off"],"1" => ["location/deactivateFact/", "fa fa-toggle-on"]]],
                        ["location/removeParamFact/", "fa fa-trash"],
                        //["bus/detailBus/", "fa fa-search"]
                    ],
                    "modal" => [
                        ["location/modifFactureModal", "location/modifFactureModal", "fa fa-edit"],

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
                "args" => null,
                "dataVal" => [
                    ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
                ],
                "fonction" => [
                    "nbre_valide"=> "nombreReservationValide",
                    "nbre_annule"=>"nombreReservationAnnule"
                ]
            ];

            $this->processing($this->locationModels, 'listeClientBusLoues', $param);
        }
    }
    /*  $data['listeClient'] = $this->locationModels->listeClientBusLoues();
      $data['nbreResVal'] = $this->locationModels->nombreReservationValide();
      //var_dump( $data['nbreResVal']);die;
      $data['nbreResAnn'] = $this->locationModels->nombreReservationAnnule();
      $this->views->setData($data);
      $this->views->getTemplate('bus/listeClients');

  }*/

    /// END LOCATION
    ///
    ///

}