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
class EmployersController extends AppController 
{

	var $helpers = array ('Html','Form');


/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Employers';

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
		$this->Auth->allow('index','captcha','contactus','subscriptionactivation');
	}
	
	public function logout() 
	{
		$this->redirect($this->Auth->logout());
	}
	
	function captcha()	{
		$this->autoRender = false;
		$this->layout='ajax';
		if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
			$this->Captcha = $this->Components->load('Captcha', array(
				'width' => 150,
				'height' => 50,
				'theme' => 'default', //possible values : default, random ; No value means 'default'
			)); //load it
			}
		$this->Captcha->create();
	}
	
	public function index()
	{
		$this->layout = "admin";
	}
	
	public function subscriptionactivation($strEmail = "")
	{
		$this->layout = "employers";
		
		if($strEmail)
		{
			$this->loadModel('User');
			$arrUserDetail = $this->User->find('all',array('conditions'=>array('email'=>$strEmail,'user_type'=>'2')));
			if($arrUserDetail[0]['User']['user_confirmed'])
			{
				if($arrUserDetail[0]['User']['owner_chosen_subscription_plan'])
				{
					
					if($arrUserDetail[0]['User']['owner_chosen_subscription_plan'] == "month")
					{
						$arrSubscriptioDetail = Configure::read('Portal.monthsubscription');
					}
					else
					{
						$arrSubscriptioDetail = Configure::read('Portal.yearsubscription');
					}
					$this->set("arrSubscriptioDetail",$arrSubscriptioDetail);
				}
				$this->set("arrUserDetail",$arrUserDetail);
			}
			else
			{
				$strMessage = "Your account is not confirmed yet, Please click the confirmation link sent to your email at time of registration";
				$this->set("strMessage",$strMessage);
				
				//$this->Session->setFlash('Your account is not confirmed yet, Please click the confirmation link sent to your email at time of registration.');
			}
			/*if(is_array($arrUserDetail)  && (count($arrUserDetail)>0))
			{
				
			}
			else
			{
				$this->set("strMessage","There is no such owner present, please click <a href='javascript:void(0);'>here</a> to initate the registration process first.");
			}*/
		}
	}
	
	public function dashboard()
	{
		//echo 'hi der'; exit();
		//$this->layout = "newemployerslatest";
		$this->layout = "newemployers";
		$arrLoggedUser = $this->Auth->user();
		$this->set('current_user',$arrLoggedUser);
		$this->loadModel('Employer');
		$arrEmployerDetail = $this->Employer->find('all',array('conditions'=>array('employer_id'=>$arrLoggedUser['id'])));
		//echo '<pre>';print_r($arrEmployerDetail); exit();
		if($arrEmployerDetail[0]['Employer']['is_wizard'] == "0")
		{
			//echo 'in wiz';//exit();
			//$this->redirect(array('controller'=>'employers','action'=>'wizard_setup'));
			$this->loadModel('Wizemployer');
			$arrEmployerWizardDetail = $this->Wizemployer->find('first',array('conditions'=>array('employer_id'=>$arrLoggedUser['id']),'order'=>'wiz_id DESC'));
			//echo '<pre>';print_r($arrEmployerWizardDetail); exit();
			if(count($arrEmployerWizardDetail) == 0)
			{	 
                               
				$this->redirect(array('controller'=>'employers','action'=>'wizard_setup'));
			}
			else
			{

				if($arrEmployerWizardDetail['Wizemployer']['step_id'] == '1')
				{	

					$this->redirect(array('controller'=>'employers','action'=>'wizard_setup_theme'));
				}
				else if($arrEmployerWizardDetail['Wizemployer']['step_id'] == '2')
				{	

					$this->redirect(array('controller'=>'employers','action'=>'wizard_setup_content'));
				}
						
			}	
		}	
		else
		{
			//echo 'in dash';//exit();
			$this->set('arrEmployerDetail',$arrEmployerDetail);
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
										'conditions' => array('career_portal_id'=> $arrLoggedUser['portal_id'])
									));
			$strPeriod = "365";
			$compTime = $this->Components->load('TimeCalculation');
			$arrDayDate = $compTime->fnGetBeforeDate($strPeriod,date('Y-m-d H:i:s'));
			$strStartDate = $arrDayDate['start'];
			$strEndDate = $arrDayDate['end'];
			//$strStartDate = date("Y-m-d")." 00:00:00";
			//$strEndDate = date("Y-m-d")." 23:59:59";
			
			
			$arrCheckSeriesDataValues = array();
			$arrCheckSeriesDataValues2 = array();
			$intEventTotal = 0;
			$intSalesTotal = 0;
			$intUsersTotal = 0;

			$compMixPanel = $this->Components->load('MixPanel');
			
			$arrEvents = array(
				$arrPortalDetail[0]['Portal']['career_portal_name']." Sale"
			);
			$objSaleTrendsData = $compMixPanel->fnGetTrends($arrEvents,$strStartDate,$strEndDate);
			//print("<pre>");
			//print_r($objSaleTrendsData);
			if(is_array((array) $objSaleTrendsData->data->values) && (count((array) $objSaleTrendsData->data->values)<=0))
			{
				
				
				$arrEvents = array(
					$arrPortalDetail[0]['Portal']['career_portal_name']." Sale",
				);
				$arrDfaultValueData = array();
				foreach($arrEvents as $strEvents)
				{
					$arrDefaultSeriesData = array();
					foreach($objSaleTrendsData->data->series as $arrSeries)
					{
						$arrDefaultSeriesData[$arrSeries] = "0";
						$intEventTotal = $intEventTotal + $arrDefaultSeriesData[$arrSeries];
						//$strSeriesData .= "'".date("jS M y",strtotime($arrSeries))."',";
					}
					$arrDfaultValueData[$strEvents] = $arrDefaultSeriesData;
				}
				/*print("<pre>");
				print_r($arrDfaultValueData);*/
				$arrCheckSeriesDataValues += $arrDfaultValueData;
			}
			else
			{
				//echo "hi";
				$arrCheckSeriesDataValues += (array) $objSaleTrendsData->data->values;
			}
			
			$strSeriesData = "[]";
			$strSeriesDataValue = "[]";
			if(isset($objSaleTrendsData->data->series) && isset($objSaleTrendsData->data->values))
			{
				$strSeriesData = "[";
				foreach($objSaleTrendsData->data->series as $arrSeries)
				{
					$strSeriesData .= "'".date("jS M y",strtotime($arrSeries))."',";
				}
				
				$strSeriesData .= "]";
				
				$strSeriesDataValue = "[";
				$arrSeriesData = array();
				$arrSeriesDataValues = $arrCheckSeriesDataValues;
				
				foreach($arrSeriesDataValues as $arrSeriesDataLabel => $arrSeriesDataLabelValue)
				{
					$strSeriesDataValue .= "{name:'".$arrSeriesDataLabel."',";
					$arrSeriesDataValueList = (array) $arrSeriesDataLabelValue;
					$strSeriesDataValue .= "data:[";
					foreach($objSaleTrendsData->data->series as $arrSeries)
					{
						$intDateSalesTotal = 0;
						//echo "---".$arrSeries;
						if($arrSeriesDataValueList[$arrSeries])
						{
							$objSaleTotal = $compMixPanel->fnSaleTotal($arrSeries,$arrSeries);
							$arrSaleTotal = (array) $objSaleTotal->data->values;
							if(is_array($arrSaleTotal) && (count($arrSaleTotal)>0))
							{
								
								foreach($arrSaleTotal as $arrKey => $arrVal)
								{
									$intDateSalesTotal = $intDateSalesTotal + $arrKey;
								}
							}
						}
						
						
						/*$strSeriesDataValue .= "['".date("jS M y",strtotime($arrSeries))."',".$arrSeriesDataValueList[$arrSeries]."],";*/
						
						$strSeriesDataValue .= "['".date("jS M y",strtotime($arrSeries))."',".$intDateSalesTotal."],";
						if($arrSeriesDataLabel == $arrPortalDetail[0]['Portal']['career_portal_name']." Sale")
						{
							$intSalesTotal = $intSalesTotal + $intDateSalesTotal;
						}
					}
					$strSeriesDataValue = rtrim($strSeriesDataValue,",");

					$strSeriesDataValue .= "]},";
				}
				$strSeriesDataValue = rtrim($strSeriesDataValue,",");
				$strSeriesDataValue .= "]";
			}
			$this->set('strSeriesLabelsValues',$strSeriesDataValue);
			$this->set('strSeriesLabels',rtrim($strSeriesData,","));
			$this->set('intSalesTotal',$intSalesTotal);
			$this->set('strPeriod',$strPeriod);
			
			
			$arrEvents = array(
				//$arrPortalDetail[0]['Portal']['career_portal_name']." Registered Users",
				$arrPortalDetail[0]['Portal']['career_portal_name']." Sale"
			);
			$this->set('arrEvents',$arrEvents);
			
			$arrEvents = array(
				$arrPortalDetail[0]['Portal']['career_portal_name']." Registered Users",
			);
			$objTrendsData = $compMixPanel->fnGetTrends($arrEvents,$strStartDate,$strEndDate);
			//print("<pre>");
			//print_r($objTrendsData);
			if(is_array((array) $objTrendsData->data->values) && (count((array) $objTrendsData->data->values)<=0))
			{
				
				
				$arrEvents = array(
					$arrPortalDetail[0]['Portal']['career_portal_name']." Registered Users",
				);
				$arrDfaultValueData = array();
				foreach($arrEvents as $strEvents)
				{
					$arrDefaultSeriesData = array();
					foreach($objTrendsData->data->series as $arrSeries)
					{
						$arrDefaultSeriesData[$arrSeries] = "0";
						$intEventTotal = $intEventTotal + $arrDefaultSeriesData[$arrSeries];
						//$intUsersTotal = $intUsersTotal + $arrDefaultSeriesData[$arrSeries];
						//$strSeriesData .= "'".date("jS M y",strtotime($arrSeries))."',";
					}
					$arrDfaultValueData[$strEvents] = $arrDefaultSeriesData;
					//print("<pre>");
					//print_r($arrDfaultValueData);
				}
				//print("<pre>");
				//print_r($arrDfaultValueData);
				$arrCheckSeriesDataValues2 += $arrDfaultValueData;
			}
			else
			{
				//echo "bi";
				$arrCheckSeriesDataValues2 += (array) $objTrendsData->data->values;
			}
			//exit;
			$strSeriesData2 = "[]";
			$strSeriesDataValue2 = "[]";
			if(isset($objTrendsData->data->series) && isset($objTrendsData->data->values))
			{
				$strSeriesData2 = "[";
				foreach($objTrendsData->data->series as $arrSeries)
				{
					$strSeriesData2 .= "'".date("jS M y",strtotime($arrSeries))."',";
				}
				
				$strSeriesData2 .= "]";
				
				$strSeriesDataValue2 = "[";
				$arrSeriesData = array();
				$arrSeriesDataValues = $arrCheckSeriesDataValues2;
				
				foreach($arrSeriesDataValues as $arrSeriesDataLabel => $arrSeriesDataLabelValue)
				{
					$strSeriesDataValue2 .= "{name:'".$arrSeriesDataLabel."',";
					$arrSeriesDataValueList = (array) $arrSeriesDataLabelValue;
					$strSeriesDataValue2 .= "data:[";
					foreach($objTrendsData->data->series as $arrSeries)
					{
						$strSeriesDataValue2 .= "['".date("jS M y",strtotime($arrSeries))."',".$arrSeriesDataValueList[$arrSeries]."],";
						if($arrSeriesDataLabel == $arrPortalDetail[0]['Portal']['career_portal_name']." Registered Users")
						{
							$intEventTotal = $intEventTotal + $arrSeriesDataValueList[$arrSeries];
							$intUsersTotal = $intUsersTotal + $arrSeriesDataValueList[$arrSeries];
						}
						if($arrSeriesDataLabel == $arrPortalDetail[0]['Portal']['career_portal_name']." Sale $")
						{
							//$intSalesTotal = $intSalesTotal + $arrSeriesDataValueList[$arrSeries];
						}
					}
					$strSeriesDataValue2 = rtrim($strSeriesDataValue2,",");

					$strSeriesDataValue2 .= "]},";
				}
				$strSeriesDataValue2 = rtrim($strSeriesDataValue2,",");
				$strSeriesDataValue2 .= "]";
			}
			
			$this->set('strSeriesLabelsValues2',$strSeriesDataValue2);
			$this->set('strSeriesLabels2',rtrim($strSeriesData2,","));
			$this->set('intEventTotal',$intEventTotal);
			$this->set('intUsersTotal',$intUsersTotal);
		}	
	}
	
	// register employer
	public function register() 
	{
		$this->layout = "admin";
		if(isset($_GET['subs']))
			{
				$this->Session->write('current_chosen_subscritopn',$_GET['subs']);
			}
		
			if($this->request->is('post'))
			{
				//echo '<pre>';print_r($_POST);	exit();
				$arrPostedData = array();
				$arrPostedData['username'] = addslashes(trim($this->request->data['user_name']));
				$arrPostedData['email'] = addslashes(trim($this->request->data['user_email']));
				$arrPostedData['pass'] = addslashes(trim($this->request->data['user_pass']));
				//$arrPostedData['cpass'] = addslashes(trim($this->request->data['User']['password_confirm']));
				$arrPostedData['user_type'] = addslashes(trim($this->request->data['u_type']));
				$arrPostedData['captcha'] = addslashes(trim($this->request->data['captcha']));
				if(($this->Session->check("current_chosen_subscritopn")) && ($this->Session->read('current_chosen_subscritopn') != "0"))
				{
					$arrPostedData['owner_chosen_subscription_plan'] = $this->Session->read('current_chosen_subscritopn');
					$this->Session->write('current_chosen_subscritopn',"0");
				}
				else
				{
					$arrPostedData['owner_chosen_subscription_plan'] = "year";
				}
				
				

				$this->loadModel('User');
				if(!isset($this->Captcha))	
				{ 
					//if Component was not loaded throug $components array()
					$this->Captcha = $this->Components->load('Captcha'); //load it
				}
				$this->User->setCaptcha($this->Captcha->getVerCode()); //getting from component and passing to model to make proper validation check
				$this->User->set($arrPostedData);
			
				if($this->User->validates())
				{
					$intUserCreated = $this->User->find('count', array(
									'conditions' => array('email' => $arrPostedData['email'],'user_type'=> $arrPostedData['user_type'])
								));
					//$intUserCreated = $this->User->fnCheckUserAccountExists($arrPostedData['email']);
					if($intUserCreated)
					{
						$this->Session->setFlash('User account has been already created','default',array('class' => 'fail'),'Message');
					}
					else
					{
						$arrPostedData['pass_dec'] = $arrPostedData['pass'];
						$arrPostedData['pass'] = AuthComponent::password($this->request->data['user_pass']);
						if ($this->User->save($arrPostedData)) 
						{
							$intLastUserInsertedId = $this->User->getInsertID();
							$this->loadModel('Employer');
							$arrEmployerDetailPostedData['employer_user_fname'] = $arrPostedData['username'];
							$arrEmployerDetailPostedData['employer_id'] = $intLastUserInsertedId;
							$intBoolNewEmployerInserted = $this->Employer->save($arrEmployerDetailPostedData);
							
							$boolRegistrationMail = $this->fnSendRegistrationEmail($arrPostedData['username'],$arrPostedData['email'],$intLastUserInsertedId);
							if($boolRegistrationMail)
							{
								$boolUpdated = $this->User->updateAll(
										array('User.user_confirmation_mail_sent' => "'1'"),
										array('User.id =' => $intLastUserInsertedId)
									);
							}
							$this->Session->setFlash('You have been registered successfully with us, please check you mail for further steps','default',array('class' => 'success'),'Message');
						}
						//$this->redirect(array('controller'=>'employers','action'=>'subscriptionactivation',$arrPostedData['email']));
					}
				}
				else
				{
					$errors = $this->User->invalidFields();
					$strRegerrorMessage = "";
					if(is_array($errors) && (count($errors)>0))
					{
						foreach($errors as $errorVal)
						{
							$strRegerrorMessage .= "<br> Error: ".$errorVal['0'];
						}
						
						$this->Session->setFlash($strRegerrorMessage);
					}
				}
			}
			
			
	}
		
	// wizard setup
	public function wizard_setup()
	{
		// Configure::write('debug', 2);
						
		$arrLoggedUserDetails = $this->Auth->user();	
		$arrEmployerDetail = $this->Employer->find('all',array('conditions'=>array('employer_id'=>$arrLoggedUserDetails['id'])));
		if($arrEmployerDetail[0]['Employer']['is_wizard'] == "0")
		{
			$this->layout = "wizardemployers";
		}
		else
		{
			$this->layout = "newemployers";
		}
		$this->loadModel('Wizemployer');
		$arrEmployerWizardDetail = $this->Wizemployer->find('all',array('conditions'=>array('employer_id'=>$arrLoggedUserDetails['id'])));
		$this->set("arrEmployerDetail",$arrEmployerDetail);	
		$this->set("arrEmployerWizardDetail",$arrEmployerWizardDetail);	
	}
	public function wizard_setup_theme()
	{
		//Configure::write('debug', 2);
		$this->layout = "wizardemployers";				
		$arrLoggedUserDetails = $this->Auth->user();	
		$arrEmployerDetail = $this->Employer->find('all',array('conditions'=>array('employer_id'=>$arrLoggedUserDetails['id'])));
		$this->loadModel('Wizemployer');
		$arrEmployerWizardDetail = $this->Wizemployer->find('all',array('conditions'=>array('employer_id'=>$arrLoggedUserDetails['id'])));
		$this->set("arrEmployerDetail",$arrEmployerDetail);	
		$this->loadModel('Portal');
		$intPortalDetails = $this->Portal->find('all',array('conditions'=>array('career_portal_created_by'=>$arrLoggedUserDetails['id'])));
		
		$this->set("intPortalDetails",$intPortalDetails);
	}
	public function wizard_setup_content()
	{
		// Configure::write('debug', 2);
		$this->layout = "wizardemployers";				
		$arrLoggedUserDetails = $this->Auth->user();	
		$arrEmployerDetail = $this->Employer->find('all',array('conditions'=>array('employer_id'=>$arrLoggedUserDetails['id'])));
		$this->loadModel('Wizemployer');
		$arrEmployerWizardDetail = $this->Wizemployer->find('all',array('conditions'=>array('employer_id'=>$arrLoggedUserDetails['id'])));
		$this->set("arrEmployerDetail",$arrEmployerDetail);	
	}
	public function wizard_theme_option()
	{
		//Configure::write('debug', 2);
		$this->layout = "wizardemployers";				
		$arrLoggedUserDetails = $this->Auth->user();	
		$arrEmployerDetail = $this->Employer->find('all',array('conditions'=>array('employer_id'=>$arrLoggedUserDetails['id'])));
		$this->loadModel('Wizemployer');
		$arrEmployerWizardDetail = $this->Wizemployer->find('all',array('conditions'=>array('employer_id'=>$arrLoggedUserDetails['id'])));
		//echo '<pre>';print_r($arrEmployerWizardDetail);
		$this->set("arrEmployerDetail",$arrEmployerDetail);	
		$this->loadModel('Portal');
		$intPortalDetails = $this->Portal->find('all',array('conditions'=>array('career_portal_created_by'=>$arrLoggedUserDetails['id'])));
		
		$this->set("intPortalDetails",$intPortalDetails);	
		if($this->request->is('post'))
		{
			//echo '<pre>';print_r($_POST);print_r($_FILES);exit();
				$intPortalCreated = $this->Portal->find('count',array('conditions'=>array('career_portal_created_by'=>$arrLoggedUserDetails['id'])));
				//$intPortalCreated = 0;
				if($intPortalCreated)
				{
					$this->set('intAllowedToCreatePortal','0');
					$this->Session->setFlash('You are not permitted to create Portals');
				}
				else
				{
					$this->request->data['Portal']['career_portal_name'] = addslashes(trim($this->request->data['portal_name']));
					$this->request->data['Portal']['career_portal_logo'] = $_FILES['portal_logo']['name'];
					$this->request->data['Portal']['career_portal_provider_id'] = $arrLoggedUserDetails['id'];
					$this->request->data['Portal']['career_portal_created_by'] = $arrLoggedUserDetails['id'];
					//echo '<pre>';print_r($this->request->data);exit();
					$this->Portal->set($this->request->data);
					if($this->Portal->validates())
					{
						$intPortalExists = $this->Portal->find('count', array(
											'conditions' => array('career_portal_provider_id' => $arrLoggedUserDetails['id'],'career_portal_name'=> $this->request->data['Portal']['career_portal_name'])
										));
						if($intPortalExists)
						{
							$this->Session->setFlash('Portal already exists with provided portal name');
						}
						else
						{
							$this->request->data['Portal']['career_portal_logo'] = $this->fnGeneratePortalName($_FILES['portal_logo']['name'],$this->request->data['Portal']['career_portal_name'],$arrLoggedUserDetails['id']);
							$this->request->data['Portal']['career_portal_thumb_logo'] = $this->fnGeneratePortalThumbLogo($_FILES['portal_logo']['name'],$this->request->data['Portal']['career_portal_name'],$arrLoggedUserDetails['id']);
							//echo '<pre>';print_r($this->request->data);exit();
							$boolPortalCreated = $this->Portal->save($this->request->data);
							if($boolPortalCreated)
							{
								$intCreatedPortalId = $this->Portal->getLastInsertID();
								move_uploaded_file($_FILES['portal_logo']['tmp_name'], WWW_ROOT . 'userdata/portal/' . $this->request->data['Portal']['career_portal_logo']);
								
								$input_file =  WWW_ROOT . 'userdata/portal/' . $this->request->data['Portal']['career_portal_logo'];
								$output_file = WWW_ROOT . 'userdata/portal/' . $this->fnGeneratePortalThumbLogo($_FILES['portal_logo']['name'],$this->request->data['Portal']['career_portal_name'],$arrLoggedUserDetails['id']);
								$this->resizeImage($input_file, $output_file, '100', '40');
								
								// relate portal id to the owner
								$this->loadModel('User');
								$boolUpdated = $this->User->updateAll(
									array('portal_id' => "'".$intCreatedPortalId."'"),
									array('id' => $arrLoggedUserDetails['id'])
								);
								
								// create and set default forms for portal
								$compPortalForm = $this->Components->load('PortalFormsCreator');
								$arrCreatedPortalForm = $compPortalForm->fnCreateDefaultPortalForms($intCreatedPortalId);
								//exit;
								
								// create default pages and menus for portal
								$compPortalPages = $this->Components->load('PortalPages');
								$arrPortalPages = $compPortalPages->fnCreateDefaultPortalPagesMenus($intCreatedPortalId);
								
								// create and set default theme for portal
								$compPortalTheme = $this->Components->load('PortalTheme');
								$arrAllocatedDefaultTheme = $compPortalTheme->fnSetDefaultTheme($intCreatedPortalId);
								
								
								
								// create default LMS course category and assign role in the category
								$compLmsBridge = $this->Components->load('LmsBridge');
								$arrEmployerSetup = array();
								$arrEmployerSetup['categoryname'] = $this->request->data['Portal']['career_portal_name'];
								$arrEmployerSetup['username'] = $arrLoggedUserDetails['email'];
								$arrEmployerSetup['portalid'] = $intCreatedPortalId;
								$arrLmsEmployerSetupOperation = $compLmsBridge->fnSetEmployerInMoodle($arrEmployerSetup);
								
								$this->Session->setFlash('Portal created successfully','default',array('class' => 'success'));
								$this->redirect(array('action'=>'wizard_theme_option'));
							}
						}
					}
					else
					{
						$strPortalCreationErrorMessage = "";
						$arrPortalCreationErrors = $this->Portal->invalidFields();
						if(is_array($arrPortalCreationErrors) && (count($arrPortalCreationErrors)>0))
						{
							$intForIterateCount = 0;
							foreach($arrPortalCreationErrors as $errorVal)
							{
								$intForIterateCount++;
								if($intForIterateCount == 1)
								{
									$strPortalCreationErrorMessage .= "Error: ".$errorVal['0'];
								}
								else
								{
									$strPortalCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
								}
							}
						}
						$this->Session->setFlash($strPortalCreationErrorMessage);
					}
			}
		}		
	}
	public function fnGeneratePortalName($strCurrentPortalLogoName = "",$strPortalName = "",$intProviderId = "")
	{
		$strNewPortalLogoName = $strCurrentPortalLogoName;
		$arrNewPortalLogoName = explode(".",$strNewPortalLogoName);
		$arrNewPortalLogoName[0] = $strPortalName."_".$intProviderId;
		$strNewPortalLogoName = implode(".",$arrNewPortalLogoName);
		
		return $strNewPortalLogoName;
	}
	
	public function fnGeneratePortalThumbLogo($strCurrentPortalLogoName = "",$strPortalName = "",$intProviderId = "")
	{
		$strNewPortalLogoName = $strCurrentPortalLogoName;
		$arrNewPortalLogoName = explode(".",$strNewPortalLogoName);
		$arrNewPortalLogoName[0] = $strPortalName."_".$intProviderId."_small";
		$strNewPortalLogoName = implode(".",$arrNewPortalLogoName);
		
		return $strNewPortalLogoName;
	}
	public function resizeImage($source_image, $target_image, $target_width, $target_height)
	{
		// check if we have valid target width and height
		if ($target_width <= 0 && $target_height <= 0)
		{
			trigger_error("resizeImage(): Invalid target width or height", E_USER_ERROR);
			return false;
		}
		
		// detect source image type from extension
		$source_file_name = basename($source_image);
		$source_image_type = substr($source_file_name, -3, 3);
		
		// create an image resource from the source image  
		switch(strtolower($source_image_type))
		{
			case 'jpg':
				$original_image = imagecreatefromjpeg($source_image);
				break;
				
			case 'gif':
				$original_image = imagecreatefromgif($source_image);
				break;

			case 'png':
				$original_image = imagecreatefrompng($source_image);
				break;    
			
			default:
				trigger_error("resizeImage(): Invalid image type", E_USER_ERROR);
				return false;
		}
		
		// detect source width and height
		list($source_width, $source_height) = getimagesize($source_image);
		
		// if target height or width is not specified, calculate it as per the aspect ratio 
		if ($target_height <= 0)
		{
			$target_height = ($source_height/$source_width) * $target_width;
		}
		if ($target_width <= 0)
		{
			$target_width = ($source_width/$source_height) * $target_height;
		}
		
		// create a blank image with target width and height
		// this will be our resized image
		$resized_image = imagecreatetruecolor($target_width, $target_height);
		
		// copy the source image to the blank image created above
		imagecopyresampled($resized_image, $original_image, 0, 0, 0, 0, 
						   $target_width, $target_height, $source_width, $source_height); 
		
		// detect target image type from extension
		$target_file_name = basename($target_image);
		$target_image_type = substr($target_file_name, -3, 3);
		
		// save the resized image to disk
		switch(strtolower($target_image_type))
		{
			case 'jpg':
				imagejpeg($resized_image, $target_image, 100);
				break;
				
			case 'gif':
				imagegif($resized_image, $target_image);
				break;

			case 'png':
				imagepng($resized_image, $target_image, 0);
				break;    
			
			default:
				trigger_error("resizeImage(): Invalid target image type", E_USER_ERROR);
				imagedestroy($resized_image);
				imagedestroy($original_image);
				return false;
		}
		
		// free resources
		imagedestroy($resized_image);
		imagedestroy($original_image);
		
		return true;
	}
	//THEME SELECTION
	public function theme_selection()
	{
		
		Configure::write('debug', 2);
		$themeName = $_GET['theme_name'];
		$themeColor = $_GET['theme_color'];
		$intPortalId = $_GET['portal_id'];
		$this->layout = $themeName.'-'.$themeColor;	
		//echo $themeName.'-'.$themeColor; //exit();
		//$this->autoRender = false;	
		$arrLoggedUserDetails = $this->Auth->user();	
		$arrEmployerDetail = $this->Employer->find('all',array('conditions'=>array('employer_id'=>$arrLoggedUserDetails['id'])));
		$this->set("arrEmployerDetail",$arrEmployerDetail);
		$this->loadModel('Wizemployer');
		$arrEmployerWizardDetail = $this->Wizemployer->find('all',array('conditions'=>array('employer_id'=>$arrLoggedUserDetails['id'])));
		$this->set("arrEmployerWizDetail",$arrEmployerWizDetail);
		$this->loadModel('Wiztheme');
		$arrThemeDetail = $this->Wiztheme->find('first',array('conditions'=>array('theme_name'=>$themeName,'theme_color'=>$themeColor)));
		//echo '<pre>';print_r($arrThemeDetail);exit();
		if(count($arrThemeDetail)>0)
		{	
		$this->loadModel('PortalTheme');
		$boolUpdated = $this->PortalTheme->updateAll(
											array('PortalTheme.career_portal_theme_id'=>$arrThemeDetail['Wiztheme']['theme_id']),array('PortalTheme.career_portal_id =' => $intPortalId)
										);
		}								
		$this->set("arrThemeDetail",$arrThemeDetail);
		$this->loadModel('Portal');
		$arrPortalDetail = $this->Portal->find('all',array('conditions'=>array('career_portal_created_by'=>$arrLoggedUserDetails['id'])));
		$this->set("arrPortalDetail",$arrPortalDetail);
		$this->loadModel('TopMenu');
		$arrMenuDetail = $this->TopMenu->find('all',array("order"=>array('career_portal_menu_order'=>'ASC'),'conditions'=>array('career_portal_id'=>$intPortalId),));
			/* print("<pre>");
			print_r($arrMenuDetail); */
		$this->set('arrPortalMenuDetail',$arrMenuDetail);
			
			// courses detail
		$compLmsBridge = $this->Components->load('LmsBridge');
		$arrCourseDetails = $compLmsBridge->fnGetPortalCourses($arrPortalDetail['0']['Portal']['career_portal_id']);
			/*print("<pre>");
			print_r($arrCourseDetails);*/
		$this->set('arrCoursesDetails',$arrCourseDetails);
			
		$this->loadModel('PortalPages');
		$arrPageList = $this->PortalPages->find('list',array('fields'=>array('PortalPages.career_portal_page_id', 'PortalPages.career_portal_page_tittle'),"conditions"=>array('career_portal_id'=>$intPortalId),"order"=>array('career_portal_page_createddatetime'=>'DESC')));
		$this->set('arrPortalPageDetailList',$arrPageList);
			
		$arrPortalHomePageDetail = $this->PortalPages->find('all',array('conditions' => array('career_portal_id' => $intPortalId,'is_career_portal_home_page'=> '1')));
		$this->set('arrPortalPageDetail',$arrPortalHomePageDetail);
		//$this->render('/themes/'.$arrThemeDetail[0]['Wiztheme']['theme_name'].'/'.$arrThemeDetail[0]['Wiztheme']['theme_color']);
	}
	public function viewthemepage($intPageId)
	{
		//Configure::write('debug', 2);
		//$this->layout = 'THEME-DESIGN-1-RED-View';	
		$strId = base64_decode($intPageId);
		$arrPageDetail = explode("_",$strId);
		$this->loadModel('PortalTheme');
			//$arrPortalThemeDetail = $this->PortalTheme->fnLoadPortalThemeDetail($arrPageDetail['1']);					
			$arrPortalThemeDetail = $this->PortalTheme->find('first', array(
			'fields' => array('Wiztheme.*','Portal.*'),
				'joins' => array(
				array(
					'table' => 'wizard_theme',
					'alias' => 'Wiztheme',
					'type' => 'inner',
					'recursive' => -1,
					'conditions'=> array('Wiztheme.theme_id = PortalTheme.career_portal_theme_id')
				),array(
					'table' => 'career_portal',
					'alias' => 'Portal',
					'type' => 'inner',
					'recursive' => -1,
					'conditions'=> array('Portal.career_portal_id = PortalTheme.career_portal_id')
				)
			),'conditions'=>array('Portal.career_portal_id'=>$arrPageDetail['1'])));
			//echo $arrPortalThemeDetail['Wiztheme']['theme_name'].'-'.$arrPortalThemeDetail['Wiztheme']['theme_color'].'-View';
			//echo '<pre>';print_r($arrPortalThemeDetail); exit();
		   	$this->layout = $arrPortalThemeDetail['Wiztheme']['theme_name'].'-'.$arrPortalThemeDetail['Wiztheme']['theme_color'].'-View';
			
		$arrLoggedUserDetails = $this->Auth->user();
		if(is_array($arrPageDetail))
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $arrPageDetail['1'])
								));			
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				//echo "HI";
				$this->set('arrPortalDetail',$arrPortalDetail);
				
				// load portal theme and its details
				$this->loadModel('PortalTheme');
				$arrPortalThemeDetail = $this->PortalTheme->fnLoadPortalThemeDetail($arrPageDetail['1']);
				if(is_array($arrPortalThemeDetail) && (count($arrPortalThemeDetail)>0))
				{
					$this->set('arrPortalThemeDetail',$arrPortalThemeDetail);
				}				
				
				// load portal theme page widgets
				$intPortalThemeId = $arrPortalThemeDetail[0]['career_portal_theme']['career_portal_theme_id'];
				$this->loadModel('PortalThemePageWidgets');
				//$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalId,$intPortalThemeId);
				$arrPortalThemePageWidgets = $this->PortalThemePageWidgets->fnLoadPortalThemePageWidgetDetail($arrPageDetail['0'],$arrPageDetail['1']);
				if(is_array($arrPortalThemePageWidgets) && (count($arrPortalThemePageWidgets)>0))
				{
					$this->set('arrPortalWidgets',$arrPortalThemePageWidgets);
				}
				else
				{
					// load portal theme widgets
					$intPortalThemeId = $arrPortalThemeDetail[0]['career_portal_theme']['career_portal_theme_id'];
					$this->loadModel('PortalThemeWidgets');
					//$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalId,$intPortalThemeId);
					$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalThemeId,$arrPageDetail['1']);
					if(is_array($arrPortalThemeWidgets) && (count($arrPortalThemeWidgets)>0))
					{
						$this->set('arrPortalWidgets',$arrPortalThemeWidgets);
					}
				}				
				
				$this->loadModel('TopMenu');
				$arrMenuDetail = $this->TopMenu->find('all',array('conditions'=>array('career_portal_id'=>$arrPageDetail['1']),'order'=>array('TopMenu.career_portal_menu_order'=>'ASC')));
				/* print("<pre>");
				print_r($arrMenuDetail); */
				if(is_array($arrMenuDetail) && (count($arrMenuDetail)>0))
				{
					$this->set('arrPortalMenuDetail',$arrMenuDetail);
				}
				$this->loadModel('PortalPages');
				$arrPortalPageDetail = $this->PortalPages->find('all', array(
										'conditions' => array('career_portal_id' => $arrPageDetail['1'],'career_portal_page_id' => $arrPageDetail['0'])
									));
						
				/*print("<pre>");
				print_r($arrPortalPageDetail);
				exit;*/
				$this->set('arrPortalPageDetail',$arrPortalPageDetail);
				if(strpos($arrPortalPageDetail[0]['PortalPages']['career_portal_page_tittle'],"Contact")  !== False)
				{
					$this->loadModel('PortalContactForm');
					$arrContactFormDetail = $this->PortalContactForm->find('all',array('conditions'=>array('PortalContactForm.career_portal_id'=>$arrPageDetail['1'],'PortalContactForm.career_portal_contact_us_form_is_active'=>'1')));
					//print("<pre>");
					//print_r($arrContactFormDetail);
					if(is_array($arrContactFormDetail)  && (count($arrContactFormDetail)>0))
					{
						$this->loadModel('ContactFormFields');
						//$arrContactFormFields = $this->ContactFormFields->find('all',array('conditions'=>array('career_portal_contact_us_form_id'=>$arrContactFormDetail[0]['PortalContactForm']['career_portal_contact_us_form_id'])));
						$arrContactFormFields = $this->ContactFormFields->fnGetAllFields($arrContactFormDetail[0]['PortalContactForm']['career_portal_contact_us_form_id']);
						if(is_array($arrContactFormFields) && (count($arrContactFormFields)>0))
						{
							$intContactFormFieldCount = 0;
							foreach($arrContactFormFields as $arrContactFFields)
							{
								$arrContactFormValidations = $this->ContactFormFields->fnGetAllFieldValidation($arrContactFFields['fields_table']['field_id']);
								$arrContactFormFields[$intContactFormFieldCount]['contactfieldvalidations'] = $arrContactFormValidations;
								$intContactFormFieldCount++;
							}
							$arrContactFormDetail[0]['PortalContactForm']['ContactFormFields'] = $arrContactFormFields;
						}
						$this->set('arrContactFormDetail',$arrContactFormDetail);
					}
				}				
				
				$this->loadModel('Job');
				$arrLatesJobDetail = $this->Job->fnGetLatesJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);
				
				$this->loadModel('Job');
				$arrLatesJobDetail = $this->Job->fnGetLatesJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);
				
				$this->set('arrPortalLatestJobDetail',$arrLatesJobDetail);
				/* print("<pre>");
				print_r($arrLatesJobDetail); */
				
				$this->loadModel('JCountry');
				$arrJCountries = $this->JCountry->find('list',array('fields'=>array('JCountry.code', 'JCountry.name')));
				asort($arrJCountries);
				$this->set('arrJcountry',$arrJCountries);
				
				
				$this->loadModel('JobCategory');
				$arrJCategories = $this->JobCategory->find('list',array('fields'=>array('JobCategory.id', 'JobCategory.cat_name')));
				$arrJCategories["0"] = "Choose Category";
				ksort($arrJCategories);
				$this->set('arrJcategories',$arrJCategories);
				
				
				$this->loadModel('JobExperience');
				$arrJobExperience = $this->JobExperience->find('list',array('fields'=>array('JobExperience.var_name', 'JobExperience.experience_name')));
				$arrJobInitialVal["0"] = "Choose Experience";
				//ksort($arrJobExperience);
				$arrNewMergedJobExp = array_merge($arrJobInitialVal,$arrJobExperience);
				$this->set('arrJobExperience',$arrNewMergedJobExp);
				
				// courses detail
				$compLmsBridge = $this->Components->load('LmsBridge');
				$arrCourseDetails = $compLmsBridge->fnGetPortalCourses($arrPortalDetail['0']['Portal']['career_portal_id']);
				/*print("<pre>");
				print_r($arrCourseDetails);*/
				
				$this->loadModel('Portalpagetemplates');
				$arrPortalPageTemplates = $this->Portalpagetemplates->find('all',array('fields'=>array('career_portal_page_template_id','career_portal_page_tittle')));
				
				$this->set('arrPortalPageTemplates',$arrPortalPageTemplates);
				
				$this->set('arrCoursesDetails',$arrCourseDetails);

			}
			
		}
	}
	public function enablewidget($intPortalId = "")
	{
		$intWidgetId = $_REQUEST['widgetid'];
		$intHolderId = $_REQUEST['widgetholderid'];
		$strWidgetHolder = $_REQUEST['widgetholder'];
		
		if($intPortalId && $intWidgetId && $intHolderId)
		{
			if($strWidgetHolder == "page")
			{
				$arrPageWidget = array();
				$this->loadModel('PortalThemePageWidgets');
				$arrPageWidget['PortalThemePageWidgets']['career_portal_page_id'] = $intHolderId;
				$arrPageWidget['PortalThemePageWidgets']['career_portal_id'] = $intPortalId;
				$arrPageWidget['PortalThemePageWidgets']['widget_id'] = $intWidgetId;
				$boolCreated = $this->PortalThemePageWidgets->save($arrPageWidget);
				if($boolCreated)
				{
					$arrResponse = array();
					$arrResponse['status'] = "success";
					$arrResponse['message'] = "Widget Enabled successfully";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
				else
				{
					$arrResponse = array();
					$arrResponse['status'] = "failure";
					$arrResponse['message'] = "Please Try Again";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
			}
			else
			{	
				$arrThemeWidget = array();
				$this->loadModel('PortalThemeWidgets');
				$arrThemeWidget['PortalThemeWidgets']['career_portal_theme_id'] = $intHolderId;
				$arrThemeWidget['PortalThemeWidgets']['career_portal_id'] = $intPortalId;
				$arrThemeWidget['PortalThemeWidgets']['widget_id'] = $intWidgetId;
				$boolCreated = $this->PortalThemeWidgets->save($arrThemeWidget);
				if($boolCreated)
				{
					$arrResponse = array();
					$arrResponse['status'] = "success";
					$arrResponse['message'] = "Widget Enabled successfully";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
				else
				{
					$arrResponse = array();
					$arrResponse['status'] = "failure";
					$arrResponse['message'] = "Please Try Again";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
			}			
		}
		else
		{
			$arrResponse = array();
			$arrResponse['status'] = "failure";
			$arrResponse['message'] = "Bad Request";
			//$arrResponse['newimage'] = $strBannerImageName;
			
			echo json_encode($arrResponse);
			exit;
		}
	}
	//THEME LOGO SELECTION
	public function updateportallogo($intPortalId = "")
	{
		//Configure::write('debug', 2);
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();
		
		if($intPortalId)
		{
			//echo 'update'.$intPortalId; exit();
			if($this->Auth->loggedIn())
			{
				$this->loadModel('Portal');
				$intPortlExists = $this->Portal->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
				if($intPortlExists)
				{
					$arrPortalDetail = $this->Portal->find('all',array('conditions'=>array('career_portal_id'=>$intPortalId)));
					if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
					{
						if(is_array($_FILES) && (count($_FILES)>0))
						{
							$arrImageAllowedExtension = array('jpg','JPG','JPEG','jpeg','png','PNG','bmp','BMP','gif','GIF');
							
							if($_FILES['portal_logo']['name'] != "")
							{
								$strFileExt = pathinfo($_FILES['portal_logo']['name'], PATHINFO_EXTENSION);
								if(in_array($strFileExt,$arrImageAllowedExtension))
								{
									$strPortalName = addslashes(trim($_POST['portal_name']));
									
									$strPortalLogo = $arrPortalDetail[0]['Portal']['career_portal_logo'];
									$strPortalThumbLogo = $arrPortalDetail[0]['Portal']['career_portal_thumb_logo'];
									$strPortalNewLogoName = $this->fnGeneratePortalName($_FILES['portal_logo']['name'],$strPortalName,$arrLoggedUserDetails['id']);
									$strPortalNewThumbLogoName = $this->fnGeneratePortalThumbLogo($_FILES['portal_logo']['name'],$strPortalName,$arrLoggedUserDetails['id']);
									unlink(WWW_ROOT.'/userdata/portal/'.$strPortalLogo);
									unlink(WWW_ROOT.'/userdata/portal/'.$strPortalThumbLogo);
									move_uploaded_file($_FILES['portal_logo']['tmp_name'], WWW_ROOT . 'userdata/portal/' .$strPortalNewLogoName);
									$input_file =  WWW_ROOT . 'userdata/portal/' . $strPortalNewLogoName;
									$output_file = WWW_ROOT . 'userdata/portal/' . $strPortalNewThumbLogoName;
									$this->resizeImage($input_file, $output_file, '100', '40');
									$boolUpdated = $this->Portal->updateAll(
											array('Portal.career_portal_name'=>"'".$strPortalName."'",'Portal.career_portal_thumb_logo'=>"'".$strPortalNewThumbLogoName."'",'Portal.career_portal_logo'=>"'".$strPortalNewLogoName."'"),
											array('Portal.career_portal_id =' => $intPortalId)
										);
									if($boolUpdated)
									{
										$arrResponse = array();
										$arrResponse['status'] = "success";
										$arrResponse['message'] = "Logo updated successfully";
										$arrResponse['newimage'] = $strPortalNewLogoName;
										
										echo json_encode($arrResponse);
									}
								}
								else
								{
									$arrResponse = array();
									$arrResponse['status'] = "failure";
									$arrResponse['message'] = "Logo type not supported";
									
									echo json_encode($arrResponse);
								}
							}
							else
							{
								$arrResponse = array();
								$arrResponse['status'] = "failure";
								$arrResponse['message'] = "Please Provide the Logo.";
								
								echo json_encode($arrResponse);
							}
						}
					}
				}
			}
		}
			
	}
	//THEME COPYRIGHT TEXT
	public function copyrighttext($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();
		//echo $intPortalId; exit();
		if($intPortalId)
		{
			if($this->Auth->loggedIn())
			{
				$this->loadModel('Portal');
				$intPortlExists = $this->Portal->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
				if($intPortlExists)
				{
					$this->request->data['Portal']['career_portal_footer_text'] = addslashes(trim($_POST['footer_text']));
					if($this->request->data['Portal']['career_portal_footer_text'] == "")
					{
						$arrResult = array();
						$arrResult['status'] = "failure";
						$arrResult['message'] = "Please Provide Copyright Text";
						
						echo json_encode($arrResult);
					}
					else
					{
						$boolUpdated = $this->Portal->updateAll(
								array('Portal.career_portal_footer_text' => "'".$this->request->data['Portal']['career_portal_footer_text']."'"),
								array('Portal.career_portal_id =' => $intPortalId)
							);
						if($boolUpdated)
						{
							$arrResult = array();
							$arrResult['status'] = "success";
							$arrResult['message'] = "Copyright Text Updated Successfully";
							
							echo json_encode($arrResult);
						}
					}
				}
			}
		}
	}
	public function removeportalpage($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();
		
		if($intPortalId)
		{
			if($this->Auth->loggedIn())
			{
				$this->loadModel('Portal');
				$intPortlExists = $this->Portal->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
				if($intPortlExists)
				{
					
					$this->loadModel('PortalPages');
					//$intPortlPagesExists = $this->PortalPages->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
					$strId = base64_decode($_POST['pagedetail']);
					$arrPageDetail = explode("_",$strId);
					
					if($arrPageDetail['0'])
					{
						$intPortalPageDeleted = $this->PortalPages->deleteAll(array('career_portal_page_id' => $arrPageDetail['0']),false);
						if($intPortalPageDeleted)
						{
							$arrResult = array();
							$arrResult['status'] = "success";
							$arrResult['message'] = "Page Updated successfully";
							
							echo json_encode($arrResult);
						}
					}
					else
					{
						$arrResult = array();
						$arrResult['status'] = "fail";
						$arrResult['message'] = "Parameter Missing";
						
						echo json_encode($arrResult);
					}
				}
			}
		}
		exit;
	}
	
	public function updatepagedata($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();
		
		if($intPortalId)
		{
			if($this->Auth->loggedIn())
			{
				$this->loadModel('Portal');
				$intPortlExists = $this->Portal->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
				if($intPortlExists)
				{
					
					$this->loadModel('PortalPages');
					//$intPortlPagesExists = $this->PortalPages->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
					$strId = base64_decode($_POST['pagedetail']);
					$arrPageDetail = explode("_",$strId);
					$this->request->data['PortalPages']['career_portal_page_tittle'] = addslashes(trim($_POST['page_name']));
					$this->request->data['PortalPages']['career_portal_page_content'] = htmlspecialchars($_POST['page_data']);
					$this->request->data['PortalPages']['career_portal_id'] = $intPortalId;
					$this->request->data['PortalPages']['career_portal_page_createdby'] = $arrLoggedUserDetails['id'];
					$this->request->data['PortalPages']['is_career_portal_home_page'] = addslashes(trim($_POST['homepage']));
					$this->request->data['PortalPages']['career_portal_page_template'] = $_POST['page_edit_template'];
					
					if($arrPageDetail['0'])
					{
						// update
						/*$intPortlPagesWithExists = $this->PortalPages->find('count',array('conditions'=>array('NOT'=>array('career_portal_page_id'=>$arrPageDetail['0']),'career_portal_page_tittle'=>$this->request->data['PortalPages']['career_portal_page_tittle'],'career_portal_id'=>$intPortalId)));
						if($intPortlPagesWithExists)
						{
							$arrResult = array();
							$arrResult['status'] = "failure";
							$arrResult['message'] = "Page with this title already exists";
							
							echo json_encode($arrResult);
						}
						else
						{*/
							$this->PortalPages->set($this->request->data);
							if($this->PortalPages->validates())
							{
								$boolUpdated = $this->PortalPages->updateAll(
									array('PortalPages.career_portal_page_tittle' => "'".$this->request->data['PortalPages']['career_portal_page_tittle']."'",'PortalPages.career_portal_page_content'=>"'".$this->request->data['PortalPages']['career_portal_page_content']."'",'PortalPages.career_portal_page_template'=>"'".$this->request->data['PortalPages']['career_portal_page_template']."'"),
									array('PortalPages.career_portal_page_id =' => $arrPageDetail['0'])
								);
								
								if($boolUpdated)
								{
									$arrResult = array();
									$arrResult['status'] = "success";
									$arrResult['message'] = "Page Updated successfully";
									
									echo json_encode($arrResult);
								}
							}
							else
							{
								$strPageCreationErrorMessage = "";
								$arrPageCreationErrors = $this->PortalPages->invalidFields();
								if(is_array($arrPageCreationErrors) && (count($arrPageCreationErrors)>0))
								{
									$intForIterateCount = 0;
									foreach($arrPageCreationErrors as $errorVal)
									{
										$intForIterateCount++;
										if($intForIterateCount == 1)
										{
											$strPageCreationErrorMessage .= "Error: ".$errorVal['0'];
										}
										else
										{
											$strPageCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
										}
									}
								}
								$arrResult = array();
								$arrResult['status'] = "failure";
								$arrResult['message'] = $strPageCreationErrorMessage;
								
								echo json_encode($arrResult);
							}
						//}
					}
					else
					{
						// insert
						/*$intPortlPagesWithExists = $this->PortalPages->find('count',array('conditions'=>array('career_portal_page_tittle'=>$this->request->data['PortalPages']['career_portal_page_tittle'],'career_portal_id'=>$intPortalId)));
						if($intPortlPagesWithExists)
						{
							$arrResult = array();
							$arrResult['status'] = "failure";
							$arrResult['message'] = "Page with this title already exists";
							
							echo json_encode($arrResult);
						}
						else
						{*/
							$this->PortalPages->set($this->request->data);
							if($this->PortalPages->validates())
							{
								$boolPortalPageCreated = $this->PortalPages->save($this->request->data);
								$intPageId = $this->PortalPages->getLastInsertID();
								if($boolPortalPageCreated)
								{
									$arrResult = array();
									$arrResult['status'] = "success";
									$arrResult['message'] = "Page created successfully";
									$arrResult['pagedetail'] = base64_encode($intPageId."_".$intPortalId);
									
									echo json_encode($arrResult);
								}
							}
							else
							{
								$strPageCreationErrorMessage = "";
								$arrPageCreationErrors = $this->PortalPages->invalidFields();
								if(is_array($arrPageCreationErrors) && (count($arrPageCreationErrors)>0))
								{
									$intForIterateCount = 0;
									foreach($arrPageCreationErrors as $errorVal)
									{
										$intForIterateCount++;
										if($intForIterateCount == 1)
										{
											$strPageCreationErrorMessage .= "Error: ".$errorVal['0'];
										}
										else
										{
											$strPageCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
										}
									}
								}
								$arrResult = array();
								$arrResult['status'] = "failure";
								$arrResult['message'] = $strPageCreationErrorMessage;
								
								echo json_encode($arrResult);
							}
						//}
					}
				}
			}
		}
	}
	public function updategraph($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$arrPropertyRequest = array();
		$arrLoggedUserDetails = $this->Auth->user();
		$arrCheckSeriesDataValues = array();
		$this->loadModel('Portal');
		$intPortalExists = $this->Portal->find('count', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
								
		if($intPortalExists)
		{
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$strEventName = $arrPortalDetail[0]['Portal']['career_portal_name'];
			$strEventPartName = "Registered Users";
			$strPeriod = $this->request->data['periodtoviewfrm'];
			$intSalesTotal = 0;
			$intUsersTotal = 0;
			$strEventName = $strEventName." ".$strEventPartName;
			$arrEvents = array($strEventName);
			$compTime = $this->Components->load('TimeCalculation');
			$arrDayDate = $compTime->fnGetBeforeDate($strPeriod,date('Y-m-d H:i:s'));
			//print("<pre>");
			//print_r($arrDayDate);
			//exit;
			$strStartDate = $arrDayDate['start'];
			$strEndDate = $arrDayDate['end'];
			if($strStartDate && $strEndDate)
			{
				$strDateDiff = $compTime->fnGetDurationInDays($strStartDate,$strEndDate);
				$arrResponse['monhtsdata'] = $compTime->fnGetMonthsFromDays($strDateDiff);
			}
			$compMixPanel = $this->Components->load('MixPanel');
			$objPropertiesFilteredData = $compMixPanel->fnGetTrends($arrEvents,$strStartDate,$strEndDate);
			if(is_array((array) $objPropertiesFilteredData->data->values) && (count((array) $objPropertiesFilteredData->data->values)<=0))
			{
				$arrDfaultValueData = array();
				foreach($arrEvents as $strEvents)
				{
					$arrDefaultSeriesData = array();
					foreach($objPropertiesFilteredData->data->series as $arrSeries)
					{
						$arrDefaultSeriesData[$arrSeries] = "0";
						//$strSeriesData .= "'".date("jS M y",strtotime($arrSeries))."',";
					}
					$arrDfaultValueData[$strEvents] = $arrDefaultSeriesData;
				}
				/*print("<pre>");
				print_r($arrDfaultValueData);*/
				$arrCheckSeriesDataValues += $arrDfaultValueData;
			}
			else
			{
				$arrCheckSeriesDataValues += (array) $objPropertiesFilteredData->data->values;
			}
			$arrEvents = array(
				$arrPortalDetail[0]['Portal']['career_portal_name']." Sale"
			);
			$objSaleTrendsData = $compMixPanel->fnGetTrends($arrEvents,$strStartDate,$strEndDate);
			if(is_array((array) $objSaleTrendsData->data->values) && (count((array) $objSaleTrendsData->data->values)<=0))
			{
				$arrDfaultValueData = array();
				foreach($arrEvents as $strEvents)
				{
					$arrDefaultSeriesData = array();
					foreach($objSaleTrendsData->data->series as $arrSeries)
					{
						$arrDefaultSeriesData[$arrSeries] = "0";
						//$strSeriesData .= "'".date("jS M y",strtotime($arrSeries))."',";
					}
					$arrDfaultValueData[$strEvents] = $arrDefaultSeriesData;
				}
				/*print("<pre>");
				print_r($arrDfaultValueData);*/
				$arrCheckSeriesDataValues += $arrDfaultValueData;
			}
			else
			{
				$arrCheckSeriesDataValues += (array) $objSaleTrendsData->data->values;
			}
			
			if(isset($objPropertiesFilteredData->data->series) && isset($objPropertiesFilteredData->data->values))
			{
				$strSeriesData = "";
				$strSeriesDataValue = "";
				$strTotalUsers = "";
				foreach($objPropertiesFilteredData->data->series as $arrSeries)
				{
					$strSeriesData .= date("jS M y",strtotime($arrSeries)).",";
					$strSeriesDataValue .= "0,";
				}
				$arrResponse['chartdata'] = "null";
				$arrSeriesData = array();
				$arrSeriesDataValues = $arrCheckSeriesDataValues;
				if(is_array($arrSeriesDataValues) && (count($arrSeriesDataValues)>0))
				{
					$strSeriesDataValue = "";
					foreach($arrSeriesDataValues as $arrSeriesDataLabel => $arrSeriesDataLabelValue)
					{
						$arrSeriesDataValueList = (array) $arrSeriesDataLabelValue;
						$strSeriesDataValue .= $arrSeriesDataLabel.":";
						$strTotal = 0;
						foreach($objPropertiesFilteredData->data->series as $arrSeries)
						{
							$intDateSalesTotal = 0;
							if($arrSeriesDataLabel == "Monster Sale")
							{
								
								if($arrSeriesDataValueList[$arrSeries])
								{
									$objSaleTotal = $compMixPanel->fnSaleTotal($arrSeries,$arrSeries);
									$arrSaleTotal = (array) $objSaleTotal->data->values;
									if(is_array($arrSaleTotal) && (count($arrSaleTotal)>0))
									{
										
										foreach($arrSaleTotal as $arrKey => $arrVal)
										{
											$intDateSalesTotal = $intDateSalesTotal + $arrKey;
										}
									}
								}
								//$strSeriesDataValue .= "['".date("jS M y",strtotime($arrSeries))."',".$arrSeriesDataValueList[$arrSeries]."]~";
								if($arrSeriesDataValueList[$arrSeries])
								{
									$arrResponse['chartdata'] = "notnull";
								}
								$strSeriesDataValue .= $intDateSalesTotal.",";
								$strTotal = $strTotal+$intDateSalesTotal;
								
							}
							else
							{
								//$strSeriesDataValue .= "['".date("jS M y",strtotime($arrSeries))."',".$arrSeriesDataValueList[$arrSeries]."]~";
								if($arrSeriesDataValueList[$arrSeries])
								{
									$arrResponse['chartdata'] = "notnull";
								}
								$strSeriesDataValue .= $arrSeriesDataValueList[$arrSeries].",";
								$strTotal = $strTotal+$arrSeriesDataValueList[$arrSeries];	
							}
						}
						$strTotalUsers .= $strTotal."~";
						$strSeriesDataValue = rtrim($strSeriesDataValue,",");
						$strSeriesDataValue .= "~";
					}
				}
				
				$arrSeriesData = array_unique($arrSeriesData);
				
				$arrResponse['status'] = "success";
				$arrResponse['xseries'] = rtrim($strSeriesData,",");
				$arrResponse['dataseries'] = rtrim($strSeriesDataValue,"~");
				$arrResponse['chartTitle'] = $arrPortalDetail[0]['Portal']['career_portal_name'];
				$arrResponse['totlavals'] = rtrim($strTotalUsers,"~");
			}
			else
			{
				$arrResponse['status'] = "fail";
			}
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function contactus()
	{
		if($this->request->is('Post'))
		{
			//print("<pre>");
			//print_r($this->request->data);
			
			$arrContactDetail = array();
			$arrContactDetail['name'] = $this->request->data['name'];
			$arrContactDetail['email'] = $this->request->data['email'];
			$arrContactDetail['message'] = $this->request->data['message'];
			$arrContactDetail['subject'] = $this->request->data['subject'];
			
			$isSent = $this->fnSendAdminEmployerContactusEmail($arrContactDetail);
			if($isSent)
			{
				$this->Session->setFlash('Your request was sent. We will get back to you soon','default',array('class' => 'success'));
			}
			else
			{
				$this->Session->setFlash('Some issues, Please try again.');
			}
		}
	}	
	
	public function reseller()	
	{
		$this->layout = "newemployers";				
		$arrLoggedUserDetails = $this->Auth->user();	
		$arrEmployerDetail = $this->Employer->find('all',array('conditions'=>array('employer_id'=>$arrLoggedUserDetails['id'])));		
		$this->set("arrEmployerDetail",$arrEmployerDetail);			
		
	}
	public function purchase()
	{
		//Configure::write('debug', 2);
		$arrLoggedUserDetails = $this->Auth->user();	
		$arrEmployerDetail = $this->Employer->find('all',array('conditions'=>array('employer_id'=>$arrLoggedUserDetails['id'])));
		
		$purchaseArray = array(
		  "domain"=> $_POST['domain'],
		  "renewAuto"=> false,
		  "privacy"=> false,
		  "nameServers"=> array(
			"ns47.domaincontrol.com"
		  ),
		  "consent"=> array(
			"agreementKeys"=> array("DNRA"),
			"agreedBy"=> "192.168.1.32",
			"agreedAt"=> "2017-01-07T13:10:56Z"
		  ),
		  "contactAdmin"=> array(
			"nameFirst"=> "teju",
			"nameMiddle"=> "p",
			"nameLast"=> "k",
			"email"=> "teju.kamble145@gmail.com",
			"addressMailing"=> array(
			  "address1"=> "pune",
			  "city"=> "pune",
			  "state"=> "MH",
			  "postalCode"=> "412308",
			  "country"=> "IN"
			),
			"phone"=> "+1.4805058800"
		  ),
		  "contactBilling"=> array(
			"nameFirst"=> "teju",
			"nameMiddle"=> "p",
			"nameLast"=> "k",
			"email"=> "teju.kamble145@gmail.com",
			"addressMailing"=> array(
			  "address1"=> "pune",
			  "city"=> "pune",
			  "state"=> "MH",
			  "postalCode"=> "412308",
			  "country"=> "IN"
			),
			"phone"=> "+1.4805058800"
		  ),
		  "contactRegistrant"=> array(
			"nameFirst"=> "teju",
			"nameMiddle"=> "p",
			"nameLast"=> "k",
			"email"=> "teju.kamble145@gmail.com",
			"addressMailing"=> array(
			  "address1"=> "pune",
			  "city"=> "pune",
			  "state"=> "MH",
			  "postalCode"=> "412308",
			  "country"=> "IN"
		   ),
			"phone"=> "+1.4805058800"
		  ),
		  "contactTech"=> array(
			"nameFirst"=> "teju",
			"nameMiddle"=> "p",
			"nameLast"=> "k",
			"email"=> "teju.kamble145@gmail.com",
			"addressMailing"=> array(
			  "address1"=> "pune",
			  "address2"=> "pune",
			  "city"=> "pune",
			  "state"=> "MH",
			  "postalCode"=> "412308",
			  "country"=> "IN"
			),
			"phone"=> "+1.4805058800"
		  )
		);
		 $purchaseStr = json_encode($purchaseArray);

		$dsc_header = array("Content-Type:application/json","Accept:application/json","X-Shopper-Id:962538");
		$ch = curl_init("https://api.ote-godaddy.com/v1/domains/purchase");
				if ($ch == FALSE) {
						echo "Connecting to createsend failed\n";
				}
				curl_setopt($ch, CURLOPT_HTTPHEADER, $dsc_header);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $purchaseStr);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
				curl_setopt($ch, CURLOPT_VERBOSE, 0);
				$result = curl_exec($ch);
				$purchased_data = json_decode($result);
				if(isset($purchased_data->orderId))
				{	
					$arrEmployerDetailPostedData = array();
					$this->loadModel('Employerdomain');
					$arrEmployerDetailPostedData['domain_name'] = $_POST['domain'];
					$arrEmployerDetailPostedData['order_id'] = $purchased_data->orderId;
					$arrEmployerDetailPostedData['employer_id'] = $arrEmployerDetail[0]['Employer']['employer_id'];
					$arrEmployerDetailPostedData['purchased_date'] = date('Y-m-d 00:00:00');
					$intBoolNewEmployerInserted = $this->Employerdomain->save($arrEmployerDetailPostedData);
					
					$arrEmployerDomainDetail = array();
					$this->loadModel('Wizemployer');
					$arrEmployerDomainDetail['step_id'] = 1;
					$arrEmployerDomainDetail['employer_id'] = $arrEmployerDetail[0]['Employer']['employer_id'];
					$arrEmployerDomainDetail['step_status'] = 1;
					$arrEmployerDomainDetail['created_date'] = date('Y-m-d 00:00:00');
					$intBoolNewEmployerInserted = $this->Wizemployer->save($arrEmployerDomainDetail);
				}	
		echo $result;
		exit;
	}
	public function purchased_domain()
	{
		//Configure::write('debug', 2);
		$this->loadModel('Employerdomain');
		$arrLoggedUserDetails = $this->Auth->user();	
		$arrEmployerDomain = $this->Employerdomain->find('first',array('conditions'=>array('employer_id'=>$arrLoggedUserDetails['id']),'order'=>'employer_domain_id DESC'));
		if(count($arrEmployerDomain)>0)
		{
			$arrEmployerDomain = json_encode($arrEmployerDomain);
		}
		else
		{
			$arrEmployerDomain = '';
		}
		/*$dsc_header = array("Content-Type:application/json","Accept:application/json","X-Shopper-Id:962538");
		$ch = curl_init("https://api.ote-godaddy.com/v1/domains?statuses=ACTIVE&statusGroups=VISIBLE");
        if ($ch == FALSE) {
                echo "Connecting to createsend failed\n";
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $dsc_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       // curl_setopt($ch, CURLOPT_POSTFIELDS, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        $result = curl_exec($ch);*/
		echo $arrEmployerDomain;
		exit;
	}
}