{literal}
<script>
	var strGlobalCurrentPortalId = '{/literal}{$intPortId}{literal}';
</script>
<script type="text/javascript" src="{/literal}{$DOC_ROOT}{literal}javascript/cv_status.js"></script>
<script type="text/javascript" src="{/literal}{$DOC_ROOT}{literal}javascript/cv_personal.js"></script>
<script type="text/javascript" src="{/literal}{$DOC_ROOT}{literal}javascript/cv_summary.js"></script>
<script type="text/javascript" src="{/literal}{$DOC_ROOT}{literal}javascript/cv_skills.js"></script>
<script type="text/javascript" src="{/literal}{$DOC_ROOT}{literal}javascript/cv_awards.js"></script>
<script type="text/javascript" src="{/literal}{$DOC_ROOT}{literal}javascript/cv_education.js"></script>
<script type="text/javascript" src="{/literal}{$DOC_ROOT}{literal}javascript/cv_experience.js"></script>
<script type="text/javascript" src="{/literal}{$DOC_ROOT}{literal}javascript/proj_contract.js"></script>
<script>
	$(document).ready(function() {
		
		$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
		
		$('#exe_sum').click(function() {
			if($(this).attr('checked') == true);
			{
				$('#text_qual').attr('name','text_exe_qual')
			}
		});
		
		$('#qal_sum').click(function() {
			if($(this).attr('checked') == true);
			{
				$('#text_qual').attr('name','text_sum_qual')
			}
		});
		
		$('#addcompetanciesreq').click(function() {
			$( "#competanciesadd" ).dialog( "open" );
			$('.ui-button-text:contains(Update)').text('Add');
			$('#competanciesadd').dialog('option','title',"Add Competencies");
		});
		
		$('#addeducationreq').click(function() {
			$( "#educationadd" ).dialog( "open" );
			$('.ui-button-text:contains(Update)').text('Add');
			$('#educationadd').dialog('option','title',"Add Education");
		});
		
		$("#compt_from_date").datepicker({ 
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
            changeYear: true
		});
		
		$("#compt_to_date").datepicker({ 
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
            changeYear: true
		});
		
		$( "#competanciesadd" ).dialog({
			autoOpen: false,
			height: 450,
			width: 400,
			modal: true,
			open: function( event, ui ) {
				$("#cv_core_competancies").validationEngine();
			},
			buttons: {
				"Add": function() {
							//$('#logoloader').show();
							var strSkillName = $('#txt_skill').val();
							var strSkillExpYear = $('#expyears').val();
							var strSkillExpMonth = $('#expmonths').val();
							var strSkillFromDate = $('#compt_from_date').val();
							var strSkillToDate = $('#compt_to_date').val();
							var intSkillCvId = $('#id').val();
							var intSkillEditModeId = $('#competancies_edit_mode_id').val();
							var intTotatlComptCurrentRows = $('#total_compt_rows').val();
							var isValidated = jQuery('#cv_core_competancies').validationEngine('validate');
							if(isValidated == false)
							{
								return false;
							}
							else
							{
								var url = "{/literal}{$DOC_ROOT}{literal}add_competancies.php?portid={/literal}{$intPortId}{literal}";
								var type = "POST";
								var datastr = "skilname="+strSkillName+"&skillexpyear="+strSkillExpYear+"&skillexpmonth="+strSkillExpMonth+"&skillexpfrmdate="+strSkillFromDate+"&skillexptodate="+strSkillToDate+"&cvid="+intSkillCvId+"&compteditmodeid="+intSkillEditModeId;
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
													
													if(intSkillEditModeId != "")
													{
														$('#compt_skill_'+intSkillEditModeId).text(strSkillName);
														$('#compt_skill_year_'+intSkillEditModeId).text(strSkillExpYear);
														$('#compt_skill_month_'+intSkillEditModeId).text(strSkillExpMonth);
														$('#frm_date_other_format_'+intSkillEditModeId).text(strSkillFromDate);
														$('#to_date_other_format_'+intSkillEditModeId).text(strSkillToDate);
														var strFrmDateHtml = responseText.skillfrmdate+"<span id='frm_date_other_format_"+intSkillEditModeId+"' style='display:none;'>"+strSkillFromDate+"</span>";
														$('#compt_skill_frm_date_'+intSkillEditModeId).html(strFrmDateHtml);
														var strToDateHtml = responseText.skilltodate+"<span id='to_date_other_format_"+intSkillEditModeId+"' style='display:none;'>"+strSkillToDate+"</span>";
														$('#compt_skil_to_date_'+intSkillEditModeId).html(strToDateHtml);
													}
													else
													{
														intTotatlComptCurrentRows++; 
														$strNewSkillHtml = "<tr id='compt_row_"+responseText.createdid+"'><td align='center'>"+intTotatlComptCurrentRows+"</td><td align='center'>&nbsp;</td><td id='compt_skill_"+responseText.createdid+"' align='center'>"+strSkillName+"</td><td id='compt_skill_year_"+responseText.createdid+"' align='center'>"+strSkillExpYear+"</td><td id='compt_skill_month_"+responseText.createdid+"' align='center'>"+strSkillExpMonth+"</td><td id='compt_skill_frm_date_"+responseText.createdid+"' align='center'>"+responseText.skillfrmdate+"<span id='frm_date_other_format_"+responseText.createdid+"' style='display:none;'>"+strSkillFromDate+"</span></td><td id='compt_skil_to_date_"+responseText.createdid+"' align='center'>"+responseText.skilltodate+"<span id='to_date_other_format_"+responseText.createdid+"' style='display:none;'>"+strSkillToDate+"</span></td><td align='center'>&nbsp;</td><td align='center'><a onclick=fnEditCompetancies('"+responseText.createdid+"') href='javascript:void(0);'>Edit</a>&nbsp;&nbsp;&nbsp;<a onclick=fnDeleteCompetancies('"+responseText.createdid+"') href='javascript:void(0);'>Delete</a></td></tr>";
														$('#competancies_rows').append($strNewSkillHtml);
														$('#total_compt_rows').val(intTotatlComptCurrentRows);
													}
													
													$('#competancies_operation_message_success').text('');
													$('#competancies_operation_message_success').removeClass('ui-state-error');
													$('#competancies_operation_message_success').addClass('ui-state-success');
													$('#competancies_operation_message_success').text(responseText.message);
													$('#competancies_operation_message_success').fadeIn('slow');
													$('#no_competancies_row').fadeOut('slow');
													
													
													$('#txt_skill').val('');
													$('#expyears').val('');
													$('#expmonths').val('');
													$('#compt_from_date').val('');
													$('#compt_to_date').val('');
													$('#competancies_edit_mode_id').val('');
													
													$( "#competanciesadd" ).dialog( "close" );
													
												}
												else
												{
													//$('#logoloader').hide();
													
													$('#competancies_operation_message_fail').text('');
													$('#competancies_operation_message_fail').removeClass('ui-state-success');
													$('#competancies_operation_message_fail').addClass('ui-state-error');
													$('#competancies_operation_message_fail').text(responseText.message);
													$('#competancies_operation_message_fail').fadeIn('slow');
													
												}
											}
									}); 
								return false; 
							}
				},
				Cancel: function() {
					$('#txt_skill').val('');
					$('#expyears').val('');
					$('#expmonths').val('');
					$('#compt_from_date').val('');
					$('#compt_to_date').val('');
					$(this).dialog( "close" );
				}
			},
			close: function() {
				
			}
		});
	});
	
	function fnEditCompetancies(comptid)
	{
		//alert(comptid);
		var strSkillName = $('#compt_skill_'+comptid).text();
		var strSkillExpYear = $('#compt_skill_year_'+comptid).text();
		var strSkillExpMonth = $('#compt_skill_month_'+comptid).text();
		var strSkillFromDate = $('#frm_date_other_format_'+comptid).text();
		var strSkillToDate = $('#to_date_other_format_'+comptid).text();
		
		$('#txt_skill').val(strSkillName);
		$('#expyears').val(strSkillExpYear);
		$('#expmonths').val(strSkillExpMonth);
		$('#compt_from_date').val(strSkillFromDate);
		$('#compt_to_date').val(strSkillToDate);
		$('#competancies_edit_mode_id').val(comptid);
		
		
		$( "#competanciesadd" ).dialog( "open" );		
		$('.ui-button-text:contains(Add)').text('Update');
		$('#competanciesadd').dialog('option','title',"Update Competencies");
	}
	
	function fnDeleteCompetancies(comptid)
	{
		var intSkillCvId = $('#id').val();
		var url = "{/literal}{$DOC_ROOT}{literal}delete_competancies.php?portid={/literal}{$intPortId}{literal}";
		var type = "POST";
		var datastr = "cvid="+intSkillCvId+"&comptdeletemodeid="+comptid;
		var intTotatlComptCurrentRows = $('#total_compt_rows').val();
		
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
							$('#no_competancies_row').fadeIn('slow');
						}
						else
						{
							$('#no_competancies_row').fadeOut('slow');
						}
						
						$('#compt_row_'+comptid).remove();
						intTotatlComptCurrentRows--;
						$('#total_compt_rows').val(intTotatlComptCurrentRows);
						
						$('#competancies_operation_message_success').text('');
						$('#competancies_operation_message_success').removeClass('ui-state-error');
						$('#competancies_operation_message_success').addClass('ui-state-success');
						$('#competancies_operation_message_success').text(responseText.message);
						$('#competancies_operation_message_success').fadeIn('slow');
					}
					else
					{
						//$('#logoloader').hide();
						
						$('#competancies_operation_message_success').text('');
						$('#competancies_operation_message_success').removeClass('ui-state-success');
						$('#competancies_operation_message_success').addClass('ui-state-error');
						$('#competancies_operation_message_success').text(responseText.message);
						$('#competancies_operation_message_success').fadeIn('slow');
						
					}
				}
		});
	}
</script>
{/literal}
<div class="header">{lang mkey='header' skey='cv_visibility'}</div>
<div><p>{lang mkey='cv' skey='cv_r_info'}</p></div>
{if $message != "" } {$message} {/if}
<!--<form action="" method="post">-->
<input type="hidden" name="id" id="id" value="{$id}" />
<p>{lang mkey='required_info_indication'}</p>
<!--<form id="test_form" method="post">
	<input type="text" name="asds" id="sadsa" class="validate[required]" />
</form>-->
<div id="tabs">
	<ul>
		<li><a href="#cv_status">{lang mkey='header' skey='cv_1'}</a></li>
		<li><a href="#personal_information">Personal Information</a></li>
		<li><a href="#summary">Summary</a></li>
		<li><a href="#competancies">Core Competancies</a></li>
		<li><a href="#education">Education</a></li>
		<li><a href="#experience">Experience</a></li>
		<li><a href="#projects">Projects / Contracts</a></li>
		<li><a href="#skills">Skills</a></li>
		<li><a href="#awards">Awards</a></li>
		<!--<li><a href="#tabs-10">Review</a></li>-->
	</ul>
	<div id="cv_status">
		<form id="cv_status_form" method="post">
		<h2><label class="label">{lang mkey='label' skey='cv_0'}</label></h2>
		<p id="cv_status_message_success" style="display:none;float:left;width:100%;"></p>
		<br />
		{if  $smarty.session.resume.status == "private"}
			{lang mkey='cv' skey='cv_info_1'}
		{else}
			{lang mkey='cv' skey='cv_info_2'}
		{/if}
		<p>
			<input type="radio" id="update_cv_status_public" name="txt_status" {if $smarty.session.resume.status == "public" } checked="checked" {/if} value="public" class="radio" /> {lang mkey='label' skey='public' }
		</p>
		{lang mkey='label' skey='cv_can_view' }
		
		<p>
		<input type="radio" id="update_cv_status_private" name="txt_status" {if $smarty.session.resume.status == "private"} checked="checked"{/if} value="private" class="radio" /> {lang mkey='label' skey='private' }
		<input type="hidden" name="cv_id" id="cv_id" value="{$id}" /> 
		</p>
		{lang mkey='label' skey='cv_cant_view' }
		<p>
			<input type="button" name="update_cv_status" onclick="fnUpdateCVStatus()" id="update_cv_status" value="Update" /> &nbsp;
			<span style="display:none;" id="cvloader"><img alt="loginloader" src="{$DOC_ROOT}images/loader.gif"></span>
		</p>
		</form>
	</div>
	<div id="personal_information">
		<form id="cv_personal_information" method="post">
		<h2>Personal Information</h2>
		<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
		<p id="cv_personal_message_success" style="display:none;float:left;width:100%;"></p>
		<div id="form_container" style="margin-top:10px;">
			<div>First Name:</div>
			<div><input type="text" class="validate[custom[onlyLetterSp]]" name="cand_f_name" id="cand_f_name" value="{$cvformfname}" />
				<input type="hidden" name="cand_personal_update_mode" id="cand_personal_update_mode" value="{$cvformperupdatemode}" />
				<input type="hidden" name="cv_id" id="cv_id" value="{$id}" /> 
			</div>
			
			<div>&nbsp;</div>
			
			<div>Sir Name / Last Name:</div>
			<div><input type="text" class="validate[custom[onlyLetterSp]]" name="cand_l_name" id="cand_l_name" value="{$cvformlname}" /></div>
			
			<div>&nbsp;</div>
			
			<div>Address:</div>
			<div><textarea name="cand_address" id="cand_address" rows="5" cols="30">{$cvformaddress}</textarea></div>
			
			<div>&nbsp;</div>
			<div>Address1:</div>
			<div><textarea name="cand_address1" id="cand_address1" rows="5" cols="30">{$cvformaddress1}</textarea></div>
			
			<div>&nbsp;</div>
			
			<div>Country:</div>
			<div>
				<select name="cand_country" id="cand_country" onchange="javascript: cascadeCountry(this.value,'cand_state');" >
					{html_options options=$country selected=$smarty.session.loc.country}
				</select>
			</div>
			
			<div>&nbsp;</div>
			
			<div>State:</div>
			<div id="stateprovince_auto">
				{if $lang.states|@count > 0}
					<select class="select" id="cand_state" name="cand_state" onchange="javascript: cascadeState(this.value, this.form.cand_country.value,'cand_county');" >
						{html_options options=$lang.states selected=$smarty.session.loc.stateprovince}
					</select>
				{ else }
					<input class="text_field required" name="cand_state" type="text" size="30" maxlength="100" value="{$smarty.session.loc.stateprovince}" />
				{ /if}                
			</div>
			
			<div>&nbsp;</div>
			
			<div>County / District:</div>
			<div id="county_auto">
			  { if $lang.counties|@count > 0}
				<select class="select" name="cand_county" onchange="javascript: cascadeCounty(this.value,this.form.cand_country.value, this.form.cand_state.value,'cand_city');" >
				{html_options options=$lang.counties selected=$smarty.session.loc.countycode}
				</select>
			  { else }
				<input name="cand_county" type="text" size="30" maxlength="100" value="{$smarty.session.loc.countycode}" />
			  { /if}
			</div>
			
			<div>&nbsp;</div>
			
			<div>City / Locality:</div>
			<div id="city_auto">
			  { if $lang.cities|@count > 0}
				<select class="select" name="cand_city" >
				  {html_options options=$lang.cities selected=$smarty.session.loc.citycode}
				</select>
			  { else }
				<input name="cand_city" type="text" size="30" maxlength="100" value="{$smarty.session.loc.citycode}" />
			  { /if}

			</div>
			
			<div>&nbsp;</div>
			
			<div>Zip / Postcode:</div>
			<div>
				<input type="text" class="validate[custom[integer]]" name="cand_post_code" id="cand_post_code" class="" value="{$cvformzipcode}" size="10" />
			</div>
			
			<div>&nbsp;</div>
			
			<div>Telephone Number:</div>
			<div>
				<input type="text" class="validate[custom[integer]]" name="cand_phone_number" id="cand_phone_number" value="{$cvformtelenumber}" size="30" />
			</div>
			
			<div>&nbsp;</div>
			
			<div>Mobile Phone:</div>
			<div>
				<input type="text" class="validate[custom[integer]]" name="cand_mob_phone_number" id="cand_mob_phone_number" value="{$cvformmobnumber}" size="30" />
			</div>
			
			<div>&nbsp;</div>
			
			<div>Email Address:</div>
			<div>
				<input type="text" name="cand_email" class="validate[custom[email]]" id="cand_email" value="{$cvformemail}" size="30" />
			</div>
		</div>
		<p>
			<input type="button" name="update_personal_status" onclick="fnUpdateCVPersonal()" id="update_personal_status" value="Update" /> &nbsp;
			<span style="display:none;" id="cvpersonalloader"><img alt="loginloader" src="{$DOC_ROOT}images/loader.gif"></span>
		</p>
		</form>
	</div>
	<div id="summary">
		<form id="cv_career_summary" method="post">
		<h2>Career Summary</h2>
		<p>This section can be used one of two ways:
			<ul>
				<li>Summary of qualifications</li>
				<li>Executive Summary</li>
			</ul>
			This statement is a keyword rich written elevator speech.  Hiring authorities and automated parsers always read the top of your CV or resume.  Emphasize key selling points, career highlights and strengths in an easy to scan format.
		</p>
		<p id="cv_summary_message_success" style="display:none;float:left;width:100%;"></p>
		<div>
			<input type="hidden" id="summary_edit_mode_id" name="summary_edit_mode_id" value="{$cvformsummaryeditmodeid}" />
			<input type="hidden" name="cv_id" id="cv_id" value="{$id}" /> 
			{if isset($cvformsummarytype)}
				{if $cvformsummarytype eq 'executive_summary'}
					<input type="radio" name="summary_type" id="qal_sum" value="summary_of_qualifications"/>Summary of qualifications &nbsp;
					<input type="radio" name="summary_type" id="exe_sum" value="executive_summary" checked="checked"  />Executive Summary 
				{else}
					<input type="radio" name="summary_type" id="qal_sum" value="summary_of_qualifications" checked="checked" />Summary of qualifications &nbsp;
					<input type="radio" name="summary_type" id="exe_sum" value="executive_summary" />Executive Summary 
				{/if}
			{else}
				<input type="radio" name="summary_type" id="qal_sum" value="summary_of_qualifications"  checked="checked" />Summary of qualifications &nbsp;
				<input type="radio" name="summary_type" id="exe_sum" value="executive_summary" />Executive Summary 
			{/if}
		</div>
		<div>&nbsp;</div>
		<div>Summary Text:</div>
		<div id="sum_desc">
			{if isset($cvformsummarytype)}
				{if $cvformsummarytype eq 'executive_summary'}
					<textarea id="text_qual" name="text_exe_qual" cols="50">{$cvformsummarytxt}</textarea>
				{else}
					<textarea id="text_qual" name="text_sum_qual" cols="50">{$cvformsummarytxt}</textarea>
				{/if}
			{else}
				<textarea id="text_qual" name="text_sum_qual" cols="50">{$cvformsummarytxt}</textarea>
			{/if}
			
		</div>
		<p>If you are not ready to write your Summary of Qualifications or Executive Summary leave this section blank.</p>
		</form>
		<p>
			<input type="button" onclick="fnUpdateCVSummary()" name="update_summary_status" id="update_summary_status" value="Update" />&nbsp;
			<span style="display:none;" id="cvsummaryloader"><img alt="loginloader" src="{$DOC_ROOT}images/loader.gif"></span>
		</p>
	</div>
	<div id="competancies">
		<h2>Core Competancies</h2>
		<p>Many employers use resume database technology to screen resumes for keywords.  In addition to your Summary of Qualifications or Executive Summary, a core competency section on your resume should include pertinent keywords and skill sets.  Without the right keywords, your resume is less likely to be screened in by these automated systems or viewed by a hiring authority.  Use the widest selection of relevant keywords in your core competency section.</p>
		<p style="float:left;width:100%;"><a href="javascript:void(0);" id="addcompetanciesreq">Add Competancies</a></p>
		<div id="competanciesadd" title="Add Competancies" style="display:none;">
			<form id="cv_core_competancies" method="post">
			<p class="validateTips">Please fill in the below fields to add your competancies.</p>
			<p id="competancies_operation_message_fail" style="display:none;"></p>
			<div style="float:left;width:100%;">
				<div style="float:left;width:100%;">
					<div>Skill:</div>
					<div><input type="text" class="validate[required,custom[onlyLetterSp]]" name="txt_skill" id="txt_skill" value="" />
						 <input type="hidden" name="competancies_edit_mode_id" id="competancies_edit_mode_id" value="" />
					</div>
				</div>
				<div style="float:left;width:100%;">
					<div>Experience Year:</div>
					<div>
						{html_options id="expyears" name="expyears" options=$yearsoptions selected=$yearselected class="validate[required]" }
					</div>
				</div>
				<div style="float:left;width:100%;">
					<div>Experience Months:</div>
					<div>
						{html_options id="expmonths" name="expmonths" options=$monthsoptions selected=$monthsselected class="validate[required]" }
					</div>
				</div>
				<div style="float:left;width:100%;">
					<div>From Date:</div>
					<div><input type="text" name="compt_from_date" id="compt_from_date" value="" readonly="readonly" /></div>
				</div>
				<div style="float:left;width:100%;">
					<div>To Date:</div>
					<div><input type="text" name="compt_to_date" id="compt_to_date" value="" readonly="readonly" /></div>
				</div>
				<!--<div style="float:left;width:100%;">
					<div>&nbsp;</div>
					<div><input type="button" name="add_competancies" id="add_competancies" value="Add Competancies" /></div>
				</div>-->
			</div>
			</form>
		</div>
		<p id="competancies_operation_message_success" style="display:none;float:left;width:80%;"></p>
		<input type="hidden" name="total_compt_rows" id="total_compt_rows" value="{$cvcompetanciesdata|@count}" />
		<table>
			<tr>
				<th>No</th>
				<th>&nbsp;</th>
				<th>Skills</th>
				<th>Year</th>
				<th>Months</th>
				<th>From Date</th>
				<th>To Date</th>
				<th>&nbsp;</th>
				<th>Actions</th>
			</tr>			
			<tbody id="competancies_rows">
		{if $cvcompetanciesdata|@count gt 0}
			
			{assign name=comptcounter value=0}
			<tr id="no_competancies_row" style="display:none;">
				<td colspan="9">
					You need to add your Core Competancies through above Add Button
				</td>
			</tr>
			{foreach from=$cvcompetanciesdata item=competanciesdata}
				{capture assign=comptcounter}{$comptcounter+1}{/capture}
				<tr id="compt_row_{$competanciesdata.cv_competancies_id}">
					<td align="center">{$comptcounter}</td>
					<td>&nbsp;</td>
					<td align="center" id="compt_skill_{$competanciesdata.cv_competancies_id}">{$competanciesdata.cv_competancies_skill}</td>
					<td align="center" id="compt_skill_year_{$competanciesdata.cv_competancies_id}">{$competanciesdata.cv_competancy_skill_year}</td>
					<td align="center" id="compt_skill_month_{$competanciesdata.cv_competancies_id}">{$competanciesdata.cv_competancy_skill_month}</td>
					<td align="center" id="compt_skill_frm_date_{$competanciesdata.cv_competancies_id}">{$competanciesdata.cv_competancy_skill_from_date|date_format}<span id="frm_date_other_format_{$competanciesdata.cv_competancies_id}" style="display:none;">{$competanciesdata.cv_competancy_skill_from_date|date_format:"%Y-%m-%d"}</span></td>
					<td align="center" id="compt_skil_to_date_{$competanciesdata.cv_competancies_id}">{$competanciesdata.cv_competancy_skill_to_date|date_format}<span id="to_date_other_format_{$competanciesdata.cv_competancies_id}" style="display:none;">{$competanciesdata.cv_competancy_skill_from_date|date_format:"%Y-%m-%d"}</span></td>
					<td>&nbsp;</td>
					<td align="center"><a href="javascript:void(0);" onclick="fnEditCompetancies('{$competanciesdata.cv_competancies_id}');">Edit</a> &nbsp; <a onclick="fnDeleteCompetancies('{$competanciesdata.cv_competancies_id}');" href="javascript:void(0);">Delete</a></td>
				</tr>
			{/foreach}
		{else}
			<tr id="no_competancies_row">
				<td colspan="9">
					You need to add your Core Competancies through above Add Button
				</td>
			</tr>
		{/if}
		</tbody>
		</table>
	</div>
	<div id="education">
		<h2>Education</h2>
		<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
		
		<p style="float:left;width:100%;"><a href="javascript:void(0);" id="addeducationreq">Add Education</a></p>
		<div id="educationadd" title="Add Education" style="display:none;">
			<form id="cv_education" method="post">
			<p class="validateTips">Please fill in the below fields to add your Education.</p>
			<p id="education_operation_message_fail" style="display:none;"></p>
			<div>Degree:</div>
			<div>
				<input type="text" class="validate[required]" name="cand_degree" id="cand_degree"  value="{$cvformeducationhighest}"  />
				<input type="hidden" id="education_edit_mode_id" name="education_edit_mode_id" value="{$cvformeducationeditmodeid}" />
			</div>
			
			<div>&nbsp;</div>
			
			<div>School / University Name:</div>
			<div>
				<input type="text" class="validate[required]" name="cand_school_uni_name" id="cand_school_uni_name" class="" value="{$cvformeducationschooluniname}"  />
			</div>
			
			<div>&nbsp;</div>
			
			<div>Location:</div>
			<div>
				<input type="text" class="validate[required]" name="cand_education_location" id="cand_education_location"  value="{$cvformeducationlocation}"  />
			</div>
			
			<div>&nbsp;</div>
			
			<div>Continuing Education Classes:</div>
			<div>
				<!--<input type="text" name="cand_edu_classes" id="cand_edu_classes"  value=""  />-->
				{html_options name=cand_edu_classes id=cand_edu_classes options=$educationcontinue selected=$educationcontinueselected class="validate[required]" }
				<!--<select id="cand_edu_classes" name="cand_edu_classes">
					<option value="No">No</option>
					<option value="Yes">Yes</option>
				</select>-->
			</div>
			
			<div>&nbsp;</div>
			</form>
		</div>
		<p id="education_operation_message_success" style="display:none;float:left;width:80%;"></p>
		<input type="hidden" name="total_edu_rows" id="total_edu_rows" value="{$cveducationdata|@count}" />
		<div id="educontainer" style="padding:5px;float:left;width:100%;">
		{if $cveducationdata|@count gt 0}
			{assign name=educounter value=0}
			<div id="edu_no_row" style="float:left;width:100%;display:none;">
				You need to add your Education through above Add Button
			</div>
			{foreach from=$cveducationdata item=educationdata}
				{capture assign=educounter}{$educounter+1}{/capture}
				<div id="counter_{$educationdata.cv_education_id}" style="float:left;width:8%;margin-right:2%;clear:both;margin-top:10px;">	
					{$educounter}
				</div>
				<div id="education_data_container_{$educationdata.cv_education_id}" style="float:left;width:68%;margin-right:2%;margin-top:10px;">
					<div id="label" style="float:left;width:48%;margin-right:2%;">
						<label style="font-weight:bold;">Education:</label>
					</div>
					<div id="edu_quali_data_{$educationdata.cv_education_id}" style="float:left;width:48%;margin-right:2%;">
						{$educationdata.cv_education_highest}
					</div>
					<div id="label" style="float:left;width:48%;margin-right:2%;">
						<label style="font-weight:bold;">School / University:</label>
					</div>
					<div id="edu_school_data_{$educationdata.cv_education_id}" style="float:left;width:48%;margin-right:2%;">
						{$educationdata.cv_education_school_uni_name}
					</div>
					<div id="label" style="float:left;width:48%;margin-right:2%;">
						<label style="font-weight:bold;">Location:</label>
					</div>
					<div id="edu_location_data_{$educationdata.cv_education_id}" style="float:left;width:48%;margin-right:2%;">
						{$educationdata.cv_education_location}
					</div>
					<div id="label" style="float:left;width:48%;margin-right:2%;">
						<label style="font-weight:bold;">Continuing Education Classes:</label>
					</div>
					<div id="edu_continue_data_{$educationdata.cv_education_id}" style="float:left;width:48%;margin-right:2%;">
						{$educationdata.cv_education_continue}
					</div>
				</div>
				<div id="action_{$educationdata.cv_education_id}" style="float:left;width:18%;margin-right:2%;margin-top:10px;">
					<a href="javascript:void(0);" onclick="fnEditEducation('{$educationdata.cv_education_id}')">Edit</a>&nbsp;<a href="javascript:void(0);" onclick="fnDeleteEducation('{$educationdata.cv_education_id}')">Delete</a>
				</div>
			{/foreach}
		{else}
			<div id="edu_no_row" style="float:left;width:100%;">
				You need to add your Education through above Add Button
			</div>
		{/if}
		</div>
	</div>
	<div id="experience">
		<h2>Experience</h2>
		<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
		
		<p style="float:left;width:100%;"><a href="javascript:void(0);" id="addexperiencereq">Add Experience</a></p>
		<div id="experienceadd" title="Add Experience" style="display:none;">
			<form id="cv_experience_form" method="post">
			<p class="validateTips">Please fill in the below fields to add your Experience.</p>
			<p id="experience_operation_message_fail" style="display:none;"></p>
			<div>Experience:</div>
			<div>
				{html_options name=exp id=exp options=$expoptions selected=$expselected class="validate[required]"}
				<input type="hidden" id="experience_edit_mode_id" name="experience_edit_mode_id" value="{$cvformexperienceeditmodeid}" />
			</div>
			
			<div>&nbsp;</div>
			
			<div>Name of the Company:</div>
			<div>
				<input class="validate[required,custom[onlyLetterSp]]" type="text" value="{$expcompanyname}" name="company_name" id="company_name" />
			</div>
			
			<div>&nbsp;</div>
			
			<div>Location of Company:</div>
			<div>
				<input type="text" class="validate[required]" value="{$expcompanylocation}" name="company_location" id="company_location" />
			</div>
			
			<div>&nbsp;</div>
			
			<div>Job Title:</div>
			<div>
				<input type="text" class="validate[required,custom[onlyLetterSp]]" value="{$expcompanyjobtitle}" name="company_job_title" id="company_job_title" />
			</div>
			
			<div>&nbsp;</div>
			
			<div>Duties / Responsibilities:</div>
			<div>
				<input type="text" class="validate[required]" value="{$expcompanyjobresp}" name="company_duties_respponsibilities" id="company_duties_respponsibilities" />
			</div>
			
			<div>&nbsp;</div>
			
			<div>Accomplishments & Impact on Employers:</div>
			<div>
				<textarea cols="45" rows="5" class="validate[required]" name="company_accomplishments" id="company_accomplishments">{$expcompanyjobaccomp}</textarea>
			</div>
			<div>&nbsp;</div>
			
			<div id="exp_positions">
				<div>Positions:
				{if $experiencedata|@count eq "0"}
					<input type="hidden" name="exp_position_field_counter" id="exp_position_field_counter" value="1" />
				{else}
					<input type="hidden" name="exp_position_field_counter" id="exp_position_field_counter" value="{$experiencedata|@count}" />
				{/if}
				<input type="hidden" name="exp_position_field_edit_id" id="exp_position_field_edit_id" value="" /><a href="javascript:void(0);" onclick="fnAddPositionFields();">Add More Positions</a>&nbsp;<a onclick="fnRemovePositionFields();" href="javascript:void(0);">Delete Positions</a></div>
				<div id="position_data_block_1">
					<input placeholder="Add Position Title" type="text" value="" name="exp_position_title_1" id="exp_position_title_1" />
					<input placeholder="Promotion Date" type="text" value="" name="exp_position_promotion_date_1" id="exp_position_promotion_date_1" />
				</div>
			</div>
			<div>&nbsp;</div>
			</form>
		</div>
		<p id="experience_operation_message_success" style="display:none;float:left;width:80%;"></p>
		<input type="hidden" name="total_experience_rows" id="total_experience_rows" value="{$cvexperiencedata|@count}" />
		<div id="expcontainer" style="padding:5px;float:left;width:100%;">
		{if $cvexperiencedata|@count gt 0}
			{assign name=expcounter value=0}
			<div id="exp_no_row" style="float:left;width:100%;display:none;">
				You need to add your Experience through above Add Button
			</div>
			{foreach from=$cvexperiencedata item=experiencedata}
				{capture assign=expcounter}{$expcounter+1}{/capture}
				<div id="exp_counter_{$experiencedata.cv_experience_id}" style="float:left;width:4%;margin-right:2%;clear:both;margin-top:10px;">	
					{$expcounter}
				</div>
				<div id="experience_data_container_{$experiencedata.cv_experience_id}" style="float:left;width:72%;margin-right:2%;margin-top:10px;">
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Experience:</label>
					</div>
					<div id="exp_type_data_{$experiencedata.cv_experience_id}" style="float:left;width:52%;margin-right:2%;">
						{$experiencedata.cv_experience_current}
					</div>
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Company Name:</label>
					</div>
					<div id="exp_company_name_data_{$experiencedata.cv_experience_id}" style="float:left;width:52%;margin-right:2%;">
						{$experiencedata.cv_experience_company_name}
					</div>
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Company Location:</label>
					</div>
					<div id="exp_company_location_data_{$experiencedata.cv_experience_id}" style="float:left;width:52%;margin-right:2%;">
						{$experiencedata.cv_experience_company_location}
					</div>
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Job Title:</label>
					</div>
					<div id="exp_company_jtitle_data_{$experiencedata.cv_experience_id}" style="float:left;width:52%;margin-right:2%;">
						{$experiencedata.cv_experience_company_job_title}
					</div>
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Duties:</label>
					</div>
					<div id="exp_company_resp_data_{$experiencedata.cv_experience_id}" style="float:left;width:52%;margin-right:2%;">
						{$experiencedata.cv_experience_company_responsibilities}
					</div>
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Accomplishments:</label>
					</div>
					<div id="exp_company_accmp_data_{$experiencedata.cv_experience_id}" style="float:left;width:52%;margin-right:2%;">
						{$experiencedata.cv_experience_company_accomplishments_impact}
					</div>
					<div id="label" style="float:left;width:44%;margin-right:2%;">
					<label style="font-weight:bold;">Positions:<span id="exp_position_list_{$experiencedata.cv_experience_id}" style="display:none;">{$experiencedata.exppositiondata|@count}</span></label>
					</div>
					{assign var=result value=''}
					<div id="exp_company_position_data_{$experiencedata.cv_experience_id}" style="float:left;width:52%;margin-right:2%;">
						{foreach from=$experiencedata.exppositiondata item=experiencepositiondata}
							{assign var=temp value=$experiencepositiondata.experience_positions_details_id}
							{assign var=result value=$result$temp|}
							<div id='exp_position_title_{$experiencedata.cv_experience_id}_{$experiencepositiondata.experience_positions_details_id}' style="float:left;width:48%;margin-right:2%;font-size:10px;">
								{$experiencepositiondata.position_title}
							</div>
							<div id="exp_position_promotiondate_{$experiencedata.cv_experience_id}_{$experiencepositiondata.experience_positions_details_id}" style="float:left;width:48%;margin-right:2%;font-size:10px;">
								{$experiencepositiondata.date_of_promotion|date_format}<span id="exp_position_mask_id_{$experiencedata.cv_experience_id}_{$experiencepositiondata.experience_positions_details_id}" style="display:none;">{$experiencepositiondata.date_of_promotion}</span>
							</div>
						{/foreach}
						<div id="position_ids_{$experiencedata.cv_experience_id}" style="display:none;">{$result}</div>
					</div>
				</div>
				<div id="exp_action_{$experiencedata.cv_experience_id}" style="float:left;width:18%;margin-right:2%;margin-top:10px;">
					<a href="javascript:void(0);" onclick="fnEditExperience('{$experiencedata.cv_experience_id}')">Edit</a>&nbsp;<a href="javascript:void(0);" onclick="fnDeleteExperience('{$experiencedata.cv_experience_id}')">Delete</a>
				</div>
			{/foreach}
		{else}
			<div id="exp_no_row" style="float:left;width:100%;">
				You need to add your Experience through above Add Button
			</div>
		{/if}
		</div>		
	</div>
	<div id="projects">
		<h2>Projects / Contracts</h2>
		<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
		<p style="float:left;width:100%;"><a href="javascript:void(0);" id="addprojectreq">Add Projects / Contracts</a></p>
		<div id="projectsadd" title="Add Projects / Contracts" style="display:none;">
			<form id="cv_contracts_form" method="post">
			<p class="validateTips">Please fill in the below fields to add your Projects / Contracts.</p>
			<p id="projects_operation_message_fail" style="display:none;"></p>
			<div>Contractor Name(if applicable):</div>
			<div>
				<input type="text" value="{$cvformcontractorname}" id="t_contractor_name" name="t_contractor_name"/>
				<input type="hidden" id="contractor_edit_mode_id" name="contractor_edit_mode_id" value="{$cvformcontractoreditmodeid}" />
			</div>
			
			<div>&nbsp;</div>
			
			<div>Company Name:</div>
			<div>
				<input class="validate[required,custom[onlyLetterSp]]" type="text" value="{$cvformcontractorcompanyname}" id="t_company_name" name="t_company_name"/>
			</div>
			
			<div>&nbsp;</div>
			
			<div>Job Title:</div>
			<div>
				<input class="validate[required,custom[onlyLetterSp]]" type="text" value="{$cvformcontractorcompanyjtitle}" id="t_company_job_title" name="t_company_job_title"/>
			</div>
			
			<div>&nbsp;</div>
			
			<div>Duration:</div>
			<div>
				<!--<input type="text" value="{$cvformcontractorcompanyjduration}" id="t_company_job_duration" name="t_company_job_duration"/>-->
				{html_options id="t_company_job_duration" name="t_company_job_duration" options=$yearsoptions class="validate[required]"} &nbsp; {html_options id="t_company_job_duration_M" name="t_company_job_duration_M" options=$monthsoptions class="validate[required]" }
			</div>
			
			<div>&nbsp;</div>
			
			<div>Accomplishments & Impact:</div>
			<div>
				<textarea cols="45" rows="5" class="validate[required]" name="t_company_job_accomplishments" id="t_company_job_accomplishments">{$cvformcontractorcompanyjaccomplishments}</textarea>
			</div>
			</form>
		</div>
		<p id="projects_operation_message_success" style="display:none;float:left;width:80%;"></p>
		<input type="hidden" name="total_proj_rows" id="total_proj_rows" value="{$cvcontractdata|@count}" />
		<div id="projcontainer" style="padding:5px;float:left;width:100%;">
		{if $cvcontractdata|@count gt 0}
			
			{assign name=projcounter value=0}
			<div id="proj_no_row" style="float:left;width:100%;display:none;">
				You need to add your Project / Contract through above Add Button
			</div>
			{foreach from=$cvcontractdata item=projdata}
				{capture assign=projcounter}{$projcounter+1}{/capture}
				<div id="proj_counter_{$projdata.cv_contracts_id}" style="float:left;width:4%;margin-right:2%;clear:both;margin-top:10px;">	
					{$projcounter}
				</div>
				<div id="proj_data_container_{$projdata.cv_contracts_id}" style="float:left;width:72%;margin-right:2%;margin-top:10px;">
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Contractor Name:</label>
					</div>
					<div id="proj_contract_name_data_{$projdata.cv_contracts_id}" style="float:left;width:52%;margin-right:2%;">
						{$projdata.cv_contracts_name}
					</div>
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Company Name:</label>
					</div>
					<div id="proj_cname_data_{$projdata.cv_contracts_id}" style="float:left;width:52%;margin-right:2%;">
						{$projdata.cv_contracts_company_name}
					</div>
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Job Title:</label>
					</div>
					<div id="proj_jtitle_data_{$projdata.cv_contracts_id}" style="float:left;width:52%;margin-right:2%;">
						{$projdata.cv_contracts_job_title}
					</div>
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Duration:</label>
					</div>
					<div id="proj_duration_data_{$projdata.cv_contracts_id}" style="float:left;width:52%;margin-right:2%;">
						<span id="proj_years_data_{$projdata.cv_contracts_id}">{$projdata.cv_contracts_job_duration_years}</span> years <span id="proj_months_data_{$projdata.cv_contracts_id}">{$projdata.cv_contracts_job_duration_months}</span> months
					</div>
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Accomplishments:</label>
					</div>
					<div id="proj_accom_data_{$projdata.cv_contracts_id}" style="float:left;width:52%;margin-right:2%;">
						{$projdata.cv_contracts_accomplishments|nl2br}
					</div>
				</div>
				<div id="proj_action_{$projdata.cv_contracts_id}" style="float:left;width:18%;margin-right:2%;margin-top:10px;">
					<a href="javascript:void(0);" onclick="fnEditProject('{$projdata.cv_contracts_id}')">Edit</a>&nbsp;<a href="javascript:void(0);" onclick="fnDeleteProject('{$projdata.cv_contracts_id}')">Delete</a>
				</div>
			{/foreach}
		{else}
			<div id="proj_no_row" style="float:left;width:100%;">
				You need to add your Projects / Contracts through above Add Button
			</div>
		{/if}
		</div>
	</div>
	<div id="skills">
		<form id="cv_skills_form" method="post">
		<h2>Skills</h2>
		<p>Technical Proficiencies i.e. software, social media.</p>
		<p id="cv_skills_message_success" style="display:none;float:left;width:100%;"></p>
		<div>&nbsp;</div>
		
		<div>Key Skills:</div>
		<div>
			<input type="hidden" name="cv_id" id="cv_id" value="{$id}" /> 
			<textarea name="key_skills" id="key_skills" placeholder="Enter comma seperated list of skills i.e. software, social media" cols="50">{$cvformkeyskills}</textarea>
		</div>
		<p>
			<input type="button" onclick="fnUpdateCVSkills()" name="update_skills_status" id="update_skills_status" value="Update" />&nbsp;
			<span style="display:none;" id="cvskillsloader"><img alt="loginloader" src="{$DOC_ROOT}images/loader.gif"></span>
		</p>
		</form>
	</div>
	<div id="awards">
		<form id="cv_awards_form" method="post">
		<h2>Awards</h2>
		<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
		<p id="	" style="display:none;float:left;width:100%;"></p>
		
		<div>Describe professional accolades, published articles, awards:</div>
		<div>
			<input type="hidden" id="award_edit_mode_id" name="award_edit_mode_id" value="{$cvformawardseditmodeid}" />
			<input type="hidden" name="cv_id" id="cv_id" value="{$id}" /> 
			<textarea cols="50" name="cv_awards" id="cv_awards">{$cvformawards}</textarea>
		</div>
		<p>
			<input type="button" onclick="fnUpdateCVAwards()" name="update_awards_status" id="update_awards_status" value="Update" />&nbsp;
			<span style="display:none;" id="cvawardsloader"><img alt="loginloader" src="{$DOC_ROOT}images/loader.gif"></span>
		</p>
		</form>
	</div>
	<!--<div id="tabs-10">
		<h2>Content heading 10</h2>
		<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
		<p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
	</div>-->
</div>

{*<br /><br />

<div class="cv_header">{lang mkey='header' skey='cv_2'}</div>
<div class="cv_contain">
    
    <label class="label">{lang mkey='label' skey='cv_1'}</label>
    <br />
    <select name='txt_experience' class="select" >
      {html_options options=$experience selected=$smarty.session.resume.exper}
    </select>
    
    <hr />
    <label class="label">{lang mkey='label' skey='cv_2'}</label>
    <br />
    <select name='txt_education' class="select" >
      {html_options options=$education selected=$smarty.session.resume.educ}
    </select>
    
    <hr />
    <label class="label">{lang mkey='label' skey='cv_3'}</label>
    <br />
    <select name='txt_salary' class="select">
        {html_options options=$salary selected=$smarty.session.resume.salary}
    </select>
    
    <hr />
    <label class="label">{lang mkey='label' skey='cv_4'}</label>
    <br />
    <select name='txt_availabe' class="select" >
    	{html_options options=$NoYes selected=$smarty.session.resume.availabe}
    </select>
        
    <hr />
    <label class="label">{lang mkey='label' skey='cv_5'}</label>
    <br />
{html_select_date 
prefix='txt_start_date_' 
start_year='-0' 
end_year="+5" 
field_order="DMY" 
month_format="%B" 
day_value_format="%02d" 
year_empty=$select_text 
month_empty=$select_text
day_empty=$select_text
time=$defult_date|default:'0000-00-00'}
        
   <hr />
   <label class="label">{lang mkey='label' skey='cv_6'}</label>
   <br />
   	<input type="text" name="txt_position" value="{$smarty.session.resume.position}" class="text_field" />
    <br /><br />
</div>

<br /><br />

<div class="cv_header">{lang mkey='header' skey='cv_3'}</div>
<div class="cv_contain">
    
    <label class="label">{lang mkey='label' skey='cv_7'}<img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />
    	<input type="text" name="txt_recent_job_title" value="{$smarty.session.resume.rjt}" class="text_field" />
    
    <hr />
    <label class="label">{lang mkey='label' skey='cv_8'}<img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />
    <input type="text" name="txt_recent_employer" value="{$smarty.session.resume.re}" class="text_field" />
    
    <hr />
    <label class="label">{lang mkey='label' skey='cv_9'}<img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />
    <select name='txt_recent_industry' class="select">
        {html_options options=$category selected=$smarty.session.resume.riw}
    </select>
    
    <hr />
    <label class="label">{lang mkey='label' skey='cv_10'}<img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />
    <select name='txt_recent_career' class="select">
      {html_options options=$career selected=$smarty.session.resume.rcl}
    </select>
 <br /><br />
</div>

<br /><br />

<div class="cv_header">{lang mkey='header' skey='cv_4'}</div>

<div class="cv_contain">
 <label class="label">{lang mkey='label' skey='cv_11'}<img src="{$skin_images_path}required.gif" alt="" /></label>
 
 <br /><input type="text" name="txt_look_job_title" value="{$smarty.session.resume.ljt}" class="text_field" /><br />
 <br /><input type="text" name="txt_look_job_title2" value="{$smarty.session.resume.ljt2}" class="text_field" />

 <hr />
    <!-- 
    <label class="label">What occupation are you looking for?  (max. 5) <img src="{$skin_images_path}required.gif" alt="" /></label>
    
    <hr />
    -->
    <label class="label">{lang mkey='label' skey='cv_12'} <img src="{$skin_images_path}required.gif" alt="" /></label>
<div class="large_box box">	
    {foreach from=$category key=k item=v}
        <div class='new_job' >
        <input type="checkbox" value="{$k}"  
            {foreach from=$category_selected key=kk item=vv}
              {if $k eq $vv } checked="checked" {/if}
            {/foreach}
        onclick="return check_max_checkbox('category[]', 10 ); " name="category[]" class="checkbox" />
        <a onclick="return check_box('{$k}', 'category[]', 10 );">{$v|strip_tags}</a>
        </div>
    {/foreach}
    
    <div class="clear"></div>
</div>
    
    
    <hr />
    
   <label class="label">{lang mkey='label' skey='cv_13'} <img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />
    <select name='txt_job_statu' class="select">
      {html_options options=$job_status selected=$smarty.session.resume.ljs}
    </select>
	
    <hr />
    
   <label class="label">{lang mkey='label' skey='cv_18'} {*<img src="{$skin_images_path}required.gif" alt="" />*}{*</label>
    <br />
    <select name='txt_job_type' class="select">
      {html_options options=$job_type selected=$smarty.session.resume.job_type}
    </select>
    
    
    <br /><br />
</div>

<br /><br />

<div class="cv_header">{lang mkey='header' skey='cv_5'}</div>

<div class="cv_contain">

     <label class="label">{lang mkey='label' skey='cv_14'}<img src="{$skin_images_path}required.gif" alt="" /></label>
     <br />

<table width="100%">
  <tr>
    <td width="49%">    
    <label class="label">{lang mkey='label' skey='country'}</label><br />
    <select name="txt_country" id="txt_country" onchange="javascript: cascadeCountry(this.value,'txtstateprovince');" >
        {html_options options=$country selected=$smarty.session.loc.country}
    </select>
</td>
    <td width="49%">
    <label class="label">{lang mkey='label' skey='state'}</label><br />
    <div id="stateprovince_auto">
        {if $lang.states|@count > 0}
            <select class="select" name="txtstateprovince" onchange="javascript: cascadeState(this.value, this.form.txt_country.value,'txtcounty');" >
            {html_options options=$lang.states selected=$smarty.session.loc.stateprovince}
            </select>
        { else }
            <input class="text_field required" name="txtstateprovince" type="text" size="30" maxlength="100" value="{$smarty.session.loc.stateprovince}" />
        { /if}                
    </div>
</td>
</tr>
<tr>
    <td>    
    <label class="label">{lang mkey='label' skey='county'} </label><br />
    <div id="county_auto">

      { if $lang.counties|@count > 0}
        <select class="select" name="txtcounty" onchange="javascript: cascadeCounty(this.value,this.form.txt_country.value, this.form.txtstateprovince.value,'txtcity');" >
        {html_options options=$lang.counties selected=$smarty.session.loc.countycode}
        </select>
      { else }
        <input name="txtcounty" type="text" size="30" maxlength="100" value="{$smarty.session.loc.countycode}" />
      { /if}
    
    </div>
</td>
    <td>
    <label class="label">{lang mkey='label' skey='city'}</label><br />
    <div id="city_auto">
      { if $lang.cities|@count > 0}
        <select class="select" name="txtcity" >
          {html_options options=$lang.cities selected=$smarty.session.loc.citycode}
        </select>
      { else }
        <input name="txtcity" type="text" size="30" maxlength="100" value="{$smarty.session.loc.citycode}" />
      { /if}

    </div>
</td>
  </tr>
</table>

    <hr />
    
    <label class="label">{lang mkey='label' skey='cv_15'}<img src="{$skin_images_path}required.gif" alt="" /></label>
     <br />
     <select name="txt_authorised_to_work" class="select" >
         <option value="">-SELECT-</option>
         {html_options options=$authorised_to_work selected=$smarty.session.resume.aya}
      </select>
    <hr />
    
    <label class="label">{lang mkey='label' skey='cv_16'}<img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />
    <select name='txt_relocate' class="select">
      {html_options options=$NoYes selected=$smarty.session.resume.wtr}
	</select>
    
    <hr />    
    <label class="label">{lang mkey='label' skey='cv_17'}<img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />
    <select name="txt_travel" class="select" > 
      <option value="">-SELECT-</option>
      {html_options options=$willing_to_travel selected=$smarty.session.resume.wtt}      
    </select>
  <br /><br />
</div>

<br /><br />

<div class="cv_header">{lang mkey='header' skey='cv_6'}</div>
<div class="cv_contain">
  <textarea name="txt_notes" rows="10" cols="60" class="textarea" >{$smarty.session.resume.notes}</textarea>
  <br /><br />
</div>*}

<p>
 <input type="button" name="bt_cancel" value=" {lang mkey='button' skey='cancel'} " class="button" onclick="redirect_to('{$BASE_URL}curriculum_vitae/?portid={$intPortId}');" />
<!-- <input type="submit" name="bt_save" value=" {lang mkey='button' skey='save_continue' }" class="button" /> -->
</p>

    <SCRIPT LANGUAGE="javascript">
    	check_max_checkbox('category[]', 10 );
    </SCRIPT>

<!--</form>-->