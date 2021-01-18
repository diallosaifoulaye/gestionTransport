<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class GestionModel extends BaseModel
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
     * Ajout Type
     */
    public function insertType($param)
    {
        $this->table = "type_materiel";
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * Processing Chauffeur
     */
    public function getAllType($param = null)
    {
        // $gie=$this->_USER->gie ;
        $this->table = "type_materiel as t";
        $this->champs = ["t.rowid","t.libelle","t.etat"];
        $this->jointure = [
            "INNER JOIN gie as g ON t.numGIE = g.id"
                        ];
        $this->condition = ['t.numGIE =' => $param->gie];
        return $this->__processing();
    }
    public function updateType($param)
    {
        $this->table = "type_materiel";
        $this->__addParam($param);
        return $this->__update();
    }

    public function getType($param = null)
    {
        $this->table = "type_materiel";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Suppression Type
     */
    public function deleteType($param)
    {
        $this->table = "type_materiel";
        $this->__addParam($param);
        return $this->__delete();
    }

    public function getOneType($param = null)
    {

        $this->table = "type_materiel as t";
        $this->champs = ["t.rowid","t.libelle","t.etat"];
        $this->jointure = [
            "INNER JOIN gie as g ON t.numGIE = g.id"
        ];

        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Type
     */

    public function updateTypeDetail($param)
    {
        $this->table = "type_materiel";
        $this->__addParam($param);
        return $this->__update();
    }


    /*****************************************************************************************************************************************************************************************
     *
     */

    public function getAllMateriel($param = null)
    {
        //var_dump($param);die;
        $this->table = "devices as m";
        $this->champs = ["m.rowid","m.nom","m.uuid","m.manufacture","m.model","m.platform","m.user_creation","m.date_creation","m.etat"];

        //$this->condition = ['etat !=' => 2];

        return $this->__processing();
    }

    public function getTypeMateriel($param = null)
    {
        $this->table = "type_materiel";
        $this->__addParam($param);
        return $this->__select();
    }

    public function insertMateriel($param)
    {
        $this->table = "devices";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function updateMateriel($param)
    {
        $this->table = "devices";
        $this->__addParam($param);
        return $this->__update();
    }

    /**
     * Suppression Materiel
     */
    public function deleteMateriel($param)
    {
        $this->table = "devices";
        $this->__addParam($param);
        return $this->__delete();
    }

    public function getMateriel($param = null)
    {
        $this->table = "devices";
        $this->champs = ["rowid"];
        $this->condition = ['etat =' =>1];
        $this->__addParam($param);
        return $this->__select();
    }
    public function AllMateriel($param = null)
    {
        $this->table = "type_materiel";
        $this->champs = ["rowid","libelle","etat"];
        $this->__addParam($param);
        return $this->__select();
    }

    public function getOneMateriel($param = null)
    {
        $this->table = "devices as m";
        $this->champs = ["m.rowid","m.nom","m.uuid","m.manufacture","m.model","m.platform","m.user_creation","m.date_creation","m.etat"];

        $this->__addParam($param);
        return $this->__detail();
    }

    public function updateMaterielDetail($param)
    {
        $this->table = "devices";
        $this->__addParam($param);
        return $this->__update();
    }

    public function updatePhoto($param){

        $this->table = "devices";
        $this->__addParam($param);
        return $this->__update();

    }


    /************************************************************************ AFFECTATION MATEREIL   *********************************************/
    public function getAllAffectMateriel($param = null)
    {
        // $gie=$this->_USER->gie ;
        $this->table = "affectation_bus as a";
        $this->champs = ["a.rowid","CONCAT(r.prenom, ' ', r.nom) as receveur","b.matricule", "m.nom as device", "m.uuid as materiel",
            "DATE(a.date_debut) as date_debut_affect","DATE(a.date_fin) as date_fin_affect","a.etat"];
        $this->jointure = [
            "INNER JOIN utilisateur as r ON a.receveur_id = r.id",
            "INNER JOIN bus as b ON a.bus_id = b.id",
            "INNER JOIN devices as m ON a.device_id = m.rowid"

        ];

        return $this->__processing();
    }
    public function updateAffectMateriel($param)
    {
        $this->table = "affectation_bus";
        $this->__addParam($param);
        return $this->__update();
    }

    public function insertAffectMateriel($param)
    {
        $this->table = "affectation_bus";
        $this->__addParam($param);
        return $this->__insert();
    }
    public function getReceveur($param = null)
    {
        $this->table = "utilisateur r";
       $this->condition = ['r.type =' => 3,'r.uuid = '=>0];
        $this->__addParam($param);
        return $this->__select();
    }
    public function deleteAffectMateriel($param)
    {
        $this->table = "affectation_bus";
        $this->__addParam($param);
        return $this->__delete();
    }


    public function getReceveur2($param)
    {
        $this->table = "utilisateur r";
        $this->champs = ["r.id", "r.prenom", "r.nom", 'a.receveur_id'];
        $this->jointure = ["LEFT JOIN affectation_bus a ON a.receveur_id = r.id"];
        $this->condition = ['r.type = ? AND r.gie = ? AND (a.etat = 0 OR a.receveur_id IS NULL)'];
        $this->value=[3,$param];
        return $this->__select();
    }


    public function getMateriel2($param = null)
    {
        $this->table = "devices r";
        $this->champs = ["r.rowid", "r.nom", "r.uuid","r.model"];
        $this->jointure = ["LEFT JOIN affectation_bus a ON a.device_id = r.rowid"];
        $this->condition = ['r.etat = ? AND (a.etat = 0 OR a.device_id IS NULL)'];
        $this->value=[1];
        return $this->__select();
    }

    public function getBus2($param)
    {
        $this->table = "bus r";
        $this->champs = ["r.id", "r.matricule"];
        $this->jointure = ["LEFT JOIN affectation_bus a ON a.bus_id = r.id"];
        $this->condition = ['r.etat = ? AND r.numGIE = ? AND (a.etat = 0 OR a.bus_id IS NULL)'];
        $this->value=[1, $param];
        return $this->__select();
    }
}