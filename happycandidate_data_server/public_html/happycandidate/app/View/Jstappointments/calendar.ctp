<?php
	$strAddUrl = Router::url(array('controller'=>'jstappointments','action'=>'add',$intPortalId),true);
?>
<div class="wrapper">
	<div id="jop_search" class="jop_search">
		<h2 id="jobn" style="padding:0;margin-bottom:30px;background:none;padding:none;">Job Seeker Appointments</h2>
		<input type="hidden" name="portal_id" id="portal_id" value="<?php echo $intPortalId; ?>" />
		<div style="float:left;width:100%;">&nbsp;</div>
		<div style="float:left;width:100%;">&nbsp;</div>
		<div id="contacts_container" class="line_up_table" style="float:left;width:100%;">
			<?php
				if(is_array($arrAppointmentList) && (count($arrAppointmentList)>0))
				{
					$arrAppointmentList['event'] = json_encode($arrAppointmentList['event']);
					echo $this->element('calendar');
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

</script>