<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class AgentModel extends BaseModel
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

    public function updatePassAgent($param)
    {
        $this->table = "agent_distributeur";
        $this->__addParam($param);
        return $this->__update();
    }


    public function insertAgent($param)
    {
        $this->table = "agent_distributeur";
        $this->__addParam($param);
        return $this->__insert();
    }
    public function getOneDistributeur($param = null)
    {
        $this->table = "distributeur a";
        $this->champs = ["a.*"];
       /* $this->jointure = [
            "INNER JOIN distributeur as d ON a.fk_distributeur = d.id"
        ];*/
        /*$this->champs = ["a.id","a.prenom_agent","a.nom_agent","a.gie","a.fk_distributeur", "c.date_creation as dateTransaction"];
        $this->jointure = [
            "INNER JOIN carte as c ON a.id = c.user_creation"
        ];*/
        $this->__addParam($param);
        return $this->__detail();
    }
    public function getOneAgent($param = null)
    {
        $this->table = "agent_distributeur a";
        $this->champs = ["a.*"];
       /* $this->jointure = [
            "INNER JOIN distributeur as d ON a.fk_distributeur = d.id"
        ];*/
        /*$this->champs = ["a.id","a.prenom_agent","a.nom_agent","a.gie","a.fk_distributeur", "c.date_creation as dateTransaction"];
        $this->jointure = [
            "INNER JOIN carte as c ON a.id = c.user_creation"
        ];*/
        $this->__addParam($param);
        return $this->__detail();
    }

    public function getIdAgent($login)
    {
        $this->table = "agent_distributeur a";
        $this->champs = ["a.id as idAgent"];
        $this->condition=[ "a.login ="=>$login,"a.etat ="=> 1];
        return $this->__detail()->idAgent;
    }

    public function getAllAgent()
    {
        $this->table = "distributeur as a";
        $this->champs = ["a.id as id","a.nom_point", "a.id as nbreTransaction", "a.id as montantTotal"];
        $this->jointure = [
           /* "LEFT JOIN carte as c ON c.fk_distributeur = a.fk_distributeur",
            "LEFT JOIN histo_rechargement as h ON a.fk_distributeur = h.fk_distributeur"*/

        ];
      // $this->condition = [ 'a.id='=>$this->_USER->gie];
        return $this->__processing();
    }
    public function getAListAgent()
    {
        $this->table = "agent_distributeur as a";
        $this->champs = ["a.id as id","a.prenom_agent", "a.nom_agent", "a.email_agent", "a.telephone_agent", "a.adresse_agent", "a.etat"];
        return $this->__processing();
    }

    public function updateAgent($param)
    {
        $this->table = "agent_distributeur";
        $this->__addParam($param);
        return $this->__update();
    }

    /**
     * VERSEMENT
     *
     */
    //CARTES

    public function getDateCollect($id){
        $this->table = "carte";
        $this->champs = ['date_creation as date_creation'];
        $this->condition = ["statut ="=>1,"verse ="=>0,"user_creation = " =>$id];
        //$this->group = ['date_creation'];
        // $this->condition=["u.code_entite ="=>$entite[0]];
        return $this->__select();
    }

    public function getCollectByAgent($fk_distributeur){

        $this->table = "carte c";
        $this->champs =['c.id', 'c.fk_distributeur as agentId', 'c.date_creation as date_creation','SUM(c.part_nta) as montant','c.fk_distributeur as fk_distributeur'];
        /*$this->jointure =["
            INNER JOIN utilisateur c on c.id = t.receveur
        "];*/
        $this->condition=["c.statut = "=>1,"c.verse = "=>0,"c.fk_distributeur = " =>$fk_distributeur];
        $this->group=['c.date_creation'];
        // $this->condition=["u.code_entite ="=>$entite[0]];
        return $this->__select();
    }
    public function getCollectByIdAgent($fk_distributeur,$date){
        $this->table = "carte";
        $this->champs =['id', 'date_creation','SUM(part_nta) as montant','COUNT(fk_distributeur) as nbreEnroelement'];
        $this->condition=["statut ="=>1,"verse ="=>0,"fk_distributeur = " =>$fk_distributeur,'date_creation=' =>$date];

        return $this->__select();

    }
    public function insertVirementCarte($data){

        $this->table = "detail_virementCarte";
        $this->champs =  $data;
        $insert = $this->__insert() ;
        return $insert ;
    }
    public function updateTransaction($fk_distributeur){
        $data['verse'] = 1 ;
        $this->table = "carte";
        $this->champs = $data;
        $this->condition=["fk_distributeur ="=>$fk_distributeur];
        $update=  $this->__update();
        return $update ;
    }

    public function getVirementCarteById($id)
    {
        $this->table = "detail_virementCarte v";
        $this->champs =["v.id","DATE(v.date_creation) as date_versement","v.montant_verse as montant", "nom_point as nom" ];
        $this->jointure =["
            LEFT JOIN distributeur a on a.id = v.fk_distributeur
        "];
        //$this->condition =["id ="=> $id];
        return $this->__detail();
    }
    public function detailsVersements($param)
    {
        $id = $param[0];
        //echo $id;
        $this->table = "detail_virementCarte v";
        $this->champs =["v.id","DATE(v.date_creation) as date_versement","v.montant_verse as montant", "nom_point as nom" ];
        $this->jointure =["
            LEFT JOIN distributeur a on a.id = v.fk_distributeur
        "];
        $this->condition=["v.id ="=>$id];

        return $this->__select();
    }

    //RECHARGEMENT
    public function getDateCollectRechargement($fk_distributeur){
        $this->table = "histo_rechargement";
        $this->champs = ['date_transac as date_transac'];
        $this->condition = ["etat ="=>1,"verse ="=>0,"fk_distributeur = " =>$fk_distributeur];
        //$this->group = ['DATE(date_transac)'];
        // $this->condition=["u.code_entite ="=>$entite[0]];
        return $this->__select();
    }
    public function getCollectByAgentRechargement($fk_distributeur){

        $this->table = "histo_rechargement h";
        $this->champs =['h.user_id as agentId', 'h.date_transac as date_transac','SUM(h.part_nta) as montant', 'h.fk_distributeur'];
        $this->condition=["h.etat = "=>1,"h.verse = "=>0,"h.fk_distributeur = " =>$fk_distributeur];
        $this->group=['h.date_transac'];
        return $this->__select();
    }
    public function getCollectByIdAgentRechargement($fk_distributeur,$date){
        $this->table = "histo_rechargement";
        $this->champs =['id', 'date_transac','SUM(part_nta) as montant','COUNT(fk_distributeur) as nbreRechargement'];
        $this->condition=["etat ="=>1,"verse ="=>0,"fk_distributeur = " =>$fk_distributeur,'date_transac =' =>$date];
        return $this->__select();

    }
    public function insertVirementRechargement($data){
        $this->table = "detail_virementRechargement";
        $this->champs =  $data;
        $insert = $this->__insert() ;
        return $insert ;
    }
    public function updateTransactionRechargement($fk_distributeur){
        $data['verse'] = 1 ;
        $this->table = "histo_rechargement";
        $this->champs = $data;
        $this->condition=["fk_distributeur ="=>$fk_distributeur];
        $update=  $this->__update();
        return $update ;
    }
    public function getVirementRechargementId($id)
    {
        $this->table = "detail_virementRechargement v";
        $this->champs =["v.id","DATE(v.date_creation) as date_versement","v.montant_verse as montant", "nom_point as nom" ];
        $this->jointure =["
            LEFT JOIN distributeur a on a.id = v.fk_distributeur
        "];
        //$this->condition =["id ="=> $id];
        return $this->__detail();
    }
    public function detailsVersementsRechargement($param)
    {
        $id = $param[0];
        //echo $id;
        $this->table = "detail_virementRechargement v";
        $this->champs =["v.id","DATE(v.date_creation) as date_versement","v.montant_verse as montant", "nom_point as nom" ];
        $this->jointure =["
            LEFT JOIN distributeur a on a.id = v.fk_distributeur
        "];
        $this->condition=["v.id ="=>$id];
        return $this->__select();
    }




}