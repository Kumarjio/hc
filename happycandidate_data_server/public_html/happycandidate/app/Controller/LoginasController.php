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
class LoginasController extends AppController 
{

	var $helpers = array ('Html','Form');


/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Loginas';

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
		$this->Auth->allow('login','swicthback');
	}
	
	public function logout() 
	{
		$this->redirect($this->Auth->logout());
	}
	
	public function login($intUserType = "", $intUserId = "",$intPortalId = "",$isLoggedOut = "")
	{
		$arrLoggedUserDetails = $this->Auth->user();
		$this->layout = 'adminlogin';
		$this->set('isLoggedOut',$isLoggedOut);
		$this->set('intUserType',$intUserType);
		$this->set('intUserId',$intUserId);
		$this->set('intPortalId',$intPortalId);
		
		//print("<pre>");
		//print_r($arrLoggedUserDetails);
		//exit;		
		
		$strUserType = "";
		
		if($intUserType == "0")
		{
			if($intUserId && $intPortalId)
			{
				$this->loadModel('Candidate');
				$arrActiveUserExists = $this->Candidate->find('all',array('conditions'=>array('candidate_id'=>$intUserId,'candidate_is_active'=>'1')));
				if(is_array($arrActiveUserExists) && (count($arrActiveUserExists)>0))
				{
					// logout admin and log in user
					//print("<pre>");
					//print_r($arrActiveUserExists);
					//exit;
					$this->set("arrActiveUserExists",$arrActiveUserExists);
					$this->set('intPortalId',$intPortalId);
					if(!$isLoggedOut)
					{
						$_SESSION['olduser'] = $arrLoggedUserDetails;
						$_SESSION['camefrom'] = Router::url(array('controller'=>'manageusers','action'=>'index'),true);
						//echo "--".$this->here;
						//echo "--".Router::url(array('controller'=>'loginas','action'=>'login',$intUserType,$intUserId,$intPortalId),true);exit;
						$_SESSION['urltogo'] = Router::url(array('controller'=>'loginas','action'=>'login',$intUserType,$intUserId,$intPortalId),true);
					}
					else
					{
						//print('<pre>');
						//print_r($_SESSION['olduser']);
						//echo "Logged Out";exit;
					}
					//print("<pre>");
					//print_r($arrActiveUserExists);
					//exit;
				}
			}
			else
			{
				if($intUserId && !($intPortalId))
				{
					$this->loadModel('User');
					$arrActiveUserExists = $this->User->find('all',array('conditions'=>array('id'=>$intUserId,'is_active'=>'1')));
					if(is_array($arrActiveUserExists) && (count($arrActiveUserExists)>0))
					{
						// logout admin and log in user
						//print("<pre>");
						//print_r($arrActiveUserExists);
						//exit;
						$this->set("arrActiveUserExists",$arrActiveUserExists);
						$this->set('intPortalId',$intPortalId);
						if(!$isLoggedOut)
						{
							$_SESSION['olduser'] = $arrLoggedUserDetails;
							$_SESSION['camefrom'] = Router::url(array('controller'=>'manageusers','action'=>'index'),true);
							//echo "--".$this->here;
							//echo "--".Router::url(array('controller'=>'loginas','action'=>'login',$intUserType,$intUserId,$intPortalId),true);exit;
							$_SESSION['urltogo'] = Router::url(array('controller'=>'loginas','action'=>'login',$intUserType,$intUserId,"0"),true);
						}
						else
						{
							//print('<pre>');
							//print_r($_SESSION['olduser']);
							//echo "Logged Out";exit;
						}
						//print("<pre>");
						//print_r($arrActiveUserExists);
						//exit;
					}
				}
			}
			
		}
	}
	
	public function swicthback($intUserType = "", $intUserId = "",$strSessKey = "",$intPortalId = "",$strPortalName = "",$isLoggedOut = "")
	{
		$arrLoggedUserDetails = $this->Auth->user();
		$this->layout = 'adminlogin';
		$this->set('isLoggedOut',$isLoggedOut);
		$this->set('intUserType',$intUserType);
		
		$strUserType = "";
		if($intUserType == "3")
		{
			if(!$isLoggedOut)
			{
				$this->loadModel('Candidate');
				$arrActiveUserExists = $this->Candidate->find('all',array('conditions'=>array('candidate_id'=>$intUserId,'candidate_is_active'=>'1')));
				//print("<pre>");
				//print_r($_SESSION);
				//exit;
				$this->set('arrActiveUserExists',$arrActiveUserExists);
				$this->set('strSessKey',$strSessKey);
				$this->set('intUserType',$intUserType);
				$this->set('intPortalId',$intPortalId);
				$this->set('intUserId',$intUserId);
				$this->set('strPortalName',$strPortalName);
				$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',strtolower($strPortalName),'switchback'),true);
				$this->set('strLogoutUrl',$strLogoutUrl);
				$_SESSION['switchurltogo'] = Router::url(array('controller'=>'loginas','action'=>'swicthback',$intUserType,$intUserId,$strSessKey,$intPortalId,$strPortalName),true);
			}
		
		}
		
		if($intUserType == "2")
		{
			if(!$isLoggedOut)
			{
				$this->loadModel('User');
				$arrActiveUserExists = $this->User->find('all',array('conditions'=>array('id'=>$intUserId,'is_active'=>'1')));
				//print("<pre>");
				//print_r($_SESSION);
				//exit;
				$this->set('arrActiveUserExists',$arrActiveUserExists);
				$this->set('strSessKey',$strSessKey);
				$this->set('intUserType',$intUserType);
				$this->set('intPortalId',$intPortalId);
				$this->set('intUserId',$intUserId);
				$this->set('strPortalName',$strPortalName);
				$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',strtolower($strPortalName),'switchback'),true);
				$this->set('strLogoutUrl',$strLogoutUrl);
				$_SESSION['switchurltogo'] = Router::url(array('controller'=>'loginas','action'=>'swicthback',$intUserType,$intUserId,$strSessKey,"0","0"),true);
			}
			else
			{
				//echo "HI";exit;
			}
		
		}
	}
	
	public function index()
	{
		$arrLoggedUserDetails = $this->Auth->user();
		/* print("<pre>");
		print_r($arrLoggedUserDetails); */
		$this->loadModel('User');
		$arrViewUserDetail = $this->User->fnGetCompleteUserDetail($arrLoggedUserDetails['id'],$arrLoggedUserDetails['user_type']);
		$this->set('arrCompleteLoggedInUserDetail',$arrViewUserDetail);
	}
	
	public function edit()
	{
		$arrLoggedUserDetails = $this->Auth->user();
		/* print("<pre>");
		print_r($arrLoggedUserDetails); */	
		$this->loadModel('User');
		$strRegerrorMessage = "";
		if($this->request->is('post'))
		{
			$arrAdminBasicPostedData = array();
			$arrAdminBasicPostedData['username'] = addslashes(trim($this->request->data['User']['username']));
			$arrAdminBasicPostedData['email'] = addslashes(trim($this->request->data['User']['emailaddress']));
			
			/* print("<pre>");
			print_r($arrAdminBasicPostedData); */
			
			$this->User->set($arrAdminBasicPostedData);
			if($this->User->validates())
			{
				$this->loadModel('Admin');
				$arrAdminDetailPostedData = array();
				$arrAdminDetailPostedData['admin_fname'] = addslashes(trim($this->request->data['User']['firstname']));
				$arrAdminDetailPostedData['admin_lname'] = addslashes(trim($this->request->data['User']['lname']));
				$arrAdminDetailPostedData['admin_contact_number'] = addslashes(trim($this->request->data['User']['contactnumber']));
				$arrAdminDetailPostedData['admin_address'] = addslashes(trim($this->request->data['User']['address']));
				$arrAdminDetailPostedData['admin_country'] = addslashes(trim($this->request->data['User']['country']));
				$arrAdminDetailPostedData['admin_state'] = addslashes(trim($this->request->data['User']['state']));
				$arrAdminDetailPostedData['admin_city'] = addslashes(trim($this->request->data['User']['city']));
				$arrAdminDetailPostedData['admin_pin'] = addslashes(trim($this->request->data['User']['zipcode']));
				
				/* print("<pre>");
				print_r($arrAdminDetailPostedData); */
				
				$this->Admin->set($arrAdminDetailPostedData);
				if($this->Admin->validates())
				{
					
					$boolUpdated = $this->User->updateAll(
							array('User.username' => "'".$arrAdminBasicPostedData['username']."'",'User.email'=>"'".$arrAdminBasicPostedData['email']."'"),
							array('User.id =' => $arrLoggedUserDetails['id'])
						);
						
					if($boolUpdated)
					{
						/* print("<pre>");
						print_r($arrAdminDetailPostedData); */
						
						$boolDetailUpdated = $this->Admin->updateAll(
																			array('Admin.admin_fname' => "'".$arrAdminDetailPostedData['admin_fname']."'",
																				  'Admin.admin_lname'=>"'".$arrAdminDetailPostedData['admin_lname']."'",
																				  'Admin.admin_contact_number'=>"'".$arrAdminDetailPostedData['admin_contact_number']."'",
																				  'Admin.admin_address'=>"'".$arrAdminDetailPostedData['admin_address']."'",
																				  'Admin.admin_country'=>"'".$arrAdminDetailPostedData['admin_country']."'",
																				  'Admin.admin_state'=>"'".$arrAdminDetailPostedData['admin_state']."'",
																				  'Admin.admin_city'=>"'".$arrAdminDetailPostedData['admin_city']."'",
																				  'Admin.admin_pin'=>"'".$arrAdminDetailPostedData['admin_pin']."'"
																				),
																			array('Admin.admin_id ='=>$arrLoggedUserDetails['id'])
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
					$arrAdminDetailErrors = $this->Admin->invalidFields();
					if(is_array($arrAdminDetailErrors) && (count($arrAdminDetailErrors)>0))
					{
						$intForIterateCount = 0;
						foreach($arrAdminDetailErrors as $errorVal)
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
				$arrAdminErrors = $this->User->invalidFields();
				if(is_array($arrAdminErrors) && (count($arrAdminErrors)>0))
				{
					$intForIterateCount = 0;
					foreach($arrAdminErrors as $errorVal)
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
				$this->loadModel('Admin');
				$arrAdminDetailPostedData = array();
				$arrAdminDetailPostedData['admin_fname'] = addslashes(trim($this->request->data['User']['firstname']));
				$arrAdminDetailPostedData['admin_lname'] = addslashes(trim($this->request->data['User']['lname']));
				$arrAdminDetailPostedData['admin_contact_number'] = addslashes(trim($this->request->data['User']['contactnumber']));
				$this->Admin->set($arrAdminDetailPostedData);
				if(!$this->Admin->validates())
				{
					// append further error messages
					$arrAdminDetailErrors = $this->Admin->invalidFields();
					if(is_array($arrAdminDetailErrors) && (count($arrAdminDetailErrors)>0))
					{
						foreach($arrAdminDetailErrors as $errorVal)
						{
							$strRegerrorMessage .= "<br> Error: ".$errorVal['0'];
						}
						
					}
				}
				$this->Session->setFlash($strRegerrorMessage);
			}
		}
		
		
		$arrViewUserDetail = $this->User->fnGetCompleteUserDetail($arrLoggedUserDetails['id'],$arrLoggedUserDetails['user_type']);
		
		$this->set('arrCompleteLoggedInUserDetail',$arrViewUserDetail);

		// call to function which gives list of countries
		$this->set('arrCountryList',$this->fnLoadCountryListToPrint());
		/* print("<pre>");
		print_r($this->fnLoadCountryListToPrint()); */
		
		// call to function which gives list of states belonging to countries
		$this->set('arrStateList',$this->fnLoadStatesListForCountryToPrint($arrViewUserDetail[0]['country_id']));
		
		/* print("<pre>");
		print_r($this->fnLoadStatesListForCountryToPrint($arrViewUserDetail[0]['country_id'])); */
		
		/* print("<pre>");
		print_r($arrListOfStates); */
		
		// call to function which gives list of cities belonging to states
		$this->set('arrCityList',$this->fnLoadCityListForStateToPrint($arrViewUserDetail[0]['state_id']));
		
		/* print("<pre>");
		print_r($this->fnLoadCityListForStateToPrint($arrViewUserDetail[0]['state_id'])); */
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