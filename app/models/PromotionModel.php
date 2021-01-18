<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class PromotionModel extends BaseModel
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


    public function insertPromotion($param)
    {
        $this->table = "promotion";
        $this->__addParam($param);
        return $this->__insert();
    }
    public function getAllPromotion()
    {
        $this->table = "promotion as p";
        $this->champs = ["p.id","p.libelle","p.date_debut","p.date_fin","p.pourcentage_carte","p.pourcentage_recharge","p.etat as etat"];
        return $this->__processing();
    }
    public function getOnePromotion($param = null)
    {
        $this->table = "promotion p";
        $this->champs = ["p.*"];
        $this->__addParam($param);
        return $this->__detail();
    }

    public function updatePromotion($param)
    {
        $this->table = "promotion";
        $this->__addParam($param);
        return $this->__update();
    }





}