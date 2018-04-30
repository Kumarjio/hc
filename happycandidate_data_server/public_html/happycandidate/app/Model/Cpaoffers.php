<?php

class Cpaoffers extends AppModel {

    var $name = 'Cpaoffers';
    var $useTable = 'cpa_offers';
   

    public function beforeSave($options = array()) {
        
    }
    
    public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
        // method content
        $recursive = -1;
        $this->useTable = false;
        $strProductListQueryStart = "SELECT *";
        $strProductListQueryFromcClause = " FROM cpa_offers";
        $strProductListQuery = $strProductListQueryStart . $strProductListQueryFromcClause;

        if (is_array($conditions) && (count($conditions) > 0)) {
            $strProductListQueryWhereClause4 = " WHERE offer_status='Active'";
        }
        
        $strProductListQuery = $strProductListQuery . $strProductListQueryWhereClause4;
        $strProductListQuery .= " ORDER BY offer_id ";
        $strProductListQuery .= " LIMIT " . (($page - 1) * $limit) . ', ' . $limit;
//        echo $strProductListQuery;exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        //	print_r($arrProductContentArray);die;
        return $arrProductContentArray;
    }

}

?>