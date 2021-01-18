<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 31/08/2018
 * Time: 09:43
 */

namespace app\models;

use app\core\BaseModel;

class ApifournisseurModel extends BaseModel
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
     * Ajout API Fournisseur
     */
    public function insertApiFournisseur($param)
    {
        $this->table = "sva_api";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Processing API Fournisseur
     */
    public function getAllApiFournisseur($param)
    {
        $this->table = "sva_api as a";
        $this->champs = ["a.rowid", "a.label", "a.lien", "a.username", "a.password", "a.etat"];
        $this->condition = ["a.fk_fournisseur =" => $param[0]];
        return $this->__processing();
    }
    /**
     * Get API
     */
    public function getApiFournisseur($param = null)
    {
        $this->table = "sva_api";
        $this->__addParam($param);
        return $this->__select();
    }
    /**
     * Détail API Fournisseur
     */
    public function getOneApiFournisseur($param = null)
    {
        $this->table = "sva_api as a";
        $this->champs = ["a.*","f.nom"];
        $this->jointure = [" 
        INNER JOIN sva_fournisseur as f ON a.fk_fournisseur = f.rowid
        "];
        $this->condition = ["a.fk_fournisseur =" => $param[0]];
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification API Fournisseur
     */
    public function updateApiFournisseur($param)
    {
        $this->table = "sva_api";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression API Fournisseur
     */
    public function deleteApiFournisseur($param)
    {
        $this->table = "sva_api";
        $this->__addParam($param);
        return $this->__delete();
    }



}