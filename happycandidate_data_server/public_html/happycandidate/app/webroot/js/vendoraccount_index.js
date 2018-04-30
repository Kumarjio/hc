$(document).ready(function () {
	$("#UsersLoginForm").validationEngine();
});

function fnSubmitVendorForm(strLoginAction,strLogoutAction)
{
	var username = $('#UserUserEmail').val();
	var password = $('#UserPassword').val();
	var utype = $('#UserUType').val();
	var datastr = "data[Vendors][user_email]="+username+"&data[Vendors][password]="+password;
	
	var strMoodleLoginUrl = strLmsLoginPath;
	var boolSystemLogin = "";
	var strSystemLoginRedirectUrl = "";
	var strAdminUserName = "";
	var strAdminUserEmail = "";
	var strAdminUserId = "";
	var loginredirecturl = "";
	var strLmsLoginUrl = ""
	var loggedinid = ""
	var vendortype = ""
	
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
					location.reload(true);
				}
				if(data.status == "success")
				{
					boolSystemLogin = "1";
					loginredirecturl = data.redirecturl;
					strLmsLoginUrl = data.lmslogin;
					vendortype = data.vendortype;
					//window.location.href = data.redirecturl;					
				}
			},
			complete: function(xhr, textStatus) 
			{
				if(vendortype == "Course")
				{
					fnLoginVendorToLMS(username,password,strLmsLoginUrl,loginredirecturl,"","2",strLogoutAction)
				}
				else
				{
					window.location.href = loginredirecturl;	
				}
			}
	});
	
	return false;
}

function fnLoginVendorToLMS(uname,password,strLMSUrl,strSystemUrl,portalid,usertype,strHcLogoutUrl,strJobberTok)
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

function fnUpdateLoogedUserSessionData(seskey,portalid,usertype,redirectUrl,strLmsLoginTok,strJobTok)
{	
	//alert(strJobTok);
	//return false;
	var datastr = "";
	datastr = "sesskey="+seskey+"&portid="+portalid+"&utype="+usertype+"&lmst="+strLmsLoginTok+"&jbt="+strJobTok;
	var strPostUrl = "";
	if(portalid != "")
	{
		strPostUrl = appBaseU+"candidates/updatesession/"+portalid;
	}
	else
	{
		strPostUrl = appBaseU+"vendoraccount/updatesession/";
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