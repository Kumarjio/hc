<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>
<div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="tab-header">
							<h3>Content Categories</h3>
								<?php
			$strVendoraddUrl = Router::url(array('controller'=>'contentcategories','action'=>'add'),true);
		?>
							<button onclick="javascript:location.href='<?php echo $strVendoraddUrl;?>'" type="button" class="btn btn-primary btn-sm">Add New</button>
						</div>
	<div class="tab-row-container ">
						
							<div class="tab-search">
						<?php
			$strProductSearchUrl = Router::url(array('controller'=>'contentcategories','action'=>'index'),true);
		?>
							<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>/" method="post" role="form">
								<input type="text" name="product_keyword" id="product_keyword" value="" name="search" placeholder="Search">
								<input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" />
								<button name="product_search" id="product_search" type="submit" class="btn btn-default btn-md">Search</button>
								</form>
							</div>
						</div>
						
						
						<!-- USER RESUME TOP CONTROLS -->
						<div class="tab-row-container">
						
							
						</div>
						
						<div class="tab-row-container">
							<div class="panel panel-default hidden-xs hidden-sm">
							  	<div class="panel-heading admin-content">
									<table>
										<tr>
											<th>ID</th>
											<th class="selected">Title<span></span></th>
											<th>Content User</th>
											<th>Created On</th>
											<th>Action</th>
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
					$strProductEditUrl = Router::url(array('controller'=>'contentcategories','action'=>'edit',$arrContent['Categories']['content_category_id']),true);
					?>
						<tr id="product_list_<?php echo $arrContent['Categories']['content_category_id'];?>">
						  <td><?php echo $intContentCount; ?></td>
						  <td><div class="user-title"><a href="<?php echo $strProductEditUrl; ?>"><?php echo $arrContent['Categories']['content_category_name']; ?></a></div></td>
						  <td>
							<?php 
								if($arrContent['Categories']['content_cat_for_user'] == "3")
								{
									echo "Job Seeker";
								}
								else
								{
									if($arrContent['Categories']['content_cat_for_user'] == "2")
									{
										echo "Portal Owner";
									}
								}
							?>
						  </td>
						  <td><?php echo date($productdateformat,strtotime($arrContent['Categories']['content_cat_created_date'])) ?></td>
						  <!--<td><?php echo $arrContent['Categories']['modified_date']; ?></td>-->
						  <td><a href="<?php echo $strProductEditUrl; ?>">Edit</a>&nbsp;|&nbsp;<a onclick="return fnDeleteContentCategories('<?php echo $arrContent['Categories']['content_category_id'];?>')" href="javascript:void(0);">Delete</a></td>
						</tr>
					<?php
				}
			}
		?>
					</table>
							 	</div>
							 	<div class="panel-footer admin-content">
							 		<table>
										<tr>
											<th>ID</th>
											<th class="selected">Title<span></span></th>
											<th>Content User</th>
											<th>Created On</th>
											<th>Action</th>
										</tr>
									</table>
							 	</div>
							</div>

					</div>
						
						<div class="tab-row-container">
							<div class="tab-controls-actions">
								
								
							</div>
							<div class="tab-controls-pagination">
			
					<div class="pagination pagination-large">
					<ul class="pagination">
							<?php
								echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
								echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
								echo $this->Paginator->next(__('next'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
							?>
						</ul>
					</div>
				
			
							</div>
						</div>
	                </div>
	            </div>
	        </div>
		<?php /*	
<div class="page-header index row">
	<h1>Content Categories</h1>
</div>
<div>&nbsp;</div>
<div id="product_list_notification" class="index row"><?php echo $strMessage;?></div>
<div class="sub-header index row"><h2>Category List</h2></div>
<div class="row index" style="width:100%;float:left;">
	<div class="col-md-12" style="width:100%;float:left;">
		<?php
			$strProductSearchUrl = Router::url(array('controller'=>'contentcategories','action'=>'index'),true);
		?>
		<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>" method="post" role="form">
			<div class="col-md-3 nopadding" style="float:left;width:20%;clear:none;"><input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" /><input type="text" class="form-control validate[required]" name="product_keyword" id="product_keyword" placeholder="Category title" /></div>
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
		  <th class="col-md-1">#</th>
		  <th class="col-md-4">Title</th>
		  <th class="col-md-4">Content User</th>
		  <th class="col-md-2">Created On</th>
		  <!--<th class="col-md-2">Last Modified</th>-->
		  <th class="col-md-2">Action</th>
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
					$strProductEditUrl = Router::url(array('controller'=>'contentcategories','action'=>'edit',$arrContent['Categories']['content_category_id']),true);
					?>
						<tr id="product_list_<?php echo $arrContent['Categories']['content_category_id'];?>">
						  <td><?php echo $intContentCount; ?></td>
						  <td><a href="<?php echo $strProductEditUrl; ?>"><?php echo $arrContent['Categories']['content_category_name']; ?></a></td>
						  <td>
							<?php 
								if($arrContent['Categories']['content_cat_for_user'] == "3")
								{
									echo "Job Seeker";
								}
								else
								{
									if($arrContent['Categories']['content_cat_for_user'] == "2")
									{
										echo "Portal Owner";
									}
								}
							?>
						  </td>
						  <td><?php echo date($productdateformat,strtotime($arrContent['Categories']['content_cat_created_date'])) ?></td>
						  <!--<td><?php echo $arrContent['Categories']['modified_date']; ?></td>-->
						  <td><a href="<?php echo $strProductEditUrl; ?>">Edit</a>&nbsp;|&nbsp;<a onclick="fnConfirmInquiryDelete('<?php echo $arrContent['Categories']['content_category_id'];?>')" href="javascript:void(0);">Delete</a></td>
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
</div> <?php */?>
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
				3: {
					// disable it by setting the property sorter to false
					sorter: false
				},
				// assign the third column (we start counting zero)
				5: {
					// disable it by setting the property sorter to false
					sorter: false
				}
				
			}
		});
	}
	);
</script>