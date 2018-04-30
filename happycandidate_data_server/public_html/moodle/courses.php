<?php
	require_once("config.php");
	require_once($CFG->libdir. '/datalib.php');
	require_once($CFG->dirroot.'/course/lib.php');
	
	global $DB;
	
	$arrCourses = array();
	if(isset($_REQUEST['portid']))
	{
		$category = $DB->get_records_sql("SELECT * FROM mdl_course_categories WHERE portal_id = '".$_REQUEST['portid']."' AND parent='0'");
		/*print("<pre>");
		print_r($category);*/
		
		if(is_array($category) && (count($category)>0))
		{
			foreach($category as $objCat)
			{
				$intCategoryId = $objCat->id;
			}
			$arrCourses = get_courses($intCategoryId);
		}
		
	}
	//print("<pre>");
	//print_r($arrCourses);
	
	echo json_encode($arrCourses);
	exit;
?>