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
class JoblistingController extends AppController 
{

	var $helpers = array ('Html','Form');


/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Joblisting';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public function beforeFilter()
	{
		//$this->Auth->autoRedirect = false;
		parent::beforeFilter();
		$this->Auth->allow('index');
	}
	
	
	public function index($intPortalId = "")
	{			$condition = '';	
	
				$this->loadModel('Joblisting');		
		if($this->request->is('Post') && ($this->request->data['filter_on']))
		{
			$strProductFilterKeyword = $this->request->data['product_keyword'];
			
			$this->redirect(array('controller'=>'joblisting','action'=>'search',$strProductFilterKeyword));
		}
						
				$this->paginate = array('fields' => array('Joblisting.*','employer.company_name','portal.career_portal_name'),'joins'=>array(array('table' => 'jobberland_employer','alias' => 'employer','type' => 'inner','recursive' => -1,'conditions'=> array('employer.id = Joblisting.fk_employer_id')				),				array(					'table' => 'career_portal',					'alias' => 'portal',					'type' => 'inner',					'recursive' => -1,					'conditions'=> array('portal.career_portal_id = Joblisting.fk_hc_portal_id')			  )),					'conditions' => $condition , 'limit' => 10);			
				$this->set( 'jobs', $this->paginate() ); 
	
	}
	
	public function deletejob($intJobId)
	{
		$arrResponse = array();
		if($intJobId)
		{
			
			$this->loadModel('Joblisting');
			$intCorrectProductId = $this->Joblisting->find('count',array('conditions'=>array('id'=>$intJobId)));
			if($intCorrectProductId)
			{
				$intContentDeleted = $this->Joblisting->deleteAll(array('id' => $intJobId),false);
				if($intContentDeleted)
				{
				
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Entry has been deleted successfully','success');
					$this->set('strMessage',$strMessage);
					$arrResponse['status'] = "success";
					$arrResponse['message'] = $strMessage;
					
					echo json_encode($arrResponse);exit;
				}
				else
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Some error, Please try again','error');
					$this->set('strMessage',$strMessage);
					
					$arrResponse['status'] = "fail";
					$arrResponse['message'] = $strMessage;
					
					echo json_encode($arrResponse);exit;
				}
			}
			else
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('Entry does not exists','info');
				$this->set('strMessage',$strMessage);
				
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = $strMessage;
				
				echo json_encode($arrResponse);exit;
			}
		}
		else
		{
			$compMessage = $this->Components->load('Message');
			$strMessage = $compMessage->fnGenerateMessageBlock('Something is missing, Please try again','error');
			$this->set('strMessage',$strMessage);
			
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = $strMessage;
			
			echo json_encode($arrResponse);exit;
		}
	}
	
	public function changeJobStatus($intJobId)
	{
		$this->loadModel('Joblisting');
		if($intJobId)
		{
			 $is_active =  $this->Joblisting->field('is_active', array('id' => $intJobId));
			 $is_active = $is_active=='Y'?'N':'Y';
			 $boolStatusChanged = $this->Joblisting->updateAll(array('is_active' => "'$is_active'"),array('id' => $intJobId));	
			 if($boolStatusChanged)
			 {
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Job Status has been changed successfully','success');
					$this->set('strMessage',$strMessage);
					$arrResponse['status'] = "success";
					$arrResponse['message'] = $strMessage;
					echo json_encode($arrResponse);exit;
			 }
			 else
			 {
				 $compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Job Status has been chang failed','success');
					$this->set('strMessage',$strMessage);
					$arrResponse['status'] = "success";
					$arrResponse['message'] = $strMessage;
					echo json_encode($arrResponse);exit;
			 }
			 
		}
		
	}
	public function search($strKeywordSearch)
	{			
	
				$this->loadModel('Joblisting');		
		
						
				$this->paginate = array( 'fields' =>
				array('Joblisting.*','employer.company_name','portal.career_portal_name'),
				'joins'=>array(array('table' => 'jobberland_employer','alias' => 'employer','type' => 'inner',				'recursive' => -1,				'conditions'=> array('employer.id = Joblisting.fk_employer_id')				),				array(					'table' => 'career_portal',					'alias' => 'portal',					'type' => 'inner',					'recursive' => -1,					'conditions'=> array('portal.career_portal_id = Joblisting.fk_hc_portal_id')			  )),					'conditions' => array('Joblisting.job_title'=>$strKeywordSearch) , 'limit' => 10);			
				$this->set( 'jobs', $this->paginate() ); 
	
	}
	
	public function applyjob($intPortalId = "", $intCandidateId = "", $intJobId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUserDetails = $this->Auth->user();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
								
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				$this->loadModel('JobsApplied');
				$intJobAlreadyApplied = $this->JobsApplied->find('count',array('conditions'=>array('job_portal_id'=>$intPortalId,'job_id'=>$intJobId,'candidate_id'=>$intCandidateId)));
				if($intJobAlreadyApplied)
				{
					$arrJobApplicationResult = array();
					$arrJobApplicationResult['status'] = 'failure';
					$this->Session->setFlash('This Job has already been applied');
					echo json_encode($arrJobApplicationResult);
					exit;
				}
				else
				{
					$this->request->data['JobsApplied']['job_portal_id'] = $intPortalId;
					$this->request->data['JobsApplied']['job_id'] = $intJobId;
					$this->request->data['JobsApplied']['candidate_id'] = $intCandidateId;
					
					$boolJobApplied = $this->JobsApplied->save($this->request->data);
					if($boolJobApplied)
					{
						$arrJobApplicationResult = array();
						$arrJobApplicationResult['status'] = 'success';
						$this->Session->setFlash('You applied for the job successfully','default',array('class' => 'success'));
						echo json_encode($arrJobApplicationResult);
						exit;
					}
					else
					{
						$arrJobApplicationResult = array();
						$arrJobApplicationResult['status'] = 'failure';
						$this->Session->setFlash('There is some technical issue, please try again');
						echo json_encode($arrJobApplicationResult);
						exit;
					}
				}
			}
		}
	}
	
	public function jobdetail($intPortalId = "",$intJobId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUserDetails = $this->Auth->user();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			$this->set('intCandidateId',$arrLoggedUserDetails['candidate_id']);
			
			$this->loadModel('Job');
			$arrJobDetail = $this->Job->find('all',array('conditions'=>array('portal_id'=>$intPortalId,'id'=>$intJobId)));
			$this->set('strJobApplyUrl',Router::url(array('controller'=>'joblisting','action'=>'applyjob',$intPortalId,$arrLoggedUserDetails['candidate_id'],$arrJobDetail[0]['Job']['id'])),true);
			if(is_array($arrJobDetail) && (count($arrJobDetail)>0))
			{
				$intJobConut = 0;
				foreach($arrJobDetail as $arrjob)
				{
					$this->loadModel('JobCategory');
					$arrJobCategoryDetail = $this->JobCategory->find('all',array('conditions'=>array('id'=>$arrjob['Job']['category_id'])));
					$arrJobDetail[0]['Job']['category_name'] = $arrJobCategoryDetail[0]['JobCategory']['name'];
					
					$this->loadModel('JobType');
					$arrJobTypeDetail = $this->JobType->find('all',array('conditions'=>array('id'=>$arrjob['Job']['type_id'])));
					$arrJobDetail[0]['Job']['type_name'] = $arrJobTypeDetail[0]['JobType']['name'];
					
					$arrJobDetail[0]['Job']['applied'] = "";
					$this->loadModel('JobsApplied');
					$arrJobApplied = $this->JobsApplied->find('all',array('conditions'=>array('job_portal_id'=>$intPortalId,'job_id'=>$intJobId,'candidate_id'=>$arrLoggedUserDetails['candidate_id'])));
					if(is_array($arrJobApplied) && (count($arrJobApplied)>0))
					{
						$arrJobDetail[0]['Job']['applied'] = "1";
						foreach($arrJobApplied as $arrApplicationDetail)
						{
							$arrJobDetail[0]['Job']['application_date'] = $arrApplicationDetail['JobsApplied']['job_application_datetime'];
						}
					}
					$arrJobDetail[0]['Job']['reminder'] = "";
					$this->loadModel('Event');
					
					$arrJobRemindersDetail = array();
					$arrJobRemindersDetail['subject']['subject_type'] = 'job';
					$arrJobRemindersDetail['subject']['subject_type_id'] = $intJobId;
					$arrJobRemindersDetail['organizer']['organizer_type'] = 'portal';
					$arrJobRemindersDetail['organizer']['organizer_type_id'] = $intPortalId;
					$arrJobRemindersDetail['event']['event_type'] = "Interview";
					$arrJobRemindersDetail['event']['status'] = "active";
					$arrJobRemindersDetail['event']['participant_type'] = "candidate";
					$arrJobRemindersDetail['event']['participant_id'] = $arrLoggedUserDetails['candidate_id'];
					
					$dateJobReminder = $this->Event->fnCheckJobReminders($arrJobRemindersDetail);
					$arrJobDetail[0]['Job']['interviewreminder'] = $dateJobReminder;
					
					
					$intJobConut++;
				}
			}
			
			$this->set('arrJobDetail',$arrJobDetail);
		}
	}

	public function edit($intJobId = "")
	{
		
	}
}