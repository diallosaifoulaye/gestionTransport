<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class ControleurModel extends BaseModel
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
     * Ajout Controleur
     */
    public function insertControleur($param)
    {
        $this->table = "controleur";
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * Processing Controleur
     */
    public function getAllControleur($param = null)
    {
        // $gie=$this->_USER->gie ;
        $this->table = "controleur as c";
        $this->champs = ["c.id","c.nom","c.prenom","c.adresse","c.email","c.etat"];
        $this->jointure = [
            "INNER JOIN gie as g ON c.numGie = g.id"
        ];
        $this->condition = ['c.numGIE =' => $param->gie];
        return $this->__processing();
    }
    public function updateControleur($param)
    {
        $this->table = "controleur";
        $this->__addParam($param);
        return $this->__update();
    }

    public function getControleur($param = null)
    {
        $this->table = "controleur";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Suppression Controleur
     */
    public function deleteControleur($param)
    {
        $this->table = "controleur";
        $this->__addParam($param);
        return $this->__delete();
    }

    public function getOneControleur($param = null)
    {

        $this->table = "controleur as c";
        $this->champs = ["c.id","c.nom","c.prenom","c.adresse","c.email","c.telephone","c.photo","c.etat"];


        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Receveur
     */

    public function updateControleurDetail($param)
    {
        $this->table = "controleur";
        $this->__addParam($param);
        return $this->__update();
    }
    public function updatePhotoControleur($param){

        $this->table = "controleur";
        $this->__addParam($param);
        return $this->__update();

    }


}