<!-- Modal -->
<div id="dialog-mediaupload-form" title="Add Media" style="display:none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<!--<h3 id="myModalLabel">Add Media</h3>-->
				<input type="hidden" name="request_media_from" id="request_media_from" value="" />
			</div>
			<div class="modal-body media_modal">
				<div id="mediauploadercontainer"></div>
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
			width: 653,
			modal: true,
			buttons: {
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				
			}
		});
	});

	/*
		"Insert Media": function() {
					var isExistingTab = $('#existing').hasClass('ui-tabs-active');
					if(isExistingTab.toString() == "true")
					{
						fnAssignMediaToContent('');
					}
					else
					{
						return false;
					}
				},
	
	*/
</script>
<style>
    .ui-dialog .ui-widget .ui-widget-content .ui-corner-all .ui-front .ui-dialog-buttons .ui-draggable .ui-resizable{
         left: 333.5px !important;
    }
</style>