<div class="tab-row-container">
	
	<div id="page-title">
		<h4>Job Seeker(s) Applied For Owner Jobs</h4>
	</div>
	<div class="panel panel-default" style="margin-top:10px;">
	<table cellpadding="0" cellspacing="0" width="100%" class="privatelabelsites">
	<tr class="hide-str">
			<th class="tb_col_head" width="5%">Sr.No.</th>
			<th class="tb_col_head" width="10%">Poratl Name</th>
			<th class="tb_col_head" width="10%">Over Time Money</th>
			
			
	</tr>
	<?php
	/*	print("<pre>");
		print_r($arrOverTimeMoneyList);*/
		
		if(is_array($arrOverTimeMoneyList) && (count($arrOverTimeMoneyList)>0))
		{
			$intForI = 0;
			$class = null;
			foreach($arrOverTimeMoneyList as $arrJob)
			{
				if ($intForI++ % 2 == 0) {
					$class = ' class="altrow"';
				}

			
				//echo '<pre>adasdasd',print_r($arrJob[0]);
				$monery=$arrJob[0]['OverTimeMonery'];
				$portal=$arrJob['career_portal']['career_portal_name'];
				
				?>
					<tr <?php echo $class;?>>
						<td class="tb_col_data"><?php echo $intForI;?></td>
						<td class="tb_col_data"><?php echo $portal; ?></td>
						<td class="tb_col_data"><?php echo $monery; ?></td>
						
						
						
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