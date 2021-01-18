<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class HomeModel extends BaseModel
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
        $this->condition =['DATE(t.date) = ' => $date ,
            't.numGIE =' => $this->_USER->gie
        ];
        $this->jointure = ["                                      
                                                                
                      INNER JOIN gie as g ON t.numGIE = g.id    
                       "];
        //$this->group = ["CURRENT_DATE"];
        return $this->__detail()->montant;

    }

    public function nbreTransactionJour()
    {
        //$condition = [];
        $date = date('Y-m-d');
        $this->table = "transaction t";
        $this->champs = ["count(t.id) as id"];

        //$condition['t.numGIE ='] = $this->_USER->gie;
        $this->condition =["DATE(t.date) = " => $date ,
            't.numGIE =' => $this->_USER->gie
        ];
        $this->jointure = ["                                                                                         
                      INNER JOIN gie as g ON t.numGIE = g.id    
                       "];
        //$this->group = ["CURRENT_DATE"];
        return $this->__detail()->id;

    }

}