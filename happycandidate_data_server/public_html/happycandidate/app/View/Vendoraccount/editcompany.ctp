<?php
echo $this->Html->script('vendor_company_edit');
?>

<!--<div class="users index">
<div class="edit-panel">
<div id="page-title">
        <h3>Edit Vendor Company Details</h3>
</div>-->

<div class="form-container vendor-edit-profile">
    <?php
    echo $this->Form->create('User', array('inputDefaults' => array(
            'label' => false,
            'div' => false
        )
            )
    );
    ?>
    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <label for="first-name" class="control-label">Company Name:</label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9">
            <?php
            echo $this->Form->input('vendorcname', array('class' => 'validate[required]', 'value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['company_name']));
            ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <label for="last-name" class="control-label">First Name: <span class="form-required">*</span></label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9">
            <?php
            echo $this->Form->input('vendorfname', array('class' => 'validate[required]', 'value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['vendor_f_name']));
            ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <label for="last-name" class="control-label">Last Name: <span class="form-required">*</span></label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9">
            <?php
            echo $this->Form->input('vendorlname', array('class' => 'validate[required]', 'value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['vendor_l_name']));
            ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <label for="email" class="control-label">Email Address: <span class="form-required">*</span></label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9">
            <?php
            echo $this->Form->input('vendorcemail', array('class' => 'validate[required]', 'value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['vendor_email']));
            ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <label for="phone" class="control-label">Company Address:</label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9">
            <textarea name="vendor_company_address" id="vendor_company_address"><?php echo stripslashes($arrProductContent['0']['Vendorcompany']['address']); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <label for="City" class="control-label">City:</label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9">
            <?php
            echo $this->Form->input('city', array('value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['city']));
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
            echo $this->Form->input('state', array('value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['state']));
            ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <label for="City" class="control-label">zip:</label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9">
            <?php
            echo $this->Form->input('zip', array('value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['zip']));
            ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <label for="phone" class="control-label">Phone:</label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9">
            <?php
            echo $this->Form->input('phone', array('value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['phone']));
            ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <label for="City" class="control-label">Fax:</label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9">
            <?php
            echo $this->Form->input('fax', array('value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['fax']));
            ?>
        </div>
    </div>

<!--    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <label for="City" class="control-label">Web Address:</label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9">
            <?php
//            echo $this->Form->input('vendorwaddress', array('value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['web_address']));
            ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <label for="City" class="control-label">Billing Phone:</label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9">
            <?php
//            echo $this->Form->input('vendorbphone', array('value' => $arrCompleteLoggedInUserDetail[0]['Vendorcompany']['billing_phone']));
            ?>
        </div>
    </div>-->


    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-3"></div>
        <div class="col-xs-12 col-sm-12 col-md-9">
            <?php
            $options = array(
                'label' => 'Save changes',
                'name' => 'edit',
                'class' => 'btn btn-primary'
            );
            echo $this->Form->end($options);
            ?>

        </div>
    </div>
</form>
</div>
