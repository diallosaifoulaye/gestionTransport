<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class TypeinterconnexionModel extends BaseModel
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
     * Ajout Type Interconnexion
     */
    public function insertTypeInterconnexion($param)
    {
        $this->table = "sva_type_interconnexion";
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * Processing Type Interconnexion
     */
    public function getAllTypeInterconnexion($param = null)
    {
        $this->table = "sva_type_interconnexion";
        $this->champs = ["id", "label", "etat"];
        return $this->__processing();
    }

    /**
     * Get Type Interconnexion
     */
    public function getTypeInterconnexion($param = null)
    {
        $this->table = "sva_type_interconnexion";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Détail Type Interconnexion
     */
    public function getOneTypeInterconnexion($param = null)
    {
        $this->table = "sva_type_interconnexion";
        $this->__addParam($param);
        return $this->__detail();
    }

    /**
     * Modification Type Interconnexion
     */
    public function updateTypeInterconnexion($param)
    {
        $this->table = "sva_type_interconnexion";
        $this->__addParam($param);
        return $this->__update();
    }


}