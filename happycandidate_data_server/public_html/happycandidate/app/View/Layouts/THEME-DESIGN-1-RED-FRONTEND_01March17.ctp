<?php //echo '<pre>';print_r($arrThemeDetail);//exit();?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!--<title>THEME-DESIGN-1-RED</title>-->
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

<body id="page-top" class="index red-theme">

	
    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                
				<?php if(isset($arrPortalDetail['0']['Portal']['career_portal_logo'])) { ?>
				<?php echo $this->Html->image('/userdata/portal/'.$arrPortalDetail['0']['Portal']['career_portal_logo'], array('id'=>'portal_header_logo','alt' => $arrPortalDetail['0']['Portal']['career_portal_name'],'height'=>'80','width'=>'165')); ?>
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
					<?php //echo '<pre>';print_r($arrPortalMenuDetail); exit();
					if(is_array($arrPortalMenuDetail) && (count($arrPortalMenuDetail)>0))
					{
						//echo '<pre>';print_r($arrPortalMenuDetail); 
						
						$strHomeEditorLink =  Router::url('/', true)."portal/themehome/".$arrPortalDetail[0]['Portal']['career_portal_name'];
                   
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
										$strMenuLink = Router::url(array('controller'=>'portal','action'=>'themepage',$strPagePortalId),true);
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
                    <div class="form-inner"> <input type="text" class="form-control" placeholder="YOUR NAME" id="name" >
                                 <input type="email" class="form-control" placeholder="EMAIL ADDRESS" id="email" >
                                 <button type="submit" class="btn btn-success btn-lg">Register Now</button>
                                <div class="social-login"> <a href="#"><img src="img/fb-login.png" alt="Facebook login"></a> <a href="#"><img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/twiiter-login.png" alt="Twitter login" ></a><div class="clear"></div></div>
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
     <h1>Lorem ipsum dolor sit amet</h1>
     Consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque<br> penatibus et magnis dis parturient montes, nascetur ridiculus mus. 
     </div></section>

<!-- features section -->
   <section id="features">
       <div class="container">
    
             <div class="row">
         <div class="col-sm-4">
         <img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/icons/icon1.png" />
         <h3>Lorem ipsum dolor</h3>
         Duis suscipit, eros vel tincidunt mollis, sapien ligula mollismi, 
         </div>
         
   
         <div class="col-sm-4">
          <img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/icons/icon2.png" />
         <h3>Lorem ipsum dolor</h3>
         Duis suscipit, eros vel tincidunt mollis, sapien ligula mollismi, 
         </div>
         
         
         <div class="col-sm-4">
          <img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/icons/icon3.png" />
         <h3>Lorem ipsum dolor</h3>
         Duis suscipit, eros vel tincidunt mollis, sapien ligula mollismi, 
         </div>
           </div>
           
             <div class="row">
         <div class="col-sm-4">
          <img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/icons/icon4.png" />
         <h3>Lorem ipsum dolor</h3>
         Duis suscipit, eros vel tincidunt mollis, sapien ligula mollismi, 
         </div>
         
   
         <div class="col-sm-4">
          <img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/icons/icon5.png" />
         <h3>Lorem ipsum dolor</h3>
         Duis suscipit, eros vel tincidunt mollis, sapien ligula mollismi, 
         </div>
         
         
         <div class="col-sm-4">
          <img src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/icons/icon6.png" />
         <h3>Lorem ipsum dolor</h3>
         Duis suscipit, eros vel tincidunt mollis, sapien ligula mollismi, 
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
          <h1>welome to our company </h1>
			<div class="content-info" >
			
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
		  
			<a href="#" class="register-btn">Register now</a>
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
     <h3>HI i am smith</h3>
    <em> consectetuer adipiscing elit. Aenean commodo ligula eget dolor. </em>
     </div>
     <div class="col-md-8">
      <h1>clients testimonial</h1>
    <em> consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</em> <br>
      <img class="active" src="<?php echo Router:: url('/',true); ?>themes/THEME-DESIGN-1/img/cleints.png" />
     </div>
     
     </div></div></section>

    <!-- Footer -->
    <footer>
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-5">
                        <!--<a href="#page-top" class="navbar-brand">Your LOGO <span>Goes Here</span></a><br>-->
						
						<?php if(isset($arrPortalDetail['0']['Portal']['career_portal_logo'])) { ?>
				<?php echo $this->Html->image('/userdata/portal/'.$arrPortalDetail['0']['Portal']['career_portal_logo'], array('id'=>'portal_header_logo','alt' => $arrPortalDetail['0']['Portal']['career_portal_name'],'height'=>'80','width'=>'165')); ?><br>
				<?php } else { ?>
				<a class="navbar-brand" href="#page-top" >Your LOGO <span>Goes Here</span></a><br>
				<?php } ?>
						
						
                        <em>Neque porro quisquam est, qui dolore ipsum quia dolor sit amet, consectetur adipisci velit, sed quia non</em> <br><br>
                        <div style="clear:both;" class="copyright"  >
						<?php if(isset($arrPortalDetail['0']['Portal']['career_portal_footer_text'])) { ?>
						<span id="footertext"><?php echo html_entity_decode($arrPortalDetail['0']['Portal']['career_portal_footer_text']);?></span>
						<?php } else { ?>
						<span id="footertext"> &copy; 2016 . All rights reserved.</span>
						<?php } ?>
						
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
                                <a href="#">Register</a>
                            </li>
                            
                        </ul>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>contact</h3>
                       Address - Boulevard des Capucines<br><br>Phone - +84 345 876 123<br><br>Email - Info@yourdomain.com
 
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
