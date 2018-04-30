<?php
echo $this->Html->script('cascade');
?>	
<div class="form-group">
    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="customer_fname"> First Name: <span class="form-required">*</span></label><!-- 
    --><input class="col-xs-12 col-sm-12 col-md-8 validate[required]" type="text" name='customer_fname' id='customer_fname' value='<?php echo $arrCustomerInformation['candidate_first_name']; ?>' required>
    <input type='hidden' name='customer_id' id='customer_id' value='<?php echo $arrCustomerInformation['candidate_id']; ?>' />
</div>
<div class="form-group">
    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="customer_lname"> Last Name: <span class="form-required">*</span></label><!-- 
    --><input class="col-xs-12 col-sm-12 col-md-8 validate[required]" type="text" name='customer_lname' id='customer_lname' value='<?php echo $arrCustomerInformation['candidate_last_name']; ?>'  required>
</div>
<div class="form-group">
    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="address1">Address 1: <span class="form-required">*</span></label><!-- 
    --><input class="col-xs-12 col-sm-12 col-md-8 validate[required]" type="text" placeholder="" name="customer_address" id="customer_address"  value="<?php echo $arrCustomerInformation['candidate_address']; ?>"  required>
</div>

<div class="form-group">
    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="Postal Code">Postal Code: <span class="form-required">*</span></label><!-- 
    --><input type="text" class="col-xs-12 col-sm-12 col-md-8 validate[required]" placeholder=""onchange="fnGetLocationDetailFromZipFront()" name="txt_post_code" id="txt_post_code" >
</div>

<div class="form-group">
    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="Country">Country <span class="form-required">*</span></label><!-- 
    --><select class="country-drop" name="txt_country" id="txt_country" onchange="javascript: fnGetLocationDetailFromCountry();">
        <?php
        foreach ($countrylist as $countryid => $country) {
            $cntname = $country;
            $id = $countryid;
            ?>
            <option value="<?php echo $id; ?>"><?php echo $cntname; ?></option>
            <?php
        }
        ?>
    </select>
</div>

<div class="form-group" id="stateprovince_auto">
    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="State">State / Province : <span class="form-required">*</span></label><!-- 
    --><input class="col-xs-12 col-sm-12 col-md-8 validate[required]" name="txtstateprovince" id="txtstateprovince" type="text" size="30" maxlength="100" />
</div>
<div class="form-group" id="county_auto">
    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="City">City: </label><!-- 
    --><input name="txtcounty" id="txtcounty" type="text" size="30" maxlength="100" value=""  class="col-xs-12 col-sm-12 col-md-8 validate[required]"/>
</div>
<div class="form-group">
    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="phone">Email:</label><!-- 
    --><?php echo $arrCustomerInformation['candidate_email']; ?>
</div>
<?php
$arrProducts = $arrContentDetail;

if (is_array($arrProducts[0]['order_detail']) && (count($arrProducts[0]['order_detail']) > 0)) {
    $intTotal = "";
    ?>
    <input type='hidden' name='order_id' id='order_id' value="<?php echo $arrProducts[0]['Resourceorder']['resource_order_id'] ?>" />
    <?php
    $intForCnt = 0;
    foreach ($arrProducts[0]['order_detail'] as $arrProduct) {
        //$strCartProductStrngs .= "<tr id='".$arrProduct['resource_order_detail']['order_id']."_".$arrProduct['resource_order_detail']['order_detail_id']."'><td>".$arrProduct['resource_order_detail']['product_name']."</td><td>".$arrProduct['resource_order_detail']['vendor_name']."</td><td>".$arrProduct['resource_order_detail']['product_unit_cost']."</td><td>1</td><td>&nbsp;&nbsp;&nbsp;".($arrProduct['resource_order_detail']['product_unit_cost'] * 1)."</td><td><a href='javascript:void(0);' id='remove_".$arrProduct['resource_order_detail']['order_id']."_".$arrProduct['resource_order_detail']['order_detail_id']."_".$intPortalId."' onclick='fnRemoveItemFromOrder(this)'>Remove</a></td></tr>";
        $intTotal = $intTotal + ($arrProduct['resource_order_detail']['product_unit_cost'] * 1);
        $intForCnt++;
    }
    ?>
    <!--<input type='hidden' name='total_amount' id='total_amount' value="<?php echo $intTotal; ?>" />-->
    <?php
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#txt_country').val('<?php echo $arrEmployerDetail[0]['Employer']['employer_country']; ?>');
    });
</script>
<style>
    .panel-slider input, select {
        width: 343px !important;
    }
</style>