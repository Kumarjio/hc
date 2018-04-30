<?php
 include_once("initialise_file_location.php");
 
 $intPortId = $_REQUEST['portid'];
 $user_id = $session->get_jobseeker_id($intPortId);
 $user = Employee::find_by_id( $user_id );
 if($user->country)
 {
	$country_code = $user->country;
 }
 else
 {
	$country_code = DEFAULT_COUNTRY;
 }
 
 $location = "";
 $category = "";
 $job_type_g = "";
 $within = "";
 $career = "";
 $experience = "";
 $education = "";
 //$search_in = "1";
 //$q = "1";
 $order_by = "1";
 
$select = " SELECT job.id as job_id, job.var_name as job_var_name, job.job_title, job.job_description, job.city, job.fk_employer_id as employer_id, employer.company_name,employer.var_name as company_var_name, jobtype.type_name, job.job_salary, job.salaryfreq, job.created_at  ";
			
$from = " FROM ".TBL_JOB." AS job";
$from .= ", ". TBL_EMPLOYER. " AS employer";
$from .= ", ".TBL_CATEGORY. " AS category";
$from .= ", ".TBL_JOB_2_CAT ." AS job_cat";
$from .= ", ".TBL_JOB_TYPE . " AS jobtype";
$from .= ", ".TBL_JOB_2_TYPE." AS job2type";
$from .= ", ".TBL_JOB_STATUS. " AS jobstatus";
$from .= ", ".TBL_JOB_2_STATUS." AS job2status";

/*$where = " WHERE DATE_ADD( job.created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() 
			AND job.is_active = 'Y'
			AND job.id > 0
			AND job.job_status = 'approved' 
			AND job.country='".$country_code."' ";*/
			
$where = " WHERE DATE_ADD( job.created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() 
			AND job.is_active = 'Y'
			AND job.id > 0
			AND job.job_status = 'approved' 
			AND job.country='".$country_code."' 
			AND fk_hc_portal_id = '".$intPortId."'";
			
$where .= " AND employer.id = job.fk_employer_id ";
$where .= " AND (category.id = job_cat.category_id ";
$where .= " AND job.id = job_cat.job_id )";
$where .= " AND (jobtype.id = job2type.fk_job_type_id ";
$where .= " AND job.id = job2type.fk_job_id )";
$where .= " AND (jobstatus.id = job2status.fk_job_status_id";
$where .= " AND job.id = job2status.fk_job_id ) ";

$order = " ORDER BY job.created_at DESC";

if ( $q != "" )
{
	if ( $search_in == 1 ){
		$select .= ", match( job.job_title, job.job_description ) against ('{$q}' IN BOOLEAN MODE) as relevance";
		$where  .= " AND match( job.job_title, job.job_description ) against ('{$q}' IN BOOLEAN MODE) ";
	}else{
		$select .= ", match( job.job_title ) against ('{$q}' IN BOOLEAN MODE) as relevance";
		$where  .= " AND match( job.job_title ) against ('{$q}' IN BOOLEAN MODE) ";
	}
	
	$order = " ORDER BY relevance DESC";
}

if ( isset($location) && $location != "" )
{
	$location = strip_html( $location );
	/*
	$city_sql = " SELECT * FROM ".TBL_CITY . " WHERE countrycode='".$country_code."' ";
	
	$city_result = $db->query( $city_sql );
	$new_array=array();
	$i=0;
	while ($fetch_sql = $db->fetch_object($city_result) ){
						
		if ( strcmp(soundex(strtolower($fetch_sql->name)), soundex(strtolower($location))) == 0 ) { 
			$new_array[$i]['name'] = $fetch_sql->name;
			$new_array[$i]['code'] = $fetch_sql->name;
			//echo "<br>".levenshtein( strtolower($fetch_sql->name), strtolower($location)). $fetch_sql->name;
			$i++; 
			//exit;
		}
	}
				
	$k=0;
	for ( $j=0; $j < sizeof($new_array); $j++ ){
		$i = similar_text(strtolower($new_array[$j]['name']), strtolower($db->escape_value($location)), &$similarity_pst);
		if( $i > $k && $i > 7 ){
			$k = $i;
				$city_db_name = $new_array[$j]['name'];
				$city_code = $new_array[$j]['code'];
		}
	}
	
	if( strtolower( $city_db_name) != strtolower( $location) )
	{
		$do_you_mean="found";
		$smarty->assign('did_you_mean_name', strtolower($city_db_name) );
		$smarty->assign('city_code', $city_code);
	}
	
	//$from .= ", ". TBL_CITY . " as city ";
	//$from .= ", ". TBL_COUNTIES . " as countty ";
	//$from .= ", ". TBL_STATES . " as states ";
	
	//$where .= " AND city.code = job.city ";
	//$where .= " AND match( city.name ) AGAINST ( '{$location}*' IN BOOLEAN MODE ) ";
	
	*/
	
	$state_r = StateProvince::find_closest_states( $country_code, $location);
	if ($state_r){
		$from .= ", ". TBL_STATES . " as states ";
		$where .= " AND states.code = job.state_province ";
		$where .= " AND job.state_province='".$state_r->code."' ";
	}else{
		$county_r = County::find_closest_county( $country_code, $location);
		if ($county_r){
			$from .= ", ". TBL_COUNTIES . " as county ";
			$where .= " AND county.code = job.county ";
			$where .= " AND job.county='".$county_r->code."' ";
		}else{
			$city_r = City::find_closest_city( $country_code, $location);
			if ($city_r){
				$from .= ", ". TBL_CITY . " as city ";
				$where .= " AND city.code = job.city ";
				$where .= " AND job.city='".$city_r->code."' ";
				//$where .= " AND match( city.name ) AGAINST ( '{$location}*' IN BOOLEAN MODE ) ";
			}else{
				$where  .= " AND match( job.city, job.county, job.state_province  ) against ('{$location}' IN BOOLEAN MODE) ";
			}					
		}
	}
	
	
	
	
	//$where .= " AND (job.city='{$location}' OR city.name ='{$location}') ";
}

if ( isset($category) && $category != "" )
{
	
	$category = implode( "," , $category_selected );
	$where .= " AND job_cat.category_id IN (". $category .") ";
	//$where .= " AND job_cat.category_id ='{$category}' ";
}

if ( isset($job_type_g ) && $job_type_g != "" )
{	
	$where .= " AND ( jobtype.var_name ='{$job_type_g}' OR jobtype.id = '{$job_type_g}' ) ";
}

if ( isset($career) && $career != "" )
{	
	$from .= ", ".TBL_CAREER_DEGREE . " as career ";
	$where .= " AND career.id = fk_career_id ";
	$where .= " AND career.var_name ='".safe_output($career)."' ";
}

if ( isset($education) && $education != "" )
{	
	$from .= ", ".TBL_EDUCATION . " as education ";
	$where .= " AND education.id = fk_education_id ";
	$where .= " AND education.var_name ='".safe_output($education)."' ";
}

if ( isset($experience) && $experience != "" )
{	
	$from .= ", ".TBL_YEAR_EXPERIENCE . " as experience ";
	$where .= " AND experience.id = fk_experience_id ";
	$where .= " AND experience.var_name ='".safe_output($experience)."' ";
}

if ( isset($within) && $within != "" && $within != 0 )
{
	$end = date("Y-m-d H:i:s");// current date
	//$start   = strtotime( date("Y-m-d H:i:s", strtotime($start)) . " +{$within} day");
	
	if( $within == 0 ) $t = "today";
	else $t = "- ".$within. " days";
	
	$start   = date("Y-m-d H:i:s", strtotime("{$t}"));
	//echo DATE_ADD( $end, INTERVAL 30 DAY );
	$where .= " AND  job.created_at BETWEEN '{$start}' AND '{$end}' ";
}

if( $order_by == "0" && $q != "" ):
	$order = " ORDER BY relevance DESC ";
else:
	$order = " ORDER BY created_at DESC ";
endif;

$group_by = " GROUP BY job.id ";
$sql = $select.$from.$where. $group_by. $order;
$result = $db->query( $sql );
$num_rows = $db->num_rows( $result );

$arrReturn = array();
if($num_rows)
{
	$arrReturn['matchedjobs'] = $num_rows;
}
else
{
	$arrReturn['matchedjobs'] = "0";
}

$my_apps = JobHistory::find_by_user_id($user_id);
if(count($my_apps))
{
	$arrReturn['appliedjobs'] = count($my_apps);
}
else
{
	$arrReturn['appliedjobs'] = "0";
}



// scheduled interview queries
$arrConditions['eventtype'] = "Interview";
$arrConditions['eventsubjecttype'] = "Job";
$arrConditions['organizertype'] = "Portal";
$arrConditions['participanttype'] = "Candidate";
$arrConditions['status'] = "active";
$arrConditions['candidateid'] = $user_id;
$arrConditions['portalid'] = $intPortId;


$arrScheduledInterviewCountQuery = "SELECT events.event_id AS scheduled_interview 
FROM 
events,events_participant,event_organizer,event_subject,jobberland_job 
WHERE 
events.event_id = events_participant.event_id AND 
events.event_id = event_organizer.event_id AND 
events.event_id = event_subject.event_id AND 
events.event_type = '".$arrConditions['eventtype']."' AND 
events.event_status = '".$arrConditions['status']."' AND 
events_participant.event_participant_type = '".$arrConditions['participanttype']."' AND 
events_participant.event_participant_id = '".$arrConditions['candidateid']."' AND 
event_organizer.event_organizer_type = '".$arrConditions['organizertype']."' AND 
event_organizer.event_organizer_head_id = '".$arrConditions['portalid']."' AND 
event_subject.event_subject_type = '".$arrConditions['eventsubjecttype']."' AND
event_subject.event_subject_id = jobberland_job.id AND
jobberland_job.is_active = 'Y' AND
jobberland_job.job_status = 'approved'";

$arrScheduledInterviewCountQueryExe = $db->query($arrScheduledInterviewCountQuery);
$scheduled_interviews = $db->num_rows($arrScheduledInterviewCountQueryExe);

if($scheduled_interviews)
{
	$arrReturn['scheduledinterviews'] = $scheduled_interviews;
}
else
{
	$arrReturn['scheduledinterviews'] = "0";
}

echo json_encode($arrReturn);
exit;
?>