<?php
		echo $this->Html->script('tinymce/tiny_mce');
?>
<script type="text/javascript">
	$(document).ready(function() {
		$("#date").datepicker({dateFormat: "yy-mm-dd" });
		
		$('#add_tletetr').click(function () {
			var isFormValidated = $("#thankyou_letter_add_edit").validationEngine('validate');
			if(isFormValidated == false)
			{
				return false;
			}
			else
			{
				$('#loader').show();
				var strletterName = $('#thankyou_letter_name').val();
				var strletterDate = $('#date').val();
				var strletterContactName = $('#contact_name').val();
				var strletterJobTitle = $('#title').val();
				var strletterCompanyName = $('#company_name').val();
				var strletterAddress = $('#address').val();
				var strletterSalutation = $('#salutation').val();
				var strletterContent = $('#letter_message').val();
				var strEditModeId = $('#edit_thankyou_id').val();
				var strPageContent = tinyMCE.activeEditor.getContent();
				//alert(strPageContent);
				//return false;
				
				var thankyouletterformurl = "<?php echo Router::url('/', true).$this->params['controller']."/modify/".$this->params['pass']['0'];?>";
				var thankyouletterformtype = "POST";
				var thankyouletterformoptions = { 
					beforeSubmit:  function(formData, jqForm, options) {
						formData.push({name:'letter_message', value:strPageContent});
					},
					success:function(responseText, statusText, xhr, $form) {
						//alert(responseText);
						if(responseText.status == "success")
						{
							$('#loader').hide();
							if(strEditModeId != "")
							{
								$('#tletter_name_'+strEditModeId).html(strletterName);
								$('#tletter_salutation_'+strEditModeId).html(strletterSalutation);
								$('#tletter_contact_name_'+strEditModeId).html(strletterContactName);
								$('#tletter_contact_title_'+strEditModeId).html(strletterJobTitle);
								$('#tletter_date_'+strEditModeId).html(strletterDate);
								$('#tletter_cname_'+strEditModeId).html(strletterCompanyName);
								$('#tletter_address_'+strEditModeId).html(strletterAddress);
								$('#tletter_content_'+strEditModeId).html(strletterContent);
							}
							else
							{
								var strRowElementName = "<td id='tletter_name_"+responseText.createdid+"'>"+strletterName+"</td>";
								var strRowElementSalutation = "<td id='tletter_salutation_"+responseText.createdid+"'>"+strletterSalutation+"</td>";
								var strRowElementContactName = "<td id='tletter_contact_name_"+responseText.createdid+"'>"+strletterContactName+"</td>";
								var strRowElementContactTitle = "<td id='tletter_contact_title_"+responseText.createdid+"'>"+strletterJobTitle+"</td>";
								var strRowElementTletterDate = "<td style='display:none;' id='tletter_date_"+responseText.createdid+"'>"+strletterDate+"</td>";
								var strRowElementCompanyName = "<td style='display:none;' id='tletter_cname_"+responseText.createdid+"'>"+strletterCompanyName+"</td>";
								var strRowElementAddress = "<td style='display:none;' id='tletter_address_"+responseText.createdid+"'>"+strletterAddress+"</td>";
								var strRowElementContent = "<td style='display:none;' id='tletter_content_"+responseText.createdid+"'>"+strPageContent+"</td>";
								
								var strRefRow = "<tr id='tletter_row_"+responseText.createdid+"'>"+strRowElementName+strRowElementSalutation+strRowElementContactName+strRowElementContactTitle+strRowElementTletterDate+strRowElementCompanyName+strRowElementAddress+strRowElementContent+"<td><a href='javascript:void(0);' onclick=fnRemoveRef('"+responseText.createdid+"')>Remove</a>&nbsp;<a href='#create_tletter_heading' onclick=fnEditRef('"+responseText.createdid+"')>Edit</a></td>"+"</tr>";
								
								$('#tletter_rows').append(strRefRow).fadeIn('slow');
							}
							
							$('#thankyouletter_operation_message').css('color','green');
							$('#thankyouletter_operation_message').html(responseText.message);
							$('#thankyouletter_operation_message').fadeIn('slow');
							
							$('#no_tl_row').fadeOut('slow');
							
							$('#thankyou_letter_name').val('');
							$('#date').val('');
							$('#contact_name').val('');
							$('#title').val('');
							$('#company_name').val('');
							$('#address').val('');
							$('#salutation').val('');
							$('#letter_message').val('');
							$('#edit_thankyou_id').val('');
							tinyMCE.activeEditor.setContent('');
						}
						else
						{
							/*$('#thankyouletter_operation_message').css('color','red');
							$('#thankyouletter_operation_message').html(responseText.message);
							$('#thankyouletter_operation_message').fadeIn('slow');*/
						}
						
					},								
					url:       thankyouletterformurl,         // override for form's 'action' attribute 
					type:      thankyouletterformtype,        // 'get' or 'post', override for form's 'method' attribute 
					dataType:  'json'        			// 'xml', 'script', or 'json' (expected server response type) 
				}
				$('#thankyou_letter_add_edit').ajaxSubmit(thankyouletterformoptions);
				return false;
			}
		});
	});
	
	function fnEditRef(refid)
	{
		var strletterName = $('#tletter_name_'+refid).html();
		var strletterDate = $('#tletter_date_'+refid).html();
		var strletterContactName = $('#tletter_contact_name_'+refid).html();
		var strletterJobTitle = $('#tletter_contact_title_'+refid).html();
		var strletterCompanyName = $('#tletter_cname_'+refid).html();
		var strletterAddress = $('#tletter_address_'+refid).html();
		var strletterSalutation = $('#tletter_salutation_'+refid).html();
		var strletterContent = $('#tletter_content_'+refid).html();
		
		
		$('#thankyou_letter_name').val(strletterName);
		$('#date').val(strletterDate);
		$('#contact_name').val(strletterContactName);
		$('#title').val(strletterJobTitle);
		$('#company_name').val(strletterCompanyName);
		$('#address').val(strletterAddress);
		$('#salutation').val(strletterSalutation);
		//$('#letter_message').val(strletterContent);
		tinyMCE.activeEditor.setContent(strletterContent);
		$('#edit_thankyou_id').val(refid);
		$('#add_tletetr').val('Edit Letter');
		
		//alert("HI");
	}
	
	function fnRemoveRef(refid)
	{
		var cand_ref_id = refid;
		var datastr = 'can_ref_id='+cand_ref_id;
		var cand_ref_del_url = '<?php echo Router::url(array('controller'=>'Tletters','action'=>'removetlet',$intPortalId),true); ?>'
		$.ajax({ 
				type: "POST",
				url: cand_ref_del_url,
				data: datastr,
				cache: false,
				dataType: 'json',
				success: function(data)
				{
					
					if(data.delstatus == "success")
					{
						$('#tletter_row_'+cand_ref_id).remove();
						$('#thankyouletter_operation_message').css('color','green');
						$('#thankyouletter_operation_message').html('');
						$('#thankyouletter_operation_message').html(data.message);
						$('#thankyouletter_operation_message').fadeIn('slow');
						
						if(data.remainingref == "0")
						{
							$('#no_tl_row').fadeIn();
						}
					}
					else
					{
						$('#thankyouletter_operation_message').css('color','red');
						$('#thankyouletter_operation_message').html(data.message);
						$('#thankyouletter_operation_message').fadeIn('slow');
					}
				}
		});
	}
	
	tinyMCE.init({
		// General options
		mode : "textareas",
		editor_deselector : "basiceditor",
		elements : "elm1",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "<?php echo Router::url('/', true); ?>css/tinymce/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "<?php echo Router::url('/', true); ?>js/tinymce/lists/template_list.js",
		external_link_list_url : "<?php echo Router::url('/', true); ?>js/tinymce/lists/link_list.js",
		external_image_list_url : "<?php echo Router::url('/', true); ?>js/tinymce/lists/image_list.js",
		media_external_list_url : "<?php echo Router::url('/', true); ?>js/tinymce/lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>

<div class="jop_search" id="jop_search">
<h2 id="create_tletter_heading" style="background:none;padding:0;">Create Thankyou Letters</h2>
<form name="thankyou_letter_add_edit" id="thankyou_letter_add_edit">
<ul class="panel-2 margin-top-5">
	<li><label>Letter Name:</label>
		<input type="text" class="validate[required,custom[onlyLetterSp]]" name="thankyou_letter_name" id="thankyou_letter_name" placeholder="Thankyou Letter Name"  />
		<input type="hidden" name="edit_thankyou_id" id="edit_thankyou_id"/>
	</li>
	<li class="advance_search"><label>Date:</label>
		<input type="text"  name="date" id="date"  readonly/>
	</li>
	<li class="advance_search"><label>Name Of Contact:</label>
		<input type="text" class="validate[custom[onlyLetterSp]]" name="contact_name" id="contact_name"/>
	</li>
	<li class="advance_search"><label>Title:</label>
		<input type="text" class="validate[custom[onlyLetterSp]]" name="title" id="title"/>
	</li>
	<li class="advance_search"><label>Company Name:</label>
		<input type="text" name="company_name" id="company_name"/>
	</li>
	<li class="advance_search"><label>Address:</label>
		<input type="text" name="address" id="address"/>
	</li>
	<li class="advance_search"><label>Salutation:</label>
		<input type="text" name="salutation" id="salutation"/>
	</li>
	<li style="width:100%;" class="advance_search"><label>Letter Content:</label>
		<textarea id="letter_message" name="letter_message" rows="5" cols="65"></textarea>
	</li>
	<li style="width:auto;">
		<input type="submit" id="add_tletetr" value="Add Letter"/>
	</li>
	<li style="width:auto;">
		<input type="reset"  class="button_class" value="Reset"/>
	</li>
	<li style="width:auto;display:none;" id="loader">
		<img src="<?php echo Router::url('/',true);?>/img/loader.gif" alt="Loader" title="Loader"/>
	</li>
</ul>
</form>
</div>
<div>&nbsp;</div>
<div id="thankyouletter_operation_message" style="display:none;">Reference Created Successfully!</div>
<div>&nbsp;</div>
<div class="jop_search" id="jop_search">
<h2 style="background:none;padding:0;">Thankyou Letter List</h2>
<table class="panel-2 margin-top-5">
	<tr>
		<th><label>Letter Name</label></th>
		<th><label>Salutation</label></th>
		<th><label>Name of Contact</label></th>
		<th><label>Title</label></th>
		<th style="display:none;"><label>Date</label></th>
		<th style="display:none;"><label>Company Name</label></th>
		<th style="display:none;"><label>Address</label></th>
		<th style="display:none;"><label>Letter Content</label></th>
	</tr>
	<tr>
		<th colspan="4">&nbsp;</th>
	</tr>
	<tbody id="tletter_rows">
<?php
	if(is_array($arrCandidateTletterDetail) && (count($arrCandidateTletterDetail)>0))
	{
		foreach($arrCandidateTletterDetail as $arrTletterDetail)
		{
			?>
				<tr id="tletter_row_<?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_thankyou_letter_id'];?>">
					<td id="tletter_name_<?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_thankyou_letter_id'];?>"><?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_letter_name'];?></td>
					<td id="tletter_salutation_<?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_thankyou_letter_id'];?>"><?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_letter_salutation'];?></td>
					<td id="tletter_contact_name_<?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_thankyou_letter_id'];?>"><?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_letter_name_of_contact'];?></td>
					<td id="tletter_contact_title_<?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_thankyou_letter_id'];?>"><?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_title'];?></td>
					<td><a href="javascript:void(0);" onclick="fnRemoveRef('<?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_thankyou_letter_id']; ?>');">Remove</a>&nbsp;<a href="#create_tletter_heading" onclick="fnEditRef('<?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_thankyou_letter_id']; ?>')">Edit</a>&nbsp;<!--<span id="inline_loader"><img src="<?php echo Router::url('/',true);?>/img/loadernew.gif" alt="Loader" title="Loader" /></span>--></td>
					<td style="display:none;" id="tletter_date_<?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_thankyou_letter_id'];?>"><?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_letter_date'];?></td>
					<td style="display:none;" id="tletter_cname_<?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_thankyou_letter_id'];?>"><?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_letter_company_name'];?></td>
					<td style="display:none;" id="tletter_address_<?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_thankyou_letter_id'];?>"><?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_letter_address'];?></td>
					<td style="display:none;" id="tletter_content_<?php echo $arrTletterDetail['CandidateThankyouletter']['candidate_thankyou_letter_id'];?>"><?php echo htmlspecialchars_decode($arrTletterDetail['CandidateThankyouletter']['candidate_letter_content']);?></td>
				</tr>
			<?php
		}
		?>
			<tr id="no_tl_row" style="display:none;">
				<td colspan="4"><label>No Thankyou Letters created yet, Please create your thankyou letter through above form</label></td>
			</tr>
		<?php
	}
	else
	{
		
		?>
			<tr id="no_tl_row">
				<td colspan="7"><label>No Thankyou Letters created yet, Please create your thankyou letter through above form</label></td>
			</tr>
		<?php
	}
?>
</tbody>
</table>
</div>