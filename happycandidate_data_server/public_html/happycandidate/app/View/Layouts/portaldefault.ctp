<!DOCTYPE html>
<html>
<head>sdaf
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php 
			echo "Happy Candidates"; 
		?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('menu');
		echo $this->Html->css('jqueryvalidationplugin/validationEngine.jquery');
		echo $this->Html->css('hometheme/reset');
		echo $this->Html->css('hometheme/style');
		echo $this->Html->css('hometheme/slider');
		echo $this->Html->css('hometheme/jquery.jscrollpane');
		//echo $this->Html->css('jqueryui/themes/base/jquery.ui.all');
		//echo $this->Html->css('jqueryui/themes/base/demos');
		echo $this->Html->css('jqueryui/themes/base/jquery.ui.datepicker');
		echo $this->Html->css('jqueryui/themes/base/jquery-ui');
		

		

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		//echo $this->Html->script('jquery/jquery');
		echo $this->Html->script('jquery/jquery-1.7.2.min');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/jquery.validationEngine');
		echo $this->Html->script('common');
		echo $this->Html->script('add_product');
		echo $this->Html->script('cart');
		
		echo $this->Html->script('jquery/jquery-ui.min');
		echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.core');
		echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.widget');	
		echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.accordion');	
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
	
	#header-candy img {
		display:none;
	}
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
	
	#ui-id-1 { font-size: 62.5%; }
	
</style>
<!-- start Mixpanel --><script type="text/javascript">(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===e.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.2.min.js';f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f)}})(document,window.mixpanel||[]);
mixpanel.init("d495e4f0d31056a7b3b94ab7a59e2894");</script><!-- end Mixpanel -->
</head>
<body>
	
	<script type="text/javascript">
		var appBaseU = '<?php echo Router::url('/',true);?>';
		var strBaseUrl = appBaseU;
		
		var strLmsLoginPath = '<?php echo $strLmsLoginUrl; ?>';
		var strLmsLogoutPath = '<?php echo $strLmsLogOutUrl; ?>';
		var strLmsSessionPath = '<?php echo $strLmsSessionUrl; ?>';
		
		var strJSeekerLoginUrl = '<?php echo $strJobberSeekerLoginUrl; ?>';
		var strJSeekerLogOutUrl = '<?php echo $strJobberSeekerLogOutUrl; ?>';
		var appBaseU = '<?php echo Router::url('/',true);?>';
		
	</script>
<?php
	echo $this->element('reminder_pop_up');
	
?>
<!--Start top Nav 1-->
<div id="top-nav">
	<div class="wrapper">
	
<?php
 $webinar = $this->webinar->fnGetLatestWebinar();
			$webinarid= $webinar['Content']['content_id'];
	$strElearningUrl = Router::url(array('controller'=>'candidates','action'=>'elearning',$intPortalId),true);
	$strShopUrl = Router::url(array('controller'=>'portal','action'=>'shop',$intPortalId),true);
	$strWebinarUrl = Router::url(array('controller'=>'candidates','action'=>'webinars',$intPortalId),true);
	$strLibraryUrl = Router::url(array('controller'=>'candidates','action'=>'library',$intPortalId),true);
	$strSettingUrl = Router::url(array('controller'=>'settings','action'=>'notifications',$intPortalId),true);
	$strSettingLatestJobUrl = Router::url(array('controller'=>'settings','action'=>'notifications',$intPortalId),true);
	$strSettingLatestResourceUrl = Router::url(array('controller'=>'settings','action'=>'notifications',$intPortalId),true);
	$strSettingLatestCareerAdUrl = Router::url(array('controller'=>'settings','action'=>'notifications',$intPortalId),true);
	$strSettingLatestCancelAcUrl = Router::url(array('controller'=>'settings','action'=>'notifications',$intPortalId),true);
	$strSearchUrl = Router::url(array('controller'=>'candidates','action'=>'search',$intPortalId),true);
	$strJobSearchTrackerUrl = Router::url(array('controller'=>'jstracker','action'=>'index',$intPortalId),true);
	$strJobResourceUrl = Router::url(array('controller'=>'resources','action'=>'index',$intPortalId),true);
	$strMyOrdersUrl = Router::url(array('controller'=>'myorders','action'=>'index',$intPortalId),true);
	
	if($logged_in)
	{
		$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$intPortalId),true);
		$strContactUsLink = Router::url(array('controller'=>'portal','action'=>'page',$intPortalId,15),true);
		?>
		<?php
			if(round($this->Session->read('Auth.FrontendUser_'.$intPortalId.'.jprocess_completeion_per')))
			{
				?>
					<span class="nav-1 fleft">My Job Search is <strong style="font-weight:bold;"><?php echo number_format((float)$this->Session->read('Auth.FrontendUser_'.$intPortalId.'.jprocess_completeion_per'), 2, '.', '');?> %</strong> Completed</span>
				<?php
			}
		?>
		<span class="nav-1 fright">
			<ul id="menu">
					<?php
					if(isset($notificationDetail))
					{
						if(is_array($notificationDetail) && (count($notificationDetail)>0))
						{
								$strNotificationIndexUrl = Router::url(array('controller'=>'notification','action'=>'index',$intPortalId),true);
							?>
								<li id="noti_Container"><?php echo $this->Html->link("Notifications",$strNotificationIndexUrl,array('target'=>"_blank")); ?>
								<?php
									if($notifyCount)
									{
										?>
											<span class="noti_bubble"><?php echo $notifyCount; ?></span>
										<?php
									}
								?>
								
									<ul class="sub-menu">
										<?php
											foreach($notificationDetail as $notification)
											{
												$strReadStyle = "style=width:400px;";
												if(!$notification['candidate_notifications']['notification_read'])
												{
													$strReadStyle .= "font-weight:bold;";
												}
												
												$strNotificationUrl = Router::url(array('controller'=>'notification','action'=>'detail',$intPortalId,$notification['candidate_notifications']['reminder_id'],$notification['candidate_notifications']['notification_id']),true);
												?>
													<li><a <?php echo $strReadStyle;?> target="_blank" href="<?php echo $strNotificationUrl; ?>"><?php echo $notification['events']['event_description']; ?></a></li>
												<?php
											}
										?>
										<li><span style="text-align:center;"><a <?php echo $strReadStyle;?> target="_blank" href="<?php echo $strNotificationIndexUrl; ?>">See All</a></span></li>
									</ul>
								</li>
							<?php
						}
					}
				?>
				<li><?php echo $this->Html->link("My Profile",$strProfileDetailUrl,$strMenuProfileSelectedText); ?>
					<ul class="sub-menu">
						<li><a href="<?php echo $strProfileDetailUrl; ?>">My Details</a></li>
						<li><a href="<?php echo $strSearchUrl; ?>">Modify Search</a></li>
						<!--<?php
							/*if(isset($strCandidateDefaultCV))
							{
								$strDefaultCvUrl = Router::url(array('controller'=>'candidates','action'=>'defaultcv',$intPortalId),true);
								?>
									<li><a href="<?php echo $strDefaultCvUrl; ?>">My Default CV</a></li>
								<?php
							}*/
						?>-->
						<li><a href="<?php echo $strProfileCvUrl; ?>">CV/Resume</a></li>
						<li><a href="<?php echo $strProfileCLetterUrl; ?>">Cover Letters</a></li>
						<?php
							$strProfilePerformanceUrl = Router::url(array('controller'=>'profileperformance','action'=>'index',$intPortalId),true);
							$strBadgesUrl = Router::url(array('controller'=>'candidates','action'=>'badges',$intPortalId),true);
							$strReferencesUrl = Router::url(array('controller'=>'references','action'=>'index',$intPortalId),true);
							$strTLettersUrl = Router::url(array('controller'=>'Tletters','action'=>'index',$intPortalId),true);
						?>
						<!--<li><a href="<?php echo $strBadgesUrl; ?>">My Badges</a></li>
						<li><a href="<?php echo $strProfilePerformanceUrl; ?>">Profile Performance</a></li>-->
						<li><a href="<?php echo $strReferencesUrl; ?>">References</a></li>
						<li><a href="<?php echo $strTLettersUrl; ?>">Thank You Letters</a></li>
					</ul>
				</li>
				<li><?php echo $this->Html->link("Job Search Tracker",$strJobSearchTrackerUrl,$strMenuJsTrackerSelectedText); ?>
					<!--<ul class="sub-menu">
						<li><a href="javascript:void(0);">Tracking Tool</a></li>
					</ul>-->
				</li>
				<li><?php echo $this->Html->link("My Settings",$strSettingUrl,$strMenuSettingSelectedText); ?>
					<ul class="sub-menu">
						<!--<li><a href="<?php echo $strLoginDetailUrl; ?>">Change Password</a></li>-->
						<li><a href="<?php echo $strSettingLatestJobUrl."#jobn";?>">Latest Job Listing Notifications</a></li>
						<!--<li><a href="<?php echo $strSettingLatestResourceUrl."#resn" ;?>">Latest Resource Notifications</a></li>
						<li><a href="<?php echo $strSettingLatestCareerAdUrl."#caradn";?>">Career Advisor</a></li>-->
						<li><a href="<?php echo $strLoginDetailUrl; ?>">Change Password</a></li>
						<li><a href="<?php echo $strSettingLatestCancelAcUrl."#cancan";?>">Cancel Account</a></li>
					</ul>
				</li>
				<!--<li><?php echo $this->Html->link("My Jobs",$strJobUrl,$strMenuMyJobSelectedText); ?>
					<ul class="sub-menu">
						<li><a href="<?php echo $strJobUrl; ?>">My Applications</a></li>
						<li><a href="<?php echo $strSaveJobUrl; ?>">My Saved Jobs</a></li>
						<li><a href="<?php echo $strSaveSearchJobUrl; ?>">My Saved Search</a></li>
					</ul>
				</li>-->
				<li><?php echo $this->Html->link("My Orders",$strMyOrdersUrl); ?></li>
				<!--<li><?php echo $this->Html->link("My Account",'javascript:void(0);'); ?>
					<ul class="sub-menu">
						<li><a href="<?php echo $strLoginDetailUrl; ?>">Change Password</a></li>
					</ul>
				</li>-->
				<li><?php echo $this->Html->link("Resources",$strJobResourceUrl,$strMenuResourcesSelectedText); ?></li>
				<li><?php echo $this->Html->link("Contact Us",$strContactUsLink,$strMenuContactUsSelectedText); ?></li>
				<li>
					<?php 
						if(isset($_SESSION['olduser']) && $_SESSION['olduser']['user_type'] == "1")
						{
							$strLogoutUrl = Router::url(array('controller'=>'loginas','action'=>'swicthback',"3",$arrLoggedUser['candidate_id'],$strLoggedUserSessKey,$intPortalId,strtolower($arrPortalDetail[0]['Portal']['career_portal_name'])),true);
							echo $this->Html->link("Switch Back To Admin",$strLogoutUrl); 
						}
						else
						{
							echo $this->Html->link("Logout",'javascript:void(0)',$strMenuLogoutSelectedText); 
						}			
						
						//echo $this->Html->link("Logout",'javascript:void(0)',$strMenuLogoutSelectedText); 
					?>
				</li>
			</ul>
		</span>
			
		<?php
	}
	else
	{
		?>
			<span class="nav-1 fright"><?php echo $this->Html->link("Register",array('controller'=>'portal','action' => 'registration',$arrPortalDetail[0]['Portal']['career_portal_id']),$strMenuRegisterSelectedText); ?>	    |	<?php echo $this->Html->link("Login",array('controller'=>'portal','action' => 'login',$arrPortalDetail[0]['Portal']['career_portal_id']),$strMenuLoginSelectedText); ?></span>
		<?php
	}
?>
	</div>
</div>
<?php
	$strHomeEditorLink = Router::url(array('controller'=>'portal','action'=>'index',$arrPortalDetail['0']['Portal']['career_portal_name']));
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
				if($logged_in)
				{
					$strJobSearchUrl = Router::url(array('controller'=>'jsprocess','action'=>'index',$intPortalId),true);
					?>
						<ul id='menusection'>
							<li><a href="<?php echo $strHomeEditorLink;?>" class="home-icon">Home</a></li>
							<li><a href="<?php echo $strJobSearchUrl; ?>" class="home-icon">Job Search Process</a></li>
							<li><a href="<?php echo $strWebinarUrl; ?>" class="home-icon">Webinars</a></li>
							<li><a href="<?php echo $strLibraryUrl; ?>" class="home-icon">Library</a></li>
							<li><a href="<?php echo $strlatestJobUrl; ?>" class="home-icon">Job Boards</a></li>	
							<!--<li><a href="<?php echo $strElearningUrl;?>" class="home-icon">E-Learning</a></li>-->
							<li><a href="<?php echo $strShopUrl; ?>" class="home-icon">Shop</a></li>	
						</ul>
					<?php
				}
				else
				{
					if(isset($arrPortalMenuDetail))
					{
						?>					
							<ul id='menusection'>
							<?php
								foreach($arrPortalMenuDetail as $arrMenu)
								{
									$strPagePortalId = base64_encode($arrMenu['TopMenu']['career_portal_menu_page_id']."_".$arrMenu['TopMenu']['career_portal_id']);
									$intPageId = $arrMenu['TopMenu']['career_portal_menu_page_id'];
									if($arrMenu['TopMenu']['career_portal_menu_name'] == "Home")
									{
										$strMenuLink = Router::url(array('controller'=>'portal','action'=>'index',$arrPortalDetail['0']['Portal']['career_portal_name']),true);
									}
									else
									{
										$strMenuLink = Router::url(array('controller'=>'portal','action'=>'page',$intPortalId,$intPageId),true);
									}
									
									?>
									<li><a href="<?php echo $strMenuLink;?>" class="home-icon"><?php echo $arrMenu['TopMenu']['career_portal_menu_name']?></a></li>	
									<?php
								}
							?>
							</ul>
						<?php
					}
				}
			?>
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
<div>
	<div class="pagemask"></div>
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->Session->flash('auth'); ?>
	<div>&nbsp;</div>
	<?php
		//print("<pre>");
		//print_r($arrRandomQuoteDetail);
		//exit;
		if(is_array($arrRandomQuoteDetail) && (count($arrRandomQuoteDetail)>0))
		{
			//echo "HI";exit;
			
			?>
				<div>&nbsp;</div>
				<div class="wrapper">
					<div id="portal_registration">
						<h2 id="jobn" style="padding:0;margin-bottom:30px;">Quotes</h2>
						<div>
							<?php echo htmlspecialchars_decode($arrRandomQuoteDetail[0]['Content']['content']); ?>
						</div>
					</div>
				</div>
			<?php
		}
	?>
	<?php echo $this->fetch('content'); ?>
	<br class="clear"/>
</div>
<?php
	$strJsTrackerUrl = Router::url(array('controller'=>'jstracker',action=>'index',$intPortalId),true);
	$strJsProcessUrl = Router::url(array('controller'=>'jsprocess',action=>'index',$intPortalId),true);
	$strCoverLetterServices = Router::url(array('controller'=>'candidates',action=>'articledetail',$intPortalId,42),true);
	$strResumeServices = Router::url(array('controller'=>'candidates',action=>'articledetail',$intPortalId,182),true);
?>
<!--Start footer -->
<div id="footer">
	<div class="wrapper">
		<ul>
			<li>Resume Services</li>
			<li><a href="<?php echo $strCoverLetterServices; ?>">Cover Letter</a></li>
			<li><a href="<?php echo $strResumeServices; ?>">LinkedIn Update</a></li>
			<li><a href="<?php echo $strResumeServices; ?>">CV / Resume Service</a></li>
			<li><a href="<?php echo $strResumeServices; ?>">Thank You Notes</a></li>
			<li>&nbsp;</li>
			<li>&nbsp;</li>
			<!--<li><a href="<?php echo $strlatestJobUrl; ?>">Latest Jobs</a></li>-->
			<!--<li><a href="javascript:void(0);">Database Manage  </a></li>
			<li><a href="javascript:void(0);">Responses Buy </a></li>
			<li><a href="javascript:void(0);">Online Report A </a></li>
			<li><a href="javascript:void(0);">Contact Us FAQs  </a></li>
			<li><a href="javascript:void(0);">With Us Site Map  </a></li>-->
		</ul>
		<ul>
			<li>Job Search Process</li>
			<?php //$strElearningUrl = Router::url(array('controller'=>'candidates','action'=>'elearning',$intPortalId),true); ?>
			<li><a href="<?php echo $strJsProcessUrl; ?>">Job Search Process</a></li>
			<li><a href="<?php echo $strJsTrackerUrl; ?>">Job Search Tracker</a></li>
			<li>&nbsp;</li>
			<!--<li><a href="javascript:void(0);">Prepare</a></li>
			<li><a href="javascript:void(0);">Search and Connect</a></li>
			<li><a href="javascript:void(0);">Interview</a></li>-->
			<li>&nbsp;</li>
			<li>&nbsp;</li>
			<li>&nbsp;</li>
			
			<!--<li><a href="<?php echo $strElearningUrl; ?>">E-Learning</a></li>-->
			<!--<li><a href="javascript:void(0);">Database Manage  </a></li>
			<li><a href="javascript:void(0);">Responses Buy </a></li>
			<li><a href="javascript:void(0);">Online Report A </a></li>
			<li><a href="javascript:void(0);">Contact Us FAQs  </a></li>
			<li><a href="javascript:void(0);">With Us Site Map  </a></li>-->
		</ul>
		<ul>
			<li>Resources</li>
			<li><a href="javascript:void(0);">Career Counselling</a></li>
			<li><a href="javascript:void(0);">Computer Training</a></li>
			<li><a href="javascript:void(0);">Education</a></li>
			<li><a href="javascript:void(0);">IT Certification</a></li>
			<li><a href="javascript:void(0);">Resume Cards</a></li>
			<li><a href="javascript:void(0);">Trade Publications</a></li>
			<?php
				/*if($logged_in)
				{
					?>
						<!--<li><a href="<?php echo $strProfileDetailUrl; ?>">User Profile</a></li>-->
					<?php
				}
				else
				{
					?>
						<!--<li><?php echo $this->Html->link("Login",array('controller'=>'portal','action' => 'login',$arrPortalDetail[0]['Portal']['career_portal_id']),$strMenuLoginSelectedText); ?></li>-->
					<?php
				}*/
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
<?php 
	echo $this->element('sql_dump'); 
?>
<!--<script type="text/javascript">
	/*$(document).ready(function () 
	{
		fnSetSeekerCurrentPortalProfile('<?php echo $intPortalId;?>');
	
	});*/
</script>-->
<?php
	echo $strActionScript;
?>
</body>
</html>