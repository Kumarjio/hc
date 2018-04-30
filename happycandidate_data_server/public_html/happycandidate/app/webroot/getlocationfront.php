<?php
$arrRsponse = array();
if(isset($_POST))
{
	$strZipCode = $_POST['zip'];
	//$strCurlForRequest = "http://maps.googleapis.com/maps/api/geocode/json?address=411019&sensor=false";
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
	$arrLocationDetail = json_decode($result,true);
	//close connection
	curl_close($ch);
	/*print("<pre>");
	print_r($arrLocationDetail);
	exit;*/
	
	if($arrLocationDetail['status'] == "OK")
	{
		$arrRsponse['status'] = "success";
		if(is_array($arrLocationDetail['results']['0']['address_components']) && (count($arrLocationDetail['results']['0']['address_components'])>0))
		{
			foreach($arrLocationDetail['results']['0']['address_components'] as $arrLocationDetails)
			{
				if($arrLocationDetails['types'][0] == "locality")
				{
					$arrRsponse['locality'] = $arrLocationDetails['long_name'];
				}
				
				if($arrLocationDetails['types'][0] == "administrative_area_level_2")
				{
					$arrRsponse['city'] = $arrLocationDetails['long_name'];
				}
				
				if($arrLocationDetails['types'][0] == "administrative_area_level_1")
				{
					$arrRsponse['state'] = $arrLocationDetails['long_name'];
					$arrRsponse['statecd'] = $arrLocationDetails['short_name'];
				}
				
				if($arrLocationDetails['types'][0] == "country")
				{
					$arrRsponse['country'] = $arrLocationDetails['long_name'];
					$arrRsponse['countrycd'] = $arrLocationDetails['short_name'];
				}
			}
		}
		/*if($arrRsponse['country'])
		{
			$arrCountryDetail = $this->fnGetCountryDetail($arrRsponse['country']);
			$arrRsponse['countrycdval'] = array_pop($arrCountryDetail);
		}
		
		if($arrRsponse['state'])
		{
			$arrStateDetail = $this->fnGetStateDetail($arrRsponse['state']);
			$arrRsponse['statecdval'] = array_pop($arrStateDetail);
		}
		
		if($arrRsponse['city'])
		{
			$arrCityDetail = $this->fnGetCityDetail($arrRsponse['city']);
			$arrRsponse['cityval'] = array_pop($arrCityDetail);
		}*/
		echo json_encode($arrRsponse);exit;
	}
	else
	{
		$arrRsponse['status'] = "fail";
		echo json_encode($arrRsponse);exit;
	}
	
}
else
{
	$arrRsponse['status'] = "fail";
	echo json_encode($arrRsponse);exit;
}
?>