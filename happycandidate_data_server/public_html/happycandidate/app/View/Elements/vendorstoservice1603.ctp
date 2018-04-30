<?php
	//echo "--".$arrProductContent[0]['content']['content_for_user'];exit;
?>
<script type="text/javascript">
	var strContTy = "<?php echo $arrProductContent[0]['content']['content_type']; ?>";
	var strContU = "<?php echo $arrProductContent[0]['content']['content_for_user']; ?>";
	$(document).ready(function () {
		if(strContTy)
		{
			$('#content_type').val(strContTy);
		}
		
		if(strContU)
		{
			$('#content_user').val(strContU);
		}
		
		$('#content_uploadhtml_file').click(function () {
			fnGetContentFileUploader();
			$('.files').html('');
		});
		
		$('#add').click(function() {
			var strFormSubmitStatus = fnSubmitContent();
			return false;
		});
		
		$('#add_publish').click(function() {
			var strFormSubmitStatus = fnSubmitContent("1");
			return false;
		});
		
		$('#banner_image_remover').click(function () {
			$('#banner_image_id').val('');
			$('#banner_image_thumb').hide();
			$('#banner_image_remover').hide();
		});
		
	});
	
	$(document).ready(function() {
		
		$('#content_pub_date').datepicker({
			format: "mm/dd/yyyy",
			endDate:'0',
			autoclose: true
		});
	});
	
function fnGetContentFileUploader()
{
	if($('#contentfileuploadcont').length>0)
	{
		$('.tabloader').hide();
	}
	else
	{
		$.ajax({ 
				type: "GET",
				url: strBaseUrl+"products/htmlfileuploader/forcontent",
				dataType: 'json',
				data:"",
				async:false,
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						//alert(data.content)
						$('.tabloader').hide();
						$('#contentfileuploadercontainer').html(data.content);
					}
					else
					{
						alert("fail");
					}
				}
		});
	}
}

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
		var strCurrentLocation = window.location.href;
		var arrCurrentLocationDetail = strCurrentLocation.split("/");
		
		var pageurl = "<?php echo Router::url('/', true)."vendorservices/add/";?>";
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('.cms-bgloader-mask').show();//show loader mask
				$('.cms-bgloader').show(); //show loading image
				formData.push({name:'content_edit_id', value:$('#content_edit_id').val()});
				if(isToBePublished == "1")
				{
					formData.push({name:'to_publish', value:"1"});
				}
			},
			success:function(responseText, statusText, xhr, $form) {
				if(responseText.status == "success")
				{
					$('.tabloader').hide();
					$('#content_html').show();
					$('#product_notification').html('');
					$('#product_notification').html(responseText.message);
					$('#product_notification').fadeIn('slow');
					$('#serviceproduct').css('display','block');
					$('#vendor_service_id').val(responseText.createdid);
				}
				else
				{
					$('.tabloader').hide();
					$('#content_html').show();
					$('#product_notification').html('');
					$('#product_notification').html(responseText.message);
					$('#product_notification').fadeIn('slow');
				}
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
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


      <div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-lg-12">
	                      
	                        <div class="form-container">
							<div id="product_notification"></div>
		                       <form id="contentform" name="contentform" action="" method="post" role="form">
								<input value="<?php echo $arrProductContent['0']['Vendors']['vendor_id']; ?>" id="content_edit_id" name="content_edit_id" type="hidden" class="form-control">
								<input type="hidden" name="content_request_for" id="content_request_for" value="" />
								<input type="hidden" name="vendor_service_id" id="vendor_service_id" value="" />
								<div class="form-group">
									<label class="control-label col-xs-12 col-sm-12 col-md-4" for="name">Type: <span class="form-required">*</span></label>
									<select id="product_type" name="product_type" onchange="fnLoadProductVendors()" class="col-xs-12 col-sm-12 col-md-8">
										<option value="Services">Services</option>
										<option value="Product">Product</option>
										<option value="Course">Course</option>
									</select>
								</div>
								<div id="product_venddors">
									<div class="form-group">
									<label class="control-label col-xs-12 col-sm-12 col-md-4" for="name">Vendor Name: <span class="form-required">*</span></label>
									
										<select id="vendor" name="vendor" class="col-xs-12 col-sm-12 col-md-8">
										<option value="">--Choose Vendor--</option>
										<?php
											if(is_array($arrVendorServiceDetail['Vendors']) && (count($arrVendorServiceDetail['Vendors'])>0))
											{
												foreach($arrVendorServiceDetail['Vendors'] as $arrVendor)
												{
													?>
														<option value="<?php echo $arrVendor['Vendors']['vendor_id'];?>"><?php echo $arrVendor['Vendors']['vendor_first_name']." ".$arrVendor['Vendors']['vendor_last_name'];?></option>
													<?php
												}
											}
										?>
										</select>
									</div>
									
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-4" for="name">Service Name: <span class="form-required">*</span></label>
										<select id="service" class="col-xs-12 col-sm-12 col-md-8" name="service" onchange="fnGetServiceDetails();">
											<option value="">--Choose Service--</option>
											<?php
												if(is_array($arrVendorServiceDetail['Services']) && (count($arrVendorServiceDetail['Services'])>0))
												{
													foreach($arrVendorServiceDetail['Services'] as $arrResource)
													{
														?>
															<option value="<?php echo $arrResource['Resources']['productd_id'];?>"><?php echo $arrResource['Resources']['product_name'];?></option>
														<?php
													}
												}
											?>
											</select>
											
									</div>
								</div>
									
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Service Cost : </label>
											<?php
												$strPubDateToshow = date($strDateFormat);
												//$strPubDateToshow = date('Y-m-d');
												if(isset($arrVendorServiceDetail['Vendors']['service_cost']))
												{
													?>
														<input value="<?php echo stripslashes($arrProductContent['0']['Vendors']['service_cost']); ?>" id="service_cost" name="service_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter service cost here" readonly>
													<?php
												}
												else
												{
													
													?>
														<input value="" id="service_cost" name="service_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter service cost here" readonly>
													<?php
												}
											?>

									</div>
									
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Vendor Cost : </label>
											<?php
												$strPubDateToshow = date($strDateFormat);
												//$strPubDateToshow = date('Y-m-d');
												if(isset($arrVendorServiceDetail['Vendors']['vendor_cost']))
												{
													?>
														<input value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_cost']); ?>" id="vendor_cost" name="vendor_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter vendor cost here">
													<?php
												}
												else
												{
													
													?>
														<input value="" id="vendor_cost" name="vendor_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter vendor cost here">
													<?php
												}
											?>

									</div>
									
									<div class="form-group" style="display:none;">
										<label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Merchant Cost Type : </label>
										<select id="merchant_cost_type" name="merchant_cost_type" class="col-xs-12 col-sm-12 col-md-8" >
											<option value="per" selected="selected">Percentage</option>
											<option value="flat">Flat</option>
										</select>
									</div>
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Merchant Cost(%) : </label>
										<?php
				$strPubDateToshow = date($strDateFormat);
				//$strPubDateToshow = date('Y-m-d');
				if(isset($arrProductContent['0']['Vendors']['vendor_password']))
				{
					?>
						<input value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_password']); ?>" id="merchant_cost" name="merchant_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter merchant cost here">
					<?php
				}
				else
				{
					
					?>
						<input value="" id="merchant_cost" name="merchant_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter merchant cost here">
					<?php
				}
			?>
									</div>
									
									<div class="form-group" style="display:none;">
										<label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Portal Owner Cost Type: </label>
										<select id="portalowner_cost_type" name="portalowner_cost_type">
											<option value="per" selected="selected">Percentage</option>
											<option value="flat">Flat</option>
										</select>
									</div>
									
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Portal Owner Revenue Share(%): </label>
										<?php
				$strPubDateToshow = date($strDateFormat);
				//$strPubDateToshow = date('Y-m-d');
				if(isset($arrProductContent['0']['Vendors']['vendor_password']))
				{
					?>
						<input value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_password']); ?>" id="portal_cost" name="portal_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter portal owner share here">
					<?php
				}
				else
				{
					
					?>
						<input value="" id="portal_cost" name="portal_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter portal owner share here">
					<?php
				}
			?>
									</div>

									<div class="form-group" style="display:none;">
										<label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">HC Cost Type: </label>
									<select id="hc_cost_type" name="hc_cost_type">
									<option value="per" selected="selected">Percentage</option>
									<option value="flat">Flat</option>
								</select>
									</div>
									
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">HC Revenue Share(%): </label>
											<?php
				$strPubDateToshow = date($strDateFormat);
				//$strPubDateToshow = date('Y-m-d');
				if(isset($arrProductContent['0']['Vendors']['vendor_password']))
				{
					?>
						<input value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_password']); ?>" id="hc_cost" name="hc_cost" type="text" class="form-control validate[required]" placeholder="Enter HC share here">
					<?php
				}
				else
				{
					
					?>
						<input value="" id="hc_cost" name="hc_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter HC share here">
					<?php
				}
			?>
									</div>
									<div class="form-group">
										<div class="hidden-xs hidden-sm col-md-4"></div>
										<div class="col-xs-12 col-sm-12 col-md-8 page-content-wrapper-buttons">
											<button  class="btn btn-primary" name="add_publish" id="add_publish" type="submit">Save Changes</button>
											<button type="button" class="btn btn-default" onclick="window.location='<?php echo $this->Session->read('strCancelUrl');?>'">Cancel</button>
										</div>
									</div>
								</form>
							</div>
	                    </div>
	                </div>
	            </div>
	        </div>
	   <?php /*
<form id="contentform" name="contentform" action="" method="post" role="form">
	
	
	<div class="row nopadding nomargin">
		<div class="col-md-12 nomargin"><span id="madatsym" class="madatsym">*</span><strong>Service Cost:</strong></div>
		<div class="col-md-9">
			<?php
				$strPubDateToshow = date($strDateFormat);
				//$strPubDateToshow = date('Y-m-d');
				if(isset($arrVendorServiceDetail['Vendors']['vendor_password']))
				{
					?>
						<input value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_password']); ?>" id="service_cost" name="service_cost" type="text" class="form-control validate[required]" placeholder="Enter service cost here">
					<?php
				}
				else
				{
					
					?>
						<input value="" id="service_cost" name="service_cost" type="text" class="form-control validate[required]" placeholder="Enter service cost here">
					<?php
				}
			?>
		</div>
	</div>
	<div class="row nopadding nomargin">
		<div class="col-md-12 nomargin"><strong>Vendor Cost:</strong></div>
		<div class="col-md-9">
			<?php
				$strPubDateToshow = date($strDateFormat);
				//$strPubDateToshow = date('Y-m-d');
				if(isset($arrProductContent['0']['Vendors']['vendor_password']))
				{
					?>
						<input value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_password']); ?>" id="vendor_cost" name="vendor_cost" type="text" class="form-control validate[required]" placeholder="Enter vendor cost here">
					<?php
				}
				else
				{
					
					?>
						<input value="" id="vendor_cost" name="vendor_cost" type="text" class="form-control validate[required]" placeholder="Enter vendor cost here">
					<?php
				}
			?>
		</div>
	</div>
	<div class="row nopadding nomargin">
		<div class="col-md-12 nomargin"><strong>Merchant Cost Type:</strong></div>
		<div class="col-md-9">
			<select id="merchant_cost_type" name="merchant_cost_type">
				<option value="per">Percentage</option>
				<option value="flat">Flat</option>
			</select>
		</div>
	</div>
	<div class="row nopadding nomargin">
		<div class="col-md-12 nomargin"><strong>Merchant Cost:</strong></div>
		<div class="col-md-9">
			<?php
				$strPubDateToshow = date($strDateFormat);
				//$strPubDateToshow = date('Y-m-d');
				if(isset($arrProductContent['0']['Vendors']['vendor_password']))
				{
					?>
						<input value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_password']); ?>" id="merchant_cost" name="merchant_cost" type="text" class="form-control validate[required]" placeholder="Enter merchant cost here">
					<?php
				}
				else
				{
					
					?>
						<input value="" id="merchant_cost" name="merchant_cost" type="text" class="form-control validate[required]" placeholder="Enter merchant cost here">
					<?php
				}
			?>
		</div>
	</div>
	<div class="row nopadding nomargin">
		<div class="col-md-12 nomargin"><strong>Portal Owner Cost Type:</strong></div>
		<div class="col-md-9">
			<select id="portalowner_cost_type" name="portalowner_cost_type">
				<option value="per">Percentage</option>
				<option value="flat">Flat</option>
			</select>
		</div>
	</div>
	<div class="row nopadding nomargin">
		<div class="col-md-12 nomargin"><strong>Portal Owner Revenue Share:</strong></div>
		<div class="col-md-9">
			<?php
				$strPubDateToshow = date($strDateFormat);
				//$strPubDateToshow = date('Y-m-d');
				if(isset($arrProductContent['0']['Vendors']['vendor_password']))
				{
					?>
						<input value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_password']); ?>" id="portal_cost" name="portal_cost" type="text" class="form-control validate[required]" placeholder="Enter portal owner share here">
					<?php
				}
				else
				{
					
					?>
						<input value="" id="portal_cost" name="portal_cost" type="text" class="form-control validate[required]" placeholder="Enter portal owner share here">
					<?php
				}
			?>
		</div>
	</div>
	<div class="row nopadding nomargin">
		<div class="col-md-12 nomargin"><strong>HC Cost Type:</strong></div>
		<div class="col-md-9">
			<select id="hc_cost_type" name="hc_cost_type">
				<option value="per">Percentage</option>
				<option value="flat">Flat</option>
			</select>
		</div>
	</div>
	<div class="row nopadding nomargin">
		<div class="col-md-12 nomargin"><strong>HC Revenue Share:</strong></div>
		<div class="col-md-9">
			<?php
				$strPubDateToshow = date($strDateFormat);
				//$strPubDateToshow = date('Y-m-d');
				if(isset($arrProductContent['0']['Vendors']['vendor_password']))
				{
					?>
						<input value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_password']); ?>" id="hc_cost" name="hc_cost" type="text" class="form-control validate[required]" placeholder="Enter HC share here">
					<?php
				}
				else
				{
					
					?>
						<input value="" id="hc_cost" name="hc_cost" type="text" class="form-control validate[required]" placeholder="Enter HC share here">
					<?php
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-9"><input name="add_publish" id="add_publish" type="submit" value="Add"></input>&nbsp;<input name="cancel" id="cancel" type="reset" onclick="window.location='<?php echo $this->Session->read('strCancelUrl');?>'" value="Cancel"></input></div>
	</div>
</form>*/?>
<script type="text/javascript">
	function fnLoadProductVendors()
	{
		var strProductType = $('#product_type').val();
		var strDataStr = "type="+strProductType;
		$('.cms-bgloader-mask').show();//show loader mask
		$('.cms-bgloader').show(); //show loading image
		$.ajax({ 
			type: "POST",
			url: appBaseU+"vendorservices/gettypevendorproducts/",
			data: strDataStr,
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
					
					$('#product_venddors').html(data.html);
					$('#service_cost').val("");
				}
				else
				{
					$('#product_notification').html(data.message);
				}
		
			
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
			
				//alert(data);
				//$("#state_city").html();
				//$("#state_city").html(data);
			}
	});
	}
</script>