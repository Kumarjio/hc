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
	$cv_education_setting->cv_id = $intCvId = $_REQUEST['cvid'];
	$intEduEditId = "";
	if($_REQUEST['edudeletemodeid'])
	{
		$cv_education_setting->cv_education_id = $intEduEditId = $_REQUEST['edudeletemodeid'];
	}
	
	if($intEduEditId)
	{
		$intCountCompt = $cv_education_setting->find_compt_count_by_id($intEduEditId);
		if($intCountCompt)
		{
			$isDeleted = $cv_education_setting->delete($intEduEditId);
			if($isDeleted)
			{
				$intReminingCount = $cv_education_setting->count_all($intCvId);
				$arrResponse['status'] = "success";
				$arrResponse['message'] = "Your Education has been deleted successfully";
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
		$arrResponse['status'] = "fail";
		$arrResponse['message'] = "Bad Request";
		echo json_encode($arrResponse);
		exit;
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