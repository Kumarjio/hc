<?php
	$strVendorServiceUrl = Router::url(array('controller'=>'vendorservicehoster','action'=>'index',$intPortalId,"interviewbest"),true);
?>
<div class="wrapper">
	<div id="portal_registration">
		<h2 id="jobn" style="padding:0;margin-bottom:30px;">Job Search Process <a href="javascript:void(0);" style="float:right;" onclick="fnShowVendorPopup('<?php echo $strVendorServiceUrl; ?>')">Interview best</a></h2>
		<input type="hidden" name="portal_id" id="portal_id" value="<?php echo $intPortalId; ?>" />
		
	</div>
	
	<?php
		echo $this->element('vendor_popup');
	?>

	<?php
		//print("<pre>");
		//print_r($arrJobSearchProcessPhases);
		if(is_array($arrJobSearchProcessPhases) && (count($arrJobSearchProcessPhases)>0))
		{
			?>
				<p class="tabloader" id="main_loader" style="display:none;"></p>
				<div id="accordion">
			<?php
			foreach($arrJobSearchProcessPhases as $arrJProcess)
			{
				?>
					<?php
						$strCompleteClass = "";
						if($arrJProcess['Categories']['step_completion_class'])
						{
							$strCompleteClass = $arrJProcess['Categories']['step_completion_class'];
						}
						
						$strMainClass = $arrJProcess['Categories']['job_process_type'];
						
					?>
					
					<h3 onclick="fnLoadJsSteps(this,'<?php echo $intPortalId; ?>')" class="stepshead <?php echo $strCompleteClass; ?>" id="phase_<?php echo $arrJProcess['Categories']['content_category_id'];?>"><?php echo $arrJProcess['Categories']['content_category_name'];?></h3>
					<div class="stepdetail <?php echo $strMainClass; ?>" id="phasedetail_<?php echo $arrJProcess['Categories']['content_category_id'];?>">
						<p style="margin-bottom:20px;">
							<?php
								echo htmlspecialchars_decode(stripslashes($arrJProcess['Categories']['content']));
							?>
						</p>
						
						<?php
							?>
								<p class="tabloader" id="<?php echo strtolower($arrJProcess['Categories']['job_process_type']);?>loader_<?php echo $arrJProcess['Categories']['content_category_id'];?>" style="display:none;"></p>
							<?php
							if($arrJProcess['Categories']['content_category_has_child'])
							{
								
								?>
									<div id="<?php echo strtolower($arrJProcess['Categories']['job_process_type']);?>container_<?php echo $arrJProcess['Categories']['content_category_id'];?>">
										<?php
											$strAccordType = "steps";
											$strAccordTypeId = $arrJProcess['Categories']['content_category_id'];
											echo $this->element('phasesteps',array("strAccord"=>$strAccordType,"strAccordId"=>$strAccordTypeId,"arrPhaseStep" => $arrJProcess['Categories']['Steps']));
										?>
									</div>
								<?php
							}
						?>
					</div>
				<?php
			}
			?>
				</div>
			<?php
			
		}
	?>
	<!--<?php
		$strChildAccords = "phase";
		if($arrJProcess['Categories']['job_process_type'] == "Phase")
		{
			$strChildAccords = "steps";
		}
		echo $this->element('phasesteps', array("arrPhaseStep" => $arrJProcess['CategoriesPhaseStep'],"strAccord"=>$strChildAccords,"strAccordId"=>$arrJProcess['Categories']['content_category_id']));
	?>-->
	<!--<div id="accordion">
		<h3>Section 1</h3>
		<div>
			<p>Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.</p>
		</div>
		<h3>Section 2</h3>
		<div>
			<p>Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In suscipit faucibus urna. </p>
		</div>
		<h3>Section 3</h3>
		<div>
			<p>Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis. Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui. </p>
			<ul>
				<li>List item one</li>
				<li>List item two</li>
				<li>List item three</li>
			</ul>
		</div>
		<h3>Section 4</h3>
		<div>
			<p>Cras dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia mauris vel est. </p><p>Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
		</div>
	</div>-->
</div>
<style>
	.ui-tabs {
		position: relative;/* position: relative prevents IE scroll bug (element with position: relative inside container with overflow: auto appear as "fixed") */
		padding: .2em;

	}
	.ui-tabs .ui-tabs-nav {
		margin: 0;
		padding: .2em .2em 0;
	}
	.ui-tabs .ui-tabs-nav li {
		list-style: none;
		float: left;
		position: relative;
		top: 0;
		margin: 1px .2em 0 0;
		border-bottom-width: 0;
		padding: 0;
		white-space: nowrap;
	}
	.ui-tabs .ui-tabs-nav .ui-tabs-anchor {
		float: left;
		padding: .5em 1em;
		text-decoration: none;
	}
	.ui-tabs .ui-tabs-nav li.ui-tabs-active {
		margin-bottom: -1px;
		padding-bottom: 1px;
	}
	.ui-tabs .ui-tabs-nav li.ui-tabs-active .ui-tabs-anchor,
	.ui-tabs .ui-tabs-nav li.ui-state-disabled .ui-tabs-anchor,
	.ui-tabs .ui-tabs-nav li.ui-tabs-loading .ui-tabs-anchor {
		cursor: text;
	}
	.ui-tabs-collapsible .ui-tabs-nav li.ui-tabs-active .ui-tabs-anchor {
		cursor: pointer;
	}
	.ui-tabs .ui-tabs-panel {
		display: block;
		border-width: 0;
		padding: 1em 1.4em;
		background: none;
	}
	#mediacontainer {
		float:left;
		width:100%;
	}
	
	#tabs2 {
		float:left;
		width:100%;
	}
</style>