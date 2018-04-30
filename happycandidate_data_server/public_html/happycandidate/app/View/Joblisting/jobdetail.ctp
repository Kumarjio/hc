<div class="users">
<?php
	if(is_array($arrJobDetail) && (count($arrJobDetail)>0))
	{
		?>
			<input type="hidden" name="jobid" id="jobid" value="<?php echo $arrJobDetail[0]['Job']['id']; ?>" />
			<input type="hidden" name="candidateid" id="candidateid" value="<?php echo $intCandidateId; ?>" />
			<input type="hidden" name="portalid" id="portalid" value="<?php echo $intPortalId; ?>" />
			<div id="jobpostpage" style="width:100%;">
				<div id="jobpostpageheader" style="width:100%;">
					<h2><?php echo $arrJobDetail['0']['Job']['title'];?></h2>
					<div id="jobpostdetail" style="height:20px;width:90%;">
						<div id="postersnapshot" style="width:100%;color:gray;"><?php echo "by ".$arrJobDetail['0']['Job']['poster_email']; ?></div>
						<div id="otherjobpostdetail" style="width:100%;color:gray;"><span style="float:right;">Posted On: <?php echo date('d M y',strtotime($arrJobDetail['0']['Job']['created_on'])) ;?></span></div>
						<div id="jobpostaction" style="width:100%;color:gray;clear:both;">
							<span class="actions">
								<?php
									if($arrJobDetail['0']['Job']['applied'])
									{
										?>
											<span id="applicationdateinfo" style="color:black;">Applied on <?php echo date('d M y',strtotime($arrJobDetail['0']['Job']['application_date']));?></span>&nbsp;
											
										<?php
									}
									else
									{
										?>
											<a id="applyjob" onClick="fnApplyJob('<?php echo $strJobApplyUrl;?>');" href="javascript:void(0);">Apply</a>
										<?php
									}
									
									if($arrJobDetail['0']['Job']['interviewreminder'])
									{
										?>
											<span id="applicationdateinfo" style="color:black;">Interview Reminder Set on <?php echo date('d M y',strtotime($arrJobDetail['0']['Job']['interviewreminder']));?></span>&nbsp;
										<?php
									}
									else
									{
										?>
											<a id="applyjob" onClick="fnShowSetReminderForm();" href="javascript:void(0);">Set Interview Reminders</a>
										<?php
									}
								?>
								
							</span>
						</div>
					</div>
				</div>
				<div>&nbsp;</div>
				<div>&nbsp;</div>
				<div>&nbsp;</div>
				<div id="jobpostpagecontent" style="width:100%;">
					<div id="jobdescriptioncontainer" style="width:90%;">
						<div id="jobdesriptionheader" style="width:100%;font-weight:bold;border-bottom:solid 2px black;margin-bottom:2%;"><span>Job Description</span></div>
						<div id="jobdescriptioncontent"><span><?php echo $arrJobDetail['0']['Job']['description'];?></span></div>
						<div id="jobclassification" style="width:100%;float:left;margin-top:2%;">
							<div id="classificationfactor1" style="width:11%;float:left;"><span>Type</span></div>
							<div id="classificationfactorvalue1" style="width:89%;float:left;"><span><?php echo $arrJobDetail['0']['Job']['type_name'];?></span></div>
							<div id="classificationfactor2" style="width:11%;float:left;"><span>Role</span></div>
							<div id="classificationfactorvalue2" style="width:89%;float:left;"><span><?php echo $arrJobDetail['0']['Job']['category_name'];?></span></div>
						</div>
					</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div id="jobdescriptioncontainer" style="width:90%;">
						<div id="jobdesriptionheader" style="width:100%;font-weight:bold;border-bottom:solid 2px black;margin-bottom:2%;"><span>Desired Candidate Profile</span></div>
						<div id="jobdescriptioncontent"><span></span></div>					
					</div
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div id="jobdescriptioncontainer" style="width:90%;">
						<div id="jobdesriptionheader" style="width:100%;font-weight:bold;border-bottom:solid 2px black;margin-bottom:2%;"><span>Company Profile</span></div>
						<div id="jobdescriptioncontent"><span><?php echo $arrJobDetail['0']['Job']['company'];?></span></span></div>					
					</div>
				</div>
				<div>&nbsp;</div>
				<div>&nbsp;</div>
				<div>&nbsp;</div>
				<div id="jobpostpagefooter">
					<div id="jobpostpagefootercontainer" style="height:20px;width:100%;">
						<div id="jobpostaction" style="width:100%;color:gray;">
							<span class="actions">
								<?php
									if(!$arrJobDetail['0']['Job']['applied'])
									{
										?>
											<a id="applyjob" href="javascript:void(0);">Apply</a>
										<?php
									}
								?>
								
							</span>
						</div>
					</div>
				</div>
			</div>	
		<?php
	}
?>
<?php
	echo $this->element("set_interview_reminder");
?>
</div>