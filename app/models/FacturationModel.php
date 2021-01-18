<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class FacturationModel extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    /**************************************************************** DEBUT TRANSACTIONS PAR PARTENAIRE  ***************************************************/

    /**
     * Lister Transaction Partenaire
     */
    public function getAllTransactionPartenaire($param)
    {
        $this->table = "sva_transaction t";
        $this->champs = ["t.rowid","t.num_transaction","t.date_transaction","t.montant","t.commission","s.label as service","t.commentaire as _commentaire_","t.statut as _statut_"];
        $this->jointure = ["
                        INNER JOIN sva_service_sunusva as s ON t.fk_service = s.rowid
        "];
        $this->condition=["t.statut="=>1, "t.fk_partenaire="=>$param[0], "DATE(t.date_transaction) >="=>$param[1], "DATE(t.date_transaction) <="=>$param[2]];
        return $this->__processing();
    }

    public function getTransactions($dateDebut='',$dateFin=''){
        $cond["DATE(date) >="] = $dateDebut ;
        $cond["DATE(date) <="] = $dateFin ;
        $cond["numGIE = " ] = $this->_USER->gie;
        $this->table = "transaction";
        $this->champs =["count(id) as nombre, sum(montant) as montant"];
        $this->condition = $cond ;
        return $this->__select()[0];
    }

    public function getTransactionsDetails($dateDebut='',$dateFin=''){
        //echo $dateDebut. ' '.$dateFin ; exit;
        $cond["DATE(tr.date) >="] = $dateDebut ;
        $cond["DATE(tr.date) <="] = $dateFin ;
        $cond["tr.numGIE = " ] = $this->_USER->gie;
        $cond["t.etat = " ] = 1;
        $this->table = "type_transaction t";
        $this->champs =["t.id, t.libelle, count(tr.id) as nombre, sum(tr.montant) as montant, t.part_nta, t.part_numherit"];
        $this->jointure = ["LEFT JOIN transaction tr ON  t.id = tr.type"];
        $this->condition = $cond ;
        $this->group = ["t.id"];
        return $this->__select();
    }
    public function factures($param=null){
        $this->table = "facture";
        $this->champs =["rowid", "CONCAT(date_debut, ' to ', date_fin ) as periode" , "date_creation" , "date_reglement" , "part_numherit as montant", "montant_regle", "statut"];
        return $this->__processing();
    }

    public function insertFacture($data){
        $this->table = "facture";
        $this->champs =  $data;
        $insert = $this->__insert() ;
        return $insert ;
    }

    public function insertDetailFacture($data){
        $this->table = "detail_facture";
        $this->champs =  $data;
        $insert = $this->__insert() ;
        return $insert ;
    }

    public function getLastDateFinFacture($idMax)
    {
        $this->table = "facture";
        $this->champs = ["rowid, date_debut, date_fin "] ;
        $this->condition=["rowid = "=> $idMax] ;
        return $this->__select()[0];
    }




    /**
     * Get Transaction Partenaire
     */
    public function getPartenaire($param = null)
    {
        $this->table = "sva_transaction";
        $this->__addParam($param);
        return $this->__select();
    }

    public function getDistributeurs()
    {
        $this->table = "distributeur";
        $this->champs = ["id , nom_point as label"] ;
        return $this->__select();
    }

    public function getEtatEnrolement($idDistributeur, $dateDebut='' ,$dateFin = '' )
    {

        $cond = [];
        if(!empty($dateDebut)){
            $cond["DATE(date_creation) >="] = $dateDebut;
        }
        if(!empty($dateFin)){
            $cond["DATE(date_creation) <="] = $dateFin;
        }

        if(!empty($idDistributeur)){
            $cond["fk_distributeur ="] = $idDistributeur;
        }


        $this->table = "carte";
        $this->champs =['id','COUNT(id) as nb_enrolement'];
        $cond['statut ='] = 1 ;

        $this->condition = $cond ;
        return $this->__select()[0];
    }

    public function getEtatRechargement($idDistributeur, $dateDebut='' ,$dateFin = '' )
    {

        $cond = [];
        if(!empty($dateDebut)){
            $cond["DATE(date_transac) >="] = $dateDebut;
        }
        if(!empty($dateFin)){
            $cond["DATE(date_transac) <="] = $dateFin;
        }

        if(!empty($idDistributeur)){
            $cond["fk_distributeur ="] = $idDistributeur;
        }


        $this->table = "histo_rechargement";
        $this->champs =['id','COUNT(id) as nb_rechargement','SUM(montant) as montant', 'SUM(part_nta) as part_nta', 'SUM(part_distributeur) as part_distributeur'];
        //$cond['statut ='] = 1 ;

        $this->condition = $cond ;
        return $this->__select()[0];
    }

    public function enrolement($param = null)
    {
        $anneCours = date('m');
        $this->table = "carte c";
        $this->champs = ["c.date_creation","c.id","cl.nom","cl.prenom","c.numero_serie","c.solde","d.nom_point"];
        $this->jointure = [
            "INNER JOIN client as cl ON c.client = cl.id",
            "LEFT JOIN distributeur as d ON d.id = c.fk_distributeur"
        ];
        $cond = [] ;
        if($param[2]!= ''){

            $cond["d.id ="] = $param[2];
        }
        if( $param[0]!= ''){
            $cond["DATE(c.date_creation) >="] = $param[0];
        }
        if( $param[1]!= ''){
            $cond["DATE(c.date_creation) <= "] = $param[1];
        }
        $cond['statut ='] = 1 ;
        $this->condition = $cond ;

        return $this->__processing();
    }

    public function rechargement($param = null)
    {

        $this->table = "histo_rechargement h";
        $this->champs = ["h.id","h.date_transac","cl.nom","cl.prenom","c.numero_serie","h.montant","d.nom_point"];
        $this->jointure = [
            "INNER JOIN carte as c ON c.id = h.carte_id",
            "INNER JOIN client as cl ON c.client = cl.id",
            "LEFT JOIN distributeur as d ON d.id = h.fk_distributeur"
        ];
        $cond = [] ;
        if($param[2]!= ''){

            $cond["d.id ="] = $param[2];
        }
        if( $param[0]!= ''){
            $cond["DATE(h.date_transac) >="] = $param[0];
        }
        if( $param[1]!= ''){
            $cond["DATE(h.date_transac) <= "] = $param[1];
        }
        //$cond['statut ='] = 1 ;
        $this->condition = $cond ;

        return $this->__processing();
    }

    /**
     * Get un Partenaire
     */
    public function getUnPartenaire($param = null)
    {
        $this->table = "sva_partenaire";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Détail Transaction Partenaire
     */
    public function getOneTransaction($param = null)
    {
        $this->table = "sva_transaction t";
        $this->champs = ["t.rowid","t.num_transaction","t.date_transaction","t.montant","t.commission","s.label as service","t.commentaire","t.statut"];
        $this->jointure = ["
                        INNER JOIN sva_service_sunusva as s ON t.fk_service = s.rowid
        "];
        $this->condition = ["t.rowid >="=>$param];
        $this->__addParam($param);
        return $this->__detail();
    }

    /**
     * Impression Transaction Partenaire
     */
    public function getTransactionPartenaire($param)
    {
        $this->table = "sva_transaction t";
        $this->champs = ["t.rowid","t.num_transaction","t.date_transaction","t.montant","t.commission","s.label as service","p.raison_sociale as partenaire","t.commentaire","t.statut"];
        $this->jointure = ["
                        INNER JOIN sva_service_sunusva as s ON t.fk_service = s.rowid
                        INNER JOIN sva_partenaire as p ON t.fk_partenaire = p.rowid
        "];
        $this->__addParam($param);
        return $this->__select();
    }

    /**************************************************************** FIN TRANSACTIONS PAR PARTENAIRE  ***************************************************/



    /**************************************************************** DEBUT TRANSACTIONS PAR SERVICE  ***************************************************/

    /**
     * Lister Transaction par Service
     */
    public function getAllTransactionService($param)
    {
        $this->table = "sva_transaction t";
        $this->champs = ["t.rowid","t.num_transaction","t.date_transaction","t.montant","t.commission","p.raison_sociale as partenaire","t.commentaire as _commentaire_","t.statut as _statut_"];
        $this->jointure = ["
                        INNER JOIN sva_partenaire as p ON t.fk_partenaire = p.rowid
        "];
        $this->condition=["t.statut="=>1, "t.fk_service="=>$param[0], "DATE(t.date_transaction) >="=>$param[1], "DATE(t.date_transaction) <="=>$param[2]];
        return $this->__processing();
    }

    /**
     * Get Transaction par Service
     */
    public function getService($param = null)
    {
        $this->table = "sva_transaction";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Get un Service
     */
    public function getUnService($param = null)
    {
        $this->table = "sva_service_sunusva";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Détail Transaction par Service
     */
    public function getOneService($param = null)
    {
        $this->table = "sva_transaction t";
        $this->champs = ["t.rowid","t.num_transaction","t.date_transaction","t.montant","t.commission","p.raison_sociale as partenaire","t.commentaire","t.statut"];
        $this->jointure = ["
                        INNER JOIN sva_partenaire as p ON t.fk_partenaire = p.rowid
        "];
        $this->condition = ["t.rowid >="=>$param];
        $this->__addParam($param);
        return $this->__detail();
    }

    /**
     * Impression Transaction pour un Service donné
     */
    public function getTransactionService($param)
    {
        $this->table = "sva_transaction t";
        $this->champs = ["t.rowid","t.num_transaction","t.date_transaction","t.montant","t.commission","p.raison_sociale as partenaire","t.commentaire","t.statut"];
        $this->jointure = ["
                        INNER JOIN sva_partenaire as p ON t.fk_partenaire = p.rowid
        "];
        $this->__addParam($param);
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

    public function reportingByMonth(){
        $anneCours = date('Y');
        //$dateM = date('m');
        $this->table = "transaction";
        $this->champs =["MONTH(date) as mois, sum(montant) as mnt"];
        $this->condition=["YEAR(date)  ="=> $anneCours  /*,"MONTH(date)  ="=> $dateM*/];
        $this->group = ["MONTH(date)"];
        return $this->__select();
    }
    public function nbreTicketParMonth(){
        $anneCours = date('Y');
        //$dateM = date('m');
        $this->table = "transaction";
        $this->champs =["MONTH(date) as mois, count(id) as nbreTicket"];
        $this->condition=["YEAR(date)  ="=> $anneCours  /*,"MONTH(date)  ="=> $dateM*/];
        $this->group = ["MONTH(date)"];
        return $this->__select();
    }

    public function ticketTotalPerCash(){
        $date = date('Y');
        $this->table = "transaction";
        $this->champs =["count(id) as nbreTicket"];
        $this->condition=["YEAR(date)  ="=> $date,"fkcarte="=> 0];
        return $this->__detail()->nbreTicket;
    }
    public function ticketVenduCash(){
        $date = date('Y');
        $this->table = "transaction";
        $this->champs =["sum(montant) as mnt"];
        $this->condition=[ "fkcarte="=> 0];
        return $this->__detail()->mnt;
    }

    public function ticketTotalPerCard(){
        $date = date('Y');
        $this->table = "transaction";
        $this->champs =["count(id) as nbreTicket"];
        $this->condition=["YEAR(date)  ="=> $date,"fkcarte>"=> 0];
        return $this->__detail()->nbreTicket;
    }

    public function ticketVenduCard(){
        $date = date('Y-m-d');
        $this->table = "transaction";
        $this->champs =["sum(montant) as mnt"];
        $this->condition=["fkcarte>"=> 0];
        return $this->__detail()->mnt;
    }

    public function ticketCashByMonth(){
        $anneCours = date('Y');
        //$dateM = date('m');
        $this->table = "transaction";
        $this->champs =["MONTH(date) as mois, count(id) as nbreTicket"];
        $this->condition=["YEAR(date)  ="=> $anneCours ,"fkcarte ="=> 0];
        $this->group = ["MONTH(date)"];
        return $this->__select();
    }
    public function ticketCardByMonth(){
        $anneCours = date('Y');
        //$dateM = date('m');
        $this->table = "transaction";
        $this->champs =["MONTH(date) as mois, count(id) as nbreTicket"];
        $this->condition=["YEAR(date)  ="=> $anneCours ,"fkcarte >"=> 0];
        $this->group = ["MONTH(date)"];
        return $this->__select();
    }

    public function CommissionProcess($param)
    {
        $result =  $this->get(["table"=>"quote_part","champs"=>["valeur"],"condition" => ["code = " => 2]])[0];
        $com_numherit = $result->valeur ;

        $cond["DATE(t.date) >="] = $param[0] ;
        $cond["DATE(t.date) <="] = $param[1] ;
        $cond["t.etat = "] = 1 ;

        $this->table = "transaction t";
        $this->champs =['t.id','DATE(t.date) as date_transaction', 'COUNT(t.ticket) as nb_ticket' , 'SUM(t.montant) as montant_total', 'SUM(t.montant * '.$com_numherit.') as com_numherit' ];

        //$this->group=['date_transaction'];

        $this->condition = $cond ;
        $this->group=['t.ticket'];
        // $this->condition=["u.code_entite ="=>$entite[0]];
        return $this->__processing();
    }

    public function getCommission($dateDebut='' ,$dateFin = '' )
    {
        $result =  $this->get(["table"=>"quote_part","champs"=>["valeur"],"condition" => ["code = " => 2]])[0];
        $com_numherit = $result->valeur ;

        $cond["DATE(t.date) >="] = $dateDebut ;
        $cond["DATE(t.date) <="] = $dateFin ;
        $cond["t.etat = "] = 1 ;

        $this->table = "transaction t";
        $this->champs =['COUNT(t.ticket) as nb_ticket' , 'SUM(t.montant) as montant_total', 'SUM(t.montant * '.$com_numherit.') as com_numherit' ];

        $this->condition = $cond ;
        $this->group=['t.ticket'];
        return $this->__select()[0];
    }

    public function detailFactures($param)
    {
        $this->table = "detail_facture df";
        $this->champs = ["df.rowid ","t.libelle","df.nombre_transaction","df.montant","df.part_numherit","df.part_nta"];
        $this->jointure = ["
                        INNER JOIN type_transaction as t ON df.fk_type_transaction = t.id
        "];
        $this->condition=["df.fk_facture ="=>$param[0]];

        return $this->__processing();



    }

    public function getImpressionFacture($param)
    {
        //var_dump($param);die();
        $this->table = "detail_facture df";
        $this->champs = ["df.rowid","df.date_debut","df.date_fin","SUM(df.montant) as montant","SUM(df.part_numherit) as part_numherit","SUM(df.part_nta) as part_nta","df.nombre_transaction as nbre","t.libelle"];
        $this->jointure = ["
                        INNER JOIN type_transaction as t ON df.fk_type_transaction = t.id
        "];
        $this->condition=["df.fk_facture ="=>$param];
        $this->group=["df.fk_facture"];
        return $this->__select();
    }


}