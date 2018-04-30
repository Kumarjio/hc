<?php
	
	class NotificationController extends AppController 
	{
		var $helpers = array ('Html','Form');
		var $name = 'Notification';
		
		//var $layout = 'register';
		
		public function beforeFilter()
		{
			//$this->Auth->autoRedirect = false;
			parent::beforeFilter();
			$this->Auth->allow('index','testemail','confirmation','forgotpassword','reminders');
		}
		
		public function detail($intPortalId = "",$intReminderId = "",$intNotificationId = "")
		{
			if($intReminderId)
			{
				$arrLoggedUser = $this->Auth->user();
				$this->loadModel('Portal');
				$arrPortalDetail = $this->Portal->find('all', array(
										'conditions' => array('career_portal_id'=> $intPortalId)
									));
				$this->set('arrPortalDetail',$arrPortalDetail);
				$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
				$this->set('intPortalId',$intPortalId);
				
				if($intReminderId)
				{
					$this->loadModel('Reminders');
					$arrReminderDetail = $this->Reminders->find('all',array('conditions'=>array('reminder_id'=>$intReminderId)));
					if(is_array($arrReminderDetail) && (count($arrReminderDetail)>0))
					{
						$strEventType = $arrReminderDetail[0]['Reminders']['reminder_type'];
						$strEventId = $arrReminderDetail[0]['Reminders']['reminder_type_id'];
						
						if($strEventType == "event")
						{
							$this->loadModel('Events');
							$arrReminder = $this->Events->find('all',array('conditions'=>array('event_id'=>$strEventId)));
						}
						else
						{
							$this->loadModel('JstAppointments');
							$arrAppointment = $this->JstAppointments->find('all',array('conditions'=>array('jstappointments_id'=>$strEventId)));
							//print("<pre>");
							//print_r($arrAppointment);
							$strAppointmentUrl = Router::url(array('controller'=>'jstappointments','action'=>'detail',$intPortalId,$strEventId),true);
							$arrReminder[0]['Events']['event_description'] = "<a href='".$strAppointmentUrl."'>Appointment</a> with ".$arrAppointment[0]['JstAppointments']['jstappointments_contact_fname'];
							$arrReminder[0]['Events']['event_date_time'] = $arrAppointment[0]['JstAppointments']['jstappointments_start_date_time'];
						}
						/*$compTimeCalculation = $this->Components->load('TimeCalculation');
						$arrReminder[0]['Reminder']['attime'] = $compTimeCalculation->fnAddMinsGetTime($arrReminder[0]['Reminder']['reminder_frequency'],$arrReminder[0]['Reminder']['reminder_time']);*/
						
						$this->set('arrReminderDetail',$arrReminder);
						
						$this->loadModel('Notification');
						$this->Notification->updateAll(array('Notification.notification_read'=>'1'),array('Notification.notification_id'=>$intNotificationId));
					}
				}
			}
		}

		public function index($intPortalId = "")
		{
			if($intPortalId)
			{
				$arrLoggedUser = $this->Auth->user();
				
				
				$this->loadModel('Notification');
				//$arrLoadNotification = $this->Notification->find('all',array('ORDER'=>array('Notification.notification_id'=>'DESC'),'conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'])));
				$arrLoadNotification = $this->Notification->fnGetNotificationDetails($arrLoggedUser['candidate_id']);
				//print("<pre>");
				//print_r($arrLoadNotification);
				//exit;
				/* print("<pre>");
				print_r($arrLoadNotification); */
				
				$this->set('arrLoadNotification',$arrLoadNotification);
			}
			
		}
		
		public function markasread($intPortalId = "",$intNotificationId = "")
		{
			if($intPortalId)
			{
				$arrLoggedUserDetail = $this->Auth->user();
				$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
								
				if(count($arrPortalDetail)>0)
				{
					$this->set('arrPortalDetail',$arrPortalDetail);
					$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
					$this->set('intPortalId',$intPortalId);
					
					if($intNotificationId)
					{
						$this->loadModel('Notification');
						$boolNotificationUpdated = $this->Notification->updateAll(
																	array('Notification.notification_read' => "'1'",),
																	array('Notification.notification_id ='=>$intNotificationId)
																	);
						if($boolNotificationUpdated)
						{
							$this->Session->setFlash('Changes Updated Successfully!','default',array('class' => 'success'));
							$this->redirect(array('controller'=>'notification','action'=>'index',$intPortalId));
						}
						else
						{
							$this->Session->setFlash('Please try again');
							$this->redirect(array('controller'=>'notification','action'=>'index',$intPortalId));
						}
					}
				}
			}
		}
	}
?>