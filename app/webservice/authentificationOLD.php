<?php
/**
 * Created by PhpStorm.
 * User: Seyni Faye
 * Date: 02/07/2018
 * Time: 11:49
 */

namespace app\webservice;

use app\core\ApiServer;
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
     *
     * @url POST /authentifier
     */
    /********************* AUTHENTIFICATION PARTENAIRE **************************/
    public function authentifier()
    {
        $username = parent::$paramPOST['username'];
        $password = parent::$paramPOST['password'];
        $verif_partenaire = $this->model->checkPartenaireExiste($username, $password);
        if($verif_partenaire == 1)
        {
            $new_token = $this->model->genererToken($username);
            if(strlen($new_token) > 30)
            {
                return array('token'=>$new_token);
            }
            else return array('erreurCode'=>9002, 'erreurMessage'=>'Echec génération du token');
        }
        elseif($verif_partenaire == -1)
        {
            return array('erreurCode'=>9003, 'erreurMessage'=>'Partenaire non activer');
        }
        else return array('erreurCode'=>9004, 'erreurMessage'=>'username ou mot de passe incorrect');
    }

}