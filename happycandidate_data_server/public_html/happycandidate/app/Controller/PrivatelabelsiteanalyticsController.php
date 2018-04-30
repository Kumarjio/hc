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
class PrivatelabelsiteanalyticsController extends AppController {

    var $helpers = array('Html', 'Form');
    public $components = array('Paginator');

    /**

     * Controller name

     *

     * @var string

     */
    public $name = 'Privatelabelsiteanalytics';

    /**

     * This controller does not use a model

     *

     * @var array

     */
    public $uses = array();

    public function beforeFilter() {

        parent::beforeFilter();
    }

    public function userstatistics($intPortalId = "") {
//        Configure::write('debug', '2');
        //$this->autoRender = false;
        $arrLoggedUser = $this->Auth->user();
//        echo '<pre>';print_r($arrLoggedUser['portal_id']);die;
        $arrResponse = array();
        if ($this->request->is('Post')) {
            $strStatRequestId = $this->request->data['requestid'];
            $strPeriod = $this->request->data['filterType'];
            if ($strPeriod != '' && $strPeriod != 'custom') {
                $compTime = $this->Components->load('TimeCalculation');
                $arrDayDate = $compTime->fnGetBeforeDate($strPeriod, date('Y-m-d H:i:s'));
                $strStartDate = $arrDayDate['start'];
                $strEndDate = $arrDayDate['end'];
            } else {
                $strFromDate = $this->request->data['strFromDate'];
                $strToDate = $this->request->data['strToDate'];
                if (!empty($strFromDate)) {
                    $strStartDate = $strFromDate . " 00:00:00";
                }
                if (!empty($strToDate)) {
                    $strEndDate = $strToDate . " 23:59:59";
                }
            }

            if ($strStatRequestId) {
                if ($strStatRequestId == "1") {
                    $arrResponse['chartTitle'] = "Job Seekers Statistics";
                    $this->loadModel('PortalUser');
                    $this->loadModel('User');

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

                        foreach ($arrSeries as $series) {
                            if ($strPeriod == 'curr_year') {
                                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_creation_date >=' => $series, 'candidate_creation_date <=' => $strToDate)));
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_creation_date >=' => $series, 'candidate_creation_date <' => $strToDate)));
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrPortalUserList) > 0) {
                                $strSeriesDataValue .= (count($arrPortalUserList)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'viewjobseekerlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim(" View Job Seekers:" . count($arrPortalUserList));
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim(" View Job Seekers:" . $strSeriesDataValue);
                    }
                    $arrResponse['graphsearies'] = "View Job Seekers";
                    $arrResponse['graphsearieslabel'] = "All View Job Seekers";
                    $arrResponse['graphseariesvalue'] = count($arrPortalUserList);
                    $arrResponse['chartTitle'] = "View Job Seekers";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "2") {

                    $arrResponse['chartTitle'] = "Portal Owners Statistics";

                    $this->loadModel('User');

                    $this->loadModel('Portal');
                    $arrPortalOwnerList = $this->User->fnGetUserDetailForPortal($intPortalId, $strStartDate, $strEndDate);

                    $arrResponse['graphsearies'] = "Registered Portal Owners";
                    if ($intPortalId) {
                        $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
                        $arrResponse['graphsearieslabel'] = $arrPortalDet[$intPortalId] . " Registered Portal Owners";
                    } else {
                        $arrResponse['graphsearieslabel'] = "All Portal Owners";
                    }

                    $arrResponse['graphseariesvalue'] = count($arrPortalOwnerList);
                    $view = new View($this, false);

                    $view->set('arrPortalOwnerList', $arrPortalOwnerList);

                    $strElementHtml = $view->element('ownerstatistics');

                    if ($strElementHtml) {

                        $arrResponse['status'] = "success";

                        $arrResponse['content'] = $strElementHtml;

                        echo json_encode($arrResponse);
                        exit;
                    }
                }

                if ($strStatRequestId == "3") {

                    $arrResponse['chartTitle'] = "Portal Owners Statistics";

                    $this->loadModel('User');

                    $this->loadModel('Portal');

                    //$arrPortalOwnerList = $this->User->find->('all',array('conditions'=>array('portal_id'=>$intPortalId,'is_active'=>'1')));

                    $arrPortalOwnerList = $this->User->fnGetUserActiveDetailForPortal($intPortalId, $strStartDate, $strEndDate);

                    $arrResponse['graphsearies'] = "Active Portal Owners";

                    if ($intPortalId) {

                        $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));

                        $arrResponse['graphsearieslabel'] = $arrPortalDet[$intPortalId] . " Active Portal Owners";
                    } else {

                        $arrResponse['graphsearieslabel'] = "All Active Portal Owners";
                    }

                    $arrResponse['graphseariesvalue'] = count($arrPortalOwnerList);



                    $view = new View($this, false);

                    $view->set('arrPortalOwnerList', $arrPortalOwnerList);

                    $strElementHtml = $view->element('activeownerstatistics');

                    if ($strElementHtml) {

                        $arrResponse['status'] = "success";

                        $arrResponse['content'] = $strElementHtml;

                        echo json_encode($arrResponse);
                        exit;
                    }
                }

                if ($strStatRequestId == "4") {

                    $arrResponse['chartTitle'] = "Portal Owners Statistics";

                    $this->loadModel('User');

                    $this->loadModel('Portal');

                    //$arrPortalOwnerList = $this->User->find->('all',array('conditions'=>array('portal_id'=>$intPortalId,'is_active'=>'1')));

                    $arrPortalOwnerList = $this->User->fnGetUserInactiveDetailForPortal($intPortalId, $strStartDate, $strEndDate);

                    $arrResponse['graphsearies'] = "Inactive Portal Owners";

                    if ($intPortalId) {

                        $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));

                        $arrResponse['graphsearieslabel'] = $arrPortalDet[$intPortalId] . " Inactive Portal Owners";
                    } else {

                        $arrResponse['graphsearieslabel'] = "All Inactive Portal Owners";
                    }

                    $arrResponse['graphseariesvalue'] = count($arrPortalOwnerList);

                    $view = new View($this, false);

                    $view->set('arrPortalOwnerList', $arrPortalOwnerList);

                    $strElementHtml = $view->element('inactiveownerstatistics');

                    if ($strElementHtml) {

                        $arrResponse['status'] = "success";

                        $arrResponse['content'] = $strElementHtml;

                        echo json_encode($arrResponse);
                        exit;
                    }
                }

                if ($strStatRequestId == "5") {
                    $arrResponse['chartTitle'] = "Active Job Seekers";
                    $this->loadModel('PortalUser');
                    $this->loadModel('Portal');

                    if (is_array($arrPortalUserList) && (count($arrPortalUserList) > 0)) {
                        $this->loadModel('Portal');
                        $this->loadModel('User');
                        $intPortalDetailCount = 0;
                        foreach ($arrPortalUserList as $arrPortalDetail) {
                            if (!empty($strStartDate)) {
                                $arrPortalDetailNew = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $arrPortalDetail['PortalUser']['career_portal_id'], 'career_portal_created_datetime <=' => $strStartDate, 'career_portal_created_datetime >=' => $strEndDate)));
                            } else {
                                $arrPortalDetailNew = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $arrPortalDetail['PortalUser']['career_portal_id'])));
                            }

                            $arrPortalUserList[$intPortalDetailCount]['PortalName']['pname'] = array_pop($arrPortalDetailNew);
                            $intPortalDetailCount++;
                        }
                    }

                    $view = new View($this, false);
                    $view->set('arrPortalUserList', $arrPortalUserList);
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

                        if ($strPeriod == 'curr_year') {
                            $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '1', 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                        }

                        foreach ($arrSeries as $series) {
                            if ($strPeriod == 'curr_year') {
                                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '1', 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '1', 'candidate_creation_date >=' => $series, 'candidate_creation_date <=' => $strToDate)));
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '1', 'candidate_creation_date >=' => $series, 'candidate_creation_date <' => $strToDate)));
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrPortalUserList) > 0) {
                                $strSeriesDataValue .= (count($arrPortalUserList)) . ",";
                                $strTotal = $strTotal + (count($arrPortalUserList));
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }

                        if ($strPeriod == 'curr_year') {
                            $arrResponse['graphseariesvalue'] = count($arrPortalUserList);
                        } else {
                            $arrResponse['graphseariesvalue'] = $strTotal;
                        }
                    } else {
                        $arrPortalUserList = $this->User->fnGetJobSeekerActiveRegisterDetails($intPortalId, $strStartDate = "", $strEndDate = "", $is_status = "1");
                        foreach ($arrPortalUserList as $k => $arrJobSeekers) {
                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($arrJobSeekers['career_portal_candidate']['candidate_creation_date'])) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($arrJobSeekers['career_portal_candidate']['candidate_creation_date'])) . ",";
                            }
                            if (count($arrJobSeekers) > 0) {
                                $strSeriesDataValue .= $arrJobSeekers[0]['total'] . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");

                    $strElementHtml = $view->element('registeredactiveuserstatistics');
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'activejobseekerlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Active Job Seekers:" . count($arrPortalUserList));
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Active Job Seekers:" . $strSeriesDataValue);
                    }

                    $arrResponse['chartTitle'] = "Active Job Seekers";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;
                    $arrResponse['graphsearies'] = "Active Job Seekers";
                    $arrResponse['graphsearieslabel'] = "Active Job Seekers";

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "6") {

                    $arrResponse['chartTitle'] = "Inactive Job Seekers";

                    $this->loadModel('PortalUser');
                    $this->loadModel('Portal');
                    $this->loadModel('User');

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
                        $total = 0;
                        foreach ($arrSeries as $series) {
                            if ($strPeriod == 'curr_year') {
                                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '0', 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '0', 'candidate_creation_date >=' => $series, 'candidate_creation_date <=' => $strToDate)));
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '0', 'candidate_creation_date >=' => $series, 'candidate_creation_date <' => $strToDate)));
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrPortalUserList) > 0) {
                                $strSeriesDataValue .= (count($arrPortalUserList)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                            $total += (count($arrPortalUserList));
                        }
                    } else {
                        $arrPortalUserList = $this->User->fnGetJobSeekerActiveRegisterDetails($intPortalId, $strStartDate = "", $strEndDate = "", $is_status = "0");
                        foreach ($arrPortalUserList as $k => $arrJobSeekers) {
//                            echo '<pre>';print_r($arrJobSeekers);
                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($arrJobSeekers['career_portal_candidate']['candidate_creation_date'])) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($arrJobSeekers['career_portal_candidate']['candidate_creation_date'])) . ",";
                            }
                            if (count($arrJobSeekers) > 0) {
                                $strSeriesDataValue .= $arrJobSeekers[0]['total'] . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'inactivejobseekerlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);

                    if ($strPeriod == 'curr_year') {
                        $arrResponse['graphseariesvalue'] = count($arrPortalUserList);
                    } else {
                        $arrResponse['graphseariesvalue'] = $total;
                    }
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " Inactive Job Seekers:" . count($arrPortalUserList));
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " Inactive Job Seekers:" . $strSeriesDataValue);
                    }
                    $arrResponse['status'] = "success";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;
                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "7") { //Refunds that were provided
                    $arrResponse['chartTitle'] = "Refunded Order";
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

                        foreach ($arrSeries as $series) {
                            if ($strPeriod == 'curr_year') {
                                $arrNewOrders = $this->Resourceorderdetail->find('all', array(
                                    'joins' => array(
                                        array(
                                            'table' => 'resource_order',
                                            'alias' => 'Resourceorder',
                                            'type' => 'inner',
                                            'conditions' => array('Resourceorderdetail.order_id=Resourceorder.resource_order_id')
                                        )
                                    ),
                                    'conditions' => array('Resourceorderdetail.refund_status =1', 'Resourceorderdetail.order_detail_creation_date_time >=' => $strStartDate, 'Resourceorderdetail.order_detail_creation_date_time <=' => $strEndDate),
                                    'order' => array('order_detail_id' => 'desc')
                                ));
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                $arrNewOrders = $this->Resourceorderdetail->find('all', array(
                                    'joins' => array(
                                        array(
                                            'table' => 'resource_order',
                                            'alias' => 'Resourceorder',
                                            'type' => 'inner',
                                            'conditions' => array('Resourceorderdetail.refund_status =1', 'Resourceorderdetail.order_id=Resourceorder.resource_order_id')
                                        )
                                    ),
                                    'conditions' => array('Resourceorderdetail.order_detail_creation_date_time >=' => $series, 'Resourceorderdetail.order_detail_creation_date_time <=' => $strToDate),
                                    'order' => array('order_detail_id' => 'desc')
                                ));
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrNewOrders = $this->Resourceorderdetail->find('all', array(
                                    'joins' => array(
                                        array(
                                            'table' => 'resource_order',
                                            'alias' => 'Resourceorder',
                                            'type' => 'inner',
                                            'conditions' => array('Resourceorderdetail.refund_status =1', 'Resourceorderdetail.order_id=Resourceorder.resource_order_id')
                                        )
                                    ),
                                    'conditions' => array('Resourceorderdetail.order_detail_creation_date_time >=' => $series, 'Resourceorderdetail.order_detail_creation_date_time <=' => $strToDate),
                                    'order' => array('order_detail_id' => 'desc')
                                ));
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
                            }
                        }
                        $arrResponse['graphseariesvalue'] = count($arrNewOrders);
                    } else {
                        $arrNewOrders = $this->Resourceorderdetail->find('all', array(
                            'joins' => array(
                                array(
                                    'table' => 'resource_order',
                                    'alias' => 'Resourceorder',
                                    'type' => 'inner',
                                    'conditions' => array('Resourceorderdetail.refund_status =1', 'Resourceorderdetail.order_id=Resourceorder.resource_order_id')
                                )
                            ),
                            'order' => array('order_detail_id' => 'desc')
                        ));

                        foreach ($arrNewOrders as $k => $arrOrders) {
                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($arrOrders['Resourceorderdetail']['order_detail_creation_date_time'])) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($arrOrders['Resourceorderdetail']['order_detail_creation_date_time'])) . ",";
                            }
                            if (count($arrOrders) > 0) {
                                $strSeriesDataValue .= count($arrOrders) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    }
                    $arrResponse['graphseariesvalue'] = (count($arrNewOrders));
                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");


                    $view = new View($this, false);
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'refundorderlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);


                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . "Refunded Order Job Seekers:" . count($arrNewOrders));
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . "Refunded Order Job Seekers:" . $strSeriesDataValue);
                    }
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;
                    $arrResponse['status'] = "success";
                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "8") {
                    $arrResponse['chartTitle'] = "Job Seekeres 15 steps completed";
                    $this->loadModel('User');
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

                        foreach ($arrSeries as $series) {
                            if ($strPeriod == 'curr_year') {
                                $strStartDate = date('Y-01-01');
                                $strEndDate = date('Y-m-d');
//                                $strEndDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrJobSeeker15StepCompletedList = $this->User->fnGetUserCompleted15Steps($intPortalId, $strStartDate, $strEndDate);
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                $arrJobSeeker15StepCompletedList = $this->User->fnGetUserCompleted15Steps($intPortalId, $series, $strToDate);
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrJobSeeker15StepCompletedList = $this->User->fnGetUserCompleted15Steps($intPortalId, $series, $strToDate);
                            }
                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrJobSeeker15StepCompletedList) > 0) {
                                $strSeriesDataValue .= (count($arrJobSeeker15StepCompletedList)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    } else {
                        $arrJobSeeker15StepCompletedList = $this->User->fnGetUserCompleted15Steps($intPortalId, $strStartDate = "", $strEndDate = "");
                        foreach ($arrJobSeeker15StepCompletedList as $k => $arrJobSeeker15StepCompleted) {
                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($arrJobSeeker15StepCompleted['career_portal']['career_portal_created_datetime'])) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($arrJobSeeker15StepCompleted['career_portal']['career_portal_created_datetime'])) . ",";
                            }
                            if (count($arrJobSeeker15StepCompleted) > 0) {
                                $strSeriesDataValue .= (count($arrJobSeeker15StepCompleted)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    }
                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");

                    $arrResponse['graphseariesvalue'] = count($arrJobSeeker15StepCompletedList);
                    $view = new View($this, false);

                    $strElementHtml = $view->element('registered15processcompleted');

                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'registered15processcompleted'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);

                    if ($strElementHtml) {

                        if ($strPeriod == 'curr_year') {
                            $arrResponse['xseries'] = date("Y");
                            $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " 15 Steps Completed Job Seekers:" . count($arrJobSeeker15StepCompletedList));
                        } else {
                            $str = implode(',', array_unique(explode(',', $strSeriesData)));
                            $arrResponse['xseries'] = rtrim($str, ",");
                            $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " 15 Steps Completed Job Seekers:" . $strSeriesDataValue);
                        }



                        $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                        $arrResponse['status'] = "success";

                        $arrResponse['content'] = $strElementHtml;

                        echo json_encode($arrResponse);
                        exit;
                    }
                }

                if ($strStatRequestId == "9") {
                    $arrResponse['chartTitle'] = "Job Seekers Applied for jobs";

                    $strCurrentUser = $arrLoggedUserDetails = $this->Auth->user();
                    $this->set('strCurrentUser', $strCurrentUser);
                    $this->loadModel('JobsApplied');

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

                        foreach ($arrSeries as $series) {
                            if ($strPeriod == 'curr_year') {
                                $this->Paginator->settings = array(
                                    'conditions' => array('job_portal_id' => $strCurrentUser['portal_id'], 'job_application_datetime <=' => $strStartDate, 'job_application_datetime >=' => $strStartDate),
                                    'order' => array('job_application_id' => 'DESC'),
                                    'limit' => 20
                                );
                                $arrApplications = $this->Paginator->paginate('JobsApplied');
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";

                                $this->Paginator->settings = array(
                                    'conditions' => array('job_portal_id' => $strCurrentUser['portal_id'], 'job_application_datetime <=' => $series, 'job_application_datetime >=' => $strToDate),
                                    'order' => array('job_application_id' => 'DESC'),
                                    'limit' => 20
                                );
                                $arrApplications = $this->Paginator->paginate('JobsApplied');
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $this->Paginator->settings = array(
                                    'conditions' => array('job_portal_id' => $strCurrentUser['portal_id'], 'job_application_datetime <=' => $series, 'job_application_datetime >=' => $strToDate),
                                    'order' => array('job_application_id' => 'DESC'),
                                    'limit' => 20
                                );
                                $arrApplications = $this->Paginator->paginate('JobsApplied');
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrPortalUserList) > 0) {
                                $strSeriesDataValue .= (count($arrApplications)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    } else {
                        $this->Paginator->settings = array(
                            'conditions' => array('job_portal_id' => $strCurrentUser['portal_id']),
                            'order' => array('job_application_id' => 'DESC'),
                            'limit' => 20
                        );

                        $arrApplications = $this->Paginator->paginate('JobsApplied');

                        foreach ($arrApplications as $k => $applied) {
                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($applied['JobsApplied']['job_application_datetime'])) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($applied['JobsApplied']['job_application_datetime'])) . ",";
                            }
                            if (count($applied) > 0) {
                                $strSeriesDataValue .= (count($applied)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");

                    if (is_array($arrApplications) && (count($arrApplications) > 0)) {
                        $this->loadModel('Candidate');
                        $this->loadModel('Candidate_Cv');
                        $this->loadModel('Job');
                        $intFrCnt = 0;
                        foreach ($arrApplications as $arrApp) {
                            $arrJobDetail = $this->Job->find('all', array('conditions' => array('id' => $arrApp['JobsApplied']['job_id'])));
                            $arrCandidateDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $arrApp['JobsApplied']['candidate_id'])));
                            $arrCandidateCvDetail = $this->Candidate_Cv->find('all', array('conditions' => array('candidatecv_id' => $arrApp['JobsApplied']['candidate_cv_id'])));
                            if (is_array($arrJobDetail) && (count($arrJobDetail) > 0)) {
                                $arrApplications[$intFrCnt]['JobsApplied']['jobdetail'] = $arrJobDetail;
                            }

                            if (is_array($arrCandidateDetail) && (count($arrCandidateDetail) > 0)) {
                                $arrApplications[$intFrCnt]['JobsApplied']['candtail'] = $arrCandidateDetail;
                            }

                            if (is_array($arrCandidateCvDetail) && (count($arrCandidateCvDetail) > 0)) {
                                $arrApplications[$intFrCnt]['JobsApplied']['candcvdetail'] = $arrCandidateCvDetail;
                            }
                            $intFrCnt++;
                        }
                    }

                    $view = new View($this, false);

                    $view->set('arrApplications', $arrApplications);

                    $strElementHtml = $view->element('jobseekersappliedforownerjob');

                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'jobseekersappliedforownerjob'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);

                    if ($strElementHtml) {

                        if ($strPeriod == 'curr_year') {
                            $arrResponse['xseries'] = date("Y");
                            $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " Owner Job Applied:" . count($arrApplications));
                        } else {
                            $str = implode(',', array_unique(explode(',', $strSeriesData)));
                            $arrResponse['xseries'] = rtrim($str, ",");
                            $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " Owner Job Applied:" . $strSeriesDataValue);
                        }

                        $arrResponse['graphseariesvalue'] = count($arrApplications);

                        $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                        $arrResponse['status'] = "success";

                        $arrResponse['content'] = $strElementHtml;

                        echo json_encode($arrResponse);
                        exit;
                    }
                }

                if ($strStatRequestId == "10") {

                    $arrResponse['chartTitle'] = "Job Seekeres Purchased Orders";

                    $this->loadModel('User');

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

                        foreach ($arrSeries as $series) {
                            if ($strPeriod == 'curr_year') {
                                $strStartDate = date('Y-01-01');
                                $strEndDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerPurchasedOrder($strStartDate, $strEndDate);
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerPurchasedOrder($series, $strToDate);
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerPurchasedOrder($series, $strToDate);
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrJobSeekerPurchaseOrderList) > 0) {
                                $strSeriesDataValue .= (count($arrJobSeekerPurchaseOrderList)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    } else {
                        $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerPurchasedOrder($strStartDate = "", $strEndDate = "");
                        foreach ($arrJobSeekerPurchaseOrderList as $k => $purchaseOrder) {
                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($purchaseOrder['career_portal_candidate']['candidate_creation_date'])) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($purchaseOrder['career_portal_candidate']['candidate_creation_date'])) . ",";
                            }
                            if (count($purchaseOrder) > 0) {
                                $strSeriesDataValue .= (count($purchaseOrder)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    }
                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");

                    $view = new View($this, false);
                    $view->set('arrJobSeekerPurchaseOrderList', $arrJobSeekerPurchaseOrderList);
                    $strElementHtml = $view->element('jobseekerspurchasedorder');
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'jobseekerspurchasedorder'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);

                    if ($strElementHtml) {

                        if ($strPeriod == 'curr_year') {
                            $arrResponse['xseries'] = date("Y");
                            $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " Purchase Orders:" . count($arrJobSeekerPurchaseOrderList));
                        } else {
                            $str = implode(',', array_unique(explode(',', $strSeriesData)));
                            $arrResponse['xseries'] = rtrim($str, ",");
                            $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " Purchase Orders:" . $strSeriesDataValue);
                        }

                        $arrResponse['graphseariesvalue'] = count($arrJobSeekerPurchaseOrderList);
                        $arrResponse['status'] = "success";
                        $arrResponse['list_link'] = $strAjaxPortalStatsUrl;
                        $arrResponse['content'] = $strElementHtml;
                        echo json_encode($arrResponse);
                        exit;
                    }
                }

                if ($strStatRequestId == "11") {
                    $arrResponse['chartTitle'] = "Money that Owner Have Made OverTime";
                    $this->loadModel('User');
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
                        $arrOverTimeMoneyList = array();

                        if ($strPeriod == 'curr_year') {
                            $strStartDate = date('Y-01-01');
                            $strEndDate = date('Y-m-d', strtotime($series . "+1 days"));
                            $arrOverTimeMoneyList = $this->User->fnGetOverTimeMoneryGraph($intPortalId, $strStartDate, $strEndDate, $strPeriod);
                        }
                        foreach ($arrSeries as $k => $series) {
                            if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                $arrOverTimeMoneyList[] = $this->User->fnGetOverTimeMoneryGraph($intPortalId, $series, $strToDate, $strPeriod);
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrOverTimeMoneyList[] = $this->User->fnGetOverTimeMoneryGraph($intPortalId, $series, $strToDate, $strPeriod);
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }

                            if (count($arrOverTimeMoneyList) > 0) {
                                if ($arrOverTimeMoneyList[$k][0][0]['OverTimeMonery'] != '') {
                                    $strSeriesDataValue .= round($arrOverTimeMoneyList[$k][0][0]['OverTimeMonery']) . ",";
                                } else {
                                    $strSeriesDataValue .= "0,";
                                }
                            } else {
                                $strSeriesDataValue .= "0,";
                            }

                            $total += $arrOverTimeMoneyList[$k][0][0]['OverTimeMonery'];
                        }
                        $Fulltotal .= $total;
                    } else {
                        $arrOverTimeMoneyList = $this->User->fnGetOverTimeMonery($intPortalId, $strStartDate = "", $strEndDate = "");
                        foreach ($arrOverTimeMoneyList as $k => $OverTimeMoney) {
                            $strSeriesData .= date("jS M y", strtotime($OverTimeMoney['resource_order_detail']['order_detail_creation_date_time'])) . ",";
                            if (count($arrOverTimeMoneyList) > 0) {
                                $strSeriesDataValue .= (count($arrOverTimeMoneyList)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    }
                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");

                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'overtimemoneylist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim(" Money that Owner Have Made OverTime:" . $Fulltotal);
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim(" Money that Owner Have Made OverTime:" . $strSeriesDataValue);
                    }

                    $arrResponse['graphseariesvalue'] = $Fulltotal;
                    $arrResponse['status'] = "success";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;
                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "12") {
                    $arrResponse['chartTitle'] = "Theme Register Job Seeker";
                    $this->loadModel('User');
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

                        foreach ($arrSeries as $k => $series) {
                            if ($strPeriod == 'curr_year') {
                                $strStartDate = date('Y-01-01');
                                $strEndDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrJobSeekerTheme1RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $strStartDate, $strEndDate, $strThemeName = "THEME-DESIGN-1");
                                $arrJobSeekerTheme2RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $strStartDate, $strEndDate, $strThemeName = "THEME-DESIGN-2");
                                $arrJobSeekerTheme3RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $strStartDate, $strEndDate, $strThemeName = "THEME-DESIGN-3");
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                $arrJobSeekerTheme1RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $series, $strToDate, $strThemeName = "THEME-DESIGN-1");
                                $arrJobSeekerTheme2RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $series, $strToDate, $strThemeName = "THEME-DESIGN-2");
                                $arrJobSeekerTheme3RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $series, $strToDate, $strThemeName = "THEME-DESIGN-3");
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrJobSeekerTheme1RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $series, $strToDate, $strThemeName = "THEME-DESIGN-1");
                                $arrJobSeekerTheme2RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $series, $strToDate, $strThemeName = "THEME-DESIGN-2");
                                $arrJobSeekerTheme3RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $series, $strToDate, $strThemeName = "THEME-DESIGN-3");
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrJobSeekerTheme1RegisterList) > 0) {
                                $strSeriesDataValue1 .= $arrJobSeekerTheme1RegisterList[0][0]['total'] . ",";
                                $strSeriesDataValue2 .= $arrJobSeekerTheme2RegisterList[0][0]['total'] . ",";
                                $strSeriesDataValue3 .= $arrJobSeekerTheme3RegisterList[0][0]['total'] . ",";
                            } else {
                                $strSeriesDataValue1 .= "0,";
                                $strSeriesDataValue2 .= "0,";
                                $strSeriesDataValue3 .= "0,";
                            }
                        }
                    } else {
                        $arrJobSeekerThemeRegisterList = $this->User->fnGetJobSeekerThemeRegisterDetails($intPortalId, $strStartDate = "", $strEndDate = "", $strThemeName = "");
                        foreach ($arrJobSeekerThemeRegisterList as $k => $resTheme) {
                            $strSeriesData .= date("jS M y", strtotime($resTheme['career_portal_candidate']['candidate_creation_date'])) . ",";
                            $arrJobSeekerTheme1RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $strStartDate = "", $strEndDate = "", $strThemeName = "THEME-DESIGN-1");
                            $arrJobSeekerTheme2RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $strStartDate = "", $strEndDate = "", $strThemeName = "THEME-DESIGN-2");
                            $arrJobSeekerTheme3RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $strStartDate = "", $strEndDate = "", $strThemeName = "THEME-DESIGN-3");
                        }

                        if (count($arrJobSeekerThemeRegisterList) > 0) {
                            $strSeriesDataValue1 .= $arrJobSeekerTheme1RegisterList[0][0]['total'] . ",";
                            $strSeriesDataValue2 .= $arrJobSeekerTheme2RegisterList[0][0]['total'] . ",";
                            $strSeriesDataValue3 .= $arrJobSeekerTheme3RegisterList[0][0]['total'] . ",";
                        } else {
                            $strSeriesDataValue1 .= "0,";
                            $strSeriesDataValue2 .= "0,";
                            $strSeriesDataValue3 .= "0,";
                        }
                    }
                    $strSeriesDataValue1 = rtrim($strSeriesDataValue1, ",");
                    $strSeriesDataValue2 = rtrim($strSeriesDataValue2, ",");
                    $strSeriesDataValue3 = rtrim($strSeriesDataValue3, ",");


                    if ($strStartDate != '') {
                        $arrJobSeekerTheme1RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $strStartDate, $strEndDate, $strThemeName = "THEME-DESIGN-1");
                        $arrJobSeekerTheme2RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $strStartDate, $strEndDate, $strThemeName = "THEME-DESIGN-2");
                        $arrJobSeekerTheme3RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $strStartDate, $strEndDate, $strThemeName = "THEME-DESIGN-3");

                        $strAjaxPortalTheme1StatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'theme1registerlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                        $strAjaxPortalTheme2StatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'theme2registerlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                        $strAjaxPortalTheme3StatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'theme3registerlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);

                        $arrResponse['graphseariesvalue1'] = $arrJobSeekerTheme1RegisterList[0][0]['total'];
                        $arrResponse['graphseariesvalue2'] = $arrJobSeekerTheme2RegisterList[0][0]['total'];
                        $arrResponse['graphseariesvalue3'] = $arrJobSeekerTheme3RegisterList[0][0]['total'];

                        $arrResponse['title1'] = "THEME-DESIGN-1";
                        $arrResponse['title2'] = "THEME-DESIGN-2";
                        $arrResponse['title3'] = "THEME-DESIGN-3";

                        $arrResponse['theme1_list_link'] = $strAjaxPortalTheme1StatsUrl;
                        $arrResponse['theme2_list_link'] = $strAjaxPortalTheme2StatsUrl;
                        $arrResponse['theme3_list_link'] = $strAjaxPortalTheme3StatsUrl;

                        $arrResponse['list_link'] = "";
                    } else {
                        $arrJobSeekerTheme1RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $strStartDate = "", $strEndDate = "", $strThemeName = "THEME-DESIGN-1");
                        $arrJobSeekerTheme2RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $strStartDate = "", $strEndDate = "", $strThemeName = "THEME-DESIGN-2");
                        $arrJobSeekerTheme3RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $strStartDate = "", $strEndDate = "", $strThemeName = "THEME-DESIGN-3");

                        $strAjaxPortalTheme1StatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'themeregisterlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&theme=THEME-DESIGN-1";
                        $strAjaxPortalTheme2StatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'themeregisterlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&theme=THEME-DESIGN-2";
                        $strAjaxPortalTheme3StatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'themeregisterlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&theme=THEME-DESIGN-3";

                        $arrResponse['graphseariesvalue1'] = $arrJobSeekerTheme1RegisterList[0][0]['total'];
                        $arrResponse['graphseariesvalue2'] = $arrJobSeekerTheme2RegisterList[0][0]['total'];
                        $arrResponse['graphseariesvalue3'] = $arrJobSeekerTheme3RegisterList[0][0]['total'];

                        $arrResponse['title1'] = "THEME-DESIGN-1";
                        $arrResponse['title2'] = "THEME-DESIGN-2";
                        $arrResponse['title3'] = "THEME-DESIGN-3";

                        $arrResponse['theme1_list_link'] = $strAjaxPortalTheme1StatsUrl;
                        $arrResponse['theme2_list_link'] = $strAjaxPortalTheme2StatsUrl;
                        $arrResponse['theme3_list_link'] = $strAjaxPortalTheme3StatsUrl;
                        $arrResponse['list_link'] = "";
                    }

                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("THEME-DESIGN-1:" . $arrJobSeekerTheme1RegisterList[0][0]['total'] . "~" . "THEME-DESIGN-2:" . $arrJobSeekerTheme2RegisterList[0][0]['total'] . "~" . "THEME-DESIGN-3:" . $arrJobSeekerTheme3RegisterList[0][0]['total']);
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("THEME-DESIGN-1:" . $strSeriesDataValue1 . "~" . "THEME-DESIGN-2:" . $strSeriesDataValue2 . "~" . "THEME-DESIGN-3:" . $strSeriesDataValue3);
                    }
                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "13") {
                    $arrResponse['chartTitle'] = "Job Seekers Phase Completed";
                    if ($strPeriod == "All") {
                        $strStartDate = "";
                        $strEndDate = "";
                    } else {
                        $strStartDate = date("Y-m-d", strtotime($strStartDate));
                        $strEndDate = date("Y-m-d", strtotime($strEndDate));
                    }
                    $this->loadModel('Categories');
                    $this->loadModel('Jobsearchtracker');

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

                        foreach ($arrSeries as $k => $series) {
                            if ($strPeriod == 'curr_year') {
                                $strStartDate = date('Y-01-01');
                                $strEndDate = date('Y-m-d', strtotime($series . "+1 days"));

                                $arrJobSearchProcessPhases = $this->Categories->find('all', array('conditions' => array('job_process_type' => 'phase'), 'order' => array('job_search_order' => 'ASC')));
                                foreach ($arrJobSearchProcessPhases as $key => $arrJsteps) {
                                    $stepId = $arrJsteps['Categories']['content_category_id'];
//                                    $phaseCompletedGraph[] = $this->Jobsearchtracker->fnGetJobSeekerPhaseCompleted($stepId, $strStartDate, $strEndDate);
                                    $arrJobSearchProcessPhases[$key][] = $this->Jobsearchtracker->fnGetJobSeekerPhaseCompleted($stepId, $strStartDate, $strEndDate);
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                $arrJobSearchProcessPhases = $this->Categories->find('all', array('conditions' => array('job_process_type' => 'phase'), 'order' => array('job_search_order' => 'ASC')));
                                foreach ($arrJobSearchProcessPhases as $key => $arrJsteps) {
                                    $stepId = $arrJsteps['Categories']['content_category_id'];
//                                    $phaseCompletedGraph = $this->Jobsearchtracker->fnGetJobSeekerPhaseCompletedGraph($stepId, $series, $strToDate);
                                    $arrJobSearchProcessPhases[$key][] = $this->Jobsearchtracker->fnGetJobSeekerPhaseCompleted($stepId, $series, $strToDate);
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrJobSearchProcessPhases = $this->Categories->find('all', array('conditions' => array('job_process_type' => 'phase'), 'order' => array('job_search_order' => 'ASC')));
                                foreach ($arrJobSearchProcessPhases as $key => $arrJsteps) {
                                    $stepId = $arrJsteps['Categories']['content_category_id'];
                                    $arrJobSearchProcessPhases[$key][] = $this->Jobsearchtracker->fnGetJobSeekerPhaseCompleted($stepId, $series, $strToDate);
                                }
                            }
                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrJobSearchProcessPhases) > 0) {
                                $strSeriesDataValue1 .= $arrJobSearchProcessPhases[0][0][0]['total'] . ",";
                                $strSeriesDataValue2 .= $arrJobSearchProcessPhases[1][0][0]['total'] . ",";
                                $strSeriesDataValue3 .= $arrJobSearchProcessPhases[2][0][0]['total'] . ",";
                            } else {
                                $strSeriesDataValue1 .= "0,";
                                $strSeriesDataValue2 .= "0,";
                                $strSeriesDataValue3 .= "0,";
                            }
                        }
                    } else {
                        $arrJobSearchProcessPhases = $this->Categories->find('all', array('conditions' => array('job_process_type' => 'phase'), 'order' => array('job_search_order' => 'ASC')));
                        foreach ($arrJobSearchProcessPhases as $key => $arrJsteps) {
                            $stepId = $arrJsteps['Categories']['content_category_id'];
                            $arrJobSearchProcessPhases[$key][] = $this->Jobsearchtracker->fnGetJobSeekerPhaseCompleted($stepId, $strStartDate = "", $strEndDate = "");
                            $strSeriesData .= date("jS M y", strtotime($resTheme['career_portal_candidate']['candidate_creation_date'])) . ",";
                        }
                        if (count($arrJobSearchProcessPhases) > 0) {
                            $strSeriesDataValue1 .= $arrJobSearchProcessPhases[0][0][0]['total'] . ",";
                            $strSeriesDataValue2 .= $arrJobSearchProcessPhases[1][0][0]['total'] . ",";
                            $strSeriesDataValue3 .= $arrJobSearchProcessPhases[2][0][0]['total'] . ",";
                        } else {
                            $strSeriesDataValue1 .= "0,";
                            $strSeriesDataValue2 .= "0,";
                            $strSeriesDataValue3 .= "0,";
                        }
                    }
                    $strSeriesDataValue1 = rtrim($strSeriesDataValue1, ",");
                    $strSeriesDataValue2 = rtrim($strSeriesDataValue2, ",");
                    $strSeriesDataValue3 = rtrim($strSeriesDataValue3, ",");


                    $arrJobSearchProcessPhases = $this->Categories->find('all', array('conditions' => array('job_process_type' => 'phase'), 'order' => array('job_search_order' => 'ASC')));

                    foreach ($arrJobSearchProcessPhases as $key => $arrJsteps) {
                        $stepId = $arrJsteps['Categories']['content_category_id'];
                        if ($strStartDate != "") {
                            $arrJobSearchProcessPhases[$key][] = $this->Jobsearchtracker->fnGetJobSeekerPhaseCompleted($stepId, $strStartDate, $strEndDate);
                        } else {
                            $arrJobSearchProcessPhases[$key][] = $this->Jobsearchtracker->fnGetJobSeekerPhaseCompleted($stepId, $strStartDate = "", $strEndDate = "");
                        }
                    }

                    $phase1_id = $arrJobSearchProcessPhases[0]['Categories']['content_category_id'];
                    $phase2_id = $arrJobSearchProcessPhases[1]['Categories']['content_category_id'];
                    $phase3_id = $arrJobSearchProcessPhases[2]['Categories']['content_category_id'];

                    $strAjaxPortalPhase1StatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'phasecompletedlist'), true) . "?startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&phaseId=" . base64_encode($phase1_id);
                    $strAjaxPortalPhase2StatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'phasecompletedlist'), true) . "?startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&phaseId=" . base64_encode($phase2_id);
                    $strAjaxPortalPhase3StatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'phasecompletedlist'), true) . "?startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&phaseId=" . base64_encode($phase3_id);

                    $arrResponse['graphseariesvalue1'] = $arrJobSearchProcessPhases[0][0][0]['total'];
                    $arrResponse['graphseariesvalue2'] = $arrJobSearchProcessPhases[1][0][0]['total'];
                    $arrResponse['graphseariesvalue3'] = $arrJobSearchProcessPhases[2][0][0]['total'];

                    $arrResponse['title1'] = "Phase -1 " . $arrJobSearchProcessPhases[0]['Categories']['content_category_name'];
                    $arrResponse['title2'] = "Phase -2 " . $arrJobSearchProcessPhases[1]['Categories']['content_category_name'];
                    $arrResponse['title3'] = "Phase -3 " . $arrJobSearchProcessPhases[2]['Categories']['content_category_name'];

                    $arrResponse['theme1_list_link'] = $strAjaxPortalPhase1StatsUrl;
                    $arrResponse['theme2_list_link'] = $strAjaxPortalPhase2StatsUrl;
                    $arrResponse['theme3_list_link'] = $strAjaxPortalPhase3StatsUrl;
                    $arrResponse['list_link'] = "";

//                    echo '<pre>';print_r($strSeriesDataValue1);
//                    echo '<pre>';print_r($strSeriesDataValue2);
//                    echo '<pre>';print_r($strSeriesDataValue3);die;
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Phase -1 Prepare:" . $arrJobSearchProcessPhases[0][0][0]['total'] . "~" . "Phase -2 Search & Connect:" . $arrJobSearchProcessPhases[1][0][0]['total'] . "~" . "Phase -3 Interview:" . $arrJobSearchProcessPhases[2][0][0]['total']);
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
//                        $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " Portal Phase Completed:" . $strSeriesDataValue);
                        $arrResponse['dataseries'] = rtrim("Phase -1 Prepare:" . $strSeriesDataValue1 . "~" . "Phase -2 Search & Connect:" . $strSeriesDataValue2 . "~" . "Phase -3 Interview:" . $strSeriesDataValue3);
                    }

                    $arrResponse['status'] = "success";
                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "14") {
                    $arrResponse['chartTitle'] = "Confirm Job Seekers";
                    $this->loadModel('PortalUser');
                    $this->loadModel('Portal');

                    if (is_array($arrPortalUserList) && (count($arrPortalUserList) > 0)) {
                        $this->loadModel('Portal');
                        $this->loadModel('User');
                        $intPortalDetailCount = 0;
                        foreach ($arrPortalUserList as $arrPortalDetail) {
                            if (!empty($strStartDate)) {
                                $arrPortalDetailNew = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $arrPortalDetail['PortalUser']['career_portal_id'], 'career_portal_created_datetime <=' => $strStartDate, 'career_portal_created_datetime >=' => $strEndDate)));
                            } else {
                                $arrPortalDetailNew = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $arrPortalDetail['PortalUser']['career_portal_id'])));
                            }

                            $arrPortalUserList[$intPortalDetailCount]['PortalName']['pname'] = array_pop($arrPortalDetailNew);
                            $intPortalDetailCount++;
                        }
                    }

                    $view = new View($this, false);
                    $view->set('arrPortalUserList', $arrPortalUserList);
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

                        if ($strPeriod == 'curr_year') {
                            $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '1', 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                        }

                        foreach ($arrSeries as $series) {
                            if ($strPeriod == 'curr_year') {
                                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '1', 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '1', 'candidate_creation_date >=' => $series, 'candidate_creation_date <=' => $strToDate)));
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '1', 'candidate_creation_date >=' => $series, 'candidate_creation_date <' => $strToDate)));
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrPortalUserList) > 0) {
                                $strSeriesDataValue .= (count($arrPortalUserList)) . ",";
                                $strTotal = $strTotal + (count($arrPortalUserList));
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }

                        if ($strPeriod == 'curr_year') {
                            $arrResponse['graphseariesvalue'] = count($arrPortalUserList);
                        } else {
                            $arrResponse['graphseariesvalue'] = $strTotal;
                        }
                    } else {
                        $arrPortalUserList = $this->User->fnGetJobSeekerActiveRegisterDetails($intPortalId, $strStartDate = "", $strEndDate = "", $is_status = "1");
                        foreach ($arrPortalUserList as $k => $arrJobSeekers) {
                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($arrJobSeekers['career_portal_candidate']['candidate_creation_date'])) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($arrJobSeekers['career_portal_candidate']['candidate_creation_date'])) . ",";
                            }
                            if (count($arrJobSeekers) > 0) {
                                $strSeriesDataValue .= $arrJobSeekers[0]['total'] . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");

                    $strElementHtml = $view->element('registeredactiveuserstatistics');
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'activejobseekerlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Confirm Job Seekers:" . count($arrPortalUserList));
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Confirm Job Seekers:" . $strSeriesDataValue);
                    }

                    $arrResponse['chartTitle'] = "Confirm Job Seekers";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;
                    $arrResponse['graphsearies'] = "Confirm Job Seekers";
                    $arrResponse['graphsearieslabel'] = "Confirm Job Seekers";

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "15") {
//                    Configure::write('debug',2);
                    $arrResponse['chartTitle'] = "Total Unique Visitors Career Portal";
                    $this->loadModel('PortalVisitors');
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

                        foreach ($arrSeries as $series) {
                            if ($strPeriod == 'curr_year') {
                                $strEndDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all' || $intPortalId == '') {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsCount($intPortalId = "all", $strStartDate, $strEndDate);
                                } else {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsCount($intPortalId, $strStartDate, $strEndDate);
                                }
//                                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'visitorslist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                            } else if ($strPeriod == '30') {
                                $strToDate = date("Y-m-t", strtotime($series));
                                if ($intPortalId == 'all' || $intPortalId == '') {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsCount($intPortalId = "all", $series, $strToDate);
                                } else {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsCount($intPortalId, $series, $strToDate);
                                }
//                                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'visitorslist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($series) . "&endDate=" . base64_encode($strToDate);
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all' || $intPortalId == '') {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsCount($intPortalId = "all", $series, $strToDate);
                                } else {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsCount($intPortalId, $series, $strToDate);
                                }
//                                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'visitorslist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($series) . "&endDate=" . base64_encode($strToDate);
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrTotalVisitors) > 0) {
                                $strSeriesDataValue .= (count($arrTotalVisitors)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                                $strTotal += "0";
                            }

                            $strTotal += count($arrTotalVisitors);
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    if($strPeriod == 'curr_year'){
                        $strEndDate = date('Y-m-d', strtotime($series . "+1 days")); 
                        $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'visitorslist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    }else if($strPeriod == '30'){
                        $strEndDate = date("Y-m-t", strtotime($series));
                        $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'visitorslist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    }else{
                       $strEndDate = date('Y-m-d', strtotime($series . "+1 days")); 
                       $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'visitorslist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    }
                    
                    
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Total Unique Visitors Career Portal :" . count($arrTotalVisitors));
                        $arrResponse['graphseariesvalue'] = count($arrTotalVisitors);
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Total Unique Visitors Career Portal :" . $strSeriesDataValue);
                        $arrResponse['graphseariesvalue'] = isset($strTotal) ? $strTotal : '0';
                    }
                    $arrResponse['graphsearies'] = "Total Unique Visitors Career Portal Statistics";
                    $arrResponse['graphsearieslabel'] = "Total Unique Visitors Career Portal Statistics";
                    $arrResponse['chartTitle'] = "Total Unique Visitors Career Portal";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "16") {
                    $arrResponse['chartTitle'] = "Total Unique Visitors Registered Career Portal";
                    $this->loadModel('PortalVisitors');
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

                        foreach ($arrSeries as $series) {

                            if ($strPeriod == 'curr_year') {
                                $strEndDate = date('Y-m-d', strtotime("+1 days"));
                                if ($intPortalId == 'all' || $intPortalId == '') {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsRegisteredCount($intPortalId = "all", $strStartDate, $strEndDate);
                                } else {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsRegisteredCount($intPortalId, $strStartDate, $strEndDate);
                                }
//                                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'visitorsregisterlist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                            } else if ($strPeriod == '30') {
                                 $strToDate = date("Y-m-t", strtotime($series));
                                if ($intPortalId == 'all' || $intPortalId == '') {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsRegisteredCount($intPortalId = "all", $series, $strToDate);
                                } else {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsRegisteredCount($intPortalId, $series, $strToDate);
                                }
//                                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'visitorsregisterlist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($series) . "&endDate=" . base64_encode($strToDate);
                            } else {

                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all' || $intPortalId == '') {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsRegisteredCount($intPortalId = "all", $series, $strToDate);
                                } else {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsRegisteredCount($intPortalId, $series, $strToDate);
                                }
//                                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'visitorsregisterlist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($series) . "&endDate=" . base64_encode($strToDate);
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrTotalVisitors) > 0) {
                                $strSeriesDataValue .= (count($arrTotalVisitors)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                                $strTotal += "0";
                            }

                            $strTotal += count($arrTotalVisitors);
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    if ($strPeriod == 'curr_year') {
                        $strEndDate = date('Y-m-d', strtotime($series . "+1 days"));
                        $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'visitorsregisterlist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    } else if ($strPeriod == '30') {
                        $strEndDate = date("Y-m-t", strtotime($series));
                        $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'visitorsregisterlist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    } else {
                        $strEndDate = date('Y-m-d', strtotime($series . "+1 days"));
                        $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'visitorsregisterlist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    }

                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Total Unique Visitors Registered Career Portal :" . count($arrTotalVisitors));
                        $arrResponse['graphseariesvalue'] = count($arrTotalVisitors);
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Total Unique Visitors Registered Career Portal :" . $strSeriesDataValue);
                        $arrResponse['graphseariesvalue'] = isset($strTotal) ? $strTotal : '0';
                    }
                    $arrResponse['graphsearies'] = "Total Unique Visitors Registered Career Portal Statistics";
                    $arrResponse['graphsearieslabel'] = "Total Unique Visitors Registered Career Portal Statistics";
                    $arrResponse['chartTitle'] = "Total Unique Visitors Registered Career Portal";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }
            }
        }
    }

    public function activejobseekerlist() {

        $this->layout = "newemployers";
        $this->loadModel('PortalUser');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if (!empty($strStartDate)) {
            $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '1', 'career_portal_id' => $intPortalId, 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
        } else {
            $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '1', 'career_portal_id' => $intPortalId)));
        }
        if (!empty($strStartDate)) {
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId, 'career_portal_created_datetime <=' => $strStartDate, 'career_portal_created_datetime >=' => $strEndDate)));
        } else {
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
        }

        if (is_array($arrPortalUserList) && (count($arrPortalUserList) > 0)) {
            $intPortalDetailCount = 0;
            foreach ($arrPortalUserList as $arrPortalDetail) {
                $arrPortalDetailNew = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $arrPortalDetail['PortalUser']['career_portal_id'])));
                $arrPortalUserList[$intPortalDetailCount]['PortalName']['pname'] = array_pop($arrPortalDetailNew);
                $intPortalDetailCount++;
            }
        }
        $this->set('arrPortalUserList', $arrPortalUserList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('strStatus', '1');
    }

    public function viewjobseekerlist() {
        $this->layout = "newemployers";
        $this->loadModel('PortalUser');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if ($intPortalId != "" && $strStartDate != '') {
            $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
            $this->Paginator->settings = array(
                'conditions' => array('candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate),
                'order' => array('career_portal_id' => 'DESC'),
                'limit' => 30
            );
        }

        if (is_array($arrPortalUserList) && (count($arrPortalUserList) > 0)) {
            $this->loadModel('Portal');
            $intPortalDetailCount = 0;
            foreach ($arrPortalUserList as $arrPortalDetail) {
                $arrPortalDetailNew = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $arrPortalDetail['PortalUser']['career_portal_id'])));
                $arrPortalUserList[$intPortalDetailCount]['PortalName']['pname'] = array_pop($arrPortalDetailNew);
                $intPortalDetailCount++;
            }
        }
        $this->set('arrPortalUserList', $arrPortalUserList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('strStatus', '');
    }

    public function inactivejobseekerlist() {

        $this->layout = "newemployers";
        $this->loadModel('PortalUser');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if ($intPortalId != '' && $strStartDate != '') {
            $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '0', 'career_portal_id' => $intPortalId, 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
            $this->Paginator->settings = array(
                'conditions' => array('career_portal_id' => $intPortalId, 'candidate_confirmed' => '1', 'candidate_is_active' => '0', 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate),
                'order' => array('career_portal_id' => 'DESC'),
                'limit' => 30
            );
        }
        $arrPortalUserList = $this->Paginator->paginate('PortalUser');
        $this->loadModel('Portal');
        $intPortalDetailCount = 0;
        foreach ($arrPortalUserList as $arrPortalDetail) {
            $arrPortalDetailNew = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $arrPortalDetail['PortalUser']['career_portal_id'])));
            $arrPortalUserList[$intPortalDetailCount]['PortalName']['pname'] = array_pop($arrPortalDetailNew);
        }
        $this->set('arrPortalUserList', $arrPortalUserList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('strStatus', '0');
    }

    public function refundorderlist() {
        $this->loadModel('Resourceorderdetail');
        $this->loadModel('Vendors');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        $arrConditions = array();
        if ($strStartDate) {
            $arrConditions['Resourceorderdetail.order_detail_creation_date_time >='] = $strStartDate;
        }

        if ($strEndDate) {
            $arrConditions['Resourceorderdetail.order_detail_creation_date_time <='] = $strEndDate;
        }

        $arrConditions['Resourceorderdetail.refund_status ='] = 1;

        if (is_array($arrConditions) && (count($arrConditions) > 0)) {
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
        } else {
            $arrNewOrders = $this->Resourceorderdetail->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'resource_order',
                        'alias' => 'Resourceorder',
                        'type' => 'inner',
                        'conditions' => array('Resourceorderdetail.order_id=Resourceorder.resource_order_id')
                    )
                ),
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
                'order' => array('order_detail_id' => 'desc')
            ));
        }

        $intTotalAmount = 0;
        if (is_array($arrTotalSumQ) && (count($arrTotalSumQ) > 0)) {
            $intTotalAmount = $arrTotalSumQ['0']['0']['amount'];
        }
        $this->set("intTotalAmount", $intTotalAmount);

        if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
            $this->loadModel('Resourceorder');
            $this->loadModel('Candidate');
            $this->loadModel('Resources');
            $intFrCnt = 0;
            foreach ($arrNewOrders as $arrOrder) {
                $intOrderId = $arrOrder['Resourceorderdetail']['order_id'];
                $intVendorType = $arrOrder['Resourceorderdetail']['vendor_type'];
                $intVendorId = $arrOrder['Resourceorderdetail']['vendor_id'];
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

                if ($intVendorType == "vendor") {
                    $arrSubVendorsFor = $this->Vendors->find('all', array(
                        'fields' => array('Vendors.*'),
                        'joins' => array(
                            array(
                                'table' => 'resource_order_detail',
                                'alias' => 'Resourceorderdetail',
                                'type' => 'left',
                                'conditions' => array('Vendors.vendor_id=Resourceorderdetail.vendor_id')
                            )
                        ),
                        'conditions' => array('Vendors.vendor_id' => $intVendorId)
                    ));
                } else {
                    $arrSubVendorsFor = $this->Portal->find('all', array(
                        'conditions' => array('career_portal_id' => $arrOrder['Resourceorderdetail']['vendor_id'])
                    ));

                    $arrSubVendorsFor[0]['Vendors']['vendor_first_name'] = $arrSubVendorsFor[0]['Portal']['career_portal_name'];
                }
                $arrNewOrders[$intFrCnt]['vendorsuser'] = $arrSubVendorsFor[0];

                $intFrCnt++;
            }
        }

        $this->set('arrProductList', $arrNewOrders);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_decode($strStartDate));
        $this->set('strEndDate', base64_decode($strEndDate));
    }

    public function phasecompletedlist() {
        $this->loadModel('Jobsearchtracker');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $phaseId = base64_decode($_GET['phaseId']);
        if ($phaseId != '') {
            if ($strStartDate) {
                $arrJobSeekerCompletedList = $this->Jobsearchtracker->fnGetJobSeekerPhaseWiseCompleted($phaseId, $strStartDate, $strEndDate);
            } else {
                $arrJobSeekerCompletedList = $this->Jobsearchtracker->fnGetJobSeekerPhaseWiseCompleted($phaseId, $strStartDate = "", $strEndDate = "");
            }
        }
        $this->set('arrJobSeekerCompletedList', $arrJobSeekerCompletedList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_decode($strStartDate));
        $this->set('strEndDate', base64_decode($strEndDate));
        $this->set('phaseId', $phaseId);
        $this->set('phaseName', $arrJobSeekerCompletedList[0]['content_category']['content_category_name']);
    }

    public function themeregisterlist() {
        $this->loadModel('User');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $strThemeName = $_GET['theme'];
        if ($strThemeName != '') {
            $arrJobSeekerThemeRegisterList = $this->User->fnGetJobSeekerThemeRegisterList($intPortalId, $strStartDate = "", $strEndDate = "", $strThemeName);
        } else {
            $arrJobSeekerThemeRegisterList = $this->User->fnGetJobSeekerThemeRegisterList($intPortalId, $strStartDate, $strEndDate, $strThemeName);
        }
        $this->set('arrJobSeekerThemeList', $arrJobSeekerThemeRegisterList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('strthemeName', $strThemeName);
    }

    public function theme1registerlist() {
        $this->loadModel('User');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $strThemeName = "THEME-DESIGN-1";

        $arrJobSeekerThemeRegisterList = $this->User->fnGetJobSeekerThemeRegisterList($intPortalId, $strStartDate, $strEndDate, $strThemeName);
        $this->set('arrJobSeekerThemeList', $arrJobSeekerThemeRegisterList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('strthemeName', $strThemeName);
    }

    public function theme2registerlist() {
        $this->loadModel('User');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $strThemeName = "THEME-DESIGN-2";

        $arrJobSeekerThemeRegisterList = $this->User->fnGetJobSeekerThemeRegisterList($intPortalId, $strStartDate, $strEndDate, $strThemeName);
        $this->set('arrJobSeekerThemeList', $arrJobSeekerThemeRegisterList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('strthemeName', $strThemeName);
    }

    public function theme3registerlist() {
        $this->loadModel('User');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $strThemeName = "THEME-DESIGN-3";

        $arrJobSeekerThemeRegisterList = $this->User->fnGetJobSeekerThemeRegisterList($intPortalId, $strStartDate, $strEndDate, $strThemeName);
        $this->set('arrJobSeekerThemeList', $arrJobSeekerThemeRegisterList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('strthemeName', $strThemeName);
    }

    public function jobseekersappliedforownerjob() {
//        Configure::write('debug','2');
        $this->loadModel('JobsApplied');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        $strCurrentUser = $arrLoggedUserDetails = $this->Auth->user();
        $this->set('strCurrentUser', $strCurrentUser);
        if (!empty($strStartDate)) {

            $this->Paginator->settings = array(
                'conditions' => array('job_portal_id' => $strCurrentUser['portal_id'], 'job_application_datetime <=' => $strStartDate, 'job_application_datetime >=' => $strStartDate),
                'order' => array('job_application_id' => 'DESC'),
                'limit' => 20
            );
        } else {
            $this->Paginator->settings = array(
                'conditions' => array('job_portal_id' => $strCurrentUser['portal_id']),
                'order' => array('job_application_id' => 'DESC'),
                'limit' => 20
            );
        }
        $arrApplications = $this->Paginator->paginate('JobsApplied');

        if (is_array($arrApplications) && (count($arrApplications) > 0)) {
            $this->loadModel('Candidate');
            $this->loadModel('Candidate_Cv');
            $this->loadModel('Job');
            $intFrCnt = 0;
            foreach ($arrApplications as $arrApp) {
                $arrJobDetail = $this->Job->find('all', array('conditions' => array('id' => $arrApp['JobsApplied']['job_id'])));
                $arrCandidateDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $arrApp['JobsApplied']['candidate_id'])));
                $arrCandidateCvDetail = $this->Candidate_Cv->find('all', array('conditions' => array('candidatecv_id' => $arrApp['JobsApplied']['candidate_cv_id'])));
                if (is_array($arrJobDetail) && (count($arrJobDetail) > 0)) {
                    $arrApplications[$intFrCnt]['JobsApplied']['jobdetail'] = $arrJobDetail;
                }

                if (is_array($arrCandidateDetail) && (count($arrCandidateDetail) > 0)) {
                    $arrApplications[$intFrCnt]['JobsApplied']['candtail'] = $arrCandidateDetail;
                }

                if (is_array($arrCandidateCvDetail) && (count($arrCandidateCvDetail) > 0)) {
                    $arrApplications[$intFrCnt]['JobsApplied']['candcvdetail'] = $arrCandidateCvDetail;
                }
                $intFrCnt++;
            }
        }
        $this->set('arrApplications', $arrApplications);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_decode($strStartDate));
        $this->set('strEndDate', base64_decode($strEndDate));
    }

    public function jobseekerspurchasedorder() {
        $this->loadModel('User');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerPurchasedOrder($strStartDate, $strEndDate);
        $this->set('arrJobSeekerPurchaseOrderList', $arrJobSeekerPurchaseOrderList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_decode($strStartDate));
        $this->set('strEndDate', base64_decode($strEndDate));
    }

    public function overtimemoneylist() {
        $this->loadModel('User');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if ($strStartDate) {
            $arrOverTimeMoneyList = $this->User->fnGetOverTimeMonery($intPortalId, $strStartDate, $strEndDate);
        } else {
            $arrOverTimeMoneyList = $this->User->fnGetOverTimeMonery($intPortalId, $strStartDate, $strEndDate);
        }

        $this->set('arrOverTimeMoneyList', $arrOverTimeMoneyList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_decode($strStartDate));
        $this->set('strEndDate', base64_decode($strStartDate));
    }

    public function registered15processcompleted() {
        $this->loadModel('User');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        $arrPortalUserList = $this->User->fnGetUserCompleted15Steps($intPortalId, $strStartDate, $strEndDate, '');
        $this->set('arrPortalOwnerList', $arrPortalUserList);

        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_decode($strStartDate));
        $this->set('strEndDate', base64_decode($strEndDate));
    }
    
    public function visitorslist() {
        $this->layout = "admin";
        $this->loadModel('PortalVisitors');
        $intPortalId = base64_decode($_GET['portalId']);
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if ($strStartDate != '') {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsList($intPortalId = "", $strStartDate, $strEndDate);
            } else {
                $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsList($intPortalId, $strStartDate, $strEndDate);
            }
        }
        $this->set('arrTotalVisitors', $arrTotalVisitors);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('visiterType', "visit");
    }

    public function visitorsregisterlist() {
        $this->layout = "admin";
        $this->loadModel('PortalVisitors');
        $intPortalId = base64_decode($_GET['portalId']);
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if ($strStartDate != '') {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsRegisteredList($intPortalId = "", $strStartDate, $strEndDate);
            } else {
                $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsRegisteredList($intPortalId, $strStartDate, $strEndDate);
            }
        }
        $this->set('arrTotalVisitors', $arrTotalVisitors);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('visiterType', "register");
    }

    public function index($intPortalId = "") {
//        echo $this->layout;die;
        $arrLoggedUserDetails = $this->Auth->user();
        $this->set('arrLoggedUser', $arrLoggedUserDetails);
        $this->loadModel('Portal');

        $intPortalExists = $this->Portal->find('count', array(
            'conditions' => array('career_portal_id' => $intPortalId)
        ));



        if ($intPortalExists) {

            $this->set('strPostJobIndexUrl', Configure::read('Jobber.employerjobindexurl'));

            $this->set('portal_id', $intPortalId);



            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));

            $strEventName = $arrPortalDetail[0]['Portal']['career_portal_name'];

            $arrEvents = array(
                $arrPortalDetail[0]['Portal']['career_portal_name'] . " Registered Users",
                    /* $arrPortalDetail[0]['Portal']['career_portal_name']." Logged In Users",

                      $arrPortalDetail[0]['Portal']['career_portal_name']." Logged Out Users",

                      $arrPortalDetail[0]['Portal']['career_portal_name']." Confirmed Users",

                      $arrPortalDetail[0]['Portal']['career_portal_name']." Basic Search",

                      $arrPortalDetail[0]['Portal']['career_portal_name']." Advance Search" */
            );



            $compMixPanel = $this->Components->load('MixPanel');

            $objTrendsData = $compMixPanel->fnGetTrends($arrEvents);

            $arrCheckSeriesDataValues = (array) $objTrendsData->data->values;



            if (is_array($arrCheckSeriesDataValues) && (count($arrCheckSeriesDataValues) <= 0)) {

                $arrDfaultValueData = array();

                foreach ($arrEvents as $strEvents) {

                    $arrDefaultSeriesData = array();

                    foreach ($objTrendsData->data->series as $arrSeries) {

                        $arrDefaultSeriesData[$arrSeries] = "0";

                        //$strSeriesData .= "'".date("jS M y",strtotime($arrSeries))."',";
                    }

                    $arrDfaultValueData[$strEvents] = $arrDefaultSeriesData;
                }

                /* print("<pre>");

                  print_r($arrDfaultValueData); */

                $arrCheckSeriesDataValues = $arrDfaultValueData;
            }



            $strSeriesData = "[]";

            $strSeriesDataValue = "[]";

            if (isset($objTrendsData->data->series) && isset($objTrendsData->data->values)) {

                $strSeriesData = "[";

                foreach ($objTrendsData->data->series as $arrSeries) {

                    $strSeriesData .= "'" . date("jS M y", strtotime($arrSeries)) . "',";
                }



                $strSeriesData .= "]";



                $strSeriesDataValue = "[";



                //$this->set('strSeriesLabels',rtrim($strSeriesData,","));
                //echo "----".$strSeriesData;
                //$strSeriesData = "[";

                $arrSeriesData = array();

                $arrSeriesDataValues = $arrCheckSeriesDataValues;



                foreach ($arrSeriesDataValues as $arrSeriesDataLabel => $arrSeriesDataLabelValue) {

                    $strSeriesDataValue .= "{name:'" . $arrSeriesDataLabel . "',";

                    $arrSeriesDataValueList = (array) $arrSeriesDataLabelValue;

                    $strSeriesDataValue .= "data:[";

                    foreach ($objTrendsData->data->series as $arrSeries) {

                        //$strSeriesData .= "'".$arrSeries."',";

                        $strSeriesDataValue .= "['" . date("jS M y", strtotime($arrSeries)) . "'," . $arrSeriesDataValueList[$arrSeries] . "],";
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");



                    /* foreach($arrSeriesDataValueList as $arrSeriesDataValueListLabel => $arrSeriesDataValueListLabelValue)

                      {

                      //$arrSeriesData[] = "'".$arrSeriesDataValueListLabel."'";

                      $strSeriesDataValue .= "['".$arrSeriesDataValueListLabel."',".$arrSeriesDataValueListLabelValue."],";

                      } */

                    $strSeriesDataValue .= "]},";
                }

                $strSeriesDataValue = rtrim($strSeriesDataValue, ",");

                //$arrSeriesData = array_unique($arrSeriesData);
                //$strSeriesData = "[".implode(",",$arrSeriesData)."]";

                $strSeriesDataValue .= "]";

                //$this->set('strSeriesLabelsValues',$strSeriesDataValue);
                //$this->set('strSeriesLabels',rtrim($strSeriesData,","));
            }

            $this->set('strSeriesLabelsValues', $strSeriesDataValue);

            $this->set('strSeriesLabels', rtrim($strSeriesData, ","));

            $this->set('arrEvents', $arrEvents);

            //print("<pre>");
            //print_r($arrSeriesDataValues);
        } else {

            $this->Session->setFlash('This Portal does not exists, Please try with other Portal');
        }
    }

    public function updatepropertygraph($intPortalId = "") {

        $this->layout = NULL;

        $this->autoRender = false;

        $arrResponse = array();

        $arrPropertyRequest = array();

        $arrLoggedUserDetails = $this->Auth->user();

        $this->loadModel('Portal');

        $intPortalExists = $this->Portal->find('count', array(
            'conditions' => array('career_portal_id' => $intPortalId)
        ));



        if ($intPortalExists) {

            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));

            $strEventName = $arrPortalDetail[0]['Portal']['career_portal_name'];

            $strEventPartName = $this->request->data['eventrequest'];

            $strEventFromDate = $this->request->data['frmdate'];

            $strEventToDate = $this->request->data['todate'];

            $strEventProperty = $this->request->data['property'];

            if ($strEventPartName == "All") {

                $arrEvents = array(
                    $arrPortalDetail[0]['Portal']['career_portal_name'] . " Logged In Users",
                    $arrPortalDetail[0]['Portal']['career_portal_name'] . " Logged Out Users",
                    $arrPortalDetail[0]['Portal']['career_portal_name'] . " Registered Users",
                    $arrPortalDetail[0]['Portal']['career_portal_name'] . " Confirmed Users"
                );
            } else {

                $strEventName = $strEventName . " " . $strEventPartName;

                $arrEvents = array($strEventName);
            }

            $compMixPanel = $this->Components->load('MixPanel');

            $objPropertiesFilteredData = $compMixPanel->fnGetPropertyWiseData($arrEvents, $strEventFromDate, $strEventToDate, $strEventProperty);
            if ($strEventFromDate && $strEventToDate) {

                $compTime = $this->Components->load('TimeCalculation');

                $strDateDiff = $compTime->fnGetDurationInDays($strEventFromDate, $strEventToDate);

                $arrResponse['monhtsdata'] = $compTime->fnGetMonthsFromDays($strDateDiff);
            }

            if ($objPropertiesFilteredData->legend_size) {

                $arrResponse['legendsize'] = $objPropertiesFilteredData->legend_size;
            }

            $arrCheckSeriesDataValues = (array) $objPropertiesFilteredData->data->values;

            if (is_array($arrCheckSeriesDataValues) && (count($arrCheckSeriesDataValues) <= 0)) {
                $arrDfaultValueData = array();
                foreach ($arrEvents as $strEvents) {
                    $arrDefaultSeriesData = array();
                    foreach ($objPropertiesFilteredData->data->series as $arrSeries) {
                        $arrDefaultSeriesData[$arrSeries] = "0";
                    }

                    $arrDfaultValueData[$strEvents] = $arrDefaultSeriesData;
                }

                $arrCheckSeriesDataValues = $arrDfaultValueData;
            }

            if (isset($objPropertiesFilteredData->data->series) && isset($objPropertiesFilteredData->data->values)) {



                $strSeriesData = "";

                $strSeriesDataValue = "";

                $arrPieData = array();

                foreach ($objPropertiesFilteredData->data->series as $arrSeries) {

                    $strSeriesData .= date("jS M y", strtotime($arrSeries)) . ",";

                    $strSeriesDataValue .= "0,";
                }

                $arrResponse['chartdata'] = "null";

                $arrSeriesData = array();

                $arrSeriesDataValues = $arrCheckSeriesDataValues;

                if (is_array($arrSeriesDataValues) && (count($arrSeriesDataValues) > 0)) {

                    $strSeriesDataValue = "";

                    $arrResponse['PieData'] = "";

                    foreach ($arrSeriesDataValues as $arrSeriesDataLabel => $arrSeriesDataLabelValue) {

                        $arrSeriesDataValueList = (array) $arrSeriesDataLabelValue;

                        $strSeriesDataValue .= $arrSeriesDataLabel . ":";

                        $intTotalCount = 0;

                        foreach ($objPropertiesFilteredData->data->series as $arrSeries) {

                            //$strSeriesDataValue .= "['".date("jS M y",strtotime($arrSeries))."',".$arrSeriesDataValueList[$arrSeries]."]~";

                            if ($arrSeriesDataValueList[$arrSeries]) {

                                $arrResponse['chartdata'] = "notnull";
                            }

                            $strSeriesDataValue .= $arrSeriesDataValueList[$arrSeries] . ",";

                            $intTotalCount = $intTotalCount + $arrSeriesDataValueList[$arrSeries];
                        }

                        $arrResponse['PieData'] .= $arrSeriesDataLabel . "," . $intTotalCount . "~";

                        $strSeriesDataValue = rtrim($strSeriesDataValue, ",");

                        $strSeriesDataValue .= "~";
                    }
                }



                $arrSeriesData = array_unique($arrSeriesData);



                $arrResponse['status'] = "success";

                $arrResponse['xseries'] = rtrim($strSeriesData, ",");

                $arrResponse['dataseries'] = rtrim($strSeriesDataValue, "~");

                $arrResponse['chartTitle'] = $strEventProperty . " Wise";

                /* print("<pre>");

                  print_r($arrResponse);

                  exit; */
            } else {

                $arrResponse['status'] = "fail";
            }
        } else {

            $arrResponse['status'] = "fail";
        }

        echo json_encode($arrResponse);

        exit;
    }

    public function updategraph($intPortalId = "") {
        $this->layout = NULL;
        $this->autoRender = false;
        $arrResponse = array();
        $arrPropertyRequest = array();
        $arrLoggedUserDetails = $this->Auth->user();
        $this->loadModel('Portal');
        $intPortalExists = $this->Portal->find('count', array(
            'conditions' => array('career_portal_id' => $intPortalId)
        ));

        if ($intPortalExists) {
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));

            $strEventName = $arrPortalDetail[0]['Portal']['career_portal_name'];
            $strPeriod = $this->request->data['filterType'];
            $strEventPartName = $this->request->data['eventrequest'];

            if ($strPeriod == 'custom') {
                $strEventFromDate = $this->request->data['frmdate'];
                $strEventToDate = $this->request->data['todate'];
            } else {
                $compTime = $this->Components->load('TimeCalculation');
                $arrDayDate = $compTime->fnGetBeforeDate($strPeriod, date('Y-m-d H:i:s'));
                $strEventFromDate = $arrDayDate['start'];
                $strEventToDate = $arrDayDate['end'];
            }

            if ($strEventPartName == "All") {
                $arrEvents = array(
                    $arrPortalDetail[0]['Portal']['career_portal_name'] . " Logged In Users",
                    $arrPortalDetail[0]['Portal']['career_portal_name'] . " Logged Out Users",
                    $arrPortalDetail[0]['Portal']['career_portal_name'] . " Registered Users",
                    $arrPortalDetail[0]['Portal']['career_portal_name'] . " Confirmed Users"
                );
            } else {
                $strEventName = $strEventName . " " . $strEventPartName;
                $arrEvents = array($strEventName);
            }
            $compMixPanel = $this->Components->load('MixPanel');
//            $objPropertiesFilteredData = $compMixPanel->fnGetTrends($arrEvents, $strEventFromDate, $strEventToDate);
            $objPropertiesFilteredData = $compMixPanel->fnGetTrends($arrEvents, $strEventFromDate, $strEventToDate, $strPeriod);

            if ($strEventFromDate && $strEventToDate) {
                $compTime = $this->Components->load('TimeCalculation');
                $strDateDiff = $compTime->fnGetDurationInDays($strEventFromDate, $strEventToDate);
                $arrResponse['monhtsdata'] = $compTime->fnGetMonthsFromDays($strDateDiff);
            }

            $arrCheckSeriesDataValues = (array) $objPropertiesFilteredData->data->values;

            if (is_array($arrCheckSeriesDataValues) && (count($arrCheckSeriesDataValues) <= 0)) {
                $arrDfaultValueData = array();
                foreach ($arrEvents as $strEvents) {
                    $arrDefaultSeriesData = array();
                    foreach ($objPropertiesFilteredData->data->series as $arrSeries) {
                        $arrDefaultSeriesData[$arrSeries] = "0";
                    }
                    $arrDfaultValueData[$strEvents] = $arrDefaultSeriesData;
                }
                $arrCheckSeriesDataValues = $arrDfaultValueData;
            }

            if (isset($objPropertiesFilteredData->data->series) && isset($objPropertiesFilteredData->data->values)) {
                $strSeriesData = "";
                $strSeriesDataValue = "";
                foreach ($objPropertiesFilteredData->data->series as $arrSeries) {
                    if ($strPeriod == 'curr_year') {
                        $strSeriesData .= date("Y", strtotime($arrSeries)) . ",";
                    } else if ($strPeriod == '30') {
                        $strSeriesData .= date("M y", strtotime($arrSeries)) . ",";
                    } else {
                        $strSeriesData .= date("jS M y", strtotime($arrSeries)) . ",";
                    }
                    $strSeriesDataValue .= "0,";
                }

                $arrResponse['chartdata'] = "null";
                $arrSeriesData = array();
                $arrSeriesDataValues = $arrCheckSeriesDataValues;
                if (is_array($arrSeriesDataValues) && (count($arrSeriesDataValues) > 0)) {
                    $strSeriesDataValue = "";
                    $strTotal = 0;
                    foreach ($arrSeriesDataValues as $arrSeriesDataLabel => $arrSeriesDataLabelValue) {
                        $arrSeriesDataValueList = (array) $arrSeriesDataLabelValue;
                        $strSeriesDataValue .= $arrSeriesDataLabel . ":";
                        foreach ($objPropertiesFilteredData->data->series as $arrSeries) {
                            if ($arrSeriesDataValueList[$arrSeries]) {
                                $arrResponse['chartdata'] = "notnull";
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesDataValue .= $arrSeriesDataValueList[$arrSeries] . ",";
                                $strTotal = $strTotal + $arrSeriesDataValueList[$arrSeries];
                            } else {
                                $strSeriesDataValue .= $arrSeriesDataValueList[$arrSeries] . ",";
                                $strTotal = $strTotal + $arrSeriesDataValueList[$arrSeries];
                            }
//                            $strSeriesDataValue .= $arrSeriesDataValueList[$arrSeries] . ",";
                        }
                        $strTotalUsers .= $strTotal . "~";
                        $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                        $strSeriesDataValue .= "~";
                    }
                }

                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'viewjobseekerlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strEventFromDate) . "&endDate=" . base64_encode($strEventToDate);

                $arrSeriesData = array_unique($arrSeriesData);
                $arrResponse['status'] = "success";
                if ($strPeriod == 'curr_year') {
                    $arrResponse['xseries'] = date("Y");
                    $strSeriesDataValue = explode("~", $strTotalUsers);
                    $arrResponse['dataseries'] = $arrPortalDetail[0]['Portal']['career_portal_name'] . " Registered Users:" . $strSeriesDataValue[0] . "";
                } else {
                    $arrResponse['xseries'] = rtrim($strSeriesData, ",");
                    $arrResponse['dataseries'] = rtrim($strSeriesDataValue, "~");
                }
                $strSeriesDataValue = explode("~", $strTotalUsers);
                $arrResponse['chartTitle'] = $arrPortalDetail[0]['Portal']['career_portal_name'] . " Registered Users";
                $arrResponse['graphseariesvalue'] = $strSeriesDataValue[0];
                $arrResponse['list_link'] = $strAjaxPortalStatsUrl;
            } else {

                $arrResponse['status'] = "fail";
            }
        } else {

            $arrResponse['status'] = "fail";
        }

        echo json_encode($arrResponse);

        exit;
    }

    public function userExport() {
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $strStatus = $_GET['Status'];

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('PortalUser');

        if ($strStatus != '') {
            if (!empty($strStartDate)) {
                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => $strStatus, 'career_portal_id' => $intPortalId, 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
            } else {
                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => $strStatus, 'career_portal_id' => $intPortalId)));
            }
        } else {
            if (!empty($strStartDate)) {
                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
            } else {
                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId)));
            }
        }

        if (is_array($arrPortalUserList) && count($arrPortalUserList) > 0) {
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
            if ($strStatus == '1') {
                $strFileName = "Active_Users_Reports.xls";
                $reportName = "Active Users Analytics Report";
            } else if ($strStatus == '0') {
                $strFileName = "Inactive_Users_Reports.xls";
                $reportName = "Inactive Users Analytics Report";
            } else {
                $strFileName = "View_Job_Seekers_Reports.xls";
                $reportName = "View Job Seekers Analytics Report";
            }
            $intFrCnt = 0;
            $intRowCnt = 6;

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Job Seeker(s) Analytics Report")
                    ->setSubject("Job Seeker(s) Analytics Report")
                    ->setDescription("Job Seeker(s) Analytics Report")
                    ->setKeywords("Job Seeker(s) Analytics Report")
                    ->setCategory("Job Seeker(s) Analytics Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'First Name')
                    ->setCellValue('C5', 'Last Name')
                    ->setCellValue('D5', 'Email')
                    ->setCellValue('E5', 'Portal Name')
                    ->setCellValue('F5', 'Date Registered');

            foreach ($arrPortalUserList as $k => $arrUsers) {
                $candidateFirstName = $arrUsers['PortalUser']['candidate_first_name'];
                $candidateLastName = $arrUsers['PortalUser']['candidate_last_name'];
                $candidateEmail = $arrUsers['PortalUser']['candidate_email'];
                $PortalName = $arrPortalDet[$intPortalId];
                $candidateCreationDate = $arrUsers['PortalUser']['candidate_creation_date'];

                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $candidateFirstName)
                        ->setCellValue('C' . $intRowCnt, $candidateLastName)
                        ->setCellValue('D' . $intRowCnt, $candidateEmail)
                        ->setCellValue('E' . $intRowCnt, $PortalName)
                        ->setCellValue('F' . $intRowCnt, $candidateCreationDate);

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);  //set column C width

                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(20);  //set row 4 height

                $intFrCnt++;
                $intRowCnt++;
            }

            $objPHPExcel->getActiveSheet()->mergeCells('C2:E2');
            $objPHPExcel->getActiveSheet()->setCellValue('C2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('C3:E3');
                $objPHPExcel->getActiveSheet()->setCellValue('C3', $strStartDate . " - " . $strEndDate);
                $objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setSize(15);  //set wrapped for some long text message
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
            $arrResponse['message'] = "There are no sales in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function orderRefundedExport() {
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Resourceorderdetail');
        $this->loadModel('Vendors');
        $this->loadModel('Portal');

        $arrConditions = array();

        if ($strStartDate) {
            $arrConditions['Resourceorderdetail.order_detail_creation_date_time >='] = $strStartDate;
        }

        if ($strEndDate) {
            $arrConditions['Resourceorderdetail.order_detail_creation_date_time <='] = $strEndDate;
        }

        $arrConditions['Resourceorderdetail.refund_status ='] = 1;

        if (is_array($arrConditions) && (count($arrConditions) > 0)) {
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
        } else {
            $arrNewOrders = $this->Resourceorderdetail->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'resource_order',
                        'alias' => 'Resourceorder',
                        'type' => 'inner',
                        'conditions' => array('Resourceorderdetail.order_id=Resourceorder.resource_order_id')
                    )
                ),
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
                'order' => array('order_detail_id' => 'desc')
            ));
        }

        $intTotalAmount = 0;
        if (is_array($arrTotalSumQ) && (count($arrTotalSumQ) > 0)) {
            $intTotalAmount = $arrTotalSumQ['0']['0']['amount'];
        }
        $this->set("intTotalAmount", $intTotalAmount);

        if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
            $this->loadModel('Resourceorder');
            $this->loadModel('Candidate');
            $this->loadModel('Resources');
            $intFrCnt = 0;
            foreach ($arrNewOrders as $arrOrder) {
                $intOrderId = $arrOrder['Resourceorderdetail']['order_id'];
                $intVendorType = $arrOrder['Resourceorderdetail']['vendor_type'];
                $intVendorId = $arrOrder['Resourceorderdetail']['vendor_id'];
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

                if ($intVendorType == "vendor") {
                    $arrSubVendorsFor = $this->Vendors->find('all', array(
                        'fields' => array('Vendors.*'),
                        'joins' => array(
                            array(
                                'table' => 'resource_order_detail',
                                'alias' => 'Resourceorderdetail',
                                'type' => 'left',
                                'conditions' => array('Vendors.vendor_id=Resourceorderdetail.vendor_id')
                            )
                        ),
                        'conditions' => array('Vendors.vendor_id' => $intVendorId)
                    ));
                } else {
                    $arrSubVendorsFor = $this->Portal->find('all', array(
                        'conditions' => array('career_portal_id' => $arrOrder['Resourceorderdetail']['vendor_id'])
                    ));

                    $arrSubVendorsFor[0]['Vendors']['vendor_first_name'] = $arrSubVendorsFor[0]['Portal']['career_portal_name'];
                }
                $arrNewOrders[$intFrCnt]['vendorsuser'] = $arrSubVendorsFor[0];

                $intFrCnt++;
            }
        }

        if (is_array($arrNewOrders) && count($arrNewOrders) > 0) {
            $strFileName = "Order_Refunded_Reports.xls";
            $reportName = "Order Refunded Analytics Report";
            $intFrCnt = 0;
            $intRowCnt = 6;

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Job Seeker(s) Analytics Report")
                    ->setSubject("Job Seeker(s) Analytics Report")
                    ->setDescription("Job Seeker(s) Analytics Report")
                    ->setKeywords("Job Seeker(s) Analytics Report")
                    ->setCategory("Job Seeker(s) Analytics Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'Order ID')
                    ->setCellValue('C5', 'Title')
                    ->setCellValue('D5', 'Payment Status')
                    ->setCellValue('E5', 'Cost')
                    ->setCellValue('F5', 'Owner Cost');

            foreach ($arrNewOrders as $k => $arrOrders) {
                $OrderId = $arrOrders['Resourceorderdetail']['order_detail_id'];
                $Title = stripslashes($arrOrders['service']['Resources']['product_name']);
                if ($arrOrders['Resourceorderdetail']['refund_status']) {
                    $Payment_Status = "Refunded";
                } else {
                    $Payment_Status = $arrOrders['Resourceorderdetail']['payment_status'];
                }

                $Cost = "$ " . $arrOrders['Resourceorderdetail']['product_unit_cost'];
                $Owner_Cost = $arrOrders['Resourceorderdetail']['order_detail_id'];
                if ($arrContent['Resourceorderdetail']['refund_status']) {
                    $Owner_Cost = "$ 0.00";
                } else {
                    $Owner_Cost = "$ " . $arrContent['Resourceorderdetail']['portal_owner_cost'];
                }

                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $OrderId)
                        ->setCellValue('C' . $intRowCnt, $Title)
                        ->setCellValue('D' . $intRowCnt, $Payment_Status)
                        ->setCellValue('E' . $intRowCnt, $Cost)
                        ->setCellValue('F' . $intRowCnt, $Owner_Cost);

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);  //set column C width

                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(20);  //set row 4 height

                $intFrCnt++;
                $intRowCnt++;
            }

            $objPHPExcel->getActiveSheet()->mergeCells('C2:E2');
            $objPHPExcel->getActiveSheet()->setCellValue('C2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('C3:E3');
                $objPHPExcel->getActiveSheet()->setCellValue('C3', $strStartDate . " - " . $strEndDate);
                $objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setSize(15);  //set wrapped for some long text message
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
            $arrResponse['message'] = "There are no refunded order in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function registered15ProcessCompletedExport() {
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['StartDate']);
        $strEndDate = base64_decode($_GET['EndDate']);

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();

        $this->loadModel('User');
        $this->loadModel('Portal');

        if ($strStartDate) {
            $arrPortalUserList = $this->User->fnGetUserCompleted15Steps($intPortalId, $strStartDate, $strEndDate, '');
        } else {
            $arrPortalUserList = $this->User->fnGetUserCompleted15Steps($intPortalId, $strStartDate = "", $strEndDate = "", '');
        }
        if (is_array($arrPortalUserList) && count($arrPortalUserList) > 0) {
            $strFileName = "15_Step_Completed_Reports.xls";
            $reportName = "15 Step Completed Analytics Report";
            $intFrCnt = 0;
            $intRowCnt = 6;

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Job Seeker(s) Analytics Report")
                    ->setSubject("Job Seeker(s) Analytics Report")
                    ->setDescription("Job Seeker(s) Analytics Report")
                    ->setKeywords("Job Seeker(s) Analytics Report")
                    ->setCategory("Job Seeker(s) Analytics Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'Email')
                    ->setCellValue('C5', 'First Name')
                    ->setCellValue('D5', 'Last Name')
                    ->setCellValue('E5', 'Portal Name')
                    ->setCellValue('F5', 'Phone Number')
                    ->setCellValue('G5', 'Portal Creation Date')
                    ->setCellValue('H5', 'Portal Cancellation Date');

            foreach ($arrPortalUserList as $k => $arrPortalOwner) {
                $OwnerEmail = $arrPortalOwner['user']['email'];
                $FirstName = stripslashes($arrPortalOwner['employer_detail']['employer_user_fname']);
                $LastName = stripslashes($arrPortalOwner['employer_detail']['employer_user_lname']);
                $PhoneNo = stripslashes($arrPortalOwner['career_portal']['career_portal_name']);
                $ContactNo = stripslashes($arrPortalOwner['employer_detail']['employer_contact_number']);
                $CreatedDate = stripslashes($arrPortalOwner['career_portal']['career_portal_created_datetime']);
                $CancelDate = stripslashes($arrPortalOwner['user']['user_inactivation_date']);

                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $OwnerEmail)
                        ->setCellValue('C' . $intRowCnt, isset($FirstName) ? $FirstName : '-')
                        ->setCellValue('D' . $intRowCnt, isset($LastName) ? $LastName : '-')
                        ->setCellValue('E' . $intRowCnt, isset($PhoneNo) ? $PhoneNo : '-')
                        ->setCellValue('F' . $intRowCnt, isset($ContactNo) ? $ContactNo : '-')
                        ->setCellValue('G' . $intRowCnt, isset($CreatedDate) ? $CreatedDate : '-')
                        ->setCellValue('H' . $intRowCnt, isset($CancelDate) ? $CancelDate : '-');

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);  //set column C width

                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(20);  //set row 4 height

                $intFrCnt++;
                $intRowCnt++;
            }

            $objPHPExcel->getActiveSheet()->mergeCells('C2:G2');
            $objPHPExcel->getActiveSheet()->setCellValue('C2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('D3:F3');
                $objPHPExcel->getActiveSheet()->setCellValue('D3', $strStartDate . " - " . $strEndDate);
                $objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setSize(15);  //set wrapped for some long text message
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
            $arrResponse['message'] = "There are no user completed 15 steps in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function appliedforOwnerJobExport() {
//        Configure::write('debug', '2');
        $this->loadModel('JobsApplied');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();

        if (!empty($strStartDate)) {

            $this->Paginator->settings = array(
                'conditions' => array('job_portal_id' => $arrLoggedUser['portal_id'], 'job_application_datetime <=' => $strStartDate, 'job_application_datetime >=' => $strStartDate),
                'order' => array('job_application_id' => 'DESC'),
                'limit' => 20
            );
        } else {
            $this->Paginator->settings = array(
                'conditions' => array('job_portal_id' => $arrLoggedUser['portal_id']),
                'order' => array('job_application_id' => 'DESC'),
                'limit' => 20
            );
        }
        $arrApplications = $this->Paginator->paginate('JobsApplied');

        if (is_array($arrApplications) && (count($arrApplications) > 0)) {
            $this->loadModel('Candidate');
            $this->loadModel('Candidate_Cv');
            $this->loadModel('Job');
            $intFrCnt = 0;
            foreach ($arrApplications as $arrApp) {
                $arrJobDetail = $this->Job->find('all', array('conditions' => array('id' => $arrApp['JobsApplied']['job_id'])));
                $arrCandidateDetail = $this->Candidate->find('all', array('conditions' => array('candidate_id' => $arrApp['JobsApplied']['candidate_id'])));
                $arrCandidateCvDetail = $this->Candidate_Cv->find('all', array('conditions' => array('candidatecv_id' => $arrApp['JobsApplied']['candidate_cv_id'])));
                if (is_array($arrJobDetail) && (count($arrJobDetail) > 0)) {
                    $arrApplications[$intFrCnt]['JobsApplied']['jobdetail'] = $arrJobDetail;
                }

                if (is_array($arrCandidateDetail) && (count($arrCandidateDetail) > 0)) {
                    $arrApplications[$intFrCnt]['JobsApplied']['candtail'] = $arrCandidateDetail;
                }

                if (is_array($arrCandidateCvDetail) && (count($arrCandidateCvDetail) > 0)) {
                    $arrApplications[$intFrCnt]['JobsApplied']['candcvdetail'] = $arrCandidateCvDetail;
                }
                $intFrCnt++;
            }
        }

        if (is_array($arrApplications) && count($arrApplications) > 0) {
            $strFileName = "Applied_Owner_Jobs_Reports.xls";
            $reportName = "Applied For Owner Jobs Analytics Report";
            $intFrCnt = 0;
            $intRowCnt = 6;

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Job Seeker(s) Analytics Report")
                    ->setSubject("Job Seeker(s) Analytics Report")
                    ->setDescription("Job Seeker(s) Analytics Report")
                    ->setKeywords("Job Seeker(s) Analytics Report")
                    ->setCategory("Job Seeker(s) Analytics Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'Email')
                    ->setCellValue('C5', 'Title')
                    ->setCellValue('D5', 'Candidate')
                    ->setCellValue('E5', 'Phone Number')
                    ->setCellValue('F5', 'Resume | CV')
                    ->setCellValue('G5', 'Application date');

            foreach ($arrApplications as $k => $arrJob) {

                $arrJobD = $arrJob['JobsApplied']['jobdetail'];
                $arrCandD = $arrJob['JobsApplied']['candtail'];
                $arrCVD = $arrJob['JobsApplied']['candcvdetail'];

                $CandidateEmail = $arrCandD[0]['Candidate']['candidate_email'];
                $JobTitle = stripslashes($arrJobD[0]['Job']['job_title']);
                $CandidateFullName = stripslashes($arrCandD[0]['Candidate']['candidate_first_name'] . " " . $arrCandD[0]['Candidate']['candidate_last_name']);
                $PhoneNo = $arrCVD[0]['Candidate_Cv']['homePhone'];
                $ResumeTitle = $arrCVD[0]['Candidate_Cv']['resume_title'];
                $ApplicationDate = $arrJob['JobsApplied']['job_application_datetime'];

                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $CandidateEmail)
                        ->setCellValue('C' . $intRowCnt, isset($JobTitle) ? $JobTitle : '-')
                        ->setCellValue('D' . $intRowCnt, isset($CandidateFullName) ? $CandidateFullName : '-')
                        ->setCellValue('E' . $intRowCnt, isset($PhoneNo) ? $PhoneNo : '-')
                        ->setCellValue('F' . $intRowCnt, isset($ResumeTitle) ? $ResumeTitle : '-')
                        ->setCellValue('G' . $intRowCnt, $ApplicationDate);

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);  //set column C width

                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(20);  //set row 4 height

                $intFrCnt++;
                $intRowCnt++;
            }

            $objPHPExcel->getActiveSheet()->mergeCells('C2:G2');
            $objPHPExcel->getActiveSheet()->setCellValue('C2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('C3:E3');
                $objPHPExcel->getActiveSheet()->setCellValue('C3', $strStartDate . " - " . $strEndDate);
                $objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setSize(15);  //set wrapped for some long text message
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
            $arrResponse['message'] = "There are no user completed 15 steps in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function purchaseOrderExport() {

        $this->loadModel('User');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();

        if ($strStartDate) {
            $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerPurchasedOrder($strStartDate, $strEndDate);
        } else {
            $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerPurchasedOrder($strStartDate = "", $strEndDate = "");
        }

        if (is_array($arrJobSeekerPurchaseOrderList) && count($arrJobSeekerPurchaseOrderList) > 0) {
            $strFileName = "Purchase_Order_Reports.xls";
            $reportName = "Purchase Order Analytics Report";
            $intFrCnt = 0;
            $intRowCnt = 6;

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Job Seeker(s) Analytics Report")
                    ->setSubject("Job Seeker(s) Analytics Report")
                    ->setDescription("Job Seeker(s) Analytics Report")
                    ->setKeywords("Job Seeker(s) Analytics Report")
                    ->setCategory("Job Seeker(s) Analytics Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'Email')
                    ->setCellValue('C5', 'First Name')
                    ->setCellValue('D5', 'Last Name')
                    ->setCellValue('E5', 'Date Registered');

            foreach ($arrJobSeekerPurchaseOrderList as $k => $arrJobSeekerPurchaseOrder) {
                $CandidateEmail = $arrJobSeekerPurchaseOrder['career_portal_candidate']['candidate_email'];
                $FirstName = stripslashes($arrJobSeekerPurchaseOrder['career_portal_candidate']['candidate_first_name']);
                $LastName = stripslashes($arrJobSeekerPurchaseOrder['career_portal_candidate']['candidate_last_name']);
                $RegisterDate = $arrJobSeekerPurchaseOrder['career_portal_candidate']['candidate_creation_date'];

                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $CandidateEmail)
                        ->setCellValue('C' . $intRowCnt, isset($FirstName) ? $FirstName : '-')
                        ->setCellValue('D' . $intRowCnt, isset($LastName) ? $LastName : '-')
                        ->setCellValue('E' . $intRowCnt, isset($RegisterDate) ? $RegisterDate : '-');

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);  //set column C width

                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(20);  //set row 4 height

                $intFrCnt++;
                $intRowCnt++;
            }

            $objPHPExcel->getActiveSheet()->mergeCells('B2:E2');
            $objPHPExcel->getActiveSheet()->setCellValue('B2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
                $objPHPExcel->getActiveSheet()->setCellValue('B3', $strStartDate . " - " . $strEndDate);
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
            $arrResponse['message'] = "There are no user completed 15 steps in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function overTimeMoneyExport() {
        $this->loadModel('User');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();

        if ($strStartDate) {
            $arrOverTimeMoneyList = $this->User->fnGetOverTimeMonery($intPortalId, $strStartDate, $strEndDate);
        } else {
            $arrOverTimeMoneyList = $this->User->fnGetOverTimeMonery($intPortalId, $strStartDate, $strEndDate);
        }

        if (is_array($arrOverTimeMoneyList) && count($arrOverTimeMoneyList) > 0) {
            $strFileName = "Owner_Made_OverTime_Reports.xls";
            $reportName = "Money that Owner Have Made OverTime Analytics Report";
            $intFrCnt = 0;
            $intRowCnt = 6;

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Job Seeker(s) Analytics Report")
                    ->setSubject("Job Seeker(s) Analytics Report")
                    ->setDescription("Job Seeker(s) Analytics Report")
                    ->setKeywords("Job Seeker(s) Analytics Report")
                    ->setCategory("Job Seeker(s) Analytics Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'Portal Name')
                    ->setCellValue('C5', 'Product Name')
                    ->setCellValue('D5', 'Over Time Money')
                    ->setCellValue('E5', 'Order Date');

            foreach ($arrOverTimeMoneyList as $k => $overTimeMoney) {
                $monery = "$ " . $overTimeMoney[0]['OverTimeMonery'];
                $portalName = $overTimeMoney['career_portal']['career_portal_name'];
                $product_name = $overTimeMoney['resource_order_detail']['product_name'];
                $order_date = $overTimeMoney['resource_order_detail']['order_detail_creation_date_time'];
                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $portalName)
                        ->setCellValue('C' . $intRowCnt, isset($product_name) ? $product_name : '-')
                        ->setCellValue('D' . $intRowCnt, isset($monery) ? $monery : '-')
                        ->setCellValue('E' . $intRowCnt, isset($order_date) ? $order_date : '-');

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);  //set column C width

                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(20);  //set row 4 height

                $intFrCnt++;
                $intRowCnt++;
            }

            $objPHPExcel->getActiveSheet()->mergeCells('B2:I2');
            $objPHPExcel->getActiveSheet()->setCellValue('B2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
                $objPHPExcel->getActiveSheet()->setCellValue('B3', $strStartDate . " - " . $strEndDate);
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
            $arrResponse['message'] = "There are no user completed 15 steps in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function themeRegisterUserExport() {
        $this->loadModel('User');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $strThemeName = $_GET['themeName'];

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();

        if ($strStartDate != '') {
            $arrJobSeekerThemeRegisterList = $this->User->fnGetJobSeekerThemeRegisterDetails($intPortalId, $strStartDate, $strEndDate, $strThemeName);
        } else {
            $arrJobSeekerThemeRegisterList = $this->User->fnGetJobSeekerThemeRegisterDetails($intPortalId, $strStartDate = "", $strEndDate = "", $strThemeName);
        }

        if (is_array($arrJobSeekerThemeRegisterList) && count($arrJobSeekerThemeRegisterList) > 0) {
            $strFileName = "Theme_Users_Reports.xls";
            $reportName = $strThemeName . " Register Users Analytics Report";
            $intFrCnt = 0;
            $intRowCnt = 6;

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Job Seeker(s) Analytics Report")
                    ->setSubject("Job Seeker(s) Analytics Report")
                    ->setDescription("Job Seeker(s) Analytics Report")
                    ->setKeywords("Job Seeker(s) Analytics Report")
                    ->setCategory("Job Seeker(s) Analytics Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'Email')
                    ->setCellValue('C5', 'First Name')
                    ->setCellValue('D5', 'Last Name')
                    ->setCellValue('E5', 'Theme Name')
                    ->setCellValue('F5', 'Date Registered');

            foreach ($arrJobSeekerThemeRegisterList as $k => $arrPortalThemeUser) {
                $candidateEmail = $arrPortalThemeUser['career_portal_candidate']['candidate_email'];
                $candidateFirstName = $arrPortalThemeUser['career_portal_candidate']['candidate_first_name'];
                $candidateLastName = $arrPortalThemeUser['career_portal_candidate']['candidate_last_name'];
                $candidateThemeName = $arrPortalThemeUser['career_portal_candidate']['portal_theme_name'];
                $candidateRegisterDate = $arrPortalThemeUser['career_portal_candidate']['candidate_creation_date'];
                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $candidateEmail)
                        ->setCellValue('C' . $intRowCnt, isset($candidateFirstName) ? $candidateFirstName : '-')
                        ->setCellValue('D' . $intRowCnt, isset($candidateLastName) ? $candidateLastName : '-')
                        ->setCellValue('E' . $intRowCnt, isset($candidateThemeName) ? $candidateThemeName : '-')
                        ->setCellValue('F' . $intRowCnt, isset($candidateRegisterDate) ? $candidateRegisterDate : '-');

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);  //set column C width

                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(20);  //set row 4 height

                $intFrCnt++;
                $intRowCnt++;
            }

            $objPHPExcel->getActiveSheet()->mergeCells('B2:I2');
            $objPHPExcel->getActiveSheet()->setCellValue('B2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
                $objPHPExcel->getActiveSheet()->setCellValue('B3', $strStartDate . " - " . $strEndDate);
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
            $arrResponse['message'] = "There are no theme register user in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function phaseCompletedJobSeekersExport() {
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $phaseId = $_GET['phaseId'];

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();

        $this->loadModel('Jobsearchtracker');

        if ($phaseId != '') {
            if ($strStartDate) {
                $arrJobSeekerCompletedList = $this->Jobsearchtracker->fnGetJobSeekerPhaseWiseCompleted($phaseId, $strStartDate, $strEndDate);
            } else {
                $arrJobSeekerCompletedList = $this->Jobsearchtracker->fnGetJobSeekerPhaseWiseCompleted($phaseId, $strStartDate = "", $strEndDate = "");
            }
        }

        if (is_array($arrJobSeekerCompletedList) && count($arrJobSeekerCompletedList) > 0) {
            $strFileName = "Phase_Completed_Reports.xls";
            $reportName = htmlspecialchars_decode($arrJobSeekerCompletedList[0]['content_category']['content_category_name']) . " Phase Completed Analytics Report";
            $intFrCnt = 0;
            $intRowCnt = 6;

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Job Seeker(s) Analytics Report")
                    ->setSubject("Job Seeker(s) Analytics Report")
                    ->setDescription("Job Seeker(s) Analytics Report")
                    ->setKeywords("Job Seeker(s) Analytics Report")
                    ->setCategory("Job Seeker(s) Analytics Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'Email')
                    ->setCellValue('C5', 'First Name')
                    ->setCellValue('D5', 'Last Name')
                    ->setCellValue('E5', 'Phase Name')
                    ->setCellValue('F5', 'Date Completion');

            foreach ($arrJobSeekerCompletedList as $k => $arrPhaseCompletedUser) {
                $candidateEmail = $arrPhaseCompletedUser['career_portal_candidate']['candidate_email'];
                $candidateFirstName = $arrPhaseCompletedUser['career_portal_candidate']['candidate_first_name'];
                $candidateLastName = $arrPhaseCompletedUser['career_portal_candidate']['candidate_last_name'];
                $candidatePhaseName = $arrPhaseCompletedUser['content_category']['content_category_name'];
                $candidateRegisterDate = $arrPhaseCompletedUser['jobsearcprocess_completion_tracker']['completion_date_time'];
                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $candidateEmail)
                        ->setCellValue('C' . $intRowCnt, isset($candidateFirstName) ? $candidateFirstName : '-')
                        ->setCellValue('D' . $intRowCnt, isset($candidateLastName) ? $candidateLastName : '-')
                        ->setCellValue('E' . $intRowCnt, isset($candidatePhaseName) ? $candidatePhaseName : '-')
                        ->setCellValue('F' . $intRowCnt, isset($candidateRegisterDate) ? $candidateRegisterDate : '-');

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);  //set column C width

                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(20);  //set row 4 height

                $intFrCnt++;
                $intRowCnt++;
            }

            $objPHPExcel->getActiveSheet()->mergeCells('B2:I2');
            $objPHPExcel->getActiveSheet()->setCellValue('B2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
                $objPHPExcel->getActiveSheet()->setCellValue('B3', $strStartDate . " - " . $strEndDate);
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
            $arrResponse['message'] = "There are no phase completed job seeker(s) in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }
    
    public function visitorsExport() {
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $visiterType = ($_GET['visiterType']);

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Portal');
        $this->loadModel('PortalVisitors');

        if ($intPortalId != "" && $strStartDate != '') {
            if($visiterType == "visit") {
                if ($intPortalId == 'all') {
                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsList($intPortalId = "", $strStartDate, $strEndDate);
                } else {
                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsList($intPortalId, $strStartDate, $strEndDate);
                }
            } else {
                if ($intPortalId == 'all') {
                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsRegisteredList($intPortalId = "", $strStartDate, $strEndDate);
                } else {
                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsRegisteredList($intPortalId, $strStartDate, $strEndDate);
                }
            }
        }

        if (is_array($arrTotalVisitors) && count($arrTotalVisitors) > 0) {
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
            $strFileName = "Visitors_Reports.xls";
            $reportName = $arrPortalDet[$intPortalId] . " Visitors Report";
            $intFrCnt = 0;
            $intRowCnt = 6;
            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Visitors Analytics Report")
                    ->setSubject("Visitors Analytics Report")
                    ->setDescription("Visitors Analytics Report")
                    ->setKeywords("Visitors Analytics Report")
                    ->setCategory("Visitors Analytics Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'Portal Name')
                    ->setCellValue('C5', 'Ip Address')
                    ->setCellValue('D5', 'Visits Date');

            foreach ($arrTotalVisitors as $k => $Visitors) {
                $PortalName = $Visitors['career_portal_visitors']['portal_name'];
                $ipAddress = $Visitors['career_portal_visitors']['ip_address'];
                $VisitsDate = $Visitors['career_portal_visitors']['visited_date'];

                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $PortalName)
                        ->setCellValue('C' . $intRowCnt, $ipAddress)
                        ->setCellValue('D' . $intRowCnt, $VisitsDate);

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);  //set column C width

                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(20);  //set row 4 height

                $intFrCnt++;
                $intRowCnt++;
            }

            $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
            $objPHPExcel->getActiveSheet()->setCellValue('A2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
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
