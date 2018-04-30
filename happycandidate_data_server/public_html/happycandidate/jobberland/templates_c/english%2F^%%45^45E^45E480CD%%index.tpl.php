<?php /* Smarty version 2.6.26, created on 2017-06-27 16:01:20
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'index.tpl', 2, false),array('modifier', 'count', 'index.tpl', 82, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="<?php echo smarty_function_lang(array('mkey' => 'ENCODING'), $this);?>
"<?php echo '?>'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo smarty_function_lang(array('mkey' => 'ENCODING'), $this);?>
" />
<?php echo '<title>'; ?><?php echo $this->_tpl_vars['html_title']; ?><?php echo '</title><meta name="description" content="'; ?><?php echo $this->_tpl_vars['meta_description']; ?><?php echo '" /><meta name="keywords" content="'; ?><?php echo $this->_tpl_vars['meta_keywords']; ?><?php echo '" /><link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script><script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script><script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script><script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script><link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css"><link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet"><link href="'; ?><?php echo $this->_tpl_vars['HCJQUERYCSSPATH']; ?><?php echo 'stylesheet.css" type="text/css" media="screen" rel="stylesheet"/><link href="'; ?><?php echo $this->_tpl_vars['HCJQUERYCSSPATH']; ?><?php echo 'jqueryui/themes/base/jquery.ui.all.css" type="text/css" media="screen" rel="stylesheet"/><link href="'; ?><?php echo $this->_tpl_vars['HCJQUERYCSSPATH']; ?><?php echo 'website.css" type="text/css" media="screen" rel="stylesheet"/><link href="'; ?><?php echo $this->_tpl_vars['HCJQUERYCSSPATH']; ?><?php echo 'jqueryvalidationplugin/validationEngine.jquery.css" type="text/css" media="screen" rel="stylesheet"/><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['DOC_ROOT']; ?><?php echo 'javascript/java.js"></script>'; ?><?php echo '<!--<script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jquery-1.6.2.min.js"></script>--><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jquery-1.7.2.min.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['DOC_ROOT']; ?><?php echo 'javascript/tiny_mce/tiny_mce.js"></script><script type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['DOC_ROOT']; ?><?php echo 'javascript/cascade.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jquery.form.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jqueryui/development-bundle/ui/jquery.ui.core.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jqueryui/development-bundle/ui/jquery.ui.widget.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jqueryui/development-bundle/ui/jquery.ui.tabs.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jqueryui/development-bundle/ui/jquery.ui.mouse.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jqueryui/development-bundle/ui/jquery.ui.button.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jqueryui/development-bundle/ui/jquery.ui.draggable.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jqueryui/development-bundle/ui/jquery.ui.position.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jqueryui/development-bundle/ui/jquery.ui.resizable.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jqueryui/development-bundle/ui/jquery.ui.dialog.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jqueryui/development-bundle/ui/jquery.ui.slider.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jqueryui/development-bundle/ui/jquery.ui.datepicker.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jqueryui/development-bundle/ui/timepicker.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'validationplugin/validationengine/js/languages/jquery.validationEngine-en.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'validationplugin/validationengine/js/jquery.validationEngine.js"></script>'; ?><?php echo '
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
'; ?><?php echo '<script type="text/javascript">var loadingTag = "'; ?><?php echo smarty_function_lang(array('mkey' => 'loading'), $this);?><?php echo '";var url = "'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo '";var jquery_cat = "'; ?><?php echo count($this->_tpl_vars['category_selected']); ?><?php echo '";'; ?><?php echo '
	var strGlobalDocRootUrl = \''; ?><?php echo ''; ?><?php echo $this->_tpl_vars['DOC_ROOT']; ?><?php echo ''; ?><?php echo '\';
$(document).ready(function(){
	if( jquery_cat <= 0 ){
		$(\'div#jquery_search_cat\').hide();
	}else{
		$(\'div#jquery_search_cat\').show();
		$(\'a#jquery_select_category\').hide();
		check_cat();
	}
	
  $(\'a#jquery_select_category\').click(function() {
    $(\'#jquery_search_cat\').show(\'slow\');
	$(\'a#jquery_select_category\').hide();
    return false;
  });
  


$("input[name=\'category[]\']").click(function () {  
	return check_cat();
	//alert(length);  
 });

function check_cat(){
	var max_categories = 10
	var length = $(\'input:checkbox:checked\').length;  
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
	$(\'#postinterviewsetmessages\').text(\'\');
	$(\'#postinterviewsetmessages\').hide();
	$( "#dialog-set-interview-reminder-form" ).dialog( "open" );
}

 
'; ?><?php echo '</script></head><body dir="'; ?><?php echo smarty_function_lang(array('mkey' => 'DIRECTION'), $this);?><?php echo '">'; ?><?php echo $this->_tpl_vars['rendered_page']; ?><?php echo '</div></body></html>'; ?>