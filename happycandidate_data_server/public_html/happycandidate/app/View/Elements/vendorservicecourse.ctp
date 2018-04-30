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
		var strIntroContentEditorType = $('.html.editor2.active').text();
		if(strIntroContentEditorType == "Text")
		{
			var strIntroContent = $('#intro_content').val();
		}
		else
		{
			var strIntroContent = tinyMCE.get('intro_content').getContent();
			
		}
		
		var strMainContentEditorType = $('.html.editor1.active').text();
		if(strMainContentEditorType == "Text")
		{
			var strMainContent = $('#main_content').val();
		}
		else
		{
			var strMainContent = tinyMCE.get('main_content').getContent();
			
		}
			
		/*var strLeftContentEditorType = $('.html.editor3.active').text();
		if(strLeftContentEditorType == "Text")
		{
			var strLeftContent = $('#left_content').val();
		}
		else
		{
			var strLeftContent = tinyMCE.get('left_content').getContent();
			
		}
		
		var strRightContentEditorType = $('.html.editor4.active').text();
		if(strRightContentEditorType == "Text")
		{
			var strRightContent = $('#right_content').val();
		}
		else
		{
			var strRightContent = tinyMCE.get('right_content').getContent();
			
		}*/

		var strCurrentLocation = window.location.href;
		var arrCurrentLocationDetail = strCurrentLocation.split("/");
		
		var pageurl = "<?php echo Router::url('/', true)."vendorcourse/add/";?>";
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
					formData.push({name:'to_moderate', value:"1"});
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
					activateTinyMCETab('visual', '.tinymce-tabs .visual.editor1', '.tinymce-tabs .html.editor1', 'main_content');
					activateTinyMCETab('visual','.tinymce-tabs .visual.editor2','.tinymce-tabs .html.editor2', 'intro_content');
					tinyMCE.get('main_content').setContent(strMainContent);
					tinyMCE.get('intro_content').setContent(strIntroContent);			
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
					$('#cat').show();
					//$('#contentparent').show();
					$('#jbsearchcat').show();
					
					//var strTobeReturned = $("#dialog-add-page-form").data('returnvalue');
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
<form id="contentform" name="contentform" action="" method="post" role="form">
	<div class="form-group">
		<div class="col-md-12"><span id="madatsym" class="madatsym">*</span><strong>Name:</strong></div>
		<div class="col-md-9">
			<?php
				if(isset($arrProductContent['0']['Resources']['product_name']))
				{
					?>
						<input value="<?php echo stripslashes($arrProductContent['0']['Resources']['product_name']); ?>" id="service_name" name="service_name" type="text" class="form-control validate[required]" placeholder="Enter your service name here">
					<?php
				}
				else
				{
					?>
						<input id="service_name" name="service_name" type="text" class="form-control validate[required]" placeholder="Enter your service name here">
					<?php
				}
			?>
			<input value="<?php echo $arrProductContent['0']['Resources']['productd_id']; ?>" id="content_edit_id" name="content_edit_id" type="hidden" class="form-control">
			<input type="hidden" name="content_request_for" id="content_request_for" value="" />
			<input type="hidden" name="content_request_for_id" id="content_request_for_id" value="" />
			<input type="hidden" name="external_service_id" id="external_service_id" value="<?php echo $arrProductContent['0']['Resources']['external_content_id'];?>" />
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12"><strong>Cost:</strong></div>
		<div class="col-md-9">
			<?php
				$strPubDateToshow = date($strDateFormat);
				//$strPubDateToshow = date('Y-m-d');
				if(isset($arrProductContent['0']['Resources']['product_cost']))
				{
					?>
						<input value="<?php echo stripslashes($arrProductContent['0']['Resources']['product_cost']); ?>" id="service_cost" name="service_cost" type="text" class="form-control validate[required]" placeholder="Enter your service cost here">
					<?php
				}
				else
				{
					
					?>
						<input value="" id="service_cost" name="service_cost" type="text" class="form-control validate[required]" placeholder="Enter your service cost here">
					<?php
				}
			?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12"><span id="madatsym" class="madatsym">*</span><strong>Content Title:</strong></div>
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
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12"><strong>Title Alias:</strong></div>
		<div class="col-md-9">
			<?php
				$strPubDateToshow = date($strDateFormat);
				//$strPubDateToshow = date('Y-m-d');
				if(isset($arrProductContent['0']['Content']['content_title_alias']))
				{
					?>
						<input id="content_title_alias" name="content_title_alias" type="text" class="form-control validate[required]" value="<?php echo$arrProductContent['0']['Content']['content_title_alias']; ?>">
					<?php
				}
				else
				{
					
					?>
						<input id="content_title_alias" name="content_title_alias" type="text" class="form-control validate[required]" value="">
					<?php
				}
			?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12"><strong>Content Intro Text:</strong></div>
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
	<div class="form-group">
		<div class="col-md-12"><strong>Main Content:</strong></div>
		<div class="col-md-12">
			<div class="col-md-12 nopadding" style="float:left;width:100%;clear:none;">	
				<div class="col-md-4 nopadding" style="float:left;">
					<input style="width:50%;" data-toggle="modal" data-target="#mediaModal" name="add_media_main_content" id="add_media" class="content_media_button" type="button" value="Add Media"></input>
				</div>
				<div  style="float:right;clear:none;">
					<div class="tinymce-tabs">
						<a class="html editor1">Text</a>
						<a class="visual editor1" class="active">Visual</a>
						<div style="clear: both;"></div>
					</div> 
				</div>
			</div>
			<div class="col-md-12  nopadding">
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
		<div class="col-md-9"><input name="add" id="add" type="submit" value="Save as Draft"></input>&nbsp;<input name="add_publish" id="add_publish" type="submit" value="Save & Set For Moderation"></input>&nbsp;<!--<button name="add" id="add" class="btn btn-lg btn-primary" type="button"><a href="<?php //echo $strPreviewUrl; ?>" target="_blank">Preview</a></button>&nbsp;--><input name="cancel" id="cancel" type="reset" onclick="window.location='<?php echo $this->Session->read('strCancelUrl');?>'" value="Cancel"></input></div>
	</div>
</form>
<?php
	echo $this->Html->script('content_form');
?>