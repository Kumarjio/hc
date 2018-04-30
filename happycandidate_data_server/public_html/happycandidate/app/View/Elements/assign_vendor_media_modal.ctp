<!-- Modal -->
<div id="dialog-mediaupload-form" title="Add Media" style="display:none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<!--<h3 id="myModalLabel">Add Media</h3>-->
				<input type="hidden" name="request_media_from" id="request_media_from" value="" />
			</div>
			<div class="modal-body media_modal">
				<div id="mediauploadercontainer" style="float:left;"></div>
			</div>
			<!--<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				<button class="btn btn-primary" id="content_modal_submit_button">Insert Into Content</button>
			</div>-->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$( "#dialog-mediaupload-form" ).dialog({
			autoOpen: false,
			height: 600,
			width: 1000,
			modal: true,
			buttons: {
				"Done": function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				
			}
		});
	});

</script>