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
use app\core\Utils;

class LocationModel extends BaseModel
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
     * Recuperer Bus
     */

    public function getBus($param = null)
    {
        $this->table = "bus";
        $this->champs = ["id","matricule", "places"];
       // $this->__addParam($param);
        return $this->__select();
    }
    /**
     * Recuperer Etat Bus Loué
     */
    /*public function getEtatBusLoue($param = null)
    {
        $this->table = "location";
        $this->champs = ["id","etat"];
        // $this->__addParam($param);
        return $this->__select();
    }*/

    public function getPlaces($param = null)
    {
        $this->table = "facturationLocation";
        $this->champs = ["id","place_min", "place_max", "price_by_day"];
       // $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Ajout Location
     */
    public function insertLocation($param)
    {
        $this->table = "location";
        $this->jointure = [
            "INNER JOIN bus as b ON l.select_bus = b.id",
            "INNER JOIN facturationLocation as f ON f.place_max = l.places"
        ];
        $this->condition = ['b.places =' => $param->places];
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * Liste des bus loués
     */
    public function getAllBusLoues()
    {
        $this->table = "location as l";
        $this->champs = ["l.id","l.nom_locataire","l.prenom_locataire","l.telephone","b.matricule","l.date_deb","l.date_fin","l.montant_total","l.etat"];
        $this->jointure = [
            "INNER JOIN bus as b ON l.select_bus = b.id"
          // "INNER JOIN facturationLocation as f ON f.place_max = l.places"
        ];
      //  $this->condition = ['l.numGie =' => $this->_USER->gie];


        return $this->__processing();
    }

    /**
     * Modification d'un bus loue
     */

    public function updateBusLoue($param)
    {
        $this->table = "location";
        $this->__addParam($param);
        return $this->__update();
    }

    public function getBusLoue()
    {
        $this->table = "location l";
        $this->champs = ["l.id","l.nom_locataire", "l.prenom_locataire","l.piece_identite","l.adresse","l.telephone","l.intermediaire","l.nom_entreprise","l.date_reservation","l.date_deb","l.date_fin","b.matricule","l.price_by_day","l.montant_total","l.etat"];
        $this->jointure = [
            "INNER JOIN bus as b ON l.select_bus = b.id"
        ];
       $this->__addParam($param);
        return $this->__select();
    }


    public function insertParam($param)
    {
        $this->table = "facturationLocation";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Liste des prix de location en fonction des places
     */

    public function getPrice($param = null)
    {
        $this->table = "facturationLocation";
        $this->champs = ["id","place_min","place_max", "price_by_day"];
        return $this->__processing();
    }
    /**
     * Recuperer une observation de la table facturationLocation
     */
    public function getParametrageFacture($param = null)
    {
        $this->table = "facturationLocation";
        $this->__addParam($param);
        return $this->__select();
    }


    /**
     * Modifier une observation selectionner
     */
    public function updateFacture($param)
    {
        $this->table = "facturationLocation";
        $this->__addParam($param);
        return $this->__update();
    }

    public function deleteParamFact($param)
    {
        $this->table = "facturationLocation";
        $this->__addParam($param);
        return $this->__delete();
    }

    /**
     * Suppression Bus Loue
     */
    public function deleteBusLoue($param)
    {
        $this->table = "location";
        $this->__addParam($param);
        return $this->__delete();
    }

    public function getOneBusLoue($param = null)
    {
        $this->table = "location l";
        $this->champs = ["l.id","l.nom_locataire", "l.prenom_locataire","l.piece_identite","l.adresse","l.telephone","l.intermediaire","l.nom_entreprise","l.date_reservation","l.date_deb","l.date_fin","b.matricule as matricule","l.price_by_day","l.montant_total","l.etat"];
        $this->jointure = ["INNER JOIN bus as b ON l.select_bus = b.id"];
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Repporting
     */


    public function getLocationByDate()
    {

        $this->table = "location l";
        $this->champs = ["l.id","l.nom_locataire","l.prenom_locataire","l.telephone","b.matricule as bus","l.date_deb","l.date_fin","l.montant_total","l.etat"];
        $this->jointure = [
                        "INNER JOIN bus as b ON l.select_bus = b.id"
                         ];
       /* $cond = [] ;
        if($param[0]!= ''){
            $tableau = explode('_',$param[0]) ;
            if ($tableau[1] != '')
                $cond['l.date_deb >= '] =$tableau[1] ;
        }


        if($param[1]!= ''){
            $tableau = explode('_',$param[1]) ;
            if ($tableau[1] != '')
                $cond['l.date_fin <= '] = $tableau[1] ;
        }



        if($param[2]!= ''){
            $tableau = explode('_',$param[2]) ;
            if ($tableau[1] != '')
                 $cond['l.select_bus ='] = $tableau[1] ;
        }


        if($param[3]!= ''){
            $tableau = explode('_',$param[3]) ;
            if ($tableau[1] != '')
                $cond['l.etat ='] = $tableau[1] ;
        }
*/
        //$cond['l.numGIE ='] = $this->_USER->gie ;

        //$this->condition = $cond ;

        return $this->__processing();
    }

    public function getCountBusLocation() {
        $this->table = "location l";
        $this->champs = ["COUNT(l.id) AS nbre"];
        $this->condition =["l.numGIE = " => $this->_USER->gie];
        return $this->__detail()->nbre;
    }

    public function getCountBusLocationApresFiltre($param) {
        $this->table = "location l";
        $this->champs = ["COUNT(l.id) AS nbre"];

        $cond = [] ;
        if($param[0]!= ''){
            $tableau = explode('_',$param[0]) ;
            if ($tableau[0] != '')
                $cond['l.date_deb >= '] =$tableau[0] ;
        }
        if($param[1]!= ''){
            $tableau = explode('_',$param[1]) ;
            if ($tableau[0] != '')
                $cond['l.date_fin <= '] = $tableau[0] ;
        }

        if($param[2]!= ''){
            $tableau = explode('_',$param[2]) ;
            if ($tableau[0] != '')
                $cond['l.select_bus ='] = $tableau[0] ;
        }


        if($param[3]!= ''){
            $tableau = explode('_',$param[3]) ;
            if ($tableau[0] != '')
                $cond['l.etat ='] = $tableau[0] ;
        }

        $cond['l.numGIE ='] = $this->_USER->gie ;
        $this->condition = $cond ;
        return $this->__detail()->nbre;
    }


    public function getAmountBusLocation() {
        $this->table = "location l";
        $this->champs = ["SUM(l.montant_total) AS montant"];
        $condition =["l.etat = " => 3, "l.numGIE = " => $this->_USER->gie];
        $this->condition = $condition;
        return $this->__detail()->montant;
    }

    public function getAmountBus() {
        $this->table = "location l";
        $this->champs = ["SUM(l.montant_total) AS montant"];
        $condition =["l.numGIE = " => $this->_USER->gie];
        $this->condition = $condition;
        return $this->__detail()->montant;
    }

    public function getAmountBusLocationApresFiltre($param) {
        $this->table = "location l";
        $this->champs = ["SUM(l.montant_total) AS montant"];
        $cond = [] ;
        if($param[0]!= ''){
            $tableau = explode('_',$param[0]) ;
            if ($tableau[0] != '')
                $cond['l.date_deb >= '] =$tableau[0] ;
        }
        if($param[1]!= ''){
            $tableau = explode('_',$param[1]) ;
            if ($tableau[0] != '')
                $cond['l.date_fin <= '] = $tableau[0] ;
        }

        if($param[2]!= ''){
            $tableau = explode('_',$param[2]) ;
            if ($tableau[0] != '')
                $cond['l.select_bus ='] = $tableau[0] ;
        }


        if($param[3]!= ''){
            $tableau = explode('_',$param[3]) ;
            if ($tableau[0] != '')
                $cond['l.etat ='] = $tableau[0] ;
        }

        $cond['l.numGIE ='] = $this->_USER->gie ;
        $this->condition = $cond ;
        return $this->__detail()->montant;
    }

    public function getNbreReservation() {
        $this->table = "location l";
        $this->champs = ["COUNT(l.date_deb) as reservation"];
        $this->condition =["l.numGIE = " => $this->_USER->gie];
        $this->condition =["l.date_deb > " =>  Utils::getDateNow()];
        ///$this->condition =["l.etat = " => 2];
        return $this->__detail()->reservation;
    }

    public function getNbreReservationApresFiltre($param) {
        $this->table = "location l";
        $this->champs = ["COUNT(l.id) AS nbre", 'l.date_deb', "l.date_reservation"];
        if($param[0]!= ''){
            $tableau = explode('_',$param[0]) ;
           // var_dump($tableau[0]);die;
            if ($tableau[0] != '')
                $cond['l.date_deb >'] = $tableau[0] ;
                //$cond['l.date_reservation >='] = $tableau[0];
        }
        if($param[1]!= ''){
            $tableau = explode('_',$param[1]) ;
            if ($tableau[0] != '')
                $cond['l.date_deb <= '] = $tableau[0] ;
        }

        if($param[2]!= ''){
            $tableau = explode('_',$param[2]) ;
            if ($tableau[0] != '')
                $cond['l.select_bus ='] = $tableau[0] ;
        }

        if($param[3]!= ''){
            $tableau = explode('_',$param[3]) ;
            if ($tableau[0] != '')
                $cond['l.etat ='] = $tableau[0] ;
        }
        $cond['l.numGIE ='] = $this->_USER->gie ;
        $this->condition = $cond ;
        return $this->__detail()->nbre;


    }

    public function getAmountBusReserve() {
        $this->table = "location l";
        $this->champs = ["SUM(l.montant_total) AS montant"];
        $this->condition =["l.numGIE = " => $this->_USER->gie];
        $this->condition =["l.date_deb > " =>  Utils::getDateNow()];
        return $this->__detail()->montant;
    }

    public function getAmountBusReserveApresFiltre($param) {
        $this->table = "location l";
        $this->champs = ["SUM(l.montant_total) AS montant"];
        if($param[0]!= ''){
            $tableau = explode('_',$param[0]) ;
            // var_dump($tableau[0]);die;
            if ($tableau[0] != '')
                $cond['l.date_deb >'] = $tableau[0] ;
            //$cond['l.date_reservation >='] = $tableau[0];
        }
        if($param[1]!= ''){
            $tableau = explode('_',$param[1]) ;
            if ($tableau[0] != '')
                $cond['l.date_deb <= '] = $tableau[0] ;
        }

        if($param[2]!= ''){
            $tableau = explode('_',$param[2]) ;
            if ($tableau[0] != '')
                $cond['l.select_bus ='] = $tableau[0] ;
        }

        if($param[3]!= ''){
            $tableau = explode('_',$param[3]) ;
            if ($tableau[0] != '')
                $cond['l.etat ='] = $tableau[0] ;
        }
        $cond['l.numGIE ='] = $this->_USER->gie ;
        $this->condition = $cond ;
        return $this->__detail()->montant;
    }
    /*
     * Liste des clients des bus loués
     */

    public function listeClientBusLoues()
    {
        $this->table = "location l";
        $this->champs = ["l.id","l.nom_locataire","l.prenom_locataire","l.piece_identite","l.intermediaire","l.telephone","l.piece_identite as nbre_valide","l.piece_identite as nbre_annule" ,"l.etat"];
        $this->group =["l.piece_identite"] ;
        return $this->__processing();
    }


}