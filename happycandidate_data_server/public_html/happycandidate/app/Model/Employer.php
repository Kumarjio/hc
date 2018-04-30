<?php
	class Employer extends AppModel 
	{
		var $name = 'Employer';
		var $useTable = 'employer_detail';
		var $validate = array(
								'employer_user_fname' => array(
													'alphaNumeric' => array(
																			'rule' => 'notEmpty',
																			'message' => 'First name cannot be empty',
																		   )
												   ),
								'employer_user_lname' => array(
													'alphaNumeric' => array(
																			'rule' => 'notEmpty',
																			'message' => 'Last name cannot be empty',
																		   )
												   ),
								'employer_company_name' => array(
													'alphaNumeric' => array(
																			'rule' => 'notEmpty',
																			'message' => 'Company name cannot be empty',
																		   )
												   ),
								'employer_industry_type' => array(
													'alphaNumeric' => array(
																			'rule' => 'notEmpty',
																			'message' => 'Industry type cannot be empty',
																		   )
												   ),
								'employer_contact_number' => array(
													'Numeric' => array(
																			'rule' => 'numeric',
																			'message' => 'Phone number should be in digits',
																		   )
												   )
							 ); 
							 
		public function beforeSave($options = array())
		{
		}
		
		public function fnCheckUserAccountExists($strEmail = "")
		{
			if($strEmail)
			{
				$arrReturnArray = $this->query("SELECT id FROM users WHERE email='".$strEmail."'");
				return count($arrReturnArray);
			}
			else
			{
				return false;
			}
		}
	}
?>