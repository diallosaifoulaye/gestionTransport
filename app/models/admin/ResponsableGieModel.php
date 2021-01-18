<?php

namespace app\models\admin;

use app\core\BaseModel;

class ResponsableGieModel extends BaseModel
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
     * Ajout Gie
     */

    public function insertRespo($param)
    {
        $this->table = "responsableGie";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Lister gie
     */

    public function getAllRes($param = null)
    {

        $this->table = "responsableGie r";
        $this->champs = ["r.id","r.nom","r.prenom","r.telephone","r.etat"];
        //$this->jointure = ["INNER JOIN responsableGie as r ON g.id_responsable = r.id"];
        return $this->__processing();
    }



    public function AllRes($param = null)
    {
        $this->table = "responsableGie";
        $this->champs = ["id","nom","prenom","email","telephone","etat"];
        $this->__addParam($param);
        return $this->__select();
    }

    public function updateRespo($param)
    {
        $this->table = "responsableGie";
        $this->__addParam($param);
        return $this->__update();
    }

    public function deleteRespo($param)
    {
        $this->table = "responsableGie";
        $this->__addParam($param);
        return $this->__delete();
    }

    public function getRespo($param = null)
    {
        $this->table = "responsableGie";
        $this->__addParam($param);
        return $this->__select();
    }

    public function getOneRespo($param = null)
    {
        $this->table = "responsableGie r";
        $this->champs = ["r.id","r.nom","r.prenom","r.email","r.telephone","r.photo","r.etat"];
        //$this->jointure = ["INNER JOIN categorie as c ON b.categorie = c.id"];

        $this->__addParam($param);
        return $this->__detail();
    }

    public function updateResponDetail($param)
    {
        $this->table = "responsableGie";
        $this->__addParam($param);
        return $this->__update();
    }

    public function updatePhoto($param){

        $this->table = "responsableGie";
        $this->__addParam($param);
        return $this->__update();

    }

    public function verifEmailModel($email)
    {
        $this->table = "responsableGie";
        $this->champs = ["id"];
        $this->condition=["email ="=>$email];
        $count = count($this->__select());
        if($count > 0) return 1;
        else return -1;
    }

}

