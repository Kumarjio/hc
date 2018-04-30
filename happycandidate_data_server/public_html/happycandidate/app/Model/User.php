<?php

class User extends AppModel {

    public $name = 'User';
    public $useTable = 'user';
    var $captcha = ''; //intializing captcha var
    public $validate = array(
        'captcha' => array(
            'captcha' => array(
                'rule' => 'matchCaptcha',
                'message' => 'Failed validating human check.'
            )
        ),
        /* 'username' => array(

          'alphaNumeric' => array(

          'rule' => 'notEmpty',

          'message' => 'Alphabets and numbers only',

          )

          ), */
        'email' => array(
            'Not Empty' => array(
                'rule' => 'notEmpty',
                "message" => "Pleaze Provide Email Address"
            ),
            'Email Check' => array(
                'rule' => 'email',
                "message" => "Provided email address was not correct"
            )
        ),
        'pass' => array(
            'Not Empty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter your password'
            ),
            'min length' => array(
                'rule' => array('minLength', '5'),
                'message' => 'Password Should be minimum 8 characters long'
            )

        /* 'Match Password' => array(

          'rule' => 'matchPasswords',

          'message'=>'Your passwords do not match'

          ) */
        )
    );

    function matchCaptcha($inputValue) {
        return $inputValue['captcha'] == $this->getCaptcha(); //return true or false after comparing submitted value with set value of captcha
    }

    function setCaptcha($value) {

        $this->captcha = $value; //setting captcha value
    }

    function getCaptcha() {

        return $this->captcha; //getting captcha value
    }

    public function matchPasswords($data) {

        if ($data['pass'] == $this->data['User']['new_password_again']) {

            return true;
        }

        return false;
    }

    public function beforeSave($options = array()) {

        /* if (isset($this->data['User']['password'])) {

          $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);

          }

          return true; */
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

    public function fnGetCountryName($intCountryId = "") {

        if ($intCountryId) {

            $arrCountryArray = $this->query("SELECT * FROM country WHERE country_id='" . $intCountryId . "'");

            return $arrCountryArray;
        } else {

            return false;
        }
    }

    public function fnGetStateName($intStateId = "") {

        if ($intStateId) {

            $arrStateArray = $this->query("SELECT * FROM state WHERE state_id='" . $intStateId . "'");

            return $arrStateArray;

            /* print("<pre>");

              print_r($arrCountryArray); */
        } else {

            return false;
        }
    }

    public function fnGetCityName($intCityId = "") {

        if ($intCityId) {

            $arrCityArray = $this->query("SELECT * FROM city WHERE city_id='" . $intCityId . "'");

            return $arrCityArray;



            /* print("<pre>");

              print_r($arrCityArray); */
        } else {

            return false;
        }
    }

    public function fnGetIndustryName($intIdustryId = "") {

        if ($intIdustryId) {

            $objModelIndustry = ClassRegistry::init('Industry');

            $arrIndustry = $objModelIndustry->find('all', array('conditions' => array('industry_id' => $intIdustryId)));



            return $arrIndustry;
        }
    }

    public function fnGetUserDetailForPortal($intPortalId = "", $strStartDate, $strEndDate) {
        if ($intPortalId == "all") {
            if (!empty($strStartDate)) {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.portal_id = career_portal.career_portal_id AND career_portal_created_by>='" . $strStartDate . "' AND career_portal_created_by<='" . $strEndDate . "'";
            } else {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.portal_id = career_portal.career_portal_id";
            }

            $arrUserDetail = $this->query($strQuery);

            return $arrUserDetail;
        } else {
            if (!empty($strStartDate)) {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.portal_id = '" . $intPortalId . "' AND career_portal_created_by>='" . $strStartDate . "' AND career_portal_created_by<='" . $strEndDate . "' AND user.portal_id = career_portal.career_portal_id";
            } else {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.portal_id = '" . $intPortalId . "' AND user.portal_id = career_portal.career_portal_id";
            }

            $arrUserDetail = $this->query($strQuery);

            return $arrUserDetail;
        }
    }

    public function fnGetUserInactiveDetailForPortal($intPortalId = "", $strStartDate, $strEndDate) {

        if ($intPortalId == "all") {

            if (!empty($strStartDate)) {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,career_portal.career_portal_created_datetime FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.is_active = '0' AND user.portal_id = career_portal.career_portal_id AND career_portal_created_by>='" . $strStartDate . "' AND career_portal_created_by<='" . $strEndDate . "'";
            } else {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,career_portal.career_portal_created_datetime FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.is_active = '0' AND user.portal_id = career_portal.career_portal_id ";
            }

            $arrUserDetail = $this->query($strQuery);

            return $arrUserDetail;
        } else {

            if (!empty($strStartDate)) {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,career_portal.career_portal_created_datetime,user_inactivation_date FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.is_active = '0' AND user.portal_id = '" . $intPortalId . "' AND career_portal_created_by>='" . $strStartDate . "' AND career_portal_created_by<='" . $strEndDate . "' AND user.portal_id = career_portal.career_portal_id";
            } else {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,career_portal.career_portal_created_datetime,user_inactivation_date FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.is_active = '0' AND user.portal_id = '" . $intPortalId . "' AND career_portal_created_by>='" . $strStartDate . "'";
            }


            $arrUserDetail = $this->query($strQuery);

            return $arrUserDetail;
        }
    }

    public function fnGetUserActiveDetailForPortal($intPortalId = "", $strStartDate, $strEndDate) {

        if ($intPortalId == "all") {
            if (!empty($strStartDate)) {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,career_portal.career_portal_created_datetime FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.is_active = '1' AND user.portal_id = career_portal.career_portal_id AND career_portal_created_by>='" . $strStartDate . "' AND career_portal_created_by<='" . $strEndDate . "'";
            } else {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,career_portal.career_portal_created_datetime FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.is_active = '1' AND user.portal_id = career_portal.career_portal_id ";
            }



            $arrUserDetail = $this->query($strQuery);

            return $arrUserDetail;
        } else {
            if (!empty($strStartDate)) {

                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,career_portal.career_portal_created_datetime FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.is_active = '1' AND user.portal_id = '" . $intPortalId . "' AND career_portal_created_by>='" . $strStartDate . "' AND career_portal_created_by<='" . $strEndDate . "' AND user.portal_id = career_portal.career_portal_id";
            } else {

                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,career_portal.career_portal_created_datetime FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.is_active = '1' AND user.portal_id = '" . $intPortalId . "' ";
            }



            $arrUserDetail = $this->query($strQuery);

            return $arrUserDetail;
        }
    }

    public function fnGetUserCompleted15Steps($intPortalId = "", $strStartDate, $strEndDate) {
        if (!empty($strStartDate)) {
            $strQuery = "SELECT distinct career_portal_candidate.j_process_substeps_completed,career_portal.career_portal_name,username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal.career_portal_created_datetime,user.user_inactivation_date FROM career_portal_candidate,user,career_portal,employer_detail WHERE career_portal_candidate.career_portal_id = user.portal_id AND employer_detail.employer_id = user.id AND career_portal_candidate.j_process_substeps_completed ='60' AND user.is_active='1' AND career_portal.career_portal_id='5' AND career_portal_created_datetime>= '" . $strStartDate . "' AND career_portal_created_datetime<= '" . $strEndDate . "' GROUP BY candidate_id";
        } else {
            $strQuery = "SELECT distinct career_portal_candidate.j_process_substeps_completed,career_portal.career_portal_name,username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal.career_portal_created_datetime,user.user_inactivation_date FROM career_portal_candidate,user,career_portal,employer_detail WHERE career_portal_candidate.career_portal_id = user.portal_id AND employer_detail.employer_id = user.id AND career_portal_candidate.j_process_substeps_completed ='60' AND user.is_active='1' AND career_portal.career_portal_id='5' GROUP BY candidate_id";
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }

    public function fnGetJobSeekerPurchasedOrder($strStartDate, $strEndDate) {

//        Configure::write('debug', '2');
        if (!empty($strStartDate)) {

            $strQuery = "SELECT distinct candidate_first_name,candidate_last_name,candidate_email,candidate_creation_date FROM `career_portal_candidate` ,`resource_order`  WHERE `career_portal_candidate`.candidate_id=`resource_order`.seeker_id and order_payment_status='captured' AND candidate_creation_date >= '" . $strStartDate . "' AND candidate_creation_date<= '" . $strEndDate . "'";
        } else {
            $strQuery = "SELECT distinct candidate_first_name,candidate_last_name,candidate_email,candidate_creation_date FROM `career_portal_candidate` ,`resource_order`  WHERE `career_portal_candidate`.candidate_id=`resource_order`.seeker_id and order_payment_status='captured'";
        }

        $arrUserDetail = $this->query($strQuery);
        //echo '<pre>',print_r($arrUserDetail);die;
        return $arrUserDetail;
    }

    public function fnGetOverTimeMoneryGraph($intPortalId = "", $strStartDate, $strEndDate, $strPeriod = "") {

        //Configure::write('debug','2');
        if (!empty($strStartDate)) {
            if ($strPeriod == 'curr_year') {
                $strQuery = "SELECT sum(portal_owner_cost) as OverTimeMonery FROM `resource_order_detail` ,`career_portal` where `resource_order_detail`.order_from_portal=`career_portal`.`career_portal_id` and order_from_portal= '" . $intPortalId . "' AND order_detail_creation_date_time >= '" . $strStartDate . "' AND order_detail_creation_date_time<= '" . $strEndDate . "' GROUP BY YEAR(order_detail_creation_date_time)";
            } elseif ($strPeriod == '30') {
                $strQuery = "SELECT sum(portal_owner_cost) as OverTimeMonery FROM `resource_order_detail` ,`career_portal` where `resource_order_detail`.order_from_portal=`career_portal`.`career_portal_id` and order_from_portal= '" . $intPortalId . "' AND order_detail_creation_date_time >= '" . $strStartDate . "' AND order_detail_creation_date_time<= '" . $strEndDate . "' GROUP BY MONTH(order_detail_creation_date_time)";
            } else {
                $strQuery = "SELECT sum(portal_owner_cost) as OverTimeMonery FROM `resource_order_detail` ,`career_portal` where `resource_order_detail`.order_from_portal=`career_portal`.`career_portal_id` and order_from_portal= '" . $intPortalId . "' AND order_detail_creation_date_time >= '" . $strStartDate . "' AND order_detail_creation_date_time<= '" . $strEndDate . "' GROUP BY date(order_detail_creation_date_time)";
            }
        } else {
            $strQuery = "SELECT sum(portal_owner_cost) as OverTimeMonery FROM `resource_order_detail` ,`career_portal` where `resource_order_detail`.order_from_portal=`career_portal`.`career_portal_id` and order_from_portal= '" . $intPortalId . "' GROUP BY date(order_detail_creation_date_time)";
        }
        $arrUserDetail = $this->query($strQuery);

        //echo '<pre>',print_r($arrUserDetail);die;
        return $arrUserDetail;
    }

    public function fnGetOverTimeMonery($intPortalId = "", $strStartDate, $strEndDate) {

        //Configure::write('debug','2');
        if (!empty($strStartDate)) {
            $strQuery = "SELECT sum(portal_owner_cost) as OverTimeMonery,career_portal_name,order_detail_creation_date_time,product_name FROM `resource_order_detail` ,`career_portal` where `resource_order_detail`.order_from_portal=`career_portal`.`career_portal_id` and order_from_portal= '" . $intPortalId . "' AND order_detail_creation_date_time >= '" . $strStartDate . "' AND order_detail_creation_date_time<= '" . $strEndDate . "' GROUP BY date(order_detail_creation_date_time)";
        } else {
            $strQuery = "SELECT sum(portal_owner_cost) as OverTimeMonery,career_portal_name,order_detail_creation_date_time,product_name FROM `resource_order_detail` ,`career_portal` where `resource_order_detail`.order_from_portal=`career_portal`.`career_portal_id` and order_from_portal= '" . $intPortalId . "' GROUP BY date(order_detail_creation_date_time)";
        }
        $arrUserDetail = $this->query($strQuery);

        //echo '<pre>',print_r($arrUserDetail);die;
        return $arrUserDetail;
    }

    public function fnFindOwnerDetail($intOwnerId = "") {

        if ($intOwnerId) {

            $strQuery = "SELECT * FROM employer_detail WHERE employer_detail.employer_id = '" . $intOwnerId . "'";

            $arrUserDetail = $this->query($strQuery);

            return $arrUserDetail;
        }
    }

    public function fnGetCompleteUserDetail($intUid = "", $intUtype = "") {

        $arrCompleteUserDetail = array();


        if ($intUid) {

            $arrUserLDetails = AuthComponent::user();

            $arrCompleteUserDetail[0] = $arrUserLDetails;

            if ($intUtype == "2") {

                $objModelEmployer = ClassRegistry::init('Employer');

                $arrEmpDetail = $objModelEmployer->find('all', array(
                    'conditions' => array('employer_id' => $intUid)
                ));

                if (is_array($arrEmpDetail) && (count($arrEmpDetail) > 0)) {

                    $arrCompleteUserDetail = $this->fnFormatArray($arrCompleteUserDetail, $arrEmpDetail['0']['Employer']);

                    $arrEmpCountryDetail = $this->fnGetCountryName($arrEmpDetail['0']['Employer']['employer_country']);

                    $arrCompleteUserDetail = $this->fnFormatArray($arrCompleteUserDetail, $arrEmpCountryDetail['0']['country']);

                    $arrEmpStateDetail = $this->fnGetStateName($arrEmpDetail['0']['Employer']['employer_state']);

                    $arrCompleteUserDetail = $this->fnFormatArray($arrCompleteUserDetail, $arrEmpStateDetail['0']['state']);

                    $arrEmpCityDetail = $this->fnGetCityName($arrEmpDetail['0']['Employer']['employer_city']);

                    $arrCompleteUserDetail = $this->fnFormatArray($arrCompleteUserDetail, $arrEmpCityDetail['0']['city']);

                    $arrEmpIndustryDetail = $this->fnGetIndustryName($arrEmpDetail['0']['Employer']['employer_industry_type']);

                    $arrCompleteUserDetail = $this->fnFormatArray($arrCompleteUserDetail, $arrEmpIndustryDetail['0']['Industry']);
                }
            } else {

                $objModelAdmin = ClassRegistry::init('Admin');

                $arrAdminDetail = $objModelAdmin->find('all', array(
                    'conditions' => array('admin_id' => $intUid)
                ));

                if (is_array($arrAdminDetail['0']['Admin']) && (count($arrAdminDetail['0']['Admin']) > 0)) {

                    $arrCompleteUserDetail = $this->fnFormatArray($arrCompleteUserDetail, $arrAdminDetail['0']['Admin']);

                    $arrAdminCountryDetail = $this->fnGetCountryName($arrAdminDetail['0']['Admin']['admin_country']);

                    $arrCompleteUserDetail = $this->fnFormatArray($arrCompleteUserDetail, $arrAdminCountryDetail['0']['country']);

                    $arrAdminStateDetail = $this->fnGetStateName($arrAdminDetail['0']['Admin']['admin_state']);

                    $arrS = $this->fnFormatArray($arrCompleteUserDetail, $arrAdminStateDetail['0']['state']);

                    if (is_array($arrS) && (count($arrS) > 0)) {

                        $arrCompleteUserDetail = $arrS;
                    }



                    $arrAdminCityDetail = $this->fnGetCityName($arrAdminDetail['0']['Admin']['admin_city']);

                    $arrC = $this->fnFormatArray($arrCompleteUserDetail, $arrAdminCityDetail['0']['city']);

                    if (is_array($arrC) && (count($arrC) > 0)) {

                        $arrCompleteUserDetail = $arrC;
                    }
                }
            }





            /* print("<pre>");

              print_r($arrCompleteUserDetail); */



            return $arrCompleteUserDetail;
        } else {

            return false;
        }
    }

    public function fnAdminDetails() {
        $arrReturnArray = $this->query("SELECT id,user_type,email FROM user WHERE user_type=1");
        return $arrReturnArray;
    }

    public function fnGetJobSeekerThemeRegister($portalID = "", $strStartDate, $strEndDate, $strThemeName = "") {
        if (!empty($strStartDate) || $portalID !='all' || $intPortalId == '') {
            if ($strThemeName != '') {
                $strQuery = "SELECT count(portal_theme_name) as total FROM `career_portal_candidate` WHERE career_portal_id='" . $portalID . "' AND candidate_creation_date >= '" . $strStartDate . "' AND candidate_creation_date<= '" . $strEndDate . "' AND portal_theme_name='" . $strThemeName . "'";
            } else {
                $strQuery = "SELECT count(portal_theme_name) as total FROM `career_portal_candidate` WHERE career_portal_id='" . $portalID . "' AND candidate_creation_date >= '" . $strStartDate . "' AND candidate_creation_date<= '" . $strEndDate . "'";
            }
        } else {
            if ($strThemeName != '') {
                $strQuery = "SELECT count(portal_theme_name) as total FROM `career_portal_candidate` WHERE portal_theme_name='" . $strThemeName . "'";
            } else {
                $strQuery = "SELECT count(portal_theme_name) as total FROM `career_portal_candidate`";
            }
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }

    public function fnGetJobSeekerThemeRegisterDetails($portalID = "", $strStartDate, $strEndDate, $strThemeName = "") {
        if (!empty($strStartDate) || $portalID != 'all' || $intPortalId == '') {
            if ($strThemeName != '') {
                $strQuery = "SELECT distinct count(candidate_creation_date) as total, candidate_first_name,candidate_last_name,candidate_email,candidate_creation_date,portal_theme_name  FROM `career_portal_candidate` WHERE career_portal_id='" . $portalID . "' AND candidate_creation_date >= '" . $strStartDate . "' AND candidate_creation_date<= '" . $strEndDate . "' AND portal_theme_name='" . $strThemeName . "'";
            } else {
                $strQuery = "SELECT distinct candidate_first_name,candidate_last_name,candidate_email,candidate_creation_date,portal_theme_name  FROM `career_portal_candidate` WHERE career_portal_id='" . $portalID . "' AND candidate_creation_date >= '" . $strStartDate . "' AND candidate_creation_date<= '" . $strEndDate . "' GROUP BY date(candidate_creation_date)";
            }
        } else {
            if ($strThemeName != '') {
                $strQuery = "SELECT distinct candidate_first_name,candidate_last_name,candidate_email,candidate_creation_date,portal_theme_name  FROM `career_portal_candidate` WHERE portal_theme_name='" . $strThemeName . "'";
            } else {
                $strQuery = "SELECT distinct count(candidate_creation_date) as total, candidate_first_name,candidate_last_name,candidate_email,candidate_creation_date,portal_theme_name  FROM `career_portal_candidate` GROUP BY date(candidate_creation_date)";
            }
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }
    
    public function fnGetJobSeekerThemeRegisterList($portalID = "", $strStartDate, $strEndDate, $strThemeName = "") {
        if (!empty($strStartDate) || $portalID != 'all' || $intPortalId == '') {
            if ($strThemeName != '') {
                $strQuery = "SELECT candidate_first_name,candidate_last_name,candidate_email,candidate_creation_date,portal_theme_name  FROM `career_portal_candidate` WHERE career_portal_id='" . $portalID . "' AND candidate_creation_date >= '" . $strStartDate . "' AND candidate_creation_date<= '" . $strEndDate . "' AND portal_theme_name='" . $strThemeName . "'";
            } else {
                $strQuery = "SELECT candidate_first_name,candidate_last_name,candidate_email,candidate_creation_date,portal_theme_name  FROM `career_portal_candidate` WHERE career_portal_id='" . $portalID . "' AND candidate_creation_date >= '" . $strStartDate . "' AND candidate_creation_date<= '" . $strEndDate . "'";
            }
        } else {
            if ($strThemeName != '') {
                $strQuery = "SELECT candidate_first_name,candidate_last_name,candidate_email,candidate_creation_date,portal_theme_name  FROM `career_portal_candidate` WHERE portal_theme_name='" . $strThemeName . "'";
            } else {
                $strQuery = "SELECT candidate_first_name,candidate_last_name,candidate_email,candidate_creation_date,portal_theme_name  FROM `career_portal_candidate`";
            }
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }

    public function fnGetJobSeekerActiveRegisterDetails($portalID = "", $strStartDate, $strEndDate, $is_status) {
        if (!empty($strStartDate)) {
            $strQuery = "SELECT distinct count(candidate_creation_date) as total, candidate_first_name,candidate_last_name,candidate_email,candidate_creation_date FROM `career_portal_candidate` WHERE candidate_confirmed='1' AND candidate_is_active='" . $is_status . "' AND career_portal_id='" . $portalID . "' AND candidate_creation_date >= '" . $strStartDate . "' AND candidate_creation_date<= '" . $strEndDate . "'";
        } else {
            $strQuery = "SELECT distinct count(candidate_creation_date) as total, candidate_first_name,candidate_last_name,candidate_email,candidate_creation_date FROM `career_portal_candidate` WHERE candidate_confirmed='1' AND candidate_is_active='" . $is_status . "' AND career_portal_id='" . $portalID . "' GROUP BY date(candidate_creation_date)";
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }

    public function fnGetPortalOwnersUsers($intPortalId = "", $strStartDate, $strEndDate,$portalOwner) {
        if ($intPortalId == "all" || $intPortalId == '') {
            if (!empty($strStartDate)) {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,user_creation_date FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.portal_id = career_portal.career_portal_id AND user_creation_date>='" . $strStartDate . "' AND user_creation_date<='" . $strEndDate . "'";
            } else {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,user_creation_date FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.portal_id = career_portal.career_portal_id";
            }

            $arrUserDetail = $this->query($strQuery);

            return $arrUserDetail;
        } else {
            if (!empty($strStartDate)) {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,user_creation_date FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.portal_id = '" . $intPortalId . "' AND user_creation_date>='" . $strStartDate . "' AND user_creation_date<='" . $strEndDate . "' AND user.portal_id = career_portal.career_portal_id AND career_portal_created_by='".$portalOwner."'";
            } else {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,user_creation_date FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.portal_id = '" . $intPortalId . "' AND user.portal_id = career_portal.career_portal_id AND career_portal_created_by='".$portalOwner."'";
            }

            $arrUserDetail = $this->query($strQuery);

            return $arrUserDetail;
        }
    }

    public function fnGetPortalOwnersActiveInactiveUsers($intPortalId = "", $strStartDate, $strEndDate,$portalOwner,$status="") {
        if ($intPortalId == "all" || $intPortalId == '') {
            if (!empty($strStartDate)) {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,user_creation_date FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.portal_id = career_portal.career_portal_id AND user_creation_date>='" . $strStartDate . "' AND user_creation_date<='" . $strEndDate . "' AND is_active='".$status."'";
            } else {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,user_creation_date FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.portal_id = career_portal.career_portal_id AND career_portal_created_by='".$portalOwner."' AND is_active='".$status."'";
            }

            $arrUserDetail = $this->query($strQuery);

            return $arrUserDetail;
        } else {
            if (!empty($strStartDate)) {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,user_creation_date FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.portal_id = '" . $intPortalId . "' AND user_creation_date>='" . $strStartDate . "' AND user_creation_date<='" . $strEndDate . "' AND user.portal_id = career_portal.career_portal_id AND career_portal_created_by='".$portalOwner."' AND is_active='".$status."'";
            } else {
                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,user_creation_date FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.portal_id = '" . $intPortalId . "' AND user.portal_id = career_portal.career_portal_id AND career_portal_created_by='".$portalOwner."' AND is_active='".$status."'";
            }

            $arrUserDetail = $this->query($strQuery);

            return $arrUserDetail;
        }
    }
    
    public function fnGetJobSeekerAdminPurchasedOrder($strStartDate, $strEndDate,$productType,$datePeriod="",$intPortalId="") {
        if (!empty($strStartDate) || $intPortalId !='') {
            if($productType !='' && $productType !='All'){
                $strQuery = "SELECT distinct sum(vendor_cost)as total,order_creation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `resource_order`,resource_order_detail,products,`career_portal_candidate` WHERE career_portal_candidate.candidate_id=`resource_order_detail`.seeker_id AND `resource_order_detail`.product_id=`products`.productd_id AND order_payment_status='captured' AND resource_order_detail.order_from_portal='".$intPortalId."' AND order_creation_date_time >= '" . $strStartDate . "' AND order_creation_date_time<= '" . $strEndDate . "' AND product_type='".$productType."' GROUP BY $datePeriod(order_creation_date_time)";
            }else{
                $strQuery = "SELECT distinct sum(vendor_cost) as total,order_creation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `resource_order`,resource_order_detail,products,`career_portal_candidate` WHERE career_portal_candidate.candidate_id=`resource_order_detail`.seeker_id AND `resource_order_detail`.product_id=`products`.productd_id AND order_payment_status='captured' AND resource_order_detail.order_from_portal='".$intPortalId."' AND order_creation_date_time >= '" . $strStartDate . "' AND order_creation_date_time<= '" . $strEndDate . "' GROUP BY $datePeriod(order_creation_date_time)";
            }
        } else {
            if($productType !='' && $productType !='All'){
               $strQuery = "SELECT distinct sum(vendor_cost) as total,order_creation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `resource_order`,resource_order_detail,products,`career_portal_candidate` WHERE career_portal_candidate.candidate_id=`resource_order_detail`.seeker_id AND `resource_order_detail`.product_id=`products`.productd_id and order_payment_status='captured' AND product_type='".$productType."' GROUP BY $datePeriod(order_creation_date_time)";  
            }else {
               $strQuery = "SELECT distinct sum(vendor_cost) as total,order_creation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `resource_order`,resource_order_detail,products,`career_portal_candidate` WHERE career_portal_candidate.candidate_id=`resource_order_detail`.seeker_id AND `resource_order_detail`.product_id=`products`.productd_id AND order_payment_status='captured' GROUP BY $datePeriod(order_creation_date_time)";  
            }
            
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }
    
    public function fnGetJobSeekerAdminPurchasedOrderList($strStartDate, $strEndDate,$productType,$intPortalId="") {
        if (!empty($strStartDate) || $intPortalId !='') {
            if($productType !='' && $productType !='All'){
                $strQuery = "SELECT distinct vendor_cost as total,order_creation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `resource_order`,resource_order_detail,products,`career_portal_candidate` WHERE career_portal_candidate.candidate_id=`resource_order_detail`.seeker_id AND `resource_order_detail`.product_id=`products`.productd_id AND order_payment_status='captured' AND resource_order_detail.order_from_portal='".$intPortalId."' AND order_creation_date_time >= '" . $strStartDate . "' AND order_creation_date_time<= '" . $strEndDate . "' AND product_type='".$productType."'";
            }else{
                $strQuery = "SELECT distinct vendor_cost as total,order_creation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `resource_order`,resource_order_detail,products,`career_portal_candidate` WHERE career_portal_candidate.candidate_id=`resource_order_detail`.seeker_id AND `resource_order_detail`.product_id=`products`.productd_id AND order_payment_status='captured' AND resource_order_detail.order_from_portal='".$intPortalId."' AND order_creation_date_time >= '" . $strStartDate . "' AND order_creation_date_time<= '" . $strEndDate . "'";
            }
        } else {
            if($productType !='' && $productType !='All'){
               $strQuery = "SELECT distinct vendor_cost as total,order_creation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `resource_order`,resource_order_detail,products,`career_portal_candidate` WHERE career_portal_candidate.candidate_id=`resource_order_detail`.seeker_id AND `resource_order_detail`.product_id=`products`.productd_id and order_payment_status='captured' AND product_type='".$productType."'";  
            }else {
               $strQuery = "SELECT distinct vendor_cost as total,order_creation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `resource_order`,resource_order_detail,products,`career_portal_candidate` WHERE career_portal_candidate.candidate_id=`resource_order_detail`.seeker_id AND `resource_order_detail`.product_id=`products`.productd_id AND order_payment_status='captured'";  
            }
            
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }
    
    public function fnGetPortalOwnerName() {
        $strProductListQuery = "SELECT username,id FROM `user` WHERE user.portal_id !='0' AND is_active='1' ORDER BY username ASC";
        $arrProductContentArray = $this->query($strProductListQuery);
        return $arrProductContentArray;
    }

//    public function fnGetJobSeekerAdminRefundedOrder($strStartDate, $strEndDate,$productType,$datePeriod="",$intPortalId="") {
//        if (!empty($strStartDate) || $intPortalId !='') {
//            if($productType !='' && $productType !='All'){
//                $strQuery = "SELECT distinct sum(vendor_cost)as total,order_creation_date_time FROM `resource_order`,resource_order_detail,products WHERE `resource_order_detail`.product_id=`products`.productd_id AND resource_order_detail.refund_status = 1 AND resource_order_detail.order_from_portal='".$intPortalId."' AND order_creation_date_time >= '" . $strStartDate . "' AND order_creation_date_time<= '" . $strEndDate . "' AND product_type='".$productType."' GROUP BY $datePeriod(order_creation_date_time)";
//            }else{
//                $strQuery = "SELECT distinct sum(vendor_cost) as total,order_creation_date_time FROM `resource_order`,resource_order_detail,products  WHERE `resource_order_detail`.product_id=`products`.productd_id AND resource_order_detail.refund_status = 1 AND resource_order_detail.order_from_portal='".$intPortalId."' AND order_creation_date_time >= '" . $strStartDate . "' AND order_creation_date_time<= '" . $strEndDate . "' GROUP BY $datePeriod(order_creation_date_time)";
//            }
//        } else {
//            if($productType !='' && $productType !='All'){
//               $strQuery = "SELECT distinct sum(vendor_cost) as total,order_creation_date_time FROM `resource_order`,resource_order_detail,products  WHERE `resource_order_detail`.product_id=`products`.productd_id AND `resource_order_detail`.product_id=`products`.productd_id and resource_order_detail.refund_status = 1 AND product_type='".$productType."' GROUP BY $datePeriod(order_creation_date_time)";  
//            }else {
//               $strQuery = "SELECT distinct sum(vendor_cost) as total,order_creation_date_time FROM `resource_order`,resource_order_detail,products  WHERE `resource_order_detail`.product_id=`products`.productd_id AND resource_order_detail.refund_status = 1 GROUP BY $datePeriod(order_creation_date_time)";  
//            }
//            
//        }
//        $arrUserDetail = $this->query($strQuery);
//        return $arrUserDetail;
//    }
    
    public function fnGetJobSeekerAdminRefundedOrder($strStartDate, $strEndDate,$productType,$datePeriod="",$intPortalId="") {
        if (!empty($strStartDate) || $intPortalId !='') {
            if($productType !='' && $productType !='All'){
                $strQuery = "SELECT distinct sum(vendor_cost)as total,order_creation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `resource_order`,resource_order_detail,products,`career_portal_candidate` WHERE career_portal_candidate.candidate_id=`resource_order_detail`.seeker_id AND `resource_order_detail`.product_id=`products`.productd_id AND resource_order_detail.refund_status = 1 AND resource_order_detail.order_from_portal='".$intPortalId."' AND order_creation_date_time >= '" . $strStartDate . "' AND order_creation_date_time<= '" . $strEndDate . "' AND product_type='".$productType."' GROUP BY $datePeriod(order_creation_date_time)";
            }else{
                $strQuery = "SELECT distinct sum(vendor_cost) as total,order_creation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `resource_order`,resource_order_detail,products,`career_portal_candidate` WHERE career_portal_candidate.candidate_id=`resource_order_detail`.seeker_id AND `resource_order_detail`.product_id=`products`.productd_id AND resource_order_detail.refund_status = 1 AND resource_order_detail.order_from_portal='".$intPortalId."' AND order_creation_date_time >= '" . $strStartDate . "' AND order_creation_date_time<= '" . $strEndDate . "' GROUP BY $datePeriod(order_creation_date_time)";
            }
        } else {
            if($productType !='' && $productType !='All'){
               $strQuery = "SELECT distinct sum(vendor_cost) as total,order_creation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `resource_order`,resource_order_detail,products ,`career_portal_candidate` WHERE career_portal_candidate.candidate_id=`resource_order_detail`.seeker_id AND `resource_order_detail`.product_id=`products`.productd_id AND `resource_order_detail`.product_id=`products`.productd_id and resource_order_detail.refund_status = 1 AND product_type='".$productType."' GROUP BY $datePeriod(order_creation_date_time)";  
            }else {
               $strQuery = "SELECT distinct sum(vendor_cost) as total,order_creation_date_time,career_portal_candidate.candidate_email,career_portal_candidate.candidate_first_name,career_portal_candidate.candidate_last_name FROM `resource_order`,resource_order_detail,products,`career_portal_candidate` WHERE career_portal_candidate.candidate_id=`resource_order_detail`.seeker_id AND `resource_order_detail`.product_id=`products`.productd_id AND resource_order_detail.refund_status = 1 GROUP BY $datePeriod(order_creation_date_time)";  
            }
            
        }
        $arrUserDetail = $this->query($strQuery);
        return $arrUserDetail;
    }
//    
//    public function fnGetUserDetailForCheckFBPortal($intPortalId = "",$email) {
//        if ($intPortalId == "all") {
//            if (!empty($email)) {
//                $strQuery = "SELECT username,email FROM user WHERE user.email='" . $email . "'";
//            } else {
//                $strQuery = "SELECT username,email FROM user";
//            }
//
//            $arrUserDetail = $this->query($strQuery);
//
//            return $arrUserDetail;
//        } else {
//            if (!empty($email)) {
//                 $strQuery = "SELECT username,email FROM user WHERE user.email='" . $email . "'";
//            } else {
//                $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name FROM user";
//            }
//
//            $arrUserDetail = $this->query($strQuery);
//
//            return $arrUserDetail;
//        }
//    }
}
