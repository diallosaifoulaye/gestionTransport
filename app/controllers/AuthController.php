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

class AuthController extends BaseController
{

    public function __construct()
    {
        parent::__construct(false);
    }


    public function authentifier()
    {
        $this->apiClient->setMethod("post");
        $this->apiClient->setService("authentifier");

        $rstApi = $this->apiClient->serviceAuth();
        echo json_decode($rstApi);
    }
}