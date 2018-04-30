<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>

<div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="tab-header">
							<h3>Service Images</h3>
											<?php
			$strProductaddUrl = Router::url(array('controller'=>'resource','action'=>'addimage'),true);
		?>
							<button type="button" onclick="javascript:location.href='<?php echo $strProductaddUrl;?>'" class="btn btn-primary btn-sm">Add New</button>
						</div>
						<div id="product_list_notification" class="index row"><?php echo $strMessage;?></div>

<div class="tab-row-container ">
						
							<div class="tab-search">
							<?php
		$strProductSearchUrl = Router::url(array('controller'=>'resource','action'=>'serviceimages'),true);
		?>
							<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>" method="post" role="form">
								<input type="text" name="product_keyword" id="product_keyword" value="" name="search" placeholder="Search">
								<input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" />
								<button name="product_search" id="product_search" type="submit" class="btn btn-default btn-md">Search</button>
								</form>
							</div>
						</div>
								
						<!-- USER RESUME TOP CONTROLS -->
							<!--<div class="tab-row-container">
							<div class="tab-controls-actions">
								<div class="form-group">
									<select name="bulk-actions" title="Bulk Actions">
										<option value="value1">Bulk Action1</option>
										<option value="value2">Bulk Action2</option>
										<option value="value3">Bulk Action3</option>
										<option value="value4">Bulk Action4</option>
									</select>
									<button type="button" class="btn btn-default btn-md">Apply</button>
								</div>
								<div class="form-group">
									<select name="date-filter" title="Date Filter">
										<option value="value1">Date Filter1</option>
										<option value="value2">Date Filter2</option>
										<option value="value3">Date Filter3</option>
										<option value="value4">Date Filter4</option>
									</select>
									<button type="button" class="btn btn-default btn-md">Filter</button>
								</div>
							</div>
							<div class="tab-controls-pagination">
								<button type="button" class="btn btn-default disabled items-counter"><span>5 items</span></button>
								<button type="button" class="btn btn-default disabled goto-beginning"><span></span></button>
								<button type="button" class="btn btn-default disabled goto-previous"><span></span></button>
								<input type="text" value="" name="input-page-number" placeholder="1">
								<button type="button" class="btn btn-default disabled pages-counter"><span>of 3</span></button>
								<button type="button" class="btn btn-default goto-next-active"><span></span></button>
								<button type="button" class="btn btn-default goto-end-active"><span></span></button>
							</div>
						</div>-->
						
						<div class="tab-row-container">
							<div class="panel panel-default hidden-xs hidden-sm">
							  	<div class="panel-heading admin-content">
									<table>
										<tr>
											<th>ID  #</th>
											<th class="selected">Image<span></span></th>
												<th>Preview</th>
											<th>Service </th>
											<th>Added On </th>
										</tr>
									</table>
							  	</div>
							 	<div class="panel-body admin-content">
							 		<table>
				<?php
			if(is_array($arrProductList) && (count($arrProductList)>0))
			{
				$intContentCount = 0;
				foreach($arrProductList as $arrContent)
				{
					$intContentCount++;
					$strProductEditUrl = Router::url(array('controller'=>'resource','action'=>'editimage',$arrContent['product_images']['product_images_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'resource','action'=>'preview',"5",$arrContent['product_images']['product_images_id']),true);
					?>				
					
					<tr id="product_list_<?php echo $arrContent['product_images']['product_images_id'];?>">
						  <td><?php echo $intContentCount; ?></td>
						  <td>
								<div class="user-title">
													<a href="#str<?php echo $arrContent['product_images']['product_images_id'];?>" id="task1" class="username-clickable"><?php echo stripslashes($arrContent['product_images']['product_image']); ?></a>
												</div>
						  </td>
						  <td><img src="<?php echo Router::url('/',true)."productfiles/thumbnail/".$arrContent['product_images']['product_image'];?>"></td>
						  <td><?php echo $arrContent['product_images']['service']; ?></td>
						  <td><?php echo date($productdateformat,strtotime($arrContent['product_images']['product_image_creation_date'])) ?></td>
						
						</tr>
								<tr id="str<?php echo $arrContent['product_images']['product_images_id'];?>" class="hide-str">
											<td></td>
											<td colspan="5">
												<div id="task1-options" class="user-options">
													<a href="#" id="serviceimage_del_<?php echo $arrContent['product_images']['product_images_id'];?>" onClick="return fnDeleteServiceImage(this);" class="link-warning">Delete</a>
													&nbsp; | &nbsp;
													<a href="<?php echo $strProductEditUrl; ?>" id="serviceimage_del_<?php echo $arrContent['product_images']['product_images_id'];?>">Edit</a>
												</div>
											</td>
										</tr>
									
									<?php
				}
			}
		?>
									</table>
							 	</div>
							 	<!--<div class="panel-footer admin-content">
							 		<table>
										<tr>
											<th>ID  #</th>
											<th class="selected">Image<span></span></th>
												<th>Preview</th>
											<th>Service </th>
											<th>Added On </th>
										</tr>
									</table>
							 	</div>-->
							</div>

							
						</div>
						
						<!--<div class="tab-row-container">
							<div class="tab-controls-actions">
								<div class="form-group">
									<select name="bulk-actions" title="Bulk Actions">
										<option value="value1">Bulk Action1</option>
										<option value="value2">Bulk Action2</option>
										<option value="value3">Bulk Action3</option>
										<option value="value4">Bulk Action4</option>
									</select>
									<button type="button" class="btn btn-default btn-md">Apply</button>
								</div>
								<div class="form-group">
									<select name="date-filter" title="Date Filter">
										<option value="value1">Date Filter1</option>
										<option value="value2">Date Filter2</option>
										<option value="value3">Date Filter3</option>
										<option value="value4">Date Filter4</option>
									</select>
									<button type="button" class="btn btn-default btn-md">Filter</button>
								</div>
							</div>-->
							<div class="tab-controls-pagination">
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
						</div>
	                </div>
	            </div>
	        </div>
			
			
<?php /*
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
</div>*/?>
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
		 $(".panel-body.admin-content .user-title a").click(function(event) {
				
				$(this.getAttribute("href")).css('display', 'table-row');
				$(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
			});
	}
	);
</script>