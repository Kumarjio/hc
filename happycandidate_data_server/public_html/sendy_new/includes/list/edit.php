<?php include('../functions.php'); ?>
<?php include('../login/auth.php'); ?>
<?php include('../helpers/EmailAddressValidator.php'); ?>
<?php

//------------------------------------------------------//
//                      VARIABLES                       //
//------------------------------------------------------//

$app = mysqli_real_escape_string($mysqli, $_POST['id']);
$list_id = mysqli_real_escape_string($mysqli, $_POST['list']);
$list_name = mysqli_real_escape_string($mysqli, $_POST['list_name']);
$userID = get_app_info('main_userID');

$userType = mysqli_real_escape_string($mysqli, $_POST['user_type']);
$portalID = mysqli_real_escape_string($mysqli, $_POST['portal_list']);
$subscribeType = mysqli_real_escape_string($mysqli, $_POST['subscribe_type']);
$productType = mysqli_real_escape_string($mysqli, $_POST['product_type']);
$service_id = mysqli_real_escape_string($mysqli, $_POST['services']);
$course_id = mysqli_real_escape_string($mysqli, $_POST['course']);
$product_id = mysqli_real_escape_string($mysqli, $_POST['products']);
$skillsofts_id = mysqli_real_escape_string($mysqli, $_POST['skillsofts']);
$time = time();


//subscribe settings
$opt_in = mysqli_real_escape_string($mysqli, $_POST['opt_in']);
$subscribed_url = mysqli_real_escape_string($mysqli, $_POST['subscribed_url']);
$confirm_url = mysqli_real_escape_string($mysqli, $_POST['confirm_url']);
$thankyou = isset($_POST['thankyou_email']) ? mysqli_real_escape_string($mysqli, $_POST['thankyou_email']) : '';
$thankyou_subject = addslashes(mysqli_real_escape_string($mysqli, $_POST['thankyou_subject']));
$thankyou_message = addslashes($_POST['thankyou_message']);
if (preg_replace('/\s+/', '', $thankyou_message) == '<html><head></head><body></body></html>')
    $thankyou_message = '';
if ($thankyou != '')
    $thankyou = 1;
else
    $thankyou = 0;
//unsubscribe settings
$unsubscribe_all_list = mysqli_real_escape_string($mysqli, $_POST['unsubscribe_all_list']);
$unsubscribed_url = mysqli_real_escape_string($mysqli, $_POST['unsubscribed_url']);
$goodbye = isset($_POST['goodbye_email']) ? mysqli_real_escape_string($mysqli, $_POST['goodbye_email']) : '';
$goodbye_subject = addslashes(mysqli_real_escape_string($mysqli, $_POST['goodbye_subject']));
$goodbye_message = addslashes($_POST['goodbye_message']);
if (preg_replace('/\s+/', '', $goodbye_message) == '<html><head></head><body></body></html>')
    $goodbye_message = '';
$confirmation_subject = addslashes(mysqli_real_escape_string($mysqli, $_POST['confirmation_subject']));
$confirmation_email = addslashes($_POST['confirmation_email']);
if (preg_replace('/\s+/', '', $confirmation_email) == '<html><head></head><body></body></html>')
    $confirmation_email = '';
if ($goodbye != '')
    $goodbye = 1;
else
    $goodbye = 0;

//------------------------------------------------------//
//                      FUNCTIONS                       //
//------------------------------------------------------//

$q = 'UPDATE lists SET name = "' . $list_name . '", opt_in = ' . $opt_in . ', subscribed_url = "' . $subscribed_url . '", confirm_url = "' . $confirm_url . '", thankyou = ' . $thankyou . ', thankyou_subject = "' . $thankyou_subject . '", thankyou_message = "' . $thankyou_message . '", unsubscribe_all_list = ' . $unsubscribe_all_list . ', unsubscribed_url = "' . $unsubscribed_url . '", goodbye = ' . $goodbye . ', goodbye_subject = "' . $goodbye_subject . '", goodbye_message = "' . $goodbye_message . '", confirmation_subject = "' . $confirmation_subject . '", confirmation_email = "' . $confirmation_email . '", user_type = "' . $userType . '", portal_id = "' . $portalID . '", subscribe_status = "' . $subscribeType . '", product_type = "' . $productType . '", service_id = "' . $service_id . '", course_id = "' . $course_id . '", product_id = "' . $product_id . '", skillsofts_id = "' . $skillsofts_id . '" WHERE id = ' . $list_id;

$r = mysqli_query($mysqli, $q);



$conn = mysqli_connect($HCdbhost, $HCdbuser, $HCdbpass, $HCdbname);
if ($userType == 'owner' && $subscribeType != '') {
    if ($portalID != '') {
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

//get comma separated lists belonging to this app
$q2 = 'SELECT id FROM lists WHERE app = ' . $app;
$r2 = mysqli_query($mysqli, $q2);
if ($r2) {
    $all_lists = '';
    while ($row = mysqli_fetch_array($r2))
        $all_lists .= $row['id'] . ',';
    $all_lists = substr($all_lists, 0, -1);
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

    $q = 'SELECT email FROM subscribers WHERE list = ' . $list_id . ' AND email = "' . trim($email) . '" AND userID = ' . $userID;
    $r = mysqli_query($mysqli, $q);

    if (mysqli_num_rows($r) > 0) {
        
    } else {
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
    }
}

header("Location: " . get_app_info('path') . "/list?i=" . $app);
?>