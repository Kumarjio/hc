function fnLogoutVendor(strLogoutUrl,strSessKey,strUserEmail)
{
	/*alert(strUserEmail);
	return false;*/
	var datastr = "logoutaction=1";
	var boolSendLogoutRequest = "";
	var strCakeLogOutUrl = strLogoutUrl;
	var sessiokey = strSessKey;
	var strLMSLogoutUrl = strLmsLogoutPath;
	var strRedirectUrl = "";
	var strVendorType = ""
	$.ajax({ 
			type: "POST",
			url: strLogoutUrl,
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == "failure")
				{
					alert(data.message);
				}
				if(data.status == "success")
				{
					strRedirectUrl = data.logoutredirecturl;					
					strVendorType = data.loggedoutusertype;
				}
			},
			complete: function()
			{
				if(strVendorType == "Course")
				{
					fnLogOutFromLMS("sesskey="+strSessKey+"&usert_type_request=admin",strRedirectUrl,strRedirectUrl,"","2")
				}
				else
				{
					window.location.href = strRedirectUrl;					
				}
			}
	});
	
	return false;
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
						/*var arrUserDetail = strLogOutUserDetail.split(",");
						
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
						});*/
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