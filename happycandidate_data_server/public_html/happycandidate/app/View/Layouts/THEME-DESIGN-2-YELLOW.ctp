<?php
$intPortalId = $arrPortalDetail[0]["Portal"]["career_portal_id"];
$strRegister = Router::url(array('controller' => 'portal', 'action' => 'register', $arrPortalDetail[0]["Portal"]["career_portal_name"]), true);
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
        echo $this->Html->css('jqueryui/themes/base/jquery.ui.all');
        //echo $this->Html->css('jqueryui/themes/base/demos');
        echo $this->Html->script('jquery/jquery-1.7.2.min');
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
                background: #821a59 !important;
            }
            
            .yellow-theme .navbar-default .navbar-nav > .active-tab > a {
                color: #821a59 !important;
            }
            
            .yellow-theme .navbar-custom .navbar-nav li a:hover {
                color: #821a59 !important;
            }
            
            .active-tab{
                background: #fff none repeat scroll 0 0;
                color: #821a59 !important;
            }
            
            .btn-success.active, .btn-success:active, .btn-success:focus, .btn-success:hover, .open .dropdown-toggle.btn-success {
                background-color: #821a59;
                border-color: #821a59;
                color: #fff;
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
            /*h1 { font-size: 1.2em; margin: .6em 0; }*/
            div#users-contain { width: 350px; margin: 20px 0; }
            div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; margin-top:11px;margin-bottom:11px;}
        </style>
    </head>

    <body id="page-top" class="index yellow-theme">
        <?php
        echo $this->element("theme_logo_manage");
        ?>
        <?php
        echo $this->element("theme_page_manage");
        ?>
        <?php
        echo $this->element("theme_copyright_manage");
        ?>
        <!-- Navigation -->
        <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll" id="logonamemenu" onmouseover="fnApplyEditorHoverCss(this);fnShowEditLogo();fnShowEditMenu()" onmouseout="fnRemoveEditorHoverCss(this);fnHideEditLogo();fnHideEditMenu()">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                    </button>

                    <?php if (isset($arrPortalDetail['0']['Portal']['career_portal_logo'])) { ?>
                        <?php echo $this->Html->image('/userdata/portal/' . $arrPortalDetail['0']['Portal']['career_portal_logo'], array('id' => 'portal_header_logo', 'alt' => $arrPortalDetail['0']['Portal']['career_portal_name'], 'height' => '80', 'width' => '165')); ?>
                    <?php } else { ?>
                        <a class="navbar-brand" href="#page-top" >Your LOGO <span>Goes Here</span></a>
                    <?php } ?>
                    <span style="font-size: 15px;position:relative;top:0px;display:none;cursor:pointer;vertical-align:top;color:#fff" id="logoedit" onclick="fnShowLogoEditSection()">Manage <i class="fa fa-edit"></i></span>
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
                            $strHomeEditorLink = Router::url(array('controller' => 'employers', 'action' => 'theme_selection', '?' => array('theme_name' => 'THEME-DESIGN-2', 'theme_color' => 'YELLOW', 'portal_id' => $arrPortalDetail['0']['Portal']['career_portal_id'])));
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
                                <li class="page-scroll <?php if ($arrMenu['TopMenu']['career_portal_menu_name'] == "Home") { ?> active-tab <?php } ?>"><a href="<?php echo $strMenuLink; ?>" ><?php echo $arrMenu['TopMenu']['career_portal_menu_name'] ?></a></li>	
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
                                <span class="name"><span>ACCELERATE YOUR</span>JOB SEARCH</span>

                                <form>
                                    <div class="form-inner"> 
                                        <input type="text" class="form-control" placeholder="EMAIL ADDRESS" id="email" >
                                        <input type="password" class="form-control" placeholder="PASSWORD" id="password" >
                                        <button type="submit" class="btn btn-success btn-lg">Login</button>
                                        <?php echo $this->Form->hidden('portal_id', array('value' => $intPortalId)); ?>
                                        <div class="social-login"> 
                                            <?php
                                            $strFURL = $this->Html->url(array("controller" => "social", "action" => "social", "login", "facebook", $intPortalId));
                                            echo $this->Form->hidden('', array('id' => 'facebook_process_url', 'value' => $strFURL));
                                            ?>
                                            <a href="#" title="facebook" onClick="fnSocialRegisterPortal(this)" ><img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/fb-login.png" alt="Facebook login"></a>
                                                                                <!--<a href="#"><img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/twiiter-login.png" alt="Twitter login" ></a>-->
                                            <a class="btn btn-success btn-lg" style="width:50%;margin-top:10px;height:47px;font-size:18px;" href="<?php echo $strRegister; ?>">Register Now</a>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </form>

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

                    <div class="col-sm-6">
                        <h1>WELCOME TO THE CAREER PORTAL OF <?php echo $arrPortalDetail[0]['Portal']['career_portal_name']; ?></h1>
                        <div class="content-info" onmouseover="fnApplyEditorHoverCss(this);fnShowEditPage();" onmouseout="fnRemoveEditorHoverCss(this);fnHideEditPage();">
                            <span style="font-size: 20px; /*float: right;*/font-weight: bold; text-decoration: underline; position: relative;top:0px;display:none;cursor:pointer;" id="pageedit" onclick="fnShowPageEditSection()">Manage <i class="fa fa-edit"></i></span>
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
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/clients/cleint1.png" alt="client" />
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/stars-blue.png" alt="stars" />
                        The newsletter always provides good stuff and on is timely.  Thanks
                        <h4>Dan</h4>
                    </div>

                    <div class="col-md-4">
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/clients/cleint1.png" alt="client" />
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/img/stars-blue.png" alt="stars" />
                        The newsletter always provides good stuff and on is timely.  Thanks
                        <h4>Dan</h4>
                    </div>

                </div>
            </div></section>

        <!-- Footer -->
        <footer>
            <div class="footer-above">
                <div class="container">
                    <div class="row">
                        <div class="footer-col col-md-3">
                            <div style="clear:both;" class="copyright"  onmouseover="fnApplyEditorHoverCss(this);fnShowEditCopyright();" onmouseout="fnRemoveEditorHoverCss(this);fnHideEditCopyright();">
                                <?php if (isset($arrPortalDetail['0']['Portal']['career_portal_footer_text'])) { ?>
                                    <span id="footertext"><?php echo html_entity_decode($arrPortalDetail['0']['Portal']['career_portal_footer_text']); ?></span>
                                <?php } else { ?>
                                    <span id="footertext"> &copy; 2016 . All rights reserved.</span>
                                <?php } ?>
                                <span style="font-size: 15px; /*float: right;*/font-weight: bold; text-decoration: underline; position: relative;top:-36px;left: 82px;display:none;cursor:pointer;" id="copyrightsedit" onclick="fnShowCopyrightEditSection()">Manage <i class="fa fa-edit"></i></span>
                            </div>
                        </div>
                        <div class="footer-col col-md-3">
                            <i aria-hidden="true" class="fa fa-map-marker"></i> Boulevard des Capucines
                        </div>

                        <div class="footer-col col-md-3">
                            <i aria-hidden="true" class="fa fa-phone"></i> +84 345 876 123
                        </div>

                        <div class="footer-col col-md-3">
                            <i aria-hidden="true" class="fa fa-envelope-o"></i> Info@yourdomain.com
                        </div>

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
        <script src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-2/vendor/jquery/jquery.min.js"></script>

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
