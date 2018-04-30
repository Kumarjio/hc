<?php
	require_once("config.php");
	require_once($CFG->libdir. '/datalib.php');
	require_once($CFG->dirroot.'/course/lib.php');
	
	global $DB;
	
	if(isset($_REQUEST))
	{
		$arrResponse = array();
		$objCourse = new stdClass;
		$objCourse->fullname = $_POST['coursename'];
		$courseconfig = get_config('moodlecourse');
		if(isset($_REQUEST['categoryid']))
		{
			$objCourse->category = $_REQUEST['categoryid'];
		}
		else
		{
			$objCourse->category = 1;
		}
		// Apply course default settings
        $objCourse->format             = $courseconfig->format;
        $objCourse->newsitems          = $courseconfig->newsitems;
        $objCourse->showgrades         = $courseconfig->showgrades;
        $objCourse->showreports        = $courseconfig->showreports;
        $objCourse->maxbytes           = $courseconfig->maxbytes;
        $objCourse->groupmode          = $courseconfig->groupmode;
        $objCourse->groupmodeforce     = $courseconfig->groupmodeforce;
        $objCourse->visible            = $courseconfig->visible;
        $objCourse->visibleold         = $data->visible;
        $objCourse->lang               = $courseconfig->lang;
		
		$objCourseCreated = create_course($objCourse);
		if($objCourseCreated->id)
		{
			$arrResponse['status'] = "success";
			$arrResponse['courseid'] = $objCourseCreated->id;
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Please try creating course again";
		}
		echo json_encode($arrResponse);
		exit;
	}
?>