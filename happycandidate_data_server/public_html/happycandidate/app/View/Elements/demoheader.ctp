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
	  <script> 
		$(document).ready(function(){
			$("#flip").click(function(){
				$("#panel").slideToggle("slow");
				if($(this).hasClass('expanded'))
		        {
		            $(this).addClass('collapsed').removeClass('expanded');
		        }
		        else
		        {
		            $(this).addClass('expanded').removeClass('collapsed');
		        }
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