<?php

require "AllegroAPIException.php";

class AllegroApi {

	const WSDL = 'https://webapi.allegro.pl/service.php?wsdl';
	const WSDL_SANDBOX = 'https://webapi.allegro.pl.webapisandbox.pl/service.php?wsdl';

	//private
	private $client = null;
	private $session = null;
	private $config = null;
	private $request = null;

	//public
	public $country_code = null;

	function __construct($config) {
		//prevents
		if(!is_object($config))
			throw new AllegroApiException("Allow only stdObject as parameter", AllegroApiException::ALLOW_ONLY_OBJECT);
		if(!$config->password && !$config->hashPassword )
			throw new AllegroApiException("Must set password for Allegro API serwer", AllegroApiException::PARAMETER_INCORECT);
		if(!$config->login)
			throw new AllegroApiException("Must set login for Allegro API serwer", AllegroApiException::PARAMETER_INCORECT);
		if(!$config->apikey)
			throw new AllegroApiException("Must set apikey for Allegro API serwer", AllegroApiException::PARAMETER_INCORECT);
		if(!isset($config->sandbox))
			throw new AllegroApiException("Must set sandbox flag for Allegro API serwer", AllegroApiException::PARAMETER_INCORECT);
		if(!$config->countryCode)
			throw new AllegroApiException("Must set countryCode for Allegro API serwer", AllegroApiException::PARAMETER_INCORECT);

		//save data
		$this->config = $config;

		//math wsdl
		$wsdl = (isset($config->sandbox) && (int)$config->sandbox)? self::WSDL_SANDBOX : self::WSDL;

		//crete client
		$this->client = new SoapClient($wsdl, array(
			'features' => SOAP_SINGLE_ELEMENT_ARRAYS
		));

		//create request id data
		$this->request = array(
			'countryId' => $config->countryCode, //for old function - example: doGetShipmentData
			'countryCode' => $config->countryCode, //for new function
			'webapiKey' => $config->apikey,
			'localVersion' => $this->loadVersionKey($config->countryCode)
		);
	}

	/**
	 * This function is not safe. Always hash password before use and STORAGE it.
	 *
	 * @deprecated
	 */
	function login() {
		//always safe login method (hash password if is not hashed)
		if(!isset($this->config->hashPassword)){
			//prevents
			if(!$this->config->password){
				throw new AllegroApiException("No set password to login");
			}
			//do
			$this->config->hashPassword =  base64_encode(hash('sha256', $this->config->password, true));
		}
		$this->loginEnc();
	}

	function loginEnc() {
		//prevents
		if(!$this->config->hashPassword){
			throw new AllegroApiException("No set sha256 hash password to login");
		}

		//login enc
		$request = $this->buildRequest(array(
			'userLogin' => $this->config->login,
			'userHashPassword' => $this->config->hashPassword
		));

		//add session to request
		$this->session = $this->client->doLoginEnc($request);
		$this->request['sessionId'] = $this->session->sessionHandlePart;	//for new functions
		$this->request['sessionHandle'] = $this->session->sessionHandlePart; //for older functions
	}

	protected function buildRequest($data) {
		return array_replace_recursive($this->request, (array) $data);
	}

	protected function buildResponse($obj) {
		return $obj;
	}


	/*
	 * MAGIC METHODS
	 */

	function __call($name, $arguments) {
		//prepare data
		$params = isset($arguments[0]) ? (array)$arguments[0] : array();
		$request = $this->buildRequest($params);

		//add 'do' to short function name
		$fname = 'do'.ucfirst($name);

		//call SOAP function
		$responseData = $this->client->$fname($request);
		return $this->buildResponse($responseData);
	}

	/*
	 * HELPERS
	 */

	private function loadVersionKey($countryCode){
		$sys = $this->client->doQueryAllSysStatus(array(
			'countryId' => $this->config->countryCode,
			'webapiKey' => $this->config->apikey
		));
		foreach ($sys->sysCountryStatus->item as $row) {
			if($row->countryId==$countryCode) return $row->verKey;
		}
		throw new Exception("No find country by code: ${$countryCode}");
	}

}
