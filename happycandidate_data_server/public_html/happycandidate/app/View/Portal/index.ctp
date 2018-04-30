<?php
$strWebinarUrl = Router::url(array('controller' => 'candidates', 'action' => 'webinars', $intPortalId), true);
$strLibraryUrl = Router::url(array('controller' => 'candidates', 'action' => 'library', $intPortalId), true);
$strLoginUrl = Router::url(array('controller' => 'portal', 'action' => 'login', $intPortalId), true);
$strJobSearchTrackerUrl = Router::url(array('controller' => 'jstracker', 'action' => 'index', $intPortalId), true);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-1"></div>

        <div class="col-md-10">

            <div class="page-header-main">
                <h1>Find a Job of Your Dream</h1>
                <p>Our &#35;1 goal is to help you identify opportunities that eventually lead you to choose a career.</p>
            </div>
            <?php // echo $this->Session->flash(); ?>
            <div class="col-md-8 index-content-container-v2">
                <h2>Get Started With Your Job Portal</h2>
                <ul class="v4-list">
                    <li>Access to more than 1,000 job boards</li>
                    <li>Weekly free job seeker webinars with Q&amp;A</li>
                    <li>Access to valuable free job search resources</li>
                    <li>Comprehensive resume review</li>
                    <li>Leading experts and resources to advance your search</li>
                    <li>Library filled with audios, articles and webinars</li>
                </ul>
                <div class="freelancer-info-container-v2">
                    <p class="freelancer-info-comment">"Thank you for creating this great search community. Keep up the excellent work, people are greteful and they do sit up and take notice!"</p>
                    <p class="freelancer-info-name">John Snow</p>
                    <p class="freelancer-info-role">Independent Interpreneur</p>
                </div>
            </div>
            <div class="col-md-4">

                <div class="index-form-container-v2">
                    <?php
                    echo $this->Form->create('PortalUser', array('inputDefaults' => array('label' => false, 'div' => false), 'type' => 'file', 'class' => 'form-signin'));
                    ?>
                    <button class="btn btn-primary btn-facebook" type="submit">Register using Facebook</button>

                    <div class="h-separator-v2">
                        <hr>
                        <span>or</span>
                    </div>
                    <?php
//                     print("<pre>");
//                      print_r($arrRegistrationFieldDetail);
//                      exit; 
                    if (is_array($arrRegistrationFieldDetail) && (count($arrRegistrationFieldDetail) > 0)) {
                        /* print("<pre>");
                          print_r($arrRegistrationFieldDetail); */

                        foreach ($arrRegistrationFieldDetail as $arrFieldInfo) {

                            $strMandatLabel = "";
                            $strValidationString = "";
                            $strFieldLabel = "";
                            $strFieldLabelComment = "";

                            if (is_array($arrFieldInfo['fields_validation']) && (count($arrFieldInfo['fields_validation']) > 0)) {
                                $strValidationString = "validate[";
                                foreach ($arrFieldInfo['fields_validation'] as $arrValidationDetail) {
                                    switch ($arrValidationDetail['validation_rule_table']['validation_rule']) {
                                        case"notempty": $strMandatLabel = "<span id='madatsym' class='madatsym'>*</span>";
                                            $strValidationString .= "required";
                                            break;
                                        case"email": $strValidationString .= ",custom[email]";
                                            break;
                                    }
                                }
                                $strValidationString .= "]";
                            }
                            //echo "--".$arrFieldInfo['career_portal_registration_form_fields']['career_portal_registration_form_field_label'];
                            if (isset($arrFieldInfo['career_portal_registration_form_fields']['career_portal_registration_form_field_label'])) {
                                $strFieldLabel = $arrFieldInfo['career_portal_registration_form_fields']['career_portal_registration_form_field_label'];
                            } else {
                                $strFieldLabel = $arrFieldInfo['fields_table']['field_label'];
                            }

                            if (isset($arrFieldInfo['career_portal_registration_form_fields']['career_portal_registration_form_field_comment'])) {
                                $strFieldLabelComment = $arrFieldInfo['career_portal_registration_form_fields']['career_portal_registration_form_field_comment'];
                            } else {
                                $strFieldLabelComment = $arrFieldInfo['fields_table']['field_comment'];
                            }


                            switch ($arrFieldInfo['fields_table']['field_type']) {
                                case "text" :
                                    echo "<label id='portalregister_field_" . $arrFieldInfo['fields_table']['field_id'] . "_label' for='" . $arrFieldInfo['fields_table']['field_name'] . "'>" . $strFieldLabel . $strMandatLabel . "</label><small>" . $strFieldLabelComment . "</small>";
                                    echo "<input value='" . $arrFieldInfo['fields_table']['field_value'] . "' type='text' class='" . $strValidationString . "' name='data[PortalUser][" . $arrFieldInfo['fields_table']['field_name'] . "]' id='" . $arrFieldInfo['fields_table']['field_name'] . "' />";
                                    echo "</li>";
                                    break;

                                case "password" :
                                    echo "<label id='portalregister_field_" . $arrFieldInfo['fields_table']['field_id'] . "_label' for='" . $arrFieldInfo['fields_table']['field_name'] . "'>" . $strFieldLabel . $strMandatLabel . "</label><small>" . $strFieldLabelComment . "</small>";
                                    echo "<input type='password' class='" . $strValidationString . "' name='data[PortalUser][" . $arrFieldInfo['fields_table']['field_name'] . "]' id='" . $arrFieldInfo['fields_table']['field_name'] . "' />";

                                    break;
                            }
                        }

                        echo $this->Form->hidden('portal_id', array('value' => $intPortalId));
                        ?>

                        <p>Already have an account? 
                            <a href="<?php echo $strLoginUrl; ?>" class="link-primary">Login</a>
                        </p>
                        <?php
                        echo "<input type='hidden' id='regmethod' name='regmethod' value='" . $strRegistrationMethod . "' />";


                        $options = array(
                            'label' => 'Register a Free Account Now',
                            'name' => 'register',
                            'div' => False,
                            'class' => 'btn btn-primary btn-large-v2'
                        );
                        echo $this->Form->end($options);
                    }
                    ?>
                    <!--<form class="form-signin">
                            <button class="btn btn-primary btn-facebook" type="submit">Register using Facebook</button>
                    
                            <div class="h-separator-v2">
                                    <hr>
                                    <span>or</span>
                            </div>

                            <label for="name">Your full name</label>
                            <input type="text" name="name" class="form-control" placeholder="Your full name" required autofocus>
                            
                            <label for="email" class="open-txt">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="john@hrsearchincsite.com" required>
                            
                            <button class="btn btn-primary btn-large-v2" type="submit">Register a Free Account Now</button>
                            
                            <p>Already have an account? 
                                    <a href="#" class="link-primary">Login</a>
                            </p>-->

                </div>
            </div>

        </div>

        <div class="col-md-1"></div>

    </div>
</div>
