<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class TypeprofilModel extends BaseModel
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
     * Ajout Typeprofil
     */
    public function insertTypeprofil($param)
    {
        $this->table = "typeprofil";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Lister typeprofil
     */
    public function getAllTypeprofil($param = null)
    {
        $this->table = "typeprofil";
        $this->champs = ["id","libelle","etat as _etat_"];
        return $this->__processing();
    }
    public function getTypeprofil($param = null)
    {
        $this->table = "typeprofil";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getOneTypeprofil($param = null)
    {
        $this->table = "typeprofil";
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Typeprofil
     */
    public function updateTypeprofil($param)
    {
        $this->table = "typeprofil";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Typeprofil
     */
    public function deleteTypeprofil($param)
    {
        $this->table = "typeprofil";
        $this->__addParam($param);
        return $this->__delete();
    }


}