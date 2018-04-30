<?php

	//echo $this->Html->script('employer_index');
	$strEmployerlogoPath = Router::url('/img/hometheme/img/logo.png',true);
?>
<div class="wrapper">
<div style="float:left;width;20%;height:auto;margin-left:36%;margin-top:25px;margin-bottom:25px;padding-top:45px;padding-bottom:45px;display:block;"><img src="<?php echo $strEmployerlogoPath;?>" alt="EmployerLogo" title="EmployerLogo" /></div>
<div style='width:100%;height:50%;float:left;'>
	<div id="leftDiv" style='width:70%;float:left;' class="widget-box visible login-box ">
		<div id="loginDiv" class="widget-main">
			<div id="loginHeader">
				<h4 class="header blue lighter bigger">Owner's Registration</h4>
			</div>
			<?php
				if($strSuccessRegister)
				{
					echo $strSuccessRegister;
				}
			?>
		<div class="clear"></div>
		</div>
		<div class="toolbar clearfix">
		</div>	
	</div>
</div>