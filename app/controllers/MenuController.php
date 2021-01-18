<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 21:11
 */

namespace app\controllers;

use app\core\BaseController;
use app\core\Session;
use app\core\Utils;

class MenuController extends BaseController
{
    private $menuModels;

    public function __construct()
    {

        parent::__construct();
        $this->menuModels = $this->model("home");
        // $this->views->initTemplate(["header"=>"header","footer"=>"footer"]);
    }

    public function index__()
    {
        $this->views->getPage('espace/home/menu');

    }
   public function menu__()
    {
        $data['nbre'] = $this->menuModels->nbreBus();
        $data['nbreChauffeur'] = $this->menuModels->nbreChauffeur();
        $data['nbreReceveur'] = $this->menuModels->nbreReceveur();
        $data['nbreControleur'] = $this->menuModels->nbreControleur();
        $data['montant'] = $this->menuModels->getAllTransactionsJournalieres();
        $data['nbreTransaction'] = $this->menuModels->nbreTransactionJour();

        $this->views->setData($data);

        $this->views->getPage('espace/home/menu');

    }

    public function firstConnect__()
    {
        $this->views->getPage('espace/home/first');

    }


}