<!-- Modal -->
<div id="confirm_delete_new" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
				<input type="hidden" name="cv_for" id="cv_for" value="" />
				<input type="hidden" name="cn_for" id="cn_for" value="" />
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
				<button class="btn btn-primary" id="delete_confirm">Yes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$('#delete_confirm').click(function () {
		var deleteFor = $('#delete_for').val();
		var cvFor = $('#cv_for').val();
		var cnFor = $('#cn_for').val();
		if(deleteFor != "")
		{
			$("#confirm_delete_new").modal('hide');
			deletecandidateCv(deleteFor,cvFor,cnFor);
		}
		return false;
	});
</script>