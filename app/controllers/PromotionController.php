<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 21:11
 */

namespace app\controllers;

use app\core\BaseController;
use app\models\PromotionModel;
use app\core\Session;
use app\core\Utils;

class PromotionController extends BaseController
{
    private $promotionModel;
    public function __construct()
    {
        parent::__construct();
        $this->promotionModel = new PromotionModel();
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar_admin"]);

    }

    public function ajoutPromotionModal(){
        //var_dump(1);die;

        //$this->views->getTemplate('promotion/nouvellePromotion');
        $this->modal('promotion/ajoutPromotionModal');
    }

    public function ajoutPromotion(){
        $result = $this->promotionModel->insertPromotion(["champs" => $this->paramPOST]);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succesSavePromotion"]]);
        else Utils::setMessageALert(["danger", $this->lang["echecSavePromotion"]]);
        Utils::redirect("promotion", "listePromotion");

    }

    public function listePromotion__(){
        $this->views->getTemplate('promotion/listePromotion');

    }
        public function afficheListePromotion__()
        {
            if ($this->_USER) {
                if ($this->_USER->admin == 1 || \app\core\Utils::getModel('utilsateur')->__authorized($this->_USER->idprofil, 'administration', 'modifUtilisateurModal') > 0) {
                    $param = [

                        "button" => [
                            "default" => [
                                //["champ" => "etat","val" => ["0" => ["bus/activateCat/","fa fa-toggle-off"],"1" => ["bus/deactivateCat/", "fa fa-toggle-on"]]],
                                //["bus/removeCategorie/", "fa fa-trash"],
                                //["bus/detailBus/", "fa fa-search"]
                            ],
                            "modal" => [
                                ["promotion/modifPromotionModal", "promotion/modifPromotionModal", "fa fa-edit"],

                            ]
                            //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                        ],
                        "tooltip" => [
                            "modal" => [$this->lang['Modifier'],["champ"=>"_etat_","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]]],
                            "default" => [["champ"=>"etat","val"=>["0"=>$this->lang['Activer'],"1"=>$this->lang['Désactiver']]], $this->lang['Supprimer'],$this->lang['Detail']]
                        ],
                        "classCss" => [
                            "modal" => [],
                            "default" => ["confirm","confirm"]
                        ],
                        "attribut" => [],
                        "args" => null,
                        "dataVal" => [
                            //["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['Desactive']." </i>"], "1" => ["<i class='text-success'>".$this->lang['Active']."</i>"]]]
                        ],
                        "fonction" => [
                            "etat"=>"getEtatPromo"

                        ]
                    ];
                    $this->processing($this->promotionModel, 'getAllPromotion', $param);
                } else {
                    $param = [
                        "button" => [
                            "modal" => [
                                ["bus/modifCategorieModal", "bus/modifCategorieModal", "fa fa-edit"],

                            ],
                            "default" => [
                                ["bus/detailBus/", "fa fa-search"]
                            ]
                            //"custom" => ["<span style='color: red;'>test</span>",["champ"=>"nom","val"=>["Faye"=>"<span style='color: red;'>faye</span>"]]]
                        ],
                        "tooltip" => [],
                        "classCss" => [
                            "modal" => [],
                            "default" => ["confirm"]
                        ],
                        "attribut" => [],
                        "args" => null,
                        "dataVal" => [],
                        "fonction" => []
                    ];
                    $this->processing($this->promotionModel, 'getAllPromotion', $param);

                }

            }
        }

    public function modifPromotionModal(){
        $data['promotion'] = $this->promotionModel->getOnePromotion(["condition" => ["id = " => $this->paramGET[2]]]);
        $this->views->setData($data);
        $this->modal();
    }
    public function updatePromotion(){
        $data['condition'] = ["id = " => base64_decode($this->paramPOST['id'])];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->promotionModel->updatePromotion($data);
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succesUpdatePromotion"]]);
        else Utils::setMessageALert(["danger",$this->lang["echecUpdatePromotion"]]);
        Utils::redirect("promotion", "listePromotion");
    }
}

