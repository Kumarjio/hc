<?php
echo $this->Html->script('vendor_company_edit');
?>
<script type="text/javascript">
    function fnSubmitCompany()
    {

        var isValidated = $('#company_add_form').validationEngine('validate');

        if (isValidated == false)
        {
            return false;
        } else
        {

            var pageurl = "<?php echo Router::url('/', true) . "vendoraccount/editcompany"; ?>";
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
                        $('#contact_form_messages').css('color', '#E04B39');
                        $('#contact_form_messages').text(responseText.message);
                    }

                },
                url: pageurl, // override for form's 'action' attribute 
                type: pagetype, // 'get' or 'post', override for form's 'method' attribute 
                dataType: 'json'        // 'xml', 'script', or 'json' (expected server response type) 
            }
            $('#company_add_form').ajaxSubmit(pageoptions);
            return false;
        }
    }
</script>
<?php // echo '<pre>';print_r($arrCompleteLoggedInUserDetail);die;?>
<div class="form-container vendor-edit-profile">
    <p>Please update your Company Details when you have a change.</p>
    <form role="form" id="company_add_form" name="company_add_form">		
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="first-name" class="control-label">Company Name:</label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <?php
                echo $this->Form->input('vendorcname', array('class' => 'validate[required]', 'label' => false, 'value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['company_name']));
                ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="last-name" class="control-label">First Name: <span class="form-required">*</span></label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <?php
                echo $this->Form->input('vendorfname', array('class' => 'validate[required]', 'label' => false, 'value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['vendor_f_name']));
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="last-name" class="control-label">Last Name: <span class="form-required">*</span></label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <?php
                echo $this->Form->input('vendorlname', array('class' => 'validate[required]', 'label' => false, 'value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['vendor_l_name']));
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="email" class="control-label">Email Address: <span class="form-required">*</span></label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <?php
                echo $this->Form->input('vendorcemail', array('class' => 'validate[required,custom[email]]', 'label' => false, 'value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['vendor_email']));
                ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="phone" class="control-label">Company Address:</label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <textarea name="vendor_company_address" id="vendor_company_address"><?php echo stripslashes($arrCompleteLoggedInUserDetail[0]['Vendorcompany']['address']); ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="City" class="control-label">City:</label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <?php
                echo $this->Form->input('city', array('value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['city'], 'label' => false));
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="state" class="control-label">
                    State:</label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <?php
                echo $this->Form->input('state', array('value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['state'], 'label' => false));
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="Zip" class="control-label">Postal / Zip Code:</label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <?php
                echo $this->Form->input('zip', array('class' => 'validate[custom[onlyNumberSp]]','value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['zip'], 'label' => false));
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="phone" class="control-label">Phone:</label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <?php
                echo $this->Form->input('phone', array('class' => 'validate[custom[phone]]','value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['phone'], 'label' => false));
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="Fax" class="control-label">Fax:</label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <?php
                echo $this->Form->input('fax', array('class' => 'validate[custom[phone]]','value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['fax'], 'label' => false));
                ?>
            </div>
        </div>

<!--        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="City" class="control-label">Web Address:</label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <?php
                echo $this->Form->input('vendorwaddress', array('value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['web_address'], 'label' => false));
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="City" class="control-label">Billing Phone:</label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <?php
                echo $this->Form->input('vendorbphone', array('value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['billing_phone'], 'label' => false));
                ?>
            </div>
        </div>
        -->
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-3"></div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <button id="save-button" type="button" onclick="fnSubmitCompany();
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