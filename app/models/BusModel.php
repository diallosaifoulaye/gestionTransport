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

class BusModel extends BaseModel
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
     * Ajout Bus
     */
    public function insertBus($param)
    {
        $this->table = "bus";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Lister Bus
     */

    public function getAllBus($param = null)
    {
        //var_dump($param);die;
        $this->table = "bus as b";
        $this->champs = ["b.id","b.matricule","b.couleur","c.libelle as categorie","b.places","b.etat"];
        $this->jointure = [
            "INNER JOIN categorie as c ON b.categorie = c.id",
            "INNER JOIN gie as g ON b.numGIE = g.id"
        ];
        $this->condition = ['b.numGie =' => $param->gie];


        return $this->__processing();
    }
    public function AllBus($param = null)
    {
        $this->table = "bus";
        $this->champs = ["id","matricule","couleur","categorie","etat"];
        $this->__addParam($param);
        return $this->__select();
    }
    public function getBus($param = null)
    {
        $this->table = "bus";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getOneBus($param = null)
    {
        $this->table = "bus b";
        $this->champs = ["b.id","b.matricule","b.couleur","c.libelle as categorie","b.photo","b.etat"];
        $this->jointure = ["INNER JOIN categorie as c ON b.categorie = c.id"];

        $this->__addParam($param);
        return $this->__detail();
    }

    /**
     * Modification Bus
     */
    public function updateBus($param)
    {
        $this->table = "bus";
       // $this->table = "categorie";

        //$this->jointure = ["INNER JOIN categorie as c ON b.categorie = c.id"];

        $this->__addParam($param);
        return $this->__update();
    }
    public function updateBusDetail($param)
    {
        $this->table = "bus";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Bus
     */
    public function deleteBus($param)
    {
        $this->table = "bus";
        $this->__addParam($param);
        return $this->__delete();
    }
    public function updatePhoto($param){

        $this->table = "bus";
        $this->__addParam($param);
        return $this->__update();

    }

    /**
     * Suppression  Affection des Droit
     */
//    public function deleteAffectDroit($param)
//    {
//        $this->table = "affectation_droit";
//        $this->condition=["fk_profil="=>$param];
//        return $this->__delete();
//    }
//    /**
//     * Affection des Droit
//     */
//    public function insertAffectDroit($param)
//    {
//        $this->table = "affectation_droit";
//        $this->__addParam($param);
//        return $this->__insert();
//    }
//
//    /**
//     * Affection des Droit
//     */
//    public function getDroitprofil($param)
//    {
//        $this->table = "affectation_droit ad";
//        $this->champs =["fk_droit"];
//        $this->condition=["fk_profil="=>$param];
//        return $this->__select();
//    }
//
//    public function getidprofil($param = null)
//    {
//        $this->table = "profil";
//        $this->__addParam($param);
//        return $this->__select();
//    }
//    /*********Liste Modules************/
//    public function  allModule($param)
//    {
//        $this->table = "module";
//        $this->champs = ["id", "libelle"];
//        $this->__addParam($param);
//        return $this->__select();
//    }
//
//    /*********Liste Groupe************/
//    public function  allGroupe($param)
//    {
//        $this->table = "typeprofil";
//        $this->champs = ["id", "libelle"];
//        $this->__addParam($param);
//        return $this->__select();
//    }
//
//    /************get Fk_Groupe par id profil*************/
//    public function getFKGroupe($param)
//    {
//        $this->table = "profil p";
//        $this->champs =['p.fk_typeprofil'];
//        $this->__addParam($param);
//        return $this->__detail()['fk_typeprofil'];
//    }
//
//    /************* allActions Autorise By Profil ***************/
//    public function allActionsAutoriseByProfil($param)
//    {
//        $mesactionsAutorises = array();
//        $this->table = "affectation_droit";
//        $this->champs =['fk_droit'];
//        $this->__addParam($param);
//        $a = $this->__select();
//        foreach($a as $t){
//            array_push($mesactionsAutorises, $t->fk_droit);
//        }
//        return $mesactionsAutorises;
//    }
//
//    /************get Profil par id Bus*************/
//    public function getProfilByIdInteger($param)
//    {
//        $this->table = "bus b";
//        $this->champs =['b.id', 'b.categorie', 'p.couleur'];
//        //$this->jointure = ["LEFT JOIN utilisateur u ON p.user_creation = u.id", "LEFT JOIN typeprofil g ON p.fk_typeprofil = g.id"];
//        $this->__addParam($param);
//        return $this->__detail();
//    }
//
//    /*********all Actions By Module************/
//    public function allActionsByModule($module)
//    {
//        $this->table = "droit";
//        $this->champs =['id', 'droit', 'fk_module'];
//        $this->condition=["fk_module ="=>$module, "etat ="=>1];
//        return $this->__select();
//    }
//    /***********SUPPRIMER ACTION AFFECTEE AU PROFIL $id*****/
//    public function deleteAutoriseAction($param)
//    {
//        //$id= $_POST['profil'];
//        $this->table = "affectation_droit";
//        $this->__addParam($param);
//        return $this->__delete();
//    }
//
//    /*********************AFFECTATION DROIT PROFIL****/
//    public function autoriseAction($action,$profil,$user_creation)
//    {
//        $this->table = "affectation_droit";
//        $array = ['fk_droit'=>$action, 'fk_profil'=>$profil, 'etat'=>1, 'user_creation'=>$user_creation, 'date_creation'=>date('Y-m-d H:i:s')];
//        $this->champs = $array;
//        return $this->__insert();
//    }
//
//    public function updatePhoto($param){
//
//        $this->table = "bus";
//        $this->__addParam($param);
//        return $this->__update();
//
//    }
//
//    public function getTypecategorie($param = null)
//    {
//        $this->table = "categorie";
//        $this->__addParam($param);
//        return $this->__select();
//    }



}