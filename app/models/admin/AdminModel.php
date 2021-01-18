<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models\admin;

use app\core\BaseModel;

class AdminModel extends BaseModel
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

    public function getUtilisateur($param = null)
    {
        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getOneUtilisateur($param = null)
    {
        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__detail();
    }

  
    public function nbreGie()
    {
        $this->table = "gie g";
        $this->champs = ["COUNT(g.id) AS nbre"];
        //$this->condition =["g.numGIE = " => $this->_USER->gie];
        //$this->group = ["b.numGIE"];

        return $this->__detail()->nbre;

    }

    public function nbreBus()
    {
        $this->table = "bus b";
        $this->champs = ["COUNT(b.id) AS nbre"];
        //$this->condition =["b.numGIE = " => $this->_USER->gie];
        //$this->group = ["b.numGIE"];

        return $this->__detail()->nbre;
    }
    public function getEmail($email)
    {

        $this->table = "utilisateur";
        $this->champs = ["id","prenom","nom","email as mail"];
        $this->condition = ["email = " => $email];
        return $this->__select()[0];
    }

    public function insertCodeGenere($email,$codeGenere)
    {
        $this->table = "utilisateur";
        $this->champs = ["code_genere=" => $codeGenere];
        $this->condition = ["email = " => $email];
        return $this->__update();
    }

    public function confirmationCode($confirmationCode)
    {
        $this->table = "utilisateur";
        $this->condition = ["code_genere = " => $confirmationCode];
        return $this->__select();

    }

    public function updatePassword($code_genere, $passwordUpdate )
    {
        $this->table = "utilisateur";
        $this->champs = ["password=" => $passwordUpdate];
        $this->condition = ["code_genere = " => $code_genere];
        return $this->__update();
    }
    public function updateReinitialisationPassword($idUser, $passwordUpdate)
    {
        $this->table = "utilisateur";
        $this->champs = ["password=" => $passwordUpdate];
        $this->condition = ["id = " => $idUser];
        return $this->__update();
    }



}