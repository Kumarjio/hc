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
class VendoraccountController extends AppController {

    var $helpers = array('Html', 'Form');

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

    public function beforeFilter() {

        //$this->Auth->autoRedirect = false;

        parent::beforeFilter();

        $this->Auth->allow('login', 'forgotpassword');
    }

    public function index() {

        //echo "HI";
        //print("<pre>");
        //print_r($this->Auth->user());
        //exit;
        /* $arrLoggedUserDetails = $this->Auth->user();

          print("<pre>");

          print_r($arrLoggedUserDetails);

          $this->loadModel('User');

          $arrViewUserDetail = $this->User->fnGetCompleteUserDetail($arrLoggedUserDetails['id'],$arrLoggedUserDetails['user_type']);

          $this->set('arrCompleteLoggedInUserDetail',$arrViewUserDetail); */
    }

    public function mgusers() {
        $arrLoggedUser = $this->Auth->user();
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/vendor_index.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);
        $this->loadModel('Vendors');
        $arrVendors = $this->Vendors->find('all', array(
            'conditions' => array('parent_vendor' => $arrLoggedUser['vendor_id']), 'ORDER' => array('vendor_id' => 'DESC')
        ));

        $this->set("arrProductList", $arrVendors);
        $this->set("strVendorHead", $arrLoggedUser['vendor_name']);
        $this->set("arrLoggedUser", $arrLoggedUser);
    }

    public function edituser($intVendorId = "") {
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Vendors');
        if ($this->request->is('Post')) {

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

            if ($intVendorId) {
                if ($arrContentData['Vendors']['vendor_password']) {
                    $boolContentUpdated = $this->Vendors->updateAll(
                            array('vendor_email' => "'" . $arrContentData['Vendors']['vendor_email'] . "'", 'vendor_password' => "'" . $arrContentData['Vendors']['vendor_password'] . "'", 'vendor_password_encrypted' => "'" . $arrContentData['Vendors']['vendor_password_encrypted'] . "'", 'vendor_first_name' => "'" . $arrContentData['Vendors']['vendor_first_name'] . "'", 'vendor_last_name' => "'" . $arrContentData['Vendors']['vendor_last_name'] . "'", 'vendor_phone' => "'" . $arrContentData['Vendors']['vendor_phone'] . "'"), array('vendor_id =' => $intVendorId)
                    );
                } else {
                    $boolContentUpdated = $this->Vendors->updateAll(
                            array('vendor_email' => "'" . $arrContentData['Vendors']['vendor_email'] . "'", 'vendor_first_name' => "'" . $arrContentData['Vendors']['vendor_first_name'] . "'", 'vendor_last_name' => "'" . $arrContentData['Vendors']['vendor_last_name'] . "'", 'vendor_phone' => "'" . $arrContentData['Vendors']['vendor_phone'] . "'"), array('vendor_id =' => $intVendorId)
                    );
                }

                if ($boolContentUpdated) {
                    if ($arrContentData['Vendors']['tonotify']) {
                        $isNotified = $this->fnSendVendorAccountDetails($arrContentData['Vendors']['vendor_name'], $arrContentData['Vendors']['vendor_email'], $arrContentData['Vendors']['vendor_password'], "1");
                        if ($isNotified) {
                            $boolContentUpdated = $this->Vendors->updateAll(
                                    array('notified' => "'1'"), array('vendor_id =' => $intEditModeId)
                            );
                        }
                    }
                    $compMessage = $this->Components->load('Message');
                    $strMessage = "Updation was successfull.";
                    $strForMessage = $compMessage->fnGenerateMessageBlock($strMessage, 'success');
                    $this->set("strForMessage", $strForMessage);
                    
                } else {
//                    $strForMessage = "Some Error, Please try again.";
                    
                    $compMessage = $this->Components->load('Message');
                    $strMessage = "Some Error, Please try again.";
                    $strForMessage = $compMessage->fnGenerateMessageBlock($strMessage, 'error');
                    $this->set("strForMessage", $strForMessage);
                }
                
            }
        }

        $arrVendors = $this->Vendors->find('all', array(
            'conditions' => array('vendor_id' => $intVendorId)
        ));
        $this->set("arrProductList", $arrVendors);
    }

    public function adduser() {
        $arrLoggedUser = $this->Auth->user();
        if ($this->request->is('Post')) {

            $arrContentData['Vendors']['vendor_first_name'] = addslashes(trim($this->request->data['vfname']));
            $arrContentData['Vendors']['vendor_last_name'] = addslashes(trim($this->request->data['vlname']));
            $arrContentData['Vendors']['vendor_phone'] = addslashes(trim($this->request->data['vphone']));
            $arrContentData['Vendors']['vendor_email'] = addslashes($this->request->data['vemail']);
            $arrContentData['Vendors']['vendor_password'] = addslashes($this->request->data['vpass']);
            $arrContentData['Vendors']['vendor_password_encrypted'] = AuthComponent::password($this->request->data['vpass']);
            $arrContentData['Vendors']['parent_vendor'] = $arrLoggedUser['vendor_id'];
            $arrContentData['Vendors']['vendor_active'] = "1";
            $arrContentData['Vendors']['vendor_type'] = "Services";

            $this->loadModel('Vendors');
            $intContentExists = $this->Vendors->find('count', array(
                'conditions' => array('vendor_email' => $arrContentData['Vendors']['vendor_email'])
            ));
            if ($intContentExists) {
//                $compMessage = $this->Components->load('Message');
//                $strForMessage = "This Vendor is already present.";
                
                $compMessage = $this->Components->load('Message');
                $strMessage = "This Vendor is already present.";
                $strForMessage = $compMessage->fnGenerateMessageBlock($strMessage, 'error');
                $this->set("strForMessage", $strForMessage);
            } else {
                $boolContentCreated = $this->Vendors->save($arrContentData);
                if ($boolContentCreated) {
                    $intCreatedContentId = $this->Vendors->getLastInsertID();
                    $arrResponseData['createdid'] = $intCreatedContentId;
                    if ($arrContentData['Vendors']['tonotify']) {
                        $isNotified = $this->fnSendVendorAccountDetails($arrContentData['Vendors']['vendor_name'], $arrContentData['Vendors']['vendor_email'], $arrContentData['Vendors']['vendor_password']);
                        if ($isNotified) {
                            $boolContentUpdated = $this->Vendors->updateAll(
                                    array('notified' => "'1'"), array('vendor_id =' => $intCreatedContentId)
                            );
                        }
                    }
                $compMessage = $this->Components->load('Message');
                $arrResponse['status'] = "success";
                $strMessage = "You have successfully created a user on your account.";
                $strForMessage = $compMessage->fnGenerateMessageBlock($strMessage, 'success');
                $arrResponse['message'] = $strForMessage;
                $this->set("strForMessage", $strForMessage);
                }
            }
            
            
        }
    }

    public function logout($strSwictchBack = "") {
        $this->layout = NULL;
        $this->autoRender = False;
        $arrResponse = array();
        $arrLoggedUser = $this->Auth->user();
        $arrResponse['logoutredirecturl'] = $this->Auth->logout();
        if ($arrResponse['logoutredirecturl']) {
            $arrResponse['logoutredirecturl'] = Router::url(array('controller' => 'vendoraccount', 'action' => 'index'), true);
            $arrResponse['status'] = "success";
            $arrResponse['loggedoutusertype'] = $arrLoggedUser['vendor_type'];
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function login($strSwictchBack = "") {
        if ($this->request->is('post')) {
            $this->loadModel('Vendors');
            $arrPostedData = array();
            $this->request->data['Vendors']['vendor_email'] = addslashes(trim($this->request->data['Vendors']['user_email']));
            $this->request->data['Vendors']['vendor_password_encrypted'] = addslashes(trim($this->request->data['Vendors']['password']));
            $this->Vendors->set($this->request->data);
            if ($this->Auth->login()) {
                $arrLoggedInUser = $this->Auth->user();
                if ($arrLoggedInUser['vendor_active'] == "0") {
                    $this->Auth->logout();
                    $arrResultSet = array();
                    $arrResultSet['status'] = "failure";
                    $arrResultSet['message'] = "Sorry, Your account is not being confirmed yet, Please confirm your account first.";
//                    $this->Session->setFlash('Sorry, Your account is not being confirmed yet, Please confirm your account first.');
                    $this->Session->setFlash('<div class="alert alert-danger">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Sorry, Your account is not being confirmed yet, Please confirm your account first.</div>');
                    echo json_encode($arrResultSet);
                    exit;
                } else {
                    $arrResultSet = array();
                    $arrResultSet['status'] = "success";
                    $arrResultSet['redirecturl'] = Router::url($this->Auth->redirectUrl(), true);
                    $arrResultSet['userid'] = $arrLoggedInUser['vendor_id'];
                    $arrResultSet['username'] = $arrLoggedInUser['vendor_name'];
                    $arrResultSet['useremail'] = $arrLoggedInUser['vendor_email'];
                    $arrResultSet['vendortype'] = $arrLoggedInUser['vendor_type'];
                    $arrResultSet['lmslogin'] = Configure::read('Lms.loginurl');
                    echo json_encode($arrResultSet);
                    exit;
                }
            } else {
                $arrResultSet = array();
                $arrResultSet['status'] = "failure";
                $arrResultSet['message'] = "Your username and password combination was incorrect.";
//                $this->Session->setFlash('Your username and password combination was incorrect');
                $this->Session->setFlash('<div class="alert alert-danger">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Your username and password combination was incorrect.</div>');
                echo json_encode($arrResultSet);
                exit;
            }
        }
    }

    public function forgotpassword() {
        if ($this->request->is('post')) {
            $this->request->data['Vendors']['vendor_email'] = addslashes(trim($this->request->data['User']['user_email']));
            $this->loadModel('Vendors');
            $this->Vendors->set($this->request->data);
            $arrUserExists = $this->Vendors->find('all', array(
                'conditions' => array('vendor_email' => $this->request->data['User']['user_email'])
            ));
            if (is_array($arrUserExists) && (count($arrUserExists) > 0)) {
                $strUsersName = $arrUserExists[0]['Vendors']['vendor_name'];
                $strNewPassword = $this->fnRegeneratePassword($arrUserExists[0]['Vendors']['vendor_id']);
                $boolUpdated = $this->Vendors->updateAll(
                        array('Vendors.vendor_password_encrypted' => "'" . AuthComponent::password($strNewPassword) . "'", 'Vendors.vendor_password' => "'" . $strNewPassword . "'"), array('Vendors.vendor_email =' => $this->request->data['User']['user_email'])
                );
                if ($boolUpdated) {
                    $intMailSent = $this->fnSendPassowordRegenerationMail($strUsersName, $this->request->data['User']['user_email'], $strNewPassword);
                    if ($intMailSent) {
                        $this->Session->setFlash("Congratulation, your Password has been reset, Please check your Mail", 'default', array('class' => 'success'));
                    } else {
                        $this->Session->setFlash("Please try again.");
                    }
                } else {
                    $this->Session->setFlash("Please try again.");
                }
            } else {
                $this->Session->setFlash("In-Correct email address, Account not registered.");
            }
        }
    }

    public function editpayout() {
        $arrLoggedUserDetails = $this->Auth->user();
        $this->loadModel('Vendorpayout');
        $this->loadModel('Vendorcompany');
        $strRegerrorMessage = "";
        if ($this->request->data['bankaccountnumber'] !='' && $this->request->data['bankroutingnumber'] !='' && $this->request->data['taxid'] !='' && $this->request->data['payoutto'] !='') {
            $arrContentData['Vendorpayout']['vendor_id'] = $intEditModeId = $arrLoggedUserDetails['vendor_id'];
            $arrContentData['Vendorpayout']['payout_to'] = addslashes($this->request->data['payoutto']);
            $arrContentData['Vendorpayout']['tax_id'] = addslashes($this->request->data['taxid']);
            $arrContentData['Vendorpayout']['bank_account_number'] = addslashes($this->request->data['bankaccountnumber']);
            $arrContentData['Vendorpayout']['bank_routing_number'] = addslashes($this->request->data['bankroutingnumber']);
            $arrContentData['Vendorpayout']['minimum_check_amt'] = addslashes($this->request->data['minamt']);
            $arrContentData['Vendorpayout']['commission_pct'] = addslashes($this->request->data['compct']);
            $arrContentData['Vendorpayout']['indeed_registration'] = addslashes($this->request->data['inreg']);
//            echo '<pre>';print_r($arrContentData);die;
            $intVendorCompanyExists = $this->Vendorpayout->find('count', array('conditions' => array('vendor_id' => $intEditModeId)));
            if ($intVendorCompanyExists) {
                $this->Vendorpayout->deleteAll(array('Vendorpayout.vendor_id' => $intEditModeId), false);
            }
            $arrCompanyDetailsEntered = $this->Vendorpayout->save($arrContentData);
            if ($arrCompanyDetailsEntered) {
//                $this->Session->setFlash('Vendor Payment Details Saved Successfully!', 'default', array('class' => 'success'));
                $arrViewUserDetail = $this->Vendorcompany->find('all', array('conditions' => array('vendor_id' => $arrLoggedUserDetails['vendor_id'])));
                $view = new View($this, false);
                $view->set('arrCompleteLoggedInUserDetail', $arrViewUserDetail);
                $strWidgetListerHtml = $view->element('vendor_payment');
                $arrResponse['status'] = "success";
                $arrResponse['message'] = '<div class="alert alert-success">
						  <img src="' . Router::url('/', true) . '/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Your Payment Details were saved successfully.</div>';
                $arrResponse['html'] = $strWidgetListerHtml;
            } else {
                $this->Session->setFlash('Please try again');
                $arrResponse['status'] = "fail";

                $arrResponse['message'] = '<div class="alert alert-danger">
						  <img src="' . Router::url('/', true) . '/images/icon-alert-error.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Parameter missing</div>';
            }
        }else{
             $this->Session->setFlash('Parameter missing');
                $arrResponse['status'] = "fail";

                $arrResponse['message'] = '<div class="alert alert-danger">
						  <img src="' . Router::url('/', true) . '/images/icon-alert-error.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Parameter missing</div>';
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function editcompany() {
        $arrLoggedUserDetails = $this->Auth->user();
        $this->loadModel('Vendorcompany');
        $strRegerrorMessage = "";
        if ($this->request->is('post')) {
            $arrContentData['Vendorcompany']['vendor_id'] = $intEditModeId = $arrLoggedUserDetails['vendor_id'];

            $arrContentData['Vendorcompany']['company_name'] = addslashes($this->request->data['vendorcname']);

            $arrContentData['Vendorcompany']['vendor_f_name'] = addslashes($this->request->data['vendorfname']);

            $arrContentData['Vendorcompany']['vendor_l_name'] = addslashes($this->request->data['vendorlname']);

            $arrContentData['Vendorcompany']['vendor_email'] = addslashes($this->request->data['vendorcemail']);

            $arrContentData['Vendorcompany']['address'] = addslashes($this->request->data['vendor_company_address']);

            $arrContentData['Vendorcompany']['zip'] = addslashes($this->request->data['zip']);

            $arrContentData['Vendorcompany']['state'] = addslashes($this->request->data['state']);

            $arrContentData['Vendorcompany']['city'] = addslashes($this->request->data['city']);

            $arrContentData['Vendorcompany']['phone'] = addslashes($this->request->data['phone']);

            $arrContentData['Vendorcompany']['fax'] = addslashes($this->request->data['fax']);

            $arrContentData['Vendorcompany']['web_address'] = addslashes($this->request->data['vendorwaddress']);

            $arrContentData['Vendorcompany']['billing_phone'] = addslashes($this->request->data['vendorbphone']);

            $intVendorCompanyExists = $this->Vendorcompany->find('count', array('conditions' => array('vendor_id' => $intEditModeId)));
            if ($intVendorCompanyExists) {
                $this->Vendorcompany->deleteAll(array('Vendorcompany.vendor_id' => $intEditModeId), false);
            }
            $arrCompanyDetailsEntered = $this->Vendorcompany->save($arrContentData);
            if ($arrCompanyDetailsEntered) {
                $arrViewUserDetail = $this->Vendorcompany->find('all', array('conditions' => array('vendor_id' => $arrLoggedUserDetails['vendor_id'])));
                $arrResponse['status'] = "success";
                $arrResponse['message'] = '<div class="alert alert-success">
						  <img src="' . Router::url('/', true) . '/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Vendor Company Details Updated Successfully</div>';
            } else {
                $arrResponse['status'] = "fail";
                $arrResponse['message'] = '<div class="alert alert-success">
						  <img src="' . Router::url('/', true) . '/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Vendor Company Details Updated Successfully</div>';
            }
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function getcompanyhtml() {
        $arrLoggedUserDetails = $this->Auth->user();
        $this->loadModel('Vendorcompany');
        if ($arrLoggedUserDetails['vendor_id']) {
            $arrViewUserDetail = $this->Vendorcompany->find('all', array('conditions' => array('vendor_id' => $arrLoggedUserDetails['vendor_id'])));
            $view = new View($this, false);
            $view->set('arrCompleteLoggedInUserDetail', $arrViewUserDetail);
            //$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
            //$view->set('arrContactDetail',$arrContactDetail);
            $strWidgetListerHtml = $view->element('vendor_company');
            $arrResponse['status'] = "success";
            $arrResponse['html'] = $strWidgetListerHtml;
        } else {
            $arrResponse['status'] = "fail";
            $arrResponse['message'] = "Parameter missing";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function getPaymenthtml() {
        $arrLoggedUserDetails = $this->Auth->user();
        $this->loadModel('Vendorpayout');
        if ($arrLoggedUserDetails['vendor_id']) {
            $arrViewUserDetail = $this->Vendorpayout->find('all', array('conditions' => array('vendor_id' => $arrLoggedUserDetails['vendor_id'])));
            $view = new View($this, false);
            $view->set('arrCompleteLoggedInUserDetail', $arrViewUserDetail);
            //$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
            //$view->set('arrContactDetail',$arrContactDetail);
            $strWidgetListerHtml = $view->element('vendor_payment');
            $arrResponse['status'] = "success";
            $arrResponse['html'] = $strWidgetListerHtml;
        } else {
            $arrResponse['status'] = "fail";
            $arrResponse['message'] = "Parameter missing";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function edit($type = "") {
        $arrLoggedUserDetails = $this->Auth->user();
        $this->loadModel('Vendors');
        $strRegerrorMessage = "";
        if ($this->request->is('post')) {
            $arrAdminBasicPostedData = array();
            $arrAdminBasicPostedData['vendor_name'] = addslashes(trim($this->request->data['User']['vendorname']));
            $arrAdminBasicPostedData['vendor_first_name'] = addslashes(trim($this->request->data['User']['vendorfname']));
            $arrAdminBasicPostedData['vendor_last_name'] = addslashes(trim($this->request->data['User']['vendorlname']));
            $arrAdminBasicPostedData['vendor_phone'] = addslashes(trim($this->request->data['User']['vendorphone']));
            if ($this->request->data['User']['vendor_pass']) {
                $arrAdminBasicPostedData['vendor_password'] = $this->request->data['User']['vendor_pass'];
                $arrAdminBasicPostedData['vendor_password_encrypted'] = AuthComponent::password($this->request->data['User']['vendor_pass']);
            }
            $this->Vendors->set($arrAdminBasicPostedData);

            if ($this->request->data['User']['vendor_pass']) {





                $boolUpdated = $this->Vendors->updateAll(
                        array('Vendors.vendor_name' => "'" . $arrAdminBasicPostedData['vendor_name'] . "'", 'Vendors.vendor_first_name' => "'" . $arrAdminBasicPostedData['vendor_first_name'] . "'", 'Vendors.vendor_last_name' => "'" . $arrAdminBasicPostedData['vendor_last_name'] . "'", 'Vendors.vendor_phone' => "'" . $arrAdminBasicPostedData['vendor_phone'] . "'", 'Vendors.vendor_password' => "'" . $arrAdminBasicPostedData['vendor_password'] . "'", 'Vendors.vendor_password_encrypted' => "'" . $arrAdminBasicPostedData['vendor_password_encrypted'] . "'"), array('Vendors.vendor_id =' => $arrLoggedUserDetails['vendor_id'])
                );
            } else {

                $boolUpdated = $this->Vendors->updateAll(
                        array('Vendors.vendor_name' => "'" . $arrAdminBasicPostedData['vendor_name'] . "'", 'Vendors.vendor_first_name' => "'" . $arrAdminBasicPostedData['vendor_first_name'] . "'", 'Vendors.vendor_last_name' => "'" . $arrAdminBasicPostedData['vendor_last_name'] . "'", 'Vendors.vendor_phone' => "'" . $arrAdminBasicPostedData['vendor_phone'] . "'"), array('Vendors.vendor_id =' => $arrLoggedUserDetails['vendor_id'])
                );
            }



            if ($boolUpdated) {

                $this->Session->setFlash('<div class="alert alert-success">		  <img src="' . Router::url('/', true) . '/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Profile updated successfully</div>');

                //$this->Session->setFlash('Profile Updated Successfully!','default',array('class' => 'success'));
            } else {

                $this->Session->setFlash('Please try again');
                $this->Session->setFlash('<div class="alert alert-success">
						  <img src="' . Router::url('/', true) . '/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Please try again</div>');
            }
        }





        $arrViewUserDetail = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $arrLoggedUserDetails['vendor_id'])));



        $this->set('arrCompleteLoggedInUserDetail', $arrViewUserDetail);
        $this->set('type', $type);
    }

    public function checkvendorreminders($intPortalId) {
        //Configure::write('debug','2');

        $this->layout = NULL;
        $this->autoRender = false;
        $arrResponse = array();

        $arrLoggedUser = $this->Auth->user();
        $strDate = date('Y-m-d H:i:') . "00";
        $this->loadModel("Notification");

        $intNotifyReadCnt = $this->Notification->find('count', array('conditions' => array('candidate_id' => $arrLoggedUser['vendor_id'], 'notification_read' => '0', 'foruser' => 'owner')));


        $arrNotifications = $this->Notification->find('all', array('conditions' => array('candidate_id' => $arrLoggedUser['vendor_id'], 'notification_read' => '0', 'foruser' => 'owner'), 'order' => array('notification_id' => 'desc'), 'limit' => 2));

        //echo '<pre>';print_r($arrNotifications); exit();
        $strNotificationHtml = '';
        if (is_array($arrNotifications) && (count($arrNotifications) > 0)) {
            $strNotificationHtml = '';
            $this->loadModel('Reminder');
            $this->loadModel('Candidate');
            $this->loadModel('Resourceorderdetail');
            foreach ($arrNotifications as $arrNoti) {
                $notification_read = $arrNoti['Notification']['notification_read'];
                $css = 'color:#000;';
                if ($notification_read > 0) {
                    $css = "";
                }
                if ($arrNoti['Notification']['reminder_type'] == "orderupdate") {

                    $arrVendorNotifications = $this->Resourceorderdetail->find('first', array('conditions' => array('order_detail_id' => $arrNoti['Notification']['reminder_id'])));

                    $arrCandidate = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $arrNoti['Notification']['notification_created_by'])));

                    //print("<pre>");
                    //print_r($arrCandidate);
                    //exit;

                    $linkorder = Router::url(array('controller' => 'vendororders', 'action' => 'orderdetail', $arrNoti['Notification']['reminder_id']), true);

                    $strNotificationHtml .= '<li class="notification-block-bordered" id="notification' . $arrNoti['Notification']['notification_id'] . '">
							<a class="dropdown-item-notification" href="' . $linkorder . '">
								<p style="' . $css . '">Candidate ' . $arrCandidate[0]['Candidate']['candidate_first_name'] . ' ' . $arrCandidate[0]['Candidate']['candidate_last_name'] . '  has updated the order ' . $arrVendorNotifications['Resourceorderdetail']['product_name'] . ' with some details </p>
							</a>
							<a class="close-notification" href="#notification1">
								<img alt="" src="images/icon-delete-notification.png">
							</a>
						</li>';
                }
            }
        }




        if ($strNotificationHtml) {
            $strNotificationHtml .= '<li>
							<a href="#" class="right-top-menu-item">See all notifications</a>
						</li>';
            $arrResponse['notifyhtml'] = $strNotificationHtml;
            $arrResponse['status'] = 'success';
        }
        if ($intNotifyReadCnt) {
            $arrResponse['notifycount'] = $intNotifyReadCnt;
            $arrResponse['status'] = 'success';
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function dashboard() {
//		echo $this->layout;
        $arrLoggedVendor = $this->Auth->user();
        $this->set('arrLoggedVendor', $arrLoggedVendor);
        $this->compTime = $this->Components->load('TimeCalculation');
        $strMonth = $this->compTime->fnFindCurrentMonth();
        $arrNewYear = $this->compTime->fnFindCurrentYear();
        $strDatFormMonthToCompare = $arrNewYear . "-" . $strMonth . "-" . "01 00:00:00";
        $strEndDatFormMonthToCompare = date($arrNewYear . '-' . $strMonth . '-t') . " 23:59:59";
        $this->loadModel('Resourceorderdetail');
        //New order count
        if ($arrLoggedVendor['parent_vendor']) {
            $arrNewOrderCountForMonth = $this->Resourceorderdetail->fnGetSubNewOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        } else {
            $arrNewOrderCountForMonth = $this->Resourceorderdetail->fnGetNewOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        }

        if (is_array($arrNewOrderCountForMonth) && (count($arrNewOrderCountForMonth) > 0)) {
            if ($arrNewOrderCountForMonth[0][0]['count(*)']) {
                $this->set('intPortalCandidates', $arrNewOrderCountForMonth[0][0]['count(*)']);
            }
        }
        //echo $arrNewOrderCountForMonth[0][0]['count(*)'];//exit();
        //$arrNewOrderCountTotal = $this->Resourceorderdetail->fnGetNewOrderCount($arrLoggedVendor['vendor_id']);
        // Closed order count
        if ($arrLoggedVendor['parent_vendor']) {
            $arrClosedOrderCountTotal = $this->Resourceorderdetail->fnGetSubClosedOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        } else {
            $arrClosedOrderCountTotal = $this->Resourceorderdetail->fnGetClosedOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        }
        if (is_array($arrClosedOrderCountTotal) && (count($arrClosedOrderCountTotal) > 0)) {
            if ($arrClosedOrderCountTotal[0][0]['count(*)']) {
                $this->set('intClosedPortalCandidates', $arrClosedOrderCountTotal[0][0]['count(*)']);
            }
        } else {
            $this->set('intClosedPortalCandidates', 0);
        }

        //vendor close order cost
        if ($arrLoggedVendor['parent_vendor']) {
            $arrClosedOrderTotal = $this->Resourceorderdetail->fnGetSubClosedOrderCost($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        } else {
            $arrClosedOrderTotal = $this->Resourceorderdetail->fnGetClosedOrderCost($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        }

        if (is_array($arrClosedOrderTotal) && (count($arrClosedOrderTotal) > 0)) {
            if ($arrClosedOrderTotal[0][0]['sum(vendor_cost)']) {
                $this->set('intClosedOrderTotal', $arrClosedOrderTotal[0][0]['sum(vendor_cost)']);
            }
        } else {
            $this->set('intClosedOrderTotal', 0);
        }

        // vendor refund orders
        if ($arrLoggedVendor['parent_vendor']) {
            $arrRefundOrderTotal = $this->Resourceorderdetail->fnGetSubRefundOrderCost($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        } else {
            $arrRefundOrderTotal = $this->Resourceorderdetail->fnGetRefundOrderCost($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        }

        if (is_array($arrRefundOrderTotal) && (count($arrRefundOrderTotal) > 0)) {
            if ($arrRefundOrderTotal[0][0]['sum(vendor_cost)']) {
                $this->set('intRefundOrderTotal', $arrRefundOrderTotal[0][0]['sum(vendor_cost)']);
            }
        } else {
            $this->set('intRefundOrderTotal', 0);
        }

        // vendor open orders
        if ($arrLoggedVendor['parent_vendor']) {
            $arrOpenOrderCountTotal = $this->Resourceorderdetail->fnGetSubOpenOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        } else {
            $arrOpenOrderCountTotal = $this->Resourceorderdetail->fnGetOpenOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        }

        if (is_array($arrOpenOrderCountTotal) && (count($arrOpenOrderCountTotal) > 0)) {
            if ($arrOpenOrderCountTotal[0][0]['count(*)']) {
                $this->set('intOpenPortalCandidates', $arrOpenOrderCountTotal[0][0]['count(*)']);
            }
        } else {
            $this->set('intOpenPortalCandidates', 0);
        }
        //echo $arrOpenOrderCountTotal[0][0]['count(*)'];exit();
        // vendor pending orders
        if ($arrLoggedVendor['parent_vendor']) {
            $arrPendingOrderCountTotal = $this->Resourceorderdetail->fnGetSubPendingOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        } else {
            $arrPendingOrderCountTotal = $this->Resourceorderdetail->fnGetPendingOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        }

        if (is_array($arrPendingOrderCountTotal) && (count($arrPendingOrderCountTotal) > 0)) {
            if ($arrPendingOrderCountTotal[0][0]['count(*)']) {
                $this->set('intPendingPortalCandidates', $arrPendingOrderCountTotal[0][0]['count(*)']);
            }
        } else {
            $this->set('intPendingPortalCandidates', 0);
        }
    }

    public function getVendorOrderCountHtml($selectedText, $reviewtype, $strStartDate = "", $strEndDate = "") {

        $arrLoggedVendor = $this->Auth->user();

        $this->compTime = $this->Components->load('TimeCalculation');



        //$strMonth = $this->compTime->fnFindCurrentMonth();
        $strMonth = $this->compTime->fnFindLastMonth();

        $arrNewYear = $this->compTime->fnFindCurrentYear();


        if ($selectedText == "month") {
            $strDatFormMonthToCompare = $arrNewYear . "-" . $strMonth . "-" . "01 00:00:00";
            //echo "--".$strEndDatFormMonthToCompare = date("",$arrNewYear.'-'.$strMonth.'-t')." 23:59:59";
            $strEndDatFormMonthToCompare = date("Y-m-d", strtotime('last day of last month')) . " 23:59:59";
        }
        if ($selectedText == "year") {
            $arrNewYear = $this->compTime->fnFindLastYear();
            $strDatFormMonthToCompare = $arrNewYear . "-01-" . "01 00:00:00";
            $strEndDatFormMonthToCompare = $arrNewYear . "-12-" . "31 23:59:59";
        }
        if ($selectedText == "day") {
            $strDatFormMonthToCompare = date('Y-m-d', strtotime(' -1 day')) . " 00:00:00";
            $strEndDatFormMonthToCompare = date('Y-m-d', strtotime(' -1 day')) . " 23:59:59";
        }
        if ($selectedText == "week") {
            $previous_week = strtotime("-1 week +1 day");

            $start_week = strtotime("last sunday midnight", $previous_week);
            $end_week = strtotime("next saturday", $start_week);

            $start_week = date("Y-m-d", $start_week);
            $end_week = date("Y-m-d", $end_week);

            $strDatFormMonthToCompare = $start_week . " 00:00:00";
            $strEndDatFormMonthToCompare = $end_week . " 23:59:59";
        }

        if ($selectedText == "custom") {

            $strDatFormMonthToCompare = date("Y-m-d", strtotime($strStartDate)) . " 00:00:00";
            $strEndDatFormMonthToCompare = date("Y-m-d", strtotime($strEndDate)) . " 23:59:59";
        }

        //echo "--".$strDatFormMonthToCompare;
        //echo "--".$strEndDatFormMonthToCompare;exit;


        $view = new View($this, false);



        $this->loadModel('Resourceorderdetail');
        //New order count
        if ($arrLoggedVendor['parent_vendor']) {
            $arrNewOrderCountForMonth = $this->Resourceorderdetail->fnGetSubNewOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        } else {
            $arrNewOrderCountForMonth = $this->Resourceorderdetail->fnGetNewOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        }

        if (is_array($arrNewOrderCountForMonth) && (count($arrNewOrderCountForMonth) > 0)) {
            if ($arrNewOrderCountForMonth[0][0]['count(*)']) {
                $view->set('intPortalCandidates', $arrNewOrderCountForMonth[0][0]['count(*)']);
            }
        }
        //echo $arrNewOrderCountForMonth[0][0]['count(*)'];//exit();
        //$arrNewOrderCountTotal = $this->Resourceorderdetail->fnGetNewOrderCount($arrLoggedVendor['vendor_id']);
        // Closed order count
        if ($arrLoggedVendor['parent_vendor']) {
            $arrClosedOrderCountTotal = $this->Resourceorderdetail->fnGetSubClosedOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        } else {
            $arrClosedOrderCountTotal = $this->Resourceorderdetail->fnGetClosedOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        }
        if (is_array($arrClosedOrderCountTotal) && (count($arrClosedOrderCountTotal) > 0)) {
            if ($arrClosedOrderCountTotal[0][0]['count(*)']) {
                $view->set('intClosedPortalCandidates', $arrClosedOrderCountTotal[0][0]['count(*)']);
            }
        } else {
            $view->set('intClosedPortalCandidates', 0);
        }

        //vendor close order cost
        if ($arrLoggedVendor['parent_vendor']) {
            $arrClosedOrderTotal = $this->Resourceorderdetail->fnGetSubClosedOrderCost($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        } else {
            $arrClosedOrderTotal = $this->Resourceorderdetail->fnGetClosedOrderCost($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        }

        if (is_array($arrClosedOrderTotal) && (count($arrClosedOrderTotal) > 0)) {
            if ($arrClosedOrderTotal[0][0]['sum(vendor_cost)']) {
                $view->set('intClosedOrderTotal', $arrClosedOrderTotal[0][0]['sum(vendor_cost)']);
            }
        } else {
            $view->set('intClosedOrderTotal', 0);
        }

        // vendor refund orders
        if ($arrLoggedVendor['parent_vendor']) {
            $arrRefundOrderTotal = $this->Resourceorderdetail->fnGetSubRefundOrderCost($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        } else {
            $arrRefundOrderTotal = $this->Resourceorderdetail->fnGetRefundOrderCost($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        }

        if (is_array($arrRefundOrderTotal) && (count($arrRefundOrderTotal) > 0)) {
            if ($arrRefundOrderTotal[0][0]['sum(vendor_cost)']) {
                $view->set('intRefundOrderTotal', $arrRefundOrderTotal[0][0]['sum(vendor_cost)']);
            }
        } else {
            $view->set('intRefundOrderTotal', 0);
        }

        // vendor open orders
        if ($arrLoggedVendor['parent_vendor']) {
            $arrOpenOrderCountTotal = $this->Resourceorderdetail->fnGetSubOpenOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        } else {
            $arrOpenOrderCountTotal = $this->Resourceorderdetail->fnGetOpenOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        }

        if (is_array($arrOpenOrderCountTotal) && (count($arrOpenOrderCountTotal) > 0)) {
            if ($arrOpenOrderCountTotal[0][0]['count(*)']) {
                $view->set('intOpenPortalCandidates', $arrOpenOrderCountTotal[0][0]['count(*)']);
            }
        } else {
            $view->set('intOpenPortalCandidates', 0);
        }
        //echo $arrOpenOrderCountTotal[0][0]['count(*)'];exit();
        // vendor pending orders
        if ($arrLoggedVendor['parent_vendor']) {
            $arrPendingOrderCountTotal = $this->Resourceorderdetail->fnGetSubPendingOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        } else {
            $arrPendingOrderCountTotal = $this->Resourceorderdetail->fnGetPendingOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);
        }

        if (is_array($arrPendingOrderCountTotal) && (count($arrPendingOrderCountTotal) > 0)) {
            if ($arrPendingOrderCountTotal[0][0]['count(*)']) {
                $view->set('intPendingPortalCandidates', $arrPendingOrderCountTotal[0][0]['count(*)']);
            }
        } else {
            $view->set('intPendingPortalCandidates', 0);
        }


        if ($reviewtype == 'Order') {
            $strWidgetListerHtml = $view->element('vendor_chart');
        } else {
            $strWidgetListerHtml = $view->element('vendor_revenue');
        }
        $arrResponse['status'] = "success";
        $arrResponse['html'] = $strWidgetListerHtml;
        echo json_encode($arrResponse);
        exit;
    }

    public function changepassword() {

        if ($this->request->is('post')) {

            $this->loadModel('User');

            $arrPostedData = array();

            $this->request->data['User']['pass'] = addslashes(trim($this->request->data['User']['new_password']));

            $this->request->data['User']['confirm_pass'] = addslashes(trim($this->request->data['User']['new_password_again']));

            $this->request->data['User']['old_pass'] = addslashes(trim($this->request->data['User']['old_pass']));

            $arrCurrentUser = $this->Auth->user();



            $this->User->set($this->request->data);

            if ($this->User->validates()) {

                if ($this->request->data['User']['pass'] == $this->request->data['User']['confirm_pass']) {

                    $intUserExists = $this->User->find('count', array(
                        'conditions' => array('id' => $arrCurrentUser['id'], 'pass' => AuthComponent::password($this->request->data['User']['old_pass']))
                    ));

                    if ($intUserExists) {

                        $boolUpdated = $this->User->updateAll(
                                array('User.pass' => "'" . AuthComponent::password($this->request->data['User']['pass']) . "'"), array('User.id =' => $arrCurrentUser['id'])
                        );

                        if ($boolUpdated) {

                            $this->Session->setFlash("Your Password has been Changed", 'default', array('class' => 'success'));
                        } else {

                            $this->Session->setFlash("Please try again");
                        }
                    } else {

                        $this->Session->setFlash("Please provide correct Old Password");
                    }
                } else {

                    $this->Session->setFlash("Your New Password does not match");
                }
            } else {

                $errors = $this->User->invalidFields();

                $strErrorMessage = "";

                if (is_array($errors) && (count($errors) > 0)) {

                    $intForIterateCount = 0;

                    foreach ($errors as $errorVal) {

                        $intForIterateCount++;

                        if ($intForIterateCount == 1) {

                            $strErrorMessage .= "Error: " . $errorVal['0'];
                        } else {

                            $strErrorMessage .= "<br> Error: " . $errorVal['0'];
                        }
                    }

                    $this->Session->setFlash($strErrorMessage);
                }
            }
        }
    }

    //Send password to sub vendor
    public function sendpassnotification($intVendorId = "") {
        $arrResponse = array();
        $this->autoRender = false;
        $this->layout = NULL;
        $this->loadModel('Vendors');
        $compMessage = $this->Components->load('Message');
        if ($intVendorId) {
            $arrVendorDetail = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $intVendorId)));
            if (is_array($arrVendorDetail) && (count($arrVendorDetail) > 0)) {
                $strPass = $arrVendorDetail[0]['Vendors']['vendor_password'];
                $strUserName = $arrVendorDetail[0]['Vendors']['vendor_name'];
                $strToEmail = $arrVendorDetail[0]['Vendors']['vendor_email'];

                if ($strPass) {
                    $strPasswordSent = $this->fnSendSubVendorPass($strUserName, $strToEmail, $strPass);
                    if ($strPasswordSent) {
                        $arrResponse['status'] = "success";
                        $strForMessage = "Notification for password was sent successfully.";
                        $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'success');
                        $arrResponse['message'] = $strMessage;
                    } else {
                        $arrResponse['status'] = "fail";
                        $strForMessage = "There seems to be some problem, Please try again";
                        $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'error');
                        $arrResponse['message'] = $strMessage;
                    }
                } else {
                    $arrResponse['status'] = "fail";
                    $strForMessage = "There is no such vendor password provided";
                    $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'error');
                    $arrResponse['message'] = $strMessage;
                }
            } else {
                $arrResponse['status'] = "fail";
                $strForMessage = "There is no such vendor Please try again";
                $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'error');
                $arrResponse['message'] = $strMessage;
            }
        } else {
            $arrResponse['status'] = "fail";
            $strForMessage = "Paramenter missing, Please try again or contact administrator";
            $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'error');
            $arrResponse['message'] = $strMessage;
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function contactus() {

        $arrCurrentUser = $this->Auth->user();
        $this->set('arrLoggedInUserDetail', $arrCurrentUser);
        if ($this->request->is('Post')) {
            $arrContactDetail = array();
            $arrContactDetail['name'] = $this->request->data['name'];
            $arrContactDetail['email'] = $this->request->data['email'];
            $arrContactDetail['message'] = $this->request->data['message'];
            $arrContactDetail['subject'] = $this->request->data['subject'];
            $isSent = $this->fnSendAdminVendorContactusEmail($arrContactDetail);
//            print_r($isSent);die;
            if ($isSent) {
                $strMssg = "Your request was sent. We will get back to you soon";
                $strMssgClass = "alert-success";
            } else {
                $strMssg = "Some issues, Please try again.";
                $strMssgClass = "alert-error";
            }
            $this->set('strMssg', $strMssg);
            $this->set('strMssgClass', $strMssgClass);
        }
    }
    
    public function library()
    {
            $this->loadModel('Categories');
            $arrLibCatDetail = $this->Categories->find('all',array('conditions'=>array('content_cat_for_user'=>'5','job_search_category'=>'0')));
            $this->set('arrLibCatDetail',$arrLibCatDetail);
    }
    
    public function libcatdetail($intCatDetailId = "")
    {
        $this->layout = "vendors";
            $arrContentType = array("1"=>"article","2"=>"webinars");
            $intUserType = "5";
            $intContentType = "1";
            $this->set('intCatDetailId',$intCatDetailId);
            $this->loadModel('Categories');
            $arrCatDetail = $this->Categories->find('all',array('conditions'=>array('content_category_id'=>$intCatDetailId,'content_cat_for_user'=>$intUserType)));

            $this->loadModel('Content');
            $arrCatContentTitles = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>array('content_default_category'=>$intCatDetailId),"ORDER"=>array('content_id'=>"ASC")));
            if(is_array($arrCatContentTitles) && (count($arrCatContentTitles)>0))
            {
                    $arrCatContentTitlesSub = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>array('content_parent_id'=>key($arrCatContentTitles)),"ORDER"=>array('content_id'=>"ASC")));

                    $arrCatContentTitles = $arrCatContentTitles + $arrCatContentTitlesSub;

                    $arrCatContent = $this->Content->find('all',array('fields'=>array('content_id','content_title_alias','content'),'conditions'=>array('content_default_category'=>$intCatDetailId),"ORDER"=>array('content_id'=>"ASC")));
                    //echo $arrCatContent[0]['Content']['content_id'];exit;

                    $arrCatContentSub = $this->Content->find('all',array('fields'=>array('content_id','content_title_alias','content'),'conditions'=>array('content_parent_id'=>$arrCatContent[0]['Content']['content_id']),"ORDER"=>array('content_id'=>"ASC")));
                    $arrCatContent = array_merge($arrCatContent,$arrCatContentSub);

                    $this->set('arrCatContentTitles',$arrCatContentTitles);			
                    $this->set('arrCatContent',$arrCatContent);
                    $this->set('arrLibCatDetail',$arrCatDetail);
            }

            $arrContentTypeList = $this->Content->fnGetDistinctContentType($intCatDetailId,$intUserType);
            $this->set('arrContentTypeList',$arrContentTypeList);
            $this->set('arrContentType',$arrContentType);
            $arrContentListArticle = $this->Content->fnGetContentList($intCatDetailId,$intContentType,$intUserType);
            $this->set('arrContentListArticle',$arrContentListArticle);
            $this->set('strArticleDetailUrl',Router::url(array('controller'=>'privatelabelsites','action'=>'articledetail'),true));
    }
}
