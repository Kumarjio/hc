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
require_once (LIB_PATH.DS."class.cvexperience.php");
require_once (LIB_PATH.DS."class.cvexperiencepositions.php");

if(isset($_REQUEST))
{
	$arrResponse = array();
	$cv_experience_setting 	= new CVExperienceSetting();
	if(isset($_REQUEST['cvid']))
	{
		$cv_experience_setting->cv_id = $intCvId = $_REQUEST['cvid'];
	}
	
	if(isset($_REQUEST['positiondelid']))
	{
		$intPositionDelId = $_REQUEST['positiondelid'];
	}
	
	$intExpEditId = "";
	if(isset($_REQUEST['expdeletemodeid']))
	{
		$cv_experience_setting->cv_experience_id = $intExpEditId = $_REQUEST['expdeletemodeid'];
	}
	
	if($intExpEditId)
	{
		$intCountCompt = $cv_experience_setting->find_compt_count_by_id($intExpEditId);
		if($intCountCompt)
		{
			$isDeleted = $cv_experience_setting->delete($intExpEditId);
			if($isDeleted)
			{
				$cv_eexperience_position_setting 	= new CVExperiencePositionsSetting();
				$cv_eexperience_position_setting->deleteAll($intExpEditId);
				$intReminingCount = $cv_experience_setting->count_all($intCvId);
				$arrResponse['status'] = "success";
				$arrResponse['message'] = "Your Experience has been deleted successfully";
				$arrResponse['remining'] = $intReminingCount;				
				echo json_encode($arrResponse);
				exit;
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Please try deleting your skill again";
				echo json_encode($arrResponse);
				exit;
			}
		}
	}
	else
	{
		if(!$intPositionDelId)
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Bad Request";
			echo json_encode($arrResponse);
			exit;
		}
	}
	
	if($intPositionDelId && $_REQUEST['action'] == "delpos")
	{
		$cv_eexperience_position_setting 	= new CVExperiencePositionsSetting();
		$cv_eexperience_position_setting->experience_positions_details_id = $intPositionDelId;
		$isDeleted = $cv_eexperience_position_setting->delete($intPositionDelId);
		if($isDeleted)
		{
			//$intReminingCount = $cv_eexperience_position_setting->count_all($intPositionDelId);
			$arrResponse['status'] = "success";
			$arrResponse['message'] = "Your Experience has been deleted successfully";
			//$arrResponse['remining'] = $intReminingCount;				
			echo json_encode($arrResponse);
			exit;
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Please try deleting your skill again";
			echo json_encode($arrResponse);
			exit;
		}
		
	}
	else
	{
		if(!$intExpEditId)
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Bad Request";
			echo json_encode($arrResponse);
			exit;
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