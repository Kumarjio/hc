<div id="dialog-logo-form" title="Update Portal Detail" style="display:none;">
	<!--<p class="validateTips">All form fields are required.</p>-->

	<form type="POST" enctype="multipart/form-data" id="logoform">
		<fieldset>
			<label for="portal_logo">Portal Logo</label>
			<input type="file" name="portal_logo" id="portal_logo" class="text ui-widget-content ui-corner-all validate[required]" />
			<span id="logoerror" class="ui-state-error" style="display:none;"></span>
			<div>&nbsp;</div>
			<label for="portal_name">Portal Name</label>
			<input value="<?php echo $arrPortalDetail['0']['Portal']['career_portal_name']; ?>" type="text" name="portal_name" id="portal_name" class="text ui-widget-content ui-corner-all validate[required]" />
			<span id="nameerror" class="ui-state-error" style="display:none;"></span>
			
			<span id="logosuccess" class="ui-state-success" style="display:none;"></span>
			<span id="logoloader" style="display:none;"><img src='<?php echo Router::url('/', true);?>img/loader.gif'/></span>
		</fieldset>
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('#portal_logo').focus(function () {
			$('#logoerror').fadeOut('slow');
			$('#logosuccess').fadeOut('slow');
		});
		
		$( "#dialog-logo-form" ).dialog({
			autoOpen: false,
			height: 290,
			width: 350,
			modal: true,
			buttons: {
				"Update": function() {
					$('#logoerror').text("");
					$('#logosuccess').text("");
					$('#logosuccess').hide();
					
					var strLogoData = $('#portal_logo').val();
					var strLogoExtension = $('#portal_logo').val().split('.').pop();
					if(strLogoData == "")
					{
						strErrorMessage = "Please Provide Logo.";
						$('#logoerror').text("");
						$('#logoerror').text(strErrorMessage);
						$('#logoerror').fadeIn('slow');
						return false;
					}
					else
					{
						if($.inArray(strLogoExtension, ['jpg','JPG','JPEG','jpeg','png','PNG','bmp','BMP','gif','GIF']) == -1) 
						{
							strErrorMessage = "Log Extension Not Valid.";
							$('#logoerror').text("");
							$('#logoerror').text(strErrorMessage);
							$('#logoerror').fadeIn('slow');
							return false;
						}
						else
						{
							$('#logoloader').show();
							var url = "<?php echo Router::url('/', true).$this->params['controller']."/updateportallogo/".$this->params['pass']['0'];?>";
							var type = "POST";
							var options = { 
								//target:        '#output2',   // target element(s) to be updated with server response 
								success:	function(responseText, statusText, xhr, $form) {
									if(responseText.status == "success")
									{
										$('#logoloader').hide();
										$('#logosuccess').text('');
										$('#logosuccess').text(responseText.message);
										$('#logosuccess').fadeIn('slow');
										$('#portal_header_logo').attr('src',"<?php echo Router::url('/', true); ?>"+'/userdata/portal/'+responseText.newimage);
										$('#page_portal_name').text('');
										$('#page_portal_name').text($('#portal_name').val());
										
									}
									else
									{
										$('#logoloader').hide();
										$('#logoerror').text("");
										$('#logoerror').text(responseText.message);
										$('#logoerror').fadeIn('slow');
									}
								},								
						 
								// other available options: 
								url:       url,         // override for form's 'action' attribute 
								type:      type,        // 'get' or 'post', override for form's 'method' attribute 
								dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
								//clearForm: true        // clear all form fields after successful submit 
								//resetForm: true        // reset the form after successful submit 
						 
								// $.ajax options can be used here too, for example: 
								//timeout:   3000 
							} 
							$('#logoform').ajaxSubmit(options); 
					 
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