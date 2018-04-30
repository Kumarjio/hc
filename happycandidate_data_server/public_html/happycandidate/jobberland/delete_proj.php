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
	$cv_proj_setting 	= new CVContractsSetting();
	$cv_proj_setting->cv_id = $intCvId = $_REQUEST['cvid'];
	$intProjEditId = "";
	if($_REQUEST['projdeletemodeid'])
	{
		$cv_proj_setting->cv_contracts_id = $intProjEditId = $_REQUEST['projdeletemodeid'];
	}
	
	if($intProjEditId)
	{
		$intCountCompt = $cv_proj_setting->find_compt_count_by_id($intProjEditId);
		if($intCountCompt)
		{
			$isDeleted = $cv_proj_setting->delete($intProjEditId);
			if($isDeleted)
			{
				$intReminingCount = $cv_proj_setting->count_all($intCvId);
				$arrResponse['status'] = "success";
				$arrResponse['message'] = "Your details has been deleted successfully";
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