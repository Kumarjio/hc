<!-- Modal -->
<div id="vendor_popup" title="Vendor Service" style="display:none;">
	<div class="modal-dialog delete_confirmation">
		<div class="modal-content">
			<div class="modal-body delete_modal">
				<iframe style="width:100%;height:1200px;" src="http://www.en.wikipedia.org" ></iframe>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$( "#vendor_popup" ).dialog({
			autoOpen: false,
			height: 1200,
			width: 1200,
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