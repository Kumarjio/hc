<?php
//error_reporting(E_ALL);echo "HI";exit;
defined('DS') ? null : define("DS", DIRECTORY_SEPARATOR);
$dir = dirname(__FILE__);
$dir = preg_split ('%[/\\\]%', $dir);
//$blank = array_pop($dir);
$dir = implode('/', $dir);
defined('SITE_ROOT') 	? null : define('SITE_ROOT', $dir );
defined('PUBLIC_PATH') 	? null : define('PUBLIC_PATH', SITE_ROOT  );
defined('LIB_PATH')		? null : define('LIB_PATH', PUBLIC_PATH . DS . 'libs');
require_once (LIB_PATH.DS."class.databaseobject.php");
require_once (LIB_PATH.DS."class.employee.php");
//print("<pre>");print_r($_REQUEST);exit;

if(isset($_REQUEST['form_param']))
{
	$strSocialPlugin = "";
	$intVarAdminId = $_REQUEST['form_param'];
	$intUserId = $_REQUEST['form_upor'];
	$strUserEmail = $_REQUEST['form_upormai'];
	$strUserName = $_REQUEST['form_uporna'];
	$strUserPortal = $_REQUEST['form_uporie'];
	if(isset($_REQUEST['form_socio']))
	{
		$strSocialPlugin = $_REQUEST['form_socio'];
	}
	
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
			$fst[0] = str_replace("0.",$boolEmpExists['id'],$fst[0]);
			//print_r($fst);
			$strNewTime = $fst[1].$fst[0];
			
			$arrLoginDetails['UniqueToken'] = $strNewTime;
			$arrLoginDetails['userid'] = $boolEmpExists['id'];
			$arrLoginDetails['hcuid'] = $intUserId;
			$arrLoginDetails['utype'] = "3";
			$arrLoginDetails['portalid'] = $strUserPortal;
			//$arrLoginDetails['session_id'] = session_id();
			$strSessionVariableName = "HCJPORTAL".$strUserPortal;
			session_name($strSessionVariableName);
			if(!$strSocialPlugin)
			{
				setcookie($strSessionVariableName,"");
			}
			session_start();
			if(!$strSocialPlugin)
			{
				setcookie($strSessionVariableName,session_id(),0,'/');
			}
			
			$_SESSION['PortalUser_'.$strUserPortal]['user_id'] = $boolEmpExists['id'];
			$_SESSION['PortalUser_'.$strUserPortal]['username'] = $boolEmpExists['username'];
			$_SESSION['PortalUser_'.$strUserPortal]['access_level'] = "User";
			$_SESSION['PortalUser_'.$strUserPortal]['account_active'] = $boolEmpExists['is_active'];
			$_SESSION['PortalUser_'.$strUserPortal]['hcuid'] = $intUserId;
			$_SESSION['current_portal'] = $strUserPortal;
			
			//$fh = fopen("rajendra.txt","a");
			//fwrite($fh,$strSessionVariableName."asdashdkjhsakj".$strUserEmail."--".$strUserPortal);
			//fclose($fh);
			
			$arrSessionSet = array();
			$arrSessionSet['status'] = "success";
			$arrSessionSet['st'] = $arrLoginDetails['UniqueToken'];
			$arrSessionSet['sid'] = session_id();
			echo json_encode($arrSessionSet);
			exit;
		}
		else
		{
			$arrUserDetail = array();
			$arrUserDetail['uname'] = $strUserName;
			$arrUserDetail['email'] = $strUserEmail;
			$arrUserDetail['hcuid'] = $intUserId;
			$arrUserDetail['hcportalid'] = $strUserPortal;
			
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
					//$arrLoginDetails['session_id'] = session_id();
					$strSessionVariableName = "HCJPORTAL".$strUserPortal;
					session_name($strSessionVariableName);
					setcookie($strSessionVariableName,"");
					session_start();
					setcookie($strSessionVariableName,session_id(),0,'/');
					
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