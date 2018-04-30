<?php

class PortalDomain extends AppModel {

    public $name = 'PortalDomain';
    public $useTable = 'career_portal_domain';

    public function fnGetPortalDomainCost($strStartDate, $strEndDate, $intPortalId, $datePeriod = "") {
        if (!empty($strStartDate)) {
            if ($intPortalId != '' && $intPortalId != 'All') {
                $strQuery = "SELECT distinct sum(career_portal_domain_amount)as total,career_portal_purchased_date FROM `career_portal_domain` WHERE career_portal_domain.career_portal_domain_payment_status = 1 AND career_portal_id='".$intPortalId."' AND career_portal_purchased_date >= '" . $strStartDate . "' AND career_portal_purchased_date<= '" . $strEndDate . "' GROUP BY $datePeriod(career_portal_purchased_date)";
            } else {
                $strQuery = "SELECT distinct sum(career_portal_domain_amount) as total,career_portal_purchased_date FROM `career_portal_domain` WHERE career_portal_domain.career_portal_domain_payment_status = 1 AND career_portal_purchased_date >= '" . $strStartDate . "' AND career_portal_purchased_date<= '" . $strEndDate . "' GROUP BY $datePeriod(career_portal_purchased_date)";
            }
        } else {
            if ($intPortalId != '' && $intPortalId != 'All') {
                $strQuery = "SELECT distinct sum(career_portal_domain_amount) as total,career_portal_purchased_date FROM `career_portal_domain` WHERE career_portal_domain.career_portal_domain_payment_status = 1 AND career_portal_id='".$intPortalId."' GROUP BY $datePeriod(career_portal_purchased_date)";
            } else {
                $strQuery = "SELECT distinct sum(career_portal_domain_amount) as total,career_portal_purchased_date FROM `career_portal_domain` WHERE career_portal_domain.career_portal_domain_payment_status = 1 GROUP BY $datePeriod(career_portal_purchased_date)";
            }
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }
    
    public function fnGetPortalDomainCostList($strStartDate, $strEndDate, $intPortalId) {
        if (!empty($strStartDate)) {
            if ($intPortalId != '' && $intPortalId != 'All') {
                $strQuery = "SELECT career_portal_domain_amount,career_portal_purchased_date,career_portal_domain_name,career_portal_order_id,career_portal_domain_status,career_portal_id FROM `career_portal_domain` WHERE career_portal_domain.career_portal_domain_payment_status = 1 AND career_portal_id='".$intPortalId."' AND career_portal_purchased_date >= '" . $strStartDate . "' AND career_portal_purchased_date<= '" . $strEndDate . "'";
            } else {
                $strQuery = "SELECT career_portal_domain_amount,career_portal_purchased_date,career_portal_domain_name,career_portal_order_id,career_portal_domain_status,career_portal_id FROM `career_portal_domain` WHERE career_portal_domain.career_portal_domain_payment_status = 1 AND career_portal_purchased_date >= '" . $strStartDate . "' AND career_portal_purchased_date<= '" . $strEndDate . "'";
            }
        } else {
            if ($intPortalId != '' && $intPortalId != 'All') {
                $strQuery = "SELECT career_portal_domain_amount,career_portal_purchased_date,career_portal_domain_name,career_portal_order_id,career_portal_domain_status,career_portal_id FROM `career_portal_domain` WHERE career_portal_domain.career_portal_domain_payment_status = 1 AND career_portal_id='".$intPortalId."'";
            } else {
                $strQuery = "SELECT career_portal_domain_amount,career_portal_purchased_date,career_portal_domain_name,career_portal_order_id,career_portal_domain_status,career_portal_id FROM `career_portal_domain` WHERE career_portal_domain.career_portal_domain_payment_status = 1";
            }
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }
}
