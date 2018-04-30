<?php
	class Email extends AppModel 
	{
		var $name = 'Email';
		var $useTable = 'email_template';
		
							 
		public function beforeSave($options = array())
		{
		}
		
	}
?>