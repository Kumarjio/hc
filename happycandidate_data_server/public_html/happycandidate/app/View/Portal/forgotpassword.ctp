<?php
//	echo $this->Html->script('user_forgotpassword');
?>
<?php 
		$strLoginUrl = Router::url(array('controller'=>'portal','action'=>'login',$intPortalId),true);
		$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$intPortalId),true);
		//echo $this->Form->create('User',array('inputDefaults'=>array('label' => false,'div' => false)));
	?>
	<div class="container-fluid">
		<div class="row">

		
			<div class="hidden-xs hidden-sm col-md-4"></div>
			<div class="col-xs-12 col-sm-12 col-md-4">
			
				<div class="admin-logo-container">
				
					<a class="navbar-brand" href="#">
						<img src="<?php echo Router::url('/', true);?>images/search-item.png" alt="logo description" /><span>HR Search</span>
					</a>
				</div>
				<div class="form-container admin-form-login">
                    <div class="admin-form-header">
					
                    	<h1>Reset Password</h1>
                    </div>
                    <form role="form" id="UserForgotpasswordForm" name="UserForgotpasswordForm" method="post">
				
						<div class="form-group">
							<p>Please provide the email address you are registered with.We will send you an email with regenerated password which can be used to login into the system.</p>
								<div id="strmessageid"></div>
							<label class="control-label " for="email">Email:</label>
							<input class="col-md-12 validate[required,custom[email]]"  type="text" name="UserEmail" value="" id="UserEmail" placeholder="Enter an email" required>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-primary btn-large-form" onClick="return checkForgotPassword('<?php echo $intPortalId; ?>');">Forgot Password</button>
							<p>Already have an account? 
								<a href="<?php echo $strLoginUrl;?>" class="link-primary">Login</a>
							</p>
						</div>
					</form>
				</div>
			</div>
			<div class="hidden-xs hidden-sm col-md-4"></div>
		</div>
	</div>
<?php /*
<div class="wrapper">
<div id="portal_registration">


	<?php 
		$strLoginUrl = Router::url(array('controller'=>'portal','action'=>'login',$intPortalId),true);
		$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$intPortalId),true);
		echo $this->Form->create('User',array('inputDefaults'=>array('label' => false,'div' => false)));
	?>
	<ul class="panel-2 margin-top-5">
		<?php
			
			echo "<li>".$this->Form->input('email',array('type'=>'text',"class"=>"validate[required,custom[email]]","label"=>"<span id='madatsym' class='madatsym'>*</span>Email"))."</li>";
			echo "<li>";
		?>
			<input type="submit" value="Regenerate Password" name="regenpass" />
		<?php
			echo "</li>";
		?>
	</ul>
</div>
</div>
*/?>
<script type="text/javascript">
function checkForgotPassword(intPortalId)
{
	var validate = $("#UserForgotpasswordForm").validationEngine('validate');
      if(validate == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	$('.cms-bgloader').show(); //show loading image
		var url = appBaseU+"portal/forgotpassword/"+intPortalId;
		
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
				if(responseText.status == "success")
				{
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					$("#strmessageid").html(responseText.message);
					//window.location.reload();
				}
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#UserForgotpasswordForm').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}
			
		
}

</script>