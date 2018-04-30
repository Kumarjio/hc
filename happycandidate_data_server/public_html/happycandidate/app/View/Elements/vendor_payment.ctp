<?php
echo $this->Html->script('vendor_company_edit');
?>
<script type="text/javascript">
    function fnSubmitPayment()
    {

        var isValidated = $('#payment_add_form').validationEngine('validate');

        if (isValidated == false)
        {
            return false;
        } else
        {

            var pageurl = "<?php echo Router::url('/', true) . "vendoraccount/editpayout"; ?>";
            var pagetype = "POST";
            var pageoptions = {
                beforeSubmit: function (formData, jqForm, options) {
                    $('#loader').show();

                },
                success: function (responseText, statusText, xhr, $form) {

                    if (responseText.status == "success")
                    {

                        $('#messageshow').html(responseText.message);

                    } else
                    {
                        $('#loader').hide();
//                        $('#contact_form_messages').css('color', '#E04B39');
//                        $('#contact_form_messages').text(responseText.message);
                        $('#messageshow').html(responseText.message);
                    }

                },
                url: pageurl, // override for form's 'action' attribute 
                type: pagetype, // 'get' or 'post', override for form's 'method' attribute 
                dataType: 'json'        // 'xml', 'script', or 'json' (expected server response type) 
            }
            $('#payment_add_form').ajaxSubmit(pageoptions);
            return false;
        }
    }
</script>

<!--<div class="users index">
<div class="edit-panel">
<div id="page-title">
        <h3>Edit Vendor Company Details</h3>
</div>-->

<div class="form-container vendor-edit-profile">
    <div id="messageshow"></div>
    <p>All career portal vendor payments will be sent to you in US dollars.</p>
    <form role="form" id="payment_add_form" name="payment_add_form">					
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="last-name" class="control-label">Make Payments To: <span class="form-required">*</span></label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <?php
                echo $this->Form->input('payoutto', array('class' => 'validate[required]', 'label' => false, 'value' => $arrCompleteLoggedInUserDetail[0]['Vendorpayout']['payout_to']));
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="last-name" class="control-label">Tax ID Number or <br/>Business Number: <span class="form-required">*</span></label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <?php
                echo $this->Form->input('taxid', array('class' => 'validate[required,custom[onlyNumberSp]]','value' => $arrCompleteLoggedInUserDetail[0]['Vendorpayout']['tax_id'], 'label' => false));
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="bank-account-number" class="control-label"> Bank Account Number: <span class="form-required">*</span></label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <?php
                echo $this->Form->input('bankaccountnumber', array('class' => 'validate[required,custom[onlyNumberSp]]','value' => $arrCompleteLoggedInUserDetail[0]['Vendorpayout']['bank_account_number'], 'label' => false));
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="bank-routing-number" class="control-label">Bank Routing Number: <span class="form-required">*</span></label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <?php
                echo $this->Form->input('bankroutingnumber', array('class' => 'validate[required,custom[onlyNumberSp]]','value' => $arrCompleteLoggedInUserDetail[0]['Vendorpayout']['bank_routing_number'], 'label' => false));
                ?>
            </div>
        </div>

        <!--<div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-3">
                        <label for="email" class="control-label">Minimum Check Amount: <span class="form-required">*</span></label>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9">
        <?php
        echo $this->Form->input('minamt', array('class' => 'validate[required]', 'label' => false, 'value' => $arrCompleteLoggedInUserDetail[0]['Vendorpayout']['minimum_check_amt']));
        ?>
                </div>
        </div>
        <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-3">
                        <label for="phone" class="control-label">Commission Pct:</label>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9">
        <?php
        echo $this->Form->input('compct', array('label' => false, 'value' => $arrCompleteLoggedInUserDetail[0]['Vendorpayout']['commission_pct']));
        ?>
                </div>
        </div>
        <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-3">
                        <label for="City" class="control-label">Indeed Registration:</label>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9">
        <?php
        echo $this->Form->input('inreg', array('label' => false, 'value' => $arrCompleteLoggedInUserDetail[0]['Vendorpayout']['indeed_registration']));
        ?>
                </div>
        </div>-->
  <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3"></div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <button id="save-button" type="button" onclick="fnSubmitPayment();
                        return false;" class="btn btn-primary">Save Changes</button>

            </div>
        </div>
    </form>
</div>

<style>
    .page-content-wrapper .form-group {
        margin-bottom: 15px;
        overflow: visible;
        width: 100%;
        float: left;
    }
</style>