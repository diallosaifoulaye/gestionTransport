<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 31/08/2018
 * Time: 09:43
 */

namespace app\models;

use app\core\BaseModel;

class ParametreModel extends BaseModel
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
    public function insertParametre($param)
    {
        $this->table = "sva_parametre";
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * Processing Web Service
     */
    public function getAllParametre($param = null)
    {
        $this->table = "sva_parametre as p";
        $this->champs = ["p.rowid","p.parametre","p.nbre_parametre"];
        $this->jointure = ["INNER JOIN sva_webservice as ws ON p.fk_webservice = ws.rowid"];
        $this->condition = ["p.fk_webservice =" => $param[0]];
        return $this->__processing();
    }
    /**
     * Get Web Service
     */
    public function getParametre($param = null)
    {
        $this->table = "sva_parametre";
        $this->__addParam($param);
        return $this->__select();
    }
    /**
     * Détail Web Service
     */
    public function getOneParametre($param = null)
    {
        $this->table = "sva_parametre as p";
        $this->champs = ["p.rowid","p.parametre","p.nbre_parametre","p.fk_webservice"];
        $this->jointure = [" 
        INNER JOIN sva_webservice as ws ON p.fk_webservice = ws.rowid
        "];
        $this->condition = ["p.fk_webservice =" => $param[0]];
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Web Service
     */
    public function updateParametre($param)
    {
        $this->table = "sva_parametre";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Web Service
     */
    public function deleteParametre($param)
    {
        $this->table = "sva_parametre";
        $this->__addParam($param);
        return $this->__delete();
    }
    
}