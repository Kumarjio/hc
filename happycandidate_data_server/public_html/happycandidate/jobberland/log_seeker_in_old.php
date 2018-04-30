<?php
include_once("initialise_file_location.php");


if(isset($_REQUEST['form_param']))
{
	$intVarAdminId = $_REQUEST['form_param'];
	$intUserId = $_REQUEST['form_upor'];
	$strUserEmail = $_REQUEST['form_upormai'];
	$strUserName = $_REQUEST['form_uporna'];
	$strUserPortal = $_REQUEST['form_uporie'];
	$strSocialPlugin = $_REQUEST['form_socio'];
	
	/*$arr[] = $intVarAdminId;
	$arr[] = $intUserId;
	$arr[] = $strUserEmail;
	$arr[] = $strUserName;
	$arr[] = $strUserPortal;
	echo json_encode($arr);exit;*/
	
	
	
	if($intVarAdminId)
	{
		/*$fh = fopen("rajendra.txt","a");
		fwrite($fh,"asdashdkjhsakj".$strUserEmail."--".$strUserPortal);
		fclose($fh);*/
		
		$boolEmpExists = Employee::find_by_email_portal($strUserEmail,$strUserPortal);
		$boolEmpExists = json_decode($boolEmpExists,true);
		
		if(is_array($boolEmpExists) && (count($boolEmpExists)>0))
		{
			$fst = explode(" ", microtime());
			$fst[0] = str_replace("0.",$boolInsertResult,$fst[0]);
			//print_r($fst);
			$strNewTime = $fst[1].$fst[0];
			
			$arrLoginDetails['UniqueToken'] = $strNewTime;
			$arrLoginDetails['userid'] = $boolEmpExists['id'];
			$arrLoginDetails['hcuid'] = $intUserId;
			$arrLoginDetails['utype'] = "3";
			$arrLoginDetails['portalid'] = $strUserPortal;
			$arrLoginDetails['session_id'] = session_id();
			
			$arrLoginTokenExists = Employee::fnCheckLoginAccess($strNewTime);
			if(is_array($arrLoginTokenExists) && (count($arrLoginTokenExists)>0))
			{
				$isLoginTokenDeleted = Employee::fnDeleteLoginAccess($strNewTime);
				$boolLoginInsertResult = Employee::fnGiveLoginAccess($arrLoginDetails);
				if($boolLoginInsertResult)
				{
					$_SESSION['PortalUser_'.$strUserPortal]['user_id'] = $boolEmpExists['id'];
					$_SESSION['PortalUser_'.$strUserPortal]['username'] = $boolEmpExists['username'];
					$_SESSION['PortalUser_'.$strUserPortal]['access_level'] = "User";
					$_SESSION['PortalUser_'.$strUserPortal]['account_active'] = $boolEmpExists['is_active'];
					$_SESSION['PortalUser_'.$strUserPortal]['hcuid'] = $intUserId;
					$_SESSION['current_portal'] = $strUserPortal;
					
					$arrSessionSet = array();
					$arrSessionSet['status'] = "success";
					$arrSessionSet['st'] = $arrLoginDetails['UniqueToken'];
					echo json_encode($arrSessionSet);
					exit;
				}
				else
				{
					unset($_SESSION['PortalUser_'.$strUserPortal]);
					$_SESSION['current_portal'] = "";
					$arrSessionSet = array();
					$arrSessionSet['status'] = "failure";
					$arrSessionSet['message'] = "failed to login, please try again";
					echo json_encode($arrSessionSet);
					exit;
				}
			}
			else
			{
				$boolLoginInsertResult = Employee::fnGiveLoginAccess($arrLoginDetails);
				if($boolLoginInsertResult)
				{
					$_SESSION['PortalUser_'.$strUserPortal]['user_id'] = $boolEmpExists['id'];
					$_SESSION['PortalUser_'.$strUserPortal]['username'] = $boolEmpExists['username'];
					$_SESSION['PortalUser_'.$strUserPortal]['access_level'] = "User";
					$_SESSION['PortalUser_'.$strUserPortal]['account_active'] = $boolEmpExists['is_active'];
					$_SESSION['PortalUser_'.$strUserPortal]['hcuid'] = $intUserId;
					$_SESSION['current_portal'] = $strUserPortal;
					
					$arrSessionSet = array();
					$arrSessionSet['status'] = "success";
					$arrSessionSet['st'] = $arrLoginDetails['UniqueToken'];
					echo json_encode($arrSessionSet);
					exit;
				}
				else
				{
					unset($_SESSION['PortalUser_'.$strUserPortal]);
					$_SESSION['current_portal'] = "";
					$arrSessionSet = array();
					$arrSessionSet['status'] = "failure";
					$arrSessionSet['message'] = "failed to login, please try again";
					echo json_encode($arrSessionSet);
					exit;
				}
			}
		}
		else
		{
			$arrUserDetail = array();
			$arrUserDetail['uname'] = $strUserName;
			$arrUserDetail['email'] = $strUserEmail;
			$arrUserDetail['hcuid'] = $intUserId;
			$arrUserDetail['hcportalid'] = $strUserPortal;
			/*print("<pre>");
			print_r($arrUserDetail);exit;*/
			
			$boolInsertResult = Employee::fnShortEmployeeRegistration($arrUserDetail);
			if($boolInsertResult)
			{
				if(!$strSocialPlugin)
				{
					$fst = explode(" ", microtime());
					$fst[0] = str_replace("0.",$boolInsertResult,$fst[0]);
					//print_r($fst);
					$strNewTime = $fst[1].$fst[0];
					
					$arrLoginDetails['UniqueToken'] = $strNewTime;
					$arrLoginDetails['userid'] = $boolInsertResult;
					$arrLoginDetails['hcuid'] = $intUserId;
					$arrLoginDetails['utype'] = "3";
					$arrLoginDetails['portalid'] = $strUserPortal;
					$arrLoginDetails['session_id'] = session_id();
					
					$arrLoginTokenExists = Employee::fnCheckLoginAccess($strNewTime);
					if(is_array($arrLoginTokenExists) && (count($arrLoginTokenExists)>0))
					{
						$isLoginTokenDeleted = Employee::fnDeleteLoginAccess($strNewTime);
						$boolLoginInsertResult = Employee::fnGiveLoginAccess($arrLoginDetails);
						if($boolLoginInsertResult)
						{
							$_SESSION['PortalUser_'.$strUserPortal]['user_id'] = $boolInsertResult;
							$_SESSION['PortalUser_'.$strUserPortal]['username'] = $strUserName;
							$_SESSION['PortalUser_'.$strUserPortal]['access_level'] = "User";
							$_SESSION['PortalUser_'.$strUserPortal]['account_active'] = "Y";
							$_SESSION['PortalUser_'.$strUserPortal]['hcuid'] = $intUserId;
							$_SESSION['PortalUser_'.$strUserPortal]['hcportalid'] = $strUserPortal;
							$_SESSION['current_portal'] = $strUserPortal;
							
							$arrSessionSet = array();
							$arrSessionSet['status'] = "success";
							$arrSessionSet['st'] = $arrLoginDetails['UniqueToken'];
							echo json_encode($arrSessionSet);
							exit;
						}
						else
						{
							unset($_SESSION['PortalUser_'.$strUserPortal]);
							$_SESSION['current_portal'] = "";
							$arrSessionSet = array();
							$arrSessionSet['status'] = "failure";
							$arrSessionSet['message'] = "failed to login, please try again";
							echo json_encode($arrSessionSet);
							exit;
						}
					}
					else
					{
						$boolLoginInsertResult = Employee::fnGiveLoginAccess($arrLoginDetails);
						if($boolLoginInsertResult)
						{
							$_SESSION['PortalUser_'.$strUserPortal]['user_id'] = $boolInsertResult;
							$_SESSION['PortalUser_'.$strUserPortal]['username'] = $strUserName;
							$_SESSION['PortalUser_'.$strUserPortal]['access_level'] = "User";
							$_SESSION['PortalUser_'.$strUserPortal]['account_active'] = "Y";
							$_SESSION['PortalUser_'.$strUserPortal]['hcuid'] = $intUserId;
							$_SESSION['PortalUser_'.$strUserPortal]['hcportalid'] = $strUserPortal;
							$_SESSION['current_portal'] = $strUserPortal;			
							
							$arrSessionSet = array();
							$arrSessionSet['status'] = "success";
							$arrSessionSet['st'] = $arrLoginDetails['UniqueToken'];
							echo json_encode($arrSessionSet);
							exit;
						}
						else
						{
							unset($_SESSION['PortalUser_'.$strUserPortal]);
							$_SESSION['current_portal'] = "";
							$arrSessionSet = array();
							$arrSessionSet['status'] = "failure";
							$arrSessionSet['message'] = "failed to login, please try again";
							echo json_encode($arrSessionSet);
							exit;
						}
					}
				}
				else
				{
					$arrSessionSet = array();
					$arrSessionSet['status'] = "success";
					//$arrSessionSet['st'] = $arrLoginDetails['UniqueToken'];
					echo json_encode($arrSessionSet);
					exit;
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