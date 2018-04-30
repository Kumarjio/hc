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
class PrivatelabelsitesregistrationController extends AppController 
{

	var $helpers = array ('Html','Form');


/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Privatelabelsitesregistration';

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
	
	public function index($intPortalId)
	{
		/* print("<pre>");
		print_r($_SESSION); */
		
		
		$arrLoggedUserDetails = $this->Auth->user();
		$this->loadModel('Portal');
		$intPortalExists = $this->Portal->find('count', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
								
		if($intPortalExists)
		{
			$this->loadModel('PortalRegistration');
			$arrPortalRegistration = $this->PortalRegistration->find('all',array("conditions"=>array('career_portal_id'=>$intPortalId),
														  "order"=>array('career_registration_form_created_datetime'=>'DESC')));
			$this->set('arrPortalRegistration',$arrPortalRegistration);
			$this->set('portal_id',$intPortalId);
		}
		else
		{
			$this->Session->setFlash('This Portal does not exists, Please try with other Portal');
		}		
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
			$this->loadModel('PortalRegistration');
			if($this->request->is('post'))
			{
				/* print("<pre>");
				print_r($this->request->data);
				exit; */
				
				$this->request->data['PortalRegistration']['career_registration_form_name'] = addslashes(trim($this->request->data['PortalRegistration']['registration_form_name']));
				$this->request->data['PortalRegistration']['career_portal_id'] = addslashes(trim($this->request->data['PortalRegistration']['portal_id']));
				$arrSocialMedia = $this->request->data['social_media'];
				if(is_array($arrSocialMedia) && (count($arrSocialMedia)>0))
				{
					$this->request->data['PortalRegistration']['career_registration_form_is_social_media'] = "1";
				}
				
				$intPostedPortalId = addslashes(trim($this->request->data['PortalRegistration']['portal_id']));
				$this->request->data['PortalRegistration']['career_registration_form_created_by'] =  $arrLoggedUserDetails['id'];
				//$intSystemFields = $this->request->data['PortalRegistration']['system_fields'];
				$intSystemFields = "1";
				

				$arrSystemFields = $this->request->data['fields'];
				$intPortalRegistrationFormExists = $this->PortalRegistration->find('count', array(
							'conditions' => array('career_portal_id' => $intPostedPortalId,'career_registration_form_name'=> $this->request->data['PortalRegistration']['career_registration_form_name'])
						));
				if($intPortalRegistrationFormExists)
				{
					$this->Session->setFlash('The Registration Form with this name is already created');
				}
				else
				{
					$this->PortalRegistration->set($this->request->data);
					if($this->PortalRegistration->validates())
					{
						$boolPortalRegistrationFormCreated = $this->PortalRegistration->save($this->request->data);
						$intLastInsertedId = $this->PortalRegistration->getLastInsertId();
										
						if($intSystemFields == 1)
						{
							if(is_array($arrSystemFields) && (count($arrSystemFields)>0))
							{
								$this->loadModel('RegistrationFormFields');
								$intPortalRegistrationFormFieldsDeleted = $this->RegistrationFormFields->deleteAll(array('RegistrationFormFields.career_portal_registration_form_id' => $intLastInsertedId),false);
								
								foreach($arrSystemFields as $intFieldCategory => $arrFields)
								{
									foreach($arrFields as $arrField)
									{
										$arrRegistrationFormFields = array();
										$arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_field_category'] = $intFieldCategory;
										$arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_field_id'] = $arrField;
										$arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_id'] = $intLastInsertedId;
										$arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_fields_created_by'] = $arrLoggedUserDetails['id'];
										$boolPortalRegistrationFormFieldCreated = $this->RegistrationFormFields->fnSaveRegistrationFields($arrRegistrationFormFields);
									}
									/* print("<pre>");
									print_r($arrRegistrationFormFields); */
								}
							}
						}
						
						if(is_array($arrSocialMedia) && (count($arrSocialMedia)>0))
						{
							$this->loadModel('RegistrationSocialMedialField');
							$intPortalRegistrationFormSocialFieldDeleted = $this->RegistrationSocialMedialField->deleteAll(array('RegistrationSocialMedialField.career_portal_registration_form_id' => $intLastInsertedId),false);
							foreach($arrSocialMedia as $arrSocialMediaId)
							{
								$arrRegistrationSocialData = array();
								$arrRegistrationSocialData['RegistrationSocialMedialField']['career_portal_registration_form_id'] = $intLastInsertedId;
								$arrRegistrationSocialData['RegistrationSocialMedialField']['career_portal_registration_social_plugin_id'] = $arrSocialMediaId;
								$arrRegistrationSocialData['RegistrationSocialMedialField']['career_portal_registration_form_social_plugin_createdby'] = $arrLoggedUserDetails['id'];
								
								$boolSocialPluginCreated = $this->RegistrationSocialMedialField->fnSaveRegistrationFormSocialPlugin($arrRegistrationSocialData);
							}
						}
						
						if($boolPortalRegistrationFormCreated)
						{
							$this->Session->setFlash('Registration Form created successfully','default',array('class' => 'success'));
							$this->redirect(array('action'=>'index',$intPostedPortalId));
						}
					}
					else
					{
						$strRegistrationFormCreationErrorMessage = "";
						$arrRegiustrationCreationErrors = $this->PortalRegistration->invalidFields();
						if(is_array($arrRegiustrationCreationErrors) && (count($arrRegiustrationCreationErrors)>0))
						{
							$intForIterateCount = 0;
							foreach($arrRegiustrationCreationErrors as $errorVal)
							{
								$intForIterateCount++;
								if($intForIterateCount == 1)
								{
									$strRegistrationFormCreationErrorMessage .= "Error: ".$errorVal['0'];
								}
								else
								{
									$strRegistrationFormCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
								}
							}
						}
						$this->Session->setFlash($strRegistrationFormCreationErrorMessage);
					}
					
				}
			}	
			
			$this->loadModel('FieldCategory');
			$arrFieldCategory = $this->FieldCategory->find('all',array('conditions'=>array('field_category_field_allocated'=>'1')));
			if(is_array($arrFieldCategory) && (count($arrFieldCategory)>0))
			{
				$this->loadModel('SystemFields');
				$intForCategoryCount = 0;
				foreach($arrFieldCategory as $arrCategory)
				{
					//echo "---".$arrCategory['FieldCategory']['field_category_name'];
					$arrCategoryFields = $this->SystemFields->fnLoadFieldsOfCategory($arrCategory['FieldCategory']['field_category_id']);
					/* print("<pre>");
					print_r($arrCategoryFields); */
					
					$arrFieldCategory[$intForCategoryCount]['fields'] = $arrCategoryFields;
					$intForCategoryCount++;
				}
			}
			
			$this->loadModel('SocialMedialPlugin');
			$arrSocialMediaPlugin = $this->SocialMedialPlugin->find('all',array('conditions'=>array('social_media_plugin_type'=>'register','social_media_plugin_isactive'=>'1')));
			
			if(is_array($arrSocialMediaPlugin) && (count($arrSocialMediaPlugin)>0))
			{
				$this->set('arrSocialMediaPlugin',$arrSocialMediaPlugin);
			}
			
			
			//$arrSystemField = $this->SystemFields->find('list',array('fields'=>array('SystemFields.field_id', 'SystemFields.field_label'),'conditions'=>array('field_created_by'=>null)));
			$this->set('arrSystemFields',$arrFieldCategory);
			$this->set('portal_id',$intPortalId);
		}
		else
		{
			$this->Session->setFlash('This Portal does not exists, Please try with other Portal');
		}
	}
	
	public function delete($intRegistrationId = "")
	{
		$strId = base64_decode($intRegistrationId);
		$arrRegistrationDetail = explode("_",$strId);
		if(is_array($arrRegistrationDetail))
		{			
			$this->loadModel('PortalRegistration');
			$intPortalRegistrationExists = $this->PortalRegistration->find('count', array(
									'conditions' => array('career_portal_id' => $arrRegistrationDetail['1'],'	career_registration_form_id' => $arrRegistrationDetail['0'])
								));
			
			if($intPortalRegistrationExists)
			{
				$intPortalRegistrationDeleted = $this->PortalRegistration->deleteAll(array('PortalRegistration.career_registration_form_id' => $arrRegistrationDetail['0']),false);
				if($intPortalRegistrationDeleted)
				{
					$this->loadModel('RegistrationFormFields');
					$intPortalRegistrationFieldsDeleted = $this->RegistrationFormFields->deleteAll(array('RegistrationFormFields.career_portal_registration_form_id' => $arrRegistrationDetail['0']),false);
					$this->Session->setFlash('Registration Form deleted successfully','default',array('class' => 'success'));
					$this->redirect(array('action'=>'index',$arrRegistrationDetail['1']));
				}
			}
			else
			{
				$this->redirect(array('action'=>'index',$arrRegistrationDetail['1']));
			}
		}
		else
		{
			$this->redirect(array('action'=>'index',$arrPageDetail['1']));
		}
	}
	
	public function edit($intRegistrationId = "")
	{
		$strId = base64_decode($intRegistrationId);
		$arrRegistrationFormDetail = explode("_",$strId);
		$arrLoggedUserDetails = $this->Auth->user();
		
		if(is_array($arrRegistrationFormDetail))
		{
			
			$this->loadModel('PortalRegistration');
			
			if($this->request->is('post'))
			{
				/* print("<pre>");
				print_r($this->request->data); */
				
				
				$this->request->data['PortalRegistration']['career_registration_form_name'] = addslashes(trim($this->request->data['PortalRegistration']['registration_form_name']));
				$arrPostedPortalRegistrationId = explode("_",base64_decode($this->request->data['PortalRegistration']['form_id']));
				//echo "--".$this->request->data['social_media'];
				$arrSocialMedia = array();
				if(isset($this->request->data['social_media']))
				{
					$arrSocialMedia = $this->request->data['social_media'];
				}
				
				if(is_array($arrSocialMedia) && (count($arrSocialMedia)>0))
				{
					$this->request->data['PortalRegistration']['career_registration_form_is_social_media'] = "1";
				}
				else
				{
					$this->request->data['PortalRegistration']['career_registration_form_is_social_media'] = "0";
				}
				
				$intPostedPortalId = addslashes(trim($this->request->data['PortalRegistration']['portal_id']));
				//$intSystemFields = $this->request->data['PortalRegistration']['system_fields'];
				$intSystemFields = "1";
				$arrSystemFields = $this->request->data['fields'];
				
				$this->PortalRegistration->set($this->request->data);
				if($this->PortalRegistration->validates())
				{					
					$boolUpdated = $this->PortalRegistration->updateAll(
								array('PortalRegistration.career_registration_form_name' => "'".$this->request->data['PortalRegistration']['career_registration_form_name']."'","PortalRegistration.career_registration_form_is_social_media"=>"'".$this->request->data['PortalRegistration']['career_registration_form_is_social_media']."'"),
								array('PortalRegistration.career_registration_form_id =' => $arrPostedPortalRegistrationId['0'])
							);
					
					if($intSystemFields == 1)
					{
						if(is_array($arrSystemFields) && (count($arrSystemFields)>0))
						{
							$this->loadModel('RegistrationFormFields');
							$intPortalRegistrationFormFieldsDeleted = $this->RegistrationFormFields->deleteAll(array('RegistrationFormFields.career_portal_registration_form_id' => $arrPostedPortalRegistrationId['0']),false);
							
							foreach($arrSystemFields as $intFieldCategory => $arrFields)
							{
								foreach($arrFields as $arrField)
								{
									$arrRegistrationFormFields = array();
									$arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_field_category'] = $intFieldCategory;
									$arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_field_id'] = $arrField;
									$arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_id'] = $arrPostedPortalRegistrationId['0'];
									$arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_fields_created_by'] = $arrLoggedUserDetails['id'];
									$boolPortalRegistrationFormFieldCreated = $this->RegistrationFormFields->fnSaveRegistrationFields($arrRegistrationFormFields);
								}
								
								/* print("<pre>");
								print_r($arrRegistrationFormFields); */
								//$boolPortalRegistrationFormFieldCreated = $this->RegistrationFormFields->fnSaveRegistrationFields($arrRegistrationFormFields);								
							}
							
						}
					}
					if(is_array($arrSocialMedia) && (count($arrSocialMedia)>0))
					{
						$this->loadModel('RegistrationSocialMedialField');
						$intPortalRegistrationFormSocialFieldDeleted = $this->RegistrationSocialMedialField->deleteAll(array('RegistrationSocialMedialField.career_portal_registration_form_id' => $arrPostedPortalRegistrationId['0']),false);
						foreach($arrSocialMedia as $arrSocialMediaId)
						{
							$arrRegistrationSocialData = array();
							$arrRegistrationSocialData['RegistrationSocialMedialField']['career_portal_registration_form_id'] = $arrPostedPortalRegistrationId['0'];
							$arrRegistrationSocialData['RegistrationSocialMedialField']['career_portal_registration_social_plugin_id'] = $arrSocialMediaId;
							$arrRegistrationSocialData['RegistrationSocialMedialField']['career_portal_registration_form_social_plugin_createdby'] = $arrLoggedUserDetails['id'];
							
							$boolSocialPluginCreated = $this->RegistrationSocialMedialField->fnSaveRegistrationFormSocialPlugin($arrRegistrationSocialData);
						}
					}
					else
					{
						$this->loadModel('RegistrationSocialMedialField');
						$intPortalRegistrationFormSocialFieldDeleted = $this->RegistrationSocialMedialField->deleteAll(array('RegistrationSocialMedialField.career_portal_registration_form_id' => $arrPostedPortalRegistrationId['0']),false);
					}
					if($boolUpdated)
					{
						$this->Session->setFlash('Registration Form Updated successfully','default',array('class' => 'success'));
						$this->redirect(array('action'=>'index',$arrPostedPortalRegistrationId['1']));
					}
				}
				else
				{
					$strRegistrationUpdationErrorMessage = "";
					$arrRegistrationUpdationErrors = $this->PortalRegistration->invalidFields();
					if(is_array($arrRegistrationUpdationErrors) && (count($arrRegistrationUpdationErrors)>0))
					{
						$intForIterateCount = 0;
						foreach($arrRegistrationUpdationErrors as $errorVal)
						{
							$intForIterateCount++;
							if($intForIterateCount == 1)
							{
								$strRegistrationUpdationErrorMessage .= "Error: ".$errorVal['0'];
							}
							else
							{
								$strRegistrationUpdationErrorMessage .= "<br> Error: ".$errorVal['0'];
							}
						}
					}
					$this->Session->setFlash($strRegistrationUpdationErrorMessage);
				}
				
			}
			
			$intRegistrationFormExists = $this->PortalRegistration->find('count', array(
									'conditions' => array('career_portal_id' => $arrRegistrationFormDetail['1'],'career_registration_form_id' => $arrRegistrationFormDetail['0'])
								));
			if($intRegistrationFormExists)
			{
				$arrPortalRegistrationDetail = $this->PortalRegistration->find('all',array('conditions'=>array('career_registration_form_id'=>$arrRegistrationFormDetail['0'])));
				$this->set('arrPortalsRegistration',$arrPortalRegistrationDetail);
				
				$this->loadModel('FieldCategory');
				$arrFieldCategory = $this->FieldCategory->find('all',array('conditions'=>array('field_category_field_allocated'=>'1')));
				if(is_array($arrFieldCategory) && (count($arrFieldCategory)>0))
				{
					$this->loadModel('SystemFields');
					$intForCategoryCount = 0;
					foreach($arrFieldCategory as $arrCategory)
					{
						//echo "---".$arrCategory['FieldCategory']['field_category_name'];
						$arrCategoryFields = $this->SystemFields->fnLoadFieldsOfCategory($arrCategory['FieldCategory']['field_category_id']);
						/* print("<pre>");
						print_r($arrCategoryFields); */
						
						$arrFieldCategory[$intForCategoryCount]['fields'] = $arrCategoryFields;
						$intForCategoryCount++;
					}
				}
				
				if($arrPortalRegistrationDetail[0]['PortalRegistration']['career_registration_form_is_social_media'])
				{
					$this->loadModel('SocialMedialPlugin');
					$arrSocialMediaPlugin = $this->SocialMedialPlugin->find('all',array('conditions'=>array('social_media_plugin_type'=>'register','social_media_plugin_isactive'=>'1')));
					$intSocialAllocatedForIterateCount = 0;
					foreach($arrSocialMediaPlugin as $arrPlugin)
					{
						$this->loadModel('RegistrationSocialMedialField');
						$boolIsFieldAllocated = $this->RegistrationSocialMedialField->find('count',array('conditions'=>array('career_portal_registration_form_id'=>$arrRegistrationFormDetail['0'],'career_portal_registration_social_plugin_id'=>$arrPlugin['SocialMedialPlugin']['social_media_plugin_id'])));
						if($boolIsFieldAllocated)
						{
							$arrSocialMediaPlugin[$intSocialAllocatedForIterateCount]['SocialMedialPlugin']['field_allocated'] = "1";
						}
						else
						{
							$arrSocialMediaPlugin[$intSocialAllocatedForIterateCount]['SocialMedialPlugin']['field_allocated'] = "0";
						}
						$intSocialAllocatedForIterateCount++;
					}
					if(is_array($arrSocialMediaPlugin) && (count($arrSocialMediaPlugin)>0))
					{
						$this->set('arrSocialMediaPlugin',$arrSocialMediaPlugin);
					}
					/* $arrSetRegistrationSocialFields = $this->RegistrationSocialMedialField->find('list',array('fields'=>array('RegistrationSocialMedialField.career_portal_registration_form_social_plugin_id','RegistrationSocialMedialField.career_portal_registration_social_plugin_id'),'conditions'=>array('career_portal_registration_form_id'=>$arrRegistrationFormDetail['0'])));
					$this->set('arrRegistrationSocialPluginData',$arrSetRegistrationSocialFields); */
				}
				
				/* $this->loadModel('SystemFields');
				$arrSystemField = $this->SystemFields->find('list',array('fields'=>array('SystemFields.field_id', 'SystemFields.field_label'),'conditions'=>array('field_created_by'=>null))); */
				$this->set('arrSystemFields',$arrFieldCategory);
				$this->loadModel('RegistrationFormFields');
				$arrFormFields = $this->RegistrationFormFields->find('list',array('fields'=>array('RegistrationFormFields.career_portal_registration_form_fields_id', 'RegistrationFormFields.career_portal_registration_form_field_id'),'conditions'=>array('career_portal_registration_form_id'=>$arrRegistrationFormDetail['0'])));
				$this->set('arrSelectedSystemFields',$arrFormFields);
				$this->set('form_id',base64_encode(implode("_",$arrRegistrationFormDetail)));
				$this->set('portal_id',$arrRegistrationFormDetail['1']);
			}
			
		}
		else
		{
			$this->redirect(array('action'=>'index',$arrPageDetail['1']));
		}
	}
	
	public function previewform($intPageId)
	{
		$strId = base64_decode($intPageId);
		$arrRegistrationFormDetail = explode("_",$strId);
		$arrLoggedUserDetails = $this->Auth->user();
		if(is_array($arrRegistrationFormDetail))
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $arrRegistrationFormDetail['1'])
								));
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				$arrCompleteRegistrationFieldDetail = array(); 
				$this->set('arrPortalDetail',$arrPortalDetail);
				$this->loadModel('RegistrationFormFields');
				$arrRegistrationFieldDetail = $this->RegistrationFormFields->fnGetAllFields($arrRegistrationFormDetail['0']);
				if(is_array($arrRegistrationFieldDetail) && (count($arrRegistrationFieldDetail)>0))
				{
					$intForEachCount = 0;
					foreach($arrRegistrationFieldDetail as $arrRegistrationField)
					{
						
						$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table'] = $arrRegistrationField['fields_table'];
						$arrFieldValidationDetail = $this->RegistrationFormFields->fnGetAllFieldValidation($arrRegistrationField['fields_table']['field_id']);
						$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_validation'] = $arrFieldValidationDetail;
						$intForEachCount++;
					}
				}
				
				$this->set('arrRegistrationFieldDetail',$arrCompleteRegistrationFieldDetail);
			}
			
		}
	}
	
	public function activate($intRegistrationId)
	{
		$strId = base64_decode($intRegistrationId);
		$arrRegistrationFormDetail = explode("_",$strId);
		$arrLoggedUserDetails = $this->Auth->user();
		
		if(is_array($arrRegistrationFormDetail))
		{
			$boolUpdated = $this->fnActivateRegistration($arrRegistrationFormDetail['1'],$arrRegistrationFormDetail['0']);
			if($boolUpdated)
			{
				$this->Session->setFlash('Registration Form activated Successfully','default',array('class' => 'success'));
				$this->redirect(array('action'=>'index',$arrRegistrationFormDetail['1']));
			}
			
		}
	}
	
	public function fnActivateRegistration($intPortalId = "", $intRegistrationId = "")
	{
		$this->loadModel('PortalRegistration');
		$boolUpdated = $this->PortalRegistration->updateAll(
							array('PortalRegistration.career_registration_form_is_active' => "'1'"),
							array('PortalRegistration.career_registration_form_id =' => $intRegistrationId)
						);			
		if($boolUpdated)
		{
			$boolUpdated = $this->PortalRegistration->updateAll(
						array('PortalRegistration.career_registration_form_is_active' => "'0'"),
						array('PortalRegistration.career_registration_form_id !=' => $intRegistrationId,'PortalRegistration.career_portal_id =' => $intPortalId)
					);
			
			if($boolUpdated)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function viewfields($intRegistrationId)
	{
		$strId = base64_decode($intRegistrationId);
		$arrRegistrationFormDetail = explode("_",$strId);
		$arrLoggedUserDetails = $this->Auth->user();
		if(is_array($arrRegistrationFormDetail))
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $arrRegistrationFormDetail['1'])
								));
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				$arrCompleteRegistrationFieldDetail = array(); 
				$this->set('arrPortalDetail',$arrPortalDetail);
				$this->loadModel('RegistrationFormFields');
				$arrRegistrationFieldDetail = $this->RegistrationFormFields->fnGetAllFields($arrRegistrationFormDetail['0']);
				if(is_array($arrRegistrationFieldDetail) && (count($arrRegistrationFieldDetail)>0))
				{
					$intForEachCount = 0;
					foreach($arrRegistrationFieldDetail as $arrRegistrationField)
					{
						
						$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table'] = $arrRegistrationField['fields_table'];
						$arrFieldValidationDetail = $this->RegistrationFormFields->fnGetAllFieldValidation($arrRegistrationField['fields_table']['field_id']);
						$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_validation'] = $arrFieldValidationDetail;
						$intForEachCount++;
					}
				}
				
				$this->set('arrRegistrationFieldDetail',$arrCompleteRegistrationFieldDetail);
				$this->set('portal_id',$arrRegistrationFormDetail['1']);
			}
		}
		
	}
}