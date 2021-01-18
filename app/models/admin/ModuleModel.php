<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models\admin;

use app\core\BaseModel;

class ModuleModel extends BaseModel
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
    public function insertModule($param)
    {
        $this->table = "module";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Processing module
     */
    public function getAllModule($param = null)
    {
        $this->table = "module";
        $this->champs = ["id","libelle","etat"];
        return $this->__processing();
    }
    public function getModule($param = null)
    {
        $this->table = "module";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getOneModule($param = null)
    {
        $this->table = "module";
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Module
     */
    public function updateModule($param)
    {
        $this->table = "module";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Module
     */
    public function deleteModule($param)
    {
        $this->table = "module";
        $this->__addParam($param);
        return $this->__delete();
    }


}