<?php
session_start();
require 'src/facebook.php';
$facebook = new Facebook(array(
  'appId'  => '2039225979637950',
  'secret' => '9b07ab5a26e45786eb43b94a570c8418',
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
echo $base_url='http://'.$_SERVER['HTTP_HOST'].'/';exit();
if ($user) 
{
	$base_url='http://'.$_SERVER['HTTP_HOST'].'/';
	$params = array('next' => $base_url.'social/reset_user_details.php');
	$logoutUrl = $facebook->getLogoutUrl($params);
	$arrUserArray = $user_profile;
	$arrUserArray['social_user'] = "fb";
	$arrUserArray['logout_url'] = $logoutUrl;
	$_SESSION['USER'] = $arrUserArray;

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
  $loginUrl = $facebook->getLoginUrl();
  header('Location: '.$loginUrl);
}
?>