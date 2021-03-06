<?php
//$strRegister = Router::url(array('controller'=>'portal','action'=>'home',$arrPortalDetail[0]["Portal"]["career_portal_name"]),true); 
$intPortalId = $arrPortalDetail[0]["Portal"]["career_portal_id"];
$strLoginUrl = Router::url(array('controller' => 'portal', 'action' => 'login', $intPortalId), true);
$strLogoutUrl = Router::url(array('controller' => 'portal', 'action' => 'logout', $intPortalId), true);

$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
$last_segment = $segments[count($segments) - 1];
$second_segment = $segments[count($segments) - 2];
$third_segment = $segments[count($segments) - 3];
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

    <!--<title>THEME-DESIGN-2-YELLOW</title>-->
        <title>Find a Job of Your Dream</title>

        <link rel="stylesheet" href="<?php echo Router:: url('/', true); ?>css/shr.css">
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Theme CSS -->
        <link href="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/css/freelancer.min.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php
        echo $this->Html->script('portal_user_login');
        echo $this->Html->css('jqueryui/themes/base/jquery.ui.all');
        //echo $this->Html->css('jqueryui/themes/base/demos');
        echo $this->Html->script('jquery/jquery-1.7.2.min');
        echo $this->Html->script('jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en');
        echo $this->Html->script('jquery/validationplugin/validationengine/js/jquery.validationEngine');
        echo $this->Html->script('common');
        echo $this->Html->css('jqueryvalidationplugin/validationEngine.jquery');
        ?>


        <script type="text/javascript">
            var appBaseU = '<?php echo Router::url('/', true); ?>';
            var strBaseUrl = appBaseU;

            var strLmsLoginPath = '<?php echo $strLmsLoginUrl; ?>';
            var strLmsLogoutPath = '<?php echo $strLmsLogOutUrl; ?>';
            var strLmsSessionPath = '<?php echo $strLmsSessionUrl; ?>';

            var strJSeekerLoginUrl = '<?php echo $strJobberSeekerLoginUrl; ?>';
            var strJSeekerLogOutUrl = '<?php echo $strJobberSeekerLogOutUrl; ?>';
            var appBaseU = '<?php echo Router::url('/', true); ?>';
        </script>

        <style>
            /*<!--Share buttons on footer-->*/
            .examples,body{vertical-align:middle}
            .examples{display:inline-block;padding:20px 30px;margin-bottom:20px;background:#fff;border-radius:4px;box-shadow:0 1px 1px rgba(0,0,0,.1);text-shadow:none}
            .examples .button,.examples .button-addon{display:inline-block;vertical-align:middle;margin-top:5px;margin-bottom:5px}
            .examples .button-addon .button{margin-top:0;margin-bottom:0}
            .examples .button svg{margin-right:7px;vertical-align:-3px;width:16px;height:16px;fill:currentColor}
            @media (min-width:480px)
            {.examples{margin-bottom:60px}}
            /*<!--Share buttons on footer-->*/

            .madatsym
            {
                color:#EE3322;
            }
            tbody#menu_rows > tr {
                background: none repeat scroll 0 0 #CCCCCC;
                border: 1px solid gray;
            }
            tbody#menu_rows > tr > td {
                vertical-align: middle;
            }
            tbody#widget_rows > tr {
                background: none repeat scroll 0 0 #CCCCCC;
                border: 1px solid gray;
            }
            tbody#widget_rows > tr > td {
                vertical-align: middle;
            }

            #header-candy img {
                display:none;
            }
            .btn.register-btn {
                background: #fff !important;
                border-radius: 3px !important;
                color: #821a59 !important;
                display: block !important;
                font-weight: bold !important;
                margin-top: 10px !important;
                padding: 7px !important;
                text-align: center !important;
                text-transform: uppercase !important;
                width: 139px !important;
            }
        .yellow-theme #video-area {
            background: #821a59 none repeat scroll 0 0;
        }
        </style>
        <style>
            div#dialog-form { font-size: 62.5%; }
            div#dialog-logo-form { font-size: 62.5%; }
            div#dialog-page-form { font-size: 62.5%; }
            div#dialog-copyright-form { font-size: 62.5%; }
            div#dialog-add-page-form { font-size: 62.5%; }
            div#dialog-banner_image-form { font-size: 62.5%; }
            div#dialog-widget-form { font-size: 62.5%; }
            div#dialog-contactus-form { font-size: 62.5%; }

            input.text { margin-bottom:12px; width:95%; padding: .4em; }
            fieldset { padding:0; border:0; margin-top:25px; }
            h1 { font-size: 1.2em; margin: .6em 0; }
            div#users-contain { width: 350px; margin: 20px 0; }
            div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; margin-top:11px;margin-bottom:11px;}
        </style>
    </head>

    <body id="page-top" class="index yellow-theme">

        <!-- Navigation -->
        <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll" id="logonamemenu" >
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                    </button>

                    <?php if (isset($arrPortalDetail['0']['Portal']['career_portal_logo'])) { ?>
                        <?php echo $this->Html->image('/userdata/portal/' . $arrPortalDetail['0']['Portal']['career_portal_logo'], array('id' => 'portal_header_logo', 'alt' => $arrPortalDetail['0']['Portal']['career_portal_name'], 'height' => '80', 'width' => '165')); ?>
                    <?php } else { ?>
                        <a class="navbar-brand" href="#page-top" >Your LOGO <span>Goes Here</span></a>
                    <?php } ?>

                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="hidden">
                            <a href="#page-top"></a>
                        </li>
                        <?php
                        //echo '<pre>';print_r($arrPortalMenuDetail); exit();
                        if (is_array($arrPortalMenuDetail) && (count($arrPortalMenuDetail) > 0)) {
                            foreach ($arrPortalMenuDetail as $arrMenu) {
                                $strPagePortalId = base64_encode($arrMenu['TopMenu']['career_portal_menu_page_id'] . "_" . $arrMenu['TopMenu']['career_portal_id']);
                                if ($arrMenu['TopMenu']['career_portal_menu_name'] == "Home") {
                                    if ($third_segment == 'portalpreview') {
                                        $strMenuLink = $strPreviewHomeEditorLink;
                                    } else {
                                        $strMenuLink = $strHomeEditorLink;
                                    }
                                } else {
                                    if ($third_segment == 'portalpreview') {
                                        $strMenuLink = Router::url(array('controller' => 'portalpreview', 'action' => 'themepage', $strPagePortalId), true);
                                    } else {
                                        $strMenuLink = Router::url(array('controller' => 'portal', 'action' => 'themepage', $strPagePortalId), true);
                                    }
                                }
                                ?>
                                <li class="page-scroll"><a href="<?php echo $strMenuLink; ?>" ><?php echo $arrMenu['TopMenu']['career_portal_menu_name'] ?></a></li>	
                                <?php
                            }
                            ?>
                        <?php } else { ?> 
                            <li class="page-scroll">
                                <a href="#">Home</a>                          
                            </li>
                            <li class="page-scroll">
                                <a href="#">About Us</a>
                            </li>
                            <li class="page-scroll">
                                <a href="#">Contact Us</a>
                            </li>
                        <?php } ?> 
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>

        <!-- Header -->
        <header>
            <div class="header-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 float-right">
                            <div class="intro-text">
                                <span class="name">ACCELERATE YOUR</span>JOB SEARCH</span>

                                <!--Form Starts-->			
                                <?php echo $this->Form->create('PortalUser', array('inputDefaults' => array('label' => false, 'div' => false), 'type' => 'file', "onsubmit" => "return fnLogCandidateLogIn('" . $strLoginUrl . "','" . $strLogoutUrl . "')", "id" => "PortalUserLoginForm")); ?>
                                <div class="form-inner"> 				
                                    <?php
//echo $this->Form->button('Login through Facebook', array('type'=>'button','name'=>'social_media_button','class'=>'btn btn-primary btn-facebook','value'=>'facebook','onclick'=>'fnSocialRegister(this)')); 
//$strFURL = $this->Html->url(array("controller"=>"social","action" => "social","login","facebook",$intPortalId));
//echo $this->Form->hidden('',array('id'=>'facebook_process_url', 'value'=>$strFURL));
                                    ?>

                                    <div id="loginerror"></div>

                                    <?php
                                    echo $this->Form->input('email', array('type' => 'text', "class" => "validate[required] form-control", "placeholder" => "EMAIL ADDRESS"));
                                    echo $this->Form->input('password', array('type' => 'password', "class" => "validate[required] form-control", "placeholder" => "PASSWORD"));
                                    ?>

                                    <?php echo $this->Form->hidden('portal_id', array('value' => $intPortalId)); ?>


                                    <button type="submit" class="btn btn-success btn-lg" onclick="return validateLogin();">Login </button>
                                    <div class="social-login"> 
                                        <?php
                                        $strFURL = $this->Html->url(array("controller" => "social", "action" => "social", "login", "facebook", $intPortalId));
                                        echo $this->Form->hidden('', array('id' => 'facebook_process_url', 'value' => $strFURL));
                                        ?>
                                        <a href="#" title="facebook" onClick="connectMe(this)" ><img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/fb-login.png" alt="Facebook login"></a>
                                        <?php
                                    if ($third_segment == 'portalpreview') { ?>
                                        <a class="btn btn-success btn-lg" style="width:50%;margin-top:10px;" href="<?php echo $strRegister; ?>">Register Now</a>
                                    <?php } else { ?>
                                        <a class="btn btn-success btn-lg" style="width:50%;margin-top:10px;" href="<?php echo $strRegister; ?>">Register Now</a>
                                   <?php }
                                    ?>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="form-bottom"></div>	
                                <!--Form End-->

                            </div>   
                        </div>

                    </div>
                </div></div>
        </header>


        <!-- features section -->
        <section id="features" class="text-center">
            <div class="container">

                <div class="row">

                    <h1>This resource will help you find a job and advance your career.
                        Learn insider secrets, successfully used by professional recruiters. </h1>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/icons/icon1.png" alt="icons" style="width: 168px; height: 126px;"/>
                        <h3>15-Step Job Search Process</h3>
                        Proven step-by-step process to finding a job 
                    </div>


                    <div class="col-sm-3">
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/icons/icon2.png" alt="icons" style="width: 168px; height: 126px;"/>
                        <h3>Weekly LIVE Webinars</h3>
                        Live training webinars – bring your questions; receive answers 
                    </div>


                    <div class="col-sm-3">
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/icons/icon3.png" alt="icons" style="width: 168px; height: 126px;"/>
                        <h3>Job Search Tracker </h3>
                        Free resource to track your contacts and job search activities
                    </div>


                    <div class="col-sm-3">
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/icons/icon4.png" alt="icons" style="width: 168px; height: 126px;"/>
                        <h3>Interview Advisor</h3>
                        Customized advice based on your Resume or CV through the eyes of an employer
                    </div>

                </div>
            </div>
        </section>


        <!-- Video section -->
        <section id="video-area">
            <div class="container">
                <div class="row">

                    <div class="col-sm-6 info">
                        <h1>welcome to our company </h1>
                        <div class="content-info" >

                            <?php if (isset($arrPortalPageDetail['0']['PortalPages']['career_portal_page_content'])) { ?>
                                <div id="page_content_div">
                                    <?php
                                    $strPageContent = htmlspecialchars_decode($arrPortalPageDetail['0']['PortalPages']['career_portal_page_content']);
                                    $strPageContent = str_replace("(site_name)", $arrPortalDetail[0]['Portal']['career_portal_name'], $strPageContent);
                                    echo $strPageContent;
                                    ?>
                                </div>
                            <?php } else { ?>
                                <div id="page_content_div">Our #1 goal at <?php echo stripslashes($arrPortalDetail[0]['Portal']['career_portal_name']); ?> is to help you find a great job.  We will share secrets used by the best recruiters and have provided you with innovative tools to assist your search.  Our CV | Resume Builder will create customized feedback from our Interview Advisor, which reviews your credentials through the eyes of a potential employer.  Make sure you update your Profile to provide additional information that will help us target job listings and align with your preferences. To obtain the best results, complete the 15-step job search process.  Sign up for our LIVE weekly training webinars where we cover hot topics, but most importantly answer questions most important to you!</div>
                            <?php } ?>

                            <!--<a href="#" class="register-btn">Register now</a>-->
                        </div>
                    </div>  

                    <div class="col-sm-6">
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/video-image.png" alt="video" />
                    </div>

                </div>
            </div>
        </section>

        <!-- Testimonials section -->
        <section id="testimonials" class="text-center">
            <div class="container">

                <div class="row">
                    <h1>JOB SEEKER SUCCESS STORIES</h1>
                    Learn how our Career Portal has helped others find the 
                    perfect job and advance in their career.
                </div>

                <div class="row">

                    <div class="col-md-4">
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/clients/cleint1.png" alt="client" />
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/stars-blue.png" alt="stars" />
                        The newsletter always provides good stuff and on is timely.  Thanks
                        <h4>Dan</h4>
                    </div>

                    <div class="col-md-4">
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/clients/cleint2.png" alt="client" />
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/stars-blue.png" alt="stars" />
                        Many thanks to you for providing such a wonderful product. This was my first webinar with you, and I look forward in joining others.Thank you for providing this useful and thought provoking service.
                        <h4>Wrenn</h4>
                    </div>

                    <div class="col-md-4">
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/clients/cleint3.png" alt="client" />
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/stars-blue.png" alt="stars" />
                        Thank you!  I started seriously pursuing my job hunt about 2 months ago. I had my Resume rewritten. I used your 15-step process. The interview information was spot on.  I listened to your advice and used your resources.  I had 8 interviews with different companies. This Friday I was hired. This was the one employer I really wanted to work for.  I thank you and my family thanks you!  I will recommend your career portal services to friends and family
                        <h4>Debra</h4>
                    </div>

                </div>
            </div></section>

        <!-- Footer -->
        <footer>
            <div class="footer-above">
                <div class="container">
                    <div class="row">
                        <div class="footer-col col-md-3">
                            <div style="clear:both;" class="copyright"  >
                                <?php if (isset($arrPortalDetail['0']['Portal']['career_portal_footer_text'])) { ?>
                                    <span id="footertext"><?php echo html_entity_decode($arrPortalDetail['0']['Portal']['career_portal_footer_text']); ?></span>
                                <?php } else { ?>
                                    <span id="footertext"> &copy; 2016 . All rights reserved.</span>
                                <?php } ?>

                            </div>
                        </div>

                        <div class="footer-col col-md-3">
                            <i aria-hidden="true" class="fa fa-map-marker"></i> <?php if ($arrEmployerDetail["Employer"]["show_address"] == '1') echo $arrEmployerDetail["Employer"]["employer_address"]; ?>
                        </div>

                        <div class="footer-col col-md-3">
                            <i aria-hidden="true" class="fa fa-phone"></i> <?php if ($arrEmployerDetail["Employer"]["show_contact_number"] == '1') echo $arrEmployerDetail["Employer"]["employer_contact_number"]; ?>
                        </div>

                        <div class="footer-col col-md-3">
                            <i aria-hidden="true" class="fa fa-envelope-o"></i> <?php if ($arrEmployerDetail["Employer"]["show_email"] == '1') echo $arrEmployerDetail["Employer"]["employer_email"]; ?>
                        </div>

                    </div>
                    <div class="row"><?php echo $this->element('socialshare'); ?></div>
                </div>
            </div>

        </footer>

        <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
        <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
            <a class="btn btn-primary" href="#page-top">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>

        <!-- Portfolio Modals -->
        <!-- jQuery -->
       <!--<script src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/vendor/jquery/jquery.min.js"></script>-->

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Plugin JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

        <!-- Contact Form JavaScript -->
        <script src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/js/jqBootstrapValidation.js"></script>
        <script src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/js/contact_me.js"></script>

        <!-- Theme JavaScript -->
        <script src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/js/freelancer.min.js"></script>

        <?php
        echo $this->Html->script('jquery/jquery.form');
        ?>
        <?php
        echo $this->Html->script('hometheme/jquery/jquery.easing.1.3');
        ?>
        <!-- the jScrollPane script -->
        <?php
        echo $this->Html->script('hometheme/jquery/jquery.mousewheel');
        ?>
        <?php
        echo $this->Html->script('hometheme/jquery/jquery.contentcarousel');
        ?>

        <?php
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.core');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.widget');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.mouse');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.button');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.draggable');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.position');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.resizable');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.button');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.dialog');
        //echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.effect');	
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.sortable');
        ?>

        <?php
        echo $this->Html->script('tinymce/tiny_mce');
        ?>
    </body>

</html>

<script>
                                            //Facebook connect for user registration start 
                                            window.fbAsyncInit = function () {
                                                FB.init({
                                                    appId: "2039225979637950",
                                                    channelUrl: "<?php echo Router:: url('/', true); ?>channel.html", // Channel File
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

                                            $(document).ready(function () {
                                                var email_address = '<?php echo $arrExistSocialSession['candidate_email']; ?>';
                                                var password = '<?php echo $arrExistSocialSession['candidate_password_decrypted']; ?>';
                                                if (email_address != '' && password != '') {
                                                    $("#register_btn").trigger("click");
                                                }
                                            });
</script>
<!-- start Mixpanel --><script type="text/javascript">(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===e.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.2.min.js';f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f)}})(document,window.mixpanel||[]);
mixpanel.init("d495e4f0d31056a7b3b94ab7a59e2894");</script><!-- end Mixpanel -->

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