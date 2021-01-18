<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 31/08/2018
 * Time: 09:43
 */

namespace app\models;

use app\core\BaseModel;
use app\core\Utils;

class ErreurwebserviceModel extends BaseModel
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
     * Ajout Erreur Web Service
     */
    public function insertErreurWebService($param)
    {
        //var_dump($param); die();
        $this->table = "sva_erreur_webservice";
        $code_genere = Utils::genererReference();
        $code = $param['fk_categorie'];
        $code = $code.$code_genere;
        unset($param['fk_categorie']);
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Processing Erreur Web Service
     */
    public function getAllErreurWebService($param)
    {
        //return $param[0];
        $this->table = "sva_erreur_webservice as ws";
        $this->champs = ["ws.id","ws.code","ws.message_fr","ws.message_en", "ws.etat as _etat_"];
        $this->condition = ["ws.fk_service =" => $param[0]];
        return $this->__processing();
    }
    /**
     * Get Erreur Web Service
     */
    public function getErreurWebService($param = null)
    {
        $this->table = "sva_erreur_webservice";
        $this->__addParam($param);
        return $this->__select();
    }
    /**
     * Détail Erreur Web Service
     */
    public function getOneErreurWebService($param = null)
    {
        $this->table = "sva_erreur_webservice as ws";
        $this->champs = ["ws.id","ws.code","ws.message_fr","ws.message_en","ws.fk_service","ws.user_creation","ws.date_creation","ws.user_modification","ws.date_modification", "ws.etat"];
        $this->condition = ["ws.fk_service =" => $param[0]];
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Erreur Web Service
     */
    public function updateErreurWebService($param)
    {
        $this->table = "sva_erreur_webservice";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Erreur Web Service
     */
    public function deleteErreurWebService($param)
    {
        $this->table = "sva_erreur_webservice";
        $this->__addParam($param);
        return $this->__delete();
    }


}