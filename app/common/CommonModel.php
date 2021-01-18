<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 31/01/2018
 * Time: 12:52
 */

namespace app\common;

trait CommonModel
{
    /**
     * Créer ici des méthodes appelable par toutes les classes models.
     */

    /**
     * Verificationde lexistance emal user des Droit
     */
    /*public function VerifEmail($param)
    {
        $this->table = $param[0];
        $this->condition=["".$param[1]."="=> $param[2] ];
        return $this->__detail();
    }*/
    /**
     * Verification de l'existance email user des Droits
     */


    public function VerifEmail($param,$vmail)
    {
        $this->table = $param[0];
        $this->condition=["".$param[1]."="=> $vmail];
        return $this->__detail();


    }




    public function set($param)
    {
        $this->__addParam($param);
        return (isset($param['champs']) && isset($param['condition'])) ? $this->__update() : ((!isset($param['champs']) && isset($param['condition'])) ? $this->__delete() : $this->__insert());
    }

    public function get($param)
    {
        $this->__addParam($param);
        return $this->__select();
    }

}