<?php //error_reporting( E_ERROR );
error_reporting(E_ALL && ~E_NOTICE);

if($_SERVER['SERVER_NAME'] == "localhost")
{	
	$strDatabaseName = 'hc';
	$strDatabaseHost = 'localhost';
	$strDatabaseUser = 'root';
	$strDatabaseUserPassword = '';
}
else
{
	$strDatabaseName = 'hc';
	$strDatabaseHost = 'localhost';
	$strDatabaseUser = 'root';
	$strDatabaseUserPassword = '';
}


if(isset($_REQUEST['portid']))
{
	//echo "----".$_REQUEST['portid'];
	
	/*$intLoginToken = $_REQUEST['token'];
	$intLoggPortalId = "";
	$dbCon = mysql_connect($strDatabaseHost,$strDatabaseUser,$strDatabaseUserPassword);
	$strSelectDb = mysql_select_db($strDatabaseName,$dbCon);

	$strQuery = " SELECT * FROM current_login_access_hc_jb WHERE login_token='".$intLoginToken."' AND token_valid='1'";
	$strQueryRes = mysql_query($strQuery);
	$intRows = mysql_num_rows($strQueryRes);
	if($intRows)
	{
		$arrLogInDetails = mysql_fetch_array($strQueryRes);
		$intLoggPortalId = $arrLogInDetails['portal_id'];
		$intSessionId = $arrLogInDetails['login_access_token'];
		session_id($intSessionId);
		$strUpdateTokenQuery = "UPDATE current_login_access_hc_jb SET token_valid = '0' WHERE login_token='".$intLoginToken."' AND token_valid !='0'";
		$strUpdateTokenQueryExe = mysql_query($strUpdateTokenQuery);
	}*/
	$strSessionVariable = "HCJPORTAL".$_REQUEST['portid'];
	$strSessionId = $_COOKIE[$strSessionVariable];
	session_name($strSessionVariable);
	session_id($strSessionId);
	$intLoggPortalId = $_REQUEST['portid'];
	//session_name($strSessionVariable);
}
session_start();
/*if(session_id())
{
	$intLoggPortalId = $_SESSION['current_portal'];
}*/
defined('DS') 			? null : define("DS", DIRECTORY_SEPARATOR);

$dir = dirname(__FILE__);
$dir = preg_split ('%[/\\\]%', $dir);
$blank = array_pop($dir);
$dir = implode('/', $dir);

defined('SITE_ROOT') 	? null : define('SITE_ROOT', $dir );

date_default_timezone_set('Asia/Kolkata');
require_once(SITE_ROOT.DS."jobberland_init.php");

if ($_SERVER['HTTPS'] == 'on') {
	$HTTP = 'https://';
} else {
	$HTTP = 'http://';
}
define ('HTTP_METHOD', $HTTP);


defined('BASE_URL') 	? null : define('BASE_URL', $HTTP. $_SERVER['HTTP_HOST'].DOC_ROOT  );

$_SESSION['BASE_URL'] = BASE_URL;
define ('SEEKERLOGINURL', $HTTP. $_SERVER['HTTP_HOST'].'/happycandidate/portal/login/'.$_REQUEST['portid']);
define ('PORTALBASEURL', $HTTP. $_SERVER['HTTP_HOST'].'/happycandidate/portal/index/');
define ('HCBASEURL', $HTTP. $_SERVER['HTTP_HOST'].'/happycandidate/');

/* new seeting */
defined('PUBLIC_PATH') 	? null : define('PUBLIC_PATH', SITE_ROOT  );

defined('LIB_PATH')		? null : define('LIB_PATH', PUBLIC_PATH . DS . 'libs');

/*** PUBLIC */
defined('LAYOUT_PATH') 	? null : define('LAYOUT_PATH', PUBLIC_PATH . DS . 'layouts');
defined('IMAGES_PATH') 	? null : define('IMAGES_PATH', PUBLIC_PATH . DS . 'images');
defined('COM_IMAGES_PATH') 	? null : define('COM_IMAGES_PATH', IMAGES_PATH .DS.'company_logo');
defined('STYLE_PATH') 	? null : define('STYLE_PATH', PUBLIC_PATH . DS . 'stylesheet');
defined('JAVA_PATH') 	? null : define('JAVA_PATH', PUBLIC_PATH . DS . 'javascript');
defined('LANGUAGE') 	? null : define('LANGUAGE', PUBLIC_PATH . DS . 'languages');

defined('PLUGIN_PATH') 	? null : define('PLUGIN_PATH', PUBLIC_PATH . DS . 'plugins');

/** Employer **/
defined('CLINT_LAYOUT_PATH') 	? null : define('CLINT_LAYOUT_PATH', PUBLIC_PATH .DS. 'employer'.DS.'layouts');
defined('CLINT_DIR') 			? null : define( 'CLINT_DIR', PUBLIC_PATH .DS. 'employer' );

/** admin **/
defined('ADMIN_LAYOUT_PATH') 	? null : define('ADMIN_LAYOUT_PATH', PUBLIC_PATH .DS. 'admin'.DS.'layouts');
defined('ADMIN_DIR') 			? null : define( 'ADMIN_DIR', PUBLIC_PATH .DS. 'admin' );

define('CAKESALTVALUE',"ABCD93b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi");

/** template */
define( 'TEMPLATE_DIR', PUBLIC_PATH . DS.'templates' );
define( 'TEMPLATE_C_DIR', PUBLIC_PATH . DS . 'templates_c' );
define( 'SMARTY_DIR', LIB_PATH . DS . 'Smarty' . DS );
define( 'CACHE_DIR', PUBLIC_PATH . DS . 'cache' );
//define ("SMARTY_CORE_DIR", SMARTY_DIR . 'core/');

define('HCJQUERYPATH',HTTP_METHOD. $_SERVER['HTTP_HOST']. "/happycandidate/js/jquery/");
define('HCJSPATH',HTTP_METHOD. $_SERVER['HTTP_HOST']. "/happycandidate/js/");
define('HCJQUERYCSSPATH',HTTP_METHOD. $_SERVER['HTTP_HOST']. "/happycandidate/css/");


require_once(LIB_PATH.DS."PHPMailer".DS."class.phpmailer.php");
require_once(LIB_PATH.DS."config.php");
require_once (LIB_PATH.DS."class.session.php");
require_once SMARTY_DIR . 'Smarty.class.php';
/***/
require_once (LIB_PATH.DS."class.database.php");
require_once (LIB_PATH.DS."class.databaseobject.php");

global $smarty;
$_SESSION['smarty'] =  $smarty = new Smarty;
require_once (LIB_PATH.DS."class.setting.php");
define('skin_images_path', DOC_ROOT . "templates/" . TEMPLATE . "/images/" );
require_once (LIB_PATH.DS."functions.php");

define("GET_LANG", "english/");
require_once(LANGUAGE.DS.GET_LANG."lang_main.php");
require_once(LANGUAGE.DS.GET_LANG."lang_main_emp.php");

require_once (LIB_PATH.DS."class.pagination.php");

require_once (LIB_PATH.DS."class.admin.php");
require_once (LIB_PATH.DS."class.job.php");
require_once (LIB_PATH.DS."class.category.php");
require_once (LIB_PATH.DS."class.job2status.php");
require_once (LIB_PATH.DS."class.job2type.php");
require_once (LIB_PATH.DS."class.jobcategory.php");

require_once (LIB_PATH.DS."class.jobhistory.php");
require_once (LIB_PATH.DS."class.jobstatus.php");
require_once (LIB_PATH.DS."class.jobtype.php");

require_once (LIB_PATH.DS."class.careerdegree.php");
require_once (LIB_PATH.DS."class.covingletter.php");
require_once (LIB_PATH.DS."class.cvsetting.php");
require_once (LIB_PATH.DS."class.cvpersonalsetting.php");
require_once (LIB_PATH.DS."class.cvsummary.php");
require_once (LIB_PATH.DS."class.cveducation.php");
require_once (LIB_PATH.DS."class.cvexperience.php");
require_once (LIB_PATH.DS."class.cvcontracts.php");
require_once (LIB_PATH.DS."class.cvawards.php");
require_once (LIB_PATH.DS."class.cvcompetancies.php");
require_once (LIB_PATH.DS."class.cvexperiencepositions.php");
//require_once (LIB_PATH.DS."class.emailtemplate.php");
require_once (LIB_PATH.DS."class.experience.php");
require_once (LIB_PATH.DS."class.invoice.php");
require_once (LIB_PATH.DS."class.package.php");
require_once (LIB_PATH.DS."class.packageinvoice.php");
require_once (LIB_PATH.DS."class.savejob.php");
require_once (LIB_PATH.DS."class.savesearch.php");
require_once (LIB_PATH.DS."class.search.php");
require_once (LIB_PATH.DS."class.sendemail.php");

require_once (LIB_PATH.DS."class.stateprovince.php");
require_once (LIB_PATH.DS."class.city.php");
require_once (LIB_PATH.DS."class.country.php");
require_once (LIB_PATH.DS."class.county.php");

require_once (LIB_PATH.DS."class.employee.php");
require_once (LIB_PATH.DS."class.employer.php");

//plugins///
require_once (LIB_PATH.DS."class.plugin.php");
require_once (LIB_PATH.DS."class.pluginconfig.php");
//end of pulgins


define( 'TEMPLATE', TEMPLATE );

/**
$path = TEMPLATE_C_DIR . DS . TEMPLATE . DS. '_cache';
if( !file_exists ( $path ))
{
	mkdir( $path, 0777, true);
}
**/

$cv_dir = SITE_ROOT . DS . FILE_UPLOAD_DIR;
if( !file_exists ( $cv_dir )){mkdir( $cv_dir, 0777, true);}

$smarty->template_dir = TEMPLATE_DIR . DS . TEMPLATE ;
$smarty->compile_dir = TEMPLATE_C_DIR ;//. DS . TEMPLATE ;
$smarty->cache_dir = CACHE_DIR;

// set the default handler and other values for caching and faster loading
$smarty->default_template_handler_func = 'make_templateTPL';

$smarty->caching = false;
$smarty->force_compile = false;
//$smarty->register_prefilter("prefilter_getlang");
$smarty->compile_id= GET_LANG;//$_SESSION['opt_lang'];

$smarty->assign('lang',$lang);

$smarty->assign('DOC_ROOT', DOC_ROOT);
$smarty->assign('BASE_URL', BASE_URL);
$smarty->assign('HCJQUERYPATH', HCJQUERYPATH);
$smarty->assign('HCJQUERYCSSPATH', HCJQUERYCSSPATH);
$smarty->assign('HCJSPATH', HCJSPATH);

$smarty->assign('css_path', DOC_ROOT . "templates/" .  TEMPLATE );
$smarty->assign('skin_images_path', DOC_ROOT . "templates/" . TEMPLATE . "/images/");

deleteCache();
?>
