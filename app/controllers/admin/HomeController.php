<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 21:11
 */

namespace app\controllers\admin;

use app\core\BaseController;
use app\core\Session;
use app\core\Utils;

class HomeController extends BaseController
{
    private $homeModels;

    public function __construct()
    {
        parent::__construct(false);
        $this->homeModels = $this->model("admin");
    }


    public function index__()
    {
        $this->views->getPage('home/acceuil');
    }

    public function login__()
    {
        $param =["condition" =>["login = "=>$this->paramPOST["login"], "password = "=>sha1($this->paramPOST["password"]),"admin ="=>1, "gie = "=>31, "etat = "=>1, "type = "=>1]];
        $result = $this->homeModels->getOneUtilisateur($param);
        //var_dump($result);die;
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
            Utils::setMessageALert(["danger",$this->lang["LoginouMotdepasseincorrect"]]);
            Utils::redirect("admin", "index");
        }
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
        Utils::envoiMailAdmin($recupEmail->nom, $recupEmail->mail, $codeGenere);
        //Utils::redirect("home", "index");
        $this->views->getPage('home/acceuil');
    }

    public function confirmationCode__()
    {
        $this->views->getPage('confirmationCode');
    }

    public function updateConfirmation__(){
        $this->views->getPage('bus/updateMotDePasse');

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