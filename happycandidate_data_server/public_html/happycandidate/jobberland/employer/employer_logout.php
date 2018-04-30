<?php
session_start();
$arrSessionSet = array();
if(isset($_SESSION['BackendUser']['access_level']))
{
	if($_SESSION['BackendUser']['access_level'] == "Recuriter" || $_SESSION['BackendUser']['access_level'] == "Admin")
	{
		$arrSessionSet['userid'] = $_SESSION['BackendUser']['hcuid'];
		$arrSessionSet['uname'] = $_SESSION['BackendUser']['username'];
		unset($_SESSION['BackendUser']);
		
		/*unset($_SESSION['BackendUser']['user_id']);
		unset($_SESSION['BackendUser']['username']);
		unset($_SESSION['BackendUser']['access_level']);
		unset($_SESSION['BackendUser']['account_active']);
		unset($_SESSION['BackendUser']['portal_id']);
		unset($_SESSION['BackendUser']['hcuid']);*/
	}
}

if(!isset($_SESSION['BackendUser']))
{
	
	$arrSessionSet['status'] = "success";
	echo json_encode($arrSessionSet);
	exit;
}
else
{
	$arrSessionSet['status'] = "failure";
	echo json_encode($arrSessionSet);
	exit;
}
?>