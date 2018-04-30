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
require_once (LIB_PATH.DS."class.cvcontracts.php");

if(isset($_REQUEST))
{
	$arrResponse = array();
	$cv_project_setting 	= new CVContractsSetting();
	$cv_project_setting->cv_contracts_name = $strContractName = trim($_REQUEST['contractorname']);
	$cv_project_setting->cv_contracts_company_name = $strProjCompName = trim($_REQUEST['projcname']);
	$cv_project_setting->cv_contracts_job_title = $strProjCTitle = trim($_REQUEST['projctitle']);
	$cv_project_setting->cv_contracts_job_duration_years = $strProjYearsDuration = trim($_REQUEST['projduration']);
	$cv_project_setting->cv_contracts_job_duration_months = $strProjMonthsDuration = trim($_REQUEST['projdurationm']);
	$cv_project_setting->cv_contracts_accomplishments = $strProjCAccomp = trim($_REQUEST['projaccmp']);
	$cv_project_setting->cv_id = $intCvId = $_REQUEST['cvid'];
	$intProjEditId = "";
	if($_REQUEST['projeditmodeid'])
	{
		$cv_project_setting->cv_contracts_id = $intProjEditId = $_REQUEST['projeditmodeid'];
	}
	
	if($intProjEditId)
	{
		$boolSkillAdded = $cv_project_setting->save();
		if($boolSkillAdded)
		{
			$arrResponse['status'] = "success";
			$arrResponse['message'] = "You have successfully updated the Details";
			$arrResponse['createdid'] = $boolSkillAdded;
			$arrResponse['accformattedcontent'] = nl2br($strProjCAccomp);
			
			echo json_encode($arrResponse);
			exit;
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Please try updating your Details again";
			echo json_encode($arrResponse);
			exit;
		}
		
		/*if($cv_project_setting->find_by_id_for_update($intCvId,$intProjEditId,$strContractName,$strProjCompName))
		{
			// send message skill already exists
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "You have already added this Details ";
			echo json_encode($arrResponse);
			exit;
		}
		else
		{
		}*/
	}
	else
	{
		// create skill for the cv
		$boolSkillAdded = $cv_project_setting->save();
		if($boolSkillAdded)
		{
			$arrResponse['status'] = "success";
			$arrResponse['message'] = "You have successfully added your Experience";
			$arrResponse['createdid'] = $boolSkillAdded;
			
			$arrResponse['printhtml'] = '<div id="proj_data_container_'.$boolSkillAdded.'" style="float:left;width:68%;margin-right:2%;margin-top:10px;">
					<div id="label" style="float:left;width:48%;margin-right:2%;">
						<label style="font-weight:bold;">Contractor Name:</label>
					</div>
					<div id="proj_contract_name_data_'.$boolSkillAdded.'" style="float:left;width:48%;margin-right:2%;">
						'.$strContractName.'
					</div>
					<div id="label" style="float:left;width:48%;margin-right:2%;">
						<label style="font-weight:bold;">Company Name:</label>
					</div>
					<div id="proj_cname_data_'.$boolSkillAdded.'" style="float:left;width:48%;margin-right:2%;">
						'.$strProjCompName.'
					</div>
					<div id="label" style="float:left;width:48%;margin-right:2%;">
						<label style="font-weight:bold;">Job Title:</label>
					</div>
					<div id="proj_jtitle_data_'.$boolSkillAdded.'" style="float:left;width:48%;margin-right:2%;">
						'.$strProjCTitle.'
					</div>
					<div id="label" style="float:left;width:48%;margin-right:2%;">
						<label style="font-weight:bold;">Duration:</label>
					</div>
					<div id="proj_duration_data_'.$boolSkillAdded.'" style="float:left;width:48%;margin-right:2%;">
						<span id="proj_years_data_'.$boolSkillAdded.'">'.$strProjYearsDuration.'</span> years <span id="proj_months_data_'.$boolSkillAdded.'">'.$strProjMonthsDuration.'</span> months
					</div>
					<div id="label" style="float:left;width:48%;margin-right:2%;">
						<label style="font-weight:bold;">Accomplishments:</label>
					</div>
					<div id="proj_accom_data_'.$boolSkillAdded.'" style="float:left;width:48%;margin-right:2%;">
						'.nl2br($strProjCAccomp).'
					</div>
				</div>
				<div id="proj_action_'.$boolSkillAdded.'" style="float:left;width:18%;margin-right:2%;margin-top:10px;">
					<a href="javascript:void(0);" onclick="fnEditProject(\''.$boolSkillAdded.'\')">Edit</a>&nbsp;<a href="javascript:void(0);" onclick="fnDeleteProject(\''.$boolSkillAdded.'\')">Delete</a>
				</div>';
			
			echo json_encode($arrResponse);
			exit;
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Please try adding your details again";
			echo json_encode($arrResponse);
			exit;
		}
		
		/*if($cv_project_setting->find_by_id($intCvId,$strContractName,$strProjCompName))
		{
			// send message skill already exists
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "You have already added these Experience ";
			echo json_encode($arrResponse);
			exit;
		}
		else
		{
		
		}*/
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