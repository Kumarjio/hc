<?php
		
		$strMyOredersUrl = Router::url(array('controller'=>'myorders','action'=>'orderdetail',$intPortalId,$intOrderId),true);
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
	
		var intOrderUpdateId = $('#service_for_comment_id').val();
		var intPortalId = '<?php echo $intPortalId; ?>';
		var strMainContent =  $("#txtEditorContent").Editor("getText");	
		var strCurrentLocation = window.location.href;
		var arrCurrentLocationDetail = strCurrentLocation.split("/");
		var pageurl = "<?php echo Router::url('/', true)."myorders/addorderupdates/";?>"+intPortalId+"/"+intOrderUpdateId;
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
			
				
				$('.tabloader').show();
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
				
					$('.tabloader').hide();
					
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
					$('#filepart').show();
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
		$('#contentform').ajaxSubmit(pageoptions);
		return false;
	}
}
</script>

<form  id="contentform" name="contentform" action="" method="post" role="form">
											<div class="form-group">
												<div class="col-xs-12 col-sm-12 col-md-3">
													<label for="first-name" class="control-label">Subject :</label>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-9">
													<input value="<?php echo stripslashes($arrProductContent['0']['content']['content_title']); ?>" id="content_title" name="content_title" type="text" class="form-control validate[required]" placeholder="Enter your content title here">
													<input value="<?php echo $arrProductContent['0']['content']['content_id']; ?>" id="content_edit_id" name="content_edit_id" type="hidden" class="form-control">
			<input type="hidden" name="content_request_for" id="content_request_for" value="" />
			<input type="hidden" name="content_request_for_id" id="content_request_for_id" value="" />
			<input type="hidden" name="service" id="service" value="<?php echo $intOrderId;?>" />
												</div>
											</div>
											<div class="form-group">
												<div class="col-xs-12 col-sm-12 col-md-3">
													<label for="last-name" class="control-label">Main Content: <span class="form-required">*</span></label>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-9">
					
							<textarea class="form-control" id="txtEditorContent" name="main_content" rows="5"><?php echo stripslashes($arrProductContent['0']['content']['content']);?></textarea>
					
												</div>
											</div>
											
											
											<div class="form-group">
												<div class="col-xs-12 col-sm-12 col-md-3"></div>
												<div class="col-xs-12 col-sm-12 col-md-9">
												<div class="submit"><input name="add_publish" id="add_publish" type="submit" class="btn btn-primary" value="Add"></input>&nbsp;<input name="cancel" class="btn btn-default" id="cancel" type="reset" onclick="window.location='<?php echo $this->Session->read('strCancelUrl');?>'" value="Cancel"></input></div>												
												
												</div>
											</div>
											</form>
											
		<?php
/*		
<form id="contentform" name="contentform" action="" method="post" role="form">
	<ul class="panel-2 margin-top-5">
		<li style="margin:0;width:100%;"><label><span id="madatsym" class="madatsym">*</span><strong>Subject:</strong></label>
			<?php
				if(isset($arrProductContent['0']['content']['content_id']))
				{
					?>
						<input value="<?php echo stripslashes($arrProductContent['0']['content']['content_title']); ?>" id="content_title" name="content_title" type="text" class="form-control validate[required]" placeholder="Enter your content title here">
					<?php
				}
				else
				{
					?>
						<input id="content_title" name="content_title" type="text" class="form-control validate[required]" placeholder="Enter your content title here">
					<?php
				}
			?>
			<input value="<?php echo $arrProductContent['0']['content']['content_id']; ?>" id="content_edit_id" name="content_edit_id" type="hidden" class="form-control">
			<input type="hidden" name="content_request_for" id="content_request_for" value="" />
			<input type="hidden" name="content_request_for_id" id="content_request_for_id" value="" />
			<input type="hidden" name="service" id="service" value="<?php echo $intOrderId;?>" />
		</li>
		<li  style="margin:0;width:100%;" class="advance_search"><label><strong>Main Content:</strong></label>
			<?php
					if(isset($arrProductContent) && ($arrProductContent['0']['content']['content']))
					{
						?>
							<textarea style="margin:0;width:100%;" class="form-control" id="main_content" name="main_content"><?php echo stripslashes($arrProductContent['0']['content']['content']);?></textarea>
						<?php
					}
					else
					{
						?>
							<textarea style="margin:0;width:100%;" class="form-control" id="main_content" name="main_content"></textarea>
						<?php
					}
				?>
		</li>
		<li style="width:auto;">
			<input name="add_publish" id="add_publish" type="submit" value="Add"></input>
		</li>
		<li style="width:auto;">
			<a style="color:#fff;" class="button_class" href="<?php echo $strMyOredersUrl;?>">Cancel</a>
		</li>
		<li style="width:auto;display:none;" id="loader">
			<img src="<?php echo Router::url('/',true);?>/img/loader.gif" alt="Loader" title="Loader"/>
		</li>
	</ul>
</form> */?>
<?php
	//echo $this->element('contentfile_uploader_modal');
?>