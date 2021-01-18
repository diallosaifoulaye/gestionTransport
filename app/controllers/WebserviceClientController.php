<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 20:02
 */

namespace app\controllers;

use app\core\ApiClient;
use app\core\ApiClientSoap;

class WebserviceClientController extends ApiClient
{
    public function __construct()
    {
        parent::__construct();
    }

    /*******Serveur April*********/
    public function april()
    {
        $this->setUri("https://numherit-labs.com/demo/sunusva/webserviceServer/april");
        $this->request();
        return $this->result();
    }

    /*******Client Jula*********/
    public function jula()
    {
        $this->setUri("https://www.numherit-labs.com/jula/soap/index.php?wsdl");
        $this->useInstanceSoap();
        return $this->soap;
    }

    /*******Serveur Jula*********/
    public function servicesJula()
    {
        $this->setUri("https://numherit-labs.com/demo/sunusva/webserviceServer/servicesJula");
        $this->request();
        return $this->result();
    }

    /*******Client TransferTo(Pour Achat credit)*********/
    public function transferTo()
    {
        $this->setUri( "https://fm.transfer-to.com/cgi-bin/shop");
        $this->request();
        return $this->result();
    }

    /*******Serveur TransferTo*********/
    public function servicesTransferTo()
    {
        $this->setUri("https://numherit-labs.com/demo/sunusva/webserviceServer/servicesTransferTo");
        $this->request();
        return $this->result();
    }

    /*******Client Rapido*********/
    public function rapido()
    {
        $this->setUri("http://41.219.17.162:7575/rapido/index.php?wsdl");
        $this->useInstanceSoap();
        return $this->soap;
    }

    /*******Serveur Rapido*********/
    public function servicesRapido()
    {
        $this->setUri("https://numherit-labs.com/demo/sunusva/webserviceServer/servicesRapido");
        $this->request();
        return $this->result();
    }

    /***************Consommation Webservice Achat code neosurf**************/
    public function neosurfAchat()
    {
        $this->setUri("https://www.neosurf.info/soap/?wsdl");
        $this->useInstanceSoap();
        return $this->soap;
    }

    /****************** Serveur Neosurf ********************/
    public function serviceNeosurf()
    {
        $this->setUri("https://numherit-labs.com/demo/sunusva/webserviceServer/neosurf");
        $this->request();
        return $this->result();
    }

    /****************** Serveur Authentification ********************/
    public function serviceAuth()
    {
        $this->setUri("https://numherit-labs.com/demo/sunusva/webserviceServer/authentification");
        $this->request();
        return $this->result();
    }

    /*******Client Woyofal*********/
    public function woyofal()
    {
        $this->setUri("http://postecash.cloudapp.net/woyofal/index.php?wsdl");
        $this->useInstanceSoap();
        return $this->soap;
    }

    /*******Serveur Woyofal*********/
    public function servicesWoyofal()
    {
        $this->setUri("https://numherit-labs.com/demo/sunusva/webserviceServer/servicesWoyofal");
        $this->request();
        return $this->result();
    }

}