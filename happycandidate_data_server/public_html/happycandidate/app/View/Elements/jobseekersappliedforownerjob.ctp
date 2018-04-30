<div class="tab-row-container">
	
	<div id="page-title">
		<h4>Job Seeker(s) Applied For Owner Jobs</h4>
	</div>
	<div class="panel panel-default" style="margin-top:10px;">
	<table cellpadding="0" cellspacing="0" width="100%" class="privatelabelsites">
	<tr class="hide-str">
			<th class="tb_col_head" width="5%">Sr.No.</th>
			<th class="tb_col_head" width="10%">Title</th>
			<th class="tb_col_head" width="10%">Candidate</th>
			<th class="tb_col_head" width="25%">Email</th>
			<th class="tb_col_head" width="10%">Phone Number</th>
			<th class="tb_col_head no-filter" width="12%">Resume | CV</th>
			<th class="tb_col_head" width="15%">Application date</th>
			
	</tr>
	<?php
		/*print("<pre>");
		print_r($arrPortalUserList);exit;*/
		
		if(is_array($arrApplications) && (count($arrApplications)>0))
		{
			$intForI = 0;
			$class = null;
			foreach($arrApplications as $arrJob)
			{
				if ($intForI++ % 2 == 0) {
					$class = ' class="altrow"';
				}

				$arrJobD = $arrJob['JobsApplied']['jobdetail'];
				$arrCandD = $arrJob['JobsApplied']['candtail'];
				$arrCVD = $arrJob['JobsApplied']['candcvdetail'];
				$intJId = $arrJob['JobsApplied']['job_application_id'];
				$intPortalId = $arrJob['JobsApplied']['job_portal_id'];
				$seekerid = $arrJob['JobsApplied']['candidate_id'];
				$cv_id = $arrJob['JobsApplied']['candidate_cv_id'];
				
				
				?>
					<tr <?php echo $class;?>>
						<td class="tb_col_data"><?php echo $intForI;?></td>
						<td class="tb_col_data"><?php echo $arrJobD[0]['Job']['job_title']; ?></td>
						<td class="tb_col_data"><?php echo $arrCandD[0]['Candidate']['candidate_first_name']." ".$arrCandD[0]['Candidate']['candidate_last_name']; ?></td>
						<td class="tb_col_data"><?php echo $arrCandD[0]['Candidate']['candidate_email']; ?></td>
						<td class="tb_col_data"><?php echo $arrCVD[0]['Candidate_Cv']['homePhone']; ?></td>
						<td class="tb_col_data"><a href="javascript:void(0);" onclick="submitToResumeViewForOwner('<?php echo $intPortalId?>','<?php echo $seekerid?>','<?php echo $cv_id;?>');" class="link-primary editable"><?php echo $arrCVD[0]['Candidate_Cv']['resume_title']; ?></a></td>
						<td class="tb_col_data"><?php echo date("M d, Y",strtotime($arrJob['JobsApplied']['job_application_datetime'])); ?></td>
						
						
					</tr>
				<?php
			}
			?>
			<tr>
				<td colspan='5' align='left'>
					<?php
						if($this->Paginator->hasPrev())
						{
							echo $this->Paginator->prev(' << ' . __('previous'), array(), null, array('class' => 'prev disabled'));
						}
					?>
					&nbsp;
					<?php 
						echo $this->Paginator->numbers(array('last' => 'Last page'));
					?>
					&nbsp;
					<?php
						if($this->Paginator->hasNext())
						{
							echo $this->Paginator->next(__('next').' >> ' , array(), null, array('class' => 'next disabled'));
						}
					?>
				</td>
			</tr>
			<?php
		}
		else
		{
			?>
				<tr>
					<td colspan='8' class="altrow">&nbsp;</td>
				</tr>
				<tr>
					<td colspan='8'><span style="margin-left:20%;">No Job Seeker(s) Applied For Owner Jobs</span></td>
				</tr>
			<?php
		}
	?>
	</table>
	</div>
</div>