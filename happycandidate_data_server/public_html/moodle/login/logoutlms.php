<?php
	require_once('../config.php');
	$sesskey = optional_param('sesskey', '__notpresent__', PARAM_RAW); // we want not null default to prevent required sesskey warning
	
	if(isloggedin())
	{
		require_logout();		
		//unset()
		//$logginlms = $DB->get_record('current_login_access_hc_lms', array('lms_login_token'=>$sesskey));
		//$logginlms = json_encode($logginlms);
		//$logginlms = json_decode($logginlms,true);
		//if(is_array($logginlms) && (count($logginlms)>0))
		//{
			//$DB->delete_records('current_login_access_hc_lms', array('lms_login_token'=>$sesskey));
		//}
	}
	if(isloggedin())
	{
		$arrResponse = array();
		$arrResponse['status'] = "failure";
	}
	else
	{
		$arrResponse = array();
		$arrResponse['status'] = "success";
	}
	echo json_encode($arrResponse);
	exit;
?>