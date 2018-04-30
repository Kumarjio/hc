<?php
// Moodle configuration file
//error_reporting(E_ALL);
//ini_set ('error_reporting', E_ALL);

//ini_set ('display_errors', 1);
//ini_set ('display_startup_errors', 1);
//ini_set ('log_errors', 1);
//ini_set ('error_log', 'syslog');
ini_set ('max_execution_time', '100');

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'hc';
$CFG->dbuser    = 'root';
$CFG->dbpass    = '';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbsocket' => 0,
);

if($_SERVER['SERVER_NAME'] == "localhost")
{
	$CFG->dbtype    = 'mysqli';
	$CFG->dblibrary = 'native';
	$CFG->dbhost    = 'localhost';
	$CFG->dbname    = 'hc';
	$CFG->dbuser    = 'root';
	$CFG->dbpass    = '';
	$CFG->prefix    = 'mdl_';
	$CFG->dboptions = array (
	  'dbpersist' => 0,
	  'dbsocket' => 0,
	);
}
else
{
	$CFG->dbtype    = 'mysqli';
	$CFG->dblibrary = 'native';
	$CFG->dbhost    = 'localhost';
	$CFG->dbname    = 'hc';
	$CFG->dbuser    = 'root';
	$CFG->dbpass    = '';
	$CFG->prefix    = 'mdl_';
	$CFG->dboptions = array (
	  'dbpersist' => 0,
	  'dbsocket' => 0,
	);
}


$dbCon = mysql_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
$strSelectDb = mysql_select_db($CFG->dbname,$dbCon);

/*if(isset($_REQUEST['sesskey']))
{
	$intLoggPortalId = "";
	

	$strTok = $_REQUEST['sesskey'];
	$strQuery = "SELECT * FROM mdl_current_login_access_hc_lms WHERE lms_login_token='".$strTok."' AND token_valid='1'";
	$strQueryRes = mysql_query($strQuery);
	$intRows = mysql_num_rows($strQueryRes);
	if($intRows)
	{
		$arrLogInDetails = mysql_fetch_array($strQueryRes);
		$intSessionId = $arrLogInDetails['lms_login_session_id'];
		session_id($intSessionId);
		$strUpdateTokenQuery = "UPDATE mdl_current_login_access_hc_lms SET token_valid = '0' WHERE lms_login_token='".$strTok."' AND token_valid !='0'";
		$strUpdateTokenQueryExe = mysql_query($strUpdateTokenQuery);
	}
}*/

//echo "---".session_id();

$CFG->wwwroot   = 'http://hc.local/moodle';
$CFG->dataroot  = '/home2/rothrres/moodledata';
$CFG->admin     = 'admin';
$CFG->sessioncookiepath = '/';

$CFG->directorypermissions = 0777;

$CFG->usepaypalsandbox = 'TRUE';

//$CFG->alternateloginurl = 'http://localhost/cakeauth/users/login,http://localhost/happycandidate/admins/';
$CFG->cakesaltvalue = 'ABCD93b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi';


$CFG->currentsessiontype = "";
$CFG->currentsessionvar = "";
$CFG->currentsessionvalue = "";
if(isset($_REQUEST['usert_type_request']))
{
	if($_REQUEST['usert_type_request'])
	{
		$CFG->currentsessiontype = "_BackendUser";
		$CFG->currentsessionvar = "usert_type_request";
		$CFG->currentsessionvalue = "admin";
		
		//$_SESSION['adminbackend'] = "_BackendUser";
	}
	//$CFG->alternateloginurl = 'http://'.$_SERVER['SERVER_NAME'].'/happycandidate/';
        $CFG->alternateloginurl = 'http://'.$_SERVER['SERVER_NAME'].'/';
}
else
{
	if(isset($_REQUEST['candidate_portal_request']))
	{
		if($_REQUEST['candidate_portal_request'])
		{
			$CFG->currentsessiontype = "_FrontendUser_";
			$CFG->currentsessionvar = "candidate_portal_request";
			$CFG->currentsessionvalue = $_REQUEST['candidate_portal_request'];
			//$_SESSION['frontend'] = "_BackendUser";
		}
//$CFG->alternateloginurl = 'http://'.$_SERVER['SERVER_NAME'].'/happycandidate/portal/login/'.$_REQUEST['candidate_portal_request'];
                $CFG->alternateloginurl = 'http://'.$_SERVER['SERVER_NAME'].'/portal/login/'.$_REQUEST['candidate_portal_request'];
	}
}

require_once(dirname(__FILE__) . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
