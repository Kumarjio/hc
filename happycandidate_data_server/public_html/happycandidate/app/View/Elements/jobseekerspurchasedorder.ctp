<div class="tab-row-container">
	
	<div id="page-title">
		<h4>Job seeker(s) Purchased Orders</h4>
	</div>
<div class="panel panel-default" style="margin-top:10px;">
	<table cellpadding="0" cellspacing="0" width="100%" class="privatelabelsites">
	<tr  class="hide-str">
			<th class="tb_col_head" width="5%">Sr.No.</th>
			<th class="tb_col_head" width="10%">First Name</th>
			<th class="tb_col_head" width="10%">Last Name</th>
			<th class="tb_col_head" width="25%">Email</th>
			
	</tr>
	<?php
		//print("<pre>");
	//	print_r($arrJobSeekerPurchaseOrderList);exit;
		
		if(is_array($arrJobSeekerPurchaseOrderList) && (count($arrJobSeekerPurchaseOrderList)>0))
		{
			$intForI = 0;
			$class = null;
			foreach($arrJobSeekerPurchaseOrderList as $arrJobSeekerPurchaseOrder)
			{
				if ($intForI++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				
				?>
					<tr <?php echo $class;?>>
						<td class="tb_col_data"><?php echo $intForI;?></td>
						<td class="tb_col_data"><?php echo $arrJobSeekerPurchaseOrder['career_portal_candidate']['candidate_first_name']; ?></td>
						<td class="tb_col_data"><?php echo $arrJobSeekerPurchaseOrder['career_portal_candidate']['candidate_last_name']; ?></td>
						<td class="tb_col_data"><?php echo $arrJobSeekerPurchaseOrder['career_portal_candidate']['candidate_email']; ?></td>
						
						
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
					<td colspan='8'><span style="margin-left:20%;">No Step process completed  job seeker</span></td>
				</tr>
			<?php
		}
	?>
	</table>
	
	</div>
</di