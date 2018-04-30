<div class="users index">
	<h2>Candidate's Applied Jobs</h2>
	<div style="height:50px;">
		&nbsp;
	</div>
<?php
	if(is_array($arrAppliedJobs) && (count($arrAppliedJobs)>0))
	{
		
		?>
			<div id="joblist">
		<?php
			$intForI = 0;
			$class = null;
			foreach($arrAppliedJobs as $arrJobDetail)
			{
				if ($intForI++ % 2 == 0) 
				{
					$style = ' style="width:100%;background:none repeat scroll 0 0 #F9F9F9;"';
				}
				else
				{
					$style = ' style="width:100%;"';
				}
				?>
					
					<div id="jobsnapshotwrapper" <?php echo $style;?>>
						<div id="jobsnapshot" style="width:100%;padding:2%;">
							<div id="jobtitle" style="font-weight:bold;width:100%;"><span><?php echo $arrJobDetail['jobs']['title']; ?></span></div>
							<div id"companydsec" style="width:100%;"><span><?php echo $arrJobDetail['jobs']['company']; ?></span></div>
							<div id"location" style="width:100%;"><span><?php echo $arrJobDetail['jobs']['outside_location']; ?></span></div>
							<div id="jobbriefintro" style="width:80%;padding-left:1%;margin-top:1%;">
								<span>
									<?php 
										if(strlen($arrJobDetail['jobs']['description'])>60)
										{
											echo substr($arrJobDetail['jobs']['description'],0,60)."...";
										}
										else
										{
											echo $arrJobDetail['jobs']['description'];
										}
									?>
								</span>
							</div>
							<div id="jobactionbuttons" style="width:100%;margin-top:1%;">
								<span>
									<?php echo $this->Html->link("Detail View",array('controller'=>'joblisting','action'=>'jobdetail',$intPortalId,$arrJobDetail['jobs']['id']))?>
									<!--<a href="javascript:void(0);">Apply & Send Resume</a>-->
								</span>
							</div>
						</div>
					</div>
				<?php
			}
		?>
			</div>
		<?php
		
	}
?>
</div>
<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('Matched Jobs', array('action' => 'matchedjobs',$intPortalId)); ?></li>
		<li><?php echo $this->Html->link('Applied Jobs', array('action' => 'appliedjobs',$intPortalId)); ?></li>
		<li><?php echo $this->Html->link('Pending Jobs To Apply', array('action' => 'jobstoapply',$intPortalId)); ?></li>
		<!--<li><?php echo $this->Html->link('Scheduled For Interview', array('action' => 'scheduledjobsinterview',$intPortalId)); ?></li>-->
	</ul>
</div>