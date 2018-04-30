<?php
	
	/*$arr = file_get_contents('http://localhost/moodle/login/testlogin.php?username=raj20084u@gmail.com&pass=rajendra');
	print("<pre>");
	print_r($arr);*/
	
	
	//set POST variables
	$url = 'http://localhost/moodle/login/moodlerevert.php';
	$fields = array(
							'username' => "raj20084u@gmail.com",
							'password' => "rajendra",
					);
					
$fields_string = "";
//url-ify the data for the POST
foreach($fields as $key=>$value) 
{ 
	$fields_string .= $key.'='.$value.'&'; 
}
$fields_string = rtrim($fields_string, '&');
//open connection
//session_start();
//echo "--".session_id();
//exit;
$strCookie = 'PHPSESSID=kib4ps3oeug4nghpaq8m028ne3; path=/moodle/';
session_write_close();
$ch = curl_init();


//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_COOKIE, $strCookie ); 

//execute post
$result = curl_exec($ch);
$arrResponse = json_decode($result);
//close connection
//echo curl_error($ch);
curl_close($ch);

print("<pre>");
print_r($arrResponse);
?>