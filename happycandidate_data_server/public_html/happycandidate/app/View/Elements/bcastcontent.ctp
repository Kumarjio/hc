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
		if(strContTy==2)
		{
			$('#webinarregister').css('display','block');
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

function fnSubmitContent(isToBePublished)
{
	var isValidated = $('#contentform').validationEngine('validate');
	
	//alert(isValidated);
	//return false;
	
	//var isValidated = true;
	
	if(isValidated == false)
	{
	  return false;
	}
	else
	{ 
		var strIntroContentEditorType = $('.html.editor2.active').text();
	
		
		var strMainContentEditorType = $('.html.editor1.active').text();
		if(strMainContentEditorType == "Text")
		{
			var strMainContent = $('#main_content').val();
		}
		else
		{
			var strMainContent = tinyMCE.get('main_content').getContent();
			
		}
		
		var strCurrentLocation = window.location.href;
		var arrCurrentLocationDetail = strCurrentLocation.split("/");
		
		var pageurl = "<?php echo Router::url('/', true)."email/send/";?>";
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('.cms-bgloader-mask').show();//show loader mask
				$('.cms-bgloader').show(); //show loading image
				$('#content_html').hide();
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
				
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					$('#content_html').show();
					$('#product_notification').html('');
					$('#product_notification').html(responseText.message);
					$('#product_notification').fadeIn('slow');
					if($('#content_edit_id').val() != "")
					{
						$('#content_edit_id').val($('#content_edit_id').val());
						$('#content_added').val($('#content_edit_id').val());
					}
					else
					{
						$('#content_edit_id').val(responseText.createdid);
						$('#content_added').val(responseText.createdid);
					}
					if($('#content_request_for_id').length > 0)
					{
						if($('#content_request_for_id').val() == "99")
						{
							$('.page-header h1').text('Edit Page');
						}
						else
						{
							$('.page-header h1').text('Edit Content');
						}
					}
					else
					{
						$('.page-header h1').text('Edit Content');
					}
					$('#cat').show();
					
					//$('#contentparent').show();
					$('#jbsearchcat').show();
					
					//var strTobeReturned = $("#dialog-add-page-form").data('returnvalue');
				}
				else
				{
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
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
		$('#contentform').ajaxSubmit(pageoptions);
		return false;
	}
}
</script>

<?php 
if(count($arrEmailContent)>0)
{
	$template_key = $arrEmailContent['Email']['template_key'];
	$templateid = $arrEmailContent['Email']['id'];
	$disablecss="disabled='disabled'";
}
else
{
	$template_key='';
	$templateid=0;
	$disablecss='';
}

?>
							<div id="product_notification" ></div>
									<form id="contentform" name="contentform"  method="post" role="form">

											<div class="form-group"  >
												<label class="control-label col-xs-12 col-sm-12 col-md-4" style="text-align:left;">User Type:</label><!--
												-->	
												<select name="template_for" id="template_for" onchange="fnGetUsers()" class="form-control col-xs-12 col-sm-12 col-md-8" <?php echo $disablecss;?>>
													<option value="">--Select Option--</option>
													<option value="Portal Owners">Portal Owners</option>
													<option value="Vendors">Vendors</option>
													<option value="Job Seekers">Job Seekers</option>
												</select>
											</div>
											
											<div class="form-group"  id="portals">
												<label class="control-label col-xs-12 col-sm-12 col-md-4" style="text-align:left;">Sites:</label><!--
												-->	
												<select name="portal_chooser" id="portal_chooser" onchange="fnGetUsers()">
													<option value="all">--All Portals--</option>
													<?php
														if(is_array($arrPortalList)  && (count($arrPortalList)>0))
														{
															
															foreach($arrPortalList as $arrPortalKey => $arrPortalName)
															{
																?>
																	<option value="<?php echo $arrPortalKey;?>"><?php echo $arrPortalName;?></option>
																<?php
															}
														}
													?>
												</select>
												<input type="hidden" name="templateid" id="templateid" class="form-control" value="<?php echo $templateid;?>"/>
											</div>
											
											<div id="users" style="display:none;">
											</div>
											
											<div class="form-group"  >
												<label class="control-label col-xs-12 col-sm-12 col-md-4" style="text-align:left;">Subject:</label><!--
												-->	
												<input style="width:60%;" type="text" name="from_email" id="from_email" class="form-control" value="<?php echo stripslashes($arrEmailContent['Email']['from_email']); ?>"/>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2" style="text-align:left;">Message:</label><!--
												-->
												<?php
													if(isset($arrEmailContent) && ($arrEmailContent['Email']['email_text']))
													{
														?>
															<textarea class="form-control" id="main_content" name="main_content" rows="5"><?php echo stripslashes($arrEmailContent['Email']['email_text']);?></textarea>
														<?php
													}
													else
													{
														?>
															<textarea class="form-control" id="main_content" name="main_content" rows="5"></textarea>
														<?php
													}
												?>
										</div>
										<div class="col-md-12 form-group submit-container">
											<div class="col-md-6">
											<div class="form-group">
												<div class="hidden-xs hidden-sm col-md-4"></div>
												<div class="col-xs-12 col-sm-12 col-md-8">
													<button type="button" id="add" class="btn btn-primary" onclick="return false;" type="button">Save Changes</button>
													<!--<button type="button" class="btn btn-primary" onclick="return fnSubmitContent();" type="button">Save Changes</button>-->
													<button class="btn btn-warning" type="button">Cancel</button>
												</div></div>
											</div>
										</div>
									</form>
						
				
							
		
<?php
	echo $this->Html->script('content_form');
?>
<?php
	//echo $this->element('contentfile_uploader_modal');
?>
<script>
$('#template_for').val('<?php echo $template_key;?>');
$('#content_type').change(function()
{
   var textselected = $("#content_type :selected").text();
  if(textselected=="Webinars")
  {
	$('#webinarregister').css('display','block');
  }
  else
  {
  $('#webinarregister').css('display','none');
  }
})

function fnGetUsers()
{
	var strUserType = $('#template_for').val();
	var strUserSite = $('#portal_chooser').val();
	//alert(strUserType);
	//return false;
	
	if(strUserType == "")
	{
		alert("Please user type");
		return false;
	}
	else
	{
		if(strUserType == "Portal Owners")
		{
			$('#portals').hide();
		}
		else
		{
			if(strUserType == "Vendors")
			{
				$('#portals').hide();
			}
			else
			{
				$('#portals').show();
			}
		}
	}
	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"email/getuser/"+strUserType+"/"+strUserSite,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
					$('#users').html(data.html);
					$('#users').show();
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