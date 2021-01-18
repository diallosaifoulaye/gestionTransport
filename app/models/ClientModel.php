<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;
use app\core\Utils;

class ClientModel extends BaseModel
{
    private $gie;

    /**
     * HomeModel constructor.
     */
    public function __construct()
    {

        parent::__construct();
        $this->gie = $this->_USER->gie ;
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
        $this->table = "client";
        $this->__addParam($param);
        return $this->__insert();
    }


    public function insertClient($param)
    {
        $this->table = "client";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function verifEmailModel($email)
    {
        $this->table = "client";
        $this->champs = ["id"];
        $this->condition=["email ="=>$email];
        $count = count($this->__select());
        if($count > 0) return 1;
        else return -1;
    }

    /**
     * Processing Chauffeur
     */
    public function getAllClient($param = null)
    {
        $this->table = "client c";
        $this->champs = ["c.id","c.prenom","c.nom","c.email","c.telephone","ca.numero_serie", "ca.solde"];
        $this->jointure = ["INNER JOIN carte ca on ca.client = c.id"];
        $this->condition = ["c.gie = "=>$this->gie];


        return $this->__processing();
    }


    public function getAllCompteBloked($param = null)
    {
        $this->table = "client c";
        $this->champs = ["c.id","c.prenom","c.nom","c.email","c.telephone","ca.numero_serie", "ca.solde","ca.statut"];
        $this->jointure = ["LEFT JOIN carte ca on ca.client = c.id"];
        $this->condition = ["c.gie = "=>$this->gie];


        return $this->__processing();
    }


    public function activationBlocage($param = null)
    {
        $this->table = "carte_commentaires c";
        $this->champs = ["c.rowid","c.date_creation","c.type","c.commentaire"];
        $this->condition = ["c.fk_carte = "=> $param[0]];
        return $this->__processing();
    }

    public function getAllRechargementClient($param = null)
    {

        $this->table = "histo_rechargement r";
        $this->champs = ["r.id","r.date_transac","r.num_transac","r.montant","r.solde_avant","r.solde_apres", 'concat(u.nom," ",u.prenom) as receveur'];
        $this->jointure = ["LEFT JOIN utilisateur u on u.id = r.user_id"];
       $this->condition = ["r.carte_id = "=> $param[0]];


        return $this->__processing();
    }

    public function Generer_numtransaction()
    {
        $found = 0;
        do {
            $code = rand(1, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(1, 9);
            $etat =  $this->verifyTransaction($code);
            if ($etat == 1) {
                $found = 1;
            }
        } while ($found == 0);
        return $code;
    }

    public function verifyTransaction($code)
    {

        $this->table = "histo_rechargement";
        $this->champs =['id'];
        $this->condition=["num_transac  ="=>$code, "etat ="=>1];
        $a = count($this->__select());
        if ($a > 0) {
            return 0;
        } else {
            return 1;
        }
    }

    public function soldeClient($idClient){
        $this->table = "carte c";
        $this->champs =['c.solde'];
        $this->condition=["client  ="=>$idClient];
        return $this->__select();

    }

    public function getLineCard($numSerie){
        $this->table = "carte c";
        $this->champs =['c.id','c.numero_serie','c.client','c.statut','c.solde'];
        $this->condition=["numero_serie  ="=>$numSerie, "statut ="=>0];
        return $this->__select();
    }
    public function getCardBloque($numSerie){
        $this->table = "carte c";
        $this->champs =['c.id','c.numero_serie','c.client','c.statut','c.solde'];
        $this->condition=["numero_serie  ="=>$numSerie, "statut ="=>2];
        return $this->__select();
    }
    public function getCardActive($numSerie){
        $this->table = "carte c";
        $this->champs =['c.id','c.numero_serie','c.client','c.statut','c.solde'];
        $this->condition=["numero_serie  ="=>$numSerie, "statut ="=>1];
        return $this->__select();
    }

    public function clientAEnrole($idClient){
        $this->table = "carte c";
        $this->champs =['c.id', "statut=" => 1];
        $this->champs = ["statut=" => 2];
        $this->condition=["client  ="=> $idClient];
        return $this->__update();
    }

    public function reenrolement($numeroSerie, $client, $solde){
        $this->table = "carte";
        $this->champs = ["client=" => $client, "statut=" => 1, "user_creation" => $this->_USER->id, "date_creation" => Utils::getDateNow(), "solde=" => $solde];
        $this->condition = ["numero_serie = " => $numeroSerie];
        return $this->__update();
    }

    public function nbreClient(){
        $this->table = "client c";
        $this->champs =["COUNT('c.id') as nbre"];
        return $this->__detail()->nbre;
    }
    public function nbreClientActif(){
        $this->table = "client c";
        $this->champs =["COUNT('c.id') as nbre"];
        $this->condition=["etat  ="=> 1];
        return $this->__detail()->nbre;
    }
    public function nbreClientDesactive(){
        $this->table = "client c";
        $this->champs =["COUNT('c.id') as nbre"];
        $this->condition=["etat  ="=> 0];
        return $this->__detail()->nbre;
    }

    public function caJournalierCarte(){
        $date = date('Y-m-d');
        $this->table = "histo_rechargement";
        $this->champs =["sum(montant) as mnt"];
        $this->condition=["DATE(date_transac)  ="=> $date ];

        return $this->__detail()->mnt;
    }

    public function caMensuelCarte(){
        $dateY = date('Y');
        $dateM = date('m');
        $this->table = "histo_rechargement";
        $this->champs =["sum(montant) as mnt"];
        $this->condition=["YEAR(date_transac)  ="=> $dateY  ,"MONTH(date_transac)  ="=> $dateM];
        return $this->__detail()->mnt;
    }
    public function caAnnuelCarte(){
        $date = date('Y-m-d');
        $this->table = "histo_rechargement";
        $this->champs =["sum(montant) as mnt"];
        $this->condition=["YEAR(date_transac)  ="=> $date];
        return $this->__detail()->mnt;
    }

    public function caJournalierTicket(){
        $date = date('Y-m-d');
        $this->table = "transaction";
        $this->champs =["sum(montant) as mnt"];
        $this->condition=["DATE(date)  ="=> $date ];

        return $this->__detail()->mnt;
    }
    public function caMensuelTicket(){
        $dateY = date('Y');
        $dateM = date('m');
        $this->table = "transaction";
        $this->champs =["sum(montant) as mnt"];
        $this->condition=["YEAR(date)  ="=> $dateY  ,"MONTH(date)  ="=> $dateM];

        return $this->__detail()->mnt;
    }
    public function caAnnuelTicket(){
        $date = date('Y-m-d');
        $this->table = "transaction";
        $this->champs =["sum(montant) as mnt"];
        $this->condition=["YEAR(date)  ="=> $date ];
        return $this->__detail()->mnt;
    }

    public function carteDisponible(){
        $this->table = "carte";
        $this->champs =["COUNT(statut) as etat"];
        $this->condition=["statut  ="=> 0 ];
        return $this->__detail()->etat;
    }
    public function carteActive(){
        $this->table = "carte";
        $this->champs =["COUNT(statut) as etat"];
        $this->condition=["statut  ="=> 1 ];
        return $this->__detail()->etat;
    }
    public function carteBloquee(){
        $this->table = "carte";
        $this->champs =["COUNT(statut) as etat"];
        $this->condition=["statut  ="=> 2 ];
        return $this->__detail()->etat;
    }

    public function verifExisteCarte($numSerie){

        $this->table = "carte c";
        $this->champs =["c.numero_serie as numSerie"];
      //  $this->condition=["c.numero_serie = " => $numSerie, " =" =>];
        return $this->__detail()->numSerie;
    }


}