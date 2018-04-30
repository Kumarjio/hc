<!-- Modal -->
<div id="confirm_close" title="Order Close Confirmation" style="display:none;">
	<div class="modal-dialog delete_confirmation">
		<div class="modal-content">
			<div class="modal-header">
				<h3 id="myModalLabel">Confirmation</h3>
			</div>
			<div class="modal-body delete_modal">
				<!--<p class="tabloader"></p>-->
				<span> Are you sure, you want to close order? </sapn>
				<input type="hidden" name="close_for" id="close_for" value="" />
			</div>
			<!--<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
				<button class="btn btn-primary" id="delete_confirm">Yes</button>
			</div>-->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$( "#confirm_close" ).dialog({
			autoOpen: false,
			height: 300,
			width: 650,
			modal: true,
			buttons: {
				"Yes": function() {
					var deleteFor = $('#close_for').val();
					if(deleteFor != "")
					{
						$( this ).dialog( "close" );
						fnCloseProduct(deleteFor);
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