<?php

class AdminanalyticsController extends AppController {

    var $helpers = array('Html', 'Form');
    public $components = array('Paginator');
    var $name = 'Adminanalytics';

    public function beforeFilter() {
        //$this->Auth->autoRedirect = false;
        parent::beforeFilter();
        $this->Auth->allow('index', 'userstatistics');
    }

    public function userstatistics($intPortalId = "") {
//        Configure::write('debug', '2');
        $arrResponse = array();
        if ($this->request->is('Post')) {
            $strStatRequestId = $this->request->data['requestid'];
            $strPeriod = $this->request->data['filterType'];
            $productType = $this->request->data['ProductType'];
            $strVendor = isset($this->request->data['vendors']) ? $this->request->data['vendors'] : null;
            $strVendorCompany = isset($this->request->data['VendorCompany']) ? $this->request->data['VendorCompany'] : null;
            $intOwnerId = isset($this->request->data['OwnerId']) ? $this->request->data['OwnerId'] : null;
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
                    $arrResponse['chartTitle'] = "Registered Job Seekers Statistics";
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
                                if ($intPortalId == 'all') {
                                    $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                                } else {
                                    $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all') {
                                    $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_creation_date >=' => $series, 'candidate_creation_date <=' => $strToDate)));
                                } else {
                                    $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'candidate_creation_date >=' => $series, 'candidate_creation_date <=' => $strToDate)));
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_creation_date >=' => $series, 'candidate_creation_date <' => $strToDate)));
                                } else {
                                    $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'candidate_creation_date >=' => $series, 'candidate_creation_date <' => $strToDate)));
                                }
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
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'registeredjobseekerlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim(" Registered Job Seekers Statistics:" . count($arrPortalUserList));
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim(" Registered Job Seekers Statistics:" . $strSeriesDataValue);
                    }
                    $arrResponse['graphsearies'] = "Registered Job Seekers Statistics";
                    $arrResponse['graphsearieslabel'] = "Registered Job Seekers Statistics";
                    $arrResponse['graphseariesvalue'] = count($arrPortalUserList);
                    $arrResponse['chartTitle'] = "Registered Job Seekers Statistics";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "2") {
                    $this->loadModel('Portal');
                    $this->loadModel('PortalUser');
                    $this->loadModel('User');
                    if ($intPortalId != 'all') {
                        $arrPortalList = $this->Portal->find('all', array('fields' => array('career_portal_id', 'career_portal_name', 'career_portal_created_by'), 'conditions' => array('career_portal_published' => '1', 'career_portal_id' => $intPortalId)));
                    }
//                    echo '<pre>';print_r($arrPortalList[0]['Portal']['career_portal_created_by']);die;
                    $arrResponse['chartTitle'] = "Portal Owners Statistics";
                    $portalOwner = $arrPortalList[0]['Portal']['career_portal_created_by'];
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
                                $arrPortalOwnerList = $this->User->fnGetPortalOwnersUsers($intPortalId, $strStartDate, $strEndDate, $portalOwner);
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                $arrPortalOwnerList = $this->User->fnGetPortalOwnersUsers($intPortalId, $series, $strToDate, $portalOwner);
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrPortalOwnerList = $this->User->fnGetPortalOwnersUsers($intPortalId, $series, $strToDate, $portalOwner);
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrPortalOwnerList) > 0) {
                                $strSeriesDataValue .= (count($arrPortalOwnerList)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'portalownerslist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&PortalOwner=" . base64_encode($portalOwner);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        if ($intPortalId) {
                            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
                            $arrResponse['dataseries'] = $arrPortalDet[$intPortalId] . rtrim(" Registered Job Seekers Statistics:" . count($arrPortalOwnerList));
                        } else {
                            $arrResponse['dataseries'] = rtrim(" Registered Job Seekers Statistics:" . count($arrPortalOwnerList));
                        }
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        if ($intPortalId) {
                            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
                            $arrResponse['dataseries'] = $arrPortalDet[$intPortalId] . rtrim(" Registered Job Seekers Statistics:" . $strSeriesDataValue);
                        } else {
                            $arrResponse['dataseries'] = rtrim(" Registered Job Seekers Statistics:" . $strSeriesDataValue);
                        }
                    }
                    if ($intPortalId) {
                        $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
                        $arrResponse['graphsearieslabel'] = $arrPortalDet[$intPortalId] . " Registered Portal Owners";
                        $arrResponse['graphsearies'] = $arrPortalDet[$intPortalId] . " Registered Job Seekers Statistics";
                        $arrResponse['chartTitle'] = $arrPortalDet[$intPortalId] . " Registered Job Seekers Statistics";
                    } else {
                        $arrResponse['graphsearieslabel'] = "All Portal Owners";
                        $arrResponse['graphsearies'] = "Registered Job Seekers Statistics";
                        $arrResponse['chartTitle'] = "Registered Job Seekers Statistics";
                    }

                    $arrResponse['graphseariesvalue'] = count($arrPortalOwnerList);

                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "3") {
                    $this->loadModel('Portal');
                    $this->loadModel('PortalUser');
                    $this->loadModel('User');
                    if ($intPortalId != 'all') {
                        $arrPortalList = $this->Portal->find('all', array('fields' => array('career_portal_id', 'career_portal_name', 'career_portal_created_by'), 'conditions' => array('career_portal_published' => '1', 'career_portal_id' => $intPortalId)));
                    }
                    $arrResponse['chartTitle'] = "Portal Active Owners Statistics";
                    $portalOwner = $arrPortalList[0]['Portal']['career_portal_created_by'];
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
                                $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId, $strStartDate, $strEndDate, $portalOwner, $status = '1');
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId, $series, $strToDate, $portalOwner, $status = '1');
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId, $series, $strToDate, $portalOwner, $status = '1');
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrPortalOwnerList) > 0) {
                                $strSeriesDataValue .= (count($arrPortalOwnerList)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'activeportalownerslist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        if ($intPortalId) {
                            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
                            $arrResponse['dataseries'] = $arrPortalDet[$intPortalId] . rtrim(" Registered Job Seekers Statistics:" . count($arrPortalOwnerList));
                        } else {
                            $arrResponse['dataseries'] = rtrim(" Registered Job Seekers Statistics:" . count($arrPortalOwnerList));
                        }
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        if ($intPortalId) {
                            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
                            $arrResponse['dataseries'] = $arrPortalDet[$intPortalId] . rtrim(" Portal Active Owners:" . $strSeriesDataValue);
                        } else {
                            $arrResponse['dataseries'] = rtrim("Portal Active Owners:" . $strSeriesDataValue);
                        }
                    }
                    if ($intPortalId) {
                        $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
                        $arrResponse['graphsearieslabel'] = $arrPortalDet[$intPortalId] . " Portal Active Owners";
                        $arrResponse['graphsearies'] = $arrPortalDet[$intPortalId] . " Portal Active Owners";
                        $arrResponse['chartTitle'] = $arrPortalDet[$intPortalId] . " Portal Active Owners";
                    } else {
                        $arrResponse['graphsearieslabel'] = "All Portal Active Owners";
                        $arrResponse['graphsearies'] = "Portal Active Owners";
                        $arrResponse['chartTitle'] = "Portal Active Owners";
                    }

                    $arrResponse['graphseariesvalue'] = count($arrPortalOwnerList);

                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "4") {
                    $this->loadModel('Portal');
                    $this->loadModel('PortalUser');
                    $this->loadModel('User');
                    if ($intPortalId != 'all') {
                        $arrPortalList = $this->Portal->find('all', array('fields' => array('career_portal_id', 'career_portal_name', 'career_portal_created_by'), 'conditions' => array('career_portal_published' => '1', 'career_portal_id' => $intPortalId)));
                    }
                    $arrResponse['chartTitle'] = "Portal Inactive Owners Statistics";
                    $portalOwner = $arrPortalList[0]['Portal']['career_portal_created_by'];
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
                                $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId, $strStartDate, $strEndDate, $portalOwner, $status = '0');
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId, $series, $strToDate, $portalOwner, $status = '0');
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId, $series, $strToDate, $portalOwner, $status = '0');
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrPortalOwnerList) > 0) {
                                $strSeriesDataValue .= (count($arrPortalOwnerList)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'inactiveportalownerslist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        if ($intPortalId) {
                            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
                            $arrResponse['dataseries'] = $arrPortalDet[$intPortalId] . rtrim(" Portal Inactive Owners:" . count($arrPortalOwnerList));
                        } else {
                            $arrResponse['dataseries'] = rtrim("Portal Inactive Owners:" . count($arrPortalOwnerList));
                        }
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        if ($intPortalId) {
                            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
                            $arrResponse['dataseries'] = $arrPortalDet[$intPortalId] . rtrim(" Portal Inactive Owners Owners:" . $strSeriesDataValue);
                        } else {
                            $arrResponse['dataseries'] = rtrim("Portal Inactive Owners:" . $strSeriesDataValue);
                        }
                    }
                    if ($intPortalId) {
                        $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
                        $arrResponse['graphsearieslabel'] = $arrPortalDet[$intPortalId] . " Portal Inactive Owners";
                        $arrResponse['graphsearies'] = $arrPortalDet[$intPortalId] . " Portal Inactive Owners";
                        $arrResponse['chartTitle'] = $arrPortalDet[$intPortalId] . " Portal Inactive Owners";
                    } else {
                        $arrResponse['graphsearieslabel'] = "All Portal Inactive Owners";
                        $arrResponse['graphsearies'] = "Portal Inactive Owners";
                        $arrResponse['chartTitle'] = "Portal Inactive Owners";
                    }

                    $arrResponse['graphseariesvalue'] = count($arrPortalOwnerList);

                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "5") {
                    $arrResponse['chartTitle'] = "Active Job Seekers";
                    $this->loadModel('PortalUser');
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

                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'activejobseekerlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
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
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'inactivejobseekerlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);

                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " Inactive Job Seekers:" . count($arrPortalUserList));
                        $arrResponse['graphseariesvalue'] = count($arrPortalUserList);
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " Inactive Job Seekers:" . $strSeriesDataValue);
                        $arrResponse['graphseariesvalue'] = $total;
                    }

                    $arrResponse['status'] = "success";

                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "7") {
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
                            $total += (count($arrJobSeeker15StepCompletedList));
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
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'registered15processcompleted'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " 15 Steps Completed Job Seekers:" . count($arrJobSeeker15StepCompletedList));
                        $arrResponse['graphseariesvalue'] = count($arrJobSeeker15StepCompletedList);
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " 15 Steps Completed Job Seekers:" . $strSeriesDataValue);
                        $arrResponse['graphseariesvalue'] = $total;
                    }

                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    $arrResponse['status'] = "success";

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "8") {
//                     Configure::write('debug', '2');
                    if ($productType != '' || $productType != 'all') {
                        $arrResponse['chartTitle'] = "Job Seekers Total Refunded Purchased " . $productType;
                    } else {
                        $arrResponse['chartTitle'] = "Job Seekers Total Refunded Purchased Products,Services Or Courses";
                    }

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
                        foreach ($arrSeries as $k => $series) {
                            if ($strPeriod == 'curr_year') {
                                $strStartDate = date('Y-01-01');
                                $strEndDate = date('Y-m-d');
                                if ($intPortalId == 'all') {
                                    $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminRefundedOrder($strStartDate, $strEndDate, $productType, $datePeriod = "YEAR", $intPortalId = "");
                                } else {
                                    $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminRefundedOrder($strStartDate, $strEndDate, $productType, $datePeriod = "YEAR", $intPortalId);
                                }
//                                $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminRefundedOrder($strStartDate, $strEndDate, $productType, $datePeriod = "YEAR");
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all') {
                                    $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminRefundedOrder($series, $strToDate, $productType, $datePeriod = "MONTH", $intPortalId = "");
                                } else {
                                    $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminRefundedOrder($series, $strToDate, $productType, $datePeriod = "MONTH", $intPortalId);
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminRefundedOrder($series, $strToDate, $productType, $datePeriod = "DATE", $intPortalId = "");
                                } else {
                                    $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminRefundedOrder($series, $strToDate, $productType, $datePeriod = "DATE", $intPortalId);
                                }
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrJobSeekerPurchaseOrderList) > 0) {
                                $strSeriesDataValue .= round($arrJobSeekerPurchaseOrderList[0][0]['total']) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                            $strTotal += $arrJobSeekerPurchaseOrderList[0][0]['total'];
                        }
                    } else {
                        if ($intPortalId == 'all') {
                            $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminRefundedOrder($strStartDate = "", $strEndDate = "", $productType, $datePeriod = "DATE", $intPortalId = "");
                        } else {
                            $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminRefundedOrder($strStartDate = "", $strEndDate = "", $productType, $datePeriod = "DATE", $intPortalId);
                        }
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

                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'refundorderlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&productType=" . base64_encode($productType) . "&datePeriod=" . base64_encode($strPeriod);
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " Purchase Orders:" . round($arrJobSeekerPurchaseOrderList[0][0]['total']));
                        $arrResponse['graphseariesvalue'] = "$" . ($arrJobSeekerPurchaseOrderList[0][0]['total']);
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " Purchase Orders:" . $strSeriesDataValue);
                        $arrResponse['graphseariesvalue'] = "$" . ($strTotal);
                    }

                    $arrResponse['status'] = "success";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;
                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "9") {
//                     Configure::write('debug', '2');
                    if ($productType != '' || $productType != 'all') {
                        $arrResponse['chartTitle'] = "Job Seekers Total Sale Purchased " . $productType;
                    } else {
                        $arrResponse['chartTitle'] = "Job Seekers Total Sale Purchased Products,Services Or Courses";
                    }
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
                        foreach ($arrSeries as $k => $series) {
                            if ($strPeriod == 'curr_year') {
                                $strStartDate = date('Y-01-01');
                                $strEndDate = date('Y-m-d');
                                if ($intPortalId == 'all') {
                                    $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminPurchasedOrder($strStartDate, $strEndDate, $productType, $datePeriod = "YEAR", $intPortalId = "");
                                } else {
                                    $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminPurchasedOrder($strStartDate, $strEndDate, $productType, $datePeriod = "YEAR", $intPortalId);
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all') {
                                    $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminPurchasedOrder($series, $strToDate, $productType, $datePeriod = "MONTH", $intPortalId = "");
                                } else {
                                    $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminPurchasedOrder($series, $strToDate, $productType, $datePeriod = "MONTH", $intPortalId);
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminPurchasedOrder($series, $strToDate, $productType, $datePeriod = "DATE", $intPortalId = "");
                                } else {
                                    $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminPurchasedOrder($series, $strToDate, $productType, $datePeriod = "DATE", $intPortalId);
                                }
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrJobSeekerPurchaseOrderList) > 0) {
                                $strSeriesDataValue .= round($arrJobSeekerPurchaseOrderList[0][0]['total']) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                            $strTotal += $arrJobSeekerPurchaseOrderList[0][0]['total'];
                        }
                    } else {
                        if ($intPortalId == 'all') {
                            $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminPurchasedOrder($strStartDate = "", $strEndDate = "", $productType, $datePeriod = "DATE", $intPortalId = "");
                        } else {
                            $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminPurchasedOrder($strStartDate = "", $strEndDate = "", $productType, $datePeriod = "DATE", $intPortalId);
                        }
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

                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'jobseekerspurchasedorder'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&productType=" . base64_encode($productType) . "&datePeriod=" . base64_encode($strPeriod);
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " Sale Purchase Orders:" . round($arrJobSeekerPurchaseOrderList[0][0]['total']));
                        $arrResponse['graphseariesvalue'] = "$" . ($arrJobSeekerPurchaseOrderList[0][0]['total']);
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim($arrPortalDet[$intPortalId] . " Sale Purchase Orders:" . $strSeriesDataValue);
                        $arrResponse['graphseariesvalue'] = "$" . ($strTotal);
                    }

                    $arrResponse['status'] = "success";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;
                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "10") {
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
                                if ($intPortalId == 'all') {
                                    $arrJobSeekerTheme1RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId = "", $strStartDate, $strEndDate, $strThemeName = "THEME-DESIGN-1");
                                    $arrJobSeekerTheme2RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId = "", $strStartDate, $strEndDate, $strThemeName = "THEME-DESIGN-2");
                                    $arrJobSeekerTheme3RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId = "", $strStartDate, $strEndDate, $strThemeName = "THEME-DESIGN-3");
                                } else {
                                    $arrJobSeekerTheme1RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $strStartDate, $strEndDate, $strThemeName = "THEME-DESIGN-1");
                                    $arrJobSeekerTheme2RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $strStartDate, $strEndDate, $strThemeName = "THEME-DESIGN-2");
                                    $arrJobSeekerTheme3RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $strStartDate, $strEndDate, $strThemeName = "THEME-DESIGN-3");
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == "all") {
                                    $arrJobSeekerTheme1RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId = "", $series, $strToDate, $strThemeName = "THEME-DESIGN-1");
                                    $arrJobSeekerTheme2RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId = "", $series, $strToDate, $strThemeName = "THEME-DESIGN-2");
                                    $arrJobSeekerTheme3RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId = "", $series, $strToDate, $strThemeName = "THEME-DESIGN-3");
                                } else {
                                    $arrJobSeekerTheme1RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $series, $strToDate, $strThemeName = "THEME-DESIGN-1");
                                    $arrJobSeekerTheme2RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $series, $strToDate, $strThemeName = "THEME-DESIGN-2");
                                    $arrJobSeekerTheme3RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $series, $strToDate, $strThemeName = "THEME-DESIGN-3");
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == "all") {
                                    $arrJobSeekerTheme1RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId = "", $series, $strToDate, $strThemeName = "THEME-DESIGN-1");
                                    $arrJobSeekerTheme2RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId = "", $series, $strToDate, $strThemeName = "THEME-DESIGN-2");
                                    $arrJobSeekerTheme3RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId = "", $series, $strToDate, $strThemeName = "THEME-DESIGN-3");
                                } else {
                                    $arrJobSeekerTheme1RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $series, $strToDate, $strThemeName = "THEME-DESIGN-1");
                                    $arrJobSeekerTheme2RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $series, $strToDate, $strThemeName = "THEME-DESIGN-2");
                                    $arrJobSeekerTheme3RegisterList = $this->User->fnGetJobSeekerThemeRegister($intPortalId, $series, $strToDate, $strThemeName = "THEME-DESIGN-3");
                                }
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

                        $strAjaxPortalTheme1StatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'themeregisterlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&theme=THEME-DESIGN-1";
                        $strAjaxPortalTheme2StatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'themeregisterlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&theme=THEME-DESIGN-2";
                        $strAjaxPortalTheme3StatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'themeregisterlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&theme=THEME-DESIGN-3";

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

                        $strAjaxPortalTheme1StatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'themeregisterlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&theme=THEME-DESIGN-1";
                        $strAjaxPortalTheme2StatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'themeregisterlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&theme=THEME-DESIGN-2";
                        $strAjaxPortalTheme3StatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'themeregisterlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&theme=THEME-DESIGN-3";

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

                if ($strStatRequestId == "11") {
                    $arrResponse['chartTitle'] = "New Portals bought and purchased Statistics";
                    $this->loadModel('PortalUser');
                    $this->loadModel('PortalDomain');
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
                        foreach ($arrSeries as $series) {
                            if ($strPeriod == 'curr_year') {
                                if ($intPortalId == 'all') {
                                    $arrPortalList = $this->PortalDomain->find('all', array('conditions' => array('career_portal_purchased_date >=' => $strStartDate, 'career_portal_purchased_date <=' => $strEndDate)));
                                } else {
                                    $arrPortalList = $this->PortalDomain->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'career_portal_purchased_date >=' => $strStartDate, 'career_portal_purchased_date <=' => $strEndDate)));
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all') {
                                    $arrPortalList = $this->PortalDomain->find('all', array('conditions' => array('career_portal_purchased_date >=' => $series, 'career_portal_purchased_date <=' => $strToDate)));
                                } else {
                                    $arrPortalList = $this->PortalDomain->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'career_portal_purchased_date >=' => $series, 'career_portal_purchased_date <=' => $strToDate)));
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrPortalList = $this->PortalDomain->find('all', array('conditions' => array('career_portal_purchased_date >=' => $series, 'career_portal_purchased_date <' => $strToDate)));
                                } else {
                                    $arrPortalList = $this->PortalDomain->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'career_portal_purchased_date >=' => $series, 'career_portal_purchased_date <' => $strToDate)));
                                }
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrPortalList) > 0) {
                                $strSeriesDataValue .= (count($arrPortalList)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }

                            $strTotal += (count($arrPortalList));
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'newportalsboughtandpurchasedlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("New Portals bought and purchased Statistics:" . count($arrPortalList));
                        $arrResponse['graphseariesvalue'] = count($arrPortalList);
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim(" New Portals bought and purchased Statistics:" . $strSeriesDataValue);
                        $arrResponse['graphseariesvalue'] = $strTotal;
                    }
                    $arrResponse['graphsearies'] = "New Portals bought and purchased Statistics";
                    $arrResponse['graphsearieslabel'] = "New Portals bought and purchased Statistics";

                    $arrResponse['chartTitle'] = "New Portals bought and purchased Statistics";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "12") {
                    $arrResponse['chartTitle'] = "Career Portal Sales Cost Statistics";
                    $this->loadModel('PortalUser');
                    $this->loadModel('PortalDomain');
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
                        foreach ($arrSeries as $series) {
                            if ($strPeriod == 'curr_year') {
                                if ($intPortalId == 'all') {
                                    $arrPortalList = $this->PortalDomain->fnGetPortalDomainCost($strStartDate, $strEndDate, $intPortalId = "", $datePeriod = "YEAR");
                                } else {
                                    $arrPortalList = $this->PortalDomain->fnGetPortalDomainCost($strStartDate, $strEndDate, $intPortalId, $datePeriod = "YEAR");
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all') {
                                    $arrPortalList = $this->PortalDomain->fnGetPortalDomainCost($series, $strToDate, $intPortalId = "", $datePeriod = "MONTH");
                                } else {
                                    $arrPortalList = $this->PortalDomain->fnGetPortalDomainCost($series, $strToDate, $intPortalId, $datePeriod = "MONTH");
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrPortalList = $this->PortalDomain->fnGetPortalDomainCost($series, $strToDate, $intPortalId = "", $datePeriod = "DATE");
                                } else {
                                    $arrPortalList = $this->PortalDomain->fnGetPortalDomainCost($series, $strToDate, $intPortalId, $datePeriod = "DATE");
                                }
                            }
                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrPortalList) > 0) {
                                $strSeriesDataValue .= $arrPortalList[0][0]['total'] . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }

                            $strTotal += $arrPortalList[0][0]['total'];
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'portalssalescostlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Career Portal Sales Cost Statistics:" . $arrPortalList[0][0]['total']);
                        $arrResponse['graphseariesvalue'] = "$ " . $arrPortalList[0][0]['total'];
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Career Portal Sales Cost Statistics:" . $strSeriesDataValue);
                        $arrResponse['graphseariesvalue'] = "$ " . $strTotal;
                    }
                    $arrResponse['graphsearies'] = "Career Portal Sales Cost Statistics";
                    $arrResponse['graphsearieslabel'] = "Career Portal Sales Cost Statistics";

                    $arrResponse['chartTitle'] = "Career Portal Sales Cost Statistics";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "13") {
                    $arrResponse['chartTitle'] = "Total Refunds Provided";

                    $this->loadModel('Resourceorderdetail');
                    $this->loadModel('Vendors');
                    $this->loadModel('Portal');

                    $arrVendorDetails = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $strVendor)));
                    $intVendorId = $arrVendorDetails[0]['Vendors']['parent_vendor'];
                    if ($strVendor) {
                        $parent_vendor = $strVendor;
                        $intVendorId = $strVendor;
                    }

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
                        foreach ($arrSeries as $k => $series) {
                            if ($strPeriod == 'curr_year') {
                                if ($intVendorId == '') {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetRefundOrderAmount($arrVendor = "", $strStartDate, $strEndDate, $datePeriod = "YEAR");
                                } else {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalRefundOrderAmount($intVendorId, $strStartDate, $strEndDate, $datePeriod = "YEAR");
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalRefundOrderAmount($intVendorId, $series, $strToDate, $datePeriod = "MONTH");
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalRefundOrderAmount($intVendorId, $series, $strToDate, $datePeriod = "DATE");
                            }
                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrNewOrders) > 0) {
                                $strSeriesDataValue .= $arrNewOrders[$k][0]['refundTotal'] . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                                $strTotal = "0";
                            }
                            $strTotal = $strTotal + $arrNewOrders[$k][0]['refundTotal'];
                        }
                        $arrResponse['graphseariesvalue'] = isset($strTotal) ? "$ " . $strTotal : '$ 0.00';
                    } else {
                        $strStartDate = date('Y-') . '01-01';
                        $strEndDate = date('Y-m-d', strtotime("+1 days"));
                        if ($strVendor == '') {
                            $arrNewOrders = $this->Resourceorderdetail->fnGetRefundOrderAmount($arrVendor = "", $strStartDate, $strEndDate, $datePeriod = "DATE");
                        } else {
                            $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalRefundOrderAmount($intVendorId, $strStartDate, $strEndDate, $datePeriod = "DATE");
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
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'totalrefundeachvendorlist'), true) . "?Vendor=" . base64_encode($strVendor) . "&portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Total Refunds Provided :" . $strTotal);
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

                if ($strStatRequestId == "14") {

                    $this->loadModel('Resourceorderdetail');
                    $this->loadModel('Vendors');
                    $this->loadModel('Portal');

                    $arrResponse['chartTitle'] = "Total Sale Vendor";
                    $arrVendorDetails = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $strVendor)));
                    $intVendorId = $arrVendorDetails[0]['Vendors']['parent_vendor'];

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
                        foreach ($arrSeries as $k => $series) {
                            if ($strPeriod == 'curr_year') {
                                if ($intPortalId == 'all') {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmount($intVendorId, $strStartDate, $strEndDate, $datePeriod = "YEAR", $intPortalId = "");
                                } else {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmount($intVendorId, $strStartDate, $strEndDate, $datePeriod = "YEAR", $intPortalId);
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all') {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmount($intVendorId, $series, $strToDate, $datePeriod = "MONTH", $intPortalId = "");
                                } else {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmount($intVendorId, $series, $strToDate, $datePeriod = "MONTH", $intPortalId);
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmount($intVendorId, $series, $strToDate, $datePeriod = "DATE", $intPortalId = "");
                                } else {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmount($intVendorId, $series, $strToDate, $datePeriod = "DATE", $intPortalId);
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
                                $strSeriesDataValue .= $arrNewOrders[$k][0]['amount'] . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                                $strTotal = "0";
                            }
                            $strTotal = $strTotal + $arrNewOrders[$k][0]['amount'];
                        }
                        $arrResponse['graphseariesvalue'] = isset($strTotal) ? "$ " . $strTotal : '$ 0.00';
                    } else {
                        $strStartDate = date('Y-') . '01-01';
                        $strEndDate = date('Y-m-d', strtotime("+1 days"));
                        if ($intPortalId == 'all') {
                            $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmount($intVendorId, $strStartDate = "", $strEndDate = "", $datePeriod = "DATE", $intPortalId = "");
                        } else {
                            $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmount($intVendorId, $strStartDate = "", $strEndDate = "", $datePeriod = "DATE", $intPortalId);
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
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'totalsaleeachvendorlist'), true) . "?Vendor=" . base64_encode($intVendorId) . "&subVendor=" . base64_encode($strVendor) . "&portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Total Sale Vendor :" . $strTotal);
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Total Sale Vendor :" . $strSeriesDataValue);
                    }
                    $arrResponse['graphsearies'] = "Total Sale Vendor Report";
                    $arrResponse['graphsearieslabel'] = "Total Sale Vendor Report";

                    $arrResponse['chartTitle'] = "Total Sale Vendor Report";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "15") {
                    $arrResponse['chartTitle'] = "Last Login Job Seekers Statistics";
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
                                $strEndDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('last_login_date >=' => $strStartDate, 'last_login_date <=' => $strEndDate)));
                                } else {
                                    $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'last_login_date >=' => $strStartDate, 'last_login_date <=' => $strEndDate)));
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all') {
                                    $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('last_login_date >=' => $series, 'last_login_date <=' => $strToDate)));
                                } else {
                                    $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'last_login_date >=' => $series, 'last_login_date <=' => $strToDate)));
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('last_login_date >=' => $series, 'last_login_date <=' => $strToDate)));
                                } else {
                                    $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'last_login_date >=' => $series, 'last_login_date <=' => $strToDate)));
                                }
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
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'lastloginjobseekerlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Last Login Job Seekers Statistics:" . count($arrPortalUserList));
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Last Login Job Seekers Statistics:" . $strSeriesDataValue);
                    }
                    $arrResponse['graphsearies'] = "Last Login Job Seekers Statistics";
                    $arrResponse['graphsearieslabel'] = "Last Login Job Seekers Statistics";
                    $arrResponse['graphseariesvalue'] = count($arrPortalUserList);
                    $arrResponse['chartTitle'] = "Last Login Job Seekers Statistics";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "16") {
                    $arrResponse['chartTitle'] = "Utilizing The CRM Job Seekers";
                    $this->loadModel('JobStatistics');
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
                                $strStartDate = date("Y-m-d", strtotime($strStartDate)) . " 00:00:00";
                                $strEndDate = date("Y-m-d", strtotime($strEndDate)) . " 23:59:59";
//                                $strEndDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingCRM($strStartDate, $strEndDate, $intPortalId = "");
                                } else {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingCRM($strStartDate, $strEndDate, $intPortalId);
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all') {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingCRM($series, $strToDate, $intPortalId = "");
                                } else {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingCRM($series, $strToDate, $intPortalId);
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingCRM($series, $strToDate, $intPortalId = "");
                                } else {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingCRM($series, $strToDate, $intPortalId);
                                }
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrJobsViews) > 0) {
                                $strSeriesDataValue .= (count($arrJobsViews)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'utilizingthecrmjobseekerlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Utilizing The CRM Job Seekers Statistics:" . count($arrJobsViews));
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Utilizing The CRM Job Seekers Statistics:" . $strSeriesDataValue);
                    }
                    $arrResponse['graphsearies'] = "Utilizing The CRM Job Seekers Statistics";
                    $arrResponse['graphsearieslabel'] = "Utilizing The CRM Job Seekers Statistics";
                    $arrResponse['graphseariesvalue'] = count($arrJobsViews);
                    $arrResponse['chartTitle'] = "Utilizing The CRM Job Seekers Statistics";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "17") {
                    $arrResponse['chartTitle'] = "Job Boards Using Job Seekers";
                    $this->loadModel('JobStatistics');
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
                                $strStartDate = date("Y-m-d", strtotime($strStartDate)) . " 00:00:00";
                                $strEndDate = date("Y-m-d", strtotime($strEndDate)) . " 23:59:59";
                                if ($intPortalId == 'all') {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingJobBoard($strStartDate, $strEndDate, $intPortalId = "");
                                } else {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingJobBoard($strStartDate, $strEndDate, $intPortalId);
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all') {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingJobBoard($series, $strToDate, $intPortalId = "");
                                } else {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingJobBoard($series, $strToDate, $intPortalId);
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerClickJobs($series, $strToDate, $intPortalId = "");
                                } else {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerClickJobs($series, $strToDate, $intPortalId);
                                }
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrJobsViews) > 0) {
                                $strSeriesDataValue .= (count($arrJobsViews)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'jobboardsusingjobseekerlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Job Boards Using Job Seekers Statistics:" . count($arrJobsViews));
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Job Boards Using Job Seekers Statistics:" . $strSeriesDataValue);
                    }
                    $arrResponse['graphsearies'] = "Job Boards Using Job Seekers Statistics";
                    $arrResponse['graphsearieslabel'] = "Job Boards Using Job Seekers Statistics";
                    $arrResponse['graphseariesvalue'] = count($arrJobsViews);
                    $arrResponse['chartTitle'] = "Job Boards Using Job Seekers Statistics";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "18") {
//                     Configure::write('debug', '2');
                    $arrResponse['chartTitle'] = "Owners Jobs Posted Clicking Job Seekers";
                    $this->loadModel('JobStatistics');
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
                                $strStartDate = date("Y-m-d", strtotime($strStartDate)) . " 00:00:00";
                                $strEndDate = date("Y-m-d", strtotime($strEndDate)) . " 23:59:59";
//                                $strEndDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerClickJobs($strStartDate, $strEndDate, $intPortalId = "");
                                } else {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerClickJobs($strStartDate, $strEndDate, $intPortalId);
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all') {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerClickJobs($series, $strToDate, $intPortalId = "");
                                } else {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerClickJobs($series, $strToDate, $intPortalId);
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerClickJobs($series, $strToDate, $intPortalId = "");
                                } else {
                                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerClickJobs($series, $strToDate, $intPortalId);
                                }
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrJobsViews) > 0) {
                                $strSeriesDataValue .= (count($arrJobsViews)) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                            }
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'jobspostedviewjobseekerlist'), true) . "?portalId=" . $intPortalId . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Owners Jobs Posted Clicking Job Seekers Statistics:" . count($arrJobsViews));
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Owners Jobs Posted Clicking Job Seekers Statistics:" . $strSeriesDataValue);
                    }
                    $arrResponse['graphsearies'] = "Owners Jobs Posted Clicking Job Seekers Statistics";
                    $arrResponse['graphsearieslabel'] = "Owners Jobs Posted Clicking Job Seekers Statistics";
                    $arrResponse['graphseariesvalue'] = count($arrJobsViews);
                    $arrResponse['chartTitle'] = "Owners Jobs Posted Clicking Job Seekers Statistics";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "19") {
                    $this->loadModel('Resourceorderdetail');
                    $arrResponse['chartTitle'] = "New Vendors Added Career Portal";
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
                        foreach ($arrSeries as $k => $series) {
                            if ($strPeriod == 'curr_year') {
                                if ($intPortalId == 'all') {
                                    $arrNewVendors = $this->Resourceorderdetail->fnGetNewVendorAdded($strStartDate, $strEndDate, $intPortalId);
                                } else {
                                    $arrNewVendors = $this->Resourceorderdetail->fnGetNewVendorAdded($strStartDate, $strEndDate, $intPortalId);
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all') {
                                    $arrNewVendors = $this->Resourceorderdetail->fnGetNewVendorAdded($series, $strToDate, $intPortalId);
                                } else {
                                    $arrNewVendors = $this->Resourceorderdetail->fnGetNewVendorAdded($series, $strToDate, $intPortalId);
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrNewVendors = $this->Resourceorderdetail->fnGetNewVendorAdded($series, $strToDate, $intPortalId);
                                } else {
                                    $arrNewVendors = $this->Resourceorderdetail->fnGetNewVendorAdded($series, $strToDate, $intPortalId);
                                }
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrNewVendors) > 0) {
                                $strSeriesDataValue .= count($arrNewVendors) . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                                $strTotal = "0";
                            }
                            $strTotal = $strTotal + count($arrNewVendors);
                        }
                    } else {
                        $strStartDate = date('Y-') . '01-01';
                        $strEndDate = date('Y-m-d', strtotime("+1 days"));
                        if ($intPortalId == 'all') {
                            $arrNewVendors = $this->Resourceorderdetail->fnGetNewVendorAdded($strStartDate, $strEndDate, $intPortalId = "");
                        } else {
                            $arrNewVendors = $this->Resourceorderdetail->fnGetNewVendorAdded($strStartDate, $strEndDate, $intPortalId);
                        }
                        if (count($arrNewOrders) > 0) {
                            foreach ($arrNewOrders as $k => $NewOrders) {
                                if (count($NewOrders) > 0) {
                                    $strSeriesDataValue .= count($arrNewVendors) . ",";
                                    $strTotal = $strTotal + count($arrNewVendors);
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
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'newvendorslist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("New Vendors Added Career Portal :" . count($arrNewVendors));
                        $arrResponse['graphseariesvalue'] = count($arrNewVendors);
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("New Vendors Added Career Portal :" . $strSeriesDataValue);
                        $arrResponse['graphseariesvalue'] = isset($strTotal) ? $strTotal : '0';
                    }
                    $arrResponse['graphsearies'] = "New Vendors Added Career Portal Report";
                    $arrResponse['graphsearieslabel'] = "New Vendors Added Career Portal Report";

                    $arrResponse['chartTitle'] = "New Vendors Added Career Portal Report";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "20") {
                    $this->loadModel('PayoutPaymentDetails');
                    $this->loadModel('Vendors');

                    $arrVendorDetails = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $strVendor)));
                    $intVendorId = $arrVendorDetails[0]['Vendors']['parent_vendor'];
                    if ($strVendorCompany) {
                        $parent_vendor = $strVendorCompany;
                        $intVendorId = $strVendorCompany;
                    }

                    $arrResponse['chartTitle'] = "Total Amount Paid To Vendor Companies";
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
                        foreach ($arrSeries as $k => $series) {
                            if ($strPeriod == 'curr_year') {
                                if ($intPortalId == 'all') {
                                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetVendorPaidPayoutGraphCount($intVendorId, $strStartDate, $strEndDate, $intPortalId = "all");
                                } else {
                                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetVendorPaidPayoutGraphCount($intVendorId, $strStartDate, $strEndDate, $intPortalId = "all");
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all') {
                                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetVendorPaidPayoutGraphCount($intVendorId, $series, $strToDate, $intPortalId = "all");
                                } else {
                                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetVendorPaidPayoutGraphCount($intVendorId, $series, $strToDate, $intPortalId = "all");
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetVendorPaidPayoutGraphCount($intVendorId, $series, $strToDate, $intPortalId = "all");
                                } else {
                                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetVendorPaidPayoutGraphCount($intVendorId, $series, $strToDate, $intPortalId = "all");
                                }
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if ($arrTotalPaid['0']['0']['amount'] != '') {
                                $strSeriesDataValue .= round($arrTotalPaid['0']['0']['amount']) . ",";
                            } else {
                                $strSeriesDataValue .= "0.00,";
                                $strTotal += "0.00";
                            }

                            $strTotal += round($arrTotalPaid['0']['0']['amount']);
                        }
                    } else {
                        $strStartDate = date('Y-') . '01-01';
                        $strEndDate = date('Y-m-d', strtotime("+1 days"));
                        if ($intPortalId == 'all') {
                            $arrTotalPaid = $this->PayoutPaymentDetails->fnGetVendorPaidPayoutGraphCount($intVendorId, $strStartDate, $strEndDate, $intPortalId = "all");
                        } else {
                            $arrTotalPaid = $this->PayoutPaymentDetails->fnGetVendorPaidPayoutGraphCount($intVendorId, $strStartDate, $strEndDate, $intPortalId = "all");
                        }
                        if (count($arrTotalPaid) > 0) {
                            foreach ($arrTotalPaid as $k => $TotalPaid) {
                                if (count($NewOrders) > 0) {
                                    $strSeriesDataValue .= $TotalPaid['0']['0']['amount'] . ",";
                                    $strTotal = $strTotal + $TotalPaid['0']['0']['amount'];
                                } else {
                                    $strSeriesDataValue .= "0.00,";
                                    $strTotal = "0.00";
                                }
                            }
                            $strSeriesData .= date("Y");
                            $strSeriesDataValue .= $strTotal;
                        } else {
                            $strSeriesData .= date("Y");
                            $strSeriesDataValue .= "0.00,";
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'paidpayoutlist'), true) . "?portalId=" . base64_encode("all") . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&vendorId=" . base64_encode($intVendorId) . "&payoutFor=vendor";
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Total Paid Amount Vendor Companies :" . $arrTotalPaid['0']['0']['amount']);
                        $arrResponse['graphseariesvalue'] = isset($arrTotalPaid['0']['0']['amount']) ? "$" . $arrTotalPaid['0']['0']['amount'] : '$0.00';
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Total Paid Amount Vendor Companies :" . $strSeriesDataValue);
                        $arrResponse['graphseariesvalue'] = isset($strTotal) ? "$" . $strTotal . ".00" : '$0.00';
                    }
                    $arrResponse['graphsearies'] = "Total Paid Amount Vendor Companies Report";
                    $arrResponse['graphsearieslabel'] = "Total Paid Amount Vendor Companies Report";

                    $arrResponse['chartTitle'] = "Total Paid Amount Vendor Companies";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "21") {
                    $this->loadModel('PayoutPaymentDetails');
                    $this->loadModel('Vendors');

                    $arrResponse['chartTitle'] = "Total Amount Paid To Portal Owner";
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
                        foreach ($arrSeries as $k => $series) {
                            if ($strPeriod == 'curr_year') {
                                if ($intPortalId == 'all') {
                                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetOwnerPaidPayoutGraphCount($intOwnerId, $strStartDate, $strEndDate, $intPortalId = "");
                                } else {
                                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetOwnerPaidPayoutGraphCount($intOwnerId, $strStartDate, $strEndDate, $intPortalId = "all");
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all') {
                                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetOwnerPaidPayoutGraphCount($intOwnerId, $series, $strToDate, $intPortalId = "");
                                } else {
                                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetOwnerPaidPayoutGraphCount($intOwnerId, $series, $strToDate, $intPortalId = "all");
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetOwnerPaidPayoutGraphCount($intOwnerId, $series, $strToDate, $intPortalId = "");
                                } else {
                                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetOwnerPaidPayoutGraphCount($intOwnerId, $series, $strToDate, $intPortalId = "all");
                                }
                            }

                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if ($arrTotalPaid['0']['0']['amount'] != '') {
                                $strSeriesDataValue .= round($arrTotalPaid['0']['0']['amount']) . ",";
                            } else {
                                $strSeriesDataValue .= "0.00,";
                                $strTotal += "0.00";
                            }

                            $strTotal += round($arrTotalPaid['0']['0']['amount']);
                        }
                    } else {
                        $strStartDate = date('Y-') . '01-01';
                        $strEndDate = date('Y-m-d', strtotime("+1 days"));
                        if ($intPortalId == 'all') {
                            $arrTotalPaid = $this->PayoutPaymentDetails->fnGetOwnerPaidPayoutGraphCount($intOwnerId, $strStartDate, $strEndDate, $intPortalId = "");
                        } else {
                            $arrTotalPaid = $this->PayoutPaymentDetails->fnGetOwnerPaidPayoutGraphCount($intOwnerId, $strStartDate, $strEndDate, $intPortalId = "all");
                        }
                        if (count($arrTotalPaid) > 0) {
                            foreach ($arrTotalPaid as $k => $TotalPaid) {
                                if (count($NewOrders) > 0) {
                                    $strSeriesDataValue .= $TotalPaid['0']['0']['amount'] . ",";
                                    $strTotal = $strTotal + $TotalPaid['0']['0']['amount'];
                                } else {
                                    $strSeriesDataValue .= "0.00,";
                                    $strTotal = "0.00";
                                }
                            }
                            $strSeriesData .= date("Y");
                            $strSeriesDataValue .= $strTotal;
                        } else {
                            $strSeriesData .= date("Y");
                            $strSeriesDataValue .= "0.00,";
                        }
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'paidpayoutlist'), true) . "?portalId=" . base64_encode("all") . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate) . "&ownerId=" . base64_encode($intOwnerId) . "&payoutFor=owner";
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Total Paid Amount Portal Owner :" . $arrTotalPaid['0']['0']['amount']);
                        $arrResponse['graphseariesvalue'] = isset($arrTotalPaid['0']['0']['amount']) ? "$" . $arrTotalPaid['0']['0']['amount'] : '$0.00';
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Total Paid Amount Portal Owner :" . $strSeriesDataValue);
                        $arrResponse['graphseariesvalue'] = isset($strTotal) ? "$" . $strTotal . ".00" : '$0.00';
                    }
                    $arrResponse['graphsearies'] = "Total Paid Amount Portal Owner Report";
                    $arrResponse['graphsearieslabel'] = "Total Paid Amount Portal Owner Report";

                    $arrResponse['chartTitle'] = "Total Paid Amount Portal Owner";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }

                if ($strStatRequestId == "22") {
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
                                $strEndDate = date('Y-m-d', strtotime("+1 days"));
                                if ($intPortalId == 'all' || $intPortalId == '') {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsCount($intPortalId = "all", $strStartDate, $strEndDate);
                                } else {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsCount($intPortalId, $strStartDate, $strEndDate);
                                }
//                                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'visitorslist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all' || $intPortalId == '') {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsCount($intPortalId = "all", $series, $strToDate);
                                } else {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsCount($intPortalId, $series, $strToDate);
                                }
//                                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'visitorslist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($series) . "&endDate=" . base64_encode($strToDate);
                            } else {

                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all' || $intPortalId == '') {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsCount($intPortalId = "all", $series, $strToDate);
                                } else {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsCount($intPortalId, $series, $strToDate);
                                }
//                                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'visitorslist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($series) . "&endDate=" . base64_encode($strToDate);
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
                        $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'visitorslist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    } else if ($strPeriod == '30') {
                        $strEndDate = date("Y-m-t", strtotime($series));
                        $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'visitorslist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    } else {
                        $strEndDate = date('Y-m-d', strtotime($series . "+1 days"));
                        $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'visitorslist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
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

                if ($strStatRequestId == "23") {
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
//                                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'visitorsregisterlist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all' || $intPortalId == '') {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsRegisteredCount($intPortalId = "all", $series, $strToDate);
                                } else {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsRegisteredCount($intPortalId, $series, $strToDate);
                                }
//                                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'visitorsregisterlist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($series) . "&endDate=" . base64_encode($strToDate);
                            } else {

                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all' || $intPortalId == '') {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsRegisteredCount($intPortalId = "all", $series, $strToDate);
                                } else {
                                    $arrTotalVisitors = $this->PortalVisitors->fnGetVisitorsRegisteredCount($intPortalId, $series, $strToDate);
                                }
//                                $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'visitorsregisterlist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($series) . "&endDate=" . base64_encode($strToDate);
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
                        $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'visitorsregisterlist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    } else if ($strPeriod == '30') {
                        $strEndDate = date("Y-m-t", strtotime($series));
                        $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'visitorsregisterlist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    } else {
                        $strEndDate = date('Y-m-d', strtotime($series . "+1 days"));
                        $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'visitorsregisterlist'), true) . "?portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
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
                
                if ($strStatRequestId == "24") {
                    $this->loadModel('Resourceorderdetail');
                    $this->loadModel('Portal');
                    $arrResponse['chartTitle'] = "Total Sale Portal Owner";
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
                        foreach ($arrSeries as $k => $series) {
                            if ($strPeriod == 'curr_year') {
                                if ($intPortalId == 'all') {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalPortalOwnerSaleOrderAmount($intOwnerId, $strStartDate, $strEndDate, $datePeriod = "YEAR", $intPortalId = "");
                                } else {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalPortalOwnerSaleOrderAmount($intOwnerId, $strStartDate, $strEndDate, $datePeriod = "YEAR", $intPortalId);
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                if ($intPortalId == 'all') {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalPortalOwnerSaleOrderAmount($intOwnerId, $series, $strToDate, $datePeriod = "MONTH", $intPortalId = "");
                                } else {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalPortalOwnerSaleOrderAmount($intOwnerId, $series, $strToDate, $datePeriod = "MONTH", $intPortalId);
                                }
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                if ($intPortalId == 'all') {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalPortalOwnerSaleOrderAmount($intOwnerId, $series, $strToDate, $datePeriod = "DATE", $intPortalId = "");
                                } else {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalPortalOwnerSaleOrderAmount($intOwnerId, $series, $strToDate, $datePeriod = "DATE", $intPortalId);
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
                                $strSeriesDataValue .= $arrNewOrders[$k][0]['amount'] . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                                $strTotal = "0";
                            }
                            $strTotal = $strTotal + $arrNewOrders[$k][0]['amount'];
                        }
                        $arrResponse['graphseariesvalue'] = isset($strTotal) ? "$" . $strTotal.".00" : '$ 0.00';
                    } else {
                        $strStartDate = date('Y-') . '01-01';
                        $strEndDate = date('Y-m-d', strtotime("+1 days"));
                        if ($intPortalId == 'all') {
                            $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalPortalOwnerSaleOrderAmount($intOwnerId, $strStartDate = "", $strEndDate = "", $datePeriod = "DATE", $intPortalId = "");
                        } else {
                            $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalPortalOwnerSaleOrderAmount($intOwnerId, $strStartDate = "", $strEndDate = "", $datePeriod = "DATE", $intPortalId);
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

                        $arrResponse['graphseariesvalue'] = isset($strTotal) ? "$" . $strTotal.".00" : '$ 0.00';
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'totalsaleeachportalownerlist'), true) . "?Owner=" . base64_encode($intOwnerId) . "&portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Total Sale Portal Owner :" . $strTotal);
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Total Sale Portal Owner :" . $strSeriesDataValue);
                    }
                    $arrResponse['graphsearies'] = "Total Sale Portal Owner Report";
                    $arrResponse['graphsearieslabel'] = "Total Sale Portal Owner Report";

                    $arrResponse['chartTitle'] = "Total Sale Portal Owner Report";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }
                
                if ($strStatRequestId == "25") {
                    $arrResponse['chartTitle'] = "Total Refunds Portal Owner";

                    $this->loadModel('Resourceorderdetail');
                    $this->loadModel('Vendors');
                    $this->loadModel('Portal');

                    $arrVendorDetails = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $strVendor)));
//                    $intVendorId = $arrVendorDetails[0]['Vendors']['parent_vendor'];
//                    if ($strVendor) {
//                        $parent_vendor = $strVendor;
//                        $intVendorId = $strVendor;
//                    }

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
                        foreach ($arrSeries as $k => $series) {
                            if ($strPeriod == 'curr_year') {
                                if ($intOwnerId == '') {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalPortalOwnerRefundOrderAmount($arrVendor = "", $strStartDate, $strEndDate, $datePeriod = "YEAR");
                                } else {
                                    $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalPortalOwnerRefundOrderAmount($intOwnerId, $strStartDate, $strEndDate, $datePeriod = "YEAR");
                                }
                            } else if ($strPeriod == '30') {
                                $date = explode("-", $series);
                                $strToDate = $date[0] . "-" . $date[1] . "-31";
                                $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalPortalOwnerRefundOrderAmount($intOwnerId, $series, $strToDate, $datePeriod = "MONTH");
                            } else {
                                $strToDate = date('Y-m-d', strtotime($series . "+1 days"));
                                $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalPortalOwnerRefundOrderAmount($intOwnerId, $series, $strToDate, $datePeriod = "DATE");
                            }
                            if ($strPeriod == 'curr_year') {
                                $strSeriesData .= date("Y");
                            } else if ($strPeriod == '30') {
                                $strSeriesData .= date("M y", strtotime($series)) . ",";
                            } else {
                                $strSeriesData .= date("jS M y", strtotime($series)) . ",";
                            }
                            if (count($arrNewOrders) > 0) {
                                $strSeriesDataValue .= $arrNewOrders[$k][0]['refundTotal'] . ",";
                            } else {
                                $strSeriesDataValue .= "0,";
                                $strTotal = "0";
                            }
                            $strTotal = $strTotal + $arrNewOrders[$k][0]['refundTotal'];
                        }
                        $arrResponse['graphseariesvalue'] = isset($strTotal) ? "$" . $strTotal.".00" : '$ 0.00';
                    } else {
                        $strStartDate = date('Y-') . '01-01';
                        $strEndDate = date('Y-m-d', strtotime("+1 days"));
                        if ($strVendor == '') {
                            $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalPortalOwnerRefundOrderAmount($arrVendor = "", $strStartDate, $strEndDate, $datePeriod = "DATE");
                        } else {
                            $arrNewOrders = $this->Resourceorderdetail->fnGetAdminTotalPortalOwnerRefundOrderAmount($intOwnerId, $strStartDate, $strEndDate, $datePeriod = "DATE");
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

                        $arrResponse['graphseariesvalue'] = isset($strTotal) ? "$" . $strTotal.".00" : '$ 0.00';
                    }

                    $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                    $strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'totalrefundeachportalownerlist'), true) . "?Owner=" . base64_encode($intOwnerId) . "&portalId=" . base64_encode($intPortalId) . "&startDate=" . base64_encode($strStartDate) . "&endDate=" . base64_encode($strEndDate);
                    $arrResponse['status'] = "success";
                    if ($strPeriod == 'curr_year') {
                        $arrResponse['xseries'] = date("Y");
                        $arrResponse['dataseries'] = rtrim("Total Refunds Portal Owner :" . $strTotal);
                    } else {
                        $str = implode(',', array_unique(explode(',', $strSeriesData)));
                        $arrResponse['xseries'] = rtrim($str, ",");
                        $arrResponse['dataseries'] = rtrim("Total Refunds Portal Owner :" . $strSeriesDataValue);
                    }
                    $arrResponse['graphsearies'] = "Total Refunds Portal Owner Report";
                    $arrResponse['graphsearieslabel'] = "Total Refunds Portal Owner Report";

                    $arrResponse['chartTitle'] = "Total Refunds Portal Owner Report";
                    $arrResponse['list_link'] = $strAjaxPortalStatsUrl;

                    echo json_encode($arrResponse);
                    exit;
                }
            }
        }
    }

    public function index() {
        $this->loadModel('Portal');
//        echo $this->layout;die;
        $arrPortalList = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_published' => '1')));
        /* print("<pre>");
          print_r($arrPortalList);
          exit; */
        $this->set('arrPortalList', $arrPortalList);
        $arrPortalEvents = array();
        if (is_array($arrPortalList) && (count($arrPortalList) > 0)) {
            foreach ($arrPortalList as $arrPortalKey => $arrPortalVal) {
                $arrPortalEvents[] = $arrPortalVal . " Registered Users";
            }
        }
        $this->loadModel('Vendors');
        $arrViewUserDetail = $this->Vendors->find('all', array('conditions' => array('parent_vendor !=' => '0')));
        $this->set("arrViewUserDetail", $arrViewUserDetail);

        $this->loadModel('Vendorcompany');
        $arrVendorDetail = $this->Vendorcompany->fnGetVendorCompanyName();
        $this->set("arrVendorDetail", $arrVendorDetail);

        $this->loadModel('User');
        $arrPortalOwnerDetail = $this->User->fnGetPortalOwnerName();
//        echo '<pre>';print_r($arrPortalOwnerDetail);die;
        $this->set("arrPortalOwnerDetail", $arrPortalOwnerDetail);

        //$arrPortalEvents = array("Monster","Naukri");
        /* $arrPortalEvents = array(
          "Monster Registered Users",
          "Naukri Logged In Users",
          /*"Monster Logged In Users",
          "Monster Logged Out Users",
          "Monster Confirmed Users",
          "Monster Basic Search",
          "Monster Advance Search" */
        /* "Naukri Logged In Users",
          "Naukri Logged Out Users",
          "Naukri Registered Users",
          "Naukri Confirmed Users" */
        /* ); */
        $compMixPanel = $this->Components->load('MixPanel');
        $objTrendsData = $compMixPanel->fnGetPortalTrends($arrPortalEvents);
        $arrCheckSeriesDataValues = (array) $objTrendsData->data->values;
        if (is_array($arrCheckSeriesDataValues) && (count($arrCheckSeriesDataValues) <= 0)) {
            $arrDfaultValueData = array();
            foreach ($arrPortalEvents as $strEvents) {
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
        /* print("<pre>");
          print_r($objTrendsData); */
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
        //echo rtrim($strSeriesData,",");
        $this->set('strSeriesLabelsValues', $strSeriesDataValue);
        $this->set('strSeriesLabels', rtrim($strSeriesData, ","));
        $this->set('arrPortals', $arrPortalEvents);
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
            /* print("<pre>");
              print_r($objPropertiesFilteredData);
              exit; */
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
                        //$strSeriesData .= "'".date("jS M y",strtotime($arrSeries))."',";
                    }
                    $arrDfaultValueData[$strEvents] = $arrDefaultSeriesData;
                }
                /* print("<pre>");
                  print_r($arrDfaultValueData); */
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
        if ($intPortalId) {
            $strEventPartName = $this->request->data['eventrequest'];
            $strEventFromDate = $this->request->data['frmdate'];
            $strEventToDate = $this->request->data['todate'];
            if ($intPortalId == "all") {
                $this->loadModel('Portal');
                $arrPortalList = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_published' => '1')));
                /* print("<pre>");
                  print_r($arrPortalList);
                  exit; */
                $arrEvents = array();
                if (is_array($arrPortalList) && (count($arrPortalList) > 0)) {
                    foreach ($arrPortalList as $arrPortalKey => $arrPortalVal) {
                        $arrEvents[] = $arrPortalVal . " " . $strEventPartName;
                        ;
                    }
                }
                $arrResponse['chartTitle'] = "Portals";
            } else {
                $intPortalExists = $this->Portal->find('count', array(
                    'conditions' => array('career_portal_id' => $intPortalId)
                ));
                if ($intPortalExists) {
                    $arrPortalDetail = $this->Portal->find('all', array(
                        'conditions' => array('career_portal_id' => $intPortalId)
                    ));
                    $strEventName = $arrPortalDetail[0]['Portal']['career_portal_name'];
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
                    $arrResponse['chartTitle'] = $arrPortalDetail[0]['Portal']['career_portal_name'];
                } else {
                    $arrResponse['status'] = "fail";
                }
            }
        } else {
            $arrResponse['status'] = "fail";
        }

        if (is_array($arrEvents) && (count($arrEvents) > 0)) {
            /* $arrPortalDetail = $this->Portal->find('all', array(
              'conditions' => array('career_portal_id'=> $intPortalId)
              ));
              $strEventName = $arrPortalDetail[0]['Portal']['career_portal_name'];
              $strEventPartName = $this->request->data['eventrequest'];
              $strEventFromDate = $this->request->data['frmdate'];
              $strEventToDate = $this->request->data['todate'];
              if($strEventPartName == "All")
              {
              $arrEvents = array(
              $arrPortalDetail[0]['Portal']['career_portal_name']." Logged In Users",
              $arrPortalDetail[0]['Portal']['career_portal_name']." Logged Out Users",
              $arrPortalDetail[0]['Portal']['career_portal_name']." Registered Users",
              $arrPortalDetail[0]['Portal']['career_portal_name']." Confirmed Users"
              );
              }
              else
              {
              $strEventName = $strEventName." ".$strEventPartName;
              $arrEvents = array($strEventName);
              } */
            $compMixPanel = $this->Components->load('MixPanel');
            $objPropertiesFilteredData = $compMixPanel->fnGetTrends($arrEvents, $strEventFromDate, $strEventToDate);
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
                        //$strSeriesData .= "'".date("jS M y",strtotime($arrSeries))."',";
                    }
                    $arrDfaultValueData[$strEvents] = $arrDefaultSeriesData;
                }
                /* print("<pre>");
                  print_r($arrDfaultValueData); */
                $arrCheckSeriesDataValues = $arrDfaultValueData;
            }

            if (isset($objPropertiesFilteredData->data->series) && isset($objPropertiesFilteredData->data->values)) {
                $strSeriesData = "";
                $strSeriesDataValue = "";
                foreach ($objPropertiesFilteredData->data->series as $arrSeries) {
                    $strSeriesData .= date("jS M y", strtotime($arrSeries)) . ",";
                    $strSeriesDataValue .= "0,";
                }
                $arrResponse['chartdata'] = "null";
                $arrSeriesData = array();
                $arrSeriesDataValues = $arrCheckSeriesDataValues;
                if (is_array($arrSeriesDataValues) && (count($arrSeriesDataValues) > 0)) {
                    $strSeriesDataValue = "";
                    foreach ($arrSeriesDataValues as $arrSeriesDataLabel => $arrSeriesDataLabelValue) {
                        $arrSeriesDataValueList = (array) $arrSeriesDataLabelValue;
                        $strSeriesDataValue .= $arrSeriesDataLabel . ":";
                        foreach ($objPropertiesFilteredData->data->series as $arrSeries) {
                            //$strSeriesDataValue .= "['".date("jS M y",strtotime($arrSeries))."',".$arrSeriesDataValueList[$arrSeries]."]~";
                            if ($arrSeriesDataValueList[$arrSeries]) {
                                $arrResponse['chartdata'] = "notnull";
                            }
                            $strSeriesDataValue .= $arrSeriesDataValueList[$arrSeries] . ",";
                        }
                        $strSeriesDataValue = rtrim($strSeriesDataValue, ",");
                        $strSeriesDataValue .= "~";
                    }
                }

                $arrSeriesData = array_unique($arrSeriesData);

                $arrResponse['status'] = "success";
                $arrResponse['xseries'] = rtrim($strSeriesData, ",");
                $arrResponse['dataseries'] = rtrim($strSeriesDataValue, "~");
            } else {
                $arrResponse['status'] = "fail";
            }
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function registeredjobseekerlist() {
        $this->layout = "admin";
        $this->loadModel('PortalUser');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if ($intPortalId != "" && $strStartDate != '') {
            if ($intPortalId == 'all') {
                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                $this->Paginator->settings = array(
                    'conditions' => array('candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate),
                    'order' => array('career_portal_id' => 'DESC'),
                    'limit' => 30
                );
            } else {
                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                $this->Paginator->settings = array(
                    'conditions' => array('career_portal_id' => $intPortalId, 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate),
                    'order' => array('career_portal_id' => 'DESC'),
                    'limit' => 30
                );
            }
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

    public function activejobseekerlist() {
        $this->layout = "admin";
        $this->loadModel('PortalUser');
        $this->loadModel('Portal');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if (!empty($strStartDate)) {
            if ($intPortalId == 'all') {
                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '1', 'career_portal_id' => $intPortalId, 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
            } else {
                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'candidate_confirmed' => '1', 'candidate_is_active' => '1', 'career_portal_id' => $intPortalId, 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
            }
        } else {
            if ($intPortalId == 'all') {
                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '1', 'career_portal_id' => $intPortalId)));
            } else {
                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'candidate_confirmed' => '1', 'candidate_is_active' => '1', 'career_portal_id' => $intPortalId)));
            }
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

    public function inactivejobseekerlist() {
        $this->layout = "admin";
        $this->loadModel('PortalUser');
        $this->loadModel('Portal');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        if ($intPortalId != '' && $strStartDate != '') {
            if ($intPortalId == 'all') {
                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '0', 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                $this->Paginator->settings = array(
                    'conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '0', 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate),
                    'order' => array('career_portal_id' => 'DESC'),
                    'limit' => 30
                );
                $arrPortalUserList = $this->Paginator->paginate('PortalUser');
            } else {
                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => '0', 'career_portal_id' => $intPortalId, 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                $this->Paginator->settings = array(
                    'conditions' => array('career_portal_id' => $intPortalId, 'candidate_confirmed' => '1', 'candidate_is_active' => '0', 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate),
                    'order' => array('career_portal_id' => 'DESC'),
                    'limit' => 30
                );
                $arrPortalUserList = $this->Paginator->paginate('PortalUser');
            }
        }

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

    public function portalownerslist() {
        $this->layout = "admin";
        $this->loadModel('User');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if ($intPortalId != 'all') {
            $arrPortalList = $this->Portal->find('all', array('fields' => array('career_portal_id', 'career_portal_name', 'career_portal_created_by'), 'conditions' => array('career_portal_published' => '1', 'career_portal_id' => $intPortalId)));
            $portalOwner = $arrPortalList[0]['Portal']['career_portal_created_by'];
        }

        if (!empty($strStartDate)) {
            if ($intPortalId == 'all') {
                $arrPortalOwnerList = $this->User->fnGetPortalOwnersUsers($intPortalId = "", $strStartDate, $strEndDate, $portalOwner = "");
            } else {
                $arrPortalOwnerList = $this->User->fnGetPortalOwnersUsers($intPortalId, $strStartDate, $strEndDate, $portalOwner);
            }
        } else {
            if ($intPortalId == 'all') {
                $arrPortalOwnerList = $this->User->fnGetPortalOwnersUsers($intPortalId = "", $strStartDate = "", $strEndDate = "", $portalOwner = "");
            } else {
                $arrPortalOwnerList = $this->User->fnGetPortalOwnersUsers($intPortalId, $strStartDate = "", $strEndDate = "", $portalOwner);
            }
        }
        $this->set('arrPortalOwnerList', $arrPortalOwnerList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('portalOwner', base64_encode($portalOwner));
        $this->set('strStatus', '');
    }

    public function activeportalownerslist() {
        $this->layout = "admin";
        $this->loadModel('User');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if ($intPortalId != 'all') {
            $arrPortalList = $this->Portal->find('all', array('fields' => array('career_portal_id', 'career_portal_name', 'career_portal_created_by'), 'conditions' => array('career_portal_published' => '1', 'career_portal_id' => $intPortalId)));
            $portalOwner = $arrPortalList[0]['Portal']['career_portal_created_by'];
        }

        if (!empty($strStartDate)) {
            if ($intPortalId == 'all') {
                $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId = "", $strStartDate, $strEndDate, $portalOwner = "", $status = '1');
            } else {
                $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId, $strStartDate, $strEndDate, $portalOwner, $status = '1');
            }
        } else {
            if ($intPortalId == 'all') {
                $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId = "", $strStartDate = "", $strEndDate = "", $portalOwner = "", $status = '1');
            } else {
                $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId, $strStartDate = "", $strEndDate = "", $portalOwner, $status = '1');
            }
        }
        $this->set('arrPortalOwnerList', $arrPortalOwnerList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('portalOwner', base64_encode($portalOwner));
        $this->set('strStatus', '1');
    }

    public function inactiveportalownerslist() {
        $this->layout = "admin";
        $this->loadModel('User');
        $this->loadModel('Portal');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        if ($intPortalId != 'all') {
            $arrPortalList = $this->Portal->find('all', array('fields' => array('career_portal_id', 'career_portal_name', 'career_portal_created_by'), 'conditions' => array('career_portal_published' => '1', 'career_portal_id' => $intPortalId)));
            $portalOwner = $arrPortalList[0]['Portal']['career_portal_created_by'];
        }
        if (!empty($strStartDate)) {
            if ($intPortalId == 'all') {
                $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId = "", $strStartDate, $strEndDate, $portalOwner = "", $status = '0');
            } else {
                $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId, $strStartDate, $strEndDate, $portalOwner, $status = '0');
            }
        } else {
            if ($intPortalId == 'all') {
                $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId = "", $strStartDate = "", $strEndDate = "", $portalOwner = "", $status = '0');
            } else {
                $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId, $strStartDate = "", $strEndDate = "", $portalOwner, $status = '0');
            }
        }
        $this->set('arrPortalOwnerList', $arrPortalOwnerList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('portalOwner', base64_encode($portalOwner));
        $this->set('strStatus', '0');
    }

    public function lastloginjobseekerlist() {
        $this->layout = "admin";
        $this->loadModel('PortalUser');
        $this->loadModel('Portal');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if (!empty($strStartDate)) {
            if ($intPortalId == 'all') {
                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('last_login_date >=' => $strStartDate, 'last_login_date <=' => $strEndDate)));
            } else {
                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'last_login_date >=' => $strStartDate, 'last_login_date <=' => $strEndDate)));
            }
        } else {
            if ($intPortalId == 'all') {
                $arrPortalUserList = $this->PortalUser->find('all');
            } else {
                $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId)));
            }
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
    }

    public function registered15processcompleted() {
        $this->layout = "admin";
        $this->loadModel('User');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        $arrPortalUserList = $this->User->fnGetUserCompleted15Steps($intPortalId, $strStartDate, $strEndDate, '');
        $this->set('arrPortalOwnerList', $arrPortalUserList);

        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
    }

    public function refundorderlist() {
        $this->layout = "admin";
        $this->loadModel('User');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $productType = base64_decode($_GET['productType']);
        $datePeriodTypes = base64_decode($_GET['datePeriod']);

        if ($datePeriodTypes == 'curr_year') {
            $datePeriod = "YEAR";
            $this->set('datePeriod', base64_encode($datePeriod));
        } else if ($datePeriodTypes == '30') {
            $datePeriod = "MONTH";
            $this->set('datePeriod', base64_encode($datePeriod));
        } else {
            $datePeriod = "DATE";
            $this->set('datePeriod', base64_encode($datePeriod));
        }

        if ($intPortalId == 'all') {
            $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminRefundedOrder($strStartDate, $strEndDate, $productType, $datePeriod, $intPortalId = "");
        } else {
            $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminRefundedOrder($strStartDate, $strEndDate, $productType, $datePeriod, $intPortalId);
        }
        $this->set('arrJobSeekerPurchaseOrderList', $arrJobSeekerPurchaseOrderList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('productType', base64_encode($productType));
        $this->set('productTypes', $productType);
    }

    public function jobseekerspurchasedorder() {
        $this->layout = "admin";
        $this->loadModel('User');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $productType = base64_decode($_GET['productType']);
        $datePeriodTypes = base64_decode($_GET['datePeriod']);

        if ($intPortalId == 'all') {
            $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminPurchasedOrderList($strStartDate, $strEndDate, $productType, $intPortalId = "");
        } else {
            $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminPurchasedOrderList($strStartDate, $strEndDate, $productType, $intPortalId);
        }

        $this->set('arrJobSeekerPurchaseOrderList', $arrJobSeekerPurchaseOrderList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('productType', base64_encode($productType));
        $this->set('productTypes', $productType);
    }

    public function themeregisterlist() {
        $this->layout = "admin";
        $this->loadModel('User');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $strThemeName = $_GET['theme'];
        if ($strThemeName != '') {
            if ($intPortalId == 'all') {
                $arrJobSeekerThemeRegisterList = $this->User->fnGetJobSeekerThemeRegisterList($intPortalId = "", $strStartDate, $strEndDate, $strThemeName);
            } else {
                $arrJobSeekerThemeRegisterList = $this->User->fnGetJobSeekerThemeRegisterList($intPortalId, $strStartDate, $strEndDate, $strThemeName);
            }
        }
        $this->set('arrJobSeekerThemeList', $arrJobSeekerThemeRegisterList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('strthemeName', $strThemeName);
    }

    public function newportalsboughtandpurchasedlist() {
        $this->layout = "admin";
        $this->loadModel('PortalDomain');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if ($intPortalId != "" && $strStartDate != '') {
            if ($intPortalId == 'all') {
                $arrPortalDomainList = $this->PortalDomain->find('all', array('conditions' => array('career_portal_purchased_date >=' => $strStartDate, 'career_portal_purchased_date <=' => $strEndDate)));
            } else {
                $arrPortalDomainList = $this->PortalDomain->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'career_portal_purchased_date >=' => $strStartDate, 'career_portal_purchased_date <=' => $strEndDate)));
            }
        }

        if (is_array($arrPortalDomainList) && (count($arrPortalDomainList) > 0)) {
            $this->loadModel('Portal');
            $intPortalDetailCount = 0;
            foreach ($arrPortalDomainList as $arrPortalDetail) {
                $arrPortalDetailNew = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $arrPortalDetail['PortalDomain']['career_portal_id'])));
                $arrPortalDomainList[$intPortalDetailCount]['PortalName']['pname'] = array_pop($arrPortalDetailNew);
                $intPortalDetailCount++;
            }
        }

        $this->set('arrPortalDomainList', $arrPortalDomainList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
    }

    public function portalssalescostlist() {
        $this->layout = "admin";
        $this->loadModel('PortalDomain');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if ($intPortalId != "" && $strStartDate != '') {
            if ($intPortalId == 'all') {
                $arrDomainList = $this->PortalDomain->fnGetPortalDomainCostList($strStartDate, $strEndDate, $intPortalId = "");
            } else {
                $arrDomainList = $this->PortalDomain->fnGetPortalDomainCostList($strStartDate, $strEndDate, $intPortalId);
            }
        }

        if (is_array($arrDomainList) && (count($arrDomainList) > 0)) {
            $this->loadModel('Portal');
            $intPortalDetailCount = 0;
            foreach ($arrDomainList as $arrPortalDetail) {
                $arrPortalDetailNew = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $arrPortalDetail['career_portal_domain']['career_portal_id'])));
                $arrDomainList[$intPortalDetailCount]['PortalName']['pname'] = array_pop($arrPortalDetailNew);
                $intPortalDetailCount++;
            }
        }
        $this->set('arrPortalDomainList', $arrDomainList);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
    }

    public function totalrefundeachvendorlist() {
        $this->layout = "admin";
        $this->loadModel('Resourceorderdetail');
        $this->loadModel('Vendors');

        $intPortalId = base64_decode($_GET['portalId']);
//        $strStartDate = "2016-01-01";
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $intVendorId = base64_decode($_GET['Vendor']);

        $arrVendorDetails = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $intVendorId)));
        $vendorName = $arrVendorDetails[0]['Vendors']['vendor_first_name'] . " " . $arrVendorDetails[0]['Vendors']['vendor_last_name'];

        if ($intPortalId != "" && $strStartDate != '') {
            if ($intVendorId == '') {
                if ($intPortalId == 'all') {
                    $arrRefundedOrders = $this->Resourceorderdetail->fnGetRefundOrderList($arrVendor = "", $strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrRefundedOrders = $this->Resourceorderdetail->fnGetRefundOrderList($arrVendor = "", $strStartDate, $strEndDate, $intPortalId);
                }
            } else {
                if ($intPortalId == 'all') {
                    $arrRefundedOrders = $this->Resourceorderdetail->fnGetAdminTotalRefundOrderList($intVendorId, $strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrRefundedOrders = $this->Resourceorderdetail->fnGetAdminTotalRefundOrderList($intVendorId, $strStartDate, $strEndDate, $intPortalId);
                }
            }
        }
        $this->set('arrRefundedOrders', $arrRefundedOrders);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('strVendorId', base64_encode($intVendorId));
        $this->set('vendorName', $vendorName);
    }

    public function totalsaleeachvendorlist() {
//        Configure::write('debug', '2');
        $this->layout = "admin";
        $this->loadModel('Resourceorderdetail');
        $this->loadModel('Vendors');

        $intPortalId = base64_decode($_GET['portalId']);
//        $strStartDate = "2016-01-01";
//        $strEndDate = "2016-12-31";
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $intVendorId = base64_decode($_GET['Vendor']);
        $subVendor = base64_decode($_GET['subVendor']);

        $arrVendorDetails = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $subVendor)));
        $vendorName = $arrVendorDetails[0]['Vendors']['vendor_first_name'] . " " . $arrVendorDetails[0]['Vendors']['vendor_last_name'];

        if ($intPortalId != "" && $strStartDate != '') {
            if ($intVendorId == '') {
                if ($intPortalId == 'all') {
                    $arrVendorSaleOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmountList($intVendorId = "", $strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrVendorSaleOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmountList($intVendorId = "", $strStartDate, $strEndDate, $intPortalId);
                }
            } else {
                if ($intPortalId == 'all') {
                    $arrVendorSaleOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmountList($intVendorId, $strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrVendorSaleOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmountList($intVendorId, $strStartDate, $strEndDate, $intPortalId);
                }
            }
        }

        $this->set('arrVendorSaleOrders', $arrVendorSaleOrders);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('strVendorId', base64_encode($intVendorId));
        $this->set('strSubVendorId', base64_encode($subVendor));
        $this->set('vendorName', $vendorName);
    }

    public function newvendorslist() {
        $this->layout = "admin";
        $this->loadModel('Resourceorderdetail');

        $intPortalId = base64_decode($_GET['portalId']);
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if ($intPortalId != "" && $strStartDate != '') {
            if ($intPortalId == 'all') {
                $arrNewVendors = $this->Resourceorderdetail->fnGetNewVendorAddedList($strStartDate, $strEndDate, $intPortalId);
            } else {
                $arrNewVendors = $this->Resourceorderdetail->fnGetNewVendorAddedList($strStartDate, $strEndDate, $intPortalId);
            }
        }
        $this->set('arrNewVendors', $arrNewVendors);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
    }

    public function paidpayoutlist() {
        $this->layout = "admin";
        $this->loadModel('PayoutPaymentDetails');
        $this->loadModel('Vendorcompany');
        $this->loadModel('User');
        $this->loadModel('Portal');
        $intPortalId = base64_decode($_GET['portalId']);
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $intVendorId = base64_decode($_GET['vendorId']);
        $ownerId = base64_decode($_GET['ownerId']);
        $payoutFor = $_GET['payoutFor'];

        if ($intPortalId != "" && $strStartDate != '') {
            if ($payoutFor == "vendor") {
                if ($intPortalId == 'all') {
                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetVendorPaidPayoutList($intVendorId, $strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetVendorPaidPayoutList($intVendorId, $strStartDate, $strEndDate, $intPortalId = "all");
                }
            } else {
                if ($intPortalId == 'all') {
                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetOwnerPaidPayoutList($ownerId, $strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrTotalPaid = $this->PayoutPaymentDetails->fnGetOwnerPaidPayoutList($ownerId, $strStartDate, $strEndDate, $intPortalId = "all");
                }
            }
        }

        if ($payoutFor == 'vendor') {
            $arrVendorDetails = $this->Vendorcompany->find('all', array('conditions' => array('vendor_id' => $intVendorId)));
            $companyName = $arrVendorDetails[0]['Vendorcompany']['company_name'];
        } else {
            $arrPortalId = $this->User->find('all', array('conditions' => array('id' => $ownerId)));
            $ownerName = $arrPortalId[0]['User']['username'];
        }


        $this->set('arrPayoutDetails', $arrTotalPaid);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('intVendorId', base64_encode($intVendorId));
        $this->set('intOwnerId', base64_encode($ownerId));
        $this->set('vendorName', $companyName);
        $this->set('ownerName', $ownerName);
        $this->set('payoutType', $payoutFor);
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

    public function userExport() {
//        Configure::write('debug', '2');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $strStatus = $_GET['Status'];

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Portal');
        $this->loadModel('PortalUser');

        if ($strStatus == 'lastLogin') {
            if (!empty($strStartDate)) {
                if ($intPortalId == 'all') {
                    $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('last_login_date >=' => $strStartDate, 'last_login_date <=' => $strEndDate)));
                } else {
                    $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'last_login_date >=' => $strStartDate, 'last_login_date <=' => $strEndDate)));
                }
            }
        } else {
            if ($strStatus != '') {
                if (!empty($strStartDate)) {
                    if ($intPortalId == 'all') {
                        $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => $strStatus, 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                    } else {
                        $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => $strStatus, 'career_portal_id' => $intPortalId, 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                    }
                } else {
                    if ($intPortalId == 'all') {
                        $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => $strStatus)));
                    } else {
                        $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_confirmed' => '1', 'candidate_is_active' => $strStatus, 'career_portal_id' => $intPortalId)));
                    }
                }
            } else {
                if (!empty($strStartDate)) {
                    if ($intPortalId == 'all') {
                        $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                    } else {
                        $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'candidate_creation_date >=' => $strStartDate, 'candidate_creation_date <=' => $strEndDate)));
                    }
                } else {
                    if ($intPortalId == 'all') {
                        $arrPortalUserList = $this->PortalUser->find('all');
                    } else {
                        $arrPortalUserList = $this->PortalUser->find('all', array('conditions' => array('career_portal_id' => $intPortalId)));
                    }
                }
            }
        }

        if (is_array($arrPortalUserList) && count($arrPortalUserList) > 0) {
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
            if ($strStatus == 'lastLogin') {
                $strFileName = "Last_Login_Users_Reports.xls";
                $reportName = $arrPortalDet[$intPortalId] . " Last Login Users Report";
                $labelName = 'Last Login Date';
            } else {
                if ($strStatus == '1') {
                    $strFileName = "Active_Users_Reports.xls";
                    $reportName = $arrPortalDet[$intPortalId] . " Active Users Report";
                    $labelName = 'Date Registered';
                } else if ($strStatus == '0') {
                    $strFileName = "Inactive_Users_Reports.xls";
                    $reportName = $arrPortalDet[$intPortalId] . " Inactive Users Report";
                    $labelName = 'Date Registered';
                } else {
                    $strFileName = "Register_Users_Reports.xls";
                    $reportName = $arrPortalDet[$intPortalId] . " Registered Job Seekers Report";
                    $labelName = 'Date Registered';
                }
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
                    ->setCellValue('F5', $labelName);

            foreach ($arrPortalUserList as $k => $arrUsers) {
                $candidateFirstName = $arrUsers['PortalUser']['candidate_first_name'];
                $candidateLastName = $arrUsers['PortalUser']['candidate_last_name'];
                $candidateEmail = $arrUsers['PortalUser']['candidate_email'];
                $PortalName = $arrPortalDet[$intPortalId];
                if ($strStatus == 'lastLogin') {
                    $candidateCreationDate = $arrUsers['PortalUser']['last_login_date'];
                } else {
                    $candidateCreationDate = $arrUsers['PortalUser']['candidate_creation_date'];
                }


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

    public function portalOwnerExport() {
//        Configure::write('debug', '2');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $strStatus = $_GET['Status'];
        $portalOwner = base64_decode($_GET['PortalOwner']);

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Portal');
        $this->loadModel('User');


        if ($strStatus != '') {
            if (!empty($strStartDate)) {
                if ($intPortalId == 'all') {
                    $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId = "", $strStartDate, $strEndDate, $portalOwner = "", $strStatus);
                } else {
                    $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId, $strStartDate, $strEndDate, $portalOwner, $strStatus);
                }
            } else {
                if ($intPortalId == 'all') {
                    $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId = "", $strStartDate = "", $strEndDate = "", $portalOwner = "", $strStatus);
                } else {
                    $arrPortalOwnerList = $this->User->fnGetPortalOwnersActiveInactiveUsers($intPortalId, $strStartDate = "", $strEndDate = "", $portalOwner, $strStatus);
                }
            }
        } else {
            if (!empty($strStartDate)) {
                if ($intPortalId == 'all') {
                    $arrPortalOwnerList = $this->User->fnGetPortalOwnersUsers($intPortalId = "", $strStartDate, $strEndDate, $portalOwner = "");
                } else {
                    $arrPortalOwnerList = $this->User->fnGetPortalOwnersUsers($intPortalId, $strStartDate, $strEndDate, $portalOwner);
                }
            } else {
                if ($intPortalId == 'all') {
                    $arrPortalOwnerList = $this->User->fnGetPortalOwnersUsers($intPortalId = "", $strStartDate = "", $strEndDate = "", $portalOwner = "");
                } else {
                    $arrPortalOwnerList = $this->User->fnGetPortalOwnersUsers($intPortalId, $strStartDate = "", $strEndDate = "", $portalOwner);
                }
            }
        }

        if (is_array($arrPortalOwnerList) && count($arrPortalOwnerList) > 0) {
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
            if ($strStatus == '1') {
                $strFileName = "Active_Owners_Reports.xls";
                $reportName = $arrPortalDet[$intPortalId] . " Active Owners Report";
            } else if ($strStatus == '0') {
                $strFileName = "Inactive_Users_Reports.xls";
                $reportName = $arrPortalDet[$intPortalId] . " Inactive Owners Report";
            } else {
                $strFileName = "Register_Owners_Reports.xls";
                $reportName = $arrPortalDet[$intPortalId] . " Registered Owners Report";
            }
            $intFrCnt = 0;
            $intRowCnt = 6;
            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Portal Owner(s) Analytics Report")
                    ->setSubject("Portal Owner(s) Analytics Report")
                    ->setDescription("Portal Owner(s) Analytics Report")
                    ->setKeywords("Portal Owner(s) Analytics Report")
                    ->setCategory("Portal Owner(s) Analytics Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'First Name')
                    ->setCellValue('C5', 'Last Name')
                    ->setCellValue('D5', 'Email')
                    ->setCellValue('E5', 'Portal Name')
                    ->setCellValue('F5', 'Date Registered');

            foreach ($arrPortalOwnerList as $k => $arrUsers) {
                $candidateFirstName = $arrUsers['employer_detail']['employer_user_fname'];
                $candidateLastName = $arrUsers['employer_detail']['employer_user_lname'];
                $candidateEmail = $arrUsers['user']['email'];
                $PortalName = $arrUsers['career_portal']['career_portal_name'];
                $candidateCreationDate = $arrUsers['user']['user_creation_date'];

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
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
            $strFileName = $arrPortalDet[$intPortalId] . "_15_Step_Completed_Reports.xls";
            $reportName = $arrPortalDet[$intPortalId] . " 15 Step Completed Analytics Report";
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
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);  //set column C width

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

    public function orderRefundedExport() {
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['StartDate']);
        $strEndDate = base64_decode($_GET['EndDate']);
        $productType = base64_decode($_GET['productType']);
        $datePeriod = base64_decode($_GET['datePeriod']);

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('User');
        $this->loadModel('Portal');
        if ($intPortalId == 'all') {
            $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminRefundedOrder($strStartDate, $strEndDate, $productType, $datePeriod, $intPortalId = "");
        } else {
            $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminRefundedOrder($strStartDate, $strEndDate, $productType, $datePeriod, $intPortalId);
        }
        if (is_array($arrJobSeekerPurchaseOrderList) && count($arrJobSeekerPurchaseOrderList) > 0) {
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
            $strFileName = $arrPortalDet[$intPortalId] . "_Refunded_Reports.xls";
            $reportName = $arrPortalDet[$intPortalId] . " Refunded Order Report";
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
                    ->setCellValue('E5', 'Refunded Amount')
                    ->setCellValue('F5', 'Order Date');

            foreach ($arrJobSeekerPurchaseOrderList as $k => $arrOrders) {
                $candidateEmail = $arrOrders['career_portal_candidate']['candidate_email'];
                $candidateFirstName = $arrOrders['career_portal_candidate']['candidate_first_name'];
                $candidateLastName = $arrOrders['career_portal_candidate']['candidate_last_name'];
                $RefundedAmount = "$" . $arrOrders['0']['total'];
                $OrderDate = date('Y-m-d', strtotime($arrOrders['resource_order']['order_creation_date_time']));
                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $candidateEmail)
                        ->setCellValue('C' . $intRowCnt, $candidateFirstName)
                        ->setCellValue('D' . $intRowCnt, $candidateLastName)
                        ->setCellValue('E' . $intRowCnt, $RefundedAmount)
                        ->setCellValue('F' . $intRowCnt, $OrderDate);

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

    public function purchaseOrderExport() {
        $this->loadModel('User');
        $this->loadModel('Portal');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['StartDate']);
        $strEndDate = base64_decode($_GET['EndDate']);
        $productType = base64_decode($_GET['productType']);

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();

        if ($intPortalId == 'all') {
            $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminPurchasedOrderList($strStartDate, $strEndDate, $productType, $intPortalId = "");
        } else {
            $arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerAdminPurchasedOrderList($strStartDate, $strEndDate, $productType, $intPortalId);
        }

        if (is_array($arrJobSeekerPurchaseOrderList) && count($arrJobSeekerPurchaseOrderList) > 0) {
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
            $strFileName = $arrPortalDet[$intPortalId] . "_Sale_Order_Reports.xls";
            $reportName = $arrPortalDet[$intPortalId] . " Sale Order Report";
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
                    ->setCellValue('E5', 'Purchased Cost')
                    ->setCellValue('F5', 'Order Date');

            foreach ($arrJobSeekerPurchaseOrderList as $k => $arrJobSeekerPurchaseOrder) {
                $CandidateEmail = $arrJobSeekerPurchaseOrder['career_portal_candidate']['candidate_email'];
                $FirstName = stripslashes($arrJobSeekerPurchaseOrder['career_portal_candidate']['candidate_first_name']);
                $LastName = stripslashes($arrJobSeekerPurchaseOrder['career_portal_candidate']['candidate_last_name']);
                $OrderCost = isset($arrJobSeekerPurchaseOrder['resource_order_detail']['total']) ? "$" . ($arrJobSeekerPurchaseOrder['resource_order_detail']['total']) : '$0.00';
                $OrderDate = date('Y-m-d', strtotime($arrJobSeekerPurchaseOrder['resource_order']['order_creation_date_time']));
                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $CandidateEmail)
                        ->setCellValue('C' . $intRowCnt, isset($FirstName) ? $FirstName : '-')
                        ->setCellValue('D' . $intRowCnt, isset($LastName) ? $LastName : '-')
                        ->setCellValue('E' . $intRowCnt, isset($OrderCost) ? $OrderCost : '$0.00')
                        ->setCellValue('F' . $intRowCnt, isset($OrderDate) ? $OrderDate : '-');

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

    public function themeRegisterUserExport() {
        $this->loadModel('User');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['StartDate']);
        $strEndDate = base64_decode($_GET['EndDate']);
        $strThemeName = $_GET['themeName'];

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();

        if ($strThemeName != '') {
            if ($intPortalId == 'all') {
                $arrJobSeekerThemeRegisterList = $this->User->fnGetJobSeekerThemeRegisterList($intPortalId = "", $strStartDate, $strEndDate, $strThemeName);
            } else {
                $arrJobSeekerThemeRegisterList = $this->User->fnGetJobSeekerThemeRegisterList($intPortalId, $strStartDate, $strEndDate, $strThemeName);
            }
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

    public function newPortalDomainPurchasedExport() {
        $this->loadModel('PortalDomain');
        $this->loadModel('Portal');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();

        if ($intPortalId != "" && $strStartDate != '') {
            if ($intPortalId == 'all') {
                $arrPortalDomainList = $this->PortalDomain->find('all', array('conditions' => array('career_portal_purchased_date >=' => $strStartDate, 'career_portal_purchased_date <=' => $strEndDate)));
            } else {
                $arrPortalDomainList = $this->PortalDomain->find('all', array('conditions' => array('career_portal_id' => $intPortalId, 'career_portal_purchased_date >=' => $strStartDate, 'career_portal_purchased_date <=' => $strEndDate)));
            }
        }

        if (is_array($arrPortalDomainList) && (count($arrPortalDomainList) > 0)) {
            $this->loadModel('Portal');
            $intPortalDetailCount = 0;
            foreach ($arrPortalDomainList as $arrPortalDetail) {
                $arrPortalDetailNew = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $arrPortalDetail['PortalDomain']['career_portal_id'])));
                $arrPortalDomainList[$intPortalDetailCount]['PortalName']['pname'] = array_pop($arrPortalDetailNew);
                $intPortalDetailCount++;
            }
        }

        if (is_array($arrPortalDomainList) && count($arrPortalDomainList) > 0) {
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
            $strFileName = $arrPortalDet[$intPortalId] . "_Domain_Reports.xls";
            $reportName = $arrPortalDet[$intPortalId] . " Domain Order Report";
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
                    ->setCellValue('B5', 'Order Id')
                    ->setCellValue('C5', 'Domain Name')
                    ->setCellValue('D5', 'Purchased Cost')
                    ->setCellValue('E5', 'Portal Name')
                    ->setCellValue('F5', 'Portal Status')
                    ->setCellValue('G5', 'Purchased Date');

            foreach ($arrPortalDomainList as $k => $arrPortalDomain) {
                $OrderId = $arrPortalDomain['PortalDomain']['career_portal_order_id'];
                ;
                $DomainName = $arrPortalDomain['PortalDomain']['career_portal_domain_name'];
                $DomainCost = isset($arrPortalDomain['PortalDomain']['career_portal_domain_amount']) ? '$' . ($arrPortalDomain['PortalDomain']['career_portal_domain_amount']) : '$0.00';
                $PortalName = $arrPortalDomain['PortalName']['pname'];
                if ($arrPortalDomain['PortalDomain']['career_portal_domain_status']) {
                    $DomainStatus = "Active";
                } else {
                    $DomainStatus = 'Inactive';
                }

                $PurchaseDate = date('Y-m-d', strtotime($arrPortalDomain['PortalDomain']['career_portal_purchased_date']));
                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $OrderId)
                        ->setCellValue('C' . $intRowCnt, isset($DomainName) ? $DomainName : '-')
                        ->setCellValue('D' . $intRowCnt, isset($DomainCost) ? $DomainCost : '$0.00')
                        ->setCellValue('E' . $intRowCnt, isset($PortalName) ? $PortalName : '-')
                        ->setCellValue('F' . $intRowCnt, isset($DomainStatus) ? $DomainStatus : '-')
                        ->setCellValue('G' . $intRowCnt, isset($PurchaseDate) ? $PurchaseDate : '-');

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);  //set column C width
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

            $objPHPExcel->getActiveSheet()->mergeCells('C2:F2');
            $objPHPExcel->getActiveSheet()->setCellValue('C2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('C3:F3');
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
            $arrResponse['message'] = "There are no new portals bought and purchased in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function portalssalescostExport() {
        $this->loadModel('PortalDomain');
        $this->loadModel('Portal');
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();

        if ($intPortalId != "" && $strStartDate != '') {
            if ($intPortalId != "" && $strStartDate != '') {
                if ($intPortalId == 'all') {
                    $arrPortalDomainList = $this->PortalDomain->fnGetPortalDomainCostList($strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrPortalDomainList = $this->PortalDomain->fnGetPortalDomainCostList($strStartDate, $strEndDate, $intPortalId);
                }
            }
        }

        if (is_array($arrPortalDomainList) && (count($arrPortalDomainList) > 0)) {
            $this->loadModel('Portal');
            $intPortalDetailCount = 0;
            foreach ($arrPortalDomainList as $arrPortalDetail) {
                $arrPortalDetailNew = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $arrPortalDetail['career_portal_domain']['career_portal_id'])));
                $arrPortalDomainList[$intPortalDetailCount]['PortalName']['pname'] = array_pop($arrPortalDetailNew);
                $intPortalDetailCount++;
            }
        }

        if (is_array($arrPortalDomainList) && count($arrPortalDomainList) > 0) {
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
            $strFileName = $arrPortalDet[$intPortalId] . "_Sale_Cost_Reports.xls";
            $reportName = $arrPortalDet[$intPortalId] . " Sale Cost Order Report";
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
                    ->setCellValue('B5', 'Order Id')
                    ->setCellValue('C5', 'Domain Name')
                    ->setCellValue('D5', 'Purchased Cost')
                    ->setCellValue('E5', 'Portal Name')
                    ->setCellValue('F5', 'Portal Status')
                    ->setCellValue('G5', 'Purchased Date');

            foreach ($arrPortalDomainList as $k => $arrPortalDomain) {
                $OrderId = $arrPortalDomain['career_portal_domain']['career_portal_order_id'];
                $DomainName = $arrPortalDomain['career_portal_domain']['career_portal_domain_name'];
                $DomainCost = isset($arrPortalDomain['career_portal_domain']['career_portal_domain_amount']) ? '$' . ($arrPortalDomain['career_portal_domain']['career_portal_domain_amount']) : '$0.00';
                $PortalName = $arrPortalDomain['PortalName']['pname'];
                if ($arrPortalDomain['career_portal_domain']['career_portal_domain_status']) {
                    $DomainStatus = "Active";
                } else {
                    $DomainStatus = 'Inactive';
                }

                $PurchaseDate = date('Y-m-d', strtotime($arrPortalDomain['career_portal_domain']['career_portal_purchased_date']));
                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $OrderId)
                        ->setCellValue('C' . $intRowCnt, isset($DomainName) ? $DomainName : '-')
                        ->setCellValue('D' . $intRowCnt, isset($DomainCost) ? $DomainCost : '$0.00')
                        ->setCellValue('E' . $intRowCnt, isset($PortalName) ? $PortalName : '-')
                        ->setCellValue('F' . $intRowCnt, isset($DomainStatus) ? $DomainStatus : '-')
                        ->setCellValue('G' . $intRowCnt, isset($PurchaseDate) ? $PurchaseDate : '-');

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);  //set column C width
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

            $objPHPExcel->getActiveSheet()->mergeCells('C2:F2');
            $objPHPExcel->getActiveSheet()->setCellValue('C2', $reportName);
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(22);  //set wrapped for some long text message
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

            if ($strStartDate != '' && $strEndDate != '') {
                $objPHPExcel->getActiveSheet()->mergeCells('C3:F3');
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
            $arrResponse['message'] = "There are no new portals bought and purchased in the system.";
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function vendorOrderRefundedExport() {
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['StartDate']);
        $strEndDate = base64_decode($_GET['EndDate']);
        $intVendorId = base64_decode($_GET['Vendor']);
        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Resourceorderdetail');
        $this->loadModel('Portal');
        if ($intPortalId != "" && $strStartDate != '') {
            if ($intVendorId == '') {
                if ($intPortalId == 'all') {
                    $arrRefundedOrders = $this->Resourceorderdetail->fnGetRefundOrderList($arrVendor = "", $strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrRefundedOrders = $this->Resourceorderdetail->fnGetRefundOrderList($arrVendor = "", $strStartDate, $strEndDate, $intPortalId);
                }
            } else {
                if ($intPortalId == 'all') {
                    $arrRefundedOrders = $this->Resourceorderdetail->fnGetAdminTotalRefundOrderList($intVendorId, $strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrRefundedOrders = $this->Resourceorderdetail->fnGetAdminTotalRefundOrderList($intVendorId, $strStartDate, $strEndDate, $intPortalId);
                }
            }
        }
        if (is_array($arrRefundedOrders) && count($arrRefundedOrders) > 0) {
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
            $strFileName = $arrPortalDet[$intPortalId] . "_Refunded_Reports.xls";
            $reportName = $arrPortalDet[$intPortalId] . " Refunded Order Report";
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
                    ->setCellValue('E5', 'Refunded Amount')
                    ->setCellValue('F5', 'Order Date');

            foreach ($arrRefundedOrders as $k => $arrOrders) {
                $candidateEmail = $arrOrders['career_portal_candidate']['candidate_email'];
                $candidateFirstName = $arrOrders['career_portal_candidate']['candidate_first_name'];
                $candidateLastName = $arrOrders['career_portal_candidate']['candidate_last_name'];
                $RefundedAmount = "$" . $arrOrders['resource_order_detail']['vendor_cost'];
                $OrderDate = date('Y-m-d', strtotime($arrOrders['resource_order_detail']['order_confirmation_date_time']));
                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $candidateEmail)
                        ->setCellValue('C' . $intRowCnt, $candidateFirstName)
                        ->setCellValue('D' . $intRowCnt, $candidateLastName)
                        ->setCellValue('E' . $intRowCnt, $RefundedAmount)
                        ->setCellValue('F' . $intRowCnt, $OrderDate);

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

    public function vendorOrderSalesExport() {
        $intPortalId = $_GET['portalId'];
//        $strStartDate = "2016-01-01";
//        $strEndDate = "2016-12-31";
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $intVendorId = base64_decode($_GET['Vendor']);
        $VendorName = $_GET['VendorName'];

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Resourceorderdetail');
        $this->loadModel('Portal');
        if ($intPortalId != "" && $strStartDate != '') {
            if ($intVendorId == '') {
                if ($intPortalId == 'all') {
                    $arrVendorSaleOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmountList($intVendorId = "", $strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrVendorSaleOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmountList($intVendorId = "", $strStartDate, $strEndDate, $intPortalId);
                }
            } else {
                if ($intPortalId == 'all') {
                    $arrVendorSaleOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmountList($intVendorId, $strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrVendorSaleOrders = $this->Resourceorderdetail->fnGetAdminTotalVendorSaleOrderAmountList($intVendorId, $strStartDate, $strEndDate, $intPortalId);
                }
            }
        }
        if (is_array($arrVendorSaleOrders) && count($arrVendorSaleOrders) > 0) {
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
            $strFileName = $arrPortalDet[$intPortalId] . "_Sales_Reports.xls";
            $reportName = $arrPortalDet[$intPortalId] . " Total Sales For " . stripslashes($VendorName);
            $intFrCnt = 0;
            $intRowCnt = 6;

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("Vendor Sales Analytics Report")
                    ->setSubject("Vendor Sales Analytics Report")
                    ->setDescription("Vendor Sales Analytics Report")
                    ->setKeywords("Vendor Sales Analytics Report")
                    ->setCategory("Vendor Sales Analytics Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'Order ID')
                    ->setCellValue('C5', 'Title')
                    ->setCellValue('D5', 'Cost')
                    ->setCellValue('E5', 'Vendor Cost')
                    ->setCellValue('F5', 'Owner Cost')
                    ->setCellValue('G5', 'HC Cost')
                    ->setCellValue('H5', 'Order Date');

            foreach ($arrVendorSaleOrders as $k => $VendorSaleOrders) {
                $OrderId = $VendorSaleOrders['resource_order']['order_name'];
                $productName = $VendorSaleOrders['resource_order_detail']['product_name'];
                $Cost = "$" . $VendorSaleOrders['resource_order_detail']['product_unit_cost'];
                $VendorCost = "$" . $VendorSaleOrders['resource_order_detail']['vendor_cost'];
                $OwnerCost = "$" . $VendorSaleOrders['resource_order_detail']['portal_owner_cost'];
                $HCCost = "$" . $VendorSaleOrders['resource_order_detail']['hc_profit_cost'];
                $OrderDate = date('Y-m-d', strtotime($VendorSaleOrders['resource_order_detail']['order_confirmation_date_time']));
                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $OrderId)
                        ->setCellValue('C' . $intRowCnt, $productName)
                        ->setCellValue('D' . $intRowCnt, $Cost)
                        ->setCellValue('E' . $intRowCnt, $VendorCost)
                        ->setCellValue('F' . $intRowCnt, $OwnerCost)
                        ->setCellValue('G' . $intRowCnt, $HCCost)
                        ->setCellValue('H' . $intRowCnt, $OrderDate);

                $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);  //set column C width

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
                $objPHPExcel->getActiveSheet()->mergeCells('C3:F3');
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

    public function utilizingthecrmjobseekerlist() {
        $this->layout = "admin";
        $this->loadModel('JobStatistics');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if ($intPortalId != "" && $strStartDate != '') {
            if ($intPortalId == 'all') {
                $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingCRMList($strStartDate, $strEndDate, $intPortalId = "");
            } else {
                $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingCRMList($strStartDate, $strEndDate, $intPortalId);
            }
            if (is_array($arrJobsViews) && (count($arrJobsViews) > 0)) {
                $this->loadModel('Portal');
                $intPortalDetailCount = 0;
                foreach ($arrJobsViews as $arrPortalDetail) {
                    $arrPortalDetailNew = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $arrPortalDetail['jobberland_graph_statistics']['career_portal_id'])));
                    $arrJobsViews[$intPortalDetailCount]['PortalName']['pname'] = array_pop($arrPortalDetailNew);
                    $intPortalDetailCount++;
                }
            }

            $this->set('arrJobsViews', $arrJobsViews);
            $this->set('portalId', $intPortalId);
            $this->set('strStartDate', base64_encode($strStartDate));
            $this->set('strEndDate', base64_encode($strEndDate));
            $this->set('strStatus', base64_encode('utilizing_crm'));
        }
    }

    public function jobboardsusingjobseekerlist() {

        $this->layout = "admin";
        $this->loadModel('JobStatistics');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if ($intPortalId != "" && $strStartDate != '') {
            if ($intPortalId == 'all') {
                $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingJobBoardList($strStartDate, $strEndDate, $intPortalId = "");
            } else {
                $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingJobBoardList($strStartDate, $strEndDate, $intPortalId);
            }

            if (is_array($arrJobsViews) && (count($arrJobsViews) > 0)) {
                $this->loadModel('Portal');
                $intPortalDetailCount = 0;
                foreach ($arrJobsViews as $arrPortalDetail) {
                    $arrPortalDetailNew = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $arrPortalDetail['jobberland_graph_statistics']['career_portal_id'])));
                    $arrJobsViews[$intPortalDetailCount]['PortalName']['pname'] = array_pop($arrPortalDetailNew);
                    $intPortalDetailCount++;
                }
            }
            $this->set('arrJobsViews', $arrJobsViews);
            $this->set('portalId', $intPortalId);
            $this->set('strStartDate', base64_encode($strStartDate));
            $this->set('strEndDate', base64_encode($strEndDate));
            $this->set('strStatus', base64_encode('job_boards'));
        }
    }

    public function jobspostedviewjobseekerlist() {
//         Configure::write('debug', '2');
        $this->layout = "admin";
        $this->loadModel('JobStatistics');
        $this->loadModel('Portal');

        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        if ($intPortalId != "" && $strStartDate != '') {
            if ($intPortalId == 'all') {
                $arrJobsViews = $this->JobStatistics->fnGetJobSeekerClickJobsList($strStartDate, $strEndDate, $intPortalId = "");
            } else {
                $arrJobsViews = $this->JobStatistics->fnGetJobSeekerClickJobsList($strStartDate, $strEndDate, $intPortalId);
            }

            if (is_array($arrJobsViews) && (count($arrJobsViews) > 0)) {
                $this->loadModel('Portal');
                $intPortalDetailCount = 0;
                foreach ($arrJobsViews as $arrPortalDetail) {
                    $arrPortalDetailNew = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $arrPortalDetail['jobberland_graph_statistics']['career_portal_id'])));
                    $arrJobsViews[$intPortalDetailCount]['PortalName']['pname'] = array_pop($arrPortalDetailNew);
                    $intPortalDetailCount++;
                }
            }
            $this->set('arrJobsViews', $arrJobsViews);
            $this->set('portalId', $intPortalId);
            $this->set('strStartDate', base64_encode($strStartDate));
            $this->set('strEndDate', base64_encode($strEndDate));
            $this->set('strStatus', base64_encode('posted_job'));
        }
    }

    public function jobCRMExport() {
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $strStatus = base64_decode($_GET['Status']);

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Portal');
        $this->loadModel('PortalUser');
        $this->loadModel('JobStatistics');

        if ($strStatus == 'utilizing_crm') {
            if (!empty($strStartDate)) {
                if ($intPortalId == 'all') {
                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingCRMList($strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingCRMList($strStartDate, $strEndDate, $intPortalId);
                }
            }
        } else if ('job_boards') {
            if (!empty($strStartDate)) {
                if ($intPortalId == 'all') {
                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingJobBoardList($strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingJobBoardList($strStartDate, $strEndDate, $intPortalId);
                }
            }
        } else {
            if (!empty($strStartDate)) {
                if ($intPortalId == 'all') {
                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingJobBoardList($strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrJobsViews = $this->JobStatistics->fnGetJobSeekerUsingJobBoardList($strStartDate, $strEndDate, $intPortalId);
                }
            }
        }

        if (is_array($arrJobsViews) && (count($arrJobsViews) > 0)) {
            $this->loadModel('Portal');
            $intPortalDetailCount = 0;
            foreach ($arrJobsViews as $arrPortalDetail) {
                $arrPortalDetailNew = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $arrPortalDetail['jobberland_graph_statistics']['career_portal_id'])));
                $arrJobsViews[$intPortalDetailCount]['PortalName']['pname'] = array_pop($arrPortalDetailNew);
                $intPortalDetailCount++;
            }
        }

        if (is_array($arrJobsViews) && count($arrJobsViews) > 0) {
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
            if ($strStatus == 'utilizing_crm') {
                $strFileName = "Utilizing_CRM_Reports.xls";
                $reportName = $arrPortalDet[$intPortalId] . " Utilizing CRM Report";
                $labelName = 'Utilize Date';
            } else if ($strStatus == 'job_boards') {
                $strFileName = "Job_Board_Users_Reports.xls";
                $reportName = $arrPortalDet[$intPortalId] . " Job Board Job Seekers Report";
                $labelName = 'Utilize Date';
            } else {
                $strFileName = "Jobs_View_Users_Reports.xls";
                $reportName = $arrPortalDet[$intPortalId] . " Jobs View Job Seekers Report";
                $labelName = 'View Date';
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
                    ->setCellValue('F5', $labelName);

            foreach ($arrJobsViews as $k => $arrUsers) {
                $candidateFirstName = $arrUsers['career_portal_candidate']['candidate_first_name'];
                $candidateLastName = $arrUsers['career_portal_candidate']['candidate_last_name'];
                $candidateEmail = $arrUsers['career_portal_candidate']['candidate_email'];
                $PortalName = $arrPortalDet[$intPortalId];
                $candidateCreationDate = date('Y-m-d', strtotime($arrUsers['jobberland_graph_statistics']['action_date']));

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

    public function vendorsExport() {
        $intPortalId = $_GET['portalId'];
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);

        App::import('Vendor', 'PHPExcel');
        $arrLoggedUser = $this->Auth->user();
        $this->loadModel('Portal');
        $this->loadModel('Resourceorderdetail');

        if ($intPortalId != "" && $strStartDate != '') {
            if ($intPortalId == 'all') {
                $arrNewVendors = $this->Resourceorderdetail->fnGetNewVendorAddedList($strStartDate, $strEndDate, $intPortalId);
            } else {
                $arrNewVendors = $this->Resourceorderdetail->fnGetNewVendorAddedList($strStartDate, $strEndDate, $intPortalId);
            }
        }

        if (is_array($arrNewVendors) && count($arrNewVendors) > 0) {
            $arrPortalDet = $this->Portal->find('list', array('fields' => array('career_portal_id', 'career_portal_name'), 'conditions' => array('career_portal_id' => $intPortalId)));
            $strFileName = "New_Vendors_Added_Reports.xls";
            $reportName = $arrPortalDet[$intPortalId] . " New Vendors Added Career Portal Report";
            $labelName = 'Added Date';

            $intFrCnt = 0;
            $intRowCnt = 6;
            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setLastModifiedBy($arrLoggedUser['employer_user_fname'] . " " . $arrLoggedUser['employer_user_lname'])
                    ->setTitle("New Vendors Added Analytics Report")
                    ->setSubject("New Vendors Added Analytics Report")
                    ->setDescription("New Vendors Added Analytics Report")
                    ->setKeywords("New Vendors Added Analytics Report")
                    ->setCategory("New Vendors Added Analytics Report file");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Id')
                    ->setCellValue('B5', 'First Name')
                    ->setCellValue('C5', 'Last Name')
                    ->setCellValue('D5', 'Vendor Email')
                    ->setCellValue('E5', 'Vendor Type')
                    ->setCellValue('F5', 'Vendor Phone')
                    ->setCellValue('G5', $labelName);

            foreach ($arrNewVendors as $k => $arrVendors) {
                $vendorEmail = stripslashes($arrVendors['vendors']['vendor_email']);
                $vendorFirstName = stripslashes($arrVendors['vendors']['vendor_first_name']);
                $vendorLastName = stripslashes($arrVendors['vendors']['vendor_last_name']);
                $vendorType = stripslashes($arrVendors['vendors']['vendor_type']);
                $vendorPhone = stripslashes($arrVendors['vendors']['vendor_phone']);
                $addedDate = $arrVendors['sub_vendor_order_service']['inserted_date_time'];

                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $intRowCnt, $k + 1)
                        ->setCellValue('B' . $intRowCnt, $vendorFirstName)
                        ->setCellValue('C' . $intRowCnt, $vendorLastName)
                        ->setCellValue('D' . $intRowCnt, $vendorEmail)
                        ->setCellValue('E' . $intRowCnt, $vendorType)
                        ->setCellValue('F' . $intRowCnt, $vendorPhone)
                        ->setCellValue('G' . $intRowCnt, $addedDate);

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
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);  //set column C width

                $objPHPExcel->getActiveSheet()->getRowDimension($intRowCnt)->setRowHeight(20);  //set row 4 height

                $intFrCnt++;
                $intRowCnt++;
            }

            $objPHPExcel->getActiveSheet()->mergeCells('C2:F2');
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

    public function paidPayoutsExport() {
        $portalId = base64_decode($_GET['portalId']);
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
        $this->loadModel('Employer');
        $this->loadModel('Vendorpayout');

        if ($payoutType != '') {
            if ($payoutType == 'vendor') {
                if ($portalId == 'all') {
                    $arrPaidPayoutDetails = $this->PayoutPaymentDetails->fnGetVendorPaidPayoutList($intVendorId, $strStartDate, $strEndDate, $portalId = "");
                } else {
                    $arrPaidPayoutDetails = $this->PayoutPaymentDetails->fnGetVendorPaidPayoutList($intVendorId, $strStartDate, $strEndDate, $portalId);
                }
                $this->loadModel('Vendorpayout');
                $VendorPaymentDetails = $this->Vendorpayout->find('all', array('conditions' => array('vendor_id' => $intVendorId)));
            } else {
                if ($portalId == 'all') {
                    $arrPaidPayoutDetails = $this->PayoutPaymentDetails->fnGetOwnerPaidPayoutList($intOwnerId, $strStartDate, $strEndDate, $portalId = "");
                } else {
                    $arrPaidPayoutDetails = $this->PayoutPaymentDetails->fnGetOwnerPaidPayoutList($intOwnerId, $strStartDate, $strEndDate, $portalId);
                }
                $this->loadModel('Employer');
                $OwnerPaymentDetails = $this->Employer->find('all', array('conditions' => array('employer_id' => $intOwnerId)));
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
                    $bankAccountNumber = stripslashes($VendorPaymentDetails[0]['Vendorpayout']['bank_account_number']);
                    $bankRoutingNumber = stripslashes($VendorPaymentDetails[0]['Vendorpayout']['bank_routing_number']);
                } else {
                    $VendorName = stripslashes($ownerName);
                    $bankAccountNumber = stripslashes($OwnerPaymentDetails[0]['Employer']['bank_account_number']);
                    $bankRoutingNumber = stripslashes($OwnerPaymentDetails[0]['Employer']['bank_routing_number']);
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
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);  //set column C width
                $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);  //set column C width

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
            if ($visiterType == "visit") {
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

    public function createRange($start, $end, $interval, $format) {
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
    
    public function totalsaleeachportalownerlist() {
//        Configure::write('debug','2');
        $this->layout = "admin";
        $this->loadModel('Resourceorderdetail');
//        $this->loadModel('Vendors');

        $intPortalId = base64_decode($_GET['portalId']);
        $strStartDate = base64_decode($_GET['startDate']);
        $strEndDate = base64_decode($_GET['endDate']);
        $intOwnerId = base64_decode($_GET['Owner']);
        
//        echo '<pre>';print_r($_GET);die;
        
        
//        $arrVendorDetails = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $subVendor)));
//        $ownerName = $arrVendorDetails[0]['Vendors']['vendor_first_name'] . " " . $arrVendorDetails[0]['Vendors']['vendor_last_name'];

        if ($intPortalId != "" && $strStartDate != '') {
            if ($intOwnerId == '') {
                if ($intPortalId == 'all') {
                    $arrVendorSaleOrders = $this->Resourceorderdetail->fnGetAdminTotalOwnerSaleOrderAmountList($intOwnerId = "", $strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrVendorSaleOrders = $this->Resourceorderdetail->fnGetAdminTotalOwnerSaleOrderAmountList($intOwnerId = "", $strStartDate, $strEndDate, $intPortalId);
                }
            } else {
                if ($intPortalId == 'all') {
                    $arrVendorSaleOrders = $this->Resourceorderdetail->fnGetAdminTotalOwnerSaleOrderAmountList($intOwnerId, $strStartDate, $strEndDate, $intPortalId = "");
                } else {
                    $arrVendorSaleOrders = $this->Resourceorderdetail->fnGetAdminTotalOwnerSaleOrderAmountList($intOwnerId, $strStartDate, $strEndDate, $intPortalId);
                }
            }
        }
        
//        echo '<pre>';print_r($arrVendorSaleOrders);die;

        $this->set('arrVendorSaleOrders', $arrVendorSaleOrders);
        $this->set('portalId', $intPortalId);
        $this->set('strStartDate', base64_encode($strStartDate));
        $this->set('strEndDate', base64_encode($strEndDate));
        $this->set('strOwnerId', base64_encode($intOwnerId));
        $this->set('ownerName', $ownerName);
    }
}

?>
