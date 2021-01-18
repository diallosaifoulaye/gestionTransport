<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 21:11
 */

namespace app\controllers\espace;

use app\core\BaseController;
use app\core\Session;
use app\core\Utils;

class AdminController extends BaseController
{
    private $homeModels;

    public function __construct()
    {
        echo 546;exit;
        parent::__construct(false);
        $this->homeModels = $this->model("admin");
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar"]);    }

    public function index__()
    {
        $this->views->getPage('admin/acceuil');
    }
    public function accueil__()
    {
        $this->views->getPage('admin/accueil');
    }
    public function menu__()
    {
        $this->views->getPage('admin/menu');
    }

    /********Connection à la plateforme sunusva si ok********/
    public function login__()
    {
        //parent::validateToken('home','index');
        $param =["condition" =>["login = "=>$this->paramPOST["login"], "password = "=>sha1($this->paramPOST["password"]), "etat = "=>1]];
        $result = $this->homeModels->getOneUtilisateur($param);
        if($result !== false)
        {
            Session::set_User_Connecter([$result]);
            if($result->connect == 1) {
                Utils::redirect("menu", "menu");
            }
            else{
                Utils::redirect("menu", "firstConnect");
            }
        }
        else
        {
            Utils::setMessageALert(["danger","Login ou Mot de passe incorrect"]);
            Utils::redirect("admin", "index");
        }
    }

    public function unlogin__()
    {
        Session::destroySession();
        Utils::redirect("admin", "index");
    }

    public function auth2()
    {
        $this->apiClient->setMethod("get");
        $this->apiClient->setService("connexion");
        $rstApi = $this->apiClient->april();
        echo $rstApi;
    }


}