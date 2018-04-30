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
class ProfileperformanceController extends AppController 
{

	var $helpers = array ('Html','Form');


/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Profileperformance';

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

			$compJobber = $this->Components->load('JobberBridge');
			$arrSeekerProfilePerformance = $compJobber->fnGetSeekerProfilePerformance($intPortalId);
			/*print("<pre>");
			print_r($arrSeekerProfilePerformance);*/
			
			$arrSeekerProfilePerformance = (array) $arrSeekerProfilePerformance;
			/* print("<pre>");
			print_r($arrProfilePerformance); */
			
			$arrProfilePerformance['Matched Jobs']['count'] = $arrSeekerProfilePerformance['matchedjobs'];
			//$arrProfilePerformance['Matched Jobs']['url'] = Router::url(array('controller' => 'profileperformance', 'action' => 'matchedjobs', $intPortalId),true);
			$arrProfilePerformance['Applied Jobs']['count'] = $arrSeekerProfilePerformance['appliedjobs'];
			//$arrProfilePerformance['Applied Jobs']['url'] = Router::url(array('controller' => 'profileperformance', 'action' => 'appliedjobs', $intPortalId),true);
			//$arrProfilePerformance['Jobs You can Apply']['count'] = ($intMatchedJobsForCandidates - $intAppliedJobsForCandidates);
			//$arrProfilePerformance['Jobs You can Apply']['url'] = Router::url(array('controller' => 'profileperformance', 'action' => 'jobstoapply', $intPortalId),true);
			$arrProfilePerformance['Scheduled Interviews']['count'] = $arrSeekerProfilePerformance['scheduledinterviews'];
			//$arrProfilePerformance['Scheduled Interviews']['url'] = Router::url(array('controller' => 'profileperformance', 'action' => 'scheduledjobsinterview', $intPortalId),true);
			
			
			$this->set('arrProfilePerfomance',$arrProfilePerformance);
			
			
			/*$this->loadModel('Job');
			$intMatchedJobsForCandidates = $this->Job->find('count',array('conditions'=>array('is_active'=>'1','portal_id'=>$intPortalId)));
			
			
			$this->loadModel('JobsApplied');
			$intAppliedJobsForCandidates = $this->JobsApplied->fnActiveAppliedJobsCount($arrLoggedUserDetails['candidate_id'],$intPortalId);			
			
			$this->loadModel('Event');
			$arrScheduledInterviewCriteria = array();
			$arrScheduledInterviewCriteria['candidateid'] = $arrLoggedUserDetails['candidate_id'];
			$arrScheduledInterviewCriteria['portalid'] = $intPortalId;
			$arrScheduledInterviewCriteria['status'] = "active";
			
			$intScheduledInterviewedJob = $this->Event->fnGetScheduledInterviewedCount($arrScheduledInterviewCriteria);
			
			$arrProfilePerformance = array();
			$arrProfilePerformance['Matched Jobs']['count'] = $intMatchedJobsForCandidates;
			$arrProfilePerformance['Matched Jobs']['url'] = Router::url(array('controller' => 'profileperformance', 'action' => 'matchedjobs', $intPortalId),true);
			$arrProfilePerformance['Applied Jobs']['count'] = $intAppliedJobsForCandidates;
			$arrProfilePerformance['Applied Jobs']['url'] = Router::url(array('controller' => 'profileperformance', 'action' => 'appliedjobs', $intPortalId),true);
			$arrProfilePerformance['Jobs You can Apply']['count'] = ($intMatchedJobsForCandidates - $intAppliedJobsForCandidates);
			$arrProfilePerformance['Jobs You can Apply']['url'] = Router::url(array('controller' => 'profileperformance', 'action' => 'jobstoapply', $intPortalId),true);
			$arrProfilePerformance['Scheduled Interviews']['count'] = $intScheduledInterviewedJob;
			$arrProfilePerformance['Scheduled Interviews']['url'] = Router::url(array('controller' => 'profileperformance', 'action' => 'scheduledjobsinterview', $intPortalId),true);*/
			
			
			
			//$this->set('arrProfilePerfomance',$arrProfilePerformance);
			
			
			/* print("<pre>");
			print_r($arrMatchedJobsForCandidates); */
			
			
		}
		
	}
	
	public function matchedjobs($intPortalId = "")
	{
		if($intPortalId)
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			$this->loadModel('Job');
			$arrMatchedJobsForCandidates = $this->Job->find('all',array('conditions'=>array('is_active'=>'1','portal_id'=>$intPortalId)));
			$this->set('arrMatchedJobs',$arrMatchedJobsForCandidates);
			/* print("<pre>");
			print_r($arrMatchedJobsForCandidates); */
			
			
		}
	}
	
	
	public function appliedjobs($intPortalId = "")
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
			
			$this->loadModel('JobsApplied');
			
			$arrAppliedJobsForCandidates = $this->JobsApplied->fnActiveAppliedJobs($arrLoggedUserDetails['candidate_id'],$intPortalId);
			/* print("<pre>");
			print_r($arrAppliedJobsForCandidates); */
			
			$this->set('arrAppliedJobs',$arrAppliedJobsForCandidates);
			
			/* print("<pre>");
			print_r($arrMatchedJobsForCandidates); */
		}
	}
	
	public function jobstoapply($intPortalId = "")
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
			
			$this->loadModel('JobsApplied');
			
			$arrPendingJobsCanbeAppliedForCandidates = $this->JobsApplied->fnActivePendingJobsToApply($arrLoggedUserDetails['candidate_id'],$intPortalId);
			
			/* print("<pre>");
			print_r($arrPendingJobsCanbeAppliedForCandidates); */
			
			$this->set('arrPendingJobs',$arrPendingJobsCanbeAppliedForCandidates);
			
			/* print("<pre>");
			print_r($arrMatchedJobsForCandidates); */
		}
	}
	
	public function scheduledjobsinterview($intPortalId = "")
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
			
			$this->loadModel('Event');
			$arrScheduledInterviewCriteria = array();
			$arrScheduledInterviewCriteria['candidateid'] = $arrLoggedUserDetails['candidate_id'];
			$arrScheduledInterviewCriteria['portalid'] = $intPortalId;
			$arrScheduledInterviewCriteria['status'] = "active";
			
			$arrScheduledInterviewJobs = $this->Event->fnGetScheduledInterviewedJobs($arrScheduledInterviewCriteria);
			
			/* print("<pre>");
			print_r($arrScheduledInterviewJobs);
			exit; */
			
			$this->set('arrScheduledInterviewJobs',$arrScheduledInterviewJobs);
			
			/* print("<pre>");
			print_r($arrMatchedJobsForCandidates); */
		}
	}
}