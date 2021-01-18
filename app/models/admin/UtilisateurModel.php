<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models\admin;

use app\core\BaseModel;

class UtilisateurModel extends BaseModel
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
     * Ajout utilisateur
     */
    public function insertUtilisateur($param)
    {

        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Vérifier si email existe déjà
     */
    public function verifEmailModel($email)
    {
        $this->table = "utilisateur";
        $this->champs = ["id"];
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
        $this->table = "utilisateur";
        $this->champs = ["id"];
        $this->condition=["login ="=>$login];
        $count = count($this->__select());
        if($count > 0) return 1;
        else return -1;
    }
    /**
     * Lister Utilisateur
     */
    public function getAllUtilisateur($param = null)
    {
        $this->table = "utilisateur";
        $this->champs = ["id","prenom","nom","telephone","login","etat"];
        return $this->__processing();
    }

    public function getUtilisateur($param = null)
    {
        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getOneUtilisateur($param = null)
    {
        $this->table = "utilisateur as u";
        $this->champs = ["u.id", "u.prenom", "u.nom", "u.email", "u.login", "p.profil", "u.telephone", "u.photo", "u.admin", "u.etat"];
        $this->jointure = ["INNER JOIN profil as p ON u.fk_profil = p.id"];
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Utilisateur
     */
    public function updateUtilisateur($param)
    {
        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Utilisateur
     */
    public function deleteUtilisateur($param)
    {
        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__delete();
    }
    /***********Update photo ad_utilisateurs*************/
    public function updatePhoto($param){

        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__update();

    }



    /*******************FALL ADD*******************/
    /**********Verifier Ancien Password**********/
    public function verifAncienPass($param = null)
    {
        $this->table = "utilisateur u";
        $this->__addParam($param);
        $count = count($this->__select());
        if($count > 0) return 1;
        else return -1;
    }

    /**
     * Modification Mot de Passe Utilisateur
     */
    public function updatePassUser($param)
    {
        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__update();
    }

    public function updateUserDetail($param)
    {
        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__update();
    }
}