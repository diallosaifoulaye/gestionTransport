<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 31/08/2018
 * Time: 09:43
 */

namespace app\models;

use app\core\BaseModel;

class CoderetourModel extends BaseModel
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
     * Ajout Code retour Web Service
     */
    public function insertCodeRetour($param)
    {
        $this->table = "sva_code_retour";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**********verifier Code**********/
    public function verifCodeModel($code)
    {
        $this->table = "sva_code_retour";
        $this->champs = ["rowid"];
        $this->condition=["code ="=>$code];
        $count = count($this->__select());
        if($count > 0) return 1;
        else return -1;
    }
    /**
     * Processing Code retour Web Service
     */
    public function getAllCodeRetour($param = null)
    {
        $this->table = "sva_code_retour as c";
        $this->champs = ["c.rowid","c.code","c.message_fr","c.message_en","c.etat"];
        $this->condition = ["c.fk_webservice =" => $param[0]];
        return $this->__processing();
    }
    /**
     * Get Code retour Web Service
     */
    public function getCodeRetour($param = null)
    {
        $this->table = "sva_code_retour";
        $this->__addParam($param);
        return $this->__select();
    }
    /**
     * Détail Code retour Web Service
     */
    public function getOneCodeRetour($param = null)
    {
        $this->table = "sva_code_retour as c";
        $this->champs = ["c.rowid","c.code","c.message_fr","c.message_en","c.user_creation","c.date_creation","c.user_modification","c.date_modification","c.fk_webservice","ws.label","c.etat"];
        $this->jointure = [" 
        INNER JOIN sva_webservice as ws ON c.fk_webservice = ws.rowid
        "];
        $this->condition = ["c.fk_webservice =" => $param[0]];
        $this->__addParam($param);
        return $this->__detail();
    }
    /**
     * Modification Code retour Web Service
     */
    public function updateCodeRetour($param)
    {
        $this->table = "sva_code_retour";
        $this->__addParam($param);
        return $this->__update();
    }
    /**
     * Suppression Code retour Web Service
     */
    public function deleteCodeRetour($param)
    {
        $this->table = "sva_code_retour";
        $this->__addParam($param);
        return $this->__delete();
    }


}