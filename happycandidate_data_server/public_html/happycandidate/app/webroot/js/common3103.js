function fnGetLocationDetailFromZip()
{
	var strZipCode = $('#UserZipcode').val();
	var datastr = 'zip='+strZipCode;
	$('#loader').show();
	var strUrl = "getlocation/";
	if($('#nohtml').length>0)
	{
		strUrl = appBaseU+"jstcontacts/"+strUrl;
	}
	$.ajax({ 
			type: "POST",
			url: strUrl,
			data: datastr,
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
					if(data.countrycdval != "")
					{
						$('#UserCountry').val(data.countrycdval);
						$('#UserCountry').change();
					}
					else
					{
						$('#UserCountry').val("");
					}
					if(data.statecdval != "")
					{
						$('#UserState').val(data.statecdval);
						$('#pstate').val(data.statecdval);
					}
					else
					{
						$('#UserState').val("");
					}
					
					if(data.cityval != "")
					{
						$('#UserCity').val(data.cityval);
						$('#pcity').val(data.cityval);
					}
					else
					{
						$('#UserCity').val("");
					}
				}
				$('#loader').hide();
				$('#country_row').show();
				$('#state_city').show();
				
				//alert(data);
				//$("#state_city").html();
				//$("#state_city").html(data);
			}
	});
}

function fnGetStateList(cid)
{
	var intCountryId = cid;
	var strNohtml = 0;
	var strUrl = "states/"+intCountryId+"/"+strNohtml;
	if($('#nohtml').length>0)
	{
		strNohtml = $('#nohtml').val();
		strUrl = appBaseU+"jstcontacts/states/"+intCountryId+"/"+strNohtml;
	}
	var datastr = 'contry_id='+intCountryId;
	$.ajax({ 
			type: "POST",
			url: strUrl,
			data: datastr,
			cache: false,
			success: function(data)
			{
				//alert(data);
				$("#state_city").html();
				$("#state_city").html(data);
				if($('#pstate').val() != "")
				{
					$('#UserState').val($('#pstate').val());
					$('#UserState').change();
					$('#pstate').val('');
				}
			}
	});
}

function fnShareOnSocial(strShareOn)
{
	var strNohtml = 0;
	shareUrl = encodeURIComponent(window.location.href);
	strUrl = appBaseU+"portal/share/?shareon="+strShareOn+"&shareurl="+shareUrl;
	window.open(strUrl,'Login','width=500,height=500');
	
	/*$.ajax({ 
			type: "POST",
			url: strUrl,
			cache: false,
			success: function(data)
			{
				
				if(data.status == "success")
				{
					alert(data.message);
				}
				else
				{
					alert(data.message);
				}
				
				//alert(data);
				//$("#city").html();
				//$("#city").html(data);
				
				/*if($('#pcity').val() != "")
				{
					$('#UserCity').val($('#pcity').val());
					$('#UserCity').change();
					$('#pcity').val('');
				}*/
			/*}
	});*/
}

function fnGetCityList(sid)
{
	var intStateId = sid;
	var strNohtml = 0;
	var strUrl = "cities/"+intStateId+"/"+strNohtml;
	if($('#nohtml').length>0)
	{
		strNohtml = $('#nohtml').val();
		strUrl = appBaseU+"jstcontacts/cities/"+intStateId+"/"+strNohtml;
	}
	var datastr = 'state_id='+intStateId;
	$.ajax({ 
			type: "POST",
			url: strUrl,
			data: datastr,
			cache: false,
			success: function(data)
			{
				//alert(data);
				$("#city").html();
				$("#city").html(data);
				
				if($('#pcity').val() != "")
				{
					$('#UserCity').val($('#pcity').val());
					$('#UserCity').change();
					$('#pcity').val('');
				}
			}
	});
}

function fnToggleFieldsDisplay(value)
{
	var intValue = value;
	if(intValue == 0)
	{
		$('#system_fields_row').fadeOut('slow');
	}
	
	if(intValue == 1)
	{
		$('#system_fields_row').fadeIn('slow');
	}
	
	if(intValue == 2)
	{
		$('#system_fields_row').fadeIn('slow');
	}
}

function fnApplyEditorHoverCss(ele)
{
	$(ele).removeClass('editorremovehovercss');	
	$(ele).addClass('editorhovercss');	
}

function fnRemoveEditorHoverCss(ele)
{
	$(ele).removeClass('editorhovercss');	
	$(ele).addClass('editorremovehovercss');	
}

function fnShowEditMenu()
{
	$('#menuedit').show();
}

function fnHideEditMenu()
{
	$('#menuedit').hide();
}

function fnToUpdateProfile(portalid)
{
	var isValidated = jQuery('#account_form').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
		
		$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/updateProfile/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
			
				if(responseText.status == "1")
				{
					$('#alertMessages').html(responseText.message);
				}
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#account_form').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}
}




function fnShowMenuSection(showform)
{
	$( "#dialog-form" ).dialog( "open" );
	$('#menu_name').val('');
	$('#menu_page option[value=""]').attr('selected', 'selected');
	$('#menu_id').val('');
	$('#menuformdiv').hide();
	
}
function fnShowWidgetsSection()
{
	$("#dialog-widget-form").dialog("open");
}
function fnShowBannerImageSection()
{
	$("#dialog-banner_image-form").dialog("open");
}

function fnShowContactCustomizer()
{
	$("#fieldchange").hide();
	$("#postfieldeditmessages").hide();
	$("#field_edit_label").val('');
	
	$("#dialog-contactus-form").dialog("open");
}

function fnShowRegisterCustomizer()
{
	$("#portalregisterfieldchange").hide();
	$("#postportalregisterfieldeditmessagess").hide();
	$("#portal_register_field_edit_label").val('');
	
	$("#dialog-register-form").dialog("open");
}

function fnShowRegisterManage()
{
	$('#register_manage').show();
}

function fnHideRegisterManage()
{
	$('#register_manage').hide();
}

function fnShowContactUsSetting()
{
	$('#contact_us_manage').show();
}

function fnHideContactUsSetting()
{
	$('#contact_us_manage').hide();
}

function fnShowWidgetSetter()
{
	$('#widgets_links').show();
}

function fnHideWidgetSetter()
{
	$('#widgets_links').hide();
}

function fnShowHeaderImageSetter()
{
	$('#header_image').show();
}

function fnHideHeaderImageSetter()
{
	$('#header_image').hide();
}

function fnShowEditLogo()
{
	//alert("Hello");
	$('#logoedit').show();
}

function fnHideEditLogo()
{
	$('#logoedit').hide();
}

function fnShowLogoEditSection()
{
	//alert("Hello");
	$( "#dialog-logo-form" ).dialog( "open" );
}

function fnShowEditPage()
{
	$('#pageedit').show();
}

function fnHideEditPage()
{
	$('#pageedit').hide();
}

function fnShowPageEditSection()
{
	//alert("Hello");
	$( "#dialog-page-form" ).dialog( "open" );
}

function fnShowPageAddSection(returnValue)
{
	//alert("Hello");
	if(returnValue =="1")
	{
		$( "#dialog-add-page-form" ).data('returnvalue',"success").dialog("open");
	}
	else
	{
		$( "#dialog-add-page-form" ).dialog( "open" );
	}
	
}

function fnShowEditCopyright()
{
	$('#copyrightsedit').show();
}

function fnHideEditCopyright()
{
	$('#copyrightsedit').hide();
}

function fnShowCopyrightEditSection()
{
	//alert("Hello");	
	$( "#dialog-copyright-form" ).dialog( "open" );
}


function fnEditPortalRegisterField(intRegisterFormId,intFieldId,strFieldLabel)
{
	
	strLatestFieldlabel = $('#portalregisterformfield_'+intFieldId).text();
	var strFieldenable = $('#field_enable_'+intFieldId).val();
	var isFieldMandatory = $('#portal_register_fieldmandatory_'+intFieldId).val();
	$('#portal_register_field_edit_label').val(strLatestFieldlabel);
	$('#portal_register_field_id').val(intFieldId);
	$('#portal_register_form_identifier').val(intRegisterFormId);
	if(isFieldMandatory != "0")
	{
		$('#portal_register_fieldmandatoryyes').attr('checked',true);
		$('#portal_register_fieldmandatoryyes').val(isFieldMandatory);
	}
	else
	{
		$('#portal_register_fieldmandatoryno').attr('checked',true);
	}

	if(strFieldenable == "1")
	{

		$('#portal_register_fieldenableyes').attr('checked',true);
		$('#portal_register_fieldenableyes').val(strFieldenable);
	}
	else
	{

		$('#portal_register_fieldenableyno').attr('checked',true);
		$('#portal_register_fieldenableyno').val("0");
	}
	
	$('#portalregisterfieldchange').fadeIn('slow');

}


function fnEditField(intContactFormId,intFieldId,strFieldLabel)
{
	strFieldLabel = $('#contactformfield_'+intFieldId).text();
	var isFieldMandatory = $('#contactformfieldmandatory_'+intFieldId).val();
	var isGreetName = $('#contactformfieldgreetname_'+intFieldId).val();
	var isCEmail = $('#contactformfieldemailfield_'+intFieldId).val();
	var isCMessage = $('#contactformfieldmessage_'+intFieldId).val();
	$('#field_edit_label').val(strFieldLabel);
	$('#field_id').val(intFieldId);
	$('#contact_form_identifier').val(intContactFormId);
	/* alert(isGreetName);
	alert(isCEmail);
	alert(isCMessage); */
	
	if(isFieldMandatory != "0")
	{
		$('#fieldmandatoryyes').attr('checked',true);
		$('#fieldmandatoryyes').val(isFieldMandatory);
	}
	else
	{
		$('#fieldmandatoryno').attr('checked',true);
	}
	
	if(isGreetName == "1")
	{
		$('#greetnameyes').attr('checked',true);
	}
	else
	{
		$('#greetnameno').attr('checked',true);
	}
	
	if(isCEmail == "1")
	{
		$('#fieldemailyes').attr('checked',true);
	}
	else
	{
		$('#fieldemailno').attr('checked',true);
	}
	
	if(isCMessage == "1")
	{
		$('#fieldmessageyes').attr('checked',true);
	}
	else
	{
		$('#fieldmessageno').attr('checked',true);
	}
	
	$('#fieldchange').fadeIn('slow');
	
	/* $('.ui-button-text').each(function () {
		if($('.ui-button-text') == "Change")
		{
			$('.ui-button-text').text('Edit');
		}
	}); */
}

function fnEditMenu(intMenuId)
{
	
	$('#menuformdiv').fadeIn('slow');
	$('#menu_name').val($('#menu_name_'+intMenuId).text());
	$('#menu_page option[value="'+$('#menu_page_'+intMenuId).text()+'"]').attr('selected', 'selected');
	$('#menu_id').val(intMenuId);
	
	/* $('.ui-button-text').each(function () {
		if($('.ui-button-text') == "Change")
		{
			$('.ui-button-text').text('Edit');
		}
	}); */
	
	
}

function fnHideSocialMediaButtons(intPortalId,intRegisterFormId,intSocialMediaButtonId)
{
	//alert(intPortalId);
	//alert(intRegisterFormId);
	//alert(intSocialMediaButtonId);
	var strPortalBaseUrl = appBaseU;
	
	var datastr = "registerformid="+intRegisterFormId+"&registersocialmediabuttonid="+intSocialMediaButtonId;
	
	$.ajax({ 
			type: "GET",
			url: strPortalBaseUrl+"privatelabelsites/hidesocialmediabutton/"+intPortalId,
			dataType: 'json',
			data:datastr,
			success: function(data)
			{
				//alert(data.status);
				if(data.status == "success")
				{
					$('#registrationformpostmessages').text('');
					$('#registrationformpostmessages').removeClass('ui-state-error');
					$('#registrationformpostmessages').addClass('ui-state-success');
					$('#registrationformpostmessages').text(data.message);
					$('#registrationformpostmessages').fadeIn('slow');
					
					$('#social_media_remove_'+intSocialMediaButtonId).hide();
					$('#social_media_add_'+intSocialMediaButtonId).show();
					
					$('#social_media_button_'+intSocialMediaButtonId).hide();
				}
			}
	});
}

function fnAddSocialMediaButtons(intPortalId,intRegisterFormId,intSocialMediaButtonId)
{
	/* alert(intPortalId);
	alert(intRegisterFormId);
	alert(intSocialMediaButtonId); */
	var strPortalBaseUrl = appBaseU;
	
	var datastr = "registerformid="+intRegisterFormId+"&registersocialmediabuttonid="+intSocialMediaButtonId;
	
	$.ajax({ 
			type: "GET",
			url: strPortalBaseUrl+"privatelabelsites/addsocialmediabutton/"+intPortalId,
			dataType: 'json',
			data:datastr,
			success: function(data)
			{
				//alert(data.status);
				if(data.status == "success")
				{
					$('#registrationformpostmessages').text('');
					$('#registrationformpostmessages').removeClass('ui-state-error');
					$('#registrationformpostmessages').addClass('ui-state-success');
					$('#registrationformpostmessages').text(data.message);
					$('#registrationformpostmessages').fadeIn('slow');
					
					$('#social_media_remove_'+intSocialMediaButtonId).show();
					$('#social_media_add_'+intSocialMediaButtonId).hide();
					
					$('#social_media_button_'+intSocialMediaButtonId).show();
				}
			}
	});
}

function fnDisableWidget(intWidgetId,intPortalId,intWidgetHolderId,strWName,strWidgetHolder)
{
	/* alert(intWidgetId);
	alert(intPortalId);
	alert(intThemeId); */
	//alert(intWidgetHolderId);
	var strPortalBaseUrl = $('#portalurl').val();
	
	var datastr = "widgetid="+intWidgetId+"&widgetholderid="+intWidgetHolderId+"&widgetholder="+strWidgetHolder;
	
	$.ajax({ 
			type: "GET",
			url: strPortalBaseUrl+"privatelabelsites/disablewidget/"+intPortalId,
			dataType: 'json',
			data:datastr,
			success: function(data)
			{
				//alert(data.status);
				if(data.status == "success")
				{
					var strMessage = data.message;
					$('#widgettablepostmessages').text('');
					$('#widgettablepostmessages').addClass('ui-state-success');
					$('#widgettablepostmessages').text(strMessage);
					$('#widgettablepostmessages').fadeIn('slow');
					$('#disable_widget_'+intWidgetId).hide();
					$('#enable_widget_'+intWidgetId).show();
					
					if(strWName == "Job Search")
					{
						$('#jopsearch-'+intPortalId+"_"+intWidgetId+"_"+intWidgetHolderId).hide();
					}
					else
					{
						if(strWName == "Latest Jobs")
						{
							$('#latestjobs-'+intPortalId+"_"+intWidgetId+"_"+intWidgetHolderId).hide();
						}
						else
						{
							if(strWName == "Highlighted Jobs")
							{
								$('#highlightedjobs-'+intPortalId+"_"+intWidgetId+"_"+intWidgetHolderId).hide();
							}
							else
							{
								if(strWName == "Contact Us")
								{
									$('#contactus-'+intPortalId+"_"+intWidgetId+"_"+intWidgetHolderId).hide();
								}
							}
						}
					}
				}
			}
	});
}

function fnEnableWidget(intWidgetId,intPortalId,intWidgetHolderId,strWName,strWidgetHolder)
{
	/* alert(intWidgetId);
	alert(intPortalId);
	alert(intThemeId); */
	var strPortalBaseUrl = $('#portalurl').val();
	
	var datastr = "widgetid="+intWidgetId+"&widgetholderid="+intWidgetHolderId+"&widgetholder="+strWidgetHolder;
	
	$.ajax({ 
			type: "GET",
			url: strPortalBaseUrl+"privatelabelsites/enablewidget/"+intPortalId,
			dataType: 'json',
			data:datastr,
			success: function(data)
			{
				//alert(data.status);
				if(data.status == "success")
				{
					var strMessage = data.message;
					$('#widgettablepostmessages').text('');
					$('#widgettablepostmessages').addClass('ui-state-success');
					$('#widgettablepostmessages').text(strMessage);
					$('#widgettablepostmessages').fadeIn('slow');
					$('#enable_widget_'+intWidgetId).hide();
					$('#disable_widget_'+intWidgetId).show();
					if(strWName == "Job Search")
					{
						$('#jopsearch-'+intPortalId+"_"+intWidgetId+"_"+intWidgetHolderId).show();
					}
					else
					{
						if(strWName == "Latest Jobs")
						{
							$('#latestjobs-'+intPortalId+"_"+intWidgetId+"_"+intWidgetHolderId).show();
						}
						else
						{
							if(strWName == "Highlighted Jobs")
							{
								$('#highlightedjobs-'+intPortalId+"_"+intWidgetId+"_"+intWidgetHolderId).show();
							}
							else
							{
								if(strWName == "Contact Us")
								{
									$('#contactus-'+intPortalId+"_"+intWidgetId+"_"+intWidgetHolderId).show();
								}
							}
						}
					}
				}
			}
	});
}

function fnDeleteMenu(intMenuId)
{
	//alert(intMenuId);
	var strPortalBaseUrl = $('#portalurl').val();
	
	$.ajax({ 
			type: "GET",
			url: strPortalBaseUrl+"privatelabelsites/menudelete/"+intMenuId+"/",
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				//alert(data.status);
				if(data.status == "success")
				{
					$('#menutablepostmessages').text('');
					$('#menutablepostmessages').addClass('ui-state-success');
					$('#menutablepostmessages').text(data.message);
					$('#menutablepostmessages').fadeIn('slow');
					$('#menu_row_'+intMenuId).remove();
					$('#menu_li_'+intMenuId).remove();
					
					$('#menu_name').val('');
					$('#menu_page option[value=""]').attr('selected', 'selected');
					$('#menu_id').val('');
					
					var strLiCount = $('#menusection').children('li').size();
					if(strLiCount == "0")
					{
						$('#add_menus_option').show();
					}
				}
			}
	});
	
}

function fnShowMenuForm()
{
	$('#menu_name').val('');
	$('#menu_page option[value=""]').attr('selected', 'selected');
	$('#menu_id').val('');
	$('#menuformdiv').fadeIn('slow');
}

function fnUpdateWidgetOrder(menu_order)
{
	var strEditorTypeToUpdate = $('#typeeditor').val();
	var strPortalBaseUrl = $('#portalurl').val();
	var strToReturn = "";
	var datastr = "widgetholder="+strEditorTypeToUpdate;
	$.ajax({ 
			type: "GET",
			url: strPortalBaseUrl+"privatelabelsites/widgetpositionupdate/"+menu_order+"/",
			cache: false,
			dataType: 'json',
			data:datastr,
			success: function(data)
			{
				//alert(data.status);
				if(data.status == "success")
				{
					
				}
				else
				{
					return false;
				}
			}
	});
}

function fnUpdateMenuOrder(menu_order)
{
	var strPortalBaseUrl = $('#portalurl').val();
	var strToReturn = "";
	$.ajax({ 
			type: "GET",
			url: strPortalBaseUrl+"privatelabelsites/menupositionupdate/"+menu_order+"/",
			//url: strPortalBaseUrl+"privatelabelsites/menupositionupdate/",
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				//alert(data.status);
				if(data.status == "success")
				{
					strMenuOrder = menu_order.toString();
					arrOrder = strMenuOrder.split(",");
					//alert(arrOrder);
					$.each(arrOrder, function(key, value) {
						var identifierString = value.toString();
						arrIdentifier = identifierString.split("_");
						var strLiElement = $('#menu_li_'+arrIdentifier[2]).get();
						$('#menusection').children('#menu_li_'+arrIdentifier[2]).remove();
						$('#menusection').append(strLiElement);
					});
				}
			}
	});
}

function fnShowLogoPopup(intDivId)
{
	$("#logo_popup_image_"+intDivId).dialog({
				autoOpen: false,
				height: 'auto',
				width: 'auto',
				modal: true,
				open: function () {
				},
				close: function() {
					
				}
			});
	
	$("#logo_popup_image_"+intDivId).dialog( "open" );
}

function fnLogSeekerIn()
{
	alert("Hi");
	//window.location.reload();
}

function fnSocialRegister(element)
{
	var strURLElementId = $(element).val()+"_process_url";	
	strUrl = $('#'+strURLElementId).val();
	window.open(strUrl,'Login','width=500,height=500');
}
function fnSocialRegisterPortal(element)
{
	var strURLElementId = $(element).attr('title')+"_process_url";	
	strUrl = $('#'+strURLElementId).val();
	window.open(strUrl,'Login','width=500,height=500');
}

function fnSetCandidateNotification(intPortalId)
{
	var isJobNotification = $('.jnotificaton:checked').val();
	
	var isResourceNotification = $('.rnotificaton:checked').val();
	var datastr = "jnotification="+isJobNotification+"&rnotification="+isResourceNotification;
	

		var url = appBaseU +"settings/notifications/"+intPortalId+"/";
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			
				if(responseText.status == "success")
				{
					alert(responseText.message);
				}
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#CandidateSettings').ajaxSubmit(options); 

	
	return false;
}

function fnSearchPortalWebinars(intPortalId)
{
	
var isValidated = jQuery('#webinar_search').validationEngine('validate');
	if(isValidated == false)
		{
			return false;
		}
		else
		{
		
		$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
		var url = appBaseU +"candidates/searchwebinars/"+intPortalId+"/"
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
			
				//alert(responseText.status);
				
				if(responseText.status == "success")
				{
					$(".results-container").html('');
					$(".results-container").html(responseText.htmldata);
				}
				else
				{
					//alert(data.message);
				}
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#webinar_search').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}
		
}

function fnSearchPortalCourses(intPortalId)
{
	var strCourseName = $('#course_name').val();
	/*alert(strCourseName);
	alert(intPortalId);*/
	var datastr = "course_name="+strCourseName;
	
	$.ajax({ 
			type: "GET",
			url: appBaseU +"candidates/getcourses/"+intPortalId+"/",
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				//alert(data.status);
				if(data.status == "success")
				{
					$(".service-con").html('');
					$(".service-con").html(data.htmldata);
				}
				else
				{
					//alert(data.message);
				}
			}
	});
	
}

function fnSubmitTheFormLoginAs(strLoginAction,strLogoutAction,$strUname,$strPassword,$strUtype)
{
	//alert(strLoginAction);
	//alert(strLogoutAction);
	//return false;
	
	var username = $strUname;
	var password = $strPassword;
	var utype = $strUtype;
	var datastr = "data[User][user_email]="+username+"&data[User][password]="+password+"&data[User][u_type]="+utype;
	var strMoodleLoginUrl = strLmsLoginPath;
	var boolSystemLogin = "";
	var strSystemLoginRedirectUrl = "";
	var strAdminUserName = "";
	var strAdminUserEmail = "";
	var strAdminUserId = "";
	
	$.ajax({ 
			type: "POST",
			url: strLoginAction,
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "failure")
				{
					window.location.reload();
				}
				
				if(data.status == "success")
				{
					boolSystemLogin = "1";
					strSystemLoginRedirectUrl = data.redirecturl;
					strAdminUserName = data.username;
					strAdminUserEmail = data.useremail;
					strAdminUserId = data.userid;
					
				}
			},
			complete: function(xhr, textStatus) 
			{
				if(boolSystemLogin == "1")
				{
					fnLoginToJb(strAdminUserName,strAdminUserEmail,strAdminUserId,strSystemLoginRedirectUrl,username,password,strMoodleLoginUrl,utype,strLogoutAction);
				}
			} 
	});
	
	return false;
}

function fnSubmitTheForm(strLoginAction,strLogoutAction)
{
	//alert(strLoginAction);
	//alert(strLogoutAction);
	//return false;
	
	var username = $('#UserUserEmail').val();
	
	var password = $('#UserPassword').val();
	var utype = $('#UserUType').val();
	var datastr = "data[User][user_email]="+username+"&data[User][password]="+password+"&data[User][u_type]="+utype;
	var strMoodleLoginUrl = strLmsLoginPath;
	var boolSystemLogin = "";
	var strSystemLoginRedirectUrl = "";
	var strAdminUserName = "";
	var strAdminUserEmail = "";
	var strAdminUserId = "";
	
	$.ajax({ 
			type: "POST",
			url: strLoginAction,
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "failure")
				{
					//return false;
					window.location.reload();
				}
				
				if(data.status == "success")
				{
					boolSystemLogin = "1";
					strSystemLoginRedirectUrl = data.redirecturl;
					strAdminUserName = data.username;
					strAdminUserEmail = data.useremail;
					strAdminUserId = data.userid;
					
				}
			},
			complete: function(xhr, textStatus) 
			{
				if(boolSystemLogin == "1")
				{
					
					fnLoginToJb(strAdminUserName,strAdminUserEmail,strAdminUserId,strSystemLoginRedirectUrl,username,password,strMoodleLoginUrl,utype,strLogoutAction);
				}
			} 
	});
	
	return false;
}

function fnLoginToJb(uname,uemail,uid,strSystemUrl,muname,mpass,murl,usertype,strLogoutUrl)
{
	
	var datastr = "form_param=1&form_upormai="+uemail+"&form_upor="+uid+"&form_uporna="+uname;
	var strResult = "";
	var strMessage = "";
	$.ajax({ 
			type: "POST",
			url: strJAdminLoginUrl,
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				strResult = data.status;
				strMessage = data.message;
			},
			complete: function(xhr, textStatus) 
			{		
						
				if(strResult == "success")
				{
					//window.location.href = appBaseU+'admins/dashboard';
					fnLoginToLMS(muname,mpass,murl,strSystemUrl,"",usertype,strLogoutUrl);
				}
				else
				{
					// code to logout from hc and generate and show error message
					window.location.href = strLogoutUrl;
				}
			} 
	});
}

function fnLoginToLMS(uname,password,strLMSUrl,strSystemUrl,portalid,usertype,strHcLogoutUrl,strJobberTok)
{
	/*alert(uname);
	alert(password);
	alert(strLMSUrl);*/
	var datastr = "";
	
	if(portalid != "")
	{
		datastr = "username="+uname+"&password="+password+"&candidate_portal_request="+portalid;
	}
	else
	{
		if(usertype != "")
		{
			datastr = "username="+uname+"&password="+password+"&usert_type_request="+usertype;
		}
		else
		{
			datastr = "username="+uname+"&password="+password;
		}
		
	}
	
	$.ajax({ 
			type: "POST",
			url: strLMSUrl,
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				// if successfully logged in than redirect other wise
				// logout from hc and jobber
				
				if(data.status == "success")
				{
					fnUpdateLoogedUserSessionData(data.sesskey,portalid,usertype,strSystemUrl,data.hc_lms_token,strJobberTok);
					//window.location.href = strSystemUrl;
				}
				else
				{
					if(usertype == "1")
					{
						// logout from jobber
						var strAdminLogOutResult = fnLogoutAdminFromJobebr();
						if(strAdminLogOutResult == "1")
						{
							// logout from hc
							window.location.href = strHcLogoutUrl;
						}
					}
					else
					{
						if(usertype == "2")
						{
							// logout from jobber
							var strEmployerLogOutResult = fnLogoutAdminFromJobebr();
							if(strEmployerLogOutResult == "1")
							{
								// logout from hc
								window.location.href = strHcLogoutUrl;
							}
						}
						else
						{
							if(usertype == "" && portalid != "0")
							{
								// logout from jobber
								var strSeekerLogOutResult = fnLogoutSeekerFromJobebr(portalid);
								if(strSeekerLogOutResult == "1")
								{
									// logout from hc
									window.location.href = strHcLogoutUrl;
								}
							}
						}
					}
				}
				$('#loginformloader').show();
			}
	});
}

function fnLogoutSeekerFromJobebr(intPortalId)
{
	var strLoggedOut = ""
	var datastr = "logoutaction=1&form_uporie="+intPortalId;
	
	$.ajax({ 
			type: "POST",
			url: strJSeekerLogOutUrl,
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "success")
				{
					strLoggedOut = "1";
				}
			},
			complete: function(xhr, textStatus) 
			{
				if(strLoggedOut != '')
				{
					return "1";
				}
				else
				{
					return "0";
				}
			} 
	});
}

function fnLogoutEmployerFromJobebr()
{
	var strLoggedOut = ""
	var datastrj = "form_param=1";
	
	$.ajax({ 
			type: "POST",
			url: strJobberEmployerLogoutPath,
			data: datastrj,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "success")
				{
					strLoggedOut = "1";
				}
			},
			complete: function(xhr, textStatus) 
			{
				if(strLoggedOut != '')
				{
					return "1";
				}
				else
				{
					return "0";
				}
			} 
	});
}

function fnLogoutAdminFromJobebr()
{
	var strLoggedOut = ""
	var datastr = "logoutaction=1";
	
	$.ajax({ 
			type: "GET",
			url: strJAdminLogOutUrl,
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "success")
				{
					strLoggedOut = "1";
				}
			},
			complete: function(xhr, textStatus) 
			{
				if(strLoggedOut != '')
				{
					return "1";
				}
				else
				{
					return "0";
				}
			} 
	});
}

function fnUpdateLoogedUserSessionData(seskey,portalid,usertype,redirectUrl,strLmsLoginTok,strJobTok)
{	
	//alert(strJobTok);
	//return false;
	var datastr = "";
	datastr = "sesskey="+seskey+"&portid="+portalid+"&utype="+usertype+"&lmst="+strLmsLoginTok+"&jbt="+strJobTok;
	var strPostUrl = "";
	if(portalid != "")
	{
		strPostUrl = appBaseU+"portal/updatesession/"+portalid;
	}
	else
	{
		strPostUrl = appBaseU+"users/updatesession/";
	}
	
	$.ajax({ 
			type: "POST",
			url: strPostUrl,
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				// if successfully logged in than redirect other wise
				// logout from hc and jobber
				
				if(data.status == "success")
				{
					//alert(data.message);
					//alert(seskey);
					//fnUpdateLoogedUserSessionData(data.sesskey,strSystemUrl);
					//alert(redirectUrl);return false;
					window.location.href = redirectUrl;
				}
				else
				{
					//alert(data.message);
				}
			}
	});
}

function fnLogout(strLogoutUrl,strSessKey,strUserEmail)
{
	/*alert(strUserEmail);
	return false;*/
	var datastr = "logoutaction=1";
	var boolSendLogoutRequest = "";
	var strCakeLogOutUrl = strLogoutUrl;
	var sessiokey = strSessKey;
	var strLMSLogoutUrl = strLmsLogoutPath;
	fnLogoutFromJ(strLogoutUrl,sessiokey,strUserEmail);
}

function fnGetMoodleSession(strCakeLogOutUrl)
{
	var datastr = "logoutaction=1";
	$.ajax({ 
			type: "POST",
			url: strLmsSessionPath,
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.id != "0")
				{
					boolSendLogoutRequest = "1";
					sessiokey = "sesskey="+data.sess;
				}
			},
			complete: function(xhr, textStatus) 
			{
				fnLogOutFromLMS(sessiokey,strLmsLogoutPath,strCakeLogOutUrl);
			} 
	});
}

function fnLogoutFromJ(strSystemLogoutUrl,sesskey,strUsermEmai)
{
	/*alert(strJAdminLogOutUrl);
	return false;*/
	
	
	var strLoggedOut = ""
	var datastr = "logoutaction=1";
	var strLoggedOutUserId = "";
	var strLoggedOutUserName = "";
	var strLoggedOutUserEmail = "";
	var strLoggedOutUserDetail = "";
	
	$.ajax({ 
			type: "GET",
			url: strJAdminLogOutUrl,
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "success")
				{
					strLoggedOut = "1";
					strLoggedOutUserId = data.userid;
					strLoggedOutUserName = data.uname;
					strLoggedOutUserEmail = strUsermEmai;
					strLoggedOutUserDetail = strLoggedOutUserId+","+strLoggedOutUserName+","+strLoggedOutUserEmail;
				}
			},
			complete: function(xhr, textStatus) 
			{
				if(strLoggedOut != '')
				{
					//window.location.href = strSystemLogoutUrl;
					//fnGetMoodleSession(strSystemLogoutUrl);
					fnLogOutFromLMS("sesskey="+sesskey+"&usert_type_request=admin",strLmsLogoutPath,strSystemLogoutUrl,strLoggedOutUserDetail,"1");
				}
				else
				{
					// code to not to log out
					return false;
				}
			} 
	});
}


function fnLogOutFromLMS(strLogoutParam,strLogoutUrl,strThisAppLogOutUrl,strLogOutUserDetail,utype)
{
	
	var strLogOutResult = "";
	
	$.ajax({ 
			type: "GET",
			url: "http://"+window.location.hostname+"/moodle/login/logoutlms.php",
			data: strLogoutParam,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "success")
				{
					strLogOutResult = "1";
				}
			},
			complete: function(xhr, textStatus) 
			{
				// check if here logout from lms was successfull or not
				// if not than again log user into jobber and do not logout from hc
				if(strLogOutResult != "")
				{
					//alert(strLogoutParam);
					
					if(utype == "0")
					{
						//alert(strThisAppLogOutUrl);
						//return false;
						
						//alert("Hello");
						var arrUserDetail = strLogOutUserDetail.split(",");
						
						mixpanel.track(arrUserDetail[4], {
									"User Logged Out": "Yes",
									"User Name": arrUserDetail[1],
									"User Id": arrUserDetail[0],
									"User Email": arrUserDetail[2],
						});
						mixpanel.track(arrUserDetail[4]+ " Logged Out Users", {
									"User Logged Out": "Yes",
									"User Name": arrUserDetail[1],
									"User Id": arrUserDetail[0],
									"User Email": arrUserDetail[2],
						});
						//alert("Hello");
					}
					window.location.href = strThisAppLogOutUrl;
				}
				else
				{
					if(utype == "1")
					{
						// call login to jb for admin
						var boolLoginResult = fnLoginAdminToJb(strLogOutUserDetail);
						return false;
					}
					else
					{
						if(utype == "2")
						{
							// call login to jb for employer
							var boolLoginResult = fnLoginEmployerToJb(strLogOutUserDetail);
							return false;
						}
						else
						{
							// call login to jb for seeker
							var boolLoginResult = fnLoginSeekerToJb(strLogOutUserDetail);
							return false;
						}
					}
					
				}
			} 
	});
}

function fnLoginSeekerToJb(strLogOutUserDetail)
{
	var arrLoginUserDetail = "";
	var uid = "";
	var uname = "";
	var uemail = "";
	var portal_id = "";
	
	if(strLogOutUserDetail != "")
	{
		arrLoginUserDetail = strLogOutUserDetail.split(",");
		uid = arrLoginUserDetail[0];
		uname = arrLoginUserDetail[1];
		uemail = arrLoginUserDetail[2];
		portal_id = arrLoginUserDetail[3];
	}
	
	var datastrj = "form_param=1&form_upor="+uid+"&form_upormai="+uemail+"&form_uporna="+uname+"&form_uporie="+portal_id;
	$.ajax({ 
			type: "POST",
			url: strJSeekerLoginUrl,
			data: datastrj,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "failure")
				{
					return "0";
				}
				
				if(data.status == "success")
				{
					return "1";
				}
			}
	});
}

function fnLoginEmployerToJb(strLoginUserDetail)
{
	var arrLoginUserDetail = "";
	var useremail = "";
	var intUserId = "";
	var username = "";
	
	if(strLoginUserDetail != "")
	{
		arrLoginUserDetail = strLoginUserDetail.split(",");
		intUserId = arrLoginUserDetail[0];
		username = arrLoginUserDetail[1];
		useremail = arrLoginUserDetail[2];
	}
	
	var datastrj = "form_param=1&form_upor="+intUserId+"&form_upormai="+useremail+"&form_uporna="+username;
	$.ajax({ 
			type: "POST",
			url: strJobberEmployerLoginPath,
			data: datastrj,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "failure")
				{
					return "0";
				}
				
				if(data.status == "success")
				{
					return "1";
				}
			}
	});
}

function fnLoginAdminToJb(strLoginUserDetail)
{
	var arrLoginUserDetail = "";
	var uemail = "";
	var uid = "";
	var uname = "";
	
	if(strLoginUserDetail != "")
	{
		arrLoginUserDetail = strLoginUserDetail.split(",");
		uid = arrLoginUserDetail[0];
		uname = arrLoginUserDetail[1];
		uemail = arrLoginUserDetail[2];
	}
	var datastr = "form_param=1&form_upormai="+uemail+"&form_upor="+uid+"&form_uporna="+uname;
	var strResult = "";
	var strMessage = "";
	$.ajax({ 
			type: "POST",
			url: strJAdminLoginUrl,
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				strResult = data.status;
				strMessage = data.message;
			},
			complete: function(xhr, textStatus) 
			{			
				if(strResult == "success")
				{
					return "1";
				}
				else
				{
					return "0";
				}
			} 
	});
}

function fnLoginEmployerLoginAs(strLoginAction,strLogoutAction,strUname,strPass)
{
	var username = strUname;
	var password = strPass;
	var utype = "2";
	var datastr = "data[User][user_email]="+username+"&data[User][password]="+password+"&data[User][u_type]="+utype;
	$('#loginformloader').show();
	$.ajax({ 
			type: "POST",
			url: strLoginAction,
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "failure")
				{
					window.location.reload();
				}
				
				if(data.status == "success")
				{
					fnLoginEmployerToJb(data.userid,data.redirecturl,data.username,username,password,utype,strLogoutAction);
				}
			}
	});
	
	return false;
}

function fnLoginEmployer(strLoginAction,strLogoutAction)
{
	var username = $('#UserUserEmail').val();
	var password = $('#UserPassword').val();
	var utype = $('#UserUType').val();
	var datastr = "data[User][user_email]="+username+"&data[User][password]="+password+"&data[User][u_type]="+utype;
	$('#loginformloader').show();
	$.ajax({ 
			type: "POST",
			url: strLoginAction,
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				
				
				if(data.status == "failure")
				{
					//window.location.reload();
					//alert(data.message);
					$('#mssg').html(data.message);
					$('#mssg').show();
					$('#loginformloader').hide();
					//alert(data.message);
				}
				
				if(data.status == "success")
				{
					fnLoginEmployerToJb(data.userid,data.redirecturl,data.username,username,password,utype,strLogoutAction);
				}
			}
	});
	
	return false;
}


function fnLoginEmployerToJb(intUserId, redirecturi,username,useremail,mpassword,usertype,strEmployerLogoutUrl)
{
	/* alert(strEmployerLogoutUrl);
	return false; */
	var datastrj = "form_param=1&form_upor="+intUserId+"&form_upormai="+useremail+"&form_uporna="+username;
	$.ajax({ 
			type: "POST",
			url: strJobberEmployerLoginPath,
			data: datastrj,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "failure")
				{
					window.location.reload();
				}
				
				if(data.status == "success")
				{
					strSystemLoginRedirectUrl = redirecturi;
					//window.location.href = strSystemLoginRedirectUrl;
					fnLoginToLMS(useremail,mpassword,strLmsLoginPath,strSystemLoginRedirectUrl,"",usertype,strEmployerLogoutUrl)
					return false;
				}
				else
				{
					// logout employer from HC
					window.location.href = strEmployerLogoutUrl
				}
			}
	});
}

function fnApplyJob(strJobApplyUrl)
{
	//alert(strJobApplyUrl);
	
	/*var intCandidateId = $('#candidateid').val();
	var intPortalId = $('#portalid').val();
	var intJobId = $('#jobid').val();*/
	
	$.ajax({ 
			type: "POST",
			url: strJobApplyUrl,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				//alert(data.status);
				if(data.status == "success")
				{
					window.location.reload();
				}
				else
				{
					window.location.reload();
				}
			}
	});
}

function fnShowSetReminderForm()
{
	$('#postinterviewsetmessages').text('');
	$('#postinterviewsetmessages').hide();
	$( "#dialog-set-interview-reminder-form" ).dialog( "open" );
}

function fnRedirectToJobBoards(strJobBoardsUri,intPortalId,intUId)
{
	/*alert(strJobBoardsUri);
	alert(intPortalId);*/
	
	var datastrj = "form_param=1&form_por="+intPortalId;
	$.ajax({ 
			type: "POST",
			url: strJobberEmployerSetPortalPath,
			data: datastrj,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "failure")
				{
					window.location.reload();
				}
				
				if(data.status == "success")
				{
					
					window.location.href = strJobBoardsUri;
					return false;
				}
			}
	});
	
	
}

function fnLogoutEmployer(strLogoutUri,strSessKey,strUserEmail)
{
	var strLoggedOutUserId = "";
	var strLoggedOutUserName = "";
	var strLoggedOutUserEmail = "";
	var strLoggedOutUserDetail = "";
	var datastrj = "form_param=1";
	$.ajax({ 
			type: "POST",
			url: strJobberEmployerLogoutPath,
			data: datastrj,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "failure")
				{
					window.location.reload();
				}
				
				if(data.status == "success")
				{
					//window.location.href = strLogoutUri;
					//fnGetMoodleSession(strLogoutUri);
					strLoggedOutUserId = data.userid;
					strLoggedOutUserName = data.uname;
					strLoggedOutUserEmail = strUserEmail;
					strLoggedOutUserDetail = strLoggedOutUserId+","+strLoggedOutUserName+","+strLoggedOutUserEmail;
					
					fnLogOutFromLMS("sesskey="+strSessKey+"&usert_type_request=admin",strLmsLogoutPath,strLogoutUri,strLoggedOutUserDetail,"2");
					
					//return false;
				}
			}
	});
}

function fnLogCandidateLogInLoginAs(strLoginUrl,strLogoutUrl,$intPortalId,$intPortalUser,$intPortalPassword)
{
	//alert(strLoginUrl);
	
	
	var username = $intPortalUser;
	var password = $intPortalPassword;
	var portal = $intPortalId;
	var datastr = "data[PortalUser][email]="+username+"&data[PortalUser][password]="+password+"&data[PortalUser][portal_id]="+portal;
	var strUserName = "";
	var strUserEmail = "";
	var strUserId = "";
	var strUserRedirection = "";
	var strUserPortal = "";
	var boolSystemLogin = "";
	$('#loginformloader').show();
	//alert("hello");
	//return false;
	
	$.ajax({ 
			type: "POST",
			url: strLoginUrl,
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				
				if(data.status == "failure")
				{
					window.location.reload();
				}
				
				if(data.status == "success")
				{
					boolSystemLogin = "1";
					strUserName = data.username;
					strUserEmail = data.useremail;
					strUserId = data.userid;
					strUserRedirection = data.redirecturl;
					strUserPortal = data.userportalid;
					
					//window.location.href = strSystemLoginRedirectUrl;
				}
			},
			complete: function(xhr, textStatus)
			{
				if(boolSystemLogin == "1")
				{
					fnLoginCandidateToJb(strUserName,strUserEmail,strUserId,strUserPortal,strUserRedirection,password,portal,strLogoutUrl);
				}
			}
	});
	return false;
}

function fnLogCandidateLogIn(strLoginUrl,strLogoutUrl)
{
	
	
	
	var username = $('#PortalUserEmail').val();
	var password = $('#PortalUserPassword').val();
	var portal = $('#PortalUserPortalId').val();
	var datastr = "data[PortalUser][email]="+username+"&data[PortalUser][password]="+password+"&data[PortalUser][portal_id]="+portal;
	var strUserName = "";
	var strUserEmail = "";
	var strUserId = "";
	var strUserRedirection = "";
	var strUserPortal = "";
	var boolSystemLogin = "";
	
	$('#loginformloader').show();
	//alert("hello");
	//return false;
		$('.cms-bgloader-mask').show();//show loader mask
	 	    $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: strLoginUrl,
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
					
				if(data.status == "failure")
				{
						$('.cms-bgloader-mask').hide();//hide loader mask
					$('.cms-bgloader').hide(); //hide loading image
					$('#loginerror').html('<div class="alert alert-danger"><a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>Invalid email or password! Please try again.</div>');
					//window.location.reload();
				}
				
				if(data.status == "success")
				{
					boolSystemLogin = "1";
					strUserName = data.username;
					strUserEmail = data.useremail;
					strUserId = data.userid;
					strUserRedirection = data.redirecturl;
					strUserPortal = data.userportalid;
					
					//window.location.href = strSystemLoginRedirectUrl;
				}
			
			},
			complete: function(xhr, textStatus)
			{
				if(boolSystemLogin == "1")
				{
					fnLoginCandidateToJb(strUserName,strUserEmail,strUserId,strUserPortal,strUserRedirection,password,portal,strLogoutUrl);
				}
			}
	});
	return false;
}

function fnLoginCandidateToJb(uname,uemail,uid,portal_id,redirecturi,lmspassword,portalid,strCandidateLogoutUrl)
{
	var datastrj = "form_param=1&form_upor="+uid+"&form_upormai="+uemail+"&form_uporna="+uname+"&form_uporie="+portal_id;
	$.ajax({ 
			type: "POST",
			url: strJSeekerLoginUrl,
			data: datastrj,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "failure")
				{
					window.location.href = strCandidateLogoutUrl;
				}
				
				if(data.status == "success")
				{
					//alert(uemail);
					//alert(lmspassword);
					strSystemUrlToRedirect = redirecturi;
					if(data.st != "")
					{
						strSystemUrlToRedirect = redirecturi;
					}
					
					fnLoginToLMS(uemail,lmspassword,strLmsLoginPath,strSystemUrlToRedirect,portalid,"",strCandidateLogoutUrl,data.st);
					//window.location.href = redirecturi;
					return false;
				}
			}
	});
}

function fnLogoutSeeker(strSeekerLogoutUrl,intPortalId,strSesskey,strUserEmail,strPortalName)
{
	//alert("hi");
	//alert(strSeekerLogoutUrl);return false;
	var strLoggedOut = ""
	var datastr = "logoutaction=1&form_uporie="+intPortalId;
	var strLoggedOutUserId = "";
	var strLoggedOutUserName = "";
	var strLoggedOutUserEmail = "";
	var strLoggedOutUserPortal = "";
	var strLoggedOutUserDetail = "";
	
	$.ajax({ 
			type: "POST",
			url: strJSeekerLogOutUrl+"?portid="+intPortalId,
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "success")
				{
					strLoggedOut = "1";
					strLoggedOutUserId = data.userid;
					strLoggedOutUserName = data.uname;
					strLoggedOutUserEmail = strUserEmail;
					strLoggedOutUserPortal = data.portal;
					strLoggedOutUserDetail = strLoggedOutUserId+","+strLoggedOutUserName+","+strLoggedOutUserEmail+","+strLoggedOutUserPortal+","+strPortalName;
					//alert("hi");
					//return false;
				}
			},
			complete: function(xhr, textStatus) 
			{
				if(strLoggedOut != '')
				{
					//window.location.href = strSeekerLogoutUrl;
					//fnGetMoodleSession(strSeekerLogoutUrl);
					fnLogOutFromLMS("sesskey="+strSesskey+"&candidate_portal_request="+strLoggedOutUserPortal,strLmsLogoutPath,strSeekerLogoutUrl,strLoggedOutUserDetail,"0");
					
				}
			} 
	});
}

function fnLoadJsSteps(ele,intPortid)
{
	var currentprocessiddetail = $(ele).attr('id'); 
	var arrcurrentprocessiddetail = currentprocessiddetail.split("_");
	var strCurrentProcessid = arrcurrentprocessiddetail[1];
	var currentproceessmode = arrcurrentprocessiddetail[0];
	var eleId = arrcurrentprocessiddetail[0]+'detail_'+strCurrentProcessid;
	$('#'+eleId).slideToggle('slow');
	if($('#'+eleId).css('display') == "block")
	{
		
		//alert($('#'+currentproceessmode+"container_"+strCurrentProcessid).html());
		if($('#'+currentproceessmode+"container_"+strCurrentProcessid).html() == '')
		{
			fnGetJobProcessSteps(currentproceessmode,strCurrentProcessid,intPortid);
		}
		else
		{
			if(currentproceessmode == "substeps")
			{
				//$("#substeps_"+strCurrentProcessid).scrollTop()+" px"
				//alert($('#substeps_'+strCurrentProcessid).scrollTop(0));
				//alert($('#substeps_'+strCurrentProcessid).offset().top);
				//$('.pagemask').css('height','1660');
				//$('.pagemask').css('width',$(window).width());
				//$('.pagemask').show();
				var strNewTimeInt = setInterval(function(){ 
					$('html, body').stop().animate({
						scrollTop: $('#substeps_'+strCurrentProcessid).offset().top
					}, 'fast');
					$('.pagemask').hide();
					clearInterval(strNewTimeInt);
				},1000);
			}
		}
	}
}

function fnGetJobProcessSteps(strProcessMode,intProcessModeId,intPortalId)
{
	$('.pagemask').css('height','1660');
	$('.pagemask').css('width',$(window).width());
	$('.pagemask').show();
	
	var strFurtherStepsEle = "steps";
	if(strProcessMode == "phase")
	{
		strFurtherStepsEle = "steps";
	}
	
	if(strProcessMode == "steps")
	{
		strFurtherStepsEle = "substeps";
	}
	
	if(strProcessMode == "substeps")
	{
		strFurtherStepsEle = "content";
	}
	
	$('#'+strProcessMode+"loader_"+intProcessModeId).show();
	//$('#main_loader').show();
	//$('#accordion').hide();
	
	if($('#'+strFurtherStepsEle+'_'+intProcessModeId+'accordion').length>0)
	{
		$('#'+strProcessMode+"loader_"+intProcessModeId).hide();
		//$('#main_loader').show();
		//$('#accordion').hide();
		if(strProcessMode == "substeps")
		{
			//$('.pagemask').hide();
		}
	}
	else
	{
		// get further steps
		//alert("further steps not loaded, we need load further steps");
		//alert(intPortalId);
		//alert(strFurtherStepsEle);
		//alert(intProcessModeId);
		//return false;
		$.ajax({ 
				type: "POST",
				url: strBaseUrl+"jsprocess/jssteps/"+intPortalId+"/"+strFurtherStepsEle+"/"+intProcessModeId,
				cache: false,
				dataType: 'json',
				success: function(data)
				{
					if(data.status == "success")
					{
						$('#'+strProcessMode+"loader_"+intProcessModeId).hide();
						//$('#main_loader').hide();
						//alert(data.jsstepshtml);
						//$('#accordion').show();
						$('#'+strProcessMode+"container_"+intProcessModeId).html(data.jsstepshtml);
						if(strProcessMode == "substeps")
						{
							var strNewTimeInt = setInterval(function(){ 
								var content = $(document).find('#substeps_'+intProcessModeId);
								//alert($(content).offset().top);
								$('html, body').stop().animate({
									scrollTop: $(content).offset().top
								}, 'fast');
								clearInterval(strNewTimeInt);
								$('.pagemask').hide();
							},1000);
						}
						else
						{
							$('.pagemask').hide();
						
						}
					}
					else
					{
						$('#'+strProcessMode+"loader_"+intProcessModeId).hide();
						//$('#main_loader').hide();
						//$('#accordion').show();
						alert(data.message);
					}
				}
		});
	}
}

function fnCompleteThis(strStepDetail)
{
	var strStepDetail = $(strStepDetail).attr('id');
	var arrStepDetail = strStepDetail.split("_");
	var strCriteriaString = $('#completion_criteria_'+arrStepDetail[2]).val();
	var dataStgring = "comcriteria="+strCriteriaString;
	var currentsubstep = arrStepDetail[2];
	var portalid =  arrStepDetail[3];
	
	var nextsubstep = $('#next_substep_'+currentsubstep).val();
	var currentstep  = $('#next_step_'+currentsubstep).val();
	var currentphase  = $('#curr_phase_'+currentsubstep).val();


	$('#'+arrStepDetail[1]+"loader_"+arrStepDetail[2]).show();
	$.ajax({ 
				type: "POST",
				url: strBaseUrl+"jsprocess/completesteps/"+arrStepDetail[3]+"/"+arrStepDetail[0]+"/"+arrStepDetail[1]+"/"+arrStepDetail[2],
				data:dataStgring,
				cache: false,
				dataType: 'json',
				success: function(data)
				{
					if(data.status == "success")
					{
						if(arrStepDetail[0] == "complete")
						{
							
							var strStepDetailIdText = strStepDetail;
							strStepDetailIdText = strStepDetailIdText.replace("complete","incomplete");
							$('.'+strStepDetail).text("Reset this step");
							$('.'+strStepDetail).attr('id',strStepDetailIdText);
							$('.'+strStepDetail).addClass(strStepDetailIdText);
							$('.'+strStepDetail).removeClass(strStepDetail);
							//$('#'+strStepDetail).attr('id',strStepDetailIdText);
							//alert(arrStepDetail[1]);
							//alert($('#substeps_'+arrStepDetail[1]).text());
							if(data.level_ids.length>0)
							{
								var completestep = data.level_ids;
								var steps = completestep.split("|");
								 var step = steps[0];
								 $('#step'+step).find("h3").contents().wrap('<s></s>');
							}
							
							$('#substeps_'+arrStepDetail[2]).addClass('stepcomplete');
							$('#phase-step'+arrStepDetail[2]).find("h3").contents().wrap('<s></s>');
							$('.progress-bar').css('width',data.complete_per+'%');
							$('.sidebar-nav-meter-value span').html(data.complete_per+'%');
							$( "<div class='col-md-3 icon-complete'></div>" ).insertAfter( '#step'+step+' .sidebar-menuitem-content');
							if(data.level_updation == "1")
							{
								var arrLevelType = data.level_type.split("|");
								var arrLevelId = data.level_ids.split("|");
								for(var i=0; i<=arrLevelType.length; i++)
								{
									var strLevelType = arrLevelType[i];
									var strLevelId = arrLevelId[i];
									
									$('#'+strLevelType+"_"+strLevelId).addClass('stepcomplete');
								}
							}
							var completeredirect = strBaseUrl+"jsprocess/"+portalid+"/"+nextsubstep+"/"+currentstep;
							
						}
						
						if(arrStepDetail[0] == "incomplete")
						{
							
							var strStepDetailIdText = strStepDetail;
							strStepDetailIdText = strStepDetailIdText.replace("incomplete","complete");
							$('.'+strStepDetail).text("Complete this step");
							$('.'+strStepDetail).attr('id',strStepDetailIdText);
							$('.'+strStepDetail).addClass(strStepDetailIdText);
							$('.'+strStepDetail).removeClass(strStepDetail);
							
							//alert($('#substeps_'+arrStepDetail[1]).text());
							$('#substeps_'+arrStepDetail[2]).removeClass('stepcomplete');
							$('.progress-bar').css('width',data.complete_per+'%');
							$('.sidebar-nav-meter-value span').html(data.complete_per+'%');
								var step = $('#curr_step_'+arrStepDetail[2]).val();
								
								$('#step'+step).find(".icon-complete").remove();
								$('#step'+step).find("s").contents().unwrap();
							$('#phase-step'+arrStepDetail[2]).find("s").contents().unwrap();
							if(data.level_updation == "1")
							{
								var arrLevelType = data.level_type.split("|");
								var arrLevelId = data.level_ids.split("|");
								for(var i=0; i<=arrLevelType.length; i++)
								{
									var strLevelType = arrLevelType[i];
									var strLevelId = arrLevelId[i];
									
									$('#'+strLevelType+"_"+strLevelId).removeClass('stepcomplete');
								}
							}
							var completeredirect = '';
						}
						
						$('#'+arrStepDetail[1]+"loader_"+arrStepDetail[2]).hide();
						$('#'+arrStepDetail[1]+"message_"+arrStepDetail[2]).html(data.message);
						if(completeredirect!="")
						{
							if($("#substepProducts").val()>0)
							{
								//alert();
								
								$('#addtocart').modal('show');
								$('.modal-backdrop').css({"z-index":"0", "opacity":"0"});
							}
							else
							{
								fnGetSubstepDetail(portalid,nextsubstep,currentstep,currentphase);
							}
						}
						
						
						//window.location.reload();
					}
					else
					{
						$('#'+arrStepDetail[1]+"loader_"+arrStepDetail[2]).hide();
						alert(data.message);
					}
				}
		});
	
}

function fnLoadStep(ele,strAction)
{
	var strEle = $(ele).attr('id');
	arrEle = strEle.split("_");
	var intCurrPhase;
	var intCurrStep;
	var intCurrsubstep;
	intCurrPhase = $('#curr_phase_'+arrEle[2]).val();
	intCurrStep = $('#curr_step_'+arrEle[2]).val();
	intCurrsubstep = $('#curr_substep_'+arrEle[2]).val();
	
	
	$('.Phase').css('display','none');
	$('.Steps').css('display','none');
	$('.Substeps').css('display','none');
	
	$('.pagemask').css('height','1660');
	$('.pagemask').css('width',$(window).width());
	$('.pagemask').show();

	if(strAction == "next")
	{
		var intNextPhase;
		
		var intNextStep;
		var intNextsubstep;

		intNextPhase = $('#next_phase_'+arrEle[2]).val();
		alert(intNextPhase);
		intNextStep = $('#next_step_'+arrEle[2]).val();
		intNextSubstep = $('#next_substep_'+arrEle[2]).val();

		var strPhaseOpened = $('#phasedetail_'+intNextPhase).css('display');
		var strStepOpened = $('#stepsdetail_'+intNextStep).css('display');
		var strSubStepOpened = $('#substepsdetail_'+intNextStep).css('display');
		
		if(strPhaseOpened != "block")
		{
			if(($('#phase_'+intNextPhase)).length>0)
			{
				$('#phase_'+intNextPhase).click();
			}
			else
			{
				var strNewPTimeInt = setInterval(function(){ 
					$('#steps_'+intNextStep).click();
					clearInterval(strNewPTimeInt);
				},3000);
			}
			
		}
		
		if(strStepOpened != "block")
		{
			if($('#steps_'+intNextStep).length>0)
			{
				$('#steps_'+intNextStep).click();
			}
			else
			{
				var strTimeInt = setInterval(function(){ 
					$('#steps_'+intNextStep).click();
					clearInterval(strTimeInt);
				},4000);
			}
		}
		
		if(strSubStepOpened != "block")
		{
			if($('#substeps_'+intNextSubstep).length>0)
			{
				$('#substeps_'+intNextSubstep).click();
			}
			else
			{
				var strNewTimeInt = setInterval(function(){ 
					$('#substeps_'+intNextSubstep).click();
					clearInterval(strNewTimeInt);
				},4000);
			}
		}
	}
	
	if(strAction == "prev")
	{
		var intPrevPhase;
		var intPrevStep;
		var intPrevsubstep;
		
		intPrevPhase = $('#previous_phase_'+arrEle[2]).val();
		intPrevStep = $('#previous_step_'+arrEle[2]).val();
		intPrevSubstep = $('#previous_substep_'+arrEle[2]).val();
		
		var strPhaseOpened = $('#phasedetail_'+intPrevPhase).css('display');
		var strStepOpened = $('#stepsdetail_'+intPrevStep).css('display');
		var strSubStepOpened = $('#substepsdetail_'+intPrevSubstep).css('display');
		if(strPhaseOpened != "block")
		{
			if($('#phase_'+intPrevPhase).length>0)
			{
				$('#phase_'+intPrevPhase).click();
			}
			else
			{
				var strNewPTimeInt = setInterval(function(){ 
					$('#phase_'+intPrevPhase).click();
					clearInterval(strNewPTimeInt);
				},3000);
			}
		}
		
		if(strStepOpened != "block")
		{
			if($('#steps_'+intPrevStep).length>0)
			{
				$('#steps_'+intPrevStep).click();
			}
			else
			{
				var strTimeInt = setInterval(function(){ 
					$('#steps_'+intPrevStep).click();
					clearInterval(strTimeInt);
				},4000);
			}
			
		}
		
		if(strSubStepOpened != "block")
		{
			if($('#substeps_'+intPrevSubstep).length>0)
			{
				$('#substeps_'+intPrevSubstep).click();
			}
			else
			{
				var strNewTimeInt = setInterval(function(){ 
					$('#substeps_'+intPrevSubstep).click();
					clearInterval(strNewTimeInt);
				},4000);
			}
		}
		
	}
	
	//alert(strAction);
	return false;
}

function fnGetEmpContent(intContId,intPortalId)
{
	if(intPortalId == "")
	{
		intPortalId = "0";
	}
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"privatelabelsites/getcontent/"+intPortalId+"/"+intContId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				//alert(data.status);
				if(data.status == "success")
				{
					$('#maincontloader_'+intContId).hide();
					$('#content_data'+intContId).html('');
					$('#content_data'+intContId).html(data.content);
				}
				else
				{
					alert("fail");
				}
			}
	});
}

function fnGetContentWebinars(portalid,catid,strContentType,intNewTab,strLoaderEle)
{
	if(portalid == "")
	{
		portalid = "0";
	}
	
	$('#content_cat_form').hide();
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"privatelabelsites/libcatwebdetail/"+portalid+"/"+catid+"/"+strContentType+"/"+intNewTab,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				alert(data.status);
				if(data.status == "success")
				{
					if(strLoaderEle != "")
					{
						$('#'+strLoaderEle).hide();
					}
					else
					{
						$('#contenthtmlloader'+strContentType).hide();
					}
					$('#content_html'+strContentType).html(data.content);
					
				}
				else
				{
					alert("fail");
				}
				$('#content_html'+strContentType).show();
			}
	});
}

function fnDeleteContact(ele,detailmode)
{
	
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#delete_for').val(arrElementId[2]);
	if(detailmode == "1")
	{
		$('#detailmode').val(detailmode);
	}
	fnDeleteProduct(arrElementId[2]);
	//$('#confirm_delete').dialog("open");
}

function fnDeletejob(ele,detailmode)
{
	
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#delete_for').val(arrElementId[2]);
	if(detailmode == "1")
	{
		$('#detailmode').val(detailmode);
	}
	fnDeletelatestjob(arrElementId[2]);
	//$('#confirm_delete').dialog("open");
}

function fnSendPassNot(ele)
{
	
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#pass_for').val(arrElementId[2]);
	//deleteVendor(arrElementId[2]);
	//$('#confirm_delete').dialog("open");
	$("#password_confirm_vendor").modal('show');
}

function fnDeleteVendor(ele)
{
	
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#vendor_del_').val(arrElementId[2]);
	$('#delete_for').val(arrElementId[2]);
	//deleteVendor(arrElementId[2]);
	//$('#confirm_delete').dialog("open");
	$("#confirm_delete_vendor").modal('show');
}
function fnDeleteResource(ele)
{
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#delete_for').val(arrElementId[2]);

	deleteResource(arrElementId[2]);
}
function fnJobStatus(ele)
{
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#delete_for').val(arrElementId[2]);

	fnChangeJobStatus(arrElementId[2]);
}
function fnChangePortalStatus(ele)
{
	
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	
	fnchangeportalstatus(arrElementId[2]);
	
}


function fnDeletelatestjob(intJobId)
{
	
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"joblisting/deletejob/"+intJobId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.message').remove();
					$('#successmessage').html(data.message);
					$('#content_'+intProductId).remove();
					$('#product_list_'+intProductId).remove();
					$('#str'+intProductId).remove();
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
				}
				else
				{
					$('.tabloader').hide();
					$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
					$('#contacts_container').show();
				}
			}
	});
}

function fnChangeJobStatus(intJobId)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"joblisting/changeJobStatus/"+intJobId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					
					var txttext =$('#content_status_'+intJobId).text();
					if(txttext=="Active")
					{
						$('#content_status_'+intJobId).text('Not active');
						$('#job_status_'+intJobId).text('Not active');
						
					}
					else
					{
						$('#content_status_'+intJobId).text('Active');
						$('#job_status_'+intJobId).text('Active');
					}
					
					$('#successmessage').html(data.message);
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
				}
				else
				{
					$('.tabloader').hide();
					$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
					$('#contacts_container').show();
				}
			}
	});
}
function deleteResource(intResourceId)
{
	$('.tabloader').show();
	$('#contacts_container').hide();
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"resource/productdelete/"+intResourceId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('.message').remove();
				
						$('.resourcetab').prepend(data.message);
						
						$('#product_list_'+intResourceId).remove();
						$('#str'+intResourceId).remove();
						
					
				}
				else
				{
					$('.tabloader').hide();
					$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
					$('#contacts_container').show();
				}
			}
	});
}

function sendPassNotification(intVendorId)
{
	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show(); //show loading image
	$('#contacts_container').hide();
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"vendors/sendpassnotification/"+intVendorId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					$('.message').remove();
				
						$('#product_notification').prepend(data.message);
						
					
				}
				else
				{
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					$('#product_notification').prepend(data.message);
				}
			}
	});
	
}

function deleteVendor(intVendorId)
{
	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show(); //show loading image
	$('#contacts_container').hide();
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"vendors/productdelete/"+intVendorId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					$('.message').remove();
				
						$('.resourcetab').prepend(data.message);
						
						$('#product_list_'+intVendorId).remove();
						$('#str'+intVendorId).remove();
						$('#str'+intVendorId).remove();
						
					
				}
				else
				{
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
					$('#contacts_container').show();
				}
			}
	});
}

function fnEmailTemplate(ele)
{
	
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#vendor_del_').val(arrElementId[2]);
	
	fnDeleteEmailTemplate(arrElementId[2]);
	//$('#confirm_delete').dialog("open");
}

function fnDeleteEmailTemplate(templateId)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"email/templatedelete/"+templateId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.cms-bgloader-mask').hide();//hide loader mask
	 	  $('.cms-bgloader').hide(); //hide loading image
			
				
						$('#strTemplatemessage').html(data.message);
						
						$('#product_list_'+templateId).remove();
						$('#str'+templateId).remove();
						
					
				}
				else
				{
					$('.tabloader').hide();
					$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
					$('#contacts_container').show();
				}
			}
	});
}


function fnDeleteAppointmentNew(ele,detailmode)
{
	
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#delete_for').val(arrElementId[2]);
	if(detailmode == "1")
	{
		$('#detailmode').val(detailmode);
	}
	fnDeleteAppointment(arrElementId[2]);
	//$('#confirm_delete').dialog("open");
}

function fnDeleteTask(ele,detailmode)
{
	
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#delete_for').val(arrElementId[2]);
	if(detailmode == "1")
	{
		$('#detailmode').val(detailmode);
	}
	fnDeleteTasks(arrElementId[2]);
	//$('#confirm_delete').dialog("open");
}


function fnDeleteNoteNew(ele,detailmode)
{
	
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#delete_for').val(arrElementId[2]);
	if(detailmode == "1")
	{
		$('#detailmode').val(detailmode);
	}

	fnDeleteNotes(arrElementId[2]);
	//$('#confirm_delete').dialog("open");
}

function fnDeleteRefrence(ele,detailmode)
{
	
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#delete_for').val(arrElementId[2]);
	if(detailmode == "1")
	{
		$('#detailmode').val(detailmode);
	}

	fnDeleteRefrences(arrElementId[2]);
	//$('#confirm_delete').dialog("open");
}
function fnDeleteContent(ele)
{
	
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	
	deleteContent(arrElementId[2]);
	
}

function fnchanagecontentstatus(ele)
{
	
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	
	fnChangeContentStatus(arrElementId[2]);
	
}



function fnDeleteServiceImage(ele)
{
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	
	deleteServiceImage(arrElementId[2]);
}

function deleteServiceImage(intProductId)
{
	$('.tabloader').show();
	$('#contacts_container').hide();
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"resource/serviceimagedelete/"+intProductId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('.message').remove();
				
						$('#contacts_container').prepend('<div class="message" >'+data.message+'</div>');
						$('#product_list_'+intProductId).remove();
						$('#str'+intProductId).remove();
						$('#contacts_container').show();
					
				}
				else
				{
					$('.tabloader').hide();
					$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
					$('#contacts_container').show();
				}
			}
	});
}

function fnDeletevendorServiceProduct(intProductId)

{
	

	$.ajax({ 

			type: "GET",

			url: strBaseUrl+"vendorservices/productdelete/"+intProductId,

			dataType: 'json',

			data:"",

			cache:false,

			success: function(data)

			{

				if(data.status == "success")

				{

					//alert(data.content)

					//$('.tabloader').hide();

					$('#product_list_notification').html(data.message);

					$('#product_list_'+intProductId).remove();

				}

				else

				{

					$('#product_list_notification').html(data.message);

				}

			}

	});

}
function fnReassignServiceProduct(intProductId)
{
	
	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show();
	$.ajax({ 

			type: "GET",

			url: strBaseUrl+"vendorservices/vendorReassignProduct/"+intProductId,

			dataType: 'html',

			data:"",

			cache:false,

			success: function(data)

			{

				if(data != '')

				{

					//alert(data.content)

					//$('.tabloader').hide();
					$('#myModal'+intProductId).modal('show');
					$('#model'+intProductId).html(data);

					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide();

				}

				else

				{

					$('#product_list_notification').html("No Steps Found");
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide();

				}

			}

	});

}
function fnChangevendorServiceProductStatus(intProductId)
{
	
	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show(); //show loading image
	$.ajax({ 

			type: "GET",

			url: strBaseUrl+"vendorservices/changeVendorServiceStatus/"+intProductId,

			dataType: 'json',

			data:"",

			cache:false,

			success: function(data)

			{

				if(data.status == "success")

				{

					//alert(data.content)

					//$('.tabloader').hide();
					
					$('#status_'+intProductId).html(data.newactstatus);
					$('#status_col_'+intProductId).html(data.newstatus);

					$('#product_list_notification').html(data.message);

					//$('#product_list_'+intProductId).remove();

				}

				else

				{

					$('#product_list_notification').html(data.message);

				}
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image

			}

	});

}


function fnDeleteContentCategories(intProductId)

{
	

	$.ajax({ 

			type: "GET",

			url: strBaseUrl+"contentcategories/productdelete/"+intProductId,

			dataType: 'json',

			data:"",

			cache:false,

			success: function(data)

			{

				if(data.status == "success")

				{

					//alert(data.content)

					//$('.tabloader').hide();

					$('#product_list_notification').html(data.message);

					$('#product_list_'+intProductId).remove();

				}

				else

				{

					$('#product_list_notification').html(data.message);

				}

			}

	});

}


function deleteContent(intProductId)
{
	$('#note_loader_'+intProductId).show();
	$('#note_'+intProductId).hide();
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"content/productdelete/"+intProductId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.message').remove();
					$('#content_'+intProductId).remove();
					$('#product_list_'+intProductId).remove();
					$('#str'+intProductId).remove();
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
				}
				else
				{
					$('.tabloader').hide();
					$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
					$('#contacts_container').show();
				}
			}
	});
}


function fnChangeContentStatus(intProductId)
{
	$('#note_loader_'+intProductId).show();
	$('#note_'+intProductId).hide();
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"content/changeProductStatus/"+intProductId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.message').remove();
					//$('#content_'+intProductId).remove();
				//	$('#product_list_'+intProductId).remove();
					//$('#str'+intProductId).remove();
					if($('#status_'+intProductId).html()=="Active")
					{
						$('#status_'+intProductId).html('Inactive');
					}
					else
					{
						$('#status_'+intProductId).html('Active');
					}
					
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
				}
				else
				{
					$('.tabloader').hide();
					$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
					$('#contacts_container').show();
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
				}
			}
	});
}

function fnDeleteNote(intProductId)
{
	$('#note_loader_'+intProductId).show();
	$('#note_'+intProductId).hide();
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"jstappointments/delnote/"+$('#portal_id').val()+'/'+intProductId+'/',
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.message').remove();
					$('#note_'+intProductId).remove();
					$('#note_loader_'+intProductId).remove();
				}
				else
				{
					$('.tabloader').hide();
					$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
					$('#contacts_container').show();
				}
			}
	});
}

function fnDeleteTasks(intProductId)
{
	$('.tabloader').show();
	$('#contacts_container').hide();
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"jsttasks/delcontact/"+$('#portal_id').val()+'/'+intProductId+'/'+0,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('.message').remove();
					if(data.detailmode == "1")
					{
						window.location = strBaseUrl+"jsttasks/index/"+$('#portal_id').val();
					}
					else
					{
						
						$('#contacts_container').prepend('<div class="message" style="float:left;width:100%;color:green;">'+data.message+'</div>');
						if(data.alldeleted === false)
						{
							$('#contacts_container').prepend('<div class="message" style="float:left;width:100%;color:#000;">You dont have any tasks, Please add one</div>');
						}
						$('#task_'+intProductId).remove();
						$('#str'+intProductId).remove();
						$('#contacts_container').show();
					}
				}
				else
				{
					$('.tabloader').hide();
					$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
					$('#contacts_container').show();
				}
			}
	});
}

function fnDeleteNotes(intProductId)
{
	$('.tabloader').show();
	$('#contacts_container').hide();
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"jstnote/delcontact/"+$('#portal_id').val()+'/'+intProductId+'/'+0,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('.message').remove();
				
						$('#contacts_container').prepend('<div class="message" style="float:left;width:100%;color:green;">'+data.message+'</div>');
						if(data.alldeleted === false)
						{
							$('#contacts_container').prepend('<div class="message" style="float:left;width:100%;color:#000;">You dont have any Notes, Please add one</div>');
						}
						$('#note_'+intProductId).remove();
						$('#contacts_container').show();
					
				}
				else
				{
					$('.tabloader').hide();
					$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
					$('#contacts_container').show();
				}
			}
	});
}

function fnDeleteRefrences(intProductId)
{
	$('.tabloader').show();
	$('#contacts_container').hide();
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"references/removeref/"+$('#portal_id').val()+'/'+intProductId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				
				if(data.delstatus == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('.message').remove();
				
						$('#contacts_container').prepend('<div class="message" style="float:left;width:100%;color:green;">'+data.message+'</div>');
						if(data.alldeleted === false)
						{
							$('#contacts_container').prepend('<div class="message" style="float:left;width:100%;color:#000;">You dont have any Notes, Please add one</div>');
						}
						$('#ref_row_'+intProductId).remove();
						$('#contacts_container').show();
					
				}
				else
				{
					$('.tabloader').hide();
					$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
					$('#contacts_container').show();
				}
			}
	});
}



function fnDeleteAppointment(intProductId)
{
	$('.tabloader').show();
	$('#contacts_container').hide();
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"jstappointments/delAppointMent/"+$('#portal_id').val()+'/'+intProductId+'/0',
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('.message').remove();
					if(data.detailmode == "1")
					{
						window.location = strBaseUrl+"jstcontacts/index/"+$('#portal_id').val();
					}
					else
					{
					
						$('#contacts_container').prepend('<div class="message" style="float:left;width:100%;color:green;">'+data.message+'</div>');
						if(data.alldeleted == "1")
						{
							$('#contacts_container').prepend('<div class="message" style="float:left;width:100%;color:#000;">You dont have any contacts in your list, Please add one</div>');
						}
						$('#appointment_'+intProductId).remove();
						$('#contacts_container').show();
					}
				}
				else
				{
					$('.tabloader').hide();
					$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
					$('#contacts_container').show();
				}
			}
	});
}


function fnDeleteProduct(intProductId)
{
	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show(); //show loading image
	
	$('#contacts_container').hide();
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"jstcontacts/delcontact/"+$('#portal_id').val()+'/'+intProductId+'/'+$('#detailmode').val(),
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					$('.message').remove();
					if(data.detailmode == "1")
					{
						window.location = strBaseUrl+"jstcontacts/index/"+$('#portal_id').val();
					}
					else
					{
						$('#contacts_container').prepend('<div class="message" style="float:left;width:100%;color:green;">'+data.message+'</div>');
						if(data.alldeleted == "1")
						{
							$('#contacts_container').prepend('<div class="message" style="float:left;width:100%;color:#000;">You dont have any contacts in your list, Please add one</div>');
						}
						$('#contact_'+intProductId).remove();
						$('#contacts_container').show();
					}
				}
				else
				{
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
					$('#contacts_container').show();
				}
			}
	});
}

function fnGetContactDetail(ele,detailmode)
{
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#deteailmode').val(detailmode);
	$('#form_loader_mask').show();
	$('#add_model_loader').show();
	$('#contact_add_form').hide();
	//$('#add_contact').dialog("open");
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"jstcontacts/getcontact/"+$('#portal_id').val()+'/'+arrElementId[2],
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
				//	alert(data.contacthtml)
					$('#tab-contacts').html(data.contacthtml);
					
					/*$('#add_model_loader').hide();
					$('#contact_add_form').show();
					$('#contactid').val(data.contact.JstContacts.jstcontacts_id);
					$('#c_f_name').val(data.contact.JstContacts.jstcontacts_fname);
					$('#c_l_name').val(data.contact.JstContacts.jstcontacts_lname);
					$('#comp_name').val(data.contact.JstContacts.jstcontacts_cname);
					$('#c_job_title').val(data.contact.JstContacts.jstcontacts_jtitle);
					$('#c_person_type').val(data.contact.JstContacts.jstcontacts_ptype);
					$('#address1').val(data.contact.JstContacts.jstcontacts_address);
					$('#address2').val(data.contact.JstContacts.jstcontacts_address2);
					$('#UserZipcode').val(data.contact.JstContacts.jstcontacts_postalcode);
					$('#UserCountry').val(data.contact.JstContacts.jstcontacts_country);
					$('#UserCountry').change();
					$('#c_ph1_no').val(data.contact.JstContacts.jstcontacts_phone1);
					$('#c_ph1_type').val(data.contact.JstContacts.jstcontacts_phonetype1);
					$('#c_ph2_no').val(data.contact.JstContacts.jstcontacts_phone2);
					$('#c_ph2_type').val(data.contact.JstContacts.jstcontacts_phonetype2);
					$('#c_fax').val(data.contact.JstContacts.jstcontacts_fax);
					$('#c_email').val(data.contact.JstContacts.jstcontacts_emailaddress);
					$('#c_website').val(data.contact.JstContacts.jstcontacts_website);
					$('#c_twitter').val(data.contact.JstContacts.jstcontacts_twitterid);
					$('#c_facebook').val(data.contact.JstContacts.jstcontacts_fbid);
					var intTimeInt = setInterval(function(){
							$('#UserState').val(data.contact.JstContacts.jstcontacts_state);
							if($('#UserState').val() == data.contact.JstContacts.jstcontacts_state)
							{
								$('#UserState').change();
								clearInterval(intTimeInt);
							}
					},3000);
					var intTimeCityInt = setInterval(function(){
							$('#UserCity').val(data.contact.JstContacts.jstcontacts_city);
							if($('#UserCity').val() == data.contact.JstContacts.jstcontacts_city)
							{
								clearInterval(intTimeCityInt);
								$('#form_loader_mask').hide();
							}
					},3000);*/
				}
				else
				{
					$('#add_model_loader').hide();
					$('#contact_add_form').show();
				}
			}
	});
}

function fnGetAppointmentDetailFromCal()
{
	var strElementId = $('#apptid').val();
	var portid = $('#portal_id').val();
	
	//$('#deteailmode').val(detailmode);
	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show(); //show loading image
	//$('#add_contact').dialog("open");
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"jstappointments/getappt/"+$('#portal_id').val()+'/'+strElementId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					
					$('#tab-appointments').html("");
					$('#tab-calendar').html(data.contacthtml);
				}
				else
				{
					//$('#add_model_loader').hide();
					//$('#appointment_add_form').show();
				}
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
			}
	});
}

function fnGetAppointmentDetail(ele,detailmode)
{
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#deteailmode').val(detailmode);
	$('#form_loader_mask').show();
	$('#add_model_loader').show();
	$('#contact_add_form').hide();
	//$('#add_contact').dialog("open");
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"jstappointments/getappt/"+$('#portal_id').val()+'/'+arrElementId[2],
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					
					$('#tab-appointments').html(data.contacthtml);
					
					/*$('#add_model_loader').hide();
					$('#contact_add_form').show();
					$('#contactid').val(data.contact.JstContacts.jstcontacts_id);
					$('#c_f_name').val(data.contact.JstContacts.jstcontacts_fname);
					$('#c_l_name').val(data.contact.JstContacts.jstcontacts_lname);
					$('#comp_name').val(data.contact.JstContacts.jstcontacts_cname);
					$('#c_job_title').val(data.contact.JstContacts.jstcontacts_jtitle);
					$('#c_person_type').val(data.contact.JstContacts.jstcontacts_ptype);
					$('#address1').val(data.contact.JstContacts.jstcontacts_address);
					$('#address2').val(data.contact.JstContacts.jstcontacts_address2);
					$('#UserZipcode').val(data.contact.JstContacts.jstcontacts_postalcode);
					$('#UserCountry').val(data.contact.JstContacts.jstcontacts_country);
					$('#UserCountry').change();
					$('#c_ph1_no').val(data.contact.JstContacts.jstcontacts_phone1);
					$('#c_ph1_type').val(data.contact.JstContacts.jstcontacts_phonetype1);
					$('#c_ph2_no').val(data.contact.JstContacts.jstcontacts_phone2);
					$('#c_ph2_type').val(data.contact.JstContacts.jstcontacts_phonetype2);
					$('#c_fax').val(data.contact.JstContacts.jstcontacts_fax);
					$('#c_email').val(data.contact.JstContacts.jstcontacts_emailaddress);
					$('#c_website').val(data.contact.JstContacts.jstcontacts_website);
					$('#c_twitter').val(data.contact.JstContacts.jstcontacts_twitterid);
					$('#c_facebook').val(data.contact.JstContacts.jstcontacts_fbid);
					var intTimeInt = setInterval(function(){
							$('#UserState').val(data.contact.JstContacts.jstcontacts_state);
							if($('#UserState').val() == data.contact.JstContacts.jstcontacts_state)
							{
								$('#UserState').change();
								clearInterval(intTimeInt);
							}
					},3000);
					var intTimeCityInt = setInterval(function(){
							$('#UserCity').val(data.contact.JstContacts.jstcontacts_city);
							if($('#UserCity').val() == data.contact.JstContacts.jstcontacts_city)
							{
								clearInterval(intTimeCityInt);
								$('#form_loader_mask').hide();
							}
					},3000);*/
				}
				else
				{
					$('#add_model_loader').hide();
					$('#appointment_add_form').show();
				}
			}
	});
}


function fnGetTaskDetail(ele,detailmode)
{
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#deteailmode').val(detailmode);
	$('#form_loader_mask').show();
	$('#add_model_loader').show();
	$('#task_add_form').hide();
	//$('#add_contact').dialog("open");
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"jsttasks/getTask/"+$('#portal_id').val()+'/'+arrElementId[2],
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					
					$('#tab-tasks').html(data.contacthtml);
					
				
				}
				else
				{
					$('#add_model_loader').hide();
					$('#appointment_add_form').show();
				}
			}
	});
}

function fnGetNoteDetail(ele,detailmode)
{
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#deteailmode').val(detailmode);
	$('#form_loader_mask').show();
	$('#add_model_loader').show();
	$('#task_add_form').hide();
	//$('#add_contact').dialog("open");
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"jstnote/getNote/"+$('#portal_id').val()+'/'+arrElementId[2],
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					
					$('#tab-notes').html(data.contacthtml);
					
				
				}
				else
				{
					$('#add_model_loader').hide();
					$('#appointment_add_form').show();
				}
			}
	});
}

function fnGetRefrencesDetail(ele,detailmode)
{
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	$('#deteailmode').val(detailmode);
	$('#form_loader_mask').show();
	$('#add_model_loader').show();
	$('#task_add_form').hide();
	//$('#add_contact').dialog("open");
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"references/getReference/"+$('#portal_id').val()+'/'+arrElementId[2],
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					
					$('#tab-references').html(data.contacthtml);
					
				
				}
				else
				{
					$('#add_model_loader').hide();
					$('#appointment_add_form').show();
				}
			}
	});
}

function fnLoadAppointMentNotes(intApptId,strPortId,type)
{
	var strType = "appointments";
	if(type != "")
	{
		strType = type;
	}
	
	$('#detail_notes_loader').show();
	$('#detail_notes').hide();
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"jstappointments/appointmentsnotes/"+strPortId+'/'+intApptId+"/"+strType,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					$('#detail_notes_loader').hide();
					$('#detail_notes').show();
					$('#detail_notes').html('');
					$('#detail_notes').html(data.noteshtml);
				}
				else
				{
					$('#detail_notes_loader').hide();
					$('#detail_notes').show();
				}
			}
	});
}

function fnGotToStep(ele)
{

	//alert($(ele).attr('class'));
	var intCurrStep = $('#currentstep').val();
	var strAttrDetail = $(ele).attr('class');
	arrAttrDetail = strAttrDetail.split(" ");
	var strStepDetail = arrAttrDetail[1];
	arrStepDetail = strStepDetail.split("_");
	var strStepNo = arrStepDetail[1];
	var intPortalId = $('#portal_id').val();
	var intMode = $(ele).hasClass('moveto');
	var datastr = "";
	var intGoToTracker = $(ele).hasClass('trackertool');
	if(intGoToTracker == true)
	{
		window.location.href = strBaseUrl+"jstracker/index/"+intPortalId+'/';
	}
	else
	{
		if(arrStepDetail[2] != "")
		{
			datastr = "tabs="+arrStepDetail[2];
		}
		if(intMode === true)
		{
			var strParentEleId = $(ele).parents('.processstepcontainer').attr('id');
			var arrCurrentStepDetail = strParentEleId.split("_");
			var strCurrentStepId = arrCurrentStepDetail[4];
			if(datastr != "")
			{
				datastr = "&currstep="+strCurrentStepId;
			}
			else
			{
				datastr = "currstep="+strCurrentStepId;
			}
		}
		
		
		$('.pagemask').css('height','1660');
		$('.pagemask').css('width',$(window).width());
		$('.pagemask').show();
		
		$.ajax({ 
						type: "POST",
						url: strBaseUrl+"jsprocess/getstepsancestors/"+intPortalId+'/'+strStepNo,
						dataType: 'json',
						data:datastr,
						cache:false,
						success: function(data)
						{
							if(data.status == "success")
							{
								var arrNavidetail = data.returnstring.split("_");
								$strUrlToGo = strBaseUrl+"jsprocess/substep/"+intPortalId+"/"+arrNavidetail[2]+"/"+arrNavidetail[1]+"/"+arrNavidetail[0]+"/"+intCurrStep;
								window.location.href = $strUrlToGo;
							}
							else
							{
							
							}
							
							/*if(data.status == "success")
							{
								
								var intNextPhase;
								var intNextStep;
								var intNextsubstep;
								
								var arrNavidetail = data.returnstring.split("_");

								intNextPhase = arrNavidetail[0];
								intNextStep = arrNavidetail[1];
								intNextSubstep = arrNavidetail[2];
								
								
								var strPhaseOpened = $('#phasedetail_'+intNextPhase).css('display');
								var strStepOpened = $('#stepsdetail_'+intNextStep).css('display');
								var strSubStepOpened = $('#substepsdetail_'+intNextSubstep).css('display');
								
								if(strPhaseOpened != "block")
								{
									if(($('#phase_'+intNextPhase)).length>0)
									{
										$('#phase_'+intNextPhase).click();
									}
									else
									{
										var strNewPTimeInt = setInterval(function(){ 
											$('#steps_'+intNextStep).click();
											clearInterval(strNewPTimeInt);
										},3000);
									}
									
								}
								
								if(strStepOpened != "block")
								{
									if($('#steps_'+intNextStep).length>0)
									{
										$('#steps_'+intNextStep).click();
									}
									else
									{
										var strTimeInt = setInterval(function(){ 
											$('#steps_'+intNextStep).click();
											clearInterval(strTimeInt);
										},4000);
									}
								}
								
								if(strSubStepOpened != "block")
								{
									if($('#substeps_'+intNextSubstep).length>0)
									{
										$('#substeps_'+intNextSubstep).click();
										if(arrStepDetail.length > 2)
										{
											if($('#tabs_'+intNextSubstep).length>0)
											{
												var nstringold = arrStepDetail[2].charAt(0);
												var nstring = arrStepDetail[2].charAt(0).toUpperCase();
												arrStepDetail[2] = arrStepDetail[2].replace(nstringold,nstring);
												var eleString = '.'+arrStepDetail[2]+"_"+intNextSubstep;
												var index = $(eleString).index();
												
												$("#tabs_"+intNextSubstep).tabs("option", "active", index);
											}
											else
											{
												var strNewTabTimeInt = setInterval(function(){ 
													var nstringold = arrStepDetail[2].charAt(0);
													var nstring = arrStepDetail[2].charAt(0).toUpperCase();
													arrStepDetail[2] = arrStepDetail[2].replace(nstringold,nstring);
													var eleString = '.'+arrStepDetail[2]+"_"+intNextSubstep;
													var index = $(eleString).index();
													$("#tabs_"+intNextSubstep).tabs("option", "active", index);
													clearInterval(strNewTabTimeInt);
												},6000);
											}
										}
									}
									else
									{	
										var strNewTimeInt = setInterval(function(){ 
											$('#substeps_'+intNextSubstep).click();
											clearInterval(strNewTimeInt);
										},4000);
										if(arrStepDetail.length > 2)
										{
											if($('#tabs_'+intNextSubstep).length>0)
											{
												var nstringold = arrStepDetail[2].charAt(0);
												var nstring = arrStepDetail[2].charAt(0).toUpperCase();
												arrStepDetail[2] = arrStepDetail[2].replace(nstringold,nstring);
												var eleString = '.'+arrStepDetail[2]+"_"+intNextSubstep;
												var index = $(eleString).index();
												
												$("#tabs_"+intNextSubstep).tabs("option", "active", index);
											}
											else
											{
												var strNewTabTimeInt = setInterval(function(){ 
													var nstringold = arrStepDetail[2].charAt(0);
													var nstring = arrStepDetail[2].charAt(0).toUpperCase();
													arrStepDetail[2] = arrStepDetail[2].replace(nstringold,nstring);
													var eleString = '.'+arrStepDetail[2]+"_"+intNextSubstep;
													var index = $(eleString).index();
													$("#tabs_"+intNextSubstep).tabs("option", "active", index);
													clearInterval(strNewTabTimeInt);
												},6000);
											}
										}
										
									}
								}
								else
								{
									if(arrStepDetail.length > 2)
									{
										var nstringold = arrStepDetail[2].charAt(0);
										var nstring = arrStepDetail[2].charAt(0).toUpperCase();
										arrStepDetail[2] = arrStepDetail[2].replace(nstringold,nstring);
										var eleString = '.'+arrStepDetail[2]+"_"+intNextSubstep;
										var index = $(eleString).index();
										
										$("#tabs_"+intNextSubstep).tabs("option", "active", index);
									}
									
									if($(ele).text() == "Back")
									{
										$(ele).remove();
									}
									$('html, body').stop().animate({
										scrollTop: $('#substeps_'+intNextSubstep).offset().top
									}, 'fast');
									$('.pagemask').hide();
								}
								
								if(intMode === true)
								{
									var strBackHtml = '<a class="button_class step_'+data.currsteporder+'" href="javascript:void(0);" id="back_'+intNextSubstep+'" name="back_'+intNextSubstep+'" onclick="fnGotToStep(this,\'0\')" style="float:left;margin-right:10px;">Back</a>';
									
									var strNewTimeIntBack = setInterval(function(){ 
										if($('#back_'+intNextSubstep).length > 0)
										{
											$('#back_'+intNextSubstep).replaceWith(strBackHtml);
										}
										else
										{
											$('#substep_action_'+intNextSubstep).append(strBackHtml);
										}
										clearInterval(strNewTimeIntBack);
									},3000);
								}
							}
							else
							{
								
							}*/
							//$('.pagemask').hide();
						}
				});
	}
}

function fnLoadMoreContent(intContentId,intPortalId,straction,containerele)
{
	$('#conten_loader_'+intContentId).show();
	$('#less_content_'+intContentId).hide();
	if(straction == "less")
	{
		$('#more_content_'+intContentId).slideUp('slow');
		$('#conten_loader_'+intContentId).hide();
		$('#less_content_'+intContentId).slideDown('slow');
		$('#read_less_action_'+intContentId).hide();
		$('#read_more_action_'+intContentId).show();
		var content = $(document).find('#substeps_'+containerele);
		//alert($(content).offset().top);
		$('html, body').stop().animate({
			scrollTop: $(content).offset().top
		}, 'fast');
	}
	else
	{
		if($('#more_content_'+intContentId).html() == '')
		{
			$.ajax({ 
					type: "POST",
					url: strBaseUrl+"jsprocess/getcontentdetail/"+intPortalId+'/'+intContentId,
					dataType: 'json',
					data:"",
					cache:false,
					success: function(data)
					{
						if(data.status == "success")
						{
							$('#more_content_'+intContentId).html(data.content);
							$('#conten_loader_'+intContentId).hide();
							$('#less_content_'+intContentId).slideUp('slow');
							$('#more_content_'+intContentId).slideDown('slow');
							$('#read_less_action_'+intContentId).show();
							$('#read_more_action_'+intContentId).hide();
						}
						else
						{
							$('#conten_loader_'+intContentId).hide();
							$('#less_content_'+intContentId).show();
							$('#read_more_action_'+intContentId).show();
							$('#read_less_action_'+intContentId).hide();
						}
					}
			});
		}
		else
		{
			$('#more_content_'+intContentId).slideDown('slow');
			$('#conten_loader_'+intContentId).hide();
			$('#less_content_'+intContentId).slideUp();
			$('#read_less_action_'+intContentId).show();
			$('#read_more_action_'+intContentId).hide();
		}
	}
}

function fnShowAddNote()
{
	$('#notes_add').toggle();
}

function fnDeleteAppoint(ele)
{
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");
	if(arrElementId[0] == "note")
	{
		$('#delete_for_note').val(arrElementId[2]);
		$('#confirm_delete_note').dialog("open");
	}
	else
	{
		$('#delete_for').val(arrElementId[2]);
		$('#confirm_delete').dialog("open");
	}
}




/*function fnGetPortalUserProfile(strHCUrl,intPortalId)
{
	var strLoggedOut = ""
	var datastr = "form_uporie="+intPortalId;
	
	$.ajax({ 
			type: "POST",
			url: "http://localhost/happycandidate/jobberland/seeker_current_portal.php",
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "success")
				{
					strLoggedOut = "1";
				}
			},
			complete: function(xhr, textStatus) 
			{
				if(strLoggedOut != '')
				{
					window.location.href = strHCUrl;
				}
			} 
	});
}

function fnSetSeekerCurrentPortalProfile(intPortalId)
{
	var strLoggedOut = ""
	var datastr = "form_uporie="+intPortalId;
	
	$.ajax({ 
			type: "POST",
			url: "http://localhost/happycandidate/jobberland/seeker_current_portal.php",
			data: datastr,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "success")
				{
					strLoggedOut = "1";
				}
			},
			complete: function(xhr, textStatus) 
			{
				if(strLoggedOut != '')
				{
					//window.location.href = strHCUrl;
				}
			} 
	});
}*/

function fnGetSubstepDetail(portalid,substepid,stepid,phaseid)
{
		$('#addtocart').modal('hide');
		$('.cms-bgloader-mask').show();//show loader mask
	 	    $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"jsprocess/substep/"+portalid+'/'+substepid+'/'+stepid+'/'+phaseid,
			data: '',
			cache: false,
			dataType: 'json',
			success: function(data)
			{
					$('.cms-bgloader-mask').hide();//hide loader mask
					$('.cms-bgloader').hide(); //hide loading image
				if(data.status == "failure")
				{
						
					$('#loginerror').html('<div class="alert alert-danger"><a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>Invalid email or password! Please try again.</div>');
					//window.location.reload();
				}
				
				if(data.status == "success")
				{
					if(substepid == '50' || substepid == '75')
					{
					//	alert(stepid);
						//window.location = strBaseUrl+"jsprocess/step/"+portalid+'/'+stepid+'/'+phaseid;
					}
					//console.log('two')
					//$('#demo'+stepid).remove("collapse");
					$('#demo'+stepid).addClass("collapse in");
					//$('#demo'+stepid).focus();	
					//$("#mainMenu").animate({ scrollTop: $('#demo'+stepid).offset().top }, 1000);
					document.getElementById('demo'+stepid).scrollIntoView({block: 'start', behavior: 'smooth'});	
					$('#addtocart').modal('hide');
					$('.wizard-step-content-container').html(data.substepshtml);
					$('#substepcontentcontainer').css('padding','0');
				}
			
			}
	});
	return false;
}

function fnGetSubstepNext(portalid,substepid,stepid,phaseid)
{
		$('#addtocart').modal('hide');
		$('.cms-bgloader-mask').show();//show loader mask
	 	    $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"jsprocess/substep/"+portalid+'/'+substepid+'/'+stepid+'/'+phaseid,
			data: '',
			cache: false,
			dataType: 'json',
			success: function(data)
			{
					$('.cms-bgloader-mask').hide();//hide loader mask
					$('.cms-bgloader').hide(); //hide loading image
				if(data.status == "failure")
				{
						
					$('#loginerror').html('<div class="alert alert-danger"><a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>Invalid email or password! Please try again.</div>');
					//window.location.reload();
				}
				
				if(data.status == "success")
				{
					if(substepid == '50' || substepid == '75')
					{
					//	alert(stepid);
						window.location = strBaseUrl+"jsprocess/step/"+portalid+'/'+stepid+'/'+phaseid;
					}
					//$('#demo'+stepid).remove("collapse");
					//console.log('one')
					$('#demo'+stepid).addClass("collapse in");
					//$('#demo'+stepid).focus();	
					//$("#mainMenu").animate({ scrollTop: $('#demo'+stepid).offset().top }, 1000);
					if(document.getElementById('demo'+stepid)!=null)
					{
						document.getElementById('demo'+stepid).scrollIntoView({block: 'start', behavior: 'smooth'});	
					}
					
					$('#addtocart').modal('hide');
					$('.wizard-step-content-container').html(data.substepshtml);
					$('#dooms').css('overflowY','auto');
					$('#substepcontentcontainer').css('padding','0');
				}
			
			}
	});
	return false;
}
function fnchangeportalstatus(intPortalId)
{
	$('#note_loader_'+intPortalId).show();
	$('#note_'+intPortalId).hide();
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	 	  var status=	$('#status_'+intPortalId).attr('data-attr');
	 	  var changecondition=	$('#contentName').val();
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"manageportal/changePortalStatus/"+intPortalId+"/"+status+"/"+changecondition,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{

				console.log(data);
				if(data.status == "success")
				{
					//alert(data.content)
					$('.message').remove();
					//$('#content_'+intProductId).remove();
				//	$('#product_list_'+intProductId).remove();
					//$('#str'+intProductId).remove();
					if(status==1)
					{
						$('#status_'+intPortalId).attr('data-attr',2);
					}else{
						$('#status_'+intPortalId).attr('data-attr',1);
					}
					$('#status_'+intPortalId).html(data.htmlContent);
					
					
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
				}
				else
				{
					$('.tabloader').hide();
					$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
					$('#contacts_container').show();
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
				}
			}
	});
}

function fnShowfirstTestimonial(){

	$("#fistTestimonial").show();
	$("#secondTestimonial").hide();
	$("#thirdTestimonial").hide();

}
function fnShowsecondTestimonial(){

	$("#fistTestimonial").hide();
	$("#secondTestimonial").show();
	$("#thirdTestimonial").hide();

}function fnShowthirdTestimonial(){

	$("#fistTestimonial").hide();
	$("#secondTestimonial").hide();
	$("#thirdTestimonial").show();

}
$(document).ready(function(){	
	if((window.location.href.indexOf("49")>0)|| (window.location.href.indexOf("74")>0) )
	{
		
		var str=window.location.href;
		var arr=str.split("/");
		var arrLength=arr.length;
		var phaseId=arr[arr.length-1];
		var substepId=arr[arr.length-2];
		var portalId=arr[arr.length-3];
	
		var nextstep=eval(substepId)+1;
	
			fnGetSubstepDetail(portalId,nextstep,substepId,phaseId);
		}

	var windowH = $(window).height(); 			var headerH = $('#page-header').height(); 			var sideH = windowH - headerH;				$('.container-layout').css({'minHeight':sideH ,'margin-bottom':-20 });				var winH = $(window).height();		$('.edit-panel').css({'height':winH-54})		});