<div class="container-fluid bg-lightest-grey">

		<div class="row">
			<div class="col-md-1"></div>

			<div class="col-md-10 bg-lightest-grey">
				<div class="page-header">
                                    <a href="javascript:void(0);" class="link-default" onclick="goBack();"><span class="glyphicon glyphicon-chevron-left"></span> Continue Shopping </a>
					<h2>Review My Cart</h2>
<!--					<p>
						The following topics will help you stand out from job seekers competing for the same opportunity.
					</p>-->
				</div>
				<p class="tabloader" style="display:none;"></p>
		<div id="cartdetail"></div>
                            <!--<div class="cart-datas">
                                    <div class="cart-list-container">

                                            <table>
                                                    <tr>
                                                            <th></th>
                                                            <th>Name</th>
                                                            <th>Vendor Name</th>
                                                            <th>Unit Price</th>
                                                            <th>Quantity</th>
                                                            <th>Amount</th>
                                                    </tr>
                                                    <tr id="cart-item1">
                                                            <td class="close-cart-item">
                                                                    <a href="#cart-item1">
                                                                            <img src="images/icon-delete-notification.png" alt="" />
                                                                    </a>
                                                            </td>
                                                            <td class="cart-item-description">
                                                                    <h3>Set Realistic Expectations</h3>
                                                                    <p>Description here</p>
                                                            </td>
                                                            <td class="cart-item-price">$70.00</td>
                                                            <td>
                                                                    <input class="cart-item-quantity" type="text" name="cart-good1-quantity" value="" placeholder="1">
                                                            </td>
                                                            <td class="cart-item-price-total">$70.00</td>
                                                    </tr>

                                            </table>
                                    </div>
                                    <div class="cart-list-options-container">
                                            <div class="cart-list-options">
                                                    <span>Discount:</span>
                                                    <a href="#" class="link-primary">Apply coupon</a>
                                            </div>
                                            <div class="cart-list-total">
                                                    <p>Total: <span>$510.00</span></p>
                                            </div>
                                    </div>

                            </div>
                            <div class="cart-item-button-container">
                                            <button type="button" class="btn btn-primary btn-form">Continue <span class="glyphicon glyphicon-chevron-right"></span></button>
                            </div>
                    </div>	-->				
			<div class="col-md-1"></div>
		</div>
	</div>
	</div>
	

<!--<div class="wrapper">
	<div id="portal_registration">
		<h2 id="jobn" style="padding:0;margin-bottom:30px;">Shop</h2>
		<p class="tabloader" style="display:none;"></p>
		<div id="cartdetail"></div>
	</div>
</div>-->
<script type="text/javascript">
    $(document).ready(function () {
        fnShowCart('<?php echo $intPortalId ;?>');
    });
    function goBack() {
        window.history.back();
    }
</script>
<style>
.btn-form {
  padding: 9px 19px 10px 23px !important;
}
.examples, body {
    vertical-align: unset !important;
}
</style>