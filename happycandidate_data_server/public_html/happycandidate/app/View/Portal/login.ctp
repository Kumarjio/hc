<?php
echo $this->Html->script('portal_user_login');
$strRegister = Router::url(array('controller' => 'portal', 'action' => 'home', 'monster'), true);
$strSocialRegister = Router::url(array('controller' => 'social', 'action' => 'social', 'login',"facebook", $intPortalId), true);
$strForgotPassword = Router::url(array('controller' => 'portal', 'action' => 'forgotpassword', 'monster'), true);
$arrExistSocialSession = $this->Session->read('current_user');
?>
<div class="container-fluid portallogin">
    <div class="row">
        <div class="hidden-xs hidden-sm col-md-4"></div>
        <div class="col-xs-12 col-sm-12 col-md-4">

            <div class="admin-logo-container">
                <a class="navbar-brand" href="#">
                    <span>HR SEARCH INC.</span>
                </a>
            </div>

            <div class="admin-form-login form-signin">

                <?php
                $strLoginUrl = Router::url(array('controller' => 'portal', 'action' => 'login', $intPortalId), true);
                $strLogoutUrl = Router::url(array('controller' => 'portal', 'action' => 'logout', $intPortalId), true);
                echo $this->Form->create('PortalUser', array('inputDefaults' => array('label' => false, 'div' => false), 'type' => 'file', "onsubmit" => "return fnLogCandidateLogIn('" . $strLoginUrl . "','" . $strLogoutUrl . "')"));
                ?>
                <!--<button type="submit" class="btn btn-primary btn-facebook">Login using Facebook</button>-->
                <!--'onclick'=>'fnSocialRegister(this)'-->
                <?php
                echo $this->Form->button('Login through Facebook', array('type' => 'button', 'name' => 'social_media_button', 'class' => 'btn btn-primary btn-facebook', 'value' => 'facebook', 'onclick' => "connectMe()"));
                $strFURL = $this->Html->url(array("controller" => "social", "action" => "social", "login", "facebook", $intPortalId));
                echo $this->Form->hidden('', array('id' => 'facebook_process_url', 'value' => $strFURL));
                ?>
                <div class="h-separator-v2">
                    <hr>
                    <span>or</span>
                </div>


                <div id="loginerror"></div>

                <?php
                echo $this->Form->input('email', array('type' => 'text', "class" => "validate[required] form-control", "label" => "Email","value"=>$arrExistSocialSession['candidate_email']));
                echo $this->Form->input('password', array('type' => 'password', "class" => "validate[required] form-control", "label" => "Password","value"=>$arrExistSocialSession['candidate_password_decrypted']));
                ?>

                <?php echo $this->Form->hidden('portal_id', array('value' => $intPortalId)); ?>


                <button type="submit" class="btn btn-primary btn-large-v2" id="log_btn" onclick="return validateLogin();">Login </button>
                <a class="link-primary" href="<?php echo $strForgotPassword; ?>">Forgot Password</a>
                <p>Not account yet? 
                    <a class="link-primary" href="<?php echo $strRegister; ?>">Register</a>
                </p>

            </div>



        </div>

    </div>

</div>
</div>

<script>
    //Facebook connect for user registration start 
    window.fbAsyncInit = function () {
        FB.init({
            appId: "2039225979637950",
            channelUrl: "http://www.rothrsolutions.com/happycandidate/channel.html", // Channel File
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
                        url: '<?php echo $strSocialRegister;?>',
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
    $('#log_btn').focus();
    var email_address = '<?php echo $arrExistSocialSession['candidate_email'];?>';
    var password = '<?php echo $arrExistSocialSession['candidate_password_decrypted'];?>';
    if(email_address !='' && password !=''){
        $("#log_btn").trigger("click");
    }
    });

</script>
