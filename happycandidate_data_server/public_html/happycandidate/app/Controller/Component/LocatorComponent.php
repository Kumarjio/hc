<?php
App::uses('Component', 'Controller');
class LocatorComponent extends Component 
{
    public $components = array('Session','Auth');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}

	public function fnGetLocationDetail($strZipCode = "")
	{
		if($strZipCode)
		{
			$strCurlForRequest = "http://maps.googleapis.com/maps/api/geocode/json?address=".$strZipCode."&sensor=false";
			
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			//curl_setopt($ch,CURLOPT_POST, count($fields));
			//curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result,true);
			//close connection
			curl_close($ch);
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
}
?>