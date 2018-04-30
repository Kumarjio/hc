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
class JsttasksController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Jsttasks';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('registration','reset','jobsearch','forgotpassword','jobdetail','deletealltasks');
	}
	
	public function getalltaskshtml($intPortalId = "",$strForToday = "")
	{
		$this->layout = NULL;
		$this->autoRender = FALSE;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		
		if($intPortalId)
		{
			$arrAppointmentCriteria['jsttasks_seeker_id'] = $arrLoggedUser['candidate_id'];			
			if($strForToday)
			{
				
				$arrAppointmentCriteria['jsttasks_start_date_time >='] = date('Y-m-d')." 00:00:00";
				$arrAppointmentCriteria['jsttasks_start_date_time <='] = date('Y-m-d')." 23:59:59";
				$arrAppointmentCriteria['jsttasks_start_date'] = date('Y-m-d')." 00:00:00";
				$arrAppointmentCriteria['jsttasks_end_date'] = date('Y-m-d')." 23:59:59";
				
			}
			
			$compAppointments = $this->Components->load('Tasks');
			$arrAppointmentList = $compAppointments->fnGetAppointments($strForToday);

//			$this->set('arrAppointmentList',$arrAppointmentList);
//			if(is_array($arrAppointmentList) && (count($arrAppointmentList)>0))
//			{
				$view = new View($this, false);
				$view->set('arrAppointmentList',$arrAppointmentList);
				//$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
				//$view->set('arrContactDetail',$arrContactDetail);
				$strWidgetListerHtml = $view->element('tasks_list_new');
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
	
	public function gettaskform()
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$view = new View($this, false);
		$strWidgetListerHtml = $view->element('tasks_add_tpl_new');
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	
	public function getTask($intPortalId,$intContactId = "")
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
				$this->loadModel('JstTasks');
				$arrContact = $this->JstTasks->find('all',array('conditions'=>array('jsttasks_id'=>$intContactId)));
				/*print("<pre>");
				print_r($arrContact);
				exit;*/
				if(is_array($arrContact) && (count($arrContact)>0))
				{
					$arrResponse['status'] = 'success';
					$arrResponse['contact'] = $arrContact[0];
					$view = new View($this, false);
					$view->set('intPortalId',$intPortalId);
					$view->set('arrAppointmentList',$arrContact);
					$view->set('strHeader',"Edit");
					
					
					$strWidgetListerHtml = $view->element('tasks_add_tpl_new');
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
	
	public function completetask($intPortalId,$intContactId = "",$strAction = "")
	{
		//onfigure::write('debug','2');
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId && $intContactId && $strAction)
		{
			$arrLoggedUser = $this->Auth->user();
			$intSeekerId = $arrLoggedUser['candidate_id'];
			$compAppointments = $this->Components->load('Tasks');
			$intAppointmentDeleted = $compAppointments->fnCompeleteTasks($intContactId,$strAction);
			if($intAppointmentDeleted)
			{
				$arrResponse['status'] = 'success';
				$arrResponse['message'] = 'Task was marked '.$strAction.' Successfully';
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
				
				$compAppointments = $this->Components->load('Tasks');
				$intAppointmentDeleted = $compAppointments->fnDeleteAppointments($intContactId);
				if($intAppointmentDeleted)
				{
					$arrResponse['status'] = 'success';
					$arrResponse['message'] = 'Task was deleted Successfully';
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
	//	echo "HI";
		//echo $intPortalId; exit;
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				 $intContactId = $this->request->data['taskid'];
				
				$intDetailMode = $this->request->data['deteailmode'];
				$arrJSContacts['JstTasks']['jsttasks_seeker_id'] = $arrLoggedUser['candidate_id'];
				$arrJSContacts['JstTasks']['task_type'] = $this->request->data['task_type'];
				$arrJSContacts['JstTasks']['jsttasks_title'] = $this->request->data['note-title'];
				$arrJSContacts['JstTasks']['jsttasks_contact_fname'] = $this->request->data['cname'];
				$arrJSContacts['JstTasks']['jsttasks_contact_email'] = $this->request->data['c_email'];
				$arrJSContacts['JstTasks']['jsttasks_contact_phone_no'] = $this->request->data['c_ph1_no'];
				$arrJSContacts['JstTasks']['jsttasks_description'] = htmlspecialchars($this->request->data['task_dsec']);
				//$arrJSContacts['JstTasks']['jsttasks_start_date'] = $this->request->data['a_start_date'];
				$arrJSContacts['JstTasks']['jsttasks_start_date'] = $this->request->data['from_date_hid'];
				$arrJSContacts['JstTasks']['jsttasks_start_time'] = $this->request->data['a_start_time'];
				//$arrJSContacts['JstTasks']['jsttasks_start_date_time'] = $this->request->data['a_start_date']." ".$this->request->data['a_start_time'];
				
				$arrJSContacts['JstTasks']['jsttasks_start_date_time'] = $this->request->data['from_date_hid']." ".$this->request->data['a_start_time'];
				$arrJSContacts['JstTasks']['jsttasks_end_date'] = "0000-00-00";
				$arrJSContacts['JstTasks']['jsttasks_end_time'] = "00:00";
				
				/*if($this->request->data['a_end_date'])
				{
					$arrJSContacts['JstTasks']['jsttasks_end_date'] = $this->request->data['a_end_date'];
				}*/
				
				if($this->request->data['to_date_hid'])
				{
					$arrJSContacts['JstTasks']['jsttasks_end_date'] = $this->request->data['to_date_hid'];
				}
				
				
				if($this->request->data['a_end_time'])
				{
					$arrJSContacts['JstTasks']['jsttasks_end_time'] = $this->request->data['a_end_time'];
				}
				
				
				/*if($this->request->data['a_end_date'] && $this->request->data['a_end_time'])
				{
					$arrJSContacts['JstTasks']['jsttasks_end_date_time'] = $this->request->data['a_end_date']." ".$this->request->data['a_end_time'];
				}
				else
				{
					$arrJSContacts['JstTasks']['jsttasks_end_date_time'] = NULL;
				}*/
				
				if($this->request->data['to_date_hid'] && $this->request->data['a_end_time'])
				{
					$arrJSContacts['JstTasks']['jsttasks_end_date_time'] = $this->request->data['to_date_hid']." ".$this->request->data['a_end_time'];
				}
				else
				{
					$arrJSContacts['JstTasks']['jsttasks_end_date_time'] = NULL;
				}
				
				$arrJSContacts['JstTasks']['jsttasks_reminder_set'] = $this->request->data['appt_reminder'];
				
				if($this->request->data['contactid'])
				{
					$arrJSContacts['JstTasks']['jsttasks_contact_id'] = $this->request->data['contactid'];
				}

				$compAppointments = $this->Components->load('Tasks');
				$this->loadModel('JstTasks');
				//print("<pre>");
				//print_r($arrJSContacts);
				//exit;
				
				if($intContactId)
				{
					$arrAppointmentUpdated = $compAppointments->fnUpdateAppointment($arrJSContacts['JstTasks'],$intContactId);
					if($arrAppointmentUpdated['status'] == "success")
					{
						$arrResponse = $arrAppointmentUpdated;
						$arrResponse['contact_id'] = $intContactId;
						$view = new View($this, false);
						
							 $arrJSContacts['JstTasks']['jsttasks_id'] = $intContactId;
							
							$arrAppointments[0] = $arrJSContacts;
							
							$arrappointmentDetail = $this->JstTasks->find('all',array('conditions'=>array('jsttasks_seeker_id'=>$arrLoggedUser['candidate_id'])));
						

							$view = new View($this, false);
							
							$view->set('addtaskurl',Router::url(array('controller'=>'JstTasks','action'=>'add',$intPortalId),true));
							$view->set('arrAppointmentList',$arrappointmentDetail);
							$this->Session->setFlash('<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Task updated successfully</div>');
							$strWidgetListerHtml = $view->element('tasks_list_new');
							$arrResponse['contactshtml'] = $strWidgetListerHtml;
					}
					else
					{
						$arrResponse = $arrAppointmentUpdated;
						$this->Session->setFlash('<div class="alert alert-danger">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Some error, Please try again.</div>');
					}
					$arrResponse['updated'] = "1";
				}
				else
				{
					//print("<pre>");
					//print_r($arrJSContacts);EXIT;
					$arrAppointCreated = $compAppointments->fnSaveAppointments($arrJSContacts);
					if($arrAppointCreated['status'] == "success")
					{
						//print("<pre>");
						//print_r($arrAppointCreated);
						
							$arrResponse['status'] = 'success';
							$arrResponse['message'] = 'You have successfully added the task';
							$arrContacts = array();
							
							$arrJSContacts['JstTasks']['jsttasks_id'] = $this->JstTasks->getLastInsertID();
							$arrContacts[0] = $arrJSContacts;
							$arrTaskDetail = $this->JstTasks->find('all',array('conditions'=>array('jsttasks_seeker_id'=>$arrLoggedUser['candidate_id'])));
							
                                                        /** Job Click Candidate User Entry **/
                                                            $arrTaskData['candidate_id'] = $arrLoggedUser['candidate_id'];
                                                            $arrTaskData['reference_id'] = $this->JstTasks->getLastInsertID();
                                                            $arrTaskData['career_portal_id'] = $intPortalId;
                                                            $arrTaskData['action_type'] = "task add";
                                                            $arrTaskData['feature'] = "CRM";
                                                            $arrTaskData['action_date'] = date('Y-m-d h:i:s');
                                                            $this->loadModel('JobStatistics');
                                                            $this->JobStatistics->save($arrTaskData);
                                                        /** Job Click Candidate User Entry **/
                                                        
							$view = new View($this, false);
							
							$view->set('addtaskurl',Router::url(array('controller'=>'JstTasks','action'=>'add',$intPortalId),true));
							$view->set('arrAppointmentList',$arrTaskDetail);
							$this->Session->setFlash('<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Task added successfully</div>');
							$strWidgetListerHtml = $view->element('tasks_list_new');
							$arrResponse['contactshtml'] = $strWidgetListerHtml;
					}
					else
					{
						$arrResponse = $arrAppointCreated;
						$this->Session->setFlash('<div class="alert alert-danger">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Some error, Please try again.</div>');
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
				$arrJSContacts['JstTasks']['jsttasks_contact_fname'] = $this->request->data['contact_fname'];
				$arrJSContacts['JstTasks']['jsttasks_contact_email'] = $this->request->data['contact_email'];
				$strSearchType = $this->request->data['search_type'];
				
				$arrConditionArray = array();
				$arrConditionArray['jsttasks_seeker_id'] = $intSeekerId;
				
				if($arrJSContacts['JstTasks']['jsttasks_contact_fname'])
				{
					$arrConditionArray['jsttasks_contact_fname'] = $arrJSContacts['JstTasks']['jstappointments_contact_fname'];
				}
				
				if($arrJSContacts['JstTasks']['jsttasks_contact_email'])
				{
					$arrConditionArray['jsttasks_contact_email'] = $arrJSContacts['JstTasks']['jsttasks_contact_email'];
				}
				if($strSearchType == "today")
				{
					$arrConditionArray['jsttasks_start_date_time >='] = date('Y-m-d')." 00:00:00";
					$arrConditionArray['jsttasks_start_date_time <='] = date('Y-m-d')." 23:59:59";
				}
				
				if($strSearchType == "completed")
				{
					$arrConditionArray['jsttasks_end_date !='] = "0000-00-00";
				}
				
				$compAppointments = $this->Components->load('Tasks');
				$arrAppointmentList = $compAppointments->fnGetAppointments($arrConditionArray);
				if(is_array($arrAppointmentList) && (count($arrAppointmentList)>0))
				{
					$arrResponse['status'] = 'success';
					$view = new View($this, false);
					$view->set('arrAppointmentList',$arrAppointmentList);
					$strWidgetListerHtml = $view->element('tasks_list');
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
			$this->set('strFooter1','<a href="'.Router::url(array('controller'=>'jstcontacts','action'=>'index',$intPortalId),true).'">My Contacts</a>');
			$this->set('strFooter2','<a href="'.Router::url(array('controller'=>'jsttasks','action'=>'index',$intPortalId),true).'">Tasks</a>');
			$this->set('strFooter3','<a href="'.Router::url(array('controller'=>'jsprocess','action'=>'index',$intPortalId),true).'">Job Search Process</a>');
			
			$this->set('contactlistsurl',Router::url(array('controller'=>'jsttasks','action'=>'index',$intPortalId),true));
			
			//print("<pre>");
			//print_r($arrContactDetail);
			
			if($intAppointmentId)
			{
				$arrAppointmentCriteria['jsttasks_id'] = $intAppointmentId;
			}
			$compAppointments = $this->Components->load('Tasks');
			$arrAppointmentList = $compAppointments->fnGetAppointments($arrAppointmentCriteria);
			//print("<pre>");
			//print_r($arrAppointmentList);
			$arrAppointmentList[0]['JstAppointments']['jstappointments_id'] = $arrAppointmentList[0]['JstTasks']['jsttasks_id'];
			
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
			$this->set('strFooter1','<a href="'.Router::url(array('controller'=>'jstcontacts','action'=>'index',$intPortalId),true).'">My Contacts</a>');
			$this->set('strFooter2','<a href="'.Router::url(array('controller'=>'jsttasks','action'=>'index',$intPortalId),true).'">Tasks</a>');
			$this->set('strFooter3','<a href="'.Router::url(array('controller'=>'jsprocess','action'=>'index',$intPortalId),true).'">Job Search Process</a>');
			
			$this->set('contactlistsurl',Router::url(array('controller'=>'jsttasks','action'=>'index',$intPortalId),true));
			if($intContactId)
			{
				$this->loadModel('JstContacts');
				$arrContactDetail = $this->JstContacts->find('all',array('conditions'=>array('jstcontacts_id'=>$intContactId)));
				
				if(is_array($arrContactDetail) && (count($arrContactDetail)>0))
				{
					$arrAppointmentList[0]['JstTasks']['jsttasks_contact_fname'] = $arrContactDetail[0]['JstContacts']['jstcontacts_fname']." ".$arrContactDetail[0]['JstContacts']['jstcontacts_lname'];
					$arrAppointmentList[0]['JstTasks']['jsttasks_contact_email'] = $arrContactDetail[0]['JstContacts']['jstcontacts_emailaddress'];
					$arrAppointmentList[0]['JstTasks']['jsttasks_contact_phone_no'] =  $arrContactDetail[0]['JstContacts']['jstcontacts_phone1'];
					$arrAppointmentList[0]['JstTasks']['jsttasks_contact_id'] = $arrContactDetail[0]['JstContacts']['jstcontacts_id'];
					$this->set('arrAppointmentList',$arrAppointmentList);
				}
			}
			
			
			//print("<pre>");
			//print_r($arrContactDetail);
		}
	}
	
	public function appointmentsnotes($intPortalId = "",$intContactId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		if($intPortalId)
		{
			$compAppointments = $this->Components->load('Appointments');
			$arrAppointmentNotes = $compAppointments->fnGetAppointmentsNotes($intContactId);
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
				$arrAppointmentCriteria['jsttasks_id'] = $intAppointmentId;
			}
			$compAppointments = $this->Components->load('Tasks');
			$arrAppointmentList = $compAppointments->fnGetAppointments($arrAppointmentCriteria);
			$arrAppointmentList[0]['JstAppointments']['jstappointments_id'] = $arrAppointmentList[0]['JstTasks']['jsttasks_id'];
			//print("<pre>");
			//print_r($arrAppointmentList);
			
			$this->set('arrAppointmentList',$arrAppointmentList);
			$this->set('addcontactsurl',Router::url(array('controller'=>'jsttasks','action'=>'add',$intPortalId),true));
			$this->set('strListcontactsurl',Router::url(array('controller'=>'jsttasks','action'=>'index',$intPortalId),true));
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
			$this->set('strFooter1','<a href="'.Router::url(array('controller'=>'jstcontacts','action'=>'index',$intPortalId),true).'">My Contacts</a>');
			$this->set('strFooter2','<a href="'.Router::url(array('controller'=>'jsttasks','action'=>'index',$intPortalId),true).'">Tasks</a>');
			$this->set('strFooter3','<a href="'.Router::url(array('controller'=>'jsprocess','action'=>'index',$intPortalId),true).'">Job Search Process</a>');
			
			if($intContactId)
			{
				$arrAppointmentCriteria['jsttasks_seeker_id'] = $arrLoggedUser['candidate_id'];
				$arrAppointmentCriteria['jsttasks_contact_id'] = $intContactId;
				
			}
			
			$arrAppointmentCriteria['jsttasks_start_date_time >='] = date('Y-m-d')." 00:00:00";
			$arrAppointmentCriteria['jsttasks_start_date_time <='] = date('Y-m-d')." 23:59:59";
			$arrAppointmentCriteria['jsttasks_end_date'] = "0000-00-00";
			
			$compAppointments = $this->Components->load('Tasks');
			$arrAppointmentList = $compAppointments->fnGetAppointments($arrAppointmentCriteria);
			$this->set('arrAppointmentList',$arrAppointmentList);
			$this->set('strSearchType','today');
			//print("<pre>");
			//print_r($arrAppointmentList);
			//exit;
		}
	}
	
	public function completedtasks($intPortalId = "",$intContactId = "")
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
			$this->set('strFooter1','<a href="'.Router::url(array('controller'=>'jstcontacts','action'=>'index',$intPortalId),true).'">My Contacts</a>');
			$this->set('strFooter2','<a href="'.Router::url(array('controller'=>'jsttasks','action'=>'index',$intPortalId),true).'">Tasks</a>');
			$this->set('strFooter3','<a href="'.Router::url(array('controller'=>'jsprocess','action'=>'index',$intPortalId),true).'">Job Search Process</a>');
			
			if($intContactId)
			{
				$arrAppointmentCriteria['jsttasks_seeker_id'] = $arrLoggedUser['candidate_id'];
				$arrAppointmentCriteria['jsttasks_contact_id'] = $intContactId;
			}
			$arrAppointmentCriteria['jsttasks_end_date !='] = "0000-00-00";
			
			$compAppointments = $this->Components->load('Tasks');
			$arrAppointmentList = $compAppointments->fnGetAppointments($arrAppointmentCriteria);
			$this->set('arrAppointmentList',$arrAppointmentList);
			$this->set('strSearchType','completed');
			//print("<pre>");
			//print_r($arrAppointmentList);
			//exit;
		}
	}
	
	public function alltasks($intPortalId = "",$intContactId = "")
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
			$this->set('strFooter1','<a href="'.Router::url(array('controller'=>'jstcontacts','action'=>'index',$intPortalId),true).'">My Contacts</a>');
			$this->set('strFooter2','<a href="'.Router::url(array('controller'=>'jsttasks','action'=>'index',$intPortalId),true).'">Tasks</a>');
			$this->set('strFooter3','<a href="'.Router::url(array('controller'=>'jsprocess','action'=>'index',$intPortalId),true).'">Job Search Process</a>');
			
			if($intContactId)
			{
				$arrAppointmentCriteria['jsttasks_seeker_id'] = $arrLoggedUser['candidate_id'];
				$arrAppointmentCriteria['jsttasks_contact_id'] = $intContactId;
			}
			$compAppointments = $this->Components->load('Tasks');
			$arrAppointmentList = $compAppointments->fnGetAppointments($arrAppointmentCriteria);
			$this->set('arrAppointmentList',$arrAppointmentList);
			$this->set('strSearchType','all');
			//print("<pre>");
			//print_r($arrAppointmentList);
			//exit;
		}
	}
	
	public function removeref($intPortalId = "",$intCandRefId = "")
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
				
				//$this->request->data['can_ref_id'] = '17';
				
				if($this->request->data['can_ref_id'])
				{
					
					// code to delete
					$this->loadModel('CandidateReferences');
					$intCandidateReferenceDeleted = $this->CandidateReferences->deleteAll(array('CandidateReferences.candidate_reference_id' => $this->request->data['can_ref_id']),false);
					if($intCandidateReferenceDeleted)
					{
						$intPortalReferenceExists = $this->CandidateReferences->find('count', array(
									'conditions' => array('candidate_id' => $arrLogedUser['candidate_id'])
						));
						
						$arrResponse['delstatus'] = "success";
						$arrResponse['message'] = "Reference Removed successfully!!";
						$arrResponse['updateid'] = $this->request->data['can_ref_id'];
						$arrResponse['remainingref'] = $intPortalReferenceExists;
						echo json_encode($arrResponse);
						exit;
					}
					else
					{
						$arrResponse['delstatus'] = "fail";
						$arrResponse['message'] = "Please try deleting again!!";
						echo json_encode($arrResponse);
						exit;
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
        
        public function deletealltasks()
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$intTaskId = $this->request->data['inttaskId'];
		$intPortalId = $this->request->data['PortalId'];
                
		if($intPortalId && $intTaskId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
                            $taskId = explode(",", $intTaskId);
                            foreach ($taskId as $Id){
                                $compAppointments = $this->Components->load('Tasks');
				$intAppointmentDeleted = $compAppointments->fnDeleteAppointments($Id);
                            }
                            
                            $arrResponse['status'] = 'success';
//                            $arrResponse['message'] = 'Task was deleted Successfully';
                            $arrResponse['intTaskId'] = $intTaskId;
                            $arrResponse['message'] = '<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Task was deleted Successfully.</div>';
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
