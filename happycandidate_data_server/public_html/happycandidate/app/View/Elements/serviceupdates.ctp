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
		
		$('#content_title').keydown(function(e){
	
			var code = e.keyCode || e.which;
			if (code === 9) { 
			
				e.preventDefault();
				$(".Editor-editor").focus();
			}
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
		var strMainContent =  $("#txtEditorContent").Editor("getText");
		
		
		var strCurrentLocation = window.location.href;
		var arrCurrentLocationDetail = strCurrentLocation.split("/");
		var pageurl = "<?php echo Router::url('/', true)."vendororders/addorderupdates/";?>"+intOrderUpdateId;
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				//$('#content_html').hide();
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
					//$('#content_html').hide();
					//$('#filepart').show();
					//$('#file_part').addClass('tab-pane fade in active');
					
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
					$('#file_part').show();
					
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

<form  id="contentform" name="contentform" action="" method="post" role="form" enctype="multipart/form-data">
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
												<div class="col-xs-12 col-sm-12 col-md-3">
													<label for="last-name" class="control-label">Files: <span class="form-required">*</span></label>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-9">
					
												<button onclick="$('input[id=profilePicture]').click(); return false;" class="btn btn-default w28">
												<span class="btn-attach-icon"></span><!----><span>Add Attachement</span>
												</button>
												<div id="photoCover"></div>
										<input id="profilePicture" class="validate[checkFileType[doc|docx|pdf]] " name="profilePicture" type="file" style="display:none">
					
												</div>
											</div>
											<script type="text/javascript">
											$('input[id=profilePicture]').change(function() {
											$('#photoCover').html($(this).val());
											});
											</script>
											<div class="form-group">
												<div class="col-xs-12 col-sm-12 col-md-3"></div>
												<div class="col-xs-12 col-sm-12 col-md-9">
												<div class="submit"><input name="add_publish" id="add_publish" type="submit" class="btn btn-primary" value="Add"></input>&nbsp;<input name="cancel" class="btn btn-default" id="cancel" type="reset" onclick="window.location='<?php echo $this->Session->read('strCancelUrl');?>'" value="Cancel"></input></div>												
												
												</div>
											</div>
											</form>
<!--<form id="contentform" name="contentform" action="" method="post" role="form">
	<div class="row ">
		<div class="col-md-12 nomargin"><span id="madatsym" class="madatsym">*</span><strong>Subject:</strong></div>
		<div class="col-md-9">
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
		</div>
	</div>
	<div class="row nopadding nomargin">
		<div class="col-md-12 nomargin"><strong>Main Content:</strong></div>
		<div class="col-md-12">
			<div class="col-md-12 nopadding nomargin" style="float:left;width:100%;clear:none;">	
				<div class="col-md-4 nopadding nomargin" style="float:left;">
					<!--<button data-toggle="modal" data-target="#htmlfileuploaderModal" name="content_uploadhtml_file" id="content_uploadhtml_file" class="btn btn-sm btn-default" type="button">Upload File</button>-->
					<!--<button data-toggle="modal" data-target="#widgetModal" name="products" id="content_widget_button" class="btn btn-sm btn-default content_widgets_button" type="button">Assign Widgets</button>
					<?php
						if(isset($arrContWidgets) && (is_array($arrContWidgets)) && (count($arrContWidgets)>0))
						{
							$strContWidgetString = implode(",",$arrContWidgets).",";
							?>
								<input type="hidden" name="content_widgets" id="content_widgets" value="<?php echo $strContWidgetString;?>" />
							<?php
						}
						else
						{
							?>
								<input type="hidden" name="content_widgets" id="content_widgets" value="" />
							<?php
						}
					?>-->
				<!--</div>
				<div class="nopadding nomargin"  style="float:right;clear:none;">
					<div class="tinymce-tabs nopadding nomargin">
						<a class="html editor1">Text</a>
						<a class="visual editor1" class="active">Visual</a>
						<div style="clear: both;"></div>
					</div> 
				</div>
			</div>
			<div class="col-md-12 nopadding">
				<?php
					if(isset($arrProductContent) && ($arrProductContent['0']['content']['content']))
					{
						?>
							<textarea class="form-control" id="main_content" name="main_content" rows="5"><?php echo stripslashes($arrProductContent['0']['content']['content']);?></textarea>
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
		</div>
	</div>
	<div class="row">
		<div class="col-md-9"><input name="add_publish" id="add_publish" type="submit" value="Add"></input>&nbsp;<input name="cancel" id="cancel" type="reset" onclick="window.location='<?php echo $this->Session->read('strCancelUrl');?>'" value="Cancel"></input></div>
	</div>
</form>-->
<?php
	echo $this->Html->script('content_form');
?>
<?php
	//echo $this->element('contentfile_uploader_modal');
?>