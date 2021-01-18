<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models\admin;

use app\core\BaseModel;

class ProfilModel extends BaseModel
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
     * Ajout Profil
     */
    public function insertProfil($param)
    {
        $this->table = "profil";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Lister Profil
     */
    public function getAllProfil($param = null)
    {
        $this->table = "profil";
        $this->champs = ["id","profil","etat"];
        return $this->__processing();
    }
    public function AllProfil($param = null)
    {
        $this->table = "profil";
        $this->champs = ["id","profil","etat"];
        $this->__addParam($param);
        return $this->__select();
    }
    public function getProfil($param = null)
    {
        $this->table = "profil";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getOneProfil($param = null)
    {
        $this->table = "profil";
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Profil
     */
    public function updateProfil($param)
    {
        $this->table = "profil";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Profil
     */
    public function deleteProfil($param)
    {
        $this->table = "profil";
        $this->__addParam($param);
        return $this->__delete();
    }
    /**
     * Suppression  Affection des Droit
     */
    public function deleteAffectDroit($param)
    {
        $this->table = "affectation_droit";
        $this->condition=["fk_profil="=>$param];
        return $this->__delete();
    }
    /**
     * Affection des Droit
     */
    public function insertAffectDroit($param)
    {
        $this->table = "affectation_droit";
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * Affection des Droit
     */
    public function getDroitprofil($param)
    {
        $this->table = "affectation_droit ad";
        $this->champs =["fk_droit"];
        $this->condition=["fk_profil="=>$param];
       return $this->__select();
    }

    public function getidprofil($param = null)
    {
        $this->table = "profil";
        $this->__addParam($param);
        return $this->__select();
    }
    /*********Liste Modules************/
    public function  allModule($param)
    {
        $this->table = "module";
        $this->champs = ["id", "libelle"];
        $this->__addParam($param);
        return $this->__select();
    }

    /*********Liste Groupe************/
    public function  allGroupe($param)
    {
        $this->table = "typeprofil";
        $this->champs = ["id", "libelle"];
        $this->__addParam($param);
        return $this->__select();
    }

    /************get Fk_Groupe par id profil*************/
    public function getFKGroupe($param)
    {
        $this->table = "profil p";
        $this->champs =['p.fk_typeprofil'];
        $this->__addParam($param);
        return $this->__detail()['fk_typeprofil'];
    }

    /************* allActions Autorise By Profil ***************/
    public function allActionsAutoriseByProfil($param)
    {
        $mesactionsAutorises = array();
        $this->table = "affectation_droit";
        $this->champs =['fk_droit'];
        $this->__addParam($param);
        $a = $this->__select();
        foreach($a as $t){
            array_push($mesactionsAutorises, $t->fk_droit);
        }
        return $mesactionsAutorises;
    }

    /************get Profil par id profil*************/
    public function getProfilByIdInteger($param)
    {
        $this->table = "profil p";
        $this->champs =['p.id', 'p.profil', 'p.etat', 'g.libelle', 'u.prenom', 'u.nom', 'p.date_creation'];
        $this->jointure = ["LEFT JOIN utilisateur u ON p.user_creation = u.id", "LEFT JOIN typeprofil g ON p.fk_typeprofil = g.id"];
        $this->__addParam($param);
        return $this->__detail();
    }

    /*********all Actions By Module************/
    public function allActionsByModule($module)
    {
        $this->table = "droit";
        $this->champs =['id', 'droit', 'fk_module'];
        $this->condition=["fk_module ="=>$module, "etat ="=>1];
        return $this->__select();
    }
    /***********SUPPRIMER ACTION AFFECTEE AU PROFIL $id*****/
    public function deleteAutoriseAction($param)
    {
        //$id= $_POST['profil'];
        $this->table = "affectation_droit";
        $this->__addParam($param);
        return $this->__delete();
    }

    /*********************AFFECTATION DROIT PROFIL****/
    public function autoriseAction($action,$profil,$user_creation)
    {
        $this->table = "affectation_droit";
        $array = ['fk_droit'=>$action, 'fk_profil'=>$profil, 'etat'=>1, 'user_creation'=>$user_creation, 'date_creation'=>date('Y-m-d H:i:s')];
        $this->champs = $array;
        return $this->__insert();
    }
}