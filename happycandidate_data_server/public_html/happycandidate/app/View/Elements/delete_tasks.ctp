<!-- Modal -->
<div id="confirm_delete" title="Delete Confirmation" style="display:none;">
	<div class="modal-dialog delete_confirmation">
		<div class="modal-content">
			<div class="modal-body delete_modal" style="margin-top:20px;">
				<span> You are about to delete a task, Are you sure? </sapn>
				<input type="hidden" name="delete_for" id="delete_for" value="" />
				<input type="hidden" name="detailmode" id="detailmode" value="0" />
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$( "#confirm_delete" ).dialog({
			autoOpen: false,
			height: 150,
			width: 600,
			modal: true,
			buttons: {
				"Delete": function() {
					var deleteFor = $('#delete_for').val();
					if(deleteFor != "")
					{
						$( this ).dialog( "close" );
						fnDeleteTasks(deleteFor);
					}
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				
			}
		});
	});

</script>