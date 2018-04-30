<?php
	class Job extends AppModel 
	{
		var $name = 'Job';
		var $useTable = 'jobberland_job';
		
		
		
		public function fnGetLatesJobForPortal($intPortalId = "")
		{
			if($intPortalId)
			{
				/*$arrReturnLatestJobArray = $this->query("SELECT jobberland_job.*,jobberland_category.cat_name FROM jobberland_job,jobberland_category,jobberland_job2category WHERE DATE_ADD( jobberland_job.created_at, INTERVAL 30 DAY ) > NOW() AND jobberland_job.is_active = 'Y' AND jobberland_job.id > 0
					   AND jobberland_job.job_status = 'approved' AND jobberland_job.fk_hc_portal_id = '".$intPortalId."' AND jobberland_job2category.job_id = jobberland_job.id AND jobberland_category.id = jobberland_job2category.category_id	ORDER by created_at DESC");*/
					   
				$arrReturnLatestJobArray = $this->query("SELECT jobberland_job.*,jobberland_category.cat_name FROM jobberland_job,jobberland_category,jobberland_job2category WHERE DATE_ADD( jobberland_job.created_at, INTERVAL 30 DAY ) > NOW() AND jobberland_job.is_active = 'Y' AND jobberland_job.id > 0
					   AND jobberland_job.job_status = 'approved' AND jobberland_job.fk_hc_portal_id = '".$intPortalId."' AND jobberland_job2category.job_id = jobberland_job.id AND jobberland_category.id = jobberland_job2category.category_id	ORDER by created_at DESC");
				
				
				return $arrReturnLatestJobArray;
			}
			else
			{
				return false;
			}
		}
				public function fnGetLatesJobForPortaldetail($intPortalId = "",$jobId)		{			if($intPortalId)			{				$arrReturnLatestJobArray = $this->query("SELECT jobberland_job.* from jobberland_job where id=".$jobId);				return $arrReturnLatestJobArray;			}			else			{				return false;			}		}		
		public function fnGetHighlightedJobForPortal($intPortalId = "")
		{
			if($intPortalId)
			{
				$arrReturnLatestJobArray = $this->query("SELECT jobberland_job.*,jobberland_category.cat_name FROM jobberland_job,jobberland_category,jobberland_job2category WHERE DATE_ADD( jobberland_job.created_at, INTERVAL 30 DAY ) > NOW() AND jobberland_job.is_active = 'Y' AND jobberland_job.id > 0
					   AND jobberland_job.job_status = 'approved' AND jobberland_job.spotlight = 'Y' AND jobberland_job.fk_hc_portal_id = '".$intPortalId."' AND jobberland_job2category.job_id = jobberland_job.id AND jobberland_category.id = jobberland_job2category.category_id	ORDER by created_at DESC");
				return $arrReturnLatestJobArray;
			}
			else
			{
				return false;
			}
		}
		
		
		
		public function fnUpdateJobAfterNotification($intJobid = "")
		{
			if($intJobid)
			{
				$strUpdateJobQuery = "UPDATE jobberland_job SET nw_job_notification = '1' WHERE id='".$intJobid."'";
				//$arrReturnLatestJobArray = $this->query("SELECT jobberland_job.*,jobberland_category.cat_name FROM jobberland_job,jobberland_category,jobberland_job2category WHERE DATE_ADD( jobberland_job.created_at, INTERVAL 30 DAY ) > NOW() AND jobberland_job.is_active = 'Y' AND jobberland_job.id > 0
					   //AND jobberland_job.job_status = 'approved' AND jobberland_job.fk_hc_portal_id = '".$intPortalId."' AND jobberland_job2category.job_id = jobberland_job.id AND jobberland_category.id = jobberland_job2category.category_id	ORDER by created_at DESC");
				
				$arrReturnLatestJobArray = $this->query($strUpdateJobQuery);
				
				return $arrReturnLatestJobArray;
			}
			else
			{
				return false;
			}
		}
	}
?>