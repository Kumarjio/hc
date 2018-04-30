<?php
   $vendor_id = $arrProductContent['0']['Vendorservice']['vendor_id'];
   $service_id = $arrProductContent['0']['Vendorservice']['service_id'];
?>
<div class="form-group">
    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="name">Vendor Name: <span class="form-required">*</span></label>

    <select id="vendor" name="vendor" class="col-xs-12 col-sm-12 col-md-8">
        <option value="">--Choose Vendor--</option>
        <?php
        if (is_array($arrVendorServiceDetail['Vendors']) && (count($arrVendorServiceDetail['Vendors']) > 0)) {
            foreach ($arrVendorServiceDetail['Vendors'] as $arrVendor) {
                ?>
                <option <?php
                        if ($vendor_id == $arrVendor['Vendors']['vendor_id']) {
                            echo "selected='selected'";
                        }
                        ?> value="<?php echo $arrVendor['Vendors']['vendor_id']; ?>"><?php echo $arrVendor['Vendors']['vendor_name']; ?></option>
                <?php
            }
        }
        ?>
    </select>
</div>

<div class="form-group">
    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="name">Service Name: <span class="form-required">*</span></label>
    <select id="service" class="col-xs-12 col-sm-12 col-md-8" name="service" onchange="fnGetServiceDetails();">
        <option value="">--Choose Service--</option>
        <?php
        if (is_array($arrVendorServiceDetail['Services']) && (count($arrVendorServiceDetail['Services']) > 0)) {
            foreach ($arrVendorServiceDetail['Services'] as $arrResource) {
                ?>
        <option <?php
                if ($service_id == $arrResource['Resources']['productd_id']) {
                    echo "selected='selected'";
                }
                ?> value="<?php echo $arrResource['Resources']['productd_id']; ?>"><?php echo $arrResource['Resources']['product_name']; ?></option>
                <?php
            }
        }
        ?>
    </select>	
</div>
