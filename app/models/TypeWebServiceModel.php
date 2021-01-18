<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class TypewebserviceModel extends BaseModel
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
     * Ajout Type WebService
     */
    public function insertTypeWebService($param)
    {
        $this->table = "sva_type_webservice";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Processing Type Web Service
     */
    public function getAllTypeWebService($param = null)
    {
        $this->table = "sva_type_webservice";
        $this->champs = ["id","label","etat"];
        return $this->__processing();
    }

    /**
     * Get Type Web Service
     */
    public function getTypeWebService($param = null)
    {
        $this->table = "sva_type_webservice";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Détail Type Web Service
     */
    public function getOneTypeWebService($param = null)
    {
        $this->table = "sva_type_webservice";
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Type Web Service
     */
    public function updateTypeWebService($param)
    {
        $this->table = "sva_type_webservice";
        $this->__addParam($param);
        return $this->__update();
    }


}