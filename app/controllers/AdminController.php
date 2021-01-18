<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 21:11
 */

namespace app\controllers;
//namespace app\controllers\*;
//namespace app\controllers;

use app\core\BaseController;
use app\core\Session;
use app\core\Utils;

class AdminController extends BaseController
{
    private $homeModels;

    public function __construct()
    {
        parent::__construct();
        $this->homeModels = $this->model("admin");
    }

    public function index__()
    {
        echo 'yes';exit();
        //$this->views->getTemplate('accueil');

    }
    public function accueil__()
    {
        $this->views->getPage('home/accueil');
    }
    public function menu__()
    {
        $this->views->getPage('home/menu');
    }

    /********Connection à la plateforme sunusva si ok********/

    public function unlogin__()
    {
        Session::destroySession();
        Utils::redirect("home", "index");
    }

    public function auth2()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("connexion");
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }


}