<div class="users index">
	<h2>Portal Pages</h2>
	<div style="height:20px;">
		&nbsp;
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th width="10%">Sr.No.</th>
			<th width="40%">Page Title</th>
			<th width="12%">Home Page</th>
			<th class="actions">Actions</th>
	</tr>
	<?php
		/*print("<pre>");
		print_r($arrPortalPages);*/
		
		if(is_array($arrPortalPages) && (count($arrPortalPages)>0))
		{
			$intForI = 0;
			$class = null;
			foreach($arrPortalPages as $arrPortalPagesVal)
			{
				if ($intForI++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				
				?>
					<tr <?php echo $class;?>>
						<td><?php echo $intForI;?></td>
						<td><?php echo $this->Html->link($arrPortalPagesVal['PortalPages']['career_portal_page_tittle'],array('action' => 'edit',base64_encode($arrPortalPagesVal['PortalPages']['career_portal_page_id']."_".$portal_id)));?></td>
						<td>
							<?php 
								if($arrPortalPagesVal['PortalPages']['is_career_portal_home_page'])
								{
									?>
									<b>
										<?php echo "Yes"; ?>
									</b>
									<?php
								}
								else
								{
									echo $this->Html->link("No",array('action'=>'sethomepage',base64_encode($arrPortalPagesVal['PortalPages']['career_portal_page_id']."_".$portal_id)));
								}
							?>
						</td>
						<td class="actions" style="text-align:left;">
							<!--<?php echo $this->Html->link('Edit',array('action' => 'edit',base64_encode($arrPortalPagesVal['PortalPages']['career_portal_page_id']."_".$portal_id)),array('style'=>"margin:0px;")); ?>-->
							<?php echo $this->Html->link('Preview',array('action' => 'preview',base64_encode($arrPortalPagesVal['PortalPages']['career_portal_page_id']."_".$portal_id)),array('target'=>'_blank','style'=>"margin:0px;")); ?>
							<?php echo $this->Html->link('Delete', array('action' => 'delete',base64_encode($arrPortalPagesVal['PortalPages']['career_portal_page_id']."_".$portal_id)),array('style'=>"margin:0px;")); ?>
						</td>
					</tr>
				<?php
			}
			?>
				<tr>
					<td colspan='4' align='left'>
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
					<td colspan='4' class="altrow">&nbsp;</td>
				</tr>
				<tr>
					<td colspan='4'><span style="margin-left:20%;">No Pages Created for Portal, You Need to Add pages for Your Portal.</span></td>
				</tr>
			<?php
		}
	?>
	</table>
	
</div>
<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('Add Pages', array('action' => 'add',$portal_id)); ?></li>
	</ul>
</div>