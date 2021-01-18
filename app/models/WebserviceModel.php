<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 31/08/2018
 * Time: 09:43
 */

namespace app\models;

use app\core\BaseModel;

class WebserviceModel extends BaseModel
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
     * Ajout Web Service
     */
    public function insertWebService($param)
    {
        $this->table = "sva_webservice";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Processing Web Service
     */
    public function getAllWebService($param)
    {
        $this->table = "sva_webservice as ws";
        $this->champs = ["ws.rowid","ws.label","ws.etat"];
        //$this->jointure = ["INNER JOIN sva_api as a ON ws.fk_api = a.rowid"];
        $this->condition = ["ws.fk_api =" => $param[0]];
        return $this->__processing();
    }

    public function allWebService($param)
    {
        $this->table = "sva_webservice as ws";
        $this->champs = ["ws.rowid","ws.label","ws.etat", "ws.fk_api"];
        //$this->jointure = ["INNER JOIN sva_api as a ON ws.fk_api = a.rowid"];
        $this->condition = ["ws.fk_api =" => $param[0]];
        return $this->__select();
    }
    /**
     * Get Web Service
     */
    public function getWebService($param = null)
    {
        $this->table = "sva_webservice";
        $this->__addParam($param);
        return $this->__select();
    }
    /**
     * Détail Web Service
     */
    public function getOneWebService($param)
    {
        $this->table = "sva_webservice as ws";
        $this->champs = ["ws.rowid","ws.label","ws.fk_api","ws.user_creation","ws.date_creation","ws.user_modification","ws.date_modification","ws.etat"];

        $this->condition = ["ws.fk_api =" => $param[0]];
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Web Service
     */
    public function updateWebService($param)
    {
        $this->table = "sva_webservice";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Web Service
     */
    public function deleteWebService($param)
    {
        $this->table = "sva_webservice";
        $this->__addParam($param);
        return $this->__delete();
    }


}