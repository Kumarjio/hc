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
if($_SERVER['SERVER_NAME'] == "localhost")
{
	define('LIAPPKEY',"jg1nraaupiah");
	define('LIAPPSECRCETKEY',"TAzjfmkkfnaSGSfd");
}
else
{
	define('LIAPPKEY',"jg1nraaupiah");
	define('LIAPPSECRCETKEY',"TAzjfmkkfnaSGSfd");
}
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
require_once(LIB_PATH.DS.'social/linkedin/linkedin.php');

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

$API_CONFIG = array(
	'appKey'       => LIAPPKEY,
	  'appSecret'    => LIAPPSECRCETKEY,
	  'callbackUrl'  => NULL 
);
if(isset($_SESSION['linkedin']['authorized']))
{
	if($_SESSION['linkedin']['authorized'] === TRUE) 
	{
		$OBJ_linkedin = new LinkedIn($API_CONFIG);
		$OBJ_linkedin->setTokenAccess($_SESSION['linkedin']['access']);
		$private = FALSE;
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
			$strDescriptionText = "Job Title: ".$jobs->job_title;
			$strDescriptionText .= ", Job Description: ".strip_tags($jobs->job_description);
			$strDescriptionText .= ", Positions: ".$jobs->job_postion;
			$strDescriptionText .= ", Contact Person: ".$jobs->contact_name;
			$strDescriptionText .= ", Contact Telephone: ".$telephone;
			
			/*if($strJobUrl)
			{
				$strDescriptionText .= "Job that might Interest you: ".$strJobUrl;
			}*/
			$content = array();
			//$content['comment'] = 'Joined '.$strPortalName;
			$content['title'] = 'Job that might Interest you: '.$jobs->job_title;
			$content['submitted-url'] = $strJobUrl;
			//$content['submitted-image-url'] = $_POST['simgurl'];
			$content['description'] = $strDescriptionText;
			// share content
			$response = $OBJ_linkedin->share('new', $content, $private);
			unset($_SESSION['linkedin']['access']);
			unset($_SESSION['linkedin']['authorized']);
			unset($_SESSION['linkedin']['request']);
			/*print("<pre>");
			print_r($response);
			exit;*/
			if($response['success'] === TRUE) 
			{
				if(isset($_SESSION['page']) && isset($_SESSION['pageid']) && isset($_SESSION['pageidportid']))
				{
					unset($_SESSION['page']);
					unset($_SESSION['pageid']);
					unset($_SESSION['pageidportid']);
				}
				
				/*$_SESSION['linkedin']['access'] = $response['linkedin'];
				$_SESSION['linkedin']['authorized'] = TRUE;*/
				//echo "HI";exit;
				?>
					<script type="text/javascript">
						window.close();
						window.opener.location.reload();
					</script>
				<?php
			}
			else
			{
				if(isset($_SESSION['page']) && isset($_SESSION['pageid']) && isset($_SESSION['pageidportid']))
				{
					unset($_SESSION['page']);
					unset($_SESSION['pageid']);
					unset($_SESSION['pageidportid']);
				}				
				//print("<pre>");
				//print_r($response);
				//echo "Failed";exit;
				//return false;
				
				?>
					<script type="text/javascript">
						window.close();
						//window.opener.location.reload();
					</script>
				<?php
			}
		}
	}
	else
	{
		// request token and access token
		$API_CONFIG['callbackUrl'] = BASE_URL.'linkedin_job_sharerer.php';
		$OBJ_linkedin = new LinkedIn($API_CONFIG);
		
		if(isset($_SESSION['linkedin']['request']))
		{
			
			//echo "----".$_REQUEST['oauth_verifier'];exit;
			$response = $OBJ_linkedin->retrieveTokenAccess($_SESSION['linkedin']['request']['oauth_token'], $_SESSION['linkedin']['request']['oauth_token_secret'], $_REQUEST['oauth_verifier']);
			if($response['success'] === TRUE) 
			{
				
				$_SESSION['linkedin']['access'] = $response['linkedin'];
				$_SESSION['linkedin']['authorized'] = TRUE;
				//$strRedirctUri = "http://".$_SERVER['HTTP_HOST'].$this->Controller->params->here;
				//$this->Controller->redirect($strRedirctUri);
				header('Location: '.BASE_URL.'linkedin_job_sharerer.php');
				exit;
			}
			else
			{
				unset($_SESSION['linkedin']);
				?>
					<script type="text/javascript">
						window.close();
						window.opener.location.reload();
					</script>
				<?php
			}
		}
		else
		{
			
			$response = $OBJ_linkedin->retrieveTokenRequest();
			if($response['success'] === TRUE)
			{
				$_SESSION['linkedin']['request'] = $response['linkedin'];
				$url = LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token'];
				//$this->Controller->redirect($url);
				header('Location: '.$url);
				exit;
			}
			else
			{
				unset($_SESSION['linkedin']);
				?>
					<script type="text/javascript">
						window.close();
						window.opener.location.reload();
					</script>
				<?php
			}
		}
	}
}
else
{
	// request token and access token
	$API_CONFIG['callbackUrl'] = BASE_URL.'linkedin_job_sharerer.php';
	$OBJ_linkedin = new LinkedIn($API_CONFIG);
	if(isset($_SESSION['linkedin']['request']))
	{
		
		//echo "----".$_REQUEST['oauth_verifier'];exit;
		$response = $OBJ_linkedin->retrieveTokenAccess($_SESSION['linkedin']['request']['oauth_token'], $_SESSION['linkedin']['request']['oauth_token_secret'], $_REQUEST['oauth_verifier']);
		if($response['success'] === TRUE) 
		{
			
			$_SESSION['linkedin']['access'] = $response['linkedin'];
			$_SESSION['linkedin']['authorized'] = TRUE;
			//$strRedirctUri = "http://".$_SERVER['HTTP_HOST'].$this->Controller->params->here;
			//$this->Controller->redirect($strRedirctUri);
			header('Location: '.BASE_URL.'linkedin_job_sharerer.php');
			exit;
		}
		else
		{
			unset($_SESSION['linkedin']);
			?>
				<script type="text/javascript">
					window.close();
					window.opener.location.reload();
				</script>
			<?php
		}
	}
	else
	{
		$response = $OBJ_linkedin->retrieveTokenRequest();
		if($response['success'] === TRUE)
		{
			$_SESSION['linkedin']['request'] = $response['linkedin'];
			$url = LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token'];
			//$this->Controller->redirect($url);
			header('Location: '.$url);
			exit;
		}
		else
		{
			unset($_SESSION['linkedin']);
			?>
				<script type="text/javascript">
					window.close();
					window.opener.location.reload();
				</script>
			<?php
		}
	}
}