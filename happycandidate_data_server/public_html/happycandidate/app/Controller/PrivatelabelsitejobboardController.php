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
class PrivatelabelsitejobboardController extends AppController 
{
	public $components = array('Paginator');
	
	var $helpers = array ('Html','Form');


/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Privatelabelsitejobboard';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public function beforeFilter()
	{
		parent::beforeFilter();
	}
	
	public function index($intPortalId = "")
	{
		/* print("<pre>");
		print_r($_SESSION); */
		//Configure::write('debug','2');
		$strCurrentUser = $arrLoggedUserDetails = $this->Auth->user();		
		$this->set('strCurrentUser',$strCurrentUser);
                $this->set('arrLoggedUser', $strCurrentUser);
		$this->loadModel('Portal');
		$intPortalExists = $this->Portal->find('count', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
		
		$this->loadModel('Jobberlandjob');
		$arrPortalJobs = $this->Jobberlandjob->find('all',array('conditions'=>array('fk_hc_portal_id'=>$intPortalId),'order'=>array('id'=>'DESC')));
		//print("<pre>");
		//print_r($arrPortalJobs);
		//exit;
		
		
		
		$this->Paginator->settings = array(
			'conditions' => array('fk_hc_portal_id'=>$intPortalId),
			'order' => array('id' => 'DESC'),
			'limit' => 20
		);
		
		$arrPortalJobs = $this->Paginator->paginate('Jobberlandjob');
		
		
		
		if(is_array($this->Session->read('operationmssg')) && (count($this->Session->read('operationmssg'))>0))
		{
			$arrMessage = $this->Session->read('operationmssg');
			$this->Session->delete('operationmssg');
		}
		if($intPortalExists)
		{
			$this->set('strPostJobIndexUrl',Configure::read('Jobber.employerjobindexurl'));
			$this->set('portal_id',$intPortalId);
			$this->set('arrPortalJobs',$arrPortalJobs);
		}
		else
		{
			$this->Session->setFlash('This Portal does not exists, Please try with other Portal');
		}
		$this->set('arrMessage',$arrMessage);
	}		
	
	public function addjob()	
	{		
		//Configure::write('debug','2');
		$this->layout = "newemployerslat";		
		$strCurrentUser = $arrLoggedUserDetails = $this->Auth->user();		
		$this->set('strCurrentUser',$strCurrentUser);
		//print("<pre>");
		//print_r($strCurrentUser);
		$this->loadModel('Jobberlandjob');
		$this->loadModel('jobberlandJobType');
		$this->loadModel('JobtoCategory');
		$arrMessage = array();
		if($this->request->is('Post'))
		{
			
			$arrJobberLandJob['Jobberlandjob']['job_status'] = "approved";
			$arrJobberLandJob['Jobberlandjob']['job_title'] = addslashes($this->request->data['job-title']);
			$arrJobberLandJob['Jobberlandjob']['job_description'] = addslashes($this->request->data['job_desc']);
			$arrJobberLandJob['Jobberlandjob']['job_requirenment'] = addslashes($this->request->data['min_req']);
			$arrJobberLandJob['Jobberlandjob']['job_postion'] = addslashes($this->request->data['job_pos']);
			$arrJobberLandJob['Jobberlandjob']['post_code'] = addslashes($this->request->data['job_pin']);
			$arrJobberLandJob['Jobberlandjob']['state_province'] = addslashes($this->request->data['job_state']);
			$arrJobberLandJob['Jobberlandjob']['country'] = addslashes($this->request->data['country']);
			$arrJobberLandJob['Jobberlandjob']['job_salary'] = addslashes($this->request->data['job_salary']);
			$arrJobberLandJob['Jobberlandjob']['salaryfreq'] = addslashes($this->request->data['sal_unit']);
			$arrJobberLandJob['Jobberlandjob']['start_date'] = addslashes($this->request->data['job_start_date']);
			$arrJobberLandJob['Jobberlandjob']['contact_telephone'] = addslashes($this->request->data['contact_phone']);
			$arrJobberLandJob['Jobberlandjob']['contact_name'] = addslashes($this->request->data['contact_name']);
			$arrJobberLandJob['Jobberlandjob']['poster_email'] = addslashes($this->request->data['contact_email']);
			$arrJobberLandJob['Jobberlandjob']['job_ref'] = addslashes($this->request->data['job_referrence_code']);
			$arrJobberLandJob['Jobberlandjob']['fk_employer_id'] = $strCurrentUser['id'];
			$arrJobberLandJob['Jobberlandjob']['fk_hc_employer_id'] = $strCurrentUser['id'];
			$arrJobberLandJob['Jobberlandjob']['fk_hc_portal_id'] = $strCurrentUser['portal_id'];
			$arrJobberLandJob['Jobberlandjob']['var_name'] = str_replace(" ","-",strtolower($this->request->data['job-title']));
			$arrJobberLandJob['Jobberlandjob']['created_at'] = date('Y-m-d');
			
			$arrJobberLandJob['jobberlandJobType']['fk_job_type_id'] = addslashes($this->request->data['job_type']);			
						
			
			
			if(is_array($this->request->data['education']) && (count($this->request->data['education'])>0))
			{
				$arrJobberLandJob['Jobberlandjob']['fk_education_id'] = implode(",",$this->request->data['education']);
			}
			if(is_array($this->request->data['exp']) && (count($this->request->data['exp'])>0))
			{
				$arrJobberLandJob['Jobberlandjob']['fk_career_id'] = implode(",",$this->request->data['exp']);
			}
			if(is_array($this->request->data['exp_yr']) && (count($this->request->data['exp_yr'])>0))
			{
				$arrJobberLandJob['Jobberlandjob']['fk_experience_id'] = implode(",",$this->request->data['exp_yr']);
			}
			
			$isJobExisit = $this->Jobberlandjob->find('count',array('conditions'=>array('job_title'=>$arrJobberLandJob['Jobberlandjob']['job_title'],'start_date'=>$arrJobberLandJob['Jobberlandjob']['start_date'])));
			if($isJobExisit)
			{
				// message already exists
				$arrMessage['mssg'] = $strMessage = "The Job you are trying to create is already present, Please try again";
				$arrMessage['status'] = "fail";
			}
			else
			{
				$arrJobSave = $this->Jobberlandjob->save($arrJobberLandJob);
				if(is_array($arrJobSave) && (count($arrJobSave)>0))
				{
					$arrJobberLandJob['jobberlandJobType']['fk_job_id'] = addslashes($arrJobSave['Jobberlandjob']['id']);
					$this->jobberlandJobType->deleteAll(array('fk_job_id' => $arrJobSave['Jobberlandjob']['id']),false);
					$arrJobTypeSave = $this->jobberlandJobType->save($arrJobberLandJob);
					$arrJobberLandJob['JobtoCategory']['category_id'] = '16';
					$arrJobberLandJob['JobtoCategory']['job_id'] = addslashes($arrJobSave['Jobberlandjob']['id']);
					$this->JobtoCategory->deleteAll(array('job_id' => $arrJobSave['Jobberlandjob']['id']),false);
					$arrJobTypeSave = $this->JobtoCategory->save($arrJobberLandJob);
					$arrMessage['mssg'] = $strMessage = "You have successfully posted the job";
					$arrMessage['status'] = "success";
					$this->Session->write('operationmssg',$arrMessage);
					$this->redirect(array('controller'=>'privatelabelsitejobboard','action'=>'index',$strCurrentUser['portal_id']));
				}
				else
				{
					// message job not created
					$arrMessage['mssg'] = $strMessage = "There was some proble, Please try posting again";
					$arrMessage['status'] = "success";
				}
			}
			
			
			/*print("<pre>");
			print_r($this->request->data);
			
			print("<pre>");
			print_r($arrJobberLandJob);
			
			exit;*/
		}
		$this->loadModel('JCountry');
		$arrJCountries = $this->JCountry->find('list',array('fields'=>array('JCountry.code', 'JCountry.name')));
		asort($arrJCountries);
		$this->set('arrJcountry',$arrJCountries);
		$this->set('arrMessage',$arrMessage);
	}
	
	public function deletejob($intJId = "")
	{
		$this->layout = NULL;
		$this->autoRender = FALSE;
		$arrResponse = array();
		if($intJId)
		{
			$this->loadModel('Jobberlandjob');
			$intDeleted = $this->Jobberlandjob->deleteAll(array('id' =>$intJId),false);
			if($intDeleted)
			{
				$arrResponse['status'] = "success";
				$arrResponse['message'] = "Job Deleted Successfully!";
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Some technical error, Please try again";
			}
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Parameter is missing, Please try again";
			
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function editjob($intPortalId = "",$intJobId = "")
	{
		$this->layout = "newemployerslat";		
		$strCurrentUser = $arrLoggedUserDetails = $this->Auth->user();		
		$this->set('strCurrentUser',$strCurrentUser);
		$arrMessage = array();
		$this->loadModel('Jobberlandjob');
		$this->loadModel('jobberlandJobType');
		$this->loadModel('JobtoCategory');
		if($this->request->is('Post'))
		{
			$intJobId = addslashes($this->request->data['jobid']);
			$arrJobberLandJob['Jobberlandjob']['job_title'] = addslashes($this->request->data['job-title']);
			$arrJobberLandJob['Jobberlandjob']['job_description'] = addslashes($this->request->data['job_desc']);
			$arrJobberLandJob['Jobberlandjob']['job_requirenment'] = addslashes($this->request->data['min_req']);
			$arrJobberLandJob['Jobberlandjob']['job_postion'] = addslashes($this->request->data['job_pos']);
			$arrJobberLandJob['Jobberlandjob']['post_code'] = addslashes($this->request->data['job_pin']);
			$arrJobberLandJob['Jobberlandjob']['state_province'] = addslashes($this->request->data['job_state']);
			$arrJobberLandJob['Jobberlandjob']['country'] = addslashes($this->request->data['country']);
			$arrJobberLandJob['Jobberlandjob']['job_salary'] = addslashes($this->request->data['job_salary']);
			$arrJobberLandJob['Jobberlandjob']['salaryfreq'] = addslashes($this->request->data['sal_unit']);
			$arrJobberLandJob['Jobberlandjob']['start_date'] = addslashes($this->request->data['job_start_date']);
			$arrJobberLandJob['Jobberlandjob']['contact_telephone'] = addslashes($this->request->data['contact_phone']);
			$arrJobberLandJob['Jobberlandjob']['contact_name'] = addslashes($this->request->data['contact_name']);
			$arrJobberLandJob['Jobberlandjob']['poster_email'] = addslashes($this->request->data['contact_email']);
			$arrJobberLandJob['Jobberlandjob']['job_ref'] = addslashes($this->request->data['job_referrence_code']);
			$arrJobberLandJob['Jobberlandjob']['fk_employer_id'] = $strCurrentUser['id'];
			$arrJobberLandJob['Jobberlandjob']['fk_hc_employer_id'] = $strCurrentUser['id'];
			$arrJobberLandJob['Jobberlandjob']['fk_hc_portal_id'] = $strCurrentUser['portal_id'];
			$arrJobberLandJob['Jobberlandjob']['var_name'] = str_replace(" ","-",strtolower($this->request->data['job-title']));
			
			$arrJobberLandJob['jobberlandJobType']['fk_job_type_id'] = addslashes($this->request->data['job_type']);$arrJobberLandJob['jobberlandJobType']['fk_job_id'] = addslashes($intJobId);			
			
			
			if(is_array($this->request->data['education']) && (count($this->request->data['education'])>0))
			{
				$arrJobberLandJob['Jobberlandjob']['fk_education_id'] = implode(",",$this->request->data['education']);
			}
			if(is_array($this->request->data['exp']) && (count($this->request->data['exp'])>0))
			{
				$arrJobberLandJob['Jobberlandjob']['fk_career_id'] = implode(",",$this->request->data['exp']);
			}
			if(is_array($this->request->data['exp_yr']) && (count($this->request->data['exp_yr'])>0))
			{
				$arrJobberLandJob['Jobberlandjob']['fk_experience_id'] = implode(",",$this->request->data['exp_yr']);
			}
			
			//print("<pre>");
			//print_r($arrJobberLandJob);
			//exit;
			
			if($intJobId)
			{
				$intUpdated = $this->Jobberlandjob->updateAll(array('job_title'=>"'".$arrJobberLandJob['Jobberlandjob']['job_title']."'",'job_description'=>"'".$arrJobberLandJob['Jobberlandjob']['job_description']."'",'job_requirenment'=>"'".$arrJobberLandJob['Jobberlandjob']['job_requirenment']."'",'job_postion'=>"'".$arrJobberLandJob['Jobberlandjob']['job_postion']."'",'post_code'=>"'".$arrJobberLandJob['Jobberlandjob']['post_code']."'",'state_province'=>"'".$arrJobberLandJob['Jobberlandjob']['state_province']."'",'country'=>"'".$arrJobberLandJob['Jobberlandjob']['country']."'",'job_salary'=>"'".$arrJobberLandJob['Jobberlandjob']['job_salary']."'",'salaryfreq'=>"'".$arrJobberLandJob['Jobberlandjob']['salaryfreq']."'",'start_date'=>"'".$arrJobberLandJob['Jobberlandjob']['start_date']."'",'contact_telephone'=>"'".$arrJobberLandJob['Jobberlandjob']['contact_telephone']."'",'contact_name'=>"'".$arrJobberLandJob['Jobberlandjob']['contact_name']."'",'poster_email'=>"'".$arrJobberLandJob['Jobberlandjob']['poster_email']."'",'job_ref'=>"'".$arrJobberLandJob['Jobberlandjob']['job_ref']."'",'fk_hc_portal_id'=>"'".$arrJobberLandJob['Jobberlandjob']['fk_hc_portal_id']."'",'var_name'=>"'".$arrJobberLandJob['Jobberlandjob']['var_name']."'",'fk_employer_id'=>"'".$arrJobberLandJob['Jobberlandjob']['fk_employer_id']."'",'fk_hc_employer_id'=>"'".$arrJobberLandJob['Jobberlandjob']['fk_hc_employer_id']."'",'fk_education_id'=>"'".$arrJobberLandJob['Jobberlandjob']['fk_education_id']."'",'fk_career_id'=>"'".$arrJobberLandJob['Jobberlandjob']['fk_career_id']."'",'fk_experience_id'=>"'".$arrJobberLandJob['Jobberlandjob']['fk_experience_id']."'",'modified'=>"'".date("Y-m-d h:i:s")."'"),array("id"=>$intJobId));

				if($intUpdated)
				{
					$this->jobberlandJobType->deleteAll(array('fk_job_id' => $intJobId),false);
					$arrJobTypeSave = $this->jobberlandJobType->save($arrJobberLandJob);
					
					$arrJobberLandJob['JobtoCategory']['category_id'] = '16';
					$arrJobberLandJob['JobtoCategory']['job_id'] = $intJobId;
					$this->JobtoCategory->deleteAll(array('job_id' => $intJobId),false);
					$arrJobTypeSave = $this->JobtoCategory->save($arrJobberLandJob);
					$arrMessage['mssg'] = $strMessage = "You have successfully updated the job";
					$arrMessage['status'] = "success";
					$this->Session->write('operationmssg',$arrMessage);
					$this->redirect(array('controller'=>'privatelabelsitejobboard','action'=>'index',$strCurrentUser['portal_id']));
				}
				else
				{
					// message job not created
					$arrMessage['mssg'] = $strMessage = "There was some proble, Please try posting again";
					$arrMessage['status'] = "success";
				}
			}
			/*print("<pre>");
			print_r($this->request->data);
			
			print("<pre>");
			print_r($arrJobberLandJob);
			
			exit;*/
		}
		
		
		
		$arrJobDetail = $this->Jobberlandjob->find('all',array('conditions'=>array('id'=>$intJobId)));
		if(is_array($arrJobDetail) && (count($arrJobDetail)>0))
		{
			$arrJobType = $this->jobberlandJobType->find('all',array('conditions'=>array('fk_job_id'=>$intJobId)));
			$arrJobDetail[0]['Jobberlandjob']['jtype'] = $arrJobType[0]['jobberlandJobType']['fk_job_type_id'];
		}
		
		//print("<pre>");
		//print_r($arrJobDetail);
		//exit;
		
		$this->loadModel('JCountry');
		$arrJCountries = $this->JCountry->find('list',array('fields'=>array('JCountry.code', 'JCountry.name')));
		asort($arrJCountries);
		$this->set('arrJcountry',$arrJCountries);
		$this->set('arrMessage',$arrMessage);
		$this->set('arrJobDetail',$arrJobDetail);
	}
	
	public function add($intPortalId)
	{
		$arrLoggedUserDetails = $this->Auth->user();
		$this->loadModel('Portal');
		$intPortalExists = $this->Portal->find('count', array(
									'conditions' => array('career_portal_provider_id' => $arrLoggedUserDetails['id'],'career_portal_id'=> $intPortalId)
								));
		
		if($intPortalExists)
		{
			$this->set('strPostJobJoberbaseUrl',Configure::read('Jobber.employeraddjoburl'));
			$this->set('portal_id',$intPortalId);
		}
		else
		{
			$this->Session->setFlash('This Portal does not exists, Please try with other Portal');
		}
	}
}