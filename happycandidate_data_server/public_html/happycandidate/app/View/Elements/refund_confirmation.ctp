<!-- Modal -->
<div id="refund_order" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Cancel & Refund Order</h3>
				<input type="hidden" name="refund_for" id="refund_for" value="" />
			</div>
			<div class="modal-body media_modal col-md-12">
				<div class="alert alert-info fade" id="mssg" style="display:none;">
					<a href="#" class="close" aria-label="close">&times;</a>
				  <strong>Info! </strong><span id="mssgtext"></span>
				</div>
				<span> Are you sure, you want to proceed with cancellation & refund on this order? </sapn>
			</div>
			<?php
				//echo "---".$seekerid;
			?>
			<div class="modal-footer">
				<button id="assignbtn" class="btn btn-primary" onclick="return fnRefundOrder();">Initiate</button> &nbsp;
				<button id="assignbtn" class="btn btn-default" onclick="return fnCloseRefund();">Close</button> &nbsp;
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
	
	function fnCloseRefund()
	{
		$("#refund_order").modal('hide');
	}
	
	function fnRefundOrder()
	{
		var intProductId = $('#refund_for').val();
		$('.cms-bgloader-mask').show();//show loader mask
		$('.cms-bgloader').show(); //show loading image
			$.ajax({ 
				type: "GET",
				url: strBaseUrl+"vendorservices/initiateRefund/"+intProductId,
				dataType: 'json',
				data:"",
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						//alert(data.content)
						//$('.tabloader').hide();
						//$('#product_list_notification').html(data.message);
						//$('#order_status_'+intProductId).text('Closed');
						$('.cms-bgloader-mask').hide();//show loader mask
						$('.cms-bgloader').hide(); //show loading image
						alert(data.messagenew);
						window.location.reload();
					}
					else
					{
						$('#product_list_notification').html(data.message);
						$('.cms-bgloader-mask').hide();//show loader mask
						$('.cms-bgloader').hide(); //show loading image
					}
				}
		});
	}
</script>