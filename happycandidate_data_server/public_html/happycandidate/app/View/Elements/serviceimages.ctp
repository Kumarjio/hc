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
		
		$('#add_other').click(function() {
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
			
		$('#featured_image_remover').click(function () {
			$('#featured_image_id').val('');
			$('#featured_image_thumb').hide();
			$('#featured_image_remover').hide();
		});

		// Getting MEDIA UPLOADER
		$('#add_featured_media').click(function () {
			$('#myModalLabel').text('Add Featured Image');
			$('#content_modal_submit_button').text('Add Featured Image');
			$('#request_media_from').val('featured_image');
			var isValidated = $('#contentform').validationEngine('validate');
			if(isValidated == false)
			{
				return false;
			}
			else
			{
				if($('#mediacontainer').length>0)
				{
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					$( "#dialog-mediaupload-form" ).dialog("open");
				}
				else
				{
					fnGetMediUploader();
				}
			}

			$('.files').html('');
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
		
		var pageurl = "<?php echo Router::url('/', true)."resource/addimagemore/";?>";
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('#content_html').hide();
				$('.cms-bgloader-mask').show();//show loader mask
				$('.cms-bgloader').show(); //show loading image
			},
			success:function(responseText, statusText, xhr, $form) {
				if(responseText.status == "success")
				{
					$('#content_html').show();
					$('#product_notification').html('');
					$('#product_notification').html(responseText.message);
					$('#product_notification').fadeIn('slow');
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
				}
				else
				{
					$('#content_html').show();
					$('#product_notification').html('');
					$('#product_notification').html(responseText.message);
					$('#product_notification').fadeIn('slow');
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
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
<form id="contentform" name="contentform" action="" method="post" role="form">
	<div class="row nopadding nomargin">
		<div class="col-md-12 nomargin"><span id="madatsym" class="madatsym">*</span><strong>Choose Service:</strong></div>
		<div class="col-md-9">
			<select class="form-control validate[required]" name="service" id="service">
				<option value="">--Select Service--</option>
				<?php
					if(is_array($arrResourceList) && (count($arrResourceList)>0))
					{
						foreach($arrResourceList as $arrResource)
						{
							?>
								<option value="<?php echo $arrResource['Resources']['productd_id'];?>"><?php echo $arrResource['Resources']['product_name'];?></option>
							<?php
						}
					}
				?>
			</select>
			<input value="<?php echo $arrProductContent['0']['Resources']['productd_id']; ?>" id="content_edit_id" name="content_edit_id" type="hidden" class="form-control">
			<input type="hidden" name="content_request_for" id="content_request_for" value="" />
			<input type="hidden" name="content_request_for_id" id="content_request_for_id" value="" />
			<input type="hidden" name="image_id" id="image_id" value="<?php echo $intImageId; ?>" />
			<input type="hidden" name="service_images" id="service_images" value="1" />
		</div>
	</div>
	<div class="row" id="feature_image_section">
		<div class="col-md-12"><strong>Service Image :</strong>&nbsp; <input data-toggle="modal" data-target="#mediaModal" name="add_featured_media" id="add_featured_media" class="btn btn-sm btn-default" type="button" value="Add Images" style="width:auto;"></input></div>
		<input type="hidden" name="request_media_from" id="request_media_from" value="" />
		<div class="col-md-9">
			<?php
				if(isset($arrResourceImageList) && ($arrResourceImageList['0']['ResourcesImages']['product_images_id']))
				{
					?>
						<input type="hidden" name="featured_image_id" id="featured_image_id" value="<?php echo $arrResourceImageList['0']['ResourcesImages']['product_images_id'];?>" />
						<img class="thumbnail" src="<?php echo Router::url('/',true).'productfiles/thumbnail/'.$arrResourceImageList['0']['ResourcesImages']['product_image_title'];?>" id="featured_image_thumb" alt="Featured Image" title="Featured Image"/>&nbsp;<a href="javascript:void(0);" id="featured_image_remover">Remove</a>
					<?php
				}
				else
				{
					?>
						<input type="hidden" name="featured_image_id" id="featured_image_id" value="" />
						<img class="thumbnail" src="" id="featured_image_thumb" alt="Featured Image" title="Featured Image" style="display:none;" />&nbsp;
						<a href="javascript:void(0);" id="featured_image_remover" style="display:none;">Remove</a>
					<?php
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">&nbsp;</div>
		<div class="col-md-9"><button name="add_other" id="add_other" class="btn btn-lg btn-primary" type="submit">Save</button>&nbsp;<button name="cancel" id="cancel" class="btn btn-lg btn-primary" type="reset" onclick="window.location='<?php echo $this->Html->url('/', true);?>resource/serviceimages'">Cancel</button></div>
	</div>
</form>
<?php
	echo $this->Html->script('content_form');
?>
<script type="text/javascript">
	var strSelectedService = "<?php echo $arrResourceImageList[0]['ResourcesImages']['product_id'];?>";
	$(document).ready(function () {
		if(strSelectedService != '')
		{
			$('#service').val(strSelectedService);
		}
	});
</script>