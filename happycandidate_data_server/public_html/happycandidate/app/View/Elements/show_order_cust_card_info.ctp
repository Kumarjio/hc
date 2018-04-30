
<div class="form-group group-fix">
    <label class="control-label col-xs-12 col-sm-12 col-md-4">Payment Method: <span class="form-required">*</span></label><!-- 
    --><div class="col-xs-12 col-sm-12 col-md-8 payment-method">
        <div class="cards-container">
            <input type="radio" name='card_type' id='card_type' value="Visa" class="validate[required]" checked="checked"><!-- 
            --><span>Credit Card</span><!-- 
            --><div class="credit-cards-icons">
                <a href="#" class="icon-visa"></a>
                <a href="#" class="icon-master-card"></a>
                <a href="#" class="icon-discover"></a>
                <a href="#" class="icon-american-express"></a>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="card-number">Card Number: <span class="form-required">*</span></label><!-- 
    --><input class="col-xs-12 col-sm-12 col-md-8 validate[required]" type="text" name="card_number" id="card_number" value="4111111111111111"  placeholder="XXXX-XXXX-XXXX-XXXX" required >
</div>
<div class="form-group">
    <label class="control-label col-xs-12 col-sm-12 col-md-4">Expiration Date: <span class="form-required">*</span></label><!-- 
    --><div class="select-container-small">
        <select id="exp_month" name="exp_month" class="form-control extra-small validate[required]">
            <option value="01" label="January">January</option>
            <option value="02" label="February">February</option>
            <option value="03" label="March">March</option>
            <option selected="selected" value="04" label="April">April</option>
            <option value="05" label="May">May</option>
            <option value="06" label="June">June</option>
            <option value="07" label="July">July</option>
            <option value="08" label="August">August</option>
            <option value="09" label="September">September</option>
            <option value="10" label="October">October</option>
            <option value="11" label="November">November</option>
            <option value="12" label="December">December</option>
        </select><!-- 
        --><select id="exp_year" name="exp_year" class="form-control extra-small validate[required]" >
            <option value="15" label="15">2015</option>
            <option value="16" label="16">2016</option>
            <option value="17" label="17">2017</option>
            <option selected="selected" value="18" label="18">2018</option>
            <option value="19" label="19">2019</option>
            <option value="20" label="20">2020</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="cvv-code">CVV Code: <span class="form-required">*</span></label><!-- 
    --><input class="col-xs-12 col-sm-12 col-md-8 extra-small validate[required]" type="text" name="security_code" id="security_code" value="" placeholder="XXX" required >
</div>

<!--<div class="form-group">
    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="cvv-code">Total Amount: </label> 
    
    <span id="totalAmount">USD $0.00</span>
</div>-->



<!--<div class="form-group">
    <div class="col-md-4 group-fix"></div>
    <div class="col-md-8 button-container">
        <input type="hidden" id="vendorId" value="<?php echo $vendorId;?>">
        <button type="submit"  name="submit_<?php echo $intPortalId; ?>" id="submit_<?php echo $intPortalId; ?>" onclick="fnSubmitCheckout(this);return false;" class="btn btn-primary">Complete Secure Order &gt;</button>
    </div>
</div>-->

<style>
    .form-check-label input{
        width: 0% !important;
        height: 10px !important;
    }
    .form-check-label {
        font-family: OpenSansRegular,Georgia,serif !important;
        font-size: 14px !important;
        font-weight: normal !important;
    }
</style>

<!--<script>
    $(document).ready(function(){
       var total_amount = $("#total_amount").val(); 
        $("#totalAmount").html("<b>USD $"+total_amount+"</b>"); 
    });
</script>-->


