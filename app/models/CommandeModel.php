<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class CommandeModel extends BaseModel
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
     * Ajout Commande
     */
    public function insertCommande($param)
    {

        $this->table = "commande";
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * Lister Commande
     */
    public function getAllCommande($param = null)
    {
        $this->table = "commande c";
        $this->champs = ["c.id", "c.code_cmde", "c.code_cmde_site", "c.pays_origine", "c.site_cmde", "c.pays_dest", "c.ville_dest", "c.description", "c.tarif", "c.date_cmde","s.libelle"];
        $this->jointure =[
            "left outer JOIN statut_commande s ON c.fk_statut = s.id"
        ];

        return $this->__processing();
    }
    public function getDetailCommande($param = null)
    {
        $this->table = "commande c";
        $this->champs = ["c.id", "c.code_cmde", "c.code_cmde_site", "c.pays_origine", "c.site_cmde", "c.pays_dest", "c.ville_dest", "c.description", "c.tarif", "c.date_cmde","s.libelle"];
        $this->jointure =[
            "left outer JOIN statut_commande s ON c.fk_statut = s.id"
        ];
        $this->__addParam($param);
        return $this->__detail();
    }
    public function getCommande($param = null)
    {
        $this->table = "commande";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getOneCommande($param = null)
    {
        $this->table = "commande";
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Commande
     */
    public function updateCommande($param)
    {
        $this->table = "commande";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Commande
     */
    public function deleteCommande($param)
    {
        $this->table = "commande";
        $this->__addParam($param);
        return $this->__delete();
    }



    /**
     * Ajout statut Commande
     */
    public function insertStatutCommande($param)
    {

        $this->table = "statut_commande";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
    /**
     * Lister  statut Commande
     */
    public function getAllStatutCommande($param = null)
    {
        $this->table = "statut_commande";
        $this->champs = ["id", "libelle"];
        return $this->__processing();
    }


    public function getOneStatutCommande($param = null)
    {
        $this->table = "statut_commande";
        $this->__addParam($param);
        return $this->__detail();
    }
    /**&
     * Modification statut Commande
     */
    public function updateStatutCommande($param)
    {
        $this->table = "statut_commande";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression statut Commande
     */
    public function deleteStatutCommande($param)
    {
        $this->table = "statut_commande";
        $this->__addParam($param);
        return $this->__delete();
    }
    public function getStatutCommande($param = null)
    {
        $this->table = "statut_commande";
        $this->__addParam($param);
        return $this->__select();
    }
}