<?php
session_start();
defined('DS') ? null : define("DS", DIRECTORY_SEPARATOR);
$dir = dirname(__FILE__);
$dir = preg_split ('%[/\\\]%', $dir);
//$blank = array_pop($dir);
$dir = implode('/', $dir);
defined('SITE_ROOT') 	? null : define('SITE_ROOT', $dir );
defined('PUBLIC_PATH') 	? null : define('PUBLIC_PATH', SITE_ROOT  );
defined('LIB_PATH')		? null : define('LIB_PATH', PUBLIC_PATH . DS . 'libs');
defined('JOBLASTFOR')	? null : define('JOBLASTFOR', '30');
//require_once (LIB_PATH.DS."class.database.php");
require_once (LIB_PATH.DS."class.databaseobject.php");
require_once (LIB_PATH.DS."class.job.php");
//require_once (LIB_PATH.DS."class.employer.php");
require_once (LIB_PATH.DS."social/fb/src/facebook.php");

$facebook = new Facebook(array(
  'appId'  => '213601475483889',
  'secret' => 'f4f1ad2b4ffd45cf3dfa939a7d843228',
));

$user = $facebook->getUser();
if ($user) 
{
  try 
  {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } 
  catch (FacebookApiException $e) 
  {
    error_log($e);
    $user = null;
  }
}
$base_url='http://'.$_SERVER['HTTP_HOST'].'/';
if ($user) 
{
	if(isset($_GET['page']))
	{
		$_SESSION['page'] = $_GET['page'];
	}
	if(isset($_GET['pageid']))
	{
		$_SESSION['pageid'] = $_GET['pageid'];
	}
	if(isset($_GET['portid']))
	{
		$_SESSION['pageidportid'] = $_GET['portid'];
	}
	
	$base_url='http://'.$_SERVER['HTTP_HOST'].'/';
	$strJobUrl = $base_url.'happycandidate/jobberland/'.$_SESSION['page'].'/'.$_SESSION['pageid'].'/?portid='.$_SESSION['pageidportid'];
	if(isset($_SESSION['page']) && isset($_SESSION['pageid']) && isset($_SESSION['pageidportid']))
	{
		$params = array('next' => $base_url.'happycandidate/jobberland/'.$_SESSION['page'].'/'.$_SESSION['pageid'].'/?portid='.$_SESSION['pageidportid']);
		$jobs = $job->find_by_id($_SESSION['pageid']);
		/*$employer = Employer::find_by_id( $jobs->fk_employer_id );
		$company_name = $employer->company_name;*/
		//$telephone = !empty($jobs->contact_telephone) ? $jobs->contact_telephone : format_lang('not_provided');
		$telephone = $jobs->contact_telephone;
	}
	
	$logoutUrl = $facebook->getLogoutUrl($params);
	if(isset($_SESSION['page']) && isset($_SESSION['pageid']) && isset($_SESSION['pageidportid']))
	{
		unset($_SESSION['page']);
		unset($_SESSION['pageid']);
		unset($_SESSION['pageidportid']);
	}
	
	
	$arrUserArray = $user_profile;
	//$arrUserArray['social_user'] = "fb";
	//$arrUserArray['logout_url'] = $logoutUrl;
	//$_SESSION['USER'] = $arrUserArray;
	
	/*print("<pre>");
	print_r($jobs);
	
	print("<pre>");
	print_r($_SESSION);
	exit;*/
	$strDescriptionText = "Job Title: ".$jobs->job_title;
	$strDescriptionText .= ", Job Description: ".strip_tags($jobs->job_description);
	$strDescriptionText .= ", Positions: ".$jobs->job_postion;
	$strDescriptionText .= ", Contact Person: ".$jobs->contact_name;
	$strDescriptionText .= ", Contact Telephone: ".$telephone;

	$ret_obj = $facebook->api('/me/feed', 'POST',array(
	'link' => 'http://www.montaukmusicfestival.com/mmfnew/',
	'message' => 'Job you Might be Interested',
	'description' => $strDescriptionText,
	//'actions' => array('name' => 'Re-share','link' =>'http://apps.facebook.com/my_app/'),
	'privacy' => array('value' => 'EVERYONE')));
	
	/*print("<pre>");
	print_r($ret_obj);
	exit;*/
	
	 //header('Location: '.$logoutUrl);
	?>
		<script type="text/javascript">
			window.close();
			window.opener.location.reload();
		</script>
	<?php
  /* print("<pre>");
  print_r($user_profile);
  exit; */
} 
else 
{
  if(isset($_GET['page']))
  {
	$_SESSION['page'] = $_GET['page'];
  }
  if(isset($_GET['pageid']))
  {
	$_SESSION['pageid'] = $_GET['pageid'];
  }
  if(isset($_GET['portid']))
  {
	$_SESSION['pageidportid'] = $_GET['portid'];
  }
  $loginUrl = $facebook->getLoginUrl();
  header('Location: '.$loginUrl);
}
?>