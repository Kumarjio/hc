<?php
$strWebinarUrl = Router::url(array('controller' => 'candidates', 'action' => 'webinars', $intPortalId), true);
$strLibraryUrl = Router::url(array('controller' => 'candidates', 'action' => 'library', $intPortalId), true);
$strLoginUrl = Router::url(array('controller' => 'portal', 'action' => 'login', $intPortalId), true);
$strJobSearchTrackerUrl = Router::url(array('controller' => 'jstracker', 'action' => 'index', $intPortalId), true);
$strTermsUrl = Router::url(array('controller' => 'portal', 'action' => 'termsandprivacy',$intPortalId), true);
$arrExistSocialSession = $this->Session->read('current_user');
?>
<script type="text/javascript">
    function validateLogin()
    {
        var strGlobalSiteBasePath = '<?php echo Router::url('/', true) ?>';
        var validate = $("#PortalUserHomeForm").validationEngine('validate');
        if (validate == false)
        {
            return false;
        }

    }
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="page-header-main">
                <h1>Find a Job of Your Dream</h1>
                <p>Our &#35;1 goal is to help you identify opportunities that eventually lead you to choose a career.</p>
            </div>
            <?php echo $this->Session->flash(); ?>
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
                    $strFURL = $this->Html->url(array("controller" => "social", "action" => "social", "register", "facebook", $intPortalId));
                    echo $this->Form->hidden('', array('id' => 'facebook_process_url', 'value' => $strFURL));
                    ?>	
                    <button class="btn btn-primary btn-facebook" title="facebook" onClick="connectMe()">Register using Facebook</button>
                    <!--<button class="btn btn-primary btn-facebook" title="facebook" onClick="fnSocialRegisterPortal(this)">Register using Facebook</button>-->

                    <?php
                    echo $this->Form->create('PortalUser', array('inputDefaults' => array('label' => false, 'div' => false), 'type' => 'file', 'class' => 'form-signin', 'id' => 'PortalUserHomeForm'));
                    ?>					
                    <div class="h-separator-v2">
                        <hr>
                        <span>or</span>
                    </div>
                    <?php
                    if (is_array($arrRegistrationFieldDetail) && (count($arrRegistrationFieldDetail) > 0)) {
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
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input validate[required]" required="" type="checkbox" id="agree" name="agree" value="option1"> <a class="agree-link" href="<?php echo $strTermsUrl; ?>" class="link-primary" target="_blank">Terms & Condition</a>
                            </label>
                        </div>

                        <p>Already have an account? 
                            <a href="<?php echo $strLoginUrl; ?>" class="link-primary">Login</a>
                        </p>
                        <?php
                        echo "<input type='hidden' id='regmethod' name='regmethod' value='" . $strRegistrationMethod . "' />";


                        $options = array(
                            'label' => 'Register a Free Account Now',
                            'name' => 'register',
                            'id' => 'register_btn',
                            'div' => False,
                            'class' => 'btn btn-primary btn-large-v2',
                            'onClick' => 'return validateLogin();'
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

<?php
if (isset($isRegistrationDone)) {
    ?>
    <script type="text/javascript">
        mixpanel.track("<?php echo $arrMixPanelUserRegData['portalname']; ?>", {
            "Portal User Registered": "Yes",
            "User Name": "<?php echo $arrMixPanelUserRegData['username']; ?>",
            "User Id": "<?php echo $arrMixPanelUserRegData['userid']; ?>",
            "User Email": "<?php echo $arrMixPanelUserRegData['useremail']; ?>",
            "Registrtaion Method": "<?php echo $arrMixPanelUserRegData['registrationmethod']; ?>",
            "User Confirmed": "No",
        });

        mixpanel.track("<?php echo $arrMixPanelUserRegData['portalname']; ?> Registered Users", {
            "Portal User Registered": "Yes",
            "User Name": "<?php echo $arrMixPanelUserRegData['username']; ?>",
            "User Id": "<?php echo $arrMixPanelUserRegData['userid']; ?>",
            "User Email": "<?php echo $arrMixPanelUserRegData['useremail']; ?>",
            "Registrtaion Method": "<?php echo $arrMixPanelUserRegData['registrationmethod']; ?>",
            "User Confirmed": "No",
        });
    </script>
    <?php
}
?>
  <?php
if (isset($isvisited)) {
    ?>
    <script type="text/javascript">
        mixpanel.track("Visits", {
            "Ip Address": "<?php echo $arrMixPanelVisitedData['ipaddress']; ?>",
            "Portal Name": "<?php echo $arrMixPanelVisitedData['portalname']; ?>",
            "Session Id": "<?php echo $arrMixPanelVisitedData['sessionid']; ?>",
            "Unique Registrtaion Method": "<?php echo $arrMixPanelVisitedData['uniqueregistrationmethod']; ?>"
        });
    </script>
    <?php
}
?>  
    
<style>
/*    .form-check-label input{
        width: 0% !important;
        height: 10px !important;
    }*/
.form-check-label input{
        width: 13% !important;
    height: 19px !important;
}
    .form-check-label {
        font-family: OpenSansRegular,Georgia,serif !important;
        font-size: 14px !important;
        font-weight: normal !important;
    }
    
    .form-signin label{
        width: 67% !important;
    }
</style>
<script>
        //Facebook connect for user registration start 
    window.fbAsyncInit = function () {
        FB.init({
            appId: "2039225979637950",
            channelUrl: "http://www.rothrsolutions.com/channel.html", // Channel File
            status: true, // check login status
            cookie: true, // enable cookies to allow the server to access the session
            picture: "http://www.fbrell.com/f8.jpg",
            xfbml: true  // parse XFBML
        });

        //FBLoginStatus();
    };
// Load the SDK Asynchronously
    (function (d) {
        var js, id = "facebook-jssdk", ref = d.getElementsByTagName("script")[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement("script");
        js.id = id;
        js.async = true;
        js.src = "http://connect.facebook.net/en_US/all.js";
        ref.parentNode.insertBefore(js, ref);
    }(document));
    function connectMe()
    {
        FB.login(function (response) {
            if (response.authResponse) {
                FB.api('/me/?fields=picture.width(160).height(160),email,id,birthday,link,name,gender', function (response) {
                    var params = "first_name=" + response.first_name + "&last_name=" + response.last_name + "&user_name=" + response.username + "&user_email=" + response.email + "&fb_id=" + response.id + "&fb_profile_picture=" + response.profile_picture + "&fb_gender=" + response.gender + "&fb_name=" + response.name + "&action=facebook_connect";
                    jQuery.ajax({
                        type: 'post',
                        url: '<?php echo $strFURL; ?>',
                        data: params,
                        success: function (msg) {
                            if (msg)
                            {
                                window.parent.location = strBaseUrl + "portal/index/monster/1";
                            }
                        },
                        error: function (e) {
                            window.location.reload();
                        }
                    });
                });
            } else {
                console.log('User cancelled login or did not fully authorize.');
            }
        }, {"scope": "email,public_profile,user_photos"});
    }

    $(document).ready(function(){
    $('#register_btn').focus();
        var email_address = '<?php echo $arrExistSocialSession['candidate_email']; ?>';
        var password = '<?php echo $arrExistSocialSession['candidate_password_decrypted']; ?>';
        if(email_address !='' && password !=''){
            $("#register_btn").trigger("click");
        }
    });
</script>