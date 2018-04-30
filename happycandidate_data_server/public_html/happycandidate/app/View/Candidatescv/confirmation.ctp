<div class="users">
	<div style="height:20px;">
		&nbsp;
	</div>
</div>
<?php
	if(isset($isCandidateConfirmed))
	{
		?>
			<script type="text/javascript">
				mixpanel.track("<?php echo $arrMixPanelUserRegData['portalname']; ?>", {
					"Portal User Registered": "Yes",
					"User Name": "<?php echo $arrMixPanelUserRegData['username']; ?>",
					"User Id": "<?php echo $arrMixPanelUserRegData['userid']; ?>",
					"User Email": "<?php echo $arrMixPanelUserRegData['useremail']; ?>",
					"User Confirmed": "Yes",
				});
				
				mixpanel.track("<?php echo $arrMixPanelUserRegData['portalname']; ?> Confirmed Users", {
					"Portal User Registered": "Yes",
					"User Name": "<?php echo $arrMixPanelUserRegData['username']; ?>",
					"User Id": "<?php echo $arrMixPanelUserRegData['userid']; ?>",
					"User Email": "<?php echo $arrMixPanelUserRegData['useremail']; ?>",
					"User Confirmed": "Yes",
				});
			</script>
		<?php
	}
?>