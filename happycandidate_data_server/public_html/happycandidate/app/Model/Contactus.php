<?php
	class Contactus extends AppModel 
	{
		var $name = 'Contactus';
		var $useTable = 'portal_contact_us';
		var $captcha = ''; //intializing captcha var
		public $validate = array(
                    'captcha' => array(
                        'captcha' => array(
                            'rule' => 'matchCaptcha',
                            'message' => 'Failed validating human check.'
                        )
                    ),
                );
		function matchCaptcha($inputValue)	
		{
			return $inputValue['captcha']==$this->getCaptcha(); //return true or false after comparing submitted value with set value of captcha
		}

		function setCaptcha($value)	
		{
			//echo "--".$value;exit;
			$this->captcha = $value; //setting captcha value
		}

		function getCaptcha()	
		{
			return $this->captcha; //getting captcha value
		}
		
	}
?>