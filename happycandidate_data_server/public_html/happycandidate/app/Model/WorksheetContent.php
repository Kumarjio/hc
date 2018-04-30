<?php
	class WorksheetContent extends AppModel 
	{
		public $name = 'WorksheetContent';
		public $useTable = 'jseeker_worksheet_content';
		
		/*public $validate = array(
								'user_name' => array(
													'alphaNumeric' => array(
																				'rule' => 'notEmpty',
																				'message' => 'Alphabets and numbers only',
																		   )
												   ),
								'userpass' => array(
													'Not Empty' => array(
																				'rule' => 'notEmpty',
																				'message' => 'Please enter your password'
													),
													'min length' => array(
																				'rule' => array('minLength', '5'),
																				'message' => 'Password Should be minimum 8 characters long'
													)
													/* 'Match Password' => array(
																				'rule' => 'matchPasswords',
																				'message'=>'Your passwords do not match'
													) */
												/*)
							 );*/
	}
?>