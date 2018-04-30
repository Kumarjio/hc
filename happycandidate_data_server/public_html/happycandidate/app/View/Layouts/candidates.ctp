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
		echo $this->Html->css('jqueryui/themes/base/jquery.ui.all');
		echo $this->Html->css('jqueryui/themes/base/demos');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->script('jquery/jquery');
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
<!-- start Mixpanel --><script type="text/javascript">(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===e.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.2.min.js';f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f)}})(document,window.mixpanel||[]);
mixpanel.init("d495e4f0d31056a7b3b94ab7a59e2894");</script><!-- end Mixpanel -->
</head>
<body>
	<script type="text/javascript">
		var appBaseU = '<?php echo Router::url('/',true);?>';
		
		var strLmsLoginPath = '<?php echo $strLmsLoginUrl; ?>';
		var strLmsLogoutPath = '<?php echo $strLmsLogOutUrl; ?>';
		var strLmsSessionPath = '<?php echo $strLmsSessionUrl; ?>';
		
		var strJSeekerLoginUrl = '<?php echo $strJobberSeekerLoginUrl; ?>';
		var strJSeekerLogOutUrl = '<?php echo $strJobberSeekerLogOutUrl; ?>';
		
	</script>
	<div id="container">
		<div id="header">
			<!--<h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>-->
			<b>HC</b>
		</div>
		<div id="content">
			<div style="text-align:right;">
			<!--<?php
				if($logged_in)
				{
					?>
						Welcome <?php echo $current_user['candidate_username'];?>!  <?php echo $this->Html->link('Logout',array('controller'=>'portal','action'=>'logout',$intPortalId)); ?>
					<?php
				}
				else
				{
					/*print("<pre>");
					print_r($this->params);*/
					
					//echo $this->Html->link('Login',array('controller'=>'users','action'=>'login'));
					if($this->params['controller'] != "home")
					{
						echo "&nbsp;".$this->Html->link("Home",array('controller'=>'home','action'=>'index'));
					}
					if($this->params['controller'] != "employers")
					{
						echo "&nbsp;".$this->Html->link("Employer's Zone",array('controller'=>'Employers','action'=>'index'));
					}
				}
			?>-->
			</div>
			<?php
				if($logged_in)
				{
					?>
						<!--<div id="menu" style="width:90%;">
							<ul>
								<li style="display:inline;list-style-type: none;">
									<?php echo $this->Html->link("Home",'/portal/index/'.$strPortalName,array('style'=>$activeHomeHoriNavigationStyle)); ?>
								</li>
								<li style="display:inline;list-style-type: none;">
									<?php echo $this->Html->link("Recomended Jobs",'/candidates/dashboard/'.$intPortalId,array('style'=>$activeDashboardHoriNavigationStyle)); ?>
								</li>
								<li style="display:inline;list-style-type: none;">
									<?php echo $this->Html->link("Profile Performance",'/profileperformance/index/'.$intPortalId,array('style'=>$activeProfilePerformanceHoriNavigationStyle)); ?>
								</li>
							</ul>
						</div>-->
					<?php
				}
			?>
			<div style="height:50px;">
				&nbsp;
			</div>
			<?php // echo $this->Session->flash(); ?>
			<?php // echo $this->Session->flash('auth'); ?>

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
		echo $this->Html->script('jquery/jquery-1.6.2.min');
	?>
	<?php
			echo $this->Html->script('jquery/jquery.form');
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
	
</body>
</html>
