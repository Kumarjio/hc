function fnEditProject(projid)
{	
	var strContratName = $.trim($('#proj_contract_name_data_'+projid).text());
	var strContratCName = $.trim($('#proj_cname_data_'+projid).text());
	var strContratCJTitle = $.trim($('#proj_jtitle_data_'+projid).text());
	var strContratDuration = $.trim($('#proj_years_data_'+projid).text());
	var strContratDurationMonths = $.trim($('#proj_months_data_'+projid).text());
	var strContratAccmp = $.trim($('#proj_accom_data_'+projid).text());
	
	$('#t_contractor_name').val(strContratName);
	$('#t_company_name').val(strContratCName);
	$('#t_company_job_title').val(strContratCJTitle);
	$('#t_company_job_duration').val(strContratDuration);
	$('#t_company_job_duration_M').val(strContratDurationMonths);
	$('#t_company_job_accomplishments').val(strContratAccmp);
	$('#contractor_edit_mode_id').val(projid);
	
	
	$( "#projectsadd" ).dialog("open");		
	$('.ui-button-text:contains(Add)').text('Update');
	$('#projectsadd').dialog('option','title',"Project / Contract Updation");
}

function fnDeleteProject(projid)
{
	
	var intCvId = $('#id').val();
	var url = strGlobalDocRootUrl+"delete_proj.php?portid="+strGlobalCurrentPortalId;
	var type = "POST";
	var datastr = "cvid="+intCvId+"&projdeletemodeid="+projid;
	var intTotatlComptCurrentRows = $('#total_proj_rows').val();
	
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
						$('#proj_no_row').fadeIn('slow');
					}
					else
					{
						$('#proj_no_row').fadeOut('slow');
					}
					
					$('#proj_counter_'+projid).remove();
					$('#proj_data_container_'+projid).remove();
					$('#proj_action_'+projid).remove();
					
					intTotatlComptCurrentRows--;
					$('#total_proj_rows').val(intTotatlComptCurrentRows);
					
					$('#projects_operation_message_success').text('');
					$('#projects_operation_message_success').removeClass('ui-state-error');
					$('#projects_operation_message_success').addClass('ui-state-success');
					$('#projects_operation_message_success').text(responseText.message);
					$('#projects_operation_message_success').fadeIn('slow');
				}
				else
				{
					//$('#logoloader').hide();
					
					$('#projects_operation_message_success').text('');
					$('#projects_operation_message_success').removeClass('ui-state-success');
					$('#projects_operation_message_success').addClass('ui-state-error');
					$('#projects_operation_message_success').text(responseText.message);
					$('#projects_operation_message_success').fadeIn('slow');
					
				}
			}
	});
}

$(document).ready(function() {
	$('#addprojectreq').click(function() {
		$( "#projectsadd" ).dialog( "open" );
		$('.ui-button-text:contains(Update)').text('Add');
		$('#projectsadd').dialog('option','title',"Add Projects / Contract Details");
	});
	
	
	$( "#projectsadd" ).dialog({
			autoOpen: false,
			height: 600,
			width: 500,
			modal: true,
			open: function( event, ui ) {
				$("#cv_contracts_form").validationEngine();
			},
			buttons: {
				"Add": function() {
							//$('#logoloader').show();
							var strContractorName = $('#t_contractor_name').val();
							var strCompanyName = $('#t_company_name').val();
							var strCompmayJtitle = $('#t_company_job_title').val();
							var strCompmayDuration = $('#t_company_job_duration').val();
							var strCompmayDurationM = $('#t_company_job_duration_M').val();
							var strCompmayAccmplishments = $('#t_company_job_accomplishments').val();
							var intCvId = $('#id').val();
							var intProjEditModeId = $('#contractor_edit_mode_id').val();
							var intTotatlProjCurrentRows = $('#total_proj_rows').val();
							
							var isValidated = jQuery('#cv_contracts_form').validationEngine('validate');
							if(isValidated == false)
							{
								return false;
							}
							else
							{
								var url = strGlobalDocRootUrl+"add_proj.php?portid="+strGlobalCurrentPortalId;
								var type = "POST";
								var datastr = "contractorname="+strContractorName+"&projcname="+strCompanyName+"&projctitle="+strCompmayJtitle+"&projduration="+strCompmayDuration+"&projdurationm="+strCompmayDurationM+"&projaccmp="+strCompmayAccmplishments+"&cvid="+intCvId+"&projeditmodeid="+intProjEditModeId;
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
													
													if(intProjEditModeId != "")
													{
														$('#proj_contract_name_data_'+intProjEditModeId).text(strContractorName);
														$('#proj_cname_data_'+intProjEditModeId).text(strCompanyName);
														$('#proj_jtitle_data_'+intProjEditModeId).text(strCompmayJtitle);
														$('#proj_years_data_'+intProjEditModeId).text(strCompmayDuration);
														$('#proj_months_data_'+intProjEditModeId).text(strCompmayDurationM);
														$('#proj_accom_data_'+intProjEditModeId).html(responseText.accformattedcontent);
													}
													else
													{
														intTotatlProjCurrentRows++; 
														var strPreHtml = "<div id='proj_counter_"+responseText.createdid+"' style='float:left;width:4%;margin-right:2%;clear:both;margin-top:10px;'>"+intTotatlProjCurrentRows+"</div>";
														var strCompleteHtml = strPreHtml+responseText.printhtml;
														
														$('#projcontainer').append(strCompleteHtml);
														$('#total_proj_rows').val(intTotatlProjCurrentRows);
													}
													
													$('#projects_operation_message_success').text('');
													$('#projects_operation_message_success').removeClass('ui-state-error');
													$('#projects_operation_message_success').addClass('ui-state-success');
													$('#projects_operation_message_success').text(responseText.message);
													$('#projects_operation_message_success').fadeIn('slow');
													$('#proj_no_row').fadeOut('slow');
													
													
													$('#t_contractor_name').val('');
													$('#t_company_name').val('');
													$('#t_company_job_title').val('');
													$('#t_company_job_duration').val('');
													$('#t_company_job_duration_M').val('');
													$('#t_company_job_accomplishments').val('');
													$('#contractor_edit_mode_id').val('');
													
													$( "#projectsadd" ).dialog( "close" );
													
												}
												else
												{
													//$('#logoloader').hide();
													
													$('#projects_operation_message_fail').text('');
													$('#projects_operation_message_fail').removeClass('ui-state-success');
													$('#projects_operation_message_fail').addClass('ui-state-error');
													$('#projects_operation_message_fail').text(responseText.message);
													$('#projects_operation_message_fail').fadeIn('slow');
													
												}
											}
									}); 
								return false;
							} 
				},
				Cancel: function() {
					$('#t_contractor_name').val('');
					$('#t_company_name').val('');
					$('#t_company_job_title').val('');
					$('#t_company_job_duration').val('');
					$('#t_company_job_duration_M').val('');
					$('#t_company_job_accomplishments').val('');
					$('#contractor_edit_mode_id').val('');
					$(this).dialog( "close" );
				}
			},
			close: function() {
				
			}
		});
});