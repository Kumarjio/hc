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
class ReferencesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
 public $components = array('Paginator');
	public $name = 'References';

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
	
	public function getreferencetemp($intPortalId = "5",$intRefId = "3,4,5")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('JobberlandCounties');
		if($intPortalId)
		{
			if($intRefId)
			{
				$arrRefId = explode(",",$intRefId);
				$this->loadModel('Candidate');
				$this->loadModel('Employee');
				$intSeekerId = $arrLoggedUser['candidate_id'];
				$arrCandidateDetail = $this->Candidate->find('all',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'])));
				
				
				$arrCandidateCDetail = $this->Employee->find('all',array('conditions'=>array('hc_uid'=>$arrLoggedUser['candidate_id'])));
				//print("<pre>");
				//print_r($arrCandidateCDetail);
				//exit;
				
				$this->loadModel('CandidateReferences');
				$arrRefDetail = $this->CandidateReferences->find('all',array('conditions'=>array('candidate_reference_id'=>$arrRefId)));
				
				//print("<pre>");
				//print_r($arrRefId);
				//exit;
				
				$view = new View($this, false);
				$view->set('arrCvDetail',$arrRefDetail);
				$view->set('arrCandDetail',$arrCandidateDetail);
				$view->set('arrCandidateCDetail',$arrCandidateCDetail);
				$view->set('strFont',"calibri");
				$view->set('strFontSize',"13");
				
				$html = $view->element('referencehtml');
				//exit;
				
				$strWorksheetFolder = "candidate_refrences";
				$strWorksheetName = "candidate_refrence_".$intPortalId."_".$intSeekerId.".pdf";
				$strCompleteStorageLocation = $strWorksheetFolder."/".$strWorksheetName;
				App::import('Vendor', 'mpdf/mpdf');
				$mpdf=new mPDF();
				$mpdf->SetDisplayMode('fullpage');
				// LOAD a stylesheet
				//$stylesheet = file_get_contents(Router::url('/',true).'css/fontresume.css');
				//$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
				$mpdf->WriteHTML($html);
				$strFileCreated = $mpdf->Output($strCompleteStorageLocation,'F');
				//echo $html;exit;
				if($strFileCreated)
				{
					$arrResponse['status'] = "success";
					$arrResponse['filename'] = $strWorksheetName;
				}
				else
				{
					$arrResponse['status'] = "fail";
				}
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Some thing is missing, Please try again";
			}
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function index($intPortalId = "")
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
			
			$strPageText = "You will be asked to submit your references throughout your job search.  It is wise to have a list completed with your Professional References.  
						When you provide your references, make sure you have called each reference to inform them of the specific opportunities you are targeting.  This will help them customize their response to fit the credentials, most important to a prospective employer.
						It is no longer required to list “References Provided Upon Request” on your resume.  List a minimum a three professional references.";
			
			$this->set('strPageText',$strPageText);
			
			$this->loadModel('CandidateReferences');
			$arrCandidateReferenceDetail = $this->CandidateReferences->find('all', array(
									'conditions' => array('candidate_id'=> $arrLoggedUser['candidate_id'])
								));
								
			/*print("<pre>");
			print_r($arrCandidateReferenceDetail);exit;*/
			$this->set('arrCandidateReferenceDetail',$arrCandidateReferenceDetail);
		}
	}
	
	
	
	public function getRefrenceshtml($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = FALSE;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		
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
			
			$strPageText = "You will be asked to submit your references throughout your job search.  It is wise to have a list completed with your Professional References.  
						When you provide your references, make sure you have called each reference to inform them of the specific opportunities you are targeting.  This will help them customize their response to fit the credentials, most important to a prospective employer.
						It is no longer required to list “References Provided Upon Request” on your resume.  List a minimum a three professional references.";
			
			$this->set('strPageText',$strPageText);
			
			$this->loadModel('CandidateReferences');
			/*$arrCandidateReferenceDetail = $this->CandidateReferences->find('all', array(
									'conditions' => array('candidate_id'=> $arrLoggedUser['candidate_id'])
								));*/
								
								
		$this->loadModel('CandidateReferences');

		$this->CandidateReferences->recursive = 0;

		$this->Paginator->settings = array(

			'CandidateReferences' => array(

				'limit' => 20,

				'conditions' => array('candidate_id' => $arrLoggedUser['candidate_id']),

			)

		);

		

		$arrCandidateReferenceDetail = $this->Paginator->paginate('CandidateReferences');
								
			/*print("<pre>");
			print_r($arrCandidateReferenceDetail);exit;*/
			//$this->set('arrCandidateReferenceDetail',$arrCandidateReferenceDetail);
			
				$view = new View($this, false);
				$view->set('arrCandidateReferenceDetail',$arrCandidateReferenceDetail);
				//$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
				//$view->set('arrContactDetail',$arrContactDetail);
				$strWidgetListerHtml = $view->element('refrences_list');
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
	
	
		public function getreferenceform($intPortalId)
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$this->loadModel('JobberlandCounties');
		$countrylist = $this->JobberlandCounties->find('list', array('fields'=>array('code', 'name'),'conditions'=>array('enabled'=>'Y')));
		$view = new View($this, false);
		$view->set('countrylist',$countrylist);
		$strAppointmentDetailHtml = $view->element('reference_add');
		$arrResponse['contactshtml'] = $strAppointmentDetailHtml;
		if($arrResponse['contactshtml'] != "")
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
		exit;
	}
		public function getReference($intPortalId,$reference_id)
	{
			
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$this->loadModel('JobberlandCounties');
		$countrylist = $this->JobberlandCounties->find('list', array('fields'=>array('code', 'name'),'conditions'=>array('enabled'=>'Y')));
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			
			if($this->request->is('Post'))
			{
				$intSeekerId = $arrLoggedUser['candidate_id'];				
				$this->loadModel('CandidateReferences');
				
			$arrCandidateReferenceDetail = $this->CandidateReferences->find('all', array(
									'conditions' => array('candidate_id'=> $arrLoggedUser['candidate_id'],'candidate_reference_id'=>$reference_id)
								));
								/*print_r($arrCandidateReferenceDetail);
								exit();*/
				if(is_array($arrCandidateReferenceDetail) && (count($arrCandidateReferenceDetail)>0))
				{
					//print("<pre>");
					//print_r($arrCandidateReferenceDetail);
					
					$arrResponse['status'] = 'success';
					
					$view = new View($this, false);
					$view->set('intPortalId',$intPortalId);
					$view->set('arrCandidateReferenceDetail',$arrCandidateReferenceDetail);
					$view->set('strHeader',"Edit");
					$view->set('countrylist',$countrylist);
					
					
					$strWidgetListerHtml = $view->element('reference_add');
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
	
	public function removeref($intPortalId = "",$intCandRefId )
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
				
				if($intCandRefId)
				{
					
					// code to delete
					$this->loadModel('CandidateReferences');
					$intCandidateReferenceDeleted = $this->CandidateReferences->deleteAll(array('CandidateReferences.candidate_reference_id' => $intCandRefId),false);
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
			$arrLoggedUser = $this->Auth->user();
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
				
				$this->request->data['CandidateReferences']['address'] = addslashes(trim($this->request->data['txt_address2']));
				$this->request->data['CandidateReferences']['zipcode'] = addslashes(trim($this->request->data['txt_post_code']));
				$this->request->data['CandidateReferences']['country'] = addslashes(trim($this->request->data['txt_country_ref']));
				$this->request->data['CandidateReferences']['state'] = addslashes(trim($this->request->data['txtstateprovinceref']));
				$this->request->data['CandidateReferences']['county'] = addslashes(trim($this->request->data['txtcountyref']));
				$this->request->data['CandidateReferences']['city'] = addslashes(trim($this->request->data['localityvalref']));
				$this->request->data['CandidateReferences']['reference_creator_id'] = $arrLogedUser['candidate_id'];
				
				if($this->request->data['edit_reference_id'])
				{
					// code to edit
					$boolUpdated = $this->CandidateReferences->updateAll(
								array('CandidateReferences.reference_name' => "'".$this->request->data['CandidateReferences']['reference_name']."'",'CandidateReferences.reference_job_title'=>"'".$this->request->data['CandidateReferences']['reference_job_title']."'",'CandidateReferences.reference_company_name'=>"'".$this->request->data['CandidateReferences']['reference_company_name']."'",'CandidateReferences.reference_tele_number'=>"'".$this->request->data['CandidateReferences']['reference_tele_number']."'",'CandidateReferences.reference_phone_number'=>"'".$this->request->data['CandidateReferences']['reference_phone_number']."'",'CandidateReferences.reference_email_address'=>"'".$this->request->data['CandidateReferences']['reference_email_address']."'",'CandidateReferences.address'=>"'".$this->request->data['CandidateReferences']['address']."'",'CandidateReferences.zipcode'=>"'".$this->request->data['CandidateReferences']['zipcode']."'",'CandidateReferences.country'=>"'".$this->request->data['CandidateReferences']['country']."'",'CandidateReferences.state'=>"'".$this->request->data['CandidateReferences']['state']."'",'CandidateReferences.state'=>"'".$this->request->data['CandidateReferences']['state']."'",'CandidateReferences.city'=>"'".$this->request->data['CandidateReferences']['city']."'",'CandidateReferences.city'=>"'".$this->request->data['CandidateReferences']['city']."'"),
								array('CandidateReferences.candidate_reference_id =' => $this->request->data['edit_reference_id'])
							);
					if($boolUpdated)
					{
						$arrResponse['status'] = "success";
						$arrResponse['message'] = "Reference Updated successfully!!";
						$arrResponse['updateid'] = $this->request->data['edit_reference_id'];
						$arrCandidateReferenceDetail = $this->CandidateReferences->find('all', array(
									'conditions' => array('candidate_id'=> $arrLoggedUser['candidate_id'])
								));
							$view = new View($this, false);
							
							$view->set('arrCandidateReferenceDetail',$arrCandidateReferenceDetail);
							$this->Session->setFlash('<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Refrence added successfully</div>');
							$strWidgetListerHtml = $view->element('refrences_list');
							$arrResponse['contactshtml'] = $strWidgetListerHtml;
							
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
							
							
							$arrCandidateReferenceDetail = $this->CandidateReferences->find('all', array(
									'conditions' => array('candidate_id'=> $arrLoggedUser['candidate_id'])
								));
							$view = new View($this, false);
							
							$view->set('arrCandidateReferenceDetail',$arrCandidateReferenceDetail);
							$this->Session->setFlash('<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Refrence added successfully</div>');
							$strWidgetListerHtml = $view->element('refrences_list');
							$arrResponse['contactshtml'] = $strWidgetListerHtml;
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
