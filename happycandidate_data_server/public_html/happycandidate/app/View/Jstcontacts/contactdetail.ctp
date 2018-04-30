<div class="wrapper">
	<div id="jop_search" class="jop_search">
		<h2 id="jobn" style="padding:0;margin-bottom:30px;background:none;padding:none;">Job Seeker Contacts</h2>
		<input type="hidden" name="portal_id" id="portal_id" value="<?php echo $intPortalId; ?>" />
		<div style="float:left;width:100%;">
			<a style="float:right;margin-right:10px;" id="contact_edit_<?php echo $arrContactDetail[0]['JstContacts']['jstcontacts_id']; ?>" onclick="fnGetContactDetail(this,'1')" href="javascript:void(0);" name="add_contact_but" class="button_class">Edit Contact</a>
			<a style="float:right;margin-right:10px;" onclick="fnDeleteContact(this,'1')" href="javascript:void(0);" name="add_contact_but" id="contact_del_<?php echo $arrContactDetail[0]['JstContacts']['jstcontacts_id']; ?>" class="button_class">Delete Contact</a>
			<a style="float:right;margin-right:10px;" href="<?php echo $strListcontactsurl; ?>" name="add_contact_but" id="add_contact_but" class="button_class">Back</a>
		</div>
		<div style="float:left;width:100%;">&nbsp;</div>
		<div style="float:left;width:100%;">&nbsp;</div>
		<?php
			echo $this->element('delete_contact');
			echo $this->element('add_contact');
		?>
		<div class="tabloader" style="display:none;float:left;width:100%;"></div>
		<div id="contacts_container" class="line_up_table" style="float:left;width:100%;">
			<?php
				echo $this->element('contact_detail');
			?>
		</div>
	</div>
</div>
<script type="text/javascript">
	function fnLoadConatctAdder()
	{
		$("#add_contact").dialog("open");
		if($('#contact_add_form').length>0)
		{
			$('#contact_add_form')[0].reset();
		}
	}
	
	function fnShowContactFilter()
	{
		$('#contact_filteration_strip').slideToggle('slow');
	}
	
	function fnDeleteContact(ele)
	{
		var strElementId = $(ele).attr('id');
		var arrElementId = strElementId.split("_");
		$('#delete_for').val(arrElementId[2]);
		$('#confirm_delete').dialog("open");
	}
	
	function fnGetContactDetail(ele)
	{
		var strElementId = $(ele).attr('id');
		var arrElementId = strElementId.split("_");
		$('#form_loader_mask').show();
		$('#add_model_loader').show();
		$('#contact_add_form').hide();
		$('#add_contact').dialog("open");
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
						//alert(data.content)
						$('#add_model_loader').hide();
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
						},3000);
					}
					else
					{
						$('#add_model_loader').hide();
						$('#contact_add_form').show();
					}
				}
		});
	}
	
	function fnDeleteProduct(intProductId)
	{
		$('.tabloader').show();
		$('#contacts_container').hide();
		$.ajax({ 
				type: "POST",
				url: strBaseUrl+"jstcontacts/delcontact/"+$('#portal_id').val()+'/'+intProductId,
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
						if(data.alldeleted == "1")
						{
							$('#contacts_container').prepend('<div class="message" style="float:left;width:100%;color:#000;">You dont have any contacts in your list, Please add one</div>');
						}
						$('#contact_'+intProductId).remove();
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
</script>