<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 17/08/2017
 * Time: 11:01
 */

namespace app\core;

use app\controllers\WebserviceClientController;
use Jacwright\RestServer\RestServer;

abstract class ApiServer
{
    protected $serv;
    protected $apiClient;
    protected $token;
    protected static $paramGET  = [];
    protected static $paramPOST = [];
    protected static $paramFILE = [];

    public function __construct($type = null)
    {
        $this->token = $_SERVER['HTTP_AUTHORIZATION_TOKEN'];
        $this->appConfig = (object)\parse_ini_file(ROOT . 'config/app.config.ini');
        if($this->appConfig->use_api_client == "1") $this->apiClient = new WebserviceClientController();
        if($type == null) {
            try{
                $mode = (ENV == "PROD") ? 'production' : 'debug';
                $this->serv = new RestServer($mode);
                $_GET['format'] = "json";
            }catch(\Exception $ex) {
                $this->serv->setStatus(500);
                $this->serv->sendData(['error' => ['code' => 500, 'message' => 'Internal Server Error']]);
            }
        }
    }

    /**
     * @param $class
     * @return string
     */
    public function setClass($class)
    {
        $class = explode("::", $class)[1];
        return "app\webservice\\".$class;
    }

    /**
     * @param $patch
     * @return string
     */
    public function setPatch($patch)
    {
        $patch = explode("::", $patch)[1];
        return "webserviceServer/".$patch;
    }

    /**
     * @param mixed $paramGET
     */
    public function setParamGET($paramGET)
    {
        unset($paramGET[0]);
        self::$paramGET = $paramGET;
    }

    /**
     * @param mixed $paramPOST
     */
    public function setParamPOST($paramPOST)
    {
        self::$paramPOST = $paramPOST;
        unset($_POST);
    }

    /**
     * @param mixed $paramFILE
     */
    public function setParamFILE($paramFILE)
    {
        self::$paramFILE = $paramFILE;
    }

    /**
     * @param $model
     * @return mixed
     */
    protected function model($model)
    {
        $model = Prefix_Model . ucfirst($model) . 'Model';
        return new $model();
    }

}