<?php

namespace AllegroApi;

require "AllegroAPIException.php";

class AllegroConfig {

	public $password = null;
	public $hashPassword = null;
	public $login = null;
	public $apikey = null;
	public $countryCode = null;
	public $sandbox = null;

	function __construct(array $config) {
		$this->password = isset($config['password']) ? $config['password'] : null;
		$this->hashPassword = isset($config['hashPassword']) ? $config['hashPassword'] : null;
		$this->login = $config['login'];
		$this->apikey = $config['apikey'];
		$this->countryCode = $config['countryCode'];
		$this->sandbox = $config['sandbox'];
	}
}
