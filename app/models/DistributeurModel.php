<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class DistributeurModel extends BaseModel
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
     * GESTION LOGIN
     */


    /**********Verifier Ancien Password**********/
    public function verifAncienPass($param = null)
    {
        $this->table = "distributeur d";
        $this->__addParam($param);
        $count = count($this->__select());
        if($count > 0) return 1;
        else return -1;
    }

    /**
     * Modification Mot de Passe Utilisateur
     */
    public function updatePassDistributeur($param)
    {
        $this->table = "distributeur";
        $this->__addParam($param);
        return $this->__update();
    }
    public function updatePassAgent($param)
    {
        $this->table = "agent_distributeur";
        $this->__addParam($param);
        return $this->__update();
    }



    /**
     * FIN GESTION LOGIN
     */
    public function getAllDistributeur()
    {
        $this->table = "distributeur as d";
        $this->champs = ["d.id","d.nom_point","d.nom_agent","d.prenom_agent","d.adresse_agent","d.email_agent","d.etat"];
        return $this->__processing();
    }
    public function allDistributeur(){
        $this->table = "distributeur as d";
        $this->champs = ["d.*"];
        return $this->__select();

    }

    public function getDepartementByRegion($idRegion)
    {

        $this->table = "departement";
        $this->champs = ['*'];
        $this->condition = ["fk_region="=>$idRegion];
        return $this->__select();

    }


    public function verifEmailModel($email)
    {
        $this->table = "distributeur";
        $this->champs = ["id"];
        $this->condition=["email_agent ="=>$email];
        $count = count($this->__select());
        if($count > 0) return 1;
        else return -1;
    }
    public function verifLoginModel($login)
    {
        $this->table = "distributeur";
        $this->champs = ["id"];
        $this->condition=["login ="=>$login];
        $count = count($this->__select());
        if($count > 0) return 1;
        else return -1;
    }
    public function insertDistributeur($param)
    {
        $this->table = "distributeur";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function updateDistributeur($param)
    {
        $this->table = "distributeur";
        $this->__addParam($param);
        return $this->__update();
    }

    public function getOneDistributeur($param = null)
    {
        $this->table = "distributeur d";
        $this->champs = ["d.*"];
        $this->__addParam($param);
        return $this->__detail();
    }
    public function getAllCardByDistributeurMonthEnCours($param = null)
    {
        $anneCours = date('m');
        $this->table = "carte c";
        $this->champs = ["c.id","cl.nom","cl.prenom","c.numero_serie","c.date_creation","c.solde","c.statut"];
        $this->jointure = [
            "INNER JOIN client as cl ON c.client = cl.id"
        ];
        $cond = [] ;
        if($param[0]!= ''){

                $cond=["MONTH(c.date_creation) ="=> $anneCours,"fk_distributeur ="=>$param[0]];
       }
        if( $param[1]!= ''){
            $cond=["fk_distributeur ="=>$param[0], "c.date_creation >="=> $param[1]];
        }
        if( $param[2]!= ''){
            $cond=["fk_distributeur ="=>$param[0], "c.date_creation <="=> $param[2]];
        }
        $this->condition = $cond ;
        // $this->condition=["MONTH(c.date_creation) ="=> $anneCours,"fk_distributeur ="=>$param[0]];
        return $this->__processing();
        }

    public function nbreCarteVendueByDistributeurMonth($distributeur)
    {
        $anneCours = date('m');
        $this->table = "carte c";
        $this->champs = ["count(c.id) as nbreCarte"];
        /*$this->jointure = [
            "INNER JOIN client as cl ON c.client = cl.id"
        ];*/
        $this->condition=["MONTH(c.date_creation) ="=> $anneCours, "fk_distributeur ="=> $distributeur, "statut ="=> 1 ];
        return $this->__detail()->nbreCarte;
    }

    public function montantSoldeCarteVenduByDistributeurMonth($distributeur)
    {
        $anneCours = date('m');
        $this->table = "carte c";
        $this->champs = ["sum(c.solde) as sumSolde"];
        /*$this->jointure = [
            "INNER JOIN client as cl ON c.client = cl.id"
        ];*/
        $this->condition=["MONTH(c.date_creation) ="=> $anneCours, "fk_distributeur ="=> $distributeur, "statut ="=> 1 ];
        return $this->__detail()->sumSolde;
    }

    public function montantVerseByDistributeurMonth($distributeur)
    {
        $anneCours = date('m');
        $this->table = "carte c";
        $this->champs = ["sum(c.solde) as sumSolde"];
        $this->condition=["MONTH(c.date_creation) ="=> $anneCours, "fk_distributeur ="=> $distributeur, "statut ="=> 1, "verse ="=> 1 ];
        return $this->__detail()->sumSolde;
    }
    public function montantNonVerseByDistributeurMonth($distributeur)
    {
        $anneCours = date('m');
        $this->table = "carte c";
        $this->champs = ["sum(c.solde) as sumSolde"];

        $this->condition=["MONTH(c.date_creation) ="=> $anneCours, "fk_distributeur ="=> $distributeur, "statut ="=> 1, "verse ="=> 0 ];
        return $this->__detail()->sumSolde;
    }

    public function getAllRechargeByDistributeurMonthEnCours($param = null)
    {
        $anneCours = date('m');
        $this->table = "histo_rechargement h";
        $this->champs = ["h.id","h.num_transac","h.date_transac","cl.prenom","cl.nom","h.montant","h.etat"];
        $this->jointure = [
            "INNER JOIN  carte as c ON h.carte_id = c.id",
            "INNER JOIN  client as cl ON c.client = cl.id"
        ];
       $this->condition=["MONTH(h.date_transac) ="=> $anneCours,"h.fk_distributeur ="=>$param[0]];
        return $this->__processing();
    }

    public function nbreRechargeVendueByDistributeurMonth($distributeur)
    {
        $anneCours = date('m');
        $this->table = "histo_rechargement h";
        $this->champs = ["count(h.id) as nbreRecharge"];
        $this->condition=["MONTH(h.date_transac) ="=> $anneCours,"h.fk_distributeur ="=>$distributeur, "h.etat ="=> 1];
        return $this->__detail()->nbreRecharge;
    }

    public function montantSoldeRechargeVenduByDistributeurMonth($distributeur)
    {
        $anneCours = date('m');
        $this->table = "histo_rechargement h";
        $this->champs = ["sum(h.montant) as sumMontant"];
        $this->condition=["MONTH(h.date_transac) ="=> $anneCours,"h.fk_distributeur ="=>$distributeur, "h.etat ="=> 1];
        return $this->__detail()->sumMontant;
    }

    public function montantVerseRechargeByDistributeurMonth($distributeur)
    {
        $anneCours = date('m');
        $this->table = "histo_rechargement h";
        $this->champs = ["sum(h.montant) as sumMontant"];
        $this->condition=["MONTH(h.date_transac) ="=> $anneCours,"h.fk_distributeur ="=>$distributeur, "h.verse ="=> 1, "h.etat ="=> 1];
        return $this->__detail()->sumMontant;
    }

    public function montantNonVerseRechargeByDistributeurMonth($distributeur)
    {
        $anneCours = date('m');
        $this->table = "histo_rechargement h";
        $this->champs = ["sum(h.montant) as sumMontant"];

        $this->condition=["MONTH(h.date_transac) ="=> $anneCours,"h.fk_distributeur ="=>$distributeur, "h.verse ="=> 0, "h.etat ="=> 1];
        return $this->__detail()->sumMontant;
    }

    public function getAllCommissionCarte()
    {
        $this->table = "commission_carte";
        $this->champs = ["id","montant_carte","commission","etat"];
        return $this->__processing();
    }

    public function insertCommissionCarte($param)
    {
        $this->table = "commission_carte";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function getOneCommissionCarte($param = null)
    {
        $this->table = "commission_carte c";
        $this->champs = ["c.id","c.montant_carte","c.commission"];
        $this->__addParam($param);
        return $this->__detail();
    }

    public function updateCommissionCarte($param)
    {
        $this->table = "commission_carte";
        $this->__addParam($param);
        return $this->__update();
    }

    public function getAllCommissionRechargement()
    {
        $this->table = "commission_rechargement";
        $this->champs = ["id","recharge_min","recharge_max","commission","etat"];
        return $this->__processing();
    }

    public function insertRechargeCommission($param)
    {
        $this->table = "commission_rechargement";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function getOneCommissionRecharge($param = null)
    {
        $this->table = "commission_rechargement c";
        $this->champs = ["c.id","c.recharge_min","c.recharge_max","c.commission" ];
        $this->__addParam($param);
        return $this->__detail();
    }

    public function updateCommissionRecharge($param)
    {
        $this->table = "commission_rechargement";
        $this->__addParam($param);
        return $this->__update();
    }

    public function getIdDistributeur($nom_point, $email, $login)
    {
        $this->table = "distributeur d";
        $this->champs = ["d.id as idDistri"];
        $this->condition=["d.nom_point ="=> $nom_point,"d.email_agent ="=>$email, "d.login ="=> $login, "d.etat ="=> 1];
        return $this->__detail()->idDistri;
    }

    public function getRechargementByClient($param = null)
    {

        $this->table = "histo_rechargement r";
        $this->champs = ["r.id","r.date_transac","r.num_transac","r.montant","r.solde_avant","r.solde_apres", 'concat(a.nom_agent," ",a.prenom_agent) as agent'];
        $this->jointure = ["INNER JOIN agent_distributeur a on a.id = r.user_id"];
        $this->condition = ["r.carte_id = "=> $param[0]];

        return $this->__processing();
    }
    public function getAllRechargementClient($param = null)
    {

        $this->table = "histo_rechargement r";
        $this->champs = ["r.id","r.date_transac","r.num_transac","r.montant","r.solde_avant","r.solde_apres", 'concat(a.nom_agent," ",a.prenom_agent) as agent'];
        $this->jointure = ["INNER JOIN agent_distributeur a on a.id = r.user_id"];

        return $this->__processing();
    }

    public function getAllCompteBloked($param = null)
    {
        $this->table = "client c";
        $this->champs = ["c.id","c.prenom","c.nom","c.email","c.telephone","ca.numero_serie", "ca.solde","ca.statut as statut"];
        $this->jointure = ["LEFT JOIN carte ca on ca.client = c.id"];
        $this->condition = ["c.gie = "=>$this->_USER->gie, "ca.statut ="=>2];
        return $this->__processing();
    }

    public function reportintRechargementProcessing($param)
    {

        $cond["DATE(h.date_transac) >="] = $param[0] ;
        $cond["DATE(h.date_transac) <="] = $param[1] ;
        $cond["h.user_id ="] = $this->_USER->id ;
        $cond["h.fk_distributeur ="] = $this->_USER->fk_distributeur;
        $this->table = "histo_rechargement h";
        $this->champs =["h.id","h.date_transac", "h.num_transac","c.numero_serie", "cl.nom","cl.prenom","h.montant as montant", "h.part_distributeur" ];
        $this->jointure = [
            "INNER JOIN  carte as c ON h.carte_id = c.id",
            "INNER JOIN  client as cl ON c.client = cl.id"
        ];
        $this->condition = $cond ;
        return $this->__processing();
    }
    public function montantRechargementVenduYear($dateDebut='' ,$dateFin = ''){
        if($dateDebut=='' and $dateFin==''){
            $anneeEnCours = date('Y');
            $this->table = "histo_rechargement h";
            $this->champs =["sum(montant) as mnt"];
            $this->condition=["YEAR(h.date_transac)  ="=> $anneeEnCours,"user_id ="=> $this->_USER->id, "h.fk_distributeur =" =>$this->_USER->fk_distributeur];
        }else{
            $cond["DATE(h.date_transac) >="] = $dateDebut ;
            $cond["DATE(h.date_transac) <="] = $dateFin ;
            $this->table = "histo_rechargement h";
            $this->champs =["sum(montant) as mnt"];
            $this->condition = $cond ;

        }
        return $this->__detail()->mnt;
    }
    public function getDataRechargement($dateDebut='' ,$dateFin = ''){

        $cond["DATE(h.date_transac) >="] = $dateDebut ;
        $cond["DATE(h.date_transac) <="] = $dateFin ;
        $cond["h.user_id ="] = $this->_USER->id ;
        $cond["h.fk_distributeur ="] = $this->_USER->fk_distributeur ;
        $this->table = "histo_rechargement h";
        $this->champs =['count(h.id) as nbreTransaction' , 'SUM(h.montant) as montant', "sum(h.part_distributeur) as commissionDistributeur", "sum(h.part_nta) as partNta" ];
        $this->condition = $cond ;
        return $this->__select()[0];
    }
    public function getCommissionRechargement($dateDebut='' ,$dateFin = ''){

        $cond["DATE(h.date_transac) >="] = $dateDebut ;
        $cond["DATE(h.date_transac) <="] = $dateFin ;
        $cond["h.user_id ="] = $this->_USER->id ;
        $cond["h.fk_distributeur ="] = $this->_USER->fk_distributeur;
        $this->table = "histo_rechargement h";
        $this->champs =["h.id","sum(h.part_distributeur) as commissionDistributeur", "sum(h.part_nta) as commissionGie", "h.date_transac"];
        $this->condition = $cond ;
        return $this->__select();

    }

    public function reportintCarteProcessing($param)
    {

        $cond["DATE(c.date_creation) >="] = $param[0] ;
        $cond["DATE(c.date_creation) <="] = $param[1] ;
        $cond["c.user_creation ="] = $this->_USER->id ;
        $cond["c.fk_distributeur ="] = $this->_USER->fk_distributeur;
        $this->table = "carte c";
        $this->champs =["c.id","c.date_creation", "c.numero_serie","cl.nom", "cl.prenom", "c.solde", "c.part_distributeur"];
        $this->jointure = [
            "INNER JOIN  client as cl ON c.client = cl.id"
        ];
        $this->condition = $cond ;
        return $this->__processing();
    }

    public function getCommissionEnrollement($montant){
        $this->table = "commission_carte c";
        $this->champs =["c.commission as commission" ];
        $this->condition = ['c.montant_carte = '=>$montant];
        return $this->__detail()->commission;
    }
    public function insertApresEnrolement($param){
        $this->table = "histo_rechargement";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function getDataCarte($dateDebut='' ,$dateFin = ''){

        $cond["DATE(c.date_creation) >="] = $dateDebut ;
        $cond["DATE(c.date_creation) <="] = $dateFin ;
        $cond["c.user_creation ="] = $this->_USER->id ;
        $cond["c.fk_distributeur ="] = $this->_USER->fk_distributeur ;
        $this->table = "carte c";
        $this->champs =['count(c.id) as nbreEnrolement' , 'SUM(c.montant_enrole) as montantTotal', "sum(c.part_distributeur) as commissionDistributeur", "sum(c.part_nta) as partNta"];
        $this->condition = $cond ;
        return $this->__select()[0];
    }

    /**
     * VERSEMENT
     */

    public function versementProcessing($param)
    {
        $this->table = "agent_distributeur a";
        $this->champs =["a.id","a.prenom_agent", "a.nom_agent","sum()", "cl.prenom", "c.solde", "c.part_distributeur"];
        $this->jointure = [
            "INNER JOIN  client as cl ON c.client = cl.id"
        ];
       // $this->condition = $cond ;
        return $this->__processing();
    }

    /**
     * DISTRIBUTION
     */

    public function insertDistribution($param){
        $this->table = "distribution";
        $this->__addParam($param);
        return $this->__insert();
    }
    public function listeNumeroSerie(){
        $this->table = "carte";
        $this->champs = ["numero_serie"];
        return $this->__select();
    }
    public function getAllDistributionCarte(){
        $this->table = "distribution d";
        $this->champs = ["d.id","a.nom_point","d.nbre_carte","d.debut_numeroSerie","d.fin_numeroSerie"];
        $this->jointure = [
            "INNER JOIN  distributeur as a ON a.id = d.distribution"
        ];
        return $this->__processing();
    }

    /**
     * MOT DE PASSE OUBLIE
     *
     */


    public function getEmail($email)
    {

        $this->table = "agent_distributeur";
        $this->champs = ["id","prenom_agent","nom_agent","email_agent as mail"];
        $this->condition = ["email_agent = " => $email];
        return $this->__select()[0];
    }

    public function insertCodeGenere($email,$codeGenere)
    {
        $this->table = "agent_distributeur";
        $this->champs = ["code_genere=" => $codeGenere];
        $this->condition = ["email_agent = " => $email];
        return $this->__update();
    }

    public function confirmationCode($confirmationCode)
    {
        $this->table = "agent_distributeur";
        $this->condition = ["code_genere = " => $confirmationCode];
        return $this->__select();

    }

    public function updatePassword($code_genere, $passwordUpdate )
    {
        $this->table = "agent_distributeur";
        $this->champs = ["password=" => $passwordUpdate];
        $this->condition = ["code_genere = " => $code_genere];
        return $this->__update();
    }
    public function updateReinitialisationPassword($idUser, $passwordUpdate)
    {
        $this->table = "agent_distributeur";
        $this->champs = ["password=" => $passwordUpdate];
        $this->condition = ["id = " => $idUser];
        return $this->__update();
    }

}