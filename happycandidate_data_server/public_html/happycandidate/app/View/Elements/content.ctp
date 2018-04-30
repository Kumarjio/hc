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
		
		$('label').css('text-align','left');
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
		
		var strCurrentLocation = window.location.href;
		var arrCurrentLocationDetail = strCurrentLocation.split("/");
		
		var pageurl = "<?php echo Router::url('/', true)."content/add/";?>";
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('#content_html').hide();
				$('.cms-bgloader-mask').show();//show loader mask
				$('.cms-bgloader').show(); //show loading image
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

<div data-parent="#edit-contact-panel-slider" id="edit-contact" class="collapse in" style="">
    <div class="col-md-12 form-container edit-contact">
        <form id="contentform" name="contentform"  method="post" role="form">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="phone1">Category User:</label>
                    <select name="content_user" id="content_user" class="form-control col-xs-12 col-sm-12 col-md-8">
                        <option value="3">Job Seeker</option>
                        <option value="2">Owners</option>
                        <option value="5">Vendors</option>
                    </select>

                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-12 col-md-4">Content Type:</label>
                    <select name="content_type" id="content_type" class="form-control col-xs-12 col-sm-12 col-md-8">
                        <option value="0">--Default Content--</option>
                        <?php
                        foreach ($arrContentTypeList as $arrContentTypeKey => $arrContentTypeKeyVal) {
                            ?>
                            <option value="<?php echo $arrContentTypeKey; ?>"><?php echo $arrContentTypeKeyVal; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group" style="display:none" id="webinarregister">
                    <label class="control-label col-xs-12 col-sm-12 col-md-4">Register Link:</label>
                    <input type="text" name="linkRegister" id="linkRegister" class="form-control" value="<?php echo stripslashes($arrProductContent['0']['content']['webinarRegisterLink']); ?>"/>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="fax">Content Title:</label>
                    <input type="text" style="width:60%;" placeholder="Content Title" value="<?php echo stripslashes($arrProductContent['0']['content']['content_title']); ?>" id="content_title" name="content_title" class="col-xs-12 col-sm-12 col-md-8">
                    <input value="<?php echo $arrProductContent['0']['content']['content_id']; ?>" id="content_edit_id" name="content_edit_id" type="hidden" class="form-control">
                    <input type="hidden" name="content_request_for" id="content_request_for" value="" />
                    <input type="hidden" name="content_request_for_id" id="content_request_for_id" value="" />
                    <input type="hidden" name="content_added" id="content_added" value=""/>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Content Publish Date:</label>
                    <?php
                    $strPubDateToshow = date($strDateFormat);
                    if (isset($arrProductContent['0']['content']['content_published_date'])) {
                        $strPubDateToshow = date($strDateFormat, strtotime($arrProductContent['0']['content']['content_published_date']));
                        ?>
                        <input id="content_pub_date" name="content_pub_date" type="text" class="form-control validate[required]" value="<?php echo $strPubDateToshow; ?>" readonly>
                        <?php
                    } else {
                        ?>
                        <input readonly id="content_pub_date" name="content_pub_date" type="text" class="form-control validate[required]" value="<?php echo $strPubDateToshow; ?>">
                        <?php
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2">Content Intro Text:</label><!--
                    <div class="tinymce-tabs nopadding nomargin">
<a class="html editor2">Text</a>
<a class="visual editor2" class="active">Visual</a>
<div style="clear: both;"></div>
</div>
                    -->
                    <?php
                    if (isset($arrProductContent) && ($arrProductContent['0']['content']['content_intro_text'])) {
                        ?>
                        <textarea class="form-control" id="intro_content" name="intro_content" rows="5"><?php echo stripslashes($arrProductContent['0']['content']['content_intro_text']); ?></textarea>
                        <?php
                    } else {
                        ?>
                        <textarea class="form-control" id="intro_content" name="intro_content" rows="5"></textarea>
                        <?php
                    }
                    ?>

                    <?php /* <div name="reference-description" class="col-xs-12 col-sm-12 col-md-8 app-area-container">
                      <textarea id="txtEditor" name="intro_content" ><?php echo stripslashes($arrProductContent['0']['Content']['content_intro_text']); ?></textarea>
                      </div> */ ?>
                </div>


                <div class="form-group">
                    <!--<label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2"></label><!--
                    -->
                    <input data-toggle="modal" data-target="#mediaModal" name="add_media_main_content" id="add_media" class="content_media_button" type="button" value="Add Media"></input>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2">Main Content:</label>
<!--                    <div class="tinymce-tabs nopadding nomargin" style="float:right;">
                        <a class="html editor2">Text</a>
                        <a class="visual editor2" class="active">Visual</a>
                        <div style="clear: both;"></div>
                    </div>-->
                    <?php
                    if (isset($arrProductContent) && ($arrProductContent['0']['content']['content'])) {
                        ?>
                        <textarea class="form-control" id="main_content" name="main_content" rows="5"><?php echo stripslashes($arrProductContent['0']['content']['content']); ?></textarea>
                        <?php
                    } else {
                        ?>
                        <textarea class="form-control" id="main_content" name="main_content" rows="5"></textarea>
                        <?php
                    }
                    ?>
                    <?php /* <div name="reference-description" class="col-xs-12 col-sm-12 col-md-8 app-area-container">
                      <textarea id="txtEditorContent" name="main_content" ><?php echo stripslashes($arrProductContent['0']['Content']['content']); ?></textarea>
                      </div> */ ?>

                </div>
            </div>
            <div class="col-md-12 submit-container">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="hidden-xs hidden-sm col-md-4"></div>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                            <button type="button" class="btn btn-primary" onclick="return fnSubmitContent();" type="button">Save Changes</button>
                            <button class="btn btn-warning" type="button">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
	echo $this->Html->script('content_form');
?>
<?php
	//echo $this->element('contentfile_uploader_modal');
?>
<script>
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
</script>