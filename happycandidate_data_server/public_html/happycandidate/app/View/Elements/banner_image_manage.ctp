<div id="dialog-banner_image-form" title="Add Banner Image" style="display:none;">
	<!--<p class="validateTips">All form fields are required.</p>-->

	<form type="POST" enctype="multipart/form-data" id="bannerimageform">
		<fieldset>
			<label for="banner_image_name">Banner Image</label>
			<input type="file" name="banner_image_name" id="banner_image_name" class="text ui-widget-content ui-corner-all validate[required]" />
			<span id="bannerimageerror" class="ui-state-error" style="display:none;"></span>
			<div>&nbsp;</div>
			<div id="explanatory_text">Add image of dimension 1263X312 for better effect.</div>
			<div>&nbsp;</div>
			<span id="bannerimagesuccess" class="ui-state-success" style="display:none;"></span>
			<span id="bannerimageloader" style="display:none;"><img src='<?php echo Router::url('/', true);?>img/loader.gif'/></span>
		</fieldset>
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('#banner_image').focus(function () {
			$('#bannerimageerror').fadeOut('slow');
			$('#bannerimagesuccess').fadeOut('slow');
		});
		
		$("#dialog-banner_image-form").dialog({
			autoOpen: false,
			height: 260,
			width: 350,
			modal: true,
			buttons: {
				"Update": function() {
					$('#bannerimageerror').text("");
					$('#bannerimagesuccess').text("");
					$('#bannerimagesuccess').hide();
					
					var strBannerImageData = $('#banner_image_name').val();
					var strBannerImageExtension = $('#banner_image_name').val().split('.').pop();
					if(strBannerImageData == "")
					{
						strErrorMessage = "Please Provide Banner Image.";
						$('#bannerimageerror').text("");
						$('#bannerimageerror').text(strErrorMessage);
						$('#bannerimageerror').fadeIn('slow');
						return false;
					}
					else
					{
						if($.inArray(strBannerImageExtension, ['jpg','JPG','JPEG','jpeg','png','PNG','bmp','BMP','gif','GIF']) == -1) 
						{
							strErrorMessage = "Log Extension Not Valid.";
							$('#bannerimageerror').text("");
							$('#bannerimageerror').text(strErrorMessage);
							$('#bannerimageerror').fadeIn('slow');
							return false;
						}
						else
						{
							$('#bannerimageloader').show();
							var bannerurl = "<?php echo Router::url('/', true).$this->params['controller']."/updateportalbannerimage/".$this->params['pass']['0'];?>";
							var type = "POST";
							var options = { 
								//target:        '#output2',   // target element(s) to be updated with server response 
								success:	function(responseText, statusText, xhr, $form) {
									if(responseText.status == "success")
									{
										$('#bannerimageloader').hide();
										$('#bannerimagesuccess').text('');
										$('#bannerimagesuccess').text(responseText.message);
										$('#bannerimagesuccess').fadeIn('slow');
										$('#banner_image').attr('src',"<?php echo Router::url('/', true); ?>"+'/img/theme/default/img/'+responseText.newimage);
										
									}
									else
									{
										$('#bannerimageloader').hide();
										$('#bannerimageerror').text("");
										$('#bannerimageerror').text(responseText.message);
										$('#bannerimageerror').fadeIn('slow');
									}
								},								
						 
								// other available options: 
								url:       bannerurl,         // override for form's 'action' attribute 
								type:      type,        // 'get' or 'post', override for form's 'method' attribute 
								dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
								//clearForm: true        // clear all form fields after successful submit 
								//resetForm: true        // reset the form after successful submit 
						 
								// $.ajax options can be used here too, for example: 
								//timeout:   3000 
							} 
							$('#bannerimageform').ajaxSubmit(options); 
					 
							// !!! Important !!! 
							// always return false to prevent standard browser submit and page navigation 
							return false; 
						}
													
					}
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				
			}
		});
	
	});

</script>