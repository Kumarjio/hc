<?php
	class Eventparticipant extends AppModel 
	{
		var $name = 'Eventparticipant';
		var $useTable = 'events_participant';
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
							 
		
		public function fnGetEventParticipant($intEventId = "")
		{
			if($intEventId)
			{
				/*echo "--".$strQuery = "SELECT career_portal_candidate.* FROM events_participant,career_portal_candidate
				WHERE events_participant.event_id = '".$intEventId."' AND events_participant.event_participant_type = 'Candidate' AND events_participant.event_participant_id  = career_portal_candidate.candidate_id";
				exit;*/
				
				$arrEventParticipantQuery = $this->query("SELECT career_portal_candidate.* FROM events_participant,career_portal_candidate
				WHERE events_participant.event_id = '".$intEventId."' AND events_participant.event_participant_type = 'Candidate' AND events_participant.event_participant_id  = career_portal_candidate.candidate_id");
				
				return $arrEventParticipantQuery;
			}
			else
			{
				return false;
			}
		}
	}
?>