<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */
/* Load required lib files. */
//error_reporting(E_ALL && ~E_NOTICE);
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
require_once(SITE_ROOT.DS."jobberland_init.php");
require_once (LIB_PATH.DS."class.databaseobject.php");
require_once (LIB_PATH.DS."class.job.php");
/*if ($_SERVER['HTTPS'] == 'on') {
	$HTTP = 'https://';
} else {
	$HTTP = 'http://';
}*/
//define ('HTTP_METHOD', $HTTP);
define ('HTTP_METHOD', "http://");
defined('BASE_URL') 	? null : define('BASE_URL', "http://". $_SERVER['HTTP_HOST'].DOC_ROOT  );
require_once(LIB_PATH.DS.'social/twitter/twitteroauth/twitteroauth.php');
require_once(LIB_PATH.DS.'social/twitter/config.php');

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

/* If access tokens are not available redirect to connect page. */
if(empty($_SESSION['access_token']) && empty($_SESSION['oauth_token']) && empty($_SESSION['oauth_token_secret'])) 
{
	//header('Location: '.BASE_URL.'libs/social/twitter/clearsessions.php');
	unset($_SESSION['access_token']);
	unset($_SESSION['access_token']['oauth_token']);
	unset($_SESSION['access_token']['oauth_token_secret']);
	
	if (CONSUMER_KEY === '' || CONSUMER_SECRET === '' || CONSUMER_KEY === 'CONSUMER_KEY_HERE' || CONSUMER_SECRET === 'CONSUMER_SECRET_HERE') 
	{
	  echo 'You need a consumer key and secret to test the sample code. Get one from <a href="https://dev.twitter.com/apps">dev.twitter.com/apps</a>';
	  exit;
	}
	
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	/*print('<pre>');
	print_r($connection);exit;*/
	/* Get temporary credentials. */
	$request_token = $connection->getRequestToken(BASE_URL.'twitter_job_sharerer.php');
	/* Save temporary credentials to session. */
	$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	switch ($connection->http_code) {
	  case 200:
		/* Build authorize URL and redirect user to Twitter. */
		$url = $connection->getAuthorizeURL($token);
		header('Location: ' .$url);
		exit;
		//echo"<script>window.location='".$url."'</script>";
		break;
	  default:
		/* Show notification if something went wrong. */
		echo 'Could not connect to Twitter. Refresh the page or try again later.';exit;
	}
}

if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token'] && !isset($_SESSION['access_token'])) 
{
	//echo "HaasdsadsdsdI";exit;
	$_SESSION['oauth_status'] = 'oldtoken';
	unset($_SESSION['access_token']);
	unset($_SESSION['access_token']['oauth_token']);
	unset($_SESSION['access_token']['oauth_token_secret']);
	unset($_SESSION['oauth_token']);
	unset($_SESSION['oauth_token_secret']);
	
	header('Location: '.BASE_URL.'twitter_job_sharerer.php');
	exit;
}

if(isset($_SESSION['oauth_token']) && isset($_SESSION['oauth_token_secret']))
{
	if(isset($_REQUEST['oauth_verifier']))
	{
		//echo "HIasd";exit;
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
		/* Request access tokens from twitter */
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
		/* Save the access tokens. Normally these would be saved in a database for future use. */
		$_SESSION['access_token'] = $access_token;
				
		/* Remove no longer needed request tokens */
		unset($_SESSION['oauth_token']);
		unset($_SESSION['oauth_token_secret']);

		/* If HTTP response is 200 continue otherwise send to connect page to retry */
		if (200 == $connection->http_code) {
		  /* The user has been verified and the access tokens can be saved for future use */
		  $_SESSION['status'] = 'verified';
		  header('Location: '.BASE_URL.'twitter_job_sharerer.php');
		} 
		else 
		{
		  /* Save HTTP status for error dialog on connnect page.*/
		  unset($_SESSION['access_token']);
		  unset($_SESSION['access_token']['oauth_token']);
		  unset($_SESSION['access_token']['oauth_token_secret']);
		  unset($_SESSION['oauth_token']);
		  unset($_SESSION['oauth_token_secret']);
		  //echo "HI";exit;
		  header('Location: '.BASE_URL.'twitter_job_sharerer.php');
		  exit;
		}
	}
	else
	{
		unset($_SESSION['access_token']);
		unset($_SESSION['access_token']['oauth_token']);
		unset($_SESSION['access_token']['oauth_token_secret']);
		unset($_SESSION['oauth_token']);
		unset($_SESSION['oauth_token_secret']);
		header('Location: '.BASE_URL.'twitter_job_sharerer.php');
		exit;
	}
}

if(isset($_SESSION['access_token']) && isset($_SESSION['status']))
{
	//echo "HasdI";exit;
	/* Get user access tokens out of the session. */
	$access_token = $_SESSION['access_token'];

	/* Create a TwitterOauth object with consumer/user tokens. */
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

	/* print("<pre>");
	print_r($_SESSION); */

	if(isset($_SESSION['page']) && isset($_SESSION['pageid']) && isset($_SESSION['pageidportid']))
	{
		$base_url='http://'.$_SERVER['HTTP_HOST'].'/';
		$strJobUrl = $base_url.'happycandidate/jobberland/'.$_SESSION['page'].'/'.$_SESSION['pageid'].'/?portid='.$_SESSION['pageidportid'];
		//$strJobUrl = "http://www.google.co.in";
		//$strJobUrl = "http://www.redorangetechnologies.com/happycandidate/portal/index/monster";
		//$strJobUrl = "http://localhost/happycandidate/portal/index/monster";
		
		$jobs = $job->find_by_id($_SESSION['pageid']);
		$telephone = $jobs->contact_telephone;
		$strDescriptionText = "";
		/*$strDescriptionText = "Job Title: ".$jobs->job_title;
		$strDescriptionText .= ", Job Description: ".strip_tags($jobs->job_description);
		$strDescriptionText .= ", Positions: ".$jobs->job_postion;
		$strDescriptionText .= ", Contact Person: ".$jobs->contact_name;
		$strDescriptionText .= ", Contact Telephone: ".$telephone;*/
		
		if($strJobUrl)
		{
			$strDescriptionText .= "Job that might Interest you: ".$strJobUrl;
		}
	}
	//echo $strDescriptionText;exit;
	$arrPostResult = $connection->post('statuses/update', array('status' => $strDescriptionText));
	$arrPostResult = json_encode($arrPostResult);
	$arrPostResult = json_decode($arrPostResult,true);
	if(is_array($arrPostResult) && count($arrPostResult)>0)
	{
		?>
			<script type="text/javascript">
				window.close();
				window.opener.location.reload();
			</script>
		<?php
	}
	
	/* If method is set change API call made. Test is called by default. */
	//$content = $connection->get('account/verify_credentials');


	/* Some example calls */
	//$connection->get('users/show', array('screen_name' => 'abraham'));
	//$connection->post('statuses/update', array('status' => date(DATE_RFC822)));
	//$connection->post('statuses/destroy', array('id' => 5437877770));
	//$connection->post('friendships/create', array('id' => 9436992));
	//$connection->post('friendships/destroy', array('id' => 9436992));

	/* Include HTML to display on the page */
}