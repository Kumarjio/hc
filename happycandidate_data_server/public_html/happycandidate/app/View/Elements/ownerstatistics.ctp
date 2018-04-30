<div class="users container-layout">
	
	<div id="page-title">
		<h3>Portal Owner(s)</h3>
	</div>

	<table cellpadding="0" cellspacing="0" width="100%" class="privatelabelsites">
	<tr>
			<th class="tb_col_head" width="5%">Sr.No.</th>
			<th class="tb_col_head" width="20%">First Name</th>
			<th class="tb_col_head" width="20%">Last Name</th>
			<th class="tb_col_head" width="25%">Email</th>
			<th class="tb_col_head" width="15%">Portal Name</th>
			<th class="tb_col_head" width="15%">Phone Number</th>
			<!--<th class="tb_col_head" width="10%">Status</th>-->
	</tr>
	<?php
		/*print("<pre>");
		print_r($arrPortalUserList);exit;*/
		
		if(is_array($arrPortalOwnerList) && (count($arrPortalOwnerList)>0))
		{
			$intForI = 0;
			$class = null;
			foreach($arrPortalOwnerList as $arrPortalOwner)
			{
				if ($intForI++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				
				?>
					<tr <?php echo $class;?>>
						<td class="tb_col_data"><?php echo $intForI;?></td>
						<td class="tb_col_data"><?php echo $arrPortalOwner['employer_detail']['employer_user_fname']; ?></td>
						<td class="tb_col_data"><?php echo $arrPortalOwner['employer_detail']['employer_user_lname']; ?></td>
						<td class="tb_col_data"><?php echo $arrPortalOwner['user']['email']; ?></td>
						<td class="tb_col_data"><?php echo $arrPortalOwner['career_portal']['career_portal_name']; ?></td>
						<td class="tb_col_data"><?php echo $arrPortalOwner['employer_detail']['employer_contact_number']; ?></td>
						<!--<td class="tb_col_data">
						<?php 
							if($arrPortalOwner['user']['is_active'])
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
					<td colspan='6'><span style="margin-left:20%;">No Portal Owners</span></td>
				</tr>
			<?php
		}
	?>
	</table>
	
</div>