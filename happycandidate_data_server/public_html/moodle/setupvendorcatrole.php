<?php	
	// this is code is for creating top level category and assigning manager role to the user
	if(isset($_REQUEST))
	{
		$arrResponse = array();
		require_once('config.php');
		require_once($CFG->dirroot.'/course/lib.php');
		require_once($CFG->dirroot.'/course/editcategory_form.php');
		require_once($CFG->libdir.'/coursecatlib.php');
		
		global $DB;
		
		$id = optional_param('id', 0, PARAM_INT);
		$editorcontext = get_system_context();
		
		
		$editoroptions = array(
			'maxfiles'  => EDITOR_UNLIMITED_FILES,
			'maxbytes'  => $CFG->maxbytes,
			'trusttext' => true,
			'context'   => $editorcontext
		);
		
		
		
		$data = new stdClass();
		$data->parent = $_REQUEST['parent'];
		$data->name = $_REQUEST['categoryname'];
		$data->idnumber = $_REQUEST['idnumber'];
		$data->description_editor = array("text"=>$_REQUEST['description'],"format"=>$_REQUEST['decriptionformat']);
		$data->id = $_REQUEST['id'];
		$data->portal_id = $_REQUEST['portal_id'];
		$strUsername = $_REQUEST['username'];
		
		/*$data = new stdClass();
		$data->parent = "0";
		$data->name = "Rohit P";
		$data->idnumber = "";
		$data->description_editor = array("text"=>"This is simple category description","format"=>"1");
		$data->id = "0";
		$data->portal_id = "13";
		$strUsername = "rohit44shauns@gmail.com";*/
		
		$user = $DB->get_record('user', array('username' => $strUsername));
		
		
		
		$newcategory = coursecat::create($data, $editoroptions);
		if($newcategory->id)
		{
			$arrResponse['categoryid'] = $newcategory->id;
			$categorycontext = context_coursecat::instance($newcategory->id);
			$intCatId = $newcategory->id;
			$intContextId = $categorycontext->id;
			$intRoleId = "1";
			$user = $DB->get_record('user', array('username' => $strUsername));
			$intUserId = $user->id;
			//$boolRoleAssigned = fnAssignContextRole($intRoleId,$intUserId,$intContextId);
			require_once($CFG->dirroot . '/' . $CFG->admin . '/roles/lib.php');
			$boolRoleAssigned = role_assign($intRoleId, $intUserId, $intContextId);
			if($boolRoleAssigned)
			{
				$strMysqlPortalIdUpdateQuery = "UPDATE mdl_course_categories SET portal_id='".$_POST['portal_id']."' WHERE id='".$newcategory->id."'";
				$strMysqlExe = mysql_query($strMysqlPortalIdUpdateQuery);
				$arrResponse['status'] = "success";
				$arrResponse['message'] = "Category created and role assigned successfully";
				
				
				echo json_encode($arrResponse);
				exit;
			}
			else
			{
				$arrResponse['status'] = "failure";
				$arrResponse['message'] = "Issue in assigning role, try again";
				echo json_encode($arrResponse);
				exit;
			}
		}
		else
		{
			$arrResponse = array();
			$arrResponse['status'] = "failure";
			$arrResponse['message'] = "Issue in creation of categroy, try again";
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


function fnAssignContextRole($intRId,$intUId,$intCId)
{
	/* $fh = fopen("check.txt","w");
	fwrite($fh,"check");
	fclose($fh); */
	require_once($CFG->dirroot . '/' . $CFG->admin . '/roles/lib.php');
	$boolRoleAssigned = role_assign($intRId, $intUId, $intCId);
	return $boolRoleAssigned;
}
?>