<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class JobStatistics extends AppModel {

    var $name = 'JobStatistics';
    var $useTable = 'jobberland_graph_statistics';

    public function fnGetJobSeekerClickJobs($strStartDate, $strEndDate,$intPortalId = "") {
        if (!empty($strStartDate) || $intPortalId != '') {
            $strQuery = "SELECT action_date FROM `jobberland_graph_statistics` WHERE jobberland_graph_statistics.action_type = 'job click' AND jobberland_graph_statistics.feature='job boards' AND jobberland_graph_statistics.career_portal_id='" . $intPortalId . "' AND action_date>= '" . $strStartDate . "' AND action_date<= '" . $strEndDate . "' GROUP BY jobberland_graph_statistics.candidate_id";
        } else {
                $strQuery = "SELECT action_date FROM `jobberland_graph_statistics` WHERE jobberland_graph_statistics.action_type = 'job click' AND jobberland_graph_statistics.feature='job boards' GROUP BY jobberland_graph_statistics.candidate_id";
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }

    public function fnGetJobSeekerClickJobsList($strStartDate, $strEndDate,$intPortalId = "") {
        if (!empty($strStartDate) || $intPortalId != '') {
            $strQuery = "SELECT action_date,jobberland_graph_statistics.career_portal_id,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM career_portal_candidate,`jobberland_graph_statistics` WHERE career_portal_candidate.candidate_id=`jobberland_graph_statistics`.candidate_id AND jobberland_graph_statistics.action_type = 'job click' AND jobberland_graph_statistics.feature='job boards' AND jobberland_graph_statistics.career_portal_id='" . $intPortalId . "' AND action_date>= '" . $strStartDate . "' AND action_date<= '" . $strEndDate . "' GROUP BY jobberland_graph_statistics.candidate_id";
        } else {
                $strQuery = "SELECT action_date,jobberland_graph_statistics.career_portal_id,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM career_portal_candidate,`jobberland_graph_statistics` WHERE career_portal_candidate.candidate_id=`jobberland_graph_statistics`.candidate_id AND jobberland_graph_statistics.action_type = 'job click' AND jobberland_graph_statistics.feature='job boards' GROUP BY jobberland_graph_statistics.candidate_id";
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }
    
    public function fnGetJobSeekerUsingJobBoard($strStartDate, $strEndDate,$intPortalId = "") {
        if (!empty($strStartDate) || $intPortalId != '') {
            $strQuery = "SELECT action_date FROM `jobberland_graph_statistics` WHERE jobberland_graph_statistics.feature='job boards' AND jobberland_graph_statistics.career_portal_id='" . $intPortalId . "' AND action_date>= '" . $strStartDate . "' AND action_date<= '" . $strEndDate . "' GROUP BY jobberland_graph_statistics.candidate_id";
        } else {
                $strQuery = "SELECT action_date FROM `jobberland_graph_statistics` WHERE jobberland_graph_statistics.feature='job boards' GROUP BY jobberland_graph_statistics.candidate_id";
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }
    
    public function fnGetJobSeekerUsingJobBoardList($strStartDate, $strEndDate,$intPortalId = "") {
        if (!empty($strStartDate) || $intPortalId != '') {
            $strQuery = "SELECT action_date,jobberland_graph_statistics.career_portal_id,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM career_portal_candidate,`jobberland_graph_statistics` WHERE career_portal_candidate.candidate_id=`jobberland_graph_statistics`.candidate_id AND jobberland_graph_statistics.feature='job boards' AND jobberland_graph_statistics.career_portal_id='" . $intPortalId . "' AND action_date>= '" . $strStartDate . "' AND action_date<= '" . $strEndDate . "' GROUP BY jobberland_graph_statistics.candidate_id";
        } else {
                $strQuery = "SELECT action_date,jobberland_graph_statistics.career_portal_id,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM career_portal_candidate,`jobberland_graph_statistics` WHERE career_portal_candidate.candidate_id=`jobberland_graph_statistics`.candidate_id AND jobberland_graph_statistics.feature='job boards' GROUP BY jobberland_graph_statistics.candidate_id";
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }
    
    public function fnGetJobSeekerUsingCRM($strStartDate, $strEndDate,$intPortalId = "") {
        if (!empty($strStartDate) || $intPortalId != '') {
            $strQuery = "SELECT action_date FROM `jobberland_graph_statistics` WHERE jobberland_graph_statistics.feature='CRM' AND jobberland_graph_statistics.career_portal_id='" . $intPortalId . "' AND action_date>= '" . $strStartDate . "' AND action_date<= '" . $strEndDate . "' GROUP BY jobberland_graph_statistics.candidate_id";
        } else {
                $strQuery = "SELECT action_date FROM `jobberland_graph_statistics` WHERE jobberland_graph_statistics.feature='CRM' GROUP BY jobberland_graph_statistics.candidate_id";
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }
    
    public function fnGetJobSeekerUsingCRMList($strStartDate, $strEndDate,$intPortalId = "") {
        if (!empty($strStartDate) || $intPortalId != '') {
            $strQuery = "SELECT action_date,jobberland_graph_statistics.career_portal_id,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM career_portal_candidate,`jobberland_graph_statistics` WHERE career_portal_candidate.candidate_id=`jobberland_graph_statistics`.candidate_id AND jobberland_graph_statistics.feature='CRM' AND jobberland_graph_statistics.career_portal_id='" . $intPortalId . "' AND action_date>= '" . $strStartDate . "' AND action_date<= '" . $strEndDate . "' GROUP BY jobberland_graph_statistics.candidate_id";
        } else {
                $strQuery = "SELECT action_date,jobberland_graph_statistics.career_portal_id,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM career_portal_candidate,`jobberland_graph_statistics` WHERE career_portal_candidate.candidate_id=`jobberland_graph_statistics`.candidate_id AND jobberland_graph_statistics.feature='CRM' GROUP BY jobberland_graph_statistics.candidate_id";
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }

}
