<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 20:02
 */

namespace app\controllers;

use app\core\ApiServer;
class WebserviceServerController extends ApiServer
{
    public function __construct()
    {
        parent::__construct();
    }

    public function servicesJula()
    {
        $this->serv->addClass($this->setClass(__METHOD__), $this->setPatch(__METHOD__));
        $this->serv->handle();
    }

    public function april()
    {
        $this->serv->addClass($this->setClass(__METHOD__), $this->setPatch(__METHOD__));
        $this->serv->handle();
    }
    public function servicesRapido()
    {
        $this->serv->addClass($this->setClass(__METHOD__), $this->setPatch(__METHOD__));
        $this->serv->handle();
    }

    public function servicesTransferTo()
    {
        $this->serv->addClass($this->setClass(__METHOD__), $this->setPatch(__METHOD__));
        $this->serv->handle();
    }

    /***************Authentification*****************/
    public function authentification()
    {
        $this->serv->addClass($this->setClass(__METHOD__), $this->setPatch(__METHOD__));
        $this->serv->handle();
    }

    /***************Intégration neosurf*****************/
    public function wsva()
    {
        $this->serv->addClass($this->setClass(__METHOD__), $this->setPatch(__METHOD__));
        $this->serv->handle();
    }

    public function servicesWoyofal()
    {
        $this->serv->addClass($this->setClass(__METHOD__), $this->setPatch(__METHOD__));
        $this->serv->handle();
    }
}