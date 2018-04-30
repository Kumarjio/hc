<?php

class Resourceorderdetail extends AppModel {

    public $name = 'Resourceorderdetail';
    public $useTable = 'resource_order_detail';
    public $validate = array(
        'content_title' => array(
            'Not Empty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please provide the content title'
            )
        ),
        /* 'content' => array(
          'Not Empty' => array(
          'rule' => 'notEmpty',
          'message' => 'Please provide content'
          )
          ), */
        'content_parent_id' => array(
            'Not Empty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please provide parent content'
            )
        )
    );

    public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
        // method content
        $recursive = -1;
        $this->useTable = false;
        /* print("<pre>");
          print_r($conditions);exit; */
        $strProductListQueryStart = "SELECT *";
        $strProductListQueryFromcClause = " FROM products";
        $strProductListQuery = $strProductListQueryStart . $strProductListQueryFromcClause;
        if (is_array($conditions) && (count($conditions) > 0)) {
            $strProductListQueryWhereClause = " WHERE";
            //$strProductListQueryWhereClause1 = " content.content_id=content_category_assignment.content_id";
            //$strProductListQueryWhereClause2 = " content.content_parent_id IS NULL";
            $strProductListQuery .= $strProductListQueryWhereClause;
            if (isset($conditions['category'])) {
                if ($conditions['No']) {
                    if ($conditions['No'] == "1") {
                        $strProductListQueryWhereClause4 = " content.content_default_category != '" . $conditions['category'] . "' AND job_search_process_content = '0'";
                    } else {
                        $strProductListQueryWhereClause4 = " content.content_default_category != '" . $conditions['category'] . "' AND job_search_process_content = '1'";
                    }
                } else {
                    $strProductListQueryWhereClause4 = " content.content_default_category = '" . $conditions['category'] . "'";
                }
                $strProductListQuery = $strProductListQuery . $strProductListQueryWhereClause4;
            }

            if ($conditions['product_name']) {
                $strProductListQueryWhereClause3 = " products.product_name LIKE '%" . $conditions['product_name'] . "%'";
                $strProductListQuery = $strProductListQuery . $strProductListQueryWhereClause3;
            }
        }
        $strProductListQuery .= " ORDER BY productd_id ASC";
        $strProductListQuery .= " LIMIT " . (($page - 1) * $limit) . ', ' . $limit;
        //echo $strProductListQuery;exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
        // method body
        $strProductListQueryStart = "SELECT *";
        $strProductListQueryFromcClause = " FROM products";
        $strProductListQuery = $strProductListQueryStart . $strProductListQueryFromcClause;
        if (is_array($conditions) && (count($conditions) > 0)) {
            $strProductListQueryWhereClause = " WHERE";
            //$strProductListQueryWhereClause1 = " content.content_id=content_category_assignment.content_id";
            //$strProductListQueryWhereClause2 = " content.content_parent_id IS NULL";
            $strProductListQuery .= $strProductListQueryWhereClause;
            if (isset($conditions['category'])) {
                if ($conditions['No']) {
                    if ($conditions['No'] == "1") {
                        $strProductListQueryWhereClause4 = " content.content_default_category != '" . $conditions['category'] . "' AND job_search_process_content = '0'";
                    } else {
                        $strProductListQueryWhereClause4 = " content.content_default_category != '" . $conditions['category'] . "' AND job_search_process_content = '1'";
                    }
                } else {
                    $strProductListQueryWhereClause4 = " content.content_default_category = '" . $conditions['category'] . "'";
                }

                $strProductListQuery = $strProductListQuery . $strProductListQueryWhereClause4;
            }

            if ($conditions['product_name']) {
                $strProductListQueryWhereClause3 = " products.product_name LIKE '%" . $conditions['product_name'] . "%'";
                $strProductListQuery = $strProductListQuery . $strProductListQueryWhereClause3;
            }
        }
        $this->recursive = $recursive;
        //echo $strProductListQuery;exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        return count($arrProductContentArray);
    }

    public function fnGetNewOrderCount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'New Order' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            //echo $strProductListQuery;exit;
        } else {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'New Order'";
        }
        //echo $strProductListQuery;//exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetSubNewOrderCount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'New Order' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            //echo $strProductListQuery;exit;
        } else {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'New Order'";
        }
        //echo $strProductListQuery;//exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetClosedOrderCount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Closed' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            //echo $strProductListQuery;exit;
        } else {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Closed'";
            //echo $strProductListQuery;exit;
        }

        //echo "--".$strProductListQuery;//exit();
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetSubClosedOrderCount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Closed' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            //echo $strProductListQuery;exit;
        } else {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Closed'";
        }
        //echo $strProductListQuery;//exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetClosedOrderCost($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strProductListQuery = "SELECT sum(vendor_cost) FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Closed' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            //echo $strProductListQuery;exit;
        } else {
            $strProductListQuery = "SELECT sum(vendor_cost) FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Closed'";
            //echo $strProductListQuery;exit;
        }

        //echo "--".$strProductListQuery;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetSubClosedOrderCost($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strProductListQuery = "SELECT sum(vendor_cost) FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Closed' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            //echo $strProductListQuery;exit;
        } else {
            $strProductListQuery = "SELECT sum(vendor_cost) FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Closed'";
        }
        //echo $strProductListQuery;//exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetRefundOrderCost($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strProductListQuery = "SELECT sum(vendor_cost) FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            //echo $strProductListQuery;exit;
        } else {
            $strProductListQuery = "SELECT sum(vendor_cost) FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1";
            //echo $strProductListQuery;exit;
        }

        //echo "--".$strProductListQuery;//exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetSubRefundOrderCost($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strProductListQuery = "SELECT sum(vendor_cost) FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            //echo $strProductListQuery;exit;
        } else {
            $strProductListQuery = "SELECT sum(vendor_cost) FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1";
        }
        //echo $strProductListQuery;//exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetOpenOrderCount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'In-Process' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            //echo $strProductListQuery;exit;
        } else {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'In-Process'";
            //echo $strProductListQuery;exit;
        }
        //echo $strProductListQuery;//exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetSubOpenOrderCount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'In-Process' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            //echo $strProductListQuery;exit;
        } else {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'In-Process'";
        }
        //echo $strProductListQuery;//exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetPendingOrderCount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Pending' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            //echo $strProductListQuery;exit;
        } else {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Pending'";
            //echo $strProductListQuery;exit;
        }
        //echo "--".$strProductListQuery;
        //exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetSubPendingOrderCount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Pending' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            //echo $strProductListQuery;exit;
        } else {
            $strProductListQuery = "SELECT count(*) FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Pending'";
        }
        //echo $strProductListQuery;//exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetOwnerTotal($intOrderId = "", $intPortalId = "") {
        if ($intOrderId) {
            $strProductListQuery = "SELECT SUM(portal_owner_cost) as total_owner_cost,SUM(vendor_cost) as total_vendor_cost,product_id FROM resource_order_detail WHERE resource_order_detail.order_id = '" . $intOrderId . "' AND resource_order_detail.order_from_portal = '" . $intPortalId . "' AND resource_order_detail.payment_status = 'captured' AND resource_order_detail.order_detail_status = 'approved'";
//            echo $strProductListQuery;exit;
            $arrProductContentArray = $this->query($strProductListQuery);
            return $arrProductContentArray;
        } else {
            return false;
        }
    }

    public function fnGetOrderDetail($intOrderId = "") {
        if ($intOrderId) {
            $strProductListQuery = "SELECT resource_order_detail.*,products.*,vendors.* FROM resource_order_detail LEFT JOIN vendors ON resource_order_detail.vendor_id = vendors.vendor_id,products WHERE resource_order_detail.order_id = '" . $intOrderId . "' AND resource_order_detail.product_id = products.productd_id";
            //echo $strProductListQuery;exit;
            $arrProductContentArray = $this->query($strProductListQuery);
            return $arrProductContentArray;
        } else {
            return false;
        }
    }

    public function fnGetBrandedProductDetailsByNameO($strBrandName = "") {
        if ($strBrandName) {
            $strProductListQuery = "SELECT content.content_id,content.content_title,content.content_name, content.content_intro_text,content_product_other_details.content_brand_title,content_product_other_details.content_brand_description FROM content, content_product_other_details WHERE content.content_status = 'published' AND content.content_title LIKE '" . $strBrandName . "%' AND content.content_is_branded = '1' AND content.content_default_category = '4' AND content.content_id = content_product_other_details.content_id ORDER BY content.content_title ASC";

            //echo $strProductListQuery;exit;
            $arrProductContentArray = $this->query($strProductListQuery);
            return $arrProductContentArray;
        } else {
            return false;
        }
    }

    public function fnGetBrandedProductDetailsByNameT($strBrandName = "") {
        if ($strBrandName) {
            $strProductListQuery = "SELECT content.content_id,content.content_title,content.content_name, content.content_intro_text,content_product_other_details.content_brand_title,content_product_other_details.content_brand_description FROM content, content_product_other_details WHERE content.content_status = 'published' AND content.content_title LIKE '" . $strBrandName . "%' AND content.content_is_branded = '1' AND content.content_default_category = '4' AND content.content_id = content_product_other_details.content_id ORDER BY content.content_title ASC";

            //echo $strProductListQuery;exit;
            $arrProductContentArray = $this->query($strProductListQuery);
            return $arrProductContentArray;
        } else {
            return false;
        }
    }

    public function fnGetBrandedProductDetailsByName($strBrandName = "") {
        if ($strBrandName) {
            $strProductListQuery = "SELECT content.content_id,content.content_title,content.content_name, content.content_intro_text,content_product_other_details.content_brand_title,content_product_other_details.content_brand_description FROM content, content_product_other_details WHERE content.content_status = 'published' AND content.content_title LIKE '" . $strBrandName . "%' AND content.content_is_branded = '1' AND content.content_default_category = '4' AND content.content_id = content_product_other_details.content_id ORDER BY content.content_title ASC";

            //echo $strProductListQuery;exit;
            $arrProductContentArray = $this->query($strProductListQuery);
            return $arrProductContentArray;
        } else {
            return false;
        }
    }

    public function fnGetBasicContactDetails($intProductId) {
        $strProductListQuery = "SELECT content.content_id,content.content_contact_form_title,content.content_contact_form_name, content.cont_contact_to,content.cont_contact_cc,cont_contact_bcc,content.cont_contact_subject,contact_address FROM content WHERE content.content_id='" . $intProductId . "'";
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetContentParentData($intProductId, $intCatuser) {
        $strProductListQuery = "SELECT content.content_id,content.content_parent_id FROM content WHERE content.content_id='" . $intProductId . "' AND content_for_user='" . $intCatuser . "'";
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetNewsContentForYear($strNewsYear = "") {
        if ($strNewsYear) {
            $strContentAsPerDateQuery = "SELECT Content.content_id, Content.content_name, Content.content_intro_text, Content.content, Content.content_published_date FROM content AS Content, content_category,content_category_assignment WHERE Content.content_published_date >='" . $strNewsYear . "-01-01 00:00:00' AND Content.content_published_date <= '" . $strNewsYear . "-12-31 23:59:59' AND content_category_assignment.content_id = Content.content_id AND content_category.content_category_id = '3' AND content_category_assignment.category_id = content_category.content_category_id";
            $arrContentAsPerDate = $this->query($strContentAsPerDateQuery);
            return $arrContentAsPerDate;
        }
    }

    public function fnGetProductsFeaturedDetails($intProductId) {
        $strProductListQuery = "SELECT content.content_id,content.content_is_featured,content.content_featured_image,content_media.content_media_title FROM content LEFT JOIN content_media ON content_media.content_media_id = content.content_featured_image WHERE content.content_id='" . $intProductId . "'";
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetBrandedProductDetails($intProductId) {
        $strProductListQuery = "SELECT content.content_id,content.content_is_branded FROM content WHERE content.content_id='" . $intProductId . "'";
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetProduct($intProductId) {
        $strProductListQuery = "SELECT content.content_id,content.content_title,content.content_type,content.content_for_user,content.content_name,content.content_intro_text,content.content_title_alias,content.content_status,content.content_layout,content.content_banner_image,content.content_intro_text,content.content,content.content_meta_title,content.content_meta_keyword,content.content_meta_description,content.content_meta_other,content.content_left_content,content.content_right_content,content.content_widget_assignment,content.content_left_widget_assignment,content.content_right_widget_assignment,content.content_related_products_assign,content.content_published_date,content_media.content_media_title FROM content LEFT JOIN content_media ON content_media.content_media_id = content.content_banner_image WHERE content.content_id='" . $intProductId . "'";
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetProductList() {
        $strProductListQuery = "SELECT content.content_id,content.content_title,content.content_status,content.created_date,content.modified_date FROM content,content_category_assignment WHERE content.content_id=content_category_assignment.content_id AND content_category_assignment.category_id = '4'";

        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnFormatArray($arrToFormat = array(), $arrTobeFormattedFrom = array()) {
        if (is_array($arrTobeFormattedFrom) && (count($arrTobeFormattedFrom) > 0)) {
            foreach ($arrTobeFormattedFrom as $key => $val) {
                $arrToFormat[0][$key] = $val;
            }

            return $arrToFormat;
        } else {
            return false;
        }
    }

    public function fnGetContents() {
        $arrContentArray = $this->query("SELECT * FROM content WHERE content_type='Content'");
        return $arrContentArray;
    }

    public function fnGetPages() {
        $arrContentArray = $this->query("SELECT * FROM content WHERE content_type='Pages'");
        return $arrContentArray;
    }

    public function fnGetProductListForHomePage($cat = "") {
        $strContentAsPerCatQuery = "SELECT DISTINCT content.content_id, content.content_name, content.content_title, content_category_assignment.category_id";
        if ($cat == '') {
            $strContentAsPerCatQuery .= " FROM content_category_assignment INNER JOIN content ON content_category_assignment.content_id = content.content_id  AND content_category_assignment.category_id !=  '201' AND content_status='published' AND content_default_category='4' AND content_parent_id IS NULL";
        } else {
            $strContentAsPerCatQuery .= " FROM content INNER JOIN content_category_assignment ON content_category_assignment.content_id = content.content_id  AND content_category_assignment.category_id =  '201' AND content_status='published' AND content_default_category='4' AND content_parent_id IS NULL";
        }
        $strContentAsPerCatQuery .= " ORDER BY content.content_title";
        $strContentAsPerCat = $this->query($strContentAsPerCatQuery);
        return $strContentAsPerCat;
    }

    public function fnGetDistinctContentType($intCatId, $intContForUser = "3") {

        if ($intCatId) {
            $strContentQuery = " SELECT DISTINCT(content.content_type) FROM content,content_category,content_category_assignment WHERE content.content_id = content_category_assignment.content_id AND content_category.content_category_id = content_category_assignment.category_id AND content_category.content_category_id = '" . $intCatId . "' AND content_status = 'published' AND content_for_user = '" . $intContForUser . "' ORDER BY content.content_id ASC";
            //echo $strContentQuery;exit;
            $strContentAsPerCat = $this->query($strContentQuery);
            return $strContentAsPerCat;
        } else {
            $strContentQuery = " SELECT DISTINCT(content.content_type) FROM content,content_category,content_category_assignment WHERE content.content_id = content_category_assignment.content_id AND content_category.content_category_id = content_category_assignment.category_id AND content_status = 'published' AND content_for_user = '" . $intContForUser . "' ORDER BY content.content_id ASC";
            //echo $strContentQuery;exit;
            $strContentAsPerCat = $this->query($strContentQuery);
            return $strContentAsPerCat;
        }
    }

    public function fnGetContentList($intCatId, $intContentType = "", $intContForUser = "3") {

        if ($intCatId) {
            $strContentQuery = " SELECT content.*,content_category.* FROM content,content_category,content_category_assignment WHERE content.content_id = content_category_assignment.content_id AND content_category.content_category_id = content_category_assignment.category_id AND content_category.content_category_id = '" . $intCatId . "'";
            if ($intContentType) {
                $strContentQuery = $strContentQuery . " " . "AND content.content_type = '" . $intContentType . "'";
            }
            $strContentQuery = $strContentQuery . " " . "AND content_status = 'published' AND content_for_user = '" . $intContForUser . "' ORDER BY content.content_id ASC";
            //echo $strContentQuery;exit;
            $strContentAsPerCat = $this->query($strContentQuery);
            return $strContentAsPerCat;
        } else {
            $strContentQuery = " SELECT content.*,content_category.* FROM content,content_category,content_category_assignment WHERE content.content_id = content_category_assignment.content_id AND content_category.content_category_id = content_category_assignment.category_id AND content_status = 'published' AND content_for_user = '" . $intContForUser . "' ORDER BY content.content_id ASC";
            $strContentAsPerCat = $this->query($strContentQuery);
            return $strContentAsPerCat;
        }
    }

    public function fnGetOrderCount($arrVendor, $ReportType, $strStartDateTime = "", $strEndDateTime = "", $datePeriods = "") {
        if ($strStartDateTime != '') {
            if ($arrVendor != '') {
                $strProductListQuery = "SELECT DISTINCT count(order_detail_creation_date_time) as total,order_detail_creation_date_time,order_detail_id FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $arrVendor . "' AND resource_order_detail.vendor_order_state = '" . $ReportType . "' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $datePeriods(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT DISTINCT count(order_detail_creation_date_time) as total,order_detail_creation_date_time,order_detail_id FROM resource_order_detail WHERE resource_order_detail.vendor_order_state = '" . $ReportType . "' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $datePeriods(order_detail_creation_date_time)";
            }
        } else {

            if ($arrVendor != '') {
                $strProductListQuery = "SELECT DISTINCT count(order_detail_creation_date_time) as total,order_detail_creation_date_time,order_detail_id FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $arrVendor . "' AND resource_order_detail.vendor_order_state = '" . $ReportType . "' GROUP BY $datePeriods(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT DISTINCT count(order_detail_creation_date_time) as total,order_detail_creation_date_time,order_detail_id FROM resource_order_detail WHERE resource_order_detail.vendor_order_state = '" . $ReportType . "' GROUP BY $datePeriods(order_detail_creation_date_time)";
            }
        }

        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetSubOrderCount($vendor_id, $ReportType = "", $strStartDateTime = "", $strEndDateTime = "", $datePeriods = "") {
        if ($strStartDateTime != '') {
            if ($vendor_id != '') {
                $strProductListQuery = "SELECT DISTINCT count(order_detail_creation_date_time) as total,order_detail_creation_date_time,order_detail_id FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $vendor_id . "' AND resource_order_detail.vendor_order_state = '" . $ReportType . "' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $datePeriods(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT DISTINCT count(order_detail_creation_date_time) as total,order_detail_creation_date_time,order_detail_id FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE resource_order_detail.vendor_order_state = '" . $ReportType . "' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $datePeriods(order_detail_creation_date_time)";
            }
        } else {
            if ($vendor_id != '') {
                $strProductListQuery = "SELECT DISTINCT count(order_detail_creation_date_time) as total,order_detail_creation_date_time,order_detail_id FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $vendor_id . "' AND resource_order_detail.vendor_order_state = '" . $ReportType . "' GROUP BY $datePeriods(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT DISTINCT count(order_detail_creation_date_time) as total,order_detail_creation_date_time,order_detail_id FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE resource_order_detail.vendor_order_state = '" . $ReportType . "' GROUP BY $datePeriods(order_detail_creation_date_time)";
            }
        }

        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetEarnedOrderAmount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intVendorId != '') {
                $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Closed' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY date(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_order_state = 'Closed' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY date(order_detail_creation_date_time)";
            }
        } else {
            if ($intVendorId != '') {
                $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Closed' GROUP BY date(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_order_state = 'Closed' GROUP BY date(order_detail_creation_date_time)";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetSubEarnedOrderAmount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intVendorId != '') {
                $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Closed' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY date(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE resource_order_detail.vendor_order_state = 'Closed' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY date(order_detail_creation_date_time)";
            }
        } else {
            if ($intVendorId != '') {
                $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Closed' GROUP BY date(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE resource_order_detail.vendor_order_state = 'Closed' GROUP BY date(order_detail_creation_date_time)";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetSubRefundOrderAmount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intVendorId != "") {
                $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY date(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY date(order_detail_creation_date_time)";
            }
        } else {
            if ($intVendorId != "") {
                $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 GROUP BY date(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE resource_order_detail.refund_status = 1 GROUP BY date(order_detail_creation_date_time)";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetRefundOrderAmount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intVendorId != "") {
                $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY date(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY date(order_detail_creation_date_time)";
            }
        } else {
            if ($intVendorId != "") {
                $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 GROUP BY date(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.refund_status = 1 GROUP BY date(order_detail_creation_date_time)";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetAdminTotalRefundOrderAmount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "", $strPeriod = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intVendorId != "") {
                $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
            }
        } else {
            if ($intVendorId != "") {
                $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 GROUP BY $strPeriod(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE resource_order_detail.refund_status = 1 GROUP BY $strPeriod(order_detail_creation_date_time)";
            }
        }
        
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetAdminTotalSaleOrderAmount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "", $strPeriod = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intVendorId != '') {
                $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Closed' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_order_state = 'Closed' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
            }
        } else {
            if ($intVendorId != '') {
                $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_order_state = 'Closed' GROUP BY $strPeriod(order_detail_creation_date_time)";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_order_state = 'Closed' GROUP BY $strPeriod(order_detail_creation_date_time)";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetRefundOrderList($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "", $intPortalId = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intVendorId != "") {
                if ($intPortalId == 'all') {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY `resource_order_detail`.`order_id` ";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY `resource_order_detail`.`order_id` ";
                }
            } else {
                if ($intPortalId == 'all') {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` WHERE resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY `resource_order_detail`.`order_id` ";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'  GROUP BY `resource_order_detail`.`order_id` ";
                }
            }
        } else {
            if ($intVendorId != "") {
                if ($intPortalId == 'all') {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 GROUP BY `resource_order_detail`.`order_id` ";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 GROUP BY `resource_order_detail`.`order_id` ";
                }
            } else {
                if ($intPortalId == 'all') {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` WHERE resource_order_detail.refund_status = 1 GROUP BY `resource_order_detail`.`order_id` ";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.refund_status = 1 GROUP BY `resource_order_detail`.`order_id` ";
                }
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetAdminTotalRefundOrderList($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "", $intPortalId = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intVendorId != "") {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.`order_id` WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY `resource_order_detail`.`order_id` ";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.`order_id` WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY `resource_order_detail`.`order_id` ";
                }
            } else {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.`order_id` WHERE resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY `resource_order_detail`.`order_id` ";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.`order_id` WHERE resource_order_detail.refund_status = 1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY `resource_order_detail`.`order_id` ";
                }
            }
        } else {
            if ($intVendorId != "") {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.`order_id` WHERE sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 GROUP BY `resource_order_detail`.`order_id` ";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.`order_id` WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND sub_vendor_order_service.vendor_id = '" . $intVendorId . "' AND resource_order_detail.refund_status = 1 GROUP BY `resource_order_detail`.`order_id` ";
                }
            } else {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.`order_id` WHERE resource_order_detail.refund_status = 1 GROUP BY `resource_order_detail`.`order_id` ";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_confirmation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `career_portal_candidate`, `resource_order_detail` INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.`order_id` WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.refund_status = 1 GROUP BY `resource_order_detail`.`order_id` ";
                }
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetAdminTotalVendorSaleOrderAmount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "", $strPeriod = "", $intPortalId = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intVendorId != '') {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
                } else {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
                }
            } else {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
                } else {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
                }
            }
        } else {
            if ($intVendorId != '') {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY $strPeriod(order_detail_creation_date_time)";
                } else {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY $strPeriod(order_detail_creation_date_time)";
                }
            } else {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY $strPeriod(order_detail_creation_date_time)";
                } else {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY $strPeriod(order_detail_creation_date_time)";
                }
            }
        }
//        echo '<pre>';print_r($strProductListQuery);die;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetAdminTotalVendorSaleOrderAmountList($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "", $intPortalId = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intVendorId != '') {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY resource_order_detail.order_confirmation_date_time";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_id,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY resource_order_detail.order_confirmation_date_time";
                }
            } else {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY resource_order_detail.order_confirmation_date_time";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY resource_order_detail.order_confirmation_date_time";
                }
            }
        } else {
            if ($intVendorId != '') {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY resource_order_detail.order_confirmation_date_time";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY resource_order_detail.order_confirmation_date_time";
                }
            } else {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY resource_order_detail.order_confirmation_date_time";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY resource_order_detail.order_confirmation_date_time";
                }
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetOrderCountList($arrVendor, $ReportType, $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime != '') {
            if ($arrVendor != '') {
                $strProductListQuery = "SELECT order_detail_creation_date_time,order_detail_id,product_name,vendor_order_state,resource_order_detail.vendor_type,vendor_name,refund_status,product_id,resource_order_detail.seeker_id,resource_order_detail.vendor_order_close_date,resource_order_detail.vendor_cost,resource_order.order_name FROM resource_order,resource_order_detail WHERE resource_order.resource_order_id = resource_order_detail.order_id AND resource_order_detail.vendor_id = '" . $arrVendor . "' AND  resource_order_detail.vendor_order_state = '" . $ReportType . "' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            } else {
                $strProductListQuery = "SELECT order_detail_creation_date_time,order_detail_id,product_name,vendor_order_state,resource_order_detail.vendor_type,vendor_name,refund_status,product_id,resource_order_detail.seeker_id,resource_order_detail.vendor_order_close_date,resource_order_detail.vendor_cost,resource_order.order_name FROM resource_order,resource_order_detail WHERE resource_order.resource_order_id = resource_order_detail.order_id AND resource_order_detail.vendor_order_state = '" . $ReportType . "' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            }
        } else {

            if ($arrVendor != '') {
                $strProductListQuery = "SELECT order_detail_creation_date_time,order_detail_id,product_name,vendor_order_state,resource_order_detail.vendor_type,vendor_name,refund_status,product_id,resource_order_detail.seeker_id,resource_order_detail.vendor_order_close_date,resource_order_detail.vendor_cost,resource_order.order_name FROM resource_order,resource_order_detail WHERE resource_order.resource_order_id = resource_order_detail.order_id AND resource_order_detail.vendor_id = '" . $arrVendor . "' AND sub_vendor_order_service.vendor_id = resource_order_detail.vendor_id AND resource_order_detail.vendor_order_state = '" . $ReportType . "'";
            } else {
                $strProductListQuery = "SELECT order_detail_creation_date_time,order_detail_id,product_name,vendor_order_state,resource_order_detail.vendor_type,vendor_name,refund_status,product_id,resource_order_detail.seeker_id,resource_order_detail.vendor_order_close_date,resource_order_detail.vendor_cost,resource_order.order_name FROM resource_order,resource_order_detail WHERE resource_order.resource_order_id = resource_order_detail.order_id AND resource_order_detail.vendor_order_state = '" . $ReportType . "'";
            }
        }

        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetSubOrderCountList($vendor_id, $ReportType = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime != '') {
            if ($vendor_id != '') {
                $strProductListQuery = "SELECT order_detail_creation_date_time,order_detail_id,product_name,vendor_order_state,resource_order_detail.vendor_type,vendor_name,refund_status,product_id,resource_order_detail.seeker_id,resource_order_detail.order_id,resource_order_detail.vendor_order_close_date,resource_order_detail.vendor_cost,sub_vendor_order_service.* FROM  resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $vendor_id . "' AND resource_order_detail.vendor_order_state = '" . $ReportType . "' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            } else {
                $strProductListQuery = "SELECT order_detail_creation_date_time,order_detail_id,product_name,vendor_order_state,resource_order_detail.vendor_type,vendor_name,refund_status,product_id,resource_order_detail.seeker_id,resource_order_detail.order_id,resource_order_detail.vendor_order_close_date,resource_order_detail.vendor_cost,sub_vendor_order_service.* FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE resource_order_detail.vendor_order_state = '" . $ReportType . "' AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "'";
            }
        } else {
            if ($vendor_id != '') {
                $strProductListQuery = "SELECT order_detail_creation_date_time,order_detail_id,product_name,vendor_order_state,resource_order_detail.vendor_type,vendor_name,refund_status,product_id,resource_order_detail.seeker_id,resource_order_detail.order_id,resource_order_detail.vendor_order_close_date,resource_order_detail.vendor_cost,sub_vendor_order_service.* FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE sub_vendor_order_service.vendor_id = '" . $vendor_id . "' AND resource_order_detail.vendor_order_state = '" . $ReportType . "'";
            } else {
                $strProductListQuery = "SELECT order_detail_creation_date_time,order_detail_id,product_name,vendor_order_state,resource_order_detail.vendor_type,vendor_name,refund_status,product_id,resource_order_detail.seeker_id,resource_order_detail.order_id,resource_order_detail.vendor_order_close_date,resource_order_detail.vendor_cost,sub_vendor_order_service.* FROM resource_order_detail INNER JOIN sub_vendor_order_service ON sub_vendor_order_service.order_id = resource_order_detail.order_id WHERE resource_order_detail.vendor_order_state = '" . $ReportType . "'";
            }
        }

        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetNewVendorAdded($strStartDateTime = "", $strEndDateTime = "", $intPortalId = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT inserted_date_time FROM `resource_order_detail`,`sub_vendor_order_service` WHERE `sub_vendor_order_service`.inserted_date_time >= '" . $strStartDateTime . "' AND `sub_vendor_order_service`.inserted_date_time <= '" . $strEndDateTime . "' GROUP BY sub_vendor_order_service.vendor_id";
            } else {
                $strProductListQuery = "SELECT inserted_date_time FROM `resource_order_detail`,`sub_vendor_order_service` WHERE `resource_order_detail`.order_from_portal='" . $intPortalId . "' AND `sub_vendor_order_service`.inserted_date_time >= '" . $strStartDateTime . "' AND `sub_vendor_order_service`.inserted_date_time <= '" . $strEndDateTime . "' GROUP BY sub_vendor_order_service.vendor_id";
            }
        } else {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT inserted_date_time FROM `resource_order_detail`,`sub_vendor_order_service` GROUP BY sub_vendor_order_service.vendor_id";
            } else {
                $strProductListQuery = "SELECT inserted_date_time FROM `resource_order_detail`,`sub_vendor_order_service` WHERE `resource_order_detail`.order_from_portal='" . $intPortalId . "' GROUP BY sub_vendor_order_service.vendor_id";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetNewVendorAddedList($strStartDateTime = "", $strEndDateTime = "", $intPortalId = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT inserted_date_time,vendor_first_name,vendor_last_name,vendor_type,vendor_email,vendor_phone FROM `vendors`,`sub_vendor_order_service` WHERE sub_vendor_order_service.vendor_id=vendors.vendor_id AND `sub_vendor_order_service`.inserted_date_time >= '" . $strStartDateTime . "' AND `sub_vendor_order_service`.inserted_date_time <= '" . $strEndDateTime . "' GROUP BY sub_vendor_order_service.vendor_id";
            } else {
                $strProductListQuery = "SELECT inserted_date_time,vendor_first_name,vendor_last_name,vendor_type,vendor_email,vendor_phone FROM `vendors`,`sub_vendor_order_service` WHERE sub_vendor_order_service.vendor_id=vendors.vendor_id AND `resource_order_detail`.order_from_portal='" . $intPortalId . "' AND `sub_vendor_order_service`.inserted_date_time >= '" . $strStartDateTime . "' AND `sub_vendor_order_service`.inserted_date_time <= '" . $strEndDateTime . "' GROUP BY sub_vendor_order_service.vendor_id";
            }
        } else {
            if ($intPortalId == 'all' || $intPortalId == '') {
                $strProductListQuery = "SELECT inserted_date_time,vendor_first_name,vendor_last_name,vendor_type,vendor_email,vendor_phone FROM `sub_vendor_order_service` WHERE sub_vendor_order_service.vendor_id=vendors.vendor_id GROUP BY sub_vendor_order_service.vendor_id";
            } else {
                $strProductListQuery = "SELECT inserted_date_time,vendor_first_name,vendor_last_name,vendor_type,vendor_email,vendor_phone FROM `sub_vendor_order_service` WHERE sub_vendor_order_service.vendor_id=vendors.vendor_id AND `resource_order_detail`.order_from_portal='" . $intPortalId . "' GROUP BY sub_vendor_order_service.vendor_id";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetVendorPayoutNewList($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intVendorId == 'all') {
                $strProductListQuery = "SELECT sum(vendor_cost) as vendor_cost,order_detail_creation_date_time,vendor_name,resource_order_detail.vendor_id FROM `resource_order_detail` WHERE resource_order_detail.vendor_type='vendor' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status ='0' AND resource_order_detail.order_detail_creation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_detail_creation_date_time <= '" . $strEndDateTime . "' GROUP BY `resource_order_detail`.`vendor_id` ";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as vendor_cost,order_detail_creation_date_time,vendor_name,resource_order_detail.vendor_id FROM `resource_order_detail` WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_type='vendor' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status ='0' AND resource_order_detail.order_detail_creation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_detail_creation_date_time <= '" . $strEndDateTime . "' GROUP BY `resource_order_detail`.`vendor_id` ";
            }
        } else {
            if ($intVendorId == 'all') {
                $strProductListQuery = "SELECT sum(vendor_cost) as vendor_cost,order_detail_creation_date_time,vendor_name,resource_order_detail.vendor_id FROM `resource_order_detail` WHERE resource_order_detail.vendor_type='vendor' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status = '0' GROUP BY `resource_order_detail`.`vendor_id` ";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as vendor_cost,order_detail_creation_date_time,vendor_name,resource_order_detail.vendor_id FROM `resource_order_detail` WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_type='vendor' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status = '0' GROUP BY `resource_order_detail`.`vendor_id` ";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }
    
    public function fnGetOwnerPayoutNewList($portalId = "", $strStartDateTime = "", $strEndDateTime = "") {
//        echo '<pre>';print_r($portalId);die;
        if ($strStartDateTime && $strEndDateTime) {
            if ($portalId == 'all' || $portalId == '') {
                $strProductListQuery = "SELECT sum(vendor_cost) as portal_owner_cost,order_detail_creation_date_time,order_from_portal,order_id FROM `resource_order_detail` WHERE resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status ='0' AND resource_order_detail.order_detail_creation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_detail_creation_date_time <= '" . $strEndDateTime . "' GROUP BY `resource_order_detail`.`order_from_portal` ";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as portal_owner_cost,order_detail_creation_date_time,order_from_portal,order_id FROM `resource_order_detail` WHERE resource_order_detail.vendor_id = '" . $portalId . "' AND resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status ='0' AND resource_order_detail.order_detail_creation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_detail_creation_date_time <= '" . $strEndDateTime . "' GROUP BY `resource_order_detail`.`order_from_portal` ";
            }
        } else {
            if ($portalId == 'all') {
                $strProductListQuery = "SELECT sum(vendor_cost) as portal_owner_cost,order_detail_creation_date_time,order_from_portal,order_id FROM `resource_order_detail` WHERE resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status = '0' GROUP BY `resource_order_detail`.`order_from_portal` ";
            } else {
                $strProductListQuery = "SELECT sum(vendor_cost) as portal_owner_cost,order_detail_creation_date_time,order_from_portal,order_id FROM `resource_order_detail` WHERE resource_order_detail.vendor_id = '" . $portalId . "' AND resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status = '0' GROUP BY `resource_order_detail`.`order_from_portal` ";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetVendorPayoutList($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intVendorId == 'all') {
                $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,payout_status,product_name,resource_order.order_name,vendor_name,resource_order_detail.order_id,vendor_company_details.company_name,resource_order_detail.vendor_id FROM `vendor_company_details`,`resource_order`,`resource_order_detail` WHERE vendor_company_details.vendor_id=resource_order_detail.vendor_id AND resource_order_detail.vendor_type='vendor' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status ='0' AND resource_order_detail.order_detail_creation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_detail_creation_date_time <= '" . $strEndDateTime . "' GROUP BY `resource_order_detail`.`order_id` ";
            } else {
                $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,payout_status,product_name,resource_order.order_name,vendor_name,resource_order_detail.order_id,vendor_company_details.company_name,resource_order_detail.vendor_id FROM `vendor_company_details`,`resource_order`,`resource_order_detail` WHERE vendor_company_details.vendor_id=resource_order_detail.vendor_id AND resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_type='vendor' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status ='0' AND resource_order_detail.order_detail_creation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_detail_creation_date_time <= '" . $strEndDateTime . "' GROUP BY `resource_order_detail`.`order_id` ";
            }
        } else {
            if ($intVendorId == 'all') {
                $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,payout_status,product_name,resource_order.order_name,vendor_name,resource_order_detail.order_id,vendor_company_details.company_name,resource_order_detail.vendor_id FROM `vendor_company_details`,`resource_order`,`resource_order_detail` WHERE vendor_company_details.vendor_id=resource_order_detail.vendor_id AND resource_order_detail.vendor_type='vendor' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status = '0' GROUP BY `resource_order_detail`.`order_id` ";
            } else {
                $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,payout_status,product_name,resource_order.order_name,vendor_name,resource_order_detail.order_id,vendor_company_details.company_name,resource_order_detail.vendor_id FROM `vendor_company_details`,`resource_order`,`resource_order_detail` WHERE vendor_company_details.vendor_id=resource_order_detail.vendor_id AND resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_type='vendor' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status = '0' GROUP BY `resource_order_detail`.`order_id` ";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetOwnerPayoutList($portalId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($portalId == 'all' || $portalId == '') {
                $strProductListQuery = "SELECT portal_owner_cost,order_detail_creation_date_time,payout_status,product_name,resource_order.order_name,resource_order_detail.order_id,resource_order_detail.order_from_portal FROM `resource_order`,`resource_order_detail` WHERE resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status ='0' AND resource_order_detail.order_detail_creation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_detail_creation_date_time <= '" . $strEndDateTime . "' GROUP BY `resource_order_detail`.`order_id` ";
            } else {
                $strProductListQuery = "SELECT portal_owner_cost,order_detail_creation_date_time,payout_status,product_name,resource_order.order_name,resource_order_detail.order_id,resource_order_detail.order_from_portal FROM `resource_order`,`resource_order_detail` WHERE resource_order_detail.order_from_portal = '" . $portalId . "' AND resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status ='0' AND resource_order_detail.order_detail_creation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_detail_creation_date_time <= '" . $strEndDateTime . "' GROUP BY `resource_order_detail`.`order_id` ";
            }
        } else {
            if ($portalId == 'all') {
                $strProductListQuery = "SELECT portal_owner_cost,order_detail_creation_date_time,payout_status,product_name,resource_order.order_name,resource_order_detail.order_id,resource_order_detail.order_from_portal FROM `resource_order`,`resource_order_detail` WHERE resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status = '0' GROUP BY `resource_order_detail`.`order_id` ";
            } else {
                $strProductListQuery = "SELECT portal_owner_cost,order_detail_creation_date_time,payout_status,product_name,resource_order.order_name,resource_order_detail.order_id,resource_order_detail.order_from_portal FROM `resource_order`,`resource_order_detail` WHERE resource_order_detail.order_from_portal = '" . $portalId . "' AND resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status = '0' GROUP BY `resource_order_detail`.`order_id` ";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetVendorPayoutCount($intVendorId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intVendorId == 'all') {
                $strProductListQuery = "SELECT DISTINCT SUM(resource_order_detail.vendor_cost) AS amount FROM `resource_order_detail` WHERE resource_order_detail.vendor_type='vendor' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status ='0' AND resource_order_detail.order_detail_creation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_detail_creation_date_time <= '" . $strEndDateTime . "'";
            } else {
                $strProductListQuery = "SELECT DISTINCT SUM(resource_order_detail.vendor_cost) AS amount FROM `resource_order_detail` WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_type='vendor' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status ='0' AND resource_order_detail.order_detail_creation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_detail_creation_date_time <= '" . $strEndDateTime . "'";
            }
        } else {
            if ($intVendorId == 'all') {
                $strProductListQuery = "SELECT DISTINCT SUM(resource_order_detail.vendor_cost) AS amount FROM `resource_order_detail` WHERE resource_order_detail.vendor_type='vendor' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status = '0'";
            } else {
                $strProductListQuery = "SELECT DISTINCT SUM(resource_order_detail.vendor_cost) AS amount FROM `resource_order_detail` WHERE resource_order_detail.vendor_id = '" . $intVendorId . "' AND resource_order_detail.vendor_type='vendor' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status = '0'";
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function fnGetOwnerPayoutCount($portalId = "", $strStartDateTime = "", $strEndDateTime = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($portalId == 'all') {
                $strProductListQuery = "SELECT SUM(resource_order_detail.vendor_cost) AS amount FROM `resource_order_detail` WHERE resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status ='0' AND resource_order_detail.order_detail_creation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_detail_creation_date_time <= '" . $strEndDateTime . "'";
            } else {
                $strProductListQuery = "SELECT SUM(resource_order_detail.vendor_cost) AS amount FROM `resource_order_detail` WHERE resource_order_detail.vendor_id = '" . $portalId . "' AND resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status ='0' AND resource_order_detail.order_detail_creation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_detail_creation_date_time <= '" . $strEndDateTime . "'";
            }
        } else {
            if ($portalId == 'all') {
                $strProductListQuery = "SELECT SUM(resource_order_detail.vendor_cost) AS amount FROM `resource_order_detail` WHERE resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status = '0'";
            } else {
                $strProductListQuery = "SELECT SUM(resource_order_detail.vendor_cost) AS amount FROM `resource_order_detail` WHERE resource_order_detail.vendor_id = '" . $portalId . "' AND resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status = '0'";
            }
        }
        
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }
    
    public function fnGetAdminTotalPortalOwnerSaleOrderAmount($intOwnerId = "", $strStartDateTime = "", $strEndDateTime = "", $strPeriod = "", $intPortalId = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intOwnerId != '') {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intOwnerId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
                } else {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.vendor_id = '" . $intOwnerId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
                }
            } else {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
                } else {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
                }
            }
        } else {
            if ($intOwnerId != '') {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intOwnerId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY $strPeriod(order_detail_creation_date_time)";
                } else {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.vendor_id = '" . $intOwnerId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY $strPeriod(order_detail_creation_date_time)";
                }
            } else {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY $strPeriod(order_detail_creation_date_time)";
                } else {
                    $strProductListQuery = "SELECT sum(vendor_cost) as amount,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY $strPeriod(order_detail_creation_date_time)";
                }
            }
        }
//        echo '<pre>';print_r($strProductListQuery);die;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }
    
    public function fnGetAdminTotalPortalOwnerRefundOrderAmount($intOwnerId = "", $strStartDateTime = "", $strEndDateTime = "", $strPeriod = "", $intPortalId = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intOwnerId != '') {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intOwnerId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
                } else {
                    $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.vendor_id = '" . $intOwnerId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
                }
            } else {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
                } else {
                    $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=1 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY $strPeriod(order_detail_creation_date_time)";
                }
            }
        } else {
            if ($intOwnerId != '') {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.vendor_id = '" . $intOwnerId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=1 GROUP BY $strPeriod(order_detail_creation_date_time)";
                } else {
                    $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.vendor_id = '" . $intOwnerId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=1 GROUP BY $strPeriod(order_detail_creation_date_time)";
                }
            } else {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY $strPeriod(order_detail_creation_date_time)";
                } else {
                    $strProductListQuery = "SELECT sum(vendor_cost) as refundTotal,order_detail_creation_date_time FROM resource_order_detail WHERE resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY $strPeriod(order_detail_creation_date_time)";
                }
            }
        }
//        echo '<pre>';print_r($strProductListQuery);die;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }
   
    public function fnGetAdminTotalOwnerSaleOrderAmountList($intOwnerId = "", $strStartDateTime = "", $strEndDateTime = "", $intPortalId = "") {
        if ($strStartDateTime && $strEndDateTime) {
            if ($intOwnerId != '') {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.order_id = resource_order.resource_order_id AND resource_order_detail.vendor_id = '" . $intOwnerId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY resource_order_detail.order_confirmation_date_time";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_id,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.order_id = resource_order.resource_order_id AND resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.vendor_id = '" . $intOwnerId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY resource_order_detail.order_confirmation_date_time";
                }
            } else {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.order_id = resource_order.resource_order_id AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY resource_order_detail.order_confirmation_date_time";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.order_id = resource_order.resource_order_id AND resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 AND resource_order_detail.order_confirmation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_confirmation_date_time <= '" . $strEndDateTime . "' GROUP BY resource_order_detail.order_confirmation_date_time";
                }
            }
        } else {
            if ($intOwnerId != '') {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.order_id = resource_order.resource_order_id AND resource_order_detail.vendor_id = '" . $intOwnerId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY resource_order_detail.order_confirmation_date_time";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.order_id = resource_order.resource_order_id AND resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.vendor_id = '" . $intOwnerId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY resource_order_detail.order_confirmation_date_time";
                }
            } else {
                if ($intPortalId == 'all' || $intPortalId == '') {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.order_id = resource_order.resource_order_id AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY resource_order_detail.order_confirmation_date_time";
                } else {
                    $strProductListQuery = "SELECT vendor_cost,order_detail_creation_date_time,product_name,hc_profit_cost,portal_owner_cost,product_unit_cost,resource_order.order_name,resource_order_detail.order_confirmation_date_time FROM resource_order_detail,resource_order WHERE resource_order_detail.order_id = resource_order.resource_order_id AND resource_order_detail.order_from_portal='" . $intPortalId . "' AND resource_order_detail.payment_status='captured' AND resource_order_detail.refund_status=0 GROUP BY resource_order_detail.order_confirmation_date_time";
                }
            }
        }
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }




//Arjun Changes New Functionality Wise 02-12-2017
//    public function fnGetOwnerPayoutCount($portalId = "", $strStartDateTime = "", $strEndDateTime = "") {
//       
//        if ($strStartDateTime && $strEndDateTime) {
//            if ($portalId == 'all') {
//                $strProductListQuery = "SELECT SUM(resource_order_detail.portal_owner_cost) AS amount FROM `resource_order_detail` WHERE resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status ='0' AND resource_order_detail.order_detail_creation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_detail_creation_date_time <= '" . $strEndDateTime . "'";
//            } else {
//                $strProductListQuery = "SELECT SUM(resource_order_detail.portal_owner_cost) AS amount FROM `resource_order_detail` WHERE resource_order_detail.order_from_portal = '" . $portalId . "' AND resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status ='0' AND resource_order_detail.order_detail_creation_date_time >= '" . $strStartDateTime . "' AND resource_order_detail.order_detail_creation_date_time <= '" . $strEndDateTime . "'";
//            }
//        } else {
//            if ($portalId == 'all') {
//                $strProductListQuery = "SELECT SUM(resource_order_detail.portal_owner_cost) AS amount FROM `resource_order_detail` WHERE resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status = '0'";
//            } else {
//                $strProductListQuery = "SELECT SUM(resource_order_detail.portal_owner_cost) AS amount FROM `resource_order_detail` WHERE resource_order_detail.order_from_portal = '" . $portalId . "' AND resource_order_detail.vendor_type='Portal Owner' AND resource_order_detail.payout_status='0' AND resource_order_detail.refund_status = '0'";
//            }
//        }
//        $arrProductContentArray = $this->query($strProductListQuery);
//        return $arrProductContentArray;
//    }

}

?>