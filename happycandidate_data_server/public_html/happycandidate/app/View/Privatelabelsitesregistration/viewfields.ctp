<div class="users index">
	<h2>Portal Registration Form Field</h2>
	<div style="height:20px;">
		&nbsp;
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th width="10%">Sr.No.</th>
			<th width="15%">Field Name</th>
			<th width="15%">Field Label</th>
			<th width="15%">Field Type</th>
			<th class="actions">Actions</th>
	</tr>
	<?php
		/*print("<pre>");
		print_r($arrRegistrationFieldDetail);*/
		
		if(is_array($arrRegistrationFieldDetail) && (count($arrRegistrationFieldDetail)>0))
		{
			$intForI = 0;
			$class = null;
			foreach($arrRegistrationFieldDetail as $arrRegistrationFieldDetailVal)
			{
				if ($intForI++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				
				?>
					<tr <?php echo $class;?>>
						<td><?php echo $intForI;?></td>
						<td><?php echo $arrRegistrationFieldDetailVal['fields_table']['field_name'];?></td>
						<td><?php echo $arrRegistrationFieldDetailVal['fields_table']['field_label'];?></td>
						<td><?php echo $arrRegistrationFieldDetailVal['fields_table']['field_type'];?></td>
						<td class="actions" style="text-align:left;">
							<!--<?php echo $this->Html->link('View Fields',array('action' => 'viewfields',base64_encode($arrPortalRegistrationVal['PortalRegistration']['career_registration_form_id']."_".$portal_id)),array('style'=>"margin:0px;")); ?>
							<?php echo $this->Html->link('Preview',array('action' => 'previewform',base64_encode($arrPortalRegistrationVal['PortalRegistration']['career_registration_form_id']."_".$portal_id)),array('target'=>'_blank','style'=>"margin:0px;")); ?>-->
							<?php echo $this->Html->link('Delete', array('action' => 'delete',base64_encode($arrRegistrationFieldDetailVal['fields_table']['field_id']."_".$portal_id)),array('style'=>"margin:0px;")); ?>
						</td>
					</tr>
				<?php
			}
		}
		else
		{
			?>
				<tr>
					<td colspan='5' class="altrow">&nbsp;</td>
				</tr>
				<tr>
					<td colspan='5'><span style="margin-left:20%;">No Registration Form Created for Portal, You Need to Create Registration form for Portal.</span></td>
				</tr>
			<?php
		}
	?>
	</table>
	
</div>
<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('Back', array('action' => 'index',$portal_id)); ?></li>
	</ul>
</div>