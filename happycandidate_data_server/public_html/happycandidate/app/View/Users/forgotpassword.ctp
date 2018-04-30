<div class="wrapper">
<div class="login-container">
<div class="widget-box visible login-box">

<div class="widget-main">
<?php

	echo $this->Html->script('user_forgotpassword');
	echo $this->Html->css('cake.generic');
?>

<div id="loginHeader">
	<h4 class="header blue lighter bigger">Forgot Password</h4>
</div>
<p align="justify">Please provide the email address you are registered with.<br> 
We will send you an email with regenerated password which can be used to login into the system.
<br/>
<br/>
</p>

<div>
	<?php
		
		echo $this->Form->create('User');
		echo $this->Form->input('user_email',array('label'=>false,'placeholder'=>'Email','class'=>'validate[required,custom[email]]'));
		echo $this->Form->input('u_type',array('type'=>'hidden','value'=>'2'));
		echo $this->Form->end('Regenerate Password');
	?>
</div>
</div>
<div class="toolbar clearfix">
	<div>
			<a href="http://www.redorangetechnologies.com/happycandidate/" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
			<i class="icon-arrow-left"></i>
			Go to Home page
		</a>
	</div>

</div>
</div>
</div>
</div>