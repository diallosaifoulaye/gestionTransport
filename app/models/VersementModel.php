<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class VersementModel extends BaseModel
{

    /**
     * TransactionModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * TransactionModel destruct.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Processing transaction
     */

    public function insertParametrage($param)
    {
        $this->table = "parametrage";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function getCollecteurs()
    {
        $this->table = "utilisateur";
        $this->champs = ["id","CONCAT(prenom,' ',nom) as label","etat"];
        $this->condition =["etat="=>"1"] ;
        return $this->__select();
    }

    public function insertVersement($data){
       // var_dump($data);
        $this->table = "versement";
        $this->champs =  $data;
        $insert = $this->__insert() ;
        return $insert ;
    }

    public function insertDetailVersement($data){
        $this->table = "detail_versement";
        $this->champs =  $data;
        $insert = $this->__insert() ;
        return $insert ;
    }

    public function updateTransaction($id, $date){
        $data['verse'] = 1 ;
        $this->table = "transaction";
        $this->champs = $data;
        $this->condition=["receveur ="=>intval($id),"DATE(date) ="=>$date];
        $update=  $this->__update();
        return $update ;
    }


    public function getDateCollect($id){
//echo 'OOOOO'.$id ;
        $this->table = "transaction";
        $this->champs = ['DATE(date) as date'];
        $this->condition = ["etat ="=>1,"verse ="=>0,"receveur = " =>$id];
        $this->group = ['DATE(date)'];
        // $this->condition=["u.code_entite ="=>$entite[0]];
        return $this->__select();

    }

    public function getUser($param = null)
    {
        $this->table = "utilisateur u";
        $this->__addParam($param);
        return $this->__select();
    }

    public function getCollectByIdCollecteur($id,$date){
       // echo $id." ".$date ;
        $this->table = "transaction";
        $this->champs =['id', 'date','montant','nombre_section'];
        $this->condition=["etat ="=>1,"verse ="=>0,"receveur = " =>$id,'DATE(date)=' =>$date];
        //$this->group=['receveur'];
        // $this->condition=["u.code_entite ="=>$entite[0]];
        return $this->__select();

    }

    public function getCollectById($id){

        $this->table = "transaction t";
        $this->champs =['t.receveur as rowid', 'c.prenom', 'c.nom','DATE(t.date) date_transaction','SUM(t.montant) as montant'];
        $this->jointure =["
            INNER JOIN utilisateur c on c.id = t.receveur
        "];
        $this->condition=["t.etat = "=>1,"t.verse = "=>0,"c.id = " =>$id];
        $this->group=['date_transaction'];
        // $this->condition=["u.code_entite ="=>$entite[0]];
        return $this->__select();

    }



    public function collectesProcess($param = null)
    {
        $this->table = "transaction t";
        $this->champs =['t.receveur as rowid', 'c.prenom', 'c.nom','COUNT(DISTINCT DATE(t.date)) as nb_jour', 'COUNT(t.id) as nbTransaction','SUM(t.montant) as montant_v'];
        $this->jointure =["
            INNER JOIN utilisateur c on c.id = t.receveur
        "];
        $this->condition=["t.etat ="=>1,"t.verse ="=>0,"t.fkcarte ="=>0];
        $this->group = ['receveur'];
        return $this->__processing();
    }


    public function historiqueProcess($param)
    {
        //var_dump($param);
        $cond["DATE(v.date_versement) >="] = $param[0] ;
        $cond["DATE(v.date_versement) <="] = $param[1] ;
        if(!empty($param[2] )){
            $cond["v.fk_collecteur ="] = $param[2] ;
        }
        //$cond = ["DATE(v.date_versement) >="=>$param[0], "DATE(v.date_versement) <="=>$param[1],"DATE(v.fk_collecteur) ="=>$param[2]];

        $this->table = "versement v";
        $this->champs =["v.rowid as rowid","DATE(v.date_versement) as date_versement","v.montant_collect as montant","v.nb_collecte as nb_collecte", "CONCAT(prenom,' ',nom) as label"];
        $this->jointure =["
            LEFT JOIN utilisateur c on c.id = v.fk_collecteur
        "];
       // var_dump($cond);exit;
        //$this->sort = ["rowid","desc"] ;
        $this->condition = $cond ;

        return $this->__processing();
       // echo '<pre>';
       // var_dump($this->__select()) ;exit;
    }


    public function historique($param)
    {
        //$cond = ["DATE(v.date_versement) >="=>$param[0], "DATE(v.date_versement) <="=>$param[1]];
        $cond["DATE(v.date_versement) >="] = $param[0] ;
        $cond["DATE(v.date_versement) <="] = $param[1] ;
        if(!empty($param[2] )){
            $cond["v.fk_collecteur ="] = $param[2] ;
        }
        $this->table = "versement v";
        $this->champs =["v.rowid as rowid","DATE(v.date_versement) as date_versement","v.montant_collect as montant","v.nb_collecte as nb_collecte", "CONCAT(prenom,' ',nom,' (',code_collecteur,')') as label"];
        $this->jointure =["
            INNER JOIN user c on c.id = v.fk_collecteur
        "];
        $this->condition = $cond ;

        return $this->__select();
    }


    public function getVersementById($param)
    {
        $this->table = "versement v";
        $this->champs =["v.rowid as rowid","v.date_creation","DATE(v.date_versement) as date_versement","v.montant_collect as montant","v.nb_collecte as nb_collecte", "CONCAT(prenom,' ',nom) as label"];
        $this->jointure =["
            LEFT JOIN utilisateur c on c.id = v.fk_collecteur
        "];
        $this->__addParam($param);

        return $this->__detail();
    }


    public function getDetailsByVersement($param)
    {
        $this->table = "detail_versement v";
        $this->champs =["v.rowid as rowid","DATE(v.date_versement) as date_versement","DATE(v.date_creation) as date_creation","v.montant_collect as montant", "CONCAT(prenom,' ',nom,' (',code_collecteur,')') as label"];
        $this->jointure =["
            INNER JOIN user c on c.id = v.fk_collecteur
        "];
        $this->__addParam($param);

        return $this->__select();
    }

    public function detailsProcess($param)
    {
        $id = $param[0];
        //echo $id;
        $this->table = "detail_versement v";
        $this->champs =["v.rowid as rowid","DATE(v.date_versement) as date_versement","CONCAT(prenom,' ',nom) as label","v.montant_collect as montant"];
        $this->jointure =["
            INNER JOIN utilisateur c on c.id = v.fk_collecteur
        "];
        $this->condition=["v.fk_versement ="=>$id];

        return $this->__processing();
    }

    public function detailsVersements($param)
    {
        $id = $param[0];
        //echo $id;
        $this->table = "detail_versement v";
        $this->champs =["v.rowid as rowid","DATE(v.date_versement) as date_versement","CONCAT(prenom,' ',nom) as label","v.montant_collect as montant"];
        $this->jointure =["
            INNER JOIN utilisateur c on c.id = v.fk_collecteur
        "];
        $this->condition=["v.fk_versement ="=>$id];

        return $this->__select();
    }

    public function getLocProcess()
    {
   // var_dump($param);exit;
        //$cond = ["DATE(date_transac) >="=>$param[0], "DATE(date_transac) <="=>$param[1]];
        $this->table = "transaction t";
        $this->champs = ["t.idtransaction as id","u.prenom","u.nom","t.codeCollecteur","t.date_transac","t.codeCollecteur as code", "longitude as _longitude_","latitude as _latitude_"];
        $this->jointure = ["INNER JOIN user u ON u.id = t.idcollecteur"];
        $this->group = ["codeCollecteur"];
        //$this->condition = $cond ;
        return $this->__processing();
    }
    public function getTransaction($param = null)
    {
        $this->table = "transaction";
        $this->__addParam($param);
        return $this->__select();
    }

    public function TransactParMois($lemois)
    {
        $year = date('Y');
        $this->table = "transaction ";
        $this->champs = ['sum(montant_ttc) as mnt'];
        $this->condition = ["month(date_transac)="=>$lemois,"year(date_transac)="=>$year,"statut="=>1];
        return $this->__select();
    }



}