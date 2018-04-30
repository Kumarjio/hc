<?php // echo '<pre>';print_r($arrContentDetail[0]['EnrolledUser']);die;?>
<div class="container-fluid bg-lightest-grey">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10 bg-lightest-grey">
            <?php
            $resourceurl = Router::url('/', true) . "resources/index/" . $intPortalId;
            ?>
            <div class="page-header">
                <a href="<?php echo $resourceurl;?>" class="link-default"><span class="glyphicon glyphicon-chevron-left"></span>Back to Resources</a>
                <!--<a style="cursor: pointer" onclick="goBack()" class="link-default"><span class="glyphicon glyphicon-chevron-left"></span>Back to Resources</a>-->
            </div>
            <div class="resource-detail-container">
                <?php
                if (is_array($arrContentDetail[0]['Resourceimages']) && (count($arrContentDetail[0]['Resourceimages']) > 0)) {
                    ?>
                    <img name="product_image" id="product_image" src="<?php echo Router::url('/', true); ?>/productfiles/<?php echo $arrContentDetail[0]['Resourceimages']['product_image']; ?>" alt="Product Image Here" class="pro-img" /*style="border:solid 2px grey;width:50%;"*/ />
                    <?php
                } else {
                    if ($arrContentDetail[0]['Vendorservice']['vendor_service_id'] == "51") {
                        ?>
                             <img name="product_image" id="product_image" src="<?php echo Router::url('/', true); ?>productfiles/index.png" alt="Resources Image Here" class="pro-img" /*style="border:solid 2px grey;width:50%;"*/ />
                             <?php
                         } else {
                             ?>
                             <img name="product_image" id="product_image" src="<?php echo Router::url('/', true); ?>productfiles/no-resourses-image.jpg" alt="Resources Image Here" class="pro-img" /*style="border:solid 2px grey;width:50%;"*/ />
                             <?php
                         }
                     }
                     ?>

                     <div class="resource-detail-info-container">
                    <h3><?php echo stripslashes($arrContentDetail[0]['Resources']['product_name']); ?></h3>
                    <!--<p><span>Type</span> - <?php echo htmlspecialchars_decode(stripslashes($arrContentDetail[0]['Resources']['product_type'])); ?></p>-->
                    <?php echo htmlspecialchars_decode(stripslashes($arrContentDetail[0]['Content']['content'])); ?>
                    
                    <div class="resources-footer">
                        <div class="prices-container">                         
                            <?php if($arrContentDetail[0]['Resources']['discount_cost'] !='' && $arrContentDetail[0]['Resources']['discount_cost'] !='0.00'){?>
                            <p class="resources-price">Regular Price <s>$<?php echo $arrContentDetail[0]['Resources']['product_cost']; ?></s></p>
                        <?php }else{?>
                            <p class="resources-price">Regular Price $<?php echo $arrContentDetail[0]['Resources']['product_cost']; ?></p>
                        <?php } ?>
                        <?php if($arrContentDetail[0]['Resources']['discount_cost'] !='' && $arrContentDetail[0]['Resources']['discount_cost'] !='0.00'){?>
                            <p class="resources-today">Today $<?php echo $arrContentDetail[0]['Resources']['discount_cost']; ?></p>
                        <?php } ?>
                            
                        </div>

                        <input type="hidden" id="vendor_id" value="<?php echo $arrContentDetail[0]['Vendorservice']['vendor_id']; ?>">
                        <button class="btn-custom-small" id="add_to_cart_<?php echo $arrContentDetail[0]['Vendorservice']['vendor_service_id'] . "_" . $intPortalId; ?>"  href="javascript:void(0);" onclick="fnAddtocart(this);">Add To Cart</button>
                        <button class="btn btn-system" id="checkout_<?php echo $intPortalId; ?>_<?php echo $arrContentDetail[0]['Vendorservice']['vendor_service_id']; ?>"  href="javascript:void(0);" onclick='fnCheckOut(this);'>Buy Now</button>

                        <div class="credit-cards-icons-small">
                            <a href="javascript:void(0);" class="icon-visa-small">&nbsp;</a> 
                            <a href="javascript:void(0);" class="icon-paypal-small">&nbsp;</a> 
                            <a href="javascript:void(0);" class="icon-master-card-small">&nbsp;</a> 
                            <a href="javascript:void(0);" class="icon-discover-small">&nbsp;</a> 
                            <a href="javascript:void(0);" class="icon-american-express-small">&nbsp;</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.resource-detail-info-container p').addClass('resource-detail-description');
     
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
    
    function goBack() {
        window.history.back();
    }
    
</script>

<style>
.pro-img {
    background-color: #f9f9f9;
    display: inline-block;
  height: 200px;
  max-width: 200px;
    vertical-align: top;
    width: 37%;
}
.prices-container {
    width: 290px !important;
}
/*.resource-detail-info-container p {
  min-height: 45px !important;
}*/
.examples{
    margin-bottom:250px !important;
}
.resource-detail-info-container p{
    margin-bottom:10px !important;
}
.resources-footer{
    background: none !important;
}
.resource-detail-info-container {
  width: 75% !important;
}
.examples, body {
     vertical-align: unset !important; 
}
</style>