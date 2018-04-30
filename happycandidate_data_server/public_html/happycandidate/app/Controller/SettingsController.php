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
class SettingsController extends AppController 
{

	var $helpers = array ('Html','Form');


/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Settings';

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
	
	public function notifications($intPortalId = "")
	{
		if($this->request->is('Post'))
		{
			/*print("<pre>");
			print_r($this->request->data);exit;*/
			
			if($intPortalId)
			{
				
				$arrLoggedUser = $this->Auth->user();
				$arrResponse = array();
			/*	print_R($this->request->data);
				exit();*/
				
				$this->request->data['CandidatesSettings']['is_job_notification'] = (($this->request->data['job_notifications'])?"1":"0");
				$this->request->data['CandidatesSettings']['is_material_notification'] = (($this->request->data['material_notifications'])?"1":"0");
				$this->request->data['CandidatesSettings']['is_career_advisor'] =(($this->request->data['career_advisor'])?"1":"0");
				$this->request->data['CandidatesSettings']['is_cancel_account'] = (($this->request->data['cancel_account'])?"1":"0");
				
				$this->request->data['CandidatesSettings']['candidate_id'] = $arrLoggedUser['candidate_id'];
				$this->request->data['CandidatesSettings']['created_by'] = $arrLoggedUser['candidate_id'];
				
				/*print("<pre>");
				print_r($this->request->data);
				exit;*/
				
				$this->loadModel('CandidatesSettings');
				$intCandidatesSettingsCount = $this->CandidatesSettings->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'])));
				if($intCandidatesSettingsCount)
				{
					// update
					$boolUpdated = $this->CandidatesSettings->updateAll(
						array('CandidatesSettings.created_by' => "'".$arrLoggedUser['candidate_id']."'",'CandidatesSettings.is_job_notification' => "'".$this->request->data['CandidatesSettings']['is_job_notification']."'",'CandidatesSettings.is_material_notification' => "'".$this->request->data['CandidatesSettings']['is_material_notification']."'",'CandidatesSettings.is_career_advisor' => "'".$this->request->data['CandidatesSettings']['is_career_advisor']."'",'CandidatesSettings.is_cancel_account' => "'".$this->request->data['CandidatesSettings']['is_cancel_account']."'"),
						array('CandidatesSettings.candidate_id =' => $arrLoggedUser['candidate_id'])
					);
					
					if($boolUpdated)
					{
						if($this->request->data['CandidatesSettings']['is_cancel_account'])
						{
							$this->loadModel('PortalUser');
							$this->PortalUser->updateAll(array('PortalUser.candidate_is_active' => '0'),array('PortalUser.candidate_id' => $arrLoggedUser['candidate_id']));
							$strN = "N";
							$this->loadModel('PortalJUser');
							$this->PortalJUser->updateAll(array('is_active' => "'".$strN."'"),array('hc_uid' => $arrLoggedUser['candidate_id']));
							
						}
						
						$this->Session->setFlash('Setting Updated Successfully!','default',array('class' => 'success'));
						$arrResponse['status'] = "success";
						$arrResponse['message'] = "Setting Updated Successfully";
					}
					else
					{
						$this->Session->setFlash('Please try again');
						$arrResponse['status'] = "fail";
						$arrResponse['message'] = "Please Try again";
					}
					
				}
				else
				{
					// insert
					$this->CandidatesSettings->set($this->request->data);
					$isSaved = $this->CandidatesSettings->save($this->request->data);
					if($isSaved)
					{
						
						$this->Session->setFlash('Setting Recorded Successfully!','default',array('class' => 'success'));
						$arrResponse['status'] = "success";
						$arrResponse['message'] = "Setting Added Successfully";
					}
					else
					{
						$this->Session->setFlash('Please try again');
						$arrResponse['status'] = "fail";
						$arrResponse['message'] = "Please Try again";
					}
				}
				echo json_encode($arrResponse);
				exit;
				
			}
			
		}
		
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
			
			$this->loadModel('TopMenu');
			$arrMenuDetail = $this->TopMenu->find('all',array("order"=>array('career_portal_menu_order'=>'ASC'),'conditions'=>array('career_portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id'])));
			/* print("<pre>");
			print_r($arrMenuDetail); */
			$this->set('arrPortalMenuDetail',$arrMenuDetail);
			$this->loadModel('CandidatesSettings');
			$intCandidatesSettingsCount = $this->CandidatesSettings->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'])));
			$arrCandidatesSettings = array();
			if($intCandidatesSettingsCount)
			{
				$arrCandidatesSettings = $this->CandidatesSettings->find('all',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'])));
				//print('<pre>');
				//print_r($arrCandidatesSettings);
			}
			
			$this->set('arrCandidatesSettings',$arrCandidatesSettings);
			$this->set('intCandidatesSettingsCount',$intCandidatesSettingsCount);
			
		}
		
	}
	
	public function setnotifications($intPortalId = "")
	{
		$this->autoRender = false;
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));			
			if($this->request->is('Post'))
			{
				print("<pre>");
				print_r($this->request->data);
				exit;
			}
		}
		
	}
	
	public function getSettinghtml($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = FALSE;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('Portal');
			$view = new View($this, false);
			
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$view->set('arrPortalDetail',$arrPortalDetail);
			$view->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$view->set('intPortalId',$intPortalId);
		
			
			$this->loadModel('CandidatesSettings');
			$intCandidatesSettingsCount = $this->CandidatesSettings->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'])));
			$arrCandidatesSettings = array();
			if($intCandidatesSettingsCount)
			{
				$arrCandidatesSettings = $this->CandidatesSettings->find('all',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'])));
				//print('<pre>');
				//print_r($arrCandidatesSettings);
			}
			
			$view->set('arrCandidatesSettings',$arrCandidatesSettings);
						$strJobberlandProfileLoginUrl = Configure::read('Jobber.seekerprofileloginurl')."?portid=".$intPortalId;
			
			$view->set('strSeekerProfileUrl',$strJobberlandProfileLoginUrl);
			$view->set('intCandidatesSettingsCount',$intCandidatesSettingsCount);
			
								
		
				
				//$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
				//$view->set('arrContactDetail',$arrContactDetail);
				$strWidgetListerHtml = $view->element('settinghtml');
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
	public function fnChangeMyPassword($intPortalId = "")
	{
		$arrLoggedUser = $this->Auth->user();
		$candidate_id = $arrLoggedUser['candidate_id'];
		$old_pass = $_POST['txt_old_pass'];
		$new_pass = $_POST['txt_new_pass'];
		
		$new_pass_retry = $_POST['txt_new_pass_retry'];
		if($new_pass!=$new_pass_retry)
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = '<div class="alert alert-success">
						  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
						  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
						 New pass and confirm pass not same.
						</div>';
		}
		else
		{
			$passsalt = Configure::read('Security.salt');
			$old_password = md5($passsalt.$old_pass);
			$new_password = md5($passsalt.$new_pass);
			$this->loadModel('Candidate');
			$intCandidatesSettingsCount = $this->Candidate->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],'candidate_password'=>$old_password)));
			
			if($intCandidatesSettingsCount>0)
			{
				$boolUserprocess =  $this->Candidate->updateAll(array('candidate_password' => "'$new_password'",'candidate_password_decrypted'=> "'$new_pass'"),array('candidate_id' => $arrLoggedUser['candidate_id']));	
				if($boolUserprocess)
				{
						$arrResponse['status'] = 'fail';
				$arrResponse['message'] = '<div class="alert alert-success">
						  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
						  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
						 Password changed successfully;
						</div>';
				}
				else
				{
						$arrResponse['status'] = 'fail';
				$arrResponse['message'] = '<div class="alert alert-success">
						  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
						  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
						 Password change failed;
						</div>';
				}
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = '<div class="alert alert-success">
						  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
						  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
						 Old password wrong;
						</div>';
			}
		}
			echo json_encode($arrResponse);
		exit;
		
		
	}
	
}