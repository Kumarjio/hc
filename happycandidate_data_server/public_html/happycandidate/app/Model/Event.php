<?php
	class Event extends AppModel 
	{
		var $name = 'Event';
		var $useTable = 'events';
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
							 
		
		
		public function fnCheckEventExists($arrEevent = array())
		{
			if(is_array($arrEevent) && (count($arrEevent)>0))
			{
				//echo "--".$strQuery = "SELECT COUNT(*) AS events FROM events,events_participant,event_organizer,event_subject WHERE events.event_id = events_participant.event_id AND events.event_id = event_organizer.event_id AND events.event_id = event_subject.event_id AND events.event_date_time = '".$arrEevent['eventdatetime']."' AND events_participant.event_participant_type = '".$arrEevent['eventparticipanttype']."' AND events_participant.event_participant_id = '".$arrEevent['eventparticipantid']."' AND event_organizer.event_organizer_type = '".$arrEevent['eventorganizationtype']."' AND event_organizer.event_organizer_head_id = '".$arrEevent['eventorganizerid']."' AND event_subject.event_subject_type = '".$arrEevent['eventsubjecttype']."' AND event_subject.event_subject_id = '".$arrEevent['eventsubjectid']."' AND events.event_type = '".$arrEevent['eventtype']."'";
				//exit;
				if($arrEevent['eventdatetime'])
				{
					$arrEventCheckQuery = $this->query("SELECT COUNT(*) AS events FROM events,events_participant,event_organizer,event_subject WHERE events.event_id = events_participant.event_id AND events.event_id = event_organizer.event_id AND events.event_id = event_subject.event_id AND events.event_date_time = '".$arrEevent['eventdatetime']."' AND events_participant.event_participant_type = '".$arrEevent['eventparticipanttype']."' AND events_participant.event_participant_id = '".$arrEevent['eventparticipantid']."' AND event_organizer.event_organizer_type = '".$arrEevent['eventorganizationtype']."' AND event_organizer.event_organizer_head_id = '".$arrEevent['eventorganizerid']."' AND event_subject.event_subject_type = '".$arrEevent['eventsubjecttype']."' AND event_subject.event_subject_id = '".$arrEevent['eventsubjectid']."' AND events.event_type = '".$arrEevent['eventtype']."'");
					return $arrEventCheckQuery[0][0]['events'];
				}
				else
				{
					/*echo "--".$strQuery = "SELECT COUNT(*) AS events FROM events,events_participant,event_organizer,event_subject WHERE events.event_id = events_participant.event_id AND events.event_id = event_organizer.event_id AND events.event_id = event_subject.event_id AND events.event_date_time = IS NULL AND events_participant.event_participant_type = '".$arrEevent['eventparticipanttype']."' AND events_participant.event_participant_id = '".$arrEevent['eventparticipantid']."' AND event_organizer.event_organizer_type = '".$arrEevent['eventorganizationtype']."' AND event_organizer.event_organizer_head_id = '".$arrEevent['eventorganizerid']."' AND event_subject.event_subject_type = '".$arrEevent['eventsubjecttype']."' AND event_subject.event_subject_id = '".$arrEevent['eventsubjectid']."' AND events.event_type = '".$arrEevent['eventtype']."'";
					exit;*/
					$arrEventCheckQuery = $this->query("SELECT COUNT(*) AS events FROM events,events_participant,event_organizer,event_subject WHERE events.event_id = events_participant.event_id AND events.event_id = event_organizer.event_id AND events.event_id = event_subject.event_id AND events.event_date_time IS NULL AND events_participant.event_participant_type = '".$arrEevent['eventparticipanttype']."' AND events_participant.event_participant_id = '".$arrEevent['eventparticipantid']."' AND event_organizer.event_organizer_type = '".$arrEevent['eventorganizationtype']."' AND event_organizer.event_organizer_head_id = '".$arrEevent['eventorganizerid']."' AND event_subject.event_subject_type = '".$arrEevent['eventsubjecttype']."' AND event_subject.event_subject_id = '".$arrEevent['eventsubjectid']."' AND events.event_type = '".$arrEevent['eventtype']."'");
					return $arrEventCheckQuery[0][0]['events'];
				}
			}
		}
		
		public function fnDeleteExistingEvent($arrEevent = array())
		{
			if(is_array($arrEevent) && (count($arrEevent)>0))
			{
				if($arrEevent['eventdatetime'])
				{
					//echo "--".$strQ = "DELETE events,events_participant,event_organizer,event_subject FROM events,events_participant,event_organizer,event_subject WHERE events.event_id = events_participant.event_id AND events.event_id = event_organizer.event_id AND events.event_id = event_subject.event_id AND events.event_date_time = '".$arrEevent['eventdatetime']."' AND events_participant.event_participant_type = '".$arrEevent['eventparticipanttype']."' AND events_participant.event_participant_id = '".$arrEevent['eventparticipantid']."' AND event_organizer.event_organizer_type = '".$arrEevent['eventorganizationtype']."' AND event_organizer.event_organizer_head_id = '".$arrEevent['eventorganizerid']."' AND event_subject.event_subject_type = '".$arrEevent['eventsubjecttype']."' AND event_subject.event_subject_id = '".$arrEevent['eventsubjectid']."' AND events.event_type = '".$arrEevent['eventtype']."'";
					//exit;
					$strDeleteEventQuery = $this->query("DELETE events,events_participant,event_organizer,event_subject FROM events,events_participant,event_organizer,event_subject WHERE events.event_id = events_participant.event_id AND events.event_id = event_organizer.event_id AND events.event_id = event_subject.event_id AND events.event_date_time = '".$arrEevent['eventdatetime']."' AND events_participant.event_participant_type = '".$arrEevent['eventparticipanttype']."' AND events_participant.event_participant_id = '".$arrEevent['eventparticipantid']."' AND event_organizer.event_organizer_type = '".$arrEevent['eventorganizationtype']."' AND event_organizer.event_organizer_head_id = '".$arrEevent['eventorganizerid']."' AND event_subject.event_subject_type = '".$arrEevent['eventsubjecttype']."' AND event_subject.event_subject_id = '".$arrEevent['eventsubjectid']."' AND events.event_type = '".$arrEevent['eventtype']."'");
				}
				else
				{
					//echo "--".$strQ = "DELETE events,events_participant,event_organizer,event_subject FROM events,events_participant,event_organizer,event_subject WHERE events.event_id = events_participant.event_id AND events.event_id = event_organizer.event_id AND events.event_id = event_subject.event_id AND events.event_date_time IS NULL AND events_participant.event_participant_type = '".$arrEevent['eventparticipanttype']."' AND events_participant.event_participant_id = '".$arrEevent['eventparticipantid']."' AND event_organizer.event_organizer_type = '".$arrEevent['eventorganizationtype']."' AND event_organizer.event_organizer_head_id = '".$arrEevent['eventorganizerid']."' AND event_subject.event_subject_type = '".$arrEevent['eventsubjecttype']."' AND event_subject.event_subject_id = '".$arrEevent['eventsubjectid']."' AND events.event_type = '".$arrEevent['eventtype']."'";
					//exit;
					$strDeleteEventQuery = $this->query("DELETE events,events_participant,event_organizer,event_subject FROM events,events_participant,event_organizer,event_subject WHERE events.event_id = events_participant.event_id AND events.event_id = event_organizer.event_id AND events.event_id = event_subject.event_id AND events.event_date_time IS NULL AND events_participant.event_participant_type = '".$arrEevent['eventparticipanttype']."' AND events_participant.event_participant_id = '".$arrEevent['eventparticipantid']."' AND event_organizer.event_organizer_type = '".$arrEevent['eventorganizationtype']."' AND event_organizer.event_organizer_head_id = '".$arrEevent['eventorganizerid']."' AND event_subject.event_subject_type = '".$arrEevent['eventsubjecttype']."' AND event_subject.event_subject_id = '".$arrEevent['eventsubjectid']."' AND events.event_type = '".$arrEevent['eventtype']."'");
				}
			}
		}
		
		public function fnSaveEvent($arrEevent = array())
		{
			if(is_array($arrEevent) && (count($arrEevent)>0))
			{
				$boolInsertEvent = $this->query("INSERT INTO events(event_name,event_description,event_type,event_venue,event_date_time,event_contact_person,event_reminder,event_created_by)VALUES('".$arrEevent['eventname']."','".$arrEevent['eventdesc']."','".$arrEevent['eventtype']."','".$arrEevent['eventvenu']."','".$arrEevent['eventdatetime']."','".$arrEevent['eventcontactperson']."','".$arrEevent['eventreminder']."','".$arrEevent['creadtedby']."')");
				
				if($boolInsertEvent)
				{
					$intEventId = $this->getLastInsertID();
					$boolInsertEventParticipant = $this->query("INSERT INTO events_participant(event_id,event_participant_type,event_participant_id,event_participant_reg_by)VALUES('".$intEventId."','".$arrEevent['eventparticipanttype']."','".$arrEevent['eventparticipantid']."','".$arrEevent['creadtedby']."')");
					$boolInsertEventOrganizer = $this->query("INSERT INTO event_organizer(event_id,event_organizer_type,event_organizer_head_id,event_organization_registered_by)VALUES('".$intEventId."','".$arrEevent['eventorganizationtype']."','".$arrEevent['eventorganizerid']."','".$arrEevent['creadtedby']."')");
					$boolInsertEventSubject = $this->query("INSERT INTO event_organizer(event_id,event_subject_type,event_subject_id,event_subject_registered_by)VALUES('".$intEventId."','".$arrEevent['eventsubjecttype']."','".$arrEevent['eventsubjectid']."','".$arrEevent['creadtedby']."')");
					
					return $boolInsertEvent;
				}
				
			}
		}
		
		public function fnCheckJobReminders($arrJobRemindersConditons = array())
		{
			if(is_array($arrJobRemindersConditons) && (count($arrJobRemindersConditons)>0))
			{
				
				
				$arrCheckJobRemindersQuery = $this->query("SELECT reminders.reminder_created_on FROM reminders,events,events_participant,event_organizer,event_subject
				WHERE events.event_id = events_participant.event_id AND events.event_id = event_organizer.event_id AND events.event_id = event_subject.event_id AND 
				events.event_id = reminders.reminder_type_id AND reminders.reminder_type = 'event' AND events.event_type = '".$arrJobRemindersConditons['event']['event_type']."' AND events.event_status = '".$arrJobRemindersConditons['event']['status']."' AND events_participant.event_participant_type = '".$arrJobRemindersConditons['event']['participant_type']."' AND events_participant.event_participant_id = '".$arrJobRemindersConditons['event']['participant_id']."'
				AND event_organizer.event_organizer_type = '".$arrJobRemindersConditons['organizer']['organizer_type']."' AND event_organizer.event_organizer_head_id = '".$arrJobRemindersConditons['organizer']['organizer_type_id']."' AND event_subject.event_subject_type = '".$arrJobRemindersConditons['subject']['subject_type']."' AND event_subject.event_subject_id = '".$arrJobRemindersConditons['subject']['subject_type_id']."'");
				return $arrCheckJobRemindersQuery[0]['reminders']['reminder_created_on'];
				
			}
		}
		
		public function fnGetScheduledInterviewedCount($arrConditions = array())
		{
			if(is_array($arrConditions) && (count($arrConditions)>0))
			{
				$arrConditions['eventtype'] = "Interview";
				$arrConditions['eventsubjecttype'] = "Job";
				$arrConditions['organizertype'] = "Portal";
				$arrConditions['participanttype'] = "Candidate";
				
				$arrScheduledInterviewCountQuery = $this->query("SELECT COUNT(*) AS scheduled_interview FROM events,events_participant,event_organizer,event_subject WHERE 
				events.event_id = events_participant.event_id AND events.event_id = event_organizer.event_id AND events.event_id = event_subject.event_id AND 
				events.event_type = '".$arrConditions['eventtype']."' AND events.event_status = '".$arrConditions['status']."' AND events_participant.event_participant_type = '".$arrConditions['participanttype']."' AND events_participant.event_participant_id = '".$arrConditions['candidateid']."'
				AND event_organizer.event_organizer_type = '".$arrConditions['organizertype']."' AND event_organizer.event_organizer_head_id = '".$arrConditions['portalid']."' AND event_subject.event_subject_type = '".$arrConditions['eventsubjecttype']."'");
				/* print("<pre>");
				print_r($arrScheduledInterviewCountQuery); */
				
				return $arrScheduledInterviewCountQuery[0][0]['scheduled_interview'];
			}
		}
		
		public function fnGetScheduledInterviewedJobs($arrConditions = array())
		{
			if(is_array($arrConditions) && (count($arrConditions)>0))
			{
				$arrConditions['eventtype'] = "Interview";
				$arrConditions['eventsubjecttype'] = "Job";
				$arrConditions['organizertype'] = "Portal";
				$arrConditions['participanttype'] = "Candidate";
				
				$arrScheduledInterviewCountQuery = $this->query("SELECT jobs.* FROM jobs,events,events_participant,event_organizer,event_subject WHERE 
				events.event_id = events_participant.event_id AND events.event_id = event_organizer.event_id AND events.event_id = event_subject.event_id AND 
				events.event_type = '".$arrConditions['eventtype']."' AND events.event_status = '".$arrConditions['status']."' AND events_participant.event_participant_type = '".$arrConditions['participanttype']."' AND events_participant.event_participant_id = '".$arrConditions['candidateid']."'
				AND event_organizer.event_organizer_type = '".$arrConditions['organizertype']."' AND event_organizer.event_organizer_head_id = '".$arrConditions['portalid']."' AND event_subject.event_subject_type = '".$arrConditions['eventsubjecttype']."' AND jobs.id = event_subject.event_subject_id");
				/* print("<pre>");
				print_r($arrScheduledInterviewCountQuery); */
				
				return $arrScheduledInterviewCountQuery;
			}
		}
		
		
	}
?>