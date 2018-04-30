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

class VendoraccountController extends AppController 

{



	var $helpers = array ('Html','Form');





/**

 * Controller name

 *

 * @var string

 */

	public $name = 'Vendoraccount';



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

		$this->Auth->allow('login','forgotpassword');

	}

	

	public function index()

	{

		//echo "HI";

		//print("<pre>");

		//print_r($this->Auth->user());

		//exit;

		

		/*$arrLoggedUserDetails = $this->Auth->user();

		print("<pre>");

		print_r($arrLoggedUserDetails);

		$this->loadModel('User');

		$arrViewUserDetail = $this->User->fnGetCompleteUserDetail($arrLoggedUserDetails['id'],$arrLoggedUserDetails['user_type']);

		$this->set('arrCompleteLoggedInUserDetail',$arrViewUserDetail); */

	}
	
	public function mgusers()
	{
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('Vendors');
		$arrVendors = $this->Vendors->find('all', array(
									'conditions' => array('parent_vendor' => $arrLoggedUser['vendor_id']),'ORDER'=>array('vendor_id'=>'DESC')
								));
								
		$this->set("arrProductList",$arrVendors);
		$this->set("strVendorHead",$arrLoggedUser['vendor_name']);
	}
	
	public function edituser($intVendorId = "")
	{
		//Configure::write('debug','2');
		
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('Vendors');
		if($this->request->is('Post'))
		{
			//print("<pre>");
			//print_r($this->request->data);
			//exit;
		
			$arrContentData['Vendors']['vendor_first_name'] = addslashes(trim($this->request->data['vfname']));
			$arrContentData['Vendors']['vendor_last_name'] = addslashes(trim($this->request->data['vlname']));
			$arrContentData['Vendors']['vendor_phone'] = addslashes(trim($this->request->data['vphone']));
			$arrContentData['Vendors']['vendor_email'] = addslashes($this->request->data['vemail']);
			$arrContentData['Vendors']['vendor_password'] = addslashes($this->request->data['vpass']);
			$arrContentData['Vendors']['vendor_password_encrypted'] = AuthComponent::password($this->request->data['vpass']);
			$arrContentData['Vendors']['parent_vendor'] = $arrLoggedUser['vendor_id'];
			$arrContentData['Vendors']['vendor_active'] = "1";
			$arrContentData['Vendors']['vendor_type'] = "Services";
			$intVendorId = $this->request->data['vid'];
			
			
			//print("<pre>");
			//print_r($arrContentData);
			//exit;
			
			if($intVendorId)
			{
				if($arrContentData['Vendors']['vendor_password'])
				{
					$boolContentUpdated = $this->Vendors->updateAll(
						array('vendor_email' => "'".$arrContentData['Vendors']['vendor_email']."'",'vendor_password' => "'".$arrContentData['Vendors']['vendor_password']."'",'vendor_password_encrypted'=> "'".$arrContentData['Vendors']['vendor_password_encrypted']."'",'vendor_first_name'=> "'".$arrContentData['Vendors']['vendor_first_name']."'",'vendor_last_name'=> "'".$arrContentData['Vendors']['vendor_last_name']."'",'vendor_phone'=> "'".$arrContentData['Vendors']['vendor_phone']."'"),
						array('vendor_id =' => $intVendorId)
					);
				}
				else
				{
						$boolContentUpdated = $this->Vendors->updateAll(
						array('vendor_email' => "'".$arrContentData['Vendors']['vendor_email']."'",'vendor_first_name'=> "'".$arrContentData['Vendors']['vendor_first_name']."'",'vendor_last_name'=> "'".$arrContentData['Vendors']['vendor_last_name']."'",'vendor_phone'=> "'".$arrContentData['Vendors']['vendor_phone']."'"),
						array('vendor_id =' => $intVendorId)
					);
				}
				
				if($boolContentUpdated)
				{
					if($arrContentData['Vendors']['tonotify'])
					{
						$isNotified = $this->fnSendVendorAccountDetails($arrContentData['Vendors']['vendor_name'],$arrContentData['Vendors']['vendor_email'],$arrContentData['Vendors']['vendor_password'],"1");
						if($isNotified)
						{
							$boolContentUpdated = $this->Vendors->updateAll(
								array('notified'=>"'1'"),
								array('vendor_id =' => $intEditModeId)
							);
						}
					}
					$strForMessage = "Updation was successfull.";
				}
				else
				{
					$strForMessage = "Some Error, Please try again.";
				}
				$this->set("strForMessage",$strForMessage);
			}
		}
		
		$arrVendors = $this->Vendors->find('all', array(
									'conditions' => array('vendor_id' => $intVendorId)
								));
		$this->set("arrProductList",$arrVendors);
	}
	
	public function adduser()
	{
		$arrLoggedUser = $this->Auth->user();
		if($this->request->is('Post'))
		{
			//print("<pre>");
			//print_r($this->request->data);
			//exit;
		
			$arrContentData['Vendors']['vendor_first_name'] = addslashes(trim($this->request->data['vfname']));
			$arrContentData['Vendors']['vendor_last_name'] = addslashes(trim($this->request->data['vlname']));
			$arrContentData['Vendors']['vendor_phone'] = addslashes(trim($this->request->data['vphone']));
			$arrContentData['Vendors']['vendor_email'] = addslashes($this->request->data['vemail']);
			$arrContentData['Vendors']['vendor_password'] = addslashes($this->request->data['vpass']);
			$arrContentData['Vendors']['vendor_password_encrypted'] = AuthComponent::password($this->request->data['vpass']);
			$arrContentData['Vendors']['parent_vendor'] = $arrLoggedUser['vendor_id'];
			$arrContentData['Vendors']['vendor_active'] = "1";
			$arrContentData['Vendors']['vendor_type'] = "Services";
			
			
			//print("<pre>");
			//print_r($arrContentData);
			//exit;
			$this->loadModel('Vendors');
			$intContentExists = $this->Vendors->find('count', array(
									'conditions' => array('vendor_email' => $arrContentData['Vendors']['vendor_email'])
								));
			//echo "---".$intContentExists;
			if($intContentExists)
			{
				$compMessage = $this->Components->load('Message');
				//$strMessage = $compMessage->fnGenerateMessageBlock('This Vendor is already present','info');
				//$arrResponseData['status'] = 'fail';
				//$arrResponseData['message'] = $strMessage;
				$strForMessage = "This Vendor is already present.";
				
			}
			else
			{
				
				$boolContentCreated = $this->Vendors->save($arrContentData);
				if($boolContentCreated)
				{
					$intCreatedContentId = $this->Vendors->getLastInsertID();
					$arrResponseData['createdid'] = $intCreatedContentId;
					
					if($arrContentData['Vendors']['tonotify'])
					{
						$isNotified = $this->fnSendVendorAccountDetails($arrContentData['Vendors']['vendor_name'],$arrContentData['Vendors']['vendor_email'],$arrContentData['Vendors']['vendor_password']);
						if($isNotified)
						{
							$boolContentUpdated = $this->Vendors->updateAll(
								array('notified'=>"'1'"),
								array('vendor_id =' => $intCreatedContentId)
							);
						}
					}
					$compMessage = $this->Components->load('Message');
					$strForMessage = "You have successfully added Vendor.";
					//$strMessage = $compMessage->fnGenerateMessageBlock($strForMessage,'success');
					//$arrResponseData['message'] = $strMessage;
				}
				
			}
			$this->set("strForMessage",$strForMessage);
		}
	}

	

	public function logout($strSwictchBack = "") 

	{

		$this->layout = NULL;

		$this->autoRender = False;

		$arrResponse = array();

		$arrLoggedUser = $this->Auth->user();

		

		$arrResponse['logoutredirecturl'] = $this->Auth->logout();

		

		if($arrResponse['logoutredirecturl'])

		{

			$arrResponse['logoutredirecturl'] = Router::url(array('controller'=>'vendoraccount','action'=>'index'),true);

			$arrResponse['status'] = "success";

			$arrResponse['loggedoutusertype'] = $arrLoggedUser['vendor_type'];

		}

		

		echo json_encode($arrResponse);

		exit;

	}

	

	public function login($strSwictchBack = "")

	{



		if($this->request->is('post'))

		{

			/* print("<pre>");

			print_r($this->request->data);

			exit; */

			

			$this->loadModel('Vendors');

			$arrPostedData = array();

			//$arrPostedData['email'] = $this->request->data['User']['user_email'];

			//$arrPostedData['pass'] = $this->request->data['User']['user_pass'];

			

			$this->request->data['Vendors']['vendor_email'] = addslashes(trim($this->request->data['Vendors']['user_email']));

			$this->request->data['Vendors']['vendor_password_encrypted'] = addslashes(trim($this->request->data['Vendors']['password']));

			

			//$this->request->data['Vendors']['vendor_email'] = "rajendra4uaty@yahoo.com";

			//$this->request->data['Vendors']['vendor_password_encrypted'] = "test123";

			

			$this->Vendors->set($this->request->data);

			

			

			/*if($this->User->validates())

			{*/

				if($this->Auth->login())

				{

					$arrLoggedInUser = $this->Auth->user();

					if($arrLoggedInUser['vendor_active'] == "0")

					{

						$this->Auth->logout();

						$arrResultSet = array();

						$arrResultSet['status'] = "failure";

						$arrResultSet['message'] = "Sorry, Your account is not being confirmed yet, Please confirm your account first.";

						$this->Session->setFlash('Sorry, Your account is not being confirmed yet, Please confirm your account first.');

						echo json_encode($arrResultSet);

						exit;

						

						/*$this->Session->setFlash('Sorry, Your account is not being confirmed yet, Please confirm your account first.');

						$this->redirect(array('controller'=>'users','action'=>'login')); */

					}

					else

					{

						$arrResultSet = array();

						$arrResultSet['status'] = "success";

						$arrResultSet['redirecturl'] = Router::url($this->Auth->redirectUrl(),true);

						$arrResultSet['userid'] = $arrLoggedInUser['vendor_id'];

						$arrResultSet['username'] = $arrLoggedInUser['vendor_name'];

						$arrResultSet['useremail'] = $arrLoggedInUser['vendor_email'];

						$arrResultSet['vendortype'] = $arrLoggedInUser['vendor_type'];

						$arrResultSet['lmslogin'] = Configure::read('Lms.loginurl');

						

						echo json_encode($arrResultSet);

						exit;

						//$this->redirect($this->Auth->redirectUrl());

					}

				}

				else

				{

					$arrResultSet = array();

					$arrResultSet['status'] = "failure";

					$arrResultSet['message'] = "Your username and password combination was incorrect.";

					$this->Session->setFlash('Your username and password combination was incorrect');

					echo json_encode($arrResultSet);

					exit;

					//$this->Session->setFlash('Your username and password combination was incorrect');

				}

			/*}

			else

			{

				$errors = $this->User->invalidFields();

				$strLoginerrorMessage = "";

				if(is_array($errors) && (count($errors)>0))

				{

					$intForIterateCount = 0;

					foreach($errors as $errorVal)

					{

						$intForIterateCount++;

						if($intForIterateCount == 1)

						{

							$strLoginerrorMessage .= "Error: ".$errorVal['0'];

						}

						else

						{

							$strLoginerrorMessage .= "<br> Error: ".$errorVal['0'];

						}

						

					}

					$this->Session->setFlash($strLoginerrorMessage);

					$arrResultSet = array();

					$arrResultSet['status'] = "failure";

					$arrResultSet['message'] = $strLoginerrorMessage;

					echo json_encode($arrResultSet);

					exit;

				}

			}*/

			//$this->redirect(array('controller'=>'home','action'=>'index'));

		

		}

	

	}

	

	public function forgotpassword()

	{

		if($this->request->is('post'))

		{

			/*print("<pre>");

			print_r($this->request->data);

			exit;*/

				

			$this->request->data['Vendors']['vendor_email'] = addslashes(trim($this->request->data['User']['user_email']));

			

			$this->loadModel('Vendors');

			$this->Vendors->set($this->request->data);

			

			/*if($this->User->validates())

			{*/

				$arrUserExists = $this->Vendors->find('all', array(

								'conditions' => array('vendor_email' => $this->request->data['User']['user_email'])

							));

				/* print("<pre>");

				print_r($arrUserExists);

				exit; */

				if(is_array($arrUserExists) && (count($arrUserExists)>0))

				{

					

					$strUsersName = $arrUserExists[0]['Vendors']['vendor_name'];

					/* echo "---".$strUsersName;

					exit; */

					$strNewPassword = $this->fnRegeneratePassword($arrUserExists[0]['Vendors']['vendor_id']);

					$boolUpdated = $this->Vendors->updateAll(

									array('Vendors.vendor_password_encrypted' => "'".AuthComponent::password($strNewPassword)."'",'Vendors.vendor_password' => "'".$strNewPassword."'"),

									array('Vendors.vendor_email =' => $this->request->data['User']['user_email'])

								);

					if($boolUpdated)

					{

						$intMailSent = $this->fnSendPassowordRegenerationMail($strUsersName, $this->request->data['User']['user_email'],$strNewPassword);

						if($intMailSent)

						{

							$this->Session->setFlash("Congratulation, your Password has been reset, Please check your Mail",'default',array('class' => 'success'));

						}

						else

						{

							$this->Session->setFlash("Please try again.");

						}

					}

					else

					{

						$this->Session->setFlash("Please try again.");

					}

				}

				else

				{

					$this->Session->setFlash("In-Correct email address, Account not registered.");

				}

			/*}

			else

			{

				$errors = $this->User->invalidFields();

				$strRegerrorMessage = "";

				if(is_array($errors) && (count($errors)>0))

				{

					$intForIterateCount = 0;

					foreach($errors as $errorVal)

					{

						$intForIterateCount++;

						if($intForIterateCount)

						{

							$strRegerrorMessage .= "Error: ".$errorVal['0'];

						}

						else

						{

							$strRegerrorMessage .= "<br> Error: ".$errorVal['0'];

						}

						

					}

					

					$this->Session->setFlash($strRegerrorMessage);

				}

			}*/

		}

	}

	

	public function editpayout()

	{

		$arrLoggedUserDetails = $this->Auth->user();

		/*print("<pre>");

		print_r($arrLoggedUserDetails);

		exit;*/

		$this->loadModel('Vendorpayout');
		$this->loadModel('Vendorcompany');

		$strRegerrorMessage = "";

		if($this->request->is('post'))

		{

		
			/*print("<pre>");

			print_r($this->request->data);

			exit;*/
			$arrContentData['Vendorpayout']['vendor_id'] = $intEditModeId = $arrLoggedUserDetails['vendor_id'];

			$arrContentData['Vendorpayout']['payout_to'] = addslashes($this->request->data['payoutto']);

			$arrContentData['Vendorpayout']['tax_id'] = addslashes($this->request->data['taxid']);

			$arrContentData['Vendorpayout']['minimum_check_amt'] = addslashes($this->request->data['minamt']);

			$arrContentData['Vendorpayout']['commission_pct'] = addslashes($this->request->data['compct']);

			$arrContentData['Vendorpayout']['indeed_registration'] = addslashes($this->request->data['inreg']);

			$intVendorCompanyExists = $this->Vendorpayout->find('count',array('conditions'=>array('vendor_id'=>$intEditModeId)));
			/*print("<pre>");

			print_r($arrContentData);

			exit;*/
			if($intVendorCompanyExists)

			{

				$this->Vendorpayout->deleteAll(array('Vendorpayout.vendor_id' => $intEditModeId),false);

			}



			$arrCompanyDetailsEntered = $this->Vendorpayout->save($arrContentData);

				

			if($arrCompanyDetailsEntered)

			{

				$this->Session->setFlash('Vendor Payment Details Saved Successfully!','default',array('class' => 'success'));
				$arrViewUserDetail = $this->Vendorcompany->find('all',array('conditions'=>array('vendor_id'=>$arrLoggedUserDetails['vendor_id'])));


				$view = new View($this, false);
				$view->set('arrCompleteLoggedInUserDetail',$arrViewUserDetail);
				//$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
				//$view->set('arrContactDetail',$arrContactDetail);
				$strWidgetListerHtml = $view->element('vendor_payment');
				$arrResponse['status'] = "success";
				$arrResponse['html'] = $strWidgetListerHtml;

			}

			else

			{

				$this->Session->setFlash('Please try again');
				
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Parameter missing";
			}

		}


echo json_encode($arrResponse);
		exit;
		

	}

	

	public function editcompany()

	{

		$arrLoggedUserDetails = $this->Auth->user();

		/*print("<pre>");

		print_r($arrLoggedUserDetails);

		exit;*/

		$this->loadModel('Vendorcompany');

		$strRegerrorMessage = "";

		if($this->request->is('post'))

		{

			$arrContentData['Vendorcompany']['vendor_id'] = $intEditModeId = $arrLoggedUserDetails['vendor_id'];

			$arrContentData['Vendorcompany']['company_name'] = addslashes($this->request->data['vendorcname']);

			$arrContentData['Vendorcompany']['vendor_f_name'] = addslashes($this->request->data['vendorfname']);

			$arrContentData['Vendorcompany']['vendor_l_name'] = addslashes($this->request->data['vendorlname']);

			$arrContentData['Vendorcompany']['vendor_email'] = addslashes($this->request->data['vendorcemail']);

			$arrContentData['Vendorcompany']['address'] = addslashes($this->request->data['vendor_company_address']);

			$arrContentData['Vendorcompany']['zip'] = addslashes($this->request->data['zip']);

			$arrContentData['Vendorcompany']['phone'] = addslashes($this->request->data['vendorcphone']);

			$arrContentData['Vendorcompany']['fax'] = addslashes($this->request->data['vendorfax']);

			$arrContentData['Vendorcompany']['web_address'] = addslashes($this->request->data['vendorwaddress']);

			$arrContentData['Vendorcompany']['billing_phone'] = addslashes($this->request->data['vendorbphone']);

			

						

			/*print("<pre>");

			print_r($arrContentData);

			exit;*/

			

			$intVendorCompanyExists = $this->Vendorcompany->find('count',array('conditions'=>array('vendor_id'=>$intEditModeId)));

			if($intVendorCompanyExists)

			{

				$this->Vendorcompany->deleteAll(array('Vendorcompany.vendor_id' => $intEditModeId),false);

			}



			$arrCompanyDetailsEntered = $this->Vendorcompany->save($arrContentData);

				

			if($arrCompanyDetailsEntered)

			{

				//$this->Session->setFlash('Vendor Company Details Updated Successfully!','default',array('class' => 'success'));
				
				$arrViewUserDetail = $this->Vendorcompany->find('all',array('conditions'=>array('vendor_id'=>$arrLoggedUserDetails['vendor_id'])));


				//$view = new View($this, false);
				//$view->set('arrCompleteLoggedInUserDetail',$arrViewUserDetail);
				//$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
				//$view->set('arrContactDetail',$arrContactDetail);
				//$strWidgetListerHtml = $view->element('vendor_company');
				$arrResponse['status'] = "success";
				$arrResponse['message'] = '<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Vendor Company Details Updated Successfully</div>';

			}

			else

			{

			//	$this->Session->setFlash('Please try again');
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = '<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Vendor Company Details Updated Successfully</div>';
			}

		}
		
		echo json_encode($arrResponse);
		exit;

	}

	public function getcompanyhtml()
	{
		$arrLoggedUserDetails = $this->Auth->user();

		/*print("<pre>");

		print_r($arrLoggedUserDetails);

		exit;*/

		$this->loadModel('Vendorcompany');
		
		if($arrLoggedUserDetails['vendor_id'])
		{
			$arrViewUserDetail = $this->Vendorcompany->find('all',array('conditions'=>array('vendor_id'=>$arrLoggedUserDetails['vendor_id'])));



		
			
				$view = new View($this, false);
				$view->set('arrCompleteLoggedInUserDetail',$arrViewUserDetail);
				//$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
				//$view->set('arrContactDetail',$arrContactDetail);
				$strWidgetListerHtml = $view->element('vendor_company');
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
	
	
	
	public function getPaymenthtml()
	{
		$arrLoggedUserDetails = $this->Auth->user();

		/*print("<pre>");

		print_r($arrLoggedUserDetails);

		exit;*/

		$this->loadModel('Vendorpayout');
		
		if($arrLoggedUserDetails['vendor_id'])
		{
				$arrViewUserDetail = $this->Vendorpayout->find('all',array('conditions'=>array('vendor_id'=>$arrLoggedUserDetails['vendor_id'])));
				$view = new View($this, false);
				$view->set('arrCompleteLoggedInUserDetail',$arrViewUserDetail);
				//$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
				//$view->set('arrContactDetail',$arrContactDetail);
				$strWidgetListerHtml = $view->element('vendor_payment');
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
	
	

	public function edit($type="")

	{

		$arrLoggedUserDetails = $this->Auth->user();

		/*print("<pre>");

		print_r($arrLoggedUserDetails);

		exit;*/

		$this->loadModel('Vendors');

		$strRegerrorMessage = "";

		if($this->request->is('post'))

		{

			$arrAdminBasicPostedData = array();

			$arrAdminBasicPostedData['vendor_name'] = addslashes(trim($this->request->data['User']['vendorname']));

			$arrAdminBasicPostedData['vendor_first_name'] = addslashes(trim($this->request->data['User']['vendorfname']));

			$arrAdminBasicPostedData['vendor_last_name'] = addslashes(trim($this->request->data['User']['vendorlname']));

			$arrAdminBasicPostedData['vendor_phone'] = addslashes(trim($this->request->data['User']['vendorphone']));

			if($this->request->data['User']['vendor_pass'])

			{

				$arrAdminBasicPostedData['vendor_password'] = $this->request->data['User']['vendor_pass'];

				$arrAdminBasicPostedData['vendor_password_encrypted'] = AuthComponent::password($this->request->data['User']['vendor_pass']);

			}

			

			//print("<pre>");

			//print_r($arrAdminBasicPostedData);

			//exit;

			

			$this->Vendors->set($arrAdminBasicPostedData);

			if($this->request->data['User']['vendor_pass'])

			{

				

				

				$boolUpdated = $this->Vendors->updateAll(

					array('Vendors.vendor_name' => "'".$arrAdminBasicPostedData['vendor_name']."'",'Vendors.vendor_first_name'=>"'".$arrAdminBasicPostedData['vendor_first_name']."'",'Vendors.vendor_last_name'=>"'".$arrAdminBasicPostedData['vendor_last_name']."'",'Vendors.vendor_phone'=>"'".$arrAdminBasicPostedData['vendor_phone']."'",'Vendors.vendor_password'=>"'".$arrAdminBasicPostedData['vendor_password']."'",'Vendors.vendor_password_encrypted'=>"'".$arrAdminBasicPostedData['vendor_password_encrypted']."'"),

					array('Vendors.vendor_id =' => $arrLoggedUserDetails['vendor_id'])

				);

			}

			else

			{

				$boolUpdated = $this->Vendors->updateAll(

					array('Vendors.vendor_name' => "'".$arrAdminBasicPostedData['vendor_name']."'",'Vendors.vendor_first_name'=>"'".$arrAdminBasicPostedData['vendor_first_name']."'",'Vendors.vendor_last_name'=>"'".$arrAdminBasicPostedData['vendor_last_name']."'",'Vendors.vendor_phone'=>"'".$arrAdminBasicPostedData['vendor_phone']."'"),

					array('Vendors.vendor_id =' => $arrLoggedUserDetails['vendor_id'])

				);

			}

				

			if($boolUpdated)

			{
				
				$this->Session->setFlash('<div class="alert alert-success">		  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Profile updated successfully</div>');

				//$this->Session->setFlash('Profile Updated Successfully!','default',array('class' => 'success'));

			}

			else

			{

				$this->Session->setFlash('Please try again');
					$this->Session->setFlash('<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Please try again</div>');

			}

		}

		

		

		$arrViewUserDetail = $this->Vendors->find('all',array('conditions'=>array('vendor_id'=>$arrLoggedUserDetails['vendor_id'])));



		$this->set('arrCompleteLoggedInUserDetail',$arrViewUserDetail);
		$this->set('type',$type);

	}

	
	public function checkvendorreminders($intPortalId)
	{
		//Configure::write('debug','2');
		
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();

		$arrLoggedUser = $this->Auth->user();
		$strDate = date('Y-m-d H:i:')."00";
		$this->loadModel("Notification");
		
		$intNotifyReadCnt = $this->Notification->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['vendor_id'],'notification_read'=>'0','foruser'=>'owner')));
									
		
			$arrNotifications = $this->Notification->find('all',array('conditions'=>array('candidate_id'=>$arrLoggedUser['vendor_id'],'notification_read'=>'0','foruser'=>'owner'),'order'=>array('notification_id'=>'desc'),'limit'=>2));
			
			
			$strNotificationHtml = '';
			if(is_array($arrNotifications) && (count($arrNotifications)>0))
			{
				$strNotificationHtml = '';
				$this->loadModel('Reminder');
				$this->loadModel('Candidate');
				$this->loadModel('Resourceorderdetail');
				foreach($arrNotifications as $arrNoti)
				{
					 $notification_read = $arrNoti['Notification']['notification_read'];
					$css='color:#000;';
					if($notification_read>0)
					{
						$css= "";
					}
					if($arrNoti['Notification']['reminder_type']=="orderupdate")
					{
						
						$arrVendorNotifications = $this->Resourceorderdetail->find('first',array('conditions'=>array('order_detail_id'=>$arrNoti['Notification']['reminder_id'])));
						
						$arrCandidate = $this->Candidate->find('all',array('conditions'=>array('candidate_id'=>$arrNoti['Notification']['notification_created_by'])));
						
						//print("<pre>");
						//print_r($arrCandidate);
						//exit;
						
						$linkorder = Router::url(array('controller'=>'vendororders','action'=>'orderdetail',$arrNoti['Notification']['reminder_id']),true);
						
						$strNotificationHtml .= '<li class="notification-block-bordered" id="notification'.$arrNoti['Notification']['notification_id'].'">
							<a class="dropdown-item-notification" href="'.$linkorder.'">
								<p style="'.$css.'">Candidate '.$arrCandidate[0]['Candidate']['candidate_first_name'].' '.$arrCandidate['Candidate']['candidate_last_name']. '  has updated the order '.$arrVendorNotifications['Resourceorderdetail']['product_name'].' with some details </p>
							</a>
							<a class="close-notification" href="#notification1">
								<img alt="" src="images/icon-delete-notification.png">
							</a>
						</li>';
					}
				}
			}
	
		
	
		
		if($strNotificationHtml)
		{
			$strNotificationHtml .= '<li>
							<a href="#" class="right-top-menu-item">See all notifications</a>
						</li>';
			$arrResponse['notifyhtml'] = $strNotificationHtml;
			$arrResponse['status'] = 'success';
			
			
		}
		if($intNotifyReadCnt)
		{
			$arrResponse['notifycount'] = $intNotifyReadCnt;
			$arrResponse['status'] = 'success';
		}
		echo json_encode($arrResponse);
		exit;
	}

	public function dashboard()

	{
		//echo $this->layout;
		$arrLoggedVendor = $this->Auth->user();
		$this->set('arrLoggedVendor',$arrLoggedVendor);
		$this->compTime = $this->Components->load('TimeCalculation'); 

		

		$strMonth = $this->compTime->fnFindCurrentMonth();

		$arrNewYear = $this->compTime->fnFindCurrentYear();

		

		$strDatFormMonthToCompare = $arrNewYear."-".$strMonth."-"."01 00:00:00";

		$strEndDatFormMonthToCompare = date($arrNewYear.'-'.$strMonth.'-t')." 23:59:59";

		

		

		$this->loadModel('Resourceorderdetail');

		$arrNewOrderCountForMonth = $this->Resourceorderdetail->fnGetNewOrderCount($arrLoggedVendor['vendor_id'],$strDatFormMonthToCompare,$strEndDatFormMonthToCompare);

		

		if(is_array($arrNewOrderCountForMonth) && (count($arrNewOrderCountForMonth)>0))

		{

			if($arrNewOrderCountForMonth[0][0]['count(*)'])

			{

				$this->set('intPortalOwners',$arrNewOrderCountForMonth[0][0]['count(*)']);

			}

		}

		

		$arrNewOrderCountTotal = $this->Resourceorderdetail->fnGetNewOrderCount($arrLoggedVendor['vendor_id']);

		//print("<pre>");

		//print_r($arrNewOrderCountTotal);

		//exit;

		if(is_array($arrNewOrderCountTotal) && (count($arrNewOrderCountTotal)>0))

		{

			if($arrNewOrderCountTotal[0][0]['count(*)'])

			{

				$this->set('intPortalCandidates',$arrNewOrderCountTotal[0][0]['count(*)']);

			}

		}
		else
		{
			$this->set('intPortalCandidates',0);
		}
		
		// vendor closed orders
		
		$arrClosedOrderCountTotal = $this->Resourceorderdetail->fnGetClosedOrderCount($arrLoggedVendor['vendor_id']);

		//print("<pre>");

		//print_r($arrNewOrderCountTotal);

		//exit;

		if(is_array($arrClosedOrderCountTotal) && (count($arrClosedOrderCountTotal)>0))

		{

			if($arrClosedOrderCountTotal[0][0]['count(*)'])

			{

				$this->set('intClosedPortalCandidates',$arrClosedOrderCountTotal[0][0]['count(*)']);

			}

		}
		else
		{
			$this->set('intClosedPortalCandidates',0);
		}
		
		
		// vendor open orders
		
		$arrOpenOrderCountTotal = $this->Resourceorderdetail->fnGetOpenOrderCount($arrLoggedVendor['vendor_id']);

		//print("<pre>");

		//print_r($arrNewOrderCountTotal);

		//exit;

		if(is_array($arrOpenOrderCountTotal) && (count($arrOpenOrderCountTotal)>0))

		{

			if($arrOpenOrderCountTotal[0][0]['count(*)'])

			{

				$this->set('intOpenPortalCandidates',$arrOpenOrderCountTotal[0][0]['count(*)']);

			}

		}
		else
		{
			$this->set('intOpenPortalCandidates',0);
		}

	}

	
	public function getVendorOrderCountHtml($selectedText)
	{
		
		$arrLoggedVendor = $this->Auth->user();

		$this->compTime = $this->Components->load('TimeCalculation'); 

		

		//$strMonth = $this->compTime->fnFindCurrentMonth();
		$strMonth = $this->compTime->fnFindLastMonth();

		$arrNewYear = $this->compTime->fnFindCurrentYear();

		
		if($selectedText == "month")
		{
			$strDatFormMonthToCompare = $arrNewYear."-".$strMonth."-"."01 00:00:00";
			//echo "--".$strEndDatFormMonthToCompare = date("",$arrNewYear.'-'.$strMonth.'-t')." 23:59:59";
			$strEndDatFormMonthToCompare = date("Y-m-d",strtotime('last day of last month'))." 23:59:59";
			
			
		}
		if($selectedText == "year")
		{
			$arrNewYear = $this->compTime->fnFindLastYear();
			echo "--".$strDatFormMonthToCompare = $arrNewYear."-01-"."01 00:00:00";
			echo "--".$strEndDatFormMonthToCompare = $arrNewYear."-12-"."31 23:59:59";
			
		}
		if($selectedText == "day")
		{		
			$strDatFormMonthToCompare = date('Y-m-d', strtotime(' -1 day'))." 00:00:00";
			$strEndDatFormMonthToCompare = date('Y-m-d', strtotime(' -1 day'))." 23:59:59";
		}
		if($selectedText == "week")
		{
			$previous_week = strtotime("-1 week +1 day");

			$start_week = strtotime("last sunday midnight",$previous_week);
			$end_week = strtotime("next saturday",$start_week);

			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);

			$strDatFormMonthToCompare = $start_week." 00:00:00";
			$strEndDatFormMonthToCompare = $end_week." 23:59:59";
		}

		

		$view = new View($this, false);
				
				

		$this->loadModel('Resourceorderdetail');

		$arrNewOrderCountForMonth = $this->Resourceorderdetail->fnGetNewOrderCount($arrLoggedVendor['vendor_id'],$strDatFormMonthToCompare,$strEndDatFormMonthToCompare);

		/*print("<pre>");

		print_r($arrNewOrderCountForMonth);

		exit;*/

		if(is_array($arrNewOrderCountForMonth) && (count($arrNewOrderCountForMonth)>0))

		{

			if($arrNewOrderCountForMonth[0][0]['count(*)'])

			{

				$view->set('intPortalOwners',$arrNewOrderCountForMonth[0][0]['count(*)']);

			}

		}
		else
		{
			$view->set('intPortalOwners',0);
		}

	
		// vendor closed orders
		
		$arrClosedOrderCountTotal = $this->Resourceorderdetail->fnGetClosedOrderCount($arrLoggedVendor['vendor_id'],$strDatFormMonthToCompare,$strEndDatFormMonthToCompare);

		//print("<pre>");

		//print_r($arrNewOrderCountTotal);

		//exit;

		if(is_array($arrClosedOrderCountTotal) && (count($arrClosedOrderCountTotal)>0))

		{

			if($arrClosedOrderCountTotal[0][0]['count(*)'])

			{

				$view->set('intClosedPortalCandidates',$arrClosedOrderCountTotal[0][0]['count(*)']);

			}

		}
		else
		{
			$view->set('intClosedPortalCandidates',0);
		}
		
		
		// vendor open orders
		
		$arrOpenOrderCountTotal = $this->Resourceorderdetail->fnGetOpenOrderCount($arrLoggedVendor['vendor_id'],$strDatFormMonthToCompare,$strEndDatFormMonthToCompare);

		//print("<pre>");

		//print_r($arrNewOrderCountTotal);

		//exit;

		if(is_array($arrOpenOrderCountTotal) && (count($arrOpenOrderCountTotal)>0))

		{

			if($arrOpenOrderCountTotal[0][0]['count(*)'])

			{

				$view->set('intOpenPortalCandidates',$arrOpenOrderCountTotal[0][0]['count(*)']);

			}

		}
		else
		{
			$view->set('intOpenPortalCandidates',0);
		}
		
		
		$strWidgetListerHtml = $view->element('vendor_chart');
		$arrResponse['status'] = "success";
		$arrResponse['html'] = $strWidgetListerHtml;
		echo json_encode($arrResponse);
		exit;
			
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