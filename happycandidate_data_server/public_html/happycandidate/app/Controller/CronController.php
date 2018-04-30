<?php
	
	class CronController extends AppController 
	{
		var $helpers = array ('Html','Form');
		var $name = 'Cron';
		
		//var $layout = 'register';
		
		public function beforeFilter()
		{
			//$this->Auth->autoRedirect = false;
			parent::beforeFilter();
			$this->Auth->allow('index','testemail','confirmation','forgotpassword','reminders');
		}
		
		public function reminders()
		{
			$this->layuout = NULL;
			$this->autoRender = false;
			
			//$fh = fopen("check.txt","w");
			//fwrite($fh,"hello");
			//fclose($fh);
			
			// Set Interview Reminders 
			//$strDateTime = $this->request->data['datetime'];
			$strDateTime = date('Y-m-d H:i:00');
			
			$this->loadModel('Reminder');
			$compTime = $this->Components->load('TimeCalculation');
			$strStartDateTime = $compTime->fnGetBeforeTime("15",$strDateTime);
			$strEndDateTime = $strDateTime;
			
			
			
			$arrReminderDetail = $this->Reminder->find('all',array('conditions'=>array('reminder_status'=>'active','reminder_time >='=>$strStartDateTime,'reminder_time <='=>$strEndDateTime,'is_reminded'=>'0')));
			//print("<pre>");
			//print_r($arrReminderDetail);
			//exit;
			//$log = $this->Reminder->getDataSource()->getLog(false, false);       
			//debug($log);
			//exit;
			
			
			//$arrReminderDetail = $this->Reminder->find('all',array('conditions'=>array('reminder_status'=>'active')));
			
			if(is_array($arrReminderDetail)  && (count($arrReminderDetail)>0))
			{
				foreach($arrReminderDetail as $arrReminder)
				{
					
						if($arrReminder['Reminder']['reminder_type'] == "event")
						{
							//$compReminder = $this->Components->load('Reminders');
							//$boolReminded = $compReminder->fnSendReminders($arrReminder);
							
							$this->loadModel('Eventparticipant');
							$arrParticpantDetail = $this->Eventparticipant->fnGetEventParticipant($arrReminder['Reminder']['reminder_type_id']);
							/*print("<pre>");
							print_r($arrParticpantDetail);
							exit;*/
							
							if(is_array($arrParticpantDetail) && (count($arrParticpantDetail)>0))
							{
								foreach($arrParticpantDetail as $arrParticipant)
								{
									if($arrReminder['Reminder']['remider_on_mail'] == "1")
									{
										$compTime = $this->Components->load('TimeCalculation');
										$strActualTime =  $compTime->fnAddMinsGetTime($arrReminder['Reminder']['reminder_frequency'],$arrReminder['Reminder']['reminder_time']);
										$strReminderText = $arrReminder['Reminder']['reminder_text']." at ".$strActualTime;
										$arrReminderMailSent[$arrParticipant['career_portal_candidate']['candidate_id']] = $this->fnSendReminderMail($arrParticipant['career_portal_candidate']['candidate_username'],$arrParticipant['career_portal_candidate']['candidate_email'],$strReminderText);
										if($arrReminderMailSent[$arrParticipant['career_portal_candidate']['candidate_id']])
										{
											$this->Reminder->updateAll(array('Reminder.is_reminded'=>'1','Reminder.remider_on_mail'=>'2'),array('Reminder.reminder_id'=>$arrReminder['Reminder']['reminder_id']));
										}
									}
									
									if($arrReminder['Reminder']['reminder_on_application'] == "1")
									{
										$this->loadModel("Notification");
										$this->request->data['Notification']['candidate_id'] = $arrParticipant['career_portal_candidate']['candidate_id'];
										$this->request->data['Notification']['reminder_type'] = "Event";
										$this->request->data['Notification']['reminder_id'] = $arrReminder['Reminder']['reminder_id'];
										
										$isNotified = $this->Notification->save($this->request->data);
										if($isNotified)
										{
											$this->Reminder->updateAll(array('Reminder.is_reminded'=>'1','Reminder.reminder_on_application'=>'2'),array('Reminder.reminder_id'=>$arrReminder['Reminder']['reminder_id']));
										}
									}
								}
							}
						}
						
						if($arrReminder['Reminder']['reminder_type'] == "Appointment")
						{
							//$compReminder = $this->Components->load('Reminders');
							//$boolReminded = $compReminder->fnSendReminders($arrReminder);
							
							$this->loadModel('JstAppointments');
							$arrAppointMentDetail = $this->JstAppointments->find('all',array('conditions'=>array('jstappointments_id'=>$arrReminder['Reminder']['reminder_type_id'])));
							/*print("<pre>");
							print_r($arrParticpantDetail);
							exit;*/
							
							if($arrAppointMentDetail[0]['JstAppointments']['jstappointments_seeker_id'])
							{
								$this->loadModel('PortalUser');
								
								$arrPartici = $this->PortalUser->find('all',array('conditions'=>array('candidate_id'=>$arrAppointMentDetail[0]['JstAppointments']['jstappointments_seeker_id'])));
								$arrParticipant['career_portal_candidate'] = $arrPartici[0]['PortalUser'];
								
								if($arrReminder['Reminder']['remider_on_mail'] == "1")
								{
									$compTime = $this->Components->load('TimeCalculation');
									$strActualTime =  $compTime->fnAddMinsGetTime($arrReminder['Reminder']['reminder_frequency'],$arrReminder['Reminder']['reminder_time']);
									$strReminderText = $arrReminder['Reminder']['reminder_text']." at ".$strActualTime;
									$arrReminderMailSent[$arrParticipant['career_portal_candidate']['candidate_id']] = $this->fnSendReminderMail($arrParticipant['career_portal_candidate']['candidate_username'],$arrParticipant['career_portal_candidate']['candidate_email'],$strReminderText);
									if($arrReminderMailSent[$arrParticipant['career_portal_candidate']['candidate_id']])
									{
										$this->Reminder->updateAll(array('Reminder.is_reminded'=>'1','Reminder.remider_on_mail'=>'2'),array('Reminder.reminder_id'=>$arrReminder['Reminder']['reminder_id']));
									}
								}
								
								if($arrReminder['Reminder']['reminder_on_application'] == "1")
								{
									$this->loadModel("Notification");
									$this->request->data['Notification']['candidate_id'] = $arrParticipant['career_portal_candidate']['candidate_id'];
									$this->request->data['Notification']['reminder_type'] = "Appointment";
									$this->request->data['Notification']['reminder_id'] = $arrReminder['Reminder']['reminder_id'];
									
									$isNotified = $this->Notification->save($this->request->data);
									if($isNotified)
									{
										$this->Reminder->updateAll(array('Reminder.is_reminded'=>'1','Reminder.reminder_on_application'=>'2'),array('Reminder.reminder_id'=>$arrReminder['Reminder']['reminder_id']));
									}
								}
							}
						}
					
					//print("<pre>");
					//print_r($arrReminderMailSent);
					//echo json_encode($arrReminderMailSent);
					//exit;
				}
			}
			
			
			// Start New Job Reminders
			$compJobberlandBridge = $this->Components->load('JobberBridge');
			$arrNewJobNotificationCandidate = $compJobberlandBridge->fnGetNewJobNotificationCandidates($strStartDateTime,$strEndDateTime);
			//print("<pre>");
			//print_r($arrNewJobNotificationCandidate);

			if($arrNewJobNotificationCandidate['status'] == "success")
			{
				if(is_array($arrNewJobNotificationCandidate['latestjobcandidates']) && (count($arrNewJobNotificationCandidate['latestjobcandidates'])>0))
				{
					$isNotified = $this->updatenewjobnotificationevent($arrNewJobNotificationCandidate);
				}
			}
			//exit;			
			//End New Job Reminders
			//echo "---".strtotime($strStartDateTime);
			
			// Start New material Reminders
			/*$compLmsBridge = $this->Components->load('LmsBridge');
			$arrNewMaterialForNotification = $compLmsBridge->fnGetNewMaterialForNotification(strtotime($strStartDateTime),strtotime($strEndDateTime));
			
			//print("<pre>");
			//print_r($arrNewMaterialForNotification);
			
			
			if(is_array($arrNewMaterialForNotification) && (count($arrNewMaterialForNotification)>0))
			{
				foreach($arrNewMaterialForNotification as $arrNewMaterial)
				{
					$arrNotificationCandidate = $compLmsBridge->fnGetNotificationCandidates($arrNewMaterial['portal_id']);					
					//print("<pre>");
					//print_r($arrNotificationCandidate);
					
					if(is_array($arrNotificationCandidate) && (count($arrNotificationCandidate)>0))
					{
						foreach($arrNotificationCandidate as $arrCandidate)
						{
							$isNotified = $this->updateNewMaterialNotification($arrCandidate,$arrNewMaterial);
						}
					}
				}
			}*/
			// End New Material Reminders
		}

		public function newjobreminders()
		{
			$this->layuout = NULL;
			$this->autoRender = false;
			
			$strDateTime = date('Y-m-d H:i');
			$compLmsBridge = $this->Components->load('LmsBridge');
			$arrNewMaterialForNotification = $compLmsBridge->fnGetNewMaterialForNotification(strtotime($strDateTime));
						
			if(is_array($arrNewMaterialForNotification) && (count($arrNewMaterialForNotification)>0))
			{
				foreach($arrNewMaterialForNotification as $arrNewMaterial)
				{
					$arrNotificationCandidate = $compLmsBridge->fnGetNotificationCandidates($arrNewMaterial['portal_id']);
					/*print("<pre>");
					print_r($arrNewMaterial);*/
					
					
					if(is_array($arrNotificationCandidate) && (count($arrNotificationCandidate)>0))
					{
						foreach($arrNotificationCandidate as $arrCandidate)
						{
							/*print("<pre>");
							print_r($arrCandidate);*/
							$isNotified = $this->updateNewMaterialNotification($arrCandidate,$arrNewMaterial);
						}
					}
				}
			}
				
			/*$this->loadModel('Job');
			//$strDateTime = $this->request->data['datetime'];
			$strDateTime = date('Y-m-d H:i');
			$compJobberlandBridge = $this->Components->load('JobberBridge');
			$arrNewJobNotificationCandidate = $compJobberlandBridge->fnGetNewJobNotificationCandidates($strDateTime);
			if($arrNewJobNotificationCandidate['status'] == "success")
			{
				if(is_array($arrNewJobNotificationCandidate['latestjobcandidates']) && (count($arrNewJobNotificationCandidate['latestjobcandidates'])>0))
				{
					$isNotified = $this->updatenewjobnotificationevent($arrNewJobNotificationCandidate);
				}
			}*/			
		}
		
		public function updateNewMaterialNotification($arrCandidate = array(),$arrNewMaterial = array())
		{
			/*print("<pre>");
			print_r($arrNewMaterial);
			
			print("<pre>");
			print_r($arrCandidate);*/
			
			$arrEventData = array();
			$strNotificationSubject = $arrEventData['Event']['event_name'] = "New Material Added";
			$arrEventData['Event']['event_description'] = "New Material ".$arrNewMaterial['fullname']." was added recently";
			$arrEventData['Event']['event_date_time'] = date("Y-m-d H:i:s",$arrNewMaterial['timecreated']);
			$arrEventData['Event']['event_venue'] = "Url of the Material";
			$arrEventData['Event']['event_type'] = "New Material";
			//$arrEventData['Event']['event_created_by'] = $arrNewJobEvent['fk_hc_employer_id'];
			
			$arrEventData['Eventparticipant']['event_participant_type'] = "Candidates";
			$arrEventData['Eventparticipant']['event_participant_id'] = $arrCandidate['candidate_id'];
			//$arrEventData['Eventparticipant']['event_participant_reg_by'] = $arrCandidate['hc_uid'];
			
			$arrEventData['Eventorganizer']['event_organizer_type'] = "Portal";
			$arrEventData['Eventorganizer']['event_organizer_head_id'] = $arrNewMaterial['portal_id'];
			//$arrEventData['Eventorganizer']['event_organization_registered_by'] = $arrNewJobEvent['fk_hc_employer_id'];
			
			
			$arrEventData['Eventsubject']['event_subject_type'] = "Material";
			$arrEventData['Eventsubject']['event_subject_id'] = $arrNewMaterial['id'];
			//$arrEventData['Eventsubject']['event_subject_registered_by'] = $arrNewJobEvent['fk_hc_employer_id'];
			
			
			/*print("<pre>");
			print_r($arrEventData);*/
			
			
			$this->loadModel('Event');
			$this->Event->create(false);
			$boolEventCreated = $this->Event->save($arrEventData);
			if($boolEventCreated)
			{
				$arrEventData['Eventsubject']['event_id'] = $arrEventData['Eventorganizer']['event_id'] = $arrEventData['Eventparticipant']['event_id'] = $this->Event->getLastInsertID();
				$this->loadModel('Eventparticipant');
				$this->Eventparticipant->create(false);
				$this->Eventparticipant->save($arrEventData);
				$this->loadModel('Eventorganizer');
				$this->Eventorganizer->create(false);
				$this->Eventorganizer->save($arrEventData);
				$this->loadModel('Eventsubject');
				$this->Eventsubject->create(false);
				$this->Eventsubject->save($arrEventData);
				
				// end of adding new event
				
				// start system notification
				$this->loadModel('Notification');
				$arrSystemNotification = array();
				$arrSystemNotification['Notification']['candidate_id'] = $arrCandidate['candidate_id'];
				$arrSystemNotification['Notification']['reminder_type'] = 'event';
				$arrSystemNotification['Notification']['reminder_id'] = $arrEventData['Eventsubject']['event_id'];
				$this->Notification->create(false);
				$isSystemNotified = $this->Notification->save($arrSystemNotification);
				// end of system notification
				
				// start of email notification
				//$this->loadModel('Candidate');
				//$arrCandidateDetail = $this->Candidate->find('all',array('conditions'=>array('candidate_id'=>$arrCandidates['hc_uid'])));
				$isNotifiedThroughEmail = $this->fnSendReminderMail($arrCandidate['candidate_username'],$arrCandidate['candidate_email'],$arrEventData['Event']['event_description'],$strNotificationSubject);
				// end of email notification
			}
			
			if($isSystemNotified && $isNotifiedThroughEmail)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
?>