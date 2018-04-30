<?php
require_once('config.php');
session_start();
if(isset($_POST['logoutaction']))
{
	$intUid = $_SESSION['USER']->id;
	$intSessionKey = $_SESSION['USER']->sesskey;
	
	$arrReturnDetail = array();
	$arrReturnDetail['sess'] = $intSessionKey;
	$arrReturnDetail['id'] = $intUid;
	
	echo json_encode($arrReturnDetail);
	exit;
}
?>