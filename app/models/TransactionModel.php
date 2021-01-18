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

class TransactionModel extends BaseModel
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

    /**************************************************************** DEBUT TRANSACTIONS PAR PARTENAIRE  ***************************************************/

    /**
     * Lister Transaction Partenaire
     */
    public function getAllListeTransaction($param = null)
    {


        $condition = [];
        $condition['t.numGIE ='] = $this->_USER->gie;
        $condition['t.etat ='] = 1;
        $this->table = "transaction t";
        $this->champs = ["t.id","t.date",'concat(e.nom," ",e.prenom)',"b.matricule as bus","k.num_ticket as ticket","t.montant","t.etat"];
        $this->jointure = ["
                        LEFT JOIN utilisateur as e ON t.receveur = e.id 
                        LEFT JOIN bus as b ON t.bus = b.id
                        LEFT JOIN ticket as k ON t.ticket = k.id 
                        LEFT JOIN gie as g ON t.numGIE = g.id 
                         "];
        if($param[0]!= 0 ){
            $condition['DATE(t.date) >='] = $param[0];
        }

        if($param[1]!= 0 ){
            $condition['DATE(t.date) <='] = $param[1];
        }
        if($param[2]!= 0 ){
            $condition['t.bus ='] = $param[2];
        }

        $this->condition = ['e.type =' => 3];

        $this->condition = $condition ;
       //var_dump($this->condition);die;



        return $this->__processing();
    }
    /*
     * Get Transaction Partenaire
     */

 public function getBus($param = null)
    {
        $this->table = "bus";
        $this->__addParam($param);

        return $this->__select();
    }


    /**
     * Get un Partenaire
     */
    public function getUnTransaction($param = null)
    {
        $this->table = "bus";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Détail Transaction Partenaire
     */
    public function getOneTransaction($param = null)
    {
        $this->table = "transaction t";
        $this->champs = ["t.id","t.date",'concat(e.nom," ",e.prenom) as nomprenom',"b.matricule as bus","k.num_ticket as numticket","k.date_ticket as dateticket","t.etat"];
        $this->jointure = ["
                        INNER JOIN utilisateur as e ON t.receveur = e.id
                        INNER JOIN bus as b ON t.bus = b.id
                        INNER JOIN ticket as k ON t.ticket = k.id 
                     
                      
                         "];
        $this->condition = ['t.numGIE =' => $param->gie];

        $this->__addParam($param);


        return $this->__detail();
    }

    /**
     * Impression Transaction Partenaire
     */
    public function getListeTransaction($param)
    {
        $this->table = "transaction t";
        $this->champs = ["t.id","t.date",'concat(e.nom," ",e.prenom) as nomprenom',"b.matricule as bus","k.num_ticket as numticket","k.date_ticket as dateticket","t.montant","t.etat"];
        $this->jointure = ["
                        INNER JOIN employe as e ON t.receveur = e.id
                        INNER JOIN bus as b ON t.bus = b.id
                        INNER JOIN ticket as k ON t.ticket = k.id 
                     
                      
                         "];
        //$this->condition = ["t.bus ="=>$param];
        $this->condition = ['t.numGIE =' => $param->gie];
        return $this->__select();
    }

    /**************************************************************** FIN TRANSACTIONS PAR PARTENAIRE  ***************************************************/



    /**************************************************************** DEBUT TRANSACTIONS PAR jour  ***************************************************/

    /**
     * Lister Transaction par Service
     */
   public function getAllTransactionsJournalieres($param = null)
    {
        $condition = [];
        $condition['t.numGIE ='] = $this->_USER->gie;
        $condition['t.etat ='] = 1;
        $this->table = "transaction t";
        $this->champs = ["DATE_FORMAT(t.date, '%Y-%m-%d') as id","DATE(t.date) as datess","count(DISTINCT t.bus) as nbr_bus","count(t.id) as nbreTransaction","sum(t.montant) as montant"];
        $this->jointure = ["
                        
                        INNER JOIN gie as g ON t.numGIE = g.id 
                         "];
        $this->group = ["DATE(t.date)"];


        if($param[0]!= 0 ){
            $condition['DATE(t.date) >='] = $param[0];
        }

        if($param[1]!= 0 ){
            $condition['DATE(t.date) <='] = $param[1];
        }
        if($param[2]!= 0 ){
            $condition['t.bus ='] = $param[2];
        }


        $this->condition = $condition ;
/*
        if($param[1]!=0 && $param[2]!=0){
            $this->condition=["DATE(t.date) >="=>$param[1], "DATE(t.date) <="=>$param[2]];
        }*/
        /*else
            if($param[1]!=0 && $param[2]!=0)
                $this->condition=["t.etat="=>1, "DATE(t.date) >="=>$param[1], "DATE(t.date) <="=>$param[2]];*/
       /* if($param[0]!=0)
            $this->condition = array_merge($this->condition,["t.bus="=>$param[0]]);*/

        return $this->__processing();
    }

    public function getAllDetailTransactionsJournalieres($param = null)
    {
        //$condition = [];
       // $condition['t.numGIE ='] = $this->_USER->gie;
        $this->table = "transaction t";
        $this->champs = ['concat(t.bus,"_",DATE(t.date)) as id',"b.matricule as bus","count(t.id) as nbreTransaction","sum(t.montant) as mon_total"];
        $this->jointure = [" 
                       INNER JOIN bus as b ON t.bus = b.id
                       INNER JOIN gie as g ON t.numGIE = g.id
        "];
        $this->group = ["t.bus"] ;

        $this->condition = ['t.numGIE =' => $this->_USER->gie,
            "DATE_FORMAT(t.date, '%Y-%m-%d') ="=>$param[0]];
        //$this->condition = $condition ;
        return $this->__processing();
    }

    public function getAllDetailJournalieres($param = null)
    {
        //$condition = [];
       // $condition['t.numGIE ='] = $this->_USER->gie;
        $this->table = "transaction t";
        $this->champs = ["t.id","b.matricule as bus",'concat(r.nom," ",r.prenom) as nomprenom',
                        "k.num_ticket as numticket","t.montant"];
        $this->jointure =[" 
                       INNER JOIN bus as b ON t.bus = b.id
                       INNER JOIN utilisateur as r ON t.receveur = r.id
                       INNER JOIN ticket as k ON t.ticket = k.id 
        "];
        $this->condition = ['t.numGIE =' =>$this->_USER->gie,
        "DATE(t.date) ="=>$param[1],"b.id ="=>$param[0]];
       // $this->condition = $condition ;


        return $this->__processing();
    }
    /**
     * Impression Transaction pour un Service donné
     */
  public function getTransactionsJournalieres($param)
    {//var_dump($bus);die;
        $this->table = "transaction  t";
        $this->champs = ["t.id","DATE(t.date) as date","count(DISTINCT t.bus) as nbr_bus","count(t.id) as nbreTransaction","sum(t.montant) as mon_total"];
        $this->jointure = [" 
                        LEFT JOIN bus as b ON t.bus = b.id
        "];
        $this->condition = ['t.numGIE =' => $param->gie];
        $this->group = ["DATE(t.date)"];
        //s->condition = ["t.bus ="=>$param];
        return $this->__select();
    }
    public function getDetailTransactionsJournalieres($param)
    {//var_dump($bus);die;
        $this->table = "transaction  t";
        $this->champs = ["t.id","DATE(t.date) as date","b.matricule as buss","count(t.id) as nbreTransaction","sum(t.montant) as mon_total"];
        $this->jointure = [" 
                       INNER JOIN bus as b ON t.bus = b.id
        "];
        $this->condition = ['t.numGIE =' => $param->gie];
        //$this->condition = ["t.date >="=>$datedeb,"t.date <="=>$datefin];
         //$this->group = ["DATE(t.date)"];
        //$this->condition = ["t.id ="=>$param];
        return $this->__select();
    }
    /**************************************************************** FIN TRANSACTIONS PAR SERVICE  ***************************************************/



    /**************************************************************** DEBUT COMMISSIONS PAR PARTENAIRE  ***************************************************/

    public function getComParPart($datedeb,$datefin,$fk_partenaire)
    {
        $this->table = "sva_transaction as t";
        $this->champs = ["sum(t.commission) as com_total", "fk_service", "s.label", "t.date_transaction"];
        $this->jointure = [" 
        INNER JOIN sva_service_sunusva as s ON t.fk_service = s.rowid
        "];
        $this->condition = ["t.date_transaction >="=>$datedeb,"t.date_transaction <="=>$datefin];
        $this->group = [$fk_partenaire];
        return $this->__select();
    }

    /**************************************************************** FIN COMMISSIONS PAR PARTENAIRE  ***************************************************/


}