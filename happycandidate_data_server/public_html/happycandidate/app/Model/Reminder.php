<?php
	class Reminder extends AppModel 
	{
		var $name = 'Reminder';
		var $useTable = 'reminders';
		
		/* var $validate = array(
								'user_name' => array(
													'alphaNumeric' => array(
																			'rule' => 'notEmpty',
																			'message' => 'Alphabets and numbers only',
																		   )
												   ),
								'user_email' => array("email"=>array(
																'rule' => 'email',
																"message"=>"Email Address Not Formatted"
															   )
												),
								'user_password' => array(
												 'rule' => array('minLength', '5'),
												 'message' => 'Password Should be mimimum 8 characters long',
											   ),
							 ); */
							 
							 
		public function fnInsertReminder($arrEevent = array())
		{
			$boolInsertEvent = $this->query("INSERT INTO reminders(reminder_type_id,reminder_text,reminder_status,reminder_frequency,reminder_time,reminder_created_by)VALUES('".$arrEevent['reminder_type_id']."','".$arrEevent['reminder_text']."','".$arrEevent['reminder_status']."','".$arrEevent['reminder_frequency']."','".$arrEevent['reminder_time']."','".$arrEevent['reminder_created_by']."')");
		}
	}
?>