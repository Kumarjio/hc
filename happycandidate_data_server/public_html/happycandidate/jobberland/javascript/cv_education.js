function fnEditEducation(eduid)
{	
	var strEducation = $.trim($('#edu_quali_data_'+eduid).text());
	var strUniversity = $.trim($('#edu_school_data_'+eduid).text());
	var strLocation = $.trim($('#edu_location_data_'+eduid).text());
	var strContinueEdu = $.trim($('#edu_continue_data_'+eduid).text());

	$('#cand_degree').val(strEducation);
	$('#cand_school_uni_name').val(strUniversity);
	$('#cand_education_location').val(strLocation);
	$('#cand_edu_classes').val(strContinueEdu);
	$('#education_edit_mode_id').val(eduid);
	
	
	$( "#educationadd" ).dialog( "open" );		
	$('.ui-button-text:contains(Add)').text('Update');
	$('#educationadd').dialog('option','title',"Update Education");
}

function fnDeleteEducation(eduid)
{
	
	var intCvId = $('#id').val();
	var url = strGlobalDocRootUrl+"delete_education.php?portid="+strGlobalCurrentPortalId;
	var type = "POST";
	var datastr = "cvid="+intCvId+"&edudeletemodeid="+eduid;
	var intTotatlComptCurrentRows = $('#total_edu_rows').val();
	
	$.ajax({ 
			type: type,
			url: url,
			dataType: 'json',
			data:datastr,
			success: function(responseText)
			{
				//alert(data.status);
				if(responseText.status == "success")
				{
					//$('#logoloader').hide();
					if(responseText.remining == "0")
					{
						$('#edu_no_row').fadeIn('slow');
					}
					else
					{
						$('#edu_no_row').fadeOut('slow');
					}
					
					$('#counter_'+eduid).remove();
					$('#education_data_container_'+eduid).remove();
					$('#action_'+eduid).remove();
					
					intTotatlComptCurrentRows--;
					$('#total_edu_rows').val(intTotatlComptCurrentRows);
					
					$('#education_operation_message_success').text('');
					$('#education_operation_message_success').removeClass('ui-state-error');
					$('#education_operation_message_success').addClass('ui-state-success');
					$('#education_operation_message_success').text(responseText.message);
					$('#education_operation_message_success').fadeIn('slow');
				}
				else
				{
					//$('#logoloader').hide();
					
					$('#education_operation_message_success').text('');
					$('#education_operation_message_success').removeClass('ui-state-success');
					$('#education_operation_message_success').addClass('ui-state-error');
					$('#education_operation_message_success').text(responseText.message);
					$('#education_operation_message_success').fadeIn('slow');
					
				}
			}
	});
}

$(document).ready(function() {
	$( "#educationadd" ).dialog({
			autoOpen: false,
			height: 450,
			width: 400,
			modal: true,
			open: function( event, ui ) {
				$("#cv_education").validationEngine();
			},
			buttons: {
				"Add": function() {
							//$('#logoloader').show();
							var strEducation = $('#cand_degree').val();
							var strUniversity = $('#cand_school_uni_name').val();
							var strLocation = $('#cand_education_location').val();
							var strContinueEdu = $('#cand_edu_classes').val();
							var intCvId = $('#id').val();
							var intEduEditModeId = $('#education_edit_mode_id').val();
							var intTotatlEduCurrentRows = $('#total_edu_rows').val();
							var isValidated = jQuery('#cv_education').validationEngine('validate');
							if(isValidated == false)
							{
								return false;
							}
							else
							{
								var url = strGlobalDocRootUrl+"add_education.php?portid="+strGlobalCurrentPortalId;
								var type = "POST";
								var datastr = "eduname="+strEducation+"&eduuni="+strUniversity+"&edulocation="+strLocation+"&educontinue="+strContinueEdu+"&cvid="+intCvId+"&edueditmodeid="+intEduEditModeId;
								$.ajax({ 
											type: type,
											url: url,
											dataType: 'json',
											data:datastr,
											success: function(responseText)
											{
												//alert(data.status);
												if(responseText.status == "success")
												{
													//$('#logoloader').hide();
													//$(this).dialog( "close" );
													
													if(intEduEditModeId != "")
													{
														$('#edu_quali_data_'+intEduEditModeId).text(strEducation);
														$('#edu_school_data_'+intEduEditModeId).text(strUniversity);
														$('#edu_location_data_'+intEduEditModeId).text(strLocation);
														$('#edu_continue_data_'+intEduEditModeId).text(strContinueEdu);
													}
													else
													{
														intTotatlEduCurrentRows++; 
														var strPreHtml = "<div id='counter_"+responseText.createdid+"' style='float:left;width:8%;margin-right:2%;clear:both;margin-top:10px;'>"+intTotatlEduCurrentRows+"</div>";
														var strCompleteHtml = strPreHtml+responseText.printhtml;
														
														$('#educontainer').append(strCompleteHtml);
														$('#total_edu_rows').val(intTotatlEduCurrentRows);
													}
													
													$('#education_operation_message_success').text('');
													$('#education_operation_message_success').removeClass('ui-state-error');
													$('#education_operation_message_success').addClass('ui-state-success');
													$('#education_operation_message_success').text(responseText.message);
													$('#education_operation_message_success').fadeIn('slow');
													$('#edu_no_row').fadeOut('slow');
													
													
													$('#cand_degree').val('');
													$('#cand_school_uni_name').val('');
													$('#cand_education_location').val('');
													$('#cand_edu_classes').val('');
													$('#education_edit_mode_id').val('');
													
													$( "#educationadd" ).dialog( "close" );
													
												}
												else
												{
													//$('#logoloader').hide();
													
													$('#education_operation_message_fail').text('');
													$('#education_operation_message_fail').removeClass('ui-state-success');
													$('#education_operation_message_fail').addClass('ui-state-error');
													$('#education_operation_message_fail').text(responseText.message);
													$('#education_operation_message_fail').fadeIn('slow');
													
												}
											}
									}); 
								return false; 
							}
				},
				Cancel: function() {
					$('#cand_degree').val('');
					$('#cand_school_uni_name').val('');
					$('#cand_education_location').val('');
					$('#cand_edu_classes').val('');
					$(this).dialog( "close" );
				}
			},
			close: function() {
				
			}
		});
});