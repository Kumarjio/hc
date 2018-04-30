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
class TlettersController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Tletters';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		//$this->Auth->allow('registration','reset','jobsearch','forgotpassword','jobdetail');
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
			
			$strPageText = "Employers like to hire individuals who are confident in their ability to do the job and are also sincerely interested in working for them!  If it comes down to a difficult decision of who to hire, they will go with the person who they feel really wants to work for them and has differentiated themselves from other individuals competing for the same opportunity.  Sending appropriate thank you follow up messages at the proper times throughout your search process will help differentiate you from your competition.When you should follow up and sample send thank you notes are included in Step 14 Follow Up in the Interview Phase of your Job Search under Process and Thank YouNotes.";
			
			$this->set('strPageText',$strPageText);
			
			$this->loadModel('CandidateThankyouletter');
			$arrCandidateTletterDetail = $this->CandidateThankyouletter->find('all', array(
									'conditions' => array('candidate_id'=> $arrLoggedUser['candidate_id'])
								));
								
			/*print("<pre>");
			print_r($arrCandidateReferenceDetail);exit;*/
			$this->set('arrCandidateTletterDetail',$arrCandidateTletterDetail);
		}
	}
	
	public function removetlet($intPortalId = "")
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
				
				//$this->request->data['can_ref_id'] = '2';
				
				if($this->request->data['can_ref_id'])
				{
					
					// code to delete
					$this->loadModel('CandidateThankyouletter');
					$intCandidateThankyouLetterDeleted = $this->CandidateThankyouletter->deleteAll(array('CandidateThankyouletter.candidate_thankyou_letter_id' => $this->request->data['can_ref_id']),false);
					if($intCandidateThankyouLetterDeleted)
					{
						$intPortalTletterExists = $this->CandidateThankyouletter->find('count', array(
									'conditions' => array('candidate_id' => $arrLogedUser['candidate_id'])
						));
						
						$arrResponse['delstatus'] = "success";
						$arrResponse['message'] = "Thankyou Letter Removed successfully!!";
						$arrResponse['updateid'] = $this->request->data['can_ref_id'];
						$arrResponse['remainingref'] = $intPortalTletterExists;
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
				
				/*print("<pre>");
				print_r($this->request->data);
				exit;*/
				
				
				$this->loadModel('CandidateThankyouletter');	
				$this->request->data['CandidateThankyouletter']['candidate_id'] = $arrLogedUser['candidate_id'];
				$this->request->data['CandidateThankyouletter']['candidate_letter_name'] = addslashes(trim($this->request->data['thankyou_letter_name']));
				$this->request->data['CandidateThankyouletter']['candidate_letter_date'] = addslashes(trim($this->request->data['date']));
				$this->request->data['CandidateThankyouletter']['candidate_letter_name_of_contact'] = addslashes(trim($this->request->data['contact_name']));
				$this->request->data['CandidateThankyouletter']['candidate_title'] = addslashes(trim($this->request->data['title']));
				$this->request->data['CandidateThankyouletter']['candidate_letter_company_name'] = addslashes(trim($this->request->data['company_name']));
				$this->request->data['CandidateThankyouletter']['candidate_letter_address'] = addslashes(trim($this->request->data['address']));
				$this->request->data['CandidateThankyouletter']['candidate_letter_salutation'] = addslashes(trim($this->request->data['salutation']));
				$this->request->data['CandidateThankyouletter']['candidate_letter_content'] = htmlspecialchars($this->request->data['letter_message']);
				$this->request->data['CandidateThankyouletter']['reference_creator_id'] = $arrLogedUser['candidate_id'];
				//$this->request->data['edit_thankyou_id'] = "1";
				if($this->request->data['edit_thankyou_id'])
				{
					// code to edit
					$boolUpdated = $this->CandidateThankyouletter->updateAll(
								array('CandidateThankyouletter.candidate_letter_name' => "'".$this->request->data['CandidateThankyouletter']['candidate_letter_name']."'",'CandidateThankyouletter.candidate_title'=>"'".$this->request->data['CandidateThankyouletter']['candidate_title']."'",'CandidateThankyouletter.candidate_letter_date'=>"'".$this->request->data['CandidateThankyouletter']['candidate_letter_date']."'",'CandidateThankyouletter.candidate_letter_name_of_contact'=>"'".$this->request->data['CandidateThankyouletter']['candidate_letter_name_of_contact']."'",'CandidateThankyouletter.candidate_letter_company_name'=>"'".$this->request->data['CandidateThankyouletter']['candidate_letter_company_name']."'",'CandidateThankyouletter.candidate_letter_address'=>"'".$this->request->data['CandidateThankyouletter']['candidate_letter_address']."'",'CandidateThankyouletter.candidate_letter_salutation'=>"'".$this->request->data['CandidateThankyouletter']['candidate_letter_salutation']."'",'CandidateThankyouletter.candidate_letter_content'=>"'".$this->request->data['CandidateThankyouletter']['candidate_letter_content']."'"),
								array('CandidateThankyouletter.candidate_thankyou_letter_id' => $this->request->data['edit_thankyou_id'])
							);
					if($boolUpdated)
					{
						$arrResponse['status'] = "success";
						$arrResponse['message'] = "Thankyou Letter Updated successfully!!";
						$arrResponse['updateid'] = $this->request->data['edit_thankyou_id'];
						
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
					$intPortalThankyouLetterExists = $this->CandidateThankyouletter->find('count', array(
									'conditions' => array('candidate_id' => $arrLogedUser['candidate_id'],'candidate_letter_name'=> $this->request->data['CandidateThankyouletter']['thankyou_letter_name'])
								));
					if($intPortalThankyouLetterExists)
					{
						$arrResponse['status'] = "fail";
						$arrResponse['message'] = "Thankyou Letter already Present!!";
						
						echo json_encode($arrResponse);
						exit;
					}
					else
					{
						$this->CandidateThankyouletter->set($this->request->data);
						$boolThankyouLetterCreated = $this->CandidateThankyouletter->save($this->request->data);
						$boolThankyouLetterCreatedId = $this->CandidateThankyouletter->getLastInsertID();
						if($boolThankyouLetterCreated)
						{
							$arrResponse['status'] = "success";
							$arrResponse['message'] = "Thankyou Letter created successfully!!";
							$arrResponse['createdid'] = $boolThankyouLetterCreatedId;
							
							echo json_encode($arrResponse);
							exit;
						}
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
