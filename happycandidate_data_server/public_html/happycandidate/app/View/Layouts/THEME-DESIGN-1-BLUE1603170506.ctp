<?php $strRegister = Router::url(array('controller'=>'portal','action'=>'register',$arrPortalDetail[0]["Portal"]["career_portal_name"]),true); ?>
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
    <link href="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/css/freelancer.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
        echo $this->Html->css('jqueryui/themes/base/demos');
        echo $this->Html->script('jquery/jquery-1.7.2.min');
        echo $this->Html->script('jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en');
        echo $this->Html->script('jquery/validationplugin/validationengine/js/jquery.validationEngine');
        echo $this->Html->script('common');
        
        
        echo $this->Html->css('jqueryvalidationplugin/validationEngine.jquery');
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
                
                <?php if(isset($arrPortalDetail['0']['Portal']['career_portal_logo'])) { ?>
                <?php echo $this->Html->image('/userdata/portal/'.$arrPortalDetail['0']['Portal']['career_portal_logo'], array('id'=>'portal_header_logo','alt' => $arrPortalDetail['0']['Portal']['career_portal_name'],'height'=>'80','width'=>'165')); ?>
                <?php } else { ?>
                <a class="navbar-brand" href="#page-top" >Your LOGO <span>Goes Here</span></a>
                <?php } ?>
                <span style="font-size: 10px;position:relative;top:0px;display:none;cursor:pointer;vertical-align:top;" id="logoedit" onclick="fnShowLogoEditSection()">Manage</span>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <?php
                    if(is_array($arrPortalMenuDetail) && (count($arrPortalMenuDetail)>0))
                    {
                        //echo '<pre>';print_r($arrPortalMenuDetail);  
                        $strHomeEditorLink = Router::url(array('controller'=>'employers','action'=>'theme_selection','?' => array('theme_name'=>'THEME-DESIGN-1','theme_color'=>'BLUE','portal_id'=>$arrPortalDetail['0']['Portal']['career_portal_id'])));?>
                    <?php
                                foreach($arrPortalMenuDetail as $arrMenu)
                                {
                                    //echo '<br>'.$strMenuUrl = Router::url(array('controller' => 'employers','action' => 'viewpage',base64_encode($arrMenu['TopMenu']['career_portal_menu_page_id']."_".$arrMenu['TopMenu']['career_portal_id'])),true);
                                    //echo '<br>--URL--'.base64_encode($strMenuUrl);
                                    $strPagePortalId = base64_encode($arrMenu['TopMenu']['career_portal_menu_page_id']."_".$arrMenu['TopMenu']['career_portal_id']);
                                    if($arrMenu['TopMenu']['career_portal_menu_name'] == "Home")
                                    {
                                        $strMenuLink = $strHomeEditorLink;
                                    }
                                    else
                                    {
                                        $strMenuLink = Router::url(array('controller'=>'employers','action'=>'viewthemepage',$strPagePortalId),true);
                                    }
                                    
                                    ?>
                                    <li class="page-scroll"><a href="<?php echo $strMenuLink;?>" ><?php echo $arrMenu['TopMenu']['career_portal_menu_name']?></a></li>  
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
                <div class="col-lg-12">
                    <div class="intro-text">
                        <span class="name">Find your next career now</span>
                         <span class="skills">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut imperdiet nibh. Mauris lorem enim, consectetur sit amet tincidunt et, porta quis tellus. Cras cursus dui eu ante scelerisque tempor.</span>
                      
                  
                     <form>
                        <div class="form-inner"> 
                            <input type="text" class="form-control" placeholder="EMAIL ADDRESS" id="email" >
                            <input type="password" class="form-control" placeholder="PASSWORD" id="password" >
                            <button type="submit" class="btn btn-success btn-lg">Login</button>
                            <div class="social-login"> 
                            <?php echo $this->Form->hidden('',array('id'=>'facebook_process_url', 'value'=>$strFURL)); ?>
                                <a href="#" onClick="fnSocialRegister(this)" ><img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/fb-login.png" alt="Facebook login"></a> 
                                <!--<a href="#"><img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/twiiter-login.png" alt="Twitter login" ></a>-->
                                <a class="btn btn-success btn-lg" style="width:50%;margin-top:10px;" href="<?php echo $strRegister;?>">Register Now</a>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="form-bottom"></div>
                     </form>
                     
                              </div>   
                </div>
                
            </div>
        </div>
    </header>
    
    
     <!-- Header below section -->
     <section id="header-below-info">
       <div class="container">
        
     <h1>ACCELERATE YOUR JOB SEARCH</h1>
     This resource will help you find a job and advance your career.
Learn insider secrets, successfully used by professional recruiters<br/><br/>
         <div style="text-align:left;"><b>TO OBTAIN THE BEST RESULTS…</b><br/>
        Follow our 15-step process, sign up for LIVE weekly webinars and use the Job Search Tracker to organize your search efforts.
        </div>
     </div></section>

<!-- features section -->
   <section id="features">
       <div class="container">
    
             <div class="row">
         <div class="col-sm-4">
         <img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/icons/icon1.png" />
         <h3>15-Step Job Search Process</h3>
         Proven step-by-step process to finding a job          
         </div>
         
   
         <div class="col-sm-4">
          <img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/icons/icon2.png" />
         <h3>Weekly LIVE Webinars</h3>
         Live training webinars – bring your questions; receive answers 
         </div>
         
         
         <div class="col-sm-4">
          <img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/icons/icon3.png" />
         <h3>Job Search Tracker </h3>
         Free resource to track your contacts and job search activities
         </div>
           </div>
           
             <div class="row">
         <div class="col-sm-4">
          <img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/icons/icon4.png" />
         <h3>Interview Advisor</h3>
         Customized advice based on your Resume or CV          
         </div>
         
   
         <div class="col-sm-4">
          <img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/icons/icon5.png" />
         <h3>Resume Builder</h3>
         Create a keyword rich Resume or CV
         </div>
         
         
         <div class="col-sm-4">
          <img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/icons/icon6.png" />
         <h3>CV | Resume Builder</h3>
         Obtain customized feedback about your Resume or CV through the eyes of an employer
         </div>
           </div>
    
     </div></section>
     
     
   <!-- Welcome section -->
   <section id="welcome-area">
       <div class="container">
       <div class="row">
       
         <div class="col-sm-6">
          <img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/welcome-image.png" />
          </div>
         
           <div class="col-sm-6 info">
          <h1>WELCOME TO THE CAREER PORTAL OF <?php echo $arrPortalDetail[0]['Portal']['career_portal_name']; ?> </h1>
          <div class="content-info" onmouseover="fnApplyEditorHoverCss(this);fnShowEditPage();" onmouseout="fnRemoveEditorHoverCss(this);fnHideEditPage();">
          <span style="font-size: 10px; float: right; position: relative;top:0px;display:none;cursor:pointer;" id="pageedit" onclick="fnShowPageEditSection()">Manage</span>
          <?php if(isset($arrPortalPageDetail['0']['PortalPages']['career_portal_page_content'])) { ?>
            <div id="page_content_div">
                    <?php
                        $strPageContent = htmlspecialchars_decode($arrPortalPageDetail['0']['PortalPages']['career_portal_page_content']);
                        $strPageContent = str_replace("(site_name)",$arrPortalDetail[0]['Portal']['career_portal_name'],$strPageContent);
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
   <section id="testimonials">
       <div class="container">
       
       <div class="row">
     <div class="col-md-4">
     <img class="active" src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/testimonials-main.jpg" />
     <!--< h3>HI i am smith</h3> -->
     <h3>HI i am Dan</h3>
   
     </div>
     <div class="col-md-8">
      <h1>CUSTOMER SUCCESS STORIES</h1>
    <em>  Thank you!  I started seriously pursuing my job hunt about 2 months ago. I had my Resume rewritten. I used your 15-step process. The interview information was spot on. I listened to your advice and used your resources.I had 8 interviews with different companies. This Friday I was hired. This was the one employer I really wanted to work for.I thank you and my family thanks you!I will recommend your career portal services to friends and family</em> <br>
      <img class="active" src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/cleints.png" />
     </div>
     
     </div></div></section>

    <!-- Footer -->
    <footer>
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-5">
                        <?php if(isset($arrPortalDetail['0']['Portal']['career_portal_logo'])) { ?>
                <?php echo $this->Html->image('/userdata/portal/'.$arrPortalDetail['0']['Portal']['career_portal_logo'], array('id'=>'portal_header_logo','alt' => $arrPortalDetail['0']['Portal']['career_portal_name'],'height'=>'80','width'=>'165')); ?><br>
                <?php } else { ?>
                <a class="navbar-brand" href="#page-top" >Your LOGO <span>Goes Here</span></a><br>
                <?php } ?>
                        <em>Neque porro quisquam est, qui dolore ipsum quia dolor sit amet, consectetur adipisci velit, sed quia non</em> <br><br>
                        <div style="clear:both;" class="copyright"  onmouseover="fnApplyEditorHoverCss(this);fnShowEditCopyright();" onmouseout="fnRemoveEditorHoverCss(this);fnHideEditCopyright();">
                        <?php if(isset($arrPortalDetail['0']['Portal']['career_portal_footer_text'])) { ?>
                        <span id="footertext"><?php echo html_entity_decode($arrPortalDetail['0']['Portal']['career_portal_footer_text']);?></span>
                        <?php } else { ?>
                        <span id="footertext"> &copy; 2016 . All rights reserved.</span>
                        <?php } ?>
                        <span style="font-size: 10px;position: relative;bottom:10px;display:none;cursor:pointer;" id="copyrightsedit" onclick="fnShowCopyrightEditSection()">Manage</span>
                        </div>
                    </div>
                    <div class="footer-col col-md-3">
                        <h3>Useful LInks</h3>
                        <ul class="list-inline">
                            <li>
                                <a href="#">Blog</a>
                            </li>
                            <li>
                                 <a href="#">Contact Us</a>
                            </li>
                            <li>
                                <a href="#">Login</a>
                            </li>
                            <li>
                                <a href="<?php echo $strRegister;?>">Register</a>
                            </li>
                            
                        </ul>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>contact</h3>
                       <?php 
                            if($arrEmployerDetail[0]["Employer"]["show_address"] == '1') {
                                echo "Address - ".$arrEmployerDetail[0]["Employer"]["employer_address"]."<br><br>";
                            } ?>
                        
                       <?php if($arrEmployerDetail[0]["Employer"]["show_contact_number"] == '1') {
                                echo "Phone - ".$arrEmployerDetail[0]["Employer"]["employer_contact_number"]."<br><br>";
                            } ?>
                            
                        <?php if($arrEmployerDetail[0]["Employer"]["show_email"] == '1') {
                            echo "Email - ".$arrEmployerDetail[0]["Employer"]["employer_email"]."<br><br>";
                            } ?>
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
    <script src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/js/jqBootstrapValidation.js"></script>
    <script src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/js/contact_me.js"></script>

    <!-- Theme JavaScript -->
    <script src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/js/freelancer.min.js"></script>
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
            echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.effect'); 
            echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.sortable');
    ?>
    
    <?php
        echo $this->Html->script('tinymce/tiny_mce');
    ?>
</body>

</html>
