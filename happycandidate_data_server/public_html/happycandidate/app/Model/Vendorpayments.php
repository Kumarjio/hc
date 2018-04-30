<?php
	class Vendorpayments extends AppModel 
	{
		public $name = 'Vendorpayments';
		public $useTable = 'vendor_payments';
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