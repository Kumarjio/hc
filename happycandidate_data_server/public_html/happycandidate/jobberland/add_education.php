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
require_once (LIB_PATH.DS."class.cveducation.php");

if(isset($_REQUEST))
{
	$arrResponse = array();
	$cv_education_setting 	= new CVEducationSetting();
	$cv_education_setting->cv_education_highest = $strEducation = trim($_REQUEST['eduname']);
	$cv_education_setting->cv_education_school_uni_name = $strUniversity = trim($_REQUEST['eduuni']);
	$cv_education_setting->cv_education_location = $strLocation = trim($_REQUEST['edulocation']);
	$cv_education_setting->cv_education_continue = $strContinueEdu = trim($_REQUEST['educontinue']);
	$cv_education_setting->cv_id = $intCvId = $_REQUEST['cvid'];
	$intEduEditId = "";
	if($_REQUEST['edueditmodeid'])
	{
		$cv_education_setting->cv_education_id = $intEduEditId = $_REQUEST['edueditmodeid'];
	}
	
	if($intEduEditId)
	{
		if($cv_education_setting->find_by_id_for_update($intCvId,$strEducation,$intEduEditId))
		{
			// send message skill already exists
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "You have already added this Education ";
			echo json_encode($arrResponse);
			exit;
		}
		else
		{
			$boolSkillAdded = $cv_education_setting->save();
			if($boolSkillAdded)
			{
				$arrResponse['status'] = "success";
				$arrResponse['message'] = "You have successfully updated your Education";
				$arrResponse['createdid'] = $boolSkillAdded;
				
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
		if($cv_education_setting->find_by_id($intCvId,$strEducation))
		{
			// send message skill already exists
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "You have already added this Education ";
			echo json_encode($arrResponse);
			exit;
		}
		else
		{
			// create skill for the cv
			$boolSkillAdded = $cv_education_setting->save();
			if($boolSkillAdded)
			{
				$arrResponse['status'] = "success";
				$arrResponse['message'] = "You have successfully added this Education";
				$arrResponse['createdid'] = $boolSkillAdded;
				
				$arrResponse['printhtml'] = '<div id="education_data_container_'.$boolSkillAdded.'" style="float:left;width:68%;margin-right:2%;margin-top:10px;">
					<div id="label" style="float:left;width:48%;margin-right:2%;">
						<label style="font-weight:bold;">Education:</label>
					</div>
					<div id="edu_quali_data_'.$boolSkillAdded.'" style="float:left;width:48%;margin-right:2%;">
						'.$strEducation.'
					</div>
					<div id="label" style="float:left;width:48%;margin-right:2%;">
						<label style="font-weight:bold;">School / University:</label>
					</div>
					<div id="edu_school_data_'.$boolSkillAdded.'" style="float:left;width:48%;margin-right:2%;">
						'.$strUniversity.'
					</div>
					<div id="label" style="float:left;width:48%;margin-right:2%;">
						<label style="font-weight:bold;">Location:</label>
					</div>
					<div id="edu_location_data_'.$boolSkillAdded.'" style="float:left;width:48%;margin-right:2%;">
						'.$strLocation.'
					</div>
					<div id="label" style="float:left;width:48%;margin-right:2%;">
						<label style="font-weight:bold;">Continuing Education Classes:</label>
					</div>
					<div id="edu_continue_data_'.$boolSkillAdded.'" style="float:left;width:48%;margin-right:2%;">
						'.$strContinueEdu.'
					</div>
				</div><div id="action_'.$boolSkillAdded.'" style="float:left;width:18%;margin-right:2%;margin-top:10px;">
					<a href="javascript:void(0);" onclick="fnEditEducation(\''.$boolSkillAdded.'\')">Edit</a>&nbsp;<a onclick="fnDeleteEducation(\''.$boolSkillAdded.'\')" href="javascript:void(0);">Delete</a>
				</div>';
				
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