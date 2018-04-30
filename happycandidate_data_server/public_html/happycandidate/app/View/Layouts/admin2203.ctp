<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php 
			//echo $cakeDescription :
		?>
		<?php 
			//echo $title_for_layout; 
		?>
		
		<?php 
			echo "Happy Candidate"; 
		?>
		<?php 
			//echo $title_for_layout; 
		?>
	</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
	<?php
		/*echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('app-production');
		echo $this->Html->css('print');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');*/
		echo $this->Html->css('stylesheet');
		echo $this->Html->css('website');
		echo $this->Html->script('jquery/jquery');
		?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
	 <script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
    <link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css">
	<?php
		//echo $this->Html->script('jquery/jquery-1.7.2.min');
		echo $this->Html->script('editor');
		echo $this->Html->css('editor');
				
		echo $this->Html->script('jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/jquery.validationEngine');
		echo $this->Html->script('common');
		//echo $this->Html->script('aui-production.min.js');
		//echo $this->Html->script('raphael.min.js');
		
		echo $this->Html->css('jqueryvalidationplugin/validationEngine.jquery');
		echo $this->Html->css('jqueryui/themes/base/jquery.ui.all');
		//echo $this->Html->css('jqueryui/themes/base/jquery.ui.datepicker');
		echo $this->Html->css('jqueryui/themes/base/jquery-ui');
	?>

	<?php
			echo $this->Html->script('jquery/jquery-ui.min');
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.core');
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.widget');	
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.tabs');	
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.mouse');	
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.button');	
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.draggable');	
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.position');	
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.resizable');	
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.dialog');	
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.slider');	
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.effect');	
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.sortable');
			//echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.datepicker');
			//echo $this->Html->script('jquery/jqueryui/development-bundle/ui/timepicker');
	?>


</head>
<?php
	if($logged_in)
	{
		$strAdminlogoPath = Router::url('/img/hometheme/img/logo.png',true);
		$strAdminHomePath = Router::url(array('controller'=>'admins','action'=>'dashboard'),true);
		?>
			<body>
		<?php
	}
	else
	{
		?>
			<body>
		<?php
	}
?>

	<script type="text/javascript">
		var appBaseU = '<?php echo Router::url('/',true);?>';
		var strBaseUrl = appBaseU;
		var strLmsLoginPath = '<?php echo $strLmsLoginUrl; ?>';
		var strLmsLogoutPath = '<?php echo $strLmsLogOutUrl; ?>';
		var strLmsSessionPath = '<?php echo $strLmsSessionUrl; ?>';
		
		var strJAdminLoginUrl = '<?php echo $strJobberAdminLoginUrl; ?>';
		var strJAdminLogOutUrl = '<?php echo $strJobberAdminLogOutUrl; ?>';
		var strJSeekerLoginUrl = '<?php echo $strJobberSeekerLoginUrl; ?>';
		var strJSeekerLogOutUrl = '<?php echo $strJobberSeekerLogOutUrl; ?>';
		
		
		var strJobberBasePath = '<?php echo $strJobberBaseUrl; ?>';
		var strJobberEmployerLoginPath = '<?php echo $strJobberEmployerLoginUrl; ?>';
		var strJobberEmployerLogoutPath = '<?php echo $strJobberEmployerLogoutUrl; ?>';
		var strJobberEmployerSetPortalPath = '<?php echo $strJobberEmployerSetPortalUrl; ?>';
		
		
	</script>
	
      <script type="text/javascript">
    	$(document).ready(function () {
    		//RUN EDITOR
    		//$("#txtEditor").Editor(); 
			
    		initMenu();
    		//TOP MENU - NOTIFICATIONS
    		//NOTIFICATIONS
			$(".close-notification").click(function(event) {
				$(this.getAttribute("href")).css('display', 'none');
				$('#notify').on({
				    "shown.bs.dropdown": function() { this.closable = true; },
				    "click":             function() { this.closable = false; },
				    "hide.bs.dropdown":  function() { return this.closable; }
				});
			});

			//AFTER CLOSING NOTIFICATION - CLICK ON THE LINK INSIDE OR ON THE DROPDOWN LINK ITSELF
			$("#notify li:last-child a, #notify").click(function(event) {
				$('#notify').on({
				    "shown.bs.dropdown": function() { this.closable = false; },
				    "click":             function() { this.closable = true; },
				    "hide.bs.dropdown":  function() { return this.closable; }
				});
			});
			////AFTER CLOSING NOTIFICATION - CLICK OUTSIDE THE NOTIFICATION CONTAINER
			$("body").click(function(e) {
    			if (!$('li#notify').is(e.target) && $('li#notify').has(e.target).length === 0 && $('.open').has(e.target).length === 0) {
       				 $('li#notify').removeClass('open');
    			}
			});

 			//ADMIN - COLLAPSE MENU
		    $(".menu-toggle").click(function(e) {
		        e.preventDefault();
		        $(".admin-wrapper").toggleClass("toggled-2");
		        $('.admin-menu ul').hide();
		    });

		    function initMenu() {
			
		      	$('.admin-menu ul').hide();
		      	//$('.admin-menu ul').children('.current').parent().show();
		      	$('.admin-menu ul.current').show();

		      	$('.admin-menu li a').click(
			        function() {

			          	if($(this).parent().attr('class') != "submenu" && $(this).parent().attr('class') != "submenu-active") {
			          		
			          		$('.admin-menu ul:visible').slideUp('normal');

			          		$('.admin-menu li').removeClass('active');
							$(this).parent().addClass('active');
				          				          	
				          	var checkElement = $(this).next();
				          	if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
				            	return false;
				            }
				          	if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
				            	$('.admin-menu ul:visible').slideUp('normal');
				            	checkElement.slideDown('normal');
				            	return false;
				            }
			          	} else if ($(this).parent().attr('class') == "submenu" || $(this).parent().attr('class') == "submenu-active") {
			          		$(this).parent().parent().children('.submenu-active').addClass('submenu');
			          		$(this).parent().parent().children('.submenu-active').removeClass('submenu-active');
			          		$(this).parent().addClass('submenu-active');
			          		$(this).parent().removeClass('submenu');
			          	}
			          	
			        }
		        );
		    }

		    //CLICKING ON THE USERS INSIDE TABLE
		    $(".panel-body.admin-jobs-category .user-title a").click(function(event) {
				
				$(this.getAttribute("href")).css('display', 'table-row');
				$(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
			});
		});
    </script>
  

	
		<?php 
			if($logged_in)
			{
				?>
		<div class="container-fluid top-menu-container">
		<nav class="navbar navbar-default top-menu">
			<div class="col-xs-12 col-md-2">
				<a class="navbar-brand" href="#" >
					<img src="<?php echo Router::url('/',true);?>images/search-item.png" alt="logo description" /><span>HR Search</span>
				</a>
			</div>
			<div class="col-xs-12 col-md-10">
<?php
					$strAdminEditUrl = Router::url(array('controller'=>'adminsprofile','action'=>'edit'),true);
					$strAdminChangePwdUrl = Router::url(array('controller'=>'adminsprofile','action'=>'changepassword'),true);
					$strLogOutUrl = Router::url(array('controller'=>'admins','action'=>'logout'),true);
					$strUserSessionKey = $this->Session->read("1_".$current_user['id']."_sesskey");
					$strUserEmail = $current_user['email'];
				?>
				<ul class="nav navbar-nav navbar-right">

					<li class="dropdown" id="notify">
						<a href="#" class="dropdown-toggle right-top-menu-item icon-notification" data-toggle="dropdown">&nbsp;</a>
						<ul class="dropdown-menu notification-block">
							<li>
								<a class="triangle-a">
									<img class="triangle-img" src="<?php echo Router::url('/',true);?>images/tooltip-triangle.png" alt=""/>	
								</a>
							</li>
							<li id="notification1" class="notification-block-bordered">
								<a href="#" class="dropdown-item-notification">
									<p>Your password was changed.</p>
								</a>
								<a href="#notification1" class="close-notification">
									<img src="<?php echo Router::url('/',true);?>images/icon-delete-notification.png" alt="" />
								</a>
							</li>
							<li id="notification2" class="notification-block-bordered">
								<a href="#" class="dropdown-item-notification">
									<p>Your application for "Sales Manager" was declined.</p>
								</a>
								<a href="#notification2" class="close-notification">
									<img src="<?php echo Router::url('/',true);?>images/icon-delete-notification.png" alt="" />
								</a>
							</li>
							<li>
								<a href="#" class="right-top-menu-item">See all notifications</a>
							</li>
						</ul>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle right-top-menu-item icon-user" data-toggle="dropdown" >
							Hi Admin!
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu xs-border" style="margin-top: 5px;">
							<li>
								<a class="triangle-a">
									<img class="triangle-img" src="<?php echo Router::url('/',true);?>images/tooltip-triangle.png" alt=""/>	
								</a>
							</li>
							<li>
								<a href="<?php echo $strAdminEditUrl;?>" class="right-top-menu-item dropdown-item">My profile</a>
							</li>
							<li>
								<a href="<?php echo $strAdminChangePwdUrl;?>" class="right-top-menu-item dropdown-item">Change password</a>
							</li>
							<li>
								<a href="<?php echo $strLogOutUrl;?>" class="right-top-menu-item dropdown-item">Logout</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div>
<div class="cms-bgloader-mask"></div>
<div class="cms-bgloader"></div>
				<!--<div id="page-header">
				<div class="logo_container" id="admin_logo" style="float:left;margin:0;padding:0;height:auto;width:auto;"><a href="<?php echo $strAdminHomePath; ?>"><img class="admin_logo" style="height:53px;" src="<?php echo $strAdminlogoPath; ?>" alt="Adminlogo" title="Adminlogo" /></a></div>
				<div id="userprof" class="user-profile dropdown">
				<?php
					$strAdminEditUrl = Router::url(array('controller'=>'adminsprofile','action'=>'edit'),true);
					$strAdminChangePwdUrl = Router::url(array('controller'=>'adminsprofile','action'=>'changepassword'),true);
					$strLogOutUrl = Router::url(array('controller'=>'admins','action'=>'logout'),true);
					$strUserSessionKey = $this->Session->read("1_".$current_user['id']."_sesskey");
					$strUserEmail = $current_user['email'];
				?>
					<a id="userprofa" href="javascript:;" title="" class="user-ico clearfix" data-toggle="dropdown"><span>Welcome <?php echo $current_user['username'];?>!</span><i class="glyph-icon icon-chevron-down"></i></a>
					<ul class="dropdown-menu float-right">
						<li><a href="<?php echo $strAdminEditUrl; ?>">Edit Profile</a><i class="glyph-icon icon-cog mrg5R"></i></li>
						<li><a href="<?php echo $strAdminChangePwdUrl; ?>">Change Password</a></li>
						<li><a href="javascript:void(0)" onclick="fnLogout('<?php echo $strLogOutUrl; ?>','<?php echo $strUserSessionKey; ?>','<?php echo $strUserEmail; ?>')">Logout</a></li>
					</ul>
				</div>
				</div>-->
				<?php
			}
			else
			{
				?>
					
				<?php
			}
		?>
	
			<?php
				if($logged_in)
				{
					$strAdminHomeUrl = Router::url(array('controller'=>'admins','action'=>'dashboard'),true);
					$strAdminProfileUrl = Router::url(array('controller'=>'adminsprofile','action'=>'index'),true);
					$strAdminJobsListingUrl = Router::url(array('controller'=>'managejobs','action'=>'index'),true);
					$strAdminManageUserUrl = Router::url(array('controller'=>'manageusers','action'=>'index'),true);
					//$strAdminManageSeekerUrl = Router::url(array('controller'=>'manageseekers','action'=>'index'),true);
					//$strAdminManageOwnerUrl = Router::url(array('controller'=>'manageowners','action'=>'index'),true);
					$strAdminManageJobInputsUrl = Router::url(array('controller'=>'managejobinputs','action'=>'index'),true);
					$strAdminManageJobUrl = Router::url(array('controller'=>'managejobs','action'=>'index'),true);
					$strAdminManageJobnewUrl = Router::url(array('controller'=>'joblisting','action'=>'index'),true);
					$strAdminJobBoardsUrl = Router::url(array('controller'=>'jobboards','action'=>'index'),true);
					$strAdminMyLmsUrl = Router::url(array('controller'=>'mylms','action'=>'index'),true);
					$strAdminAdminsAnalyticsUrl = Router::url(array('controller'=>'adminanalytics','action'=>'index'),true);
					$strAdminAdminsBcastUrl = Router::url(array('controller'=>'email','action'=>'bcast'),true);
					$strAdminAdminsSentEmailsUrl = Router::url(array('controller'=>'email','action'=>'sentmails'),true);
					$strContentManageUrl = Router::url(array('controller'=>'content','action'=>'index'),true);
					$strContentOwnerManageUrl = Router::url(array('controller'=>'content','action'=>'ownercontent'),true);
					$strContentVendorManageUrl = Router::url(array('controller'=>'content','action'=>'vendorcontent'),true);
					$strContentAddUrl = Router::url(array('controller'=>'content','action'=>'add'),true);
					$strContentCatManageUrl = Router::url(array('controller'=>'contentcategories','action'=>'index'),true);
					$strContentCatAddUrl = Router::url(array('controller'=>'contentcategories','action'=>''),true);
					$strCatContentUrl = Router::url(array('controller'=>'contentcategories','action'=>'content'),true);
					$strJobSearcProcessUrl = Router::url(array('controller'=>'jsprocessphase','action'=>'index'),true);
					$strAddPhaseUrl = Router::url(array('controller'=>'jsprocessphase','action'=>'add'),true);
					$strViewPhaseUrl = Router::url(array('controller'=>'jsprocessphase','action'=>'index'),true);
					$strPhaseContentUrl = Router::url(array('controller'=>'jsprocessphase','action'=>'content'),true);
					$strAddStepsUrl = Router::url(array('controller'=>'jsprocesssteps','action'=>'add'),true);
					$strViewStepsUrl = Router::url(array('controller'=>'jsprocesssteps','action'=>'index'),true);
					$strSubstepsAddUrl = Router::url(array('controller'=>'jsprocesssubsteps','action'=>'add'),true);
					$strViewSubStepsUrl = Router::url(array('controller'=>'jsprocesssubsteps','action'=>'index'),true);
					$strResourceManageUrl = Router::url(array('controller'=>'resource','action'=>'index'),true);
					$strResourceAddUrl = Router::url(array('controller'=>'resource','action'=>'add'),true);
					$strResourceAddImageUrl = Router::url(array('controller'=>'resource','action'=>'addimage'),true);
					$strResourceServiceImageUrl = Router::url(array('controller'=>'resource','action'=>'serviceimages'),true);
					$strVendorsManageUrl = Router::url(array('controller'=>'vendors','action'=>'index'),true);
					$strVendorsAddUrl = Router::url(array('controller'=>'vendors','action'=>'add'),true);
					$strVendorsServicesManageUrl = Router::url(array('controller'=>'vendorservices','action'=>'index'),true);
					$strEmailTemplateManageUrl = Router::url(array('controller'=>'email','action'=>'index'),true);
					$strEmailTemplateaddUrl = Router::url(array('controller'=>'email','action'=>'add'),true);
					$strVendorsServicesMapUrl = Router::url(array('controller'=>'vendorservices','action'=>'add'),true);
					$strVendorsSalesManageUrl = Router::url(array('controller'=>'vendorsales','action'=>'sales'),true);
					$strVendorsSalesUrl = Router::url(array('controller'=>'vendorsales','action'=>'vendorsales'),true);
					$strResourcecourseManageUrl = Router::url(array('controller'=>'resourcecourse','action'=>'index'),true);
					$strResourcecourseAddUrl = Router::url(array('controller'=>'resourcecourse','action'=>'add'),true);
					$strResourcecourseDraftAddUrl = Router::url(array('controller'=>'resourcecourse','action'=>'drafted'),true);
					$strResourcecourseModerationAddUrl = Router::url(array('controller'=>'resourcecourse','action'=>'moderation'),true);
					
					$strResourceManageUrl = Router::url(array('controller'=>'resource','action'=>'index'),true);
					
					?>
					
					<div class="container-fluid">

		<div class="admin-wrapper">

	        <div class="admin-sidebar-wrapper">
	            <ul class="sidebar-nav nav-pills nav-stacked admin-menu">
					<?php $current_controller = $this->params['controller'];
					$current_action = $this->params['action'];?>
	                <li class="<?php echo ($current_controller == 'admins' && $current_action == 'dashboard' ? 'active' : ''); ?>">
	                    <a href="<?php echo $strAdminHomeUrl; ?>">
	                    	<span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> 
	                    	Dashboard
	                    </a>
	                </li>
	              		
					<li class="<?php echo ($current_controller == 'manageusers'  ? 'active' : ''); ?>">
	                    <a href="#" title="Users">
	                    	<span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
	                    	Users
	                    </a>
	                    <ul class="nav-pills nav-stacked <?php echo ($current_controller == 'manageusers'  ? 'current' : ''); ?>">
	                        <li class="submenu">
	                        	<a href="<?php echo $strAdminManageUserUrl; ?>" title="Job Seekers">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Job Seekers
	                        	</a>
	                        </li>
	                        <li class="submenu-active">
	                        	<a href="<?php echo $strAdminManageUserUrl; ?>" title="Portal Owners">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Portal Owners
	                        	</a>
	                        </li>
	                    </ul>
	                </li>
					
					  <li class="<?php  if($current_controller == 'managejobs' || $current_controller ==  'managejobinputs' ||$current_controller ==  'joblisting'  ) { echo 'active'; } ?>">
	                    <a href="#" title="Jobs">
	                    	<span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> 
	                    	Jobs
	                    </a>
	                    <ul class="nav-pills nav-stacked <?php  if($current_controller == 'joblisting' || $current_controller ==  'managejobinputs' ) { echo 'current'; } ?>">
	                        <li class="submenu">
	                        	<a href="<?php echo $strAdminManageJobUrl; ?>" title="All Jobs">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		All Jobs
	                        	</a>
	                        </li>
							<!--<li class="submenu">
	                        	<a href="<?php echo $strAdminManageJobnewUrl; ?>" title="All Jobs">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		All Jobs
	                        	</a>
	                        </li>-->
	                        <li class="submenu">
	                        	<a href="<?php echo $strAdminManageJobInputsUrl; ?>" title="Category">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        	Jobs Inputs
	                        	</a>
	                        </li>
	                        <!--<li class="submenu">
	                        	<a href="#" title="Type">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Type
	                        	</a>
	                        </li>
	                        <li class="submenu">
	                        	<a href="#" title="Status">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Status
	                        	</a>
	                        </li>
	                        <li class="submenu">
	                        	<a href="#" title="Education">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Education
	                        	</a>
	                        </li>
	                        <li class="submenu">
	                        	<a href="#" title="Career Level">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Career Level
	                        	</a>
	                        </li>
	                        <li class="submenu">
	                        	<a href="#" title="Years Experience">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Years Experience
	                        	</a>
	                        </li>-->
	                    </ul>
	                </li>
	               
					
	               <li class="<?php   if($current_controller == 'content' ||  $current_controller ==  'contentcategories' ) { echo "active";} ?>">
	                    <a href="#" title="Content">
	                    	<span class="glyphicon glyphicon-picture" aria-hidden="true"></span> 
	                    	Content
	                    </a>
	                    <ul class="nav-pills nav-stacked  <?php   if($current_controller == 'content' ||  $current_controller ==  'contentcategories' ) { echo "current";} ?>">
	                        <li class="submenu<?php   if($current_controller == 'content' &&  $current_action ==  'index' ) { echo "-active";} ?>">
	                        	<a href="<?php echo $strContentManageUrl; ?>" title=" Content">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Jobseeker Content
	                        	</a>
	                        </li>
							<li class="submenu<?php   if($current_controller == 'content' &&  $current_action ==  'index' ) { echo "-active";} ?>">
	                        	<a href="<?php echo $strContentOwnerManageUrl; ?>" title=" Content">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Owner Content
	                        	</a>
	                        </li>
							<li class="submenu<?php   if($current_controller == 'content' &&  $current_action ==  'index' ) { echo "-active";} ?>">
	                        	<a href="<?php echo $strContentVendorManageUrl; ?>" title=" Content">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Vendor Content
	                        	</a>
	                        </li>
	                        <li class="submenu<?php   if($current_controller == 'content' &&  $current_action ==  'add' ) { echo "-active";} ?>">
	                        	<a href="<?php echo $strContentAddUrl; ?>" title="Add New">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Add New
	                        	</a>
	                        </li>
	                        <li class="submenu<?php   if($current_controller == 'contentcategories' && ($current_action ==  'add' ||  $current_action ==  'index' )) { echo "-active";} ?>">
	                        	<a href="<?php echo $strContentCatAddUrl; ?>" title="Categories">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Categories
	                        	</a>
	                        </li>
	                    </ul>
	                </li>
	               <li class="<?php   if($current_controller == 'jsprocessphase' ||  $current_controller ==  'jsprocesssubsteps' || $current_controller ==  'jsprocesssteps') { echo "active";} ?>">
	                    <a href="#" title="Job Search Process">
	                    	<span class="glyphicon glyphicon-search" aria-hidden="true"></span> 
	                    	Job Search Process
	                    </a>
						
	                    <ul class="nav-pills nav-stacked <?php   if($current_controller == 'jsprocessphase' ||  $current_controller ==  'jsprocesssubsteps' || $current_controller ==  'jsprocesssteps') { echo "current";} ?> " >
	                        <li class="submenu<?php echo ($current_controller == 'jsprocessphase' && ($current_action=='index') ? '-active' : ''); ?>">
	                        	<a href="<?php echo $strViewPhaseUrl; ?>" title="Phases">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Phases
	                        	</a>
	                        </li>
	                        <li class="submenu<?php echo ($current_controller == 'jsprocessphase'  && ($current_action=='add' ||$current_action=='edit') ? '-active' : ''); ?>">
	                        	<a href="<?php echo $strAddPhaseUrl; ?>" title="Edit Phase (Add New)">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Edit Phase (Add New)
	                        	</a>
	                        </li>
	                        <li class="submenu<?php echo ($current_controller == 'jsprocesssteps' && ($current_action=='index') ? '-active' : ''); ?>">
	                        	<a href="<?php echo $strViewStepsUrl; ?>" title="Steps">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Steps
	                        	</a>
	                        </li>
	                        <li class="submenu<?php echo ($current_controller == 'jsprocesssteps' && ($current_action=='add' ||$current_action=='edit') ? '-active' : ''); ?>">
	                        	<a href="<?php echo $strAddStepsUrl; ?>" title="Edit Step (Add New)">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Edit Step (Add New)
	                        	</a>
	                        </li>
	                        <li class="submenu<?php echo ($current_controller == 'jsprocesssubsteps' && ($current_action=='index') ? '-active' : ''); ?>">
	                        	<a href="<?php echo $strViewSubStepsUrl; ?>" title="Substeps">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Substeps
	                        	</a>
	                        </li>
	                        <li class="submenu<?php echo ($current_controller == 'jsprocesssubsteps' && ($current_action=='add' ||$current_action=='edit') ? '-active' : ''); ?>">
	                        	<a href="<?php echo $strSubstepsAddUrl; ?>" title="Edit Substeps (Add New)">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Edit Substeps (Add New)
	                        	</a>
	                        </li>
	                    </ul>
	                </li>
	            
	                    <li class="<?php   if($current_controller == 'vendors' ) { echo "active";} ?>">
	                    <a href="#" title="Vendors">
	                    	<span class="glyphicon glyphicon-barcode" aria-hidden="true"></span> 
	                    	Vendors
	                    </a>
	                    <ul class="nav-pills nav-stacked <?php   if($current_controller == 'vendors' ) { echo "current";} ?>">
	                        <li class="submenu-active">
	                        	<a href="<?php echo $strVendorsManageUrl; ?>"" title="All Vendors">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		All Vendors
	                        	</a>
	                        </li>
	                        <li class="submenu">
	                        	<a href="<?php echo $strVendorsAddUrl; ?>" title="Edit Vendor (Add New)">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Edit Vendor (Add New)
	                        	</a>
	                        </li>
	                    </ul>
	                </li>
					
					<li class="<?php   if($current_controller == 'resource' ) { echo "active";} ?>">
	                    <a href="#" title="Manage Services">
	                    	<span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> 
	                    	Manage Product / Services
	                    </a>
	                    <ul class="nav-pills nav-stacked <?php   if($current_controller == 'resource' ) { echo 'current';} ?>">
	                        <li class="submenu-active">
	                        	<a href="<?php echo $strResourceManageUrl?>" title="All Vendor Services">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		All Product / Services
	                        	</a>
	                        </li>
	                        <li class="submenu">
	                        	<a href="<?php echo $strResourceAddUrl;?>" title="Edit Vendor Service (Add New)">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Edit Product / Service (Add New)
	                        	</a>
	                        </li>
							 <li class="submenu">
	                        	<a href="<?php echo $strResourceServiceImageUrl;?>" title="Edit Vendor Service (Add New)">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Product / Service Images
	                        	</a>
	                        </li>
							 <li class="submenu">
	                        	<a href="<?php echo $strResourceAddImageUrl;?>" title="Edit Vendor Service (Add New)">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Add Product / Service Image
	                        	</a>
	                        </li>
	                    </ul>
	                </li>
					<li class="<?php   if($current_controller == 'resource' ) { echo "active";} ?>">
						<a href="<?php echo $strResourcecourseManageUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>"><span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> Manage Courses</a>
						<ul class="nav-pills nav-stacked <?php   if($current_controller == 'resource' ) { echo 'current';} ?>">
							<li class="submenu"><a href="<?php echo $strResourcecourseAddUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>Add Courses</a></li>
							<li class="submenu"><a href="<?php echo $strResourcecourseManageUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>Published Courses</a></li>
							<li class="submenu"><a href="<?php echo $strResourcecourseDraftAddUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>Drafted Courses</a></li>
							<li class="submenu"><a href="<?php echo $strResourcecourseModerationAddUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>Course Moderation</a></li>
						</ul>
					</li>
	                <li class="<?php   if($current_controller == 'vendorservices' ) { echo 'active';} ?>">
	                    <a href="#" title="Vendor Services">
	                    	<span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> 
	                    	Vendor Product / Service
	                    </a>
	                    <ul class="nav-pills nav-stacked <?php   if($current_controller == 'vendorservices' ) { echo 'current';} ?>">
	                        <li class="submenu-active">
	                        	<a href="<?php echo $strVendorsServicesManageUrl?>" title="All Vendor Services">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		All Vendor Product / Service
	                        	</a>
	                        </li>
	                        <li class="submenu">
	                        	<a href="<?php echo $strVendorsServicesMapUrl;?>" title="Edit Vendor Service (Add New)">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Edit Vendor Product / Service (Add New)
	                        	</a>
	                        </li>
	                    </ul>
	                </li>
					<li class="<?php   if($current_controller == 'vendorsales' ) { echo 'active';} ?>">
	                    <a href="javascript:void(0);" title="Vendor Services">
	                    	<span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> 
	                    	Sales Report
	                    </a>
	                    <ul class="nav-pills nav-stacked <?php   if($current_controller == 'vendorsales' ) { echo 'current';} ?>">
	                        <li class="submenu-active">
	                        	<a href="<?php echo $strVendorsSalesManageUrl?>" title="All Vendor Services">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Daily Sales
	                        	</a>
	                        </li>
							 <li class="submenu-active">
	                        	<a href="<?php echo $strVendorsSalesUrl?>" title="All Vendor Services">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Vendor Sales
	                        	</a>
	                        </li>
	                    </ul>
	                </li>
					 <li class="<?php   if($current_controller == 'email'  && $current_action != "bcast" && $current_action != "sentmails") { echo 'active';} ?>">
	                    <a href="#" title="Vendor Services">
	                    	<span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> 
	                    	Add Email Templates
	                    </a>
	                    <ul class="nav-pills nav-stacked <?php   if($current_controller == 'email' ) { echo 'current';} ?>">
	                        <li class="submenu-active">
	                        	<a href="<?php echo $strEmailTemplateManageUrl?>" title="All Email Templates">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		All Email Templates
	                        	</a>
	                        </li>
	                        <li class="submenu">
	                        	<a href="<?php echo $strEmailTemplateaddUrl;?>" title="Edit Vendor Template (Add New)">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Add Email Template
	                        	</a>
	                        </li>
	                    </ul>
	                </li>
					
					
	                
	               <!-- <li>
	                    <a href="<?php echo $strAdminMyLmsUrl; ?>">
	                    	<span class="glyphicon glyphicon-cog" aria-hidden="true"></span> 
	                    	LMS
	                    </a>
	                </li>-->
					<li class="<?php   if($current_controller == 'email'  && $current_action != "index" && $current_action != "add") { echo 'active';} ?>">
	                    <a href="<?php echo $strAdminAdminsBcastUrl; ?>">
	                    	<span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> 
	                    	Broadcast Email
	                    </a>
						<ul class="nav-pills nav-stacked <?php   if($current_controller == 'email' ) { echo 'current';} ?>">
	                        <li class="submenu-active">
	                        	<a href="<?php echo $strAdminAdminsBcastUrl; ?>" title="All Email Templates">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Send E-Mail
	                        	</a>
	                        </li>
	                        <li class="submenu">
	                        	<a href="<?php echo $strAdminAdminsSentEmailsUrl;?>" title="Edit Vendor Template (Add New)">
	                        		<span class="glyphicon glyphicon-record" aria-hidden="true"></span> 
	                        		Sent E-Mails
	                        	</a>
	                        </li>
	                    </ul>
	                </li>
	                <li>
	                    <a href="<?php echo $strAdminAdminsAnalyticsUrl; ?>">
	                    	<span class="glyphicon glyphicon-signal" aria-hidden="true"></span> 
	                    	Analytics
	                    </a>
	                </li>
	            </ul>
				<div class="toggle-buttons-container">
	                <button class="navbar-toggle collapse in menu-toggle" data-toggle="collapse">
	                	<span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> Collapse menu
	                </button>
	        	</div>
	        </div>
		
						<!--<div id="menu">
							<ul>
								<li><a href="<?php echo $strAdminHomeUrl; ?>" style="<?php echo $activeHomeHoriNavigationStyleAdmin; ?>">Admin's Home</a></li>
								<!--<li><a href="<?php echo $strAdminProfileUrl; ?>" style="<?php echo $activeProfileHoriNavigationStyleAdmin; ?>">Profile</a></li>-->
								<!--<li><a href="<?php echo $strAdminManageSeekerUrl; ?>" style="<?php echo $activeManageUsersHoriNavigationStyleAdmin; ?>">Manage Seekers</a></li>
							<!--	<li><a href="<?php echo $strAdminManageOwnerUrl; ?>" style="<?php echo $activeManageUsersHoriNavigationStyleAdmin; ?>">Manage Owners</a></li>
								<li><a href="<?php echo $strAdminManageUserUrl; ?>" style="<?php echo $activeManageUsersHoriNavigationStyleAdmin; ?>">Manage Users</a></li>
								<li><a href="<?php echo $strAdminJobsListingUrl; ?>" style="<?php echo $activeJoblistingHoriNavigationStyleAdmin; ?>">Job Listings</a></li>
								<li><a href="<?php echo $strAdminManageJobInputsUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Manage Jobs</a></li>
								<li>
									<a href="<?php echo $strContentManageUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Manage Content</a>
									<div class="submenu">
										<ul>
											<li><a href="<?php echo $strContentAddUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Add Content</a></li>
											<li><a href="<?php echo $strContentCatManageUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">View Content Categories</a></li>
											<li><a href="<?php echo $strContentCatAddUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Add Categories</a></li>
											<li><a href="<?php echo $strCatContentUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Categories Content</a></li>
										</ul>
									</div>
								</li>
								<li>
									<a href="<?php echo $strJobSearcProcessUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Job Search Process</a>
									<div class="submenu">
										<ul>
											<li><a href="<?php echo $strViewPhaseUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">View Phases</a></li>
											<li><a href="<?php echo $strAddPhaseUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Add Phases</a></li>
											<li><a href="<?php echo $strViewStepsUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">View Steps</a></li>
											<li><a href="<?php echo $strAddStepsUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Add Steps</a></li>
											<li><a href="<?php echo $strViewSubStepsUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">View Substeps</a></li>
											<li><a href="<?php echo $strSubstepsAddUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Add Substeps</a></li>
											<li><a href="<?php echo $strPhaseContentUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Job Search Content</a></li>
										</ul>
									</div>
								</li>
								<li>
									<a href="<?php echo $strVendorsManageUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Manage Vendors</a>
									<div class="submenu">
										<ul>
											<li><a href="<?php echo $strVendorsAddUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Add Vendors</a></li>
										</ul>
									</div>
								</li>
								<li>
									<a href="<?php echo $strResourceManageUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Manage Services</a>
									<div class="submenu">
										<ul>
											<li><a href="<?php echo $strResourceAddUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Add Service</a></li>
											<li><a href="<?php echo $strResourceServiceImageUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Service Images</a></li>
											<li><a href="<?php echo $strResourceAddImageUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Add Service Images</a></li>
										</ul>
									</div>
								</li>
								<li>
									<a href="<?php echo $strResourcecourseManageUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Manage Courses</a>
									<div class="submenu">
										<ul>
											<li><a href="<?php echo $strResourcecourseAddUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Add Courses</a></li>
											<li><a href="<?php echo $strResourcecourseManageUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Published Courses</a></li>
											<li><a href="<?php echo $strResourcecourseDraftAddUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Drafted Courses</a></li>
											<li><a href="<?php echo $strResourcecourseModerationAddUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Course Moderation</a></li>
										</ul>
									</div>
								</li>
								
						
								
								<!--<li><a href="<?php echo $strAdminJobBoardsUrl; ?>" style="<?php echo $activeManageJobBoardsHoriNavigationStyleAdmin; ?>">Jobboards</a></li>
								<li>
									<a href="<?php echo $strVendorsServicesManageUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Vendor Service</a>
									<div class="submenu">
										<ul>
											<li><a href="<?php echo $strVendorsServicesMapUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Set Vendor Services</a></li>
										</ul>
									</div>
								</li>
								<li><a href="<?php echo $strAdminMyLmsUrl; ?>" style="<?php echo $activeLMSHoriNavigationStyleAdmin; ?>">MY LMS</a></li>
								<li><a href="<?php echo $strAdminAdminsAnalyticsUrl; ?>" style="<?php echo $activeLMSHoriNavigationStyleAdmin; ?>">My Analytics</a></li>
							</ul>
						</div>-->
					<?php
				}
			?>	
			
			<?php //echo $this->Session->flash(); ?>
			<?php // echo $this->Session->flash('auth'); ?>

			<?php echo $this->fetch('content'); ?>

	<?php 
		echo $this->element('sql_dump'); 
		echo $strActionScript;
	?>
	<?php
				if($logged_in)
				{?>
	</div>
	</div>
	<?php
	}
?>
<script type="text/javascript">
	$(document).ready(function () {
		$('#userprofa').click(function () {
			if($('#userprof').hasClass('open'))
			{
				$('#userprof').removeClass('open');
			}
			else
			{
				$('#userprof').addClass('open');
			}
		});
	});

function fnClearMessage()
{
	setTimeout(function(){ $('#product_notification').hide(); }, 5000);
}
</script>
</body>
</html>
