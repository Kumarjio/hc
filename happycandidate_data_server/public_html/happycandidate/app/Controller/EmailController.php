<?php

class EmailController extends AppController {

    var $helpers = array('Html', 'Form');
    var $name = 'Email';
    public $components = array('Paginator');

    //var $layout = 'register';



    public function beforeFilter() {

        //$this->Auth->autoRedirect = false;

        parent::beforeFilter();

        $this->Auth->allow('index', 'sendemail', 'sendybcas');
    }

    public function detail($intPortalId = "") {
        
    }

    public function getuser($intUserType = "", $strPortal = "") {
        $this->layout = NULL;
        $this->autoRender = false;
        $arrLoggedUser = $this->Auth->user();
        $arrResponse = array();

        if ($intUserType) {

            if ($intUserType == "Portal Owners") {
                $this->loadModel('User');
                $arrConditions = array();
                $arrConditions['is_active'] = "1";
                $arrConditions['user_type'] = "2";
                if ($strPortal) {
                    //$arrConditions['portal_id'] = $strPortal;
                }

                $arrUser = $this->User->find('all', array('conditions' => $arrConditions));
                //print("<pre>");
                //print_r($arrUser);
                //exit;
                $view = new View($this, false);
                $view->set('arrRelatedProductList', $arrUser);
                if (is_array($arrUser) && (count($arrUser) > 0)) {
                    $view = new View($this, false);
                    $view->set('arrRelatedProductList', $arrUser);
                    $strWidgetListerHtml = $view->element('portal_owner_list');
                    $arrResponse['status'] = "success";
                    $arrResponse['html'] = $strWidgetListerHtml;
                    echo json_encode($arrResponse);
                    exit;
                } else {
                    $arrResponse['status'] = "fail";
                    $arrResponse['message'] = "There are no portal Owners, Please check later.";
                    echo json_encode($arrResponse);
                    exit;
                }
            } else {
                if ($intUserType == "Vendors") {
                    $this->loadModel('Vendors');
                    $arrConditions = array();
                    $arrConditions['vendor_active'] = '1';
                    $arrUser = $this->Vendors->find('all', array('conditions' => $arrConditions));
                    //print("<pre>");
                    //print_r($arrUser);
                    //exit;
                    $view = new View($this, false);
                    $view->set('arrRelatedProductList', $arrUser);
                    if (is_array($arrUser) && (count($arrUser) > 0)) {
                        $view = new View($this, false);
                        $view->set('arrRelatedProductList', $arrUser);
                        $strWidgetListerHtml = $view->element('vendor_select_list');
                        $arrResponse['status'] = "success";
                        $arrResponse['html'] = $strWidgetListerHtml;
                        echo json_encode($arrResponse);
                        exit;
                    } else {
                        $arrResponse['status'] = "fail";
                        $arrResponse['message'] = "There are no Vendors, Please check later.";
                        echo json_encode($arrResponse);
                        exit;
                    }
                } else {
                    if ($intUserType == "Job Seekers") {
                        $this->loadModel('Candidate');
                        $arrConditions = array();
                        $arrConditions['candidate_is_active'] = "1";
                        if ($strPortal && $strPortal != "all") {
                            $arrConditions['career_portal_id'] = $strPortal;
                        }
                        if (is_array($arrConditions) && (count($arrConditions) > 0)) {
                            $arrUser = $this->Candidate->find('all', array('conditions' => $arrConditions));
                        } else {
                            $arrUser = $this->Candidate->find('all');
                        }

                        if (is_array($arrUser) && (count($arrUser) > 0)) {
                            $view = new View($this, false);
                            $view->set('arrRelatedProductList', $arrUser);
                            $strWidgetListerHtml = $view->element('job_seeker_list');
                            $arrResponse['status'] = "success";
                            $arrResponse['html'] = $strWidgetListerHtml;
                            echo json_encode($arrResponse);
                            exit;
                        } else {
                            $arrResponse['status'] = "fail";
                            $arrResponse['message'] = "There are no job seekers, Please check later.";
                            echo json_encode($arrResponse);
                            exit;
                        }
                    } else {
                        $arrResponse['status'] = "fail";
                        $arrResponse['message'] = "You have not chosen user type, Please select user type.";
                        echo json_encode($arrResponse);
                        exit;
                    }
                }
            }
        } else {
            $arrResponse['status'] = "fail";
            $arrResponse['message'] = "Please choose user type";
            echo json_encode($arrResponse);
            exit;
        }
    }

    public function bcast() {
        //Configure::write('debug','2');
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.form.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/add_product.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/tinymce/tiny_mce.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);
        $this->loadModel('Portal');
        $arrPortalList = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_published' => '1')));
        /* print("<pre>");
          print_r($arrPortalList);
          exit; */
        $this->set('arrPortalList', $arrPortalList);
    }

    public function sendybcas() {
        //Configure::write('debug','2');
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.form.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/add_product.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/tinymce/tiny_mce.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);
        $this->loadModel('Portal');
        $arrPortalList = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_published' => '1')));
        /* print("<pre>");
          print_r($arrPortalList);
          exit; */
        $this->set('arrPortalList', $arrPortalList);
    }

    public function index() {


        $this->loadModel('Email');
        $arrEmailContents = $this->Email->find('all', array("order" => array('created_date' => 'DESC')));

        $this->Paginator->settings = array(
            'order' => array('created_date' => 'DESC'),
            'limit' => 10
        );

        $arrEmailTemplateList = $this->Paginator->paginate('Email');

        $this->set('arrEmailTemplateList', $arrEmailTemplateList);
    }

    public function sendemail($intEmailId = "") {
        $fh = fopen("emailsend.txt", "w");
        fwrite($fh, "hello there");
        fclose($fh);
        $this->layout = NULL;
        $this->autoRender = false;
        if ($intEmailId) {
            $this->loadModel('Bcast');
            $this->loadModel('Bcastsent');
            $this->loadModel('User');
            $this->loadModel('Vendors');
            $this->loadModel('Candidate');
            $arrBcasContent = $this->Bcast->find('all', array('conditions' => array('email_id' => $intEmailId)));
            if (is_array($arrBcasContent) && (count($arrBcasContent) > 0)) {
                $arrToUsers = $this->Bcastsent->find('all', array('conditions' => array('email_id' => $intEmailId, 'push_processed' => '0')));
                if (is_array($arrToUsers) && (count($arrToUsers) > 0)) {
                    foreach ($arrToUsers as $arrUser) {
                        $intUId = $arrUser['Bcastsent']['to_id'];
                        $intUType = $arrUser['Bcastsent']['to_type'];
                        $intEmailSentId = $arrUser['Bcastsent']['email_sent_id'];
                        $arrConditions = array();

                        if ($intUType == "Portal Owners") {
                            $arrConditions['id'] = $intUId;
                            $arrUsreDetail = $this->User->find('all', array('conditions' => $arrConditions));
                            if (is_array($arrUsreDetail) && (count($arrUsreDetail) > 0)) {
                                $strEmailAddress = $arrUsreDetail[0]['User']['email'];
                                $strEmailSubject = $arrBcasContent[0]['Bcast']['email_subject'];
                                $strEmailMessage = $arrBcasContent[0]['Bcast']['email_message'];
                            }
                        } else {
                            if ($intUType == "Vendors") {
//                                print("<pre>");
//                                print_r($arrEmail);
//                                print("<pre>");
//                                exit;
                                $arrConditions['vendor_id'] = $intUId;
                                $arrUsreDetail = $this->Vendors->find('all', array('conditions' => $arrConditions));
                                if (is_array($arrUsreDetail) && (count($arrUsreDetail) > 0)) {
                                    $strEmailAddress = $arrUsreDetail[0]['Vendors']['vendor_email'];
                                    $strEmailSubject = $arrBcasContent[0]['Bcast']['email_subject'];
                                    $strEmailMessage = $arrBcasContent[0]['Bcast']['email_message'];
                                }
                            } else {
                                if ($intUType == "Job Seekers") {
                                    $arrConditions['candidate_id'] = $intUId;
                                    $arrUsreDetail = $this->Candidate->find('all', array('conditions' => $arrConditions));
                                    if (is_array($arrUsreDetail) && (count($arrUsreDetail) > 0)) {
                                        $strEmailAddress = $arrUsreDetail[0]['Candidate']['candidate_email'];
                                        $strEmailSubject = $arrBcasContent[0]['Bcast']['email_subject'];
                                        $strEmailMessage = $arrBcasContent[0]['Bcast']['email_message'];
                                    }
                                }
                            }
                        }
                        // send email
                        $intSent = $this->fnSendEmail($strEmailAddress, $strEmailSubject, $strEmailMessage);
                        if ($intSent) {
                            $this->Bcastsent->updateAll(
                                    array('push_processed' => "'1'"), array('email_sent_id =' => $intEmailSentId)
                            );
                        }
                    }
                }
            }
        }
    }

    public function sentmails() {
        $this->loadModel('Bcast');
        $arrBcastEmail = $this->Bcast->find('all', array('order' => array('email_id' => 'DESC')));
        $this->set('arrProductList', $arrBcastEmail);

        //print("<pre>");
        //print_r($arrBcastEmail);
        //exit;
    }

    public function send() {
        //Configure::write('debug','2');
        $arrResponse = array();
        $this->layout = NULL;
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Vendors');
        $this->loadModel('Candidate');
        $this->loadModel('Bcastsent');
        if ($this->request->is('Post')) {
            //print("<pre>");
            //print_r($this->request->data);
            //exit;
            $arrUsers = array();

            $arrEmail['Bcast']['email_message'] = $strMessage = $this->request->data['main_content'];
            $arrEmail['Bcast']['email_subject'] = $strMessageSubject = $this->request->data['from_email'];
            $arrEmail['Bcast']['email_user_type'] = $strMessageUType = $this->request->data['template_for'];
            $arrEmail['Bcast']['email_user_sites'] = $strMessageSites = $this->request->data['portal_chooser'];
            $arrUsers = $this->request->data['users'];

            $this->loadModel('Bcast');
            $intEmailExisit = $this->Bcast->find('count', array('conditions' => array('email_subject' => $arrEmail['Bcast']['email_subject'], 'email_user_type' => $arrEmail['Bcast']['email_user_type'], 'email_user_sites' => $arrEmail['Bcast']['email_user_sites'])));
            $compMessage = $this->Components->load('Message');
            if ($intEmailExisit) {

                $strMessage = $compMessage->fnGenerateMessageBlock('This email has already been sent', 'error');

                $arrResponse['status'] = "fail";
                $arrResponse['message'] = $strMessage;
            } else {

                if (is_array($arrUsers) && (count($arrUsers) > 0)) {
                    $isAllSet = "";
                    if (in_array('all', $arrUsers)) {
                        $isAllSet = "1";
                    } else {
                        $isAllSet = "";
                    }

                    if ($arrEmail['Bcast']['email_user_type'] == "Portal Owners") {
                        $arrConditions['is_active'] = "1";
                        $arrConditions['user_type'] = "2";
                        if ($isAllSet) {
                            $arrConditions['is_active'] = "1";
                            $arrConditions['user_type'] = "2";
                        } else {
                            $arrConditions['id'] = $arrUsers;
                        }

                        $arrUsreList = $this->User->find('all', array('conditions' => $arrConditions));
                        //print("<pre>");
                        //print_r($arrUsreList);
                        //exit;
                        if (is_array($arrUsreList) && (count($arrUsreList) > 0)) {
                            $arrSaved = $this->Bcast->save($arrEmail);

                            $arrConditions = array();
                            if (is_array($arrSaved) && (count($arrSaved) > 0)) {
                                foreach ($arrUsreList as $arrU) {
                                    $arrBcastsent['Bcastsent']['email_id'] = $arrSaved['Bcast']['id'];
                                    $arrBcastsent['Bcastsent']['to_id'] = $arrU['User']['id'];
                                    $arrBcastsent['Bcastsent']['to_type'] = "Portal Owners";
                                    $intCount = $this->Bcastsent->find('count', array('conditions' => array('email_id' => $arrSaved['Bcast']['id'], 'to_id' => $arrU['User']['id'], 'to_type' => "Portal Owners")));

                                    if ($intCount) {
                                        continue;
                                    } else {
                                        $this->Bcastsent->create(false);
                                        $this->Bcastsent->save($arrBcastsent);
                                    }
                                }
                                $strProcessUrl = Router::url(array('controller' => 'email', 'action' => 'sendemail', $arrSaved['Bcast']['id']), true);
                                $strBackProcessComm = "wget " . $strProcessUrl . " > /dev/null 2>&1 & echo $!";
                                $pid = shell_exec(sprintf('%s', $strBackProcessComm));
                                $strMessage = $compMessage->fnGenerateMessageBlock('Email sent has initiated successfully', 'success');
                                $arrResponse['status'] = "success";
                                $arrResponse['message'] = $strMessage;
                            } else {
                                $strMessage = $compMessage->fnGenerateMessageBlock('There was some problem, please try again', 'error');
                                $arrResponse['status'] = "fail";
                                $arrResponse['message'] = $strMessage;
                            }
                        } else {
                            $strMessage = $compMessage->fnGenerateMessageBlock('Email cant be sent, there are no users.', 'error');
                            $arrResponse['status'] = "fail";
                            $arrResponse['message'] = $strMessage;
                        }
                    } else {
                        if ($arrEmail['Bcast']['email_user_type'] == "Vendors") {
                            $arrConditions['vendor_active'] = '1';
                            if ($isAllSet) {
                                $arrConditions['vendor_active'] = '1';
                            } else {
                                $arrConditions['vendor_id'] = $arrUsers;
                            }
                            $arrUsreList = $this->Vendors->find('all', array('conditions' => $arrConditions));
                            //print("<pre>");
                            //print_r($arrUsreList);
                            //exit;
                            if (is_array($arrUsreList) && (count($arrUsreList) > 0)) {
                                $arrSaved = $this->Bcast->save($arrEmail);

                                if (is_array($arrSaved) && (count($arrSaved) > 0)) {

                                    foreach ($arrUsreList as $arrU) {
                                        $arrBcastsent['Bcastsent']['email_id'] = $arrSaved['Bcast']['id'];
                                        $arrBcastsent['Bcastsent']['to_id'] = $arrU['Vendors']['vendor_id'];
                                        $arrBcastsent['Bcastsent']['to_type'] = "Vendors";
                                        $intCount = $this->Bcastsent->find('count', array('conditions' => array('email_id' => $arrSaved['Bcast']['id'], 'to_id' => $arrU['Vendors']['vendor_id'], 'to_type' => "Vendors")));

                                        if ($intCount) {
                                            continue;
                                        } else {
                                            $this->Bcastsent->create(false);
                                            $this->Bcastsent->save($arrBcastsent);
                                        }
                                    }
                                    $strProcessUrl = Router::url(array('controller' => 'email', 'action' => 'sendemail', $arrSaved['Bcast']['id']), true);
                                    $strBackProcessComm = "wget " . $strProcessUrl . " > /dev/null 2>&1 & echo $!";
                                    $pid = shell_exec(sprintf('%s', $strBackProcessComm));
                                    $strMessage = $compMessage->fnGenerateMessageBlock('Email sent has initiated successfully', 'success');
                                    $arrResponse['status'] = "success";
                                    $arrResponse['message'] = $strMessage;
                                } else {
                                    $strMessage = $compMessage->fnGenerateMessageBlock('There was some problem, please try again', 'error');
                                    $arrResponse['status'] = "fail";
                                    $arrResponse['message'] = $strMessage;
                                }
                            } else {
                                $strMessage = $compMessage->fnGenerateMessageBlock('Email cant be sent, there are no users.', 'error');
                                $arrResponse['status'] = "fail";
                                $arrResponse['message'] = $strMessage;
                            }
                        } else {
                            if ($arrEmail['Bcast']['email_user_type'] == "Job Seekers") {
                                $arrConditions['candidate_is_active'] = "1";
                                if ($isAllSet) {
                                    $arrConditions['candidate_is_active'] = "1";
                                } else {
                                    $arrConditions['candidate_id'] = $arrUsers;
                                }
                                $arrUsreList = $this->Candidate->find('all', array('conditions' => $arrConditions));
                                //print("<pre>");
                                //print_r($arrUsreList);
                                //exit;
                                if (is_array($arrUsreList) && (count($arrUsreList) > 0)) {
                                    $arrSaved = $this->Bcast->save($arrEmail);

                                    $arrConditions = array();
                                    if (is_array($arrSaved) && (count($arrSaved) > 0)) {

                                        foreach ($arrUsreList as $arrU) {
                                            $arrBcastsent['Bcastsent']['email_id'] = $arrSaved['Bcast']['id'];
                                            $arrBcastsent['Bcastsent']['to_id'] = $arrU['Candidate']['candidate_id'];
                                            $arrBcastsent['Bcastsent']['to_type'] = "Job Seekers";
                                            $intCount = $this->Bcastsent->find('count', array('conditions' => array('email_id' => $arrSaved['Bcast']['id'], 'to_id' => $arrU['Candidate']['candidate_id'], 'to_type' => "Job Seekers")));

                                            if ($intCount) {
                                                continue;
                                            } else {
                                                $this->Bcastsent->create(false);
                                                $this->Bcastsent->save($arrBcastsent);
                                            }
                                        }
                                        $strProcessUrl = Router::url(array('controller' => 'email', 'action' => 'sendemail', $arrSaved['Bcast']['id']), true);
                                        $strBackProcessComm = "wget " . $strProcessUrl . " > /dev/null 2>&1 & echo $!";
                                        $pid = shell_exec(sprintf('%s', $strBackProcessComm));
                                        $strMessage = $compMessage->fnGenerateMessageBlock('Email sent has initiated successfully', 'success');
                                        $arrResponse['status'] = "success";
                                        $arrResponse['message'] = $strMessage;
                                    } else {
                                        $strMessage = $compMessage->fnGenerateMessageBlock('There was some problem, please try again', 'error');
                                        $arrResponse['status'] = "fail";
                                        $arrResponse['message'] = $strMessage;
                                    }
                                } else {
                                    $strMessage = $compMessage->fnGenerateMessageBlock('Email cant be sent, there are no users.', 'error');
                                    $arrResponse['status'] = "fail";
                                    $arrResponse['message'] = $strMessage;
                                }
                            }
                        }
                    }
                } else {
                    $strMessage = $compMessage->fnGenerateMessageBlock('You have not chosen any users.', 'error');
                    $arrResponse['status'] = "fail";
                    $arrResponse['message'] = $strMessage;
                }
            }

            //print("<pre>");
            //print_r($arrEmail);
            //exit;
        } else {
            $strMessage = $compMessage->fnGenerateMessageBlock('Bad request', 'error');
            $arrResponse['status'] = "fail";
            $arrResponse['message'] = $strMessage;
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function add($id = "") {
//        echo '<pre>';print_r($this->request->data);die;
        $arrResponse = array();

        $this->loadModel('Email');
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.form.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/add_product.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/tinymce/tiny_mce.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/vendor/jquery.ui.widget.js') . '"></script>';

        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/tmpl.min.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/load-image.all.min.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/canvas-to-blob.min.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.iframe-transport.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-process.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-image.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-audio.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-video.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-validate.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-ui.js') . '"></script>';
        //$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
        //$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/main.js').'"></script>';
        $this->set('strActionScript', $strActionScript);
        if ($id > 0) {
            $arrEmailContent = $this->Email->find('first', array("conditions" => array('id' => $id)));
            $this->set('arrEmailContent', $arrEmailContent);
        }
        if ($this->request->is('Post')) {
            $compMessage = $this->Components->load('Message');
            if ($this->request->data['templateid'] > 0) {
                $templateid = $this->request->data['templateid'];
            } else {
                $templateid = 0;
            }

            if ($this->request->data['template_type'] == 'seekers') {
                $template_for = $this->request->data['template_for_seeker'];
            } else if ($this->request->data['template_type'] == 'vendors') {
                $template_for = $this->request->data['template_for_vendor'];
            } else if ($this->request->data['template_type'] == 'owners') {
                $template_for = $this->request->data['template_for_owner'];
            } else {
                $template_for = $this->request->data['template_for_search'];
            }

            $arrEmailData['Email']['template_name'] = htmlspecialchars(addslashes($this->request->data['template_name']));
            $arrEmailData['Email']['template_type'] = htmlspecialchars(addslashes($this->request->data['template_type']));
            $arrEmailData['Email']['template_key'] = htmlspecialchars(addslashes($template_for));
            $arrEmailData['Email']['from_email'] = htmlspecialchars(addslashes($this->request->data['from_email']));
            $arrEmailData['Email']['from_name'] = htmlspecialchars(addslashes($this->request->data['from_name']));
            $arrEmailData['Email']['email_subject'] = htmlspecialchars(addslashes($this->request->data['email_subject']));
            $arrEmailData['Email']['email_text'] = htmlspecialchars(addslashes($this->request->data['main_content']));
            $arrEmailData['Email']['created_date'] = date('Y-m-d H:i:s');
            if ($templateid > 0) {
                $boolTemplateUpdated = $this->Email->updateAll(
                        array('template_name' => "'" . $arrEmailData['Email']['template_name'] . "'", 'template_type' => "'" . $arrEmailData['Email']['template_type'] . "'", 'from_email' => "'" . $arrEmailData['Email']['from_email'] . "'", 'from_name' => "'" . $arrEmailData['Email']['from_name'] . "'", 'email_subject' => "'" . $arrEmailData['Email']['email_subject'] . "'", 'email_text' => "'" . $arrEmailData['Email']['email_text'] . "'"), array('id =' => $templateid)
                );

                $arrResponseData['emailContentId'] = $templateid;
                $arrResponseData['status'] = 'success';
                $strForMessage = "You have successfully updated Template.";
            } else {
                $keyCount = $this->Email->find('count', array(
                    'conditions' => array('Email.template_key' => $arrEmailData['Email']['template_key'])
                ));
                if ($keyCount > 0) {
                    $arrResponseData['status'] = 'success';
                    $strForMessage = "Template for " . $arrEmailData['Email']['template_key'] . " already exists.";
                } else {
                    $arrRes = $this->Email->save($arrEmailData);

                    $intEmailContentId = $this->Email->getLastInsertID();
                    $arrResponseData['emailContentId'] = $intEmailContentId;
                    $arrResponseData['status'] = 'success';
                    $strForMessage = "You have successfully added Template.";
                }
            }
            $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'success');
            $arrResponseData['message'] = $strMessage;
            echo json_encode($arrResponseData);
            exit;
        }
    }

    public function templatedelete($templateid) {
        $arrResponseData = array();
        if ($templateid) {
            $this->loadModel('Email');
            $isEmailTemplatePresent = $this->Email->find('count', array('conditions' => array('id' => $templateid)));
            if ($isEmailTemplatePresent) {
                $intEmailDeleted = $this->Email->deleteAll(array('id' => $templateid), false);
                if ($intEmailDeleted) {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Email Template deleted Successfully', 'success');
                    $arrResponseData ['status'] = "success";
                    $arrResponseData ['message'] = $strMessage;
                } else {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Some error, Please try again, Please', 'warning');
                    $arrResponseData ['status'] = "fail";
                    $arrResponseData ['message'] = $strMessage;
                }
            }
        } else {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('Template Missing, Please', 'error');
            $arrResponseData ['status'] = "fail";
            $arrResponseData ['message'] = $strMessage;
        }
        echo json_encode($arrResponseData);
        exit;
    }

    public function createnewcampaign() {

    }

    public function campaignreports() {

    }

}

?>