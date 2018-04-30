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
require_once (LIB_PATH.DS."class.cvsummary.php");

if(isset($_REQUEST))
{
	/*print("<pre>");
	print_r($_REQUEST);
	exit;*/
	
	$arrResponse = array();
	$cv_summary_setting->cv_summary_type = $_POST['summary_type'];
	if(isset($_POST['text_sum_qual']))
	{
		$cv_summary_setting->cv_qualification_summary = $_POST['text_sum_qual'];
	}
	if(isset($_POST['text_exe_qual']))
	{
		$cv_summary_setting->cv_exe_summary = $_POST['text_exe_qual'];
	}
	$cv_summary_setting->cv_id = $_POST['cv_id'];
	if($_POST['summary_edit_mode_id'])
	{
		$cv_summary_setting->cv_summary_id = $intCvSummaryId = $_POST['summary_edit_mode_id'];
	}
	
	if($intCvSummaryId)
	{
		
		$boolCVSummaryUpdated = $cv_summary_setting->save();
		if($boolCVSummaryUpdated)
		{
			$arrResponse['status'] = "success";
			$arrResponse['message'] = "You have successfully updated the Details";
			//$arrResponse['createdid'] = $boolSkillAdded;
			//$arrResponse['accformattedcontent'] = nl2br($strProjCAccomp);
			
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