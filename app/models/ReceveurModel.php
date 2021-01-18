<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class ReceveurModel extends BaseModel
{

    /**
     * HomeModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * HomeModel destruct.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * @param $param
     * @return bool|mixed
     */

    /**
     * Ajout Receveur
     */
    public function insertReceveur($param)
    {
        $this->table = "utilisateur u";
        $this->condition = ['u.type =' => 3];
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * Processing Chauffeur
     */
    public function getAllReceveur($param = null)
    {
        // $gie=$this->_USER->gie ;
        $this->table = "utilisateur u";
        $this->champs = ["u.id","u.prenom","u.nom","u.email","u.login","u.etat"];
        $this->jointure = [
            "INNER JOIN gie as g ON u.gie = g.id"
        ];
        $this->condition = ['u.gie =' => $param->gie,
            'u.type =' => 3
        ];

        return $this->__processing();
    }
    public function updateReceveur($param )
    {
        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__update();
    }
    public function getProfil($param = null)
    {
        $this->table = "profil";
        $this->__addParam($param);
        return $this->__select();
    }

    public function verifEmailModel($email)
    {
        $this->table = "utilisateur";
        $this->champs = ["id"];
        $this->condition=["email ="=>$email];
        $count = count($this->__select());
        if($count > 0) return 1;
        else return -1;
    }
    public function getGie($param = null)
    {
        $this->table = "gie";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getReceveur($param = null)
    {
        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Suppression Receveur
     */
    public function deleteReceveur($param)
    {
        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__delete();
    }

    public function getOneReceveur($param = null)
    {
        $this->table = "utilisateur as u";
        $this->champs = ["u.id", "u.prenom", "u.nom", "u.email", "u.login", "p.profil", "u.telephone", "u.photo", "u.admin", "u.etat"];
        $this->jointure = ["INNER JOIN profil as p ON u.fk_profil = p.id"];
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Receveur
     */

    public function updateReceveurDetail($param)
    {
        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__update();
    }
    public function updatePhotoReceveur($param){

        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__update();

    }


}