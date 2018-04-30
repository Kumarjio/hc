<?php

class PayoutPaymentDetails extends AppModel {

    var $name = 'PayoutPaymentDetails';
    var $useTable = 'payout_payment_details';

    public function fnGetVendorPaidPayoutGraphCount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "", $intPortalId = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strStartDateTime = $strStartDateTime . " 00:00:00";
            $strEndDateTime = $strEndDateTime . " 23:59:59";
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE payout_payment_details.vendor_id = '" . $intVendorId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "'";
            } else {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE `payout_payment_details`.order_from_portal='" . $intPortalId . "' AND payout_payment_details.vendor_id = '" . $intVendorId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "'";
            }
        } else {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE payout_payment_details.vendor_id = '" . $intVendorId . "' AND payout_payment_details.payout_status='1'";
            } else {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE `payout_payment_details`.order_from_portal='" . $intPortalId . "' AND payout_payment_details.vendor_id = '" . $intVendorId . "' AND payout_payment_details.payout_status='1'";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetOwnerPaidPayoutGraphCount($ownerId = "", $strStartDateTime = "", $strEndDateTime = "", $intPortalId = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strStartDateTime = $strStartDateTime . " 00:00:00";
            $strEndDateTime = $strEndDateTime . " 23:59:59";
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE payout_payment_details.owner_id = '" . $ownerId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "'";
            } else {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE `payout_payment_details`.order_from_portal='" . $intPortalId . "' AND payout_payment_details.owner_id = '" . $ownerId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "'";
            }
        } else {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE payout_payment_details.owner_id = '" . $ownerId . "' AND payout_payment_details.payout_status='1'";
            } else {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE `payout_payment_details`.order_from_portal='" . $intPortalId . "' AND payout_payment_details.owner_id = '" . $ownerId . "' AND payout_payment_details.payout_status='1'";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetVendorPaidPayoutList($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "", $intPortalId = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strStartDateTime = $strStartDateTime . " 00:00:00";
            $strEndDateTime = $strEndDateTime . " 23:59:59";
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT payout_amount,payout_date,payout_status,payout_from_date,payout_to_date FROM `payout_payment_details` WHERE payout_payment_details.vendor_id = '" . $intVendorId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "' GROUP BY `payout_payment_details`.`vendor_id` ";
            } else {
                $strProductListQuery = "SELECT payout_amount,payout_date,payout_status,payout_from_date,payout_to_date FROM `payout_payment_details` WHERE `payout_payment_details`.order_from_portal='" . $intPortalId . "' AND payout_payment_details.vendor_id = '" . $intVendorId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "' GROUP BY `payout_payment_details`.`vendor_id` ";
            }
        } else {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT payout_amount,payout_date,payout_status,payout_from_date,payout_to_date FROM `payout_payment_details` WHERE payout_payment_details.vendor_id = '" . $intVendorId . "' AND payout_payment_details.payout_status='1' GROUP BY `payout_payment_details`.`vendor_id` ";
            } else {
                $strProductListQuery = "SELECT payout_amount,payout_date,payout_status,payout_from_date,payout_to_date FROM `payout_payment_details` WHERE `payout_payment_details`.order_from_portal='" . $intPortalId . "' AND payout_payment_details.vendor_id = '" . $intVendorId . "' AND payout_payment_details.payout_status='1' GROUP BY `payout_payment_details`.`vendor_id` ";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetOwnerPaidPayoutList($ownerId = "", $strStartDateTime = "", $strEndDateTime = "", $intPortalId = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strStartDateTime = $strStartDateTime . " 00:00:00";
            $strEndDateTime = $strEndDateTime . " 23:59:59";
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT payout_amount,payout_date,payout_status,payout_from_date,payout_to_date FROM `payout_payment_details` WHERE payout_payment_details.owner_id = '" . $ownerId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "' GROUP BY `payout_payment_details`.`owner_id` ";
            } else {
                $strProductListQuery = "SELECT payout_amount,payout_date,payout_status,payout_from_date,payout_to_date FROM `payout_payment_details` WHERE `payout_payment_details`.order_from_portal='" . $intPortalId . "' AND payout_payment_details.owner_id = '" . $ownerId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "' GROUP BY `payout_payment_details`.`owner_id` ";
            }
        } else {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT payout_amount,payout_date,payout_status,payout_from_date,payout_to_date FROM `payout_payment_details` WHERE payout_payment_details.owner_id = '" . $ownerId . "' AND payout_payment_details.payout_status='1' GROUP BY `payout_payment_details`.`owner_id` ";
            } else {
                $strProductListQuery = "SELECT payout_amount,payout_date,payout_status,payout_from_date,payout_to_date FROM `payout_payment_details` WHERE `payout_payment_details`.order_from_portal='" . $intPortalId . "' AND payout_payment_details.owner_id = '" . $ownerId . "' AND payout_payment_details.payout_status='1' GROUP BY `payout_payment_details`.`owner_id` ";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    /** Manage Payout section **/
    public function fnGetVendorPaidPayoutCount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strStartDateTime = $strStartDateTime . " 00:00:00";
            $strEndDateTime = $strEndDateTime . " 23:59:59";
            if ($intVendorId == 'all' || $intVendorId == '') {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='vendor' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "'";
            } else {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE payout_payment_details.vendor_id = '" . $intVendorId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='vendor' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "'";
            }
        } else {
            if ($intVendorId == 'all' || $intVendorId == '') {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='vendor'";
            } else {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE payout_payment_details.vendor_id = '" . $intVendorId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='vendor'";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetOwnerPaidPayoutCount($ownerId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strStartDateTime = $strStartDateTime . " 00:00:00";
            $strEndDateTime = $strEndDateTime . " 23:59:59";
            if ($ownerId == 'all' || $ownerId == '') {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='owner' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "'";
            } else {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE payout_payment_details.owner_id = '" . $ownerId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='owner' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "'";
            }
        } else {
            if ($ownerId == 'all' || $ownerId == '') {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='owner'";
            } else {
                $strProductListQuery = "SELECT SUM(payout_payment_details.payout_amount) AS amount FROM `payout_payment_details` WHERE payout_payment_details.owner_id = '" . $ownerId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='owner'";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }
    
    public function fnGetVendorPaidPayoutNewList($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "", $intPortalId = "") {
        if ($strStartDateTime && $strEndDateTime) {
//            $strStartDateTime = $strStartDateTime . " 00:00:00";
//            $strEndDateTime = $strEndDateTime . " 23:59:59";
            if ($intVendorId == 'all' || $intVendorId == '') {
                $strProductListQuery = "SELECT payout_amount,payout_date,vendor_id,payout_from_date,payout_to_date FROM `payout_payment_details` WHERE payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='vendor' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "' GROUP BY `payout_payment_details`.`vendor_id` ";
            } else {
                $strProductListQuery = "SELECT payout_amount,payout_date,vendor_id,payout_from_date,payout_to_date FROM `payout_payment_details` WHERE payout_payment_details.vendor_id = '" . $intVendorId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='vendor' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "' GROUP BY `payout_payment_details`.`vendor_id` ";
            }
        } else {
            if ($intVendorId == 'all' || $intVendorId == '') {
                $strProductListQuery = "SELECT payout_amount,payout_date,vendor_id,payout_from_date,payout_to_date FROM `payout_payment_details` WHERE payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='vendor' GROUP BY `payout_payment_details`.`vendor_id` ";
            } else {
                $strProductListQuery = "SELECT payout_amount,payout_date,vendor_id,payout_from_date,payout_to_date FROM `payout_payment_details` WHERE payout_payment_details.vendor_id = '" . $intVendorId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='vendor' GROUP BY `payout_payment_details`.`vendor_id` ";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetOwnerPaidPayoutNewList($ownerId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($ownerId == 'all' || $ownerId == '') {
                $strProductListQuery = "SELECT payout_amount,payout_date,payout_from_date,payout_to_date,owner_id FROM `payout_payment_details` WHERE payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='owner' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "' GROUP BY `payout_payment_details`.`owner_id` ";
            } else {
                $strProductListQuery = "SELECT payout_amount,payout_date,payout_from_date,payout_to_date,owner_id FROM `payout_payment_details` WHERE payout_payment_details.owner_id = '" . $ownerId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='owner' AND payout_payment_details.payout_date >= '" . $strStartDateTime . "' AND payout_payment_details.payout_date <= '" . $strEndDateTime . "' GROUP BY `payout_payment_details`.`owner_id` ";
            }
        } else {
            if ($ownerId == 'all' || $ownerId == '') {
                $strProductListQuery = "SELECT payout_amount,payout_date,payout_from_date,payout_to_date,owner_id FROM `payout_payment_details` WHERE payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='owner' GROUP BY `payout_payment_details`.`owner_id` ";
            } else {
                $strProductListQuery = "SELECT payout_amount,payout_date,payout_from_date,payout_to_date,owner_id FROM `payout_payment_details` WHERE payout_payment_details.owner_id = '" . $ownerId . "' AND payout_payment_details.payout_status='1' AND payout_payment_details.payout_for='owner' GROUP BY `payout_payment_details`.`owner_id` ";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }
    
    /** Manage Payout section **/

}

?>