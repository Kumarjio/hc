<?php
include_once("../initialise_file_location.php");

$arrResponse = array();
if(isset($_REQUEST['strtime']) && isset($_REQUEST['strendtime']))
{
	$arrLatestJobs = Job::get_latest_job_as_per_time($_REQUEST['strtime'],$_REQUEST['strendtime']);
	//$arrResponse['latestjobcandidates'] = $arrLatestJobs;
	$arrLatestJobsMatchingCandidate = array();
	if(is_array($arrLatestJobs) && (count($arrLatestJobs)>0))
	{
		
		$intForCnt = 0;
		foreach($arrLatestJobs as $arrJob)
		{
			/*$fh = fopen('rajendra.txt',"w");
			fwrite($fh,print_r($arrJob,true));
			fclose($fh);*/
			
			$arrCandidateMatchFacts = array();
			$arrCandidateMatchFacts['txt_education'] = $arrJob['fk_education_id'];
			$arrCandidateMatchFacts['txt_experience'] = $arrJob['fk_experience_id'];
			$arrCandidateMatchFacts['txt_location'] = $arrJob['city'];
			$arrCandidateMatchFacts['txt_category'][] = $arrJob['category_id'];
			
			$arrJobsMatchingCandidates = Job::find_matched_cvs($arrCandidateMatchFacts);
			
			$arrLatestJobsMatchingCandidate[$intForCnt]['job'] = $arrJob;
			$arrLatestJobsMatchingCandidate[$intForCnt]['candidates'] = $arrJobsMatchingCandidates;
			$intForCnt++;
		}
		$arrResponse['status'] = "success";
		$arrResponse['latestjobcandidates'] = $arrLatestJobsMatchingCandidate;
	}
	else
	{
		$arrResponse['status'] = "fail";
		$arrResponse['message'] = "No Latest Job";
	}
}
else
{
	$arrResponse['status'] = "fail";
	$arrResponse['message'] = "Bad Url";
}

echo json_encode($arrResponse);
exit;
?>