<?php

class Jobsearchtracker extends AppModel {

    public $name = 'Jobsearchtracker';
    public $useTable = 'jobsearcprocess_completion_tracker';

    /* public $validate = array(

      'user_name' => array(

      'alphaNumeric' => array(

      'rule' => 'notEmpty',

      'message' => 'Alphabets and numbers only',

      )

      ),

      'userpass' => array(

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

    /* )

      ); */

    public function fnGetCatContentParentData($intProductId, $intCatuser) {

        if ($intProductId) {

            $strProductListQuery = "SELECT content_category.content_category_id,content_category.content_category_parent_id FROM content_category WHERE content_category.content_category_id='" . $intProductId . "' AND content_cat_for_user='" . $intCatuser . "'";

            //echo $strProductListQuery;exit;

            $arrProductContentArray = $this->query($strProductListQuery);

            return $arrProductContentArray;
        }
    }
    
    public function fnGetJobSeekerPhaseCompleted($stepID="",$strStartDate, $strEndDate) {
       if (!empty($strStartDate)) {
           $strQuery = "SELECT count(jobsearcprocess_completion_tracker.candidate_id) as total  FROM `jobsearcprocess_completion_tracker`,`career_portal_candidate` where `jobsearcprocess_completion_tracker`.candidate_id=`career_portal_candidate`.`candidate_id` AND step_id='".$stepID."' AND `jobsearcprocess_completion_tracker`.completion_date_time >= '" . $strStartDate . "' AND `jobsearcprocess_completion_tracker`.completion_date_time<= '" . $strEndDate . "'";
       } else {
           $strQuery = "SELECT count(jobsearcprocess_completion_tracker.candidate_id) as total  FROM `jobsearcprocess_completion_tracker`,`career_portal_candidate` where `jobsearcprocess_completion_tracker`.candidate_id=`career_portal_candidate`.`candidate_id` AND step_id='".$stepID."'";
       }
       $arrUserDetail = $this->query($strQuery);
       return end($arrUserDetail);
   }
    
    public function fnGetJobSeekerPhaseWiseCompleted($stepID="",$strStartDate, $strEndDate) {
       if (!empty($strStartDate)) {
           $strQuery = "SELECT distinct candidate_first_name,candidate_last_name,candidate_email,jobsearcprocess_completion_tracker.completion_date_time,content_category.content_category_name FROM `jobsearcprocess_completion_tracker`,`career_portal_candidate`,content_category where `jobsearcprocess_completion_tracker`.candidate_id=`career_portal_candidate`.`candidate_id` AND content_category.content_category_id=`jobsearcprocess_completion_tracker`.step_id AND step_id='".$stepID."' AND completion_date_time >= '" . $strStartDate . "' AND completion_date_time<= '" . $strEndDate . "'";
       } else {
           $strQuery = "SELECT distinct candidate_first_name,candidate_last_name,candidate_email,jobsearcprocess_completion_tracker.completion_date_time,content_category.content_category_name FROM `jobsearcprocess_completion_tracker`,`career_portal_candidate`,content_category where `jobsearcprocess_completion_tracker`.candidate_id=`career_portal_candidate`.`candidate_id` AND content_category.content_category_id=`jobsearcprocess_completion_tracker`.step_id AND step_id='".$stepID."'";
       }
       $arrUserDetail = $this->query($strQuery);
       return $arrUserDetail;
   }
   
   public function fnGetJobSeekerPhaseCompletedGraph($stepID="",$strStartDate, $strEndDate) {
       if (!empty($strStartDate)) {
           if ($stepID != '') {
            $strQuery = "SELECT count(completion_date_time) as total, candidate_first_name,candidate_last_name,candidate_email,jobsearcprocess_completion_tracker.completion_date_time,content_category.content_category_name FROM `jobsearcprocess_completion_tracker`,`career_portal_candidate`,content_category where `jobsearcprocess_completion_tracker`.candidate_id=`career_portal_candidate`.`candidate_id` AND content_category.content_category_id=`jobsearcprocess_completion_tracker`.step_id AND completion_date_time >= '" . $strStartDate . "' AND completion_date_time<= '" . $strEndDate . "' AND `jobsearcprocess_completion_tracker`.step_type = 'Phase' GROUP BY date(completion_date_time)";
           }
       } else {
           if ($stepID != '') {
               $strQuery = "SELECT count(completion_date_time) as total, candidate_first_name,candidate_last_name,candidate_email,jobsearcprocess_completion_tracker.completion_date_time,content_category.content_category_name FROM `jobsearcprocess_completion_tracker`,`career_portal_candidate`,content_category where `jobsearcprocess_completion_tracker`.candidate_id=`career_portal_candidate`.`candidate_id` AND content_category.content_category_id=`jobsearcprocess_completion_tracker`.step_id AND `jobsearcprocess_completion_tracker`.step_type = 'Phase' GROUP BY date(completion_date_time)";
           }
       }
       $arrUserDetail = $this->query($strQuery);
       return $arrUserDetail;
   }

}

?>