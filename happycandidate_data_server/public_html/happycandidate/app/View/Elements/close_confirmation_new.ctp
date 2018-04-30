<!-- Modal -->
<div id="close_delete_new" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog delete_confirmation">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Confirmation</h3>
			</div>
			<div class="modal-body delete_modal">
				<!--<p class="tabloader"></p>-->
				<span> Are you sure, you want to close this order? </sapn>
				<input type="hidden" name="close_for" id="close_for" value="" />
				<input type="hidden" name="close_port_for" id="close_port_for" value="" />
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
				<button class="btn btn-primary" id="close_confirm">Yes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$('#close_confirm').click(function () {
		var deleteFor = $('#close_for').val();
		var portFor = $('#close_port_for').val();
		if(deleteFor != "")
		{
			$("#close_delete_new").modal('hide');
			//closeCandidateOrder(deleteFor);
			fnChangeOrderStatus(deleteFor,"Closed","0",portFor);
		}
		return false;
	});
</script>