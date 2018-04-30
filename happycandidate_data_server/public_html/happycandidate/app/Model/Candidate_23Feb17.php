<?php
	class Candidate extends AppModel 
	{
		public $name = 'Candidate';
		public $useTable = 'career_portal_candidate';
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