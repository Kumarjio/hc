<?php
include_once("initialise_file_location.php");
$intCurrentPortal = $_POST['form_uporie'];

$arrSessionSet = array();
$arrSessionSet['userid'] = $_SESSION['PortalUser_'.$intCurrentPortal]['hcuid'];
$arrSessionSet['uname'] = $_SESSION['PortalUser_'.$intCurrentPortal]['username'];
$arrSessionSet['portal'] = $intCurrentPortal;



unset($_SESSION['PortalUser_'.$intCurrentPortal]);
unset($_COOKIE['HCJPORTAL'.$intCurrentPortal]);
$_SESSION['current_portal'] = "";




/*unset($_SESSION['PortalUser_'.$intCurrentPortal]['user_id']);
unset($_SESSION['PortalUser_'.$intCurrentPortal]['username']);

unset($_SESSION['PortalUser_'.$intCurrentPortal]['account_active']);
unset($_SESSION['PortalUser_'.$intCurrentPortal]['hcuid']);
unset($_SESSION['PortalUser_'.$intCurrentPortal]['hcportalid']);*/


if(!isset($_SESSION['access_level']))
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