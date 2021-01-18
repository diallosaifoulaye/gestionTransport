<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class ServiceModel extends BaseModel
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
     * Ajout Service
     */
    public function insertService($param)
    {
        $this->table = "sva_service_sunusva";
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * Vérifier nom méthode
     */
    public function verifMethodeModel($methode)
    {
        $this->table = "sva_service_sunusva";
        $this->champs = ["rowid"];
        $this->condition=["methode ="=>$methode];
        $count = count($this->__select());
        if($count > 0) return 1;
        else return -1;
    }
    /**
     * Processing Service
     */
    public function getAllService($param = null)
    {
        $this->table = "sva_service_sunusva as s";
        $this->champs = ["s.rowid","s.label as service","c.label as categorie","s.methode","s.etat","s.disponibilite as _disponibilite_"];
        $this->jointure = ["INNER JOIN sva_categorie_service c ON s.fk_categorie = c.rowid"];
        return $this->__processing();
    }

    /**
     * Get Service
     */
    public function getService($param = null)
    {
        $this->table = "sva_service_sunusva";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Détail Service
     */
    public function getOneService($param = null)
    {
        $this->table = "sva_service_sunusva as s";
        $this->champs = ["s.rowid","s.label as service","s.fk_categorie","c.label as categorie","s.etat", "s.disponibilite", "s.fk_fournisseur"];
        $this->jointure = ["INNER JOIN sva_categorie_service c ON s.fk_categorie = c.rowid"];
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Service
     */
    public function updateService($param)
    {
        $this->table = "sva_service_sunusva";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Service
     */
    public function deleteService($param)
    {
        $this->table = "sva_service_sunusva";
        $this->__addParam($param);
        return $this->__delete();
    }


    /**
     * Ajout Parametrage Service
     */
    public function insertParamService($param)
    {
        $this->table = "sva_tarif_frais";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Get Api
     */
    public function getApi($param)
    {
        $this->table = "sva_api";
        //$this->champs = ["rowid","username","password"];
        $this->__addParam($param);
        return $this->__detail();
    }

    /**
     * Recuperer Id Service
     */
    public function getIdService($methode)
    {
        $this->table = "sva_service_sunusva";
        $this->champs =['rowid'];
        $this->condition=["methode ="=>$methode, "etat ="=>1];
        return $this->__detail()->rowid;
    }

    /**
     * Recuperer Id Fournisseur
     */
    public function getIdFournisseur($methode)
    {
        $this->table = "sva_service_sunusva";
        $this->champs =['fk_fournisseur'];
        $this->condition=["methode ="=>$methode, "etat ="=>1];
        return $this->__detail()->fk_fournisseur;
    }

    public function Generer_numtransaction()
    {
        $found = 0;
        do {
            $code = rand(1, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(1, 9);
            $etat =  $this->verifyTransaction($code);
            if ($etat == 1) {
                $found = 1;
            }
        } while ($found == 0);
        return $code;
    }

    public function verifyTransaction($code)
    {

        $this->table = "sva_transaction";
        $this->champs =['rowid'];
        $this->condition=["num_transaction  ="=>$code, "statut ="=>1];
        $a = count($this->__select());
        if ($a > 0) {
            return 0;
        } else {
            return 1;
        }
    }



}