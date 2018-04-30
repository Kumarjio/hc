<?php

class Portal extends AppModel {

    public $name = 'Portal';
    public $useTable = 'career_portal';
    public $validate = array(
        'career_portal_name' => array(
            'Required' => array(
                'rule' => 'notEmpty',
                'message' => 'You have not provided Portal Name',
            ),
//            'Alphanumeric' => array(
//                'rule' => 'alphaNumeric',
//                'message' => 'Portal name cannot contain Alphanumeric Characters',
//            )
        ),
        'career_portal_logo' => array(
            'Not Empty' => array(
                'rule' => 'notEmpty',
                "message" => "You have not provided Portal Logo"
            ),
            'Extension' => array(
                'rule' => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
                "message" => "Provided Logo is not valid, Please provide valid image file"
            )
        )
    );

    public function beforeSave($options = array()) {

        /* if (isset($this->data['User']['password'])) {

          $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);

          }

          return true; */
    }

    public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
        // method content
        $recursive = -1;
        $this->useTable = false;
//        print("<pre>");
//        print_r($conditions);exit;
        $strProductListQueryStart = "SELECT career_portal_name,career_portal_published,career_portal_created_datetime,career_portal.career_portal_id,career_portal_approved,employer_detail.employer_user_fname,employer_user_lname,employer_company_name,career_portal_domain.career_portal_domain_name,career_portal_domain.career_portal_domain_id";
        $strProductListQueryFromcClause = " FROM user,career_portal_domain,employer_detail,career_portal";
        $strProductListQuery = $strProductListQueryStart . $strProductListQueryFromcClause;

        if (is_array($conditions) && (count($conditions) > 0)) {
            $strProductListQueryWhereClause = " WHERE career_portal.career_portal_created_by=user.id and employer_detail.employer_id=user.id and career_portal.career_portal_id=career_portal_domain.career_portal_id and ";

            $strProductListQuery .= $strProductListQueryWhereClause;

            if ($conditions['career_portal_published'] == "1") {
                if ($conditions['career_portal_created_datetime >=']) {
                    $strProductListQueryWhereClause4 = " career_portal_published = '1' and  career_portal_approved='1' and career_portal_created_datetime >='" . $conditions['career_portal_created_datetime >='] . "' and career_portal_created_datetime <='" . $conditions['career_portal_created_datetime <='] . "'";
                } else {
                    $strProductListQueryWhereClause4 = " career_portal_published = '1' and  career_portal_approved='1'";
                }
            }
            if ($conditions['career_portal_published'] == "0") {
                if ($conditions['career_portal_created_datetime >=']) {
                    $strProductListQueryWhereClause4 = " career_portal_published = '0' and career_portal_created_datetime >='" . $conditions['career_portal_created_datetime >='] . "' and career_portal_created_datetime <='" . $conditions['career_portal_created_datetime <='] . "'";
//                    $strProductListQueryWhereClause4 = " career_portal_published = '0' and career_portal_approved='1' and career_portal_created_datetime >='" . $conditions['career_portal_created_datetime >='] . "' and career_portal_created_datetime <='" . $conditions['career_portal_created_datetime <='] . "'";
                } else {
                    $strProductListQueryWhereClause4 = " career_portal_published = '0'";
//                    $strProductListQueryWhereClause4 = " career_portal_published = '0' and career_portal_approved='1'";
                }
            }
            if ($conditions['career_portal_approved'] == "1") {
                if ($conditions['career_portal_created_datetime >=']) {
                    $strProductListQueryWhereClause4 = " career_portal_approved='0' and career_portal_created_datetime >='" . $conditions['career_portal_created_datetime >='] . "' and career_portal_created_datetime <='" . $conditions['career_portal_created_datetime <='] . "'";
                } else {
                    $strProductListQueryWhereClause4 = " career_portal_approved = '0'";
                }
            }
            if ($conditions['career_portal_approved'] == "2") {
                if ($conditions['career_portal_created_datetime >=']) {
                    $strProductListQueryWhereClause4 = " career_portal_approved='2' and career_portal_created_datetime >='" . $conditions['career_portal_created_datetime >='] . "' and career_portal_created_datetime <='" . $conditions['career_portal_created_datetime <='] . "'";
                } else {
                    $strProductListQueryWhereClause4 = " career_portal_approved = '2'";
                }
            }
            if ($conditions['career_portal_published'] == "3") {
                if ($conditions['career_portal_created_datetime >=']) {
                    $strProductListQueryWhereClause4 = " career_portal_published = '0' and  career_portal_approved='0' and career_portal_created_datetime >='" . $conditions['career_portal_created_datetime >='] . "' and career_portal_created_datetime <='" . $conditions['career_portal_created_datetime <='] . "'";
                } else {
                    $strProductListQueryWhereClause4 = " career_portal_published = '0' and  career_portal_approved='0'";
                }
            }
        }
        $strProductListQuery = $strProductListQuery . $strProductListQueryWhereClause4;
        $strProductListQuery .= " ORDER BY career_portal.career_portal_id ";
        $strProductListQuery .= " LIMIT " . (($page - 1) * $limit) . ', ' . $limit;
//        echo $strProductListQuery;exit;
        $arrProductContentArray = $this->query($strProductListQuery);
        //	print_r($arrProductContentArray);die;
        return $arrProductContentArray;
    }

}

?>