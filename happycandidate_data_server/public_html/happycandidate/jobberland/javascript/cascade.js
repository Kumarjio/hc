function fnGetLocationDetailFromZip()
{
	var strZipCode = $('#txt_pcode').val();
	var datastr = 'zip='+strZipCode;
	$('#loader').show();
	$.ajax({ 
			type: "POST",
			url: url+"getlocation.php",
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
	var datastr = 'zip='+strZipCode;
	$('#loader').show();
	$.ajax({ 
			type: "POST",
			url: url+"getlocationfront.php",
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

function cascadeCountry(value) {
   if (document.getElementById("stateprovince_auto") != null) {
	if (value != '') {
	    http.open('get', url+'cascade/cascade_sign.php?a=country&v=' + value );
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
