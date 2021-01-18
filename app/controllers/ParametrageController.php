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

class ParametrageController extends BaseController
{
    private $tarifModels;

    public function __construct()
    {

        parent::__construct();
        $this->tarifModels = $this->model("tarif");
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_admin"]);
    }


    //******** Gestion des tarifs  *************//
    //******** Gestion des tarifs  *************//


    public function paramTarif()
    {
        $data['tarif'] = $this->tarifModels->getTarif();
        $data['max'] = $this->tarifModels->getMaxPoids();

        $this->views->setData($data);

        $this->views->getTemplate("parametrage/paramTarif");


    }

    public function ajoutTarif()
    {
        //echo "<pre>";var_dump($this->paramPOST);exit;
       // var_dump($nbr);exit;
        foreach ($this->paramPOST["poidsmin"] as $key => $item) {
            $result = $this->tarifModels->insertTarif(["champs" => ["poidsmax" => $this->paramPOST["poidsmax"][$key], "poidsmin" => $this->paramPOST["poidsmin"][$key], "prix" => $this->paramPOST["prix"][$key]]]);
            if ($result !== false) Utils::setMessageALert(["success", "Tarif ajouté avec succes"]);
            else Utils::setMessageALert(["danger", "Echec de l'ajout de la tarif"]);

        }
        Utils::redirect("parametrage", "paramTarif");

    }



    //******** FIN Gestion des tarifs  *************//
    //******** FIN Gestion des tarifs  *************//


}