<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
<!--    <div class="product-header">
        <?php
        
        if($intvendorserviceId !=''){
        $arrshowProducts = $arrContentDetail;
        
        if (is_array($arrshowProducts[0]['order_detail']) && (count($arrshowProducts[0]['order_detail']) > 0)) {
            $intTotal = "";
            ?>
            <?php
            $intForCnt = 0;
            foreach ($arrshowProducts[0]['order_detail'] as $arrshowProduct) {
                $intForCnt++;
                if ($intForCnt == 1) {
                    $product_name = $arrshowProduct['products']['product_name'];
                    $product_cost = $arrshowProduct['products']['product_cost'];
                    $discount_cost = $arrshowProduct['products']['discount_cost'];
                    $save_cost = (($arrshowProduct['products']['product_cost']) - ($arrshowProduct['products']['discount_cost']));
                    ?>
                    <h3><?php echo $product_name; ?></h3>
                    <p class="info"><i>Regular Price $<?php echo $product_cost;?></i> <?php if($discount_cost !='') { ?>| <b>Discount Price $<?php echo $discount_cost ?></b><?php } ?></span></p>
                    <p><?php echo htmlspecialchars_decode(stripslashes($arrRContentDetails[0]['Content']['content_intro_text']));?></p>
                    <hr>
                    <?php
                }
            }
            ?>
            <?php
        }
        }else{
            foreach ($arrCartResources as $arrshowProduct) {
                    $product_name = $arrshowProduct['Resourcecart']['product_name'];
                    $product_cost = $arrshowProduct['Resourcecart']['product_cost'];
                    $discount_cost = $arrshowProduct['Product'][0]['Resources']['discount_cost'];
                    $save_cost = (($product_cost) - ($discount_cost));
                    
                    ?>
                    <h3><?php echo $product_name; ?></h3>
                    <p class="info"><i>Regular Price $<?php echo $product_cost;?></i> <?php if($discount_cost !='') { ?>| <?php if($discount_cost !='' && $discount_cost !='0.00'){ ?><b>Discount Price $<?php echo $discount_cost ?></b><?php } } ?></span></p>
                    <p><?php echo htmlspecialchars_decode(stripslashes($arrshowProduct['content'][0]['Content']['content_intro_text']));?></p>
                    <hr>
                    <?php
                }
            
        }
        ?>
    </div>-->
    <div class="product-body">
        <div class="product-body-item">
            <div class="item-money-back"></div>
            <h4>Iron-Clad 100% Money Back Guarantee</h4>
            <p>If you are not satisfied with your purchase for any reason, you can take advantage of our 30 day money back guarantee.</p>
            <p>No questions asked, no reason needed - even if you are a few days late with the request, we will understand and return the full amount you paid.</p>
        </div>
        <div class="product-body-item">
            <div class="item-secure"></div>
            <h4>Secure Payment</h4>
            <p>This website utilizes some of the most advanced techniques to protect your information and personal data.</p>
            <p>These include technical, administrative and even physical safeguards against unauthorized access, misuse and improper disclosure.</p>
        </div>
        <div class="product-body-item">
            <div class="item-privacy"></div>
            <h4>Privacy</h4>
            <p>We take privacy very seriously at Sovereign Man and we will never share or trade information that you provide us (including e-mail addresses). Your connection is encrypted and secure.</p>
        </div>
        <?php $strTermsUrl = Router::url(array('controller' => 'resources', 'action' => 'termsandprivacy',$intPortalId), true); ?>
        <div class="product-body-item">
            <div class="item-privacy"></div>
            <h4><a class="agree-link" href="<?php echo $strTermsUrl; ?>" class="link-primary" target="_blank">Terms & Condition</a></h4>
            <p>Please <a class="agree-link" href="<?php echo $strTermsUrl; ?>" class="link-primary" target="_blank">click here</a> to following link to indicate that you have read and agree to the terms presented in the resources terms and conditions agreement</p>
        </div>

    </div>
</div>
<style>
    .form-check-label {
        margin-left: 71px;
    }
</style>
<script>
    $(document).ready(function(){
        $('p span').each(function() {
            var $this = $(this);
            if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
            $this.remove();
        });
      
        $('p').each(function() {
            var $this = $(this);
            if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
            $this.remove();
        });

    });
</script>