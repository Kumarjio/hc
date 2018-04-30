<?php
	class JobsApplied extends AppModel 
	{
		public $name = 'JobsApplied';
		public $useTable = 'candidate_job_applied';

		public function fnActiveAppliedJobsCount($intCandidateId = "", $intPortalId = "")
		{
			if($intCandidateId)
			{
				$arrCandidateJobsApplied = $this->query("SELECT COUNT(*) as jobapplication FROM candidate_job_applied, jobs WHERE jobs.id = candidate_job_applied.job_id AND jobs.is_active = '1' AND candidate_job_applied.candidate_id = '".$intCandidateId."'");
				return $arrCandidateJobsApplied['0']['0']['jobapplication'];
			}
		}
		
		public function fnActiveAppliedJobs($intCandidateId = "", $intPortalId = "")
		{
			if($intCandidateId)
			{
				$arrCandidateJobsApplied = $this->query("SELECT jobs.* FROM candidate_job_applied, jobs WHERE jobs.id = candidate_job_applied.job_id AND jobs.is_active = '1' AND candidate_job_applied.candidate_id='".$intCandidateId."'");
				return $arrCandidateJobsApplied;
			}
		}
		
		public function fnActivePendingJobsToApply($intCandidateId = "", $intPortalId = "")
		{
			if($intCandidateId)
			{
				//$arrCandidatePendingJobsToBeApplied = $this->query("SELECT jobs.* FROM jobs LEFT OUTER JOIN candidate_job_applied ON jobs.id = candidate_job_applied.job_id WHERE jobs.is_active = '1' AND candidate_job_applied.job_id IS NULL");
				
				$arrCandidatePendingJobsToBeApplied = $this->query("SELECT jobs.* FROM jobs WHERE jobs.id NOT IN (SELECT jobs.id FROM candidate_job_applied, jobs WHERE jobs.id = candidate_job_applied.job_id AND jobs.is_active = '1' AND candidate_job_applied.candidate_id='".$intCandidateId."')");
				return $arrCandidatePendingJobsToBeApplied;
			}
		}
	}
?>