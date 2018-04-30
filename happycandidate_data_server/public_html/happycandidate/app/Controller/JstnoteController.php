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
class JstnoteController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Jstnote';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('registration','reset','jobsearch','forgotpassword','jobdetail');
	}
	
	public function getNoteshtml($intPortalId = "",$strForToday = "")
	{
		$this->layout = NULL;
		$this->autoRender = FALSE;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		
		if($intPortalId)
		{
			//$arrAppointmentCriteria['jstappointments_seeker_id'] = $arrLoggedUser['candidate_id'];			
			$arrAppointmentCriteria['jstnotes_type'] = 'default';
			$compAppointments = $this->Components->load('Notes');
			$arrAppointmentList = $compAppointments->fnGetAppointments($arrAppointmentCriteria);

			//print("<pre>");
			//print_r($arrAppointmentList);
			//exit;
			//$this->set('arrAppointmentList',$arrAppointmentList);
			if(is_array($arrAppointmentList) && (count($arrAppointmentList)>0))
			{
				$view = new View($this, false);
				$view->set('arrAppointmentNoteList',$arrAppointmentList);
				//$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
				//$view->set('arrContactDetail',$arrContactDetail);
				$strWidgetListerHtml = $view->element('note_list_new');
				$arrResponse['status'] = "success";
				$arrResponse['html'] = $strWidgetListerHtml;
			}
			else
			{
				$arrResponse['status'] = "success";
				$arrResponse['html'] = "";
			}
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Parameter missing";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function checkreminders($intPortalId)
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$strDate = date('Y-m-d H:i:')."00";
			$this->loadModel('Reminder');
			$arrReminderDetail = $this->Reminder->find('all',array('conditions'=>array('reminder_status'=>'active','reminder_time'=>$strDate,'reminder_user'=>$arrLoggedUser['candidate_id'])));
			
			if(is_array($arrReminderDetail) && (count($arrReminderDetail)>0))
			{
				$view = new View($this, false);
				$view->set('intPortalId',$intPortalId);
				$view->set('arrReminderDetail',$arrReminderDetail);
				$strWidgetListerHtml = $view->element('reminder_pop');
				$arrResponse['contactshtml'] = $strWidgetListerHtml;
				$arrResponse['status'] = 'success';
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'There are no reminders for now';
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
	
	public function getnoteform($intPortalId)
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		$view = new View($this, false);
		$strAppointmentDetailHtml = $view->element('note_add_tpl_new');
		$arrResponse['contactshtml'] = $strAppointmentDetailHtml;
		if($arrResponse['contactshtml'] != "")
		{
			$arrResponse['status'] = "success";
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
				
				$compAppointments = $this->Components->load('Notes');
				$intAppointmentDeleted = $compAppointments->fnDeleteAppointments($intContactId);
				if($intAppointmentDeleted)
				{
					$arrResponse['status'] = 'success';
					$arrResponse['message'] = 'Note was deleted Successfully';
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
		//echo "HI";exit;
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				
				$arrJSContacts['JstAppointmentsNotes']['appointment_id'] = $intContactId = $this->request->data['appointmentid'];
				$arrJSContacts['JstAppointmentsNotes']['appointment_note'] = $intContactId = $this->request->data['appoint_note'];
				$arrJSContacts['JstAppointmentsNotes']['notes_type'] = $strNoteType = $this->request->data['type'];

				$compAppointments = $this->Components->load('Appointments');
				$arrAppointCreated = $compAppointments->fnSaveAppointmentNote($arrJSContacts);
				if($arrAppointCreated['status'] == "success")
				{
					//print("<pre>");
					//print_r($arrAppointCreated);
					
					$arrResponse = $arrAppointCreated;
					$arrContacts[0] = $arrResponse['createdappoint'];
					$view = new View($this, false);
					$view->set('arrAppointmentNotes',$arrContacts);
					$strWidgetListerHtml = $view->element('appointment_notes');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
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
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function addform($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		//echo "HI";exit;
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				$intContactId = $this->request->data['appointmentid'];
				$intDetailMode = $this->request->data['deteailmode'];
				$arrJSContacts['JstNotes']['jstnotes_seeker_id'] = $arrLoggedUser['candidate_id'];
				$arrJSContacts['JstNotes']['jstnotes_contact_fname'] = $this->request->data['cname'];
				$arrJSContacts['JstNotes']['jstnotes_contact_email'] = $this->request->data['c_email'];
				$arrJSContacts['JstNotes']['jstnotes_contact_phone_no'] = $this->request->data['c_ph1_no'];
				$arrJSContacts['JstNotes']['jstnotes_title'] = $this->request->data['note-title'];
				$arrJSContacts['JstNotes']['jstnotes_description'] = htmlspecialchars($this->request->data['notedesc']);
				$arrJSContacts['JstNotes']['jstnotes_start_date'] = $this->request->data['a_start_date'];
				$arrJSContacts['JstNotes']['jstnotes_start_time'] = $this->request->data['a_start_time'];
				$datestart =  date('H:i:s',strtotime($this->request->data['a_start_time']));
				 $arrJSContacts['JstNotes']['jstnotes_start_date_time'] = $this->request->data['a_start_date']." ".$datestart;
				
				if($this->request->data['contactid'])
				{
					$arrJSContacts['JstNotes']['jstnotes_contact_id'] = $this->request->data['contactid'];
				}

				$compAppointments = $this->Components->load('Notes');
				$this->loadModel('JstNotes');
				
			
				if($intContactId)
				{
					$arrAppointmentUpdated = $compAppointments->fnUpdateAppointment($arrJSContacts['JstNotes'],$intContactId);
					if($arrAppointmentUpdated['status'] == "success")
					{
						$arrResponse = $arrAppointmentUpdated;
						$arrResponse['contact_id'] = $intContactId;
						
					$arrappointmentDetail = $this->JstNotes->find('all',array('conditions'=>array('jstnotes_seeker_id'=>$arrLoggedUser['candidate_id'])));
					$view = new View($this, false);
					$view->set('addappointsurl',Router::url(array('controller'=>'JstNotes','action'=>'add',$intPortalId),true));
					$view->set('arrAppointmentNoteList',$arrappointmentDetail);
					$this->Session->setFlash('<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Note updated successfully</div>');
					$strWidgetListerHtml = $view->element('note_list_new');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
					}
					else
					{
						$arrResponse = $arrAppointmentUpdated;
					}
					$arrResponse['updated'] = "1";
				}
				else
				{
					$arrAppointCreated = $compAppointments->fnSaveAppointments($arrJSContacts);
					if($arrAppointCreated['status'] == "success")
					{
							
							$arrResponse['message'] = 'You have successfully added the Appointment';
							$arrContacts = array();
							
							$arrJSContacts['JstNotes']['jstnotes_id'] = $this->JstNotes->getLastInsertID();
							$arrContacts[0] = $arrJSContacts;
							$arrappointmentDetail = $this->JstNotes->find('all',array('conditions'=>array('jstnotes_seeker_id'=>$arrLoggedUser['candidate_id'])));
                                                        
                                                        /** Job Click Candidate User Entry **/
                                                            $arrNotesData['candidate_id'] = $arrLoggedUser['candidate_id'];
                                                            $arrNotesData['reference_id'] = $this->JstNotes->getLastInsertID();
                                                            $arrNotesData['career_portal_id'] = $intPortalId;
                                                            $arrNotesData['action_type'] = "notes add";
                                                            $arrNotesData['feature'] = "CRM";
                                                            $arrNotesData['action_date'] = date('Y-m-d h:i:s');
                                                            $this->loadModel('JobStatistics');
                                                            $this->JobStatistics->save($arrNotesData);
                                                        /** Job Click Candidate User Entry **/
                                                        
							$view = new View($this, false);
							$view->set('addappointsurl',Router::url(array('controller'=>'JstNotes','action'=>'add',$intPortalId),true));
							$view->set('arrAppointmentNoteList',$arrappointmentDetail);
							$this->Session->setFlash('<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Note added successfully</div>');
							$strWidgetListerHtml = $view->element('note_list_new');
							$arrResponse['contactshtml'] = $strWidgetListerHtml;
						
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
				$arrJSContacts['JstNotes']['jstappointments_contact_email'] = $this->request->data['contact_email'];
				$arrConditionArray = array();
				$arrConditionArray['jstnotes_seeker_id'] = $intSeekerId;
				
				if($arrJSContacts['JstNotes']['jstappointments_contact_email'])
				{
					$arrConditionArray['jstnotes_contact_email'] = $arrJSContacts['JstNotes']['jstappointments_contact_email'];
				}
				$arrConditionArray['jstnotes_type'] = 'default';
				$compAppointments = $this->Components->load('Notes');
				$arrAppointmentList = $compAppointments->fnGetAppointments($arrConditionArray);
				if(is_array($arrAppointmentList) && (count($arrAppointmentList)>0))
				{
					$arrResponse['status'] = 'success';
					$view = new View($this, false);
					$view->set('arrAppointmentList',$arrAppointmentList);
					$strWidgetListerHtml = $view->element('note_list');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
				}
				else
				{
					$arrResponse['status'] = 'fail';
					$arrResponse['message'] = 'There are no Notes matching with provided filteration criteria';
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
	public function getNote($intPortalId,$intContactId = "")
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
				$this->loadModel('JstNotes');
				$arrContact = $this->JstNotes->find('all',array('conditions'=>array('jstnotes_id'=>$intContactId)));
			
				if(is_array($arrContact) && (count($arrContact)>0))
				{
					$arrResponse['status'] = 'success';
					$arrResponse['contact'] = $arrContact[0];
					$view = new View($this, false);
					$view->set('intPortalId',$intPortalId);
					$view->set('arrAppointmentList',$arrContact);
					$view->set('strHeader',"Edit");
					
					
					$strWidgetListerHtml = $view->element('note_add_tpl_new');
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
			
			$this->set('contactlistsurl',Router::url(array('controller'=>'jstnote','action'=>'index',$intPortalId),true));
			
			//print("<pre>");
			//print_r($arrContactDetail);
			
			if($intAppointmentId)
			{
				$arrAppointmentCriteria['jstnotes_id'] = $intAppointmentId;
			}
			$compAppointments = $this->Components->load('Notes');
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
			
			$this->set('contactlistsurl',Router::url(array('controller'=>'jstnote','action'=>'index',$intPortalId),true));
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
			
			if($intContactId)
			{
				$arrAppointmentCriteria['jstnotes_id'] = $intContactId;
			}
			$compAppointments = $this->Components->load('Notes');
			$arrAppointmentList = $compAppointments->fnGetAppointments($arrAppointmentCriteria);
			
			
			
			
			
			//print("<pre>");
			//print_r($arrAppointmentList);
			
			$this->set('arrAppointmentList',$arrAppointmentList);
			$this->set('addcontactsurl',Router::url(array('controller'=>'jstnote','action'=>'add',$intPortalId),true));
			$this->set('strListcontactsurl',Router::url(array('controller'=>'jstnote','action'=>'index',$intPortalId),true));
			//print("<pre>");
			//print_r($arrContactDetail);
			
		}
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
			$arrAppointmentCriteria['jstnotes_type'] = 'default';
			$compAppointments = $this->Components->load('Notes');
			$arrAppointmentList = $compAppointments->fnGetAppointments($arrAppointmentCriteria);
			$this->set('arrAppointmentList',$arrAppointmentList);
			//print("<pre>");
			//print_r($arrAppointmentList);
			//exit;
		}
	}
	
		
	public function calendar($intPortalId)
	{
		Configure::write('debug','2');
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
					//$arrAppointmentDetail['title'] = "Appointment with ".$arrAppointment['JstAppointments']['jstappointments_contact_fname'];
					$strTitle = "";
					$arrStrTitle = array();
					
					if($arrAppointment['JstAppointments']['jstappointments_title'])
					{
						$arrStrTitle[] = $arrAppointment['JstAppointments']['jstappointments_title'];
					}
					
					if($arrAppointment['JstAppointments']['jstappointments_contact_fname'])
					{
						$arrStrTitle[] = "Contact Name:- ".$arrAppointment['JstAppointments']['jstappointments_contact_fname'];
					}
					
					if($arrAppointment['JstAppointments']['jstappointments_start_date'])
					{
						$arrStrTitle[] = " On ".$arrAppointment['JstAppointments']['jstappointments_start_date'];
					}
					if(is_array($arrStrTitle) && (count($arrStrTitle)>0))
					{
						$strTitle = implode(",",$arrStrTitle);
					}
					
					if($strTitle)
					{
						$arrAppointmentDetail['title'] = $strTitle;
					}
					
					$arrAppointmentDetail['start'] = $arrAppointment['JstAppointments']['jstappointments_start_date']."T".$arrAppointment['JstAppointments']['jstappointments_start_time'];
					$arrAppointmentDetail['end'] = $arrAppointment['JstAppointments']['jstappointments_end_date']."T".$arrAppointment['JstAppointments']['jstappointments_end_time'];
					$arrAppointmentDetail['id'] = $arrAppointment['JstAppointments']['jstappointments_id'];
					$arrAppointments['event'][] = $arrAppointmentDetail;
				}
				$view = new View($this, false);
				$view->set('arrAppointmentList',$arrAppointments);
			}
			else
			{
				$view->set('arrAppointmentList',$arrAppointmentList);
			}
				$strWidgetListerHtml = $view->element('calendar');
				$arrResponse['status'] = "success";
				$arrResponse['html'] = $strWidgetListerHtml;
				echo json_encode($arrResponse);
				exit;
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
}
