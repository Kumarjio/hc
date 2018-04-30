<!-- Modal -->
<div id="confirm_delete" title="Delete Confirmation" style="display:none;">
	<div class="modal-dialog delete_confirmation">
		<div class="">
			<div class="modal-header">
				<h3 id="myModalLabel">Confirmation</h3>
			</div>
			<div class="modal-body delete_modal">
				<!--<p class="tabloader"></p>-->
				<span> Are you sure, you want to delete? </sapn>
				<input type="hidden" name="delete_for" id="delete_for" value="" />
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
		$( "#confirm_delete" ).dialog({
			autoOpen: false,
			height: 200,
			width: 650,
			modal: true,
			buttons: {
				"Delete": function() {
					var deleteFor = $('#delete_for').val();
					if(deleteFor != "")
					{
						$( this ).dialog( "close" );
						fnDeleteProduct(deleteFor);
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

<style>
.ui-dialog .ui-widget .ui-widget-content .ui-corner-all .ui-front .ui-dialog-buttons .ui-draggable .ui-resizable{
  width: 650px !important;
}
#confirm_delete{
    height: 150px !important;
    overflow: hidden;
}  
</style>