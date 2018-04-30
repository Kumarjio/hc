<?php
	/*$arr = array();
	$arr[] = "Rajendra";
	echo json_encode($arr);
	exit;*/
	//echo "HI";exit;
	if(isset($_REQUEST))
	{
		
		require('../config.php');
			
		
		$strUsername = $_REQUEST['username'];
		$strUserpassword = $_REQUEST['password'];
		$strUserPortal = $_REQUEST['candidate_portal_request'];
		$intHcUserId = $_REQUEST['hcuid'];
		$intUserType = $_REQUEST['usert_type_request'];
		$intFromSocialPlugin = $_REQUEST['social_plugin'];
		
		//echo "--".$intFromSocialPlugin;exit;
		
		if($intFromSocialPlugin)
		{
			$user = $DB->get_record('user', array('username' => $_REQUEST['username']));
		}
		else
		{
			//echo "BI";
			$user = authenticate_user_login($strUsername, $strUserpassword);
		}
		
		$res = complete_user_login($user);

		//$fh = fopen("rajendra.txt","a");
		//fwrite($fh,"---".session_id());
		//fclose($fh);
		//set_moodle_cookie($user->username);
		$arrResponse = (array) $user;
		
		if(is_array($arrResponse)  && (count($arrResponse)>0))
		{
			/*if(isset($strUserPortal))
			{
				$hc_lms_access = new stdClass();
				$hc_lms_access->lms_login_token = $arrResponse['sesskey'];
				$hc_lms_access->lms_login_session_id = session_id();
				$hc_lms_access->user_id = $user->id;
				$hc_lms_access->hc_user_id = $intHcUserId;
				$hc_lms_access->user_type = $intUserType;
				$hc_lms_access->portal_id = $strUserPortal;
				$DB->insert_record_raw('current_login_access_hc_lms', $hc_lms_access, false);
			}*/
			
			
			$arrReturn = array();
			$arrReturn['status'] = "success";
			$arrReturn['sesskey'] = $arrResponse['sesskey'];
			$arrReturn['sid'] =  session_id();
			echo json_encode($arrReturn);
			exit;
		}
		else
		{
			$arrReturn = array();
			$arrReturn['status'] = "failure";
			echo json_encode($arrReturn);
			exit;
		}
	}	
?>