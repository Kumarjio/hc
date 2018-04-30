<div class="users  container-layout">
	
	<div id="page-title">
		<h3>
			<?php
				if($title)
				{
					echo $title;
				}
				else
				{
					?>
						Registered Job Seeker(s)
					<?php
				}
			?>
		</h3>
	</div>

	<table cellpadding="0" cellspacing="0" width="100%" class="privatelabelsites">
	<tr>
			<th class="tb_col_head" width="5%">Sr.No.</th>
			<th class="tb_col_head" width="15%">First Name</th>
			<th class="tb_col_head" width="15%">Last Name</th>
			<th class="tb_col_head" width="20%">Email</th>
			<th class="tb_col_head" width="10%">Phone Number</th>
			<th class="tb_col_head" width="10%">Last Updated On</th>
			<th class="tb_col_head" width="10%">Job Seeker CV</th>
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
				$strStyleRow = "";
				if($arrPortalUser['PortalJUser']['cvupdateone'])
				{
					$strStyleRow = "style='font-weight:bold;'";
				}
				else
				{
					$strStyleRow = "";
				}
				
				?>
					<tr <?php echo $class;?> <?php echo $strStyleRow; ?>>
						<td class="tb_col_data"><?php echo $intForI;?></td>
						<td class="tb_col_data"><?php echo $arrPortalUser['PortalJUser']['fname']; ?></td>
						<td class="tb_col_data"><?php echo $arrPortalUser['PortalJUser']['sname']; ?></td>
						<td class="tb_col_data"><?php echo $arrPortalUser['PortalJUser']['email_address']; ?></td>
						<td class="tb_col_data"><?php echo $arrPortalUser['PortalJUser']['phone_number']; ?></td>
						<td class="tb_col_data"><?php echo $arrPortalUser['PortalJUser']['updateddate']; ?></td>
						<?php
							if($arrPortalUser['PortalJUser']['cvname'])
							{
								$strCandidateSeekerUrl = Router::url(array('controller'=>'candidatescv','action'=>'index',$arrPortalUser['PortalJUser']['cvid'],$arrPortalUser['PortalJUser']['id']),true);
								
								?>
									<td class="tb_col_data"><a href="<?php echo $strCandidateSeekerUrl;?>"><?php echo $arrPortalUser['PortalJUser']['cvname']; ?></a></td>
								<?php
							}
							else
							{
								?>
									<td class="tb_col_data">--</td>
								<?php
							}
						?>
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
					<td colspan='6'><span style="margin-left:20%;">No Registered Users</span></td>
				</tr>
			<?php
		}
	?>
	</table>
	
</div>