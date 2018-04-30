<?php
	if(isset($strJobSearchUrl))
	{
		?>
			<div style="width:100%;">
				<iframe style="width:100%;height:1200px;" src="<?php echo $strJobSearchUrl;?>" ></iframe>
			</div>
		<?php
	}
	/*print("<pre>");
	print_r($arrPortalDetail);*/
?>
<script type="text/javascript">
	mixpanel.track("<?php echo $arrPortalDetail[0]['Portal']['career_portal_name']." ".$strSearchMode; ?> Search", {
		"Basic Search": "Yes",
		"Search Keyword": "<?php echo $strKeywords; ?>",
	});
</script>