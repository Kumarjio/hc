function fnGetLocationDetailFromZip()
{
	var strZipCode = $('#txt_pcode').val();
	var datastr = 'zip='+strZipCode;
	$('#loader').show();
	$.ajax({ 
			type: "POST",
			url: appBaseU+"getlocation.php",
			data: datastr,
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
					if(data.countrycd != "")
					{
						$('#txt_country').val(data.countrycd);
					}
					else
					{
						$('#txt_country').val("");
					}
					if(data.state != "")
					{
						$('#txtstateprovince').val(data.state);
					}
					else
					{
						$('#txtstateprovince').val("");
					}
					
					if(data.city != "")
					{
						$('#txtcounty').val(data.city);
					}
					else
					{
						$('#txtcounty').val("");
					}
					if(data.locality != "")
					{
						$('#localityval').val(data.locality);
					}
					else
					{
						$('#localityval').val("");
					}
				}
				$('#loader').hide();
				$('#country').show();
				$('#state').show();
				$('#city').show();
				$('#locality').show();
				
				//alert(data);
				//$("#state_city").html();
				//$("#state_city").html(data);
			}
	});
}

function fnGetLocationDetailFromZipFront()
{
	var strZipCode = $('#txt_post_code').val();
	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show(); //show loading image
			
	var datastr = 'zip='+strZipCode;
	$('#loader').show();
	$.ajax({ 
			type: "POST",
			url: appBaseU+"getlocationfront.php",
			data: datastr,
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
					if(data.countrycd != "")
					{
						$('#txt_country').val(data.countrycd);
					}
					else
					{
						$('#txt_country').val("");
					}
					if(data.state != "")
					{
						$('#txtstateprovince').val(data.state);
					}
					else
					{
						$('#txtstateprovince').val("");
					}
					
					if(data.city != "")
					{
						$('#txtcounty').val(data.city);
					}
					else
					{
						$('#txtcounty').val("");
					}
					if(data.locality != "")
					{
						$('#localityval').val(data.locality);
					}
					else
					{
						$('#localityval').val("");
					}
				}
				$('#loader').hide();
				$('#country').show();
				$('#state').show();
				
				$('#city_auto').css('display','block');
				$('#county_auto').css('display','block');
			
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
			
				//alert(data);
				//$("#state_city").html();
				//$("#state_city").html(data);
			}
	});
}

function fnAddCv(portalid)
{
	var isValidated = jQuery('#cv_form').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
		
		$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnAddMyCv/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
			
				
					$('#alertcvMessages').html(responseText.message);
				
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#cv_form').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}
}

function fnCongoCv(portalid)
{
	var strCtype = $('#ctype').val();
	if(strCtype == "new")
	{
		$('.cms-bgloader-mask').show();//show loader mask
			  $('.cms-bgloader').show(); //show loading image
				$.ajax({ 
				type: "POST",
				url: appBaseU+"candidates/getCongocvform/"+portalid,
				data: '',
				cache: false,
				dataType:"json",
				success: function(data)
				{
					if(data.status == "success")
					{
						
						$('#tab-resume').html(data.contactshtml);
					}
			
				
					$('.cms-bgloader-mask').hide();//show loader mask
			  $('.cms-bgloader').hide(); //show loading image
				
					//alert(data);
					//$("#state_city").html();
					//$("#state_city").html(data);
				}
		});
	}
	else
	{
		$('.cms-bgloader-mask').show();//show loader mask
			  $('.cms-bgloader').show(); //show loading image
				$.ajax({ 
				type: "POST",
				url: appBaseU+"candidates/getUploadExisting/"+portalid,
				data: '',
				cache: false,
				dataType:"json",
				success: function(data)
				{
					if(data.status == "success")
					{
						
						$('#tab-resume').html(data.contactshtml);
					}
			
				
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
				
					//alert(data);
					//$("#state_city").html();
					//$("#state_city").html(data);
				}
		});
	}
	return false; 	
}

function fnGetCvType(portalid,cvid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/fnChooseCVType/"+portalid+"/"+cvid,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
					
					$('#tab-resume').html(data.contactshtml);
				}
		
			
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
			
				//alert(data);
				//$("#state_city").html();
				//$("#state_city").html(data);
			}
	});
		
	return false;
	
}

function fnChooseCVType(portalid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/fnChooseCVType/"+portalid,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
					
					$('#tab-resume').html(data.contactshtml);
				}
		
			
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
			
				//alert(data);
				//$("#state_city").html();
				//$("#state_city").html(data);
			}
	});
		
	return false;
	
}


function fnCreateCv(portalid)
{

			
		$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getCreateCvform/"+portalid,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
					
					$('#tab-resume').html(data.contactshtml);
				}
		
			
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
			
				//alert(data);
				//$("#state_city").html();
				//$("#state_city").html(data);
			}
	});
		
	return false; 	
}

function fnGetResumeView(portalid,seekerid)
{
	var strResumeId = $('#resumeid').val();
	//alert(strResumeId);
	if(strResumeId !="")
	{
		$('.cms-bgloader-mask').show();//show loader mask
		$('.cms-bgloader').show(); //show loading image
		$.ajax({ 
				type: "POST",
				url: appBaseU+"candidates/getresumefont/"+portalid+"/"+seekerid+"/"+strResumeId,
				data: '',
				cache: false,
				dataType:"json",
				success: function(data)
				{
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					if(data.status == "success")
					{
						$('#fontsize').val(data.fontsize)
						$("input[name=font][value=" + data.font + "]").attr('checked', 'checked');
					}
				}
		});
		
		$('#fontModal').modal('show');
		
		/*$('.cms-bgloader-mask').show();//show loader mask
		$('.cms-bgloader').show(); //show loading image
		$.ajax({ 
				type: "POST",
				url: appBaseU+"candidates/getresumeView/"+portalid+"/"+seekerid+"/"+strResumeId,
				data: '',
				cache: false,
				dataType:"json",
				success: function(data)
				{
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					if(data.status == "success")
					{
						var strFname = data.filename;
						var strUrlTOpen = appBaseU+"candidate_resume/"+strFname;
						window.open(strUrlTOpen);
					}
				}
		});*/
	}
	else
	{
		alert("CV / Resume has not been created, Please proceed with Resume builder first.");
		return false;
	}
}

function getInterviewAdvisor(portalid,seekerid,resumeid)
{

	$('.cms-bgloader-mask').show();//show loader mask
		$('.cms-bgloader').show(); //show loading image
		$.ajax({ 
				type: "POST",
				url: appBaseU+"candidates/getAdvisor/"+portalid+"/"+seekerid+"/"+resumeid,
				data: '',
				cache: false,
				dataType:"json",
				success: function(data)
				{
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					if(data.status == "success")
					{
						$('#tab-resume').html(data.careeradvisorhtml);
					}
				}
		});
}


function submitToResumeViewList(portalid,seekerid,resumeid)
{
	$('#resumeid').val(resumeid);
	$('#portalid').val(portalid);
	$('#seekerid').val(seekerid);
	$('.cms-bgloader-mask').show();//show loader mask
		$('.cms-bgloader').show(); //show loading image
		$.ajax({ 
				type: "POST",
				url: appBaseU+"candidates/getresumefont/"+portalid+"/"+seekerid+"/"+resumeid,
				data: '',
				cache: false,
				dataType:"json",
				success: function(data)
				{
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					if(data.status == "success")
					{
						$('#fontsize').val(data.fontsize)
						$("input[name=font][value=" + data.font + "]").attr('checked', 'checked');
					}
				}
		});
	$('#fontNewModal').modal('show');
}


function submitToResumeViewSaveFont(portalid,seekerid)
{
	var strResumeId = $('#resumeid').val();
	if(portalid == '')
	{
		portalid = $('#portalid').val();
	}

	if(seekerid == '')
	{
		seekerid = $('#seekerid').val();
	}
	
	//alert(portalid);
	//alert(seekerid);
	
	//alert(strResumeId);
	//alert(seekerid);
	//return false;
	var strFont = $('input[name=font]:checked', '#fontform').val();
	var strFontSize = $('#fontsize').val();
	if(strResumeId !="")
	{
		
		$('.cms-bgloader-mask').show();//show loader mask
		$('.cms-bgloader').show(); //show loading image
		$.ajax({ 
				type: "POST",
				url: appBaseU+"candidates/getresumeView/"+portalid+"/"+seekerid+"/"+strResumeId+"/"+strFont+"/"+strFontSize+"/1",
				data: '',
				cache: false,
				dataType:"json",
				success: function(data)
				{
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					if(data.status == "success")
					{
						var strFname = data.filename;
						var strUrlTOpen = appBaseU+"candidate_resume/"+strFname;
						window.open(strUrlTOpen);
					}
				}
		});
	}
	else
	{
		alert("CV / Resume has not been created, Please proceed with Resume builder first.");
		return false;
	}
}

function submitToResumeViewForOwner(portalid,seekerid,strResumeId)
{
	var strFont = "no";
	var strFontSize = "no";
	//alert(strResumeId);
	//alert(seekerid);
	//return false;
	
	if(strResumeId !="")
	{
		
		$('.cms-bgloader-mask').show();//show loader mask
		$('.cms-bgloader').show(); //show loading image
		$.ajax({ 
				type: "POST",
				url: appBaseU+"candidates/getresumeView/"+portalid+"/"+seekerid+"/"+strResumeId+"/"+strFont+"/"+strFontSize,
				data: '',
				cache: false,
				dataType:"json",
				success: function(data)
				{
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					if(data.status == "success")
					{
						var strFname = data.filename;
						var strUrlTOpen = appBaseU+"candidate_resume/"+strFname;
						window.open(strUrlTOpen);
					}
				}
		});
	}
	else
	{
		alert("CV / Resume has not been created, Please proceed with Resume builder first.");
		return false;
	}
}

function submitToResumeView(portalid,seekerid)
{
	var strResumeId = $('#resumeid').val();
	if(portalid == '')
	{
		portalid = $('#portalid').val();
	}
	
	if(seekerid == '')
	{
		seekerid = $('#seekerid').val();
	}
	//alert(strResumeId);
	//alert(seekerid);
	//return false;
	var strFont = $('input[name=font]:checked', '#fontform').val();
	var strFontSize = $('#fontsize').val();
	if(strResumeId !="")
	{
		
		$('.cms-bgloader-mask').show();//show loader mask
		$('.cms-bgloader').show(); //show loading image
		$.ajax({ 
				type: "POST",
				url: appBaseU+"candidates/getresumeView/"+portalid+"/"+seekerid+"/"+strResumeId+"/"+strFont+"/"+strFontSize,
				data: '',
				cache: false,
				dataType:"json",
				success: function(data)
				{
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					if(data.status == "success")
					{
						var strFname = data.filename;
						var strUrlTOpen = appBaseU+"candidate_resume/"+strFname;
						window.open(strUrlTOpen);
					}
				}
		});
	}
	else
	{
		alert("CV / Resume has not been created, Please proceed with Resume builder first.");
		return false;
	}
}

function submitTypFrom(portalid,isQuit)
{
	var isValidated = jQuery('#typ_form').validationEngine('validate');
	//alert(isValidated);
	if(isValidated == false)
		{
			var strExoName = $("input[name=rtype]:checked").val();
			if(strExoName == undefined)
			{
				alert("You have not provided resume type, Please check");
				return false;
			}
			return false;			
		}
		else
		{
			fnCreateType(portalid);
		}
	return false;
}

function fnCreateType(portalid)
{
	var strExoName = $("input[name=rtype]:checked").val();
	var intResumeId = $('#resumeid').val();
	//alert(strExoName);
	//return false;
	
	var strU = appBaseU+"candidates/fnSaveRType/"+portalid+"/"+strExoName+"/"+intResumeId;
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			$.ajax({ 
			type: "POST",
			url: strU,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
					
					$('#tab-resume').html(data.contactshtml);
				}
		
			
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
			
				//alert(data);
				//$("#state_city").html();
				//$("#state_city").html(data);
			}
	});
		
	return false;
}

function submitExpFrom(portalid,isQuit)
{
	var isValidated = jQuery('#exp_form').validationEngine('validate');
	//alert(isValidated);
	if(isValidated == false)
		{
			var strExoName = $("input[name=experience]:checked").val();
			if(strExoName == undefined)
			{
				alert("You have not provided your experience level, Please check");
				return false;
			}
			else
			{
				var WorkHistory = $("input[name=workhistory]:checked").val();
				if(WorkHistory == undefined)
				{
					alert("You have not provided your work history, Please check");
					return false;
				}
			}
			return false;			
		}
		else
		{
			
			
			var intResumeId = $('#resumeid').val();
			if(intResumeId != "")
			{
				
				$('.cms-bgloader-mask').show();//show loader mask
				$('.cms-bgloader').show(); //show loading image
				
				var url = appBaseU+"candidates/fnAddMyExperienceLevel/"+portalid;
				var type = "POST";
				var options = { 
				//target:        '#output2',   // target element(s) to be updated with server response 
				success:	function(responseText, statusText, xhr, $form) {
					
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					if(isQuit == "1")
					{
						fnGetResume();
					}
					else
					{
						$('#tab-resume').html(responseText.contactshtml);
						window.scrollTo(0,0);
					}
					},								
						 
					// other available options: 
					url:       url,         // override for form's 'action' attribute 
					type:      type,        // 'get' or 'post', override for form's 'method' attribute 
					dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
				} 
					$('#exp_form').ajaxSubmit(options); 
					// !!! Important !!! 
					// always return false to prevent standard browser submit and page navigation 
					return false; 
			}
			else
			{
				$('#resumeModal').modal('show');
			}
		}
	return false;
}

function submitExpFromNew(portalid)
{
	var isValidated = jQuery('#exp_form').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			var strResumeName = $('#resume_name').val();
			if(strResumeName != "")
			{
				$("#resumeModal").modal('hide');
				$('.cms-bgloader-mask').show();//show loader mask
				$('.cms-bgloader').show(); //show loading image
				var url = appBaseU+"candidates/fnAddMyExperienceLevel/"+portalid;
				var type = "POST";
				var options = { 
					//target:        '#output2',   // target element(s) to be updated with server response
					beforeSubmit:  function(formData, jqForm, options) {
						//$('#content_html').hide();
							formData.push({name:'resume_title', value:$('#resume_name').val()});
					},
					success:	function(responseText, statusText, xhr, $form) {
						
						$('.cms-bgloader-mask').hide();//show loader mask
						$('.cms-bgloader').hide(); //show loading image
						$('#tab-resume').html(responseText.contactshtml);
						//alert("hi");
						window.scrollTo(0,0);
							
						},								
							 
						// other available options: 
						url:       url,         // override for form's 'action' attribute 
						type:      type,        // 'get' or 'post', override for form's 'method' attribute 
						dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
					} 
					$('#exp_form').ajaxSubmit(options); 
					// !!! Important !!! 
					// always return false to prevent standard browser submit and page navigation 
					return false; 
			}
			else
			{
				$('#mssgtext').text('Resume Name, not provided yet, Please name your resume first');
				$('#mssg').addClass('in');
				$('#mssg').show();
				$('#resume_name').focus();
				return false;
			}
		}
	return false;
}

function getExisting(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyExisting/"+portalid+"/"+resumeid,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				//alert(data.contactshtml);
				//return false;
				
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
				
			}
	});
}

function getExpLevel(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyExplevel/"+portalid+"/"+resumeid,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				//alert(data.contactshtml);
				//return false;
				
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
				
			}
	});
}

function getContactInfof(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"jstcontacts/getMyContactInfo/"+portalid+"/"+resumeid,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getContactInfo(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyContactInfo/"+portalid+"/"+resumeid,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getCareerSumf(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"jstcontacts/getCareerSummary/"+portalid+"/"+resumeid,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}


function getCareerSum(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getCareerSummary/"+portalid+"/"+resumeid,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getCoreCompentsf(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"jstcontacts/getCoreCompentents/"+portalid+"/"+resumeid,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getFEducation(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"jstcontacts/getFEducation/"+portalid+"/"+resumeid,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getProfDev(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"jstcontacts/getProfDev/"+portalid+"/"+resumeid,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyEducationF(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"jstcontacts/getEducationF/"+portalid+"/"+resumeid,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getCoreCompents(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getCoreCompentents/"+portalid+"/"+resumeid,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyEducation(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyEducation/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getWokExp(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"jstcontacts/getProfExperience/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getProfExp(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getProfExperience/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyGrants(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyGrants/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyInvites(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyInvites/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyConference(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyConference/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyCampus(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyCampus/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyTeaching(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyTeaching/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyPublications(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyPublications/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyResearch(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyResearch/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyService(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyService/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyLang(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyLang/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyUniService(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyUniService/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyPrffAffA(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyPrffAffA/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyExtra(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyExtra/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyAffiliates(portalid,resumeid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyAffiliates/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
}

function getMyAwards(portalid,resumeid)
{
	
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getMyAwards/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
	
}


function getCommunityInvolve(portalid,resumeid)
{
	
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/getCommunityInvolve/"+portalid+"/"+resumeid,
			
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('#tab-resume').html(data.contactshtml);
				window.scrollTo(0,0);
			}
	});
	
}




function saveContact(portalid,isQuit)
{
	var isValidated = jQuery('#contactform').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnAddMyContactInfo/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
			if(isQuit == "1")
			{
				fnGetResume();
			}
			else
			{
				$('#tab-resume').html(responseText.contactshtml);
				window.scrollTo(0,0);
			}
			
			
				
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#contactform').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}

function saveCareerSummary(portalid,isQuit)
{
	var isValidated = jQuery('#frmcarsumm').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnAddMyCareerSummary/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
			if(isQuit == "1")
			{
				fnGetResume();
			}
			else
			{
				$('#tab-resume').html(responseText.contactshtml);
				window.scrollTo(0,0);
			}
			
				
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmcarsumm').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}

function saveResumeTitlef(portalid)
{
	var isValidated = jQuery('#frmResumeTitle').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"jstcontacts/fnAddMyResumeTitle/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
				$('.footer-wizard').hide();
				$('#tab-resume').html(responseText.contactshtml);
				window.scrollTo(0,0);
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmResumeTitle').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}


function saveResumeTitle(portalid)
{
	var isValidated = jQuery('#frmResumeTitle').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnAddMyResumeTitle/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
				$('.footer-wizard').hide();
				$('#tab-resume').html(responseText.contactshtml);
				window.scrollTo(0,0);
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmResumeTitle').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}


function saveExistingResume(portalid)
{
	var isValidated = jQuery('#existingResumeTitle').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnAddExistingResume/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				$('.footer-wizard').hide();
				$('#tab-resume').html(responseText.contactshtml);
				window.scrollTo(0,0);
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#existingResumeTitle').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}


function saveProffAffilations(portalid,isQuit)
{
	var isValidated = jQuery('#frmprofaff').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnAddMyProffesionalAff/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
				
				
			if(isQuit == "1")
			{
				fnGetResume();
			}
			else
			{
				$('#tab-resume').html(responseText.contactshtml);
				window.scrollTo(0,0);
			}	
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmprofaff').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}

function saveResearch(portalid,isQuit)
{
	var isValidated = jQuery('#research').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnSaveResearch/"+portalid;
		var type = "POST";
		var options = { 
			//target:        '#output2',   // target element(s) to be updated with server response 
			success:	function(responseText, statusText, xhr, $form) {
				
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
					
				if(isQuit == "1")
				{
					fnGetResume();
				}
				else
				{
					$('#tab-resume').html(responseText.contactshtml);
					tal();
					window.scrollTo(0,0);
				}	
					
					
				},								
					 
				// other available options: 
				url:       url,         // override for form's 'action' attribute 
				type:      type,        // 'get' or 'post', override for form's 'method' attribute 
				dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#research').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}


function saveTeaching(portalid,isQuit)
{
	var isValidated = jQuery('#teaching').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnSaveTeaching/"+portalid;
		var type = "POST";
		var options = { 
			//target:        '#output2',   // target element(s) to be updated with server response 
			success:	function(responseText, statusText, xhr, $form) {
				
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
					
				if(isQuit == "1")
				{
					fnGetResume();
				}
				else
				{
					$('#tab-resume').html(responseText.contactshtml);
					tal();
					window.scrollTo(0,0);
				}	
					
					
				},								
					 
				// other available options: 
				url:       url,         // override for form's 'action' attribute 
				type:      type,        // 'get' or 'post', override for form's 'method' attribute 
				dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#teaching').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}

function saveExtra(portalid,isQuit)
{
	var isValidated = jQuery('#extra').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
			
			var url = appBaseU+"candidates/fnSaveExtra/"+portalid;
			var type = "POST";
			var options = {
					//target:        '#output2',   // target element(s) to be updated with server response 
					success:	function(responseText, statusText, xhr, $form) {
					
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
						
					if(isQuit == "1")
					{
						fnGetResume();
					}
					else
					{
						$('#tab-resume').html(responseText.contactshtml);
						tal();
						window.scrollTo(0,0);
					}	
						
						
					},								
						 
					// other available options: 
					url:       url,         // override for form's 'action' attribute 
					type:      type,        // 'get' or 'post', override for form's 'method' attribute 
					dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
			} 
			$('#extra').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
		return false;
}

function saveAcaProffAffilations(portalid,isQuit)
{
	var isValidated = jQuery('#frmprofaffa').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
			
			var url = appBaseU+"candidates/fnSaveProfAffA/"+portalid;
			var type = "POST";
			var options = {
					//target:        '#output2',   // target element(s) to be updated with server response 
					success:	function(responseText, statusText, xhr, $form) {
					
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
						
					if(isQuit == "1")
					{
						fnGetResume();
					}
					else
					{
						$('#tab-resume').html(responseText.contactshtml);
						tal();
						window.scrollTo(0,0);
					}	
						
						
					},								
						 
					// other available options: 
					url:       url,         // override for form's 'action' attribute 
					type:      type,        // 'get' or 'post', override for form's 'method' attribute 
					dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
			} 
			$('#frmprofaffa').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
		return false;
}

function saveLang(portalid,isQuit)
{
	var isValidated = jQuery('#lang').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
			
			var url = appBaseU+"candidates/fnSaveLang/"+portalid;
			var type = "POST";
			var options = {
					//target:        '#output2',   // target element(s) to be updated with server response 
					success:	function(responseText, statusText, xhr, $form) {
					
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
						
					if(isQuit == "1")
					{
						fnGetResume();
					}
					else
					{
						$('#tab-resume').html(responseText.contactshtml);
						tal();
						window.scrollTo(0,0);
					}	
						
						
					},								
						 
					// other available options: 
					url:       url,         // override for form's 'action' attribute 
					type:      type,        // 'get' or 'post', override for form's 'method' attribute 
					dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
			} 
			$('#lang').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
		return false;
}

function saveUniService(portalid,isQuit)
{
	var isValidated = jQuery('#uniservice').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnSaveUniService/"+portalid;
		var type = "POST";
		var options = { 
			//target:        '#output2',   // target element(s) to be updated with server response 
			success:	function(responseText, statusText, xhr, $form) {
				
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
					
				if(isQuit == "1")
				{
					fnGetResume();
				}
				else
				{
					$('#tab-resume').html(responseText.contactshtml);
					tal();
					window.scrollTo(0,0);
				}	
					
					
				},								
					 
				// other available options: 
				url:       url,         // override for form's 'action' attribute 
				type:      type,        // 'get' or 'post', override for form's 'method' attribute 
				dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#uniservice').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}


function saveService(portalid,isQuit)
{
	var isValidated = jQuery('#service').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnSaveService/"+portalid;
		var type = "POST";
		var options = { 
			//target:        '#output2',   // target element(s) to be updated with server response 
			success:	function(responseText, statusText, xhr, $form) {
				
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
					
				if(isQuit == "1")
				{
					fnGetResume();
				}
				else
				{
					$('#tab-resume').html(responseText.contactshtml);
					tal();
					window.scrollTo(0,0);
				}	
					
					
				},								
					 
				// other available options: 
				url:       url,         // override for form's 'action' attribute 
				type:      type,        // 'get' or 'post', override for form's 'method' attribute 
				dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#service').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}



function saveCamp(portalid,isQuit)
{
	var isValidated = jQuery('#campus').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnSaveCamp/"+portalid;
		var type = "POST";
		var options = { 
			//target:        '#output2',   // target element(s) to be updated with server response 
			success:	function(responseText, statusText, xhr, $form) {
				
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
					
				if(isQuit == "1")
				{
					fnGetResume();
				}
				else
				{
					$('#tab-resume').html(responseText.contactshtml);
					tal();
					window.scrollTo(0,0);
				}	
					
					
				},								
					 
				// other available options: 
				url:       url,         // override for form's 'action' attribute 
				type:      type,        // 'get' or 'post', override for form's 'method' attribute 
				dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#campus').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}

function saveConf(portalid,isQuit)
{
	var isValidated = jQuery('#conference').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnSaveConf/"+portalid;
		var type = "POST";
		var options = { 
			//target:        '#output2',   // target element(s) to be updated with server response 
			success:	function(responseText, statusText, xhr, $form) {
				
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
					
				if(isQuit == "1")
				{
					fnGetResume();
				}
				else
				{
					$('#tab-resume').html(responseText.contactshtml);
					tal();
					window.scrollTo(0,0);
				}	
					
					
				},								
					 
				// other available options: 
				url:       url,         // override for form's 'action' attribute 
				type:      type,        // 'get' or 'post', override for form's 'method' attribute 
				dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#conference').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}

function saveInvite(portalid,isQuit)
{
	var isValidated = jQuery('#invited').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnSaveInvites/"+portalid;
		var type = "POST";
		var options = { 
			//target:        '#output2',   // target element(s) to be updated with server response 
			success:	function(responseText, statusText, xhr, $form) {
				
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
					
				if(isQuit == "1")
				{
					fnGetResume();
				}
				else
				{
					$('#tab-resume').html(responseText.contactshtml);
					tal();
					window.scrollTo(0,0);
				}	
					
					
				},								
					 
				// other available options: 
				url:       url,         // override for form's 'action' attribute 
				type:      type,        // 'get' or 'post', override for form's 'method' attribute 
				dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#invited').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}

function saveGrants(portalid,isQuit)
{
	var isValidated = jQuery('#frmgrant').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnAddMyGrants/"+portalid;
		var type = "POST";
		var options = { 
			//target:        '#output2',   // target element(s) to be updated with server response 
			success:	function(responseText, statusText, xhr, $form) {
				
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
					
				if(isQuit == "1")
				{
					fnGetResume();
				}
				else
				{
					$('#tab-resume').html(responseText.contactshtml);
					tal();
					window.scrollTo(0,0);
				}	
					
					
				},								
					 
				// other available options: 
				url:       url,         // override for form's 'action' attribute 
				type:      type,        // 'get' or 'post', override for form's 'method' attribute 
				dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmgrant').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}

function saveAwards(portalid,isQuit)
{
	var isValidated = jQuery('#frmawards').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnAddMyAwards/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
				
			if(isQuit == "1")
			{
				fnGetResume();
			}
			else
			{
				$('#tab-resume').html(responseText.contactshtml);
				//tal();
				window.scrollTo(0,0);
			}	
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmawards').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}


function saveCommunityInvolvement(portalid,isQuit)
{
	var isValidated = jQuery('#frmcommunity').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnAddCommunityInvolvement/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
				
			if(isQuit == "1")
			{
				fnGetResume();
			}
			else
			{
				$('#tab-resume').html(responseText.contactshtml);
				window.scrollTo(0,0);
			}	
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmcommunity').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}



function saveCoreCompents(portalid,isQuit)
{
	var isValidated = jQuery('#frmKeywords').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnAddMyKeywords/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
			if(isQuit == "1")
			{
				fnGetResume();
			}
			else
			{
				$('#tab-resume').html(responseText.contactshtml);
				window.scrollTo(0,0);
			}	
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmKeywords').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}

function savePublication(portalid,isQuit)
{
	var isValidated = jQuery('#frmpublication').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnAddMyPublications/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
				
			if(isQuit == "1")
			{
				fnGetResume();
			}
			else
			{
				$('#tab-resume').html(responseText.contactshtml);
				window.scrollTo(0,0);
			}	
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmpublication').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}

function saveProfDev(portalid,isQuit)
{
	var isValidated = jQuery('#frmeducation').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"jstcontacts/fnAddMyProfDevf/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
				
			if(isQuit == "1")
			{
				fnGetResume();
			}
			else
			{
				$('#tab-resume').html(responseText.contactshtml);
				window.scrollTo(0,0);
			}	
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmeducation').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}

function saveEducationf(portalid,isQuit)
{
	var isValidated = jQuery('#frmeducation').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"jstcontacts/fnAddMyEducationf/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
				
			if(isQuit == "1")
			{
				fnGetResume();
			}
			else
			{
				$('#tab-resume').html(responseText.contactshtml);
				window.scrollTo(0,0);
			}	
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmeducation').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}

function saveEducationNew(portalid,isQuit)
{
	var isValidated = jQuery('#frmeducation').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"jstcontacts/fnAddMyEducationNew/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
				
			if(isQuit == "1")
			{
				fnGetResume();
			}
			else
			{
				$('#tab-resume').html(responseText.contactshtml);
				window.scrollTo(0,0);
			}	
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmeducation').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}

function saveEducation(portalid,isQuit)
{
	var isValidated = jQuery('#frmeducation').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnAddMyEducation/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
				
			if(isQuit == "1")
			{
				fnGetResume();
			}
			else
			{
				$('#tab-resume').html(responseText.contactshtml);
				window.scrollTo(0,0);
			}	
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmeducation').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}

function saveWorkExp(portalid,isQuit)
{
	var isValidated = jQuery('#frmprofexp').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"jstcontacts/fnAddMyWorkExp/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
				
			if(isQuit == "1")
			{
				fnGetResume();
			}
			else
			{
				$('#tab-resume').html(responseText.contactshtml);
				window.scrollTo(0,0);
			}	
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmprofexp').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}



function saveProfExp(portalid,isQuit)
{
	var isValidated = jQuery('#frmprofexp').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnAddMyProfExp/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
				
			if(isQuit == "1")
			{
				fnGetResume();
			}
			else
			{
				$('#tab-resume').html(responseText.contactshtml);
				window.scrollTo(0,0);
			}	
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmprofexp').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
			
		}
	return false;
}


function fnAddCoverLetter(portalid)
{
	var isValidated = jQuery('#cover_form').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
		
		$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnAddMyCoverLetter/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
			
				
					$('#alertcvMessages').html(responseText.message);
				
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#cover_form').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}
}


function fnGetLocationDetailFromCountry()
{
	var country = $( "#txt_country option:selected" ).text();
	
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
	var datastr = 'zip='+country;
	$('#loader').show();
	$.ajax({ 
			type: "POST",
			url: appBaseU+"jobberland/getlocationfront.php",
			data: datastr,
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
					if(data.countrycd != "")
					{
						$('#txt_country').val(data.countrycd);
					}
					else
					{
						$('#txt_country').val("");
					}
					if(data.state != "")
					{
						$('#txtstateprovince').val(data.state);
					}
					else
					{
						$('#txtstateprovince').val("");
					}
					
					if(data.city != "")
					{
						$('#txtcounty').val(data.city);
					}
					else
					{
						$('#txtcounty').val("");
					}
					if(data.locality != "")
					{
						$('#localityval').val(data.locality);
					}
					else
					{
						$('#localityval').val("");
					}
				}
				$('#loader').hide();
				$('#country').show();
				$('#state').show();
				
				$('#city_auto').css('display','block');
				$('#county_auto').css('display','block');
			
				$('.cms-bgloader-mask').hide();//show loader mask
	 	  $('.cms-bgloader').hide(); //show loading image
			
				//alert(data);
				//$("#state_city").html();
				//$("#state_city").html(data);
			}
	});
}

function cascadeCountry(value) {
   if (document.getElementById("stateprovince_auto") != null) {
	if (value != '') {
	    http.open('get', appBaseU+'jobberland/cascade/cascade_sign.php?a=country&v=' + value );
	    document.getElementById('stateprovince_auto').innerHTML = "&nbsp;&nbsp;" + loadingTag;
	    http.onreadystatechange = handleResponse;
	    http.send(null);
	}
	//alert( value );
   }
}

function cascadeState(value, v1) {
   if (document.getElementById("county_auto") != null) {
    	http.open('get', url+'cascade/cascade_sign.php?a=state&v=' + value  + '&v1=' + v1);
		document.getElementById('county_auto').innerHTML="&nbsp;&nbsp;"+loadingTag;
    	http.onreadystatechange = handleResponse;
    	http.send(null);
   }

}

function cascadeCounty(value,v1,v2) {
   if (document.getElementById("city_auto") != null) {
     http.open('get', url+'cascade/cascade_sign.php?a=county&v=' + value
					+ '&v1=' + v1 + '&v2=' + v2);
	document.getElementById('city_auto').innerHTML="&nbsp;&nbsp;"+loadingTag;
     http.onreadystatechange = handleResponse;
     http.send(null);
   }
}

/** this is not being used **/
function cascadeCity(value,v1,v2,v3) {
   if (document.getElementById("txtzip") != null) {
     http.open('get', url+'cascade/cascade_sign.php?a=city&v=' + value
					+ '&v1=' + v1 + '&v2=' + v2 + '&v3=' + v3);
	document.getElementById('txtzip').innerHTML="&nbsp;&nbsp;"+loadingTag;
      http.onreadystatechange = handleResponse;
      http.send(null);
   }
}



/////

function cascadeState_multiple(value, v1) {
   if (document.getElementById("county_auto") != null) {
    	http.open('get', url+'cascade/cascade_multiple_cities.php?a=state&v=' + value  + '&v1=' + v1);
		document.getElementById('county_auto').innerHTML="&nbsp;&nbsp;"+loadingTag;
    	http.onreadystatechange = handleResponse;
    	http.send(null);
   }

}

//multiple cities
function cascadeCounty_multiple(value,v1,v2) {
   if (document.getElementById("city_auto") != null) {
     http.open('get', url+'cascade/cascade_multiple_cities.php?a=county&v=' + value
					+ '&v1=' + v1 + '&v2=' + v2);
	document.getElementById('city_auto').innerHTML="&nbsp;&nbsp;"+loadingTag;
     http.onreadystatechange = handleResponse;
     http.send(null);
   }
}

function deletecandidateCv(id,portalid,intCount)
{
	
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/deleteCv/"+portalid+"/"+id,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
				     $('#resume_'+id).remove();
				     $('#str'+intCount).remove();
					$('#alertcvMessage').html(data.message);
				}
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
			
				
				
				//alert(data);
				//$("#state_city").html();
				//$("#state_city").html(data);
			}
	});
}


function changecvstatus(id,portalid)
{
	
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/changecvstatus/"+portalid+"/"+id,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
				    // $('#resume_'+id).remove();
					$('#tab-resume').html(data.html);
				}
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
			
				
				
				//alert(data);
				//$("#state_city").html();
				//$("#state_city").html(data);
			}
	});
}

function deletecandidateCover(id,portalid)
{
	
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/deleteCover/"+portalid+"/"+id,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
				     $('#coverletter'+id).remove();
					$('#alertcvMessage').html(data.message);
				}
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
			
				
				
				//alert(data);
				//$("#state_city").html();
				//$("#state_city").html(data);
			}
	});
}

function downlaodCv(id,portalid)
{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
	$.ajax({ 
			type: "POST",
			url: appBaseU+"candidates/downloadCv/"+portalid+"/"+id,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
				     
				
				}
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
			
				
				
				//alert(data);
				//$("#state_city").html();
				//$("#state_city").html(data);
			}
	});
}
function fnRenameCV(portalid)
{
	var isValidated = jQuery('#renamecv_form').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
		
		$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"candidates/fnrenameMyCv/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
			
				
					$('#alertcvMessages').html(responseText.message);
				
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#renamecv_form').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}
}


function fnaddRenameCv(intPortalId,intCvId)
		{
		$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		
		$.ajax({ 
				type: "GET",
				url: strBaseUrl+"candidates/getAddRenameform/"+intPortalId+"/"+intCvId,
				dataType: 'json',
				data:"",
				async:false,
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						
						$('#tab-resume').html(data.contactshtml);
					}
					else
					{
						alert("fail");
					}
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
			
				}
		});
	}
	
function fnmakeDefaultCover(intPortalId,intCvId)
		{
		$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		
		$.ajax({ 
				type: "GET",
				url: strBaseUrl+"candidates/fnmakeCoverDefault/"+intPortalId+"/"+intCvId,
				dataType: 'json',
				data:"",
				async:false,
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						
						$('#alertcvMessage').html(data.message);
					}
					else
					{
						alert("fail");
					}
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
			
				}
		});
	}

	function fnmakeDefaultCv(intPortalId,intCvId)
		{
		$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		
		$.ajax({ 
				type: "GET",
				url: strBaseUrl+"candidates/fnmakecvDefault/"+intPortalId+"/"+intCvId,
				dataType: 'json',
				data:"",
				async:false,
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						
						$('#alertcvMessage').html(data.message);
					}
					else
					{
						alert("fail");
					}
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
			
				}
		});
	}

function fnupdatepassword(portalid)
{
		var isValidated = jQuery('#frmchangepass').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
		
		$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"settings/fnChangeMyPassword/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
			
				
					$('#alertpassMessages').html(responseText.message);
				
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#frmchangepass').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}
	
}