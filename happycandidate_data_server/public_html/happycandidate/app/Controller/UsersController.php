<?php

class UsersController extends AppController {

    var $helpers = array('Html', 'Form');
    var $name = 'Users';

    //var $layout = 'register';

    public function beforeFilter() {
        //$this->Auth->autoRedirect = false;
        parent::beforeFilter();
        $this->Auth->allow('index', 'testemail', 'confirmation', 'forgotpassword', 'ownerregistration', 'login');
    }

    public function logout($strSwictchBack = "") {
        if ($strSwictchBack) {
            $strUrlToGo = $_SESSION['switchurltogo'] . "/1";
            $this->Auth->logout();
            $this->redirect($strUrlToGo);
        } else {
            $this->redirect($this->Auth->logout());
        }
    }

    public function login($strSwictchBack = "") {
        $this->loadModel('User');
        $this->loadModel('Employer');
        $arrPostedData = array();
        
        
        $this->request->data['User']['email'] = addslashes(trim($this->request->data['User']['user_email']));
        $this->request->data['User']['pass'] = addslashes(trim($this->request->data['User']['password']));
        //AuthComponent::password('tejswini');
        $intUserType = addslashes(trim($this->request->data['User']['u_type']));

        $this->User->set($this->request->data);

        if ($this->User->validates()) {
            //debug($this->Auth->login()); die();
            if ($this->Auth->login()) {
                $arrLoggedInUser = $this->Auth->user();
                
                if ($arrLoggedInUser['user_type'] == $intUserType) {
                    if ($arrLoggedInUser['user_confirmed'] == "0") {
                        $this->Auth->logout();
                        $arrResultSet = array();

                        $compMessage = $this->Components->load('Message');
                        $strForMessage = "<div class='alert alert-danger'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-error.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a>Sorry, Your account is not being confirmed yet, Please confirm your account first.</div>";
                        $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'alert-danger');
                        $arrResultSet['message'] = $strForMessage;
                        $arrResultSet['status'] = 'failure';

                        echo json_encode($arrResultSet);
                        exit;

                        /* $this->Session->setFlash('Sorry, Your account is not being confirmed yet, Please confirm your account first.');
                          $this->redirect(array('controller'=>'users','action'=>'login')); */
                    } else {
                        $strEmail = $arrLoggedInUser['email'];
                        $strSubscriptionUrl = Router::url(array('controller' => 'employers', 'action' => 'subscriptionactivation', $strEmail), true);
                       
                        if ($arrLoggedInUser['is_active'] == "0") {
                            $this->Auth->logout();
                            $arrResultSet = array();
                            $compMessage = $this->Components->load('Message');
                            $strForMessage = "<div class='alert alert-danger'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-error.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> Sorry, Your account subcription plan is not activated, Please go ahead with your subcription activation first</p><p>You can go ahead with your subscription, by clicking on this <a href='" . $strSubscriptionUrl . "'>link </a></div>";
                            $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'alert-danger');
                            $arrResultSet['message'] = $strForMessage;
                            $arrResultSet['status'] = 'failure';
                            echo json_encode($arrResultSet);
                            exit;
                        } else {
                            
                            $arrResultSet = array();
                            if ($intUserType == "2") {
                                $compInfusionSoft = $this->Components->load('Infusionsoft'); //load it
                                $strCurrentDate = strtotime(date("Y-m-d H:i:s"));
                                //$strCurrentDate = strtotime("2016-08-30 00:00:00");
                                $arrLoggedUserSubsDetails = $this->User->find('all', array('conditions' => array('id' => $arrLoggedInUser['id'])));
                                $intOrderId = $arrLoggedUserSubsDetails[0]['User']['owner_order_id'];
                                if ($arrLoggedUserSubsDetails[0]['User']['owner_subcription_expiry_date']) {
                                    $strExpiryDateTime = strtotime($arrLoggedUserSubsDetails[0]['User']['owner_subcription_expiry_date']);
                                    if ($strCurrentDate >= $strExpiryDateTime) {
                                        //$arrExpiryDate = $compInfusionSoft->fnGetSubscriptionExpiryDate($intOrderId);
                                        $arrExpiryDate = $compInfusionSoft->fnGetSubscriptionExpiryInformation($intOrderId, $arrLoggedUserSubsDetails[0]['User']['owner_contact_id']);
                                        if ($arrExpiryDate) {
                                            $strExpiryDate = date("Y-m-d", strtotime($arrExpiryDate));
                                            $boolUpdated = $this->User->updateAll(
                                                    array('User.owner_subcription_expiry_date' => "'" . $strExpiryDate . " 00:00:00'"), array('User.id =' => $arrLoggedInUser['id'])
                                            );
                                             
                                            if ($strCurrentDate >= strtotime($strExpiryDate)) {
                                                // expired
                                                $boolUpdated = $this->User->updateAll(
                                                        array('User.is_active' => "'0'"), array('User.id =' => $arrLoggedInUser['id'])
                                                );
                                                $this->Auth->logout();
                                                $compMessage = $this->Components->load('Message');
                                                $strForMessage = "<div class='alert alert-danger'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-error.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> Your account subscription has been expired, you need to renew your subscription, Please go ahead with your subscription activation <a href='" . $strSubscriptionUrl . "'>link </a></div>";
                                                $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'alert-danger');
                                                $arrResultSet['message'] = $strForMessage;
                                                $arrResultSet['status'] = 'failure';
                                            } else {
                                                $arrResultSet['status'] = "success";
                                                $boolUpdated = $this->User->updateAll(
                                                        array('User.is_active' => "'1'"), array('User.id =' => $arrLoggedInUser['id'])
                                                );
                                            }
                                        } else {
                                            $this->Auth->logout();
                                            $compMessage = $this->Components->load('Message');
                                            $strForMessage = "<div class='alert alert-danger'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-error.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> Your account subscription has been expired, you need to renew your subscription.</div>";
                                            $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'alert-danger');
                                            $arrResultSet['message'] = $strForMessage;
                                            $arrResultSet['status'] = 'failure';
                                        }
                                    } else {
                                        $arrResultSet['status'] = "success";
                                    }
                                } else {
                                    //$arrExpiryDate = $compInfusionSoft->fnGetSubscriptionExpiryDate($intOrderId);
                                    $arrExpiryDate = $compInfusionSoft->fnGetSubscriptionExpiryInformation($intOrderId, $arrLoggedUserSubsDetails[0]['User']['owner_contact_id']);

                                    if ($arrExpiryDate) {
                                        $strExpiryDate = date("Y-m-d", strtotime($arrExpiryDate));
                                        $boolUpdated = $this->User->updateAll(
                                                array('User.owner_subcription_expiry_date' => "'" . $strExpiryDate . " 00:00:00'"), array('User.id =' => $arrLoggedInUser['id'])
                                        );
                                        if ($strCurrentDate >= strtotime($strExpiryDate)) {
                                            // expired
                                            $this->Auth->logout();
//                                            $arrResultSet['status'] = "failure";
//                                            $arrResultSet['message'] = "Your account subscription has been expired, you need to renew your subscription, Please go ahead with your subscription activation <a href='" . $strSubscriptionUrl . "'>link </a>";
                                            $compMessage = $this->Components->load('Message');
                                            $strForMessage = "<div class='alert alert-danger'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-error.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> Your account subscription has been expired, you need to renew your subscription, Please go ahead with your subscription activation <a href='" . $strSubscriptionUrl . "'>link </a></div>";
                                            $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'alert-danger');
                                            $arrResultSet['message'] = $strForMessage;
                                            $arrResultSet['status'] = 'failure';

                                            $boolUpdated = $this->User->updateAll(
                                                    array('User.owner_subcription_expiry_date' => "'" . $strExpiryDate . " 00:00:00'", 'User.is_active' => "'0'"), array('User.id =' => $arrLoggedInUser['id'])
                                            );
                                        } else {
                                            $arrResultSet['status'] = "success";
                                            $boolUpdated = $this->User->updateAll(
                                                    array('User.is_active' => "'1'"), array('User.id =' => $arrLoggedInUser['id'])
                                            );
                                        }
                                    } else {
                                        $this->Auth->logout();
                                        $compMessage = $this->Components->load('Message');
                                        $strForMessage = "<div class='alert alert-danger'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-error.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> Your account subscription has been expired, you need to renew your subscription.</div>";
                                        $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'alert-danger');
                                        $arrResultSet['message'] = $strForMessage;
                                        $arrResultSet['status'] = 'failure';
                                    }
                                    $strExpiryDateTime = strtotime($arrExpiryDate);
                                }
                            } else {
                                $arrResultSet['status'] = "success";
                            }

                            if ($arrResultSet['status'] == "success") {
                                $arrEmployerDetails = $this->Employer->find('all', array('conditions' => array('employer_id' => $arrLoggedInUser['id'])));
                                unset($_SESSION['infu_email']);
                                unset($_SESSION['infu_pass']);
                                
                                if ($strSwictchBack) {
                                    if ($strSwictchBack == "loginas") {
                                        $arrResultSet['redirecturl'] = Router::url($this->Auth->redirectUrl(), true);
                                    } else {
                                        unset($_SESSION['olduser']);
                                        $arrResultSet['redirecturl'] = $_SESSION['camefrom'];
                                    }
                                } else {
                                    if ($arrEmployerDetails[0]['Employer']['is_wizard'] == "0") {
                                        $strwizardsetupUrl = Router::url(array('controller' => 'employers', 'action' => 'wizard_setup'), true);
                                        $arrResultSet['redirecturl'] = $strwizardsetupUrl;
                                    } else {
                                        
                                        $arrResultSet['redirecturl'] = Router::url($this->Auth->redirectUrl(), true);
                                        
                                    }
                                }
                                $arrResultSet['userid'] = $arrLoggedInUser['id'];
                                $arrResultSet['username'] = $arrLoggedInUser['username'];
                                $arrResultSet['useremail'] = $arrLoggedInUser['email'];
                            }
                            echo json_encode($arrResultSet);
                            exit;
                            //$this->redirect($this->Auth->redirectUrl());
                        }
                    }
                } else {
                    $this->Auth->logout();
                    $arrResultSet = array();
                    $compMessage = $this->Components->load('Message');
                    $strForMessage = "<div class='alert alert-danger'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-error.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> You cannot login from this Panel.</div>";
                    $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'alert-danger');
                    $arrResultSet['message'] = $strForMessage;
                    $arrResultSet['status'] = 'failure';
                    echo json_encode($arrResultSet);
                    exit;
                }
            } else {
                $arrResultSet = array();
                $compMessage = $this->Components->load('Message');
                $strForMessage = "<div class='alert alert-danger'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-error.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> Your username and password combination was incorrect.</div>";
                $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'alert-danger');
                $arrResultSet['message'] = $strForMessage;
                $arrResultSet['status'] = 'failure';
                echo json_encode($arrResultSet);
                exit;
            }
        } else {
            $errors = $this->User->invalidFields();
            $strLoginerrorMessage = "";
            if (is_array($errors) && (count($errors) > 0)) {
                $intForIterateCount = 0;
                foreach ($errors as $errorVal) {
                    $intForIterateCount++;
                    if ($intForIterateCount == 1) {
                        $strLoginerrorMessage .= "Error: " . $errorVal['0'];
                    } else {
                        $strLoginerrorMessage .= "<br> Error: " . $errorVal['0'];
                    }
                }
//                $this->Session->setFlash($strLoginerrorMessage);
                $arrResultSet = array();
//                $arrResultSet['status'] = "failure";
//                $arrResultSet['message'] = $strLoginerrorMessage;

                $compMessage = $this->Components->load('Message');
                $strForMessage = "<div class='alert alert-danger'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-error.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> '" . $strLoginerrorMessage . "'</div>";
                $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'alert-danger');
                $arrResultSet['message'] = $strLoginerrorMessage;
                $arrResultSet['status'] = 'failure';

                echo json_encode($arrResultSet);
                exit;
            }
        }
        
        
        //$this->redirect(array('controller'=>'home','action'=>'index'));
        //}
    }

    public function index() {
        //$this->redirect('login');
    }

    public function edit() {
        
    }

    public function register() {
        $this->autoRender = false;
        if (isset($_GET['subs'])) {
            $this->Session->write('current_chosen_subscritopn', $_GET['subs']);
        }

        if ($this->request->is('post')) {
            $arrPostedData = array();
            $arrPostedData['username'] = addslashes(trim($this->request->data['User']['user_name']));
            $arrPostedData['email'] = addslashes(trim($this->request->data['User']['user_email']));
            $arrPostedData['pass'] = addslashes(trim(AuthComponent::password($this->request->data['User']['user_pass'])));
            //$arrPostedData['cpass'] = addslashes(trim($this->request->data['User']['password_confirm']));
            $arrPostedData['user_type'] = addslashes(trim($this->request->data['User']['u_type']));
            $arrPostedData['captcha'] = addslashes(trim($this->request->data['User']['captcha']));
            if (($this->Session->check("current_chosen_subscritopn")) && ($this->Session->read('current_chosen_subscritopn') != "0")) {
                $arrPostedData['owner_chosen_subscription_plan'] = $this->Session->read('current_chosen_subscritopn');
                $this->Session->write('current_chosen_subscritopn', "0");
            } else {
                $arrPostedData['owner_chosen_subscription_plan'] = "year";
            }



            $this->loadModel('User');
            if (!isset($this->Captcha)) {
                //if Component was not loaded throug $components array()
                $this->Captcha = $this->Components->load('Captcha'); //load it
            }
            $this->User->setCaptcha($this->Captcha->getVerCode()); //getting from component and passing to model to make proper validation check
            $this->User->set($arrPostedData);

            if ($this->User->validates()) {
                $intUserCreated = $this->User->find('count', array(
                    'conditions' => array('email' => $arrPostedData['email'], 'user_type' => $arrPostedData['user_type'])
                ));
                //$intUserCreated = $this->User->fnCheckUserAccountExists($arrPostedData['email']);
                if ($intUserCreated) {
                    $this->Session->setFlash('User account has been already created');
                } else {
                    $arrPostedData['pass_dec'] = $arrPostedData['pass'];
                    $arrPostedData['pass'] = AuthComponent::password($this->request->data['User']['user_pass']);
                    if ($this->User->save($arrPostedData)) {
                        $intLastUserInsertedId = $this->User->getInsertID();
                        $this->loadModel('Employer');
                        $arrEmployerDetailPostedData['employer_user_fname'] = $arrPostedData['username'];
                        $arrEmployerDetailPostedData['employer_id'] = $intLastUserInsertedId;
                        $intBoolNewEmployerInserted = $this->Employer->save($arrEmployerDetailPostedData);

                        $boolRegistrationMail = $this->fnSendRegistrationEmail($arrPostedData['username'], $arrPostedData['email'], $intLastUserInsertedId);
                        if ($boolRegistrationMail) {
                            $boolUpdated = $this->User->updateAll(
                                    array('User.user_confirmation_mail_sent' => "'1'"), array('User.id =' => $intLastUserInsertedId)
                            );
                        }
                        $this->Session->setFlash('You have been registered successfully with us, please check you mail for further steps', 'default', array('class' => 'success'));
                    }
                    //$this->redirect(array('controller'=>'employers','action'=>'subscriptionactivation',$arrPostedData['email']));
                }
            } else {
                $errors = $this->User->invalidFields();
                $strRegerrorMessage = "";
                if (is_array($errors) && (count($errors) > 0)) {
                    foreach ($errors as $errorVal) {
                        $strRegerrorMessage .= "<br> Error: " . $errorVal['0'];
                    }

                    $this->Session->setFlash($strRegerrorMessage);
                }
            }
        }
        $this->redirect(array('controller' => 'employers', 'action' => 'index'));
    }

    public function ownerregistration() {
        $this->layout = "employers";
        
        $strEmail = "";
        if (isset($_GET['inf_field_Email'])) {
            $arrPostedData['email'] = $strEmail = $_GET['inf_field_Email'];
        } else {
            if (isset($_POST['inf_field_Email'])) {
                $arrPostedData['email'] = $strEmail = $_POST['inf_field_Email'];
            }
        }

        if (isset($_GET['orderId'])) {
            $intOrderId = $_GET['orderId'];
        } else {
            if (isset($_POST['orderId'])) {
                $intOrderId = $_POST['orderId'];
            }
        }

        if ($strEmail) {
            $arrPostedData['username'] = $arrPostedData['email'];
            $arrPostedData['user_type'] = "2";
            $this->loadModel('User');
            $this->User->set($arrPostedData);

            if ($this->User->validates()) {
                
                $arrUserCreated = $this->User->find('all', array(
                    'conditions' => array('email' => $arrPostedData['email'], 'user_type' => $arrPostedData['user_type'])
                ));
               
                //$intUserCreated = $this->User->fnCheckUserAccountExists($arrPostedData['email']);
                if (is_array($arrUserCreated) && (count($arrUserCreated) > 0)) {
                    if ($arrUserCreated[0]['User']['is_active'] == "1") {
                        $this->Session->setFlash('Your subscription is active, you can login and access your account', 'default', array('class' => 'success'),'success');
                    } else {
                        $arrResultSet = array();
                        $compInfusionSoft = $this->Components->load('Infusionsoft'); //load it
                        $arrOrderDetail = $compInfusionSoft->fnGetOrderDetail($intOrderId);
                         
                        if (is_array($arrOrderDetail) && (count($arrOrderDetail) > 0)) {
                            $intContactId = $arrOrderDetail[0]['ContactId'];
                            //echo "---".$arrOrderDetail[0]['StartDate'];exit;

                            $strSTartDate = date("Y-m-d H:i:s", strtotime($arrOrderDetail[0]['StartDate']));
                            $strAddDate = "+1 years";
                            if ($arrUserCreated[0]['User']['owner_chosen_subscription_plan'] == "month") {
                                $strAddDate = "+1 months";
                            }

                            $strExpiryDate = date("Y-m-d H:i:s", strtotime($strAddDate, strtotime($strSTartDate)));
                        }

                        /* $boolUpdated = $this->User->updateAll(
                          array('User.is_active' => "'1'","User.owner_contact_id" => "'".$intContactId."'","User.owner_order_id" => "'".$intOrderId."'","User.owner_subcription_expiry_date"=>"'".$strExpiryDate."'"),
                          array('User.email =' => $arrPostedData['email'])
                          ); */

                        $boolUpdated = $this->User->updateAll(
                                array('User.is_active' => "'1'", "User.owner_contact_id" => "'" . $intContactId . "'", "User.owner_order_id" => "'" . $intOrderId . "'"), array('User.email =' => $arrPostedData['email'])
                        );

                        if ($boolUpdated) {
                            $this->Session->setFlash('Your subscription has been turned active, you can now login and have access to your account', 'default', array('class' => 'success'),'success');
                        } else {
                            $this->Session->setFlash('Please Try again, some issue', 'default', array('class' => 'fail'),'danger');
                        }
                    }
                    
                    $this->redirect(array('controller' => 'employers', 'action' => 'index'));
                } else {
                    
                    
//                    retun infusion subcription then register user here
                    $compInfusionSoft = $this->Components->load('Infusionsoft'); //load it
                    $arrOrderDetail = $compInfusionSoft->fnGetOrderDetail($intOrderId);
                    $intContactId = $arrOrderDetail[0]['ContactId'];
                    $arrPostedData = array();
                    $arrPostedData['pass_dec'] = $_GET['inf_field_FirstName']."@".rand(0, 9);
                    $arrPostedData['pass'] = addslashes(trim(AuthComponent::password($arrPostedData['pass_dec'])));
                    
                    $arrPostedData['user_confirmed'] = '1';
                    $arrPostedData['user_confirmation_mail_sent'] = '1';
                    $arrPostedData['is_active'] = '1';
                    $arrPostedData['owner_contact_id'] = $intContactId;
                    $arrPostedData['owner_order_id'] = $intOrderId;
                    
                    if (($this->Session->check("current_chosen_subscritopn")) && ($this->Session->read('current_chosen_subscritopn') != "0")) {
                        $arrPostedData['owner_chosen_subscription_plan'] = $this->Session->read('current_chosen_subscritopn');
                        $this->Session->write('current_chosen_subscritopn', "0");
                    } else {
                        $arrPostedData['owner_chosen_subscription_plan'] = "year";
                    }
                    
                    if ($this->User->save($arrPostedData)) {
                        $intLastUserInsertedId = $this->User->getInsertID();
                        $this->loadModel('Employer');
                        $arrEmployerDetailPostedData['employer_uname'] = $_GET['inf_field_Email'];
                        $arrEmployerDetailPostedData['employer_user_fname'] = $_GET['inf_field_FirstName'];
                        $arrEmployerDetailPostedData['employer_user_lname'] = $_GET['inf_field_LastName'];
                        $arrEmployerDetailPostedData['employer_company_name'] = $_GET['inf_field_Company'];
                        $arrEmployerDetailPostedData['employer_address'] = $_GET['inf_field_StreetAddress1'];
                        $arrEmployerDetailPostedData['address2'] = $_GET['inf_field_StreetAddress2'];
                        $arrEmployerDetailPostedData['employer_country'] = $_GET['inf_field_Country'];
                        $arrEmployerDetailPostedData['employer_state'] = $_GET['inf_field_State'];
                        $arrEmployerDetailPostedData['employer_city'] = $_GET['inf_field_City'];
                        $arrEmployerDetailPostedData['employer_pin'] = $_GET['inf_field_PostalCode'];
                        $arrEmployerDetailPostedData['employer_email'] = $_GET['inf_field_Email'];
                        $arrEmployerDetailPostedData['employer_id'] = $intLastUserInsertedId;
                        $intBoolNewEmployerInserted = $this->Employer->save($arrEmployerDetailPostedData);
                        
                        
                        $arrResultSet = array();
                        $compInfusionSoft = $this->Components->load('Infusionsoft'); //load it
                        $arrOrderDetail = $compInfusionSoft->fnGetOrderDetail($intOrderId);
                         
                        if (is_array($arrOrderDetail) && (count($arrOrderDetail) > 0)) {
                            $intContactId = $arrOrderDetail[0]['ContactId'];
                            $strSTartDate = date("Y-m-d H:i:s", strtotime($arrOrderDetail[0]['StartDate']));
                            $strAddDate = "+1 years";
                            if ($arrUserCreated[0]['User']['owner_chosen_subscription_plan'] == "month") {
                                $strAddDate = "+1 months";
                            }

                            $strExpiryDate = date("Y-m-d H:i:s", strtotime($strAddDate, strtotime($strSTartDate)));
                        }
                        
                        $boolRegistrationMail = $this->fnSendRegistrationEmail($_GET['inf_field_Email'], $_GET['inf_field_Email'], $intLastUserInsertedId,$arrPostedData['pass_dec']);
                        
                        $this->Session->write('infu_email', $_GET['inf_field_Email']);
                        $this->Session->write('infu_pass', $arrPostedData['pass_dec']);
                        $this->redirect(array('controller' => 'employers', 'action' => 'index'));
                        
//                        $this->Session->setFlash('You have been registered successfully with us, please check you mail for further steps', 'default', array('class' => 'success'));
                    }
                    
                    
                    
//                    $strSubscriptionUrl = Router::url(array('controller' => 'employers', 'action' => 'subscriptions'), true);
//                    $strRegistrationUrl = Router::url(array('controller' => 'employers', 'action' => 'index'), true);
//                    $this->Session->setFlash("Sorry, You are not registered with us", 'default', array('class' => 'fail'),'danger');
//                    $strSuccessRegisterMessage = "<p>Your can register and subscribe with default plan from <a href='" . $strRegistrationUrl . "'>here</a></p>";
//                    $strSuccessRegisterMessage .= "<p>You can also choose plans and activate you subscription from <a href='" . $strSubscriptionUrl . "'>here</a></p>";
//                    $this->set("strSuccessRegister", $strSuccessRegisterMessage);
                }
            } else {
               
                $errors = $this->User->invalidFields();
                $strRegerrorMessage = "";
                if (is_array($errors) && (count($errors) > 0)) {
                    foreach ($errors as $errorVal) {
                        $strRegerrorMessage .= "<br> Error: " . $errorVal['0'];
                    }

                    $this->Session->setFlash($strRegerrorMessage);
                }
            }
        }
    }

    public function confirmation($strUserId = "", $strAction = "") {
        $this->layout = "admin";
        $intUserId = base64_decode($strUserId);
        $strToDo = base64_decode($strAction);
        //exit;
        $this->loadModel('User');
        if ($intUserId) {
            $intUserExists = $this->User->find('count', array(
                'conditions' => array('id' => $intUserId)
            ));
            if ($intUserExists) {
                $boolIsConfirmed = $this->User->find('count', array(
                    'conditions' => array('id' => $intUserId, "user_confirmation_mail_sent" => '0')
                ));
                if ($boolIsConfirmed) {
                    $this->Session->setFlash('Your account has already been Confirmed', 'default', array('class' => 'success'));
                    $this->set('confirmationmessage',"Your account has already been Confirmed");
                } else {
                    $boolUpdated = $this->User->updateAll(
                            array('User.user_confirmed' => "'1'"), array('User.id =' => $intUserId)
                    );
                    if ($boolUpdated) {
                        $this->Session->setFlash('Your account has been Confirmed, You are now permitted to login to your account', 'default', array('class' => 'success'));
                        $this->set('confirmationmessage',"Congratulations, Your account has been Confirmed, You are now permitted to login to your account");
                    } else {
                        $this->Session->setFlash('Please try confirming you registration again.');
                        $this->set('confirmationmessage',"Please try confirming you registration again");
                    }
                }

                if ($strToDo == "subscribe") {
                    $arrUserDetail = $this->User->find('all', array('conditions' => array('id' => $intUserId)));

                    $this->redirect(array('controller' => 'employers', 'action' => 'subscriptionactivation', $arrUserDetail[0]['User']['email']));
                }
            } else {
                $this->set('confirmationmessage',"The Confirmation link is not active.");
                $this->Session->setFlash('The Confirmation link is not active.');
            }
        } else {
            $this->Session->setFlash('Please user correct Confirmation link, This Link seems to be incorrect.');
            $this->set('confirmationmessage',"Please user correct Confirmation link, This Link seems to be incorrect.");
        }
    }

    public function forgotpassword() {
        if ($this->request->is('post')) {
            /* print("<pre>");
              print_r($this->request->data);
              exit; */

            $this->request->data['User']['email'] = addslashes(trim($this->request->data['User']['user_email']));
            $intUtype = $this->request->data['User']['u_type'];

            $this->loadModel('User');
            $this->User->set($this->request->data);

            if ($this->User->validates()) {
                $arrUserExists = $this->User->find('all', array(
                    'conditions' => array('email' => $this->request->data['User']['email'], "user_type" => $intUtype)
                ));
                /* print("<pre>");
                  print_r($arrUserExists);
                  exit; */
                if (is_array($arrUserExists) && (count($arrUserExists) > 0)) {

                    $strUsersName = $arrUserExists[0]['User']['username'];
                    /* echo "---".$strUsersName;
                      exit; */
                    $strNewPassword = $this->fnRegeneratePassword($arrUserExists[0]['User']['id']);
                    $boolUpdated = $this->User->updateAll(
                            array('User.pass' => "'" . AuthComponent::password($strNewPassword) . "'"), array('User.email =' => $this->request->data['User']['email'], 'user_type' => $intUtype)
                    );
                    if ($boolUpdated) {
                        $intMailSent = $this->fnSendPassowordRegenerationMail($strUsersName, $this->request->data['User']['email'], $strNewPassword);
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
            } else {
                $errors = $this->User->invalidFields();
                $strRegerrorMessage = "";
                if (is_array($errors) && (count($errors) > 0)) {
                    $intForIterateCount = 0;
                    foreach ($errors as $errorVal) {
                        $intForIterateCount++;
                        if ($intForIterateCount) {
                            $strRegerrorMessage .= "Error: " . $errorVal['0'];
                        } else {
                            $strRegerrorMessage .= "<br> Error: " . $errorVal['0'];
                        }
                    }

                    $this->Session->setFlash($strRegerrorMessage);
                }
            }
        }
    }

}

?>