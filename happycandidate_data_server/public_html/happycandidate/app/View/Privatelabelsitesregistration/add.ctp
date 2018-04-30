<?php
	echo $this->Html->script('privatelabelsitesregistration_add');
	
?>
<div class="users index">
	<h2>Create Registration Form</h2>
	<div style="height:20px;">
		&nbsp;
	</div>
	<?php 
		echo $this->Form->create('PortalRegistration',array('inputDefaults' => array(
																		'label' => false,
																		'div' => false,
																	  )
											 )
								);
	?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th colspan="2">Basic Information</th>
	</tr>
	<tr>
			<td style="width:27%;"><span id="madatsym" class="madatsym">*</span>Registration Form Name:</td>
			<td>
				<?php
					echo $this->Form->input('registration_form_name',array('style'=>'width:50%;font-size:90%;','type'=>'text','class'=>'validate[required]'));
					echo $this->Form->hidden('portal_id',array('value'=>$portal_id));
				?>
			</td>
	</tr>
	<?php
		if(is_array($arrSystemFields) && (count($arrSystemFields)>0))
		{
			?>
			<!--<tr>
					<td style="width:27%;">Use System Fields:</td>
					<td>
						<?php
							$options = array('1'=>'Yes, Use System Fields','0'=>'No, Create New Fields','2'=>'Both');
							echo $this->Form->input('system_fields', array('onchange'=>'fnToggleFieldsDisplay(this.value)','style'=>'font-size:90%;','options'=>$options,'selected'=>1));
							
						?>
					</td>
			</tr>-->
			<tr id="system_fields_row">
					<td style="width:27%;">Registration Fields:</td>
					<td>
						<?php
							foreach($arrSystemFields as $arrSystemField)
							{
								?>
								<div style="width:100%;float:left;font-weight:bold;">
									<?php echo $arrSystemField['FieldCategory']['field_category_name'];?>
								</div>
								<div style="width:100%;float:left;">
									<?php
										foreach($arrSystemField['fields'] as $arrSystemF)
										{
											?>
												<input type='checkbox' style='float:none;' name='fields[<?php echo $arrSystemField['FieldCategory']['field_category_id'];?>][]' id='fields_<?php echo $arrSystemF['fields_table']['field_id'];?>' value='<?php echo $arrSystemF['fields_table']['field_id'];?>' /><?php echo $arrSystemF['fields_table']['field_label'];?>
											<?php
										}
									?>
								</div>
								<?php
							}
						?>
					</td>
			</tr>
			<?php
		}
	?>
	<?php
		if(isset($arrSocialMediaPlugin))
		{
			?>
				<tr>
					<td style="width:27%;">Registration Social Media Plugin:</td>
					<td>
						<?php
							foreach($arrSocialMediaPlugin as $arrPlugin)
							{
								?>
									<input type="checkbox" style="float:none;" value="<?php echo $arrPlugin['SocialMedialPlugin']['social_media_plugin_id'];?>" name="social_media[]" id="<?php echo $arrPlugin['SocialMedialPlugin']['social_media_plugin_name']."_".$arrPlugin['SocialMedialPlugin']['social_media_plugin_type']; ?>" ><?php echo $arrPlugin['SocialMedialPlugin']['social_media_plugin_name']; ?> &nbsp;</input>
								<?php
							}
							//$strSocialMedialOptions = array('0'=>'Select','Facebook'=>'Facebook');
							//echo $this->Form->input('social_media', array('options'=>$strSocialMedialOptions));
						?>
					</td>
				</tr>
			<?php
		}
	?>
	<tr>
			<td colspan="2" align='center'>
				<?php
					$options = array(
						'label' => 'Create',
						'name' => 'create',
						'div' => array(
							'style' => 'padding-left:50%;',
						)
					);
					echo $this->Form->end($options);
				?>
			</td>
	</tr>
	</table>
</div>

<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('Create Registration Form', array('action' => 'add',$portal_id)); ?></li>
		<li><?php echo $this->Html->link('Back', array('action' => 'index',$portal_id)); ?></li>
	</ul>
</div>