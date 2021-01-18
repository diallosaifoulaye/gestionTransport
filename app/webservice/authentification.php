<?php
/**
 * Created by PhpStorm.
 * User: Seyni Faye
 * Date: 02/07/2018
 * Time: 11:49
 */

namespace app\webservice;

use app\core\ApiServer;
use app\core\TokenJWT;

class authentification extends ApiServer
{
    private $model;
    public function __construct()
    {
        parent::__construct(__CLASS__);
        $this->model = $this->model("partenaire");
    }

    /**
     * Authentification partenaire
     * @params : username et password du partenaire
     * @url POST /authentifier
     */
    /********************* AUTHENTIFICATION PARTENAIRE **************************/
    public function authentifier()
    {
        $username = parent::$paramPOST['username'];
        $password = parent::$paramPOST['password'];
        $verif_partenaire = $this->model->checkPartenaireExiste($username, $password);
        if(intval($verif_partenaire) > 0)
        {
            $param = [
                "id"=>intval($verif_partenaire),
                "username"=>$username,
                "password"=>$password
            ];
            $new_token = TokenJWT::encode($param,TOKEN_KEY);
            return array('token'=>$new_token);
        }
        elseif($verif_partenaire == -1)
        {
            return array('erreurCode'=>9003, 'erreurMessage'=>'Partenaire non activer');
        }
        else return array('erreurCode'=>9004, 'erreurMessage'=>'username ou mot de passe incorrect');
    }

}