<?php
	class Notification extends AppModel 
	{
		var $name = 'Notification';
		var $useTable = 'candidate_notifications';
		
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
							 
		public function fnGetNotificationDetails($intCandidateId = "", $intLimit = "")
		{
			$strStartOffset = "0";
			$strLimitPQueryPart = "";
			$strSelectQuerypart = "SELECT candidate_notifications.*,reminders.*";
			$strFromQuerypart = "FROM candidate_notifications, reminders";
			
			$arrWhereQueryPart = array();
			$arrWhereQueryPart[] = "candidate_notifications.reminder_id = reminders.reminder_id";
			if($intCandidateId)
			{
				$arrWhereQueryPart[] = "candidate_notifications.candidate_id = '".$intCandidateId."'";
			}
			
			$strWhereQueryPart = "WHERE"." ".implode(' AND ',$arrWhereQueryPart);
			$strOrderQueryPart = "ORDER BY candidate_notifications.notification_id DESC";
			
			$strLimitPQueryPart = "";
			
			if($intLimit)
			{
				$strLimitPQueryPart = "LIMIT ".$strStartOffset.", ".$intLimit;
			}
			
			$strQuery = $strSelectQuerypart." ".$strFromQuerypart." ".$strWhereQueryPart." ".$strOrderQueryPart." ".$strLimitPQueryPart;

			//echo "---".$strQuery;exit;
			$arrNotificationDetail= $this->query($strQuery);
			return $arrNotificationDetail;
		}
		
	}
?>