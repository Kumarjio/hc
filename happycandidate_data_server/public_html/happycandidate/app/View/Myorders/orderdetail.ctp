<?php
	echo $this->Html->script('myorder_index');
?>
<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});
	
	function fnShowCloseConfirmation(ele,intPortalId)
	{
		var intOrderId = $('#order_id').val();
		$('#close_for').val(intOrderId);
		$('#close_port_for').val(intPortalId);
		$("#close_delete_new").modal('show');
	}

</script>

<?php
	echo $this->element('close_confirmation_new');
?>	
<?php

//	print("<pre>");
//	print_r($arrProductList['service']['Resources']);
	
?>
<div class="container-fluid bg-lightest-grey">

		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10 bg-lightest-grey">
				<div id="product_list_notification" class="index row"><?php echo $strMessage;?></div>
				<div class="find-jobs-header user-my-order-details-v2"> <!-- find-jobs-v3 -->
					<div class="col-md-12">
						<h2>My Order</h2>
					</div>
				</div>
				
				<div class="find-jobs-body find-jobs-v3 user-my-order-details-v2">
					<div class="col-md-3 fix992">
						<div class="my-order-options-container">
							
							<div class="my-order-options-headings">
								<h4>Order Details</h4>
								<input type="hidden" name="order_id" id="order_id" value="<?php echo $intOrderMId; ?>" />
								<div class="order_display_fields">
									<!--<button onclick="fnShowEditableFields(this,'<?php echo $intPortalId;?>');return false;" class="btn btn-default btn-sm" value="Edit">Edit</button>-->
									
									<button onclick="fnShowCloseConfirmation(this,'<?php echo $intPortalId;?>');return false;" class="btn btn-primary btn-sm" value="Edit">Close Order</button>
								</div>
								<div id="order_detail_action_container" class="order_editable_fields" style="display:none;"><input onclick="fnShowEditableFields(this,'<?php echo $intPortalId;?>');return false;" type="submit" name="done_edit" id="done_edit" value="Done"></input></div>
							</div>

							<div class="group-container">
								<p class="my-order-option-title">Customer name:</p>
								<p class="my-order-option-value"><?php echo $arrProductList[0]['customer']['Candidate']['candidate_first_name']." ".$arrProductList[0]['customer']['Candidate']['candidate_last_name'];?></p>
							</div><!-- 

						 --><div class="group-container">
								<p class="my-order-option-title">Order (Service) request:</p>
								<p class="my-order-option-value"><?php echo $arrProductList[0]['service']['Resources']['product_name'];?></p>
							</div><!-- 

						 --><!--<div class="group-container">
								<p class="my-order-option-title">Order status:</p>
								<p class="my-order-option-value"><span id="right_label_answer_order_status" class="order_display_fields"><?php //echo $arrProductList[0]['Resourceorderdetail']['vendor_order_state'];?></span>
								<div id="right_label_answer" class="order_editable_fields" style="display:none;">
									<select id="order_status" name="order_status">
										<option value="Open">Open</option>
										<option value="In-Process">In-Process</option>
										<option value="Closed">Closed</option>
									</select>
								</div></p>
							</div>--><!-- 

						 --><div class="group-container">
								<p class="my-order-option-title">Order name:</p>
								<p class="my-order-option-value"><?php echo $arrProductList[0]['mainorder']['Resourceorder']['order_name'];?></p>
							</div><!-- 

						 --><div class="group-container">
								<p class="my-order-option-title">Order placed date:</p>
								<p class="my-order-option-value"><?php echo date($productdateformatnew,strtotime($arrProductList[0]['Resourceorderdetail']['order_confirmation_date_time']));?></p>
							</div><!--
                                                    
						 -->
                                                 <?php if($arrProductList[0]['Resourceorderdetail']['order_detail_id'] !=''){?>
<!--                                                 <div class="group-container">
								<p class="my-order-option-title">Download:</p>
								<a href="<?php echo Router::url('/',true).'productfiles/'.$arrProductList[0]['service']['Resources']['product_file'];?>" target="_blank">
                                                                    <img src="<?php echo Router::url('/',true).'img/zip_icon.png';?>" width="100px" height="100px" alt="<?php echo $arrProductList[0]['service']['Resources']['product_file'];?>" class="img-responsive" title="<?php echo $arrProductList[0]['service']['Resources']['product_file'];?>"> 
                                                                </a>
							</div>-->
                                                 <?php } ?>	
						</div>
					</div>
					
					<div class="col-md-9">
						
						<div class="my-order-options-headings content-side">
							<h4>Add New Update</h4>
						</div>

						<div class="my-order-content-container">
							<form id="contentform" method="post" enctype="multipart/form-data">
							
								<h5>Title:</h5>
								<div class="group-container">
									
										<input type="text" class="w70 validate[required]" id="content_title" name="content_title" placeholder="Enter your content title here" value="">
								</div>
								
								<h5>Description:</h5>
								<textarea rows="4" id="order_update" class="validate[required]" name="main_content_new"></textarea>

								<h5>Files:</h5>
								<div class="group-container">
									
										<button onclick="$('input[id=profilePicture]').click(); return false;" class="btn btn-default w28">
									 		<span class="btn-attach-icon"></span><!-- 
									 	 --><span>Add Attachement</span>
									 	</button>
										<div id="photoCover"></div>
										<input id="profilePicture" class="validate[checkFileType[doc|docx|pdf]] " name="profilePicture" type="file" style="display:none">
								</div>
								<script type="text/javascript">
								$('input[id=profilePicture]').change(function() {
								$('#photoCover').html($(this).val());
								});
								</script>
								<button type="submit" class="btn btn-primary" onclick="fnSubmitContent();return false;">Submit</button>
								
							</form>
						</div>
						
						<div class="my-order-options-headings content-side">
							<h4>Order Updates</h4>
						</div>
						<div class="my-order-content-container article-type">
						<?php
							if(is_array($arrServiceUpdates) && (count($arrServiceUpdates)>0))
							{
								$intContentCount = 0;
								foreach($arrServiceUpdates as $arrContent)
								{
									$intContentCount++;
									$strProductEditUrl = Router::url(array('controller'=>'myorders','action'=>'viewupdate',$intPortalId,$intOrderMId,$arrContent['Serviceupdates']['order_service_update_id']),true);
									
									?>
										<div class="my-order-content-article">
								
											<h5><a href="<?php echo $strProductEditUrl; ?>"><?php echo $arrContent['Serviceupdates']['order_service_subject']; ?></a></h5>
											
											<!--<p class="content-article-subtitle">
												<span>posted</span> 5 days ago <span>by</span> Venor Name
											</p>-->
											
											<p class="content-article-description">
												<?php echo htmlspecialchars_decode(stripslashes($arrContent['Serviceupdates']['order_updated_text'])); ?><!--<a href="#" class="link link-primary">Show More</a>-->
											</p>
											
											<?php
												foreach($arrContent['Serviceupdates']['files'] as $arrFiles)
												{
													$strFileDownloadUrl = Router::url("/",true)."vendorupdates/".$arrFiles['Vendorfiles']['vendor_updates_file'];
													?>
														<div class="content-article-attach-container">
															<a href="<?php echo $strFileDownloadUrl; ?>"><?php echo $arrFiles['Vendorfiles']['vendor_updates_file'];?></a><!-- 
														 <span>&nbsp;(2Mb)</span>-->
														</div>
													<?php
												}
											?>

											

										</div>
									<?php
								}
							}
							else
							{
								
							}
						?>
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>
<!--<div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-lg-12">
	                        <h3>Order Detail</h3>
							<div id="product_list_notification" class="index row"><?php //echo $strMessage;?></div>
	                        <div class="row">
	                        <div id="order_detail_action_container" class="order_display_fields pull-right" style="width:25%;"><input onclick="fnShowEditableFields(this,'<?php //echo $intPortalId;?>');return false;" type="submit" name="start_edit" id="start_edit" value="Edit"></input></div>
			<div id="order_detail_action_container" class="order_editable_fields" style="display:none;width:25%;float:right"><input onclick="fnShowEditableFields(this,'<?php //echo $intPortalId;?>');return false;" type="submit" name="done_edit" id="done_edit" value="Done"></input></div>
		
			<input type="hidden" name="order_id" id="order_id" value="<?php //echo $intOrderMId; ?>" />
			
			</div>
	                        <div class="tab-row-container">
							<!--<div class="tab-filters">
								<a href="<?php //echo $strVendorOrdersUrl; ?>" class="active">All <span>(5)</span></a> |
								<a href="<?php //echo $strAdminNewUrl; ?>"  class="link-primary">New <span>(4)</span></a> |
								<a href="<?php //echo $strAdminOpenUrl; ?>" class="link-primary">Open <span>(1)</span></a> |
								<a href="<?php //echo $strAdminClosedUrl; ?>" class="link-primary">Closed <span>(1)</span></a>
							</div>-->
							
							<!--<div class="row-container">
									
									<form role="form">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label " for="select-type">Customer Name:</label>
											<?php //echo $arrProductList[0]['customer']['Candidate']['candidate_first_name']." ".$arrProductList[0]['customer']['Candidate']['candidate_last_name'];?>
											</div>
											<div class="form-group">
												<label class="control-label " for="person-name">Order(Service Request): <span class="form-required">*</span></label><!--
												--> <?php //echo $arrProductList[0]['service']['Resources']['product_name'];?>
											<!--</div>
											<!--<div class="form-group">
												<label class="control-label " for="person-email">Consultant: <span class="form-required">*</span></label><!--
												--><!--<?php //echo $arrProductList[0]['Resourceorderdetail']['vendor_name'];?>
											</div>-->
											
											
										<!--</div>

										<div class="col-md-6">
											<div class="form-group" >
												<label  class="control-label " for="select-type">Order Status:</label>
											<span id="right_label_answer_order_status" class="order_display_fields"><?php //echo $arrProductList[0]['Resourceorderdetail']['vendor_order_state'];?></span>
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
												--> <?php //echo $arrProductList[0]['mainorder']['Resourceorder']['order_name'];?>
											<!--</div>
											<div class="form-group">
												<label class="control-label " for="person-email">Order Placed Date: <span class="form-required">*</span></label><!--
												-->	<?php //echo date($productdateformat,strtotime($arrProductList[0]['Resourceorderdetail']['order_confirmation_date_time'])); ;?>
											<!--</div>
											
										</div>

									</form>
								
			</div>

							<!-- CONTENT -->
							<!--<div class="clear"></div>
							<?php
			
			$strUpdatesUrl = Router::url(array('controller'=>'myorders','action'=>'addupdates',$intPortalId,$intOrderMId),true);
		?>
							<h3>Order Updates<a style="float:right;" class="btn btn-default" href="<?php echo $strUpdatesUrl;?>">Add Updates</a></h3>
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
					$strProductEditUrl = Router::url(array('controller'=>'myorders','action'=>'viewupdate',$intPortalId,$intOrderMId,$arrContent['Serviceupdates']['order_service_update_id']),true);
					?>
					
					<tr id="product_list_<?php //echo $arrContent['Serviceupdates']['order_detail_id'];?>" >
											<td>
												<div class="user-title">
													<a href="#str<?php //echo $intContentCount; ?>" id="task1" class="username-clickable"><?php //echo $intContentCount;?></a>
												</div>
											</td>
											<td><a href="<?php //echo $strProductEditUrl; ?>"><?php //echo $arrProductList[0]['mainorder']['Resourceorder']['order_name']; ?></a></td>
											<td><?php // echo $arrContent['Serviceupdates']['updatefrom']; ?></td>
											<td id="order_status"><?php //echo $arrContent['Serviceupdates']['order_service_subject']; ?></td>
											<td><?php //echo date($productdateformat,strtotime($arrContent['Serviceupdates']['order_updated_on'])) ?></td>
										</tr>
					
						<tr id="str<?php //echo $intContentCount; ?>" class="hide-str">
											<td colspan="5">
												<div id="task1-options" class="user-options">
													
													<a href="<?php //echo $strProductEditUrl; ?>" class="link-primary">View</a> 
													
												</div>
											</td>
										</tr>
					<?php
				}
			}
		?>
										
										
										
										
										
										
									</table>
							 	</div>
							 	<!--<div class="panel-footer vendor-orders">
							 		<table>
										<tr>
											<th>Order #</th>
											<th>Customer Order ID</th>
											<th class="selected">From<span></span></th>
											<th>Subject</th>
											<th>Date</th>
										</tr>
									</table>
							 	</div>-->
							<!--</div>
							<!-- SMALL TABLE -->
						<!--<table class="table table-striped" style="width:80%;">
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
	        </div>-->
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
<script type="text/javascript">
 $(".panel-body.vendor-orders .user-title a").click(function(event) {
				
				$(this.getAttribute("href")).css('display', 'table-row');
				$(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
			});
			
			
function fnSubmitContent(isToBePublished)
{
	var isValidated = $('#contentform').validationEngine('validate');
	
	//var isValidated = true;
	if(isValidated == false)
	{
	  return false;
	}
	else
	{ 
	
		var intOrderUpdateId = $('#order_id').val();
		var intPortalId = '<?php echo $intPortalId; ?>';
		var strMainContent =  $("#order_update").val();	
		var strCurrentLocation = window.location.href;
		var arrCurrentLocationDetail = strCurrentLocation.split("/");
		var pageurl = "<?php echo Router::url('/', true)."myorders/addorderupdates/";?>"+intPortalId+"/"+intOrderUpdateId;
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
			
				
				$('.cms-bgloader-mask').show();//show loader mask
				$('.cms-bgloader').show(); //show loading image
				formData.push({name:'main_content', value:strMainContent});
				formData.push({name:'content_edit_id', value:$('#content_edit_id').val()});
				if(isToBePublished == "1")
				{
					formData.push({name:'to_publish', value:"1"});
				}
				
			},
			success:function(responseText, statusText, xhr, $form) {
				if(responseText.status == "success")
				{
				
					$('#order_update').val("");
					$('#content_title').val("");
					window.location.reload();
					//$('.tabloader').hide();
					
					//$('#product_notification').html('');
					//$('#product_notification').html(responseText.message);
					//$('#product_notification').fadeIn('slow');
					//$('#filepart').show();
				}
				else
				{
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					
					$('#product_list_notification').html('');
					$('#product_list_notification').html(responseText.message);
					$('#product_list_notification').fadeIn('slow');
				}
				
			},								
			url:       pageurl,         // override for form's 'action' attribute 
			type:      pagetype,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		}
		$('#contentform').ajaxSubmit(pageoptions);
		return false;
	}
}	

</script>