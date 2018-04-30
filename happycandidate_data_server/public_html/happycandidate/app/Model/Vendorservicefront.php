<?php

class Vendorservicefront extends AppModel {

    public $name = 'Vendorservicefront';
    public $useTable = 'vendor_service';

    public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
        // method content
        $recursive = -1;
        $this->useTable = false;
        /* print("<pre>");
          print_r($conditions);exit; */
        $strProductListQueryStart = "SELECT Resources.*,Vendorservice.*";
        if($conditions['category_id'] == ''){
            $strProductListQueryFromcClause = " FROM products AS Resources,vendor_service AS Vendorservice";
        }else{
            $strProductListQueryFromcClause = " FROM products AS Resources,vendor_service AS Vendorservice,content_category_assignment AS CategoryAssign";
        }
        
        $strProductListQuery = $strProductListQueryStart . $strProductListQueryFromcClause;
        if (is_array($conditions) && (count($conditions) > 0)) {
            
            if($conditions['category_id'] == ''){
                $strProductListQueryWhereClause = " WHERE Resources.productd_id = Vendorservice.service_id";
            }else{
                $strProductListQueryWhereClause = " WHERE Resources.productd_id = Vendorservice.service_id AND Resources.productd_id = CategoryAssign.product_id";
            }
            $strProductListQuery .= $strProductListQueryWhereClause;

            if ($conditions['product_publish_status']) {
                $strProductListQueryWhereClause3 = " AND Resources.product_publish_status = '" . $conditions['product_publish_status'] . "' AND Vendorservice.status = '" . $conditions['status'] . "'";
                $strProductListQuery = $strProductListQuery . $strProductListQueryWhereClause3;
            }

            if ($conditions['category_id']) {
                $strProductListQueryWhereClause3 = " AND CategoryAssign.category_id = '" . $conditions['category_id'] . "'";
                $strProductListQuery = $strProductListQuery . $strProductListQueryWhereClause3;
            }
        }
//        $strProductListQuery .= " Order by productd_id DESC";
        $strProductListQuery .= " Group BY productd_id DESC";
        $strProductListQuery .= " LIMIT " . (($page - 1) * $limit) . ', ' . $limit;
//			echo $strProductListQuery;exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

    public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
        // method body
        $strProductListQueryStart = "SELECT *";
        
        if($conditions['category_id'] == ''){
            $strProductListQueryFromcClause = " FROM products AS Resources,vendor_service AS Vendorservice";
        }else{
            $strProductListQueryFromcClause = " FROM products AS Resources,vendor_service AS Vendorservice,content_category_assignment AS CategoryAssign";
        }
        
        $strProductListQuery = $strProductListQueryStart . $strProductListQueryFromcClause;
        if (is_array($conditions) && (count($conditions) > 0)) {
            
            if($conditions['category_id'] == ''){
                $strProductListQueryWhereClause = " WHERE Resources.productd_id = Vendorservice.service_id";
            }else{
                $strProductListQueryWhereClause = " WHERE Resources.productd_id = Vendorservice.service_id AND Resources.productd_id = CategoryAssign.product_id";
            }

            $strProductListQuery .= $strProductListQueryWhereClause;

            if ($conditions['product_publish_status']) {
                $strProductListQueryWhereClause3 = " AND Resources.product_publish_status = '" . $conditions['product_publish_status'] . "' AND Vendorservice.status = '" . $conditions['status'] . "'";
                $strProductListQuery = $strProductListQuery . $strProductListQueryWhereClause3;
            }
            
            if ($conditions['category_id']) {
                $strProductListQueryWhereClause3 = " AND CategoryAssign.category_id = '" . $conditions['category_id'] . "'";
                $strProductListQuery = $strProductListQuery . $strProductListQueryWhereClause3;
            }
            
        }
        $this->recursive = $recursive;
//        $strProductListQuery .= " Order by productd_id DESC";
        $strProductListQuery .= " Group BY productd_id DESC";
        //echo $strProductListQuery;exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        return count($arrProductContentArray);
    }

}

?>