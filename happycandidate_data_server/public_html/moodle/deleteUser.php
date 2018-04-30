<?php
	// this is code is for creating top level category and assigning manager role to the user
	if(isset($_REQUEST))
	{
		$arrResponse = array();
		require_once('config.php');
		require_once($CFG->dirroot.'/user/lib.php');
		//require_once($CFG->dirroot.'/course/editcategory_form.php');
		//require_once($CFG->libdir.'/coursecatlib.php');
		global $DB;
		
		$strUserId =  $_REQUEST['uname'];
		
		if($strUserId)
		{
			$user = $DB->get_record('user', array('username' => $strUserId));
			$objUser = $user;
			$user = (array) $user;
			/*print("<pre>");
			print_r($user);
			exit;*/
			if(is_array($user) && (count($user)>0))
			{
				$isUserDeleted = user_delete_user($objUser);
				if($isUserDeleted)
				{
					$arrResponse = array();
					$arrResponse['status'] = "success";
					$arrResponse['message'] = "User deleted successfully";
					echo json_encode($arrResponse);
					exit;
				}
				else
				{
					$arrResponse = array();
					$arrResponse['status'] = "failure";
					$arrResponse['message'] = "Please try again";
					echo json_encode($arrResponse);
					exit;
				}
			}
			else
			{
				$arrResponse = array();
				$arrResponse['status'] = "failure";
				$arrResponse['message'] = "There is no such user exists";
				echo json_encode($arrResponse);
				exit;
			}
		}
	}
	else
	{
		$arrResponse = array();
		$arrResponse['status'] = "failure";
		$arrResponse['message'] = "Bad Request";
		echo json_encode($arrResponse);
		exit;
	}
?>