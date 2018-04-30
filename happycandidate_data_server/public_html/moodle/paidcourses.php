<?php
	require_once("config.php");
	require_once($CFG->libdir. '/datalib.php');
	require_once($CFG->dirroot.'/course/lib.php');
	
	global $DB;
	
	if(isset($_REQUEST['portid']))
	{
		$payment_enrolled_courses = array();
		//echo "--".$strQ = "SELECT mdl_enrol.*,mdl_course.* FROM mdl_course,mdl_enrol,mdl_course_categories WHERE mdl_course.id = mdl_enrol.courseid AND mdl_enrol.enrol = 'paypal' AND mdl_enrol.status = '0' AND mdl_course_categories.id = mdl_course.category AND mdl_course_categories.portal_id = '".$_REQUEST['portid']."' AND mdl_course_categories.parent = '0'";
		//exit;
		$payment_enrolled_courses = $DB->get_records_sql("SELECT mdl_enrol.*,mdl_course.* FROM mdl_course,mdl_enrol,mdl_course_categories WHERE mdl_course.id = mdl_enrol.courseid AND mdl_enrol.enrol = 'paypal' AND mdl_enrol.status = '0' AND mdl_course_categories.id = mdl_course.category AND mdl_course_categories.portal_id = '".$_REQUEST['portid']."' AND mdl_course_categories.parent = '0'");
		//print("<pre>");
		//print_r($payment_enrolled_courses);
		echo json_encode($payment_enrolled_courses);
		exit;
	}
?>