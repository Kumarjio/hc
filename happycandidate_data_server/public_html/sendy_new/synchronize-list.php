<?php include('includes/functions.php'); ?>
<?php include('includes/login/auth.php'); ?>
<?php include('includes/helpers/EmailAddressValidator.php'); ?>
<?php

//------------------------------------------------------//
//                      FUNCTIONS                       //
//------------------------------------------------------//
$conn = mysqli_connect($HCdbhost, $HCdbuser, $HCdbpass, $HCdbname);
$arr_app = 'SELECT id,userID FROM apps';
$arrR = mysqli_query($mysqli, $arr_app);
if ($arrR) {
    $app = '';
    while ($arrResult = mysqli_fetch_array($arrR)) {
        $app = $arrResult['id'];
        $userID = $arrResult['userID'];
        $time = time();
        //get comma separated lists belonging to this app
        $q2 = 'SELECT id,user_type,portal_id,subscribe_status,service_id,course_id,product_id,skillsofts_id FROM lists WHERE app = ' . $app;
        $r2 = mysqli_query($mysqli, $q2);
        if ($r2) {
            $all_lists = '';
            $list_id = '';
            $userType = '';
            $portalID = '';
            $subscribeType = '';

            while ($row = mysqli_fetch_array($r2)) {
                $line_array = '';
                $list_id = $row['id'];
                $userType = $row['user_type'];
                $portalID = $row['portal_id'];
                $subscribeType = $row['subscribe_status'];
                $service_id = $row['service_id'];
                $course_id = $row['course_id'];
                $product_id = $row['product_id'];
                $skillsofts_id = $row['skillsofts_id'];
                $all_lists .= $row['id'] . ',';
                $all_lists = substr($all_lists, 0, -1);


                if ($userType == 'owner') {
                    if ($portalID != '' && $portalID != '0') {
                        if ($subscribeType == 'all') {
                            $q = 'SELECT user.email,employer_user_fname,employer_user_lname FROM user INNER JOIN employer_detail WHERE user.id = employer_detail.employer_id AND user_type=2 AND portal_id="' . $portalID . '"';
                        } else {
                            $q = 'SELECT user.email,employer_user_fname,employer_user_lname FROM user INNER JOIN employer_detail WHERE user.id = employer_detail.employer_id AND is_active ="' . $subscribeType . '" AND user_type=2 AND portal_id="' . $portalID . '"';
                        }
                    } else {
                        if ($subscribeType == 'all') {
                            $q = 'SELECT user.email,employer_user_fname,employer_user_lname FROM user INNER JOIN employer_detail WHERE user.id = employer_detail.employer_id AND user_type=2';
                        } else {
                            $q = 'SELECT user.email,employer_user_fname,employer_user_lname FROM user INNER JOIN employer_detail WHERE user.id = employer_detail.employer_id AND is_active ="' . $subscribeType . '" AND user_type=2';
                        }
                    }
                    $r = mysqli_query($conn, $q);
                    if ($r) {
                        while ($arrEmail = mysqli_fetch_array($r)) {

                            $name = strip_tags($arrEmail['employer_user_fname'] . " " . $arrEmail['employer_user_lname']);
                            $email = trim($arrEmail['email']);
                            $line_array[] = ($name . "," . $email);
                        }
                    }
                } else if ($userType == 'vendor') {
                    if ($subscribeType == 'all') {
                        $q = 'SELECT vendor_email,vendor_first_name,vendor_last_name FROM vendors';
                    } else {
                        $q = 'SELECT vendor_email,vendor_first_name,vendor_last_name FROM vendors WHERE vendor_active ="' . $subscribeType . '"';
                    }
                    $r = mysqli_query($conn, $q);
                    if ($r) {
                        while ($arrEmail = mysqli_fetch_array($r)) {

                            $name = strip_tags($arrEmail['vendor_first_name'] . " " . $arrEmail['vendor_last_name']);
                            $email = trim($arrEmail['vendor_email']);
                            $line_array[] = ($name . "," . $email);
                        }
                    }
                } else {
                    if ($userType != '' && $subscribeType != '') {
                        if ($portalID != '' && $portalID != '0') {
                            if ($productType != '' && $service_id != '' || $course_id != '' || $product_id != '' || $skillsofts_id != '') {
                                if ($subscribeType == 'all') {
                                    $q = 'SELECT candidate_first_name,candidate_last_name,candidate_email FROM career_portal_candidate INNER JOIN resource_order_detail WHERE career_portal_id="' . $portalID . '" AND resource_order_detail.vendor_service_id="' . $service_id . '" OR resource_order_detail.vendor_service_id="' . $course_id . '" OR resource_order_detail.vendor_service_id="' . $product_id . '" OR resource_order_detail.vendor_service_id="' . $skillsofts_id . '"';
                                } else {
                                    $q = 'SELECT candidate_first_name,candidate_last_name,candidate_email FROM career_portal_candidate INNER JOIN resource_order_detail WHERE candidate_is_active ="' . $subscribeType . '" AND career_portal_id="' . $portalID . '" AND resource_order_detail.vendor_service_id="' . $service_id . '" OR resource_order_detail.vendor_service_id="' . $course_id . '" OR resource_order_detail.vendor_service_id="' . $product_id . '" OR resource_order_detail.vendor_service_id="' . $skillsofts_id . '"';
                                }
                            } else {
                                if ($subscribeType == 'all') {
                                    $q = 'SELECT candidate_first_name,candidate_last_name,candidate_email FROM career_portal_candidate WHERE career_portal_id="' . $portalID . '"';
                                } else {
                                    $q = 'SELECT candidate_first_name,candidate_last_name,candidate_email FROM career_portal_candidate WHERE candidate_is_active ="' . $subscribeType . '" AND career_portal_id="' . $portalID . '"';
                                }
                            }
                        } else {
                            if ($productType != '' && $service_id != '' || $course_id != '' || $product_id != '' || $skillsofts_id != '') {
                                if ($subscribeType == 'all') {
                                    $q = 'SELECT candidate_first_name,candidate_last_name,candidate_email FROM career_portal_candidate INNER JOIN resource_order_detail WHERE resource_order_detail.vendor_service_id="' . $service_id . '" OR resource_order_detail.vendor_service_id="' . $course_id . '" OR resource_order_detail.vendor_service_id="' . $product_id . '" OR resource_order_detail.vendor_service_id="' . $skillsofts_id . '"';
                                } else {
                                    $q = 'SELECT candidate_first_name,candidate_last_name,candidate_email FROM career_portal_candidate INNER JOIN resource_order_detail WHERE candidate_is_active ="' . $subscribeType . '" AND resource_order_detail.vendor_service_id="' . $service_id . '" OR resource_order_detail.vendor_service_id="' . $course_id . '" OR resource_order_detail.vendor_service_id="' . $product_id . '" OR resource_order_detail.vendor_service_id="' . $skillsofts_id . '"';
                                }
                            } else {
                                if ($subscribeType == 'all') {
                                    $q = 'SELECT candidate_first_name,candidate_last_name,candidate_email FROM career_portal_candidate';
                                } else {
                                    $q = 'SELECT candidate_first_name,candidate_last_name,candidate_email FROM career_portal_candidate WHERE candidate_is_active ="' . $subscribeType . '"';
                                }
                            }
                        }

                        $r = mysqli_query($conn, $q);
                        if ($r) {
                            while ($arrEmail = mysqli_fetch_array($r)) {

                                $name = strip_tags($arrEmail['candidate_first_name'] . " " . $arrEmail['candidate_last_name']);
                                $email = trim($arrEmail['candidate_email']);
                                $line_array[] = ($name . "," . $email);
                            }
                        }
                    }
                }


                $q = 'DELETE FROM subscribers WHERE list = ' . $list_id . '';
                $r = mysqli_query($mysqli, $q);

                for ($i = 0; $i < count($line_array); $i++) {
                    $the_line = explode(',', $line_array[$i]);
                    if (count($the_line) == 1) {
                        $name = '';
                        $email = $the_line[0];
                    } else {
                        $name = strip_tags($the_line[0]);
                        $email = $the_line[1];
                    }

                    $email = trim($email);

//                    $q = 'SELECT email FROM subscribers WHERE list = ' . $list_id . ' AND email = "' . trim($email) . '" AND userID = ' . $userID;
//                    $r = mysqli_query($mysqli, $q);
//                    
//                    if (mysqli_num_rows($r) > 0) {
//                        
//                    } else {
                    //Check if user set the list to unsubscribe from all lists
                    $q = 'SELECT unsubscribe_all_list FROM lists WHERE id = ' . $list_id;
                    $r = mysqli_query($mysqli, $q);
                    if ($r) {
                        while ($row = mysqli_fetch_array($r)) {
                            $unsubscribe_all_list = $row['unsubscribe_all_list'];
                        }
                    }
                    //Check if this email is previously marked as bounced, if so, we shouldn't add it
                    if ($unsubscribe_all_list) {
                        $q = 'SELECT email from subscribers WHERE ( email = "' . trim($email) . '" AND bounced = 1 ) OR ( email = "' . trim($email) . '" AND list IN (' . $all_lists . ') AND (complaint = 1 OR unsubscribed = 1) )';
                    } else {
                        $q = 'SELECT email from subscribers WHERE ( email = "' . trim($email) . '" AND bounced = 1 ) OR ( email = "' . trim($email) . '" AND list IN (' . $all_lists . ') AND complaint = 1 )';
                    }
                    $r = mysqli_query($mysqli, $q);
                    if (mysqli_num_rows($r) > 0) {
                        
                    } else {
                        $validator = new EmailAddressValidator;
                        if ($validator->check_email_address(trim($email))) {
                            $q = 'INSERT INTO subscribers (userID, name, email, list, timestamp) values(' . $userID . ', "' . $name . '", "' . trim($email) . '", ' . $list_id . ', ' . $time . ')';
                            $r = mysqli_query($mysqli, $q);
                            if ($r) {
                                
                            }
                        }
                    }
//                    }
                }
            }
        }
    }
}
?>