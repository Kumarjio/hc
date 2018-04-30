<!-- Modal -->
<div id="pay_order" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Add Payment</h3>
				<input type="hidden" name="pay_for" id="pay_for" value="" />
			</div>
			<div class="modal-body media_modal col-md-12">
				<form method="POST" action="">
					<div class="form-group">
						<label for="name" class="control-label col-xs-12 col-sm-12 col-md-4">Enter Amount: <span class="form-required">*</span></label>
						<input type="text" name="amount" id="amount" class="form-control" />
					</div>
				</form>
			</div>
			<?php
				//echo "---".$seekerid;
			?>
			<div class="modal-footer">
				<button id="assignbtn" class="btn btn-primary" onclick="return fnAddPaymentFurther();">Add</button> &nbsp;
				<button id="assignbtn" class="btn btn-default" onclick="return fnClosePayment();">Close</button> &nbsp;
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
	
	function fnClosePayment()
	{
		$("#pay_order").modal('hide');
	}
	
	function fnAddPaymentFurther()
	{
		var intProductId = $('#pay_for').val();
		var intAmount = $('#amount').val();
		var dataStr = "vendorid="+intProductId+"&amount="+intAmount;
		$('.cms-bgloader-mask').show();//show loader mask
		$('.cms-bgloader').show(); //show loading image
			$.ajax({ 
				type: "POST",
				url: strBaseUrl+"vendorsales/addpayment/"+intProductId,
				dataType: 'json',
				data:dataStr,
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						$("#pay_order").modal('hide');
						//alert(data.content)
						//$('.tabloader').hide();
						//$('#product_list_notification').html(data.message);
						//$('#order_status_'+intProductId).text('Closed');
						//$('.cms-bgloader-mask').hide();//show loader mask
						//$('.cms-bgloader').hide(); //show loading image
						alert(data.messagenew);
						window.location.reload();
					}
					else
					{
						$('#product_list_notification').html(data.message);
						$("#pay_order").modal('hide');
						$('.cms-bgloader-mask').hide();//show loader mask
						$('.cms-bgloader').hide(); //show loading image
					}
				}
		});
	}
</script>