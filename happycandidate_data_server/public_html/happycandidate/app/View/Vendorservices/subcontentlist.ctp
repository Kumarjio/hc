<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>
<div class="index page-header row">
	<h1>Content</h1>
	<p class="lead">&nbsp;</p>
</div>
<div class="index row" id="product_list_notification"><?php echo $strMessage;?></div>
<div class="index sub-header row"><h2>Sub Content List</h2></div>
<div class="index row">
	<div class="col-md-12">
		<?php 
			$strProductIndexUrl = Router::url(array('controller'=>'content','action'=>'index'),true);
		?>
		<a href="<?php echo $strProductIndexUrl; ?>" class="btn btn-default btn-primary">Back</a>
	</div>
</div>
<div class="index col-md-12 table-responsive row">
	<table class="table table-striped">
	  <thead>
		<tr>
		  <th class="col-md-0.5">#</th>
		  <th class="col-md-3.5">Title</th>
		  <th class="col-md-1">Status</th>
		  <th class="col-md-2">Created On</th>
		  <!--<th class="col-md-2">Last Modified</th>-->
		  <th class="col-md-2.5">Action</th>
		</tr>
	  </thead>
	  <tbody>
		<?php
			if(is_array($arrProductList) && (count($arrProductList)>0))
			{
				$intContentCount = 0;
				foreach($arrProductList as $arrContent)
				{
					$intContentCount++;
					$strProductEditUrl = Router::url(array('controller'=>'content','action'=>'edit',$arrContent['Content']['content_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'content','action'=>'preview',"5",$arrContent['Content']['content_id']),true);
					?>
						<tr id="product_list_<?php echo $arrContent['Content']['content_id'];?>">
						  <td><?php echo $intContentCount; ?></td>
						  <td><a href="<?php echo $strProductEditUrl; ?>"><?php echo $arrContent['Content']['content_title']; ?></a></td>
						  <td><?php echo ucfirst($arrContent['Content']['content_status']); ?></td>
						  <td><?php echo date($productdateformat,strtotime($arrContent['Content']['created_date'])); ?></td>
						  <!--<td><?php echo $arrContent['Content']['modified_date']; ?></td>-->
						  <td><a href="<?php echo $strProductEditUrl; ?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo $strPreviewUrl; ?>" target="_blank">Preview</a>&nbsp;|&nbsp;<a onclick="fnDeleteProduct('<?php echo $arrContent['Content']['content_id'];?>')" href="javascript:void(0);">Delete</a></td>
						</tr>
					<?php
				}
				
				?>
				<tr>
					<td colspan='6' align='left'>
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
		?>
	  </tbody>
	</table>
</div>