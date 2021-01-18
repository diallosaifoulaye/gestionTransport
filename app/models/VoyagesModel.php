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

class VoyagesModel extends BaseModel
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
            'concat(c.nom," ",c.prenom) as controleur',"t.ligne as trajet","v.date_voyage","v.etat"];
        $this->jointure = [
            "INNER JOIN bus as b ON v.bus_id = b.id",
            "INNER JOIN employe as e ON v.conducteur_id = e.id",
            "INNER JOIN receveur as r ON v.receveur_id = r.id",
            "INNER JOIN controleur as c ON v.controleur_id = c.id",
            "INNER JOIN trajet as t ON v.trajet_id = t.id",
            "INNER JOIN gie as g ON v.numGie= g.id"
        ];
       $this->condition = ['v.numGie =' => $param->gie];
        return $this->__processing();
    }

    public function getOneVoyages($param = null)
    {
        $this->table = "voyage v";
        $this->champs = ["t.id","t.ligne","t.lieu_depart","t.lieu_arrive","t.nombre_section","t.ecart_section","t.prix_base","t.etat"];
        $this->jointure = [
           " INNER JOIN gie as g ON t.numGie = g.id"
        ];
        $this->condition = ['t.numGie =' => $param->gie];
        $this->__addParam($param);
        return $this->__detail();
    }

}