<?php
	$strDateTime = date('Y-m-d H:i');
	/* $fh=fopen("hell.txt","w");
	fwrite($fh,$strDateTime);
	fclose($fh); */
	if($_SERVER['SERVER_NAME'] == "localhost")
	{
		$strCronReminderUrl = "http://localhost/happycandidate/cron/reminders";
	}
	else
	{
		$strCronReminderUrl = "http://www.rothrsolutions.com/happycandidate/cron/reminders";
	}
	
	$arrayPost = array('runfor'=>'cron','datetime'=>$strDateTime);
	$fields = $arrayPost;
	$fields_string = "";
	foreach($fields as $key=>$value) 
	{ 
		$fields_string .= $key.'='.$value.'&'; 
	}
	$fields_string = rtrim($fields_string, '&');
	
	
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $strCronReminderUrl);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	//execute post
	$result = curl_exec($ch);
	$result = json_decode($result);
	//print("<pre>");
	//print_r($result);
	//exit;
?>