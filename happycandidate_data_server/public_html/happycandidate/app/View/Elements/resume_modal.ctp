<!-- Modal -->
<div id="resumeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">CV or Resume Builder</h3>
				<input type="hidden" name="request_media_from" id="request_media_from" value="" />
			</div>
			<div class="modal-body media_modal">
				<div class="alert alert-info fade" id="mssg" style="display:none;">
					<a href="#" class="close" aria-label="close">&times;</a>
				  <strong>Info! </strong><span id="mssgtext"></span>
				</div>
				<div>Name your CV or resume so that you are able to differentiate your various versions.</div>
				<p><label>Name Your Resume: </label><span><input type="text" name="resume_name" id="resume_name" class="form-control col-md-4"/></p>

				<p>&nbsp;</p>
				<!--<p style="margin-bottom:0px;"><label>Thank You</label></p>-->
				<div class="row">
					<button style="float:right;margin-right:2%;" class="btn btn-primary" onclick="return submitExpFromNew(<?php echo $intPortalId?>);">Go</button>
				</div>
			</div>
			<!--<div class="modal-footer">
				<button class="btn btn-primary" onclick="return submitExpFromNew(<?php echo $intPortalId?>);">Done</button>
			</div>-->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.close').click(function () {
			$('#mssg').hide();
		});
	});
</script>