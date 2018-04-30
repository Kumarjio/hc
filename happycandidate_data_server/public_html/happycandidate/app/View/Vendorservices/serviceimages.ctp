<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>
<div class="page-header index row">
	<h1>Services</h1>
</div>
<div>&nbsp;</div>
<div id="product_list_notification" class="index row"><?php echo $strMessage;?></div>
<div class="sub-header index row"><h2>Service Image List</h2></div>
<div class="row index" style="width:100%;float:left;">
	<div class="col-md-12" style="width:100%;float:left;">
		<?php
			$strProductSearchUrl = Router::url(array('controller'=>'resource','action'=>'serviceimages'),true);
		?>
		<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>" method="post" role="form">
			<div class="col-md-3 nopadding" style="float:left;width:20%;clear:none;"><input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" /><input type="text" class="form-control validate[required]" name="product_keyword" id="product_keyword" placeholder="Image title" /></div>
			<div class="col-md-3 nopadding" style="float:left;width:20%;clear:none;">
				&nbsp;<input name="product_search" id="product_search" class="btn btn-default btn-primary" type="submit" value="Filter"></input>
			</div>
		</form>
	</div>
</div>
<?php
	echo $this->element('delete_confirmation');
?>
<div class="row index" style="width:100%;float:left;">
	<table id="product_list" class="table tablesorter" style="width:80%;">
	  <thead>
		<tr>
		  <th class="col-md-1" style="width:5%;">#</th>
		  <th class="col-md-4" style="width:26%;">Image</th>
		  <th class="col-md-1" style="width:10%;">Preview</th>
		  <th class="col-md-1" style="width:10%;">Service</th>
		  <th class="col-md-2" style="width:12%;">Added On</th>
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
					$strProductEditUrl = Router::url(array('controller'=>'resource','action'=>'edit',$arrContent['product_images']['product_images_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'resource','action'=>'preview',"5",$arrContent['product_images']['product_images_id']),true);
					?>
						<tr id="product_list_<?php echo $arrContent['product_images']['product_images_id'];?>">
						  <td><?php echo $intContentCount; ?></td>
						  <td><?php echo stripslashes($arrContent['product_images']['product_image']); ?></td>
						  <td><img src="<?php echo Router::url('/',true)."productfiles/thumbnail/".$arrContent['product_images']['product_image'];?>"></td>
						  <td><?php echo $arrContent['product_images']['service']; ?></td>
						  <td><?php echo date($productdateformat,strtotime($arrContent['product_images']['product_image_creation_date'])) ?></td>
						  <td><a onclick="fnConfirmInquiryDelete('<?php echo $arrContent['product_images']['product_images_id'];?>')" href="javascript:void(0);">Delete</a></td>
						</tr>
					<?php
				}
			}
		?>
	  </tbody>
	</table>
	<table class="table table-striped" style="width:80%;">
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
				// assign the third column (we start counting zero)
				2: {
					// disable it by setting the property sorter to false
					sorter: false
				},
				3: {
					// disable it by setting the property sorter to false
					sorter: false
				},
				4: {
					// disable it by setting the property sorter to false
					sorter: false
				},
				5: {
					// disable it by setting the property sorter to false
					sorter: false
				}
			}
		});
	}
	);
</script>