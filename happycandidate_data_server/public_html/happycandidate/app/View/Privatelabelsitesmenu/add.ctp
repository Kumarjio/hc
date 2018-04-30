<?php
	echo $this->Html->script('portalmenu_add');
?>
<div class="users index">
	<h2>Create Menu</h2>
	<div style="height:20px;">
		&nbsp;
	</div>
	<?php 
		echo $this->Form->create('TopMenu',array('inputDefaults' => array(
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
			<td style="width:27%;"><span id="madatsym" class="madatsym">*</span>Choose Page For Menu:</td>
			<td>
				<?php
					echo $this->Form->input('menu_page',array('options'=>$arrPageList,'style'=>'width:50%;font-size:90%;','class'=>'validate[required]'));
					echo $this->Form->hidden('portal_id',array('value'=>$portal_id));
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
		<li><?php echo $this->Html->link('Add Pages', array('action' => 'add',$portal_id)); ?></li>
		<li><?php echo $this->Html->link('Back', array('action' => 'index',$portal_id)); ?></li>
	</ul>
</div>