<div class="users index">
	<h2>Portal Menus</h2>
	<div style="height:20px;">
		&nbsp;
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th width="10%">Sr.No.</th>
			<th width="20%">Menu Name</th>
			<!--<th width="20%">Menu Page</th>-->
			<th class="actions">Actions</th>
	</tr>
	<?php
		/*print("<pre>");
		print_r($arrPortalPages);*/
		
		if(is_array($arrPortalTopMenu) && (count($arrPortalTopMenu)>0))
		{
			$intForI = 0;
			$class = null;
			foreach($arrPortalTopMenu as $arrPortalTopMenuVal)
			{
				if ($intForI++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				
				?>
					<tr <?php echo $class;?>>
						<td><?php echo $intForI;?></td>
						<td><?php echo $arrPortalTopMenuVal['TopMenu']['career_portal_menu_name'];?></td>
						<!--<td><?php echo $arrPortalTopMenuVal['TopMenu']['career_portal_menu_page_id'];?></td>-->
						<td class="actions" style="text-align:left;">
							<?php echo $this->Html->link('Preview',array('controller' => 'privatelabelsitespages', 'action' => 'preview',base64_encode($arrPortalTopMenuVal['TopMenu']['career_portal_menu_page_id']."_".$arrPortalTopMenuVal['TopMenu']['career_portal_id'])),array('target'=>'_blank','style'=>"margin:0px;")); ?>
							<?php echo $this->Html->link('Delete', array('action' => 'delete',base64_encode($arrPortalTopMenuVal['TopMenu']['career_portal_menu_alloc_id']."_".$portal_id)),array('style'=>"margin:0px;")); ?>
						</td>
					</tr>
				<?php
			}
			?>
				<tr>
					<td colspan='3' align='left'>
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
					<td colspan='3' class="altrow">&nbsp;</td>
				</tr>
				<tr>
					<td colspan='3'><span style="margin-left:20%;">No Menu Allocated for  Portal, You Need to Allocate Menus for the Portal.</span></td>
				</tr>
			<?php
		}
	?>
	</table>
	
</div>
<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('Add Top Menu', array('action' => 'add',$portal_id)); ?></li>
	</ul>
</div>