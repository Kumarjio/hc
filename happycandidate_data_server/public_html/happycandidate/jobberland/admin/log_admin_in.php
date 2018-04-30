<?php
include_once("../initialise_file_location.php");

if(isset($_POST['form_param']))
{
	$intVarAdminId = $_POST['form_param'];
	$intUserId = $_POST['form_upor'];
	$strUserEmail = $_POST['form_upormai'];
	$strUserName = $_POST['form_uporna'];
	
	if($intVarAdminId)
	{
		 $boolEmpExists = Admin::find_by_email($strUserEmail);
		
		if($boolEmpExists)
		{
			$_SESSION['BackendUser']['user_id'] = $boolEmpExists->id;
			$_SESSION['BackendUser']['username'] = $boolEmpExists->username;
			$_SESSION['BackendUser']['access_level'] = "Admin";
			$_SESSION['BackendUser']['account_active'] = "Y";
			$_SESSION['BackendUser']['hcuid'] = $intUserId;
			
			$arrSessionSet = array();
			$arrSessionSet['status'] = "success";
			echo json_encode($arrSessionSet);
			exit;
		}
		else
		{
			$arrUserDetail = array();
			$arrUserDetail['uname'] = $strUserName;
			$arrUserDetail['email'] = $strUserEmail;
			$arrUserDetail['hcuid'] = $intUserId;
			
			$boolInsertResult = Admin::fnShortAdminRegistration($arrUserDetail);
			if($boolInsertResult)
			{
				$_SESSION['BackendUser']['user_id'] = $boolInsertResult;
				$_SESSION['BackendUser']['username'] = $strUserName;
				$_SESSION['BackendUser']['access_level'] = "Admin";
				$_SESSION['BackendUser']['account_active'] = "Y";
				$_SESSION['BackendUser']['hcuid'] = $intUserId;
				
				$arrSessionSet = array();
				$arrSessionSet['status'] = "success";
				echo json_encode($arrSessionSet);
				exit;
			}
			else
			{
				$arrSessionSet = array();
				$arrSessionSet['status'] = "failure";
				echo json_encode($arrSessionSet);
				exit;
			}
		}
	}
	else
	{
		$arrSessionSet = array();
		$arrSessionSet['status'] = "failure";
		echo json_encode($arrSessionSet);
		exit;
	}
}
?>