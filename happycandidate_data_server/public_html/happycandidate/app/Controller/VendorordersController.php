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
class VendorordersController extends AppController {

    var $helpers = array('Html', 'Form');

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Vendororders';

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

    public function addorderupdates($intOrderMId = "") {
        $this->layout = NULL;
        $this->autoRender = false;
        $arrResponse = array();
        $arrLoggedUser = $this->Auth->user();
        if ($intOrderMId) {
            $this->loadModel('Serviceupdates');
            $this->loadModel('Resourceorderdetail');
            $arrNewOrders = $this->Resourceorderdetail->find('all', array('conditions' => array('order_detail_id' => $intOrderMId)));

            if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
                $this->loadModel('Resourceorder');
                $this->loadModel('Candidate');
                $this->loadModel('Resources');
                $intFrCnt = 0;
                foreach ($arrNewOrders as $arrOrder) {
                    $intOrderId = $arrOrder['Resourceorderdetail']['order_id'];
                    $arrOrderDetail = $this->Resourceorder->find('all', array('conditions' => array('resource_order_id' => $intOrderId)));
                    if (is_array($arrOrderDetail) && (count($arrOrderDetail) > 0)) {
                        $arrNewOrders[$intFrCnt]['mainorder'] = $arrOrderDetail[0];
                    }
                    $intServiceId = $arrOrder['Resourceorderdetail']['product_id'];
                    $arrServiceDetail = $this->Resources->find('all', array('conditions' => array('productd_id' => $intServiceId)));
                    if (is_array($arrServiceDetail) && (count($arrServiceDetail) > 0)) {
                        $arrNewOrders[$intFrCnt]['service'] = $arrServiceDetail[0];
                    }
                    $intCustomerId = $arrOrder['Resourceorderdetail']['seeker_id'];
                    $arrCustomerDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $intCustomerId)));
                    if (is_array($arrCustomerDetail) && (count($arrCustomerDetail) > 0)) {
                        $arrNewOrders[$intFrCnt]['customer'] = $arrCustomerDetail[0];
                    }
                    $intFrCnt++;
                }
            }


            $arrOrderUpdateDetail['Serviceupdates']['order_id'] = $intOrderMId;
            $arrOrderUpdateDetail['Serviceupdates']['order_name'] = $arrNewOrders[0]['mainorder']['Resourceorder']['order_name'];
            $arrOrderUpdateDetail['Serviceupdates']['order_update_from'] = $arrLoggedUser['vendor_id'];
            $arrOrderUpdateDetail['Serviceupdates']['order_service_update_to'] = $arrNewOrders[0]['customer']['Candidate']['candidate_id'];
            $arrOrderUpdateDetail['Serviceupdates']['order_service_update_to'] = $arrNewOrders[0]['customer']['Candidate']['candidate_id'];
            $arrOrderUpdateDetail['Serviceupdates']['order_update_by_type'] = "vendor";
            $arrOrderUpdateDetail['Serviceupdates']['order_updated_by_name'] = $arrLoggedUser['vendor_first_name'] . " " . $arrLoggedUser['vendor_last_name'];
            $arrOrderUpdateDetail['Serviceupdates']['order_service_subject'] = addslashes($this->request->data['content_title']);

            $arrOrderUpdateDetail['Serviceupdates']['order_updated_text'] = htmlspecialchars(addslashes($this->request->data['main_content']));
            //echo '<pre>';print_r($arrNewOrders);print_r($arrOrderUpdateDetail); exit();
            $this->Serviceupdates->set($arrOrderUpdateDetail);
            $arrOrderSaved = $this->Serviceupdates->save($arrOrderUpdateDetail);

            $this->loadModel('Notification');
            $arrSystemNotification = array();

            $arrLoggedUser = $this->Auth->user();
            /* print_R($arrLoggedUser['vendor_id']);
              exit(); */

            $candidate_id = $this->Resourceorderdetail->field('seeker_id', array('order_detail_id' => $intOrderMId));
            $arrSystemNotification['Notification']['candidate_id'] = $candidate_id;
            $arrSystemNotification['Notification']['reminder_type'] = 'orderupdate';
            $arrSystemNotification['Notification']['reminder_id'] = $intOrderMId;
            $arrSystemNotification['Notification']['notification_created_by'] = $arrLoggedUser['vendor_id'];

            $isSystemNotified = $this->Notification->save($arrSystemNotification);

            if ($isSystemNotified) {
                $this->loadModel('Candidate');
                $this->loadModel('Resourceorderdetail');

                //$candidate_email  =  $this->Candidate->find('first', array('candidate_id' => $candidate_id));

                $arrContacterDetail = $this->Candidate->find('first', array('conditions' => array('candidate_id' => $candidate_id)));
                $arrResourcreDetail = $this->Resourceorderdetail->find('first', array('conditions' => array('order_detail_id' => $intOrderMId)));
                // send email to candidate

                $arrContacterDetail['email'] = $arrContacterDetail['Candidate']['candidate_email'];
                $arrContacterDetail['name'] = $arrContacterDetail['Candidate']['candidate_first_name'];
                $arrContacterDetail['vendorname'] = $arrResourcreDetail['Resourceorderdetail']['vendor_name'];
                $arrContacterDetail['product_name'] = $arrResourcreDetail['Resourceorderdetail']['product_name'];
                $this->fnSendVendorUpdateEmail($arrContacterDetail);
            }

            if ($arrOrderSaved) {
                $intCreatedContentId = $this->Serviceupdates->getLastInsertID();
                $this->loadModel('Vendorfiles');
                if (is_array($_FILES) && (count($_FILES) > 0)) {

                    if ($_FILES['profilePicture']['name'] != "") {
                        //$get_microtime = $this->fnToGetMicroTime();
                        $strVehicleImgName = $_FILES['profilePicture']['name'];
                        $strFileExt = pathinfo($strVehicleImgName);
                        $customVehicleimgName = $strVehicleImgName;
                        $arrProDetail = array();
                        $strVehicleImageTmpName = $_FILES['profilePicture']['tmp_name'];
                        //echo "--".$strVehicleImageTmpName;
                        //echo "--".$strVehicleImgName;
                        //exit;
                        move_uploaded_file($strVehicleImageTmpName, WWW_ROOT . 'vendorupdates/' . $strVehicleImgName);
                        $arrAlbumPicInfo['Vendorfiles']['vendor_updates_file_title'] = $strVehicleImgName;
                        $arrAlbumPicInfo['Vendorfiles']['vendor_updates_file_path'] = 'vendorupdates/' . $strVehicleImgName;
                        $arrAlbumPicInfo['Vendorfiles']['vendor_updates_file'] = $strVehicleImgName;
                        $arrAlbumPicInfo['Vendorfiles']['vendor_update_id'] = $intCreatedContentId;
                        $arrAlbumPicInfo['Vendorfiles']['vendor_updates_file_status'] = 'active';

                        $this->Vendorfiles->set($arrAlbumPicInfo);
                        $this->Vendorfiles->create(false);
                        $arrAlbumPicSaved = $this->Vendorfiles->save($arrAlbumPicInfo);
                        //print("<pre>");
                        //print_r($_FILES);
                        //exit;
                    }
                }

                $boolUpdated = $this->Resourceorderdetail->updateAll(
                        array('vendor_order_state' => "'Pending'"), array('order_detail_id =' => $intOrderMId)
                );

                $arrResponse['createdid'] = $intCreatedContentId;
                $arrResponse['status'] = 'success';
                $compMessage = $this->Components->load('Message');
                $strForMessage = "You have successfully updated your order.";
                $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'success');
                $arrResponse['message'] = $strMessage;
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('There was some issue, please try again', 'error');
                $arrResponse['status'] = 'fail';
                $arrResponse['message'] = $strMessage;
            }
        } else {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('Sorry, Some Parameter missing.', 'error');
            $arrResponse['status'] = 'fail';
            $arrResponse['message'] = $strMessage;
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function mediauploader($isServiceImage = "", $strVendor = "") {
        $arrResponse = array();
        $this->autoRender = false;
        // code to get the html content
        $view = new View($this, false);
        if ($isServiceImage) {
            $view->set('forService', $strVendor);
        }

        $strMediaUploaderHtml = $view->element('vendormediaselector', $params);
        //$view->render('testlogin');
        //echo $strLoginHtml;exit;
        if ($strMediaUploaderHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strMediaUploaderHtml;
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function addupdates($intOrderMId = "") {
        if ($intOrderMId) {
            $arrLoggedUser = $this->Auth->user();
            $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.form.js') . '"></script>';
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/add_vendor_update.js') . '"></script>';
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
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-jquery-ui.js') . '"></script>';

            $this->set('strActionScript', $strActionScript);


            $this->loadModel('Serviceupdates');
            $this->loadModel('Resourceorderdetail');
            $arrNewOrders = $this->Resourceorderdetail->find('all', array('conditions' => array('order_detail_id' => $intOrderMId)));

            if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
                $this->loadModel('Resourceorder');
                $this->loadModel('Candidate');
                $this->loadModel('Resources');
                $intFrCnt = 0;
                foreach ($arrNewOrders as $arrOrder) {
                    $intOrderId = $arrOrder['Resourceorderdetail']['order_id'];
                    $arrOrderDetail = $this->Resourceorder->find('all', array('conditions' => array('resource_order_id' => $intOrderId)));
                    if (is_array($arrOrderDetail) && (count($arrOrderDetail) > 0)) {
                        $arrNewOrders[$intFrCnt]['mainorder'] = $arrOrderDetail[0];
                    }
                    $intServiceId = $arrOrder['Resourceorderdetail']['product_id'];
                    $arrServiceDetail = $this->Resources->find('all', array('conditions' => array('productd_id' => $intServiceId)));
                    if (is_array($arrServiceDetail) && (count($arrServiceDetail) > 0)) {
                        $arrNewOrders[$intFrCnt]['service'] = $arrServiceDetail[0];
                    }
                    $intCustomerId = $arrOrder['Resourceorderdetail']['seeker_id'];
                    $arrCustomerDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $intCustomerId)));
                    if (is_array($arrCustomerDetail) && (count($arrCustomerDetail) > 0)) {
                        $arrNewOrders[$intFrCnt]['customer'] = $arrCustomerDetail[0];
                    }
                    $intFrCnt++;
                }
            }




            $this->set('arrProductList', $arrNewOrders);
            $this->set('arrCurrentUser', $arrLoggedUser);
            $this->set('intOrderId', $intOrderMId);
        } else {
            $this->Session->setFlash('Sorry, Some Parameter missing.');
        }
    }

    public function viewupdate($intOrderMId = "", $intUpdateId = "") {
        if ($intOrderMId && $intUpdateId) {
            $arrLoggedUser = $this->Auth->user();
            $this->loadModel('Resourceorderdetail');
            $arrNewOrders = $this->Resourceorderdetail->find('all', array('conditions' => array('order_detail_id' => $intOrderMId)));

            if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
                $this->loadModel('Resourceorder');
                $this->loadModel('Candidate');
                $this->loadModel('Resources');
                $intFrCnt = 0;
                foreach ($arrNewOrders as $arrOrder) {
                    $intOrderId = $arrOrder['Resourceorderdetail']['order_id'];
                    $arrOrderDetail = $this->Resourceorder->find('all', array('conditions' => array('resource_order_id' => $intOrderId)));
                    if (is_array($arrOrderDetail) && (count($arrOrderDetail) > 0)) {
                        $arrNewOrders[$intFrCnt]['mainorder'] = $arrOrderDetail[0];
                    }
                    $intServiceId = $arrOrder['Resourceorderdetail']['product_id'];
                    $arrServiceDetail = $this->Resources->find('all', array('conditions' => array('productd_id' => $intServiceId)));
                    if (is_array($arrServiceDetail) && (count($arrServiceDetail) > 0)) {
                        $arrNewOrders[$intFrCnt]['service'] = $arrServiceDetail[0];
                    }
                    $intCustomerId = $arrOrder['Resourceorderdetail']['seeker_id'];
                    $arrCustomerDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $intCustomerId)));
                    if (is_array($arrCustomerDetail) && (count($arrCustomerDetail) > 0)) {
                        $arrNewOrders[$intFrCnt]['customer'] = $arrCustomerDetail[0];
                    }
                    $intFrCnt++;
                }
            }

            $this->loadModel('Serviceupdates');
            $arrServiceUpdateDetails = $this->Serviceupdates->find('all', array('conditions' => array('order_service_update_id' => $intUpdateId)));
            if (is_array($arrServiceUpdateDetails) && (count($arrServiceUpdateDetails) > 0)) {
                $this->loadModel('Vendorfiles');
                $arrVendorUpdateFiles = $this->Vendorfiles->find('all', array('conditions' => array('vendor_update_id' => $intUpdateId)));

                if (is_array($arrVendorUpdateFiles) && count($arrVendorUpdateFiles) > 0) {
                    $arrServiceUpdateDetails[0]['files'] = $arrVendorUpdateFiles;
                }
            }
            //print("<pre>");
            //print_r($arrServiceUpdateDetails);
            //exit;
            $this->set('arrCurrentUser', $arrLoggedUser);
            $this->set('arrProductList', $arrNewOrders);
            $this->set('arrServiceUpdateDetails', $arrServiceUpdateDetails);
        } else {
            $this->Session->setFlash('Sorry, Some Parameter missing.');
        }
    }

    public function orderdetail($intOrderMId = "") {
        if ($intOrderMId) {
            $arrLoggedUser = $this->Auth->user();

            $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/vendor_index.js') . '"></script>';
            $this->set('strActionScript', $strActionScript);

            $this->loadModel('Vendors');
            $arrSubVendorsRecords = $this->Vendors->find('all', array('conditions' => array('parent_vendor' => $arrLoggedUser['vendor_id'])));
            $arrVendors = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $arrLoggedUser['vendor_id'])));
            $arrSubVendors = array_merge($arrSubVendorsRecords, $arrVendors);
//
//            print("<pre>");
//            print_r($arrSubVendors);

            $this->set('arrSubVendors', $arrSubVendors);

            $this->loadModel('Serviceupdates');
            $this->loadModel('Resourceorderdetail');
            $arrNewOrders = $this->Resourceorderdetail->find('all', array('conditions' => array('order_detail_id' => $intOrderMId)));

            if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
                $this->loadModel('Resourceorder');
                $this->loadModel('Candidate');
                $this->loadModel('Resources');
                $this->loadModel('Subvendororders');
                $intFrCnt = 0;
                foreach ($arrNewOrders as $arrOrder) {
                    $intOrderId = $arrOrder['Resourceorderdetail']['order_id'];

                    if ($arrLoggedUser['parent_vendor']) {
                        $isAuthUser = $this->Subvendororders->find('count', array('conditions' => array('order_id' => $intOrderId, 'vendor_id' => $arrLoggedUser['vendor_id'])));
                        if (!$isAuthUser) {
                            $this->redirect(array('controller' => 'vendororders', 'action' => 'index'));
                        }
                    }
                    $arrOrderDetail = $this->Resourceorder->find('all', array('conditions' => array('resource_order_id' => $intOrderId)));
                    if (is_array($arrOrderDetail) && (count($arrOrderDetail) > 0)) {
                        $arrNewOrders[$intFrCnt]['mainorder'] = $arrOrderDetail[0];
                    }
                    $intServiceId = $arrOrder['Resourceorderdetail']['product_id'];
                    $arrServiceDetail = $this->Resources->find('all', array('conditions' => array('productd_id' => $intServiceId)));
                    if (is_array($arrServiceDetail) && (count($arrServiceDetail) > 0)) {
                        $arrNewOrders[$intFrCnt]['service'] = $arrServiceDetail[0];
                    }
                    $intCustomerId = $arrOrder['Resourceorderdetail']['seeker_id'];
                    $arrCustomerDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $intCustomerId)));
                    if (is_array($arrCustomerDetail) && (count($arrCustomerDetail) > 0)) {
                        $arrNewOrders[$intFrCnt]['customer'] = $arrCustomerDetail[0];
                    }
                    $arrVendorWorkingDetail = $this->Subvendororders->find('all', array('conditions' => array('order_id' => $intOrderId)));
                    $intFrCnt++;
                }
            }
            $this->set("arrVendorWorkingDetail", $arrVendorWorkingDetail);

            $arrServiceUpdates = $this->Serviceupdates->find('all', array('conditions' => array('order_id' => $intOrderMId)));
            if (is_array($arrServiceUpdates) && count($arrServiceUpdates) > 0) {
                $intFrCnt = 0;
                $this->loadModel('Vendor');
                $this->loadModel('Candidate');
                foreach ($arrServiceUpdates as $arrServiceUpdate) {
                    $stUpdateFrom = $arrServiceUpdate['Serviceupdates']['order_update_by_type'];
                    if ($stUpdateFrom == "vendor") {
                        $arrUpdateByDetail = $this->Vendor->find('all', array('conditions' => array('vendor_id' => $arrServiceUpdate['Serviceupdates']['order_update_from'])));
                        $arrServiceUpdates[$intFrCnt]['Serviceupdates']['updatefrom'] = $arrUpdateByDetail[0]['Vendor']['vendor_first_name'] . " " . $arrUpdateByDetail[0]['Vendor']['vendor_last_name'];
                    }
                    if ($stUpdateFrom == "candidate") {
                        $arrUpdateByDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $arrServiceUpdate['Serviceupdates']['order_update_from'])));
                        $arrServiceUpdates[$intFrCnt]['Serviceupdates']['updatefrom'] = $arrUpdateByDetail[0]['Candidate']['candidate_first_name'] . " " . $arrUpdateByDetail[0]['Candidate']['candidate_last_name'];
                    }
                    $intFrCnt++;
                }
            }

            $this->set('arrServiceUpdates', $arrServiceUpdates);
            $this->set('arrProductList', $arrNewOrders);
            $this->set('arrCurrentUser', $arrLoggedUser);
            $this->set('intOrderMId', $intOrderMId);
        } else {
            $this->Session->setFlash('Sorry, Some Parameter missing.');
        }
    }

    public function changeorderstatus($intOrderId = "", $strOrderStatus = "") {
        $this->layout = NULL;
        $this->autoRender = false;
        $arrResponse = array();
        if ($intOrderId && $strOrderStatus) {
            $this->loadModel('Resourceorderdetail');
            $boolUpdated = $this->Resourceorderdetail->updateAll(
                    array('Resourceorderdetail.vendor_order_state' => "'" . $strOrderStatus . "'"), array('Resourceorderdetail.order_detail_id =' => $intOrderId)
            );

            $candidate_id = $this->Resourceorderdetail->field('seeker_id', array('order_detail_id' => $intOrderId));
            $this->loadModel('Notification');
            $arrSystemNotification = array();

            $arrLoggedUser = $this->Auth->user();
            /* print_R($arrLoggedUser['vendor_id']);
              exit(); */
            $arrSystemNotification['Notification']['candidate_id'] = $candidate_id;
            $arrSystemNotification['Notification']['reminder_type'] = 'orderupdate';
            $arrSystemNotification['Notification']['reminder_id'] = $intOrderId;
            $arrSystemNotification['Notification']['notification_created_by'] = $arrLoggedUser['vendor_id'];

            $isSystemNotified = $this->Notification->save($arrSystemNotification);
            if ($isSystemNotified) {
                $this->loadModel('Candidate');
                $this->loadModel('Resourceorderdetail');

                //$candidate_email  =  $this->Candidate->find('first', array('candidate_id' => $candidate_id));

                $arrContacterDetail = $this->Candidate->find('first', array('conditions' => array('candidate_id' => $candidate_id)));
                $arrResourcreDetail = $this->Resourceorderdetail->find('first', array('conditions' => array('order_detail_id' => $intOrderId)));
                // send email to candidate

                $arrContacterDetail['email'] = $arrContacterDetail['Candidate']['candidate_email'];
                $arrContacterDetail['name'] = $arrContacterDetail['Candidate']['candidate_first_name'];
                $arrContacterDetail['vendorname'] = $arrResourcreDetail['Resourceorderdetail']['vendor_name'];
                $arrContacterDetail['product_name'] = $arrResourcreDetail['Resourceorderdetail']['product_name'];
                $this->fnSendVendorUpdateEmail($arrContacterDetail);
            }
            if ($boolUpdated) {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Your order was updated successfully.', 'success');
                $arrResponse['status'] = 'success';
                $arrResponse['message'] = $strMessage;
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('There was some error, please try again later.', 'error');
                $arrResponse['status'] = 'fail';
                $arrResponse['message'] = $strMessage;
            }
        } else {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('Parameter missing, please try again.', 'error');
            $arrResponse['status'] = 'fail';
            $arrResponse['message'] = $strMessage;
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function closeorder($intOrderId = "") {
        $this->layout = NULL;
        $this->autoRender = false;
        $arrResponse = array();
        if ($intOrderId) {
            $this->loadModel('Resourceorderdetail');
            $close = date('Y-m-d');
            $boolUpdated = $this->Resourceorderdetail->updateAll(
                    array('Resourceorderdetail.vendor_order_state' => "'Closed'", 'Resourceorderdetail.vendor_order_close_date' => "'" . $close . "'"), array('Resourceorderdetail.order_detail_id =' => $intOrderId)
            );

            if ($boolUpdated) {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Your order was closed successfully.', 'success');
                $arrResponse['status'] = 'success';
                $arrResponse['message'] = $strMessage;
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('There was some error, please try again later.', 'error');
                $arrResponse['status'] = 'fail';
                $arrResponse['message'] = $strMessage;
            }
        } else {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('Parameter missing, please try again.', 'error');
            $arrResponse['status'] = 'fail';
            $arrResponse['message'] = $strMessage;
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function assignordertovendoruser($intOrderId = "", $intVendorId = "", $strAction = "assign") {
        //Configure::write('debug','2');
        $this->layout = NULL;
        $this->autoRender = FALSE;
        $arrResponse = array();

        if ($intOrderId && $intVendorId) {
            $this->loadModel('Subvendororders');
            $intVendorOrderCount = $this->Subvendororders->find('count', array('conditions' => array('order_id' => $intOrderId, 'vendor_id' => $intVendorId)));


            if ($strAction == "assign") {
                if ($intVendorOrderCount) {
                    $arrResponse['status'] = 'fail';
                    $arrResponse['message'] = "Order is already assigned to this vendor user.";
                } else {
                    $arrVendorUserOrderDetial['Subvendororders']['order_id'] = $intOrderId;
                    $arrVendorUserOrderDetial['Subvendororders']['vendor_id'] = $intVendorId;
                    $this->Subvendororders->create(false);
                    $arrVendorOrderUserAssigned = $this->Subvendororders->save($arrVendorUserOrderDetial);

                    if (is_array($arrVendorOrderUserAssigned) && (count($arrVendorOrderUserAssigned) > 0)) {
                        $this->loadModel('Resourceorderdetail');
                        $boolUpdated = $this->Resourceorderdetail->updateAll(
                                array('vendor_order_state' => "'In-Process'"), array('order_id =' => $intOrderId)
                        );

                        $arrResponse['status'] = 'success';
                        $arrResponse['message'] = "This Order was successfully assigned to the chosen vendor user.";
                    } else {
                        $arrResponse['status'] = 'fail';
                        $arrResponse['message'] = "Something went wrong, Please try again";
                    }
                }
            } else {
                if ($intVendorOrderCount) {
                    $intUnAssign = $this->Subvendororders->deleteAll(array('order_id' => $intOrderId, 'vendor_id' => $intVendorId), false);

                    if ($intUnAssign) {
                        $intVendorUserOnOrder = $this->Subvendororders->find('count', array('conditions' => array('order_id' => $intOrderId)));

                        if (!$intVendorUserOnOrder) {
                            $this->loadModel('Resourceorderdetail');
                            $boolUpdated = $this->Resourceorderdetail->updateAll(
                                    array('vendor_order_state' => "'New Order'"), array('order_id =' => $intOrderId)
                            );
                        }

                        $arrResponse['status'] = 'success';
                        $arrResponse['message'] = "Operation completed successfully";
                    } else {
                        $arrResponse['status'] = 'fail';
                        $arrResponse['message'] = "Cannot be done, Please try again";
                    }
                } else {
                    $arrResponse['status'] = 'fail';
                    $arrResponse['message'] = "Cannot be done, User is not assigned";
                }
            }
        } else {
            $arrResponse['status'] = 'fail';
            $arrResponse['message'] = "Parameter Missing, Please try again";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function candidateexport($strStartDate = "", $strEndDate = "") {
        $this->layout = NULL;
        $this->autoRender = FALSE;
        $arrResponse = array();

        $arrLoggedUser = $this->Auth->user();
        $arrConditions = array();
        if ($strStartDate) {
            if ($strEndDate) {
                $strStartTime = strtotime($strStartDate);
                $strEndTime = strtotime($strEndDate);

                if ($strEndTime > $strStartTime) {
                    $arrConditions['Resourceorderdetail.vendor_id'] = $arrLoggedUser['vendor_id'];
                    $arrConditions['Resourceorderdetail.order_detail_creation_date_time >='] = $strStartDate;
                    $arrConditions['Resourceorderdetail.order_detail_creation_date_time <='] = $strEndDate;
                } else {
                    $arrResponse['status'] = "fail";
                    $arrResponse['message'] = "End date cannot be before the start date.";
                }
            } else {
                $arrConditions['Resourceorderdetail.vendor_id'] = $arrLoggedUser['vendor_id'];
                $arrConditions['Resourceorderdetail.order_detail_creation_date_time >='] = $strStartDate;
            }

            if (is_array($arrConditions) && (count($arrConditions) > 0)) {
                $this->loadModel('Candidate');
                $this->loadModel('Resourceorderdetail');
                $arrCandidates = $this->Candidate->find('all', array(
                    'fields' => array('Candidate.*'),
                    'joins' => array(array(
                            'table' => 'resource_order_detail',
                            'alias' => 'Resourceorderdetail',
                            'type' => 'left',
                            'conditions' => array('Candidate.candidate_id=Resourceorderdetail.seeker_id')
                        )),
                    'conditions' => $arrConditions,
                    'group' => array('Candidate.candidate_id')
                ));
                if (is_array($arrCandidates) && (count($arrCandidates) > 0)) {
                    $strFileName = "candidates_order_" . time() . ".csv";
                    $strNewFh = fopen(WWW_ROOT . 'Candidateorder/' . $strFileName, "w");
                    $intFrCnt = 0;
                    $strWriteDataHeader = "Name,Email" . ",\n";
                    fputs($strNewFh, $strWriteData);
                    foreach ($arrCandidates as $arrContent) {
                        $strWriteData = $arrContent['Candidate']['candidate_first_name'] . " " . $arrContent['Candidate']['candidate_last_name'] . "," . $arrContent['Candidate']['candidate_email'] . ",\n";
                        fputs($strNewFh, $strWriteData);
                    }
                    fseek($strNewFh, SEEK_END);
                    fclose($strNewFh);
                    $arrResponse['status'] = "success";
                    $arrResponse['file'] = $strFileName;
                    $arrResponse['filepath'] = "Candidateorder";
                } else {
//                    $arrResponse['status'] = "fail";
//                    $arrResponse['message'] = "There were no order from candidates for this time period.";
                    
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('There were no order from candidates for this time period.','error');
                    $arrResponse['status'] = 'fail';
                    $arrResponse['message'] = $strMessage;
                }
            }
        } else {
//            $arrResponse['status'] = "fail";
//            $arrResponse['message'] = "Please check the provided start date and try again.";
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('Please check the provided start date and try again.','error');
            $arrResponse['status'] = 'fail';
            $arrResponse['message'] = $strMessage;
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function candidates() {
        //Configure::write('debug','2');
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/vendor_index.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);

        $strStartDate = "0";
        $strEndDate = "0";
        if ($this->request->is('Post')) {


            $strStartDate = $this->request->data['from_date_hid'] . " 00:00:00";
            $strEndDate = $this->request->data['to_date_hid'] . " 23:59:59";
        } else {

            $strStartDate = date("Y") . "-" . date("m") . "-" . "01 00:00:00";
            //$strEndDate = date("",date("Y").'-'.date("m").'-t')." 23:59:59";
            $strEndDate = date("Y-m-d", strtotime('last day of this month')) . " 23:59:59";
        }

        //echo $strStartDate;
        //echo $strEndDate;
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Candidate');
        $this->loadModel('Resourceorderdetail');
        $arrCandidates = $this->Candidate->find('all', array(
            'fields' => array('Candidate.*'),
            'joins' => array(array(
                    'table' => 'resource_order_detail',
                    'alias' => 'Resourceorderdetail',
                    'type' => 'left',
                    'conditions' => array('Candidate.candidate_id=Resourceorderdetail.seeker_id')
                )),
            'conditions' => array('Resourceorderdetail.vendor_id' => $arrLoggedUser['vendor_id'], 'Resourceorderdetail.order_detail_creation_date_time >=' => $strStartDate, 'Resourceorderdetail.order_detail_creation_date_time <=' => $strEndDate),
            'group' => array('Candidate.candidate_id')
        ));

        //print("<pre>");
        //print_r($arrCandidates);
        //exit;arrProductList
        $this->set('strStartDate', $strStartDate);
        $this->set('strEndDate', $strEndDate);
        $this->set('arrProductList', $arrCandidates);
    }

    public function index() {

        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/vendor_index.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);

        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Resourceorderdetail');
        $this->loadModel('Subvendororders');

        $this->set('arrLoggedUser', $arrLoggedUser);

        if ($arrLoggedUser['parent_vendor']) {
            $arrNewOrders = $this->Subvendororders->find('all', array(
                'fields' => array('Resourceorderdetail.*', 'Subvendororders.*'),
                'joins' => array(
                    array(
                        'table' => 'resource_order_detail',
                        'alias' => 'Resourceorderdetail',
                        'type' => 'left',
                        'conditions' => array('Subvendororders.order_id=Resourceorderdetail.order_id')
                    )
                ),
                'conditions' => array('Subvendororders.vendor_id' => $arrLoggedUser['vendor_id']),
                'order' => array('Resourceorderdetail.order_detail_creation_date_time' => 'desc')
            ));
        } else {
            $arrNewOrders = $this->Resourceorderdetail->find('all', array('conditions' => array("vendor_id" => $arrLoggedUser['vendor_id']), 'order' => array('order_detail_creation_date_time' => 'desc')));
        }


        $this->loadModel('Vendors');
        $arrSubVendors = $this->Vendors->find('all', array('conditions' => array('parent_vendor' => $arrLoggedUser['vendor_id'])));

        $this->set('arrSubVendors', $arrSubVendors);

        if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
            $this->loadModel('Resourceorder');
            $this->loadModel('Candidate');
            $this->loadModel('Resources');
            $intFrCnt = 0;
            foreach ($arrNewOrders as $arrOrder) {

                $intOrderId = $arrOrder['Resourceorderdetail']['order_id'];
                $arrOrderDetail = $this->Resourceorder->find('all', array('conditions' => array('resource_order_id' => $intOrderId)));
                if (is_array($arrOrderDetail) && (count($arrOrderDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['mainorder'] = $arrOrderDetail[0];
                }
                $intServiceId = $arrOrder['Resourceorderdetail']['product_id'];
                $arrServiceDetail = $this->Resources->find('all', array('conditions' => array('productd_id' => $intServiceId)));
                if (is_array($arrServiceDetail) && (count($arrServiceDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['service'] = $arrServiceDetail[0];
                }
                $intCustomerId = $arrOrder['Resourceorderdetail']['seeker_id'];
                $arrCustomerDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $intCustomerId)));
                if (is_array($arrCustomerDetail) && (count($arrCustomerDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['customer'] = $arrCustomerDetail[0];
                }

                $arrSubVendorsFor = $this->Subvendororders->find('all', array(
                    'fields' => array('Vendors.*', 'Subvendororders.*'),
                    'joins' => array(
                        array(
                            'table' => 'vendors',
                            'alias' => 'Vendors',
                            'type' => 'left',
                            'conditions' => array('Subvendororders.vendor_id=Vendors.vendor_id')
                        )
                    ),
                    'conditions' => array('order_id' => $intOrderId)
                ));

                if (is_array($arrSubVendorsFor) && (count($arrSubVendorsFor) > 0)) {
                    $arrNewOrders[$intFrCnt]['vendorsuser'] = $arrSubVendorsFor[0];
                } else {
                    
                }
                $intFrCnt++;
            }
        }
        $this->set('arrProductList', $arrNewOrders);
    }

    public function neworders() {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/vendor_index.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);

        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Resourceorderdetail');

        $arrNewOrders = $this->Resourceorderdetail->find('all', array('conditions' => array("vendor_order_state" => "New Order", "vendor_id" => $arrLoggedUser['vendor_id']), 'order' => array('order_detail_creation_date_time' => 'desc')));


        if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
            $this->loadModel('Resourceorder');
            $this->loadModel('Candidate');
            $this->loadModel('Resources');
            $intFrCnt = 0;
            foreach ($arrNewOrders as $arrOrder) {

                $intOrderId = $arrOrder['Resourceorderdetail']['order_id'];
                $arrOrderDetail = $this->Resourceorder->find('all', array('conditions' => array('resource_order_id' => $intOrderId)));
                if (is_array($arrOrderDetail) && (count($arrOrderDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['mainorder'] = $arrOrderDetail[0];
                }
                $intServiceId = $arrOrder['Resourceorderdetail']['product_id'];
                $arrServiceDetail = $this->Resources->find('all', array('conditions' => array('productd_id' => $intServiceId)));
                if (is_array($arrServiceDetail) && (count($arrServiceDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['service'] = $arrServiceDetail[0];
                }
                $intCustomerId = $arrOrder['Resourceorderdetail']['seeker_id'];
                $arrCustomerDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $intCustomerId)));
                if (is_array($arrCustomerDetail) && (count($arrCustomerDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['customer'] = $arrCustomerDetail[0];
                }
                $intFrCnt++;
            }
        }
        $this->set('arrProductList', $arrNewOrders);
    }

    public function openorders() {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/vendor_index.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);

        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Resourceorderdetail');

        $arrNewOrders = $this->Resourceorderdetail->find('all', array('conditions' => array("vendor_order_state" => "Open", "vendor_id" => $arrLoggedUser['vendor_id']), 'order' => array('order_detail_creation_date_time' => 'desc')));


        if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
            $this->loadModel('Resourceorder');
            $this->loadModel('Candidate');
            $this->loadModel('Resources');
            $intFrCnt = 0;
            foreach ($arrNewOrders as $arrOrder) {

                $intOrderId = $arrOrder['Resourceorderdetail']['order_id'];
                $arrOrderDetail = $this->Resourceorder->find('all', array('conditions' => array('resource_order_id' => $intOrderId)));
                if (is_array($arrOrderDetail) && (count($arrOrderDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['mainorder'] = $arrOrderDetail[0];
                }
                $intServiceId = $arrOrder['Resourceorderdetail']['product_id'];
                $arrServiceDetail = $this->Resources->find('all', array('conditions' => array('productd_id' => $intServiceId)));
                if (is_array($arrServiceDetail) && (count($arrServiceDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['service'] = $arrServiceDetail[0];
                }
                $intCustomerId = $arrOrder['Resourceorderdetail']['seeker_id'];
                $arrCustomerDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $intCustomerId)));
                if (is_array($arrCustomerDetail) && (count($arrCustomerDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['customer'] = $arrCustomerDetail[0];
                }
                $intFrCnt++;
            }
        }
        $this->set('arrProductList', $arrNewOrders);
    }

    public function pendingorders() {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/vendor_index.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);

        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Resourceorderdetail');

        $arrNewOrders = $this->Resourceorderdetail->find('all', array('conditions' => array("vendor_order_state" => "Pending", "vendor_id" => $arrLoggedUser['vendor_id']), 'order' => array('order_detail_creation_date_time' => 'desc')));


        if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
            $this->loadModel('Resourceorder');
            $this->loadModel('Candidate');
            $this->loadModel('Resources');
            $intFrCnt = 0;
            foreach ($arrNewOrders as $arrOrder) {

                $intOrderId = $arrOrder['Resourceorderdetail']['order_id'];
                $arrOrderDetail = $this->Resourceorder->find('all', array('conditions' => array('resource_order_id' => $intOrderId)));
                if (is_array($arrOrderDetail) && (count($arrOrderDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['mainorder'] = $arrOrderDetail[0];
                }
                $intServiceId = $arrOrder['Resourceorderdetail']['product_id'];
                $arrServiceDetail = $this->Resources->find('all', array('conditions' => array('productd_id' => $intServiceId)));
                if (is_array($arrServiceDetail) && (count($arrServiceDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['service'] = $arrServiceDetail[0];
                }
                $intCustomerId = $arrOrder['Resourceorderdetail']['seeker_id'];
                $arrCustomerDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $intCustomerId)));
                if (is_array($arrCustomerDetail) && (count($arrCustomerDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['customer'] = $arrCustomerDetail[0];
                }
                $intFrCnt++;
            }
        }
        $this->set('arrProductList', $arrNewOrders);
    }

    public function closedorders() {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/vendor_index.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);

        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Resourceorderdetail');

        $arrNewOrders = $this->Resourceorderdetail->find('all', array('conditions' => array("vendor_order_state" => "Closed", "vendor_id" => $arrLoggedUser['vendor_id']), 'order' => array('order_detail_creation_date_time' => 'desc')));


        if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
            $this->loadModel('Resourceorder');
            $this->loadModel('Candidate');
            $this->loadModel('Resources');
            $intFrCnt = 0;
            foreach ($arrNewOrders as $arrOrder) {

                $intOrderId = $arrOrder['Resourceorderdetail']['order_id'];
                $arrOrderDetail = $this->Resourceorder->find('all', array('conditions' => array('resource_order_id' => $intOrderId)));
                if (is_array($arrOrderDetail) && (count($arrOrderDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['mainorder'] = $arrOrderDetail[0];
                }
                $intServiceId = $arrOrder['Resourceorderdetail']['product_id'];
                $arrServiceDetail = $this->Resources->find('all', array('conditions' => array('productd_id' => $intServiceId)));
                if (is_array($arrServiceDetail) && (count($arrServiceDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['service'] = $arrServiceDetail[0];
                }
                $intCustomerId = $arrOrder['Resourceorderdetail']['seeker_id'];
                $arrCustomerDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $intCustomerId)));
                if (is_array($arrCustomerDetail) && (count($arrCustomerDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['customer'] = $arrCustomerDetail[0];
                }
                $intFrCnt++;
            }
        }
        $this->set('arrProductList', $arrNewOrders);
    }

    public function logout($strSwictchBack = "") {
        $this->layout = NULL;
        $this->autoRender = False;
        $arrResponse = array();

        $arrResponse['logoutredirecturl'] = $this->Auth->logout();

        if ($arrResponse['logoutredirecturl']) {
            $arrResponse['logoutredirecturl'] = Router::url(array('controller' => 'vendoraccount', 'action' => 'index'), true);
            $arrResponse['status'] = "success";
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function login($strSwictchBack = "") {

        if ($this->request->is('post')) {
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


            /* if($this->User->validates())
              { */
            if ($this->Auth->login()) {
                $arrLoggedInUser = $this->Auth->user();
                if ($arrLoggedInUser['vendor_active'] == "0") {
                    $this->Auth->logout();
                    $arrResultSet = array();
                    $arrResultSet['status'] = "failure";
                    $arrResultSet['message'] = "Sorry, Your account is not being confirmed yet, Please confirm your account first.";
                    $this->Session->setFlash('Sorry, Your account is not being confirmed yet, Please confirm your account first.');
                    echo json_encode($arrResultSet);
                    exit;

                    /* $this->Session->setFlash('Sorry, Your account is not being confirmed yet, Please confirm your account first.');
                      $this->redirect(array('controller'=>'users','action'=>'login')); */
                } else {
                    $arrResultSet = array();
                    $arrResultSet['status'] = "success";
                    $arrResultSet['redirecturl'] = Router::url($this->Auth->redirectUrl(), true);
                    $arrResultSet['userid'] = $arrLoggedInUser['vendor_id'];
                    $arrResultSet['username'] = $arrLoggedInUser['vendor_name'];
                    $arrResultSet['useremail'] = $arrLoggedInUser['vendor_email'];

                    echo json_encode($arrResultSet);
                    exit;
                    //$this->redirect($this->Auth->redirectUrl());
                }
            } else {
                $arrResultSet = array();
                $arrResultSet['status'] = "failure";
                $arrResultSet['message'] = "Your username and password combination was incorrect.";
                $this->Session->setFlash('Your username and password combination was incorrect');
                echo json_encode($arrResultSet);
                exit;
                //$this->Session->setFlash('Your username and password combination was incorrect');
            }
            /* }
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
              } */
            //$this->redirect(array('controller'=>'home','action'=>'index'));
        }
    }

    public function forgotpassword() {
        if ($this->request->is('post')) {
            /* print("<pre>");
              print_r($this->request->data);
              exit; */

            $this->request->data['Vendors']['vendor_email'] = addslashes(trim($this->request->data['User']['user_email']));

            $this->loadModel('Vendors');
            $this->Vendors->set($this->request->data);

            /* if($this->User->validates())
              { */
            $arrUserExists = $this->Vendors->find('all', array(
                'conditions' => array('vendor_email' => $this->request->data['User']['user_email'])
            ));
            /* print("<pre>");
              print_r($arrUserExists);
              exit; */
            if (is_array($arrUserExists) && (count($arrUserExists) > 0)) {

                $strUsersName = $arrUserExists[0]['Vendors']['vendor_name'];
                /* echo "---".$strUsersName;
                  exit; */
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
            /* }
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
              } */
        }
    }

    public function editpayout() {
        $arrLoggedUserDetails = $this->Auth->user();
        /* print("<pre>");
          print_r($arrLoggedUserDetails);
          exit; */
        $this->loadModel('Vendorpayout');
        $strRegerrorMessage = "";
        if ($this->request->is('post')) {
            $arrContentData['Vendorpayout']['vendor_id'] = $intEditModeId = $arrLoggedUserDetails['vendor_id'];
            $arrContentData['Vendorpayout']['payout_to'] = addslashes($this->request->data['User']['payoutto']);
            $arrContentData['Vendorpayout']['tax_id'] = addslashes($this->request->data['User']['taxid']);
            $arrContentData['Vendorpayout']['minimum_check_amt'] = addslashes($this->request->data['User']['minamt']);
            $arrContentData['Vendorpayout']['commission_pct'] = addslashes($this->request->data['User']['compct']);
            $arrContentData['Vendorpayout']['indeed_registration'] = addslashes($this->request->data['User']['inreg']);


            /* print("<pre>");
              print_r($arrContentData);
              exit; */

            $intVendorCompanyExists = $this->Vendorpayout->find('count', array('conditions' => array('vendor_id' => $intEditModeId)));
            if ($intVendorCompanyExists) {
                $this->Vendorpayout->deleteAll(array('Vendorpayout.vendor_id' => $intEditModeId), false);
            }

            $arrCompanyDetailsEntered = $this->Vendorpayout->save($arrContentData);

            if ($arrCompanyDetailsEntered) {
                $this->Session->setFlash('Vendor Payment Details Saved Successfully!', 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash('Please try again');
            }
        }

        $arrViewUserDetail = $this->Vendorpayout->find('all', array('conditions' => array('vendor_id' => $arrLoggedUserDetails['vendor_id'])));

        $this->set('arrCompleteLoggedInUserDetail', $arrViewUserDetail);
    }

    public function editcompany() {
        $arrLoggedUserDetails = $this->Auth->user();
        /* print("<pre>");
          print_r($arrLoggedUserDetails);
          exit; */
        $this->loadModel('Vendorcompany');
        $strRegerrorMessage = "";
        if ($this->request->is('post')) {
            $arrContentData['Vendorcompany']['vendor_id'] = $intEditModeId = $arrLoggedUserDetails['vendor_id'];
            $arrContentData['Vendorcompany']['company_name'] = addslashes($this->request->data['User']['vendorcname']);
            $arrContentData['Vendorcompany']['vendor_f_name'] = addslashes($this->request->data['User']['vendorfname']);
            $arrContentData['Vendorcompany']['vendor_l_name'] = addslashes($this->request->data['User']['vendorlname']);
            $arrContentData['Vendorcompany']['vendor_email'] = addslashes($this->request->data['User']['vendorcemail']);
            $arrContentData['Vendorcompany']['address'] = addslashes($this->request->data['User']['vendor_company_address']);
            $arrContentData['Vendorcompany']['zip'] = addslashes($this->request->data['User']['zip']);
            $arrContentData['Vendorcompany']['phone'] = addslashes($this->request->data['User']['vendorcphone']);
            $arrContentData['Vendorcompany']['fax'] = addslashes($this->request->data['User']['vendorfax']);
            $arrContentData['Vendorcompany']['web_address'] = addslashes($this->request->data['User']['vendorwaddress']);
            $arrContentData['Vendorcompany']['billing_phone'] = addslashes($this->request->data['User']['vendorbphone']);


            /* print("<pre>");
              print_r($arrContentData);
              exit; */

            $intVendorCompanyExists = $this->Vendorcompany->find('count', array('conditions' => array('vendor_id' => $intEditModeId)));
            if ($intVendorCompanyExists) {
                $this->Vendorcompany->deleteAll(array('Vendorcompany.vendor_id' => $intEditModeId), false);
            }

            $arrCompanyDetailsEntered = $this->Vendorcompany->save($arrContentData);

            if ($arrCompanyDetailsEntered) {
                $this->Session->setFlash('Vendor Company Details Updated Successfully!', 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash('Please try again');
            }
        }

        $arrViewUserDetail = $this->Vendorcompany->find('all', array('conditions' => array('vendor_id' => $arrLoggedUserDetails['vendor_id'])));

        $this->set('arrCompleteLoggedInUserDetail', $arrViewUserDetail);
    }

    public function edit() {
        $arrLoggedUserDetails = $this->Auth->user();
        /* print("<pre>");
          print_r($arrLoggedUserDetails);
          exit; */
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

            //print("<pre>");
            //print_r($arrAdminBasicPostedData);
            //exit;

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
                $this->Session->setFlash('Profile Updated Successfully!', 'default', array('class' => 'success'));
            } else {
                $this->Session->setFlash('Please try again');
            }
        }


        $arrViewUserDetail = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $arrLoggedUserDetails['vendor_id'])));

        $this->set('arrCompleteLoggedInUserDetail', $arrViewUserDetail);
    }

    public function dashboard() {
        $arrLoggedVendor = $this->Auth->user();
        $this->compTime = $this->Components->load('TimeCalculation');

        $strMonth = $this->compTime->fnFindCurrentMonth();
        $arrNewYear = $this->compTime->fnFindCurrentYear();

        $strDatFormMonthToCompare = $arrNewYear . "-" . $strMonth . "-" . "01 00:00:00";
        $strEndDatFormMonthToCompare = date($arrNewYear . '-' . $strMonth . '-t') . " 23:59:59";


        $this->loadModel('Resourceorderdetail');
        $arrNewOrderCountForMonth = $this->Resourceorderdetail->fnGetNewOrderCount($arrLoggedVendor['vendor_id'], $strDatFormMonthToCompare, $strEndDatFormMonthToCompare);

        if (is_array($arrNewOrderCountForMonth) && (count($arrNewOrderCountForMonth) > 0)) {
            if ($arrNewOrderCountForMonth[0][0]['count(*)']) {
                $this->set('intPortalOwners', $arrNewOrderCountForMonth[0][0]['count(*)']);
            }
        }

        $arrNewOrderCountTotal = $this->Resourceorderdetail->fnGetNewOrderCount($arrLoggedVendor['vendor_id']);
        //print("<pre>");
        //print_r($arrNewOrderCountTotal);
        //exit;
        if (is_array($arrNewOrderCountTotal) && (count($arrNewOrderCountTotal) > 0)) {
            if ($arrNewOrderCountTotal[0][0]['count(*)']) {
                $this->set('intPortalCandidates', $arrNewOrderCountTotal[0][0]['count(*)']);
            }
        }
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

    public function sales() {
//        echo $this->layout;die;
//        Configure::write('debug', '2');
        $arrLoggedUser = $this->Auth->user();
        $intVendorId = $arrLoggedUser['vendor_id'];
        $this->loadModel('Vendors');
        $arrSubVendorsDetail = $this->Vendors->find('all', array('conditions' => array('parent_vendor' => $intVendorId)));
        $arrParentVendorsDetail = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $intVendorId, 'parent_vendor' => '0')));
        $arrViewUserDetail = array_merge($arrSubVendorsDetail, $arrParentVendorsDetail);
        $this->set("arrViewUserDetail", $arrViewUserDetail);
    }

    public function ordersReport() {
        $this->autoRender = false;
        $this->layout = "vendors";
        $arrLoggedUser = $this->Auth->user();
        $arrResponse = array();
        $intVendorIds = $arrLoggedUser['vendor_id'];
        $this->loadModel('Vendors');
        $arrViewUserDetail = $this->Vendors->find('all', array('conditions' => array('parent_vendor' => $intVendorId)));
        $this->set("arrViewUserDetail", $arrViewUserDetail);

        if ($this->request->is('Post')) {
            $strVendor = isset($this->request->data['vendors']) ? $this->request->data['vendors'] : null;
            $strReportType = isset($this->request->data['reportType']) ? $this->request->data['reportType'] : null;

            $strPeriod = $this->request->data['filterType'];
            if ($strPeriod != '' && $strPeriod != 'custom') {
                $compTime = $this->Components->load('TimeCalculation');
                $arrDayDate = $compTime->fnGetBeforeDate($strPeriod, date('Y-m-d H:i:s'));
                $strStartDate = $arrDayDate['start'];
                $strEndDate = $arrDayDate['end'];
            } else {
                $strStartDate = isset($this->request->data['strFromDate']) ? $this->request->data['strFromDate'] : null;
                $strEndDate = isset($this->request->data['strToDate']) ? $this->request->data['strToDate'] : null;
            }

            if ($strVendor) {
                $parent_vendor = $strVendor;
                $intVendorId = $strVendor;
            }

            if ($strReportType) {
                if ($strReportType == "New Order" || $strReportType == "Open" || $strReportType == "Pending" || $strReportType == "Closed") {
                    $arrResponse['chartTitle'] = $strReportType . " Statistics";
                    $arrLoggedUser = $this->Auth->user();

                    $this->loadModel('Resourceorderdetail');
                    $this->loadModel('Vendors');
                    $this->loadModel('Portal');

                    if ($strStartDate != '' && $strEndDate != '') {
                        $strStartDate = date("Y-m-d", strtotime($strStartDate));
                        $strEndDate = date("Y-m-d", strtotime($strEndDate));
                        if ($strPeriod != '30') {
                            $arrSeries = $this->createRange($strStartDate, $strEndDate, '1 day', 'Y-m-d');
                        } else {
                            $qt = date('m');
                            $time = strtotime($strStartDate);
                            for ($i = 0; $i < $qt; $i++) {
                                // convert timestamp back to date string
                                $date = date('Y-m-d', $time);
                                $arrSeries[] = $date;
                                // move to next timestamp
                                $time = strtotime('+1 month', $time);
                            }
                        }
                        $strTotal = 0;
                        foreach ($arrSeries as $series) {
                            if ($strPeriod == 'curr_year') {
                                $arrVendor = array();
                                array_push($arrVendor, $intVendorId);
                                foreach ($arrViewUserDetail as $vendors) {
                                    array_push($arrVendor, $vendors['Vendors']['vendor_id']);
                                }
                                if ($strVendor == '') {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetOrderCount($arrVendor = "", $strReportType, $strStartDate, $strEndDate, $strPeriods = "YEAR");
                                } else {
                                    if ($parent_vendor && $parent_vendor != $intVendorIds) {
                                        $arrNewOrders = $this->Resourceorderdetail->fnGetSubOrderCount($intVendorId, $strReportType, $strStartDate, $strEndDate, $strPeriods = "YEAR");
                                    } else {
                                        $arrNewOrders = $this->Resourceorderdetail->fnGetOrderCount($arrVendor, $strReportType, $strStartDate, $strEndDate, $strPeriods = "YEAR");
                                    }
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($parent_vendor && $parent_vendor != $intVendorIds) {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetSubOrderCount($intVendorId, $strReportType, $series, $strToDate, $strPeriods = "MONTH");
                                } else {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetOrderCount($arrVendor, $strReportType, $series, $strToDate, $strPeriods = "MONTH");
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($parent_vendor && $parent_vendor != $intVendorIds) {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetSubOrderCount($intVendorId, $strReportType, $series, $strToDate, $strPeriods = "DATE");
                                } else {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetOrderCount($arrVendor, $strReportType, $series, $strToDate, $strPeriods = "DATE");
                                }
                            }
                            
                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrNewOrders) > 0) {
                                $strSeriesDataValue .= (count($arrNewOrders)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                                $strTotal = "0";
                            }
                            $total += (count($arrNewOrders));
                        }
                        if ($strPeriod == 'curr_year') {
                            $arrResponse['graphseariesvalue'] = (count($arrNewOrders));
                        } else {
                            $arrResponse['graphseariesvalue'] = isset($total) ? $total : '0';
                        }
                    } else {
//                        $strStartDate = '2016-01-01';
//                        $strEndDate = '2016-12-31';
                        $strStartDate = date('Y-').'01-01';
                        $strEndDate = date('Y-m-d', strtotime("+1 days"));
                        if ($strVendor == '') {
                            $arrNewOrders = $this->Resourceorderdetail->fnGetOrderCount($arrVendor = "", $strReportType, $strStartDate, $strEndDate, $strPeriods = "YEAR");
                        } else {
                            if ($parent_vendor && $parent_vendor != $intVendorIds) {
                                $arrNewOrders = $this->Resourceorderdetail->fnGetSubOrderCount($intVendorId, $strReportType, $strStartDate, $strEndDate, $strPeriods = "YEAR");
                            } else {
                                $arrNewOrders = $this->Resourceorderdetail->fnGetOrderCount($intVendorId, $strReportType, $strStartDate, $strEndDate, $strPeriods = "YEAR");
                            }
                        }

                        if (count($arrNewOrders) > 0) {
//                            foreach ($arrNewOrders as $k => $NewOrders) {
//                            if ($strPeriod == 'curr_year') {
//                                $strSeriesData .= date("Y");
//                            } else if ($strPeriod == '30') {
//                                $strSeriesData .= date("M y", strtotime($NewOrders['resource_order_detail']['order_detail_creation_date_time'])) . ",";
//                            } else {
//                                $strSeriesData .= date("jS M y", strtotime($NewOrders['resource_order_detail']['order_detail_creation_date_time'])) . ",";
//                            }
//                            if (count($NewOrders) > 0) {
//                                $strSeriesDataValue .= $NewOrders[0]['total'] . ",";
//                                $strTotal = $strTotal + $NewOrders[0]['total'];
//                            } else {
//                                $strSeriesDataValue .= "0,";
//                                $strTotal = "0,";
//                            }
//                        }

                            $strSeriesData .= date("Y");
                            $strSeriesDataValue .= $arrNewOrders[0][0]['total'];
                        } else {
                            $strSeriesData = date("Y");
                            $strSeriesDataValue .= "0,";
                        }
                        $arrResponse['graphseariesvalue'] = isset($arrNewOrders[0][0]['total']) ? $arrNewOrders[0][0]['total'] : '0';
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'vendororders', 'action' => 'orderslist'), true) . "?Vendor=" . base64_encode($strVendor) . "&reportType=" . base64_encode($strReportType) . "&filterType=" . base64_encode($strPeriod) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        if ($strReportType == 'New Order') {
                            $arrResponse['dataseries'] = rtrim($strReportType . " :" . count($arrNewOrders));
                        }else{
                            $arrResponse['dataseries'] = rtrim($strReportType . " Orders :" . count($arrNewOrders));
                        }
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        if ($strReportType == 'New Order') {
                            $arrResponse['dataseries'] = rtrim($strReportType . " :" . $strSeriesDataValue);
                        }else{
                            $arrResponse['dataseries'] = rtrim($strReportType . " Orders :" . $strSeriesDataValue);
                        }
                    }
                    if ($strReportType == 'New Order') {
                        $arrResponse['graphsearies'] = $strReportType . " Report";
                        $arrResponse['graphsearieslabel'] = $strReportType . " Report";
                        $arrResponse['chartTitle'] = $strReportType . " Report";
                    }else{
                        $arrResponse['graphsearies'] = $strReportType . " Orders Report";
                        $arrResponse['graphsearieslabel'] = $strReportType . " Orders Report";
                        $arrResponse['chartTitle'] = $strReportType . " Orders Report";
                    }
                    
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strReportType == "Earned") {
                    $arrResponse['chartTitle'] = "Total Amount Earned";
                    $arrLoggedUser = $this->Auth->user();

                    $this->loadModel('Resourceorderdetail');
                    $this->loadModel('Vendors');
                    $this->loadModel('Portal');

                    if ($strStartDate != '' && $strEndDate != '') {
                        $strStartDate = date("Y-m-d", strtotime($strStartDate));
                        $strEndDate = date("Y-m-d", strtotime($strEndDate));
                        if ($strPeriod != '30') {
                            $arrSeries = $this->createRange($strStartDate, $strEndDate, '1 day', 'Y-m-d');
                        } else {
                            $qt = date('m');
                            $time = strtotime($strStartDate);
                            for ($i = 0; $i < $qt; $i++) {
                                // convert timestamp back to date string
                                $date = date('Y-m-d', $time);
                                $arrSeries[] = $date;
                                // move to next timestamp
                                $time = strtotime('+1 month', $time);
                            }
                        }
                        $strTotal = 0;
                        foreach ($arrSeries as $series) {
                            if ($strPeriod == 'curr_year') {
                                $arrVendor = array();
                                array_push($arrVendor, $intVendorId);
                                foreach ($arrViewUserDetail as $vendors) {
                                    array_push($arrVendor, $vendors['Vendors']['vendor_id']);
                                }
                                if ($strVendor == '') {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetEarnedOrderAmount($arrVendor = "", $strReportType, $strStartDate, $strEndDate);
                                } else {
                                    if ($parent_vendor) {
                                        $arrNewOrders = $this->Resourceorderdetail->fnGetSubEarnedOrderAmount($intVendorId, $strReportType, $strStartDate, $strEndDate);
                                    } else {
                                        $arrNewOrders = $this->Resourceorderdetail->fnGetEarnedOrderAmount($arrVendor, $strReportType, $strStartDate, $strEndDate);
                                    }
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($parent_vendor) {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetSubEarnedOrderAmount($intVendorId, $strReportType, $series, $strToDate);
                                } else {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetEarnedOrderAmount($arrVendor, $strReportType, $series, $strToDate);
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($parent_vendor) {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetSubEarnedOrderAmount($intVendorId, $strReportType, $series, $strToDate);
                                } else {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetEarnedOrderAmount($arrVendor, $strReportType, $series, $strToDate);
                                }
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrNewOrders) > 0) {
                                $strSeriesDataValue .= (count($arrNewOrders)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                                $strTotal = "0";
                            }
                        }
                        if ($strPeriod == 'curr_year') {
                            $arrResponse['graphseariesvalue'] = (count($arrNewOrders));
                        } else {
                            $arrResponse['graphseariesvalue'] = isset($strTotal) ? "$ " . $strTotal : '$ 0.00';
                        }
                    } else {
                        $strStartDate = date('Y-') . '01-01';
                        $strEndDate = date('Y-m-d', strtotime("+1 days"));
//                        echo $strStartDate." ".$strEndDate;
                        if ($strVendor == '') {
                            $arrNewOrders = $this->Resourceorderdetail->fnGetEarnedOrderAmount($arrVendor = "", $strReportType, $strStartDate, $strEndDate);
                        } else {
                            if ($parent_vendor) {
                                $arrNewOrders = $this->Resourceorderdetail->fnGetSubEarnedOrderAmount($intVendorId, $strReportType, $strStartDate, $strEndDate);
                            } else {
                                $arrNewOrders = $this->Resourceorderdetail->fnGetEarnedOrderAmount($arrVendor, $strReportType, $strStartDate, $strEndDate);
                            }
                        }
                        if (count($arrNewOrders) > 0) {
                            foreach ($arrNewOrders as $k => $NewOrders) {
                                if (count($NewOrders) > 0) {
                                    $strSeriesDataValue .= $NewOrders[0]['amount'] . ",";
                                    $strTotal = $strTotal + $NewOrders[0]['amount'];
                                } else {
                                    $strSeriesDataValue .= "0,";
                                    $strTotal = "0";
                                }
                            }
                            $strSeriesData .= date("Y");
                            $strSeriesDataValue .= $strTotal;
                        } else {
                            $strSeriesData .= date("Y");
                            $strSeriesDataValue .= "0,";
                        }

                        $arrResponse['graphseariesvalue'] = isset($strTotal) ? "$ " . $strTotal : '$ 0.00';
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'vendororders', 'action' => 'earnedorderlist'), true) . "?Vendor=" . base64_encode($strVendor) . "&reportType=" . base64_encode('Closed') . "&filterType=" . base64_encode($strPeriod) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Total Amount Earned :" . count($NewOrders));
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Total Amount Earned :" . $strSeriesDataValue);
                    }
                    $arrResponse['graphsearies'] = "Total Amount Earned Report";
                    $arrResponse['graphsearieslabel'] = "Total Amount Earned Report";

                    $arrResponse['chartTitle'] = "Total Amount Earned Report";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strReportType == "Refunds") {
                    $arrResponse['chartTitle'] = "Total Refunds Provided";
                    $arrLoggedUser = $this->Auth->user();

                    $this->loadModel('Resourceorderdetail');
                    $this->loadModel('Vendors');
                    $this->loadModel('Portal');

                    if ($strStartDate != '' && $strEndDate != '') {
                        $strStartDate = date("Y-m-d", strtotime($strStartDate));
                        $strEndDate = date("Y-m-d", strtotime($strEndDate));
                        if ($strPeriod != '30') {
                            $arrSeries = $this->createRange($strStartDate, $strEndDate, '1 day', 'Y-m-d');
                        } else {
                            $qt = date('m');
                            $time = strtotime($strStartDate);
                            for ($i = 0; $i < $qt; $i++) {
                                // convert timestamp back to date string
                                $date = date('Y-m-d', $time);
                                $arrSeries[] = $date;
                                // move to next timestamp
                                $time = strtotime('+1 month', $time);
                            }
                        }
                        $strTotal = 0;
                        foreach ($arrSeries as $series) {
                            if ($strPeriod == 'curr_year') {
                                $arrVendor = array();
                                array_push($arrVendor, $intVendorId);
                                foreach ($arrViewUserDetail as $vendors) {
                                    array_push($arrVendor, $vendors['Vendors']['vendor_id']);
                                }
                                if ($strVendor == '') {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetRefundOrderAmount($arrVendor = "", $strReportType, $strStartDate, $strEndDate);
                                } else {
                                    if ($parent_vendor) {
                                        $arrNewOrders = $this->Resourceorderdetail->fnGetSubRefundOrderAmount($intVendorId, $strReportType, $strStartDate, $strEndDate);
                                    } else {
                                        $arrNewOrders = $this->Resourceorderdetail->fnGetRefundOrderAmount($arrVendor, $strReportType, $strStartDate, $strEndDate);
                                    }
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($parent_vendor) {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetSubRefundOrderAmount($intVendorId, $strReportType, $series, $strToDate);
                                } else {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetRefundOrderAmount($arrVendor, $strReportType, $series, $strToDate);
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($parent_vendor) {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetSubRefundOrderAmount($intVendorId, $strReportType, $series, $strToDate);
                                } else {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetRefundOrderAmount($arrVendor, $strReportType, $series, $strToDate);
                                }
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrNewOrders) > 0) {
                                $strSeriesDataValue .= (count($arrNewOrders)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                                $strTotal = "0";
                            }
                        }
                        if ($strPeriod == 'curr_year') {
                            $arrResponse['graphseariesvalue'] = (count($arrNewOrders));
                        } else {
                            $arrResponse['graphseariesvalue'] = isset($strTotal) ? "$ " . $strTotal : '$ 0.00';
                        }
                    } else {
                        $strStartDate = date('Y-') . '01-01';
                        $strEndDate = date('Y-m-d', strtotime("+1 days"));
                        if ($strVendor == '') {
                            $arrNewOrders = $this->Resourceorderdetail->fnGetRefundOrderAmount($arrVendor = "", $strReportType, $strStartDate, $strEndDate);
                        } else {
                            if ($parent_vendor) {
                                $arrNewOrders = $this->Resourceorderdetail->fnGetSubRefundOrderAmount($intVendorId, $strReportType, $strStartDate, $strEndDate);
                            } else {
                                $arrNewOrders = $this->Resourceorderdetail->fnGetRefundOrderAmount($arrVendor, $strReportType, $strStartDate, $strEndDate);
                            }
                        }
                        if (count($arrNewOrders) > 0) {

                            foreach ($arrNewOrders as $k => $NewOrders) {
                                if (count($NewOrders) > 0) {
                                    $strSeriesDataValue .= $NewOrders[0]['refundTotal'] . ",";
                                    $strTotal = $strTotal + $NewOrders[0]['refundTotal'];
                                } else {
                                    $strSeriesDataValue .= "0,";
                                    $strTotal = "0";
                                }
                            }
                            $strSeriesData .= date("Y");
                            $strSeriesDataValue .= $strTotal;
                        } else {
                            $strSeriesData .= date("Y");
                            $strSeriesDataValue .= "0,";
                        }

                        $arrResponse['graphseariesvalue'] = isset($strTotal) ? "$ " . $strTotal : '$ 0.00';
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'vendororders', 'action' => 'refundedorderlist'), true) . "?Vendor=" . base64_encode($strVendor) . "&reportType=" . base64_encode($strReportType) . "&filterType=" . base64_encode($strPeriod) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Total Refunds Provided :" . count($NewOrders));
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Total Refunds Provided :" . $strSeriesDataValue);
                    }
                    $arrResponse['graphsearies'] = "Total Refunds Provided Report";
                    $arrResponse['graphsearieslabel'] = "Total Refunds Provided Report";

                    $arrResponse['chartTitle'] = "Total Refunds Provided Report";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }
            }
        }
    }

    public function orderslist() {
        $strPeriod = isset($_GET['filterType']) ? base64_decode($_GET['filterType']) : null;
        $strVendor = isset($_GET['Vendor']) ? base64_decode($_GET['Vendor']) : null;
        $strReport_type = isset($_GET['reportType']) ? base64_decode($_GET['reportType']) : null;
        $strStartDate = isset($_GET['startDate']) ? base64_decode($_GET['startDate']) : null;
        $strEndDate = isset($_GET['endDate']) ? base64_decode($_GET['endDate']) : null;
        $arrLoggedUser = $this->Auth->user();
        $intVendorIds = $arrLoggedUser['vendor_id'];
        $this->loadModel('Resourceorderdetail');
        $this->loadModel('Vendors');
        if ($strVendor) {
            $parent_vendor = $strVendor;
            $intVendorId = $strVendor;
        }
        if($parent_vendor != $intVendorIds){
            $arrViewUserDetail = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $intVendorId)));
            $vendorName = $arrViewUserDetail[0]['Vendors']['vendor_first_name']." ".$arrViewUserDetail[0]['Vendors']['vendor_last_name'];
        }else{
            $arrViewUserDetail = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $intVendorIds)));
            $vendorName = $arrViewUserDetail[0]['Vendors']['vendor_first_name']." ".$arrViewUserDetail[0]['Vendors']['vendor_last_name'];
        }
        
       
        
        if ($strVendor == '') {
            $arrNewOrders = $this->Resourceorderdetail->fnGetOrderCountList($arrVendor = "", $strReport_type, $strStartDate, $strEndDate);
        } else {
            if ($parent_vendor && $parent_vendor != $intVendorIds) {
                $arrNewOrders = $this->Resourceorderdetail->fnGetSubOrderCountList($intVendorId, $strReport_type, $strStartDate, $strEndDate);
            } else {
                $arrNewOrders = $this->Resourceorderdetail->fnGetOrderCountList($intVendorId, $strReport_type, $strStartDate, $strEndDate);
            }
        }
        
        if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
            $this->loadModel('Resourceorder');
            $this->loadModel('Candidate');
            $this->loadModel('Resources');
            $this->loadModel('Subvendororders');
            $intFrCnt = 0;
            foreach ($arrNewOrders as $arrOrder) {
                $intOrderId = $arrOrder['resource_order_detail']['order_id'];
                $intVendorType = $arrOrder['resource_order_detail']['vendor_type'];
                $intVendorId = $arrOrder['sub_vendor_order_service']['vendor_id'];
                $arrOrderDetail = $this->Resourceorder->find('all', array('conditions' => array('resource_order_id' => $intOrderId)));
                if (is_array($arrOrderDetail) && (count($arrOrderDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['mainorder'] = $arrOrderDetail[0];
                }
                $intServiceId = $arrOrder['resource_order_detail']['product_id'];
                $arrServiceDetail = $this->Resources->find('all', array('conditions' => array('productd_id' => $intServiceId)));
                if (is_array($arrServiceDetail) && (count($arrServiceDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['service'] = $arrServiceDetail[0];
                }
                $intCustomerId = $arrOrder['resource_order_detail']['seeker_id'];
                $arrCustomerDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $intCustomerId)));
                if (is_array($arrCustomerDetail) && (count($arrCustomerDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['customer'] = $arrCustomerDetail[0];
                }
                //echo $intVendorId;
                $con = array();
                if ($strVendor) {
                    $con['Vendors.vendor_id'] = $strVendor;
                    $con['Subvendororders.order_id'] = $intOrderId;
                } else {
                    $con['Subvendororders.order_id'] = $intOrderId;
                }
                $arrSubVendorsFor = $this->Subvendororders->find('all', array(
                    'fields' => array('Vendors.*', 'Subvendororders.*'),
                    'joins' => array(
                        array(
                            'table' => 'vendors',
                            'alias' => 'Vendors',
                            'type' => 'inner',
                            'conditions' => array('Subvendororders.vendor_id=Vendors.vendor_id')
                        )
                    ),
                    'conditions' => $con
                ));
                if (is_array($arrSubVendorsFor) && (count($arrSubVendorsFor) > 0)) {
                    $arrNewOrders[$intFrCnt]['vendorsuser'] = $arrSubVendorsFor[0];
                } else {
                    
                }
                $intFrCnt++;
            }
        }
//           echo '<pre>';print_r($arrNewOrders);die;  
        $this->set('selected_vendor', $strVendor);
        $this->set('selected_report_type', $strReport_type);
        $this->set('selected_filter_type', $strPeriod);
        if ($strStartDate != '' && $strEndDate != '') {
            $this->set('selected_start_date', date("Y-m-d", strtotime($strStartDate)));
            $this->set('selected_end_date', date("Y-m-d", strtotime($strEndDate)));
        }
        $this->set('reportName', $strReport_type);
        $this->set('VendorName', $vendorName);
        $this->set('arrProductList', $arrNewOrders);
    }

    public function earnedorderlist() {
//        Configure::write('debug', '2');
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Resourceorderdetail');
        $this->loadModel('Vendors');
        $this->loadModel('Portal');
        $arrConditions = array();
        $arrSubVendorConditions = array();
        $intVendorId = $arrLoggedUser['vendor_id'];
        $this->loadModel('Subvendororders');
        $this->loadModel('Vendors');
        $arrViewUserDetail = $this->Vendors->find('all', array('conditions' => array('parent_vendor' => $intVendorId)));
        $this->set("arrViewUserDetail", $arrViewUserDetail);
        $parent_vendor = '';
        if ($arrLoggedUser['parent_vendor']) {
            $parent_vendor = $arrLoggedUser['parent_vendor'];
            $arrSubVendorConditions['Subvendororders.vendor_id'] = $intVendorId;
            $arrSubVendorConditions['Resourceorderdetail.vendor_type'] = "vendor";
        } else {
            $arrVendor = array();
            array_push($arrVendor, $intVendorId);
            foreach ($arrViewUserDetail as $vendors) {
                array_push($arrVendor, $vendors['Vendors']['vendor_id']);
            }
            $parent_vendor = '';
            $arrConditions['Resourceorderdetail.vendor_id'] = $arrVendor;
            $arrConditions['Resourceorderdetail.vendor_type'] = "vendor";
        }

        $strPeriod = isset($_GET['filterType']) ? base64_decode($_GET['filterType']) : null;
        $strVendor = isset($_GET['vendors']) ? base64_decode($_GET['vendors']) : null;
        $strReport_type = isset($_GET['reportType']) ? base64_decode($_GET['reportType']) : null;

        if ($strPeriod != '' && $strPeriod != 'custom') {
            $compTime = $this->Components->load('TimeCalculation');
            $arrDayDate = $compTime->fnGetBeforeDate($strPeriod, date('Y-m-d H:i:s'));
            $strStartDate = $arrDayDate['start'];
            $strEndDate = $arrDayDate['end'];
        } else {
            $strStartDate = isset($_GET['startDate']) ? base64_decode($_GET['startDate']) : null;
            $strEndDate = isset($_GET['endDate']) ? base64_decode($_GET['endDate']) : null;
        }

        if ($strVendor) {
            $parent_vendor = $strVendor;
            $intVendorId = $strVendor;
        }
        if ($parent_vendor) {
            $arrConditions = array();
            $arrSubVendorConditions = array();
            $arrSubVendorConditions['Subvendororders.vendor_id'] = $intVendorId;
            $arrSubVendorConditions['Resourceorderdetail.vendor_type'] = "vendor";
            if ($strReport_type != '' && $strReport_type != 'Earned' && $strReport_type != 'Refunds') {
                $arrSubVendorConditions['Resourceorderdetail.vendor_order_state'] = $strReport_type;
            }
            if (isset($strStartDate) && $strStartDate != '') {
                $arrSubVendorConditions['Resourceorderdetail.order_detail_creation_date_time >='] = $strStartDate;
            }

            if (isset($strEndDate) && $strEndDate != '') {
                $arrSubVendorConditions['Resourceorderdetail.order_detail_creation_date_time <='] = $strEndDate;
            }
            $arrNewOrders = $this->Subvendororders->find('all', array(
                'fields' => array('Resourceorderdetail.*', 'Subvendororders.*'),
                'joins' => array(
                    array(
                        'table' => 'resource_order_detail',
                        'alias' => 'Resourceorderdetail',
                        'type' => 'inner',
                        'conditions' => array('Subvendororders.order_id=Resourceorderdetail.order_id')
                    )
                ),
                'conditions' => $arrSubVendorConditions,
                'order' => array('Resourceorderdetail.order_detail_creation_date_time' => 'desc')
            ));

            $arrTotalSumQ = $this->Subvendororders->find('all', array(
                'fields' => array('SUM(Resourceorderdetail.product_unit_cost) AS amount,sum(vendor_cost) as refundTotal'),
                'joins' => array(
                    array(
                        'table' => 'resource_order_detail',
                        'alias' => 'Resourceorderdetail',
                        'type' => 'inner',
                        'conditions' => array('Subvendororders.order_id=Resourceorderdetail.order_id')
                    )
                ),
                'conditions' => $arrSubVendorConditions,
                'order' => array('order_detail_id' => 'desc')
            ));
        } else {
            $arrConditions = array();
            $arrSubVendorConditions = array();
            $arrVendor = array();
            array_push($arrVendor, $intVendorId);
            foreach ($arrViewUserDetail as $vendors) {
                array_push($arrVendor, $vendors['Vendors']['vendor_id']);
            }
            $parent_vendor = '';
            $arrConditions['Resourceorderdetail.vendor_id'] = $arrVendor;
            $arrConditions['Resourceorderdetail.vendor_type'] = "vendor";
            if ($strReport_type != '' && $strReport_type != 'Earned' && $strReport_type != 'Refunds') {
                $arrConditions['Resourceorderdetail.vendor_order_state'] = $strReport_type;
            }
            if (isset($strStartDate) && $strStartDate != '') {
                $arrConditions['Resourceorderdetail.order_detail_creation_date_time >='] = $strStartDate;
            }

            if (isset($strEndDate) && $strEndDate != '') {
                $arrConditions['Resourceorderdetail.order_detail_creation_date_time <='] = $strEndDate;
            }
            $arrNewOrders = $this->Resourceorderdetail->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'resource_order',
                        'alias' => 'Resourceorder',
                        'type' => 'inner',
                        'conditions' => array('Resourceorderdetail.order_id=Resourceorder.resource_order_id')
                    )
                ),
                'conditions' => $arrConditions,
                'order' => array('order_detail_id' => 'desc')
            ));

            $arrTotalSumQ = $this->Resourceorderdetail->find('all', array(
                'fields' => array('SUM(Resourceorderdetail.product_unit_cost) AS amount'),
                'joins' => array(
                    array(
                        'table' => 'resource_order',
                        'alias' => 'Resourceorder',
                        'type' => 'inner',
                        'conditions' => array('Resourceorderdetail.order_id=Resourceorder.resource_order_id')
                    )
                ),
                'conditions' => $arrConditions,
                'order' => array('order_detail_id' => 'desc')
            ));
        }

        if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
            $this->loadModel('Resourceorder');
            $this->loadModel('Candidate');
            $this->loadModel('Resources');
            $intFrCnt = 0;
            foreach ($arrNewOrders as $arrOrder) {
                $intOrderId = $arrOrder['Resourceorderdetail']['order_id'];
                $intVendorType = $arrOrder['Resourceorderdetail']['vendor_type'];
                $intVendorId = $arrOrder['Subvendororders']['vendor_id'];
                $arrOrderDetail = $this->Resourceorder->find('all', array('conditions' => array('resource_order_id' => $intOrderId)));
                if (is_array($arrOrderDetail) && (count($arrOrderDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['mainorder'] = $arrOrderDetail[0];
                }
                $intServiceId = $arrOrder['Resourceorderdetail']['product_id'];
                $arrServiceDetail = $this->Resources->find('all', array('conditions' => array('productd_id' => $intServiceId)));
                if (is_array($arrServiceDetail) && (count($arrServiceDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['service'] = $arrServiceDetail[0];
                }
                $intCustomerId = $arrOrder['Resourceorderdetail']['seeker_id'];
                $arrCustomerDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $intCustomerId)));
                if (is_array($arrCustomerDetail) && (count($arrCustomerDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['customer'] = $arrCustomerDetail[0];
                }
                //echo $intVendorId;
                $con = array();
                if ($strVendor) {
                    $con['Vendors.vendor_id'] = $strVendor;
                    $con['Subvendororders.order_id'] = $intOrderId;
                } else {
                    $con['Subvendororders.order_id'] = $intOrderId;
                }
                $arrSubVendorsFor = $this->Subvendororders->find('all', array(
                    'fields' => array('Vendors.*', 'Subvendororders.*'),
                    'joins' => array(
                        array(
                            'table' => 'vendors',
                            'alias' => 'Vendors',
                            'type' => 'inner',
                            'conditions' => array('Subvendororders.vendor_id=Vendors.vendor_id')
                        )
                    ),
                    'conditions' => $con
                ));
                if (is_array($arrSubVendorsFor) && (count($arrSubVendorsFor) > 0)) {
                    $arrNewOrders[$intFrCnt]['vendorsuser'] = $arrSubVendorsFor[0];
                } else {
                    
                }
                $intFrCnt++;
            }
        }

        $this->set('selected_vendor', $strVendor);
        $this->set('selected_report_type', $strReport_type);
        $this->set('selected_filter_type', $strPeriod);
        if ($strStartDate != '' && $strEndDate != '') {
            $this->set('selected_start_date', date("Y-m-d", strtotime($strStartDate)));
            $this->set('selected_end_date', date("Y-m-d", strtotime($strEndDate)));
        }
        $this->set('arrProductList', $arrNewOrders);
        //exit();
    }

    public function refundedorderlist() {
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Resourceorderdetail');
        $this->loadModel('Vendors');
        $this->loadModel('Portal');
        $arrConditions = array();
        $arrSubVendorConditions = array();
        $intVendorId = $arrLoggedUser['vendor_id'];
        $this->loadModel('Subvendororders');
        $this->loadModel('Vendors');
        $arrViewUserDetail = $this->Vendors->find('all', array('conditions' => array('parent_vendor' => $intVendorId)));
        $this->set("arrViewUserDetail", $arrViewUserDetail);
        $parent_vendor = '';
        if ($arrLoggedUser['parent_vendor']) {
            $parent_vendor = $arrLoggedUser['parent_vendor'];
            $arrSubVendorConditions['Subvendororders.vendor_id'] = $intVendorId;
            $arrSubVendorConditions['Resourceorderdetail.vendor_type'] = "vendor";
        } else {
            $arrVendor = array();
            array_push($arrVendor, $intVendorId);
            foreach ($arrViewUserDetail as $vendors) {
                array_push($arrVendor, $vendors['Vendors']['vendor_id']);
            }
            $parent_vendor = '';
            $arrConditions['Resourceorderdetail.vendor_id'] = $arrVendor;
            $arrConditions['Resourceorderdetail.vendor_type'] = "vendor";
        }

        $strPeriod = isset($_GET['filterType']) ? base64_decode($_GET['filterType']) : null;
        $strVendor = isset($_GET['vendors']) ? base64_decode($_GET['vendors']) : null;
        $strReport_type = isset($_GET['reportType']) ? base64_decode($_GET['reportType']) : null;

        if ($strPeriod != '' && $strPeriod != 'custom') {
            $compTime = $this->Components->load('TimeCalculation');
            $arrDayDate = $compTime->fnGetBeforeDate($strPeriod, date('Y-m-d H:i:s'));
            $strStartDate = $arrDayDate['start'];
            $strEndDate = $arrDayDate['end'];
        } else {
            $strStartDate = isset($_GET['startDate']) ? base64_decode($_GET['startDate']) : null;
            $strEndDate = isset($_GET['endDate']) ? base64_decode($_GET['endDate']) : null;
        }

        if ($strVendor) {
            $parent_vendor = $strVendor;
            $intVendorId = $strVendor;
        }
        if ($parent_vendor) {
            $arrConditions = array();
            $arrSubVendorConditions = array();
            $arrSubVendorConditions['Subvendororders.vendor_id'] = $intVendorId;
            $arrSubVendorConditions['Resourceorderdetail.vendor_type'] = "vendor";
            $arrSubVendorConditions['Resourceorderdetail.refund_status'] = "1";
            if ($strReport_type != '' && $strReport_type != 'Earned' && $strReport_type != 'Refunds') {
                $arrSubVendorConditions['Resourceorderdetail.vendor_order_state'] = $strReport_type;
            }
            if (isset($strStartDate) && $strStartDate != '') {
                $arrSubVendorConditions['Resourceorderdetail.order_detail_creation_date_time >='] = $strStartDate;
            }

            if (isset($strEndDate) && $strEndDate != '') {
                $arrSubVendorConditions['Resourceorderdetail.order_detail_creation_date_time <='] = $strEndDate;
            }
            $arrNewOrders = $this->Subvendororders->find('all', array(
                'fields' => array('Resourceorderdetail.*', 'Subvendororders.*'),
                'joins' => array(
                    array(
                        'table' => 'resource_order_detail',
                        'alias' => 'Resourceorderdetail',
                        'type' => 'inner',
                        'conditions' => array('Subvendororders.order_id=Resourceorderdetail.order_id')
                    )
                ),
                'conditions' => $arrSubVendorConditions,
                'order' => array('Resourceorderdetail.order_detail_creation_date_time' => 'desc')
            ));

            $arrTotalSumQ = $this->Subvendororders->find('all', array(
                'fields' => array('SUM(Resourceorderdetail.product_unit_cost) AS amount,sum(vendor_cost) as refundTotal'),
                'joins' => array(
                    array(
                        'table' => 'resource_order_detail',
                        'alias' => 'Resourceorderdetail',
                        'type' => 'inner',
                        'conditions' => array('Subvendororders.order_id=Resourceorderdetail.order_id')
                    )
                ),
                'conditions' => $arrSubVendorConditions,
                'order' => array('order_detail_id' => 'desc')
            ));
        } else {
            $arrConditions = array();
            $arrSubVendorConditions = array();
            $arrVendor = array();
            array_push($arrVendor, $intVendorId);
            foreach ($arrViewUserDetail as $vendors) {
                array_push($arrVendor, $vendors['Vendors']['vendor_id']);
            }
            $parent_vendor = '';
            $arrConditions['Resourceorderdetail.vendor_id'] = $arrVendor;
            $arrConditions['Resourceorderdetail.vendor_type'] = "vendor";
            $arrConditions['Resourceorderdetail.refund_status'] = "1";
            if ($strReport_type != '' && $strReport_type != 'Earned' && $strReport_type != 'Refunds') {
                $arrConditions['Resourceorderdetail.vendor_order_state'] = $strReport_type;
            }
            if (isset($strStartDate) && $strStartDate != '') {
                $arrConditions['Resourceorderdetail.order_detail_creation_date_time >='] = $strStartDate;
            }

            if (isset($strEndDate) && $strEndDate != '') {
                $arrConditions['Resourceorderdetail.order_detail_creation_date_time <='] = $strEndDate;
            }
            $arrNewOrders = $this->Resourceorderdetail->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'resource_order',
                        'alias' => 'Resourceorder',
                        'type' => 'inner',
                        'conditions' => array('Resourceorderdetail.order_id=Resourceorder.resource_order_id')
                    )
                ),
                'conditions' => $arrConditions,
                'order' => array('order_detail_id' => 'desc')
            ));

            $arrTotalSumQ = $this->Resourceorderdetail->find('all', array(
                'fields' => array('SUM(Resourceorderdetail.product_unit_cost) AS amount'),
                'joins' => array(
                    array(
                        'table' => 'resource_order',
                        'alias' => 'Resourceorder',
                        'type' => 'inner',
                        'conditions' => array('Resourceorderdetail.order_id=Resourceorder.resource_order_id')
                    )
                ),
                'conditions' => $arrConditions,
                'order' => array('order_detail_id' => 'desc')
            ));
        }

        if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
            $this->loadModel('Resourceorder');
            $this->loadModel('Candidate');
            $this->loadModel('Resources');
            $intFrCnt = 0;
            foreach ($arrNewOrders as $arrOrder) {
                $intOrderId = $arrOrder['Resourceorderdetail']['order_id'];
                $intVendorType = $arrOrder['Resourceorderdetail']['vendor_type'];
                $intVendorId = $arrOrder['Subvendororders']['vendor_id'];
                $arrOrderDetail = $this->Resourceorder->find('all', array('conditions' => array('resource_order_id' => $intOrderId)));
                if (is_array($arrOrderDetail) && (count($arrOrderDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['mainorder'] = $arrOrderDetail[0];
                }
                $intServiceId = $arrOrder['Resourceorderdetail']['product_id'];
                $arrServiceDetail = $this->Resources->find('all', array('conditions' => array('productd_id' => $intServiceId)));
                if (is_array($arrServiceDetail) && (count($arrServiceDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['service'] = $arrServiceDetail[0];
                }
                $intCustomerId = $arrOrder['Resourceorderdetail']['seeker_id'];
                $arrCustomerDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $intCustomerId)));
                if (is_array($arrCustomerDetail) && (count($arrCustomerDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['customer'] = $arrCustomerDetail[0];
                }
                //echo $intVendorId;
                $con = array();
                if ($strVendor) {
                    $con['Vendors.vendor_id'] = $strVendor;
                    $con['Subvendororders.order_id'] = $intOrderId;
                } else {
                    $con['Subvendororders.order_id'] = $intOrderId;
                }
                $arrSubVendorsFor = $this->Subvendororders->find('all', array(
                    'fields' => array('Vendors.*', 'Subvendororders.*'),
                    'joins' => array(
                        array(
                            'table' => 'vendors',
                            'alias' => 'Vendors',
                            'type' => 'inner',
                            'conditions' => array('Subvendororders.vendor_id=Vendors.vendor_id')
                        )
                    ),
                    'conditions' => $con
                ));
                if (is_array($arrSubVendorsFor) && (count($arrSubVendorsFor) > 0)) {
                    $arrNewOrders[$intFrCnt]['vendorsuser'] = $arrSubVendorsFor[0];
                } else {
                    
                }
                $intFrCnt++;
            }
        }

        $this->set('selected_vendor', $strVendor);
        $this->set('selected_report_type', $strReport_type);
        $this->set('selected_filter_type', $strPeriod);
        if ($strStartDate != '' && $strEndDate != '') {
            $this->set('selected_start_date', date("Y-m-d", strtotime($strStartDate)));
            $this->set('selected_end_date', date("Y-m-d", strtotime($strEndDate)));
        }
        $this->set('arrProductList', $arrNewOrders);
        //exit();
    }

    public function salesexport() {
        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Resourceorderdetail');
        $this->loadModel('Vendors');
        $this->loadModel('Portal');
        
        $intVendorIds = $arrLoggedUser['vendor_id'];
        $strReport_type = $_GET['reportType'];
        $strStartDate = $_GET['StartDate'];
        $strEndDate = $_GET['EndDate'];
        $intVendorId = isset($_GET['Vendors']) ? ($_GET['Vendors']) : null;
        $VendorName = isset($_GET['VendorName']) ? ($_GET['VendorName']) : null;
        if ($intVendorId == '') {
            $arrNewOrders = $this->Resourceorderdetail->fnGetOrderCountList($intVendorId = "", $strReport_type, $strStartDate, $strEndDate);
        } else {
            if ($intVendorId && $intVendorId != $intVendorIds) {
                $arrNewOrders = $this->Resourceorderdetail->fnGetSubOrderCountList($intVendorId, $strReport_type, $strStartDate, $strEndDate);
            } else {
                $arrNewOrders = $this->Resourceorderdetail->fnGetOrderCountList($intVendorId, $strReport_type, $strStartDate, $strEndDate);
            }
        }

        if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
            $this->loadModel('Resourceorder');
            $this->loadModel('Candidate');
            $this->loadModel('Resources');
            $this->loadModel('Subvendororders');
            $strFileName = "daily_sales_" . time() . ".xls";
            $intFrCnt = 0;
            $intRowCnt = 6;
            $strVCostTotal = 0;

            if ($strReport_type == 'Refunds') {
                $textLabel = "Amount Refunded";
            } else {
                $textLabel = "Amount Earned";
            }

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['vendor_first_name'] . " " . $arrLoggedUser['vendor_last_name'])
                    ->setLastModifiedBy($arrLoggedUser['vendor_first_name'] . " " . $arrLoggedUser['vendor_last_name'])
                    ->setTitle("Service Order Report")
                    ->setSubject("Service Order Report")
                    ->setDescription("Service Order Report")
                    ->setKeywords("Service Order Report")
                    ->setCategory("Service Order Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Order Id')
                    ->setCellValue('B5', 'Item Purchased')
                    ->setCellValue('C5', 'Order Status')
                    ->setCellValue('D5', 'Assigned To')
                    ->setCellValue('E5', 'Assigned Date')
                    ->setCellValue('F5', 'Closed Date')
                    ->setCellValue('G5', $textLabel);

            foreach ($arrNewOrders as $k => $arrOrder) {
                $intOrderId = $arrOrder['resource_order_detail']['order_id'];
                $intVendorType = $arrOrder['resource_order_detail']['vendor_type'];
                $intVendorId = $arrOrder['Subvendororders']['vendor_id'];
                $arrOrderDetail = $this->Resourceorder->find('all', array('conditions' => array('resource_order_id' => $intOrderId)));
                if (is_array($arrOrderDetail) && (count($arrOrderDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['mainorder'] = $arrOrderDetail[0];
                }
                $intServiceId = $arrOrder['resource_order_detail']['product_id'];
                $arrServiceDetail = $this->Resources->find('all', array('conditions' => array('productd_id' => $intServiceId)));
                if (is_array($arrServiceDetail) && (count($arrServiceDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['service'] = $arrServiceDetail[0];
                }
                $intCustomerId = $arrOrder['resource_order_detail']['seeker_id'];
                $arrCustomerDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $intCustomerId)));
                if (is_array($arrCustomerDetail) && (count($arrCustomerDetail) > 0)) {
                    $arrNewOrders[$intFrCnt]['customer'] = $arrCustomerDetail[0];
                }
                //echo $intVendorId;
                $con = array();
                if ($strVendor) {
                    $con['Vendors.vendor_id'] = $strVendor;
                    $con['Subvendororders.order_id'] = $intOrderId;
                } else {
                    $con['Subvendororders.order_id'] = $intOrderId;
                }
                $arrSubVendorsFor = $this->Subvendororders->find('all', array(
                    'fields' => array('Vendors.*', 'Subvendororders.*'),
                    'joins' => array(
                        array(
                            'table' => 'vendors',
                            'alias' => 'Vendors',
                            'type' => 'inner',
                            'conditions' => array('Subvendororders.vendor_id=Vendors.vendor_id')
                        )
                    ),
                    'conditions' => $con
                ));
                
                                                             
                if (is_array($arrSubVendorsFor) && (count($arrSubVendorsFor) > 0)) {
                    $arrNewOrders[$intFrCnt]['vendorsuser'] = $arrSubVendorsFor[0];
                } else {
                    
                }
              
                if($arrNewOrders[$intFrCnt]['mainorder']['Resourceorder']['order_name'] !=""){
                    $orderID = $arrNewOrders[$intFrCnt]['mainorder']['Resourceorder']['order_name'];
                }else{
                    $orderID = $arrNewOrders[$intFrCnt]['resource_order']['order_name'];
                }
                   
                if (is_array($arrNewOrders[$intFrCnt]['vendorsuser']) && (count($arrNewOrders[$intFrCnt]['vendorsuser']) > 0)) {
                    $strVendorName = $arrNewOrders[$intFrCnt]['vendorsuser']['Vendors']['vendor_first_name'] . " " . $arrNewOrders[$intFrCnt]['vendorsuser']['Vendors']['vendor_last_name'];
                } else {
                    $strVendorName = $arrNewOrders[$intFrCnt]['resource_order_detail']['vendor_name'];
                }
                
                if (is_array($arrNewOrders[$intFrCnt]['vendorsuser']) && (count($arrNewOrders[$intFrCnt]['vendorsuser']) > 0)) {
                    $assign_date = date('F d Y', strtotime($arrNewOrders[$intFrCnt]['vendorsuser']['Subvendororders']['inserted_date_time']));
                } else {
                    $assign_date = "NA";
                }
                $order_status = $arrNewOrders[$intFrCnt]['resource_order_detail']['vendor_order_state'];

                $strVendorCost = "";
                $strOwnerCost = "";
                $strHCostCost = "";

                if ($arrNewOrders[$intFrCnt]['resource_order_detail']['vendor_order_close_date'] != '0000-00-00') {
                    $close_date = date('F d Y', strtotime($arrNewOrders[$intFrCnt]['Resourceorderdetail']['vendor_order_close_date']));
                } else {
                    $close_date = "NA";
                }
                if ($arrNewOrders[$intFrCnt]['resource_order_detail']['refund_status']) {
                    $strVendorCost = $arrNewOrders[$intFrCnt]['resource_order_detail']['vendor_cost'];
                    $strVCostTotal += $arrNewOrders[$intFrCnt]['resource_order_detail']['vendor_cost'];
                } else {
                    $strVendorCost = $arrNewOrders[$intFrCnt]['resource_order_detail']['vendor_cost'];
                    $strVCostTotal += $arrNewOrders[$intFrCnt]['resource_order_detail']['vendor_cost'];
                }

                if ($arrNewOrders[$intFrCnt]['resource_order_detail']['refund_status']) {
                    $strOwnerCost = "0.00";
                } else {
                    $strOwnerCost = $arrNewOrders[$intFrCnt]['resource_order_detail']['portal_owner_cost'];
                }

                if ($arrNewOrders[$intFrCnt]['resource_order_detail']['refund_status']) {
                    $strHCostCost = "0.00";
                } else {
                    $strHCostCost = $arrNewOrders[$intFrCnt]['resource_order_detail']['hc_profit_cost'];
                }
                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $orderID)
                        ->setCellValue('B' . $intRowCnt, $arrNewOrders[$intFrCnt]['service']['Resources']['product_name'])
                        ->setCellValue('C' . $intRowCnt, $order_status)
                        ->setCellValue('D' . $intRowCnt, $strVendorName)
                        ->setCellValue('E' . $intRowCnt, $assign_date)
                        ->setCellValue('F' . $intRowCnt, $close_date)
                        ->setCellValue('G' . $intRowCnt, isset($strVendorCost) ? $strVendorCost . " USD" : '0 USD');

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);  //set column C width

                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(20);  //set row 4 height

                $intFrCnt++;
                $intRowCnt++;
            }

            $totalLabelRow = (count($arrNewOrders) + 7);

            $objPHPExcel->getActiveSheet()->mergeCells("F" . ($totalLabelRow) . ":G" . ($totalLabelRow));
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F' . $totalLabelRow, isset($strVCostTotal) ? "Total Vendor Cost =  " . $strVCostTotal . " USD" : 'Total Vendor Cost = 0 USD');
            $objPHPExcel->getActiveSheet()->getStyle('F' . $totalLabelRow)->getFont()->setSize(14);

            if ($_GET['Vendors'] == '') {
                $objPHPExcel->getActiveSheet()->mergeCells('C2:E2');
                $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Reporting for All');
                $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(22);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
            } else {
                $objPHPExcel->getActiveSheet()->mergeCells('C2:E2');
                $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Reporting for ' . $VendorName);
                $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(22);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
            }

            if (($_GET['StartDate']) && $_GET['EndDate'] != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('C3:E3');
                $objPHPExcel->getActiveSheet()->setCellValue('C3', $_GET['StartDate'] . " - " . $_GET['EndDate']);
                $objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setSize(15);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
            }
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle($strFileName);
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
            $filename = WWW_ROOT . 'adminsales/' . $strFileName;
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save($filename);

            $arrResponse['status'] = "success";
            $arrResponse['file'] = $strFileName;
            $arrResponse['filepath'] = "adminsales";
        } else {
            $arrResponse['status'] = "fail";
            $arrResponse['message'] = "There are no sales in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }

    function createRange($start, $end, $interval, $format) {
        $start = new DateTime($start);
        $end = new DateTime($end);
        $invert = $start > $end;
        $dates = array();
        $dates[] = $start->format($format);
        while ($start != $end) {
            $start->modify(($invert ? '-' : '+') . $interval);
            $dates[] = $start->format($format);
        }
        return $dates;
    }

}
