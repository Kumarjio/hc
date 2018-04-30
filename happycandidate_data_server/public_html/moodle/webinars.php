<?php
	require_once("config.php");
	require_once($CFG->libdir. '/datalib.php');
	require_once($CFG->dirroot.'/course/lib.php');
	
	global $DB;
	$arrCourses = array();
	if(isset($_REQUEST['portid']))
	{
		//echo "--".$strQ = "SELECT a.* FROM mdl_course_categories as a WHERE a.name = 'Webinars' AND a.parent IN(SELECT b.id FROM mdl_course_categories as b WHERE b.portal_id = '".$_REQUEST['portid']."' AND b.parent = '0')";
		//exit;
		$category = $DB->get_records_sql("SELECT a.* FROM mdl_course_categories as a WHERE a.name = 'Webinars' AND a.parent IN(SELECT b.id FROM mdl_course_categories as b WHERE b.portal_id = '".$_REQUEST['portid']."' AND b.parent = '0')");
		if(is_array($category) && (count($category)>0))
		{
			foreach($category as $objCat)
			{
				$intCategoryId = $objCat->id;
			}
			$arrCourses = get_courses($intCategoryId);
		}
		
	}
	print("<pre>");
	print_r($arrCourses);
	exit;
	echo json_encode($arrCourses);
	exit;
?>