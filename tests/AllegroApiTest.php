<?php

namespace Tests;

require "../src/AllegroAPI.php";
require "ConfigDistributor.php";

use Tests\ConfigDistributor;

class AllegroApiTest extends \PHPUnit_Framework_TestCase {

    public function testCanLogin()
    {
        //config
        $config = ConfigDistributor::getInstance()->getConfig();

        //create object
        $allegroApi = new \AllegroApi($config);

        //test plain login
        // ok, if no exception
        $throwException = false;
        try{
            $allegroApi->login();
        }catch (Exception $ex){
            $throwException = true;
        }
        //no throw a exception if success
        $this->assertEquals(false, $throwException);
    }

    public function testCanLoginEnc()
    {
        //config
        $config = ConfigDistributor::getInstance()->getConfig();

        //create object
        $allegroApi = new \AllegroApi($config);

        //test plain login
        // ok, if no exception
        $throwException = false;
        try{
            $allegroApi->loginEnc();
        }catch (Exception $ex){
            $throwException = true;
        }
        //no throw a exception if success
        $this->assertEquals(false, $throwException);
    }

    public function testConstructorPreventArray()
    {
        try{
            new \AllegroApi([]);
        }catch (\AllegroApiException $ex){
            //thrown no object exception
            $this->assertEquals(\AllegroApiException::ALLOW_ONLY_OBJECT, $ex->getCode());
            $throwException = true;
        }
        // must throw exception
        $this->assertEquals(true, $throwException);
    }

    public function testCanExecuteRemoteFunction()
    {
        //config
        $config = ConfigDistributor::getInstance()->getConfig();

        //create object
        $allegroApi = new \AllegroApi($config);

        //execute remote function
        $throwException = false;
        try{
            $allegroApi->getCountries();
        }catch (Exception $ex){
            $throwException = true;
        }
        //no throw a exception if success
        $this->assertEquals(false, $throwException);
    }

    public function testDoesExecuteResultIsObject()
    {
        //config
        $config = ConfigDistributor::getInstance()->getConfig();

        //create object
        $allegroApi = new \AllegroApi($config);

        //execute remote function
        $result = $allegroApi->getCountries();
        $this->assertEquals(true, is_object($result));
    }
}
