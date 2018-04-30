<?php
	class Bcastsent extends AppModel 
	{
		public $name = 'Bcastsent';
		public $useTable = 'email_sent';
		public $validate = array();
		
		
		public function fnGetCandidateData($intCandidateId = "")
		{
			
			if($intCandidateId)
			{
				$strSql = "SELECT * FROM career_portal_candidate WHERE candidate_id='".$intCandidateId."'";
				$arrCandidateData = $this->query($strSql);
				return $arrCandidateData;
			}
			else
			{
				return false;
			}
		}
	}
?>