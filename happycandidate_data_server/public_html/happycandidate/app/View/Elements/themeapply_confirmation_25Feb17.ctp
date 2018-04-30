<!-- Modal -->
<div id="theme_confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog delete_confirmation">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Confirmation</h3>
			</div>
			<div class="modal-body delete_modal">
				<!--<p class="tabloader"></p>-->
				<span> Are you sure, you want to apply this theme? </sapn>
				<input type="hidden" name="pass_for" id="pass_for" value="" />
			</div>
			<div class="modal-footer">
				<button id="theme_confirm_no" class="btn" data-dismiss="modal" aria-hidden="true">No</button>
				<button class="btn btn-primary" id="theme_confirm_yes">Yes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$('#theme_confirm_yes').click(function () {
		var deleteFor = $('#pass_for').val();
		var arrElementId = deleteFor.split("@");	
		if(arrElementId[1] != "")
		{
			$("#theme_confirm").modal('hide');
			$("#selectedtheme1").removeClass('selected-theme');
			$("#selectedtheme2").removeClass('selected-theme');
			$("#selectedtheme3").removeClass('selected-theme');
			$("#selectedtheme4").removeClass('selected-theme');
			$("#selectedtheme11").removeClass('selected-theme');
			$("#selectedtheme12").removeClass('selected-theme');
			$("#selectedtheme13").removeClass('selected-theme');
			$("#selectedtheme14").removeClass('selected-theme');
			$("#selectedtheme21").removeClass('selected-theme');
			$("#selectedtheme22").removeClass('selected-theme');
			$("#selectedtheme23").removeClass('selected-theme');
			
			$("#" + arrElementId[0] ).addClass("selected-theme");
			
			//$("#" + deleteFor ).text("Selected");
			
			window.open(arrElementId[1],'_blank');
		}
		return false;
	});
	
	$('#theme_confirm_no').click(function () {
				$("#theme_confirm").modal('hide');
			});
</script>