<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>
<div class="page-header index row">
	<h1>Job Search Process Contents</h1>
</div>
<div id="product_list_notification"><?php echo $strMessage;?></div>
<div class="sub-header index row"><h2>Job Search Process Content List</h2></div>
<div class="index row" style="width:100%;float:left;">
	<div class="col-md-12" style="width:100%;float:left;">
		<?php
			$strProductSearchUrl = Router::url(array('controller'=>'jsprocessphase','action'=>'index'),true);
		?>
		<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>" method="post" role="form">
			<div class="col-md-3 nopadding" style="float:left;width:20%;clear:none;"><input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" /><input type="text" value="<?php echo $strKeywordSearch;?>" class="form-control validate[required]" name="product_keyword" id="product_keyword" placeholder="Content title" /></div>
			<div class="col-md-3 nopadding" style="float:left;width:20%;clear:none;">&nbsp;<input name="product_search" id="product_search" type="submit" value="Filter"></input></div>
		</form>
	</div>
</div>
<?php
	echo $this->element('delete_confirmation');
?>
<div class="index row" style="width:100%;float:left;">
	<table id="product_list" class="table tablesorter" style="width:80%;">
	  <thead>
		<tr>
		  <th class="col-md-1" style="width:5%;">#</th>
		  <th class="col-md-4" style="width:36%;">Title</th>
		  <th class="col-md-1" style="width:10%;">Status</th>
		  <th class="col-md-2" style="width:14%;">Content User</th>
		  <th class="col-md-2" style="width:15%;">Created On</th>
		  <!--<th class="col-md-2">Last Modified</th>-->
		  <th class="col-md-2" style="width:20%;">Action</th>
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
					$strProductEditUrl = Router::url(array('controller'=>'content','action'=>'edit',$arrContent['content']['content_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'content','action'=>'preview',"5",$arrContent['content']['content_id']),true);
					?>
						<tr id="product_list_<?php echo $arrContent['content']['content_id'];?>">
						  <td><?php echo $intContentCount; ?></td>
						  <td><a href="<?php echo $strProductEditUrl; ?>"><?php echo stripslashes($arrContent['content']['content_title']); ?></a></td>
						  <td><?php echo ucfirst($arrContent['content']['content_status']); ?></td>
						  <td>
							<?php
								if($arrContent['content']['content_for_user'] == "3")
								{
									echo "Job Seeker";
								}
								else
								{
									if($arrContent['content']['content_for_user'] == "2")
									{
										echo "Portal Owner";
									}
								}
							?>
						  </td>
						  <td><?php echo date($productdateformat,strtotime($arrContent['content']['created_date'])) ?></td>
						  <!--<td><?php echo $arrContent['content']['modified_date']; ?></td>-->
						  <td><a href="<?php echo $strProductEditUrl; ?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo $strPreviewUrl; ?>" target="_blank">Preview</a></td>
						</tr>
					<?php
				}
			}
		?>
	  </tbody>
	</table>
	<table class="table table-striped">
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
	</table>
</div>
<script type="text/javascript">
	$(document).ready(function()
	{
		$("#product_list").tablesorter({
			// pass the headers argument and assing a object
			headers: {
				// assign the secound column (we start counting zero)
				2: {
					// disable it by setting the property sorter to false
					sorter: false
				},
				// assign the third column (we start counting zero)
				4: {
					// disable it by setting the property sorter to false
					sorter: false
				}
				
			}
		});
	}
	);
</script>