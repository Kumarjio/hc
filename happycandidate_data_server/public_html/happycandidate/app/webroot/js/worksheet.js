$(document).ready(function () {
	/*$('.worksheet_entry_dash').click(function () {
		var strEleId = $(this).attr('id');
		if(strEleId == "")
		{
			return false;
		}
		else
		{
			fnAddEditableField(strEleId);
		}
	});*/
	
	$('.worksheet_entry_dash_div').click(function () {
		var strEleId = $(this).attr('id');
		if(strEleId == "")
		{
			return false;
		}
		else
		{
			fnAddEditableField(strEleId);
		}
	});
        
        
});

function fnSaveWorkSheet()
{
	if($('.worksheet_edit_elements').length >0)
	{
		alert("Please complete you information updation and than hit save");
		return false;
	}
	else
	{
		//var strPortalDetail = $('#jobn').attr('class');
		//var arrPortalDetail = strPortalDetail.split("_");
		var strPortId = $('#portid').val();
		var strArtId = $('#artid').val();
		//var strContent = $('#contentcontainer').html();
		var strContent = '';
		var strContentId = '';
		$('.worksheet_entry_dash').each(function() {
			strContentId += $(this).attr('id')+'~';
			strContent += encodeURIComponent($(this)[0]['outerHTML'])+'~';
		});
		//alert(strContent);
		var datastr = "strcont="+strContent+"&strcontid="+strContentId;
		//var datastr = JSON.stringify({'strcont':strContent});
		$('#loader').show();
		$.ajax({ 
				type: "POST",
				url: strBaseUrl+"candidates/savearticle/"+strPortId+"/"+strArtId,
				dataType: 'json',
				data:datastr,
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						$('#worksheet_save').remove();
						$('#loader').remove();
					}
					else
					{
						$('#loader').hide();
					}
				}
		});
	}
}

function fnAddEditableField(strEleInfo)
{
        $("#printButton").hide();
        var contentId = $("#artid").val();
        $("#entButton").html("<input onclick='fnOneClickAcceptInput("+contentId+")' class='worksheet_edit_elements hidden-print' type='button' name='strEleInfobut' id='strEleInfo' value='Enter'>");
        
	strEleInfo = $(strEleInfo).attr('id');
        var arrEleInfo = strEleInfo.split("_");
	var strElementString = "";
	if(arrEleInfo[arrEleInfo.length-2] == "text")
	{
		var strExistingText = $('#'+strEleInfo).text();
		if(strExistingText == "&nbsp;" || strExistingText == "")
		{
			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><input type='text' name='"+strEleInfo+"_field' id='"+strEleInfo+"_field' value='' /></span>";
		}
		else
		{
			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><input type='text' name='"+strEleInfo+"_field' id='"+strEleInfo+"_field' value='"+strExistingText+"' /></span>";
		}
		
		if($('#'+strEleInfo+'_elements').length > 0)
		{
			if($('#'+strEleInfo+'_elements').css('display') == 'block')
			{
				return false;
			}
			else
			{
				$('#'+strEleInfo).after(strElementString);
				$('#'+strEleInfo).hide();
				if($('#worksheet_save').length <= 0)
				{
					$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
					
				}
			}
		}
		else
		{
			$('#'+strEleInfo).after(strElementString);
			$('#'+strEleInfo).hide();
			if($('#worksheet_save').length <= 0)
			{
				$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
			}
		}
	}
	
	if(arrEleInfo[arrEleInfo.length-2] == "selectcontacttype")
	{
		var strExistingText = $('#'+strEleInfo).text();
		if(strExistingText == "&nbsp;" || strExistingText == "")
		{
			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Family'>Family</option><option value='Friends'>Friends</option><option value='Neighbors'>Neighbors</option><option value='Colleagues'>Colleagues</option><option value='College Friends'>College Friends</option><option value='College Alumni'>College Alumni</option><option value='Interest Groups'>Interest Groups | Hobbies</option><option value='Religious Groups'>Religious Groups</option><option value='Community Groups'>Community Groups</option><option value='Sports Teams'>Sports Teams</option><option value='Doctors'>Doctors | Dentists</option><option value='Lawyers'>Lawyers | Accountants</option><option value='Board'>Board members</option><option value='Volunteers'>Volunteers</option><option value='Travel Contacts'>Travel Contacts</option><option value='Teachers'>Teachers | Professors</option></span>";
		}
		else
		{
			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Family'>Family</option><option value='Friends'>Friends</option><option value='Neighbors'>Neighbors</option><option value='Colleagues'>Colleagues</option><option value='College Friends'>College Friends</option><option value='College Alumni'>College Alumni</option><option value='Interest Groups'>Interest Groups | Hobbies</option><option value='Religious Groups'>Religious Groups</option><option value='Community Groups'>Community Groups</option><option value='Sports Teams'>Sports Teams</option><option value='Doctors'>Doctors | Dentists</option><option value='Lawyers'>Lawyers | Accountants</option><option value='Board'>Board members</option><option value='Volunteers'>Volunteers</option><option value='Travel Contacts'>Travel Contacts</option><option value='Teachers'>Teachers | Professors</option></span>";
			
		}
		if($('#'+strEleInfo+'_elements').length > 0)
		{
			if($('#'+strEleInfo+'_elements').css('display') == 'block')
			{
				return false;
			}
			else
			{
				$('#'+strEleInfo).after(strElementString);
				if(strExistingText != "&nbsp;" && strExistingText != "")
				{
					$('#'+strEleInfo+"_field").val(strExistingText);
				}
				$('#'+strEleInfo).hide();
				if($('#worksheet_save').length <= 0)
				{
					$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
				}
				
			}
		}
		else
		{
			$('#'+strEleInfo).after(strElementString);
			if(strExistingText != "&nbsp;" && strExistingText != "")
			{
				$('#'+strEleInfo+"_field").val(strExistingText);
			}
			$('#'+strEleInfo).hide();
			if($('#worksheet_save').length <= 0)
			{
				$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
			}
		}
	}
	
	if(arrEleInfo[arrEleInfo.length-2] == "selectcontactclassi")
	{
		var strExistingText = $('#'+strEleInfo).text();
		if(strExistingText == "&nbsp;" || strExistingText == "")
		{
			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Challengers'>Challengers</option><option value='Experts'>Experts</option><option value='Hubs'>Hubs</option><option value='Mentors'>Mentors</option><option value='Promoters'>Promoters</option><option value='Role Models'>Role Models</option></span>";
		}
		else
		{
			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Challengers'>Challengers</option><option value='Experts'>Experts</option><option value='Hubs'>Hubs</option><option value='Mentors'>Mentors</option><option value='Promoters'>Promoters</option><option value='Role Models'>Role Models</option></span>";
			
		}
		if($('#'+strEleInfo+'_elements').length > 0)
		{
			if($('#'+strEleInfo+'_elements').css('display') == 'block')
			{
				return false;
			}
			else
			{
				$('#'+strEleInfo).after(strElementString);
				if(strExistingText != "&nbsp;" && strExistingText != "")
				{
					$('#'+strEleInfo+"_field").val(strExistingText);
				}
				$('#'+strEleInfo).hide();
				if($('#worksheet_save').length <= 0)
				{
					$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
				}
				
			}
		}
		else
		{
			$('#'+strEleInfo).after(strElementString);
			if(strExistingText != "&nbsp;" && strExistingText != "")
			{
				$('#'+strEleInfo+"_field").val(strExistingText);
			}
			$('#'+strEleInfo).hide();
			if($('#worksheet_save').length <= 0)
			{
				$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
			}
		}
	}
	
	if(arrEleInfo[arrEleInfo.length-2] == "select110")
	{
		var strExistingText = $('#'+strEleInfo).text();
		if(strExistingText == "&nbsp;" || strExistingText == "")
		{
			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option></span>";
		}
		else
		{
			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option></span>";
			
		}
		if($('#'+strEleInfo+'_elements').length > 0)
		{
			if($('#'+strEleInfo+'_elements').css('display') == 'block')
			{
				return false;
			}
			else
			{
				$('#'+strEleInfo).after(strElementString);
				if(strExistingText != "&nbsp;" && strExistingText != "")
				{
					$('#'+strEleInfo+"_field").val(strExistingText);
				}
				$('#'+strEleInfo).hide();
				if($('#worksheet_save').length <= 0)
				{
					$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
				}
				
			}
		}
		else
		{
			$('#'+strEleInfo).after(strElementString);
			if(strExistingText != "&nbsp;" && strExistingText != "")
			{
				$('#'+strEleInfo+"_field").val(strExistingText);
			}
			$('#'+strEleInfo).hide();
			if($('#worksheet_save').length <= 0)
			{
				$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
			}
		}
	}
	
	
	
	if(arrEleInfo[arrEleInfo.length-2] == "selectyesno")
	{
		var strExistingText = $('#'+strEleInfo).text();
		if(strExistingText == "&nbsp;" || strExistingText == "")
		{
			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Yes'>Yes</option><option value='No'>No</option></span>";
		}
		else
		{
			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Yes'>Yes</option><option value='No'>No</option></span>";
			
			/*if(strExistingText == "Yes")
			{
				strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Yes' selected='selected'>Yes</option><option value='No'>No</option><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
			}
			else
			{
				if(strExistingText == "No")
				{
					strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Yes'>Yes</option><option value='No' selected='selected'>No</option><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
				}
				else
				{
					strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Yes'>Yes</option><option value='No'>No</option><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
				}
			}*/
			
		}
		if($('#'+strEleInfo+'_elements').length > 0)
		{
			if($('#'+strEleInfo+'_elements').css('display') == 'block')
			{
				return false;
			}
			else
			{
				$('#'+strEleInfo).after(strElementString);
				if(strExistingText != "&nbsp;" && strExistingText != "")
				{
					$('#'+strEleInfo+"_field").val(strExistingText);
				}
				$('#'+strEleInfo).hide();
				if($('#worksheet_save').length <= 0)
				{
					$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
				}
				
			}
		}
		else
		{
			$('#'+strEleInfo).after(strElementString);
			if(strExistingText != "&nbsp;" && strExistingText != "")
			{
				$('#'+strEleInfo+"_field").val(strExistingText);
			}
			$('#'+strEleInfo).hide();
			if($('#worksheet_save').length <= 0)
			{
				$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
			}
		}
	}
	
	if(arrEleInfo[arrEleInfo.length-2] == "para")
	{
		var strExistingText = $('#'+strEleInfo).text();
		if(strExistingText == "&nbsp;" || strExistingText == "")
		{
			strElementString = "<div id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><textarea name='"+strEleInfo+"_field' id='"+strEleInfo+"_field' style='width:100%;'></textarea></div>";
		}
		else
		{
			strElementString = "<div id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><textarea name='"+strEleInfo+"_field' id='"+strEleInfo+"_field' style='width:100%;'>"+strExistingText+"</textarea></div>";
		}
		
		if($('#'+strEleInfo+'_elements').length > 0)
		{
			if($('#'+strEleInfo+'_elements').css('display') == 'block')
			{
				return false;
			}
			else
			{
				$('#'+strEleInfo).after(strElementString);
				$('#'+strEleInfo).hide();
				if($('#worksheet_save').length <= 0)
				{
					$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
				}
			}
		}
		else
		{
			$('#'+strEleInfo).after(strElementString);
			$('#'+strEleInfo).hide();
			if($('#worksheet_save').length <= 0)
			{
				$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
			}
		}
	}
	
	if(arrEleInfo[arrEleInfo.length-2] == "date")
	{
		var strExistingText = $('#'+strEleInfo).text();
		if(strExistingText == "&nbsp;" || strExistingText == "")
		{
			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><input type='text' name='"+strEleInfo+"_field' id='"+strEleInfo+"_field' value='' /></span>";
		}
		else
		{
			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><input type='text' name='"+strEleInfo+"_field' id='"+strEleInfo+"_field' value='"+strExistingText+"' /></span>";
		}
		
		if($('#'+strEleInfo+'_elements').length > 0)
		{
			if($('#'+strEleInfo+'_elements').css('display') == 'block')
			{
				return false;
			}
			else
			{
				$('#'+strEleInfo).after(strElementString);
				$('#'+strEleInfo+'_field').datepicker();
				$('#'+strEleInfo).hide();
				if($('#worksheet_save').length <= 0)
				{
					$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
				}
			}
		}
		else
		{
			$('#'+strEleInfo).after(strElementString);
			$('#'+strEleInfo+'_field').datepicker();
			$('#'+strEleInfo).hide();
			if($('#worksheet_save').length <= 0)
			{
				$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
			}
		}
	}
}

function fnDownloadWorkSheet(intPortalId,strWorkSheetName)
{
	$("#entButton").html('');
	var strContent = $('#portal_registration').html();
	var strContentId = $('#artid').val();
	var datastr = 'htm='+encodeURIComponent(strContent)+'&sheetname='+strWorkSheetName;
	
	$('#form_loader_mask').css('top','auto');
	$('#form_loader_mask').css('height','900px');
	$('#form_loader_mask').show();
	
	$.ajax({ 
				type: "POST",
				url: strBaseUrl+"candidates/getworksheet/"+intPortalId,
				dataType: 'json',
				cache:false,
				data:datastr,
				success: function(data)
				{
					if(data.status == "success")
					{
                                                var str ="<input onclick='fnOneClickAcceptInput("+strContentId+")' class='worksheet_edit_elements' type='button' name='strEleInfobut' id='strEleInfo' value='Enter' />";
						$('#entButton').html(str);
						$('#form_loader_mask').hide();
						window.open(strBaseUrl+'seekerworksheet/'+data.filename);
					}
				}
		});
}

function fnLoadWorksheetData(intPortalId,intArticleId)
{
	$('#form_loader_mask').css('top','auto');
	$('#form_loader_mask').css('height','900px');
	$('#form_loader_mask').show();
	
	$.ajax({ 
				type: "POST",
				url: strBaseUrl+"candidates/getarticledata/"+intPortalId+"/"+intArticleId,
				dataType: 'json',
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						//alert(data.contentid);
						//alert(data.content);
						var arrEleIds = data.contentid.split("~");
						var arrEleContent = data.content.split("~");
						//alert(arrEleIds.length);
						for(var i=1;i<=(arrEleIds.length-1);i++)
						{
							//alert(i);
							//alert(arrEleIds[i-1]);
							
							if($('#'+arrEleIds[i-1]).length>0)
							{
								$('#'+arrEleIds[i-1]).replaceWith(arrEleContent[i-1]);
							}
						}
						$('#form_loader_mask').hide();
					}
					else
					{
						$('#form_loader_mask').hide();
					}
				},
				complete: function()
				{
					//$('.worksheet_entry_dash').css("border-bottom-width","1px");
					//$('.worksheet_entry_dash').css("border-bottom-style","solid");
				}
		});
}

function fnAcceptInput(ele,eletoinsertvaluein)
{
	//alert(eletoinsertvaluein);
	var strEleIdInFocus = $(ele).attr('id');
	var arrEleIdInFocus = strEleIdInFocus.split('_');
	if($('#'+arrEleIdInFocus[0]+"_"+arrEleIdInFocus[1]+"_"+arrEleIdInFocus[2]+"_"+arrEleIdInFocus[3]+"_field").val() == "")
	{
		$('#'+eletoinsertvaluein).html("&nbsp;");
	}
	else
	{
		$('#'+eletoinsertvaluein).text($('#'+arrEleIdInFocus[0]+"_"+arrEleIdInFocus[1]+"_"+arrEleIdInFocus[2]+"_"+arrEleIdInFocus[3]+"_field").val());
	}
	$('#'+arrEleIdInFocus[0]+"_"+arrEleIdInFocus[1]+"_"+arrEleIdInFocus[2]+"_"+arrEleIdInFocus[3]+"_elements").remove();
	$('#'+eletoinsertvaluein).show();
}


//function fnAddEditableField(strEleInfo)
//{
//	strEleInfo = $(strEleInfo).attr('id');
//        var arrEleInfo = strEleInfo.split("_");
//	var strElementString = "";
//	if(arrEleInfo[arrEleInfo.length-2] == "text")
//	{
//		var strExistingText = $('#'+strEleInfo).text();
//		if(strExistingText == "&nbsp;" || strExistingText == "")
//		{
//			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><input type='text' name='"+strEleInfo+"_field' id='"+strEleInfo+"_field' value='' /><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
//		}
//		else
//		{
//			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><input type='text' name='"+strEleInfo+"_field' id='"+strEleInfo+"_field' value='"+strExistingText+"' /><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
//		}
//		
//		if($('#'+strEleInfo+'_elements').length > 0)
//		{
//			if($('#'+strEleInfo+'_elements').css('display') == 'block')
//			{
//				return false;
//			}
//			else
//			{
//				$('#'+strEleInfo).after(strElementString);
//				$('#'+strEleInfo).hide();
//				if($('#worksheet_save').length <= 0)
//				{
//					$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
//					
//				}
//			}
//		}
//		else
//		{
//			$('#'+strEleInfo).after(strElementString);
//			$('#'+strEleInfo).hide();
//			if($('#worksheet_save').length <= 0)
//			{
//				$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
//			}
//		}
//	}
//	
//	if(arrEleInfo[arrEleInfo.length-2] == "selectcontacttype")
//	{
//		var strExistingText = $('#'+strEleInfo).text();
//		if(strExistingText == "&nbsp;" || strExistingText == "")
//		{
//			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Family'>Family</option><option value='Friends'>Friends</option><option value='Neighbors'>Neighbors</option><option value='Colleagues'>Colleagues</option><option value='College Friends'>College Friends</option><option value='College Alumni'>College Alumni</option><option value='Interest Groups'>Interest Groups | Hobbies</option><option value='Religious Groups'>Religious Groups</option><option value='Community Groups'>Community Groups</option><option value='Sports Teams'>Sports Teams</option><option value='Doctors'>Doctors | Dentists</option><option value='Lawyers'>Lawyers | Accountants</option><option value='Board'>Board members</option><option value='Volunteers'>Volunteers</option><option value='Travel Contacts'>Travel Contacts</option><option value='Teachers'>Teachers | Professors</option><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
//		}
//		else
//		{
//			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Family'>Family</option><option value='Friends'>Friends</option><option value='Neighbors'>Neighbors</option><option value='Colleagues'>Colleagues</option><option value='College Friends'>College Friends</option><option value='College Alumni'>College Alumni</option><option value='Interest Groups'>Interest Groups | Hobbies</option><option value='Religious Groups'>Religious Groups</option><option value='Community Groups'>Community Groups</option><option value='Sports Teams'>Sports Teams</option><option value='Doctors'>Doctors | Dentists</option><option value='Lawyers'>Lawyers | Accountants</option><option value='Board'>Board members</option><option value='Volunteers'>Volunteers</option><option value='Travel Contacts'>Travel Contacts</option><option value='Teachers'>Teachers | Professors</option><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
//			
//		}
//		if($('#'+strEleInfo+'_elements').length > 0)
//		{
//			if($('#'+strEleInfo+'_elements').css('display') == 'block')
//			{
//				return false;
//			}
//			else
//			{
//				$('#'+strEleInfo).after(strElementString);
//				if(strExistingText != "&nbsp;" && strExistingText != "")
//				{
//					$('#'+strEleInfo+"_field").val(strExistingText);
//				}
//				$('#'+strEleInfo).hide();
//				if($('#worksheet_save').length <= 0)
//				{
//					$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
//				}
//				
//			}
//		}
//		else
//		{
//			$('#'+strEleInfo).after(strElementString);
//			if(strExistingText != "&nbsp;" && strExistingText != "")
//			{
//				$('#'+strEleInfo+"_field").val(strExistingText);
//			}
//			$('#'+strEleInfo).hide();
//			if($('#worksheet_save').length <= 0)
//			{
//				$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
//			}
//		}
//	}
//	
//	if(arrEleInfo[arrEleInfo.length-2] == "selectcontactclassi")
//	{
//		var strExistingText = $('#'+strEleInfo).text();
//		if(strExistingText == "&nbsp;" || strExistingText == "")
//		{
//			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Challengers'>Challengers</option><option value='Experts'>Experts</option><option value='Hubs'>Hubs</option><option value='Mentors'>Mentors</option><option value='Promoters'>Promoters</option><option value='Role Models'>Role Models</option><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
//		}
//		else
//		{
//			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Challengers'>Challengers</option><option value='Experts'>Experts</option><option value='Hubs'>Hubs</option><option value='Mentors'>Mentors</option><option value='Promoters'>Promoters</option><option value='Role Models'>Role Models</option><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
//			
//		}
//		if($('#'+strEleInfo+'_elements').length > 0)
//		{
//			if($('#'+strEleInfo+'_elements').css('display') == 'block')
//			{
//				return false;
//			}
//			else
//			{
//				$('#'+strEleInfo).after(strElementString);
//				if(strExistingText != "&nbsp;" && strExistingText != "")
//				{
//					$('#'+strEleInfo+"_field").val(strExistingText);
//				}
//				$('#'+strEleInfo).hide();
//				if($('#worksheet_save').length <= 0)
//				{
//					$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
//				}
//				
//			}
//		}
//		else
//		{
//			$('#'+strEleInfo).after(strElementString);
//			if(strExistingText != "&nbsp;" && strExistingText != "")
//			{
//				$('#'+strEleInfo+"_field").val(strExistingText);
//			}
//			$('#'+strEleInfo).hide();
//			if($('#worksheet_save').length <= 0)
//			{
//				$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
//			}
//		}
//	}
//	
//	if(arrEleInfo[arrEleInfo.length-2] == "select110")
//	{
//		var strExistingText = $('#'+strEleInfo).text();
//		if(strExistingText == "&nbsp;" || strExistingText == "")
//		{
//			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
//		}
//		else
//		{
//			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
//			
//		}
//		if($('#'+strEleInfo+'_elements').length > 0)
//		{
//			if($('#'+strEleInfo+'_elements').css('display') == 'block')
//			{
//				return false;
//			}
//			else
//			{
//				$('#'+strEleInfo).after(strElementString);
//				if(strExistingText != "&nbsp;" && strExistingText != "")
//				{
//					$('#'+strEleInfo+"_field").val(strExistingText);
//				}
//				$('#'+strEleInfo).hide();
//				if($('#worksheet_save').length <= 0)
//				{
//					$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
//				}
//				
//			}
//		}
//		else
//		{
//			$('#'+strEleInfo).after(strElementString);
//			if(strExistingText != "&nbsp;" && strExistingText != "")
//			{
//				$('#'+strEleInfo+"_field").val(strExistingText);
//			}
//			$('#'+strEleInfo).hide();
//			if($('#worksheet_save').length <= 0)
//			{
//				$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
//			}
//		}
//	}
//	
//	
//	
//	if(arrEleInfo[arrEleInfo.length-2] == "selectyesno")
//	{
//		var strExistingText = $('#'+strEleInfo).text();
//		if(strExistingText == "&nbsp;" || strExistingText == "")
//		{
//			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Yes'>Yes</option><option value='No'>No</option><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
//		}
//		else
//		{
//			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Yes'>Yes</option><option value='No'>No</option><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
//			
//			/*if(strExistingText == "Yes")
//			{
//				strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Yes' selected='selected'>Yes</option><option value='No'>No</option><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
//			}
//			else
//			{
//				if(strExistingText == "No")
//				{
//					strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Yes'>Yes</option><option value='No' selected='selected'>No</option><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
//				}
//				else
//				{
//					strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><select name='"+strEleInfo+"_field' id='"+strEleInfo+"_field'><option value=''>--Select One--</option><option value='Yes'>Yes</option><option value='No'>No</option><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
//				}
//			}*/
//			
//		}
//		if($('#'+strEleInfo+'_elements').length > 0)
//		{
//			if($('#'+strEleInfo+'_elements').css('display') == 'block')
//			{
//				return false;
//			}
//			else
//			{
//				$('#'+strEleInfo).after(strElementString);
//				if(strExistingText != "&nbsp;" && strExistingText != "")
//				{
//					$('#'+strEleInfo+"_field").val(strExistingText);
//				}
//				$('#'+strEleInfo).hide();
//				if($('#worksheet_save').length <= 0)
//				{
//					$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
//				}
//				
//			}
//		}
//		else
//		{
//			$('#'+strEleInfo).after(strElementString);
//			if(strExistingText != "&nbsp;" && strExistingText != "")
//			{
//				$('#'+strEleInfo+"_field").val(strExistingText);
//			}
//			$('#'+strEleInfo).hide();
//			if($('#worksheet_save').length <= 0)
//			{
//				$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
//			}
//		}
//	}
//	
//	if(arrEleInfo[arrEleInfo.length-2] == "para")
//	{
//		var strExistingText = $('#'+strEleInfo).text();
//		if(strExistingText == "&nbsp;" || strExistingText == "")
//		{
//			strElementString = "<div id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><textarea name='"+strEleInfo+"_field' id='"+strEleInfo+"_field' style='width:60%;'></textarea><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></div>";
//		}
//		else
//		{
//			strElementString = "<div id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><textarea name='"+strEleInfo+"_field' id='"+strEleInfo+"_field' style='width:60%;'>"+strExistingText+"</textarea><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></div>";
//		}
//		
//		if($('#'+strEleInfo+'_elements').length > 0)
//		{
//			if($('#'+strEleInfo+'_elements').css('display') == 'block')
//			{
//				return false;
//			}
//			else
//			{
//				$('#'+strEleInfo).after(strElementString);
//				$('#'+strEleInfo).hide();
//				if($('#worksheet_save').length <= 0)
//				{
//					$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
//				}
//			}
//		}
//		else
//		{
//			$('#'+strEleInfo).after(strElementString);
//			$('#'+strEleInfo).hide();
//			if($('#worksheet_save').length <= 0)
//			{
//				$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
//			}
//		}
//	}
//	
//	if(arrEleInfo[arrEleInfo.length-2] == "date")
//	{
//		var strExistingText = $('#'+strEleInfo).text();
//		if(strExistingText == "&nbsp;" || strExistingText == "")
//		{
//			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><input type='text' name='"+strEleInfo+"_field' id='"+strEleInfo+"_field' value='' /><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
//		}
//		else
//		{
//			strElementString = "<span id='"+strEleInfo+"_elements' class='worksheet_edit_elements' style='display:block;'><input type='text' name='"+strEleInfo+"_field' id='"+strEleInfo+"_field' value='"+strExistingText+"' /><input onclick=fnAcceptInput(this,'"+strEleInfo+"') class='worksheet_edit_elements' type='button' name='"+strEleInfo+"_but' id='"+strEleInfo+"_but' value='Enter' /></span>";
//		}
//		
//		if($('#'+strEleInfo+'_elements').length > 0)
//		{
//			if($('#'+strEleInfo+'_elements').css('display') == 'block')
//			{
//				return false;
//			}
//			else
//			{
//				$('#'+strEleInfo).after(strElementString);
//				$('#'+strEleInfo+'_field').datepicker();
//				$('#'+strEleInfo).hide();
//				if($('#worksheet_save').length <= 0)
//				{
//					$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
//				}
//			}
//		}
//		else
//		{
//			$('#'+strEleInfo).after(strElementString);
//			$('#'+strEleInfo+'_field').datepicker();
//			$('#'+strEleInfo).hide();
//			if($('#worksheet_save').length <= 0)
//			{
//				$('#portal_registration').after('<a id="worksheet_save" onclick="fnSaveWorkSheet()" class="button_class" style="float:right;margin-left:10px;" href="javascript:void(0);">SAVE</a><span style="float:right;margin-left:10px;display:none;" id="loader"><img title="Loader" alt="Loader" src="'+strBaseUrl+'img/loader.gif"></span>');
//			}
//		}
//	}
//}