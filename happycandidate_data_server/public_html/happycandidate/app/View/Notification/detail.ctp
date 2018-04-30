<div class="wrapper">
	<div id="jop_search" class="jop_search">
	<?php
		if(is_array($arrReminderDetail) && (count($arrReminderDetail)>0))
		{
			//print("<pre>");
			//print_r($arrReminderDetail);
			
			?>
				<!--<input type="hidden" name="jobid" id="jobid" value="<?php echo $arrJobDetail[0]['Job']['id']; ?>" />
				<input type="hidden" name="candidateid" id="candidateid" value="<?php echo $intCandidateId; ?>" />
				<input type="hidden" name="portalid" id="portalid" value="<?php echo $intPortalId; ?>" />-->
				<div id="jobpostpage" style="width:100%;">
					<div id="jobpostpageheader" style="width:100%;">
						<h2 style="padding:0;margin-bottom:30px;background:none;padding:none;">Event Notification</h2>
						<div id="reminderpostdetail" style="height:20px;width:90%;">
							<div id="reminderaction" style="width:100%;color:gray;clear:both;">
								<span>Dear Candidate,</span>
								<p>
									<?php 
										echo $arrReminderDetail[0]['Events']['event_description']." at ".$arrReminderDetail[0]['Events']['event_date_time']; 
									?>
								</p>
							</div>
						</div>
					</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
				</div>	
			<?php
		}
	?>
	</div>
</div>