<?php
	$strAddUrl = Router::url(array('controller'=>'jstappointments','action'=>'add',$intPortalId),true);
?>
<div class="wrapper">
	<div id="jop_search" class="jop_search">
		<h2 id="jobn" style="padding:0;margin-bottom:30px;background:none;padding:none;">Job Seeker Appointments</h2>
		<input type="hidden" name="portal_id" id="portal_id" value="<?php echo $intPortalId; ?>" />
		<div style="float:left;width:100%;">
			<a style="float:right;" onclick="fnShowContactFilter()" href="javascript:void(0);" name="filter_contacts" id="filter_contacts" class="button_class">Search</a>
			<a style="float:right;margin-right:10px;" href="<?php echo $strAddUrl; ?>" name="add_contact_but" id="add_contact_but" class="button_class">Add Appointments</a>
		</div>
		<?php
			echo $this->element('filter_appointments');
		?>
		<div style="float:left;width:100%;">&nbsp;</div>
		<div style="float:left;width:100%;">&nbsp;</div>
		<?php
			echo $this->element('delete_appointment');
			//echo $this->element('add_appointment');
		?>
		<div id="contacts_container" class="line_up_table" style="float:left;width:100%;">
			<?php
				if(is_array($arrAppointmentList) && (count($arrAppointmentList)>0))
				{
					?>
						<div style="width:95%;border:none;" class="line_up_td" id="contact">
							<div style="width:10%;height:40px;line-height:40px;" class="line_up_thumb"><a href="javascript:void(0);">Sr.No</a></div>
							<div style="width:20%;" class="line_up_title">
								<a title="<?php echo $arrAppointment['JstAppointments']['jstappointments_contact_fname']; ?>" href="javascript:void(0);">Appointment With</a>
							</div>
							<div style="width:20%;border:none;line-height:40px;" class="line_up_action">
								<a style="margin-top:0;" href="javascript:void(0);">Date</a>
							</div>
							<div style="width:20%;border:none;line-height:40px;" class="line_up_action">
								<a style="margin-top:0;" href="javascript:void(0);">Time</a>
							</div>
							<div style="width:20%;border:none;line-height:40px;" class="line_up_action">
								<a style="margin-top:0;" href="javascript:void(0);">Action</a>
							</div>
						</div>
						<div class="tabloader" id="appoint_list_tabloader" style="display:none;float:left;width:100%;"></div>
						<div style="width:100%;float:left;" id="app_list">
							<?php
								echo $this->element('appointment_list');
							?>
						</div>
						<?php
				}
				else
				{
					?>
						<div id="contact_message" style="float:left;width:100%;">
							<strong>You don't have any appointments created in your list, Please create one</strong>
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
		$("#add_appointment").dialog("open");
		if($('#appointment_add_form').length>0)
		{
			$('#appointment_add_form')[0].reset();
		}
	}
	
	function fnShowContactFilter()
	{
		$('#contact_filteration_strip').slideToggle('slow');
	}
</script>