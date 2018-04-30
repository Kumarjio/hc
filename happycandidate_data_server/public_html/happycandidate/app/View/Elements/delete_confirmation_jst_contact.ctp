<!-- Modal -->
<div id="confirm_delete_jst" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog delete_confirmation">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Confirmation</h3>
			</div>
			<div class="modal-body delete_modal">
				<!--<p class="tabloader"></p>-->
				<span> Are you sure, you want to delete? </sapn>
				<input type="hidden" name="delete_for" id="delete_for" value="" />
			</div>
			<div class="modal-footer">
				<button id="confirm_no" class="btn" data-dismiss="modal" aria-hidden="true">No</button>
				<button class="btn btn-primary" id="delete_confirm_new">Yes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$('#delete_confirm_new').click(function () {
		var deleteFor = $('#delete_for').val();
		if(deleteFor != "")
		{
			$("#confirm_delete_jst").modal('hide');
			fnDeleteProduct(deleteFor)
		}
		return false;
	});
	$('#confirm_no').click(function () {
				$("#confirm_delete_jst").modal('hide');
				
			});
</script>