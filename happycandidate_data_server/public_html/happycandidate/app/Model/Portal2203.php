<?php
	class Portal extends AppModel 
	{
		public $name = 'Portal';
		public $useTable = 'career_portal';
		
		public $validate = array(
								'career_portal_name' => array(
													'Required' => array(
																			'rule' => 'notEmpty',
																			'message' => 'You have not provided Portal Name',
																		),
													'Alphanumeric' => array(
																			'rule' => 'alphaNumeric',
																			'message' => 'Portal name cannot contain Alphanumeric Characters',
													)
												   ),
								'career_portal_logo' => array(
													'Not Empty'	=>	array(
																			'rule' => 'notEmpty',
																			"message"=>"You have not provided Portal Logo"
																		),
													'Extension'	=>	array(
																			'rule' => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
																			"message"=>"Provided Logo is not valid, Please provide valid image file"
																		)
												)
							 );
							 
		
							 
		public function beforeSave($options = array()) {
			/* if (isset($this->data['User']['password'])) {
				$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
			}
			return true; */
		}
		
		
	}
?>