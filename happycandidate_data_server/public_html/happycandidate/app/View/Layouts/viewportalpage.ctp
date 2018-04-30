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
		echo $this->Html->css('hometheme/style');
		echo $this->Html->css('hometheme/reset');
		echo $this->Html->css('hometheme/slider');
		echo $this->Html->css('hometheme/jquery.jscrollpane');
		echo $this->Html->css('jqueryui/themes/base/jquery.ui.all');
		echo $this->Html->css('jqueryui/themes/base/demos');

		

		/*echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');*/
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
<body>
	<script type="text/javascript">
		var appBaseU = '<?php echo Router::url('/',true);?>';
		
		var strLmsLoginPath = '<?php echo $strLmsLoginUrl; ?>';
		var strLmsLogoutPath = '<?php echo $strLmsLogOutUrl; ?>';
		var strLmsSessionPath = '<?php echo $strLmsSessionUrl; ?>';
	</script>
	<input type="hidden" name="portalurl" id="portalurl" value="<?php echo Router::url('/', true);?>" />
	<?php
		echo $this->element("preview_page_add");
	?>
	
	<?php
		echo $this->element("preview_menu_manage");
	?>
	
	<?php
		echo $this->element("preview_logo_manage");
	?>
	
	<?php
		echo $this->element("banner_image_manage");
	?>
	
	<?php
		echo $this->element("preview_page_manage");
	?>
	
	<?php
		echo $this->element("widgets_manage_page");
	?>
	
	
	<?php
		echo $this->element("preview_copyright_manage");
	?>
	
	
	
	<!--Start top Nav 1-->
	<div id="top-nav">
		<div class="wrapper">
			<span class="nav-1 fright"><?php echo $this->Html->link("Register",'javascript:void(0);'); ?>	    |	<?php echo $this->Html->link("Login",'javascript:void(0);'); ?></span>
		</div>
	</div>
	<?php
		$strHomeEditorLink = Router::url(array('controller'=>'privatelabelsites','action'=>'view',$arrPortalDetail['0']['Portal']['career_portal_id']));
	?>
	<!--Start main Nav 2-->
	<div class="main-nav-panel padding-top-5">
			<div class="wrapper" id="logonamemenu">
				<span>
					<a href="<?php echo $strHomeEditorLink; ?>"><?php echo $this->Html->image('/userdata/portal/'.$arrPortalDetail['0']['Portal']['career_portal_logo'], array('id'=>'portal_header_logo','alt' => $arrPortalDetail['0']['Portal']['career_portal_name'],'height'=>'80','width'=>'165')); ?></a>
				</span>
				<ul id='menusection'>
				<?php
					if(is_array($arrPortalMenuDetail) && (count($arrPortalMenuDetail)>0))
					{
						?>
							<?php
								foreach($arrPortalMenuDetail as $arrMenu)
								{
									$strPagePortalId = base64_encode($arrMenu['TopMenu']['career_portal_menu_page_id']."_".$arrMenu['TopMenu']['career_portal_id']);
									if($arrMenu['TopMenu']['career_portal_menu_name'] == "Home")
									{
										$strMenuLink = $strHomeEditorLink;
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
							
						<?php
					}
					else
					{
					}
				?>
				</ul>
				<!--<ul>
					<li><a href="javascript:void(0);" class="home-icon">Home</a></li>
					<li><a href="javascript:void(0);">About us</a></li>
					<li><a href="javascript:void(0);">Jobs</a></li>
					<li><a href="javascript:void(0);">Contact us</a></li>
				</ul>-->
				<div>
					<span style="margin-left:5%;"><a href="<?php echo $strHomeEditorLink;?>" id="page_portal_name"><?php echo $arrPortalDetail['0']['Portal']['career_portal_name']; ?></a></span>
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
		<span><img src="<?php echo $strThemeHeaderImagePath; ?>" alt="Top Header Image" id="banner_image" /></span>
	</div>-->
	<div>&nbsp;</div>
	<?php
		if($this->params['controller'] == 'privatelabelsites' && $this->params['action'] == 'view')
		{
			?>
				<input type='hidden' name='typeeditor' id='typeeditor' value='theme' />
			<?php
		}
		else
		{
			if($this->params['controller'] == 'privatelabelsites' && $this->params['action'] == 'viewpage')
			{
				?>
					<input type='hidden' name='typeeditor' id='typeeditor' value='page' />
				<?php
			}
		}
	?>
	<div id="widgets" onmouseover="fnApplyEditorHoverCss(this);fnShowWidgetSetter();" onmouseout="fnRemoveEditorHoverCss(this);fnHideWidgetSetter();">
		&nbsp;
		<span style="font-size: 10px;position: relative;top:0px;display:none;cursor:pointer;vertical-align:top;" id="widgets_links" onclick="fnShowWidgetsSection()">Manage Widgets</span>
		<?php
			/*print("<pre>");
			print_r($arrPortalWidgets);*/
			if(isset($arrPortalWidgets) && (is_array($arrPortalWidgets)) && (count($arrPortalWidgets)>0))
			{
				foreach($arrPortalWidgets as $arrWidgetDetail)
				{
					if($arrWidgetDetail['PW']['career_portal_id'] == $arrPortalDetail[0]['Portal']['career_portal_id'] && $arrWidgetDetail['PW']['career_portal_page_id'] == $arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'])
					{
						if($arrWidgetDetail['W']['widget_name'] == "Job Search")
						{
							echo $this->element("job_search",array('widget_id'=>$arrWidgetDetail['W']['widget_id'],'theme_id'=>$arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'],'portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id']));
						}
						
						if($arrWidgetDetail['W']['widget_name'] == "Latest Jobs")
						{
							echo $this->element("latest_jobs",array('widget_id'=>$arrWidgetDetail['W']['widget_id'],'theme_id'=>$arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'],'portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id']));
						}
						
						if($arrWidgetDetail['W']['widget_name'] == "Highlighted Jobs")
						{
							echo $this->element("highlighted_jobs",array('widget_id'=>$arrWidgetDetail['W']['widget_id'],'theme_id'=>$arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'],'portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id']));
						}
						
						if($arrWidgetDetail['W']['widget_name'] == "Contact Us")
						{
							echo $this->element("portal_contact_us",array('widget_id'=>$arrWidgetDetail['W']['widget_id'],'theme_id'=>$arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'],'portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id']));
						}
					}
					else
					{
						if($arrWidgetDetail['W']['widget_name'] == "Job Search")
						{
							echo $this->element("job_search",array('strHidden'=>'1','widget_id'=>$arrWidgetDetail['W']['widget_id'],'theme_id'=>$arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'],'portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id']));
						}
						
						if($arrWidgetDetail['W']['widget_name'] == "Latest Jobs")
						{
							echo $this->element("latest_jobs",array('strHidden'=>'1','widget_id'=>$arrWidgetDetail['W']['widget_id'],'theme_id'=>$arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'],'portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id']));
						}
						
						if($arrWidgetDetail['W']['widget_name'] == "Highlighted Jobs")
						{
							echo $this->element("highlighted_jobs",array('strHidden'=>'1','widget_id'=>$arrWidgetDetail['W']['widget_id'],'theme_id'=>$arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'],'portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id']));
						}
						
						if($arrWidgetDetail['W']['widget_name'] == "Contact Us")
						{
							echo $this->element("portal_contact_us",array('strHidden'=>'1','widget_id'=>$arrWidgetDetail['W']['widget_id'],'theme_id'=>$arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'],'portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id']));
						}
					}
				}
			}
		?>
	</div>
	<div>&nbsp;</div>
	<!--Start content Part -->
	<div class="content-info" onmouseover="fnApplyEditorHoverCss(this);fnShowEditPage();" onmouseout="fnRemoveEditorHoverCss(this);fnHideEditPage()">
		<div class="wrapper" style="color:#FFFFFF;">
			<span style="font-size: 10px; float: right; position: relative;top:0px;display:none;cursor:pointer;" id="pageedit" onclick="fnShowPageEditSection()">Manage</span>
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth'); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
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


	<div style="clear:both;" class="copyright">
	<span id="footertext"><?php echo $arrPortalDetail['0']['Portal']['career_portal_footer_text'];?></span>
	</div>
	<?php echo $this->element('sql_dump'); ?>
	<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>-->
	
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
	
	<?php
		echo $this->Html->script('tinymce/tiny_mce');
	?>
	<script type="text/javascript">
		$('#ca-container').contentcarousel();
		$('#ca-containernew').contentcarousel();
	</script>
	
	<script type="text/javascript">
		$(document).ready(function () {
				$('#widgets').sortable({
				update: function(event, ui) {
					var idsInOrder = $('#widgets').sortable("toArray");
					var result = fnUpdateWidgetOrder(idsInOrder);
				}
			
			});
		});
	</script>
</body>
</html>