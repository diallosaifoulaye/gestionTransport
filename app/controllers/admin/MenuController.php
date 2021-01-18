<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 21:11
 */

namespace app\controllers\admin;

use app\core\BaseController;
use app\core\Session;
use app\core\Utils;

class MenuController extends BaseController
{
    private $menuModels;

    public function __construct()
    {
        parent::__construct();
        $this->menuModels = $this->model("admin");
    }

    public function index__()
    {
        $this->views->getPage('home/menu');
    }
   public function menu__()
    {
        $data['nbre'] = $this->menuModels->nbreGie();
        $data['nbreBus'] = $this->menuModels->nbreBus();

        $this->views->setData($data);

        $this->views->getPage('home/menu');
    }

    public function firstConnect__()
    {
        $this->views->getPage('home/first');
    }

}