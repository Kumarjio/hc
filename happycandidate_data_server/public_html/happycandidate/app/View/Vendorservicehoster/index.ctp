<div style="width:100%;" class="container-fluid bg-lightest-grey">
	<!--<iframe style="width:100%;height:1200px;" src="<?php echo $strVendServiceUrl;?>" ></iframe>
	<object style="width:100%;height:1200px;" data="http://www.google.co.in/"></object>-->
</div>
<script type="text/javascript">
	$(document).ready(function () {
		<?php
			if($strVendServiceUrl)
			{
				?>
					window.location.href = '<?php echo $strVendServiceUrl;?>';
				<?php
			}
		?>
	});
</script>