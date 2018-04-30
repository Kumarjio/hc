<?php
$strRegister = Router::url(array('controller' => 'portal', 'action' => 'register', $arrPortalDetail[0]["Portal"]["career_portal_name"]), true);
$intPortalId = $arrPortalDetail[0]["Portal"]["career_portal_id"];
$strLoginUrl = Router::url(array('controller' => 'portal', 'action' => 'login', $intPortalId), true);
$strLogoutUrl = Router::url(array('controller' => 'portal', 'action' => 'logout', $intPortalId), true);
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Find a Job of Your Dream</title>

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
        echo $this->Html->script('jquery/jquery-1.9.1');
        echo $this->Html->script('jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en');
        echo $this->Html->script('jquery/validationplugin/validationengine/js/jquery.validationEngine');
        echo $this->Html->script('common');
        echo $this->Html->css('jqueryvalidationplugin/validationEngine.jquery');
        
        $_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
        $last_segment = base64_decode($segments[count($segments) - 1]);
        $ar = explode("_", $last_segment);
        $second_segment = $segments[count($segments) - 2];
        $third_segment = $segments[count($segments) - 3];
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
                color: #108bd9 !important;
                display: block !important;
                font-weight: bold !important;
                margin-top: 10px !important;
                padding: 7px !important;
                text-align: center !important;
                text-transform: uppercase !important;
                width: 139px !important;
            }
            
            .green-theme .navbar-default .navbar-nav > .active-tab > a {
                color: #fff !important;
            }
            
            .green-theme .navbar-custom .navbar-nav li a:hover {
                color: #fff !important;
            }
            
            .active-tab{
                background: #69b1aa none repeat scroll 0 0;
                color: #fff !important;
            }
            #dummyTxt {
                 margin-top: -100px !important;
            }
            section h2 {
                margin-left: 40px !important;
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

    <body id="page-top" class="index green-theme">
        <?php
        echo $this->element("theme_logo_manage");
        ?>
        <?php
        echo $this->element("theme_page_manage");
        ?>
        <?php
        echo $this->element("theme_widgets_manage_page");
        ?>
        <?php
        echo $this->element("theme_copyright_manage");
        ?>
        <!-- Navigation -->
        <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll" id="logonamemenu">
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
                        if (is_array($arrPortalMenuDetail) && (count($arrPortalMenuDetail) > 0)) {
                            //echo '<pre>';print_r($arrPortalMenuDetail);  
                            $strHomeEditorLink = Router::url(array('controller' => 'employers', 'action' => 'theme_selection', '?' => array('theme_name' => 'THEME-DESIGN-2', 'theme_color' => 'GREEN', 'portal_id' => $arrPortalDetail['0']['Portal']['career_portal_id'])));
                            ?>
                            <?php
                            foreach ($arrPortalMenuDetail as $arrMenu) {
                                //echo '<br>'.$strMenuUrl = Router::url(array('controller' => 'employers','action' => 'viewpage',base64_encode($arrMenu['TopMenu']['career_portal_menu_page_id']."_".$arrMenu['TopMenu']['career_portal_id'])),true);
                                //echo '<br>--URL--'.base64_encode($strMenuUrl);
                                $strPagePortalId = base64_encode($arrMenu['TopMenu']['career_portal_menu_page_id'] . "_" . $arrMenu['TopMenu']['career_portal_id']);
                                if ($arrMenu['TopMenu']['career_portal_menu_name'] == "Home") {
                                    $strMenuLink = $strHomeEditorLink;
                                } else {
                                    $strMenuLink = Router::url(array('controller' => 'employers', 'action' => 'viewthemepage', $strPagePortalId), true);
                                }
                                ?>
                                <li class="page-scroll <?php if ($ar[0] == $arrMenu['TopMenu']['career_portal_menu_page_id']) { ?> active-tab <?php } ?>"><a href="<?php echo $strMenuLink; ?>" ><?php echo $arrMenu['TopMenu']['career_portal_menu_name'] ?></a></li>	
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
                                <span class="name"><span>Find your next</span> career now</span>

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
                                        <a href="#"><img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-1/img/fb-login.png" alt="Facebook login"></a> 
                                        <a class="btn btn-success btn-lg" style="width:50%;margin-top:10px;height:47px;font-size:18px;" href="<?php echo $strRegister; ?>">Register Now</a>
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
                        Learn insider secrets, successfully used by professional recruiters.</h1>
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

                    <div class="col-sm-6 info" id="dummyTxt">
                        
                        <h1>welcome to our company </h1>
                        
                        <div id="widgets" onmouseover="fnApplyEditorHoverCss(this);fnShowWidgetSetter();" onmouseout="fnRemoveEditorHoverCss(this);fnHideWidgetSetter();">
                            &nbsp;
                            <!--<span style="font-size: 10px;position: relative;top:0px;display:none;cursor:pointer;vertical-align:top;" id="widgets_links" onclick="fnShowWidgetsSection()">Manage Widgets</span>-->
                            <?php
                            /* print("<pre>");
                              print_r($arrPortalWidgets); */
                            if (isset($arrPortalWidgets) && (is_array($arrPortalWidgets)) && (count($arrPortalWidgets) > 0)) {
                                foreach ($arrPortalWidgets as $arrWidgetDetail) {
                                    if ($arrWidgetDetail['PW']['career_portal_id'] == $arrPortalDetail[0]['Portal']['career_portal_id'] && $arrWidgetDetail['PW']['career_portal_page_id'] == $arrPortalPageDetail[0]['PortalPages']['career_portal_page_id']) {
                                        /* if($arrWidgetDetail['W']['widget_name'] == "Job Search")
                                          {
                                          echo $this->element("job_search",array('widget_id'=>$arrWidgetDetail['W']['widget_id'],'theme_id'=>$arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'],'portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id']));
                                          }

                                          if($arrWidgetDetail['W']['widget_name'] == "Latest Jobs")
                                          {
                                          echo $this->element("latest_jobs",array('widget_id'=>$arrWidgetDetail['W']['widget_id'],'theme_id'=>$arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'],'portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id']));
                                          }

                                          if($arrWidgetDetail['W']['widget_name'] == "Highlighted Jobs")
                                          {
                                          echo $this->element("highlighted_jobs",array('widget_id'=>$arrWidgetDetail['W']['widget_id'],'theme_id'=>$arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'],'portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id']));
                                          } */

                                        if ($arrWidgetDetail['W']['widget_name'] == "Contact Us") {
                                            echo $this->element("portal_contact_us", array('widget_id' => $arrWidgetDetail['W']['widget_id'], 'theme_id' => $arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'], 'portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id']));
                                        }
                                    } else {
                                        /* if($arrWidgetDetail['W']['widget_name'] == "Job Search")
                                          {
                                          echo $this->element("job_search",array('strHidden'=>'1','widget_id'=>$arrWidgetDetail['W']['widget_id'],'theme_id'=>$arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'],'portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id']));
                                          }

                                          if($arrWidgetDetail['W']['widget_name'] == "Latest Jobs")
                                          {
                                          echo $this->element("latest_jobs",array('strHidden'=>'1','widget_id'=>$arrWidgetDetail['W']['widget_id'],'theme_id'=>$arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'],'portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id']));
                                          }

                                          if($arrWidgetDetail['W']['widget_name'] == "Highlighted Jobs")
                                          {
                                          echo $this->element("highlighted_jobs",array('strHidden'=>'1','widget_id'=>$arrWidgetDetail['W']['widget_id'],'theme_id'=>$arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'],'portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id']));
                                          } */

                                        if ($arrWidgetDetail['W']['widget_name'] == "Contact Us") {
                                            echo $this->element("portal_contact_us", array('strHidden' => '1', 'widget_id' => $arrWidgetDetail['W']['widget_id'], 'theme_id' => $arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'], 'portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id']));
                                        }
                                    }
                                }
                            }
                            ?>
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
                    <h1>welcome to our company </h1>
                    <div class="content-info" onmouseover="fnApplyEditorHoverCss(this);fnShowEditPage();" onmouseout="fnRemoveEditorHoverCss(this);fnHideEditPage();">
                        <!--<span style="font-size: 10px; float: right; position: relative;top:0px;display:none;cursor:pointer;" id="pageedit" onclick="fnShowPageEditSection()">Manage</span>-->
                        <?php if (isset($arrPortalPageDetail['0']['PortalPages']['career_portal_page_content'])) { ?>
                            <div id="page_content_div">
                                <?php
                                $strPageContent = htmlspecialchars_decode($arrPortalPageDetail['0']['PortalPages']['career_portal_page_content']);
                                $strPageContent = str_replace("(site_name)", $arrPortalDetail[0]['Portal']['career_portal_name'], $strPageContent);
                                echo $strPageContent;
                                ?>
                            </div>
                        <?php } else { ?>
                        <div id="page_content_div">
                                At Monster we offer you the best way to find, keep and advance in a job you love.
                                Our dedicated staff of professionals is focused on helping you utilize to the fullest our personalized Career Portal. Our goal is to help place you in an opportunity whether you desire. To best serve you, our Career Portal will walk you through the entire job search process and help you to identify areas in which you can improve upon. This is done through the use of our one of a kind Career Portal. Using this tool will help us to provide you with the best possible employment opportunities. If you are considering a new career or are unsure as to what career you may like, our Assessment Tools can help you understand what type of career you are best suited for or may be of interest to you. These are just two examples of the many tools in our Career Portal that reflect the level of attention to detail that is required to fully assist you in all aspects of finding that perfect job.
                                Our job listings are customized to your area and your field and offer that touch of “personal service” we at Monster know is important. Our tools reflect the business attitude of our company. We care about placing you in a job opportunity that fits your individual needs.
                                Monster
                            </div>
                        <?php } ?>

                        <!--<a href="#" class="register-btn">Register now</a>-->
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
                        <?php if ($arrEmployerDetail["Employer"]["show_address"] == '1') { ?>
                        <div class="footer-col col-md-3">
                            <i aria-hidden="true" class="fa fa-map-marker"></i> <?php echo $arrEmployerDetail["Employer"]["employer_address"]; ?>
                        </div>
                        <?php } 
                        if ($arrEmployerDetail["Employer"]["show_contact_number"] == '1') { ?>
                        <div class="footer-col col-md-3">
                            <i aria-hidden="true" class="fa fa-phone"></i> <?php echo $arrEmployerDetail["Employer"]["employer_contact_number"]; ?>
                        </div>
                        <?php } 
                        if ($arrEmployerDetail["Employer"]["show_email"] == '1') { ?>
                        <div class="footer-col col-md-3">
                            <i aria-hidden="true" class="fa fa-envelope-o"></i> <?php echo $arrEmployerDetail["Employer"]["employer_email"]; ?>
                        </div>
                        <?php } ?>
                    </div>
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
    <script type="text/javascript">
        $(document).ready(function () {
            var activeTab = $(".active-tab").text();
            if (activeTab == 'About Us') {
                $("#video-area").html('');
                $("#header-below-info").html('');
            }
            
            if (activeTab == 'Contact Us') {
                $("#dummyTxt h1").remove();
                $("#testimonials").html('');
            }
            
        });
    </script>
</html>
