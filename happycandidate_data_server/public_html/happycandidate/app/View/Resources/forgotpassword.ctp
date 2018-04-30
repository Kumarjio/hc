<?php
	echo $this->Html->script('user_forgotpassword');
?>
<div class="wrapper">
<div id="portal_registration">
	<h2>Forgot Password</h2>
	<div class="forgot-text">
		<p align="justify">Please provide the email address you are registered with.<br> 
			We will send you an email with regenerated password which can be used to login into the system.
		</p>
	</div>
	<div>&nbsp;</div>
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