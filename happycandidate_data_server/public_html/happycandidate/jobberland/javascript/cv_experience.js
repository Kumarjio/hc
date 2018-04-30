function fnAddPositionFields()
{
	var intCurrPositionsCounter = $('#exp_position_field_counter').val();
	intCurrPositionsCounter = (parseInt(intCurrPositionsCounter)+ 1);
	var strPositionFieldCounter = '<div id="position_data_block_'+intCurrPositionsCounter+'"><input placeholder="Add Position Title" type="text" value="" name="exp_position_title_'+intCurrPositionsCounter+'" id="exp_position_title_'+intCurrPositionsCounter+'" /><input placeholder="Promotion Date" type="text" value="" name="exp_position_promotion_date_'+intCurrPositionsCounter+'" id="exp_position_promotion_date_'+intCurrPositionsCounter+'" /></div>';
	$('#exp_positions').append(strPositionFieldCounter);
	$('#exp_position_field_counter').val(intCurrPositionsCounter);
	$("#exp_position_promotion_date_"+intCurrPositionsCounter).datepicker({ 
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
            changeYear: true
	});
}

function fnRemovePositionFields()
{
	var intCurrPositionsCounter = $('#exp_position_field_counter').val();
	var intCurrPositionsEditMode = $('#exp_position_field_edit_id').val();

	if(intCurrPositionsEditMode != "")
	{
		if(intCurrPositionsCounter == "0")
		{
			return false;
		}
		else
		{
			//alert(intCurrPositionsCounter);
			var exp_edit_mode = $('#experience_edit_mode_id').val();
			var intDeleteIds = intCurrPositionsEditMode;
			var arrIds = intDeleteIds.split("|");
			var exp_position_id = arrIds[(arrIds.length-2)];
			var datastr = "positiondelid="+arrIds[(arrIds.length-2)];
			var url = strGlobalDocRootUrl+"delete_experience.php?action=delpos&portid="+strGlobalCurrentPortalId;
			var strResponse = false;
			$.ajax({ 
					type: 'POST',
					url: url,
					dataType: 'json',
					data:datastr,
					success: function(responseText)
					{
						//alert(data.status);
						if(responseText.status == "success")
						{
							//$('#logoloader').hide();
							var strToBeRemovedId = 'position_data_block_'+intCurrPositionsCounter;
							intCurrPositionsCounter = (parseInt(intCurrPositionsCounter)-1);
							if(intCurrPositionsCounter == 0)
							{
								$('#exp_position_field_counter').val(1);
								$('#exp_position_title_1').val('');
								$('#exp_position_promotion_date_1').val('');
							}
							else
							{
								$('#'+strToBeRemovedId).remove();
								$('#exp_position_field_counter').val(intCurrPositionsCounter);
							}
							var strNewPositionIdCombination = "";
							for(var i=0;i<=arrIds.length-3;i++)
							{
								if(arrIds[i])
								{
									strNewPositionIdCombination = strNewPositionIdCombination+arrIds[i]+"|";
								}
							}
							$('#exp_position_field_edit_id').val(strNewPositionIdCombination);
							$('#position_ids_'+exp_edit_mode).html(strNewPositionIdCombination);
							$('#exp_position_title_'+exp_edit_mode+'_'+exp_position_id).remove();
							$('#exp_position_promotiondate_'+exp_edit_mode+'_'+exp_position_id).remove();
							
							
						}
						else
						{
							//$('#logoloader').hide();
							strResponse = "0";
						}
					}
			});
		}
	}
	else
	{
		if(intCurrPositionsCounter == "1")
		{
			return false;
		}
		else
		{
			var strToBeRemovedId = 'position_data_block_'+intCurrPositionsCounter;
			intCurrPositionsCounter = (parseInt(intCurrPositionsCounter)-1);
			$('#'+strToBeRemovedId).remove();
			$('#exp_position_field_counter').val(intCurrPositionsCounter);
		}
	}
}

function fnDeletePosition(intDeletePositionId)
{
	if(intDeletePositionId != "")
	{
		var datastr = "positiondelid="+intDeletePositionId;
		var url = strGlobalDocRootUrl+"delete_experience.php?action=delpos&portid="+strGlobalCurrentPortalId;
		var strResponse = false;
		$.ajax({ 
				type: 'POST',
				url: url,
				dataType: 'json',
				data:datastr,
				success: function(responseText)
				{
					//alert(data.status);
					if(responseText.status == "success")
					{
						//$('#logoloader').hide();
						strResponse = "1";
						
					}
					else
					{
						//$('#logoloader').hide();
						strResponse = "0";
					}
				},
				complete: function(responseText)
				{
					return strResponse;
				}
		});
	}
	else
	{
		return false;
	}
}

function fnGeneraEditHtml(counter,position_id,expid)
{
	var strEditFormPositionHtml = "";
	var strEditFormPositionDateHtml = "";
	var strEditPositionTitle = $.trim($('#exp_position_title_'+expid+'_'+position_id).text());
	var strPosPromotionDate = $.trim($('#exp_position_mask_id_'+expid+'_'+position_id).text());
	
	strEditFormPositionHtml += '<input placeholder="Add Position Title" type="text" value="'+strEditPositionTitle+'" name="exp_position_title_'+counter+'" id="exp_position_title_'+counter+'" />';
	strEditFormPositionDateHtml += '<input placeholder="Promotion Date" type="text" value="'+strPosPromotionDate+'" name="exp_position_promotion_date_'+counter+'" id="exp_position_promotion_date_'+counter+'" />';
	
	return strPositionFieldHTML = '<div id="position_data_block_'+counter+'">'+strEditFormPositionHtml+strEditFormPositionDateHtml+'</div>';
}

function fnEditExperience(expid)
{	
	var strExpType = $.trim($('#exp_type_data_'+expid).text());
	var strExpCName = $.trim($('#exp_company_name_data_'+expid).text());
	var strExpCLocation = $.trim($('#exp_company_location_data_'+expid).text());
	var strExpCJtitle = $.trim($('#exp_company_jtitle_data_'+expid).text());
	var strExpCResp = $.trim($('#exp_company_resp_data_'+expid).text());
	var strExpCAccmp = $.trim($('#exp_company_accmp_data_'+expid).text());
	//var strCurrentCounterVal = $('#exp_position_field_counter').val();
	fnDeletePositionFields($('#exp_position_field_counter').val());
	
	
	var strPositionIds = $.trim($('#position_ids_'+expid).text());
	var arrPositionIds = strPositionIds.split("|");
	var intFieldCnt = 1;
	for(var i=0;i<arrPositionIds.length;i++)
	{
		if(arrPositionIds[i] != "")
		{
			var j = i+1;
			intFieldCnt++;
			$('#position_data_block_'+j).remove();
			strEditPositionHtm = fnGeneraEditHtml(j,arrPositionIds[i],expid);
			$('#exp_positions').append(strEditPositionHtm);
			$("#exp_position_promotion_date_"+j).datepicker({ 
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
					changeYear: true
			});
		}
	}

	
	$('#exp').val(strExpType);
	$('#company_name').val(strExpCName);
	$('#company_location').val(strExpCLocation);
	$('#company_job_title').val(strExpCJtitle);
	$('#company_duties_respponsibilities').val(strExpCResp);
	$('#company_accomplishments').val(strExpCAccmp);
	$('#experience_edit_mode_id').val(expid);
	
	if(arrPositionIds.length-1 == 0)
	{
		$('#exp_position_field_counter').val(1);
	}
	else
	{
		$('#exp_position_field_counter').val(arrPositionIds.length-1);
	}
	
	$('#exp_position_field_edit_id').val(strPositionIds);
	$( "#experienceadd" ).dialog( "open" );		
	$('.ui-button-text:contains(Add)').text('Update');
	$('#experienceadd').dialog('option','title',"Update Experience");
}

function fnDeleteExperience(expid)
{
	
	var intCvId = $('#id').val();
	var url = strGlobalDocRootUrl+"delete_experience.php?portid="+strGlobalCurrentPortalId;
	var type = "POST";
	var datastr = "cvid="+intCvId+"&expdeletemodeid="+expid;
	var intTotatlComptCurrentRows = $('#total_experience_rows').val();
	
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
						$('#exp_no_row').fadeIn('slow');
					}
					else
					{
						$('#exp_no_row').fadeOut('slow');
					}
					
					$('#exp_counter_'+expid).remove();
					$('#experience_data_container_'+expid).remove();
					$('#exp_action_'+expid).remove();
					
					intTotatlComptCurrentRows--;
					$('#total_experience_rows').val(intTotatlComptCurrentRows);
					
					$('#experience_operation_message_success').text('');
					$('#experience_operation_message_success').removeClass('ui-state-error');
					$('#experience_operation_message_success').addClass('ui-state-success');
					$('#experience_operation_message_success').text(responseText.message);
					$('#experience_operation_message_success').fadeIn('slow');
				}
				else
				{
					//$('#logoloader').hide();
					
					$('#experience_operation_message_success').text('');
					$('#experience_operation_message_success').removeClass('ui-state-success');
					$('#experience_operation_message_success').addClass('ui-state-error');
					$('#experience_operation_message_success').text(responseText.message);
					$('#experience_operation_message_success').fadeIn('slow');
					
				}
			}
	});
}

$(document).ready(function() {
	$("#exp_position_promotion_date_1").datepicker({ 
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
            changeYear: true
	});
	
	$('#addexperiencereq').click(function() {
		$( "#experienceadd" ).dialog( "open" );
		$('.ui-button-text:contains(Update)').text('Add');
		$('#experienceadd').dialog('option','title',"Add Experience");
	});
	
	
	$( "#experienceadd" ).dialog({
			autoOpen: false,
			height: 600,
			width: 500,
			modal: true,
			open: function( event, ui ) {
				$("#cv_experience_form").validationEngine();
			},
			buttons: {
				"Add": function() {
							//$('#logoloader').show();
							var strExperienceType = $('#exp').val();
							var strExpCompanyName = $('#company_name').val();
							var strExpCompanyLocation = $('#company_location').val();
							var strExpCompanyJobTitle = $('#company_job_title').val();
							var strExpCompanyResp = $('#company_duties_respponsibilities').val();
							var strExpCompanyAccomplishments = $('#company_accomplishments').val();
							var intCvId = $('#id').val();
							var intExpEditModeId = $('#experience_edit_mode_id').val();
							var intTotatlExpCurrentRows = $('#total_experience_rows').val();
							var intExpPositionRowCounter = $('#exp_position_field_counter').val();
							var intExpPositionTitle = $('#exp_position_title_1').val();
							var intExpPositionPromotionDate = $('#exp_position_promotion_date_1').val();
							var intExpPositionEditIds = $('#exp_position_field_edit_id').val();
							
							var isValidated = jQuery('#cv_experience_form').validationEngine('validate');
							if(isValidated == false)
							{
								return false;
							}
							else
							{
								var strExpPositionDataStr = "";
								if(intExpPositionRowCounter == 1)
								{
									strExpPositionDataStr = "&exppostit1="+intExpPositionTitle+"&exppospromodte1="+intExpPositionPromotionDate+"&posdatacounter="+intExpPositionRowCounter+"&editpositionids="+intExpPositionEditIds;
								}
								else
								{
									for(var i=1;i<=parseInt(intExpPositionRowCounter);i++)
									{
										var intExpPositionTitle = $('#exp_position_title_'+i).val();
										var intExpPositionPromotionDate = $('#exp_position_promotion_date_'+i).val();
										
										strExpPositionDataStr += "&exppostit"+i+"="+intExpPositionTitle+"&exppospromodte"+i+"="+intExpPositionPromotionDate;
									}
									strExpPositionDataStr += "&posdatacounter="+intExpPositionRowCounter+"&editpositionids="+intExpPositionEditIds;
								}
								var url = strGlobalDocRootUrl+"add_experience.php?portid="+strGlobalCurrentPortalId;
								var type = "POST";
								var datastr = "exptype="+strExperienceType+"&expcname="+strExpCompanyName+"&expclocation="+strExpCompanyLocation+"&expcompjtitle="+strExpCompanyJobTitle+"&expcompresp="+strExpCompanyResp+"&expcompaccomp="+strExpCompanyAccomplishments+"&cvid="+intCvId+"&expeditmodeid="+intExpEditModeId+strExpPositionDataStr;
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
													
													if(intExpEditModeId != "")
													{
														$('#exp_type_data_'+intExpEditModeId).text(strExperienceType);
														$('#exp_company_name_data_'+intExpEditModeId).text(strExpCompanyName);
														$('#exp_company_location_data_'+intExpEditModeId).text(strExpCompanyLocation);
														$('#exp_company_jtitle_data_'+intExpEditModeId).text(strExpCompanyJobTitle);
														$('#exp_company_resp_data_'+intExpEditModeId).text(strExpCompanyResp);
														//$('#exp_company_accmp_data_'+intExpEditModeId).text(strExpCompanyAccomplishments);
														$('#exp_company_accmp_data_'+intExpEditModeId).html('');
														$('#exp_company_accmp_data_'+intExpEditModeId).html(responseText.updatedaccomp);
														
														if(responseText.positionhtml != "")
														{
															$('#exp_company_position_data_'+intExpEditModeId).html();
															$('#exp_company_position_data_'+intExpEditModeId).html(responseText.positionhtml);
														}
														if(responseText.positionids != "")
														{
															$('#position_ids_'+intExpEditModeId).html(responseText.positionids);
														}
													}
													else
													{
														intTotatlExpCurrentRows++; 
														var strPreHtml = "<div id='exp_counter_"+responseText.createdid+"' style='float:left;width:4%;margin-right:2%;clear:both;margin-top:10px;'>"+intTotatlExpCurrentRows+"</div>";
														var strCompleteHtml = strPreHtml+responseText.printhtml;
														
														$('#expcontainer').append(strCompleteHtml);
														$('#total_experience_rows').val(intTotatlExpCurrentRows);
														if(responseText.positionids != "")
														{
															$('#position_ids_'+intExpEditModeId).html(responseText.positionids);
														}
													}
													
													$('#experience_operation_message_success').text('');
													$('#experience_operation_message_success').removeClass('ui-state-error');
													$('#experience_operation_message_success').addClass('ui-state-success');
													$('#experience_operation_message_success').text(responseText.message);
													$('#experience_operation_message_success').fadeIn('slow');
													$('#exp_no_row').fadeOut('slow');
													
													
													
													
													$('#exp').val('');
													$('#company_name').val('');
													$('#company_location').val('');
													$('#company_job_title').val('');
													$('#company_duties_respponsibilities').val('');
													$('#company_accomplishments').val('');
													$('#experience_edit_mode_id').val('');
													
													$( "#experienceadd" ).dialog( "close" );
													
												}
												else
												{
													//$('#logoloader').hide();
													
													if(responseText.positionhtml != "")
													{
														$('#exp_company_position_data_'+intExpEditModeId).html();
														$('#exp_company_position_data_'+intExpEditModeId).html(responseText.positionhtml);
													}
													
													if(responseText.positionids != "")
													{
														$('#position_ids_'+intExpEditModeId).html(responseText.positionids);
													}
													
													
													$('#experience_operation_message_fail').text('');
													$('#experience_operation_message_fail').removeClass('ui-state-success');
													$('#experience_operation_message_fail').addClass('ui-state-error');
													$('#experience_operation_message_fail').text(responseText.message);
													$('#experience_operation_message_fail').fadeIn('slow');
													
													// remove position fields
													fnDeletePositionFields($('#exp_position_field_counter').val());
													
												}
											}
									}); 
								return false; 
							}
				},
				Cancel: function() {
					$('#exp').val('');
					$('#company_name').val('');
					$('#company_location').val('');
					$('#company_job_title').val('');
					$('#company_duties_respponsibilities').val('');
					$('#company_accomplishments').val('');
					$('#experience_edit_mode_id').val('');
					
					// remove position fields
					fnDeletePositionFields($('#exp_position_field_counter').val());
					
					$(this).dialog( "close" );
				}
			},
			close: function() {
				
			}
		});
});

function fnDeletePositionFields(intFieldTotalCount)
{
	if(intFieldTotalCount == "1")
	{
		$('#exp_position_title_1').val('');
		$('#exp_position_promotion_date_1').val('');
		return false;
	}
	else
	{
		for(var i=intFieldTotalCount; i>=1; i--)
		{
			if(i == "1")
			{
				$('#exp_position_title_1').val('');
				$('#exp_position_promotion_date_1').val('');
				$('#exp_position_field_counter').val(i);
			}
			else
			{
				$('#position_data_block_'+i).remove();
				$('#exp_position_field_counter').val(i);
			}
		}
	}
}