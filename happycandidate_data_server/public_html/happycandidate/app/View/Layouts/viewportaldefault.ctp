<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php 
			echo "Happy Candidates"; 
		?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('menu');
		echo $this->Html->css('hometheme/style');
		echo $this->Html->css('hometheme/reset');
		echo $this->Html->css('hometheme/slider');
		echo $this->Html->css('hometheme/jquery.jscrollpane');
		echo $this->Html->css('jqueryui/themes/base/jquery.ui.all');
		echo $this->Html->css('jqueryui/themes/base/demos');

		

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->script('jquery/jquery-1.7.2.min');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/jquery.validationEngine');
		echo $this->Html->script('common');
		
		echo $this->Html->css('jqueryvalidationplugin/validationEngine.jquery');
	?>
<style>
	
	#header-candy img {
		display:none;
	}
	
	div#dialog-register-form { font-size: 62.5%; }
	
	input.text { margin-bottom:12px; width:95%; padding: .4em; }
	fieldset { padding:0; border:0; margin-top:25px; }
	h1 { font-size: 1.2em; margin: .6em 0; }
	div#users-contain { width: 350px; margin: 20px 0; }
	div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
	div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
	.ui-dialog .ui-state-error { padding: .3em; }
	.validateTips { border: 1px solid transparent; padding: 0.3em; margin-top:11px;margin-bottom:11px;}
	.madatsym
	{
		color:#EE3322;
	}
	#noti_Container {
		position:relative;     /* This is crucial for the absolutely positioned element */
		height:16px;
	}
	.noti_bubble {
		padding:1px 2px 1px 2px;
		background-color:red; /* you could use a background image if you'd like as well */
		color:white;
		font-weight:bold;

		/* The following is CSS3, but isn't crucial for this technique to work. */
		/* Keep in mind that if a browser doesn't support CSS3, it's fine! They just won't have rounded borders and won't have a box shadow effect. */
		/* You can always use a background image to produce the same effect if you want to, and you can use both together so browsers without CSS3 still have the rounded/shadow look. */
		border-radius:30px;
	}
</style>
</head>
<body>
	<script type="text/javascript">
		var appBaseU = '<?php echo Router::url('/',true);?>';
		
		var strLmsLoginPath = '<?php echo $strLmsLoginUrl; ?>';
		var strLmsLogoutPath = '<?php echo $strLmsLogOutUrl; ?>';
		var strLmsSessionPath = '<?php echo $strLmsSessionUrl; ?>';
		
		var strJSeekerLoginUrl = '<?php echo $strJobberSeekerLoginUrl; ?>';
		var strJSeekerLogOutUrl = '<?php echo $strJobberSeekerLogOutUrl; ?>';
		var appBaseU = '<?php echo Router::url('/',true);?>';
		
	</script>
<!--Start top Nav 1-->
<div id="top-nav">
	<div class="wrapper">
	
		<?php 
			$intPortalId = $arrPortalDetail[0]['Portal']['career_portal_id'];
		?>
		<span class="nav-1 fright"><?php echo $this->Html->link("Register",array('controller'=>'privatelabelsites','action'=>'registereditor',$intPortalId)); ?>	    |	<?php echo $this->Html->link("Login",'javascript:void(0);'); ?></span>
	</div>
</div>
<?php
	$strHomeEditorLink = Router::url(array('controller'=>'privatelabelsites','action'=>'view',$arrPortalDetail['0']['Portal']['career_portal_id']));
?>
<!--Start main Nav 2-->
<div class="main-nav-panel padding-top-5">
		<div class="wrapper">
			<a href="<?php echo $strHomeEditorLink; ?>"><span>
				<?php 
						if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
						{
							echo $this->Html->image('/userdata/portal/'.$arrPortalDetail['0']['Portal']['career_portal_logo'], array('alt' => $arrPortalDetail['0']['Portal']['career_portal_name'],'height'=>'80','width'=>'165'));					
							
						}
				?>
			</span></a>
			<?php
				if(isset($arrPortalMenuDetail))
				{
					?>					
						<ul id='menusection'>
						<?php
							foreach($arrPortalMenuDetail as $arrMenu)
							{
								$strPagePortalId = base64_encode($arrMenu['TopMenu']['career_portal_menu_page_id']."_".$arrMenu['TopMenu']['career_portal_id']);
								if($arrMenu['TopMenu']['career_portal_menu_name'] == "Home")
								{
									$strMenuLink = Router::url(array('controller'=>'privatelabelsites','action'=>'view',$intPortalId),true);
								}
								else
								{
									$strMenuLink = Router::url(array('controller'=>'privatelabelsites','action'=>'viewpage',$strPagePortalId),true);
								}
								
								?>
								<li id="menu_li_<?php echo $arrMenu['TopMenu']['career_portal_menu_alloc_id']?>"><a id="portal_menu_<?php echo $arrMenu['TopMenu']['career_portal_menu_alloc_id'];?>" href="<?php echo $strMenuLink;?>" class="home-icon"><?php echo $arrMenu['TopMenu']['career_portal_menu_name']?></a></li>	
								<?php
							}
						?>
						</ul>
					<?php
				}
			?>
			<!--<ul>
				<li><a href="javascript:void(0);" class="home-icon">Home</a></li>
				<li><a href="javascript:void(0);">About us</a></li>
				<li><a href="javascript:void(0);">Jobs</a></li>
				<li><a href="javascript:void(0);">Contact us</a></li>
			</ul>-->
			<div>
				<span style="margin-left:5%;" onmouseover="fnShowEditLogo()" onmouseout="fnHideEditLogo()"><a href="<?php echo $strHomeEditorLink; ?>" id="page_portal_name"><?php echo $arrPortalDetail['0']['Portal']['career_portal_name']; ?></a></span>
			</div>
		</div>
</div>
<?php
	if(isset($arrPortalThemeDetail) && is_array($arrPortalThemeDetail) && (count($arrPortalThemeDetail)>0))
	{
		$strThemeHeaderImagePath = Router::url('/', true)."img/theme/default/img/".$arrPortalThemeDetail[0]['theme']['theme_top_banner_image'];
	}
?>
<!--Start Header -->
<!--<div id="header-candy">
	<img src="<?php echo $strThemeHeaderImagePath; ?>" alt="Top Header Image" />
</div>-->
<!--Start content Part -->
<div style="clear:both;">
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->Session->flash('auth'); ?>
	<?php echo $this->fetch('content'); ?>
	<br class="clear"/>
</div>

<!--Start footer -->
<div id="footer">
	<div class="wrapper">
		<ul>
			<li>Jobs</li>
			<li><a href="javascript:void(0);">Latest Jobs</a></li>
			<!--<li><a href="javascript:void(0);">Database Manage  </a></li>
			<li><a href="javascript:void(0);">Responses Buy </a></li>
			<li><a href="javascript:void(0);">Online Report A </a></li>
			<li><a href="javascript:void(0);">Contact Us FAQs  </a></li>
			<li><a href="javascript:void(0);">With Us Site Map  </a></li>-->
		</ul>
		<ul>
			<li>Resources</li>
			<li><a href="javascript:void(0);">E-Learning</a></li>
			<!--<li><a href="javascript:void(0);">Database Manage  </a></li>
			<li><a href="javascript:void(0);">Responses Buy </a></li>
			<li><a href="javascript:void(0);">Online Report A </a></li>
			<li><a href="javascript:void(0);">Contact Us FAQs  </a></li>
			<li><a href="javascript:void(0);">With Us Site Map  </a></li>-->
		</ul>
		<ul>
			<li>User</li>
			<?php
				if($logged_in)
				{
					?>
						<li><a href="javascript:void(0);">User Profile</a></li>
					<?php
				}
				else
				{
					?>
						<li><?php echo $this->Html->link("Login",array('controller'=>'portal','action' => 'login',$arrPortalDetail[0]['Portal']['career_portal_id']),$strMenuLoginSelectedText); ?></li>
					<?php
				}
			?>
			<!--<li><a href="javascript:void(0);">Contact Us</a></li>
			<li><a href="javascript:void(0);">Database Manage  </a></li>
			<li><a href="javascript:void(0);">Responses Buy </a></li>
			<li><a href="javascript:void(0);">Online Report A </a></li>
			<li><a href="javascript:void(0);">Contact Us FAQs  </a></li>
			<li><a href="javascript:void(0);">With Us Site Map  </a></li>-->
		</ul>
	</div>
</div>


<div class="copyright">
<span>All rights reserved © 2013 Ltd.</span>
</div>
<?php echo $this->element('sql_dump'); ?>
<?php echo $this->Html->script('jquery/jquery.form'); ?>
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