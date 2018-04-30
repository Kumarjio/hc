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
		echo $this->Html->css('fonts');
		echo $this->Html->css('normalize');
	?>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<?php
	
		/*echo $this->Html->css('print');
		echo $this->Html->css('main');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');*/
		echo $this->Html->css('stylesheetlatnew');
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
</style>
<script type="text/javascript">
    	$(document).ready(function () {
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
		});
    </script>
</head>
<?php
	if($logged_in)
	{
		//print("<pre>");
		//print_r($current_user);
		//exit;
		
		$strEmployerlogoPath = Router::url('/img/hometheme/img/logo.png',true);
		$strEmployerHomePath = Router::url(array('controller'=>'employers','action'=>'dashboard'),true);
		$strLogoutUrl = Router::url(array('controller' => 'users', 'action' => 'logout'),true);
		$strUserSessionKey = $this->Session->read("2_".$current_user['id']."_sesskey");
		$strUserEmail = $current_user['email'];
		$strEmployerProfile = Router::url(array('controller' => 'employersprofile', 'action' => 'index'),true);
		$strJobBoardsUri = Router::url(array('controller' => 'privatelabelsitejobboard', 'action' => 'index', $current_user['portal_id']),true);
		$strPortalAnalyticsUri = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'index', $current_user['portal_id']),true);
		
		$strPortalLibraryUri = Router::url(array('controller' => 'privatelabelsites', 'action' => 'library'),true);
		
		
		?>
			<body class="no-padding">
		<?php
	}
	else
	{
		?>
			<body class="login-layout no-padding">
		<?php
	}
?>
	<?php
		//echo "--".$strJobberEmployerLoginUrl;exit;
	?>
	<script type="text/javascript">
		var appBaseU = '<?php echo Router::url('/',true);?>';
		var strBaseUrl = appBaseU;
		
		var strLmsLoginPath = '<?php echo $strLmsLoginUrl; ?>';
		var strLmsLogoutPath = '<?php echo $strLmsLogOutUrl; ?>';
		var strLmsSessionPath = '<?php echo $strLmsSessionUrl; ?>';
		
		var strJobberBasePath = '<?php echo $strJobberBaseUrl; ?>';
		var strJobberEmployerLoginPath = '<?php echo $strJobberEmployerLoginUrl; ?>';
		var strJobberEmployerLogoutPath = '<?php echo $strJobberEmployerLogoutUrl; ?>';
		var strJobberEmployerSetPortalPath = '<?php echo $strJobberEmployerSetPortalUrl; ?>';
	</script>
	<div class="container-fluid top-menu-container">
		<nav class="navbar navbar-default top-menu">
			<div class="col-xs-12 col-md-2">
				<a class="navbar-brand" href="#" >
					<img src="<?php echo Router::url('/',true); ?>images/search-item.png" alt="logo description"><span>HR Search</span>
				</a>
			</div>
			<div class="col-xs-12 col-md-10">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="#" class="right-top-menu-item icon-questionmark">&nbsp;</a>
					</li>
					<li class="dropdown" id="notify">
						<a href="#" class="dropdown-toggle right-top-menu-item icon-notification" data-toggle="dropdown">&nbsp;</a>
						<ul class="dropdown-menu notification-block">
							<li>
								<a class="triangle-a">
									<img class="triangle-img" src="<?php echo Router::url('/',true); ?>images/tooltip-triangle.png" alt="">	
								</a>
							</li>
							<li id="notification1" class="notification-block-bordered">
								<a href="#" class="dropdown-item-notification">
									<p>Your password was changed.</p>
								</a>
								<a href="#notification1" class="close-notification">
									<img src="<?php echo Router::url('/',true); ?>images/icon-delete-notification.png" alt="">
								</a>
							</li>
							<li id="notification2" class="notification-block-bordered">
								<a href="#" class="dropdown-item-notification">
									<p>Your application for "Sales Manager" was declined.</p>
								</a>
								<a href="#notification2" class="close-notification">
									<img src="<?php echo Router::url('/',true); ?>images/icon-delete-notification.png" alt="">
								</a>
							</li>
							<li>
								<a href="#" class="right-top-menu-item">See all notifications</a>
							</li>
						</ul>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle right-top-menu-item icon-user" data-toggle="dropdown" >
							Hi Matthew!
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu xs-border" style="margin-top: 5px;">
							<li>
								<a class="triangle-a">
									<img class="triangle-img" src="<?php echo Router::url('/',true); ?>images/tooltip-triangle.png" alt="">	
								</a>
							</li>
							<li>
								<a href="<?php echo Router::url(array('controller'=>'employersprofile','action'=>'index'),true); ?>" class="right-top-menu-item dropdown-item">Edit my profile</a>
							</li>
							<li>
								<a href="<?php echo Router::url(array('controller'=>'employersprofile','action'=>'changepassword'),true); ?>" class="right-top-menu-item dropdown-item">Change password</a>
							</li>
							<li>
								<a href="javascript:void(0);" onclick="fnLogoutEmployer('<?php echo $strLogoutUrl; ?>','<?php echo $strUserSessionKey; ?>','<?php echo $strUserEmail; ?>')">Logout</a>
								<!--<a href="#" class="right-top-menu-item dropdown-item">Logout</a>-->
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div>
	<div class="container-fluid">
		<?php
			//print("<pre>");
			//print_r($strCurrentUser);
			
		?>
		
		
		<div class="admin-wrapper">
	        <div class="admin-sidebar-wrapper">
	            <ul class="sidebar-nav nav-pills nav-stacked admin-menu">
	                <li id="dashnavi" class="active leftnavi">
	                    <a href="<?php echo Router::url(array('controller'=>'employers','action'=>'dashboard'),true); ?>">
	                    	<span class="employer-menu-icon emp-icon-dashboard" aria-hidden="true"></span> 
	                    	Dashboard
	                    </a>
	                </li>
					<li id="libnavi" class="leftnavi">
	                    <a href="<?php echo Router::url(array('controller'=>'privatelabelsites','action'=>'library'),true); ?>">
	                    	<span class="employer-menu-icon emp-icon-library" aria-hidden="true"></span> 
	                    	Library
	                    </a>
	                </li>
	                <li id="pagenavi" class="leftnavi">
	                    <a href="<?php echo Router::url(array('controller'=>'privatelabelsites','action'=>'pages'),true); ?>">
	                    	<span class="employer-menu-icon emp-icon-page" aria-hidden="true"></span> 
	                    	Pages
	                    </a>
	                </li>
	                <li id="jobnavi" class="leftnavi">
	                    <a href="<?php echo Router::url(array('controller'=>'privatelabelsitejobboard','action'=>'index',$strCurrentUser['portal_id']),true); ?>">
	                    	<span class="employer-menu-icon emp-icon-tasks" aria-hidden="true"></span> 
	                    	Jobs
	                    </a>
	                </li>
	                <li id="candnavi" class="leftnavi">
	                    <a href="<?php echo Router::url(array('controller'=>'privatelabelsites','action'=>'candidates'),true); ?>">
	                    	<span class="employer-menu-icon emp-icon-candidates" aria-hidden="true"></span> 
	                    	Candidates
	                    </a>
	                </li>
	                <li id="appnavi" class="leftnavi">
	                    <a href="<?php echo Router::url(array('controller'=>'privatelabelsites','action'=>'applications'),true); ?>">
	                    	<span class="employer-menu-icon emp-icon-applications" aria-hidden="true"></span> 
	                    	Applications
	                    </a>
	                </li>
	                <li id="eventsnavi" class="leftnavi">
	                    <a href="<?php echo Router::url(array('controller'=>'privatelabelsites','action'=>'events'),true); ?>">
	                    	<span class="employer-menu-icon emp-icon-events" aria-hidden="true"></span> 
	                    	Events
	                    </a>
	                </li>
	                <li id="reportsnavi" class="leftnavi">
	                    <a href="<?php echo Router::url(array('controller'=>'privatelabelsiteanalytics','action'=>'index',$strCurrentUser['portal_id']),true); ?>">
	                    	<span class="employer-menu-icon emp-icon-reports" aria-hidden="true"></span> 
	                    	Reports
	                    </a>
	                </li>
	            </ul>
				<div class="toggle-buttons-container">
	                <button class="navbar-toggle collapse in menu-toggle" data-toggle="collapse">
	                	<span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> Collapse menu
	                </button>
	        	</div>
	        </div>
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth'); ?>
			<?php echo $this->fetch('content'); ?>
	       
	    </div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
	<?php
			//echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.core');
			//echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.widget');	
			//echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.mouse');	
			//echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.button');	
			//echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.draggable');	
			//echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.position');	
			//echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.resizable');	
			//echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.button');	
			//echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.dialog');	
			//echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.effect');	
			//echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.sortable');
			//echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.datepicker');
			//echo $this->Html->script('jquery/jqueryui/development-bundle/ui/timepicker');
	?>
</body>
</html>
