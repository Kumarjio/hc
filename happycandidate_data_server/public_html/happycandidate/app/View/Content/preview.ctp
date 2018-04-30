<div class="wrapper">
	<div id="portal_registration">
		<h2 id="jobn" style="border-bottom:1px solid #44899B;margin-bottom:30px;padding:0;"><?php echo stripslashes($arrContentDetail[0]['Content']['content_title']); ?></h2>
		<div>
			<?php
				echo htmlspecialchars_decode(stripslashes($arrContentDetail[0]['Content']['content']));
			?>
		</div>
	</div>	
</div>