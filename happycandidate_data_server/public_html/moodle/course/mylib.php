<?php
	require_once("../config.php");
	require_once($CFG->libdir. '/coursecatlib.php');
	require_once($CFG->libdir. '/accesslib.php');
	global $USER;
	$categoryid = optional_param('categoryid', 0, PARAM_INT); // Category id
	$coursecat = coursecat::get($categoryid);
	$arrCourseCat = $coursecat->get_children();
	$arrEnrolledCategoryId = array();
	if(is_array($arrCourseCat) && (count($arrCourseCat)>0))
	{
		foreach($arrCourseCat as $arrCatKey=>$arrCatVal)
		{
			$context = context_coursecat::instance($arrCatKey,MUST_EXIST);
			$arrUserRole = get_user_roles($context,$USER->id,true);
			if(is_array($arrUserRole) && (count($arrUserRole)>0))
			{
				$arrEnrolledCategoryId[] = $arrCatKey;
			}
		}
	}
	/* print("<pre>");
	print_r($arrEnrolledCategoryId); */
	
	if(is_array($arrEnrolledCategoryId) && (count($arrEnrolledCategoryId)>0))
	{
		$categoryid = $arrEnrolledCategoryId[0];
	}
	//echo $categoryid;
	/* print("<pre>");
	print_r($arrEnrolledCategoryId); */
?>