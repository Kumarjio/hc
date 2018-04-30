<?php
	
	if(isset($_REQUEST))
	{
		$arrResponse = array();
		require_once('config.php');
		require_once($CFG->dirroot.'/course/lib.php');
		require_once($CFG->dirroot.'/course/editcategory_form.php');
		require_once($CFG->libdir.'/coursecatlib.php');
		require_once($CFG->libdir. '/accesslib.php');
		
		global $DB;
		
		$intPortalId = $_REQUEST['portid'];
		
		
		if($intPortalId)
		{
			//$strQ = "SELECT * FROM mdl_course_categories WHERE portal_id = '".$intPortalId."'";

			$category = $DB->get_records_sql("SELECT * FROM mdl_course_categories WHERE portal_id = '".$intPortalId."'");
			if(is_array($category) && (count($category)>0))
			{
				$intCategoryId = "";
				foreach($category as $objCat)
				{
					$intCategoryId = $objCat->id;
				}
				
				$context = context_coursecat::instance($intCategoryId,MUST_EXIST);
				$user = $DB->get_record('user', array('username' => $_REQUEST['username']));
				
				/* $fh = fopen("check.txt","w");
				//fwrite($fh,count($arrUserRole));
				fwrite($fh,$user->id);
				fclose($fh);
				exit; */
				$arrUserRole = get_user_roles($context,$user->id,true);
				
				if(is_array($arrUserRole) && (count($arrUserRole)>0))
				{
					// no need to assign role, return true
					
					$arrResponse = array();
					$arrResponse['status'] = "success";
					$arrResponse['message'] = "Role Already Assigned";
					echo json_encode($arrResponse);
					exit;
				}
				else
				{
					// assign authenticated user role to logged in user
					$intRoleId = "7";
					$intUserId = $user->id;
					$intContextId = $context->id;
					require_once($CFG->dirroot . '/' . $CFG->admin . '/roles/lib.php');
					$boolRoleAssigned = role_assign($intRoleId, $intUserId, $intContextId);
					if($boolRoleAssigned)
					{
						$arrResponse = array();
						$arrResponse['status'] = "success";
						$arrResponse['message'] = "Role Assigned";
						echo json_encode($arrResponse);
						exit;
					}
					else
					{
						$arrResponse = array();
						$arrResponse['status'] = "failure";
						$arrResponse['message'] = "Please try again some technical issue";
						echo json_encode($arrResponse);
						exit;
					}
				}
			}
			else
			{
				$arrResponse = array();
				$arrResponse['status'] = "failure";
				$arrResponse['message'] = "Category Does Not Exists";
				echo json_encode($arrResponse);
				exit;
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