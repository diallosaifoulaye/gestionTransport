<?php
/**
 * Created by PhpStorm.
 * User: stagiaire_dev_mob
 * Date: 9/26/19
 * Time: 11:33 AM
 */
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class TrajetsModel extends BaseModel
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
     * @param $param
     * @return bool|mixed
     */

    /**
     * Ajout Bus
     */
    public function insertTrajets($param)
    {
        $this->table = "trajet";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function existeGroupe($param)
    {
        var_dump($param);die;
        $this->table = "trajet t";
        $this->champs = ["t.id","t.etat"];
        $this->condition = ['t.id =' => $param ];
        if ($param =='1') return 1;
        else -1;
    }
    /**
     * Lister Bus
     */
    public function updateTrajets($param)
    {
        $this->table = "trajet";
        $this->__addParam($param);
        return $this->__update();
    }

    public function deleteTrajets($param)
    {
        $this->table = "trajet";
        $this->__addParam($param);
        return $this->__delete();
    }

    public function getTrajets($param = null)
    {
        $this->table = "trajet ";
      /*  $this->champs = ["t.*"];
        $this->jointure = [
            " INNER JOIN gie as g ON t.numGie = g.id"
        ];
        $this->condition = ['t.numGie =' => $this->_USER->gie];*/
        $this->__addParam($param);
        return $this->__select();
    }

    public function getOneLigne($param = null)
    {
        $this->table = "ligne ";
        $this->__addParam($param);
        return $this->__detail();
    }

    public function getLigne($param = null)
    {
        $this->table = "ligne ";
        $this->__addParam($param);
        return $this->__select();
    }

    public function updateTrajetsDetail($param)
    {
        $this->table = "trajet";
        $this->__addParam($param);
        return $this->__update();
    }

    public function getAllTrajets($param = null)
    {
        $this->table = "trajet t";
        $this->champs = ["t.id","l.libelle","t.lieu_depart","t.lieu_arrive","t.nombre_section","t.ecart_section","t.prix_base","t.etat"];
        $this->jointure = [
              "INNER JOIN gie as g ON t.gie = g.id",
              "INNER JOIN ligne as l ON t.ligne = l.id"
        ];
        $this->condition = ['t.gie =' => $param->gie];
        return $this->__processing();
    }

    public function getOneTrajets($param)
    {
        $this->table = "trajet t";
        $this->champs = ["t.id","l.libelle as ligne","t.lieu_depart","t.lieu_arrive","t.nombre_section","t.ecart_section","t.prix_base","t.etat"];
        $this->jointure = [
           " INNER JOIN gie as g ON t.gie = g.id",
            "INNER JOIN ligne as l ON t.ligne = l.id"
        ];
        $this->condition = ['t.numGie =' => $param->gie];
        $this->__addParam($param);
        return $this->__detail();
    }
//////revoir cette methode vu qu'on l utilise pas pour l'instant
    public function getItinerary(){
        $this->table = "itineraire i";
        $this->champs = ["i.nom", "t.ligne"];
        $this->jointure = [
            "INNER JOIN trajet as t ON t.id = i.id_trajet"
        ];
        return $this->__select();

    }

    public function getPoints($param = null){
        //var_dump($param);die;
        $this->table = "points p";
        $this->champs = ["p.rowid","p.nom", "p.longitude", "p.latitude"];
        $this->jointure = [
            "INNER JOIN trajet as t ON t.id = p.id_trajet",
            "INNER JOIN ligne as l ON l.id = p.id_trajet"

        ];
        $this->condition = ['p.id_trajet =' => $param[0]];
        return $this->__processing();
    }

    public function getOnePoint($param){
        $this->table = "points p";
        $this->champs = ["p.rowid","p.nom", "t.ligne", "p.longitude", "p.latitude"];
        $this->jointure = [
            "INNER JOIN trajet as t ON t.id = p.id_trajet"
        ];
        $this->__addParam($param);
        return $this->__detail();
    }

    public function updateOnePoint($param)
    {
        $this->table = "points";
        $this->__addParam($param);
        return $this->__update();
    }

    public function deletePoint($param)
    {
        $this->table = "points";
        $this->__addParam($param);
        return $this->__delete();
    }

    public function insertPoint($param)
    {
        $this->table = "points";
        $this->__addParam($param);
        return $this->__insert();
    }
/********************************************************************************** Debut Voyage*******************************************************************************************/
    public function insertVoyages($param)
    {
        $this->table = "voyage";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Lister Bus
     */
    public function updateVoyages($param)
    {
        $this->table = "voyage";
        $this->__addParam($param);
        return $this->__update();
    }

    public function deleteVoyages($param)
    {
        $this->table = "voyage";
        $this->__addParam($param);
        return $this->__delete();
    }

    public function getVoyages($param = null)
    {
        $this->table = "voyage";
        $this->__addParam($param);
        return $this->__select();
    }

    public function countTransactionVoyages($param = null)
    {
        $this->table = "transaction";
        $this->champs = ["id"];
        $this->__addParam($param);
        $res = $this->__select();
        if($res != false){
            return count($this->__select());
        }
        else
            return -1;

    }


    public function updateVoyagesDetail($param)
    {
        $this->table = "voyage";
        $this->__addParam($param);
        return $this->__update();
    }

    public function getAllVoyages($param = null)
    {

        $this->table = "voyage v";
        $this->champs = ["v.id","b.matricule as bus",'concat(e.nom," ",e.prenom) as employe','concat(r.nom," ",r.prenom) as receveur',
            'concat(c.nom," ",c.prenom) as controleur','concat(t.lieu_depart," ",t.lieu_arrive) as trajet',"DATE(v.date_voyage) as date_voyage","v.etat"];
        $this->jointure = [
            "INNER JOIN bus as b ON v.bus_id = b.id
            INNER JOIN employe as e ON v.conducteur_id = e.id
            INNER JOIN utilisateur as r ON v.receveur_id = r.id
            INNER JOIN controleur as c ON v.controleur_id = c.id
            INNER JOIN trajet as t ON v.trajet_id = t.id
            INNER JOIN gie as g ON v.gie = g.id"
        ];
       /* $this->condition = ['v.gie =' => $param->gie,
            'r.type =' => 3
            ];*/
        return $this->__processing();
    }

    public function getOneVoyages($param = null)
    {
        $this->table = "voyage v";
        $this->champs = ["v.*","b.matricule as bus",'concat(e.nom," ",e.prenom) as employe','concat(r.nom," ",r.prenom) as receveur',
            'concat(c.nom," ",c.prenom) as controleur','concat(t.lieu_depart," ====> ",t.lieu_arrive) as trajet'];
        $this->jointure = [
            "INNER JOIN bus as b ON v.bus_id = b.id
            INNER JOIN employe as e ON v.conducteur_id = e.id
            INNER JOIN utilisateur as r ON v.receveur_id = r.id
            INNER JOIN controleur as c ON v.controleur_id = c.id
            INNER JOIN trajet as t ON v.trajet_id = t.id
            INNER JOIN gie as g ON v.gie= g.id"
        ];

        $this->__addParam($param);
        return $this->__detail();
    }

    public function getChauffeur($param = null)
    {
        $this->table = "employe e";
        $this->champs = ["e.*"];
        $this->jointure = [
            " INNER JOIN gie as g ON e.numGie = g.id"
        ];
        $this->condition = ['e.numGie =' => $this->_USER->gie];
        $this->__addParam($param);
        return $this->__select();
    }
    public function getReceveur($param = null)
    {
        $this->table = "utilisateur r";
        $this->champs = ["r.*"];
        $this->jointure = [
            " INNER JOIN gie as g ON r.gie = g.id"
        ];
        $this->condition = ['r.gie =' => $this->_USER->gie,
           'r.type =' => 3
        ];
        $this->__addParam($param);
        return $this->__select();
    }
    public function getControleur($param = null)
    {
        $this->table = "controleur c";
        $this->champs = ["c.*"];
        $this->jointure = [
            " INNER JOIN gie as g ON c.numGie = g.id"
        ];
        $this->condition = ['c.numGie =' => $this->_USER->gie];
        $this->__addParam($param);
        return $this->__select();
    }
    public function getBus($param = null)
    {
        $this->table = "bus b";
        $this->champs = ["b.*"];
        $this->jointure = [
            " INNER JOIN gie as g ON b.numGIE = g.id"
        ];
        $this->condition = ['b.numGIE =' => $this->_USER->gie];
        $this->__addParam($param);
        return $this->__select();
    }
    public function getTrajetsVoy($param = null)
    {
        $this->table = "trajet t";
         $this->champs = ["t.*"];
          $this->jointure = [
              " INNER JOIN gie as g ON t.gie = g.id"
          ];
          $this->condition = ['t.gie =' => $this->_USER->gie];
        $this->__addParam($param);
        return $this->__select();
    }
/********************************************************************************* Debut Voyage*******************************************************************************************/

public function insertLignes($param)
{
    $this->table = "ligne";
    $this->__addParam($param);
    return $this->__insert();
}

public function getAlllignes($param = null)
{

    $this->table = "ligne l";
    $this->champs = ["l.id","l.libelle","l.etat"];
   // $this->condition = ['v.numGie =' => $param->gie];
    return $this->__processing();
}

    public function updateLignes($param)
    {
        $this->table = "ligne";
        $this->__addParam($param);
        return $this->__update();
    }
    public function deleteLignes($param)
    {
        $this->table = "ligne";
        $this->__addParam($param);
        return $this->__delete();
    }
/****************************************************************************** Debut Ticket*******************************************************************************************/

    public function insertTickets($param)
    {
        $this->table = "ticket";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function getAllTickets($param = null)
    {

        $this->table = "ticket t";
        $this->champs = ["t.id","t.num_ticket","t.prix","DATE(t.date_ticket) as date_ticket","t.etat"];
        $this->jointure = [
            " INNER JOIN gie as g ON t.numGIE = g.id"
         ];
        $this->condition = ['t.numGIE =' => $param->gie];
        return $this->__processing();
    }

    public function updateTickets($param)
    {
        $this->table = "ticket";
        $this->__addParam($param);
        return $this->__update();
    }


    public function getAffectation(){
        $this->table = "affectation_bus a";
        $this->champs = ["a.rowid", "a.bus_id", "a.device_id", "a.receveur_id", "b.matricule", "CONCAT(u.prenom, ' ', u.nom) as receveur", "d.uuid"];
        $this->jointure = [
            " INNER JOIN bus as b ON a.bus_id = b.id",
            " INNER JOIN utilisateur as u ON a.receveur_id = u.id",
            " INNER JOIN devices as d ON a.device_id = d.rowid"
        ];
        //$this->condition = ['a.gie = ? AND a.etat = ? AND a.date_debut <= ? AND a.date_fin >= ?'];
        //$this->value = [$this->_USER->gie, 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')];
        $allaffections = $this->__select();
        $lesaffectes = array();

        $this->table = "voyage";
        $this->champs = ["affectation_id"];
        $this->condition = ["etat = " => 1, 'gie = ' => $this->_USER->gie, 'DATE(date_voyage) = ' => date('Y-m-d')];
        $allaffectionsencours = $this->__select();

        if(count($allaffections) > 0){
            foreach ($allaffections as $one){
                $trouve = false;
                if(count($allaffectionsencours) > 0){
                    foreach ($allaffectionsencours as $one2){
                        if($one->rowid == $one2->affectation_id){
                            $trouve = true;
                        }
                    }
                }
                if($trouve == false){
                    $lesaffectes[] = $one;
                }
            }

            return $lesaffectes;
        }
        else{
            return $allaffections;
        }
    }


    public function getTicket($param = null){
        $this->table = "transaction t";
        $this->champs = ["count(t.id) as nombre", "SUM(t.montant) as ca"];
        $this->__addParam($param);
        return $this->__detail();
    }

    public function getOneTicket($param = null){
        $this->table = "ticket t";
        $this->champs = ["t.id","t.num_ticket","t.prix","DATE(t.date_ticket) as date_ticket","t.etat"];
        /*$this->jointure = [
            " INNER JOIN gie as g ON t.numGIE = g.id"
        ];*/
        $this->__addParam($param);
        return $this->__detail();
    }

    public function getTicketAllVoyages($param = null)
    {

        $this->table = "transaction t";
        $this->champs = ["t.id","t.num_transaction","TIME(t.date) as date_trans","t.montant","t.nombre_section","t.section_courante", "t.fkcarte"];
        $this->condition = ['t.trajet =' => $param['idvoyage']];
        return $this->__processing();
    }
}
