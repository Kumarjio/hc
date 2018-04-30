<?xml version="1.0" encoding="{lang mkey='ENCODING'}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={lang mkey='ENCODING'}" />
{strip}

<title>{$html_title}</title>
<meta name="description" content="{$meta_description}" />
<meta name="keywords" content="{$meta_keywords}" />
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
    <link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css">
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">

<link href="{$HCJQUERYCSSPATH}stylesheet.css" type="text/css" media="screen" rel="stylesheet"/>
<link href="{$HCJQUERYCSSPATH}jqueryui/themes/base/jquery.ui.all.css" type="text/css" media="screen" rel="stylesheet"/>

<link href="{$HCJQUERYCSSPATH}website.css" type="text/css" media="screen" rel="stylesheet"/>
<link href="{$HCJQUERYCSSPATH}jqueryvalidationplugin/validationEngine.jquery.css" type="text/css" media="screen" rel="stylesheet"/>

<script language="javascript" type="text/javascript" src="{$DOC_ROOT}javascript/java.js"></script>
{*<script language="javascript" type="text/javascript" src="{$DOC_ROOT}javascript/jquery.js"></script>*}
<!--<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jquery-1.6.2.min.js"></script>-->
<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jquery-1.7.2.min.js"></script>
<script language="javascript" type="text/javascript" src="{$DOC_ROOT}javascript/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$DOC_ROOT}javascript/cascade.js"></script>


<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jquery.form.js"></script>
<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jqueryui/development-bundle/ui/jquery.ui.core.js"></script>
<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jqueryui/development-bundle/ui/jquery.ui.widget.js"></script>
<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jqueryui/development-bundle/ui/jquery.ui.tabs.js"></script>
<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jqueryui/development-bundle/ui/jquery.ui.mouse.js"></script>
<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jqueryui/development-bundle/ui/jquery.ui.button.js"></script>
<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jqueryui/development-bundle/ui/jquery.ui.draggable.js"></script>
<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jqueryui/development-bundle/ui/jquery.ui.position.js"></script>
<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jqueryui/development-bundle/ui/jquery.ui.resizable.js"></script>
<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jqueryui/development-bundle/ui/jquery.ui.dialog.js"></script>
<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jqueryui/development-bundle/ui/jquery.ui.slider.js"></script>
<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jqueryui/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jqueryui/development-bundle/ui/timepicker.js"></script>


<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}validationplugin/validationengine/js/languages/jquery.validationEngine-en.js"></script>
<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}validationplugin/validationengine/js/jquery.validationEngine.js"></script>


{literal}
<style>
	/* css for timepicker */
	.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
	.ui-timepicker-div dl { text-align: left; }
	.ui-timepicker-div dl dt { float: left; clear:left; padding: 0 0 0 5px; }
	.ui-timepicker-div dl dd { margin: 0 10px 10px 45%; }
	.ui-timepicker-div td { font-size: 90%; }
	.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }

	.ui-timepicker-rtl{ direction: rtl; }
	.ui-timepicker-rtl dl { text-align: right; padding: 0 5px 0 0; }
	.ui-timepicker-rtl dl dt{ float: right; clear: right; }
	.ui-timepicker-rtl dl dd { margin: 0 45% 10px 10px; }
	
	.ui-tabs-vertical { width: 55em; }
	.ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
	.ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
	.ui-tabs-vertical .ui-tabs-nav li a { display:block; }
	.ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
	.ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 40em;}
</style>
{/literal}


<script type="text/javascript">
var loadingTag = "{lang mkey='loading'}";
var url = "{$BASE_URL}";
var jquery_cat = "{$category_selected|@count}";

{literal}
	var strGlobalDocRootUrl = '{/literal}{$DOC_ROOT}{literal}';
$(document).ready(function(){
	if( jquery_cat <= 0 ){
		$('div#jquery_search_cat').hide();
	}else{
		$('div#jquery_search_cat').show();
		$('a#jquery_select_category').hide();
		check_cat();
	}
	
  $('a#jquery_select_category').click(function() {
    $('#jquery_search_cat').show('slow');
	$('a#jquery_select_category').hide();
    return false;
  });
  


$("input[name='category[]']").click(function () {  
	return check_cat();
	//alert(length);  
 });

function check_cat(){
	var max_categories = 10
	var length = $('input:checkbox:checked').length;  
	if ( length  <= max_categories ) {
		var extra = " Max 10 categories";
		$("#jquery_selecting_cat").html( length + ( length == 1 ? " Category is" : " Categories are") + " selected. <br />"+extra );
	}else{
		var extra = " Max categories are selected";
		$("#jquery_selecting_cat").html( max_categories + " Categories are selected. <br />" + extra );
		return false;
	}	
}

  
  
  	
   // Your code here
 });
 

 function fnShowSetReminderForm()
{
	$('#postinterviewsetmessages').text('');
	$('#postinterviewsetmessages').hide();
	$( "#dialog-set-interview-reminder-form" ).dialog( "open" );
}

 
{/literal}


</script>


</head>

<body dir="{lang mkey='DIRECTION'}">



  {$rendered_page}
  
 


</div>
</body>
</html>
{/strip}