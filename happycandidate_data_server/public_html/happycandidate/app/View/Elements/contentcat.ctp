
<script type="text/javascript">
	var strContU = "<?php echo $arrProductContent[0]['Categories']['content_cat_for_user']; ?>";
	$(document).ready(function () {
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
		
		var strMainContentEditorType = $('.html.editor1.active').text();
		if(strMainContentEditorType == "Text")
		{
			var strMainContent = $('#main_content').val();
			var strIntroContent = $('#intro_content').val();
		}
		else
		{
			var strMainContent = tinyMCE.get('main_content').getContent();
			var strIntroContent = tinyMCE.get('intro_content').getContent();
			
		}

		var strCurrentLocation = window.location.href;
		var arrCurrentLocationDetail = strCurrentLocation.split("/");
		
		var pageurl = "<?php echo Router::url('/', true)."contentcategories/add/";?>";
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('#content_html').hide();
				$('.tabloader').show();
				formData.push({name:'main_contentnew', value:strMainContent});
				formData.push({name:'intro_contentnew', value:strIntroContent});
				formData.push({name:'content_edit_id', value:$('#content_edit_id').val()});
				if(isToBePublished == "1")
				{
					formData.push({name:'to_publish', value:"1"});
				}
				
				$('.cms-bgloader-mask').show();//show loader mask
				$('.cms-bgloader').show(); //show loading image
				
			},
			success:function(responseText, statusText, xhr, $form) {
				if(responseText.status == "success")
				{
					$('.tabloader').hide();
					$('#content_html').show();
					$('#product_notification').html('');
					$('#product_notification').html(responseText.message);
					$('#product_notification').fadeIn('slow');
				
					if($('#content_edit_id').val() != "")
					{
						$('#content_edit_id').val($('#content_edit_id').val());
						$('#content_cat_added').val($('#content_edit_id').val());
					}
					else
					{
						$('#content_edit_id').val(responseText.createdid);
						$('#content_cat_added').val(responseText.createdid);
					}
					if($('#cat_type').length > 0)
					{
						if($('#cat_type').val() == "Steps" || $('#cat_type').val() == "Substeps")
						{
							$('#subcat').show();
						}
						
						if($('#cat_type').val() == "Steps")
						{
							$('.page-header h1').text('Edit Steps');
						}
						else
						{
							if($('#cat_type').val() == "Phase")
							{
								$('.page-header h1').text('Edit Phase');
							}
							else
							{
								if($('#cat_type').val() == "Substeps")
								{
									$('.page-header h1').text('Edit Substeps');
								}
								else
								{
									$('.page-header h1').text('Edit Categories');
								}
							}
							
						}
					}
					//$('.nav-tabs li').removeClass('disabled');
					window.location = "<?php echo Router::url('/', true)."contentcategories";?>";
					
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
				
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				fnClearMessage();
				
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

								<div class="col-md-12 form-container edit-contact">
								
									<form role="form" method="post" id="contentform" name="contentform">
							<div class="col-md-12">
											<div class="form-group" id="usercont">
												<label class="control-label col-xs-12 col-sm-12 col-md-4" for="phone1"><span id="user_label">Category User:</span></label><!--
												-->
										<select name="content_user" id="content_user" class="form-control col-xs-12 col-sm-12 col-md-8">
											<option value="3">Job Seeker</option>
											<option value="2">Owners</option>
											<option value="5">Vendors</option>
											</select>
											
											</div>
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4"><span id="name_label">Category Name:<span></label><!--
												--><input type="text" placeholder=" Name" value="<?php echo $arrProductContent['0']['Categories']['content_category_name']; ?>" id="content_title" name="content_title" class="col-xs-12 col-sm-12 col-md-8">
												<input value="<?php echo $arrProductContent['0']['Categories']['content_category_id']; ?>" id="content_edit_id" name="content_edit_id" type="hidden" class="form-control">
			<input type="hidden" name="content_request_for" id="content_request_for" value="" />
			<input type="hidden" name="content_request_for_id" id="content_request_for_id" value="" />
			<input type="hidden" name="cat_type" id="cat_type" value="" />
											</div>
											
											<div class="form-group" id="iconcont">
												<label class="control-label col-xs-12 col-sm-12 col-md-4" for="fax"><span id="phase_icon_label">Category Icon:</span></label><!--
												<input name="add_banner_media" id="add_banner_media" type="submit" onclick="return false;" value="Add Icon"></input>-->
												<div class="group-container">
									
										<?php //if($arrProductContent['0']['Categories']['content_category_image'] == null){?>
										<div id="nimage" style="display: <?php echo ($arrProductContent['0']['Categories']['content_category_image'] == null) ? '':'none';?>">
										<span>Icon should be of dimention 70 x 70.</span><br/>
										<button onclick="$('input[id=content_category_image]').click(); return false;" class="btn btn-default w28">
									 		<span class="btn-attach-icon"></span><!-- 
									 	 --><span>Add Icon</span> 
									 	</button>
										<div id="photoCover" style="display: inline;"></div>
										<input id="content_category_image" class="validate[checkFileType[jpg|png|gif]] " name="content_category_image" type="file" style="display:none">
										</div>
										<?php //}else{ ?>
											<div id="yimage" style="display: <?php echo ($arrProductContent['0']['Categories']['content_category_image'] == null)?'none':'';?>">
											<img src="<?php echo $this->webroot;?>contentcat/<?php echo $arrProductContent['0']['Categories']['content_category_image'];?>" width="70px" height="70px">
											<button onclick="removeimg();return false;" class="btn btn-default w28">
												<!--span class="btn-attach-icon"></span--> 
											<span>Remove Icon</span>
											</button>
											</div>
										<?php //} ?>
								</div>
								<script type="text/javascript">
								$('input[id=content_category_image]').change(function() {
								$('#photoCover').html($(this).val());
								});
								function removeimg()
								{
									$('#nimage').show();
									$('#yimage').hide();
								}
								</script>
											</div>
											
											<div class="form-group">
										
											
												<label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2"><strong id="phase_introtext_label">Category Description:</strong></label><!--
												-->
												<div name="reference-description" class="col-xs-12 col-sm-12 col-md-8 app-area-container">
											    	
			
			<div class="col-md-12 nopadding">
				<?php
					//echo $arrProductContent['0']['Categories']['content_category_introtext'];
					
					if($arrProductContent['0']['Categories']['content_category_introtext'])
					{
						?>
							<textarea class="form-control" id="intro_content" name="intro_content" rows="5"><?php echo stripslashes($arrProductContent['0']['Categories']['content_category_introtext']);?></textarea>
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
											</div>
											
											
											<div class="form-group">
										
											
												<label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2"><strong id="phase_desc_label">Category Description:</strong></label><!--
												-->
												<div name="reference-description" class="col-xs-12 col-sm-12 col-md-8 app-area-container">
											    	
			
			<div class="col-md-12 nopadding">
				<?php
					//print("<pre>");
					//print_r($arrProductContent);
					
					if($arrProductContent['0']['Categories']['content_category_description'])
					{
						?>
							<textarea class="form-control" id="main_content" name="main_content" rows="5"><?php echo stripslashes($arrProductContent['0']['Categories']['content_category_description']);?></textarea>
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
											
											
										</div>
										<div class="col-md-12 submit-container">
											<div class="col-md-6">
											<div class="form-group">
												<div class="hidden-xs hidden-sm col-md-4"></div>
												<div class="col-xs-12 col-sm-12 col-md-8">
												
											<?php $url = Router::url('/', true).'/'.$this->params['controller'];?>
													<button type="button" class="btn btn-primary" onClick="return fnSubmitContent();" type="button">Save Changes</button>
													<button class="btn btn-warning" type="button" onClick="javascript:window.location='<?php echo $url?>'">Cancel</button>
												</div></div>
											</div>
										</div>
									</form>
								</div>

						

<?php
	echo $this->Html->script('content_form');
?>
<?php
	echo $this->element('contentfile_uploader_modal');
?>