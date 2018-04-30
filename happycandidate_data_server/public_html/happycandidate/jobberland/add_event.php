<?php
if(isset($_POST))
{
	$intPortId = $_GET['portid'];
	$strAddEventProcessUrl = "http://".$_SERVER['SERVER_NAME']."/happycandidate/portal/updateevent/".$intPortId;
	
	$fields = $_POST;
	$fields_string = "";
	//url-ify the data for the POST
	foreach($fields as $key=>$value) 
	{ 
		$fields_string .= $key.'='.$value.'&'; 
	}
	$fields_string = rtrim($fields_string, '&');
	
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $strAddEventProcessUrl);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	//execute post
	$result = curl_exec($ch);
	echo $result;
	exit;
}
else
{
	$arrReturn = array();
	$arrReturn['status'] = "failure";
	$arrReturn['message'] = "Reuqest not set";
	
	echo json_encode($arrReturn);
	exit;
}
?>