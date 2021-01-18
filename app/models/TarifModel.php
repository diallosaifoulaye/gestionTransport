<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class TarifModel extends BaseModel
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


    public function insertTarif($param)
    {
        $this->table = "tarif";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function getTarif($param = null)
    {
        $this->table = "tarif";
        $this->__addParam($param);
        return $this->__select();
    }

    public function getMaxPoids($param = null)
    {
        $this->table = "tarif";
        $param = [
            "champs"=>["MAX(poidsmax) AS poidsmax"]
        ];
        $this->__addParam($param);
        return $this->__select()[0]->poidsmax;
    }

    public function deleteTarif($param = null)
    {
        $this->table = "tarif";
        $this->__addParam($param);
        return $this->__delete();
    }
}