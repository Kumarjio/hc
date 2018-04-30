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
</head>
<body class="login-layout">
	<script type="text/javascript">
		var appBaseU = '<?php echo Router::url('/',true);?>';
		
		var strLmsLoginPath = '<?php echo $strLmsLoginUrl; ?>';
		var strLmsLogoutPath = '<?php echo $strLmsLogOutUrl; ?>';
		var strLmsSessionPath = '<?php echo $strLmsSessionUrl; ?>';
	</script>
	<div id="container">
		<div id="header"></div>
		<div id="content">
			<div style="text-align:right;">
			<?php
				if($logged_in)
				{
					?>
						Welcome <?php echo $current_user['username'];?>  <?php echo $this->Html->link('Logout',array('controller'=>'users','action'=>'logout')); ?>
					<?php
				}
				else
				{
					/*print("<pre>");
					print_r($this->params);*/
					
					//echo $this->Html->link('Login',array('controller'=>'users','action'=>'login'));
					if($this->params['controller'] != "home")
					{
						//echo "&nbsp;".$this->Html->link("Home",array('controller'=>'home','action'=>'index'));
					}
					if($this->params['controller'] != "Employers")
					{
						//echo "&nbsp;".$this->Html->link("Employer's Zone",array('controller'=>'employers','action'=>'index'));
					}
				}
			?>
			</div>
			
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
</body>
</html>
