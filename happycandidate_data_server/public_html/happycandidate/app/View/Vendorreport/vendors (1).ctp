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
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<?php
		echo $this->Html->script('editor');
	?>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
    <link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css">
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
	<?php
		echo $this->Html->css('editor');
		echo $this->Html->css('stylesheet');
		
		
		//echo $this->Html->script('jquery/jquery');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/jquery.validationEngine');
		echo $this->Html->script('jquery/jquery.form');
		echo $this->Html->script('common');
		echo $this->Html->script('add_product');
		echo $this->Html->script('cart');
		echo $this->Html->script('vendorjs');
		
		echo $this->Html->css('jqueryvalidationplugin/validationEngine.jquery');
		echo $this->Html->css('jqueryui/themes/base/jquery.ui.all');
		echo $this->Html->css('jqueryui/themes/base/jquery.ui.datepicker');
		echo $this->Html->css('jqueryui/themes/base/jquery-ui');
		
	?>
	<?php
			/*echo $this->Html->script('jquery/jquery-ui.min');
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
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/timepicker');*/
	?>
<style>
	.cms-bgloader-mask{
			position:fixed;
			left:0;
			top:0;
			width:100%;
			height:100%;
			background-color:#292D30;
			opacity:0.4;
			display:none;
			z-index:100000;
}
.cms-bgloader { 	
				background:url(../img/bg-loader.gif) no-repeat 10px 10px; 
				margin:-22px -22px; 
				top:50%; 
				left:50%; 
				z-index:100000;
				position:fixed;
				width:64px;
				height:64px;
				display:none;
				border-radius: 3px;
				-moz-border-radius: 3px;
				-webkit-border-radius: 3px;
}
</style>
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
	
		
	</script>
	<script type="text/javascript">
	var strTimeInt =  "";
	$(document).ready(function () {
		fnCheckReminders();
		strTimeInt = setInterval(function(){ 
			fnCheckReminders()
		}, 50000);
	});

	function fnCheckReminders()
	{
		//alert(appBaseU);
		//clearInterval(strTimeInt);
		//alert("hi");
		
		
		var strUrl = appBaseU+"vendoraccount/checkvendorreminders/";
		$.ajax({ 
				type: "POST",
				url: strUrl,
				cache: false,
				dataType:"json",
				success: function(data)
				{
					if(data.status == "success")
					{
						
						if(data.notifycount != "")
						{
							$('#notificationicon').removeClass('icon-notification-empty');
							$('#notificationicon').addClass('icon-notification');
						}
						else
						{
							$('#notificationicon').removeClass('icon-notification');
							$('#notificationicon').addClass('icon-notification-empty');
						}
						if(data.notifyhtml != "")
						{
							//alert(data.notifyhtml);
						
							$('.notification-block').html(data.notifyhtml);
						}
						
						
						/*if(data.contactshtml != "")
						{
							$('#reminder_container').html(data.contactshtml);
							$('.reminders').dialog('open');
						}
						else
						{
							$('#reminder_container').html('');
						}*/
					}
				}
		});
	}
	</script>
		<?php 
			
			//print("<pre>");
			//print_r($current_user);
			
			if($logged_in)
			{
			
					$strAdminEditUrl = Router::url(array('controller'=>'vendoraccount','action'=>'edit',$type=""),true);
					
					$strCompanyEditUrl = Router::url(array('controller'=>'vendoraccount','action'=>'edit',$type="company"),true);
					$strPayoutEditUrl = Router::url(array('controller'=>'vendoraccount','action'=>'edit',$type="payout"),true);
					$strAdminChangePwdUrl = Router::url(array('controller'=>'vendoraccount','action'=>'changepassword'),true);
					$strLogOutUrl = Router::url(array('controller'=>'vendoraccount','action'=>'logout'),true);
					$strdashboardUrl = Router::url(array('controller'=>'vendoraccount','action'=>'dashboard'),true);
					$strUserEmail = $current_user['vendor_email'];
					$strUserSessionKey = $this->Session->read("2_".$current_user['id']."_sesskey");
				?>
				<div class="container-fluid top-menu-container">
		<nav class="navbar navbar-default top-menu">
			<div class="col-xs-12 col-md-2">
				<a class="navbar-brand" href="#" >
					<span>Vendor Management</span>
				</a>
			</div>
			<div class="col-xs-12 col-md-10">
<?php $strAdminNewUrl = Router::url(array('controller'=>'vendororders','action'=>'neworders'),true);?>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown" id="notify">
						<?php
							if($notifyCount)
							{
								?>
									<a href="#" class="dropdown-toggle right-top-menu-item icon-notification" data-toggle="dropdown">&nbsp;</a>
								<?php
							}
							else
							{
								?>
									<a href="#" id="notificationicon" class="dropdown-toggle right-top-menu-item icon-notification-empty" data-toggle="dropdown">&nbsp;</a>
								<?php
							}
						?>
						
						<ul class="dropdown-menu notification-block">
							<!--<li>
								<a class="triangle-a">
									<img class="triangle-img" src="<?php //echo Router::url('/',true);?>images/tooltip-triangle.png" alt=""/>	
								</a>
							</li>
							<li id="notification1" class="notification-block-bordered">
								<a href="<?php //echo $strAdminNewUrl;?>" class="dropdown-item-notification">
									<p>New order found.</p>
								</a>
								<a href="#notification1" class="close-notification">
									<img src="<?php //echo Router::url('/',true);?>images/icon-delete-notification.png" alt="" />
								</a>
							</li>
							<li id="notification2" class="notification-block-bordered">
								<a href="#" class="dropdown-item-notification">
									<p>Your application for "Sales Manager" was declined.</p>
								</a>
								<a href="#notification2" class="close-notification">
									<img src="<?php //echo Router::url('/',true);?>images/icon-delete-notification.png" alt="" />
								</a>
							</li>
							<li>
								<a href="#" class="right-top-menu-item">See all notifications</a>
							</li>-->
						</ul>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle right-top-menu-item icon-user" data-toggle="dropdown" >
							Hi <?php echo $current_user['vendor_first_name'];?>!
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu xs-border" style="margin-top: 5px;">
							<li>
								<a class="triangle-a">
									<img class="triangle-img" src="<?php echo Router::url('/',true);?>images/tooltip-triangle.png" alt=""/>	
								</a>
							</li>
							<li>
								<a href="<?php echo $strAdminEditUrl; ?>" class="right-top-menu-item dropdown-item">Edit my profile</a>
							</li>
						
							<li>
								<a href="<?php echo $strCompanyEditUrl; ?>" class="right-top-menu-item dropdown-item">Edit Company Details</a>
							</li>
							<li>
								<a href="<?php echo $strPayoutEditUrl; ?>" class="right-top-menu-item dropdown-item">Edit Payment Details</a>
							</li>
							<li>
								<a href="javascript:void(0)" onclick="fnLogoutVendor('<?php echo $strLogOutUrl; ?>','<?php echo $strUserSessionKey; ?>','<?php echo $strUserEmail; ?>')" class="right-top-menu-item dropdown-item">Logout</a>
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
			
					<a id="userprofa" href="javascript:;" title="" class="user-ico clearfix" data-toggle="dropdown"><span>Welcome <?php echo $current_user['vendor_name'];?>!</span><i class="glyph-icon icon-chevron-down"></i></a>
					<ul class="dropdown-menu float-right">
						<li><a href="<?php echo $strAdminEditUrl; ?>">Edit Profile</a></li>
						<li><a href="<?php echo $strCompanyEditUrl; ?>">Edit Company Details</a></li>
						<li><a href="<?php echo $strPayoutEditUrl; ?>">Edit Payment Details</a></li>
						<li><a href="<?php echo $strAdminChangePwdUrl; ?>">Change Password</a></li>
						<li><a href="javascript:void(0)" onclick="fnLogoutVendor('<?php echo $strLogOutUrl; ?>','<?php echo $strUserSessionKey; ?>','<?php echo $strUserEmail; ?>')">Logout</a></li>
					</ul>
				</div>
				</div>-->
				<?php
			}
			else
			{
				?>
					<div></div>
				<?php
			}
		?>
		
			<?php
				if($logged_in)
				{
					$strAdminHomeUrl = Router::url(array('controller'=>'vendoraccount','action'=>'dashboard'),true);
					$strVendorOrdersUrl = Router::url(array('controller'=>'vendororders','action'=>'index'),true);
					$strAdminNewUrl = Router::url(array('controller'=>'vendororders','action'=>'neworders'),true);
					$strAdminOpenUrl = Router::url(array('controller'=>'vendororders','action'=>'openorders'),true);
					$strAdminClosedUrl = Router::url(array('controller'=>'vendororders','action'=>'closedorders'),true);
					$strAddVendorUserUrl = Router::url(array('controller'=>'vendoraccount','action'=>'adduser'),true);
					$strManageVendorUserUrl = Router::url(array('controller'=>'vendoraccount','action'=>'mgusers'),true);
					
					?>
					<div class="container-fluid">

		<div class="admin-wrapper">

	        <div class="admin-sidebar-wrapper">
	            <ul class="sidebar-nav nav-pills nav-stacked admin-menu">
					<?php
						if($current_user['parent_vendor'])
						{
							?>
								<li class="<?php echo $this->params['action'] == "index" ? 'active' : ''?>">
									<a href="<?php echo $strVendorOrdersUrl; ?>">
										<span class="glyphicon glyphicon-list" aria-hidden="true"></span> 
										My Orders
									</a>
								</li>
							<?php
						}
						else
						{
							?>
								 <li class="<?php echo $this->params['action'] == "dashboard" ? 'active' : ''?>">
									<a href="<?php echo $strdashboardUrl;?>">
										<span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> 
										Dashboard
									</a>
								</li>
								<li class="<?php echo $this->params['action'] == "index" ? 'active' : ''?>">
									<a href="<?php echo $strVendorOrdersUrl; ?>">
										<span class="glyphicon glyphicon-list" aria-hidden="true"></span> 
										My Orders
									</a>
								</li>
								<li>
									<a href="<?php echo $strAddVendorUserUrl; ?>">
										<span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
										Add User
									</a>
								</li>
								<li>
									<a href="<?php echo $strManageVendorUserUrl; ?>">
										<span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
										Manage Users
									</a>
								</li>
								<?php
												if($current_user['vendor_type'] == "Course")
												{
													$strVendorcourseManageUrl = Router::url(array('controller'=>'vendorcourse','action'=>'index'),true);
													$strVendorcourseAddManageUrl = Router::url(array('controller'=>'vendorcourse','action'=>'add'),true);
													$strResourcecourseModerationAddUrl = Router::url(array('controller'=>'vendorcourse','action'=>'moderation'),true);
													$strResourcecourseDraftAddUrl = Router::url(array('controller'=>'vendorcourse','action'=>'drafted'),true);
													
													?>
														<li>
															<a href="<?php echo $strVendorcourseManageUrl; ?>" >Manage Courses</a>
															<div class="submenu">
																<ul>
																	<li><a href="<?php echo $strVendorcourseAddManageUrl; ?>">Add Courses</a></li>
																	
																	<li><a href="<?php echo $strVendorcourseManageUrl; ?>" >Published Course</a></li>
																	<li><a href="<?php echo $strResourcecourseDraftAddUrl; ?>">Drafted Course</a></li>
																	<li><a href="<?php echo $strResourcecourseModerationAddUrl; ?>" >Course Moderation</a></li>
																</ul>
															</div>
														</li>
														<li style="display:inline;list-style-type: none;">
															<?php echo $this->Html->link('MYLMS','/vendorslms/index',array('style'=>$activeLMSHoriNavigationStyleAdmin)); ?>
														</li>
													<?php
												}
												else
												{
													?>
														<!--<li><a href="<?php echo $strVendorOrdersUrl; ?>" >My Orders</a></li>
														<li><a href="<?php echo $strAdminNewUrl; ?>" >My New Orders</a></li>
														<li><a href="<?php echo $strAdminOpenUrl; ?>" >My Open Orders</a></li>
														<li><a href="<?php echo $strAdminClosedUrl; ?>" >My Closed Orders</a></li>-->
													<?php
												}
											?>
							<?php
						}
					?>
	            </ul>
				<div class="toggle-buttons-container">
	                <button class="navbar-toggle collapse in menu-toggle" data-toggle="collapse">
	                	<span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> Collapse menu
	                </button>
	        	</div>
	        </div>
		
	       
	

				
						<!--<div id="menu">
							<ul>
								
								
								<li><a href="<?php echo $strAdminHomeUrl; ?>" style="<?php echo $activeHomeHoriNavigationStyleAdmin; ?>">Home</a></li>
								<?php
									if($current_user['vendor_type'] == "Course")
									{
										$strVendorcourseManageUrl = Router::url(array('controller'=>'vendorcourse','action'=>'index'),true);
										$strVendorcourseAddManageUrl = Router::url(array('controller'=>'vendorcourse','action'=>'add'),true);
										$strResourcecourseModerationAddUrl = Router::url(array('controller'=>'vendorcourse','action'=>'moderation'),true);
										$strResourcecourseDraftAddUrl = Router::url(array('controller'=>'vendorcourse','action'=>'drafted'),true);
										
										?>
											<li>
												<a href="<?php echo $strVendorcourseManageUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Manage Courses</a>
												<div class="submenu">
													<ul>
														<li><a href="<?php echo $strVendorcourseAddManageUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Add Courses</a></li>
														
														<li><a href="<?php echo $strVendorcourseManageUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Published Course</a></li>
														<li><a href="<?php echo $strResourcecourseDraftAddUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Drafted Course</a></li>
														<li><a href="<?php echo $strResourcecourseModerationAddUrl; ?>" style="<?php echo $activeManageJobInputsHoriNavigationStyleAdmin; ?>">Course Moderation</a></li>
													</ul>
												</div>
											</li>
											<li style="display:inline;list-style-type: none;">
												<?php echo $this->Html->link('MYLMS','/vendorslms/index',array('style'=>$activeLMSHoriNavigationStyleAdmin)); ?>
											</li>
										<?php
									}
									else
									{
										?>
											<li><a href="<?php echo $strVendorOrdersUrl; ?>" style="<?php echo $activeHomeHoriNavigationStyleAdmin; ?>">My Orders</a></li>
											<li><a href="<?php echo $strAdminNewUrl; ?>" style="<?php echo $activeHomeHoriNavigationStyleAdmin; ?>">My New Orders</a></li>
											<li><a href="<?php echo $strAdminOpenUrl; ?>" style="<?php echo $activeHomeHoriNavigationStyleAdmin; ?>">My Open Orders</a></li>
											<li><a href="<?php echo $strAdminClosedUrl; ?>" style="<?php echo $activeHomeHoriNavigationStyleAdmin; ?>">My Closed Orders</a></li>
										<?php
									}
								?>
							</ul>
						</div>-->
					<?php
				}
			?>	
			
			
			

			<?php echo $this->fetch('content'); ?>
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
		    $(".menu-toggle").click(function(e) {
		        e.preventDefault();
		        $(".admin-wrapper").toggleClass("toggled-2");
		        $('.admin-menu ul').hide();
		    });
	});
</script>
</body>
</html>
