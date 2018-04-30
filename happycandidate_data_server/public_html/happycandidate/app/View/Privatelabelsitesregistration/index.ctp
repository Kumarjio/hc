<div class="users index">
	<h2>Portal Registration Forms</h2>
	<div style="height:20px;">
		&nbsp;
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th width="10%">Sr.No.</th>
			<th width="40%">Registration Title</th>
			<th width="12%">Active</th>
			<th class="actions">Actions</th>
	</tr>
	<?php
		/*print("<pre>");
		print_r($arrPortalPages);*/
		
		if(is_array($arrPortalRegistration) && (count($arrPortalRegistration)>0))
		{
			$intForI = 0;
			$class = null;
			foreach($arrPortalRegistration as $arrPortalRegistrationVal)
			{
				if ($intForI++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				
				?>
					<tr <?php echo $class;?>>
						<td><?php echo $intForI;?></td>
						<td><?php echo $this->Html->link($arrPortalRegistrationVal['PortalRegistration']['career_registration_form_name'],array('action' => 'edit',base64_encode($arrPortalRegistrationVal['PortalRegistration']['career_registration_form_id']."_".$portal_id)));?></td>
						<td>
							<?php 
								if($arrPortalRegistrationVal['PortalRegistration']['career_registration_form_is_active'])
								{
									?>
									<b>
										<?php echo "Yes"; ?>
									</b>
									<?php
								}
								else
								{
									echo $this->Html->link("No",array('action'=>'activate',base64_encode($arrPortalRegistrationVal['PortalRegistration']['career_registration_form_id']."_".$portal_id)));
								}
							?>
						</td>
						<td class="actions" style="text-align:left;">
							<?php echo $this->Html->link('View Fields',array('action' => 'viewfields',base64_encode($arrPortalRegistrationVal['PortalRegistration']['career_registration_form_id']."_".$portal_id)),array('style'=>"margin:0px;")); ?>
							<?php echo $this->Html->link('Preview',array('action' => 'previewform',base64_encode($arrPortalRegistrationVal['PortalRegistration']['career_registration_form_id']."_".$portal_id)),array('target'=>'_blank','style'=>"margin:0px;")); ?>
							<?php echo $this->Html->link('Delete', array('action' => 'delete',base64_encode($arrPortalRegistrationVal['PortalRegistration']['career_registration_form_id']."_".$portal_id)),array('style'=>"margin:0px;")); ?>
						</td>
					</tr>
				<?php
			}
		}
		else
		{
			?>
				<tr>
					<td colspan='4' class="altrow">&nbsp;</td>
				</tr>
				<tr>
					<td colspan='4'><span style="margin-left:20%;">No Registration Form Created for Portal, You Need to Create Registration form for Portal.</span></td>
				</tr>
			<?php
		}
	?>
	</table>
	
</div>
<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('Create Registration Form', array('action' => 'add',$portal_id)); ?></li>
	</ul>
</div>