<?php
	class PortalJUser extends AppModel 
	{
		public $name = 'PortalJUser';
		public $useTable = 'jobberland_employee';
		var $captcha = ''; //intializing captcha var
		
		public $validate = array(
									'captcha' => array(
														'captcha'	=>	array(
																			'rule' => 'matchCaptcha',
																			'message'=>'Failed validating human check.'
																		)
													)
								);

		function matchCaptcha($inputValue)	
		{
			return $inputValue['captcha']==$this->getCaptcha(); //return true or false after comparing submitted value with set value of captcha
		}

		function setCaptcha($value)	
		{
			$this->captcha = $value; //setting captcha value
		}

		function getCaptcha()	
		{
			return $this->captcha; //getting captcha value
		}


		
		public function beforeSave($options = array()) {
			/* if (isset($this->data['User']['password'])) {
				$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
			}
			return true; */
		}
		
		public function fnAddValidationRule($strFieldName,$strRuleString,$arrValidationRule)
		{
			$this->validator()->add($strFieldName, $strRuleString, $arrValidationRule);
		}

	}
?>