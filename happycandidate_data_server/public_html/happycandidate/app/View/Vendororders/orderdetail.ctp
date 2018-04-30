<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>

<div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-lg-12">
	                        <h3>Order Detail</h3>
	                        <div class="row">
	                        <div id="order_detail_action_container" class="order_display_fields pull-right" style="width:25%;"><!--<input onclick="fnShowEditableFields(this);return false;" type="submit" name="start_edit" id="start_edit" value="Edit"></input>&nbsp;--><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><input type="button" name="back" id="back" value="Back"></input></a></div>
			<div id="order_detail_action_container" class="order_editable_fields" style="display:none;width:25%;float:right"><input onclick="fnShowEditableFields(this);return false;" type="submit" name="done_edit" id="done_edit" value="Done"></input></div>
		
			<input type="hidden" name="order_id" id="order_id" value="<?php echo $intOrderMId; ?>" />
			
			</div>
	                        <div class="tab-row-container">
							<!--<div class="tab-filters">
								<a href="<?php echo $strVendorOrdersUrl; ?>" class="active">All <span>(5)</span></a> |
								<a href="<?php echo $strAdminNewUrl; ?>"  class="link-primary">New <span>(4)</span></a> |
								<a href="<?php echo $strAdminOpenUrl; ?>" class="link-primary">Open <span>(1)</span></a> |
								<a href="<?php echo $strAdminClosedUrl; ?>" class="link-primary">Closed <span>(1)</span></a>
							</div>-->
							
							<div class="row-container">
									
									<form role="form">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label " for="select-type">Customer Name:</label>
											<?php echo $arrProductList[0]['customer']['Candidate']['candidate_first_name']." ".$arrProductList[0]['customer']['Candidate']['candidate_last_name'];?>
											</div>
											<div class="form-group">
												<label class="control-label " for="person-name">Order(Service Request): <span class="form-required">*</span></label><!--
												--> <?php echo $arrProductList[0]['service']['Resources']['product_name'];?>
											</div>
											<div class="form-group">
												<label class="control-label " for="person-email">Consultant: <span class="form-required">*</span></label><!--
												--> <?php echo $arrCurrentUser['vendor_first_name']." ".$arrCurrentUser['vendor_last_name'];?>
											</div>
										<?php
											if($arrCurrentUser['parent_vendor'])
											{
												
											}
											else
											{
												?>
													<div class="form-group">
														<label class="control-label" for="person-email">Assigned To: <span class="form-required">*</span></label>
														<select class="form-control" name="vendoruser" id="vendoruser">
															<?php
																foreach($arrSubVendors as $arrVendor)
																{
																	?>
																		<option value="<?php echo $arrVendor['Vendors']['vendor_id'];?>"><?php echo $arrVendor['Vendors']['vendor_first_name']." ".$arrVendor['Vendors']['vendor_last_name'];?></option>
																	<?php
																}
															?>
														</select>
														<input type="button" class="btn btn-default" onclick="fnAssignOrderToSubVendor();" value="Assign" />
														<input type="hidden" name="vendor_order_id" id="vendor_order_id" value="<?php echo $arrProductList[0]['mainorder']['Resourceorder']['resource_order_id'];?>"/>
													</div>
													
												<?php
											}
										?>
												

											
											
										</div>

										<div class="col-md-6">
											<div class="form-group" >
												<label  class="control-label " for="select-type">Order Status:</label>
											<span id="right_label_answer_order_status" class="order_display_fields"><?php echo $arrProductList[0]['Resourceorderdetail']['vendor_order_state'];?></span>
													<div id="right_label_answer" class="order_editable_fields" style="display:none;">
														<select id="order_status" name="order_status">
															<option value="Open">Open</option>
															<option value="In-Process">In-Process</option>
															<option value="Closed">Closed</option>
														</select>
													</div>
											</div>
												
											<div class="form-group">
												<label class="control-label " for="person-name">Order Name: <span class="form-required">*</span></label><!--
												--> <?php echo $arrProductList[0]['mainorder']['Resourceorder']['order_name'];?>
											</div>
											<div class="form-group">
												<label class="control-label " for="person-email">Order Placed Date: <span class="form-required">*</span></label><!--
												-->	<?php echo date($productdateformat,strtotime($arrProductList[0]['Resourceorderdetail']['order_confirmation_date_time'])); ;?>
											</div>
											
										</div>

									</form>
								
			</div>

							<!-- CONTENT -->
							<div class="clear"></div>
							<?php
			
			$strUpdatesUrl = Router::url(array('controller'=>'vendororders','action'=>'addupdates',$intOrderMId),true);
		?>
							<h3 style="clear:both;">Order Updates<a style="float:right;" class="btn btn-default" href="<?php echo $strUpdatesUrl;?>">Add Updates</a></h3>
							<br>
							<div class="panel panel-default hidden-xs hidden-sm vendor-orders-container">
							  	<div class="panel-heading vendor-orders">
								
									<table>
										<tr>
										
											<th>Order #</th>
											<th>Customer Order ID</th>
											<th class="selected">From<span></span></th>
											<th>Subject</th>
											<th>Date</th>
										</tr>
									</table>
							  	</div>
							 	<div class="panel-body vendor-orders">
							 		<table>
							<?php
			if(is_array($arrServiceUpdates) && (count($arrServiceUpdates)>0))
			{
				//print("<pre>");
				//print_r($arrServiceUpdates);
				
				$intContentCount = 0;
				foreach($arrServiceUpdates as $arrContent)
				{
					$intContentCount++;
					$strProductEditUrl = Router::url(array('controller'=>'vendororders','action'=>'viewupdate',$intOrderMId,$arrContent['Serviceupdates']['order_service_update_id']),true);
					?>
					
					<tr id="product_list_<?php echo $arrContent['Serviceupdates']['order_detail_id'];?>" >
											<td>
												<div class="user-title">
													<a href="#str<?php echo $intContentCount; ?>" id="task1" class="username-clickable"><?php echo $intContentCount;?></a>
												</div>
											</td>
											<td><a href="<?php echo $strProductEditUrl; ?>"><?php echo $arrProductList[0]['mainorder']['Resourceorder']['order_name']; ?></a></td>
											<td><?php echo $arrContent['Serviceupdates']['updatefrom']; ?></td>
											<td id="order_status"><?php echo $arrContent['Serviceupdates']['order_service_subject']; ?></td>
											<td><?php echo date($productdateformat,strtotime($arrContent['Serviceupdates']['order_updated_on'])) ?></td>
										</tr>
					
						<tr id="str<?php echo $intContentCount; ?>" class="hide-str">
											<td colspan="5">
												<div id="task1-options" class="user-options">
													
													<a href="<?php echo $strProductEditUrl; ?>" class="link-primary">Edit</a>  
													<a onclick="fnConfirmInquiryClose('<?php echo $arrContent['Resourceorderdetail']['order_detail_id'];?>')" href="javascript:void(0);" class="link-primary">Close</a>
												</div>
											</td>
										</tr>
					<?php
				}
			}
		?>
										
										
										
										
										
										
									</table>
							 	</div>
							 	<div class="panel-footer vendor-orders">
							 		<table>
										<tr>
											<th>Order #</th>
											<th>Customer Order ID</th>
											<th class="selected">From<span></span></th>
											<th>Subject</th>
											<th>Date</th>
										</tr>
									</table>
							 	</div>
							</div>
							<!-- SMALL TABLE -->
							<div class="panel panel-default hidden-md hidden-lg vendor-orders-container">
							  	<div class="panel-heading small-view-orders">
									<table>
										<tr>
											<th>Order #</th>
											<th class="disabled">Options</th>
										</tr>
									</table>
							  	</div>
							 	<div class="panel-body small-view vendor-orders-small">
							 		<table>
										<tr>
											<td>
												<div class="user-title">
													<a class="username-clickable">1</a>
												</div>
											</td>
											<td>
												<div class="user-options visible">
													<a href="#" class="link-primary">View</a> |
													<a href="#" class="link-primary">Close</a>
												</div>
											</td>
										</tr>
										<tr class="selected">
											<td>
												<div class="user-title">
													<a class="username-clickable">2</a>
												</div>
											</td>
											<td>
												<div class="user-options visible">
													<a href="#" class="link-primary">View</a> |
													<a href="#" class="link-primary">Close</a>
												</div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="user-title">
													<a class="username-clickable">3</a>
												</div>
											</td>
											<td>
												<div class="user-options visible">
													<a href="#" class="link-primary">View</a> |
													<a href="#" class="link-primary">Close</a>
												</div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="user-title">
													<a class="username-clickable">4</a>
												</div>
											</td>
											<td>
												<div class="user-options visible">
													<a href="#" class="link-primary">View</a> |
													<a href="#" class="link-primary">Close</a>
												</div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="user-title">
													<a class="username-clickable">5</a>
												</div>
											</td>
											<td>
												<div class="user-options visible">
													<a href="#" class="link-primary">View</a> |
													<a href="#" class="link-primary">Close</a>
												</div>
											</td>
										</tr>
									</table>
							 	</div>
							 	<div class="panel-footer small-view-orders">
							 		<table>
										<tr>
											<th>Order #</th>
											<th class="disabled">Options</th>
										</tr>
									</table>
							 	</div>
							</div>
						</div>
	                    </div>
	                </div>
	            </div>
	        </div>
			<?php
	echo $this->element('delete_confirmation');
?>
<!--
<div class="page-header index row">
	<h1>Orders</h1>
</div>
<div>&nbsp;</div>
<div id="product_list_notification" class="index row"><?php echo $strMessage;?></div>
<div class="sub-header index row"><h2>Order Detail</h2></div>


<div class="row index" style="float:left;">
	<div id="order_detail_container" style="width:100%;float:left;">
		<div id="order_detail_action" style="width:100%;float:left;">
			<div id="order_detail_action_container" class="order_display_fields" style="float:right;width:5%;"><input onclick="fnShowEditableFields(this);return false;" type="submit" name="start_edit" id="start_edit" value="Edit"></input></div>
			<div id="order_detail_action_container" class="order_editable_fields" style="float:right;width:5%;display:none;"><input onclick="fnShowEditableFields(this);return false;" type="submit" name="done_edit" id="done_edit" value="Done"></input></div>
			<div id="order_done_loader" style="float:right;width:5%;display:none;"><img src="<?php echo Router::url('/',true); ?>img/load.gif" /></div>
			<input type="hidden" name="order_id" id="order_id" value="<?php echo $intOrderMId; ?>" />
		</div>
		<div id="order_left_detail_container" style="width:48%;float:left;margin-right:2%;">
			<div id="order_left_container" style="width:100%;float:left;">
				<div id="left_label" style="width:48%;float:left;">
					<label>Customer Name:</label>
				</div>
				<div id="right_label_answer" style="width:48%;float:left;">
					<?php echo $arrProductList[0]['customer']['Candidate']['candidate_first_name']." ".$arrProductList[0]['customer']['Candidate']['candidate_last_name'];?>
				</div>
			</div>
			<div id="order_left_container" style="width:100%;float:left;">
				<div id="left_label" style="width:48%;float:left;">
					<label>Order(Service Request):</label>
				</div>
				<div id="right_label_answer" style="width:48%;float:left;">
					<?php echo $arrProductList[0]['service']['Resources']['product_name'];?>
				</div>
			</div>
			<div id="order_left_container" style="width:100%;float:left;">
				<div id="left_label" style="width:48%;float:left;">
					<label>Consultant:</label>
				</div>
				<div id="right_label_answer" style="width:48%;float:left;">
					<?php echo $arrCurrentUser['vendor_first_name']." ".$arrCurrentUser['vendor_last_name'];?>
				</div>
			</div>
		</div>
		<div id="order_right_detail_container" style="width:48%;float:left;margin-right:2%;">
			<div id="order_right_container" style="width:100%;float:left;">
				<div id="left_label" style="width:48%;float:left;">
					<label>Order Status:</label>
				</div>
				<div id="right_label_answer_order_status" class="order_display_fields" style="width:48%;float:left;">
					<?php echo $arrProductList[0]['Resourceorderdetail']['vendor_order_state'];?>
				</div>
				<div id="right_label_answer" class="order_editable_fields" style="width:48%;float:left;display:none;">
					<select id="order_status" name="order_status">
						<option value="Open">Open</option>
						<option value="In-Process">In-Process</option>
						<option value="Closed">Closed</option>
					</select>
				</div>
			</div>
			<div id="order_right_container" style="width:100%;float:left;">
				<div id="left_label" style="width:48%;float:left;">
					<label>Order Name:</label>
				</div>
				<div id="right_label_answer" style="width:48%;float:left;">
					<?php echo $arrProductList[0]['mainorder']['Resourceorder']['order_name'];?>
				</div>
			</div>
			<div id="order_right_container" style="width:100%;float:left;">
				<div id="left_label" style="width:48%;float:left;">
					<label>Order Placed Date:</label>
				</div>
				<div id="right_label_answer" style="width:48%;float:left;">
					<?php echo date($productdateformat,strtotime($arrProductList[0]['Resourceorderdetail']['order_confirmation_date_time'])); ;?>
				</div>
			</div>
		</div>
	</div>
	<div style="float:left;width:100%;border-bottom:1px solid;">&nbsp;</div>
</div>
<div class="sub-header index row"><h2>Order Updates</h2></div>
<div class="row index" style="float:left;width:84%;">
	<div id="order_detail_container" style="width:100%;float:left;">
		<?php
			
			$strUpdatesUrl = Router::url(array('controller'=>'vendororders','action'=>'addupdates',$intOrderMId),true);
		?>
		<div style="float:left;width:100%;"><a style="float:right;" href="<?php echo $strUpdatesUrl;?>">Add Updates</a></div>
	</div>
	<div style="float:left;width:100%;border-bottom:1px solid;">&nbsp;</div>
	
	<table id="product_list" class="table tablesorter" style="width:100%;">
	  <thead>
		<tr>
		  <th class="col-md-1" style="width:3%;">#</th>
		  <th class="col-md-1" style="width:7%;">Order Id</th>
		  <th class="col-md-1" style="width:7%;">From</th>
		  <th class="col-md-4" style="width:11%;">Subject</th>
		  <th class="col-md-1" style="width:13%;">Date</th>
		  <th class="col-md-2" style="width:12%;">Action</th>
		</tr>
	  </thead>
	  <tbody>
		<?php
			if(is_array($arrServiceUpdates) && (count($arrServiceUpdates)>0))
			{
				//print("<pre>");
				//print_r($arrServiceUpdates);
				
				$intContentCount = 0;
				foreach($arrServiceUpdates as $arrContent)
				{
					$intContentCount++;
					$strProductEditUrl = Router::url(array('controller'=>'vendororders','action'=>'viewupdate',$intOrderMId,$arrContent['Serviceupdates']['order_service_update_id']),true);
					?>
						<tr id="product_list_<?php echo $arrContent['Serviceupdates']['order_detail_id'];?>">
						  <td><?php echo $intContentCount; ?></td>
						  <td><a href="<?php echo $strProductEditUrl; ?>"><?php echo $arrProductList[0]['mainorder']['Resourceorder']['order_name']; ?></a></td>
						  <td><?php echo $arrContent['Serviceupdates']['updatefrom']; ?></td>
						   <td><?php echo $arrContent['Serviceupdates']['order_service_subject']; ?></td>
						  <td><?php echo date($productdateformat,strtotime($arrContent['Serviceupdates']['order_updated_on'])) ?></td>
						  <td><a href="<?php echo $strProductEditUrl; ?>">View</a>&nbsp;</td>
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
<?php
	if(is_array($arrVendorWorkingDetail) && (count($arrVendorWorkingDetail)>0))
	{
		$strVendorId = $arrVendorWorkingDetail[0]['Subvendororders']['vendor_id'];
		
		?>
			<script type="text/javascript">
				var strVendorUserId = "<?php echo $strVendorId; ?>";
				if(strVendorUserId !="")
				{
					$('#vendoruser').val(strVendorUserId);
				}
			</script>
		<?php
	}
?>
