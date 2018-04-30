<?php

class PortalVisitors extends AppModel {

    public $name = 'PortalVisitors';
    public $useTable = 'career_portal_visitors';

    public function fnGetVisitorsCount($intPortalId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT DISTINCT career_portal_visitors.ip_address,portal_id FROM `career_portal_visitors` WHERE career_portal_visitors.visited_date >= '" . $strStartDateTime . "' AND career_portal_visitors.visited_date <= '" . $strEndDateTime . "' GROUP BY (career_portal_visitors.unique_value)";
            } else {
                $strProductListQuery = "SELECT DISTINCT career_portal_visitors.ip_address,portal_id FROM `career_portal_visitors` WHERE `career_portal_visitors`.portal_id='" . $intPortalId . "' AND career_portal_visitors.visited_date >= '" . $strStartDateTime . "' AND career_portal_visitors.visited_date <= '" . $strEndDateTime . "' GROUP BY (career_portal_visitors.unique_value)";
            }
        } else {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT career_portal_visitors.ip_address,portal_id FROM `career_portal_visitors` GROUP BY (career_portal_visitors.unique_value)";
            } else {
                $strProductListQuery = "SELECT career_portal_visitors.ip_address,portal_id FROM `career_portal_visitors` WHERE `career_portal_visitors`.portal_id='" . $intPortalId . "' GROUP BY (career_portal_visitors.unique_value)";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetVisitorsList($intPortalId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT ip_address,visited_date,portal_name,portal_id FROM `career_portal_visitors` WHERE career_portal_visitors.visited_date >= '" . $strStartDateTime . "' AND career_portal_visitors.visited_date <= '" . $strEndDateTime . "' GROUP BY (career_portal_visitors.unique_value)";
            } else {
                $strProductListQuery = "SELECT ip_address,visited_date,portal_name,portal_id FROM `career_portal_visitors` WHERE `career_portal_visitors`.portal_id='" . $intPortalId . "' AND career_portal_visitors.visited_date >= '" . $strStartDateTime . "' AND career_portal_visitors.visited_date <= '" . $strEndDateTime . "' GROUP BY (career_portal_visitors.unique_value)";
            }
        } else {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT ip_address,visited_date,portal_name,portal_id FROM `career_portal_visitors` GROUP BY (career_portal_visitors.unique_value)";
            } else {
                $strProductListQuery = "SELECT ip_address,visited_date,portal_name,portal_id FROM `career_portal_visitors` WHERE `career_portal_visitors`.portal_id='" . $intPortalId . "' GROUP BY (career_portal_visitors.unique_value)";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetVisitorsRegisteredCount($intPortalId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT career_portal_visitors.ip_address,portal_id FROM `career_portal_visitors` WHERE career_portal_visitors.registration='Yes' AND career_portal_visitors.visited_date >= '" . $strStartDateTime . "' AND career_portal_visitors.visited_date <= '" . $strEndDateTime . "' GROUP BY (career_portal_visitors.unique_value)";
            } else {
                $strProductListQuery = "SELECT career_portal_visitors.ip_address,portal_id FROM `career_portal_visitors` WHERE career_portal_visitors.registration='Yes' AND `career_portal_visitors`.portal_id='" . $intPortalId . "' AND career_portal_visitors.visited_date >= '" . $strStartDateTime . "' AND career_portal_visitors.visited_date <= '" . $strEndDateTime . "' GROUP BY (career_portal_visitors.unique_value)";
            }
        } else {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT career_portal_visitors.ip_address,portal_id FROM `career_portal_visitors` WHERE career_portal_visitors.registration='Yes' GROUP BY (career_portal_visitors.unique_value)";
            } else {
                $strProductListQuery = "SELECT career_portal_visitors.ip_address,portal_id FROM `career_portal_visitors` WHERE career_portal_visitors.registration='Yes' AND `career_portal_visitors`.portal_id='" . $intPortalId . "' GROUP BY (career_portal_visitors.unique_value)";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetVisitorsRegisteredList($intPortalId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT ip_address,visited_date,portal_name,portal_id FROM `career_portal_visitors` WHERE career_portal_visitors.registration='Yes' AND career_portal_visitors.visited_date >= '" . $strStartDateTime . "' AND career_portal_visitors.visited_date <= '" . $strEndDateTime . "' GROUP BY (career_portal_visitors.unique_value)";
            } else {
                $strProductListQuery = "SELECT ip_address,visited_date,portal_name,portal_id FROM `career_portal_visitors` WHERE career_portal_visitors.registration='Yes' AND `career_portal_visitors`.portal_id='" . $intPortalId . "' AND career_portal_visitors.visited_date >= '" . $strStartDateTime . "' AND career_portal_visitors.visited_date <= '" . $strEndDateTime . "' GROUP BY (career_portal_visitors.unique_value)";
            }
        } else {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT ip_address,visited_date,portal_name,portal_id FROM `career_portal_visitors` WHERE career_portal_visitors.registration='Yes' GROUP BY (career_portal_visitors.unique_value)";
            } else {
                $strProductListQuery = "SELECT ip_address,visited_date,portal_name,portal_id FROM `career_portal_visitors` WHERE career_portal_visitors.registration='Yes' AND `career_portal_visitors`.portal_id='" . $intPortalId . "' GROUP BY (career_portal_visitors.unique_value)";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

}

?>