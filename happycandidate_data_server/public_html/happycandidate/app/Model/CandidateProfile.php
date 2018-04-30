<?php
	class CandidateProfile extends AppModel 
	{
		public $name = 'CandidateProfile';
		public $useTable = 'jobberland_employee';
		public $validate = array();
		
		
		public function fnGetCandidateData($intCandidateId = "")
		{
			
			if($intCandidateId)
			{
				$strSql = "SELECT * FROM jobberland_employee WHERE hc_uid='".$intCandidateId."'";
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