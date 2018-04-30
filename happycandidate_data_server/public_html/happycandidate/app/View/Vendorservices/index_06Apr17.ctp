<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>
<?php
echo $this->Html->script('myorder_index');

?>
<div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="tab-header">
							<h3>Vendor Service List</h3>
								<?php
			$strVendoraddUrl = Router::url(array('controller'=>'vendorservices','action'=>'add'),true);
		?>
							<button onclick="javascript:location.href='<?php echo $strVendoraddUrl;?>'" type="button" class="btn btn-primary btn-sm">Add New</button>
						</div>
	<div class="tab-row-container ">
						
							<div class="tab-search">
							<?php
			$strProductSearchUrl = Router::url(array('controller'=>'vendorservices','action'=>'index'),true);
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
											<th class="selected">Vendor Name<span></span></th>
											<th>Service Name</th>
											<th>Status</th>
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
				//print("<pre>");
				//print_r($arrProductList);
				
				$intContentCount = 0;
				foreach($arrProductList as $arrContent)
				{
					$intContentCount++;
					$strProductEditUrl = Router::url(array('controller'=>'vendorservices','action'=>'edit',$arrContent['vendor_service']['vendor_service_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'vendorservice','action'=>'preview',"5",$arrContent['vendor_service']['vendor_service_id']),true);
					$strStatus = "Activate";
					if($arrContent['vendor_service']['status'] == "Active")
					{
						$strStatus = "Inactivate";
					}
					?>
						<tr id="product_list_<?php echo $arrContent['vendor_service']['vendor_service_id'];?>">
						  <td><?php echo $intContentCount; ?></td>
						  <td><div class="user-title"><?php echo stripslashes($arrContent['vendors']['vendor_name']); ?></div></td>
						  <td><?php echo $arrContent['Resources']['product_name']; ?></td>
						  <td id="status_col_<?php echo $arrContent['vendor_service']['vendor_service_id'];?>"><?php echo ucfirst($arrContent['vendor_service']['status']); ?></td>
						  <td><?php echo date($productdateformat,strtotime($arrContent['vendor_service']['vendor_service_creation_date'])) ?></td>
						  <td style="width:35%!important;"><a  href="<?php echo $strProductEditUrl; ?>">Edit</a> |<a onClick="return fnDeletevendorServiceProduct('<?php echo $arrContent['vendor_service']['vendor_service_id'];?>')" href="javascript:void(0);">Delete</a> | <a id="status_<?php echo $arrContent['vendor_service']['vendor_service_id'];?>" onClick="return fnChangevendorServiceProductStatus('<?php echo $arrContent['vendor_service']['vendor_service_id'];?>')" href="javascript:void(0);"><?php echo $strStatus ;?></a> | <a onClick="return fnReassignServiceProduct('<?php echo $arrContent['vendor_service']['vendor_service_id'];?>')" href="javascript:void(0);" >Reassign Step</a></td>
						</tr>
						<div id="myModal<?php echo $arrContent['vendor_service']['vendor_service_id'];?>" class="modal fade" role="dialog">
								  <div class="modal-dialog">

									<!-- Modal content-->
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Reassign Step</h4>
									  </div>
									  <div class="modal-body">
										<p id="model<?php echo $arrContent['vendor_service']['vendor_service_id'];?>">Some text in the modal.</p>
									  </div>
									  <div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									  </div>
									</div>

								  </div>
								</div>
					<?php
				}
			}
		?>
		
			
									</table>
							 	</div>
								
							 	<!--<div class="panel-footer admin-content">
							 		<table>
										<tr>
											<th>ID</th>
											<th class="selected">Vendor Name<span></span></th>
											<th>Service Name</th>
											<th>Created On</th>
											<th>Action</th>
										</tr>
									</table>
							 	</div>-->
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
	<h1>Vendor Services</h1>
</div>
<div>&nbsp;</div>
<div id="product_list_notification" class="index row"><?php echo $strMessage;?></div>
<div class="sub-header index row"><h2>Vendor Service List</h2></div>
<div class="row index" style="width:100%;float:left;">
	<div class="col-md-12" style="width:100%;float:left;">
		<?php
			$strProductSearchUrl = Router::url(array('controller'=>'vendorservices','action'=>'index'),true);
		?>
		<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>/" method="post" role="form">
			<div class="col-md-3 nopadding" style="float:left;width:20%;clear:none;"><input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" /><input type="text" class="form-control validate[required]" name="product_keyword" id="product_keyword" placeholder="Vendor title" /></div>
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
		  <th class="col-md-4" style="width:26%;">Vendor Name</th>
		  <th class="col-md-1" style="width:10%;">Service Name</th>
		  <th class="col-md-2" style="width:12%;">Created On</th>
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
					$strProductEditUrl = Router::url(array('controller'=>'vendorservice','action'=>'edit',$arrContent['vendor_service']['vendor_service_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'vendorservice','action'=>'preview',"5",$arrContent['vendor_service']['vendor_service_id']),true);
					?>
						<tr id="product_list_<?php echo $arrContent['vendor_service']['vendor_service_id'];?>">
						  <td><?php echo $intContentCount; ?></td>
						  <td><?php echo stripslashes($arrContent['Vendors']['vendor_name']); ?></td>
						  <td><?php echo $arrContent['Resources']['product_name']; ?></td>
						  <td><?php echo date($productdateformat,strtotime($arrContent['vendor_service']['vendor_service_creation_date'])) ?></td>
						  <td><a onclick="fnConfirmInquiryDelete('<?php echo $arrContent['vendor_service']['vendor_service_id'];?>')" href="javascript:void(0);">Delete</a></td>
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
				// assign the third column (we start counting zero)
				3: {
					// disable it by setting the property sorter to false
					sorter: false
				},
				4: {
					// disable it by setting the property sorter to false
					sorter: false
				}
			}
		});
	}
	);
</script>