<?php

/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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
class ManagepayoutsController extends AppController {

    public $components = array('Paginator');

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array();
    public $layout = "admin";
    public $name = 'Managepayouts';

    public function beforeFilter() {
        //$this->Auth->autoRedirect = false;
        parent::beforeFilter();
    }

    /**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     * @throws NotFoundException When the view file could not be found
     * 	or MissingViewException in debug mode.
     */
    public function payouts() {
        
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Vendorcompany');
        $arrVendorDetail = $this->Vendorcompany->fnGetVendorCompanyName();
        $this->set("arrVendorDetail", $arrVendorDetail);

        $this->loadModel('User');
        $arrPortalOwnerDetail = $this->User->fnGetPortalOwnerName();
        $this->set("arrPortalOwnerDetail", $arrPortalOwnerDetail);

        $this->loadModel('Resourceorderdetail');
        $this->loadModel('Vendors');
        $this->loadModel('Portal');
        $this->loadModel('CpaoffersCommissions');

        if ($this->request->is('Post')) {
            $PayoutType = $this->request->data['PayoutType'];
            $intVendorId = isset($this->request->data['Vendors']) ? $this->request->data['Vendors'] : null;
            $intOwnerId = isset($this->request->data['Owners']) ? $this->request->data['Owners'] : null;
            $strFromDate = $this->request->data['strFromDate'];
            $strToDate = $this->request->data['strToDate'];

//            if ($PayoutType == 'owner') {
//                if ($intOwnerId != 'all') {
//                    $arrPortalId = $this->User->find('all', array('conditions' => array('id' => $intOwnerId)));
//                    $portalId = $arrPortalId[0]['User']['portal_id'];
//                }
//            }

            if (!empty($strFromDate)) {
                $strStartDate = $strFromDate . " 00:00:00";
            }

            if (!empty($strToDate)) {
                $strEndDate = $strToDate . " 23:59:59";
            }

            if ($PayoutType != '') {
                if ($PayoutType == 'vendor') {
                    if ($intVendorId == 'all') {
                        if($strStartDate == ''){
                            $arrTotalSumQ = $this->Resourceorderdetail->fnGetVendorPayoutCount($intVendorId, $strStartDate="", $strEndDate="");
                        }else{
                            $arrTotalSumQ = $this->Resourceorderdetail->fnGetVendorPayoutCount($intVendorId, $strStartDate, $strEndDate);
                        }
                        
                    } else {
                        if($strStartDate == ''){
                            $arrTotalSumQ = $this->Resourceorderdetail->fnGetVendorPayoutCount($intVendorId, $strStartDate="", $strEndDate="");
                        }else{
                            $arrTotalSumQ = $this->Resourceorderdetail->fnGetVendorPayoutCount($intVendorId, $strStartDate, $strEndDate);
                        }
                        
                    }
                } else {
                    if ($intOwnerId == 'all') {
                        if($strStartDate == ''){
                            $arrTotalSumQ = $this->Resourceorderdetail->fnGetOwnerPayoutCount($intOwnerId, $strStartDate="", $strEndDate="");
                            $arrOfferCommiTotalSumQ = $this->CpaoffersCommissions->fnGetOwnerCPAOfferPayoutCount($intOwnerId, $strStartDate="", $strEndDate="");
                        }else{
                            $arrTotalSumQ = $this->Resourceorderdetail->fnGetOwnerPayoutCount($intOwnerId, $strStartDate, $strEndDate);
                            $arrOfferCommiTotalSumQ = $this->CpaoffersCommissions->fnGetOwnerCPAOfferPayoutCount($intOwnerId, $strStartDate, $strEndDate);
                        }
                        
                    } else {
                        if($strStartDate == ''){
                            $arrTotalSumQ = $this->Resourceorderdetail->fnGetOwnerPayoutCount($intOwnerId, $strStartDate="", $strEndDate="");
                            $arrOfferCommiTotalSumQ = $this->CpaoffersCommissions->fnGetOwnerCPAOfferPayoutCount($intOwnerId, $strStartDate="", $strEndDate="");
                        }else{
                            $arrTotalSumQ = $this->Resourceorderdetail->fnGetOwnerPayoutCount($intOwnerId, $strStartDate, $strEndDate);
                            $arrOfferCommiTotalSumQ = $this->CpaoffersCommissions->fnGetOwnerCPAOfferPayoutCount($intOwnerId, $strStartDate, $strEndDate);
                        }
                    }
                }
            }
            
            $intTotalAmount = 0;
            if (is_array($arrTotalSumQ) && (count($arrTotalSumQ) > 0)) {
                $intTotalAmount = $arrTotalSumQ['0']['0']['amount'];
            }
            
            $intComissionTotalAmount = 0;
            if (is_array($arrOfferCommiTotalSumQ) && (count($arrOfferCommiTotalSumQ) > 0)) {
                $intComissionTotalAmount = $arrOfferCommiTotalSumQ['0']['0']['commission_cost'];
            }
            
            if ($PayoutType == 'vendor') {
                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'managepayouts', 'action' => 'payoutdetailslist'), true) . "?vendorId=" . base64_encode($intVendorId) . "&payoutType=" . base64_encode($PayoutType) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate)."&payoutsCost=" . base64_encode($intTotalAmount);
            } else {
                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'managepayouts', 'action' => 'payoutdetailslist'), true) . "?ownerId=" . base64_encode($intOwnerId) . "&payoutType=" . base64_encode($PayoutType) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate)."&payoutsCost=" . base64_encode($intTotalAmount);
                $strAjaxOwnerComissionUrl = Router::url(array('controller' => 'managepayouts', 'action' => 'cpacomissionlist'), true) . "?ownerId=" . base64_encode($intOwnerId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate)."&payoutsCost=" . base64_encode($intComissionTotalAmount);
            }
            $arrResponse['status'] = "success";
            $arrResponse['amount'] = isset($intTotalAmount) ? "$" . $intTotalAmount : '$0.00';
            $arrResponse['comission_cost'] = isset($intComissionTotalAmount) ? "$" . $intComissionTotalAmount : '$0.00';
            $arrResponse['list_link'] = $strAjaxPortalStatsUrl;
            $arrResponse['list_link1'] = $strAjaxOwnerComissionUrl;
            $arrResponse['Title'] = "Resources Total Amount";
            $arrResponse['CPA_Comission'] = "CPA Offers Comissions";
            echo json_encode($arrResponse);
            exit;
        }
    }

    public function payoutdetailslist() {
        $intVendorId = base64_decode($_GET['vendorId']);
        $intOwnerId = base64_decode($_GET['ownerId']);
        $payoutType = base64_decode($_GET['payoutType']);
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $payoutsCost = base64_decode($_GET['payoutsCost']);

        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Resourceorderdetail');
        $this->loadModel('Vendors');
        $this->loadModel('Portal');
        $this->loadModel('User');

        if ($payoutType == 'owner') {
            if ($intOwnerId != 'all') {
                $arrPortalId = $this->User->find('all', array('fields' => array('portal_id', 'username'), 'conditions' => array('id' => $intOwnerId)));
                $portalId = $arrPortalId[0]['User']['portal_id'];
            }
        }

        if ($payoutType != '') {
            if ($payoutType == 'vendor') {
                $arrPayoutDetails = $this->Resourceorderdetail->fnGetVendorPayoutNewList($intVendorId, $strStartDate, $strEndDate);
            } else {
                $arrPayoutDetails = $this->Resourceorderdetail->fnGetOwnerPayoutNewList($intOwnerId, $strStartDate, $strEndDate);
            }
        }
        $intKey = 0;
        foreach ($arrPayoutDetails as $arrPayout) {
            $arrOwnerDetails = $this->User->find('list', array('fields' => array('username'), 'conditions' => array('portal_id' => $arrPayout['resource_order_detail']['order_from_portal'])));
            $arrPayoutDetails[$intKey]['username'] = array_pop($arrOwnerDetails);
            $intKey++;
        }

        $this->set("arrPayoutDetails", $arrPayoutDetails);

        if ($intVendorId == 'all') {
            $this->set("vendorName", "All");
        } else {
            $this->set("vendorName", $arrPayoutDetails[0]['vendor_company_details']['company_name']);
        }

        if ($intOwnerId == 'all') {
            $this->set("ownerName", "All");
        } else {
            $ownerName = $arrPortalId[0]['User']['username'];
            $this->set("ownerName", $ownerName);
        }

        $this->set("payoutType", $payoutType);
        if($strStartDate !="" && $strEndDate !=""){
            $this->set("selectedStartDate", $strStartDate);
            $this->set("selectedEndDate", $strEndDate);
        }
        
        $this->set("strStartDate", base64_encode($strStartDate));
        $this->set("strEndDate", base64_encode($strEndDate)); 
        $this->set("intVendorId", base64_encode($intVendorId));
        $this->set("intOwnerId", base64_encode($intOwnerId));
        $this->set("payoutsCost", base64_encode($payoutsCost));
        
    }

    public function payoutsExport() {
        $intVendorId = base64_decode($_GET['vendorId']);
        $intOwnerId = base64_decode($_GET['ownerId']);
        $payoutType = $_GET['payoutType'];
        $strStartDate = base64_decode($_GET['StartDate']);
        $strEndDate = base64_decode($_GET['EndDate']);
        $vendorName = $_GET['vendorName'];
        $ownerName = $_GET['ownerName'];

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Resourceorderdetail');
        $this->loadModel('User');

//        if ($payoutType == 'owner') {
//            if ($intOwnerId != 'all') {
//                $arrPortalId = $this->User->find('all', array('fields' => array('portal_id'), 'conditions' => array('id' => $intOwnerId)));
//                $portalId = $arrPortalId[0]['User']['portal_id'];
//            }
//        }

        if ($payoutType != '') {
            if ($payoutType == 'vendor') {
                $arrPayoutDetails = $this->Resourceorderdetail->fnGetVendorPayoutNewList($intVendorId, $strStartDate, $strEndDate);
            } else {
                $arrPayoutDetails = $this->Resourceorderdetail->fnGetOwnerPayoutNewList($intOwnerId, $strStartDate, $strEndDate);
            }
        }

        if (is_array($arrPayoutDetails) && count($arrPayoutDetails) > 0) {
            if ($payoutType == 'vendor') {
                $strFileName = "Vendor_Payouts_Reports.xls";
                if ($intVendorId == 'all') {
                    $reportName = "All Vendor Payouts Report";
                } else {
                    $reportName = ucfirst($vendorName) . " Payouts Report";
                }
//                $labelName = "Vendor Name";
            } else {

                $strFileName = "Owner_Payouts_Reports.xls";
                if ($intOwnerId == 'all') {
                    $reportName = "All Owner Payouts Report";
                } else {
                    $reportName = ucfirst($ownerName) . " Payouts Report";
                }
//                $labelName = "Owner Name";
            }

            $intFrCnt = 0;
            $intRowCnt = 6;
            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Payouts Report")
                    ->setSubject("Payouts Report")
                    ->setDescription("Payouts Report")
                    ->setKeywords("Payouts Report")
                    ->setCategory("Payouts Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'First Name')
                    ->setCellValue('C5', 'Last Name')
                    ->setCellValue('D5', 'Company Name')
                    ->setCellValue('E5', 'Street Address')
                    ->setCellValue('F5', 'City')
                    ->setCellValue('G5', 'State')
                    ->setCellValue('H5', 'Zip Code')
                    ->setCellValue('I5', 'Amount Owed')
                    ->setCellValue('J5', 'Payment Date');
//                    ->setCellValue('K5', 'Bank Routing Number')
//                    ->setCellValue('L5', 'Bank Account Number');

            foreach ($arrPayoutDetails as $k => $arrPayouts) {

                $this->loadModel('Vendorpayout');
                $VendorPaymentDetails = $this->Vendorpayout->find('all', array('conditions' => array('vendor_id' => $arrPayouts['resource_order_detail']['vendor_id'])));

                $this->loadModel('Vendorcompany');
                $arrVendorDetail = $this->Vendorcompany->fnGetVendorDetails($arrPayouts['resource_order_detail']['vendor_id']);

                $arrEmployersDetails = $this->User->find('all', array('fields' => array('id'), 'conditions' => array('portal_id' => $arrPayouts['resource_order_detail']['order_from_portal'])));
                $this->loadModel('Employer');
                $OwnerPaymentDetails = $this->Employer->find('all', array('conditions' => array('employer_id' => $arrEmployersDetails[0]['User']['id'])));

                if ($payoutType == 'vendor') {
                    $firstName = stripslashes($arrVendorDetail[0]['vendors']['vendor_first_name']);
                    $lastName = stripslashes($arrVendorDetail[0]['vendors']['vendor_last_name']);
                    $companyName = stripslashes($arrVendorDetail[0]['vendor_company_details']['company_name']);
                    $streetAddress = stripslashes($arrVendorDetail[0]['vendor_company_details']['address']);
                    $city = stripslashes($arrVendorDetail[0]['vendor_company_details']['city']);
                    $state = stripslashes($arrVendorDetail[0]['vendor_company_details']['state']);
                    $zipCode = stripslashes($arrVendorDetail[0]['vendor_company_details']['zip']);
                    $AmountOwed = isset($arrPayouts[0]['vendor_cost']) ? "$" . ($arrPayouts[0]['vendor_cost']) : '$0.00';
//                    $bankAccountNumber = stripslashes($VendorPaymentDetails[0]['Vendorpayout']['bank_account_number']);
//                    $bankRoutingNumber = stripslashes($VendorPaymentDetails[0]['Vendorpayout']['bank_routing_number']);

                    $PaymentDate = $arrPayouts['resource_order_detail']['order_detail_creation_date_time'];
                } else {
                    $firstName = stripslashes($OwnerPaymentDetails[0]['Employer']['employer_user_fname']);
                    $lastName = stripslashes($OwnerPaymentDetails[0]['Employer']['employer_user_lname']);
                    $companyName = stripslashes($OwnerPaymentDetails[0]['Employer']['employer_company_name']);
                    $streetAddress = stripslashes($OwnerPaymentDetails[0]['Employer']['employer_address']);
                    $city = stripslashes($OwnerPaymentDetails[0]['Employer']['employer_city']);
                    $state = stripslashes($OwnerPaymentDetails[0]['Employer']['employer_state']);
                    $zipCode = stripslashes($OwnerPaymentDetails[0]['Employer']['employer_pin']);
                    $AmountOwed = isset($arrPayouts[0]['portal_owner_cost']) ? "$" . ($arrPayouts[0]['portal_owner_cost']) : '$0.00';
//                    $bankAccountNumber = stripslashes($OwnerPaymentDetails[0]['Employer']['bank_account_number']);
//                    $bankRoutingNumber = stripslashes($OwnerPaymentDetails[0]['Employer']['bank_routing_number']);
                    $PaymentDate = $arrPayouts['resource_order_detail']['order_detail_creation_date_time'];
                }

                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, ucfirst($firstName))
                        ->setCellValue('C' . $intRowCnt, ucfirst($lastName))
                        ->setCellValue('D' . $intRowCnt, ucfirst($companyName))
                        ->setCellValue('E' . $intRowCnt, $streetAddress)
                        ->setCellValue('F' . $intRowCnt, $city)
                        ->setCellValue('G' . $intRowCnt, $state)
                        ->setCellValue('H' . $intRowCnt, $zipCode)
                        ->setCellValue('I' . $intRowCnt, $AmountOwed)
                        ->setCellValue('J' . $intRowCnt, $PaymentDate);
//                        ->setCellValue('J' . $intRowCnt, isset($bankAccountNumber) ? $bankAccountNumber : "-")
//                        ->setCellValue('K' . $intRowCnt, isset($bankRoutingNumber) ? $bankRoutingNumber : '-');

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('J')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('K')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('L')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);  //set column C width

                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(30);  //set row 4 height

                $intFrCnt++;
                $intRowCnt++;
            }
            $objPHPExcel->getActiveSheet()->mergeCells('B2:E2');
            $objPHPExcel->getActiveSheet()->setCellValue('B2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
                $objPHPExcel->getActiveSheet()->setCellValue('B3', date("Y-m-d", strtotime($strStartDate)) . " - " . date("Y-m-d", strtotime($strEndDate)));
                $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setSize(15);  //set wrapped for some long text message
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
            $arrResponse['message'] = "There are no payout in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function payoutsPayment() {
        $intVendorId = $this->request->data['VendorId'];
        $intOwnerId = $this->request->data['OwnerId'];
        $strStartDate = $this->request->data['strFromDate'];
        $strEndDate = $this->request->data['strToDate'];
        $payoutCost = str_replace("$", "", $this->request->data['payoutCost']);
        $payoutType = $this->request->data['PayoutType'];
        $arrLoggedUser = $this->Auth->user();

        $this->loadModel('Resourceorderdetail');
        $this->loadModel('User');
        $this->loadModel('PayoutPaymentDetails');

        if ($payoutCost != '' && $payoutCost != '0.00') {
            if ($payoutType == 'owner') {
                if ($intOwnerId != '') {
                    $arrPortalId = $this->User->find('all', array('fields' => array('portal_id'), 'conditions' => array('id' => $intOwnerId)));
                    $portalId = $arrPortalId[0]['User']['portal_id'];
                }
            }

            if ($payoutType != '') {
                if ($payoutType == 'vendor') {
                    $arrPayoutDetails = $this->Resourceorderdetail->fnGetVendorPayoutNewList($intVendorId, $strStartDate, $strEndDate);
                } else {
                    $arrPayoutDetails = $this->Resourceorderdetail->fnGetOwnerPayoutNewList($intOwnerId, $strStartDate, $strEndDate);
                }
            }
            
            foreach ($arrPayoutDetails as $payoutsUp) {
                $arrEmployerId = $this->User->find('all', array('fields' => array('id'), 'conditions' => array('portal_id' => $payoutsUp['resource_order_detail']['order_from_portal'])));
                $arrPostedData = array();
                $arrPostedData['payout_from'] = $arrLoggedUser['id'];
                $arrPostedData['vendor_id'] = $payoutsUp['resource_order_detail']['vendor_id'];
                $arrPostedData['owner_id'] = $arrEmployerId[0]['User']['id'];
                $arrPostedData['order_from_portal'] = $payoutsUp['resource_order_detail']['order_from_portal'];
                $arrPostedData['payout_for'] = $payoutType;
                $arrPostedData['payout_amount'] = $payoutCost;
                $arrPostedData['payout_status'] = '1';
                $arrPostedData['payout_from_date'] = $strStartDate;
                $arrPostedData['payout_to_date'] = $strEndDate;
                $arrPostedData['payout_date'] = date('Y-m-d h:i:s');
                $payoutInserted = $this->PayoutPaymentDetails->save($arrPostedData);
                $payoutUpdated = $this->Resourceorderdetail->updateAll(array('payout_status' => '1'), array('order_id' => $payoutsUp['resource_order_detail']['order_id']));
            }

            if ($payoutInserted) {
                $compMessage = $this->Components->load('Message');
                $strForMessage = "<div class='alert alert-success'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-success.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> payout payment successfully.</div>";
                $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'success');
                $arrResponseData['message'] = $strForMessage;
                $arrResponseData['type'] = 'success';
            } else {
                $compMessage = $this->Components->load('Message');
                $strForMessage = "<div class='alert alert-danger'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-error.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> payout payment failed. please try again.</div>";
                $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'alert-danger');
                $arrResponseData['message'] = $strForMessage;
                $arrResponseData['type'] = 'fail';
            }
        } else {
            $compMessage = $this->Components->load('Message');
            $strForMessage = "<div class='alert alert-danger'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-error.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> payout payment failed. please try again.</div>";
            $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'alert-danger');
            $arrResponseData['message'] = $strForMessage;
            $arrResponseData['type'] = 'fail';
        }

        echo json_encode($arrResponseData);
        exit;
    }
   
    public function paidpayouts() {
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Vendorcompany');
        $this->loadModel('PayoutPaymentDetails');
        $this->loadModel('User');
        $this->loadModel('CpaoffersCommissions');

        $arrVendorDetail = $this->Vendorcompany->fnGetVendorCompanyName();
        $this->set("arrVendorDetail", $arrVendorDetail);
        $arrPortalOwnerDetail = $this->User->fnGetPortalOwnerName();
        $this->set("arrPortalOwnerDetail", $arrPortalOwnerDetail);

        if ($this->request->is('Post')) {
            $PayoutType = $this->request->data['PayoutType'];
            $intVendorId = isset($this->request->data['Vendors']) ? $this->request->data['Vendors'] : null;
            $intOwnerId = isset($this->request->data['Owners']) ? $this->request->data['Owners'] : null;
            $strFromDate = $this->request->data['strFromDate'];
            $strToDate = $this->request->data['strToDate'];

            if (!empty($strFromDate)) {
                $strStartDate = $strFromDate . " 00:00:00";
            } else {
                $strStartDate = date('Y-m') . "-01 00:00:00";
            }
            if (!empty($strToDate)) {
                $strEndDate = $strToDate . " 23:59:59";
            } else {
                $strEndDate = date('Y-m') . "-31 23:59:59";
            }

            if ($PayoutType != '') {
                if ($PayoutType == 'vendor') {
                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetVendorPaidPayoutCount($intVendorId, $strStartDate, $strEndDate);
                } else {
                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetOwnerPaidPayoutCount($intOwnerId, $strStartDate, $strEndDate);
                    $arrOfferCommiPaid = $this->CpaoffersCommissions->fnGetOwnerPaidComissionCount($intOwnerId, $strStartDate, $strEndDate);
                }
            }

            $intTotalAmount = 0;
            if (is_array($arrTotalPaid) && (count($arrTotalPaid) > 0)) {
                $intTotalAmount = $arrTotalPaid['0']['0']['amount'];
            }
            
             $intComissionTotalAmount = 0;
            if (is_array($arrOfferCommiPaid) && (count($arrOfferCommiPaid) > 0)) {
                $intComissionTotalAmount = $arrOfferCommiPaid['0']['0']['commission_cost'];
            }

            if ($PayoutType == 'vendor') {
                $arrVendorDetails = $this->Vendorcompany->find('all', array('conditions' => array('vendor_id' => $intVendorId)));
                $companyName = $arrVendorDetails[0]['Vendorcompany']['company_name'];
                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'managepayouts', 'action' => 'paidpayoutlist'), true) . "?vendorId=" . base64_encode($intVendorId) . "&vendorName=" . base64_encode($companyName) . "&payoutType=" . base64_encode($PayoutType) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
            } else {
                $arrOwnerDetails = $this->User->find('all', array('conditions' => array('id' => $intOwnerId)));
                $ownerName = $arrOwnerDetails[0]['User']['username'];
                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'managepayouts', 'action' => 'paidpayoutlist'), true) . "?ownerId=" . base64_encode($intOwnerId) . "&ownerName=" . base64_encode($ownerName) . "&payoutType=" . base64_encode($PayoutType) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                $strAjaxOwnerComissionUrl = Router::url(array('controller' => 'managepayouts', 'action' => 'paidcpacomissionlist'), true) . "?ownerId=" . base64_encode($intOwnerId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate)."&payoutsCost=" . base64_encode($intComissionTotalAmount);
            }
            $arrResponse['status'] = "success";
            $arrResponse['amount'] = isset($intTotalAmount) ? "$" . $intTotalAmount : '$0.00';
            $arrResponse['comission_cost'] = isset($intComissionTotalAmount) ? "$" . $intComissionTotalAmount : '$0.00';
            $arrResponse['list_link'] = $strAjaxPortalStatsUrl;
            $arrResponse['list_link1'] = $strAjaxOwnerComissionUrl;
            $arrResponse['Title'] = "Total Amount";
            $arrResponse['CPA_Comission'] = "Offers Paid Comissions";
            
            echo json_encode($arrResponse);
            exit;
        }
    }

    public function paidpayoutlist() {
        $arrLoggedUser = $this->Auth->user();
        $intVendorId = base64_decode($_GET['vendorId']);
        $intOwnerId = base64_decode($_GET['ownerId']);
        $payoutType = base64_decode($_GET['payoutType']);
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        $this->loadModel('PayoutPaymentDetails');
        $this->loadModel('User');
        $this->loadModel('Vendorcompany');

        if ($payoutType != '') {
            if ($payoutType == 'vendor') {
                $arrPaidPayoutDetails = $this->PayoutPaymentDetails->fnGetVendorPaidPayoutNewList($intVendorId, $strStartDate, $strEndDate);
            } else {
                $arrPaidPayoutDetails = $this->PayoutPaymentDetails->fnGetOwnerPaidPayoutNewList($intOwnerId, $strStartDate, $strEndDate);
            }
        }

        $intKey = 0;
        foreach ($arrPaidPayoutDetails as $arrPayout) {
            if ($payoutType == 'owner') {
                $arrOwnerDetails = $this->User->find('list', array('fields' => array('username'), 'conditions' => array('id' => $arrPayout['payout_payment_details']['owner_id'])));
                $arrPaidPayoutDetails[$intKey]['username'] = array_pop($arrOwnerDetails);
            } else {
                $arrVendorDetails = $this->Vendorcompany->find('list', array('fields' => array('vendor_company_details_id', 'company_name'), 'conditions' => array('vendor_id' => $arrPayout['payout_payment_details']['vendor_id'])));
                $arrPaidPayoutDetails[$intKey]['company_name'] = array_pop($arrVendorDetails);
            }
            $intKey++;
        }

        if ($intVendorId == 'all') {
            $this->set("vendorName", "All");
        } else {
            $this->set("vendorName", $arrPaidPayoutDetails[0]['company_name']);
        }

        if ($intOwnerId == 'all') {
            $this->set("ownerName", "All");
        } else {
            $ownerName = $arrPaidPayoutDetails[0]['username'];
            $this->set("ownerName", $ownerName);
        }

        $this->set("arrPayoutDetails", $arrPaidPayoutDetails);
        $this->set("payoutType", $payoutType);
        $this->set("strStartDate", base64_encode($strStartDate));
        $this->set("strEndDate", base64_encode($strEndDate));
        $this->set("intVendorId", base64_encode($intVendorId));
        $this->set("intOwnerId", base64_encode($intOwnerId));
        $this->set("selectedStartDate", date("Y-m-d", strtotime($strStartDate)));
        $this->set("selectedEndDate", date("Y-m-d", strtotime($strEndDate)));
    }

    public function paidPayoutsExport() {
        $intVendorId = base64_decode($_GET['vendorId']);
        $intOwnerId = base64_decode($_GET['ownerId']);
        $payoutType = $_GET['payoutType'];
        $strStartDate = base64_decode($_GET['StartDate']);
        $strEndDate = base64_decode($_GET['EndDate']);
        $vendorName = $_GET['vendorName'];
        $ownerName = $_GET['ownerName'];

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('PayoutPaymentDetails');

        if ($payoutType != '') {
            if ($payoutType == 'vendor') {
                $arrPaidPayoutDetails = $this->PayoutPaymentDetails->fnGetVendorPaidPayoutList($intVendorId, $strStartDate, $strEndDate);
            } else {
                $arrPaidPayoutDetails = $this->PayoutPaymentDetails->fnGetOwnerPaidPayoutList($intOwnerId, $strStartDate, $strEndDate);
            }
        }

        if (is_array($arrPaidPayoutDetails) && count($arrPaidPayoutDetails) > 0) {
            if ($payoutType == 'vendor') {
                $strFileName = "Paid_Payouts_Reports.xls";
                $reportName = ucfirst($vendorName) . " Paid Payouts Report";
                $labelName = "Vendor Name";
            } else {
                $strFileName = "Paid_Payouts_Reports.xls";
                $reportName = ucfirst($ownerName) . " Paid Payouts Report";
                $labelName = "Owner Name";
            }

            $intFrCnt = 0;
            $intRowCnt = 6;
            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Paid Payouts Report")
                    ->setSubject("Paid Payouts Report")
                    ->setDescription("Paid Payouts Report")
                    ->setKeywords("Paid Payouts Report")
                    ->setCategory("Paid Payouts Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', $labelName)
                    ->setCellValue('C5', 'Cost')
                    ->setCellValue('D5', 'Date');

            foreach ($arrPaidPayoutDetails as $k => $arrPaidPayouts) {

                if ($payoutType == 'vendor') {
                    $VendorName = stripslashes($vendorName);
                } else {
                    $VendorName = stripslashes($ownerName);
                }
                $Cost = isset($arrPaidPayouts['payout_payment_details']['payout_amount']) ? "$" . ($arrPaidPayouts['payout_payment_details']['payout_amount']) : '$0.00';
                $Date = $arrPaidPayouts['payout_payment_details']['payout_date'];
                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, ucfirst($VendorName))
                        ->setCellValue('C' . $intRowCnt, $Cost)
                        ->setCellValue('D' . $intRowCnt, $Date);

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);  //set column C width

                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(20);  //set row 4 height

                $intFrCnt++;
                $intRowCnt++;
            }
            $objPHPExcel->getActiveSheet()->mergeCells('B2:D2');
            $objPHPExcel->getActiveSheet()->setCellValue('B2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
                $objPHPExcel->getActiveSheet()->setCellValue('B3', date("Y-m-d", strtotime($strStartDate)) . " - " . date("Y-m-d", strtotime($strEndDate)));
                $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setSize(15);  //set wrapped for some long text message
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
            $arrResponse['message'] = "There are no paid payout in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }
    
    public function cpacomissionlist() {
        $intOwnerId = base64_decode($_GET['ownerId']);
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $payoutsCost = base64_decode($_GET['payoutsCost']);

        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('CpaoffersCommissions');
        $this->loadModel('User');
        $this->loadModel('Employer');

        if ($intOwnerId != 'all') {
            $arrPortalId = $this->User->find('all', array('fields' => array('portal_id', 'username'), 'conditions' => array('id' => $intOwnerId)));
            $portalId = $arrPortalId[0]['User']['portal_id'];
        }
       
        if ($intOwnerId != '') {
            $arrPayoutDetails = $this->CpaoffersCommissions->fnGetOwnerCPAComissionList($intOwnerId, $strStartDate, $strEndDate);
        }  
        
        $intKey = 0;
        foreach ($arrPayoutDetails as $arrPayout) {
            $arrOwnerDetails = $this->User->find('list', array('fields' => array('username'), 'conditions' => array('id' => $arrPayout['cpa_offers_commissions']['portal_owner_id'])));
            $arrPayoutDetails[$intKey]['username'] = array_pop($arrOwnerDetails);
            $intKey++;
        }
        
        $this->set("arrPayoutDetails", $arrPayoutDetails);
        if ($intOwnerId == 'all') {
            $this->set("ownerName", "All");
        } else {
            $ownerName = $arrPortalId[0]['User']['username'];
            $this->set("ownerName", $ownerName);
        }

        if($strStartDate !="" && $strEndDate !=""){
            $this->set("selectedStartDate", $strStartDate);
            $this->set("selectedEndDate", $strEndDate);
        }
        
        $this->set("strStartDate", base64_encode($strStartDate));
        $this->set("strEndDate", base64_encode($strEndDate)); 
        $this->set("intOwnerId", base64_encode($intOwnerId));
        $this->set("payoutsCost", base64_encode($payoutsCost));
    }
    
    public function cpaComissionExport() {
        $intOwnerId = base64_decode($_GET['ownerId']);
        $strStartDate = base64_decode($_GET['StartDate']);
        $strEndDate = base64_decode($_GET['EndDate']);
        $ownerName = $_GET['ownerName'];

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
       
        $this->loadModel('Resourceorderdetail');
        $this->loadModel('User');
        $this->loadModel('CpaoffersCommissions');
     
        if ($intOwnerId != 'all') {
            $arrPortalId = $this->User->find('all', array('fields' => array('portal_id', 'username'), 'conditions' => array('id' => $intOwnerId)));
            $portalId = $arrPortalId[0]['User']['portal_id'];
        }
        
        if ($intOwnerId != '') {
            $arrPayoutDetails = $this->CpaoffersCommissions->fnGetOwnerCPAComissionList($intOwnerId, $strStartDate, $strEndDate);
        }  
        
        $intKey = 0;
        foreach ($arrPayoutDetails as $arrPayout) {
            $arrOwnerDetails = $this->User->find('list', array('fields' => array('username'), 'conditions' => array('id' => $arrPayout['cpa_offers_commissions']['portal_owner_id'])));
            $arrPayoutDetails[$intKey]['username'] = array_pop($arrOwnerDetails);
            $intKey++;
        }
        
        if (is_array($arrPayoutDetails) && count($arrPayoutDetails) > 0) {
            $strFileName = "Owner_Comission_Reports.xls";
            if ($intOwnerId == 'all') {
                $reportName = "All Owner Comission Report";
            } else {
                $reportName = ucfirst($ownerName) . " Comission Report";
            }

            $intFrCnt = 0;
            $intRowCnt = 6;
            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Payouts Report")
                    ->setSubject("Payouts Report")
                    ->setDescription("Payouts Report")
                    ->setKeywords("Payouts Report")
                    ->setCategory("Payouts Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'Offer Id')
                    ->setCellValue('C5', 'Offer Name')
                    ->setCellValue('D5', 'Owner Name')
                    ->setCellValue('E5', 'Comission Cost')
                    ->setCellValue('F5', 'Added Date');

            foreach ($arrPayoutDetails as $k => $arrPayouts) {

                    $offer_id = stripslashes($arrPayouts['cpa_offers_commissions']['offer_id']);
                    $offer_name = stripslashes($arrPayouts['cpa_offers']['offer_name']);
                    $owner_name = stripslashes($arrPayouts['username']);
                    $commission_cost = stripslashes($arrPayouts[0]['commission_cost']);
                    $AddedDate = date("F j, Y", strtotime($arrPayouts['cpa_offers_commissions']['added_date']));

                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, ucfirst($offer_id))
                        ->setCellValue('C' . $intRowCnt, ucfirst($offer_name))
                        ->setCellValue('D' . $intRowCnt, ucfirst($owner_name))
                        ->setCellValue('E' . $intRowCnt, "$".$commission_cost)
                        ->setCellValue('F' . $intRowCnt, $AddedDate);

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);  //set column C width

                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(30);  //set row 4 height

                $intFrCnt++;
                $intRowCnt++;
            }
            $objPHPExcel->getActiveSheet()->mergeCells('B2:E2');
            $objPHPExcel->getActiveSheet()->setCellValue('B2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
                $objPHPExcel->getActiveSheet()->setCellValue('B3', date("Y-m-d", strtotime($strStartDate)) . " - " . date("Y-m-d", strtotime($strEndDate)));
                $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setSize(15);  //set wrapped for some long text message
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
            $arrResponse['message'] = "There are no comission in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }
    
    public function payoutsComissionPayment() {
//        Configure::write('debug',2);
        $intOwnerId = $this->request->data['OwnerId'];
        $strStartDate = $this->request->data['strFromDate'];
        $strEndDate = $this->request->data['strToDate'];
        $payoutCost = str_replace("$", "", $this->request->data['payoutCost']);
        $arrLoggedUser = $this->Auth->user();

        $this->loadModel('User');
        $this->loadModel('CpaoffersCommissions');

            if ($payoutCost != '' && $payoutCost != '0.00') {
                if ($intOwnerId != '') {
                    $arrPayoutDetails = $this->CpaoffersCommissions->fnGetOwnerCPAComissionList($intOwnerId, $strStartDate, $strEndDate);
                }  
            
            foreach ($arrPayoutDetails as $payoutsUp) {
                $currentDate = date("Y-m-d h:i:s");
                $payoutUpdated = $this->CpaoffersCommissions->updateAll(array('payout_status' => '1','payout_date' => "'".$currentDate."'"), array('portal_owner_id' => $payoutsUp['cpa_offers_commissions']['portal_owner_id']));
            }

            if ($payoutUpdated) {
                $compMessage = $this->Components->load('Message');
                $strForMessage = "<div class='alert alert-success'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-success.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>&times;</a> cpa offer comission payment successfully.</div>";
                $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'success');
                $arrResponseData['message'] = $strForMessage;
                $arrResponseData['type'] = 'success';
            } else {
                $compMessage = $this->Components->load('Message');
                $strForMessage = "<div class='alert alert-danger'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-error.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>&times;</a> cpa offer comission payment failed. please try again.</div>";
                $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'alert-danger');
                $arrResponseData['message'] = $strForMessage;
                $arrResponseData['type'] = 'fail';
            }
        } else {
            $compMessage = $this->Components->load('Message');
            $strForMessage = "<div class='alert alert-danger'><img alt='image description' src='http://www.rothrsolutions.com/images/icon-alert-error.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>&times;</a> cpa offer comission payment failed. please try again.</div>";
            $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'alert-danger');
            $arrResponseData['message'] = $strForMessage;
            $arrResponseData['type'] = 'fail';
        }

        echo json_encode($arrResponseData);
        exit;
    }
    
    public function paidcpacomissionlist() {
//         Configure::write('debug',2);
        $arrLoggedUser = $this->Auth->user();
        $intOwnerId = base64_decode($_GET['ownerId']);
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        $this->loadModel('User');
        $this->loadModel('CpaoffersCommissions');
        
        if ($intOwnerId != 'all') {
            $arrPortalId = $this->User->find('all', array('fields' => array('portal_id', 'username'), 'conditions' => array('id' => $intOwnerId)));
            $portalId = $arrPortalId[0]['User']['portal_id'];
        }
       
        if ($intOwnerId != '') {
            $arrPaidPayoutDetails = $this->CpaoffersCommissions->fnGetOwnerPaidComissionList($intOwnerId, $strStartDate, $strEndDate);
        }  
        
        $intKey = 0;
        foreach ($arrPaidPayoutDetails as $arrPayout) {
            $arrOwnerDetails = $this->User->find('list', array('fields' => array('username'), 'conditions' => array('id' => $arrPayout['cpa_offers_commissions']['portal_owner_id'])));
            $arrPaidPayoutDetails[$intKey]['username'] = array_pop($arrOwnerDetails);
            $intKey++;
        }

        if ($intOwnerId == 'all') {
            $this->set("ownerName", "All");
        } else {
            $ownerName = $arrPaidPayoutDetails[0]['username'];
            $this->set("ownerName", $ownerName);
        }

        $this->set("arrPayoutDetails", $arrPaidPayoutDetails);
        $this->set("strStartDate", base64_encode($strStartDate));
        $this->set("strEndDate", base64_encode($strEndDate));
        $this->set("intOwnerId", base64_encode($intOwnerId));
        $this->set("selectedStartDate", date("Y-m-d", strtotime($strStartDate)));
        $this->set("selectedEndDate", date("Y-m-d", strtotime($strEndDate)));
    }
    
    public function cpaComissionPaidExport() {
        $intOwnerId = base64_decode($_GET['ownerId']);
        $strStartDate = base64_decode($_GET['StartDate']);
        $strEndDate = base64_decode($_GET['EndDate']);
        $ownerName = $_GET['ownerName'];

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
       
        $this->loadModel('Resourceorderdetail');
        $this->loadModel('User');
        $this->loadModel('CpaoffersCommissions');
     
        if ($intOwnerId != 'All') {
            $arrPortalId = $this->User->find('all', array('fields' => array('portal_id', 'username'), 'conditions' => array('id' => $intOwnerId)));
            $portalId = $arrPortalId[0]['User']['portal_id'];
        }
        
        if ($intOwnerId != '') {
            $arrPayoutDetails = $this->CpaoffersCommissions->fnGetOwnerPaidComissionList($intOwnerId, $strStartDate, $strEndDate);
        }  
        
        $intKey = 0;
        foreach ($arrPayoutDetails as $arrPayout) {
            $arrOwnerDetails = $this->User->find('list', array('fields' => array('username'), 'conditions' => array('id' => $arrPayout['cpa_offers_commissions']['portal_owner_id'])));
            $arrPayoutDetails[$intKey]['username'] = array_pop($arrOwnerDetails);
            $intKey++;
        }
        
        if (is_array($arrPayoutDetails) && count($arrPayoutDetails) > 0) {
            $strFileName = "Comission_Paid_Reports.xls";
            if ($intOwnerId == 'All') {
                $reportName = "All Owner Comission Paid Report";
            } else {
                $reportName = ucfirst($ownerName) . " Comission Paid Report";
            }

            $intFrCnt = 0;
            $intRowCnt = 6;
            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Payouts Report")
                    ->setSubject("Payouts Report")
                    ->setDescription("Payouts Report")
                    ->setKeywords("Payouts Report")
                    ->setCategory("Payouts Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'Offer Id')
                    ->setCellValue('C5', 'Offer Name')
                    ->setCellValue('D5', 'Owner Name')
                    ->setCellValue('E5', 'Comission Cost')
                    ->setCellValue('F5', 'Added Date');

            foreach ($arrPayoutDetails as $k => $arrPayouts) {

                    $offer_id = stripslashes($arrPayouts['cpa_offers_commissions']['offer_id']);
                    $offer_name = stripslashes($arrPayouts['cpa_offers']['offer_name']);
                    $owner_name = stripslashes($arrPayouts['username']);
                    $commission_cost = stripslashes($arrPayouts[0]['commission_cost']);
                    $AddedDate = date("F j, Y", strtotime($arrPayouts['cpa_offers_commissions']['added_date']));

                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, ucfirst($offer_id))
                        ->setCellValue('C' . $intRowCnt, ucfirst($offer_name))
                        ->setCellValue('D' . $intRowCnt, ucfirst($owner_name))
                        ->setCellValue('E' . $intRowCnt, "$".$commission_cost)
                        ->setCellValue('F' . $intRowCnt, $AddedDate);

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);  //set column C width

                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(30);  //set row 4 height

                $intFrCnt++;
                $intRowCnt++;
            }
            $objPHPExcel->getActiveSheet()->mergeCells('B2:E2');
            $objPHPExcel->getActiveSheet()->setCellValue('B2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
                $objPHPExcel->getActiveSheet()->setCellValue('B3', date("Y-m-d", strtotime($strStartDate)) . " - " . date("Y-m-d", strtotime($strEndDate)));
                $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setSize(15);  //set wrapped for some long text message
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
            $arrResponse['message'] = "There are no comission in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }
}
