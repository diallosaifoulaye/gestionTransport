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

class PaiementController extends BaseController
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


}