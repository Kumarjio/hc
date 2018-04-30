<div class="wrapper">
	<div id="jop_search" class="jop_search">
		<h2 id="jobn" style="padding:0;margin-bottom:30px;background:none;padding:none;">Job Seeker Contacts</h2>
		<input type="hidden" name="portal_id" id="portal_id" value="<?php echo $intPortalId; ?>" />
		<div style="float:left;width:100%;">
			<a style="float:right;" onclick="fnShowContactFilter()" href="javascript:void(0);" name="filter_contacts" id="filter_contacts" class="button_class">Filter Contacts</a>
			<a style="float:right;margin-right:10px;" onclick="fnLoadConatctAdder()" href="javascript:void(0);" name="add_contact_but" id="add_contact_but" class="button_class">Add Contact</a>
		</div>
		<?php
			echo $this->element('filter_contact');
		?>
		<div style="float:left;width:100%;">&nbsp;</div>
		<div style="float:left;width:100%;">&nbsp;</div>
		<?php
			echo $this->element('delete_contact');
			echo $this->element('add_contact');
		?>
		<div class="tabloader" style="display:none;float:left;width:100%;"></div>
		<div id="contacts_container" class="line_up_table" style="float:left;width:100%;">
			<?php
				if(is_array($arrContactDetail) && (count($arrContactDetail)>0))
				{
					echo $this->element('contact_list');
				}
				else
				{
					?>
						<div id="contact_message" style="float:left;width:100%;">
							<strong>You don't have any contacts in your list, Please add one</strong>
						</div>
					<?php
				}
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
</script>