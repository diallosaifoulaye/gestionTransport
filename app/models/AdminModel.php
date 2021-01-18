<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

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
    public function nbreBus()
    {
        $this->table = "bus b";
        $this->champs = ["COUNT(b.id) AS nbre"];
        $this->condition =["b.numGIE = " => $this->_USER->gie];
        //$this->group = ["b.numGIE"];

        return $this->__detail()->nbre;

    }

    public function nbreChauffeur()
    {
        $this->table = "employe e";
        $this->champs = ["COUNT(e.id) AS nbreChauffeur"];
        $this->condition =["e.numGIE = " => $this->_USER->gie];
        //$this->group = ["b.numGIE"];

        return $this->__detail()->nbreChauffeur;

    }

    public function nbreReceveur()
    {
        $this->table = "receveur r";
        $this->champs = ["COUNT(r.id) AS nbreReceveur"];
        $this->condition =["r.numGIE = " => $this->_USER->gie];
        //$this->group = ["b.numGIE"];

        return $this->__detail()->nbreReceveur;

    }

    public function nbreControleur()
    {
        $this->table = "controleur c";
        $this->champs = ["COUNT(c.id) AS nbreControleur"];
        $this->condition =["c.numGIE = " => $this->_USER->gie];
        //$this->group = ["b.numGIE"];

        return $this->__detail()->nbreControleur;

    } public function transactionByDay()
    {
        $this->table = "controleur c";
        $this->champs = ["COUNT(c.id) AS nbreControleur"];
        $this->condition =["c.numGIE = " => $this->_USER->gie];
        //$this->group = ["b.numGIE"];

        return $this->__detail()->nbreControleur;

    }
    public function getAllTransactionsJournalieres()
    {
        //$condition = [];
        $date = date('Y-m-d');
        $this->table = "transaction t";
        $this->champs = ["sum(t.montant) as montant"];

        //$condition['t.numGIE ='] = $this->_USER->gie;
        $this->condition =["t.date = " => $date ,
            't.numGIE =' => $this->_USER->gie
        ];
//        $this->jointure = ["
//
//                        INNER JOIN gie as g ON t.numGIE = g.id
//                         "];
        //$this->group = ["CURRENT_DATE"];
        return $this->__detail()->montant;

    }

    ////MOT DE PASSE OUBLIE

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


    /// END


}