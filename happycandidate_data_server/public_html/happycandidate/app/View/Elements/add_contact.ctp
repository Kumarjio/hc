<!-- Modal -->
<div id="add_contact" title="Add Contacts" style="display:none;">
	<div class="modal-dialog add_contact">
		<div class="modal-content">
			<!--<div class="modal-header">
				<h3 id="myModalLabel">Add Contact</h3>
			</div>-->
			<div class="modal-body delete_modal" id="portal_registration">
				<?php
					echo $this->element('contact_add_tpl');
				?>
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
		$( "#add_contact" ).dialog({
			autoOpen: false,
			height: 730,
			width: 950,
			modal: true,
			buttons: {
				Cancel: function() {
					$(this).dialog( "close" );
				}
			},
			close: function() {
				
			}
		});
	});

</script>