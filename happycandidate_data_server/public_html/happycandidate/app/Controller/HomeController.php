<?php
App::uses('AppController', 'Controller');

class HomeController extends AppController {
    public $name = 'Home';
    public $uses = array();
  
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'contactus','captcha');
       
    }

    public function captcha() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        if (!isset($this->Captcha)) { //if Component was not loaded throug $components array()
            $this->Captcha = $this->Components->load('Captcha', array(
                'width' => 150,
                'height' => 50,
                'theme' => 'default', //possible values : default, random ; No value means 'default'
            )); //load it
        }
        $this->Captcha->create();
    }
    
    public function index1() {
        $this->layout = "home";
    }

    public function index() {
//        Configure::write('debug', 2);
        $hostUrl = $_SERVER['HTTP_HOST'];
        $this->loadModel('PortalDomain');
        $this->loadModel('Portal');
        $intPortalUrl = $this->PortalDomain->find('all', array(
            'conditions' => array('career_portal_domain_name' => $hostUrl)
        ));
        
        $careerPortalId = $intPortalUrl[0]['PortalDomain']['career_portal_id'];
        $strPortalData = $this->Portal->find('all',array(
            'fields'=>array('career_portal_name'),
            'conditions' => array('career_portal_id' => $careerPortalId)
        ));
        
        $strPortalName = $strPortalData[0]['Portal']['career_portal_name'];
       
        $intPortalExists = $this->Portal->find('count', array(
            'conditions' => array('career_portal_name' => $strPortalName)
        ));

        if ($intPortalExists) {
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_name' => $strPortalName)
            ));

            //To get Emplyer detail code starts
            $intPortalId = $arrPortalDetail[0]['Portal']['career_portal_id'];
            $this->loadModel('User');
            $arrEmployerId = $this->User->find('first', array('conditions' => array('User.portal_id' => $intPortalId)));
            $employerId = $arrEmployerId["User"]["id"];
            $this->loadModel('Employer');
            $arrEmployerDetail = $this->Employer->find('first', array('conditions' => array('Employer.employer_id' => $employerId)));
            $this->set('arrEmployerDetail', $arrEmployerDetail);

            $strHomeEditorLink = Router::url('/', true) . "portal/home/" . $arrPortalDetail[0]['Portal']['career_portal_name'];
            $this->set('strHomeEditorLink', $strHomeEditorLink);
            $strRegister = Router::url(array('controller' => 'portal', 'action' => 'register', $arrPortalDetail[0]["Portal"]["career_portal_name"]), true);
            $this->set('strRegister', $strRegister);

            $this->loadModel('PortalTheme');
            //$arrPortalThemeDetail = $this->PortalTheme->fnLoadPortalThemeDetail($arrPageDetail['1']);					
            $arrPortalThemeDetail = $this->PortalTheme->find('first', array(
                'fields' => array('Wiztheme.*', 'Portal.*'),
                'joins' => array(
                    array(
                        'table' => 'wizard_theme',
                        'alias' => 'Wiztheme',
                        'type' => 'inner',
                        'recursive' => -1,
                        'conditions' => array('Wiztheme.theme_id = PortalTheme.career_portal_theme_id')
                    ), array(
                        'table' => 'career_portal',
                        'alias' => 'Portal',
                        'type' => 'inner',
                        'recursive' => -1,
                        'conditions' => array('Portal.career_portal_id = PortalTheme.career_portal_id')
                    )
                ), 'conditions' => array('Portal.career_portal_name' => $strPortalName)));
            //To get Emplyer detail code end

//            if ($this->params['action'] == "home") {
                $this->layout = $arrPortalThemeDetail['Wiztheme']['theme_name'] . '-' . $arrPortalThemeDetail['Wiztheme']['theme_color'] . '-FRONTEND';
//            }
//            if ($this->params['action'] == "themepage") {
//                $this->layout = $arrPortalThemeDetail['Wiztheme']['theme_name'] . '-' . $arrPortalThemeDetail['Wiztheme']['theme_color'] . '-FRONTENDPAGE';
//            }

            $this->loadModel('TopMenu');
            $arrMenuDetail = $this->TopMenu->find('all', array("order" => array('career_portal_menu_order' => 'ASC'), 'conditions' => array('career_portal_id' => $intPortalId),));
            $this->set('arrPortalMenuDetail', $arrMenuDetail);

            // courses detail
            $compLmsBridge = $this->Components->load('LmsBridge');
            $arrCourseDetails = $compLmsBridge->fnGetPortalCourses($arrPortalDetail['0']['Portal']['career_portal_id']);
            $this->set('arrCoursesDetails', $arrCourseDetails);

            $this->loadModel('PortalPages');
            $arrPageList = $this->PortalPages->find('list', array('fields' => array('PortalPages.career_portal_page_id', 'PortalPages.career_portal_page_tittle'), "conditions" => array('career_portal_id' => $intPortalId), "order" => array('career_portal_page_createddatetime' => 'DESC')));
            $this->set('arrPortalPageDetailList', $arrPageList);

            $arrPortalHomePageDetail = $this->PortalPages->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'is_career_portal_home_page' => '1')));
            $this->set('arrPortalPageDetail', $arrPortalHomePageDetail);
        }else{
            $this->layout = "home";
        }
    }

    public function contactus() {
        $this->loadModel('Contactus');
        if ($this->request->is('Post')) {
                $arrContactDetail = array();
                $arrContactDetail['name'] = $this->request->data['name'];
                $arrContactDetail['email'] = $this->request->data['email'];
                $arrContactDetail['message'] = $this->request->data['message'];
                $arrContactDetail['subject'] = $this->request->data['subject'];
                $arrContactDetail['captcha'] = $this->request->data['captcha'];
                
                if (!isset($this->Captcha)) {
                    //if Component was not loaded throug $components array()
                    $this->Captcha = $this->Components->load('Captcha'); //load it
                }
                $this->Contactus->setCaptcha($this->Captcha->getVerCode()); //getting from component and passing to model to make proper validation check
                $this->Contactus->set($arrContactDetail);

                if($_POST['captcha'] == $this->Contactus->getCaptcha()){
                    $isSent = $this->fnSendAdminEmployerContactusEmail($arrContactDetail);
                    if ($isSent) {
                        $this->Session->setFlash('Your request was sent. We will get back to you soon', 'default', array('class' => 'success'));
                    } else {
                        $this->Session->setFlash('Some issues, Please try again.');
                    }
                } else {
                    $this->Session->setFlash('Error: Your captcha code not match.Please enter valid captcha.');
                }
        }
    }
}


