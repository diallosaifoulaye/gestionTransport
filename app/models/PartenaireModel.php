<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;
use app\core\Security;
use app\core\Utils;

class PartenaireModel extends BaseModel
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
     * Ajout Partenaire
     */
    public function insertPartenaire($param)
    {
        $this->__beginTransaction();
        $this->table = "sva_partenaire";
        $this->__addParam($param);
        $insert = $this->__insert();
        if($insert > 0)
        {
            $add = $this->ajouterComptePartenaire(0, $insert);
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
     * Ajout Compte Partenaire
     */
    public function ajouterComptePartenaire($solde, $fk_partenaire)
    {
        $this->table = "sva_compte_partenaire";
        $array = ['solde'=>$solde, 'fk_partenaire'=>$fk_partenaire];
        $this->champs = $array;
        return $this->__insert();
    }
    /**
     * Vérifier si email existe déjà
     */
    public function verifEmailModel($email)
    {
        $this->table = "sva_partenaire";
        $this->champs = ["rowid"];
        $this->condition=["email ="=>$email];
        $count = count($this->__select());
        if($count > 0) return 1;
        else return -1;
    }
    /**
     * Vérifier si login existe déjà
     */
    public function verifLoginModel($login)
    {
        $this->table = "sva_partenaire";
        $this->champs = ["rowid"];
        $this->condition=["login ="=>$login];
        $count = count($this->__select());
        if($count > 0) return 1;
        else return -1;
    }
    /**
     * Lister Partenaire
     */
    public function getAllPartenaire($param = null)
    {
        $this->table = "sva_partenaire";
        $this->champs = ["rowid","raison_sociale","login","email","telephone","etat"];
        return $this->__processing();
    }

    /**
     * Get Partenaire
     */
    public function getPartenaire($param = null)
    {
        $this->table = "sva_partenaire";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Détail Partenaire
     */
    public function getOnePartenaire($param = null)
    {
        $this->table = "sva_partenaire";
        $this->champs = ["rowid","raison_sociale","cle","login","email","telephone","adresse","etat","user_creation","date_creation","user_modification","date_modification"];
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Update Partenaire
     */
    public function updatePartenaire($param)
    {
        $this->table = "sva_partenaire";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Partenaire
     */
    public function deletePartenaire($param)
    {
        $this->table = "sva_partenaire";
        $this->__addParam($param);
        return $this->__delete();
    }
    /*********all categoie services ************/
    public function allCatServices()
    {
        $this->table = "sva_categorie_service";
        $this->champs =['rowid', 'label'];
        $this->condition=["etat ="=>1];
        return $this->__select();
    }
    /*********all services by categorie************/
    public function allServiceyCat($module)
    {
        $this->table = "sva_service_sunusva";
        $this->champs =['rowid', 'label', 'fk_categorie'];
        $this->condition=["fk_categorie ="=>$module, "etat ="=>1];
        return $this->__select();
    }
    /************* allActions Services By categorie ***************/
    public function allActionsAutoriseByPartenaire($param)
    {
        $mesactionsAutorises = array();
        $this->table = "sva_souscription_paretenaire";
        $this->champs =['fk_service'];
        $this->__addParam($param);
        $a = $this->__select();
        foreach($a as $t){
            array_push($mesactionsAutorises, $t->fk_service);
        }
        return $mesactionsAutorises;
    }
    /***********SUPPRIMER SERVICE AFFECTEE AU PARTENAIRE $id*****/
    public function deleteAutoriseService($param)
    {
        $this->table = "sva_souscription_paretenaire";
        $this->__addParam($param);
        return $this->__delete();
    }

    /*********************AFFECTATION SERVICE PARTENAIRE****/
    public function autoriseService($fk_service,$fk_partenaire,$pourcentage_partenaire,$pourcentage_sva,$pourcentage_fournisseur,$user_creation)
    {
        $this->table = "sva_souscription_paretenaire";
        $array = ['fk_service'=>$fk_service, 'fk_partenaire'=>$fk_partenaire, 'etat'=>1, 'pourcentage_partenaire'=>$pourcentage_partenaire, 'pourcentage_sva'=>$pourcentage_sva, 'pourcentage_fournisseur'=>$pourcentage_fournisseur, 'date_souscription'=>date('Y-m-d H:i:s'), 'user_creation'=>$user_creation];
        $this->champs = $array;
        return $this->__insert();
    }

    /*********all services by categorie************/
    public function pourcentage_partenaire($fk_partenaire,$fk_service)
    {
        $this->table = "sva_souscription_paretenaire";
        $this->champs =['pourcentage_partenaire','pourcentage_sva','pourcentage_fournisseur'];
        $this->condition=["fk_partenaire ="=>$fk_partenaire, "fk_service ="=>$fk_service, "etat ="=>1];
        return $this->__detail();
    }

    /*********all services by categorie************/
    public function allUserPart($module)
    {
        $this->table = "sva_user_partenaire";
        $this->champs =['rowid', 'nom_complet', 'login'];
        $this->condition=["fk_partenaire ="=>$module];
        return $this->__select();
    }

    /**********VERIFIER SI UN PARTENAIRE EST SOUSCRIT A UN SERVICE***************/
    public function checkPartenaireAccess($partenaire, $service)
    {
        $this->table = "sva_souscription_paretenaire";
        $this->champs = ["rowid"];
        $this->condition=["fk_partenaire ="=>$partenaire, "fk_service ="=>$service, "etat ="=>1];
        $count = count($this->__select());
        if($count == 1) return 1;
        else return 0;
    }

    /****************** VERIFIER SI UN PARTENAIRE EST ACTIVE ********************/
    public function checkPartenaireExiste($username, $password)
    {
        $this->table = 'sva_partenaire';
        $this->champs = ['rowid', 'etat'];
        $this->condition=['login ='=>$username, 'password ='=>$password];
        $select = $this->__select();

        if(count($select) == 1)
        {
            if($select[0]->etat == 1){
                return $select[0]->rowid; //partenaire valide et active
            }
            else{
                return -1; //partenaire inactive
            }
        }
        else {
            return -2; //username ou password incorrect
        }
    }

    /********************* RETOURNER LE SOLDE DU PARTENAIRE *********************/
    public function getSoldePartenaire($partenaire)
    {
        $this->table = "sva_compte_partenaire";
        $this->champs = ["solde"];
        $this->condition=["fk_partenaire ="=>$partenaire, "etat ="=>1];

        $select = $this->__select();
        if(count($select) == 1) return $select[0]->solde;
        else return 0;
    }

    /********************* RETOURNER LE USER ADMIN DU PARTENAIRE *********************/
    public function getUserPartenaire($partenaire)
    {
        $this->table = 'sva_user_partenaire';
        $this->champs = ['rowid'];
        $this->condition=['fk_partenaire ='=>$partenaire, 'admin ='=>1];
        return $this->__detail()->rowid;
    }


    /******************* DEBITER COMPTE PARTENAIRE ********************/
    public function debiterSoldePartenaire($montant,$partenaire)
    {
        $this->__beginTransaction();
        $this->table = "sva_compte_partenaire";
        $this->champs = ["solde = solde -"=>$montant];
        $this->condition=["fk_partenaire ="=>$partenaire, "etat ="=>1];
        $res = $this->__update();
        if ($res){
            $this->__commit();
            return $res;
        }else{
            $this->__rollBack();
            return $res;
        }

    }
    /******************* CREDITER COMPTE PARTENAIRE ********************/
    public function crediterSoldePartenaire($montant,$partenaire)
    {
        $this->__beginTransaction();
        $this->table = "sva_compte_partenaire";
        $this->champs = ["solde = solde +"=>$montant];
        $this->condition=["fk_partenaire ="=>$partenaire, "etat ="=>1];
        $res = $this->__update();
        if ($res){
            $this->__commit();
            return $res;
        }else{
            $this->__rollBack();
            return $res;
        }
    }
}