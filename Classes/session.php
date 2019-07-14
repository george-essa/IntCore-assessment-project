<?php
define('sessionNewPath', dirname(__DIR__). DIRECTORY_SEPARATOR .'sessions' );

class Session extends sessionHandler{
    private $sessionNAme        = 'Goerge';
    private $sessionNewPath     = sessionNewPath;

    private $sessionLifetime    = 0;
    private $sessionPath        = '/';
    private $sessionDomain      = 'localhost';
    private $sessionSSl         = false;
    private $sessionHttpOnly    = true;

    private $sessionTtl         = 30;

    public function __construct() {
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_trans_sid', 0);
        ini_set('session.save_handler', 'files');

        session_name($this->sessionNAme);

        session_save_path($this->sessionNewPath);

        session_set_save_handler($this,true);

        session_set_cookie_params(
            $this->sessionLifetime,
            $this->sessionPath,
            $this->sessionDomain,
            $this->sessionSSl,
            $this->sessionHttpOnly
        );
    }

    public function __get ($key) {
        return $_SESSION[$key];
    }

    public function __set ($key, $value){
        $_SESSION[$key] = $value;
    }

    public function __isset($key){
        return isset($_SESSION[$key]);
    }

    public function read($id) {
        return parent::read($id);
    }

    public function write($id, $data){
        return parent::write($id,$data);
    }
    public function start() {
        if(empty(session_id())){
            if(session_start()){
                $this->sessionStartTime();
                $this->sessionValidity();
            }
        }
    }

    private function sessionStartTime(){
        if (!isset($this->sessionStartTime)){
            $this->sessionStartTime = time();
        }
    }

    private function sessionValidity(){
        if((time() - $this->sessionStartTime) > ($this->sessionTtl * 60)){
            $this->sessionIdRenewer();
        }
    }

    private function sessionIdRenewer(){
        session_regenerate_id(true);
        $this->sessionStartTime = time();
        $this->fingerPrintGenerate();


    }
    public function Kill() {
        session_unset();
        setcookie($this->sessionNAme,'',time() - 1000,$this->sessionPath,$this->sessionDomain,$this->sessionSSl,$this->sessionHttpOnly);
        session_destroy();
    }
    private function fingerPrintGenerate() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $sessionid = session_id();
        $this->fingerprint = sha1($userAgent . $sessionid);
    }

    public function fingerprintValidate(){
        if(!isset($this->fingerprint)){
            $this->fingerPrintGenerate();
        }

        $fingerprint = sha1($_SERVER['HTTP_USER_AGENT'] . session_id());

        if($this->fingerprint === $fingerprint){

            return true;
        } else {

            return false;
        }
    }
}
