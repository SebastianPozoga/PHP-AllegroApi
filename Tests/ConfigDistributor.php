<?php

namespace Tests;


class ConfigDistributor {

    private static $instance = null;
    private $config = null;

    function __construct() {
        $configPath = dirname(__FILE__).'/../Config/config.ini';
        $data = parse_ini_file($configPath);
        if($data==null) throw new \Exception("No read or decode config.ini file");
        $this->config = json_decode(json_encode($data), FALSE);
        if(!$this->config->login) throw new \Exception("Must set login for Allegro API serwer");
        if(!$this->config->password) throw new \Exception("Must set password for Allegro API serwer");
        if(!$this->config->apikey) throw new \Exception("Must set apikey for Allegro API serwer");
        if(!isset($this->config->sandbox)) throw new \Exception("Must set sandbox flag for Allegro API serwer");
        if(!$this->config->countryCode) throw new \Exception("Must set countryCode for Allegro API serwer");
    }

    public function getConfig(){
        return $this->config;
    }

    public function getParameters(){
        return [
            'username' => $this->config->username,
            'password' => $this->config->password,
            'sandbox' => $this->config->sandbox,
            'appkey' => $this->config->appkey,
            'countryCode' => $this->config->countryCode
        ];
    }


    /*
     * Singleton
     */

    /**
     * @return ConfigDistributor
     */
    public static function getInstance(){
        if(self::$instance==null){
            self::$instance = new ConfigDistributor();
        }
        return self::$instance;
    }

}