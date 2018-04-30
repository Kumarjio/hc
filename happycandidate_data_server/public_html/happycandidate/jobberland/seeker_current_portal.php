<?php
session_start();

$intCurrentPortal = $_POST['form_uporie'];

$_SESSION['current_portal'] = $intCurrentPortal;

if(!isset($_SESSION['current_portal']))
{
	$arrSessionSet = array();
	$arrSessionSet['status'] = "failure";
	echo json_encode($arrSessionSet);
	exit;
}
else
{
	$arrSessionSet = array();
	$arrSessionSet['status'] = "success";
	echo json_encode($arrSessionSet);
	exit;
}
?>