<?php
	//echo "--".$arrProductContent[0]['content']['content_for_user'];exit;
?>
<script type="text/javascript">
function fnSubmitVendorCompanyContent(isToBePublished)
{
	alert($('#vendor_company_address').val());
	var isValidated = $('#vendorcompanydetailform').validationEngine('validate');	
	//var isValidated = true;
	
	if(isValidated == false)
	{
	  return false;
	}
	else
	{
		var strCurrentLocation = window.location.href;
		var arrCurrentLocationDetail = strCurrentLocation.split("/");
		
		var pageurl = "<?php echo Router::url('/', true)."vendors/companyadd/";?>";
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('#content_html').hide();
				$('.tabloader').show();
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
				}
				else
				{
					$('.tabloader').hide();
					$('#content_html').show();
					$('#product_notification').html('');
					$('#product_notification').html(responseText.message);
					$('#product_notification').fadeIn('slow');
				}
				
			},								
			url:       pageurl,         // override for form's 'action' attribute 
			type:      pagetype,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		}
		$('#vendorcompanydetailform').ajaxSubmit(pageoptions);
		return false;
	}
}
</script>
<div class="col-md-12 form-container edit-profile">
									<form id="vendorcompanydetailform" name="vendorcompanydetailform" action="" method="post" role="form">
									
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Company Name: <span class="form-required">*</span></label>
											<input type="text"  placeholder="Company Name" value="<?php echo stripslashes($arrProductContent['0']['Vendorcompany']['company_name']); ?>" id="company_name" name="company_name"class="col-xs-12 col-sm-12 col-md-9 validate[required]" data-prompt-position="topRight:-100">
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">First Name:<span class="form-required">*</span></label>
											<input type="text" placeholder="First Name" value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_first_name']); ?>"  id="vendor_f_name" name="vendor_f_name" class="col-xs-12 col-sm-12 col-md-9 validate[required]" data-prompt-position="topRight:-100">
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Last Name:<span class="form-required">*</span></label>
											<input type="text" placeholder="Last Name" value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_last_name']); ?>"  id="vendor_l_name" name="vendor_l_name" class="col-xs-12 col-sm-12 col-md-9 validate[required]" data-prompt-position="topRight:-100">
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Email: <span class="form-required">*</span></label>
											<input type="text"  placeholder="Email" value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_email']); ?>" name="email" class="col-xs-12 col-sm-12 col-md-9 validate[required] " data-prompt-position="topRight:-100">
										</div>
									
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Address:</label>
											<textarea name="vendor_company_address" id="vendor_company_address" class="col-xs-12 col-sm-12 col-md-9" data-prompt-position="topRight:-100"><?php echo stripslashes($arrProductContent['0']['Vendorcompany']['address']); ?></textarea>
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Zip: <span class="form-required">*</span></label>
											<input type="text" placeholder="Zip"  value="<?php echo stripslashes($arrProductContent['0']['Vendorcompany']['zip']); ?>" id="vendor_company_zip" name="vendor_company_zip" class="col-xs-12 col-sm-12 col-md-9 validate[required]" data-prompt-position="topRight:-100">
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Phone: <span class="form-required">*</span></label>
											<input type="text"  placeholder="+1 - 555 - 55 - 55" value="<?php echo stripslashes($arrProductContent['0']['Vendorcompany']['phone']); ?>" id="vendor_company_phone" name="vendor_company_phone" class="col-xs-12 col-sm-12 col-md-9 validate[required]" data-prompt-position="topRight:-100">
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Fax: </label>
											<input type="text"  placeholder="Fax" value="<?php echo stripslashes($arrProductContent['0']['Vendorcompany']['fax']); ?>" id="vendor_company_fax" name="vendor_company_fax" class="col-xs-12 col-sm-12 col-md-9" data-prompt-position="topRight:-100">
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Web Address:</label>
											<input type="text"  placeholder="Web Address" value="<?php echo stripslashes($arrProductContent['0']['Vendorcompany']['web_address']); ?>" id="vendor_company_website" name="vendor_company_website" class="col-xs-12 col-sm-12 col-md-9" data-prompt-position="topRight:-100">
										</div>
										<!--<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Billing Phone: </label>
											<input type="text"  placeholder="+1 - 555 - 55 - 55" value="<?php //echo stripslashes($arrProductContent['0']['Vendorcompany']['billing_phone']); ?>" id="vendor_company_b_phone" name="vendor_company_b_phone" class="col-xs-12 col-sm-12 col-md-9" data-prompt-position="topRight:-100">
										</div>-->
										<div class="form-group">
											<div class="hidden-xs hidden-sm col-md-3"></div>
											<div class="col-xs-12 col-sm-12 col-md-9">
												<button class="btn btn-primary" name="add" id="add" onclick="fnSubmitVendorCompanyContent();return false;" type="button">Save Changes</button>
												<button class="btn btn-default" type="button">Cancel</button>
											</div>
										</div>
									</form>
								</div>