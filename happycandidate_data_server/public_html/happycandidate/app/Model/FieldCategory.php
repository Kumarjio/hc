<?php
	class FieldCategory extends AppModel 
	{
		public $name = 'FieldCategory';
		public $useTable = 'field_category';
		
		/* public $validate = array(
								'username' => array(
													'alphaNumeric' => array(
																				'rule' => 'notEmpty',
																				'message' => 'Alphabets and numbers only',
																		   )
												   ),
								'email' => array(
													'Not Empty'	=>	array(
																				'rule' => 'email',
																				"message"=>"Provided email address was not correct"
																		)
												),
								'pass' => array(
													'Not Empty' => array(
																				'rule' => 'notEmpty',
																				'message' => 'Please enter your password'
													),
													'min length' => array(
																				'rule' => array('minLength', '5'),
																				'message' => 'Password Should be minimum 8 characters long'
													)
												)
							 ); */
							 
		public function matchPasswords($data) {
			if ($data['pass'] == $this->data['User']['new_password_again']) {
				return true;
			}
			return false;
		}
							 
		public function beforeSave($options = array()) {
			/* if (isset($this->data['User']['password'])) {
				$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
			}
			return true; */
		}
		
		
	}
?>