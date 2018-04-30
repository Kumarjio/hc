<?php
defined('DS') ? null : define("DS", DIRECTORY_SEPARATOR);
$dir = dirname(__FILE__);
$dir = preg_split ('%[/\\\]%', $dir);
//$blank = array_pop($dir);
$dir = implode('/', $dir);
defined('SITE_ROOT') 	? null : define('SITE_ROOT', $dir );
defined('PUBLIC_PATH') 	? null : define('PUBLIC_PATH', SITE_ROOT  );
defined('LIB_PATH')		? null : define('LIB_PATH', PUBLIC_PATH . DS . 'libs');
require_once (LIB_PATH.DS."class.databaseobject.php");
//require_once (LIB_PATH.DS."class.employee.php");
require_once (LIB_PATH.DS."class.cvcompetancies.php");

if(isset($_REQUEST))
{
	$arrResponse = array();
	$cv_cpmpetancies_setting 	= new CVCompetanciesSetting();
	$cv_cpmpetancies_setting->cv_competancies_skill = $strSkillName = $_REQUEST['skilname'];
	$cv_cpmpetancies_setting->cv_competancy_skill_year = $strSkillExpYear = $_REQUEST['skillexpyear'];
	$cv_cpmpetancies_setting->cv_competancy_skill_month = $strSkillExpMonth = $_REQUEST['skillexpmonth'];
	$cv_cpmpetancies_setting->cv_competancy_skill_from_date = $strSkillExpFrmDate = $_REQUEST['skillexpfrmdate'];
	$cv_cpmpetancies_setting->cv_competancy_skill_to_date = $strSkillExpToDate = $_REQUEST['skillexptodate'];
	$cv_cpmpetancies_setting->cv_id = $intCvId = $_REQUEST['cvid'];
	$intComptEditId = "";
	if($_REQUEST['compteditmodeid'])
	{
		$cv_cpmpetancies_setting->cv_competancies_id = $intComptEditId = $_REQUEST['compteditmodeid'];
	}
	
	if($intComptEditId)
	{
		if($cv_cpmpetancies_setting->find_by_id_for_update($intCvId,$strSkillName,$intComptEditId))
		{
			// send message skill already exists
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "You have already added this skill ";
			echo json_encode($arrResponse);
			exit;
		}
		else
		{
			$boolSkillAdded = $cv_cpmpetancies_setting->save();
			if($boolSkillAdded)
			{
				$arrResponse['status'] = "success";
				$arrResponse['message'] = "You have successfully updated your skill";
				$arrResponse['createdid'] = $boolSkillAdded;
				$arrResponse['skillfrmdate'] = date("M j, Y",strtotime($cv_cpmpetancies_setting->cv_competancy_skill_from_date));  
				$arrResponse['skilltodate'] = date("M j, Y",strtotime($cv_cpmpetancies_setting->cv_competancy_skill_to_date));
				
				echo json_encode($arrResponse);
				exit;
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Please try updating your skill again";
				echo json_encode($arrResponse);
				exit;
			}
		}
	}
	else
	{
		if($cv_cpmpetancies_setting->find_by_id($intCvId,$strSkillName))
		{
			// send message skill already exists
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "You have already added this skill ";
			echo json_encode($arrResponse);
			exit;
		}
		else
		{
			// create skill for the cv
			$boolSkillAdded = $cv_cpmpetancies_setting->save();
			if($boolSkillAdded)
			{
				$arrResponse['status'] = "success";
				$arrResponse['message'] = "You have successfully added this skill";
				$arrResponse['createdid'] = $boolSkillAdded;
				$arrResponse['skillfrmdate'] = date("M j, Y",strtotime($cv_cpmpetancies_setting->cv_competancy_skill_from_date));  
				$arrResponse['skilltodate'] = date("M j, Y",strtotime($cv_cpmpetancies_setting->cv_competancy_skill_to_date));
				
				echo json_encode($arrResponse);
				exit;
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Please try adding your skill again";
				echo json_encode($arrResponse);
				exit;
			}
		}
	}
}
else
{
	$arrResponse['status'] = "fail";
	$arrResponse['message'] = "Bad Request";
	echo json_encode($arrResponse);
	exit;
}
?>