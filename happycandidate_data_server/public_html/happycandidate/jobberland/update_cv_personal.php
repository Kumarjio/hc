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
require_once (LIB_PATH.DS."class.cvpersonalsetting.php");

if(isset($_REQUEST))
{
	/*print("<pre>");
	print_r($_REQUEST);
	exit;*/
	
	$arrResponse = array();
	$cv_personal_setting = new CVPersonalSetting();
	// cv personal detail
	$intCvId = $_REQUEST['cv_id'];
	$cv_personal_setting->cv_personal_f_name = $_POST['cand_f_name'];
	$cv_personal_setting->cv_personal_l_name = $_POST['cand_l_name'];
	$cv_personal_setting->cv_personal_address = $_POST['cand_address'];
	$cv_personal_setting->cv_personal_address1 = $_POST['cand_address1'];
	$cv_personal_setting->cv_personal_country = $_POST['cand_country'];
	$cv_personal_setting->cv_personal_state = $_POST['cand_state'];
	$cv_personal_setting->cv_personal_district = $_POST['cand_county'];
	$cv_personal_setting->cv_personal_city = $_POST['cand_city'];
	$cv_personal_setting->cv_personal_zip_code = $_POST['cand_post_code'];
	$cv_personal_setting->cv_personal_telenumber = $_POST['cand_phone_number'];
	$cv_personal_setting->cv_personal_mob_number = $_POST['cand_mob_phone_number'];
	$cv_personal_setting->cv_personal_email = $_POST['cand_email'];
	$cv_personal_setting->cv_id = $intCvId;
	if($_POST['cand_personal_update_mode'])
	{
		$cv_personal_setting->cv_personal_detail_id = $intCvPersonalId = $_POST['cand_personal_update_mode'];
	}
	
	if($intCvPersonalId)
	{
		
		$boolCVPersonalUpdated = $cv_personal_setting->save();
		if($boolCVPersonalUpdated)
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