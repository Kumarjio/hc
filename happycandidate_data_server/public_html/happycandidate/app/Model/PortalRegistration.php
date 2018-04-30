<?php
	class PortalRegistration extends AppModel 
	{
		public $name = 'PortalRegistration';
		public $useTable = 'career_portal_registration_form';
		
		public $validate = array(
								'career_registration_form_name' => array(
													'Required' => array(
																			'rule' => 'notEmpty',
																			'message' => 'You have not provided Name For Registration Form',
																		)
												   )
							 );
							 
		
							 
		public function beforeSave($options = array()) {
		}
		
		
	}
?>