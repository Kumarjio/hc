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
require_once (LIB_PATH.DS."class.cvawards.php");

if(isset($_REQUEST))
{
	/*print("<pre>");
	print_r($_REQUEST);
	exit;*/
	
	$arrResponse = array();
	$cv_awards_setting 	= new CVAwardsSetting();
	$cv_awards_setting->cv_awards = $_POST['cv_awards'];
	$cv_awards_setting->cv_id = $_POST['cv_id'];;
	if($_POST['award_edit_mode_id'])
	{
		$cv_awards_setting->cv_awards_id = $intCvSummaryId = $_POST['award_edit_mode_id'];
	}
	
	if($intCvSummaryId)
	{
		
		$boolCVAwardsUpdated = $cv_awards_setting->save();
		if($boolCVAwardsUpdated)
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