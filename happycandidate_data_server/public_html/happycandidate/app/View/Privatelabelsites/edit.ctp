<?php
	echo $this->Html->script('portal_edit');
?>
<div class="users index container-layout">

		<div id="page-title">
		<h3>My Create Portal</h3>
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
	<table cellpadding="0" cellspacing="8" width="500" class="Portal-panel">
	<tr>
			<th colspan="2">Basic Information</th>
	</tr>
	<tr>
			<td style="width:27%;"><span id="madatsym" class="madatsym">*</span>Portal Name:</td>
			<td>
				<?php
					echo $this->Form->input('portal_name',array('value'=>$arrPortals['0']['Portal']['career_portal_name'],'style'=>'font-size:90%;','type'=>'text','class'=>'validate[required,custom[onlyLetterSp]]'));
				?>
			</td>
	</tr>
	<tr>
			<td>Portal Logo:</td>
			<td>
				<?php 
					echo $this->Form->file('portal_logo',array('style'=>'width:50%;font-size:90%;'));
				?>
				&nbsp;
				<?php echo $this->Html->image('/userdata/portal/'.$arrPortals['0']['Portal']['career_portal_logo'], array('alt' => $arrPortals['0']['Portal']['career_portal_name'],'height'=>'20','width'=>'40')); ?>
				<?php echo $this->Form->hidden('portal_id',array('value'=>$arrPortals['0']['Portal']['career_portal_id']));?>
				<?php echo $this->Form->hidden('portal_image',array('value'=>$arrPortals['0']['Portal']['career_portal_logo']));?>
				<?php echo $this->Form->hidden('portal_thumb_image',array('value'=>$arrPortals['0']['Portal']['career_portal_thumb_logo']));?>
			</td>
	</tr>
	<tr>
			<td colspan="2" align='center'>
				<?php
					$options = array(
						'label' => 'Update',
						'name' => 'update',
						
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