<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class EmployeModel extends BaseModel
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
     * Ajout Chauffeur
     */
    public function insertChauffeur($param)
    {
        $this->table = "employe";
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * Processing Chauffeur
     */
    public function getAllChauffeur($param = null)
    {
       // $gie=$this->_USER->gie ;
        $this->table = "employe as e";
        $this->champs = ["e.id","e.nom","e.prenom","e.adresse","e.email","e.etat"];
         $this->jointure = [
            "INNER JOIN gie as g ON e.numGIE = g.id"
        ];
        $this->condition = ['e.numGIE =' => $param->gie];
        return $this->__processing();
    }
    public function getChauffeur($param = null)
    {
        $this->table = "employe";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getOneChauffeur($param = null)
    {

        $this->table = "employe as e";
        $this->champs = ["e.id","e.nom","e.prenom","e.adresse","e.email","e.telephone","e.photo","e.etat"];

        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Chauffeur
     */
    public function updateChauffeur($param)
    {
        $this->table = "employe";
        $this->__addParam($param);
        return $this->__update();
    }
    public function updateChauffeurDetail($param)
    {
        $this->table = "employe";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Chauffeur
     */
    public function deleteChauffeur($param)
    {
        $this->table = "employe";
        $this->__addParam($param);
        return $this->__delete();
    }
    public function updatePhotoChauffeur($param){

        $this->table = "employe";
        $this->__addParam($param);
        return $this->__update();

    }
    /**
     * Ajout Receveur
     */
    public function insertReceveur($param)
    {
        $this->table = "employe";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Processing receveur
     */





    /**
     * Ajout Controleur
     */
    public function insertControleur($param)
    {
        $this->table = "employe";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Processing controleur
     */
    public function getAllControleur($param = null)
    {
        $gie=$this->_USER->gie ;
        $this->table = "employe as e";
        $this->champs = ["e.id","e.nom","e.prenom","e.adresse","e.email","g.nomgie","e.etat"];
        $this->jointure = ["
                        INNER JOIN gie as g ON e.gie = g.id
                        
                         "];
        if($gie > 0 ){

            $this->condition = ["e.profil=" =>3,  "e.gie="=>$gie];
        }
        else{
            $this->condition = ["e.profil=" =>3];
        }

        return $this->__processing();
    }
    public function getControleur($param = null)
    {
        $this->table = "employe";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getOneControleur($param = null)
    {
        $gie=$this->_USER->gie ;
        $this->table = "employe as e";
        $this->champs = ["e.id","e.nom","e.prenom","e.adresse","e.email","e.telephone","e.photo","e.etat","g.nom","g.adresse"];
        $this->jointure = ["
                        INNER JOIN gie as g ON e.gie = g.id
                        
                         "];
        if($gie > 0 ){

            $this->condition = ["e.profil=" =>3,  "e.gie="=>$gie];
        }
        else{
            $this->condition = ["e.profil=" =>3];
        }
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Controleur
     */
    public function updateControleur($param)
    {
        $this->table = "employe";
        $this->__addParam($param);
        return $this->__update();
    }
    public function updateControleurDetail($param)
    {
        $this->table = "employe";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Controleur
     */
    public function deleteControleur($param)
    {
        $this->table = "employe";
        $this->__addParam($param);
        return $this->__delete();
    }
    public function updatePhotoControleur($param){

        $this->table = "employe";
        $this->__addParam($param);
        return $this->__update();

    }

}