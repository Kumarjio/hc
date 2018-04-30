<?php
App::uses('Component', 'Controller');
class FbRegisterComponent extends Component 
{
    public $components = array('Session');
	 
	public function startup(Controller $controller) {
		$this->Controller = $controller;
	}
	
	public function fnShareUserRegistrationOnFacebook($arrPortalInfo = array())
	{
		App::import('Vendor', 'social/fb/src/facebook');
		$facebook = new Facebook(array(
		  'appId'  => Configure::read('Social.FbApkey'),
		  'secret' => Configure::read('Social.FbSecretkey'),
		));
		
		$user = $facebook->getUser();
		if($user) 
		{
		  try 
		  {
			// Proceed knowing you have a logged in user who's authenticated.
			$user_profile = $facebook->api('/me');
			$strPortalName = $arrPortalInfo[0]['Portal']['career_portal_name'];
			$ret_obj = $facebook->api('/me/feed', 'POST',array(
			//'link' => 'www.yahoo.com',
			'message' => 'Joined '.$strPortalName,
			'description' => "Conratulations!, ".$user_profile['username']." has just joined ".$strPortalName,
			'privacy' => array('value' => 'EVERYONE')));
			//$fh = fopen("check.txt","w");
			if($ret_obj['id'])
			{
				
				//fwrite($fh,"done");
				//fclose($fh);
				return true;
			}
			else
			{
				//fwrite($fh,"not done");
				//fclose($fh);
				return false;
			}
		  } 
		  catch (FacebookApiException $e) 
		  {
			$user = null;
		  }
		}
	}
	
	public function fnShareOnFacebook($arrPortalInfo = array())
	{
		App::import('Vendor', 'social/fb/src/facebook');
		$facebook = new Facebook(array(
		  'appId'  => Configure::read('Social.FbApkey'),
		  'secret' => Configure::read('Social.FbSecretkey'),
		));
		
		$user = $facebook->getUser();
		if($user) 
		{
		  try 
		  {
			// Proceed knowing you have a logged in user who's authenticated.
			$user_profile = $facebook->api('/me');
			$strLink = $arrPortalInfo['link'];
			$ret_obj = $facebook->api('/me/feed', 'POST',array(
			//'link' => 'www.yahoo.com',
			'message' => 'Shared '.$strLink,
			'description' => $user_profile['username']." has just shared a link ".$strLink.", Please check it",
			'privacy' => array('value' => 'EVERYONE')));
			//$fh = fopen("check.txt","w");
			if($ret_obj['id'])
			{
				
				//fwrite($fh,"done");
				//fclose($fh);
				return true;
			}
			else
			{
				//fwrite($fh,"not done");
				//fclose($fh);
				return false;
			}
		  } 
		  catch (FacebookApiException $e) 
		  {
			$user = null;
		  }
		}
		else
		{
			$strRedirctUri = "http://".$_SERVER['HTTP_HOST'].$this->Controller->params->here;
			$loginUrl = $facebook->getLoginUrl(array('scope' => 'email, publish_actions','redirect_uri'=>$strRedirctUri));
			//$loginUrl = $facebook->getLoginUrl();
			$this->Controller->redirect($loginUrl);
		}
	}
	
	public function fnGetFbUserDetails($intCareerPortalId = "",$boolForLogin = "")
	{
		App::import('Vendor', 'social/fb/src/facebook');
		$facebook = new Facebook(array(
		  'appId'  => Configure::read('Social.FbApkey'),
		  'secret' => Configure::read('Social.FbSecretkey'),
		));
		
		//echo '<pre>',print_r($facebook);
		$user = $facebook->getUser();

			//echo '<pre>',print_r($user);die;
		if($user) 
		{
		  try 
		  {
			// Proceed knowing you have a logged in user who's authenticated.
			$user_profile = $facebook->api('/me');
		  } 
		  catch (FacebookApiException $e) 
		  {
			$user = null;
		  }
		}
		
		if($user) 
		{
			//$arrUserArray = $user_profile;
			/* print("<pre>");*/
			//print_r($user_profile); die;
			$boolSocialSessionExists = $this->Session->check('SOCIALREGISTRATIONDETAILS');
			if($boolSocialSessionExists)
			{
				$arrExistSocialSession = $this->Session->read('SOCIALREGISTRATIONDETAILS');
				if(isset($arrExistSocialSession['SOCIALUSERTYPE']))
				{
					if($arrExistSocialSession['SOCIALUSERTYPE'] == "twitter")
					{
						// run the facebook logout url in background
						$this->Session->delete('twitter');
						
					}
					if($arrExistSocialSession['SOCIALUSERTYPE'] == "linkedin")
					{
						// run the facebook logout url in background
						$this->Session->delete('linkedin');
						
					}
					$this->Session->delete('SOCIALREGISTRATIONDETAILS');
				}
			}
			
			$arrUserArray['SOCIALUSERID'] = $user_profile['id'];
			$arrUserArray['SOCIALUSERFNAME'] = $user_profile['first_name'];
			$arrUserArray['SOCIALUSERLNAME'] = $user_profile['last_name'];
			$arrUserArray['SOCIALUSERFULLNAME'] = $user_profile['name'];
			$arrUserArray['SOCIALUSERNAME'] = $user_profile['username'];
			$arrUserArray['SOCIALUSEREMAIL'] = $user_profile['email'];
			$arrUserArray['SOCIALUSERABOUT'] = $user_profile['bio'];
			$arrUserArray['SOCIALUSERGENDER'] = $user_profile['gender'];
			$arrUserArray['SOCIALUSERVERIFIED'] = $user_profile['verified'];
			if(isset($user_profile['location']['name']))
			{
				$arrUserArray['SOCIALUSERLOCATION'] = $user_profile['location']['name'];
			}
			else
			{
				$arrUserArray['SOCIALUSERLOCATION'] = $user_profile['location']['name'];
			}
			
			$arrUserArray['SOCIALUSERTYPE'] = "facebook";
			if($boolForLogin)
			{
				$strLogoutUrl = Router::url(array('controller' => 'candidates', 'action' => 'dashboard', $intCareerPortalId),true);
			}
			else
			{
				$strLogoutUrl = Router::url(array('controller' => 'social', 'action' => 'social','resetregister','facebook',$intCareerPortalId),true);
			}
			$params = array('next'=>$strLogoutUrl);
			$logoutUrl = $facebook->getLogoutUrl($params);
			$arrUserArray['logout_url'] = $logoutUrl;
			/* print("<pre>");
			print_r($arrUserArray);
			exit; */
			
			$this->Session->write('SOCIALREGISTRATIONDETAILS',$arrUserArray);
			?>
				<script type="text/javascript">
					window.close();
					window.opener.location.reload();
				</script>
			<?php
		} 
		else 
		{
		  $strRedirctUri = "http://".$_SERVER['HTTP_HOST'].$this->Controller->params->here;
		  $loginUrl = $facebook->getLoginUrl(array('scope' => 'email, publish_actions','redirect_uri'=>$strRedirctUri));
		  //$loginUrl = $facebook->getLoginUrl();
		  $this->Controller->redirect($loginUrl);
		}
	}
	
	public function fnShareUserRegistrationOnLinkedIn($arrPortalInfo = array())
	{
		App::import('Vendor', 'social/linkedin/linkedin');
		$API_CONFIG = array(
			'appKey'       => Configure::read('Social.LinkedInApkey'),
			  'appSecret'    => Configure::read('Social.LinkedInSecretkey'),
			  'callbackUrl'  => NULL 
		);
		
		if(isset($_SESSION['linkedin']['authorized']))
		{
			if($_SESSION['linkedin']['authorized'] === TRUE) 
			{
				$OBJ_linkedin = new LinkedIn($API_CONFIG);
				$OBJ_linkedin->setTokenAccess($_SESSION['linkedin']['access']);
				$private = FALSE;
				$strPortalName = $arrPortalInfo[0]['Portal']['career_portal_name'];
				$arrUserDetail = $this->Session->read('SOCIALREGISTRATIONDETAILS');
				// prepare content for sharing
				$content = array();
				$content['comment'] = 'Joined '.$strPortalName;
				$content['title'] = 'Joined '.$strPortalName;
				//$content['submitted-url'] = "www.yahoo.com";
				//$content['submitted-image-url'] = $_POST['simgurl'];
				$content['description'] = "Conratulations!, ".$arrUserDetail['SOCIALUSERFULLNAME']." has joined ".$strPortalName;
				// share content
				$response = $OBJ_linkedin->share('new', $content, $private);
				 if($response['success'] === TRUE) 
				 {
					return true;
				 }
				 else
				 {
					//print("<pre>");
					//print_r($response);
					
					return false;
				 }
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		
	}
	
	public function fnShareOnLinkedIn($arrPortalInfo = array())
	{
	
		App::import('Vendor', 'social/linkedin/linkedin');
		App::import('Vendor', 'social/linkedin/oAuth');
		$API_CONFIG = array(
			'appKey'       => Configure::read('Social.LinkedInApkey'),
			  'appSecret'    => Configure::read('Social.LinkedInSecretkey'),
			  'callbackUrl'  => NULL 
		);
		
		
		if(isset($_SESSION['linkedin']['authorized']))
		{
			if($_SESSION['linkedin']['authorized'] === TRUE) 
			{
				$OBJ_linkedin = new LinkedIn($API_CONFIG);
				$OBJ_linkedin->setTokenAccess($_SESSION['linkedin']['access']);
				$OBJ_linkedin->setResponseFormat('JSON');
				$responseu = $OBJ_linkedin->profile('~:(id,first-name,last-name,picture-url,email-address,phone-numbers,location,summary,formatted-name)');
				$private = FALSE;
				$strPortalName = $arrPortalInfo['link'];
				// prepare content for sharing
				$content = array();
				$content['comment'] = 'Shared '.$strPortalName;
				$content['title'] = 'Shared '.$strPortalName;
				//$content['submitted-url'] = "www.yahoo.com";
				//$content['submitted-image-url'] = $_POST['simgurl'];
				$content['description'] = "Conratulations!, ".$responseu->formattedName." has Shared ".$strPortalName;
				// share content
				$response = $OBJ_linkedin->share('new', $content, $private);
				
				
				 if($response['success'] === TRUE) 
				 {
					return true;
					?>
						<script type="text/javascript">
							window.close();
							window.opener.location.reload();
						</script>
					<?php
				 }
				 else
				 {
					//print("<pre>");
					//print_r($response);
					
					return false;
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
				return false;
			}
		}
		else
		{
			
			// request token and access token
			 $API_CONFIG['callbackUrl'] = "https://".$_SERVER['HTTP_HOST'].$this->Controller->params->here;
	
			 $OBJ_linkedin = new linkedin($API_CONFIG);
			
		
			
			if(isset($_SESSION['linkedin']['request']))
			{
			
				$response = $OBJ_linkedin->retrieveTokenAccess($_SESSION['linkedin']['request']['oauth_token'], $_SESSION['linkedin']['request']['oauth_token_secret'], $_REQUEST['oauth_verifier']);
				if($response['success'] === TRUE) 
				{
					
					$_SESSION['linkedin']['access'] = $response['linkedin'];
					$_SESSION['linkedin']['authorized'] = TRUE;
					$strRedirctUri = "http://".$_SERVER['HTTP_HOST'].$this->Controller->params->here;
					$this->Controller->redirect($strRedirctUri);
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
					$this->Controller->redirect($url);
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
	
	public function fnGetLinkedInUserDetails($intCareerPortalId = "",$boolForLogin = "")
	{
		App::import('Vendor', 'social/linkedin/linkedin');
		$API_CONFIG = array(
			'appKey'       => Configure::read('Social.LinkedInApkey'),
			  'appSecret'    => Configure::read('Social.LinkedInSecretkey'),
			  'callbackUrl'  => NULL 
		);
		
		/* print("<pre>");
		print_r($_SESSION); */
		
		if(isset($_SESSION['linkedin']['authorized']))
		{
			//echo "My";exit;
			// user details here
			if($_SESSION['linkedin']['authorized'] === TRUE) 
			{
				$OBJ_linkedin = new LinkedIn($API_CONFIG);
				$OBJ_linkedin->setTokenAccess($_SESSION['linkedin']['access']);
				$OBJ_linkedin->setResponseFormat('JSON');
				$response = $OBJ_linkedin->profile('~:(id,first-name,last-name,picture-url,email-address,phone-numbers,location,summary,formatted-name)');
				if($response['success'] === TRUE) 
				{
				  //$response['linkedin'] = new SimpleXMLElement($response['linkedin']);
				  $response['linkedin'] = json_decode($response['linkedin']);
				    
				  $boolSocialSessionExists = $this->Session->check('SOCIALREGISTRATIONDETAILS');
				  if($boolSocialSessionExists)
				  {
					$arrExistSocialSession = $this->Session->read('SOCIALREGISTRATIONDETAILS');
					if(isset($arrExistSocialSession['SOCIALUSERTYPE']))
					{
						if($arrExistSocialSession['SOCIALUSERTYPE'] == "twitter")
						{
							// run the facebook logout url in background
							$this->Session->delete('twitter');
							
						}
						
						if($arrExistSocialSession['SOCIALUSERTYPE'] == "facebook")
						{
							// run the facebook logout url in background
							$this->Session->delete('fb_'.Configure::read('Social.FbApkey').'_access_token');
							$this->Session->delete('fb_'.Configure::read('Social.FbApkey').'_code');
							$this->Session->delete('fb_'.Configure::read('Social.FbApkey').'_user_id');
						}
						
						$this->Session->delete('SOCIALREGISTRATIONDETAILS');
					}
				  }
				   
					$arrUserArray['SOCIALUSERID'] = $response['linkedin']->id;
					$arrUserArray['SOCIALUSERFNAME'] = $response['linkedin']->firstName;
					$arrUserArray['SOCIALUSERLNAME'] = $response['linkedin']->lastName;
					$arrUserArray['SOCIALUSERFULLNAME'] = $response['linkedin']->formattedName;
					$arrUserArray['SOCIALUSERNAME'] = "";
					$arrUserArray['SOCIALUSEREMAIL'] = $response['linkedin']->emailAddress;
					if(isset($response['linkedin']->summary))
					{
						$arrUserArray['SOCIALUSERABOUT'] = $response['linkedin']->summary;
					}
					else
					{
						$arrUserArray['SOCIALUSERABOUT'] = "";
					}
					$arrUserArray['SOCIALUSERGENDER'] = "";
					$arrUserArray['SOCIALUSERLOCATION'] = $response['linkedin']->location->name;
					$arrUserArray['SOCIALUSERVERIFIED'] = "1";
					$arrUserArray['logout_url'] = Router::url(array('controller' => 'portal', 'action' => 'reset', $intCareerPortalId),true);
					$arrUserArray['SOCIALUSERTYPE'] = "linkedin";
					/* print("<pre>");
					print_r($arrUserArray);
					exit; */
					$this->Session->write('SOCIALREGISTRATIONDETAILS',$arrUserArray);
					?>
						<script type="text/javascript">
							window.close();
							window.opener.location.reload();
						</script>
					<?php
				  
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
			// request token and access token
			$API_CONFIG['callbackUrl'] = "http://".$_SERVER['HTTP_HOST'].$this->Controller->params->here;
			$OBJ_linkedin = new LinkedIn($API_CONFIG);
			
			if(isset($_SESSION['linkedin']['request']))
			{
				//echo "----".$_REQUEST['oauth_verifier'];exit;
				$response = $OBJ_linkedin->retrieveTokenAccess($_SESSION['linkedin']['request']['oauth_token'], $_SESSION['linkedin']['request']['oauth_token_secret'], $_REQUEST['oauth_verifier']);
				if($response['success'] === TRUE) 
				{
					
					$_SESSION['linkedin']['access'] = $response['linkedin'];
					$_SESSION['linkedin']['authorized'] = TRUE;
					$strRedirctUri = "http://".$_SERVER['HTTP_HOST'].$this->Controller->params->here;
					$this->Controller->redirect($strRedirctUri);
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
						$this->Controller->redirect($url);
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
	
	
	public function fnShareUserRegistrationOnTwitter($arrPortalInfo = array())
	{
		App::import('Vendor', 'social/twitter/twitteroauth/twitteroauth');
		if(empty($_SESSION['twitter']['access_token']) || empty($_SESSION['twitter']['access_token']['oauth_token']) || empty($_SESSION['twitter']['access_token']['oauth_token_secret']))
		{
			return false;
			
		}
		else
		{
			$strPortalName = $arrPortalInfo[0]['Portal']['career_portal_name'];
			$access_token = $_SESSION['twitter']['access_token'];
			$connection = new TwitterOAuth(Configure::read('Social.TwitterApkey'), Configure::read('Social.TwitterSecretkey'), $access_token['oauth_token'], $access_token['oauth_token_secret']);
			$content = $connection->get('account/verify_credentials');
			$strMessage = $content->name.' Joined '.$strPortalName;
			$boolPostResult = $connection->post('statuses/update', array('status' => $strMessage));
			/*print("<pre>");
			print_r($boolPostResult);*/
			if($boolPostResult->id_str)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function fnShareOnTwitter($arrPortalInfo = array())
	{
		App::import('Vendor', 'social/twitter/twitteroauth/twitteroauth');
		
		
		if(isset($_SESSION['twitter']['access_token']) && isset($_SESSION['twitter']['access_token']))
		{
			
			if(empty($_SESSION['twitter']['access_token']) || empty($_SESSION['twitter']['access_token']['oauth_token']) || empty($_SESSION['twitter']['access_token']['oauth_token_secret'])) 
			{
				unset($_SESSION['twitter']);
				?>
					<script type="text/javascript">
						window.close();
						window.opener.location.reload();
					</script>
				<?php
			}
			else
			{
				//echo "LI";exit;
				$strPortalName = $arrPortalInfo['link'];
				$access_token = $_SESSION['twitter']['access_token'];
				$connection = new TwitterOAuth(Configure::read('Social.TwitterApkey'), Configure::read('Social.TwitterSecretkey'), $access_token['oauth_token'], $access_token['oauth_token_secret']);
				$content = $connection->get('account/verify_credentials');
				$strMessage = $content->name.' Shared '.$strPortalName;
				$boolPostResult = $connection->post('statuses/update', array('status' => $strMessage));
				/*print("<pre>");
				print_r($boolPostResult);
				exit;*/
				if($boolPostResult->id_str)
				{
					$msg = 'job successfully posted on twitter';
					$this->Session->setFlash('<div class="alert alert-success">
									  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
									  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
									   '.$msg.'
									</div>');
					?>
					<script type="text/javascript">
							window.close();
							window.parent.sharestatus = 'true';
							window.opener.location.reload();
						</script>
						<?php
				}
				else
				{
					$errormsg = $boolPostResult->errors[0]->message;
					if($errormsg == 'Status is a duplicate.')
					{
						$errormsg = 'You allready posted this job on twitter';
					}
					
				
					
					$this->Session->setFlash('<div class="alert alert-success">
									  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
									  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
									  '.$errormsg.'
									</div>');
					
					?>
						<script type="text/javascript">
							window.close();
							window.parent.sharestatus = 'false';
							window.opener.location.reload();
						</script>
						<?php
				}
			}
		}
		else
		{
			
			if(isset($_SESSION['twitter']['oauth_token']) && isset($_SESSION['twitter']['oauth_token_secret']))
			{
				//echo "hi";exit;
				
				if($_SESSION['twitter']['oauth_token'] !== $_REQUEST['oauth_token'])
				{
					unset($_SESSION['twitter']);
					?>
						<script type="text/javascript">
							window.close();
							window.opener.location.reload();
						</script>
					<?php
				}
				else
				{
					$connection = new TwitterOAuth(Configure::read('Social.TwitterApkey'), Configure::read('Social.TwitterSecretkey'), $_SESSION['twitter']['oauth_token'],$_SESSION['twitter']['oauth_token_secret']);
					$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
					$_SESSION['twitter']['access_token'] = $access_token;
					unset($_SESSION['twitter']['oauth_token']);
					unset($_SESSION['twitter']['oauth_token_secret']);
					if (200 == $connection->http_code) 
					{
					  /* The user has been verified and the access tokens can be saved for future use */
					  $_SESSION['twitter']['status'] = 'verified';
					   $strRedirctUri = "http://".$_SERVER['HTTP_HOST'].$this->Controller->params->here;
					 
					  $this->Controller->redirect($strRedirctUri);
					} 
					else 
					{
					  unset($_SESSION['twitter']);
						?>
							<script type="text/javascript">
								window.close();
								window.opener.location.reload();
							</script>
						<?php
					}
				}
			}
			else
			{
				$connection = new TwitterOAuth(Configure::read('Social.TwitterApkey'), Configure::read('Social.TwitterSecretkey'));
				$strRedirctUri = "http://".$_SERVER['HTTP_HOST'].$this->Controller->params->here;
				$request_token = $connection->getRequestToken($strRedirctUri);
				
				$_SESSION['twitter']['oauth_token'] = $token = $request_token['oauth_token'];
				$_SESSION['twitter']['oauth_token_secret'] = $request_token['oauth_token_secret'];
				
				switch ($connection->http_code) 
				{
				  case 200:
							/* Build authorize URL and redirect user to Twitter. */
							$url = $connection->getAuthorizeURL($token);
							$this->Controller->redirect($url);
							break;
				  default:	?>
								<script type="text/javascript">
									window.close();
									window.opener.location.reload();
								</script>
							<?php
							/* Show notification if something went wrong. */
							//echo 'Could not connect to Twitter. Refresh the page or try again later.';
				}
			}
		}
	}
	
	public function fnGetTwitterUserDetails($intCareerPortalId = "",$boolForLogin = "")
	{
		App::import('Vendor', 'social/twitter/twitteroauth/twitteroauth');
		if(isset($_SESSION['twitter']['access_token']) && isset($_SESSION['twitter']['access_token']))
		{
			
			if(empty($_SESSION['twitter']['access_token']) || empty($_SESSION['twitter']['access_token']['oauth_token']) || empty($_SESSION['twitter']['access_token']['oauth_token_secret'])) 
			{

				unset($_SESSION['twitter']);
				?>
					<script type="text/javascript">
						window.close();
						window.opener.location.reload();
					</script>
				<?php
			}
			else
			{
				$access_token = $_SESSION['twitter']['access_token'];
				$connection = new TwitterOAuth(Configure::read('Social.TwitterApkey'), Configure::read('Social.TwitterSecretkey'), $access_token['oauth_token'], $access_token['oauth_token_secret']);
				$content = $connection->get('account/verify_credentials');
				
				/* print("<pre>");
				print_r($content); */
				$boolSocialSessionExists = $this->Session->check('SOCIALREGISTRATIONDETAILS');
				if($boolSocialSessionExists)
				{
					$arrExistSocialSession = $this->Session->read('SOCIALREGISTRATIONDETAILS');
					if(isset($arrExistSocialSession['SOCIALUSERTYPE']))
					{
						if($arrExistSocialSession['SOCIALUSERTYPE'] == "facebook")
						{
							// run the facebook logout url in background
							$this->Session->delete('fb_'.Configure::read('Social.FbApkey').'_access_token');
							$this->Session->delete('fb_'.Configure::read('Social.FbApkey').'_code');
							$this->Session->delete('fb_'.Configure::read('Social.FbApkey').'_user_id');
							
						}
						if($arrExistSocialSession['SOCIALUSERTYPE'] == "linkedin")
						{
							// run the facebook logout url in background
							$this->Session->delete('linkedin');
							
						}
						$this->Session->delete('SOCIALREGISTRATIONDETAILS');
					}
				}
				
				
				//$arrUserArray = $content;
				$arrUserNameDetail = explode(" ",$content->name);
				$arrUserArray['SOCIALUSERID'] = $content->id;
				if(is_array($arrUserNameDetail) && (count($arrUserNameDetail)>0))
				{
					if($arrUserNameDetail[0])
					{
						$arrUserArray['SOCIALUSERFNAME'] = $arrUserNameDetail[0];
					}
					
					if($arrUserNameDetail[1])
					{
						$arrUserArray['SOCIALUSERLNAME'] = $arrUserNameDetail[1];
					}
					else
					{
						$arrUserArray['SOCIALUSERLNAME'] = "";
					}
					
				}
				else
				{
					$arrUserArray['SOCIALUSERFNAME'] = "";
					$arrUserArray['SOCIALUSERLNAME'] = "";
					
				}
				$arrUserArray['SOCIALUSERFULLNAME'] = $content->name;
				$arrUserArray['SOCIALUSERNAME'] = $content->screen_name;
				if(isset($content->email))
				{
					$arrUserArray['SOCIALUSEREMAIL'] = $content->email;
				}
				else
				{
					$arrUserArray['SOCIALUSEREMAIL'] = "";
				}
				
				$arrUserArray['SOCIALUSERABOUT'] = $content->description;
				
				if(isset($content->gender))
				{
					$arrUserArray['SOCIALUSERGENDER'] = $content->gender;
				}
				else
				{
					$arrUserArray['SOCIALUSERGENDER'] = "";
				}
				if(isset($content->location))
				{
					$arrUserArray['SOCIALUSERLOCATION'] = $content->location;
				}
				else
				{
					$arrUserArray['SOCIALUSERLOCATION'] = "";
				}
				$arrUserArray['SOCIALUSERVERIFIED'] = "1";
				$arrUserArray['logout_url'] = Router::url(array('controller' => 'portal', 'action' => 'reset', $intCareerPortalId),true);
				$arrUserArray['SOCIALUSERTYPE'] = "twitter";
				
				
				
				
				/*print("<pre>");
				print_r($arrUserArray);
				exit;*/
				
				$this->Session->write('SOCIALREGISTRATIONDETAILS',$arrUserArray);
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
			if(isset($_SESSION['twitter']['oauth_token']) && isset($_SESSION['twitter']['oauth_token_secret']))
			{
				if($_SESSION['twitter']['oauth_token'] !== $_REQUEST['oauth_token'])
				{
					unset($_SESSION['twitter']);
					?>
						<script type="text/javascript">
							window.close();
							window.opener.location.reload();
						</script>
					<?php
				}
				else
				{
					$connection = new TwitterOAuth(Configure::read('Social.TwitterApkey'), Configure::read('Social.TwitterSecretkey'), $_SESSION['twitter']['oauth_token'],$_SESSION['twitter']['oauth_token_secret']);
					$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
					$_SESSION['twitter']['access_token'] = $access_token;
					unset($_SESSION['twitter']['oauth_token']);
					unset($_SESSION['twitter']['oauth_token_secret']);
					if (200 == $connection->http_code) 
					{
					  /* The user has been verified and the access tokens can be saved for future use */
					  $_SESSION['twitter']['status'] = 'verified';
					  $strRedirctUri = "http://".$_SERVER['HTTP_HOST'].$this->Controller->params->here;
					  $this->Controller->redirect($strRedirctUri);
					} 
					else 
					{
					  unset($_SESSION['twitter']);
						?>
							<script type="text/javascript">
								window.close();
								window.opener.location.reload();
							</script>
						<?php
					}
				}
			}
			else
			{
				 $connection = new TwitterOAuth(Configure::read('Social.TwitterApkey'), Configure::read('Social.TwitterSecretkey'));
			
				$strRedirctUri = "http://".$_SERVER['HTTP_HOST'].$this->Controller->params->here;
				$request_token = $connection->getRequestToken($strRedirctUri);
				
				$_SESSION['twitter']['oauth_token'] = $token = $request_token['oauth_token'];
				$_SESSION['twitter']['oauth_token_secret'] = $request_token['oauth_token_secret'];
				
				switch ($connection->http_code) 
				{
				  case 200:
							/* Build authorize URL and redirect user to Twitter. */
							$url = $connection->getAuthorizeURL($token);
							$this->Controller->redirect($url);
							break;
				  default:	?>
								<script type="text/javascript">
									window.close();
									window.opener.location.reload();
								</script>
							<?php
							/* Show notification if something went wrong. */
							//echo 'Could not connect to Twitter. Refresh the page or try again later.';
				}
			}
		}
	}
}
?>