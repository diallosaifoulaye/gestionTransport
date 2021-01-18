<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 31/08/2018
 * Time: 09:43
 */

namespace app\models\admin;

use app\core\BaseModel;

class MessageModel extends BaseModel
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
     * Ajout Message
     */
    public function insertMessage($param)
    {
        $this->table = "sva_messenger";
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * Processing Message
     */
    public function getAllMessage($param = null)
    {
        $this->table = "sva_messenger as f";
        $this->champs = ["f.id as rowid", "f.expediteur", "f.txt_messenger", "m.libelle", "f.etat"];
        $this->jointure = [" INNER JOIN module as m ON f.fk_module = m.id"];
        return $this->__processing();
    }


    /**
     * Get module
     */
    public function getMessage($param = null)
    {
        $this->table = "sva_messenger";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * Détail Message
     */
    public function getOneMessage($param = null)
    {
        $this->table = "sva_messenger as f";
        $this->champs = ["f.id", "f.expediteur", "f.txt_messenger", "m.libelle", "f.etat"];
        $this->jointure = [" INNER JOIN module as m ON f.fk_module = m.id"];
        $this->__addParam($param);
        return $this->__detail();
    }

    /**
     * Modification Message
     */
    public function updateMessage($param)
    {
        $this->table = "sva_messenger";
        $this->__addParam($param);
        return $this->__update();
    }

    /**
     * Suppression Message
     */
    public function deleteMessage($param)
    {
        $this->table = "sva_messenger";
        $this->__addParam($param);
        return $this->__delete();
    }


}