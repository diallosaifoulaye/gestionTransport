<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class DisponibiliteModel extends BaseModel
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


    /*********Liste Services************/
    public function  allService($param)
    {
        $this->table = "sva_service_sunusva";
        $this->champs = ["rowid", "label"];
        $this->__addParam($param);
        return $this->__select();
    }

    /*********Liste Pays************/
    public function getPays($param = null)
    {
        $this->table = "sva_pays";
        $this->champs = ["rowid", "label"];
        $this->__addParam($param);
        return $this->__select();
    }

    /************* Services Disponibles Par Pays ***************/
    public function allServiceDispoParPays($param)
    {
        $messervicesDispo = array();
        $this->table = "sva_disponibilite";
        $this->champs =['fk_pays'];
        $this->__addParam($param);
        $a = $this->__select();
        foreach($a as $t){
            array_push($messervicesDispo, $t->fk_pays);
        }
        return $messervicesDispo;
    }

    /***********SUPPRIMER SERVICE DANS UN PAYS*****/
    public function deleteDisponibiliteService($param)
    {
        $this->table = "sva_disponibilite";
        $this->__addParam($param);
        return $this->__delete();
    }

    /*********************RENDRE UN SERVICE DISPONIBLE DANS UN PAYS****/
    public function addService($pays,$service,$user_creation)
    {
        $this->table = "sva_disponibilite";
        $array = ['fk_pays'=>$pays, 'fk_service'=>$service, 'etat'=>1, 'user_creation'=>$user_creation, 'date_creation'=>date('Y-m-d H:i:s')];
        $this->champs = $array;
        return $this->__insert();
    }

    /***************** Services disponibles dans les pays *************/
    public function getServiceDispoInCountry($param)
    {
        $this->table = "sva_disponibilite as d";
        $this->champs = ["d.rowid", "s.label as service", "p.label as pays", "d.etat as _etat_"];
        $this->jointure = [
                        "INNER JOIN sva_pays as p ON d.fk_pays = p.rowid",
                        "INNER JOIN sva_service_sunusva as s ON d.fk_service = s.rowid"
        ];
        $this->condition = ["d.fk_service =" => $param[0]];
        return $this->__processing();
    }

}