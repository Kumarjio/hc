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
			echo "Find a Job of Your Dream"; 
		?>
	</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<?php
		echo $this->Html->script('editor.js');
	?>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
    <link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css">
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
	<?php
		echo $this->Html->css('editor');
		echo $this->Html->css('stylesheet');
		//echo $this->Html->css('stylesheetnew');
		/*echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');*/
		//echo $this->Html->script('jquery/jquery');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/jquery.validationEngine');
		echo $this->Html->script('jquery/jquery.form');
		echo $this->Html->script('common');
		echo $this->Html->script('add_product');
		echo $this->Html->script('cart');
		
		echo $this->Html->css('jqueryvalidationplugin/validationEngine.jquery');
		 
		 
			
	
		
	?>
	   <script type="text/javascript">
	    function setCookie(key, value) {
            var expires = new Date();
            expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
            document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
        }

        function getCookie(key) {
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? keyValue[2] : null;
        }
    	$(document).ready(function () {
		
		 var visitedPopup = getCookie('visitedPopup');
		
		if(visitedPopup!=1)
		{
		 	$('#welcome-modal').modal('show');
			
			setCookie('visitedPopup','1');
		}
		
		
	
    		//SHOW MAIN POPUP
    		
    		var currentStep = 0;


    		//AFTER MAIN POPUP CLOSED
    		//SHOWING FIRST STEP MODAL WITH POPOVER
    		$('#welcome-modal').on('hidden.bs.modal', function () {
			    $('#profile-modal').modal('show');
			    currentStep = 1;

			    //DEFINE POSITION ON THE SCREEN DEPENDS OF TAB POSITION
			    var x = getOffset( document.getElementById('js-profile') ).left; 
				var y = getOffset( document.getElementById('js-profile') ).top;

				//ALIGN CURRENT MODAL
				$('.modal-dialog').css('position', 'absolute');
				$('.modal-dialog').css('left', x);
				$('.modal-dialog').css('top', y);

				//POPOVER INIT
				$('#popover').popover({ 
				    html : true,
				    title: function() {
				      return $("#popover-head").html();
				    },
				    content: function() {
				      return $("#popover-content").html();
				    }
				});

				//SHOW POPOVER
				$('[data-toggle="popover"]').popover('show');

				//NEXT BUTTON CLICK
				$('#popover').on('shown.bs.popover', function () {
					$("#goto-step2").click(function(event) {
						$('#profile-modal').modal('hide');
					});
				});
			});

    		//AFTER FIRST STEP POPUP CLOSED
    		//SHOWING SECOND STEP MODAL WITH POPOVER
    		$('#profile-modal').on('hidden.bs.modal', function () {
			    $('#job-search-modal').modal('show');
    			currentStep = 2;

    			//DEFINE POSITION ON THE SCREEN DEPENDS OF TAB POSITION
			    x = getOffset( document.getElementById('js-job-search') ).left; 
				y = getOffset( document.getElementById('js-job-search') ).top;

				//ALIGN CURRENT MODAL
				$('.modal-dialog').css('position', 'absolute');
				$('.modal-dialog').css('left', x);
				$('.modal-dialog').css('top', y);

				//STEP 2 POPOVER INIT
				$('#popover-step2').popover({ 
				    html : true,
				    title: function() {
				      return $("#popover-step2-head").html();
				    },
				    content: function() {
				      return $("#popover-step2-content").html();
				    }
				});

				//SHOW STEP 2 POPOVER
				$('[data-toggle="popover-step2"]').popover('show');

				//NEXT BUTTON CLICK
				$('#popover-step2').on('shown.bs.popover', function () {
					$("#goto-step3").click(function(event) {
						$('#job-search-modal').modal('hide');
					});
				});
			});

 			//GET OFFSETS
    		function getOffset( el ) {
			    var _x = 0;
			    var _y = 0;
			    while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
			        _x += el.offsetLeft - el.scrollLeft;
			        _y += el.offsetTop - el.scrollTop;
			        el = el.offsetParent;

			    }
			    return { top: _y, left: _x };
			}

			//POPOVER SHOWN AND WINDOW RESIZING
		 	$(window).resize(function() {
		 		
		 		//DEPENDS WHAT STEP WE ARE
		 		switch(currentStep) {
		 			case 1 :
		 				//CHANGE MODAL AND STEP1 POPOVER POSITIONS
		 				x = getOffset( document.getElementById('js-profile') ).left; 
						y = getOffset( document.getElementById('js-profile') ).top;

						$('.modal-dialog').css('position', 'absolute');
						$('.modal-dialog').css('left', x);
						$('.modal-dialog').css('top', y);

						$('#popover').popover({ 
						    html : true,
						    title: function() {
						      return $("#popover-head").html();
						    },
						    content: function() {
						      return $("#popover-content").html();
						    }
						});

		 				break;
		 			case 2 :
		 				//CHANGE MODAL AND STEP2 POPOVER POSITIONS
		 				x = getOffset( document.getElementById('js-job-search') ).left; 
						y = getOffset( document.getElementById('js-job-search') ).top;

						$('.modal-dialog').css('position', 'absolute');
						$('.modal-dialog').css('left', x);
						$('.modal-dialog').css('top', y);

						$('#popover-step2').popover({ 
						    html : true,
						    title: function() {
						      return $("#popover-step2-head").html();
						    },
						    content: function() {
						      return $("#popover-step2-content").html();
						    }
						});
		 				break;
		 		}
			});
			//end of resize function
			
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
			        $(this.getAttribute("data-parent") + ' span.icon-indicator').css('background', 'url("images/job-search-tracker-overview-sort-sprite.png") top left no-repeat');
			    });
			    
			    $(this.getAttribute("href")).on('hidden.bs.collapse', function(){
			        $(this.getAttribute("data-parent") + ' span.icon-indicator').css('background', 'url("images/job-search-tracker-overview-sort-sprite.png") top -50px left no-repeat');
			    });
			});
			
			//TABS - CLICKING ON THE USERS
			$('.panel-body .user-title a').click(function(event) {
				$(this.getAttribute("href")).css('display', 'inline-block');
			});

			//TAB TASKS - CLICKING ON
			$(".panel-body.tasks .user-title a").click(function(event) {
				
				$(this.getAttribute("href")).css('display', 'table-row');
				$(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
			});
		});
    </script>
<!-- start Mixpanel --><script type="text/javascript">(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===e.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.2.min.js';f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f)}})(document,window.mixpanel||[]);
mixpanel.init("d495e4f0d31056a7b3b94ab7a59e2894");</script><!-- end Mixpanel -->
</head>
<body class="login-layout">
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
	$strElearningUrl = Router::url(array('controller'=>'candidates','action'=>'elearning',$intPortalId),true);
	$strShopUrl = Router::url(array('controller'=>'portal','action'=>'shop',$intPortalId),true);
	$strWebinarUrl = Router::url(array('controller'=>'candidates','action'=>'webinars',$intPortalId),true);
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
	
	//echo "--".array_pop($strMenuJsTrackerSelectedText);
?>
<?php

						$strRouter = Router::url('/',true);
				
	?>
	<div class="container-fluid top-menu-container">
		<nav class="navbar navbar-default top-menu">
			<div class="col-xs-12 col-md-2">
				<a class="navbar-brand" href="javascript:void(0);" >
					
					<img class="img-responsive" src="<?php echo $strRouter;?>images/logo.png" alt="logo description" />	
				</a>
			</div>
			<div class="col-xs-12 col-md-10">
				<ul class="nav navbar-nav">
					<li>
						<a class="top-menu-item" href="javascript:void(0);">Wizard</a>
					</li>
					<li>
						<a class="top-menu-item " href="javascript:void(0);">Job Search</a>
					</li>
					<li>
						<a class="top-menu-item" href="javascript:void(0);">Webinars</a>
					</li>
					<li>
						<a class="top-menu-item" href="javascript:void(0);">Library</a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="#" class="right-top-menu-item icon-questionmark">&nbsp;</a>
					</li>

					<li class="dropdown" id="notify">
						<a href="#" class="dropdown-toggle right-top-menu-item icon-notification" data-toggle="dropdown">&nbsp;</a>
						<ul class="dropdown-menu notification-block">
							<li>
								<a class="triangle-a">
									<img class="triangle-img" src="<?php echo $strRouter;?>images/tooltip-triangle.png" alt=""/>	
								</a>
							</li>
							<li id="notification1" class="notification-block-bordered">
								<a href="#" class="dropdown-item-notification">
									<p>Your password was changed.</p>
								</a>
								<a href="#notification1" class="close-notification">
									<img src="<?php echo $strRouter;?>images/icon-delete-notification.png" alt="" />
								</a>
							</li>
							<li id="notification2" class="notification-block-bordered">
								<a href="#" class="dropdown-item-notification">
									<p>Your application for "Sales Manager" was declined.</p>
								</a>
								<a href="#notification2" class="close-notification">
									<img src="<?php echo $strRouter;?>images/icon-delete-notification.png" alt="" />
								</a>
							</li>
							<li>
								<a href="#" class="right-top-menu-item">See all notifications</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="<?php echo $strShopUrl; ?>" class="right-top-menu-item icon-cart-empty" >&nbsp;</a>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle right-top-menu-item icon-user" data-toggle="dropdown" href="<?php echo $strProfileUrl; ?>">

							Hi !
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu xs-border" style="margin-top: 5px;">
							<li>
								<a class="triangle-a">
									<img class="triangle-img" src="<?php echo $strRouter;?>images/tooltip-triangle.png" alt=""/>	
								</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="right-top-menu-item dropdown-item">Edit my profile</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="right-top-menu-item dropdown-item">CV/Resume</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="right-top-menu-item dropdown-item">Cover Letters</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="right-top-menu-item dropdown-item">References</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="right-top-menu-item dropdown-item">My orders</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="javascript:void(0);" class="right-top-menu-item dropdown-item">Settings</a>
							</li>
							<li>
								<a href="javascript:void(0);" onclick="<?php echo array_pop($strMenuLogoutSelectedText); ?>" class="osr13 text-blue right-top-menu-item dropdown-item">Logout</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div>

