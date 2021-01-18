<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models\admin;

use app\core\BaseModel;

class DroitModel extends BaseModel
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
     * Ajout Droit
     */
    public function insertDroit($param)
    {
        $this->table = "droit";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Processing droit
     */
    public function getAllDroit($param = null)
    {
        $this->table = "droit";
        $this->champs = ["id","droit","controller","action","etat"];
        return $this->__processing();
    }
    public function getDroit($param = null)
    {
        $this->table = "droit";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getOneDroit($param = null)
    {
        $this->table = "droit";
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Droit
     */
    public function updateDroit($param)
    {
        $this->table = "droit";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Droit
     */
    public function deleteDroit($param)
    {
        $this->table = "droit";
        $this->__addParam($param);
        return $this->__delete();
    }


}