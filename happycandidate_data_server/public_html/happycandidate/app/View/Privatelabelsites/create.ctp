<?php
	if($intAllowedToCreatePortal)
	{
		echo $this->Html->script('portal_create');
		?>
			<div class="users index">
				<h2>Create Portal</h2>
				<div style="height:20px;">
					&nbsp;
				</div>
				<?php 
					echo $this->Form->create('Portal',array('inputDefaults' => array(
																					'label' => false,
																					'div' => false,
																				  ),
															'type'=>'file'
														 )
											);
				?>
				<table cellpadding="0" cellspacing="0">
				<tr>
						<th colspan="2">Basic Information</th>
				</tr>
				<tr>
						<td style="width:27%;"><span id="madatsym" class="madatsym">*</span>Portal Name:</td>
						<td>
							<?php
								echo $this->Form->input('portal_name',array('style'=>'width:50%;font-size:90%;','type'=>'text','class'=>'validate[required,custom[onlyLetterSp]]'));
							?>
						</td>
				</tr>
				<tr>
						<td><span id="madatsym" class="madatsym">*</span>Portal Logo:</td>
						<td>
							<?php 
								echo $this->Form->file('portal_logo',array('style'=>'width:50%;font-size:90%;','class'=>'validate[required]'));
							?>
						</td>
				</tr>
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
					<li><?php echo $this->Html->link('Create Portal', array('action' => 'create')); ?></li>
				</ul>
			</div>
		
		<?php
	}
?>
