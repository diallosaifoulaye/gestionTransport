<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 31/08/2018
 * Time: 09:43
 */

namespace app\models\admin;

use app\core\BaseModel;

class PaysModel extends BaseModel
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
     * Ajout Module
     */
    public function insertPays($param)
    {
        $this->table = "sva_pays";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Processing module
     */
    public function getAllPays($param = null)
    {
        $this->table = "sva_pays";
        //$this->champs = ["rowid","label","etat as _etat_"];
        $this->champs = ["rowid","label","etat"];
        return $this->__processing();
    }
    public function getPays($param = null)
    {
        $this->table = "sva_pays";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getOnePays($param = null)
    {
        $this->table = "sva_pays";
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Pays
     */
    public function updatePays($param)
    {
        $this->table = "sva_pays";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Pays
     */
    public function deletePays($param)
    {
        $this->table = "sva_pays";
        $this->__addParam($param);
        return $this->__delete();
    }


}