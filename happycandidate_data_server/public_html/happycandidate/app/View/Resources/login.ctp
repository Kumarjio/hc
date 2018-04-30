<?php
	echo $this->Html->script('portal_user_login');
?>
<div class="wrapper">
<div id="portal_registration">
	<h2>
		Login
	</h2>
	<?php 
		$strLoginUrl = Router::url(array('controller'=>'portal','action'=>'login',$intPortalId),true);
		$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$intPortalId),true);
		echo $this->Form->create('PortalUser',array('inputDefaults'=>array('label' => false,'div' => false),'type'=>'file',"onsubmit"=>"return fnLogCandidateLogIn('".$strLoginUrl."','".$strLogoutUrl."')"));
	?>
	<ul class="panel-2 margin-top-5">
		<?php
			
			echo "<li>".$this->Form->input('email',array('type'=>'text',"class"=>"validate[required]","label"=>"<span id='madatsym' class='madatsym'>*</span>Email"))."</li>";
			echo "<li>".$this->Form->input('password',array('type'=>'password',"class"=>"validate[required]","label"=>"<span id='madatsym' class='madatsym'>*</span>Password"))."</li>";
			echo $this->Form->hidden('portal_id',array('value'=>$intPortalId));
			echo "<li>";
			echo $this->Form->button('Login through Facebook', array('type'=>'button','onclick'=>'fnSocialRegister(this)','name'=>'social_media_button','class'=>'button_class','value'=>'facebook'))."&nbsp; OR &nbsp;"; 
			$strFURL = $this->Html->url(array("controller"=>"social","action" => "social","login","facebook",$intPortalId));
			echo $this->Form->hidden('',array('id'=>'facebook_process_url', 'value'=>$strFURL));
			
			/*echo $this->Form->button('Login through Twitter', array('type'=>'button','onclick'=>'fnSocialRegister(this)','name'=>'social_media_button','class'=>'button_class','value'=>'twitter'))."&nbsp; OR &nbsp;"; 
			$strTwURL = $this->Html->url(array("controller"=>"social","action" => "social","login","twitter",$intPortalId));
			echo $this->Form->hidden('',array('id'=>'facebook_process_url', 'value'=>$strTwURL));*/
			?>
			<input type="submit" value="Login" name="login" />
			<?php
			echo "&nbsp;".$this->Html->link("Forgot Your Password?",array('controller'=>'portal','action'=>'forgotpassword',$intPortalId), array('class' => 'forgotpass'));
			echo "&nbsp;";
			$strLoaderImageUrl = Router::url('/',true)."img/loader.gif";
			?>
			<span id="loginformloader" style="display:none;"><img src="<?php echo $strLoaderImageUrl; ?>" alt="loginloader" /></span>
			<?php
			echo "</li>";
		?>
	</ul>
</div>
</div>