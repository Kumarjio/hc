<?php
	foreach($arrReminderDetail as $arrReminder)
	{
		$strReminderTitle = "Event Reminder";
		$strReminderDetailUrl = "";
		if($arrReminder['Reminder']['reminder_type'] == "Appointment")
		{
			$strReminderTitle = "Appointment Reminder";
			$strReminderDetailUrl = Router::url(array('controller'=>'jstappointments','action'=>'detail',$intPortalId,$arrReminder['Reminder']['reminder_type_id']),true);
		}
		
		
		?>
			<!-- Modal -->
			<div id="reminder_<?php echo $arrReminder['Reminder']['reminder_id']; ?>" class="reminders" title="<?php echo $strReminderTitle; ?>" style="display:none;">
				<div class="modal-dialog delete_confirmation">
					<div class="modal-content">
						<div class="modal-body delete_modal" style="margin-top:20px;">
							<div> 
								<?php echo $arrReminder['Reminder']['reminder_text']; ?>
							</div>
							<?php
								if($strReminderDetailUrl)
								{
									?>
									<div style="margin-top:10px;"> 
										<a style="text-decoration:underline;color:blue;" href="<?php echo $strReminderDetailUrl;?>" target='_blank'>View in Detail</a>
									</div>
									<?php
								}
							?>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div>
			<script type="text/javascript">
				$(document).ready(function () {
					$("#reminder_"+<?php echo $arrReminder['Reminder']['reminder_id']; ?>).dialog({
						autoOpen: false,
						height: 200,
						width: 600,
						modal: true,
						buttons: {
							"OK": function() {
								$( this ).dialog( "close" );
							}
						},
						close: function() {
							
						}
					});
				});
			</script>
		<?php
	}
?>