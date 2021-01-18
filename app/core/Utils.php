<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 17/08/2017
 * Time: 11:03
 */

namespace app\core;

use app\common\CommonUtils;

class Utils
{

    public static function redirect($controleur = null, $action = "index", array $param = [], $space = null)
    {
        $url = ($space === "default") ? RACINE : ((is_null($space)) ? WEBROOT : RACINE.$space);
        $action = (is_null($action)) ? "index" : $action;
        if (is_string($controleur)){
            $url .= $controleur . "/" . $action;
            if (count($param) > 0) $url .= "/" . implode('/', self::setBase64_encode_array($param));
        }
        header('Location:' . $url);
    }

    /**
     *
     */
    public static function sessionStarted()
    {
        if (\php_sapi_name() !== 'cli') {
            if (\version_compare(\phpversion(), '5.4.0', '>=')) {
                if(\session_status() !== PHP_SESSION_ACTIVE) {
                    session_cache_expire(30);
                    session_start();
                }
            } else {
                if(\session_id() === ''){
                    session_cache_expire(30);
                    session_start();
                }
            }
        }else{
            session_cache_expire(30);
            session_start();
        }
    }

    /**
     * @param $model
     * @return mixed
     */
    public static function getModel($model)
    {
        $_USER = (Session::existeAttribut(SESSIONNAME)) ? Session::getAttributArray(SESSIONNAME)[0] : null;
        $model = Prefix_Model . ucfirst($model) . 'Model';
        return new $model($_USER);
    }

    /**
     * @param array $array
     * @return array
     */
    public static function setBase64_encode_array($array)
    {
        foreach ($array as $key => $value){
            if(!\is_array($value)) $array[$key] = base64_encode($value);
            else self::setBase64_encode_array($value);
        }
        return $array;
    }

    /**
     * @param array $array
     * @return array
     */
    public static function setBase64_decode_array($array)
    {
        if(count($array) > 0){
            foreach ($array as $key => $value){
                if(!\is_array($value))
                    $array[$key] = (base64_encode(base64_decode($value, true)) === $value) ? base64_decode($value) : $value;
                else self::setBase64_decode_array($value);
            }
        }
        return $array;
    }

    /**
     * @param int $length
     * @return string
     */
    public static function getAlphaNumerique($length = 10)
    {
        $string = "";
        $chaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        \srand((double)\microtime() * 1000000);
        for ($i = 0; $i < $length; $i++) $string .= $chaine[\rand() % \strlen($chaine)];
        return $string;
    }

    /**
     * @param $pass
     * @return bool|null|string
     */
    public static function getPassCrypt($pass)
    {
        $timeTarget = 0.05; // 50 millisecondes
        $cost = 8;
        $passHasher = null;
        do {
            $cost++;
            $start = \microtime(true);
            $passHasher = \password_hash($pass, PASSWORD_BCRYPT, ["cost" => $cost]);
            $end = \microtime(true);
        } while (($end - $start) < $timeTarget);
        return $passHasher;
    }

    /**
     * @param $lenght
     * @return bool|string
     */
    public static function random($lenght = 8) {
        $return = null;
        if (function_exists('openssl_random_pseudo_bytes')) {
            $byteLen = intval(($lenght / 2) + 1);
            $return = substr(bin2hex(openssl_random_pseudo_bytes($byteLen)), 0, $lenght);
        } elseif (@is_readable('/dev/urandom')) {
            $f=fopen('/dev/urandom', 'r');
            $urandom=fread($f, $lenght);
            fclose($f);
        }

        if (is_null($return)) {
            for ($i=0; $i<$lenght; ++$i) {
                if (!isset($urandom)) {
                    if ($i%2==0) {
                        mt_srand(time()%2147 * 1000000 + (double)microtime() * 1000000);
                    }
                    $rand=48+mt_rand()%64;
                } else {
                    $rand=48+ord($urandom[$i])%64;
                }

                if ($rand>57)
                    $rand+=7;
                if ($rand>90)
                    $rand+=6;

                if ($rand==123) $rand=52;
                if ($rand==124) $rand=53;
                $return .= chr($rand);
            }
        }
        return $return;
    }

    /**
     * @param $length
     * @return array
     */
    public static function getGeneratePassword($length = 8)
    {
        // on declare une chaine de caractÃ¨res
        $chaine = "abcdefghijklmnopqrstuvwxyz@ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        //nombre de caractÃ¨res dans le mot de passe
        $pass = "";
        //on fait une boucle
        for ($u = 1; $u <= $length; $u++) {
            //on compte le nombre de caractÃ¨res prÃ©sents dans notre chaine
            $nb = \strlen($chaine);
            // on choisie un nombre au hasard entre 0 et le nombre de caractÃ¨res de la chaine
            $nb = \mt_rand(0, ($nb - 1));
            // on ajoute la lettre a la valeur de $pass
            $pass .= $chaine[$nb];
        }
        // on retourne le rÃ©sultat :
        return ["pass"=>$pass,"crypt"=>self::getPassCrypt($pass)];
    }

    /**
     * @param int $length
     * @return string
     */
    public static function genererReference($length = 8)
    {
        $characts = '0123456789';
        $ref = '';
        for ($i = 0; $i < $length; $i++) {
            $ref .= \substr($characts, \rand() % (\strlen($characts)), 1);
        }
        return $ref;
    }

    /**
     * @return bool
     */
    public static function getSessionStarted()
    {
        if (\php_sapi_name() !== 'cli') {
            if (\version_compare(\phpversion(), '5.4.0', '>=')) {
                return \session_status() === PHP_SESSION_ACTIVE ? true : false;
            } else {
                return \session_id() === '' ? false : true;
            }
        }
        return false;
    }

    /**
     * @return string
     */
    public static function getBrowser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'] . "\n\n";
        switch (true) {
            case (\strpos($user_agent, 'Opera') || \strpos($user_agent, 'OPR/')) :
                return 'Opera';
                break;
            case (\strpos($user_agent, 'Edge')) :
                return 'Edge';
                break;
            case (\strpos($user_agent, 'Chrome')) :
                return 'Chrome';
                break;
            case (\strpos($user_agent, 'Safari')) :
                return 'Safari';
                break;
            case (\strpos($user_agent, 'Firefox')) :
                return 'Firefox';
                break;
            case  (\strpos($user_agent, 'MSIE') || \strpos($user_agent, 'Trident/7')) :
                return 'Internet Explorer';
                break;
            default :
                return 'Other';
        }
    }

    /**
     * @return mixed
     */
    public static function getIp()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $ip;
    }


    /**
     * @param float $nombre
     * @param null $arg
     * @param int $decimals
     * @return string
     */
    public static function getFormatMoney($nombre = 0.0, $arg = null, $decimals = 0)
    {
        return @\number_format(floatval($nombre), $decimals, ',', ' ') . ' ' . $arg;
    }

    public static function heure_minute_seconde($date)
    {
        $date_fr = '';
        if ($date != '') {
            $ss = substr($date, 17, 2);
            $ii = substr($date, 14, 2);
            $hh = substr($date, 11, 2);

            ///////////////
            $date_fr =  $hh . ':' . $ii . ':' . $ss;
        }
        return $date_fr;
    }


    /**
     * @param $date
     * @param bool $heure
     * @return string
     */
    public static function getDateFR($date, $heure = true)
    {
        $tabMois = ["01"=>"Jan","02"=>"Fev","03"=>"Mar","04"=>"Avr","05"=>"Mai","06"=>"Jui","07"=>"Juil","08"=>"Aout","09"=>"Sept","10"=>"Oct","11"=>"Nov","12"=>"Dec"];
        $date    = \explode(" ",$date);
        $heur   = $date[1];
        $date    = \explode("-",$date[0]);
        $date[1] = $tabMois[$date[1]];
        $heur = ($heure) ? $heur : null;
        return (!\is_null($heur)) ? $date[2] . " / " . $date[1] . " / " . $date[0] . " " . $heur : $date[2] . " / " . $date[1] . " / " . $date[0];
    }

    /**
     * @param bool $with_time default false
     * @return false|string
     */
    public static function getDateNow($with_time = false)
    {
        return ($with_time) ? \gmdate("Y-m-d H:i:s") : \gmdate("Y-m-d");
    }

    /**
     * @param array $interval
     * @param string $dateFrom
     * @return false|string
     */
    public static function getDateFuturFromDate($interval = [1, "mois"], $dateFrom = "now")
    {
        $int = null;
        $number = intval($interval[0]);
        $number = $number == 0 ? 1 : $number;

        switch (strtolower($interval[1])){
            case "jour"  : $int = "+".$number." Day"; break;
            case "mois"  : $int = "+".$number." Month"; break;
            case "annee" : $int = "+".$number." Year"; break;
            default      : $int = "+".$number." Month"; break;
        }
        return gmdate("Y-m-d H:i:s", strtotime($int, strtotime($dateFrom)));
    }

    /**
     * @param $date
     * @return string
     */
    public static function getMonthYearFR($date)
    {
        $tabMois = ["01"=>"Jan","02"=>"Fev","03"=>"Mar","04"=>"Avr","05"=>"Mai","06"=>"Jui","07"=>"Juil","08"=>"Aout","09"=>"Sept","10"=>"Oct","11"=>"Nov","12"=>"Dec"];
        $date    = \explode(" ",$date);
        $date    = \explode("-",$date[0]);
        $date[1] = $tabMois[$date[1]];
        return $date[1] . " / " . $date[0];
    }

    /**
     * @param $date
     * @return string
     */
    public static function getDayMonthFR($date)
    {
        $tabMois = ["01"=>"Jan","02"=>"Fev","03"=>"Mar","04"=>"Avr","05"=>"Mai","06"=>"Jui","07"=>"Juil","08"=>"Aout","09"=>"Sept","10"=>"Oct","11"=>"Nov","12"=>"Dec"];
        $date    = \explode(" ",$date);
        $date    = \explode("-",$date[0]);
        $date[1] = $tabMois[$date[1]];
        return $date[2] . " / " . $date[1];
    }

    public static function alignRightMontant($val)
    {
        return "<div style='text-align: right;'>".Utils::getFormatMoney($val)."</div>";
    }

    /**
     * @param $date
     * @return string
     */
    public static function getDateUS($date)
    {
        $tabMois = ["01"=>"Jan","02"=>"Fev","03"=>"Mar","04"=>"Avr","05"=>"Mai","06"=>"Jui","07"=>"Juil","08"=>"Aout","09"=>"Sept","10"=>"Oct","11"=>"Nov","12"=>"Dec"];
        $date    = \explode(" ",$date);
        $heure   = $date[1];
        $date    = \explode("-",$date[0]);
        $date[1] = $tabMois[$date[1]];
        return (!\is_null($heure)) ? $date[2] . " / " . $date[1] . " / " . $date[0] . " " . $heure : $date[2] . " / " . $date[1] . " / " . $date[0];
    }

    /**
     * @param $car
     * @return string
     */
    public static function getIntegerUnique($car = 6) {
        $string = "";
        $chaine = "0123456789";
        \srand((double)\microtime()*1000000);
        for($i=0; $i<$car; $i++) {
            $string .= $chaine[\rand()%\strlen($chaine)];
        }
        return $string;
    }

    /**
     * @param $car
     * @return string
     */
    public static function getStringUnique($car = 6) {
        $string = "";
        $chaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        \srand((double)\microtime()*1000000);
        for($i=0; $i<$car; $i++) {
            $string .= $chaine[\rand()%\strlen($chaine)];
        }
        return $string;
    }

    /**
     * @param array $paramFiles
     * @param string $url
     * @param string $nameFile
     * @return bool
     */
    public static function setUploadFiles($paramFiles = [], $url = "", $nameFile = "")
    {
        if (\count($paramFiles) > 0 && $paramFiles["error"] != "4" && $url != "") {
            if(!self::createDir($url)) return false;
            if($nameFile == "") $nameFile = gmdate("YmdHis");
            $nameFile .= ".".\pathinfo($paramFiles['name'], PATHINFO_EXTENSION);
            return (\move_uploaded_file($paramFiles['tmp_name'], ROOT.$url ."/". $nameFile)) ? $nameFile : false;
        }
        return false;
    }

    /**
     * @param array $paramFiles
     * @param string $url
     * @param string $name
     * @return bool
     */
    public static function setUploadFilesBinaire($paramFiles = [], $url = "", $name = "")
    {
        if (\count($paramFiles) > 0 && $paramFiles["error"] != "4" && $url != "") {
            if ($name == "") $name = Utils::getAlphaNumerique(5);
            if(!self::createDir($url)) return 'Error';
            $fWriteHandle = fopen($url.'/'.$name."." . \pathinfo($paramFiles['name'], PATHINFO_EXTENSION), 'w+');
            $fReadHandle = fopen($paramFiles['tmp_name'], 'rb');
            $fileContent = fread($fReadHandle, $paramFiles['size']);
            $result = fwrite($fWriteHandle, $fileContent);
            fclose($fWriteHandle);
            return ($result === false) ? $result : $name.'.'.\pathinfo($paramFiles['name'], PATHINFO_EXTENSION);
        }
        return false;
    }

    /**
     * @param $path
     * @param $newName
     * @return bool
     */
    public static function setRenameFile($path, $newName)
    {
        $dispath = explode("/",$path);
        if(count($dispath) > 0) {
            self::createDir(ROOT.implode("/",[$dispath[0]]));
            $tempDispath = $dispath;
            $newName .= ".".\pathinfo($tempDispath[count($tempDispath)-1], PATHINFO_EXTENSION);
            unset($tempDispath[count($tempDispath)-1]);
            $newName = implode("/",$tempDispath)."/".$newName;
            return rename(ROOT.$path, ROOT.$newName);
        }
        return false;
    }

    /**
     * @param string $url
     * @return bool
     */
    public static function setDeleteFiles($url = "")
    {
        return ($url != "") ? ((is_file(ROOT.$url)) ? \unlink(ROOT.$url) : true) : false;
    }

    /**
     * @param int $index
     * @param string $sort
     */
    public static function setDefaultSort($index = 0, $sort = "ASC")
    {
        Session::setAttributArray("default_sort",[$index,$sort]);
    }

    /**
     *
     */
    public static function unsetDefaultSort()
    {
        Session::destroyAttributSession("default_sort");
    }

    /**
     * @param string $url
     * @return bool
     */
    public static function createDir($url = "")
    {
        return ($url != "") ? ((!\is_dir(ROOT . $url)) ? \mkdir(ROOT . $url, 0777, true) : chmod(ROOT . $url, 0777)) : false;
    }

    /**
     * @param array $message
     */
    public static function setMessageALert(array $message)
    {
        Session::setAttributArray("MSG_ALERT",["type"=>$message[0],"alert"=>$message[1]]);
    }

    /**
     * @return array
     */
    public static function getMessageALert()
    {
        $msg = Session::getAttributArray("MSG_ALERT");
        return $msg;
    }

    /**
     * @param array $message
     */
    public static function setMessageError(array $message)
    {
        Session::setAttributArray("MSG_ERROR",["type"=>$message[0],"alert"=>$message[1]]);
    }

    /**
     * @return array
     */
    public static function getMessageError()
    {
        $msg = Session::getAttributArray("MSG_ERROR");
        return $msg;
    }

    /**
     * @param $name
     */
    public static function unsetMessage($name)
    {
        Session::destroyAttributSession("MSG_$name");
    }

    /**
     * @param array $droits
     * @return array
     */
    public static function setArrayDroit(array $droits)
    {
        $retour = [];
        foreach ($droits as $item) {
            //$item->module = str_replace(" ","-",$item->module);
            if(array_key_exists($item->module, $retour)){
                if(array_key_exists($item->sous_module, $retour[$item->module]))   $retour[$item->module][$item->sous_module][] = (isset($item->id_aff)) ? ["id"=>$item->id,"droit"=>$item->droit,"id_aff"=>$item->id_aff,"etat_aff"=>$item->etat_aff] : ["id"=>$item->id,"droit"=>$item->droit];
                else $retour[$item->module][$item->sous_module][] = (isset($item->id_aff)) ? ["id"=>$item->id,"droit"=>$item->droit,"id_aff"=>$item->id_aff,"etat_aff"=>$item->etat_aff] : ["id"=>$item->id,"droit"=>$item->droit];
            }else $retour[$item->module] = [$item->sous_module=>[((isset($item->id_aff)) ? ["id"=>$item->id,"droit"=>$item->droit,"id_aff"=>$item->id_aff,"etat_aff"=>$item->etat_aff] : ["id"=>$item->id,"droit"=>$item->droit])]];
        }
        return $retour;
    }

    /**
     * @param $errtxt
     */
    public static function writeFileLogs($errtxt)
    {
        self::createDir('logs/' . date('Y'). "/" . date('m'). '/' . date('W'));

        $fp = fopen(ROOT . 'logs/' . date('Y') . '/' . date('m') . '/' . date('W') . '/' . date("d_m_Y") . '.txt', 'a+'); // ouvrir le fichier ou le créer
        fseek($fp, SEEK_END); // poser le point de lecture à la fin du fichier
        $nouvel_ligne = $errtxt . "\r\n"; // ajouter un retour à la ligne au fichier
        fputs($fp, $nouvel_ligne); // ecrire ce texte
        fclose($fp); //fermer le fichier
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function validateMail($params)
    {
        return filter_var(filter_var($params, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param array $params
     * @return bool
     */
    public static function validateForm(array $params)
    {
        $retour = true;
        foreach ($params as $key => $value){
            if(\is_array($value)) self::validateForm($value);
            else {
                switch (strtolower($key)) {
                    case "email" : if(filter_var(filter_var($value, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) === false) return false; break;
                    case "prenom" : if((filter_var($value, FILTER_VALIDATE_INT) && self::startsWith($value,"+") && (strlen($value) === 7)) === false) return false; break;
                }
            }
        }
        return $retour;
    }

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return $length === 0 || (substr($haystack, -$length) === $needle);
    }
    /**
     * @BDK
     *
     * Envoie mail des parametres de l'utilisateur
     *
     */


    public static function envoiparametreClient($destinataire, $email, $login, $password, $cleSecrete, $numSerie)
    {
        $sujet = "Création compte d'accès suNuBus"; //Sujet du mail

        $message = '<html><body></body><table class="table_full editable-bg-color bg_color_e6e6e6 editable-bg-image" bgcolor="#e6e6e6" width="100%" align="center"  mc:repeatable="castellab" mc:variant="Header" cellspacing="0" cellpadding="0" border="0">
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_303f9f" bgcolor="#93979a" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="25"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td>
                           <table width="50%" align="left" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                 <td align="left">
                                    <a href="#" class="editable-img">
                                       <img src="https://numherit-preprod.com/sunubus/assets/plugins/images/white-sunusva.png" style="display:block;max-width: 100%;height: auto;" border="0" alt="" />
                                    
                                    </a>
                                 </td>
                              </tr>
                              <tr><td height="22"></td></tr>
                           </table>
                        </td>
                     </tr>
                     
                     <tr>
                        <td align="center" class="text_color_ffffff" style="color: #ffffff; font-size: 30px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline style="color: #325186; font-weight: bold; ">
                                    Création compte client d\'accès suNuBus
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="30"></td></tr>                   
                  </table>
               </td>
            </tr>
            <tr><td height="104"></td></tr>
         </table>
      </td>
   </tr>
   
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_ffffff" bgcolor="#ffffff" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="60"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td mc:edit="text011" align="left" class="center_content text_color_282828" style="color: #282828; font-size: 20px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline>
                                    Cher(e) client' .$destinataire.' , 
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="10"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline>
                                    Vous êtes à présent client de suNuBus.<br/> 
                                    Vous pourrez désormais vous connecter sur la platefortme mobile.<br />
                                    Vos paramètres sont les suivants: <br />
                                    Login : <span style="color: #0b0b0b;">'.$login.'</span><br/> 
                                    Mot de passe : <span style="color: #0b0b0b;">'.$password.'</span><br/> 
                                    Clé secréte : <span style="color: #0b0b0b;">'.$cleSecrete.'</span><br/> <br/> 
                                    Numéro série carte : <span style="color: #0b0b0b;">'.$numSerie.'</span><br/> 
                                    Téléphone : <span style="color: #0b0b0b;">'.$login.'</span><br/> 
                                    Email : <span style="color: #0b0b0b;">'.$email.'</span><br/> 
                                    Nous vous rappelons que vos paramètres de connexion sont confidentiels.<br/><br/>
                                    <a href="https://numherit-preprod.com/sunubus/" target="_blank">Cliquer sur ce lien pour accéder á votre compte.</a>
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="20"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="5"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline style="text-align: right;">
                                    Equipe sunuBus
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr><td height="60"></td></tr>
         </table>
      </td>
   </tr>
                    </table></body></html>';

        /** Envoi du mail **/
        $entete = "Content-type: text/html; charset=utf8\r\n";
        $entete .= " MIME-Version: 1.0\r\n";
        $entete .= "To: $destinataire<".$email."> \r\n";
        $entete .= "From:suNuBus<no-reply@sunubus.sn>\r\n";
        @mail($email, $sujet, $message, $entete);

    }

    public static function envoiParametreReceveur($destinataire, $email, $login, $password)
    {
        $sujet = "suNuBus access account creation"; //Sujet du mail

        $message = '<html><body></body><table class="table_full editable-bg-color bg_color_e6e6e6 editable-bg-image" bgcolor="#e6e6e6" width="100%" align="center"  mc:repeatable="castellab" mc:variant="Header" cellspacing="0" cellpadding="0" border="0">
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_303f9f" bgcolor="#93979a" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="25"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td>
                           <table width="50%" align="left" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                 <td align="left">
                                    <a href="#" class="editable-img">
                                       <img src=https://numherit-preprod.com/sunubus//assets/plugins/images/white-sunusva.png" style="display:block;max-width: 100%;height: auto;" border="0" alt="" />
                                    
                                    </a>
                                 </td>
                              </tr>
                              <tr><td height="22"></td></tr>
                           </table>
                        </td>
                     </tr>
                     <tr><td height="60"></td></tr>
                     <tr>
                        <td align="center">
                           <div class="editable-img">
                              <img src="https://numherit-labs.com/demo/sunusva/assets/plugins/images/circle-icon-password_access.png"  style="display:block; line-height:0; font-size:0; border:0;" border="0" alt="" />
                           </div>
                        </td>
                     </tr>
                     <tr><td height="40"></td></tr>
                     <tr>
                        <td align="center" class="text_color_ffffff" style="color: #ffffff; font-size: 30px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline style="color: #325186; font-weight: bold; ">
                                   suNuBus access account creation
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="30"></td></tr>                   
                  </table>
               </td>
            </tr>
            <tr><td height="104"></td></tr>
         </table>
      </td>
   </tr>
   
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_ffffff" bgcolor="#ffffff" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="60"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td mc:edit="text011" align="left" class="center_content text_color_282828" style="color: #282828; font-size: 20px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline>
                                    Dear ' .$destinataire.' , 
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="10"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline>
                                    Your suNuBus access password has just been created.<br/> 
                                    You will now be able to connect to the platform with the following credentials :<br />
                                    Login : <span style="color: #0b0b0b;">'.$login.'</span><br/> 
                                    Password : <span style="color: #0b0b0b;">'.$password.'</span><br/> 
                                    We remind you there are confidential.<br/><br/>
                               
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="20"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="5"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline style="text-align: right;">
                                    suNuBUS Team
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr><td height="60"></td></tr>
         </table>
      </td>
   </tr>
                    </table></body></html>';

        /** Envoi du mail **/
        $entete = "Content-type: text/html; charset=utf8\r\n";
        $entete .= " MIME-Version: 1.0\r\n";
        $entete .= "To: $destinataire<".$email."> \r\n";
        $entete .= "From:suNuBus<no-reply@sunubus.sn>\r\n";
        @mail($email, $sujet, $message, $entete);

    }

    public static function envoiparametre($destinataire, $email, $login, $password)
    {
        $sujet = "suNuBus access account creation"; //Sujet du mail

        $message = '<html><body></body><table class="table_full editable-bg-color bg_color_e6e6e6 editable-bg-image" bgcolor="#e6e6e6" width="100%" align="center"  mc:repeatable="castellab" mc:variant="Header" cellspacing="0" cellpadding="0" border="0">
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_303f9f" bgcolor="#93979a" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="25"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td>
                           <table width="50%" align="left" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                 <td align="left">
                                    <a href="#" class="editable-img">
                                       <img src=https://numherit-preprod.com/sunubus//assets/plugins/images/white-sunusva.png" style="display:block;max-width: 100%;height: auto;" border="0" alt="" />
                                    
                                    </a>
                                 </td>
                              </tr>
                              <tr><td height="22"></td></tr>
                           </table>
                        </td>
                     </tr>
                     <tr><td height="60"></td></tr>
                     <tr>
                        <td align="center">
                           <div class="editable-img">
                              <img src="https://numherit-labs.com/demo/sunusva/assets/plugins/images/circle-icon-password_access.png"  style="display:block; line-height:0; font-size:0; border:0;" border="0" alt="" />
                           </div>
                        </td>
                     </tr>
                     <tr><td height="40"></td></tr>
                     <tr>
                        <td align="center" class="text_color_ffffff" style="color: #ffffff; font-size: 30px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline style="color: #325186; font-weight: bold; ">
                                   suNuBus access account creation
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="30"></td></tr>                   
                  </table>
               </td>
            </tr>
            <tr><td height="104"></td></tr>
         </table>
      </td>
   </tr>
   
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_ffffff" bgcolor="#ffffff" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="60"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td mc:edit="text011" align="left" class="center_content text_color_282828" style="color: #282828; font-size: 20px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline>
                                    Dear ' .$destinataire.' , 
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="10"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline>
                                    Your suNuBus access password has just been created.<br/> 
                                    You will now be able to connect to the platform with the following credentials :<br />
                                    Login : <span style="color: #0b0b0b;">'.$login.'</span><br/> 
                                    Password : <span style="color: #0b0b0b;">'.$password.'</span><br/> 
                                    We remind you there are confidential.<br/><br/>
                                    <a href="https://numherit-preprod.com/sunubus/" target="_blank">Click on this link to access your account.</a>
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="20"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="5"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline style="text-align: right;">
                                    suNuBUS Team
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr><td height="60"></td></tr>
         </table>
      </td>
   </tr>
                    </table></body></html>';

        /** Envoi du mail **/
        $entete = "Content-type: text/html; charset=utf8\r\n";
        $entete .= " MIME-Version: 1.0\r\n";
        $entete .= "To: $destinataire<".$email."> \r\n";
        $entete .= "From:suNuBus<no-reply@sunubus.sn>\r\n";
        @mail($email, $sujet, $message, $entete);

    }
    public static function envoiparametreDistributeur($destinataire, $email, $login, $password)
    {
        $sujet = "suNuBus access account creation"; //Sujet du mail

        $message = '<html><body></body><table class="table_full editable-bg-color bg_color_e6e6e6 editable-bg-image" bgcolor="#e6e6e6" width="100%" align="center"  mc:repeatable="castellab" mc:variant="Header" cellspacing="0" cellpadding="0" border="0">
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_303f9f" bgcolor="#93979a" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="25"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td>
                           <table width="50%" align="left" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                 <td align="left">
                                    <a href="#" class="editable-img">
                                       <img src=https://numherit-preprod.com/sunubus//assets/plugins/images/white-sunusva.png" style="display:block;max-width: 100%;height: auto;" border="0" alt="" />
                                    
                                    </a>
                                 </td>
                              </tr>
                              <tr><td height="22"></td></tr>
                           </table>
                        </td>
                     </tr>
                     <tr><td height="60"></td></tr>
                     <tr>
                        <td align="center">
                           <div class="editable-img">
                              <img src="https://numherit-labs.com/demo/sunusva/assets/plugins/images/circle-icon-password_access.png"  style="display:block; line-height:0; font-size:0; border:0;" border="0" alt="" />
                           </div>
                        </td>
                     </tr>
                     <tr><td height="40"></td></tr>
                     <tr>
                        <td align="center" class="text_color_ffffff" style="color: #ffffff; font-size: 30px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline style="color: #325186; font-weight: bold; ">
                                   suNuBus access account creation
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="30"></td></tr>                   
                  </table>
               </td>
            </tr>
            <tr><td height="104"></td></tr>
         </table>
      </td>
   </tr>
   
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_ffffff" bgcolor="#ffffff" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="60"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td mc:edit="text011" align="left" class="center_content text_color_282828" style="color: #282828; font-size: 20px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline>
                                    Dear ' .$destinataire.' , 
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="10"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline>
                                    Your suNuBus access password has just been created.<br/> 
                                    You will now be able to connect to the platform with the following credentials :<br />
                                    Login : <span style="color: #0b0b0b;">'.$login.'</span><br/> 
                                    Password : <span style="color: #0b0b0b;">'.$password.'</span><br/> 
                                    We remind you there are confidential.<br/><br/>
                                    <a href="https://numherit-preprod.com/sunubus/distributeur" target="_blank">Click on this link to access your account.</a>
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="20"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="5"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline style="text-align: right;">
                                    suNuBUS Team
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr><td height="60"></td></tr>
         </table>
      </td>
   </tr>
                    </table></body></html>';

        /** Envoi du mail **/
        $entete = "Content-type: text/html; charset=utf8\r\n";
        $entete .= " MIME-Version: 1.0\r\n";
        $entete .= "To: $destinataire<".$email."> \r\n";
        $entete .= "From:suNuBus<no-reply@sunubus.sn>\r\n";
        @mail($email, $sujet, $message, $entete);

    }

    public static function envoiparametrePartenaire($destinataire, $email, $login, $password)
    {
        $sujet = "Création compte d'accès suNuBus"; //Sujet du mail

        $message = '<html><body></body><table class="table_full editable-bg-color bg_color_e6e6e6 editable-bg-image" bgcolor="#e6e6e6" width="100%" align="center"  mc:repeatable="castellab" mc:variant="Header" cellspacing="0" cellpadding="0" border="0">
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_303f9f" bgcolor="#93979a" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="25"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td>
                           <table width="50%" align="left" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                 <td align="left">
                                    <a href="#" class="editable-img">
                                       <img src="https://numherit-labs.com/demo/sunusva/assets/plugins/images/white-sunusva.png" style="display:block;max-width: 100%;height: auto;" border="0" alt="" />
                                    
                                    </a>
                                 </td>
                              </tr>
                              <tr><td height="22"></td></tr>
                           </table>
                        </td>
                     </tr>
                     <tr><td height="60"></td></tr>
                     <tr>
                        <td align="center">
                           <div class="editable-img">
                              <img src="https://numherit-labs.com/demo/sunusva/assets/plugins/images/circle-icon-password_access.png"  style="display:block; line-height:0; font-size:0; border:0;" border="0" alt="" />
                           </div>
                        </td>
                     </tr>
                     <tr><td height="40"></td></tr>
                     <tr>
                        <td align="center" class="text_color_ffffff" style="color: #ffffff; font-size: 30px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline style="color: #325186; font-weight: bold; ">
                                    Création compte d\'accès suNuBus
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="30"></td></tr>                   
                  </table>
               </td>
            </tr>
            <tr><td height="104"></td></tr>
         </table>
      </td>
   </tr>
   
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_ffffff" bgcolor="#ffffff" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="60"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td mc:edit="text011" align="left" class="center_content text_color_282828" style="color: #282828; font-size: 20px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline>
                                    Cher(e) ' .$destinataire.' , 
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="10"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline>
                                    Votre mot de passe d\'accès à suNuBus vient d\'être créé.<br/> 
                                    Vous pourrez désormais vous connecter sur la platefortme avec les paramètres suivants :<br />
                                    Login : <span style="color: #0b0b0b;">'.$login.'</span><br/> 
                                    Mot de passe : <span style="color: #0b0b0b;">'.$password.'</span><br/> 
                                    Nous vous rappelons que vos paramètres de connexion sont confidentiels.
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="20"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="5"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline style="text-align: right;">
                                    Equipe suNuBus
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr><td height="60"></td></tr>
         </table>
      </td>
   </tr>
                    </table></body></html>';

        /** Envoi du mail **/
        $entete = "Content-type: text/html; charset=utf8\r\n";
        $entete .= " MIME-Version: 1.0\r\n";
        $entete .= "To: $destinataire<".$email."> \r\n";
        $entete .= "From:suNuBus<no-reply@sunubus.sn>\r\n";
        @mail($email, $sujet, $message, $entete);

    }


    public static function date_aaaa_mm_jj($date)
    {
        $date_en = '';
        if ($date != '') {

            $jj = substr($date, 0, 2);
            $mm = substr($date, 3, 2);
            $aa = substr($date, 6, 4);

            ////////////////
            $date_en = $aa.'-'.$mm.'-'.$jj;
        }
        return $date_en;
    }

    public static function envoiMail($destinataire, $email, $code)
    {
        $sujet = "Démande de réinitialisation de mot de passe"; //Sujet du mail

        $message = '<html><body></body><table class="table_full editable-bg-color bg_color_e6e6e6 editable-bg-image" bgcolor="#e6e6e6" width="100%" align="center"  mc:repeatable="castellab" mc:variant="Header" cellspacing="0" cellpadding="0" border="0">
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_303f9f" bgcolor="#93979a" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="25"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td>
                           <table width="50%" align="left" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                 <td align="left">
                                    <a href="#" class="editable-img">
                                       <img src=https://numherit-preprod.com/sunubus//assets/plugins/images/white-sunusva.png" style="display:block;max-width: 100%;height: auto;" border="0" alt="" />
                                    
                                    </a>
                                 </td>
                              </tr>
                              <tr><td height="22"></td></tr>
                           </table>
                        </td>
                     </tr>
                     <tr><td height="60"></td></tr>
                     <tr>
                        <td align="center">
                           <div class="editable-img">
                              <img src="https://numherit-labs.com/demo/sunusva/assets/plugins/images/circle-icon-password_access.png"  style="display:block; line-height:0; font-size:0; border:0;" border="0" alt="" />
                           </div>
                        </td>
                     </tr>
                     <tr><td height="40"></td></tr>
                     <tr>
                        <td align="center" class="text_color_ffffff" style="color: #ffffff; font-size: 30px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline style="color: #325186; font-weight: bold; ">
                                    Démande d\'un nouveau mot de passe
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="30"></td></tr>                   
                  </table>
               </td>
            </tr>
            <tr><td height="104"></td></tr>
         </table>
      </td>
   </tr>
   
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_ffffff" bgcolor="#ffffff" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="60"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td mc:edit="text011" align="left" class="center_content text_color_282828" style="color: #282828; font-size: 20px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline>
                                    Cher(e) ' .$destinataire.' , 
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="10"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline>
                                    Si vous avez fait cette demande, cliquez sur le lien ci-dessous pour changer votre mot de passe en renseignant le code<br />
                                    Code : <span style="color: #0b0b0b;">'.$code.'</span><br/> 
                                    <a href="https://numherit-preprod.com/sunubus/home/confirmationCode" target="_blank">Cliquer sur ce lien pour accéder á votre compte.</a>
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="20"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="5"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline style="text-align: right;">
                                    Equipe suNuBUS
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr><td height="60"></td></tr>
         </table>
      </td>
   </tr>
                    </table></body></html>';

        /** Envoi du mail **/
        $entete = "Content-type: text/html; charset=utf8\r\n";
        $entete .= " MIME-Version: 1.0\r\n";
        $entete .= "To: <".$email."> \r\n";
        $entete .= "From:suNuBus<no-reply@sunubus.sn>\r\n";
        @mail($email, $sujet, $message, $entete);

    }
    public static function envoiMailAdmin($destinataire, $email, $code)
    {
        $sujet = "Démande de réinitialisation de mot de passe"; //Sujet du mail

        $message = '<html><body></body><table class="table_full editable-bg-color bg_color_e6e6e6 editable-bg-image" bgcolor="#e6e6e6" width="100%" align="center"  mc:repeatable="castellab" mc:variant="Header" cellspacing="0" cellpadding="0" border="0">
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_303f9f" bgcolor="#93979a" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="25"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td>
                           <table width="50%" align="left" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                 <td align="left">
                                    <a href="#" class="editable-img">
                                       <img src=https://numherit-preprod.com/sunubus//assets/plugins/images/white-sunusva.png" style="display:block;max-width: 100%;height: auto;" border="0" alt="" />
                                    
                                    </a>
                                 </td>
                              </tr>
                              <tr><td height="22"></td></tr>
                           </table>
                        </td>
                     </tr>
                     <tr><td height="60"></td></tr>
                     <tr>
                        <td align="center">
                           <div class="editable-img">
                              <img src="https://numherit-labs.com/demo/sunusva/assets/plugins/images/circle-icon-password_access.png"  style="display:block; line-height:0; font-size:0; border:0;" border="0" alt="" />
                           </div>
                        </td>
                     </tr>
                     <tr><td height="40"></td></tr>
                     <tr>
                        <td align="center" class="text_color_ffffff" style="color: #ffffff; font-size: 30px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline style="color: #325186; font-weight: bold; ">
                                    Démande d\'un nouveau mot de passe
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="30"></td></tr>                   
                  </table>
               </td>
            </tr>
            <tr><td height="104"></td></tr>
         </table>
      </td>
   </tr>
   
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_ffffff" bgcolor="#ffffff" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="60"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td mc:edit="text011" align="left" class="center_content text_color_282828" style="color: #282828; font-size: 20px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline>
                                    Cher(e) ' .$destinataire.' , 
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="10"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline>
                                    Si vous avez fait cette demande, cliquez sur le lien ci-dessous pour changer votre mot de passe en renseignant le code<br />
                                    Code : <span style="color: #0b0b0b;">'.$code.'</span><br/> 
                                    <a href="https://numherit-preprod.com/sunubus/admin/home/confirmationCode" target="_blank">Cliquer sur ce lien pour accéder á votre compte.</a>
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="20"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="5"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline style="text-align: right;">
                                    Equipe suNuBUS
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr><td height="60"></td></tr>
         </table>
      </td>
   </tr>
                    </table></body></html>';

        /** Envoi du mail **/
        $entete = "Content-type: text/html; charset=utf8\r\n";
        $entete .= " MIME-Version: 1.0\r\n";
        $entete .= "To: <".$email."> \r\n";
        $entete .= "From:suNuBus<no-reply@sunubus.sn>\r\n";
        @mail($email, $sujet, $message, $entete);

    }
    public static function envoiMailDistributeur($destinataire, $email, $code)
    {
        $sujet = "Démande de réinitialisation de mot de passe"; //Sujet du mail

        $message = '<html><body></body><table class="table_full editable-bg-color bg_color_e6e6e6 editable-bg-image" bgcolor="#e6e6e6" width="100%" align="center"  mc:repeatable="castellab" mc:variant="Header" cellspacing="0" cellpadding="0" border="0">
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_303f9f" bgcolor="#93979a" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="25"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td>
                           <table width="50%" align="left" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                 <td align="left">
                                    <a href="#" class="editable-img">
                                       <img src=https://numherit-preprod.com/sunubus//assets/plugins/images/white-sunusva.png" style="display:block;max-width: 100%;height: auto;" border="0" alt="" />
                                    
                                    </a>
                                 </td>
                              </tr>
                              <tr><td height="22"></td></tr>
                           </table>
                        </td>
                     </tr>
                     <tr><td height="60"></td></tr>
                     <tr>
                        <td align="center">
                           <div class="editable-img">
                              <img src="https://numherit-labs.com/demo/sunusva/assets/plugins/images/circle-icon-password_access.png"  style="display:block; line-height:0; font-size:0; border:0;" border="0" alt="" />
                           </div>
                        </td>
                     </tr>
                     <tr><td height="40"></td></tr>
                     <tr>
                        <td align="center" class="text_color_ffffff" style="color: #ffffff; font-size: 30px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline style="color: #325186; font-weight: bold; ">
                                    Démande d\'un nouveau mot de passe
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="30"></td></tr>                   
                  </table>
               </td>
            </tr>
            <tr><td height="104"></td></tr>
         </table>
      </td>
   </tr>
   
                    <tr>
      <td>
         <table class="table1 editable-bg-color bg_color_ffffff" bgcolor="#ffffff" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
            <tr><td height="60"></td></tr>
            <tr>
               <td>
                  <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                     <tr>
                        <td mc:edit="text011" align="left" class="center_content text_color_282828" style="color: #282828; font-size: 20px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text">
                              <span class="text_container">
                                 <multiline>
                                    Cher(e) ' .$destinataire.' , 
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="10"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline>
                                    Si vous avez fait cette demande, cliquez sur le lien ci-dessous pour changer votre mot de passe en renseignant le code<br />
                                    Code : <span style="color: #0b0b0b;">'.$code.'</span><br/> 
                                    <a href="https://numherit-preprod.com/sunubus/distributeur/home/confirmationCode" target="_blank">Cliquer sur ce lien pour accéder á votre compte.</a>
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="20"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 
                              </span>
                           </div>
                        </td>
                     </tr>
                     <tr><td height="5"></td></tr>
                     <tr>
                        <td align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                           <div class="editable-text" style="line-height: 2;">
                              <span class="text_container">
                                 <multiline style="text-align: right;">
                                    Equipe suNuBUS
                                 </multiline>
                              </span>
                           </div>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr><td height="60"></td></tr>
         </table>
      </td>
   </tr>
                    </table></body></html>';

        /** Envoi du mail **/
        $entete = "Content-type: text/html; charset=utf8\r\n";
        $entete .= " MIME-Version: 1.0\r\n";
        $entete .= "To: <".$email."> \r\n";
        $entete .= "From:suNuBus<no-reply@sunubus.sn>\r\n";
        @mail($email, $sujet, $message, $entete);

    }


    use CommonUtils;
}