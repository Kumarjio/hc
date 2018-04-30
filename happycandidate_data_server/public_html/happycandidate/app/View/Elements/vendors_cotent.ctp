<?php
	//echo "--".$arrProductContent[0]['content']['content_for_user'];exit;
?>
<script type="text/javascript">
	$(document).ready(function () {
		
		$('#content_uploadhtml_file').click(function () {
			fnGetContentFileUploader();
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
	
	var isValidated = $('#vendorcontentform').validationEngine('validate');	
	//var isValidated = true;
	
	if(isValidated == false)
	{
	  return false;
	}
	else
	{ 
	
		var strIntroContent =  $("#txtEditor").Editor("getText");
		var strMainContent =  $("#txtEditorContent").Editor("getText");
			
		

		var strCurrentLocation = window.location.href;
		var arrCurrentLocationDetail = strCurrentLocation.split("/");
		
		var pageurl = "<?php echo Router::url('/', true)."vendors/contentadd/";?>";
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('#content_html').hide();
				$('.tabloader').show();
				formData.push({name:'main_content', value:strMainContent});
				formData.push({name:'intro_content', value:strIntroContent});
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
					
					//$('#cat').show();
					$('#js-company-detail').show();
					$('#tab-company-detail').addClass('tab-pane fade in active');
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
		$('#vendorcontentform').ajaxSubmit(pageoptions);
		return false;
	}
}
</script>

<div data-parent="#edit-contact-panel-slider" id="edit-contact" class="collapse in" style="">
								<div class="col-md-12 form-container edit-contact">
								<form id="vendorcontentform" name="vendorcontentform" action="" method="post" role="form">
							<div class="col-md-12">
											
									
											
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4" for="fax">Content Title:</label><!--
												--><input type="text"  placeholder="Content Title" value="<?php echo stripslashes($arrProductContent['0']['Content']['content_title']); ?>" id="content_title" name="content_title"  class="col-xs-12 col-sm-12 col-md-8">
												
											</div>
											<?php
				$strPubDateToshow = date($strDateFormat);
				//$strPubDateToshow = date('Y-m-d');
				if(isset($arrProductContent['0']['Content']['content_published_date']))
				{
					$strPubDateToshow = date($strDateFormat,strtotime($arrProductContent['0']['Content']['content_published_date']));
				
				}
				?>
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Content Publish Date:</label><!--
												-->
													<input id="content_pub_date" name="content_pub_date" type="text" class="form-control validate[required]" value="<?php echo $strPubDateToshow; ?>" readonly>
											</div>
											<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2"></label>
											<input data-toggle="modal" data-target="#mediaModal" name="add_media_main_content" id="add_media" class="content_media_button" type="button" value="Add Media" onclick="fnShowMediaUploader(this);"></input>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Content Intro Text:</label>
												<div name="reference-description" class="col-xs-12 col-sm-12 col-md-8 app-area-container">
												<textarea class="form-control" id="txtEditor" name="intro_content" class="" ><?php echo stripslashes($arrProductContent['0']['content']['content_intro_text']); ?></textarea>
												</div>
											</div>
											
											<div class="form-group ">
											
												<label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Main Content:</label>
												<div name="reference-description" class="col-xs-12 col-sm-12 col-md-8 app-area-container">
												<textarea class="form-control" id="txtEditorContent" name="main_content" ><?php echo stripslashes($arrProductContent['0']['content']['content']);?></textarea>
												</div>
											</div>
											
										</div>
										<div class="col-md-12 submit-container">
											<div class="col-md-6">
											<div class="form-group">
												<div class="hidden-xs hidden-sm col-md-4"></div>
												<div class="col-xs-12 col-sm-12 col-md-8">
													<button type="button" class="btn btn-primary" onclick="return fnSubmitContent();" type="button">Save Changes</button>
													<button class="btn btn-warning" type="button">Cancel</button>
												</div></div>
											</div>
										</div>
									</form>
								</div>

							</div>
							
			<?php	/*			
<form id="vendorcontentform" name="vendorcontentform" action="" method="post" role="form">
	<div class="row nopadding nomargin">
		<div class="col-md-12 nomargin"><span id="madatsym" class="madatsym">*</span><strong>Content Title:</strong></div>
		<div class="col-md-9">
			<?php
				if(isset($arrProductContent['0']['Content']['content_title']))
				{
					?>
						<input value="<?php echo stripslashes($arrProductContent['0']['Content']['content_title']); ?>" id="content_title" name="content_title" type="text" class="form-control validate[required]" placeholder="Enter your content title here">
					<?php
				}
				else
				{
					?>
						<input id="content_title" name="content_title" type="text" class="form-control validate[required]" placeholder="Enter your content title here">
					<?php
				}
			?>
			<input value="<?php echo $arrProductContent['0']['Content']['content_id']; ?>" id="vendor_content_edit_id" name="vendor_content_edit_id" type="hidden" class="form-control">
		</div>
	</div>
	<div class="row nopadding nomargin">
		<div class="col-md-12 nomargin"><strong>Content Publish Date:</strong></div>
		<div class="col-md-9">
			<?php
				$strPubDateToshow = date($strDateFormat);
				//$strPubDateToshow = date('Y-m-d');
				if(isset($arrProductContent['0']['Content']['content_published_date']))
				{
					$strPubDateToshow = date($strDateFormat,strtotime($arrProductContent['0']['Content']['content_published_date']));
					?>
						<input id="content_pub_date" name="content_pub_date" type="text" class="form-control validate[required]" value="<?php echo $strPubDateToshow; ?>" readonly>
					<?php
				}
				else
				{
					
					?>
						<input readonly id="content_pub_date" name="content_pub_date" type="text" class="form-control validate[required]" value="<?php echo $strPubDateToshow; ?>">
					<?php
				}
			?>
		</div>
	</div>
	<div class="row nopadding nomargin">
		<div class="col-md-12 nomargin"><strong>Content Intro Text:</strong></div>
		<div class="col-md-12">
			<div class="tinymce-tabs nopadding nomargin">
				<a class="html editor2">Text</a>
				<a class="visual editor2" class="active">Visual</a>
				<div style="clear: both;"></div>
			</div>
			<?php
				if(isset($arrProductContent) && ($arrProductContent['0']['Content']['content_intro_text']))
				{
					?>
						<textarea class="form-control" id="intro_content" name="intro_content" rows="5"><?php echo stripslashes($arrProductContent['0']['Content']['content_intro_text']); ?></textarea>
					<?php
				}
				else
				{
					?>
						<textarea class="form-control" id="intro_content" name="intro_content" rows="5"></textarea>
					<?php
				}
			?>
		</div>
	</div>
	<div class="row nopadding nomargin">
		<div class="col-md-12 nomargin"><strong>Main Content:</strong></div>
		<div class="col-md-12">
			<div class="col-md-12 nopadding nomargin" style="float:left;width:100%;clear:none;">	
				<div class="col-md-4 nopadding nomargin" style="float:left;">
					<input data-toggle="modal" data-target="#mediaModal" name="add_media_main_content" id="add_media" class="content_media_button" type="button" value="Add Media" onclick="fnShowMediaUploader(this);"></input>
				</div>
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
					if(isset($arrProductContent) && ($arrProductContent['0']['Content']['content']))
					{
						?>
							<textarea class="form-control" id="main_content" name="main_content" rows="5"><?php echo stripslashes($arrProductContent['0']['Content']['content']);?></textarea>
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
		<div class="col-md-9"><input name="add" id="add" type="submit" value="Save as Draft" onclick="fnSubmitContent();return false;"></input>&nbsp;<input name="add_publish" id="add_publish" type="submit" value="Save & Publish" onclick="fnSubmitContent('1');return false;"></input>&nbsp;<!--<button name="add" id="add" class="btn btn-lg btn-primary" type="button"><a href="<?php //echo $strPreviewUrl; ?>" target="_blank">Preview</a></button>&nbsp;--><input name="cancel" id="cancel" type="reset" onclick="window.location='<?php echo $this->Session->read('strCancelUrl');?>'" value="Cancel"></input></div>
	</div>
</form>*/?>
<?php
	echo $this->Html->script('content_form');
?>
<?php
	//echo $this->element('contentfile_uploader_modal');
?>
<script type="text/javascript">
	$(document).ready(function () {
		$("#txtEditor").Editor(); 
			$("#txtEditorContent").Editor();
			
		$("#txtEditor").Editor("setText", '<?php echo htmlspecialchars_decode($arrProductContent['0']['Content']['content_intro_text']); ?>');
			$("#txtEditorContent").Editor("setText", '<?php echo htmlspecialchars_decode($arrProductContent['0']['Content']['content']); ?>');
			
	});
</script>