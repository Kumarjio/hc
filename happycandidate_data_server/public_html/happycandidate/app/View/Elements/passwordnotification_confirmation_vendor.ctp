<!-- Modal -->
<div id="password_confirm_vendor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog delete_confirmation">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Confirmation</h3>
			</div>
			<div class="modal-body delete_modal">
				<!--<p class="tabloader"></p>-->
				<span> Are you sure, you want to send password notification? </sapn>
				<input type="hidden" name="pass_for" id="pass_for" value="" />
			</div>
			<div class="modal-footer">
				<button id="pass_confirm_no" class="btn" data-dismiss="modal" aria-hidden="true">No</button>
				<button class="btn btn-primary" id="pass_confirm">Yes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$('#pass_confirm').click(function () {
		var deleteFor = $('#pass_for').val();
		if(deleteFor != "")
		{
			$("#password_confirm_vendor").modal('hide');
			sendPassNotification(deleteFor);
		}
		return false;
	});
	
	$('#pass_confirm_no').click(function () {
				$("#password_confirm_vendor").modal('hide');
			});
</script>