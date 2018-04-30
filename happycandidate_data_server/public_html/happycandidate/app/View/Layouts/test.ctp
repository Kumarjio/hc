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
			echo "Happy Candidates"; 
		?>
		<?php 
			//echo $title_for_layout; 
		?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('app-production');
		echo $this->Html->css('print');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->script('jquery/jquery');
		//echo $this->Html->script('jquery/jquery-1.7.2.min');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/jquery.validationEngine');
		echo $this->Html->script('common');
		//echo $this->Html->script('aui-production.min.js');
		//echo $this->Html->script('raphael.min.js');
		
		echo $this->Html->css('jqueryvalidationplugin/validationEngine.jquery');
		echo $this->Html->css('jqueryui/themes/base/jquery.ui.all');
		echo $this->Html->css('jqueryui/themes/base/jquery.ui.datepicker');
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
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.datepicker');
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/timepicker');
	?>
<style>
	.madatsym
	{
		color:#EE3322;
	}
</style>
<!-- start Mixpanel --><script type="text/javascript">(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===e.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.2.min.js';f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f)}})(document,window.mixpanel||[]);
mixpanel.init("d495e4f0d31056a7b3b94ab7a59e2894");</script><!-- end Mixpanel -->
</head>
<?php
	if($logged_in)
	{
		$strAdminlogoPath = Router::url('/img/hometheme/img/logo.png',true);
		$strAdminHomePath = Router::url(array('controller'=>'admins','action'=>'dashboard'),true);
		?>
			<body class="loggedin-admin-layout">
		<?php
	}
	else
	{
		?>
			<body class="login-layout">
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
		
		
	</script>
	<div id="container">
		<?php 
			if($logged_in)
			{
				?>
				<div id="page-header">
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
				</div>
				<?php
			}
			else
			{
				?>
					<div id="header"></div>
				<?php
			}
		?>
		<div id="content">
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
					$strAdminJobBoardsUrl = Router::url(array('controller'=>'jobboards','action'=>'index'),true);
					$strAdminMyLmsUrl = Router::url(array('controller'=>'mylms','action'=>'index'),true);
					$strAdminAdminsAnalyticsUrl = Router::url(array('controller'=>'adminanalytics','action'=>'index'),true);
					$strContentManageUrl = Router::url(array('controller'=>'content','action'=>'index'),true);
					$strContentAddUrl = Router::url(array('controller'=>'content','action'=>'add'),true);
					$strContentCatManageUrl = Router::url(array('controller'=>'contentcategories','action'=>'index'),true);
					$strContentCatAddUrl = Router::url(array('controller'=>'contentcategories','action'=>'add'),true);
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
					$strVendorsServicesMapUrl = Router::url(array('controller'=>'vendorservices','action'=>'add'),true);
					$strResourcecourseManageUrl = Router::url(array('controller'=>'resourcecourse','action'=>'index'),true);
					$strResourcecourseAddUrl = Router::url(array('controller'=>'resourcecourse','action'=>'add'),true);
					$strResourcecourseDraftAddUrl = Router::url(array('controller'=>'resourcecourse','action'=>'drafted'),true);
					$strResourcecourseModerationAddUrl = Router::url(array('controller'=>'resourcecourse','action'=>'moderation'),true);
					
					?>
						<div id="menu">
							<ul>
								<li><a href="<?php echo $strAdminHomeUrl; ?>" style="<?php echo $activeHomeHoriNavigationStyleAdmin; ?>">Admin's Home</a></li>
								<!--<li><a href="<?php echo $strAdminProfileUrl; ?>" style="<?php echo $activeProfileHoriNavigationStyleAdmin; ?>">Profile</a></li>-->
								<!--<li><a href="<?php echo $strAdminManageSeekerUrl; ?>" style="<?php echo $activeManageUsersHoriNavigationStyleAdmin; ?>">Manage Seekers</a></li>
								<li><a href="<?php echo $strAdminManageOwnerUrl; ?>" style="<?php echo $activeManageUsersHoriNavigationStyleAdmin; ?>">Manage Owners</a></li>-->
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
											<!--<li><a href="<?php echo $strCatContentUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Categories Content</a></li>-->
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
											<!--<li><a href="<?php echo $strPhaseContentUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Job Search Content</a></li>-->
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
								<!--<li><a href="<?php echo $strAdminJobBoardsUrl; ?>" style="<?php echo $activeManageJobBoardsHoriNavigationStyleAdmin; ?>">Jobboards</a></li>-->
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
						</div>
					<?php
				}
			?>	
			
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth'); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">			
		</div>
	</div>
	<?php 
		echo $this->element('sql_dump'); 
		echo $strActionScript;
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
</script>
</body>
</html>
