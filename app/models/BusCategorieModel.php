<?php
/**
 * Created by PhpStorm.
 * User: stagiaire_dev_mob
 * Date: 9/26/19
 * Time: 11:33 AM
 */
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class BusCategorieModel extends BaseModel
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
     * Ajout Categorie Categorie
     */
    public function insertCategorie($param)
    {
        $this->table = "categorie";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Lister Categorie
     */
    public function getAllCategorie($param = null)
    {
        $this->table = "categorie";
        $this->champs = ["id","libelle","etat"];
        return $this->__processing();
    }
    public function AllCategorie($param = null)
    {
        $this->table = "categorie";
        $this->champs = ["id","libelle","etat"];
        $this->__addParam($param);
        return $this->__select();
    }
    public function getCategorie($param = null)
    {
        $this->table = "categorie";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getOneCategorie($param = null)
    {
        $this->table = "categorie c";
        $this->champs = ["c.*"];
        //$this->jointure = ["INNER JOIN  as p ON u.fk_profil = p.id"];
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Categorie
     */
    public function updateCategorie($param)
    {
        $this->table = "categorie";
        $this->__addParam($param);
        return $this->__update();
    }
    public function updateCategorieDetail($param)
    {
        $this->table = "bus";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Categorie
     */
    public function deleteCategorie($param)
    {
        $this->table = "categorie";
        $this->__addParam($param);
        return $this->__delete();
    }

    public function getTypeCategorie($param = null)
    {
        $this->table = "categorie";
        $this->__addParam($param);
        return $this->__select();
    }


}