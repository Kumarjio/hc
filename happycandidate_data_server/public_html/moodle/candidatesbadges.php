<?php
	require_once("config.php");
	require_once($CFG->libdir. '/datalib.php');
	require_once($CFG->dirroot.'/course/lib.php');
	require_once($CFG->libdir. '/accesslib.php');
	
	global $DB;
	//$context = context_course::instance("15");
	//echo "--".$context->id;
	//$url = $CFG->wwwroot."/pluginfile.php/136/badges/badgeimage/1/f1";
	//$url = $CFG->wwwroot."/pluginfile.php/".$context->id."/badges/badgeimage/1/f1";
	
	$strUserName = $_REQUEST['username'];
	$intPortalId = $_REQUEST['portid'];

	
	
	$arrResponse = array();
	if($strUserName && $intPortalId)
	{
		$strBadgeQuery = "SELECT mdl_badge_issued.*,mdl_badge.*,mdl_course.* FROM mdl_badge_issued,mdl_badge,mdl_user,mdl_course WHERE mdl_badge.id = mdl_badge_issued.badgeid AND mdl_user.id = mdl_badge_issued.userid AND mdl_user.username = '".$strUserName."' AND mdl_course.id = mdl_badge.courseid";
		//echo "---".$strBadgeQuery = "SELECT * FROM mdl_badge";
		$strBadgeQueryExe = mysql_query($strBadgeQuery);
		$intBadgeQueryRows = mysql_num_rows($strBadgeQueryExe);
			
		if($intBadgeQueryRows)
		{
			$arrBadgesDetails = array();
			while($arrBadgesData = mysql_fetch_assoc($strBadgeQueryExe))
			{
				$intCourseId = $arrBadgesData['courseid'];
				$objCourseContextId = $context = context_course::instance($intCourseId);
				$arrBadgesData['badgeImageUrl'] = $CFG->wwwroot."/pluginfile.php/".$objCourseContextId->id."/badges/badgeimage/".$arrBadgesData['badgeid']."/f1";
				$arrBadgesDetails[] = $arrBadgesData;
			}			
			$arrResponse['status'] = "success";
			$arrResponse['badgedetail'] = $arrBadgesDetails;
		}
		else
		{
			$arrResponse['status'] = "failure";
			$arrResponse['message'] = "There are no badges for the user yet";
		}
	}
	else
	{
		$arrResponse['status'] = "failure";
		$arrResponse['message'] = "Bad Request";
	}
	echo json_encode($arrResponse);
	//print('<pre>');
	//print_r($arrResponse);
	exit;
?>