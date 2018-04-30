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
		
		echo $this->Html->css('jqueryui/themes/base/jquery.ui.all');
		echo $this->Html->css('jqueryui/themes/base/demos');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->script('jquery/jquery');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/jquery.validationEngine');
		echo $this->Html->script('aui-production.min.js');
		echo $this->Html->script('common');
		
		
		echo $this->Html->css('jqueryvalidationplugin/validationEngine.jquery');
	?>
<style>
	.madatsym
	{
		color:#EE3322;
	}
</style>
</head>
<?php
	if($logged_in)
	{
		$strEmployerlogoPath = Router::url('/img/hometheme/img/logo.png',true);
		$strEmployerHomePath = Router::url(array('controller'=>'employers','action'=>'dashboard'),true);
		?>
			<body class="loggedin-employer-layout">
		<?php
	}
	else
	{
		?>
			<body class="login-layout">
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
	<div id="container">
		<div id="page-header">
		<?php
			if($logged_in)
			{
				?>
					<div class="logo_container" id="employer_logo" style="float:left;margin:0;padding:0;height:auto;width:auto;"><a href="<?php echo $strEmployerHomePath; ?>"><img class="employer_logo" style="height:53px;" src="<?php echo $strEmployerlogoPath; ?>" alt="Employerlogo" title="Employerlogo" /></a></div>
				<?php
			}
		?>
		<?php
			if($logged_in)
			{
					$strLogoutUrl = Router::url(array('controller' => 'users', 'action' => 'logout'),true);
					$strUserSessionKey = $this->Session->read("2_".$current_user['id']."_sesskey");
					$strUserEmail = $current_user['email'];
					$strEmployerProfile = Router::url(array('controller' => 'employersprofile', 'action' => 'index'),true);
					?>
						<div class="user-profile dropdown">
							<a href="javascript:;" title="" class="user-ico clearfix" data-toggle="dropdown">Account Detail & Settings</span><i class="glyph-icon icon-chevron-down"></i></a>
							<ul class="dropdown-menu float-right">
								<li><a href="<?php echo $strEmployerProfile; ?>">Profile</a></li>
								<li><a href="javascript:void(0);">Subscription</a></li>
								<li><a href="javascript:void(0);">Revenue</a></li>
							</ul>
						</div>
						
						<div class="user-profile dropdown">
							<a href="javascript:;" title="" class="user-ico clearfix" data-toggle="dropdown"><span>Welcome <?php echo $current_user['username'];?>!</span><i class="glyph-icon icon-chevron-down"></i></a>
							<ul class="dropdown-menu float-right">
								<li>
									<?php
										if(isset($_SESSION['olduser']) && $_SESSION['olduser']['user_type'] == "1")
										{
											$strLogoutUrl = Router::url(array('controller'=>'loginas','action'=>'swicthback',"2",$current_user['id'],$strUserSessionKey,'0'),true);
											?>
												<a href="<?php echo $strLogoutUrl;?>">Switch Back To Admin</a>
											<?php
										}
										else
										{
											?>
												<a href="javascript:void(0);" onclick="fnLogoutEmployer('<?php echo $strLogoutUrl; ?>','<?php echo $strUserSessionKey; ?>','<?php echo $strUserEmail; ?>')">Logout</a>
											<?php
										}
									?>
								</li>
								<!--<?php //echo $this->Html->link('Logout',array('controller'=>'users','action'=>'logout')); ?>-->
							</ul>
						</div>
					<?php
			}
			else
			{
					/*print("<pre>");
					print_r($this->params);*/
					?>
					<div class="user-profile dropdown">
						<?php
							//echo $this->Html->link('Login',array('controller'=>'users','action'=>'login'));
							if($this->params['controller'] != "home")
							{
								echo "&nbsp;".$this->Html->link("Home",array('controller'=>'home','action'=>'index'));
								echo "&nbsp;".$this->Html->link("Contact Us",array('controller'=>'employers','action'=>'contactus'));
							}
							if($this->params['controller'] != "employers")
							{
								echo "&nbsp;".$this->Html->link("Employer's Zone",array('controller'=>'employers','action'=>'index'));
							}
						?>
					</div>
					<?php
			}
		?>

		</div>
		
		<div id="content">
			
			<?php
				if($logged_in)
				{
					?>
						<div id="menu">
							<ul>
								<li style="display:inline;list-style-type: none;">
									<?php echo $this->Html->link("Home",'/employers/dashboard',array('style'=>$activeHomeHoriNavigationStyle)); ?>
								</li>
								<!--<li style="display:inline;list-style-type: none;">
									<?php echo $this->Html->link("Profile",'/employersprofile/index',array('style'=>$activeProfileHoriNavigationStyle)); ?>
								</li>-->
<!--								<li style="display:inline;list-style-type: none;">
									<?php echo $this->Html->link("Library",'/privatelabelsites/library',array('style'=>$activePrivatelabelsitesHoriNavigationStyle)); ?>
								</li>-->
								<li style="display:inline;list-style-type: none;">
									<?php echo $this->Html->link("My Career Portal",'/privatelabelsites/index',array('style'=>$activePrivatelabelsitesHoriNavigationStyle)); ?>
								</li>
								<li style="display:inline;list-style-type: none;">
									<?php echo $this->Html->link("Library",'/privatelabelsites/libcatdetail',array('style'=>$activePrivatelabelsitesHoriNavigationStyle)); ?>
								</li>
								<!--<li style="display:inline;list-style-type: none;">
									<?php echo $this->Html->link('MYLMS','/employerslms/index',array('style'=>$activeLMSHoriNavigationStyleAdmin)); ?>
								</li>-->
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
			<!--<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>-->
			
			
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
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
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.datepicker');
			echo $this->Html->script('jquery/jqueryui/development-bundle/ui/timepicker');
	?>
</body>
</html>
