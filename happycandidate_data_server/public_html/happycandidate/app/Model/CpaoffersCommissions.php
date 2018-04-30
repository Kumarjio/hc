<?php

class CpaoffersCommissions extends AppModel {

    var $name = 'CpaoffersCommissions';
    var $useTable = 'cpa_offers_commissions';
   

    public function beforeSave($options = array()) {
        
    }
    
    public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
        // method content
        $recursive = -1;
        $this->useTable = false;
        $strProductListQueryStart = "SELECT cpa_offers_commissions.*,employer_detail.employer_user_fname,employer_detail.employer_user_lname";
        $strProductListQueryFromcClause = " FROM cpa_offers_commissions,employer_detail";
        $strProductListQuery = $strProductListQueryStart . $strProductListQueryFromcClause;
        $strProductListQueryWhereClause4 = " WHERE cpa_offers_commissions.portal_owner_id=employer_detail.employer_id";
        
        $strProductListQuery = $strProductListQuery.$strProductListQueryWhereClause4;
        $strProductListQuery .= " ORDER BY offer_commission_id ";
        $strProductListQuery .= " LIMIT " . (($page - 1) * $limit) . ', ' . $limit;
//        echo $strProductListQuery;exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

                
    public function fnGetOwnerCPAOfferPayoutCount($ownerId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($ownerId == 'all') {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost FROM `cpa_offers_commissions` WHERE cpa_offers_commissions.payout_status='0' AND cpa_offers_commissions.added_date >= '" . $strStartDateTime . "' AND cpa_offers_commissions.added_date <= '" . $strEndDateTime . "'";
            } else {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost FROM `cpa_offers_commissions` WHERE cpa_offers_commissions.portal_owner_id = '" . $ownerId . "' AND cpa_offers_commissions.payout_status='0' AND cpa_offers_commissions.added_date >= '" . $strStartDateTime . "' AND cpa_offers_commissions.added_date <= '" . $strEndDateTime . "'";
            }
        } else {
            if ($ownerId == 'all') {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost FROM `cpa_offers_commissions` WHERE cpa_offers_commissions.payout_status='0'";
            } else {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost FROM `cpa_offers_commissions` WHERE cpa_offers_commissions.portal_owner_id = '" . $ownerId . "' AND cpa_offers_commissions.payout_status='0'";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }
    
    public function fnGetOwnerCPAComissionList($ownerId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($ownerId == 'all') {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost,cpa_offers_commissions.*,cpa_offers.offer_name FROM `cpa_offers_commissions`,`cpa_offers` WHERE cpa_offers_commissions.offer_id = cpa_offers.pf_offer_id AND cpa_offers_commissions.payout_status='0' AND cpa_offers_commissions.added_date >= '" . $strStartDateTime . "' AND cpa_offers_commissions.added_date <= '" . $strEndDateTime . "' GROUP BY cpa_offers_commissions.portal_owner_id";
            } else {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost,cpa_offers_commissions.*,cpa_offers.offer_name FROM `cpa_offers_commissions`,`cpa_offers` WHERE cpa_offers_commissions.offer_id = cpa_offers.pf_offer_id AND cpa_offers_commissions.portal_owner_id = '" . $ownerId . "' AND cpa_offers_commissions.payout_status='0' AND cpa_offers_commissions.added_date >= '" . $strStartDateTime . "' AND cpa_offers_commissions.added_date <= '" . $strEndDateTime . "' GROUP BY cpa_offers_commissions.portal_owner_id";
            }
        } else {
            if ($ownerId == 'all') {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost,cpa_offers_commissions.*,cpa_offers.offer_name FROM `cpa_offers_commissions`,`cpa_offers` WHERE cpa_offers_commissions.offer_id = cpa_offers.pf_offer_id AND cpa_offers_commissions.payout_status='0' GROUP BY cpa_offers_commissions.portal_owner_id";
            } else {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost,cpa_offers_commissions.*,cpa_offers.offer_name FROM `cpa_offers_commissions`,`cpa_offers` WHERE cpa_offers_commissions.offer_id = cpa_offers.pf_offer_id AND cpa_offers_commissions.portal_owner_id = '" . $ownerId . "' AND cpa_offers_commissions.payout_status='0' GROUP BY cpa_offers_commissions.portal_owner_id";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }
    
    public function fnGetOwnerPaidComissionCount($ownerId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strStartDateTime = $strStartDateTime . " 00:00:00";
            $strEndDateTime = $strEndDateTime . " 23:59:59";
            if ($ownerId == 'all' || $ownerId == '') {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost FROM `cpa_offers_commissions` WHERE cpa_offers_commissions.payout_status='1' AND cpa_offers_commissions.payout_date >= '" . $strStartDateTime . "' AND cpa_offers_commissions.payout_date <= '" . $strEndDateTime . "'";
            } else {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost FROM `cpa_offers_commissions` WHERE cpa_offers_commissions.portal_owner_id = '" . $ownerId . "' AND cpa_offers_commissions.payout_status='1' AND cpa_offers_commissions.payout_date >= '" . $strStartDateTime . "' AND cpa_offers_commissions.payout_date <= '" . $strEndDateTime . "'";
            }
        } else {
            if ($ownerId == 'all' || $ownerId == '') {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost FROM `cpa_offers_commissions` WHERE cpa_offers_commissions.payout_status='1'";
            } else {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost FROM `cpa_offers_commissions` WHERE cpa_offers_commissions.portal_owner_id = '" . $ownerId . "' AND cpa_offers_commissions.payout_status='1'";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }
    
    public function fnGetOwnerPaidComissionList($ownerId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strStartDateTime = $strStartDateTime . " 00:00:00";
            $strEndDateTime = $strEndDateTime . " 23:59:59";
            if ($ownerId == 'all' || $ownerId == '') {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost,cpa_offers_commissions.*,cpa_offers.offer_name FROM `cpa_offers_commissions`,`cpa_offers` WHERE cpa_offers_commissions.offer_id = cpa_offers.pf_offer_id AND cpa_offers_commissions.payout_status='1' AND cpa_offers_commissions.payout_date >= '" . $strStartDateTime . "' AND cpa_offers_commissions.payout_date <= '" . $strEndDateTime . "' GROUP BY cpa_offers_commissions.portal_owner_id";
            } else {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost,cpa_offers_commissions.*,cpa_offers.offer_name FROM `cpa_offers_commissions`,`cpa_offers` WHERE cpa_offers_commissions.offer_id = cpa_offers.pf_offer_id AND cpa_offers_commissions.portal_owner_id = '" . $ownerId . "' AND cpa_offers_commissions.payout_status='1' AND cpa_offers_commissions.payout_date >= '" . $strStartDateTime . "' AND cpa_offers_commissions.payout_date <= '" . $strEndDateTime . "' GROUP BY cpa_offers_commissions.portal_owner_id";
            }
        } else {
            if ($ownerId == 'all' || $ownerId == '') {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost,cpa_offers_commissions.*,cpa_offers.offer_name FROM `cpa_offers_commissions`,`cpa_offers` WHERE cpa_offers_commissions.offer_id = cpa_offers.pf_offer_id AND cpa_offers_commissions.payout_status='1' GROUP BY cpa_offers_commissions.portal_owner_id";
            } else {
                $strProductListQuery = "SELECT SUM(cpa_offers_commissions.portal_cost) AS commission_cost,cpa_offers_commissions.*,cpa_offers.offer_name FROM `cpa_offers_commissions`,`cpa_offers` WHERE cpa_offers_commissions.offer_id = cpa_offers.pf_offer_id AND cpa_offers_commissions.portal_owner_id = '" . $ownerId . "' AND cpa_offers_commissions.payout_status='1' GROUP BY cpa_offers_commissions.portal_owner_id";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }
}

?>