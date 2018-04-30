$(document).ready(function () {
	//alert($('#featured_loaded').val());
	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		  //var clickedTab = 
		  var targettab = $(e.target).attr("href");
		  if($(e.target).parent().hasClass('disabled'))
		  {
			$('.tabloader').hide();
			return false;
		  }
		  
		  // ADDING FEATURED FORM SECTION
		  if ((targettab == '#featured')) 
		  {
			$('.tabloader').show();
			if($('#featuredform').length>0)
			{
				$('.tabloader').hide();
			}
			else
			{
				fnGetFeaturedForm();
			}
		  }
		  
		  // ADDING CONTACT DETAIL FORM SECTION
		  if ((targettab == '#contact_form')) 
		  {
			$('.tabloader').show();
			if($('#contactdetailsform').length>0)
			{
				$('.tabloader').hide();
			}
			else
			{
				fnGetContactForm();
			}
		  }
		  
		  // ADDING CONTACT LOCATION FORM SECTION
		  if ((targettab == '#contact_form_locations')) 
		  {
			$('.tabloader').show();
			if($('#contactlocationsform').length>0)
			{
				$('.tabloader').hide();
			}
			else
			{
				fnGetContactDetailForm();
			}
			$('#update_location_id').val('');
			$('#contact_location_add').text("Save");
		  }
		  
		  // ADDING CONTACT LOCATION FORM SECTION
		  if ((targettab == '#content_cat')) 
		  {
			$('.tabloader').show();
			if($('#contentcategoryform').length>0)
			{
				$('.tabloader').hide();
			}
			else
			{
				fnGetContentCategoryForm();
			}
		  }
		  
		  // ADDING CONTENT PARENT SELECTOR FORM SECTION
		  if ((targettab == '#parent_content')) 
		  {
			$('.tabloader').show();
			if($('#contentparentform').length>0)
			{
				$('.tabloader').hide();
			}
			else
			{
				fnGetParentContentForm();
			}
		  }
		  
		   // ADDING CONTENT OTHER FORM SECTION
		  if ((targettab == '#content_other')) 
		  {
			$('.tabloader').show();
			if($('#contentotherform').length>0)
			{
				$('.tabloader').hide();
			}
			else
			{
				fnGetContentHighlightForm();
			}
		  }
		  
	});
	
	// Getting MEDIA UPLOADER
	if($('.content_media_button').length > 0)
	{
		$('.content_media_button').click(function () {
			$('#myModalLabel').text('Add Media');
			$('#content_modal_submit_button').text('Insert into Content');
			if($(this).attr('name') == "add_media_main_content")
			{
				$('#request_media_from').val('main_content');
			}
			else
			{
				if($(this).attr('name') == "add_media_left_content")
				{
					$('#request_media_from').val('left_content');
				}
				else
				{
					if($(this).attr('name') == "add_media_right_content")
					{
						$('#request_media_from').val('right_content');
					}
				}
			}
			if($('#mediacontainer').length>0)
			{
				$('.tabloader').hide();
			}
			else
			{
				fnGetMediUploader();
			}
			$( "#dialog-mediaupload-form" ).dialog( "open" );
			$('.files').html('');
		});
	}
	
	// Getting MEDIA UPLOADER
	if($('.content_media_button_order_update').length > 0)
	{
		$('.content_media_button_order_update').click(function () {
			$('#myModalLabel').text('Add Media');
			$('#content_modal_submit_button').text('Insert into Content');			
			if($(this).attr('name') == "add_media_main_content")
			{
				$('#request_media_from').val('main_content');
			}
			else
			{
				if($(this).attr('name') == "add_media_left_content")
				{
					$('#request_media_from').val('left_content');
				}
				else
				{
					if($(this).attr('name') == "add_media_right_content")
					{
						$('#request_media_from').val('right_content');
					}
				}
			}
			if($('#mediacontainer').length>0)
			{
				$('.tabloader').hide();
			}
			else
			{
				fnGetMediUploader();
			}
			$( "#dialog-mediaupload-form" ).dialog( "open" );
			$('.files').html('');
		});
	}
	
	// Getting MEDIA UPLOADER
	$('#add_banner_media').click(function () {
		$('#myModalLabel').text('Add Banner Image');
		$('#content_modal_submit_button').text('Add Banner Image');
		$('#request_media_from').val('banner_image');
		if($('#mediacontainer').length>0)
		{
			$('.tabloader').hide();
		}
		else
		{
			fnGetMediUploader();
		}
		$( "#dialog-mediaupload-form" ).dialog( "open" );
		$('.files').html('');
	});
	
	// Getting Related Products 
	$('.related_products_button').click(function () {
		var strRelatedContentFor = $('#content_request_for_id').val();
		//alert(strRelatedContentFor);
		if(strRelatedContentFor == "99")
		{
			//alert("HI");
			//alert($('#relatedproducthead').text());
			$('#relatedproducthead').text("Assign Related Pages");
		}
		if(strRelatedContentFor == "2")
		{
			//alert("HI");
			//alert($('#relatedproducthead').text());
			$('#relatedproducthead').text("Assign Related Affiliates");
		}
		var strReqInitiaterElement = $(this).attr('id');
		var arrReqIntiatorElement = strReqInitiaterElement.split('_');
		$('#related_modal_opened_for').val(arrReqIntiatorElement[0]);
		if($('#widget_lister').length>0)
		{
			$('.tabloader').hide();
		}
		else
		{
			var intEditId = $('#content_added').val();
			if(intEditId != "")
			{
				fnGetRelatedProductListForAssignment(intEditId);
			}
			else
			{
				fnGetRelatedProductListForAssignment();
			}
		}
		var strCurrentWidgetReqFor = $("#related_modal_opened_for").val();
		var strAssignedWidgetId = $('#'+strCurrentWidgetReqFor+'_ids').val();
		//alert(strAssignedWidgetId);
		if(strAssignedWidgetId !="")
		{
			//strAssignedWidgetId = strAssignedWidgetId.replace(/,+$/,'');
			var arrAssWidgetIds = strAssignedWidgetId.split(',');
			if(arrAssWidgetIds.length>0)
			{
				$('.product_remover').hide();
				$('.product_assigner').show();
				for(var i=0; i<(arrAssWidgetIds.length-1);i++)
				{
					$('#productremover_'+arrAssWidgetIds[i]).show();
					$('#productassigner_'+arrAssWidgetIds[i]).hide();
				}
			}
			else
			{
				$('.product_assigner').show();
				$('.product_remover').hide();
			}
		}
		else
		{
			$('.product_assigner').show();
			$('.product_remover').hide();
		}
		
	});

	
	// Getting Widgets UPLOADER
	$('.content_widgets_button').click(function () {
		var strReqInitiaterElement = $(this).attr('id');
		var arrReqIntiatorElement = strReqInitiaterElement.split('_');
		$('#modal_opened_for').val(arrReqIntiatorElement[0]);
		if($('#widget_lister').length>0)
		{
			$('.tabloader').hide();
		}
		else
		{
			var strWidgetCategory = $('.content_widgets_button').attr('name');
			fnGetWidgetAssignmentList(strWidgetCategory);
		}
		var strCurrentWidgetReqFor = $("#modal_opened_for").val();
		var strAssignedWidgetId = $('#'+strCurrentWidgetReqFor+'_widgets').val();
		if(strAssignedWidgetId !="")
		{
			//strAssignedWidgetId = strAssignedWidgetId.replace(/,+$/,'');
			var arrAssWidgetIds = strAssignedWidgetId.split(',');
			if(arrAssWidgetIds.length>0)
			{
				$('.widget_assigner').show();
				$('.widget_remover').hide();
				for(var i=0; i<(arrAssWidgetIds.length-1);i++)
				{
					$('#widgetremover_'+arrAssWidgetIds[i]).show();
					$('#widgetassigner_'+arrAssWidgetIds[i]).hide();
				}
			}
			else
			{
				$('.widget_assigner').show();
				$('.widget_remover').hide();
			}
		}
		else
		{
			$('.widget_assigner').show();
			$('.widget_remover').hide();
		}
		
	});
	
	$('#content_modal_submit_button').click(function () {
		fnAssignMediaToContent('');
	});
	
});

function fnShowMediaUploader(ele)
{
	$('#myModalLabel').text('Add Media');
	$('#content_modal_submit_button').text('Insert into Content');
	if($(ele).attr('name') == "add_media_main_content")
	{
		$('#request_media_from').val('main_content');
	}
	else
	{
		if($(ele).attr('name') == "add_media_left_content")
		{
			$('#request_media_from').val('left_content');
		}
		else
		{
			if($(ele).attr('name') == "add_media_right_content")
			{
				$('#request_media_from').val('right_content');
			}
		}
	}
	if($('#mediacontainer').length>0)
	{
		$('.tabloader').hide();
	}
	else
	{
		fnGetMediUploader();
	}
	$( "#dialog-mediaupload-form" ).dialog( "open" );
	$('.files').html('');
}

function fnGetRelatedProductListForAssignment(intContId)
{
	var strRelatedContentFor = $('#content_request_for_id').val();
	if(intContId != "")
	{
		var strRelatedUr = strBaseUrl+"products/relatedproductlist/"+intContId;
	}
	else
	{
		var strRelatedUr = strBaseUrl+"products/relatedproductlist/";
	}
	
	if(strRelatedContentFor)
	{
		strRelatedUr = strRelatedUr+"/"+strRelatedContentFor;
	}
	
	
	$.ajax({ 
			type: "GET",
			url: strRelatedUr,
			dataType: 'json',
			data:"",
			cache:false,
			async:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('#relatedproductcontainer').html(data.content);
				}
				else
				{
					alert("fail");
				}
			}
	});
}

function fnAssignMediaToContent(strImagePassUrl,imageId)
{
	var intImageId = "";
	var strImageUrl = "";
	if(strImagePassUrl != "")
	{
		strImageUrl = strImagePassUrl;
	}
	else
	{
		if($('#tabs2').css('display') == 'block')
		{
			if($('.mediathumbselected').length == 0)
			{
				alert("Please choose image for Banner");
				return false
			}
			else
			{
				if($('.mediathumbselected').length == 1)
				{
					strImageUrl = $('.mediathumbselected').attr('src');
					intImageId = $('.mediathumbselected').attr('id');
				}
			}
		}
		
	}
	var strAssignmentFor = $('#request_media_from').val();
	if(strAssignmentFor == "banner_image")
	{
		$('#banner_image_thumb').attr('src',strImageUrl);
		$('#banner_image_thumb').show();
		$('#banner_image_remover').show();
		if(imageId !="" && (!isNaN(imageId)))
		{
			intImageId = imageId;
		}
		$('#banner_image_id').val(intImageId);
	}
	else
	{
		if(strAssignmentFor == "featured_image")
		{
			$('#featured_image_thumb').attr('src',strImageUrl);
			$('#featured_image_thumb').show();
			$('#featured_image_remover').show();
			if(imageId !="" && (!isNaN(imageId)))
			{
				intImageId = imageId;
			}
			$('#featured_image_id').val(intImageId);
		}
		else
		{
			if(strImageUrl.indexOf("pdf_icon").toString() != "-1")
			{
				var strPdfFile = $('.mediathumbselected').attr('alt');
				strImageUrl = strImageUrl.replace("/img/pdf_icon.jpg","/files/"+strPdfFile);
				var strImageString = "<a target='_blank' href='"+strImageUrl+"'>"+strPdfFile+"</a>";
			}
			else
			{
				if(strImageUrl.indexOf("mp3_icon").toString() != "-1")
				{
					var strMp3File = $('.mediathumbselected').attr('alt');
					strImageUrl = strImageUrl.replace("/img/mp3_icon.jpg","/files/"+strMp3File);
					var strImageString = "<a target='_blank' href='"+strImageUrl+"'>"+strMp3File+"</a>";
				}
				else
				{
					if(strImageUrl.indexOf("thumbnail").toString() != "-1")
					{
						strImageUrl = strImageUrl.replace("thumbnail/","");
						var strImageString = "<img src='"+strImageUrl+"' alt='image' title='image' />";
					}
					else
					{
						var arrFile = strImageUrl.split("/");
						var strFile = arrFile[(arrFile.length-1)];
						if(strFile.indexOf("pdf").toString() != "-1")
						{
							var strImageString = "<a target='_blank' href='"+strImageUrl+"'>PDF</a>";
						}
						else
						{
							var strImageString = "<a target='_blank' href='"+strImageUrl+"'>MP3</a>";
						}
						
					}
				}
			}
			tinymce.get(strAssignmentFor).execCommand('mceInsertContent', false, strImageString);
		}
	}
	
	//$('#mediaModal').modal('hide');
	$('#dialog-mediaupload-form').dialog("close");
}

function fnGetWidgetAssignmentList(strWidgetCategory)
{
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"products/assignwidgetlist/"+strWidgetCategory,
			dataType: 'json',
			data:"",
			async:false,
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('#widgetcontainer').html(data.content);
				}
				else
				{
					alert("fail");
				}
			}
	});
}

function fnAssignRelatedProductsToContent(strAction,strAssignWidgetId,strWidgetName)
{
	var strCurrentWidgetReqFor = $("#related_modal_opened_for").val();
	var strAssignedWidgetIds = $('#'+strCurrentWidgetReqFor+'_ids').val();
	if(strAction == "assign")
	{
		if(strAssignedWidgetIds !="")
		{
			if (strAssignedWidgetIds.indexOf(strAssignWidgetId+",") >= 0)
			{
				strAssignedWidgetIds = strAssignedWidgetIds.replace(strAssignedWidgetIds+",",strAssignWidgetId+",");
			}
			else
			{
				strAssignedWidgetIds = strAssignedWidgetIds+strAssignWidgetId+",";
			}
			var strWidgetHtml = '<a id="'+strCurrentWidgetReqFor+'_relatedproducts_'+strAssignWidgetId+'" role="button" class="btn btn-sm btn-success" href="javascript:void(0);">'+strWidgetName+'</a>&nbsp;';
			$('#'+strCurrentWidgetReqFor+'_ids').val(strAssignedWidgetIds);
			// add button to show added widgets
			$('#'+strCurrentWidgetReqFor+'_relatedproducts_'+strAssignWidgetId).remove();
			$('#'+strCurrentWidgetReqFor+'_ass').append(strWidgetHtml);
		}
		else
		{
			$('#'+strCurrentWidgetReqFor+'_ids').val(strAssignWidgetId+",");
			// add button to show added widgets
			var strWidgetHtml = '<a id="'+strCurrentWidgetReqFor+'_relatedproducts_'+strAssignWidgetId+'" role="button" class="btn btn-sm btn-success" href="javascript:void(0);">'+strWidgetName+'</a>&nbsp;';
			// add button to show added widgets
			$('#'+strCurrentWidgetReqFor+'_relatedproducts_'+strAssignWidgetId).remove();
			$('#'+strCurrentWidgetReqFor+'_ass').append(strWidgetHtml);
		}
		$('#productremover_'+strAssignWidgetId).fadeIn();
		$('#productassigner_'+strAssignWidgetId).fadeOut();
	}
	
	if(strAction == "remove")
	{
		if(strAssignedWidgetIds !="")
		{
			if (strAssignedWidgetIds.indexOf(strAssignWidgetId+",") >= 0)
			{
				strAssignedWidgetIds = strAssignedWidgetIds.replace(strAssignWidgetId+",","");
			}
			$('#'+strCurrentWidgetReqFor+'_ids').val(strAssignedWidgetIds);
			// remove button to show removed widgets
			$('#'+strCurrentWidgetReqFor+'_relatedproducts_'+strAssignWidgetId).remove();
		}
		$('#productassigner_'+strAssignWidgetId).fadeIn();
		$('#productremover_'+strAssignWidgetId).fadeOut();
	}
}

function fnAssignWidgetToContent(strAction,strAssignWidgetId,strWidgetName)
{
	var strCurrentWidgetReqFor = $("#modal_opened_for").val();
	var strAssignedWidgetIds = $('#'+strCurrentWidgetReqFor+'_widgets').val();
	if(strAction == "assign")
	{
		if(strAssignedWidgetIds !="")
		{
			if (strAssignedWidgetIds.indexOf(strAssignWidgetId+",") >= 0)
			{
				strAssignedWidgetIds = strAssignedWidgetIds.replace(strAssignedWidgetIds+",",strAssignWidgetId+",");
			}
			else
			{
				strAssignedWidgetIds = strAssignedWidgetIds+strAssignWidgetId+",";
			}
			$('#'+strCurrentWidgetReqFor+'_widgets').val(strAssignedWidgetIds);
			var strWidgetHtml = '<a id="'+strCurrentWidgetReqFor+'_widget_'+strAssignWidgetId+'" role="button" class="btn btn-sm btn-success" href="javascript:void(0);">'+strWidgetName+'</a>&nbsp;';
			// add button to show added widgets
			$('#'+strCurrentWidgetReqFor+'_widget_'+strAssignWidgetId).remove();
			$('#'+strCurrentWidgetReqFor+'_ass_widgets').append(strWidgetHtml);
		}
		else
		{
			$('#'+strCurrentWidgetReqFor+'_widgets').val(strAssignWidgetId+",");
			// add button to show added widgets
			var strWidgetHtml = '<a id="'+strCurrentWidgetReqFor+'_widget_'+strAssignWidgetId+'" role="button" class="btn btn-sm btn-success" href="javascript:void(0);">'+strWidgetName+'</a>&nbsp;';
			// add button to show added widgets
			$('#'+strCurrentWidgetReqFor+'_widget_'+strAssignWidgetId).remove();
			$('#'+strCurrentWidgetReqFor+'_ass_widgets').append(strWidgetHtml);
		}
		$('#widgetremover_'+strAssignWidgetId).fadeIn();
		$('#widgetassigner_'+strAssignWidgetId).fadeOut();
	}
	
	if(strAction == "remove")
	{
		if(strAssignedWidgetIds !="")
		{
			if (strAssignedWidgetIds.indexOf(strAssignWidgetId+",") >= 0)
			{
				strAssignedWidgetIds = strAssignedWidgetIds.replace(strAssignWidgetId+",","");
			}
			$('#'+strCurrentWidgetReqFor+'_widgets').val(strAssignedWidgetIds);
			// remove button to show removed widgets
			$('#'+strCurrentWidgetReqFor+'_widget_'+strAssignWidgetId).remove();
		}
		$('#widgetassigner_'+strAssignWidgetId).fadeIn();
		$('#widgetremover_'+strAssignWidgetId).fadeOut();
	}
}

function fnExistingContentFiles()
{
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"products/filescontentlister",
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('#existingcontentfilecontent').html(data.content);
				}
				else
				{
					alert("fail");
				}
			}
	});
}


function fnExistingFiles()
{
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"products/fileslister",
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('#existingfilecontent').html(data.content);
				}
				else
				{
					alert("fail");
				}
			}
	});
}

function fnExistingMediaContent()
{
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"content/medialister",
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('#existingmediacontent').html(data.content);
				}
				else
				{
					alert("fail");
				}
			}
	});
}


function fnGetContentHighlightForm()
{
	var strContentId = $('#content_added').val();
	var strRelatedContentFor = $('#content_request_for_id').val();
	if(strRelatedContentFor == "2")
	{
		var strFrmUrl = strBaseUrl+"products/contentaffotherform/"+strContentId;
	}
	else
	{
		if(strRelatedContentFor == "99")
		{
			var strFrmUrl = strBaseUrl+"products/contentaffotherform/"+strContentId;
		}
		else
		{
			if(strRelatedContentFor == "1")
			{
				var strFrmUrl = strBaseUrl+"products/contentaffotherform/"+strContentId+"/"+strRelatedContentFor;
			}
			else
			{
				var strFrmUrl = strBaseUrl+"products/contentotherform/"+strContentId;
			}
		}
	}
	
	$.ajax({ 
			type: "GET",
			url: strFrmUrl,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('#content_other_form').html(data.content);
					$('#content_other_loaded').val('1');
				}
				else
				{
					alert("fail");
				}
			}
	});
}

function fnGetParentContentForm()
{
	var strContentId = $('#content_edit_id').val();
	alert(strContentId);
	$('.tabloader').show();
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"vendors/parentcontentform/"+strContentId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					alert(data.content)
					$('.tabloader').hide();
					$('#parent_content_form').html(data.content);
					$('#parent_cont_loaded').val('1');
				}
				else
				{
					alert("fail");
				}
			}
	});
}

function fnGetCompanyDetailForm()
{
	var strContentId = $('#content_edit_id').val();
	alert(strContentId);
	$('.tabloader').show();
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"vendors/companydetail/"+strContentId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					alert(data.content)
					$('.tabloader').hide();
					$('#vendorcompanycontainer').html(data.content);
				}
				else
				{
					alert("fail");
				}
			}
	});
}

function fnGetParentCatContentForm(strParentCatType)
{
	var strContentId = 0;
	var intCatFrUser = 3;
	if($('#content_cat_added').val() != "")
	{
		strContentId = $('#content_cat_added').val();
	}
	if(strParentCatType == "Phase" || strParentCatType == "Steps" || strParentCatType == "Substeps")
	{
		intCatFrUser = 3;
	}
	
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"content/parentcatcontentform/"+strContentId+"/"+intCatFrUser+"/"+strParentCatType,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('#content_sub_cat_html').html(data.content);
					//$('#parent_cont_loaded').val('1');
				}
				else
				{
					alert("fail");
				}
			}
	});
}

function fnGetContentLayoutForm()
{
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"products/contentlayoutform",
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('#content_layout_form').html(data.content);
					$('#content_layout_loaded').val('1');
				}
				else
				{
					alert("fail");
				}
			}
	});
}

function fnGetContent(intContId,intPortalId)
{
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"candidates/getcontent/"+intPortalId+"/"+intContId,
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
	$('#content_cat_form').hide();
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"candidates/libcatwebdetail/"+portalid+"/"+catid+"/"+strContentType+"/"+intNewTab,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				//alert(data.status);
				if(data.status == "success")
				{
					if(strLoaderEle != "")
					{
						$('#'+strLoaderEle).hide();
					}
					else
					{
						$('.tabloader').hide();
					}
					
					$('#content_html'+data.contenthtmlid).html(data.content);
					
				}
				else
				{
					alert("fail");
				}
				$('#content_html'+data.contenthtmlid).show();
			}
	});
}


function fnGetContentCategoryForm(strCategoryTypes)
{
	var strContentId = $('#content_added').val();
	var strContentUserId = $('#content_user').val();
	var strDefaultId = $('#content_request_for_id').val();
	if(strContentId == "")
	{
		strContentId = 0;
	}
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"content/contentcategoryassform/"+strContentId+"/"+strContentUserId+"/"+strCategoryTypes,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					if(strCategoryTypes == "1")
					{
						$('#content_jsp_cat_form').html(data.content);
					}
					else
					{
						$('#content_cat_form').html(data.content);
					}
					$('#cont_cat_loaded').val('1');
					if(strDefaultId != "")
					{
						$("#defaultcategory").val(strDefaultId);
					}
				}
				else
				{
					alert("fail");
				}
			}
	});
}

function fnGetFeaturedForm()
{
	var strContentId = $('#content_added').val();
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"products/featuredform/"+strContentId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('#featured_form').html(data.content);
					$('#featured_loaded').val('1');
				}
				else
				{
					alert("fail");
				}
			}
	});
}

function fnGetServiceDetails()
{
	var strServiceId = $('#service').val();
	$('.tabloader').show();
	$('#content_html').hide();
	if(strServiceId != "")
	{
		$.ajax({ 
				type: "GET",
				url: strBaseUrl+"vendorservices/getservicedetails/"+strServiceId,
				dataType: 'json',
				data:"",
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						//alert(data.content)
						$('.tabloader').hide();
						$('#service_cost').val(data.cost);
						$('#content_html').show();
					}
					else
					{
						alert("fail");
						$('.tabloader').hide();
						$('#content_html').show();
					}
				}
		});
	}
	else
	{
		return false;
	}
}

function fnGetContactForm()
{
	var strContentId = $('#content_added').val();
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"products/contact/"+strContentId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('#contact_details').html(data.content);
					$('#contact_loaded').val('1');
				}
				else
				{
					alert("fail");
				}
			}
	});
}

function fnGetContactDetailForm()
{
	var strContentId = $('#content_added').val();
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"products/contactlocation/"+strContentId,
			dataType: 'json',
			data:"",
			async:false,
			cache:false,
			success: function(data)
			{
				//alert(data.content);
				if(data.status == "success")
				{
					//alert(data.content)
					$('.tabloader').hide();
					$('#contact_locations').html(data.content);
					$('#contact_detail_loaded').val('1');
				}
				else
				{
					alert("fail");
				}
			}
	});
}

function fnGetMediUploaderOrderUpdate()
{
	
	var strUrl = "";
	var portalid = $('#portal_id').val();
	if($('#service').length > 0)
	{
		var serviceId = $('#content_edit_id').val();
		strUrl = strBaseUrl+"myorders/mediauploader/"+portalid+"/vendor_"+serviceId;
	}
	else
	{
		strUrl = strBaseUrl+"myorders/mediauploader/"+portalid+"/vendor";
	}
	$.ajax({ 
			type: "GET",
			url: strUrl,
			dataType: 'json',
			data:"",
			async:false,
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					
					//alert(data.content)
					$('.tabloader').hide();
					$('#mediauploadercontainer').html(data.content);
					$( "#dialog-mediaupload-form" ).dialog("open");
				}
				else
				{
					alert("fail");
				}
			}
	});
}

function fnGetMediUploader()
{
	
	var strUrl = "";
	if($('#service').length > 0)
	{
		var serviceId = $('#content_edit_id').val();

		if($('#portal_id').length > 0)
		{
			var portalid = $('#portal_id').val();
			strUrl = strBaseUrl+"myorders/mediauploader/"+portalid+"/vendor_"+serviceId;
		}
		else
		{
			strUrl = strBaseUrl+"vendororders/mediauploader/5/vendor_"+serviceId;
		}
	}
	else
	{
		strUrl = strBaseUrl+"vendororders/mediauploader/vendor";
	}
	$.ajax({ 
			type: "GET",
			url: strUrl,
			dataType: 'json',
			data:"",
			async:false,
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					
					//alert(data.content)
					$('.tabloader').hide();
					$('#mediauploadercontainer').html(data.content);
					$( "#dialog-mediaupload-form" ).dialog("open");
				}
				else
				{
					alert("fail");
				}
			}
	});
}

function fnRegisterLoadSubCategory(eleId,parentElementId)
{
	// get the sub cat flag value to check sub cat exists
	// if exists get the sub categories through ajax and fill the elemnt with retrieved html
	// make arrangement register categories 
	var strCheckSubCatPresentElementSelector = eleId+"_sub_category_present";
	var strIsSubCatFlag = $('#'+strCheckSubCatPresentElementSelector).val();
	if(strIsSubCatFlag == "1")
	{
		// load only when checked
		// otherwise remove hide subcats
		var elementCheckedStatus = $('#'+eleId).prop('checked');
		var elementCheckedValue = $('#'+eleId).val();
		if(elementCheckedStatus.toString() == 'true')
		{
			fnRegisterUnregisterCategory('register',elementCheckedValue);
			// check if subcategories loaded
			// if not load subcat otherwise do not load
			if($('#'+eleId+"_subcat").html() != "")
			{
				// just show the sub cats
				$('#'+eleId+"_subcat").fadeIn();
			}
			else
			{
				$('.catcontainer').hide();
				$('#cat_loader').addClass('tabloader');
				var strContentId = $('#content_added').val();
				// get the sub cats
					$.ajax({ 
						type: "GET",
						url: strBaseUrl+"content/getcategories/"+elementCheckedValue+"/"+eleId+"/"+strContentId,
						dataType: 'json',
						data:"",
						async:false,
						cache:false,
						success: function(data)
						{
							if(data.status == "success")
							{
								//alert(data.content)
								//$('.tabloader').hide();
								$('#'+eleId+"_subcat").html(data.content);
							}
							else
							{
								alert("fail");
							}
						}
				});
				$('#cat_loader').removeClass('tabloader');
				$('.catcontainer').fadeIn();
			}
		}
		else
		{
			//$('#'+eleId+'_subcat').hide();
			fnRegisterUnregisterCategory('unregister',elementCheckedValue);
			if(parentElementId != "")
			{
				//$('#'+parentElementId).attr('checked',false);
				//$('#'+parentElementId).trigger("click");
				//fnRegisterUnregisterCategory('unregister',$('#'+parentElementId).val());
				//fnRegisterLoadSubCategory(eleId,parentElementId);
				
			}
		}
	}
	else
	{
		var elementCheckedStatus = $('#'+eleId).prop('checked');
		var elementCheckedValue = $('#'+eleId).val();
		if(elementCheckedStatus.toString() == 'true')
		{
			//$('#'+eleId+'_subcat').hide();
			fnRegisterUnregisterCategory('register',elementCheckedValue);
		}
		else
		{
			//$('#'+eleId+'_subcat').hide();
			fnRegisterUnregisterCategory('unregister',elementCheckedValue);
			if(parentElementId != "")
			{
				//$('#'+parentElementId).attr('checked',false);
				/*$('#'+parentElementId).trigger("click");
				fnRegisterUnregisterCategory('unregister',$('#'+parentElementId).val());*/
			}
		}
	}
}

function  fnRegisterUnregisterCategory(action,registerstring)
{
	var strCategoryValuesForRegistration = $('#maincategoryselected').val();
	if(action == "register")
	{
		if(strCategoryValuesForRegistration !="")
		{
			if (strCategoryValuesForRegistration.indexOf(registerstring+",") >= 0)
			{
				strCategoryValuesForRegistration = strCategoryValuesForRegistration.replace(registerstring+",",registerstring+",");
			}
			else
			{
				strCategoryValuesForRegistration = strCategoryValuesForRegistration+registerstring+",";
			}
			$('#maincategoryselected').val(strCategoryValuesForRegistration);
		}
		else
		{
			$('#maincategoryselected').val(registerstring+",");
		}
		
	}
	
	if(action == "unregister")
	{
		if(strCategoryValuesForRegistration !="")
		{
			if (strCategoryValuesForRegistration.indexOf(registerstring+",") >= 0)
			{
				strCategoryValuesForRegistration = strCategoryValuesForRegistration.replace(registerstring+",","");
			}
			$('#maincategoryselected').val(strCategoryValuesForRegistration);
		}		
	}
	
	
	
}

function fnSetEditorCont(eleId)
{
	tinyMCE.get(eleId).setContent("rajendra");
}

function activateTinyMCETab(selectedTab, visualTab, htmlTab, elementId) 
{
	if (selectedTab == 'visual') 
	{
		var strHtmlContent = $('#'+elementId).val();
		fnInitializeTinyMce('#'+elementId);
		tinyMCE.get(elementId).setContent(strHtmlContent);
		$(visualTab).addClass('active');
		$(htmlTab).removeClass('active');
	}

	if (selectedTab == 'html') 
	{
		var strHtmlContent = tinyMCE.get(elementId).getContent();
		tinyMCE.get(elementId).remove(elementId);
		$(elementId).html(strHtmlContent);
		$(visualTab).removeClass('active');
		$(htmlTab).addClass('active');
	}
}

function fnShowSubjectPath(type,path)
{
	if(type == "media")
	{
		if($('#elepath').length>0)
		{
			$('#elepath').text(path);
		}
		else
		{
			$('<span id="elepath" style="font-size:10px;position:relative;top:7px;">'+path+'</span>').prependTo('.ui-dialog-buttonpane');
		}
	}
}

function fnInitializeTinyMce(eleIDSelector)
{
/*	tinyMCE.init({
			// General options
			selector : eleIDSelector,
			relative_urls: false,
			editor_deselector : "basiceditor",
			elements : "elm1",
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

			// Theme options
			theme_advanced_buttons1 : "formatselect,link,unlink,underline,justifyfull|cut,copy,paste,pastetext,pasteword|",
			theme_advanced_buttons2 : "forecolor,backcolor,bold,italic,strikethrough,bullist,numlist,charmap,|blockquote,hr,justifyleft,justifycenter,justifyright|outdent,indent,undo,redo,media",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : "/css/tinymce/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "/js/tinymce/lists/template_list.js",
			external_link_list_url : "/js/tinymce/lists/link_list.js",
			external_image_list_url : "/js/tinymce/lists/image_list.js",
			media_external_list_url : "/js/tinymce/lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});*/
}