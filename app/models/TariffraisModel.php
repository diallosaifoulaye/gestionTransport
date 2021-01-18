<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class TariffraisModel extends BaseModel
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
     * Ajout Tarif Frais
     */
    public function insertTarifFrais($param)
    {
        $this->table = "sva_tarif_frais";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Processing Tarif Frais
     */
    public function getAllTarifFrais($param)
    {
        $this->table = "sva_tarif_frais";
        $this->champs = ["rowid", "montant_deb","montant_fin","valeur"];
        $this->condition = ["fk_service =" => $param[0]];
        return $this->__processing();
    }

    /**
     * Get Tarif Frais
     */
    public function getTarifFrais($param = null)
    {
        $this->table = "sva_tarif_frais";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Détail Tarif Frais
     */
    public function getOneTarifFrais($param = null)
    {
        $this->table = "sva_tarif_frais as t";
        $this->champs = ["t.rowid","s.label as service","c.label as categorie","t.montant_deb","t.montant_fin","t.tva", "t.ht", "t.valeur"];
        $this->jointure = [
            "INNER JOIN sva_service_sunusva s ON t.fk_service = s.rowid",
            "INNER JOIN sva_categorie_service c ON s.fk_categorie = c.rowid"
        ];
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Tarif Frais
     */
    public function updateTarifFrais($param)
    {
        $this->table = "sva_tarif_frais";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Tarif Frais
     */
    public function deleteTarifFrais($param)
    {
        $this->table = "sva_tarif_frais";
        $this->__addParam($param);
        return $this->__delete();
    }


}