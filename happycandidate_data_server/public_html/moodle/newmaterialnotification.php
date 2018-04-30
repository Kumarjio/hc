<?php
	require_once("config.php");
	require_once($CFG->libdir. '/datalib.php');
	require_once($CFG->dirroot.'/course/lib.php');
	
	global $DB;
	
	if($_REQUEST['getcandidates'] == "1")
	{
		$arrNotificationCandidates = array();
		if(isset($_REQUEST['portid']))
		{
			
			
			//echo "--".$strSql = "SELECT ccat.* FROM mdl_course_categories as ccat WHERE ccat.portal_id = '".$_REQUEST['portid']."' AND ccat.parent='0'";
			$category = $DB->get_records_sql("SELECT ccat.* FROM mdl_course_categories as ccat WHERE ccat.portal_id = '".$_REQUEST['portid']."' AND ccat.parent='0'");
			//print("<pre>");
			//print_r($category);
			if(is_array($category) && (count($category)>0))
			{			
				foreach($category as $objCat)
				{
					$arrContext = get_context_instance(CONTEXT_COURSECAT,$objCat->id,MUST_EXIST);
					//$arrUsers = get_role_users(7,$intContext);
					//echo "--".$strPortalUsers = "SELECT hccan.* FROM career_portal_candidate as hccan,mdl_user as mu,mdl_role_assignments as mra,candidate_settings as hccs WHERE mra.userid = mu.id AND mu.username = hccan.candidate_email AND mra.contextid = '".$arrContext->id."' AND hccs.candidate_id = hccan.candidate_id AND hccs.is_material_notification = '1'";
					$arrNotificationCandidates = $DB->get_records_sql("SELECT hccan.* FROM career_portal_candidate as hccan,mdl_user as mu,mdl_role_assignments as mra,candidate_settings as hccs WHERE mra.userid = mu.id AND mra.roleid = '7' AND mu.username = hccan.candidate_email AND mra.contextid = '".$arrContext->id."' AND hccs.candidate_id = hccan.candidate_id AND hccs.is_material_notification = '1'");
				}
				//print("<pre>");
				//print_r($arrNotificationCandidates);
			}
			
		}
		//print("<pre>");
		//print_r($arrNotificationCandidates);
		
		echo json_encode($arrNotificationCandidates);
		exit;
	}
	
	
	if($_REQUEST['getmaterial'] == "1")
	{
		$arrMaterialForNotification = array();
		if(isset($_REQUEST['strtime']) && isset($_REQUEST['strendtime']))
		{
			//echo "---".$sql = "SELECT mcourse.id,mcourse.fullname,mcourse.shortname,mcourse.shortname,mcourse.summaryformat,mcourse.timecreated,ccat.portal_id,ccat.name FROM mdl_course_categories as ccat,mdl_course as mcourse,career_portal as cp WHERE ccat.portal_id = cp.career_portal_id AND ccat.parent='0' AND mcourse.category = ccat.id AND mcourse.timecreated >= '".$_REQUEST['strtime']."' AND mcourse.timecreated <= '".$_REQUEST['strendtime']."'";
			//exit;
			/*$fh = fopen("query.txt","w");
			$fh = fwrite($fh,"--".$sql);
			fclose($fh);*/
			
			$arrMaterialForNotification= $DB->get_records_sql("SELECT mcourse.id,mcourse.fullname,mcourse.shortname,mcourse.shortname,mcourse.summaryformat,mcourse.timecreated,ccat.portal_id,ccat.name FROM mdl_course_categories as ccat,mdl_course as mcourse,career_portal as cp WHERE ccat.portal_id = cp.career_portal_id AND ccat.parent='0' AND mcourse.category = ccat.id AND mcourse.timecreated >= '".$_REQUEST['strtime']."' AND mcourse.timecreated <= '".$_REQUEST['strendtime']."'");
			
			//echo "--".$strQ = "SELECT mcourse.id,mcourse.fullname,mcourse.shortname,mcourse.shortname,mcourse.summaryformat,ccat.portal_id,ccat.name FROM mdl_course_categories as ccat,mdl_course as mcourse,career_portal as cp WHERE ccat.portal_id = cp.career_portal_id AND ccat.parent='0' AND mcourse.category = ccat.id";
			
			//$arrMaterialForNotification= $DB->get_records_sql("SELECT mcourse.id,mcourse.fullname,mcourse.shortname,mcourse.shortname,mcourse.summaryformat,mcourse.timecreated,ccat.portal_id,ccat.name FROM mdl_course_categories as ccat,mdl_course as mcourse,career_portal as cp WHERE ccat.portal_id = cp.career_portal_id AND ccat.parent='0' AND mcourse.category = ccat.id");
			
		}
		//print("<pre>");
		//print_r($arrMaterialForNotification);
		
		echo json_encode($arrMaterialForNotification);
		exit;
	}
?>