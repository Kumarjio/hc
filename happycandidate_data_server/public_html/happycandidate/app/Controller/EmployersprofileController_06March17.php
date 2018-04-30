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
class EmployersprofileController extends AppController 
{

	var $helpers = array ('Html','Form');


/**
 * Controller name
 *
 * @var string
 */
	public $name = 'EmployersProfile';

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
	
	public function logout() 
	{
		$this->redirect($this->Auth->logout());
	}
	
	public function index()
	{
		
		//Configure::write('debug','2');
		$arrLoggedUserDetails = $this->Auth->user();
		//print("<pre>");
		//print_r($arrLoggedUserDetails);
		//exit;
		/* 
		/* $this->loadModel('User');
		$arrViewUserDetail = $this->User->fnGetCompleteUserDetail($arrLoggedUserDetails['id'],$arrLoggedUserDetails['user_type']);
		$this->set('arrCompleteLoggedInUserDetail',$arrViewUserDetail); */
		
		//$strEmployerProfileUrl = Configure::Read('Jobber.employerprofileurl');
		//$this->set('strEmployerProfileUrl',$strEmployerProfileUrl);
		$this->loadModel('Employer');
		if($this->request->is('post'))
		{
			
			//print("<pre>");
			//print_r($this->request->data);
			
			//print("<pre>");
		//	print_r($_POST);
			//exit;
			
			$fname = ucfirst($_POST['txt_fname']);
			$sname = ucfirst($_POST['txt_sname']);
			$address = $_POST['txt_address'];
			$address2 = $_POST['txt_address2'];
			$city = $_POST['txtcity'];
			$county = $_POST['txtcounty'];
			$state_province = $_POST['txtstateprovince'];
			$country = $_POST['txt_country'];
			$post_code = strtoupper($_POST['txt_post_code']);
			$phone_number = strtoupper($_POST['txt_phone_number']);
			//$email = strtoupper($_POST['eemail']);
			$company_name = strtoupper($_POST['cname']);
			//echo "--".$arrLoggedUser['id'];exit;
			//exit;
			$boolUpdated = $this->Employer->updateAll(array('employer_user_fname' =>"'$fname'",'employer_user_lname' => "'$sname'",'employer_company_name'=>"'$company_name'",'employer_address'  => "'$address'",'address2'  => "'$address2'",'employer_city'  => "'$city'",'employer_country'  => "'$country'",'employer_state'  => "'$state_province'",'employer_pin'=> "'$post_code'",'employer_contact_number'=>"'$phone_number'"),array('employer_id' => $arrLoggedUserDetails['id']));	
			
			//echo $boolUpdated;exit;
			if($boolUpdated)
			{
				$strMssg = "Profile was updated successfully";
				$strMssgClass = "alert-success";
			}
			else
			{
				$strMssg = "There was some problem, Please try again";
				$strMssgClass = "alert-error";
				
			}
			$this->set('strMssg',$strMssg);
			$this->set('strMssgClass',$strMssgClass);
		}

		
		$arrEmployerDetail = $this->Employer->find('all',array('conditions'=>array('employer_id'=>$arrLoggedUserDetails['id'])));
		$this->set("arrEmployerDetail",$arrEmployerDetail);
		$this->loadModel('JobberlandCounties');
		$countrylist = $this->JobberlandCounties->find('list', array('fields'=>array('code', 'name'),'conditions'=>array('enabled'=>'Y')));
		$this->set('countrylist',$countrylist);
		
		//print("<pre>");
		//print_r($arrEmployerDetail);
		//exit;
		
		
		
	}
	
	public function edit()
	{
		$arrLoggedUserDetails = $this->Auth->user();
		$this->loadModel('User');
		$strRegerrorMessage = "";
		if($this->request->is('post'))
		{
			$arrEmployerBasicPostedData = array();
			$arrEmployerBasicPostedData['username'] = addslashes(trim($this->request->data['User']['username']));
			$arrEmployerBasicPostedData['email'] = addslashes(trim($this->request->data['User']['emailaddress']));
			
			/* print("<pre>");
			print_r($arrEmployerBasicPostedData); */
			
			$this->User->set($arrEmployerBasicPostedData);
			if($this->User->validates())
			{
				$this->loadModel('Employer');
				$arrEmployerDetailPostedData = array();
				$arrEmployerDetailPostedData['employer_user_fname'] = addslashes(trim($this->request->data['User']['firstname']));
				$arrEmployerDetailPostedData['employer_user_lname'] = addslashes(trim($this->request->data['User']['lastname']));
				$arrEmployerDetailPostedData['employer_company_name'] = addslashes(trim($this->request->data['User']['company_name']));
				$arrEmployerDetailPostedData['employer_industry_type'] = addslashes(trim($this->request->data['User']['industry_type']));
				$arrEmployerDetailPostedData['employer_contact_number'] = addslashes(trim($this->request->data['User']['contact_number']));
				$arrEmployerDetailPostedData['employer_address'] = addslashes(trim($this->request->data['User']['address']));
				$arrEmployerDetailPostedData['employer_country'] = addslashes(trim($this->request->data['User']['country']));
				$arrEmployerDetailPostedData['employer_state'] = addslashes(trim($this->request->data['User']['state']));
				$arrEmployerDetailPostedData['employer_city'] = addslashes(trim($this->request->data['User']['city']));
				$arrEmployerDetailPostedData['employer_pin'] = addslashes(trim($this->request->data['User']['zipcode']));
				
				/* print("<pre>");
				print_r($arrEmployerDetailPostedData); */
				
				$this->Employer->set($arrEmployerDetailPostedData);
				if($this->Employer->validates())
				{
					
					$boolUpdated = $this->User->updateAll(
							array('User.username' => "'".$arrEmployerBasicPostedData['username']."'",'User.email'=>"'".$arrEmployerBasicPostedData['email']."'"),
							array('User.id =' => $arrLoggedUserDetails['id'])
						);
					if($boolUpdated)
					{
						/* print("<pre>");
						print_r($arrEmployerDetailPostedData); */
						
						$boolDetailUpdated = $this->Employer->updateAll(
																			array('Employer.employer_user_fname' => "'".$arrEmployerDetailPostedData['employer_user_fname']."'",
																				  'Employer.employer_user_lname'=>"'".$arrEmployerDetailPostedData['employer_user_lname']."'",
																				  'Employer.employer_company_name'=>"'".$arrEmployerDetailPostedData['employer_company_name']."'",
																				  'Employer.employer_industry_type'=>"'".$arrEmployerDetailPostedData['employer_industry_type']."'",
																				  'Employer.employer_contact_number'=>"'".$arrEmployerDetailPostedData['employer_contact_number']."'",
																				  'Employer.employer_address'=>"'".$arrEmployerDetailPostedData['employer_address']."'",
																				  'Employer.employer_country'=>"'".$arrEmployerDetailPostedData['employer_country']."'",
																				  'Employer.employer_state'=>"'".$arrEmployerDetailPostedData['employer_state']."'",
																				  'Employer.employer_city'=>"'".$arrEmployerDetailPostedData['employer_city']."'",
																				  'Employer.employer_pin'=>"'".$arrEmployerDetailPostedData['employer_pin']."'"
																				),
																			array('Employer.employer_id ='=>$arrLoggedUserDetails['id'])
																		);
						if($boolDetailUpdated)
						{
							$this->Session->setFlash('Profile Updated Successfully!','default',array('class' => 'success'));
						}
						else
						{
							$this->Session->setFlash('Please try again');
						}
					}
					else
					{
						$this->Session->setFlash('Please try again');
					}
				}
				else
				{
					$arrEmployerDetailErrors = $this->Employer->invalidFields();
					if(is_array($arrEmployerDetailErrors) && (count($arrEmployerDetailErrors)>0))
					{
						$intForIterateCount = 0;
						foreach($arrEmployerDetailErrors as $errorVal)
						{
							$intForIterateCount++;
							if($intForIterateCount == 1)
							{
								$strRegerrorMessage .= "Error: ".$errorVal['0'];
							}
							else
							{
								$strRegerrorMessage .= "<br> Error: ".$errorVal['0'];
							}
						}
						
					}
					$this->Session->setFlash($strRegerrorMessage);
				}
			}
			else
			{
				$arrEmployerErrors = $this->User->invalidFields();
				if(is_array($arrEmployerErrors) && (count($arrEmployerErrors)>0))
				{
					$intForIterateCount = 0;
					foreach($arrEmployerErrors as $errorVal)
					{
						$intForIterateCount++;
						if($intForIterateCount == 1)
						{
							$strRegerrorMessage .= "Error: ".$errorVal['0'];
						}
						else
						{
							$strRegerrorMessage .= "<br> Error: ".$errorVal['0'];
						}
					}
				}
				$this->loadModel('Employer');
				$arrEmployerDetailPostedData = array();
				$arrEmployerDetailPostedData['employer_user_fname'] = addslashes(trim($this->request->data['User']['firstname']));
				$arrEmployerDetailPostedData['employer_user_lname'] = addslashes(trim($this->request->data['User']['lastname']));
				$arrEmployerDetailPostedData['employer_company_name'] = addslashes(trim($this->request->data['User']['company_name']));
				$arrEmployerDetailPostedData['employer_industry_type'] = addslashes(trim($this->request->data['User']['industry_type']));
				$arrEmployerDetailPostedData['employer_contact_number'] = addslashes(trim($this->request->data['User']['contact_number']));
				$this->Employer->set($arrEmployerDetailPostedData);
				if(!$this->Employer->validates())
				{
					// append further error messages
					$arrEmployerDetailErrors = $this->Employer->invalidFields();
					if(is_array($arrEmployerDetailErrors) && (count($arrEmployerDetailErrors)>0))
					{
						$intForIterateCount = 0;
						foreach($arrEmployerDetailErrors as $errorVal)
						{
							$intForIterateCount++;
							if($intForIterateCount == 1)
							{
								$strRegerrorMessage .= "<br> Error: ".$errorVal['0'];
							}
							else
							{
								$strRegerrorMessage .= "<br> Error: ".$errorVal['0'];
							}
						}
						
					}
				}
				$this->Session->setFlash($strRegerrorMessage);
			}
		}
		
		
		/* print("<pre>");
		print_r($arrLoggedUserDetails); */
		
		
		$arrViewUserDetail = $this->User->fnGetCompleteUserDetail($arrLoggedUserDetails['id'],$arrLoggedUserDetails['user_type']);
		/* print("<pre>");
		print_r($arrViewUserDetail); */
		//echo "---".$arrCompleteLoggedInUserDetail[0]['country_id'];
		$this->set('arrCompleteLoggedInUserDetail',$arrViewUserDetail);

		// call to function which gives list of countries
		$this->set('arrCountryList',$this->fnLoadCountryListToPrint());
		
		// call to function which gives list of states belonging to countries
		/* print("<pre>");
		print_r($arrViewUserDetail); */
		
		$this->set('arrStateList',$this->fnLoadStatesListForCountryToPrint($arrViewUserDetail[0]['country_id']));
		/* print("<pre>");
		print_r($arrListOfStates); */
		
		// call to function which gives list of cities belonging to states
		$this->set('arrCityList',$this->fnLoadCityListForStateToPrint($arrViewUserDetail[0]['state_id']));
		
		$this->set('arrIndustryList',$this->fnLoadIndustryTypesToPrint());
	}
	
	public function dashboard()
	{
	
	}
	
	public function changepassword()
	{
		if($this->request->is('post'))
		{
			$this->loadModel('User');
			$arrPostedData = array();
			$this->request->data['User']['pass'] = addslashes(trim($this->request->data['User']['new_password']));
			$this->request->data['User']['confirm_pass'] = addslashes(trim($this->request->data['User']['new_password_again']));
			$this->request->data['User']['old_pass'] = addslashes(trim($this->request->data['User']['old_pass']));
			$arrCurrentUser = $this->Auth->user();
			
			$this->User->set($this->request->data);
			if($this->User->validates())
			{
				if($this->request->data['User']['pass'] == $this->request->data['User']['confirm_pass'])
				{
					$intUserExists = $this->User->find('count', array(
										'conditions' => array('id' => $arrCurrentUser['id'],'pass'=>AuthComponent::password($this->request->data['User']['old_pass']))
									));
					if($intUserExists)
					{
						$boolUpdated = $this->User->updateAll(
								array('User.pass' => "'".AuthComponent::password($this->request->data['User']['pass'])."'"),
								array('User.id =' => $arrCurrentUser['id'])
							);
						if($boolUpdated)
						{
							$this->Session->setFlash("Your Password has been Changed",'default',array('class' => 'success'));
						}
						else
						{
							$this->Session->setFlash("Please try again");
						}
					}
					else
					{
						$this->Session->setFlash("Please provide correct Old Password");
					}
				}
				else
				{
					$this->Session->setFlash("Your New Password does not match");
				}
			}
			else
			{
				$errors = $this->User->invalidFields();
				$strErrorMessage = "";
				if(is_array($errors) && (count($errors)>0))
				{
					$intForIterateCount = 0;
					foreach($errors as $errorVal)
					{
						$intForIterateCount++;
						if($intForIterateCount == 1)
						{
							$strErrorMessage .= "Error: ".$errorVal['0'];
						}
						else
						{
							$strErrorMessage .= "<br> Error: ".$errorVal['0'];
						}
					}
					$this->Session->setFlash($strErrorMessage);
				}
			}
		}
	}
}