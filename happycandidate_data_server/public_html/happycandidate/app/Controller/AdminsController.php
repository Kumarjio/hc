<?php

class AdminsController extends AppController {

    var $helpers = array('Html', 'Form');
    var $name = 'Admins';

    public function beforeFilter() {
        //$this->Auth->autoRedirect = false;
        parent::beforeFilter();
        $this->Auth->allow('index');
    }

    public function logout($strLoginAs = "") {
        if ($strLoginAs) {
            $strLoggedOut = $this->Auth->logout();
            //$this->redirect($_SESSION['urltogo']."")
            if ($strLoggedOut) {
                $strUrlToGo = $_SESSION['urltogo'] . "/1";
                $this->redirect($strUrlToGo);
            }
        } else {
            $this->redirect($this->Auth->logout());
        }
    }

    public function dashboard() {
        //Configure::write('debug','2');
        //echo "--".$this->layout;
        $this->loadModel('Portal');
        $intPortalOwners = $this->Portal->find('count');
        $this->set('intPortalOwners', $intPortalOwners);

        $this->loadModel('Candidate');
        $intPortalCandidates = $this->Candidate->find('count');
        $this->set('intPortalCandidates', $intPortalCandidates);

        $this->compTime = $this->Components->load('TimeCalculation');

        $strMonth = $this->compTime->fnFindCurrentMonth();
        $arrNewYear = $this->compTime->fnFindCurrentYear();

        $strDatFormMonthToCompare = $arrNewYear . "-" . $strMonth . "-" . "01 00:00:00";
        $strEndDatFormMonthToCompare = date($arrNewYear . '-' . $strMonth . '-t') . " 23:59:59";
        $this->loadModel('Candidate');
        $arrCandidates = $this->Candidate->find('all', array('conditions' => array('candidate_creation_date >=' => $strDatFormMonthToCompare, 'candidate_creation_date <=' => $strEndDatFormMonthToCompare)));

        $this->set('arrCount', count($arrCandidates));
        $this->loadModel('User');
        $arrUser = $this->User->find('all', array('conditions' => array('user_creation_date >=' => $strDatFormMonthToCompare, 'user_creation_date <=' => $strEndDatFormMonthToCompare)));

//        echo count($arrUser);
        $this->set('arrUser', count($arrUser));
    }

    public function getVendorOrderCountHtml($selectedText, $strStartDate = "", $strEndDate = "") {

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

        $view = new View($this, false);

        $this->loadModel('Candidate');
        $arrCount = $this->Candidate->find('all', array('conditions' => array('candidate_creation_date >=' => $strDatFormMonthToCompare, 'candidate_creation_date <=' => $strEndDatFormMonthToCompare)));
        $this->set('arrCount', count($arrCount));

        $this->loadModel('User');
        $arrUser = $this->User->find('all', array('conditions' => array('user_creation_date >=' => $strDatFormMonthToCompare, 'user_creation_date <=' => $strEndDatFormMonthToCompare)));
        $view->set('arrUser', count($arrUser));
       
        $strWidgetListerHtml = $view->element('admin_chart', ["arrCount" => $arrCount,"arrUser"=>$arrUser]);
        $arrResponse['status'] = "success";
        $arrResponse['html'] = $strWidgetListerHtml;
        echo json_encode($arrResponse);
        exit;
    }

    public function index() {
        //$this->redirect('login');
        //echo $this->layout;
    }

    public function edit() {
        
    }

}

?>
