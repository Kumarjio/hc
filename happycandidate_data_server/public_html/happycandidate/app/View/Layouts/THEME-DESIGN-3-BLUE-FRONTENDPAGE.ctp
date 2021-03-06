<?php
//$strRegister = Router::url(array('controller'=>'portal','action'=>'home',$arrPortalDetail[0]["Portal"]["career_portal_name"]),true); 
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

        <link rel="stylesheet" href="http://www.rothrsolutions.com/css/shr.css">
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-3/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Theme CSS -->
        <link href="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-3/css/freelancer.min.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-3/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
        //echo $this->Html->css('jqueryui/themes/base/jquery.ui.all');
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
            .imgcentre {
                display:block;
                margin-left:auto;
                margin-right:auto;
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

    <body id="page-top" class="index blue-theme">

        <!-- Navigation -->
        <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom text-center">
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
                        if (is_array($arrPortalMenuDetail) && (count($arrPortalMenuDetail) > 0)) {
                            //echo '<pre>';print_r($arrPortalMenuDetail);  
                            //$strHomeEditorLink =  Router::url('/', true)."portal/themehome/".$arrPortalDetail[0]['Portal']['career_portal_name'];

                            foreach ($arrPortalMenuDetail as $arrMenu) {
                                //echo '<br>'.$strMenuUrl = Router::url(array('controller' => 'employers','action' => 'viewpage',base64_encode($arrMenu['TopMenu']['career_portal_menu_page_id']."_".$arrMenu['TopMenu']['career_portal_id'])),true);
                                //echo '<br>--URL--'.base64_encode($strMenuUrl);
                                $strPagePortalId = base64_encode($arrMenu['TopMenu']['career_portal_menu_page_id'] . "_" . $arrMenu['TopMenu']['career_portal_id']);
                                if ($arrMenu['TopMenu']['career_portal_menu_name'] == "Home") {
                                    $strMenuLink = $strHomeEditorLink;
                                } else {
                                    $strMenuLink = Router::url(array('controller' => 'portal', 'action' => 'themepage', $strPagePortalId), true);
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

            <div class="container">
                <div class="row">
                    <div class="col-lg-10 text-center">
                        <div class="intro-text">
                            <span class="name">Find your next career now</span>
                            <span class="skills">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut imperdiet nibh. Mauris lorem enim, consectetur sit amet tincidunt et, porta quis tellus. Cras cursus dui eu ante scelerisque tempor.</span>
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
            </div> 
        </header>


        <!-- Devices section -->
        <section id="devices">
            <div class="container">

                <div class="row">
                    <div class="col-sm-6"> <h1>welcome to our company </h1>
                        <div id="widgets" >
                            &nbsp;

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

                    <div class="col-sm-6"> <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-3/img/devices.png" alt="devices" />
                    </div>
                </div>


            </div>
        </section>


        <!-- Video section -->
        <section id="video-area">
            <div class="container">
                <div class="row">

                    <div class="col-sm-6">
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-3/img/video-image.png" alt="video" />
                    </div>

                    <div class="col-sm-6">
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
                                <div id="page_content_div">Consectetur adipiscing elit. Donec luctus at augue id tincidunt. Proin nulla risus, pharetra id aliquet quis, cursus interdum orci cras ullamcorper tellus a massa ornare, non ornare arcu cursus.Maecenas nulla orci iaculis eu tortor feugiat tempor semper tortor. Integer efficitur nisl turpis, sit amet tristique dolor laoreet nec. Duis felis lectus, lacinia lectus pretium.Finibus nunc quis turpis quis leo volutpat id sit amet orci. Etiam nec diam tincidunt, consequat diam suscipit metus.</div>
                            <?php } ?>

                            <!--<a href="#" class="register-btn">Register now</a>-->
                        </div>
                    </div>  

                </div>
            </div>
        </section>

        <!-- Testimonials section -->
        <section id="testimonials" class="text-center">
            <div class="container">

                <div class="row">
                    <h1>Our Customers Review</h1>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel aliquet ante. Sed enim mauris, porttitor ut leo nec, scelerisque vestibulum dui. Quisque eu sem at augue tincidunt ultricies. Nam euismod egestas ipsum a convallis. Nullam lobortis porttitor elit, quis placerat neque auctor eu.
                </div>

                <div class="row">

                    <div class="col-md-4">
                        <h4>Brenda T. Anderson</h4>
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-3/img/stars-yellow.png" alt="stars" />
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel aliquet ante. Sed enim mauris, porttitor ut leo nec

                    </div>

                    <div class="col-md-4">
                        <h4>David Lara</h4>
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-3/img/stars-yellow.png" alt="stars" />
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel aliquet ante. Sed enim mauris, porttitor ut leo nec

                    </div>

                    <div class="col-md-4">
                        <h4>Richard Parr</h4>
                        <img src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-3/img/stars-yellow.png" alt="stars" />
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel aliquet ante. Sed enim mauris, porttitor ut leo nec

                    </div>

                </div>
            </div></section>

        <!-- Footer -->
        <footer>
            <div class="footer-above">
                <div class="container">

                    <div class="row">                
                        <div class="footer-col col-md-12">
                            <ul class="list-inline text-center ftr-brdr">
                                <li> <a href="<?php echo $strRegister; ?>">Register</a></li> 
                                <li>   <a href="#">Blog</a>  </li>
                                <li>  <a href="#">Contact Us</a>  </li>
                                <li> <a href="<?php echo $strHomeEditorLink; ?>">Login</a>  </li >
                                <li>  <div style="clear:both;color:black;" class="copyright" >
                                        <?php if (isset($arrPortalDetail['0']['Portal']['career_portal_footer_text'])) { ?>
                                            <span id="footertext"><?php echo html_entity_decode($arrPortalDetail['0']['Portal']['career_portal_footer_text']); ?></span>
                                        <?php } else { ?>
                                            <span id="footertext"> &copy; 2016 . All rights reserved.</span>
                                        <?php } ?>

                                    </div> </li>
                            </ul>
                        </div>                     
                    </div>

                    <div class="row"><?php echo $this->element('socialshare'); ?></div>
                    <div class="footer-col col-md-12">
                        <?php if (isset($arrPortalDetail['0']['Portal']['career_portal_logo'])) { ?>
                            <?php echo $this->Html->image('/userdata/portal/' . $arrPortalDetail['0']['Portal']['career_portal_logo'], array('id' => 'portal_header_logo', 'alt' => $arrPortalDetail['0']['Portal']['career_portal_name'], 'height' => '80', 'width' => '165', 'class' => 'imgcentre')); ?>
                        <?php } else { ?>
                            <a class="navbar-brand" href="#page-top" >Your LOGO <span>Goes Here</span></a><br>
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

        <!-- start Mixpanel -->
        <script type="text/javascript">
            (function(e, b){if (!b.__SV){var a, f, i, g; window.mixpanel = b; b._i = []; b.init = function(a, e, d){function f(b, h){var a = h.split("."); 2 == a.length && (b = b[a[0]], h = a[1]); b[h] = function(){b.push([h].concat(Array.prototype.slice.call(arguments, 0)))}}var c = b; "undefined" !== typeof d?c = b[d] = []:d = "mixpanel"; c.people = c.people || []; c.toString = function(b){var a = "mixpanel"; "mixpanel" !== d && (a += "." + d); b || (a += " (stub)"); return a}; c.people.toString = function(){return c.toString(1) + ".people (stub)"}; i = "disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
            for (g = 0; g < i.length; g++)f(c, i[g]); b._i.push([a, e, d])}; b.__SV = 1.2; a = e.createElement("script"); a.type = "text/javascript"; a.async = !0; a.src = ("https:" === e.location.protocol?"https:":"http:") + '//cdn.mxpnl.com/libs/mixpanel-2.2.min.js'; f = e.getElementsByTagName("script")[0]; f.parentNode.insertBefore(a, f)}})(document, window.mixpanel || []);
            mixpanel.init("d495e4f0d31056a7b3b94ab7a59e2894");
        </script>
        <!-- end Mixpanel -->
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
            
        <!-- Portfolio Modals -->

        <!-- jQuery -->
       <!--<script src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-3/vendor/jquery/jquery.min.js"></script>-->

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-3/vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Plugin JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

        <!-- Contact Form JavaScript -->
        <script src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-3/js/jqBootstrapValidation.js"></script>
        <script src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-3/js/contact_me.js"></script>

        <!-- Theme JavaScript -->
        <script src="<?php echo Router:: url('/', true); ?>themes/THEME-DESIGN-3/js/freelancer.min.js"></script>

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
