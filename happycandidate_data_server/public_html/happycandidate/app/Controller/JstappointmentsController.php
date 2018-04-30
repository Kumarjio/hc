<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class JstappointmentsController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Jstappointments';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('registration','reset','jobsearch','forgotpassword','jobdetail','contactdetails','deleteallappointments');
	}
	
	public function checkreminders($intPortalId)
	{
		//Configure::write('debug','2');
		
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$strDate = date('Y-m-d H:i:')."00";
			$this->loadModel("Notification");
			
			$intNotifyReadCnt = $this->Notification->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],'notification_read'=>'0','foruser'=>'candidate')));
										
			
				$arrNotifications = $this->Notification->find('all',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],'foruser'=>'candidate'),'order'=>array('notification_id'=>'desc'),'limit'=>2));
				
				
				$strNotificationHtml = '';
				if(is_array($arrNotifications) && (count($arrNotifications)>0))
				{
					$strNotificationHtml = '';
					$this->loadModel('Reminder');
					$this->loadModel('Resourceorderdetail');
					foreach($arrNotifications as $arrNoti)
					{
						 $notification_read = $arrNoti['Notification']['notification_read'];
						$css='color:#000;';
						if($notification_read>0)
						{
							$css= "";
						}
						if($arrNoti['Notification']['reminder_type']=="Event")
						{
							
							$arrReminderDetail = $this->Reminder->find('all',array('conditions'=>array('reminder_id'=>$arrNoti['Notification']['reminder_id'])));
							
							$strNotificationHtml .= '<li class="notification-block-bordered" id="notification'.$arrNoti['Notification']['notification_id'].'">
									<a class="dropdown-item-notification" href="#">
										<p style="'.$css.'">'.$arrReminderDetail[0]['Reminder']['reminder_text'].'.</p>
									</a>
									<a class="close-notification" href="#notification1">
										<img alt="" src="images/icon-delete-notification.png">
									</a>
								</li>';
						}
						if($arrNoti['Notification']['reminder_type']=="orderupdate")
						{
							
							
							$arrVendorNotifications = $this->Resourceorderdetail->find('first',array('conditions'=>array('order_detail_id'=>$arrNoti['Notification']['reminder_id'])));
							
							$linkorder = Router::url(array('controller'=>'myorders','action'=>'orderdetail',$intPortalId,$arrNoti['Notification']['reminder_id']),true);
							
							$strNotificationHtml .= '<li class="notification-block-bordered" id="notification'.$arrNoti['Notification']['notification_id'].'">
								<a class="dropdown-item-notification" href="'.$linkorder.'">
									<p style="'.$css.'">'.$arrVendorNotifications['Resourceorderdetail']['vendor_name'].'  vendor updated the order for your order for product '.$arrVendorNotifications['Resourceorderdetail']['vendor_name'].'</p>
								</a>
								<a class="close-notification" href="#notification1">
									<img alt="" src="images/icon-delete-notification.png">
								</a>
							</li>';
						}
					}
				}
		
			
		
			
			if($strNotificationHtml)
			{
				$strNotificationHtml .= '<li>
								<a href="#" class="right-top-menu-item">See all notifications</a>
							</li>';
				$arrResponse['notifyhtml'] = $strNotificationHtml;
				$arrResponse['status'] = 'success';
				
				
			}
			if($intNotifyReadCnt)
			{
				$arrResponse['notifycount'] = $intNotifyReadCnt;
				$arrResponse['status'] = 'success';
			}
			
			
			
			/*$this->loadModel('Reminder');
			$arrReminderDetail = $this->Reminder->find('all',array('conditions'=>array('reminder_status'=>'active','reminder_time'=>$strDate,'reminder_created_by'=>$arrLoggedUser['candidate_id'])));
			
			if(is_array($arrReminderDetail) && (count($arrReminderDetail)>0))
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
						
						/*if(is_array($arrParticpantDetail) && (count($arrParticpantDetail)>0))
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
										$arrResponse['status'] = 'success';
										$arrResponse['notifycount'] = $intNotifyReadCnt;
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
						
						/*if($arrAppointMentDetail[0]['JstAppointments']['jstappointments_seeker_id'])
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
									$arrResponse['status'] = 'success';
								}
							}
						}
					}
				}
				/*$view = new View($this, false);
				$view->set('intPortalId',$intPortalId);
				$view->set('arrReminderDetail',$arrReminderDetail);
				$strWidgetListerHtml = $view->element('reminder_pop');
				$arrResponse['contactshtml'] = $strWidgetListerHtml;*/
			/*}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'There are no reminders for now';
			}*/
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function getcontact($intPortalId,$intContactId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId && $intContactId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				$intSeekerId = $arrLoggedUser['candidate_id'];				
				$this->loadModel('JstContacts');
				$arrContact = $this->JstContacts->find('all',array('conditions'=>array('jstcontacts_id'=>$intContactId)));
				if(is_array($arrContact) && (count($arrContact)>0))
				{
					$arrResponse['status'] = 'success';
					$arrResponse['contact'] = $arrContact[0];
				}
				else
				{
					$arrResponse['status'] = 'fail';
					$arrResponse['message'] = 'Contact does not exists anymore';
				}
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'Bad Request';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	
	public function getappt($intPortalId,$intContactId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId && $intContactId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				$intSeekerId = $arrLoggedUser['candidate_id'];				
				$this->loadModel('JstAppointments');
				$arrContact = $this->JstAppointments->find('all',array('conditions'=>array('jstappointments_id'=>$intContactId)));
				
				$this->loadModel('JstContacts');
				$arrContactDetail = $this->JstContacts->find('all',array('conditions'=>array('jstcontacts_seeker_id'=>$arrLoggedUser['candidate_id'])));
				/*print("<pre>");
				print_r($arrContact);
				exit;*/
				if(is_array($arrContact) && (count($arrContact)>0))
				{
					$arrResponse['status'] = 'success';
					$arrResponse['contact'] = $arrContact[0];
					$view = new View($this, false);
					$view->set('intPortalId',$intPortalId);
					$view->set('arrAppoinmentDetail',$arrContact);
					$view->set('strHeader',"Edit");
					$view->set('arrContacts',$arrContactDetail);
					// call to function which gives list of countries
					//$view->set('arrCountryList',$this->fnLoadCountryListToPrint());
					/* print("<pre>");
					print_r($this->fnLoadCountryListToPrint()); */
					
					// call to function which gives list of states belonging to countries
				//	$view->set('arrStateList',$this->fnLoadStatesListForCountryToPrint($arrContact[0]['JstContacts']['jstcontacts_country']));
					
					/* print("<pre>");
					print_r($this->fnLoadStatesListForCountryToPrint($arrViewUserDetail[0]['country_id'])); */
					
					/* print("<pre>");
					print_r($arrListOfStates); */
					
					// call to function which gives list of cities belonging to states
					//$view->set('arrCityList',$this->fnLoadCityListForStateToPrint($arrContact[0]['JstContacts']['jstcontacts_state']));
					$strWidgetListerHtml = $view->element('appointment_add_tpl_new');
					$arrResponse['contacthtml'] = $strWidgetListerHtml;
				}
				else
				{
					$arrResponse['status'] = 'fail';
					$arrResponse['message'] = 'Contact does not exists anymore';
				}
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'Bad Request';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function contactdetails($intContactId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intContactId)
		{
			$this->loadModel('JstContacts');
			$arrContactDetail = $this->JstContacts->find('all',array('conditions'=>array('jstcontacts_id'=>$intContactId)));
			if(is_array($arrContactDetail) && (count($arrContactDetail)>0))
			{
				$arrResponse['status'] = 'success';
				$arrResponse['name'] = $arrContactDetail[0]['JstContacts']['jstcontacts_fname']." ".$arrContactDetail[0]['JstContacts']['jstcontacts_lname'];
				
				$arrResponse['email'] = $arrContactDetail[0]['JstContacts']['jstcontacts_emailaddress'];
				$arrResponse['phone'] = $arrContactDetail[0]['JstContacts']['jstcontacts_phone1'];
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'There is no such contact present.';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
		}
		echo json_encode($arrResponse);
		exit;
		
	}
	
	public function getapptform($intPortalId)
	{
		//Configure::write('debug','2');
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('JstContacts');
		$arrContactDetail = $this->JstContacts->find('all',array('conditions'=>array('jstcontacts_seeker_id'=>$arrLoggedUser['candidate_id'])));
		$view = new View($this, false);
		$view->set('intPortalId',$intPortalId);
		$view->set('arrContacts',$arrContactDetail);
		//$view->set('arrAppointmentNotes',$arrContacts);
		$strWidgetListerHtml = $view->element('appointment_add_tpl_new');
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		
		echo json_encode($arrResponse);
		exit;
	}
	
	public function delnote($intPortalId,$intContactId = "",$intDetailMode = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId && $intContactId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				$intSeekerId = $arrLoggedUser['candidate_id'];
				
				$compAppointments = $this->Components->load('Appointments');
				$intAppointmentDeleted = $compAppointments->fnDeleteAppointmentsNotes($intContactId);
				if($intAppointmentDeleted)
				{
					$arrResponse['status'] = 'success';
					//$arrResponse['message'] = 'Appointment was deleted Successfully';
					//$arrResponse['alldeleted'] = $compAppointments->fnCheckAppointmentsForSeeker($intContactId);
				}
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'Bad Request';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function delcontact($intPortalId,$intContactId = "",$intDetailMode = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId && $intContactId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				$intSeekerId = $arrLoggedUser['candidate_id'];
				
				$compAppointments = $this->Components->load('Appointments');
				$intAppointmentDeleted = $compAppointments->fnDeleteAppointments($intContactId);
				if($intAppointmentDeleted)
				{
					$arrResponse['status'] = 'success';
					$arrResponse['message'] = 'Appointment was deleted Successfully';
					$arrResponse['alldeleted'] = $compAppointments->fnCheckAppointmentsForSeeker($intSeekerId);
					if($intDetailMode)
					{
						$arrResponse['detailmode'] = "1";
					}
				}
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'Bad Request';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function addnote($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		//echo "HI";exit;
		if($intPortalId)
		{
			
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				
				$arrJSContacts['JstNotes']['jstnotes_contact_id'] = $arrLoggedUser['candidate_id'];
				$arrJSContacts['JstNotes']['jstnotes_seeker_id'] = $arrLoggedUser['candidate_id'];
				$arrJSContacts['JstNotes']['jstnotes_type_id'] = $intContactId = $this->request->data['appointmentid'];
				$arrJSContacts['JstNotes']['jstnotes_description'] = $intContactId = $this->request->data['appoint_note'];
				$arrJSContacts['JstNotes']['jstnotes_type'] = $strNoteType = $this->request->data['type'];
				$arrJSContacts['JstNotes']['jstnotes_title'] = $this->request->data['appointmentid'];
				$arrJSContacts['JstNotes']['jstnotes_start_date'] = date('Y-m-d');
				$arrJSContacts['JstNotes']['jstnotes_start_time'] = date('H:i:s');
				$arrJSContacts['JstNotes']['jstnotes_start_date_time'] = $arrJSContacts['JstNotes']['jstnotes_start_date']." ".$arrJSContacts['JstNotes']['jstnotes_start_time'];

				$compAppointments = $this->Components->load('Appointments');
				$arrAppointCreated = $compAppointments->fnSaveAppointmentNote($arrJSContacts);
				$this->loadModel('JstNotes');
				if($arrAppointCreated['status'] == "success")
				{
				
							$arrResponse['status'] = 'success';
							$arrResponse['message'] = 'You have successfully added the Appointment';
							$arrContacts = array();
							
							$arrJSContacts['JstNotes']['jsttasks_id'] = $this->JstNotes->getLastInsertID();
							$arrContacts[0] = $arrJSContacts;
							$arrappointmentDetail = $this->JstNotes->find('all',array('conditions'=>array('jstnotes_seeker_id'=>$arrLoggedUser['candidate_id'])));
							

							$view = new View($this, false);
							
							$view->set('addappointsurl',Router::url(array('controller'=>'JstNotes','action'=>'add',$intPortalId),true));
							$view->set('arrAppointmentNoteList',$arrappointmentDetail);
							$strWidgetListerHtml = $view->element('note_list_new');
							$arrResponse['contactshtml'] = $strWidgetListerHtml;
							//$arrResponse['contact_f_name'] = $arrJSContacts['JstContacts']['jstcontacts_fname'];
							//$arrResponse['contact_l_name'] = $arrJSContacts['JstContacts']['jstcontacts_lname'];
							//$arrResponse['contact_id'] = $this->JstContacts->getLastInsertID();
				}
				else
				{
					$arrResponse = $arrAppointCreated;
				}
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'Bad Request';
			}
		}
		
		echo json_encode($arrResponse);
		exit;
	}
	
	public function addform($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
			
				$intContactId = $this->request->data['appointmentid'];
				$intDetailMode = $this->request->data['deteailmode'];
				$arrJSContacts['JstAppointments']['jstappointments_seeker_id'] = $arrLoggedUser['candidate_id'];
				$arrJSContacts['JstAppointments']['jstappointments_contact_id'] = $this->request->data['is_internal'];
				$arrJSContacts['JstAppointments']['jstappointments_type'] = $this->request->data['appt_type'];
				$arrJSContacts['JstAppointments']['jstappointments_title'] = $this->request->data['appointment-title'];
				$arrJSContacts['JstAppointments']['jstappointments_contact_fname'] = $this->request->data['cname'];
				$arrJSContacts['JstAppointments']['jstappointments_contact_email'] = $this->request->data['c_email'];
				$arrJSContacts['JstAppointments']['jstappointments_contact_phone_no'] = $this->request->data['c_ph1_no'];
				$arrJSContacts['JstAppointments']['jstappointments_description'] = htmlspecialchars($this->request->data['appoint_dsec']);
				//$arrJSContacts['JstAppointments']['jstappointments_start_date'] = $this->request->data['a_start_date'];
				$arrJSContacts['JstAppointments']['jstappointments_start_date'] = $this->request->data['from_date_hid'];
				$arrJSContacts['JstAppointments']['jstappointments_start_time'] = $this->request->data['a_start_time'];
				//$arrJSContacts['JstAppointments']['jstappointments_start_date_time'] = $this->request->data['a_start_date']." ".$this->request->data['a_start_time'];
				
				$arrJSContacts['JstAppointments']['jstappointments_start_date_time'] = $this->request->data['from_date_hid']." ".$this->request->data['a_start_time'];
				
				//$arrJSContacts['JstAppointments']['jstappointments_end_date'] = $this->request->data['a_end_date'];
				$arrJSContacts['JstAppointments']['jstappointments_end_date'] = $this->request->data['to_date_hid'];
				$arrJSContacts['JstAppointments']['jstappointments_end_time'] = $this->request->data['a_end_time'];
				//$arrJSContacts['JstAppointments']['jstappointments_end_date_time'] = $this->request->data['a_end_date']." ".$this->request->data['a_end_time'];
				
				$arrJSContacts['JstAppointments']['jstappointments_end_date_time'] = $this->request->data['to_date_hid']." ".$this->request->data['a_end_time'];
				$arrJSContacts['JstAppointments']['jstappointments_reminder_set'] = $this->request->data['appt_reminder'];
				
				if($this->request->data['contactid'])
				{
					$arrJSContacts['JstAppointments']['jstappointments_contact_id'] = $this->request->data['contactid'];
				}

				$compAppointments = $this->Components->load('Appointments');
				$this->loadModel('JstAppointments');
				
				
				if($intContactId)
				{
					$arrAppointmentUpdated = $compAppointments->fnUpdateAppointment($arrJSContacts['JstAppointments'],$intContactId);
					if($arrAppointmentUpdated['status']="success")
					{
						
						$arrResponse = $arrAppointmentUpdated;
						$arrResponse['contact_id'] = $intContactId;
						$view = new View($this, false);
						
							$arrJSContacts['JstAppointments']['jstappointments_id'] = $intContactId;
							$arrAppointments[0] = $arrJSContacts;
							
							$arrappointmentDetail = $this->JstAppointments->find('all',array('conditions'=>array('jstappointments_seeker_id'=>$arrLoggedUser['candidate_id'])));
							

							$view = new View($this, false);
							
							$view->set('addappointsurl',Router::url(array('controller'=>'JstAppointments','action'=>'add',$intPortalId),true));
							$view->set('arrAppointmentList',$arrappointmentDetail);
							$this->Session->setFlash('<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Appointment updated successfully</div>');
							$strWidgetListerHtml = $view->element('appointment_list_new');
							
							$arrResponse['contactshtml'] = $strWidgetListerHtml;
							//$strAppointmentDetailHtml = $view->element('appointment_detail');
							//$arrResponse['detailhtml'] = $strAppointmentDetailHtml;
						
					}
					else
					{
						$arrResponse['status'] = 'fail';
						$this->Session->setFlash('<div class="alert alert-danger">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Some error, Please try again.</div>');
						$arrResponse['message'] = 'Some error, Please try again';
						
					}
					
				}
				else
				{
					 
					 $arrAppointCreated = $compAppointments->fnSaveAppointments($arrJSContacts);
					
						if($arrAppointCreated['status']="success")
						{
							
							$arrResponse['status'] = 'success';
							$arrResponse['message'] = 'You have successfully added the Appointment';
							$arrContacts = array();
							
							$arrJSContacts['JstAppointments']['jstappointments_id'] = $this->JstAppointments->getLastInsertID();
							$arrContacts[0] = $arrJSContacts;
							$arrappointmentDetail = $this->JstAppointments->find('all',array('conditions'=>array('jstappointments_seeker_id'=>$arrLoggedUser['candidate_id'])));
							
                                                        /** Job Click Candidate User Entry **/
                                                            $arrAppointmentData['candidate_id'] = $arrLoggedUser['candidate_id'];
                                                            $arrAppointmentData['reference_id'] = $this->JstAppointments->getLastInsertID();
                                                            $arrAppointmentData['career_portal_id'] = $intPortalId;
                                                            $arrAppointmentData['action_type'] = "appointment add";
                                                            $arrAppointmentData['feature'] = "CRM";
                                                            $arrAppointmentData['action_date'] = date('Y-m-d h:i:s');
                                                            $this->loadModel('JobStatistics');
                                                            $this->JobStatistics->save($arrAppointmentData);
                                                        /** Job Click Candidate User Entry **/
                                                        
                                                        
							$view = new View($this, false);
							
							$view->set('addappointsurl',Router::url(array('controller'=>'JstAppointments','action'=>'add',$intPortalId),true));
							$view->set('arrAppointmentList',$arrappointmentDetail);
							$this->Session->setFlash('<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Appointment added successfully</div>');
							//$strWidgetListerHtml = $view->element('appointment_list_new');
							//$arrResponse['contact_f_name'] = $arrJSContacts['JstContacts']['jstcontacts_fname'];
							//$arrResponse['contact_l_name'] = $arrJSContacts['JstContacts']['jstcontacts_lname'];
							//$arrResponse['contact_id'] = $this->JstContacts->getLastInsertID();
							//$arrAppointmentCriteria['jstappointments_id'] = $this->JstAppointments->getLastInsertID();
							$arrAppointmentCriteria['jstappointments_seeker_id'] = $arrLoggedUser['candidate_id'];
							$arrAppointmentCriteria['jstappointments_start_date'] = $arrJSContacts['JstAppointments']['jstappointments_start_date'];
							$arrAppointmentList = $compAppointments->fnGetAppointments($arrAppointmentCriteria);
							if(is_array($arrAppointmentList) && (count($arrAppointmentList)>0))
							{
								$arrAppointments = array();
								
								foreach($arrAppointmentList as $arrAppointment)
								{
									$arrAppointmentDetail = array();
									$arrAppointmentDetail['title'] = "Appointment with ".$arrAppointment['JstAppointments']['jstappointments_contact_fname'];
									$arrAppointmentDetail['start'] = $arrAppointment['JstAppointments']['jstappointments_start_date']."T".$arrAppointment['JstAppointments']['jstappointments_start_time'];
									$arrAppointmentDetail['end'] = $arrAppointment['JstAppointments']['jstappointments_end_date']."T".$arrAppointment['JstAppointments']['jstappointments_end_time'];
									$arrAppointments['event'][] = $arrAppointmentDetail;
								}
								$view->set('arrAppointmentList',$arrAppointments);
							}
							
							//echo $arrAppointmentList[0]['JstAppointments']['jstappointments_start_date'];
							$view->set('arrPpointDate',$arrAppointmentList[0]['JstAppointments']['jstappointments_start_date']);
							$strWidgetListerHtml = $view->element('calendar');
							$arrResponse['contactshtml'] = $strWidgetListerHtml;
						}
						else
						{
							$this->Session->setFlash('<div class="alert alert-danger">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Some error, Please try again.</div>');
							$arrResponse['status'] = 'fail';
							$arrResponse['message'] = 'Some error, Please try again';
						}
				}
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'Bad Request';
				$this->Session->setFlash('<div class="alert alert-danger">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Some error, Please try again.</div>');
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
			$this->Session->setFlash('<div class="alert alert-danger">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Some error, Please try again.</div>');
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	
	public function getApptOnCal($intPortalId = "",$intApptId = "")
	{
		//Configure::write('debug','2');
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		$view = new View($this, false);
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('JstAppointments');
			$arrappointmentDetail = $this->JstAppointments->find('all',array('conditions'=>array('jstappointments_id'=>$intApptId)));
			
			if(is_array($arrappointmentDetail) && (count($arrappointmentDetail)>0))
			{
				$arrAppointmentCriteria['jstappointments_seeker_id'] = $arrLoggedUser['candidate_id'];
				$arrAppointmentCriteria['jstappointments_start_date'] = $arrappointmentDetail[0]['JstAppointments']['jstappointments_start_date'];
				
				
				$compAppointments = $this->Components->load('Appointments');
				$arrAppointmentList = $compAppointments->fnGetAppointments($arrAppointmentCriteria);
				if(is_array($arrAppointmentList) && (count($arrAppointmentList)>0))
				{
					$arrAppointments = array();
					
					foreach($arrAppointmentList as $arrAppointment)
					{
						$arrAppointmentDetail = array();
						$arrAppointmentDetail['title'] = "Appointment with ".$arrAppointment['JstAppointments']['jstappointments_contact_fname'];
						$arrAppointmentDetail['start'] = $arrAppointment['JstAppointments']['jstappointments_start_date']."T".$arrAppointment['JstAppointments']['jstappointments_start_time'];
						$arrAppointmentDetail['end'] = $arrAppointment['JstAppointments']['jstappointments_end_date']."T".$arrAppointment['JstAppointments']['jstappointments_end_time'];
						$arrAppointments['event'][] = $arrAppointmentDetail;
					}
					$view->set('arrPpointDate',$arrAppointmentList[0]['JstAppointments']['jstappointments_start_date']);
					$view->set('arrAppointmentList',$arrAppointments);
					$strWidgetListerHtml = $view->element('calendar');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
					$arrResponse['status'] = "success";
				}
				else
				{
					$arrResponse['status'] = "fail";
				$arrResponse['message'] = 'Appointment does not exist, please try again';
				}
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = 'Appointment does not exist, please try again';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function searchform($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				$intSeekerId = $arrLoggedUser['candidate_id'];
				$arrJSContacts['JstAppointments']['jstappointments_contact_fname'] = $this->request->data['contact_fname'];
				$arrJSContacts['JstAppointments']['jstappointments_contact_email'] = $this->request->data['contact_email'];
				$arrConditionArray = array();
				$arrConditionArray['jstappointments_seeker_id'] = $intSeekerId;
				
				if($arrJSContacts['JstAppointments']['jstappointments_contact_fname'])
				{
					$arrConditionArray['jstappointments_contact_fname'] = $arrJSContacts['JstAppointments']['jstappointments_contact_fname'];
				}
				
				if($arrJSContacts['JstAppointments']['jstappointments_contact_email'])
				{
					$arrConditionArray['jstappointments_contact_email'] = $arrJSContacts['JstAppointments']['jstappointments_contact_email'];
				}
				$compAppointments = $this->Components->load('Appointments');
				$arrAppointmentList = $compAppointments->fnGetAppointments($arrConditionArray);
				if(is_array($arrAppointmentList) && (count($arrAppointmentList)>0))
				{
					$arrResponse['status'] = 'success';
					$view = new View($this, false);
					$view->set('arrAppointmentList',$arrAppointmentList);
					$strWidgetListerHtml = $view->element('appointment_list');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
				}
				else
				{
					$arrResponse['status'] = 'fail';
					$arrResponse['message'] = 'There are no Appointments matching with provided filteration criteria';
				}
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'Bad Request';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function edit($intPortalId = "",$intAppointmentId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			$this->loadModel('PortalPages');	
			$arrPortalContactUsPageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'],'career_portal_page_tittle'=> 'Contact Us')
								));
			$intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
			$this->set('intContactUsPageId',$intContactUsPageDetail);
			$this->set('strFooter1','<a href="'.Router::url(array('controller'=>'jstappointments','action'=>'calendar',$intPortalId),true).'">Calendar</a>');
			$this->set('strFooter2','<a href="'.Router::url(array('controller'=>'jsttasks','action'=>'index',$intPortalId),true).'">Tasks</a>');
			$this->set('strFooter3','<a href="'.Router::url(array('controller'=>'jsprocess','action'=>'index',$intPortalId),true).'">Job Search Process</a>');
			
			$this->set('contactlistsurl',Router::url(array('controller'=>'jstappointments','action'=>'index',$intPortalId),true));
			
			//print("<pre>");
			//print_r($arrContactDetail);
			
			if($intAppointmentId)
			{
				$arrAppointmentCriteria['jstappointments_id'] = $intAppointmentId;
			}
			$compAppointments = $this->Components->load('Appointments');
			$arrAppointmentList = $compAppointments->fnGetAppointments($arrAppointmentCriteria);
			//print("<pre>");
			//print_r($arrAppointmentList);
			
			$this->set('arrAppointmentList',$arrAppointmentList);
		}
	}
	
	public function add($intPortalId = "",$intContactId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			$this->loadModel('PortalPages');	
			$arrPortalContactUsPageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'],'career_portal_page_tittle'=> 'Contact Us')
								));
			$intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
			$this->set('intContactUsPageId',$intContactUsPageDetail);
			$this->set('strFooter1','<a href="'.Router::url(array('controller'=>'jstappointments','action'=>'calendar',$intPortalId),true).'">Calendar</a>');
			$this->set('strFooter2','<a href="'.Router::url(array('controller'=>'jsttasks','action'=>'index',$intPortalId),true).'">Tasks</a>');
			$this->set('strFooter3','<a href="'.Router::url(array('controller'=>'jsprocess','action'=>'index',$intPortalId),true).'">Job Search Process</a>');
			
			$this->set('contactlistsurl',Router::url(array('controller'=>'jstappointments','action'=>'index',$intPortalId),true));
			if($intContactId)
			{
				$this->loadModel('JstContacts');
				$arrContactDetail = $this->JstContacts->find('all',array('conditions'=>array('jstcontacts_id'=>$intContactId)));
				
				if(is_array($arrContactDetail) && (count($arrContactDetail)>0))
				{
					$arrAppointmentList[0]['JstAppointments']['jstappointments_contact_fname'] = $arrContactDetail[0]['JstContacts']['jstcontacts_fname']." ".$arrContactDetail[0]['JstContacts']['jstcontacts_lname'];
					$arrAppointmentList[0]['JstAppointments']['jstappointments_contact_email'] = $arrContactDetail[0]['JstContacts']['jstcontacts_emailaddress'];
					$arrAppointmentList[0]['JstAppointments']['jstappointments_contact_phone_no'] =  $arrContactDetail[0]['JstContacts']['jstcontacts_phone1'];
					$arrAppointmentList[0]['JstAppointments']['jstappointments_contact_id'] = $arrContactDetail[0]['JstContacts']['jstcontacts_id'];
					$this->set('arrAppointmentList',$arrAppointmentList);
				}
			}
			
			
			//print("<pre>");
			//print_r($arrContactDetail);
		}
	}
	
	public function appointmentsnotes($intPortalId = "",$intContactId = "",$strType = "appointment")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		if($intPortalId)
		{
			$compAppointments = $this->Components->load('Appointments');
			$arrAppointmentNotes = $compAppointments->fnGetAppointmentsNotes($intContactId,$strType);
			$arrResponse['noteshtml'] = "";
			if(is_array($arrAppointmentNotes) && count($arrAppointmentNotes)>0)
			{
				$view = new View($this, false);
				$view->set('arrAppointmentNotes',$arrAppointmentNotes);
				$strAppointmentFormHtml = $view->element('appointment_notes');
				$arrResponse['noteshtml'] = $strAppointmentFormHtml;
			}
			$arrResponse['status'] = "success";
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Parameter Missing";
		}
		
		echo json_encode($arrResponse);
		exit;
	}
	
	public function detail($intPortalId = "",$intContactId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			$this->loadModel('PortalPages');	
			$arrPortalContactUsPageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'],'career_portal_page_tittle'=> 'Contact Us')
								));
			$intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
			$this->set('intContactUsPageId',$intContactUsPageDetail);
			
			if($intAppointmentId)
			{
				$arrAppointmentCriteria['jstappointments_id'] = $intAppointmentId;
			}
			$compAppointments = $this->Components->load('Appointments');
			$arrAppointmentList = $compAppointments->fnGetAppointments($arrAppointmentCriteria);
			
			
			
			
			
			//print("<pre>");
			//print_r($arrAppointmentList);
			
			$this->set('arrAppointmentList',$arrAppointmentList);
			$this->set('addcontactsurl',Router::url(array('controller'=>'jstappointments','action'=>'add',$intPortalId),true));
			$this->set('strListcontactsurl',Router::url(array('controller'=>'jstappointments','action'=>'index',$intPortalId),true));
			//print("<pre>");
			//print_r($arrContactDetail);
			
		}
	}
	
	public function getappointmentshtml($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = FALSE;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		
		if($intPortalId)
		{
			$arrAppointmentCriteria['jstappointments_seeker_id'] = $arrLoggedUser['candidate_id'];
			$compAppointments = $this->Components->load('Appointments');
			$arrAppointmentList = $compAppointments->fnGetAppointments($arrAppointmentCriteria);
			$view = new View($this, false);
			$view->set('arrAppointmentList',$arrAppointmentList);
			//$this->set('arrAppointmentList',$arrAppointmentList);
			/*if(is_array($arrAppointmentList) && (count($arrAppointmentList)>0))
			{
				
				//$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
				//$view->set('arrContactDetail',$arrContactDetail);
				$strWidgetListerHtml = $view->element('appointment_list_new');
				$arrResponse['status'] = "success";
				$arrResponse['html'] = $strWidgetListerHtml;
			}*/
			$strWidgetListerHtml = $view->element('appointment_list_new');
			$arrResponse['status'] = "success";
			$arrResponse['html'] = $strWidgetListerHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Parameter missing";
		}
		echo json_encode($arrResponse);
		exit;
	}
	public function delAppointMent($intPortalId,$intContactId = "",$intDetailMode = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId && $intContactId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				$intSeekerId = $arrLoggedUser['candidate_id'];
				$this->loadModel('JstAppointments');
				$intPortalThemeWidgetDeleted = $this->JstAppointments->deleteAll(array('JstAppointments.jstappointments_id' => $intContactId),false);
				if($intPortalThemeWidgetDeleted)
				{
					$intContactCount = $this->JstAppointments->find('count',array('jstappointments_seeker_id'=>$intSeekerId));
					
					$arrResponse['status'] = 'success';
					$arrResponse['message'] = 'Appointment was deleted Successfully';
					if($intDetailMode)
					{
						$arrResponse['detailmode'] = "1";
					}
					if($intContactCount)
					{
						$arrResponse['alldeleted'] = "0";
					}
					else
					{
						$arrResponse['alldeleted'] = "1";
					}
				}
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'Bad Request';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	
	public function index($intPortalId = "",$intContactId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			$this->loadModel('PortalPages');	
			$arrPortalContactUsPageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'],'career_portal_page_tittle'=> 'Contact Us')
								));
			$intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
			$this->set('intContactUsPageId',$intContactUsPageDetail);
			
			$this->set('strFooter1','<a href="'.Router::url(array('controller'=>'jstappointments','action'=>'calendar',$intPortalId),true).'">Calendar</a>');
			$this->set('strFooter2','<a href="'.Router::url(array('controller'=>'jsttasks','action'=>'index',$intPortalId),true).'">Tasks</a>');
			$this->set('strFooter3','<a href="'.Router::url(array('controller'=>'jsprocess','action'=>'index',$intPortalId),true).'">Job Search Process</a>');
			
			if($intContactId)
			{
				$arrAppointmentCriteria['jstappointments_seeker_id'] = $arrLoggedUser['candidate_id'];
				$arrAppointmentCriteria['jstappointments_contact_id'] = $intContactId;
			}
			$compAppointments = $this->Components->load('Appointments');
			$arrAppointmentList = $compAppointments->fnGetAppointments($arrAppointmentCriteria);
			$this->set('arrAppointmentList',$arrAppointmentList);
			//print("<pre>");
			//print_r($arrAppointmentList);
			//exit;
		}
	}
	
		
	public function calendar($intPortalId)
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			$this->loadModel('PortalPages');	
			$arrPortalContactUsPageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'],'career_portal_page_tittle'=> 'Contact Us')
								));
			$intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
			$this->set('intContactUsPageId',$intContactUsPageDetail);
			$this->set('strFooter1','<a href="'.Router::url(array('controller'=>'jstappointments','action'=>'index',$intPortalId),true).'">Appointments</a>');
			$this->set('strFooter2','<a href="'.Router::url(array('controller'=>'jsttasks','action'=>'index',$intPortalId),true).'">Tasks</a>');
			$this->set('strFooter3','<a href="'.Router::url(array('controller'=>'jsprocess','action'=>'index',$intPortalId),true).'">Job Search Process</a>');
			if($intContactId)
			{
				$arrAppointmentCriteria['jstappointments_seeker_id'] = $arrLoggedUser['candidate_id'];
				$arrAppointmentCriteria['jstappointments_contact_id'] = $intContactId;
			}
			$compAppointments = $this->Components->load('Appointments');
			$arrAppointmentList = $compAppointments->fnGetAppointments($arrAppointmentCriteria);
			if(is_array($arrAppointmentList) && (count($arrAppointmentList)>0))
			{
				$arrAppointments = array();
				
				foreach($arrAppointmentList as $arrAppointment)
				{
					$arrAppointmentDetail = array();
					$arrAppointmentDetail['title'] = "Appointment with ".$arrAppointment['JstAppointments']['jstappointments_contact_fname'];
					$arrAppointmentDetail['start'] = $arrAppointment['JstAppointments']['jstappointments_start_date']."T".$arrAppointment['JstAppointments']['jstappointments_start_time'];
					$arrAppointmentDetail['end'] = $arrAppointment['JstAppointments']['jstappointments_end_date']."T".$arrAppointment['JstAppointments']['jstappointments_end_time'];
					$arrAppointments['event'][] = $arrAppointmentDetail;
				}
				
				$this->set('arrAppointmentList',$arrAppointments);
			}
			else
			{
				$this->set('arrAppointmentList',$arrAppointmentList);
			}
		}
	}
	
	public function modify($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		if($intPortalId)
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				$arrLogedUser = $this->Auth->user();
				$this->loadModel('CandidateReferences');
				$this->request->data['CandidateReferences']['candidate_id'] = $arrLogedUser['candidate_id'];
				$this->request->data['CandidateReferences']['reference_name'] = addslashes(trim($this->request->data['reference_name']));
				$this->request->data['CandidateReferences']['reference_job_title'] = addslashes(trim($this->request->data['job_title']));
				$this->request->data['CandidateReferences']['reference_company_name'] = addslashes(trim($this->request->data['company_name']));
				$this->request->data['CandidateReferences']['reference_tele_number'] = addslashes(trim($this->request->data['tele_number']));
				$this->request->data['CandidateReferences']['reference_phone_number'] = addslashes(trim($this->request->data['cell_number']));
				$this->request->data['CandidateReferences']['reference_email_address'] = addslashes(trim($this->request->data['email_address']));
				$this->request->data['CandidateReferences']['reference_creator_id'] = $arrLogedUser['candidate_id'];
				
				if($this->request->data['edit_reference_id'])
				{
					// code to edit
					$boolUpdated = $this->CandidateReferences->updateAll(
								array('CandidateReferences.reference_name' => "'".$this->request->data['CandidateReferences']['reference_name']."'",'CandidateReferences.reference_job_title'=>"'".$this->request->data['CandidateReferences']['reference_job_title']."'",'CandidateReferences.reference_company_name'=>"'".$this->request->data['CandidateReferences']['reference_company_name']."'",'CandidateReferences.reference_tele_number'=>"'".$this->request->data['CandidateReferences']['reference_tele_number']."'",'CandidateReferences.reference_phone_number'=>"'".$this->request->data['CandidateReferences']['reference_phone_number']."'",'CandidateReferences.reference_email_address'=>"'".$this->request->data['CandidateReferences']['reference_email_address']."'"),
								array('CandidateReferences.candidate_reference_id =' => $this->request->data['edit_reference_id'])
							);
					if($boolUpdated)
					{
						$arrResponse['status'] = "success";
						$arrResponse['message'] = "Reference Updated successfully!!";
						$arrResponse['updateid'] = $this->request->data['edit_reference_id'];
						
						echo json_encode($arrResponse);
						exit;
					}
					else
					{
						$arrResponse['status'] = "fail";
						$arrResponse['message'] = "Please try editing again!!";
						
						echo json_encode($arrResponse);
						exit;
					}
				}
				else
				{
					// code to add
					$intPortalReferenceExists = $this->CandidateReferences->find('count', array(
									'conditions' => array('candidate_id' => $arrLogedUser['candidate_id'],'reference_email_address'=> $this->request->data['CandidateReferences']['reference_email_address'])
								));
					if($intPortalReferenceExists)
					{
						$arrResponse['status'] = "fail";
						$arrResponse['message'] = "Reference already Exists!!";
						
						echo json_encode($arrResponse);
						exit;
					}
					else
					{
						$this->CandidateReferences->set($this->request->data);
						$boolReferenceCreated = $this->CandidateReferences->save($this->request->data);
						$intReferenceCreatedId = $this->CandidateReferences->getLastInsertID();
						if($boolReferenceCreated)
						{
							$arrResponse['status'] = "success";
							$arrResponse['message'] = "Reference created successfully!!";
							$arrResponse['createdid'] = $intReferenceCreatedId;
							
							echo json_encode($arrResponse);
							exit;
						}
						//print("<pre>");
						//print_r($this->request->data['CandidateReferences']);
						//exit;
					}
				}
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Bad Url";
				
				echo json_encode($arrResponse);
				exit;
			}
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Bad Url";
			
			echo json_encode($arrResponse);
			exit;
		}
	}
             
        public function deleteallappointments()
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$intAppointmentId = $this->request->data['appointmentId'];
		$intPortalId = $this->request->data['PortalId'];
		if($intPortalId && $intAppointmentId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
                            $appointmentId = explode(",", $intAppointmentId);
                            foreach ($appointmentId as $Id){
                                $this->loadModel('JstAppointments');
				$intDeletedAppointment = $this->JstAppointments->deleteAll(array('JstAppointments.jstappointments_id' => $Id),false);
                            }
                            
                            $arrResponse['status'] = 'success';
//                            $arrResponse['message'] = 'Appointment was deleted Successfully';
                            $arrResponse['intAppointmentId'] = $intAppointmentId;
                            $arrResponse['message'] = '<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Appointment was deleted Successfully.</div>';
//                            $this->Session->setFlash('<div class="alert alert-success">
//						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
//						  Appointment was deleted Successfully.</div>');
			}
			else
			{
				$arrResponse['status'] = 'fail';
//				$arrResponse['message'] = 'Bad Request';
                                $arrResponse['message'] = '<div class="alert alert-danger">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Bad Request.</div>';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
//			$arrResponse['message'] = 'Parameter missing, Please try again';
                        $arrResponse['message'] = '<div class="alert alert-danger">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Parameter missing, Please try again.</div>';
		}
		echo json_encode($arrResponse);
		exit;
	}
}
