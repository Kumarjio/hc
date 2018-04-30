<?php
	$strPageDivideClass = "";
	if(is_array($arrPortals) && (count($arrPortals)==0))
	{
		$strPageDivideClass = "index";
	}
?>
<div class="users index container-layout <?php echo $strPageDivideClass;?>">
	
	<div id="page-title">
		<h3>My Career Portal</h3>
		</div>

	<table cellpadding="0" cellspacing="0" width="90%" class="privatelabelsites">
	<tr>
			<th class="tb_col_head">Sr.No.</th>
			<th class="tb_col_head" width="22%">Portal Name</th>
			<th class="tb_col_head" width="22%">Logo</th>
			<th class="tb_col_head">Active</th>
			<th class="actions tb_col_head">Actions</th>
	</tr>
	<?php
		/*print("<pre>");
		print_r($arrPortals);*/
		
		if(is_array($arrPortals) && (count($arrPortals)>0))
		{
			$intForI = 0;
			$class = null;
			foreach($arrPortals as $arrPortalsVal)
			{
				if ($intForI++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				
				?>
					<tr <?php echo $class;?>>
						<td class="tb_col_data"><?php echo $intForI;?></td>
						<td class="tb_col_data"><?php echo $this->Html->link($arrPortalsVal['Portal']['career_portal_name'],array('action' => 'edit',$arrPortalsVal['Portal']['career_portal_id']));?></td>
						<td class="tb_col_data">
							<div style="display:none;" id="logo_popup_image_<?php echo $arrPortalsVal['Portal']['career_portal_id'];?>">
								<?php echo $this->Html->image('/userdata/portal/'.$arrPortalsVal['Portal']['career_portal_logo'], array('alt'=>$arrPortalsVal['Portal']['career_portal_name'])); ?>
							</div>
							<?php $intPrivateSiteId = $arrPortalsVal['Portal']['career_portal_id']; ?>
							<?php echo $this->Html->image('/userdata/portal/'.$arrPortalsVal['Portal']['career_portal_thumb_logo'], array("onmouseover"=>"fnShowLogoPopup(".$intPrivateSiteId.")",'alt' => $arrPortalsVal['Portal']['career_portal_name'])); ?>
						</td>
						<td class="tb_col_data"><?php 
								if($arrPortalsVal['Portal']['career_portal_published'])
								{
									echo "Yes";
								}
								else
								{
									echo "No";
								}
							?>
						</td>
						<td class="actions tb_col_data" style="text-align:left;">
						
							<?php
								$strJobBoardsUri = $strLogoutUrl = Router::url(array('controller' => 'privatelabelsitejobboard', 'action' => 'index', $arrPortalsVal['Portal']['career_portal_id']),true);
								$strPortalAnalyticsUri = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'index', $arrPortalsVal['Portal']['career_portal_id']),true);
							
							?>
							<?php echo $this->Html->link('Domains',array('controller'=>'privatelabelsitesdomains','action' => 'index',$arrPortalsVal['Portal']['career_portal_id']),array('style'=>"margin:0px;")); ?>
							<?php echo $this->Html->link('Editor',array('action' => 'editor',$arrPortalsVal['Portal']['career_portal_id']),array('style'=>"margin:0px;")); ?>
							<!--<?php echo $this->Html->link('Pages',array('controller'=>'privatelabelsitespages','action' => 'index',$arrPortalsVal['Portal']['career_portal_id']),array('style'=>"margin:0px;")); ?>
							<?php echo $this->Html->link('Menus',array('controller'=>'privatelabelsitesmenu','action' => 'index',$arrPortalsVal['Portal']['career_portal_id']),array('style'=>"margin:0px;")); ?>
							<?php echo $this->Html->link('Registration',array('controller'=>'privatelabelsitesregistration','action' => 'index',$arrPortalsVal['Portal']['career_portal_id']),array('style'=>"margin:0px;")); ?>-->
							<a href="javascript:void(0);" style="margin:0px;" onClick="fnRedirectToJobBoards('<?php echo $strJobBoardsUri; ?>','<?php echo $arrPortalsVal['Portal']['career_portal_id'] ?>','<?php echo $intLoggedInUserId; ?>')">My Jobs</a>
							<a href="<?php echo $strPortalAnalyticsUri;?>">Analytics</a>
							<?php echo $this->Html->link('View',array('action' => 'view',$arrPortalsVal['Portal']['career_portal_id']),array('style'=>"margin:0px;",'target'=>'_blank')); ?>
							<!--<?php echo $this->Html->link('Edit',array('action' => 'edit',$arrPortalsVal['Portal']['career_portal_id']),array('style'=>"margin:0px;")); ?>-->
							<?php echo $this->Html->link('Delete', array('action' => 'delete',$arrPortalsVal['Portal']['career_portal_id']),array('style'=>"margin:0px;")); ?>
						</td>
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
					<td colspan='5' class="altrow">&nbsp;</td>
				</tr>
				<tr>
					<td colspan='5'><span style="margin-left:20%;">No Portals Created yet, You Need to Create Your Portal.</span></td>
				</tr>
			<?php
		}
	?>
	</table>
	
<?php
	if(is_array($arrPortals) && (count($arrPortals) == 0))
	{
		//echo "HI";exit;
		?>
		<div>
			<h3>Actions</h3>
			<ul>
				<li><?php echo $this->Html->link('Create Portal', array('action' => 'create')); ?></li>
			</ul>
		</div>
		<?php
	}
?>	
</div>