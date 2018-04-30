<!-- Modal -->
<div id="subvendorModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Vendor User List</h3>
				<input type="hidden" name="vendor_order_id" id="vendor_order_id" value="" />
				<input type="hidden" name="action" id="action" value="assign" />
			</div>
			<div class="modal-body media_modal col-md-12">
				<div class="alert alert-info fade" id="mssg" style="display:none;">
					<a href="#" class="close" aria-label="close">&times;</a>
				  <strong>Info! </strong><span id="mssgtext"></span>
				</div>
				<form id="fontform" name="fontform">
					<div class="form-group">
						<div class="col-md-12">
							<div class="col-md-3">
								Choose Vendor Users:
							</div>
							<div class="col-md-9">
								<?php
									//print("<pre>");
									//print_r($arrSubVendors);
								?>
								<select class="form-control" name="vendoruser" id="vendoruser">
									<?php
										foreach($arrSubVendors as $arrVendor)
										{
											?>
												<option value="<?php echo $arrVendor['Vendors']['vendor_id'];?>"><?php echo $arrVendor['Vendors']['vendor_first_name']." ".$arrVendor['Vendors']['vendor_last_name'];?></option>
											<?php
										}
									?>
								</select>
							</div>
						</div>
					</div>
				</form>
			</div>
			<?php
				//echo "---".$seekerid;
			?>
			<div class="modal-footer">
				<button id="assignbtn" class="btn btn-primary" onclick="return fnAssignOrderToSubVendor();">Assign</button>
				<button id="unassignbtn" style="display:none;" class="btn btn-primary" onclick="return fnUnAssignOrderToSubVendor();">UnAssign</button>
			</div>
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