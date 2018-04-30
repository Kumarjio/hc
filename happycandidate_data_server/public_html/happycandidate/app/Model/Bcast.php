<?php
	class Bcast extends AppModel 
	{
		public $name = 'Bcast';
		public $useTable = 'email';
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