<script type="text/javascript">
function fnSubmitAddAppointment()
{
	var isValidated = $('#appointment_add_form').validationEngine('validate');
	if(isValidated == false)
	{
		return false;
	}
	else
	{
		var strMainContent = tinyMCE.get('appoint_dsec').getContent();
		
		var intPortalId = $('#portal_id').val();
		var pageurl = "<?php echo Router::url('/', true)."jstnote/addform/";?>"+intPortalId;
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('#loader').show();
				formData.push({name:'appoint_dsec', value:strMainContent});
			},
			success:function(responseText, statusText, xhr, $form) {
				if(responseText.status == "success")
				{
					$('#loader').hide();
					$('#contact_message').hide();
					$('.message').remove();
					$('#contact_form_messages').css('color','green');
					$('#contacts_container').prepend('<div class="message" style="float:left;width:100%;color:green;">'+responseText.message+'</div>');
					if(responseText.updated != "1")
					{
						$('#appointment_add_form')[0].reset();
					}
					
					if($('#deteailmode').val() == "1")
					{
						$('#edit_appointment').html('');
						$('#edit_appointment').html(responseText.updatedform);
						$('#edit_appointment').show();
						$('#detail_appointment').html('');
						$('#detail_appointment').html(responseText.detailhtml);
						$('#detail_appointment').hide();
					}
					
					//$('#add_contact').dialog("close");
				}
				else
				{
					$('#loader').hide();
					$('#contact_form_messages').css('color','#E04B39');
					$('#contact_form_messages').text(responseText.message);
				}
				
			},								
			url:       pageurl,         // override for form's 'action' attribute 
			type:      pagetype,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		}
		$('#appointment_add_form').ajaxSubmit(pageoptions);
		return false;
	}
}

function checkURL(field, rules, i, options)
{
	var re=/^(http:\/\/www\.|https:\/\/www\.|ftp:\/\/www\.|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
	if(re.test(field.val())) 
	{
		return true;
	}
	else
	{
		return options.allrules.urlcheck.alertText;
	}
}
</script>
<p id="contact_form_messages" style="display:none;"></p>
<p class="tabloader" id="add_model_loader" style="display:none;"></p>
<div id="form_loader_mask" class="pagemask"></div>
<form name="appointment_add_form" id="appointment_add_form">
<ul class="panel-2 margin-top-5">
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Contact Name:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstNotes']['jstnotes_contact_fname'])
			{
				?>
					<input style="margin-top:0;" type="text" class="validate[required,custom[onlyLetterSp]]" value="<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_contact_fname'];?>" name="cname" id="cname" data-prompt-position="topRight:-100" />
				<?php
			}
			else
			{
				?>
					<input type="text" style="margin-top:0;" class="validate[required,custom[onlyLetterSp]]" name="cname" id="cname" data-prompt-position="topRight:-100" />
				<?php
			}
		?>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Contact Email:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstNotes']['jstnotes_contact_email'])
			{
				?>
					<input type="text" style="margin-top:0;" class="validate[required,custom[email]]" name="c_email" id="c_email" value="<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_contact_email'];?>" data-prompt-position="topRight:-100"/>
				<?php
			}
			else
			{
				?>
					<input type="text" style="margin-top:0;" class="validate[required,custom[email]]" name="c_email" id="c_email" data-prompt-position="topRight:-100"/>
				<?php
			}
		?>
		
		<input type='hidden' name='nohtml' id='nohtml' value='1' /> 		
		<input type='hidden' name='appointmentid' id='appointmentid' value='<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_id'];?>' />
		<input type='hidden' name='deteailmode' id='deteailmode' value='<?php echo $strDetailMode ;?>' />
		<?php
			if($arrAppointmentList[0]['JstNotes']['jstnotes_contact_id'])
			{
				?>
					<input type='hidden' name='contactid' id='contactid' value='<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_contact_id'];?>' />
				<?php
			}
		?>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Contact Telephone Number:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstNotes']['jstnotes_contact_phone_no'])
			{
				?>
					<input type="text" style="margin-top:0;" value="<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_contact_phone_no'] ;?>" class="validate[custom[phone]]" name="c_ph1_no" id="c_ph1_no" data-prompt-position="topRight:-100" />
				<?php
			}
			else
			{
				?>
					<input type="text" style="margin-top:0;" class="validate[custom[phone]]" name="c_ph1_no" id="c_ph1_no" data-prompt-position="topRight:-100" />
				<?php
			}
		?>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Note Title:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstNotes']['jstnotes_title'])
			{
				?>
					<input type='text' style="margin-top:0;" name="note_on" id="note_on" value="<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_title'] ;?>" ></input>
				<?php
			}
			else
			{
				?>
					<input type='text' style="margin-top:0;" name="note_on" id="note_on"></input>
				<?php
			}
		?>
	</li>
	<li style="width:90%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Note Description:</label></li>
	<li style="width:90%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstNotes']['jstnotes_description'])
			{
				?>
					<textarea style="margin-top:0;" name="appoint_dsec" id="appoint_dsec"><?php echo htmlspecialchars_decode(stripslashes($arrAppointmentList[0]['JstNotes']['jstnotes_description']));;?></textarea>
				<?php
			}
			else
			{
				?>
					<textarea style="margin-top:0;" name="appoint_dsec" id="appoint_dsec"></textarea>
				<?php
			}
		?>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Note Date:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstNotes']['jstnotes_start_date'])
			{
				?>
					<input style="margin-top:0;" type="text" value="<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_start_date'];?>" name="a_start_date" id="a_start_date" data-prompt-position="topRight:-100"/>
				<?php
			}
			else
			{
				?>
					<input style="margin-top:0;" type="text" name="a_start_date" id="a_start_date" data-prompt-position="topRight:-100"/>
				<?php
			}
		?>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Note Time:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstNotes']['jstnotes_start_time'])
			{
				?>
					<input style="margin-top:0;" type="text" value="<?php echo date('H:i',strtotime($arrAppointmentList[0]['JstNotes']['jstnotes_start_time']));?>" name="a_start_time" id="a_start_time" data-prompt-position="topRight:-100"/>
				<?php
			}
			else
			{
				?>
					<input style="margin-top:0;" type="text" name="a_start_time" id="a_start_time" data-prompt-position="topRight:-100"/>
				<?php
			}
		?>
	</li>
	<li style="width:40%;">
		<input type="submit" id="add_appointment" value="Save" onclick="fnSubmitAddAppointment();return false;" /> &nbsp; <input type="reset"  class="button_class" value="Reset"/>
	</li>
	<li style="width:auto;display:none;" id="loader">
		<img src="<?php echo Router::url('/',true);?>/img/loader.gif" alt="Loader" title="Loader"/>
	</li>
</ul>
</form>
<script type="text/javascript">

	$(document).ready(function () {
	
		$("#a_start_date").datepicker({ 
			dateFormat: 'yy-mm-dd',
			minDate: -90,
			 onClose: function( selectedDate ) {
				$( "#a_end_date" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		
		$("#a_start_time").timepicker();
		
		$("#a_end_date").datepicker({ 
			dateFormat: 'yy-mm-dd',
			 onClose: function( selectedDate ) {
				$( "#a_start_date" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
		
		$("#a_end_time").timepicker();
		
		tinyMCE.init({
			// General options
			selector : "#appoint_dsec",
			editor_deselector : "basiceditor",
			elements : "elm1",
			theme : "advanced",
			width: "400",
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
	});
</script>