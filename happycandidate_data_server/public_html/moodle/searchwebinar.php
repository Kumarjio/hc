<?php
	require_once("config.php");
	require_once($CFG->libdir. '/datalib.php');
	require_once($CFG->dirroot.'/course/lib.php');
	
	global $DB;
	
	$strCourseSearchQuery = "SELECT * FROM mdl_course,mdl_course_categories WHERE mdl_course.category = mdl_course_categories.id AND mdl_course_categories.parent != '0' AND mdl_course_categories.name = 'Webinars' AND mdl_course_categories.portal_id = '".$_REQUEST['portid']."'";
	
	$strWebinarName = "";
	if(isset($_REQUEST['webinar_name']))
	{
		$strWebinarName = $_REQUEST['webinar_name'];
	}
	
	
	if(isset($strWebinarName))
	{
		$strQueryPostedCritea = " AND mdl_course.fullname LIKE '%".$strWebinarName."%'";		
	}
	
	$strCourseSearchQuery .= $strQueryPostedCritea; 
	
	//echo "--".$strCourseSearchQuery;
	
	$objMatchingCourses = array();
	$objMatchingCourses = $DB->get_records_sql($strCourseSearchQuery);
	/*print("<pre>");
	print_r($objMatchingCourses);*/
	
	echo json_encode($objMatchingCourses);
	exit;
?>