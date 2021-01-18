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

class AssuranceController extends BaseController
{
    //private $homeModels;

    public function __construct()
    {

        parent::__construct(false);
        //$this->homeModels = $this->model("home");
    }

    public function villes()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("GetVillesApril");
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function ville()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("findoneville");
        $data = [
            "findoneville" =>[
                "id" => 1
            ]
        ];
        $this->apiClient->setData($data);
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function civilites()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("civilites");
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function civilite()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("findonecivilite");
        $data = [
            "findonecivilite" =>[
                "id" => 1
            ]
        ];
        $this->apiClient->setData($data);
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function createPerson()
    {
        $this->apiClient->setMethod("post");
        $this->apiClient->setService("createPerson");
        $data = [
            "createPerson" =>[
                'genre' => 'H',
                'nom' => 'DIENG',
                'prenoms' => 'Maguette',
                'adresse' => 'Canada',
                'ville' => 'Toronto',
                'quartier' => 'Ohio',
                'telephone' => '77-273-08-41'
            ]
        ];
        $this->apiClient->setData($data);
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function assureurs()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("assureurs");
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function findoneassureur()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("findoneassureur");
        $data = [
            "findoneassureur" =>[
                "id" => 1
            ]
        ];
        $this->apiClient->setData($data);
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function createClient()
    {
        $this->apiClient->setMethod("post");
        $this->apiClient->setService("createClient");
        $data = [
            "createClient" =>[
                'origine_id' => 1,
                'type_id' => 1,
                'personne_id' => 121
            ]
        ];
        $this->apiClient->setData($data);
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function client()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("client");
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function findoneclient()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("findoneclient");
        $data = [
            "findoneclient" =>[
                "id" => 93
            ]
        ];
        $this->apiClient->setData($data);
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function puissance_fiscales()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("puissances_fiscales");
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function marques_auto()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("marques_auto");
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function onemarques_auto()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("onemarques_auto");
        $data = [
            "onemarques_auto" =>[
                "id" => 1
            ]
        ];
        $this->apiClient->setData($data);
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function modelemarques_auto()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("modelemarques_auto");
        $data = [
            "modelemarques_auto" =>[
                "id" => 2
            ]
        ];
        $this->apiClient->setData($data);
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function modeles_auto()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("modeles_auto");
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function carburants()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("carburants");
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function durees()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("durees");
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function packs()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("packs");
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function onepack()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("onepack_auto");
        $data = [
            "onepack_auto" =>[
                "id" => 1
            ]
        ];
        $this->apiClient->setData($data);
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function tarifs_auto()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("tarifs_auto");
        $data = [
            "tarif_auto" =>[
                "puissance_fiscale_id" => 4,
                "duree" => 1,
                "carte_brune" => 0
            ]
        ];
        $this->apiClient->setData($data);
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function tarif_auto()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("tarif_auto");
        $data = [
            "tarif_auto" =>[
                "pack_id" => 1,
                "puissance_fiscale_id" => 4,
                "duree" => 1,
                "carte_brune" => 0
            ]
        ];
        $this->apiClient->setData($data);
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function createDevis()
    {
        $this->apiClient->setMethod("post");
        $this->apiClient->setService("createDevis");
        $data = [
            "createDevis" =>[
                'immatriculation' => 'DK8086AA',
                'numcli' => '70',
                'personne_id' => '89',
                'pack_id' => '1',
                'assureur_id' => '1',
                'fabriquant_id' => '1',
                'modele_id' => '3',
                'carburant_id' => '2',
                'puissance_fiscale_id' => '4',
                'n_place' => '7',
                'date_deb' => '2018-10-12',
                'date_fin' => '2018-12-12',
                'duree' => '3',
                'mode_rgl' => 'ESP',
                'vendeur_code' => '473b5b5934ae5ad3ed0d'
            ]
        ];
        $this->apiClient->setData($data);
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    public function createContrat()
    {
        $this->apiClient->setMethod("post");
        $this->apiClient->setService("createContrat");
        $data = [
            "createContrat" =>[
                'immatriculation' => 'DK8086AA',
                'numcli' => '70',
                'personne_id' => '89',
                'pack_id' => '1',
                'assureur_id' => '1',
                'fabriquant_id' => '1',
                'modele_id' => '3',
                'carburant_id' => '2',
                'puissance_fiscale_id' => '4',
                'n_place' => '7',
                'date_deb' => '2018-10-12',
                'date_fin' => '2018-12-12',
                'duree' => '3',
                'mode_rgl' => 'ESP',
                'vendeur_code' => '473b5b5934ae5ad3ed0d'
            ]
        ];
        $this->apiClient->setData($data);
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }


}