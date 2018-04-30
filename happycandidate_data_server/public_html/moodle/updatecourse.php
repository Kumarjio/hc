<?php
	require_once("config.php");
	require_once($CFG->libdir. '/datalib.php');
	require_once($CFG->dirroot.'/course/externallib.php');
	
	global $DB;
	
	//$fh = fopen("updateerror.txt","w");
	//fwrite($fh,"hello");
	//fclose($fh);
	
	
	if(isset($_REQUEST))
	{
		$arrResponse = array();
		$objCourse = array();
		$objCourse[0]['fullname'] = $_REQUEST['coursename'];
		//$objCourse[0]['fullname'] = "Test V Course";
		$objCourse[0]['id'] = $_REQUEST['courseid'];
		//$objCourse[0]['id'] = "34";
		//$objCourse[0]['categoryid'] = "1";
		if(isset($_REQUEST['categoryid']))
		{
			$objCourse[0]['categoryid'] = $_REQUEST['categoryid'];
		}
		
		$objCourseCreated = core_course_external::update_courses($objCourse);
		
		
		if(is_array($objCourseCreated['warnings']) && (count($objCourseCreated['warnings'])>0))
		{
			$arrResponse['status'] = "fail";
			$arrResponse['courseid'] = $objCourse[0]['id'];
			$arrResponse['message'] = $objCourseCreated['warnings'][0]['message'];
		}
		else
		{
			$arrResponse['status'] = "success";
		}
		
		//$fh = fopen('check.txt','w');
		//fwrite($fh,print_r($arrResponse,true));
		//fclose($fh);
		//exit;
		echo json_encode($arrResponse);
		exit;
	}
?>