<div class="container-fluid bg-lightest-grey">

    <div class="row">
        <div class="col-md-1"></div>

        <div class="col-md-10 bg-lightest-grey">
            <div class="page-header cart-order">
                <h2>Complete Order</h2>
<!--                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam accusantium vitae, culpa odio quod corrupti est asperiores nobis ullam recusandae!
                </p>-->
                <div id="checkout_messages"></div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 cart-order-pad-fix">
                <form name="checkoutfrm" id="checkoutfrm">
                <div class="cart-datas-overflow">
                    
                        <input type="hidden" name="portal_id" id="portal_id" value="<?php echo $intPortalId; ?>" />
                        <div class="form-section">
                            <h3>1. Billing Information</h3>

                            <div class="col-md-11 group-fix-visible">
                                <?php
                                echo $this->element('show_order_cust_info');
                                ?>
                            </div>
                            <div class="col-md-1 group-fix-hide"></div>
                        </div>

                        <div class="form-section">
                            <h3>2. Payment Method</h3>

                            <div class="col-md-11 group-fix-visible">
                                <?php
                                echo $this->element('show_order_cust_card_info');
                                ?>
                            </div>
                            <div class="col-md-1 group-fix-hide"></div>
                        </div>
                        
                </div>
                
                <!--cart-dates-start-->
                <div class="cart-datas">
                    <div class="cart-list-container">
                        <table>
                            <tr>
                                <th></th>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                            <?php 
                            
                            if($intvendorserviceId !=''){
                                $arrshowProducts = $arrContentDetail;
                            if (is_array($arrshowProducts[0]['order_detail']) && (count($arrshowProducts[0]['order_detail']) > 0)) {
                                $intTotal = "";
                                ?>
                                <?php
                                $intTotalDefault =0;
                                $intForCnt = 0;
                                foreach ($arrshowProducts[0]['order_detail'] as $arrshowProduct) {
                                    $intForCnt++;
                                    if ($intForCnt == 1) {
                                        $product_name = $arrshowProduct['products']['product_name'];
                                        $product_cost = $arrshowProduct['products']['product_cost'];
                                        $discount_cost = $arrshowProduct['products']['discount_cost'];
                                        $save_cost = (($arrshowProduct['products']['product_cost']) - ($arrshowProduct['products']['discount_cost']));
                                        if($discount_cost !='' && $discount_cost !='0.00'){ 
                                            $intTotal = $discount_cost;
                                        }else{
                                            $intTotal = $product_cost;
                                        }
                                        
                                        ?>
                                <tr id="cart-item1">
                                <td class="close-cart-item"></td>
                                <td class="cart-item-description">
                                    <?php echo $product_name; ?></td>
                                <?php if($discount_cost !='' && $discount_cost !='0.00'){ ?>
                                    <td class="cart-item-price">$<?php echo $discount_cost;?></td>
                                <?php }else{?>
                                    <td class="cart-item-price">$<?php echo $product_cost;?></td>
                                <?php } ?>
                                <td>1</td>
                                <?php if($discount_cost !='' && $discount_cost !='0.00'){ ?>
                                <td class="cart-item-price-total" style="font-weight: normal">$<?php echo $discount_cost;?></td>
                                <?php }else{ ?>
                                    <td class="cart-item-price-total" style="font-weight: normal">$<?php echo $product_cost;?></td>
                                <?php }
                                    }
                                    }
                                }
                                ?>
                            </tr>
                            <?php }else{
                                $intTotalDefault = 0;
                                foreach ($arrCartResources as $arrshowProduct) {
                                $product_name = $arrshowProduct['Resourcecart']['product_name'];
                                $product_cost = $arrshowProduct['Resourcecart']['product_cost'];
                                $discount_cost = $arrshowProduct['Product'][0]['Resources']['discount_cost'];
                                $save_cost = (($product_cost) - ($discount_cost));
                                $intTotal += (($intTotalDefault) + ($arrshowProduct['Resourcecart']['product_cost']));
                            ?>
                            <tr id="cart-item1">
                                <td class="close-cart-item"></td>
                                <td class="cart-item-description">
                                    <?php echo $product_name; ?></td>
                                <?php if($discount_cost !='' && $discount_cost !='0.00'){ ?>
                                    <td class="cart-item-price">$<?php echo $discount_cost;?></td>
                                <?php }else{?>
                                    <td class="cart-item-price">$<?php echo $product_cost;?></td>
                                <?php } ?>
                                <td>1</td>
                                <?php if($discount_cost !='' && $discount_cost !='0.00'){ ?>
                                    <td class="cart-item-price-total" style="font-weight: normal">$<?php echo $discount_cost;?></td>
                                <?php }else{ ?>
                                    <td class="cart-item-price-total" style="font-weight: normal">$<?php echo $product_cost;?></td>
                                <?php } ?>
                            </tr>
                            <?php } } ?>
                        </table>
                    </div>
                    <div class="cart-list-options-container">
                        <div class="col-sm-6"></div>

                        <div class="col-sm-6"> 
<!--                            <div class="cart-list-options">
                                <span>Discount:</span>
                                <a href="#" class="link-primary">Apply coupon</a>
                            </div>-->
                            <div class="cart-list-total">
                                <p>Total: <span style="font-weight: bold">$<?php echo $intTotal;?></span></p>
                                <p style="font-size: 14px !important;">(Price listed in U.S. currency)</p>
                                <input type='hidden' name='total_amount' id='total_amount' value="<?php echo $intTotal; ?>" />
                            </div>

                            <div class="form-group">

                                <div class="group-fix"></div>
                                <div class="button-container">
                                    <input type="hidden" id="vendorId" value="<?php echo $vendorId;?>">
                                    
                                    <button type="submit"  name="submit_<?php echo $intPortalId; ?>" id="submit_<?php echo $intPortalId; ?>" onclick="fnSubmitCheckout(this);return false;" class="btn btn-primary">Complete Secure Order &gt;</button>
                                </div>
                            </div>
                        </div>
                        <div class="tos col-sm-12">*By purchasing I agree to the TOS</div>
                    </div>
                </div>
                <!--cart-dates-ends-->
                </form>
            </div>
            <?php
            echo $this->element('show_cart_product_info');
            ?>

        </div>					
        <div class="col-md-1"></div>
    </div>
</div>


	
<style>
/*    .form-check-label input{
        width: 0% !important;
        height: 10px !important;
    }*/
.form-check-label input{
        width: 13% !important;
    height: 19px !important;
}
    .form-check-label {
        font-family: OpenSansRegular,Georgia,serif !important;
        font-size: 14px !important;
        font-weight: normal !important;
    }
    
    .form-signin label{
        width: 67% !important;
    }
    .form-section .button-container button {
        width: 60% !important;
    }
</style>

<script type="text/javascript">
	$(document).ready(function () {
		fnShowCart('5')
	});
</script>


<script type="text/javascript">
	function fnLoadConatctAdder()
	{
		$("#add_contact").dialog("open");
		if($('#contact_add_form').length>0)
		{
			$('#contact_add_form')[0].reset();
		}
	}
	
	function fnShowContactFilter()
	{
		$('#contact_filteration_strip').slideToggle('slow');
	}
</script>
<script>
    $(document).ready(function(){
       var total_amount = $("#total_amount").val(); 
        $("#totalAmount").html("<b>USD $"+total_amount+"</b>"); 
    });
</script>