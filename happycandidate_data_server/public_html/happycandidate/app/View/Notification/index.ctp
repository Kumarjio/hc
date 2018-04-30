<div class="wrapper">
	<div id="jop_search" class="jop_search">
		<h2 style="padding:0;margin-bottom:30px;background:none;padding:none;">Notifications</h2>
		<div style="height:20px;">
			&nbsp;
		</div>
		<table cellpadding="0" cellspacing="0">
		<tr>
				<th width="10%" align="left">Sr.No.</th>
				<th width="40%" align="left">Notification</th>
				<th class="actions" align="left">Actions</th>
		</tr>
		<tr>
				<td colspan='3'>&nbsp;</td>
		</tr>
		<?php
			/*print("<pre>");
			print_r($arrPortalPages);*/
			
			if(is_array($arrLoadNotification) && (count($arrLoadNotification)>0))
			{
				$intForI = 0;
				$class = null;
				foreach($arrLoadNotification as $arrNotification)
				{
					if ($intForI++ % 2 == 0) {
						$class = ' class="altrow"';
					}
					
					?>
						<tr <?php echo $class;?>>
							<td><?php echo $intForI;?></td>
							<td>
								<?php
									if($arrNotification['candidate_notifications']['notification_read'])
									{
										?>
										<span>
											<?php echo substr($arrNotification['reminders']['reminder_text'],0,40)."....";?>
										</span>
										<?php
									}
									else
									{
										?>
										<span style="font-weight:bold;">
											<?php echo substr($arrNotification['reminders']['reminder_text'],0,40)."....";?>
										</span>
										<?php
									}
								?>
							</td>
							<td class="actions" style="text-align:left;">
								<?php echo $this->Html->link('Detail',array('controller' => 'notification', 'action' => 'detail',$intPortalId,$arrNotification['candidate_notifications']['reminder_id'],$arrNotification['candidate_notifications']['notification_id']),array('target'=>'_blank','style'=>"margin:0px;")); ?>
								<?php 
									if($arrNotification['candidate_notifications']['notification_read'] == "0")
									{
										echo $this->Html->link('Mark As Read', array('action' => 'markasread',$intPortalId,$arrNotification['candidate_notifications']['notification_id']),array('style'=>"margin:0px;"));
									}
								 ?>
							</td>
						</tr>
					<?php
				}
			}
			else
			{
				?>
					<tr>
						<td colspan='3' class="altrow">&nbsp;</td>
					</tr>
					<tr>
						<td colspan='3'><span style="margin-left:20%;">No New Notifications present.</span></td>
					</tr>
				<?php
			}
		?>
		</table>
	</div>
</div>