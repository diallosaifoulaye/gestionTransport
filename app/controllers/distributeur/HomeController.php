<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 21:11
 */

namespace app\controllers\distributeur;

use app\core\BaseController;
use app\core\Session;
use app\core\Utils;

class HomeController extends BaseController
{
    private $homeModels;
    private $agentModels;

    public function __construct()
    {

        parent::__construct(false);
        $this->homeModels = $this->model("distributeur");
        $this->agentModels = $this->model("agent");
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar"]);
    }


    public function index__()
    {
        $this->views->getPage('home/acceuil');
    }

    public function login__()
    {
        $param =["condition" =>["login = "=>$this->paramPOST["login"], "password = "=>sha1($this->paramPOST["password"]), "etat = "=>1]];
        $result = $this->agentModels->getOneDistributeur($param);
        $resultAgent = $this->agentModels->getOneAgent($param);
        $data['type'] = '';
        if($resultAgent !== false)
        {

            Session::set_User_Connecter([$resultAgent]);
            if($resultAgent->connect == 1) {
                $data['type'] = $resultAgent->type;
                $this->views->setData($data);
                Utils::redirect("distrib", "operationIndex");
            }
            else{
                $data['type'] = $resultAgent->type;
                $this->views->setData($data);
                $this->views->getPage('home/first');
            }
        }
        else
        {

            Utils::setMessageALert(["danger",$this->lang["LoginouMotdepasseincorrect"]]);
            Utils::redirect("home", "index");
        }
    }

    public function unlogin__()
    {
        Session::destroySession();
        Utils::redirect("home", "index");
    }
    public function menu__()
    {
        $data['typeProfil'] = $this->_USER->type;
        $this->views->setData($data);
        $this->views->getPage('home/menu');
    }

    public function firstConnect__()
    {
        $this->views->getPage('home/first');

    }
    public function receptionMail() {
        $data = [];
        $email = $this->paramPOST['email'];
        $codeGenere = bin2hex(random_bytes(2));
        $recupEmail = $this->homeModels->getEmail($email);
        $insertCode = $this->homeModels->insertCodeGenere($email,$codeGenere);
        $data['messageEnvoye'] = "Un mail contenant un lien vous a été envoyé." ;
        //var_dump($data);die;
        $this->views->setData($data);
        Utils::envoiMailDistributeur($recupEmail->nom_agent, $recupEmail->mail, $codeGenere);
        //Utils::redirect("home", "index");
        $this->views->getPage('home/acceuil');
    }

    public function confirmationCode__()
    {
        $this->views->getPage('confirmationCode');
    }

    public function traitementCode(){
        $data['confirmationCode'] = $this->paramPOST['code_genere'];
        $recupUser = $this->homeModels->confirmationCode($data['confirmationCode']);
        //var_dump($data);die;
        $this->views->setData($data);
        if($recupUser){
            json_encode(array('ok'=>1)) ;
            $this->views->setData($data);
            //Utils::redirect("home", "updateConfirmation");
            $this->views->getPage('updateMotDePasse');

        }
        else{
            json_encode(array('no'=>0)) ;
            Utils::redirect("home", "confirmationCode");
        }
    }
    public function updatePassword(){
        $code_genere = $this->paramPOST['code_genere'];
        // var_dump($confirmationCode);die;
        $password =$this->paramPOST['password'];
        $passwordUpdate = sha1($password);
        $recupUser = $this->homeModels->updatePassword($code_genere, $passwordUpdate);
        $data['updatePassword'] = "Votre mot de passe a été changé avec succès." ;
        $this->views->setData($data);
        $this->views->getPage('home/acceuil');

        //Utils::redirect("home", "index");


    }



}