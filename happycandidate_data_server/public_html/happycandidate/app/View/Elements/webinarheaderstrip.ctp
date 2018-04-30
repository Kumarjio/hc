<?php
	
	if($strOtherWebinar)
	{
		$strActiveClass = "class='active'";
		$strActiveBClass = "";
	}
	else
	{
		$strActiveClass = "";
		$strActiveBClass = "class='active'";
	}
	$strUpcomingWebinarUrl = Router::url(array('controller'=>'candidates','action'=>'upcomingwebinars',$intPortalId),true);
	$strFindWebinarUrl = Router::url(array('controller'=>'candidates','action'=>'webinars',$intPortalId),true);
?>

<div class="container-fluid job-search-submenu">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<a href="<?php echo $strFindWebinarUrl; ?>">Find Webinars</a>
				<?php if($strOtherWebinar) { ?>
                                    <a href="<?php echo $strUpcomingWebinarUrl; ?>" >Other Upcoming Webinars</a>
                                <?php }?>
				<!--<a href="#" >Saved Webinars (2)</a>-->
			</div>
			<div class="col-md-1"></div>
		</div>
</div>