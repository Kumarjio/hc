<div class="users  container-layout">
	
	<div id="page-title">
		<h3>Active Job Seeker(s)</h3>
	</div>

	<table cellpadding="0" cellspacing="0" width="100%" class="privatelabelsites">
	<tr>
			<th class="tb_col_head" width="5%">Sr.No.</th>
			<th class="tb_col_head" width="15%">First Name</th>
			<th class="tb_col_head" width="15%">Last Name</th>
			<th class="tb_col_head" width="20%">Email</th>
			<th class="tb_col_head" width="10%">Portal Name</th>
			<th class="tb_col_head" width="25%">Date Registered </th>
	</tr>
	<?php
		/*print("<pre>");
		print_r($arrPortalUserList);exit;*/
		
		if(is_array($arrPortalUserList) && (count($arrPortalUserList)>0))
		{
			$intForI = 0;
			$class = null;
			foreach($arrPortalUserList as $arrPortalUser)
			{
				if ($intForI++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				
				?>
					<tr <?php echo $class;?>>
						<td class="tb_col_data"><?php echo $intForI;?></td>
						<td class="tb_col_data"><?php echo $arrPortalUser['PortalUser']['candidate_first_name']; ?></td>
						<td class="tb_col_data"><?php echo $arrPortalUser['PortalUser']['candidate_last_name']; ?></td>
						<td class="tb_col_data"><?php echo $arrPortalUser['PortalUser']['candidate_email']; ?></td>
						<td class="tb_col_data"><?php echo $arrPortalUser['PortalName']['pname']; ?></td>
						<td class="tb_col_data"><?php echo date('Y-m-d',strtotime($arrPortalUser['PortalUser']['candidate_creation_date'])); ?></td>
						<!--<td class="tb_col_data">
						<?php 
							if($arrPortalUser['PortalUser']['candidate_is_active'])
							{
								echo "Active";
							}
							else
							{
								echo "Inactive";
							}
						?>
						</td>-->
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
					<td colspan='6' class="altrow">&nbsp;</td>
				</tr>
				<tr>
					<td colspan='6'><span style="margin-left:20%;">No Active Job Seekers`</span></td>
				</tr>
			<?php
		}
	?>
	</table>
	
</div>