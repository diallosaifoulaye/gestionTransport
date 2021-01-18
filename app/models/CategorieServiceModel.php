<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class CategorieServiceModel extends BaseModel
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
     * Ajout Catégorie Service
     */
    public function insertCatService($param)
    {
        $this->table = "sva_categorie_service";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**********verifier Code**********/
    public function verifCodeModel($code)
    {
        $this->table = "sva_categorie_service";
        $this->champs = ["rowid"];
        $this->condition=["code ="=>$code];
        $count = count($this->__select());
        if($count > 0) return 1;
        else return -1;
    }
    /**
     * Processing Catégorie Service
     */
    public function getAllCatService($param = null)
    {
        $this->table = "sva_categorie_service";
        $this->champs = ["rowid", "code", "label", "etat"];
        return $this->__processing();
    }

    /**
     * Get Catégorie Service
     */
    public function getCatService($param = null)
    {
        $this->table = "sva_categorie_service";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Détail Catégorie Service
     */
    public function getOneCatService($param = null)
    {
        $this->table = "sva_categorie_service";
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Catégorie Service
     */
    public function updateCatService($param)
    {
        $this->table = "sva_categorie_service";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Catégorie Service
     */
    public function deleteCatService($param)
    {
        $this->table = "sva_categorie_service";
        $this->__addParam($param);
        return $this->__delete();
    }


}