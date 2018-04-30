<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Find a Job of Your Dream</title>
	<style>
	[placeholder]:focus::-webkit-input-placeholder {
  color: transparent;
}
[placeholder]:focus::-webkit-input-placeholder {
  transition: opacity 0.5s 0.5s ease; 
  opacity: 0;
}
	</style>
	<!-- Styles -->
	<link rel="stylesheet" href="http://www.rothrsolutions.com/happycandidate/css/shr.css">

	<!-- Docs styles -->
	<link rel="stylesheet" href="http://www.rothrsolutions.com/happycandidate/css/docs.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	
	<?php 
		echo $this->Html->css('editor');
		echo $this->Html->css('stylesheet');
		echo $this->Html->css('website');
		
		echo $this->Html->script('jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/jquery.validationEngine');
		echo $this->Html->script('jquery/jquery.form');
		echo $this->Html->script('common');
		echo $this->Html->script('add_product');
		echo $this->Html->script('cart');
		
		echo $this->Html->css('jqueryvalidationplugin/validationEngine.jquery');
	?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

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

 			//OPEN-CLOSE PANEL - TRIANGLE CHANGING DEPEND OF STATUS
			$(".panel-slider-item").click(function(event) {

			    //TABs SLIDERs
			    $(this.getAttribute("href")).on('shown.bs.collapse', function(){
			        $(this.getAttribute("data-parent") + ' span.icon-indicator').css('background', 'url("<?php echo $strRouter; ?>images/job-search-tracker-overview-sort-sprite.png") top left no-repeat');
			    });
			    
			    $(this.getAttribute("href")).on('hidden.bs.collapse', function(){
			        $(this.getAttribute("data-parent") + ' span.icon-indicator').css('background', 'url("<?php echo $strRouter; ?>images/job-search-tracker-overview-sort-sprite.png") top -50px left no-repeat');
			    });
			});
			
			//TABS - CLICKING ON THE USERS
			$('.panel-body .user-title a').click(function(event) {
				$(this.getAttribute("href")).css('display', 'inline-block');
			});
		});
    </script>
<!-- start Mixpanel --><script type="text/javascript">(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===e.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.2.min.js';f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f)}})(document,window.mixpanel||[]);
mixpanel.init("d495e4f0d31056a7b3b94ab7a59e2894");</script><!-- end Mixpanel -->
  </head>
  <body>
  <script type="text/javascript">
		var appBaseU = '<?php echo Router::url('/',true);?>';
		var strBaseUrl = '<?php echo Router::url('/',true);?>';
		
		var strLmsLoginPath = '<?php echo $strLmsLoginUrl; ?>';
		var strLmsLogoutPath = '<?php echo $strLmsLogOutUrl; ?>';
		var strLmsSessionPath = '<?php echo $strLmsSessionUrl; ?>';
		
		var strJSeekerLoginUrl = '<?php echo $strJobberSeekerLoginUrl; ?>';
		var strJSeekerLogOutUrl = '<?php echo $strJobberSeekerLogOutUrl; ?>';
	</script>
	<?php
		echo $this->element('reminder_pop_up');
		 $webinar = $this->webinar->fnGetLatestWebinar();
			$webinarid= $webinar['Content']['content_id'];
	?>
<?php
	$strElearningUrl = Router::url(array('controller'=>'candidates','action'=>'elearning',$intPortalId),true);
	$strShopUrl = Router::url(array('controller'=>'portal','action'=>'shop',$intPortalId),true);
	$strWebinarUrl = Router::url(array('controller'=>'candidates','action'=>'webinardetail',$intPortalId,$webinarid),true);
	$strResourceUrl = Router::url(array('controller'=>'resources','action'=>'index',$intPortalId),true);
	$strLibraryUrl = Router::url(array('controller'=>'candidates','action'=>'library',$intPortalId),true);
	$strSettingUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPortalId,$type="setting"),true);
	$strSettingLatestJobUrl = Router::url(array('controller'=>'settings','action'=>'notifications',$intPortalId),true);
	$strSettingLatestResourceUrl = Router::url(array('controller'=>'settings','action'=>'notifications',$intPortalId),true);
	$strSettingLatestCareerAdUrl = Router::url(array('controller'=>'settings','action'=>'notifications',$intPortalId),true);
	$strSettingLatestCancelAcUrl = Router::url(array('controller'=>'settings','action'=>'notifications',$intPortalId),true);
	$strSearchUrl = Router::url(array('controller'=>'candidates','action'=>'search',$intPortalId),true);
	$strJobSearchTrackerUrl = Router::url(array('controller'=>'jstracker','action'=>'index',$intPortalId),true);
	$strJobResourceUrl = Router::url(array('controller'=>'resources','action'=>'index',$intPortalId),true);
	$strMyOrdersUrl = Router::url(array('controller'=>'myorders','action'=>'index',$intPortalId),true);
	$strPortalUrl = Router::url(array('controller'=>'portal','action'=>'index',$intPortalId),true);
	$strJobSearchProcessUrl = Router::url(array('controller'=>'jsprocess','action'=>'index',$intPortalId),true);
	$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPortalId,$type=""),true);
	$strCVUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPortalId,$type="cv"),true);
	$strCletterUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPortalId,$type="cover"),true);
	$strRefrencesUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPortalId,$type="refrence"),true);
	$strTlettersUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPortalId,$type="tletter"),true);
	$strMyOrdersUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPortalId,$type="orders"),true);
	$strVendorServiceUrl = Router::url(array('controller'=>'vendorservicehoster','action'=>'index',$intPortalId,"interviewbest"),true);
	$strFaqUrl = Router::url(array('controller'=>'faq','action'=>'index',$intPortalId),true);
	$strResumebuilderUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPortalId,'cv'),true);
	
	//echo "--".array_pop($strMenuJsTrackerSelectedText);
?>
<div class="container-fluid top-menu-container">
	<nav class="navbar navbar-default top-menu">
		<div class="col-xs-12 col-md-2">
			<a class="navbar-brand" href="#">
				<?php 
					$strRouter = Router::url('/',true);
					
				?>
				<img src="<?php echo $strRouter;?>images/search-item.png" alt="logo description"><span>HR Search</span>
			</a>
		</div>
		<div class="col-xs-12 col-md-10">
			<ul class="nav navbar-nav">
				<li>
					<a class="top-menu-item" href="<?php echo $strJobSearchProcessUrl;?>">15 Step Process</a>
				</li>
				<li>
					<a class="top-menu-item" href="<?php echo $strJobSearchTrackerUrl;?>">Job Search Tracker</a>
				</li>
				<li>
					<a class="top-menu-item" href="<?php  echo $strWebinarUrl;?>">Webinars</a>
				</li>
				<li>
					<a class="top-menu-item" href="<?php echo $strLibraryUrl;?>">Library</a>
				</li>
				<li>
					<a class="top-menu-item" href="<?php echo $strResourceUrl;?>">Resources</a>
				</li>
				<li>
					<a class="top-menu-item" href="<?php echo $strResumebuilderUrl;?>">CV or Resume Builder</a>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="<?php echo $strFaqUrl; ?>" class="right-top-menu-item icon-questionmark">&nbsp;</a>
				</li>
				
				<li class="dropdown" id="notify">
					<?php
						if($notifyCount)
						{
							?>
								<a href="#" id="notificationicon" class="dropdown-toggle right-top-menu-item icon-notification" data-toggle="dropdown">&nbsp;</a>
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
						<?php
						/*
							//print("<pre>");
							//print_r($notificationDetailnew);
							//exit;
							if(isset($notificationDetailnew))
							{
								if(is_array($notificationDetailnew) && (count($notificationDetailnew)>0))
								{
									foreach($notificationDetailnew as $notification)
									{
										//print("<pre>");
										//print_r($notification);
										//exit;
										
										if(!$notification['candidate_notifications']['notification_read'])
										{
											$strReadStyle .= "font-weight:bold;";
										}
										$strNotificationUrl = Router::url(array('controller'=>'notification','action'=>'detail',$intPortalId,$notification['candidate_notifications']['reminder_id'],$notification['candidate_notifications']['notification_id']),true);
										if($notification['candidate_notifications']['reminder_type'] == "Appointment")
										{
											$strText = $notification['reminders']['reminder_text'];
											?>
												
												<li id="notification<?php echo $notification['Notification']['notification_id'];?>" class="notification-block-bordered">
													<a href="<?php echo $strNotificationUrl; ?>" class="dropdown-item-notification">
														<p><?php echo $strText; ?>.</p>
													</a>
													<a href="#notification1" class="close-notification">
														<img src="<?php echo $strRouter; ?>images/icon-delete-notification.png" alt="">
													</a>
												</li>
											<?php
										}
										else
										{
											?>
												
												<li id="notification<?php echo $notification['Notification']['notification_id'];?>" class="notification-block-bordered">
													<a href="<?php echo $strNotificationUrl; ?>" class="dropdown-item-notification">
														<p><?php echo $notification['reminders']['reminder_text']; ?>.</p>
													</a>
													<a href="#notification1" class="close-notification">
														<img src="<?php echo $strRouter; ?>images/icon-delete-notification.png" alt="">
													</a>
												</li>
											<?php
										}
									}
								}
							}
						?>
						<!--<li id="notification2" class="notification-block-bordered">
							<a href="#" class="dropdown-item-notification">
								<p>Your application for "Sales Manager" was declined.</p>
							</a>
							<a href="#notification2" class="close-notification">
								<img src="<?php echo $strRouter; ?>images/icon-delete-notification.png" alt="">
							</a>
						</li>-->
						<li>
							<a href="#" class="right-top-menu-item">See all notifications</a>
						</li> 
						<?php 
						*/
						?>
					</ul>
				</li>
<?php 
				 $loggedid = $this->Session->read("Auth.FrontendUser_".$intPortalId.".candidate_id");
			$cartCount = $this->cart->checkUserCart($loggedid);
			
			
			
				
				if($cartCount>0)
				{
				  $cartclass = '';
				}
				else
				{
					$cartclass = '-empty';
				}?>
				<li>
					<a href="<?php echo $strShopUrl;?>" class="right-top-menu-item icon-cart<?php echo $cartclass;?>" >&nbsp;</a>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle right-top-menu-item icon-user" data-toggle="dropdown">
						Hi <?php echo $this->Session->read("Auth.FrontendUser_".$intPortalId.".candidate_first_name");?>!
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu xs-border" style="margin-top: 5px;">
						<li>
							<a class="triangle-a">
								<img class="triangle-img" src="<?php echo $strRouter; ?>images/tooltip-triangle.png" alt="">	
							</a>
						</li>
						<li>
							<a href="<?php echo $strProfileUrl; ?>" class="right-top-menu-item dropdown-item">Edit my profile</a>
						</li>
						<li>
							<a href="<?php echo $strCVUrl; ?>" class="right-top-menu-item dropdown-item">CV/Resume</a>
						</li>
						<li>
							<a href="<?php echo $strCletterUrl; ?>" class="right-top-menu-item dropdown-item">Cover Letters</a>
						</li>
						<li>
							<a href="<?php echo $strRefrencesUrl; ?>" class="right-top-menu-item dropdown-item">References</a>
						</li>
						<li>
							<a href="<?php echo $strMyOrdersUrl; ?>" class="right-top-menu-item dropdown-item">My orders</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="<?php echo $strSettingUrl; ?>" class="right-top-menu-item dropdown-item">Settings</a>
						</li>
						<li>
							<a href="javascript:void(0);" onclick="<?php echo array_pop($strMenuLogoutSelectedText); ?>" class="right-top-menu-item dropdown-item">Logout</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</div>

	<div class="container-fluid job-search-submenu">
		<div class="row">
		
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<a class="active" href="#">Find Jobs</a>
				<!--<a href="#">Saved Jobs (2)</a>-->
				<a href="<?php echo $strJobSearchTrackerUrl; ?>">Job Search Tracker</a>
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>

	<div class="container-fluid bg-lightest-grey">
			<?php  
			echo $this->Session->flash();
			if(isset($_SESSION['message']))
			{
			?> 
			<div style="padding-top:15px;">
				<?php print_R($_SESSION['message']);
				
				?>
				</div>
			<?php	
			}?>
		<div class="row">
		
			<div class="col-md-1"></div>
			<div class="col-md-10 bg-lightest-grey">
			
				<div class="col-xs-12 col-sm-12 col-md-9 layout-fix">
			
						<div class="step-slider">
						
						<?php 
						$strProfileStepUrl = Router::url(array('controller'=>'jsprocess','action'=>'step',$intPortalId,$arrfirstStepdata['content_category_parent_id'],$phaseIncompleteid),true);
						//print_R($arrfirstStepdata);
						//exit();
						$strStep = "1";
						if($stepIncompleteid >=0 && $stepIncompleteid < 6)
						{
							$strStep = "1";
						}
						
						if($stepIncompleteid >=6 && $stepIncompleteid < 11)
						{
							$strStep = "2";
						}
						
						if($stepIncompleteid >=11 && $stepIncompleteid <= 15)
						{
							$strStep = "3";
						}
						
						?>
							<span class="step-number">Step <?php echo $strStep;?> Substep <?php echo $stepIncompleteid;?></span>
							<h1 class="v2-fix"><?php echo $arrfirstStepdata['content_category_name'];?></h1>
							<div class="v2-fix"><?php echo  htmlspecialchars_decode($arrfirstStepcontent['Content']['content_intro_text']);?></div>
							
							<div class="step-slider-footer">
								<div class="progress-well-v2">
						
									<p class="col-xs-12 col-sm-12 col-md-3 col-lg-3 v2-fix">Profile completeness:</p>
										
									<div class="meter-indicator-big col-xs-12 col-sm-12 col-md-12 col-lg-6">
										<div class="meter-value-before">
											<span><?php echo round($current_user['jprocess_completeion_per']); ?>%</span>
										</div>
										
										<div class="meter-progress-after">
							  				<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo round($current_user['jprocess_completeion_per'],2); ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($current_user['jprocess_completeion_per']); ?>%">
							    				<span class="sr-only"><?php echo round($current_user['jprocess_completeion_per'],2); ?>% Complete</span>
											</div>
										</div>
									</div>
									<div class="meter-well-right col-xs-12 col-sm-12 col-md-12 col-lg-3">
										<button class="btn btn-primary btn-md" onclick="javascript:location.href='<?php echo $strProfileStepUrl; ?>'">Complete Your Process Now <span class="glyphicon glyphicon-chevron-right"></span></button>
									</div>
								</div>
							</div>
						</div>
					</div>
				
					<div class="col-xs-12 col-sm-12  col-md-3 text-right layout-fix">
						<div class="ads-container">
							<?php
							//print("<pre>");
							//sprint_r($arrResourcesDetail);
							
							
							foreach($arrResourcesDetail as $arrResource)
							{
								$arrImageArray = $arrResource['Resources']['images'];
								$strServiceImage = Router::url('/',true).$arrImageArray[0]['ResourcesImages']['product_image_path'];
								$strServiceDetailUrl = Router::url(array('controller'=>'resources','action'=>'detail',$intPortalId,$arrResource['Vendorservice']['vendor_service_id']),true);
								?>
									<a href="<?php echo $strServiceDetailUrl; ?>">
										<div class="job-search-action-button-container">
											<img src='<?php echo $strServiceImage; ?>' alt='Service Image' title='Service Image' width="272"height="64"></img>
										</div>
									</a>
								<?php
							}
						?>
							
						</div>
					</div>

					
				<div class="clear" style="clear: both"></div>	
				
				<div class="col-xs-12 col-sm-12 col-md-3 layout-fix">
					<h2 class="job-search-column-header">15 Step Process</h2>
					<div class="container-fluid sidebar-main-menu-container"> 
						<div id="mainMenu" class="sidebar-main-menu job-search-style">
						<div class="list-group panel">
					<?php
						if(is_array($arrJobSearchProcessPhases) && (count($arrJobSearchProcessPhases)>0))
						{
						/*	print("<pre>");
							print_r($arrJobSearchProcessPhases);
							exit;*/
							
							$intPhaseCnt = 0;
							$intStepCnt = 0;
							foreach($arrJobSearchProcessPhases as $arrJProcess)
							{
								$intPhaseCnt++;
								$strPhaseUrl = Router::url(array('controller'=>'jsprocess','action'=>'phase',$intPortalId,$arrJProcess['Categories']['content_category_id']),true);
								$strCompleteClass = "";
								if($arrJProcess['Categories']['step_completion_class'])
								{
									$strCompleteClass = $arrJProcess['Categories']['step_completion_class'];
								}
								
								$strMainClass = $arrJProcess['Categories']['job_process_type'];
								?>
								
								<a href="#demo<?php echo $intPhaseCnt;?>" class="list-group-item" data-toggle="collapse" data-parent="#mainMenu">
									<div class="sidebar-menuitem-content">
										<p>Phase <?php echo $intPhaseCnt; ?></p>
										<h3><?php
														if($arrJProcess['Categories']['step_completion_class'])
														{
															?>
																<s><?php echo $arrJProcess['Categories']['content_category_name'];?></s>
															<?php
														}
														else
														{
															echo $arrJProcess['Categories']['content_category_name'];
														}
													?></h3>
									</div>
									<div class="col-md-3 <?php if($strCompleteClass){ echo 'icon-complete';}?>"></div>
								</a>
								<div class="collapse" id="demo<?php echo $intPhaseCnt;?>">
								<?php
									$arrSteps = $arrJProcess['Categories']['Steps'];
									if(is_array($arrSteps) && (count($arrSteps)>0))
									{
										
										foreach($arrSteps as $arrPStep)
										{
											//print("<pre>");
											//print_r($arrPStep);
											
											$intStepCnt++;
											$strClass = $arrPStep['Categories']['job_process_type'];
											$strStepUrl = Router::url(array('controller'=>'jsprocess','action'=>'step',$intPortalId,$arrPStep['Categories']['content_category_id'],$arrJProcess['Categories']['content_category_id']),true);
											
											if($arrPStep['Categories']['iscompleted'])
											{
												$strClassElement = "class = 'active-step-icon-bg step-content-container'";
											}
											else
											{
												$strClassElement = "class = 'inactive-step-icon-bg step-content-container'";
											}
											?>
											
										
									<div <?php echo $strClassElement;?>> <!--  -->
										<div class="step-content-container-left"></div>
										<div class="step-content-container-right">
											<a href="<?php echo $strStepUrl; ?>" class="phase-step">
												<p>Step <?php echo $intStepCnt; ?></p>
												<h3><?php
																	if($arrPStep['Categories']['iscompleted'])
																	{
																		?>
																			<s><?php echo $arrPStep['Categories']['content_category_name']; ?></s>
																		<?php
																	}
																	else
																	{
																		echo $arrPStep['Categories']['content_category_name'];
																	}
																?></h3>
											</a>
										</div>
									</div>
							
								
											<?php
										}
									}
									?>
									</div>
									<?php
							}
						}
					?>
				</div>
			</div>
			</div>
			
			<img src="<?php echo Router::url('/',true);?>images/banner-1.png" class="img-responsive margened" alt="image description">
					<img src="<?php echo Router::url('/',true);?>images/banner-2.png" class="img-responsive margened" alt="image description">
					<img src="<?php echo Router::url('/',true);?>images/banner-3.png" class="img-responsive margened" alt="image description">
		</div>
				<?php
					//print("<pre>");
					//print_r($arrPortalLatestJobDetail);
					//exit;
				?>
				<div class="col-xs-12 col-sm-12 col-md-9 layout-fix">
					
						<h2 class="job-search-column-header">Featured Jobs</h2>
								<?php
									if(is_array($arrPortalLatestJobDetail) && (count($arrPortalLatestJobDetail)>0))
									{
										?>
											<div class="results-container small-v2">
										<?php
										$intFor = 1;
										foreach($arrPortalLatestJobDetail as $arrLatestJob)
										{
									//	print_R($arrLatestJob);
											if($intFor == "2")
											{
												$strClass = "class='result-element-favour'";
											}
											else
											{
												$strClass = "class='result-element'";
											}
											?>
												<div <?php echo $strClass; ?>>
													<div class="result-element-head">
														<h3><a href="<?php echo Router::url('/',true);?>portal/getjobdetail/<?php echo $intPortalId;?>/<?php echo $arrLatestJob['jobberland_job']['id']; ?>"><?php echo $arrLatestJob['jobberland_job']['job_title']; ?></a></h3>
														
														<p class="result-element-subheader"><span>Full-time</span> - <?php echo $arrLatestJob['jobberland_job']['city']; ?> , <?php echo $arrLatestJob['jobberland_job']['country']; ?> - Salary: $<?php echo $arrLatestJob['jobberland_job']['job_salary']; ?>k - Posted <?php echo date('Y M d',strtotime($arrLatestJob['jobberland_job']['created_at']));?></p>
													</div>
													<p class="result-element-description"><?php echo $arrLatestJob['jobberland_job']['job_description']; ?></p>
												</div>
											<?php
											$intFor++;
										}
										?>
										</div>
										<?php
									}
								?>
					
					
					<div class="col-md-12 hor-pad-fix">
						<div class="find-jobs-header small-v2">
							<!-- <div class="col-md-3"> -->
								<h2>Find Jobs</h2>
							<!-- </div> -->
								<div class="job-search-search-container">
									<form name="frmSearchjob" id="frmSearchjob">
										<div class="inner-addon left-addon col-md-5">
											<i class="glyphicon glyphicon-search"></i>
											<input type="text" class="form-control" id="title" name="title" required='required' placeholder="e.g. accountant, sales, programming">
										</div>
										<div class="inner-addon left-addon col-md-5">
											<i class="glyphicon glyphicon-map-marker"></i>
											<input type="text" class="form-control" name="location" id="location"  placeholder="location: e.g. New York">
										</div>
										<button type="button" onclick="return searchResult();" class="btn btn-primary btn-md-pad col-md-2">Search</button>
									<form>
								</div>
						</div>
						<!--<div class="result-header">
								<h3>256 results found</h3>
								<div class="result-filters">
									<select name="category" class="form-control" title="category">
										<option value="value1">Sort by newest</option>
										<option value="value2">Sort by oldest</option>
									</select>
									<div class="tab-controls-pagination">
										<button type="button" class="btn btn-default disabled goto-beginning"><span></span></button>
										<button type="button" class="btn btn-default disabled goto-previous"><span></span></button>
										<input type="text" value="" name="input-page-number" placeholder="1">
										<button type="button" class="btn btn-default disabled pages-counter"><span>of 3</span></button>
										<button type="button" class="btn btn-default goto-next-active"><span></span></button>
										<button type="button" class="btn btn-default goto-end-active"><span></span></button>
									</div>
								</div>
						</div>-->
						<div id="rs">
							
								<?php
								if(is_array($indeedresults) && (count($indeedresults)>0))
									{
										?>
											<div class="results-container">
										<?php
										$intFor = 1;
										foreach($indeedresults as $arrIndeedJob)
										{
											if($intFor == "2")
											{
												$strClass = "class='result-element-favour'";
											}
											else
											{
												$strClass = "class='result-element'";
											}
											?>
											
									<div <?php echo $strClass;?>>
										<div class="result-element-head">
											<h3><a target="_blank" href="http://www.indeed.com/viewjob?jk=<?php echo $arrIndeedJob['jobkey'];?>"><?php echo $arrIndeedJob['jobtitle'];?></a></h3>
											
											<p class="result-element-subheader"><span>Full-time</span> - <?php echo $arrIndeedJob['city'];?>, <?php echo $arrIndeedJob['state'];?> - <!--Salary: $50k ---> Posted <?php echo date('d M Y',strtotime($arrIndeedJob['date']));?></p>
										</div>
										<p class="result-element-description"><?php echo $arrIndeedJob['snippet'];?></p>
									</div>
									<?php
											$intFor++;
										}
										?>
									
								</div>
								<?php
								}?>
								
						</div>
						<!--<div class="tab-controls-pagination">
								<button type="button" class="btn btn-default disabled goto-beginning"><span></span></button>
								<button type="button" class="btn btn-default disabled goto-previous"><span></span></button>
								<input type="text" value="" name="input-page-number" placeholder="1">
								<button type="button" class="btn btn-default disabled pages-counter"><span>of 3</span></button>
								<button type="button" class="btn btn-default goto-next-active"><span></span></button>
								<button type="button" class="btn btn-default goto-end-active"><span></span></button>
						</div>-->
					</div>
					
					</div>
					
				</div>
			<div class="col-md-1"></div>
		</div>
	</div>
	<?php 
		echo $this->element('socialshare');
		echo $this->element('sql_dump'); 
		echo $strActionScript;
	?>
	<div class="container-fluid footer-wizard">
		<footer>
			<div class="left-nav">
				<a href="#">Privacy Policy</a>
				<a href="#">Contact Us</a>
			</div>
			<div class="right-nav">
				<p>&copy; 2015 HR Search, Inc.</p>
				<img src="<?php echo $strRouter; ?>images/app-store.png" alt="img description">
				<img src="<?php echo $strRouter; ?>images/google-play.png" alt="img description">
			</div>
		</footer>
	</div>

 <?php
 
	//echo "--".$newuserregistered;
	if($newuserregistered)
	{
		?>
			<script type="text/javascript">
				mixpanel.track("<?php echo $arrPortalDetail[0]['Portal']['career_portal_name']." Registered Users"; ?>", {
					"Portal User Registered": "Yes",
					"User Name": "<?php echo $current_user['candidate_username']; ?>",
					"User Id": "<?php echo $current_user['candidate_id']; ?>",
					"User Email": "<?php echo $current_user['candidate_email']; ?>"
				});
			</script>
		<?php
	}
?>
<script type="text/javascript">
function resendconfirmemail()
{
		var portalid = '<?php echo $intPortalId ;?>';
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"portal/resendemail/"+portalid,
			dataType: 'json',
			data:'',
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{					
					alert(data.message);
					
				}
				else
				{
					//alert("fail");
				}
			}
	});
}
function searchResult()
{
	var title = $('#title').val();
	var location = $('#location').val();
	var portalid = '<?php echo $intPortalId ;?>';
	datastr = "title="+title+"&location="+location;
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"portal/getIndeedJobSerach/"+portalid,
			dataType: 'json',
			data:datastr,
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{					
					$('#rs').html(data.html);
				}
				else
				{
					//alert("fail");
				}
			}
	});
}

$('input').on('focus', function(){
                if(!$(this).data('placeholder')){
                    $(this).data('placeholder', $(this).attr('placeholder'));
                }
                $(this).attr('placeholder', "");
            }).on('focusout', function(){
                if($(this).val()==""){
                    $(this).attr('placeholder', $(this).data('placeholder'));
                }
 });

</script>	
  </body>
</html>
