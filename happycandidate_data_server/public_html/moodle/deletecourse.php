<?php
	//session_write_close();
	require_once("config.php");
	//require_once($CFG->dirroot.'/course/lib.php');
	require_once($CFG->libdir. '/datalib.php');
	require_once($CFG->dirroot.'/course/externallib.php');
	
	//global $DB;
	
	/*$fh = fopen("check.txt","w");
	fwrite($fh,session_name()."---".session_id()."---".print_r($_COOKIE,true));
	fclose($fh);
	exit;*/
	if(isset($_REQUEST))
	{
		$arrResponse = array();
		$arrCourse = array();
		$arrCourse['id'] = $_REQUEST['courseid'];
		/*$fh = fopen("check.txt","w");
		fwrite($fh,print_r($arrCourse,true));
		fclose($fh);
		exit;*/

		
		
		try 
		{
			$arrDeleted = core_course_external::delete_courses($arrCourse);
			$arrResponse['status'] = "success";
		}
		catch (Exception $e)
		{
			$arrResponse['status'] = "failure";
		}
		
		
		
		//$fh = fopen("check.txt","w");
		//fwrite($fh,"---".print_r($arrDeleted,true));
		//fclose($fh);
		//exit;
		
		//print("<pre>");
		//print_r($arrDeleted);
		//exit;
		
		echo json_encode($arrResponse);
		exit;
	}
?>