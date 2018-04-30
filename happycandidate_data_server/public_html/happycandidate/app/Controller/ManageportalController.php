

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
class ManageportalController extends AppController {

    public $components = array('Paginator');

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array();
    public $layout = "admin";
    public $name = 'Manageportal';

    /**

     * Controller name

     *

     * @var string

     */

    /**

     * This controller does not use a model

     *

     * @var array

     */
    public function beforeFilter() {

        //$this->Auth->autoRedirect = false;

        parent::beforeFilter();

        $this->Auth->allow('index');
    }

    public function logout() {

        $this->redirect($this->Auth->logout());
    }

    public function publish() {
//        Configure::write('debug',2);

        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);
        $this->Session->write('strCancelUrl', Router::url(array('controller' => 'content', 'action' => 'index'), true));
        if ($this->request->is('Post')) {
            $strStartDate = $this->request->data['from_date_hid'] . " 00:00:00";
            $strEndDate = $this->request->data['to_date_hid'] . " 23:59:59";
        }
        if ($strStartDate) {
            $arrConditions['career_portal_created_datetime >='] = $strStartDate;
        }
        if ($strEndDate) {
            $arrConditions['career_portal_created_datetime <='] = $strEndDate;
        }
        $arrConditions['career_portal_published'] = '1';
        $this->loadModel('Portal');
        $this->Manageportal->recursive = 0;
        $this->Paginator->settings = array(
            'Portal' => array(
                'limit' => 20,
                'conditions' => $arrConditions
            )
        );
        $arrProductContentList = $this->Paginator->paginate('Portal');
        $this->set('arrProductList', $arrProductContentList);
        $this->set('strStartDate', $strStartDate);
        $this->set('strEndDate', $strEndDate);
        $this->set('strType', 'publish');
        if (count($arrProductContentList) == 0) {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('There are no Portal present, Please add one', 'info');
            $this->set('strMessage', $strMessage);
        }
    }

    public function unpublish() {
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);
        $this->Session->write('strCancelUrl', Router::url(array('controller' => 'content', 'action' => 'index'), true));
        if ($this->request->is('Post')) {
            $strStartDate = $this->request->data['from_date_hid'] . " 00:00:00";
            $strEndDate = $this->request->data['to_date_hid'] . " 23:59:59";
        }
        if ($strStartDate) {
            $arrConditions['career_portal_created_datetime >='] = $strStartDate;
        }
        if ($strEndDate) {
            $arrConditions['career_portal_created_datetime <='] = $strEndDate;
        }
        $arrConditions['career_portal_published'] = '0';
        $this->loadModel('Portal');
        $this->Manageportal->recursive = 0;
        $this->Paginator->settings = array(
            'Portal' => array(
                'limit' => 20,
                'conditions' => $arrConditions
            )
        );
        $arrProductContentList = $this->Paginator->paginate('Portal');
        $this->set('arrProductList', $arrProductContentList);
        $this->set('strStartDate', $strStartDate);
        $this->set('strEndDate', $strEndDate);
        $this->set('strType', 'unpublish');
        if (count($arrProductContentList) == 0) {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('There are no Portal present, Please add one', 'info');
            $this->set('strMessage', $strMessage);
        }
    }

    public function Pending() {
//         Configure::write('debug',2);
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);
        $this->Session->write('strCancelUrl', Router::url(array('controller' => 'content', 'action' => 'index'), true));
        if ($this->request->is('Post')) {
            $strStartDate = $this->request->data['from_date_hid'] . " 00:00:00";
            $strEndDate = $this->request->data['to_date_hid'] . " 23:59:59";
        }
        if ($strStartDate) {
            $arrConditions['career_portal_created_datetime >='] = $strStartDate;
        }
        if ($strEndDate) {
            $arrConditions['career_portal_created_datetime <='] = $strEndDate;
        }
        $arrConditions['career_portal_published'] = '3';
        $this->loadModel('Portal');
        $this->Manageportal->recursive = 0;
        $this->Paginator->settings = array(
            'Portal' => array(
                'limit' => 20,
                'conditions' => $arrConditions
            )
        );
        $arrProductContentList = $this->Paginator->paginate('Portal');
        $this->set('arrProductList', $arrProductContentList);
        $this->set('strStartDate', $strStartDate);
        $this->set('strEndDate', $strEndDate);
        $this->set('strType', 'pending');
        if (count($arrProductContentList) == 0) {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('There are no Portal present, Please add one', 'info');
            $this->set('strMessage', $strMessage);
        }
    }

    public function approve() {
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);
        $this->Session->write('strCancelUrl', Router::url(array('controller' => 'content', 'action' => 'index'), true));

        $this->loadModel('Portal');
        $this->Manageportal->recursive = 0;
        $this->Paginator->settings = array(
            'Portal' => array(
                'limit' => 20,
                'conditions' => array('career_portal_approved' => '1')
            )
        );

        $arrProductContentList = $this->Paginator->paginate('Portal');
        $this->set('arrProductList', $arrProductContentList);
        if (count($arrProductContentList) == 0) {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('There are no Portal present, Please add one', 'info');
            $this->set('strMessage', $strMessage);
        }
    }

    public function cancel() {
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);
        $this->Session->write('strCancelUrl', Router::url(array('controller' => 'content', 'action' => 'index'), true));
        if ($this->request->is('Post')) {
            $strStartDate = $this->request->data['from_date_hid'] . " 00:00:00";
            $strEndDate = $this->request->data['to_date_hid'] . " 23:59:59";
        }
        if ($strStartDate) {
            $arrConditions['career_portal_created_datetime >='] = $strStartDate;
        }
        if ($strEndDate) {
            $arrConditions['career_portal_created_datetime <='] = $strEndDate;
        }
        
        $arrConditions['career_portal_approved'] = '2';
        
        $this->loadModel('Portal');
        $this->Manageportal->recursive = 0;
        $this->Paginator->settings = array(
            'Portal' => array(
                'limit' => 20,
                'conditions' => $arrConditions
            )
        );

        $arrProductContentList = $this->Paginator->paginate('Portal');
        $this->set('arrProductList', $arrProductContentList);
        $this->set('strStartDate', $strStartDate);
        $this->set('strEndDate', $strEndDate);
        $this->set('strType', 'cancel');
        if (count($arrProductContentList) == 0) {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('There are no Portal present, Please add one', 'info');
            $this->set('strMessage', $strMessage);
        }
    }

    public function changePortalStatus($intPortalId, $intstatusId, $changecondition) {
        $arrResponse = array();
        if ($intPortalId) {
            $this->loadModel('Portal');
            $intCorrectPortalId = $this->Portal->find('count', array('conditions' => array('career_portal_id' => $intPortalId)));
            if ($intCorrectPortalId) {
                if ($changecondition == "publish" || $changecondition == "unpublish") {
                    if ($intstatusId == "1") {
                        $updStausId = "0";
                        $updapprStausId = "0";
                        $html = "UnPublished";
                    } else {
                        $updStausId = "1";
                        $updapprStausId = "1";
                        $html = "Published";
                    }

                    $this->Portal->updateAll(
                            array('career_portal_published' => "'" . $updStausId . "'",'career_portal_approved' => "'" . $updapprStausId . "'"), array('career_portal_id' => $intPortalId)
                    );
                }
                if ($changecondition == "approve" || $changecondition == "reject") {
                    if ($intstatusId == "1") {
                        $updStausId = "2";
                        $html = "Rejected";
                    } else {
                        $updStausId = "1";
                        $html = "Approved";
                    }
                    $this->Portal->updateAll(
                            array('career_portal_approved' => "'" . $updStausId . "'"), array('career_portal_id' => $intPortalId)
                    );
                }
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Career portal '.$html.'  successfully ', 'success');
                $arrResponse['status'] = "success";
                $arrResponse['message'] = $strMessage;
                $arrResponse['htmlContent'] = $html;
                echo json_encode($arrResponse);
                exit;
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Entry does not exists', 'info');
                $this->set('strMessage', $strMessage);
                $arrResponse['status'] = "fail";
                $arrResponse['message'] = $strMessage;
                echo json_encode($arrResponse);
                exit;
            }
        } else {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('Something is missing, Please try again', 'error');
            $this->set('strMessage', $strMessage);

            $arrResponse['status'] = "fail";
            $arrResponse['message'] = $strMessage;

            echo json_encode($arrResponse);
            exit;
        }
    }
    
    public function portalExport() {
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $strType = $_GET['Type'];

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('PortalUser');

        if ($strType == 'publish') {
            $arrConditions['career_portal_published'] = '1';//check publish portal
        }elseif($strType == 'unpublish'){
            $arrConditions['career_portal_published'] = '0';//check unpublish portal
        }else if($strType == 'pending'){
            $arrConditions['career_portal_published'] = '3';//check pending portal
        }else{
            $arrConditions['career_portal_approved'] = '2';//check cancel portal
        }

        if ($strStartDate) {
            $arrConditions['career_portal_created_datetime >='] = $strStartDate;
        }
        if ($strEndDate) {
            $arrConditions['career_portal_created_datetime <='] = $strEndDate;
        }
        
        $this->loadModel('Portal');
        $this->Manageportal->recursive = 0;
        $this->Paginator->settings = array(
            'Portal' => array(
                'limit' => 20,
                'conditions' => $arrConditions
            )
        );
        $arrPortalList = $this->Paginator->paginate('Portal');
        if (is_array($arrPortalList) && count($arrPortalList) > 0) {
            if ($strType == 'publish') {
                $strFileName = "Published_Portal_Reports.xls";
                $reportName = "Published Portal Analytics Report";
            } else if ($strType == 'unpublish') {
                $strFileName = "Unpublished_Portal_Reports.xls";
                $reportName = "Unpublished_Portal Analytics Report";
            } else if($strType == 'pending'){
                $strFileName = "Pending_Portal_Reports.xls";
                $reportName = "Pending_Portal Analytics Report";
            } else {
                $strFileName = "Canceled_Portal_Reports.xls";
                $reportName = "Canceled_Portal Analytics Report";
            }
            $intFrCnt = 0;
            $intRowCnt = 6;

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Career Portal Analytics Report")
                    ->setSubject("Career Portal Analytics Report")
                    ->setDescription("Career Portal Analytics Report")
                    ->setKeywords("Career Portal Analytics Report")
                    ->setCategory("Career Portal Analytics Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'Company Name')
                    ->setCellValue('C5', 'First Name')
                    ->setCellValue('D5', 'Last Name')
                    ->setCellValue('E5', 'Career Portal URL')
                    ->setCellValue('F5', 'Date Created');
            foreach ($arrPortalList as $k => $arrPortal) {
                $companyName = stripslashes($arrPortal['employer_detail']['employer_company_name']);
                $firstName = stripslashes($arrPortal['employer_detail']['employer_user_fname']);
                $lastName = stripslashes($arrPortal['employer_detail']['employer_user_lname']);
                $portalURL = "http://www.".$arrPortal['career_portal_domain']['career_portal_domain_name']."";
//                $portalURL = stripslashes($arrPortal['career_portal_domain']['career_portal_domain_name']);
                $portalCreatedDate = date("F j, Y", strtotime($arrPortal['career_portal']['career_portal_created_datetime']));
                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $companyName)
                        ->setCellValue('C' . $intRowCnt, $firstName)
                        ->setCellValue('D' . $intRowCnt, $lastName)
                        ->setCellValue('E' . $intRowCnt, $portalURL)
                        ->setCellValue('F' . $intRowCnt, $portalCreatedDate);
                       

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(20);  //set row 4 height
                $intFrCnt++;
                $intRowCnt++;
            }

            $objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
            $objPHPExcel->getActiveSheet()->setCellValue('A2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('A3:F3');
                $objPHPExcel->getActiveSheet()->setCellValue('A3', $strStartDate . " - " . $strEndDate);
                $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(15);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
            }
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle($strFileName);
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
            $filename = WWW_ROOT . 'Analyticsreportfiles/' . $strFileName;
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save($filename);

            $arrResponse['status'] = "success";
            $arrResponse['file'] = $strFileName;
            $arrResponse['filepath'] = "Analyticsreportfiles";
        } else {
            $arrResponse['status'] = "fail";
            $arrResponse['message'] = "There are no ". ucfirst($strType)." in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }
    
    public function canceldomain() {
        $this->layout = NULL;
        $this->autoRender = false;
        
        $domainname = $_POST['domain'];
        $portalId = $_POST['portalId'];
        $domainId = $_POST['domainId'];
//        $is_active = '0';
//        $user_confirmed = '0';
//        $user_inactivation_date = 'date("Y-m-d h:i:s")';
         
        $cancelArray = array(
            "renewAuto" => false,
            "locked" => false,
            "nameServers" => Configure::read('nameServers'),
            "subaccountId" => ""
        );

        $cancelStr = json_encode($cancelArray);
        
        /** Test Header * */
//        $dsc_header = array("Authorization: sso-key VVBRynBW_GRx8QP1i7MEaa4E7zST3j2:GRxBUdE3PMoSHZ8Kaqs9oJ", "Content-Type:application/json", "Accept:application/json", "X-Shopper-Id:50769414");
        /** Test Header * */
        /** Server Header * */
        $dsc_header = array("Authorization: sso-key 9tzdJCoZv8j_N2kSLgmLeu4GAQxdxTNsHH:7q5eN2PmBtLQhjz3yCnXhH", "Content-Type:application/json", "Accept:application/json", "X-Shopper-Id:50769414");
        /** Server Header * */
        $url="https://api.godaddy.com/v1/domains/" . $domainname . "";
        
        $ch = curl_init();
        if ($ch == FALSE) {
            echo "Connecting to createsend failed\n";
        }
         
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $dsc_header);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_USERPWD, "9tzdJCoZv8j_N2kSLgmLeu4GAQxdxTNsHH:7q5eN2PmBtLQhjz3yCnXhH");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $cancelStr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        $result = curl_exec($ch);
        
        $cancel_data = json_decode($result);
        curl_close($ch);
        
        $this->loadModel('Candidate');
        $boolPortalUpdated = $this->Candidate->updateAll(array('career_portal_id' => "5"), array('career_portal_id' => $portalId));
      
        $this->loadModel('User');
        $boolUpdatedUserInactive = $this->User->updateAll(array('is_active' => '0','user_confirmed'=>'0'), array('portal_id' => $portalId));
      
        $this->loadModel('Portal');
        $boolDomainUpdated = $this->Portal->updateAll(array('career_portal_approved' => "2","career_portal_published"=>"0"), array('career_portal_id' => $portalId));
      
        if ($boolPortalUpdated) {
            $compMessage = $this->Components->load('Message');
            $strForMessage = "<div class='alert alert-success'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-success.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a>" . $_POST['domain'] . " has been cancelled successfully.</div>";
            $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'success');
            $arrResponseData['message'] = $strForMessage;
            $arrResponseData['status'] = "success";
            $arrResponseData['domainId'] = $domainId;
            echo json_encode($arrResponseData);
            exit;
        } else {
            $compMessage = $this->Components->load('Message');
            $strForMessage = "<div class='alert alert-danger'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-error.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> " . $_POST['domain'] . " '" . $cancel_data->message . "'</div>";
            $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'alert-danger');
            $arrResponseData['message'] = $strForMessage;
            $arrResponseData['status'] = "fail";
            echo json_encode($arrResponseData);
            exit;
        }
        
        echo $result;
        exit;
    }
}
