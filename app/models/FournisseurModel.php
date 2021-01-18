<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 31/08/2018
 * Time: 09:43
 */

namespace app\models;

use app\core\BaseModel;

class FournisseurModel extends BaseModel
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
     * Ajout Fournisseur
     */
    public function insertFournisseur($param)
    {
        $this->__beginTransaction();
        $this->table = "sva_fournisseur";
        $this->__addParam($param);
        $insert = $this->__insert();
        if($insert > 0)
        {
            $add = $this->ajouterCompteFournisseur(0, $insert);
            if($add > 0)
            {
                $this->__commit();
                return $insert;
            }
            else{
                $this->__rollBack();
                return false;
            }
        }
        else return false;
    }
    /**
     * Processing Fournisseur
     */
    public function getAllFournisseur($param = null)
    {
        $this->table = "sva_fournisseur as f";
        $this->champs = ["f.rowid","f.nom","f.telephone","p.label","f.etat"];
        $this->jointure = [" 
        INNER JOIN sva_pays as p ON f.fk_pays = p.rowid
        "];
        return $this->__processing();
    }
    /**
     * Get module
     */
    public function getFournisseur($param = null)
    {
        $this->table = "sva_fournisseur";
        $this->__addParam($param);
        return $this->__select();
    }
    /**
     * Détail Fournisseur
     */
    public function getOneFournisseur($param = null)
    {
        $this->table = "sva_fournisseur as f";
        $this->champs = ["f.rowid","f.nom","f.telephone","f.email","f.adresse","f.fk_pays","f.etat","p.label"];
        $this->jointure = [" 
        INNER JOIN sva_pays as p ON f.fk_pays = p.rowid
        "];
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Fournisseur
     */
    public function updateFournisseur($param)
    {
        $this->table = "sva_fournisseur";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Fournisseur
     */
    public function deleteFournisseur($param)
    {
        $this->table = "sva_fournisseur";
        $this->__addParam($param);
        return $this->__delete();
    }


    /**
     * Get type webservice
     */
    public function getTypeWebservice($param = null)
    {
        $this->table = "sva_type_webservice";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Get type interconnexion
     */
    public function getTypeInterconnexion($param = null)
    {
        $this->table = "sva_type_interconnexion";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Ajout Compte Fournisseur
     */
    public function ajouterCompteFournisseur($solde, $fk_fournisseur)
    {
        $this->table = "sva_compte_fournisseur";
        $array = ['solde'=>$solde, 'fk_fournisseur'=>$fk_fournisseur];
        $this->champs = $array;
        return $this->__insert();
    }


}