<?php
/**
 * Created by PhpStorm.
 * User: Seyni Faye
 * Date: 02/07/2018
 * Time: 11:49
 */

namespace app\webservice;

use app\core\ApiServer;
use app\core\Utils;
use app\core\TokenJWT;
use Jacwright\RestServer\RestException;


class april extends ApiServer
{

    private $model;
    private $partnaire;
    private $key;
    private $lien;
    private $identifer;
    private $transactionModel;
    public function __construct()
    {
        parent::__construct(__CLASS__);
        $this->model = $this->model("service");
        $this->partnaire = $this->model("partenaire");
        $this->transactionModel = $this->model("transaction");
        $infos = $this->model->getApi(["condition" => ["rowid = " => 1]]);
        $this->key = $infos->cle;
        $this->lien = $infos->lien;
        $this->identifer = $infos->identification;
    }

    /********************verification token***********************************/
    function authorize(){
        //return (TokenJWT::verif($this->token, TOKEN_KEY));
        $result = intval(TokenJWT::verif($this->token, TOKEN_KEY));
        if($result == -1){
            throw new RestException(401, "Token expiré");
            return false;
        }elseif($result == -2){
            throw new RestException(401, "Token invalide");
            return false;
        }else return true;
    }

    /**
     * Authentification d'un partenaire
     *
     * params : username et password
     *
     * @url POST /authentifier
     *
     * @noAuth
     */
    /********************* AUTHENTIFICATION PARTENAIRE **************************/
    public function authentifier()
    {
        $username = parent::$paramPOST['username'];
        $password = parent::$paramPOST['password'];
        $verif_partenaire = $this->partnaire->checkPartenaireExiste($username, $password);
        if(intval($verif_partenaire) > 0)
        {
            $param = [
                "id"=>intval($verif_partenaire)
            ];
            $new_token = TokenJWT::encode($param,TOKEN_KEY,1);
            return array('token'=>$new_token);
        }
        elseif($verif_partenaire == -1)
        {
            return array('erreurCode'=>9003, 'erreurMessage'=>'Partenaire non activé');
        }
        else return array('erreurCode'=>9004, 'erreurMessage'=>'username ou mot de passe incorrect');
    }

    /**
     * Gets villes list
     *
     * @url GET /GetVillesApril
     */
    public function GetVillesApril()
    {
        /*$verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('GetVillesApril');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){*/
            $url =$this->lien."auth/token";
            $url1 = $this->lien."villes";
            $token = Utils::auth2($this->identifer,$this->key,$url);
            $obj = json_decode($token);
            if(!empty($obj)){
                $token1 = $obj->{'token'};
                $villes = Utils::Method_GET($url1,$this->key,$token1);
                $data  = json_decode($villes);
                $data1 = $data->{'data'};
                if($data1 == null){
                    $return = array(
                        'code'=>'6021',
                        'message'=>'Aucune ville trouvée'
                    );
                    return $return;
                }else{
                    $return = array(
                        'code'=>'6020',
                        'data'=>$data1
                    );
                    return $return;
                }

            }else{
                $obj = array(
                    'code'=>'6011',
                    'message'=>'token incorrect'
                );
                return $obj;
            }
        /*}
        else
        {
            return array('errorCode' => '#001','errorMessage' => 'Partenaire non autorisé.');
        }*/

    }

    /**
     * Get one ville
     *
     * @url GET /GetOneVilleApril
     */
    public function GetOneVilleApril()
    {
        /*$verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('GetOneVilleApril');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){*/
            $id=parent::$paramGET["id"];
            $url =$this->lien."auth/token";
            $url1 = $this->lien."villes/".$id;
            $token = Utils::auth2($this->identifer,$this->key,$url);
            $obj = json_decode($token);
            if(!empty($obj)){
                $token1 = $obj->{'token'};
                $villes = Utils::Method_GET($url1,$this->key,$token1);
                $data  = json_decode($villes);
                if($data == null){
                    $return = array(
                        'code'=>'6021',
                        'message'=>'Aucune ville trouvée'
                    );
                    return $return;
                }else{
                    $return = array(
                        'code'=>'6020',
                        'data'=>$data
                    );
                    return $return;
                }

            }else{
                $obj = array(
                    'code'=>'6011',
                    'message'=>'token incorrect'
                );
                return $obj;

            }
        /*}
        else
        {
            return array('errorCode' => '#001','errorMessage' => 'Partenaire non autorisé.');
        }*/


    }

    /**
     * Gets genres list
     *
     * @url GET /GetGenres
     */
    public function GetGenres()
    {
        /*$verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('GetGenres');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){*/
            $url =$this->lien."auth/token";
            $url1 = $this->lien."genres/";
            $token = Utils::auth2($this->identifer,$this->key,$url);
            $obj = json_decode($token);
            if(!empty($obj)){
                $token1 = $obj->{'token'};
                $genres = Utils::Method_GET($url1,$this->key,$token1);
                $data  = json_decode($genres);
                if($data == null){
                    $return = array(
                        'code'=>'6031',
                        'message'=>'Aucune civilité trouvée'
                    );
                    return $return;
                }else{
                    $data1 = $data->{'data'};
                    $return = array(
                        'code'=>'6030',
                        'data'=>$data1
                    );
                    return $return;
                }

            }else{
                $obj = array(
                    'code'=>'6011',
                    'message'=>'token incorrect'
                    );
                return $obj;

            }
        /*}
        else
        {
            return array('errorCode' => '#001','errorMessage' => 'Partenaire non autorisé.');
        }*/
    }

    /**
     * Get one genre
     *
     * @url GET /GetOneGenre
     */

    public function GetOneGenre()
    {
        /*$verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('GetOneGenre');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){*/
            $id=parent::$paramGET["id"];
            $url =$this->lien."auth/token";
            $url1 = $this->lien."genres/".$id;
            $token = Utils::auth2($this->identifer,$this->key,$url);
            $obj = json_decode($token);
            if(!empty($obj)){
                $token1 = $obj->{'token'};
                $genres = Utils::Method_GET($url1,$this->key,$token1);
                $data  = json_decode($genres);
                if($data == null){
                    $return = array(
                        'code'=>'6031',
                        'message'=>'Aucune civilité trouvée'
                    );
                    return $return;
                }else{
                    $return = array(
                        'code'=>'6030',
                        'data'=>$data
                    );
                    return $return;
                }

            }else{
                $obj = array(
                    'code'=>'6011',
                    'message'=>'token incorrect'
                    );
                return $obj;

            }
        /*}
        else
        {
            return array('errorCode' => '#001','errorMessage' => 'Partenaire non autorisé.');
        }*/


    }

    /**
     * create person
     *
     * @url POST /createPerson
     */

    public function createPerson()
    {
        $verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('createPerson');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){
            $donnee = array(
                'genre' => parent::$paramPOST["genre"],
                'nom' => parent::$paramPOST["nom"],
                'prenoms' => parent::$paramPOST["prenoms"],
                'adresse' => parent::$paramPOST["adresse"],
                'ville' => parent::$paramPOST["ville"],
                'quartier' => parent::$paramPOST["quartier"],
                'telephone_1' => parent::$paramPOST["telephone"]
            );
            if(isset(parent::$paramPOST["genre"]) && isset(parent::$paramPOST["nom"]) && isset(parent::$paramPOST["prenoms"]) && isset(parent::$paramPOST["adresse"]) && isset(parent::$paramPOST["ville"]) && isset(parent::$paramPOST["quartier"]) && isset(parent::$paramPOST["telephone"]) )
            {
                $url =$this->lien."auth/token";
                $url1 = $this->lien."personne/";
                $token = Utils::auth2($this->identifer,$this->key,$url);
                $obj = json_decode($token);
                if(!empty($obj)){
                    $token1 = $obj->{'token'};
                    $person = Utils::Method_POST($donnee,$url1,$this->key,$token1);
                    $data  = json_decode($person);

                        if($data == null)
                        {
                            $return = array(
                                'code'=>'6041',
                                'message'=>'Erreur insertion'
                            );
                            return $return;
                        }
                        else
                        {
                            $return = array(
                                'code'=>'6040',
                                'data'=>$data
                            );
                            return $return;
                        }

                }
                else
                {
                    $obj = array(
                        'code'=>'6011',
                        'message'=>'token incorrect'
                        );
                    return $obj;

                }
            }
            else
            {
                $obj = array(
                    'code'=>'6042',
                    'message'=>'Veuillez renseigner tous les champs!'
                );
                return $obj;
            }
        }
        else
        {
            return array('errorCode' => '#001','errorMessage' => 'Partenaire non autorisé.');
        }


    }

    /**
     * Gets assureur list
     *
     * @url GET /GetAssureurs
     */

    public function GetAssureurs()
    {
        /*$verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('GetAssureurs');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){*/
            $url =$this->lien."auth/token";
            $url1 = $this->lien."assureurs/";
            $token = Utils::auth2($this->identifer,$this->key,$url);
            $obj = json_decode($token);
            if(!empty($obj)){
                $token1 = $obj->{'token'};
                $assureur = Utils::Method_GET($url1,$this->key,$token1);
                $data  = json_decode($assureur);
                if($data == null){
                    $return = array(
                        'code'=>'6051',
                        'message'=>'Aucun assureur trouvé'
                    );
                    return $return;
                }else{
                    $data1 = $data->{'data'};
                    $return = array(
                        'code'=>'6050',
                        'data'=>$data1
                    );
                    return $return;
                }

            }else{
                $obj = array(
                    'code'=>'6011',
                    'message'=>'token incorrect'
                );
                return $obj;

            }
        /*}
        else
        {
            return array('errorCode' => '#001','errorMessage' => 'Partenaire non autorisé.');
        }*/


    }

    /**
     * Get one assureur
     *
     * @url GET /GetOneAssureur
     */

    public function GetOneAssureur()
    {
        /*$verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('GetOneAssureur');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){*/
            $id=parent::$paramGET["id"];
            $url =$this->lien."auth/token";
            $url1 = $this->lien."assureur/".$id;
            $token = Utils::auth2($this->identifer,$this->key,$url);
            $obj = json_decode($token);
            if(!empty($obj)){
                $token1 = $obj->{'token'};
                $assureur = Utils::Method_GET($url1,$this->key,$token1);
                //return $assureur;
                $data  = json_decode($assureur);
                if($data == null){
                    $return = array(
                        'code'=>'6051',
                        'message'=>'Aucun assureur trouvé'
                    );
                    return $return;
                }else{
                    $return = array(
                        'code'=>'6050',
                        'data'=>$data
                    );
                    return $return;
                }

            }else{
                $obj = array(
                    'code'=>'6011',
                    'message'=>'token incorrect'
                );
                return $obj;

            }
        /*}
        else
        {
            return array('errorCode' => '#001','errorMessage' => 'Partenaire non autorisé.');
        }*/


    }

    /**
     * create person
     *
     * @url POST /createClientApril
     */

    public function createClientApril()
    {
        $verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('createClientApril');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){
        $donnee = array(
            'origine_id' => parent::$paramPOST["origine_id"],
            'type_id' => parent::$paramPOST["type_id"],
            'personne_id' => parent::$paramPOST["personne_id"]
        );
            if(isset(parent::$paramPOST["origine_id"]) && isset(parent::$paramPOST["type_id"]) && isset(parent::$paramPOST["personne_id"]))
            {
                $url =$this->lien."auth/token";
                $url1 = $this->lien."client/";
                $token = Utils::auth2($this->identifer,$this->key,$url);
                $obj = json_decode($token);
                if(!empty($obj)){
                    $token1 = $obj->{'token'};
                    $person = Utils::Method_POST($donnee,$url1,$this->key,$token1);
                    $data  = json_decode($person);
                        if($data == null)
                        {
                            $return = array(
                                'code'=>'6051',
                                'message'=>'Erreur insertion'
                            );
                            return $return;
                        }
                        else
                        {
                            $return = array(
                                'code'=>'6050',
                                'data'=>$data
                            );
                            return $return;
                        }
                }
                else
                {
                    $obj = array(
                        'code'=>'6011',
                        'message'=>'token incorrect'
                    );
                    return $obj;

                }
            }
            else
            {
                $obj = array(
                    'code'=>'6052',
                    'message'=>'Veuillez renseigner tous les champs!'
                );
                return $obj;
            }
        }
        else
        {
            return array('errorCode' => '#001','errorMessage' => 'Partenaire non autorisé.');
        }


    }

    /**
     * Gets client list
     *
     * @url GET /getClientApril
     */

    public function getClientApril()
    {
        /*$verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('getClientApril');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){*/
            $url =$this->lien."auth/token";
            $url1 = $this->lien."client/";
            $token = Utils::auth2($this->identifer,$this->key,$url);
            $obj = json_decode($token);
            if(!empty($obj)){
                $token1 = $obj->{'token'};
                $client = Utils::Method_GET($url1,$this->key,$token1);
                $data  = json_decode($client);
                if($data == null){
                    $return = array(
                        'code'=>'6051',
                        'message'=>'Aucun client trouvé'
                    );
                    return $return;
                }else{
                    $data1 = $data->{'data'};
                    $return = array(
                        'code'=>'6050',
                        'data'=>$data1
                    );
                    return $return;
                }

            }else{
                $obj = array(
                    'code'=>'6011',
                    'message'=>'token incorrect'
                );
                return $obj;

            }
        /*}
        else
        {
            return array('errorCode' => '#001','errorMessage' => 'Partenaire non autorisé.');
        }*/


    }

    /**
     * Get one client
     *
     * @url GET /getOneClientApril
     */

    public function getOneClientApril()
    {
        /*$verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('getOneClientApril');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){*/
            $id=parent::$paramGET["id"];
            $url =$this->lien."auth/token";
            $url1 = $this->lien."client/".$id;
            $token = Utils::auth2($this->identifer,$this->key,$url);
            $obj = json_decode($token);
            if(!empty($obj)){
                $token1 = $obj->{'token'};
                $assureur = Utils::Method_GET($url1,$this->key,$token1);
                $data  = json_decode($assureur);
                if($data == null){
                    $return = array(
                        'code'=>'6051',
                        'message'=>'Aucun client trouvé'
                    );
                    return $return;
                }else{
                    $return = array(
                        'code'=>'6050',
                        'data'=>$data
                    );
                    return $return;
                }

            }else{
                $obj = array(
                    'code'=>'6011',
                    'message'=>'token incorrect'
                );
                return $obj;

            }
        /*}
        else
        {
            return array('errorCode' => '#001','errorMessage' => 'Partenaire non autorisé.');
        }*/
    }

    /**
     * Gets puissance_fiscales list
     *
     * @url GET /puissance_fiscales_auto
     */

    public function puissance_fiscales_auto()
    {
        /*$verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('puissance_fiscales_auto');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){*/
            $url =$this->lien."auth/token";
            $url1 = $this->lien."auto/puissances_fiscales";
            $token = Utils::auth2($this->identifer,$this->key,$url);
            $obj = json_decode($token);
            if(!empty($obj)){
                $token1 = $obj->{'token'};
                $client = Utils::Method_GET($url1,$this->key,$token1);
                $data  = json_decode($client);
                if($data == null){
                    $return = array(
                        'code'=>'6051',
                        'message'=>'Aucune puissance fiscale trouvé'
                    );
                    return $return;
                }else{
                    $return = array(
                        'code'=>'6050',
                        'data'=>$data
                    );
                    return $return;
                }

            }else{
                $obj = array(
                    'code'=>'6011',
                    'message'=>'token incorrect'
                );
                return $obj;

            }
        /*}
        else
        {
            return array('errorCode' => '#001','errorMessage' => 'Partenaire non autorisé.');
        }*/


    }

    /**
     * Gets marques_auto list
     *
     * @url GET /marques_auto_April
     */

    public function marques_auto_April()
    {
        /*$verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('marques_auto_April');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){*/
            $identifer ='311f9e8368f470edb94b';
            $key ='d47aa6470be64485f78f6ff27e633b59d62fcf73087cbeb8f74fbd7aad42f79d2969fa20161045cf705ee3ec44ee8b3860d3b18a36c53165646eaf95d51c4ab7';
            $url ="https://www.api-sn.aprilapps.com/api/auth/token";
            $url1 = "https://www.api-sn.aprilapps.com/api/auto/marques";
            $token = Utils::auth2($identifer,$key,$url);
            $obj = json_decode($token);
            if(!empty($obj)){
                $token1 = $obj->{'token'};
                $client = Utils::Method_GET($url1,$key,$token1);
                $data  = json_decode($client);
                if($data == null){
                    $return = array(
                        'code'=>'6051',
                        'message'=>'Aucune marques trouvé'
                    );
                    return $return;
                }else{
                    $return = array(
                        'code'=>'6050',
                        'data'=>$data
                    );
                    return $return;
                }

            }else{
                $obj = array(
                    'code'=>'6011',
                    'message'=>'token incorrect'
                );
                return $obj;
            }
        /*}
        else
        {
            return array('errorCode' => '#001','errorMessage' => 'Partenaire non autorisé.');
        }*/


    }

    /**
     * Get one client
     *
     * @url GET /getOnemarques_auto_April
     */

    public function getOnemarques_auto_April()
    {
        /*$verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('getOnemarques_auto_April');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){*/
            $id=parent::$paramGET["id"];
            $identifer ='311f9e8368f470edb94b';
            $key ='d47aa6470be64485f78f6ff27e633b59d62fcf73087cbeb8f74fbd7aad42f79d2969fa20161045cf705ee3ec44ee8b3860d3b18a36c53165646eaf95d51c4ab7';
            $url ="https://www.api-sn.aprilapps.com/api/auth/token";
            $url1 = "https://www.api-sn.aprilapps.com/api/auto/marques/".$id;
            $token = Utils::auth2($identifer,$key,$url);
            $obj = json_decode($token);
            if(!empty($obj)){
                $token1 = $obj->{'token'};
                $assureur = Utils::Method_GET($url1,$key,$token1);
                $data  = json_decode($assureur);
                if($data == null){
                    $return = array(
                        'code'=>'6051',
                        'message'=>'Aucune marques trouvé'
                    );
                    return $return;
                }else{
                    $return = array(
                        'code'=>'6050',
                        'data'=>$data
                    );
                    return $return;
                }

            }else{
                $obj = array(
                    'code'=>'6011',
                    'message'=>'token incorrect'
                );
                return $obj;

            }
        /*}
        else
        {
            return array('errorCode' => '#001','errorMessage' => 'Partenaire non autorisé.');
        }*/


    }

    /**
     * Get one client
     *
     * @url GET /getModelemarques_auto_April
     */

    public function getModelemarques_auto_April()
    {
        $id=parent::$paramGET["id"];
        $identifer ='311f9e8368f470edb94b';
        $key ='d47aa6470be64485f78f6ff27e633b59d62fcf73087cbeb8f74fbd7aad42f79d2969fa20161045cf705ee3ec44ee8b3860d3b18a36c53165646eaf95d51c4ab7';
        $url ="https://www.api-sn.aprilapps.com/api/auth/token";
        $url1 = "https://www.api-sn.aprilapps.com/api/auto/marques/".$id."/modeles";
        $token = Utils::auth2($identifer,$key,$url);
        $obj = json_decode($token);
        if(!empty($obj)){
            $token1 = $obj->{'token'};
            $assureur = Utils::Method_GET($url1,$key,$token1);
            $data  = json_decode($assureur);
            if($data == null){
                $return = array(
                    'code'=>'6051',
                    'message'=>'Aucune modele marques trouvé'
                );
                return $return;
            }else{
                $return = array(
                    'code'=>'6050',
                    'data'=>$data
                );
                return $return;
            }

        }else{
            $obj = array(
                'code'=>'6011',
                'message'=>'token incorrect'
            );
            return $obj;

        }


    }

    /**
     * Gets modeles_auto list
     *
     * @url GET /getModeles_auto_April
     */

    public function getModeles_auto_April()
    {
        $identifer ='311f9e8368f470edb94b';
        $key ='d47aa6470be64485f78f6ff27e633b59d62fcf73087cbeb8f74fbd7aad42f79d2969fa20161045cf705ee3ec44ee8b3860d3b18a36c53165646eaf95d51c4ab7';
        $url ="https://www.api-sn.aprilapps.com/api/auth/token";
        $url1 = "https://www.api-sn.aprilapps.com/api/auto/modeles";
        $token = Utils::auth2($identifer,$key,$url);
        $obj = json_decode($token);
        if(!empty($obj)){
            $token1 = $obj->{'token'};
            $client = Utils::Method_GET($url1,$key,$token1);
            $data  = json_decode($client);
            if($data == null){
                $return = array(
                    'code'=>'6051',
                    'message'=>'Aucune modele trouvé'
                );
                return $return;
            }else{
                $return = json_encode(array(
                    'code'=>'6050',
                    'data'=>$data
                ));
                return $return;
            }

        }else{
            $obj = array(
                'code'=>'6011',
                'message'=>'token incorrect'
            );
            return $obj;

        }


    }


    /**
     * Gets carburants list
     *
     * @url GET /getCarburants_April
     */

    public function getCarburants_April()
    {
        $identifer ='311f9e8368f470edb94b';
        $key ='d47aa6470be64485f78f6ff27e633b59d62fcf73087cbeb8f74fbd7aad42f79d2969fa20161045cf705ee3ec44ee8b3860d3b18a36c53165646eaf95d51c4ab7';
        $url ="https://www.api-sn.aprilapps.com/api/auth/token";
        $url1 = "https://www.api-sn.aprilapps.com/api/auto/carburants";
        $token = Utils::auth2($identifer,$key,$url);
        $obj = json_decode($token);
        if(!empty($obj)){
            $token1 = $obj->{'token'};
            $client = Utils::Method_GET($url1,$key,$token1);
            $data  = json_decode($client);
            //return $data;
            if($data == null){
                $return = array(
                    'code'=>'6051',
                    'message'=>'Aucun carburant trouvé'
                );
                return $return;
            }else{
                //$data1 = $data->{'data'};
                $return = array(
                    'code'=>'6050',
                    'data'=>$data
                );
                return $return;
            }

        }else{
            $obj = array(
                'code'=>'6011',
                'message'=>'token incorrect'
            );
            return $obj;

        }


    }


    /**
     * Gets carburants list
     *
     * @url GET /getDurees_April
     */

    public function getDurees_April()
    {
        $identifer ='311f9e8368f470edb94b';
        $key ='d47aa6470be64485f78f6ff27e633b59d62fcf73087cbeb8f74fbd7aad42f79d2969fa20161045cf705ee3ec44ee8b3860d3b18a36c53165646eaf95d51c4ab7';
        $url ="https://www.api-sn.aprilapps.com/api/auth/token";
        $url1 = "https://www.api-sn.aprilapps.com/api/auto/durees";
        $token = Utils::auth2($identifer,$key,$url);
        $obj = json_decode($token);
        if(!empty($obj)){
            $token1 = $obj->{'token'};
            $client = Utils::Method_GET($url1,$key,$token1);
            $data  = json_decode($client);
            if($data == null){
                $return = array(
                    'code'=>'6051',
                    'message'=>'Aucune durée trouvé'
                );
                return $return;
            }else{
                $return = array(
                    'code'=>'6050',
                    'data'=>$data
                );
                return $return;
            }

        }else{
            $obj = array(
                'code'=>'6011',
                'message'=>'token incorrect'
            );
            return $obj;

        }


    }


    /**
     * Gets packs list
     *
     * @url GET /getPacksauto_April
     */

    public function getPacksauto_April()
    {
        $identifer ='311f9e8368f470edb94b';
        $key ='d47aa6470be64485f78f6ff27e633b59d62fcf73087cbeb8f74fbd7aad42f79d2969fa20161045cf705ee3ec44ee8b3860d3b18a36c53165646eaf95d51c4ab7';
        $url ="https://www.api-sn.aprilapps.com/api/auth/token";
        $url1 = "https://www.api-sn.aprilapps.com/api/auto/packs";
        $token = Utils::auth2($identifer,$key,$url);
        $obj = json_decode($token);
        if(!empty($obj)){
            $token1 = $obj->{'token'};
            $client = Utils::Method_GET($url1,$key,$token1);
            $data  = json_decode($client);
            if($data == null){
                $return = array(
                    'code'=>'6051',
                    'message'=>'Aucun pack trouvé'
                );
                return $return;
            }else{
                $return = array(
                    'code'=>'6050',
                    'data'=>$data
                );
                return $return;
            }

        }else{
            $obj = array(
                'code'=>'6011',
                'message'=>'token incorrect'
            );
            return $obj;

        }


    }

    /**
     * Get one pack
     *
     * @url GET /getOnepackauto_April
     */

    public function getOnepackauto_April()
    {
        $id=parent::$paramGET["id"];
        $identifer ='311f9e8368f470edb94b';
        $key ='d47aa6470be64485f78f6ff27e633b59d62fcf73087cbeb8f74fbd7aad42f79d2969fa20161045cf705ee3ec44ee8b3860d3b18a36c53165646eaf95d51c4ab7';
        $url ="https://www.api-sn.aprilapps.com/api/auth/token";
        $url1 = "https://www.api-sn.aprilapps.com/api/auto/packs/".$id;
        $token = Utils::auth2($identifer,$key,$url);
        $obj = json_decode($token);
        if(!empty($obj)){
            $token1 = $obj->{'token'};
            $assureur = Utils::Method_GET($url1,$key,$token1);
            $data  = json_decode($assureur);
            if($data == null){
                $return = array(
                    'code'=>'6051',
                    'message'=>'Aucun pack trouvé'
                );
                return $return;
            }else{
                $return = array(
                    'code'=>'6050',
                    'data'=>$data
                );
                return $return;
            }

        }else{
            $obj = array(
                'code'=>'6011',
                'message'=>'token incorrect'
            );
            return $obj;

        }


    }


    /**
     * Gets tarif_auto list
     *
     * @url GET /gettarifsauto_April
     */

    public function gettarifsauto_April()
    {
        $puissance_fiscale_id=parent::$paramGET["puissance_fiscale_id"];
        $duree=parent::$paramGET["duree"];
        $carte_brune=parent::$paramGET["carte_brune"];
        $identifer ='311f9e8368f470edb94b';
        $key ='d47aa6470be64485f78f6ff27e633b59d62fcf73087cbeb8f74fbd7aad42f79d2969fa20161045cf705ee3ec44ee8b3860d3b18a36c53165646eaf95d51c4ab7';
        $url ="https://www.api-sn.aprilapps.com/api/auth/token";
        $url1 = "https://www.api-sn.aprilapps.com/api/auto/tarifs?puissance_fiscale_id=".$puissance_fiscale_id."&duree=".$duree."&carte_brune=".$carte_brune;
        $token = Utils::auth2($identifer,$key,$url);
        $obj = json_decode($token);
        if(!empty($obj)){
            $token1 = $obj->{'token'};
            $client = Utils::Method_GET($url1,$key,$token1);
            $data  = json_decode($client);
            //return $client;
            if($data == null){
                $return = array(
                    'code'=>'6051',
                    'message'=>'Aucun tarif trouvé'
                );
                return $return;
            }else{
                //$data1 = $data->{'data'};
                $return = array(
                    'code'=>'6050',
                    'data'=>$data
                );
                return $return;
            }

        }else{
            $obj = array(
                'code'=>'6011',
                'message'=>'token incorrect'
            );
            return $obj;

        }


    }


    /**
     * Gets tarif_auto list
     *
     * @url GET /gettarifauto_April
     */

    public function gettarifauto_April()
    {
        $pack_id=parent::$paramGET["pack_id"];
        $puissance_fiscale_id=parent::$paramGET["puissance_fiscale_id"];
        $duree=parent::$paramGET["duree"];
        $carte_brune=parent::$paramGET["carte_brune"];
        $identifer ='311f9e8368f470edb94b';
        $key ='d47aa6470be64485f78f6ff27e633b59d62fcf73087cbeb8f74fbd7aad42f79d2969fa20161045cf705ee3ec44ee8b3860d3b18a36c53165646eaf95d51c4ab7';
        $url ="https://www.api-sn.aprilapps.com/api/auth/token";
        $url1 = "https://www.api-sn.aprilapps.com/api/auto/tarif?pack_id=".$pack_id."&puissance_fiscale_id=".$puissance_fiscale_id."&duree=".$duree."&carte_brune=".$carte_brune;
        $token = Utils::auth2($identifer,$key,$url);
        $obj = json_decode($token);
        if(!empty($obj)){
            $token1 = $obj->{'token'};
            $client = Utils::Method_GET($url1,$key,$token1);
            $data  = json_decode($client);
            //return $client;
            if($data == null){
                $return = array(
                    'code'=>'6051',
                    'message'=>'Aucun tarif trouvé'
                );
                return $return;
            }else{
                //$data1 = $data->{'data'};
                $return = array(
                    'code'=>'6050',
                    'data'=>$data
                );
                return $return;
            }

        }else{
            $obj = array(
                'code'=>'6011',
                'message'=>'token incorrect'
            );
            return $obj;

        }


    }


    /**
     * create devis
     *
     * @url POST /createDevisauto_April
     */

    public function createDevisauto_April()
    {
        $verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('createDevisauto_April');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){
            $identifer ='311f9e8368f470edb94b';
            $key ='d47aa6470be64485f78f6ff27e633b59d62fcf73087cbeb8f74fbd7aad42f79d2969fa20161045cf705ee3ec44ee8b3860d3b18a36c53165646eaf95d51c4ab7';
            $url ="https://www.api-sn.aprilapps.com/api/auth/token";
            $url1 = "https://www.api-sn.aprilapps.com/api/auto/devis";
            $donnee = array(
                'immatriculation' => parent::$paramPOST["immatriculation"],
                'numcli' => parent::$paramPOST["numcli"],
                'personne_id' => parent::$paramPOST["personne_id"],
                'pack_id' => parent::$paramPOST["pack_id"],
                'assureur_id' => parent::$paramPOST["assureur_id"],
                'fabriquant_id' => parent::$paramPOST["fabriquant_id"],
                'modele_id' => parent::$paramPOST["modele_id"],
                'carburant_id' => parent::$paramPOST["carburant_id"],
                'puissance_fiscale_id' => parent::$paramPOST["puissance_fiscale_id"],
                'n_place' => parent::$paramPOST["n_place"],
                'date_deb' => parent::$paramPOST["date_deb"],
                'date_fin' => parent::$paramPOST["date_fin"],
                'duree' => parent::$paramPOST["duree"],
                'mode_rgl' => parent::$paramPOST["mode_rgl"],
                'vendeur_code' => parent::$paramPOST["vendeur_code"]
            );
            $token = Utils::auth2($identifer,$key,$url);
            $obj = json_decode($token);
            //return $obj;
            if(!empty($obj)){
                $token1 = $obj->{'token'};
                $person = Utils::Method_POST($donnee,$url1,$key,$token1);
                $data  = json_decode($person);
                //return $data;
                if(isset(parent::$paramPOST["immatriculation"]) &&
                    isset(parent::$paramPOST["numcli"]) &&
                    isset(parent::$paramPOST["personne_id"]) &&
                    isset(parent::$paramPOST["pack_id"]) &&
                    isset(parent::$paramPOST["assureur_id"]) &&
                    isset(parent::$paramPOST["fabriquant_id"]) &&
                    isset(parent::$paramPOST["modele_id"]) &&
                    isset(parent::$paramPOST["carburant_id"]) &&
                    isset(parent::$paramPOST["puissance_fiscale_id"]) &&
                    isset(parent::$paramPOST["n_place"]) &&
                    isset(parent::$paramPOST["date_deb"]) &&
                    isset(parent::$paramPOST["date_fin"]) &&
                    isset(parent::$paramPOST["duree"]) &&
                    isset(parent::$paramPOST["mode_rgl"]) &&
                    isset(parent::$paramPOST["vendeur_code"])
                  ){
                    if($data == null)
                    {
                        $return = array(
                            'code'=>'6051',
                            'message'=>'Erreur insertion'
                        );
                        return $return;
                    }
                    else
                    {
                        $return = array(
                            'code'=>'6050',
                            'data'=>$data
                        );
                        return $return;
                    }
                }
                else
                {
                    $obj = array(
                        'code'=>'6052',
                        'message'=>'Veuillez renseigner tous les champs!'
                    );
                    return $obj;
                }
            }
            else
            {
                $obj = array(
                    'code'=>'6011',
                    'message'=>'token incorrect'
                );
                return $obj;

            }
        }
        else
        {
            return array('errorCode' => '#001','errorMessage' => 'Partenaire non autorisé.');
        }


    }

    /**
     * create contrat
     *
     * @url POST /createContratauto_April
     */

    public function createContratauto_April()
    {
        //return 1;
        $verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('createContratauto_April');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){
            $identifer ='311f9e8368f470edb94b';
            $key ='d47aa6470be64485f78f6ff27e633b59d62fcf73087cbeb8f74fbd7aad42f79d2969fa20161045cf705ee3ec44ee8b3860d3b18a36c53165646eaf95d51c4ab7';
            $url ="https://www.api-sn.aprilapps.com/api/auth/token";
            $url1 = "https://www.api-sn.aprilapps.com/api/auto/contrat";
            $donnee = array(
                'immatriculation' => parent::$paramPOST["immatriculation"],
                'numcli' => parent::$paramPOST["numcli"],
                'personne_id' => parent::$paramPOST["personne_id"],
                'pack_id' => parent::$paramPOST["pack_id"],
                'assureur_id' => parent::$paramPOST["assureur_id"],
                'fabriquant_id' => parent::$paramPOST["fabriquant_id"],
                'modele_id' => parent::$paramPOST["modele_id"],
                'carburant_id' => parent::$paramPOST["carburant_id"],
                'puissance_fiscale_id' => parent::$paramPOST["puissance_fiscale_id"],
                'n_place' => parent::$paramPOST["n_place"],
                'date_deb' => parent::$paramPOST["date_deb"],
                'date_fin' => parent::$paramPOST["date_fin"],
                'duree' => parent::$paramPOST["duree"],
                'carte_brune' => parent::$paramPOST["carte_brune"],
                'mode_rgl' => parent::$paramPOST["mode_rgl"],
                'vendeur_code' => parent::$paramPOST["vendeur_code"]
            );
            $token = Utils::auth2($identifer,$key,$url);
            $obj = json_decode($token);
            if(!empty($obj)){
                $token1 = $obj->{'token'};
                if(isset(parent::$paramPOST["immatriculation"]) &&
                    isset(parent::$paramPOST["numcli"]) &&
                    isset(parent::$paramPOST["personne_id"]) &&
                    isset(parent::$paramPOST["pack_id"]) &&
                    isset(parent::$paramPOST["assureur_id"]) &&
                    isset(parent::$paramPOST["fabriquant_id"]) &&
                    isset(parent::$paramPOST["modele_id"]) &&
                    isset(parent::$paramPOST["carburant_id"]) &&
                    isset(parent::$paramPOST["puissance_fiscale_id"]) &&
                    isset(parent::$paramPOST["n_place"]) &&
                    isset(parent::$paramPOST["date_deb"]) &&
                    isset(parent::$paramPOST["date_fin"]) &&
                    isset(parent::$paramPOST["duree"]) &&
                    isset(parent::$paramPOST["mode_rgl"]) &&
                    isset(parent::$paramPOST["vendeur_code"])
                ){
                    $url_tarif = "https://www.api-sn.aprilapps.com/api/auto/tarif?pack_id=".parent::$paramPOST["pack_id"]."&puissance_fiscale_id=".parent::$paramPOST["puissance_fiscale_id"]."&duree=".parent::$paramPOST["duree"]."&carte_brune=".parent::$paramPOST["carte_brune"];
                    $tarif = Utils::Method_GET($url_tarif,$key,$token1);
                    $data_tarif  = json_decode($tarif);
                    $montant = $data_tarif->{'montant_total'};
                    $soldePartenaire = $this->partnaire->getSoldePartenaire($verif_token);
                    $commission = $this->transactionModel->getFraisService($service, $montant);
                    $partage_commission = $this->transactionModel->getCommissionUnitaire($service, $verif_token);
                    $commission_sva = ($commission * $partage_commission->pourcentage_sva)/100;
                    $commission_fournisseur = ($commission * $partage_commission->pourcentage_fournisseur)/100;
                    $commission_partenaire = ($commission * $partage_commission->pourcentage_partenaire)/100;
                    $montant_total = intval($montant + $commission_sva + $commission_fournisseur);
                    $num_transac = $this->model->Generer_numtransaction();
                    if($soldePartenaire >= $montant_total)
                    {
                        $person = Utils::Method_POST($donnee,$url1,$key,$token1);
                        $data  = json_decode($person);
                        if($data == null)
                        {
                            return array('code'=>401,'message'=>'Erreur insertion');
                        }
                        else
                        {
                            $statut = 1;
                            $user = 1;
                            $user_partenaire = 1;
                            $date_transaction = date('Y-m-d H:i:s');
                            $this->partnaire->debiterSoldePartenaire($montant_total,$verif_token);
                            $this->transactionModel->crediterCompteSVA($montant);
                            $this->transactionModel->crediterCompteSVACommission($commission_sva);
                            $fk_transaction = $this->transactionModel->saveTransaction($user_partenaire, $service, $verif_token, $montant, $commission, $num_transac, "ContratApril", $statut, 200);
                            $this->transactionModel->saveDetailTransaction($commission_sva, $commission_partenaire, $fk_transaction, $date_transaction);
                            $solde_apres = $this->partnaire->getSoldePartenaire($verif_token);
                            $this->transactionModel->saveRelevePartenaire($num_transac, $soldePartenaire, $solde_apres, $montant_total, $service, $verif_token);
                            $this->transactionModel->saveRetourWebservice(200, 'SuccessFull', 'ContratApril', parent::$paramPOST["numcli"].$montant.$num_transac.$user.$_SERVER['REMOTE_ADDR'], $verif_token);
                            return array('code'=>200,'data'=>$data);
                        }
                    }
                    else
                    {
                        return array('code'=>401, 'message'=>'Votre solde est insuffisant');
                    }

                }
                else
                {
                    $obj = array(
                        'code'=>402,
                        'message'=>'Veuillez renseigner tous les champs!'
                    );
                    return $obj;
                }
            }
            else
            {
                $obj = array(
                    'code'=>401,
                    'message'=>'token incorrect'
                );
                return $obj;

            }
        }
        else
        {
            return array('code' => 502,'message' => 'Partenaire non autorisé.');
        }


    }

    /**
     * create facture
     *
     * @url POST /createFactureauto_April
     */

    public function createFactureauto_April()
    {
        $verif_token = TokenJWT::decode($this->token, TOKEN_KEY);
        $verif_token = $verif_token->{'id'};
        $service = $this->model->getIdService('createFactureauto_April');
        $checkPart = $this->partnaire->checkPartenaireAccess($verif_token,$service);
        if($checkPart === 1){
            $identifer ='311f9e8368f470edb94b';
            $key ='d47aa6470be64485f78f6ff27e633b59d62fcf73087cbeb8f74fbd7aad42f79d2969fa20161045cf705ee3ec44ee8b3860d3b18a36c53165646eaf95d51c4ab7';
            $url ="https://www.api-sn.aprilapps.com/api/auth/token";
            $url1 = "https://www.api-sn.aprilapps.com/api/auto/facture";
            $donnee = array(
                'contrat_no' => parent::$paramPOST["contrat_no"],
                'numcli' => parent::$paramPOST["numcli"],
                'pack_id' => parent::$paramPOST["pack_id"],
                'puissance_fiscale_id' => parent::$paramPOST["puissance_fiscale_id"],
                'duree' => parent::$paramPOST["duree"],
                'mode_rgl' => parent::$paramPOST["mode_rgl"],
                'carte_brune' => parent::$paramPOST["carte_brune"],
                'vendeur_code' => parent::$paramPOST["vendeur_code"]
            );
            $token = Utils::auth2($identifer,$key,$url);
            $obj = json_decode($token);
            //return $obj;
            if(!empty($obj)){
                $token1 = $obj->{'token'};
                $person = Utils::Method_POST($donnee,$url1,$key,$token1);
                $data  = json_decode($person);
                //return $data;
                if(isset(parent::$paramPOST["contrat_no"]) &&
                    isset(parent::$paramPOST["numcli"]) &&
                    isset(parent::$paramPOST["pack_id"]) &&
                    isset(parent::$paramPOST["puissance_fiscale_id"]) &&
                    isset(parent::$paramPOST["duree"]) &&
                    isset(parent::$paramPOST["mode_rgl"]) &&
                    isset(parent::$paramPOST["vendeur_code"])
                ){
                    if($data == null)
                    {
                        return array('code'=>401,'message'=>'Erreur insertion');
                    }
                    else
                    {
                        return array('code'=>200,'data'=>$data);
                    }
                }
                else
                {
                    return array('code'=>401,'message'=>'Veuillez renseigner tous les champs!');
                }
            }
            else
            {
                return array('code'=>401,'message'=>'token incorrect');
            }
        }
        else
        {
            return array('errorCode' => '#001','errorMessage' => 'Partenaire non autorisé.');
        }


    }










}