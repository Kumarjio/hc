<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>
	<?php
$strAdminHomeUrl = Router::url(array('controller'=>'vendoraccount','action'=>'dashboard'),true);
					$strVendorOrdersUrl = Router::url(array('controller'=>'vendororders','action'=>'index'),true);
					$strAdminNewUrl = Router::url(array('controller'=>'vendororders','action'=>'neworders'),true);
					$strAdminOpenUrl = Router::url(array('controller'=>'vendororders','action'=>'openorders'),true);
					$strAdminPendingUrl = Router::url(array('controller'=>'vendororders','action'=>'pendingorders'),true);
					$strAdminClosedUrl = Router::url(array('controller'=>'vendororders','action'=>'closedorders'),true);
?>
	        <div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-lg-12">
	                        <h1>Vendor Orders</h1>
	                       <!-- <p>Sed cursus id libero molestie ullamcorper. Nullam cursus mauris in enim interdum varius. Integer ex risus, dignissim nec placerat ac, mattis vitae augue.</p>-->
	                        
	                        <div class="tab-row-container">
							<div class="tab-filters">
								<a href="<?php echo $strVendorOrdersUrl; ?>" class="active">All </a> |
								<a href="<?php echo $strAdminNewUrl; ?>"  class="link-primary">New </a> |
								<a href="<?php echo $strAdminOpenUrl; ?>" class="link-primary">Open</a> |
								<a href="<?php echo $strAdminPendingUrl; ?>" class="link-primary">Pending</a> |
								<a href="<?php echo $strAdminClosedUrl; ?>" class="link-primary">Closed</a>
							</div>

							<!-- CONTENT -->
							<div class="panel panel-default hidden-xs hidden-sm vendor-orders-container">
							  	<div class="panel-heading vendor-orders">
									<table>
										<tr>
										
											<th>Order #</th>
											<th>Customer Order ID</th>
											<th class="selected">Service Title<span></span></th>
											<th>Order Status</th>
											<th>Assigned To</th>
											<th>Purchase Date</th>
										</tr>
									</table>
							  	</div>
							 	<div class="panel-body vendor-orders">
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
					$strProductEditUrl = Router::url(array('controller'=>'vendororders','action'=>'orderdetail',$arrContent['Resourceorderdetail']['order_detail_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'vendors','action'=>'preview',"5",$arrContent['vendors']['vendor_id']),true);
					
					$arrSubVendorUser = $arrContent['vendorsuser'];
					?>
					<tr >
											<td>
												
													<?php echo $intContentCount;?>
											
											</td>
											<td>
											<div class="user-title">
													<a href="#str<?php echo $arrContent['Resourceorderdetail']['order_detail_id'];?>" id="task1" class="username-clickable"><?php echo $arrContent['mainorder']['Resourceorder']['order_name']; ?></a>
											</div>
											</td>
											<td><?php echo stripslashes($arrContent['service']['Resources']['product_name']); ?></td>
											<td id="order_status_<?php echo $arrContent['Resourceorderdetail']['order_detail_id'];?>"><?php echo $arrContent['Resourceorderdetail']['vendor_order_state']; ?></td>
											<td><?php 
												if(is_array($arrSubVendorUser) && (count($arrSubVendorUser)>0))
												{
													echo $arrSubVendorUser['Vendors']['vendor_first_name']." ".$arrSubVendorUser['Vendors']['vendor_last_name'];
												}
												else
												{
													echo "Not Assigned";
												}
											
											?></td>
											
											<td><?php echo date($productdateformat,strtotime($arrContent['Resourceorderdetail']['order_confirmation_date_time'])) ?></td>
										</tr>
					
									<tr id="str<?php echo $arrContent['Resourceorderdetail']['order_detail_id'];?>" class="hide-str">
									<td>
									</td>
											<td colspan="4">
												<div id="task1-options" class="user-options">
													<a href="<?php echo $strProductEditUrl; ?>" class="link-primary">Issue Refund</a> |
													<a href="<?php echo $strProductEditUrl; ?>" class="link-primary">Cancel Order</a>
												</div>
											</td>
										</tr>
					<?php
				}
			}
		?>
										
										
										
										
										
										
									</table>
							 	</div>					
						</div>
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
<?php
	echo $this->element('subvendor_assign_modal');
?>	  
<!--<div class="page-header index row">
	<h1>Orders</h1>
</div>
<div>&nbsp;</div>
<div id="product_list_notification" class="index row"><?php echo $strMessage;?></div>
<div class="sub-header index row"><h2>Orders</h2></div>
<div class="row index" style="width:100%;float:left;">
	<div class="col-md-12" style="width:100%;float:left;">
		<?php
			$strProductSearchUrl = Router::url(array('controller'=>'vendors','action'=>'index'),true);
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
	//echo $this->element('delete_confirmation');
	echo $this->element('close_confirmation');
?>
<!--<div class="row index" style="width:100%;float:left;">
	<table id="product_list" class="table tablesorter" style="width:80%;">
	  <thead>
		<tr>
		  <th class="col-md-1" style="width:3%;">#</th>
		  <th class="col-md-1" style="width:7%;">Customer Order Id</th>
		  <th class="col-md-4" style="width:11%;">Service Request</th>
		  <th class="col-md-1" style="width:13%;">Customer Name</th>
		  <th class="col-md-2" style="width:8%;">Order Status</th>
		  <th class="col-md-2" style="width:6%;">Created On</th>
		  <th class="col-md-2" style="width:12%;">Action</th>
		</tr>
	  </thead>
	  <tbody>
		<?php
			if(is_array($arrProductList) && (count($arrProductList)>0))
			{
				//print("<pre>");
				//print_r($arrProductList);
				
				$intContentCount = 0;
				foreach($arrProductList as $arrContent)
				{
					$intContentCount++;
					$strProductEditUrl = Router::url(array('controller'=>'vendororders','action'=>'orderdetail',$arrContent['Resourceorderdetail']['order_detail_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'vendors','action'=>'preview',"5",$arrContent['vendors']['vendor_id']),true);
					?>
						<tr id="product_list_<?php echo $arrContent['Resourceorderdetail']['order_detail_id'];?>">
						  <td><?php echo $intContentCount; ?></td>
						  <td><a href="<?php echo $strProductEditUrl; ?>"><?php echo $arrContent['mainorder']['Resourceorder']['order_name']; ?></a></td>
						  <td><?php echo stripslashes($arrContent['service']['Resources']['product_name']); ?></td>
						  <td><?php echo $arrContent['customer']['Candidate']['candidate_first_name']." ".$arrContent['customer']['Candidate']['candidate_last_name']; ?></td>
						   <td id="order_status_<?php echo $arrContent['Resourceorderdetail']['order_detail_id'];?>"><?php echo $arrContent['Resourceorderdetail']['vendor_order_state']; ?></td>
						  <td><?php echo date($productdateformat,strtotime($arrContent['Resourceorderdetail']['order_confirmation_date_time'])) ?></td>
						  <td><a href="<?php echo $strProductEditUrl; ?>">View</a>&nbsp;|&nbsp;<a href="<?php echo $strProductEditUrl; ?>">Edit</a>|&nbsp;<a onclick="fnConfirmInquiryClose('<?php echo $arrContent['Resourceorderdetail']['order_detail_id'];?>')" href="javascript:void(0);">Close</a></td>
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
</div>-->
<script type="text/javascript">
	$(document).ready(function()
	{
		$("#product_list").tablesorter({
			// pass the headers argument and assing a object
			headers: {
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
<script type="text/javascript">
 /*$(".panel-body.vendor-orders .user-title a").click(function(event) {
				
				$(this.getAttribute("href")).css('display', 'table-row');
				$(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
			});*/
			
	$(".panel-body.vendor-orders .user-title a").click(function(event) {
    event.preventDefault();
    $(this.getAttribute("href")).css('display', 'table-row');
    $(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
   });
	
 function fnLoadSubVendorList(ele)
 {
	var strVDetail = $(ele).attr('id');
	var strAction = $(ele).text();
	
	var arrVDetail = strVDetail.split("_");
	var intOrderId = arrVDetail[2];
	$('#vendor_order_id').val(intOrderId);
	$('#action').val(strAction);
	
	if(strAction == "Assign")
	{
		$('#assignbtn').show();
		$('#unassignbtn').hide();
	}
	else
	{
		$('#unassignbtn').show();
		$('#assignbtn').hide();
	}
	
	
	$('#subvendorModal').modal('show');
 }
</script>