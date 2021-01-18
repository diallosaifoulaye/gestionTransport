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

class RechargementController extends BaseController
{
    private $homeModels;

    public function __construct()
    {

        parent::__construct(false);
        $this->homeModels = $this->model("home");
    }

    public function auth2()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("connexion");
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }

    /************************** DEBUT TEST WEB SERVICE ****************************/

    public function soldeCarteJula()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("ConsultationSolde");
        $rstApi = $this->apiClient->servicesJula();
        ///echo json_encode($rstApi);
        echo json_decode($rstApi);exit();
    }

    public function debiterCarteJula()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("debiterCarte");
        $rstApi = $this->apiClient->servicesJula();
        ///echo json_encode($rstApi);
        echo json_decode($rstApi);exit();
    }

    public function crediterCarteJula()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("crediterCarte");
        $rstApi = $this->apiClient->servicesJula();
        ///echo json_encode($rstApi);
        //echo"<pre>";var_dump($rstApi['message']);exit();
        echo json_decode($rstApi);exit();

    }

    public function activationCarteJula()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("ActivationCarteJula");
        $rstApi = $this->apiClient->servicesJula();
        ///echo json_encode($rstApi);
        echo json_decode($rstApi);exit();
    }

    public function infosCarteJula()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("infosCarteJula");
        $rstApi = $this->apiClient->servicesJula();
        ///echo json_encode($rstApi);
        echo json_decode($rstApi);exit();
    }

    public function getPartenaireJula()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("getPartenaire");
        $rstApi = $this->apiClient->servicesJula();
        echo json_decode($rstApi);exit();
    }

    public function returnTypeClientJula()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("ReturnTypeClient");
        $rstApi = $this->apiClient->servicesJula();
        ///echo json_encode($rstApi);
        //echo"<pre>";var_dump($rstApi);exit();
        echo json_decode($rstApi);exit();
    }

    public function returnTypeCarteJula()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("ReturnTypeCarte");
        $rstApi = $this->apiClient->servicesJula();
        echo json_decode($rstApi);exit();
    }

    public function returnNumserieCarteJUla()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("ReturnNumserieCarte");
        $rstApi = $this->apiClient->servicesJula();
        echo json_decode($rstApi);exit();
    }

    public function soldeCompteJula()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("ConsulterSoldeCompteJula");
        $rstApi = $this->apiClient->servicesJula();
        ///echo json_encode($rstApi);
        echo json_decode($rstApi);exit();
    }

    public function crediterCompteJula()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("CrediterCompteJula");
        $rstApi = $this->apiClient->servicesJula();
        ///echo json_encode($rstApi);
        echo json_decode($rstApi);exit();
    }

    public function soldeCompteJulaPartenaire()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("ConsulterSoldeCompteJulaPartenaire");
        $rstApi = $this->apiClient->servicesJula();
        ///echo json_encode($rstApi);
        echo json_decode($rstApi);exit();
    }

    public function codeOwo()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("codeOwo");
        $rstApi = $this->apiClient->servicesJula();
        ///echo json_encode($rstApi);
        echo json_decode($rstApi);exit();
    }

    public function genererCodeJula()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("genererCodeJula");
        $rstApi = $this->apiClient->servicesJula();
        ///echo json_encode($rstApi);
        echo json_decode($rstApi);exit();
    }

    public function verificationCodeJula()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("VerificationCode");
        $rstApi = $this->apiClient->servicesJula();
        ///echo json_encode($rstApi);
        echo json_decode($rstApi);exit();
    }

    public function creerMarchandJula()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("creerMarchandJula");
        $rstApi = $this->apiClient->servicesJula();
        echo json_decode($rstApi);exit();
    }

    /************************** FIN TEST WEB SERVICE ****************************/





    /************************** CONSULTATION SOLDE BADGE RAPIDO ****************************/

    public function soldeBadgeRapido()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("soldeBadgeRapido");
        $rstApi = $this->apiClient->servicesRapido();
        ///echo json_encode($rstApi);
        echo json_decode($rstApi);exit();
    }

    /************************** RECHARGE SOLDE BADGE RAPIDO ****************************/

    public function rechargeBadgeRapido()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("rechargeBadgeRapido");
        $rstApi = $this->apiClient->servicesRapido();
        ///echo json_encode($rstApi);
        echo json_decode($rstApi);exit();
    }

}