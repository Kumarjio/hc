<div id="dialog-copyright-form" title="Edit Copyright Text" style="display:none;">
	<!--<p class="validateTips">All form fields are required.</p>-->

	<form id="footerform">
		<fieldset>
			<div id="postcopyrightmessages" class="" style="width:95%;display:none;"></div>
			<span id="copyrightloader" style="display:none;"><img src='<?php echo Router::url('/', true);?>img/loader.gif'/></span>
			<div>&nbsp;</div>
			<label for="name">Copyright Text</label>
			<div>&nbsp;</div>
			<input type="text" name="footer_text" id="footer_text" class="text ui-widget-content ui-corner-all" />
			<div>&nbsp;</div>
			<div id="copyrighttexterror" class="ui-state-error" style="width:95%;display:none;"></div>
		</fieldset>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function () {		
		$('#footer_text').focus(function () {
				$('#postcopyrightmessages').fadeOut('slow');
				$('#copyrighttexterror').fadeOut('slow');
		});
		
		$( "#dialog-copyright-form" ).dialog({
				autoOpen: false,
				height: 260,
				width: 350,
				modal: true,
				open: function () {
					var strFooterText = $('#footertext').text();
					$('#footer_text').val(strFooterText);
				},
				buttons: {
					"Edit": function() {
						
						$('#postcopyrightmessages').text("");
						$('#copyrighttexterror').text("");
						
						var strCopyrightText = $('#footer_text').val();
						if(strCopyrightText == "")
						{
							strErrorMessage = "Please Provide Copyright Text.";
							$('#copyrighttexterror').text("");
							$('#copyrighttexterror').text(strErrorMessage);
							$('#copyrighttexterror').fadeIn('slow');
							return false;
						}
						else
						{
							$('#copyrightloader').show();
							var copyrighturl = "<?php echo Router::url('/', true)."employers/copyrighttext/".$_GET['portal_id'];?>";
							var copyrighttype = "POST";
							var copyrighttextoptions = { 
								beforeSubmit:  function(formData, jqForm, options) {
								},
								success:function(responseText, statusText, xhr, $form) {
									//alert(responseText);
									if(responseText.status == "success")
									{
										$('#copyrightloader').hide();
										$('#postcopyrightmessages').text('');
										$('#postcopyrightmessages').addClass('ui-state-success');
										$('#postcopyrightmessages').text(responseText.message);
										$('#postcopyrightmessages').fadeIn('slow');
										$('#footertext').text('');
										$('#footertext').text(strCopyrightText);
									}
									else
									{
										$('#copyrightloader').hide();
										$('#postcopyrightmessages').text('');
										$('#postcopyrightmessages').addClass('ui-state-error');
										$('#postcopyrightmessages').text(responseText.message);
									}
									
								},								
								url:       copyrighturl,         // override for form's 'action' attribute 
								type:      copyrighttype,        // 'get' or 'post', override for form's 'method' attribute 
								dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
							}
							$('#footerform').ajaxSubmit(copyrighttextoptions); 
					 
							// !!! Important !!! 
							// always return false to prevent standard browser submit and page navigation 
							return false; 
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