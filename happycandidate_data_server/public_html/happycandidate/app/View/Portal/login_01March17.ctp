<?php
	echo $this->Html->script('portal_user_login');
	$strRegister = Router::url(array('controller'=>'portal','action'=>'home','monster'),true);
	$strForgotPassword = Router::url(array('controller'=>'portal','action'=>'forgotpassword','monster'),true);
?>

<div class="container-fluid portallogin">
		<div class="row">
			<div class="hidden-xs hidden-sm col-md-4"></div>
			<div class="col-xs-12 col-sm-12 col-md-4">
			
				<div class="admin-logo-container">
					<a class="navbar-brand" href="#">
						<span>HR SEARCH INC.</span>
					</a>
				</div>
				
				<div class="admin-form-login form-signin">
				
						<?php 
		$strLoginUrl = Router::url(array('controller'=>'portal','action'=>'login',$intPortalId),true);
		$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$intPortalId),true);
		echo $this->Form->create('PortalUser',array('inputDefaults'=>array('label' => false,'div' => false),'type'=>'file',"onsubmit"=>"return fnLogCandidateLogIn('".$strLoginUrl."','".$strLogoutUrl."')"));
	?>
							<!--<button type="submit" class="btn btn-primary btn-facebook">Login using Facebook</button>-->
							<!--'onclick'=>'fnSocialRegister(this)'-->
						<?php 
							echo $this->Form->button('Login through Facebook', array('type'=>'button','name'=>'social_media_button','class'=>'btn btn-primary btn-facebook','value'=>'facebook','onclick'=>'fnSocialRegister(this)')); 
			$strFURL = $this->Html->url(array("controller"=>"social","action" => "social","login","facebook",$intPortalId));
			echo $this->Form->hidden('',array('id'=>'facebook_process_url', 'value'=>$strFURL));?>
							<div class="h-separator-v2">
								<hr>
								<span>or</span>
							</div>

							
							<div id="loginerror"></div>
							
							<?php echo $this->Form->input('email',array('type'=>'text',"class"=>"validate[required] form-control","label"=>"Email"));
							echo $this->Form->input('password',array('type'=>'password',"class"=>"validate[required] form-control","label"=>"Password"));
							?>
							
							<?php echo $this->Form->hidden('portal_id',array('value'=>$intPortalId));?>
							
						
							
							
							<button type="submit" class="btn btn-primary btn-large-v2" onclick="return validateLogin();">Login </button>
							<a class="link-primary" href="<?php echo $strForgotPassword;?>">Forgot Password</a>
							<p>Not account yet? 
								<a class="link-primary" href="<?php echo $strRegister;?>">Register</a>
							</p>
						
					</div>
				
				
			

			</div>

			</div>

		</div>
	</div>
