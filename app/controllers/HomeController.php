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

class HomeController extends BaseController
{
    private $homeModels;

    public function __construct()
    {
        parent::__construct(false);
        $this->homeModels = $this->model("admin");
        // $this->views->initTemplate(["header"=>"header","footer"=>"footer"]);
    }

    public function index__()
    {
        $this->views->getPage('home/acceuil');
    }
   public function menu__()
    {

        //$data['nbre'] = $this->homeModels->nbreBus();

        //$this->views->setData($data);


        $this->views->getPage('home/menu');
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
            Utils::redirect("home", "index");
        }
    }

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

    /// MOT DE PASSE OUBLIE

    public function receptionMail() {
        $data = [];
        $email = $this->paramPOST['email'];
        $codeGenere = bin2hex(random_bytes(2));
        $recupEmail = $this->homeModels->getEmail($email);
        $insertCode = $this->homeModels->insertCodeGenere($email,$codeGenere);
        $data['messageEnvoye'] = "Un mail contenant un lien vous a été envoyé." ;
        //var_dump($data);die;
        $this->views->setData($data);
        Utils::envoiMail($recupEmail->nom, $recupEmail->mail, $codeGenere);
        //Utils::redirect("home", "index");
        $this->views->getPage('home/acceuil');



    }

    public function confirmationCode__()
    {
        $this->views->getPage('bus/confirmationCode');
    }

    public function updateConfirmation__(){
        $this->views->getPage('bus/updateMotDePasse');

    }

    public function traitementCode(){
        //$confirmationCode = $this->paramPOST['code_genere'];
        $data['confirmationCode'] = $this->paramPOST['code_genere'];
        $recupUser = $this->homeModels->confirmationCode($data['confirmationCode']);
        //var_dump($data);die;
        $this->views->setData($data);
       if($recupUser){
           json_encode(array('ok'=>1)) ;
           $this->views->setData($data);
           //Utils::redirect("home", "updateConfirmation");
           $this->views->getPage('bus/updateMotDePasse');

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





    ////END


}