<?php echo $this->Html->script('admin_edit'); ?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 id="page_lable">My Profile</h1>
                <?php //echo $this->Session->flash(); ?>
                <div id="messageshow"></div>
                <ul class="nav nav-pills tab-list-long">
                    <li class="<?php echo $type == '' ? 'active' : '' ?>">
                        <a id="vendor-profile" data-toggle="pill" href="#tab-profile" onclick="fnPageDetailsDetails();">My Profile</a>
                    </li>
                    <li class="<?php echo $type == 'company' ? 'active' : '' ?>">
                        <a id="vendor-company-details" data-toggle="pill" href="#tab-company-details">Company Details</a>
                    </li>
                    <li class="<?php echo $type == 'payout' ? 'active' : '' ?>">
                        <a id="vendor-payment-details" data-toggle="pill" href="#tab-payment-details">Payment Details</a>
                    </li>
                </ul>
                <div class="tab-content" >

                    <div id="tab-profile" class="tab-pane fade <?php echo $type == '' ? 'in active' : '' ?>">
                        <div class="form-container vendor-edit-profile">
                            <p>If you need to update your email address, please contact support@careersupportnetwork.com</p>

                            <?php
                            echo $this->Form->create('User', array('inputDefaults' => array(
                                    'label' => false,
                                    'div' => false,
                                    'onsubmit'=> 'return false'
                                ))
                            );
                            ?>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <label class="control-label" for="first-name">First Name:</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <?php
                                    echo $this->Form->input('vendorfname', array('class' => 'validate[required]', 'label' => false, 'value' => $arrCompleteLoggedInUserDetail[0]['Vendors']['vendor_first_name']));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <label class="control-label" for="last-name">Last Name: <span class="form-required">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <?php
                                    echo $this->Form->input('vendorlname', array('class' => 'validate[required]', 'label' => false, 'value' => $arrCompleteLoggedInUserDetail[0]['Vendors']['vendor_last_name']));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <label class="control-label" for="email">Email Address: <span class="form-required">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <?php echo $arrCompleteLoggedInUserDetail[0]['Vendors']['vendor_email']; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <label class="control-label" for="phone">Phone:</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <?php
                                        echo $this->Form->input('vendorphone', array('class' => 'validate[required]', 'label' => false, 'value' => $arrCompleteLoggedInUserDetail[0]['Vendors']['vendor_phone']));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <label class="control-label" for="last-name">Company Name: <span class="form-required">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <?php
                                        echo $this->Form->input('vendorname', array('class' => 'validate[required]', 'label' => false, 'value' => $arrCompleteLoggedInUserDetail[0]['Vendors']['vendor_name']));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <label class="control-label" for="password">Password:</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <?php
                                    echo $this->Form->input('vendor_pass', array('class' => 'validate[required]','type' => 'password','label' => false, 'value' => $arrCompleteLoggedInUserDetail[0]['Vendors']['vendor_password']));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <label class="control-label" for="confirm-password">Confirm Password:</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <?php
                                    echo $this->Form->input('vendor_conf_pass', array('type' => 'password', 'class' => 'validate[required,equals[UserVendorPass]]', 'label' => false, 'value' => $arrCompleteLoggedInUserDetail[0]['Vendors']['vendor_password']));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-3"></div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <?php
                                    $options = array(
                                        'label' => 'Save Changes',
                                        'name' => 'save',
                                        'class' => 'btn btn-primary'
                                    );
                                    echo $this->Form->end($options);
                                    ?>


                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                    <div id="tab-company-details" class="tab-pane fade <?php echo $type == 'company' ? 'in active' : '' ?>">
                    </div>

                    <div id="tab-payment-details" class="tab-pane fade <?php echo $type == 'payout' ? 'in active' : '' ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
            $("#page_lable").html('My Profile');
	var type= '<?php echo $type?>';
	switch (type) { 
		case 'company': 
		fnGetCompanyDetails();
		break;
		case 'payout': 
		fnGetPaymentDetails();
		break;
		}
	
		$("a[data-toggle='pill']").click(function() {
		   var strNewTab = $(this).attr('id');
		   if(strNewTab=="vendor-company-details")
		   {
			  fnGetCompanyDetails();
		   }
		 else if(strNewTab=="vendor-payment-details")
		   {
		     fnGetPaymentDetails();
		   }
	   });
	});
	
        function fnPageDetailsDetails()
	{
             $("#page_lable").html('My Profile');
        }
	function fnGetCompanyDetails()
	{
            $("#page_lable").html('Company Details');
            $.ajax({ 
                    type: "GET",
                    url: strBaseUrl+"vendoraccount/getcompanyhtml",
                    dataType: 'json',
                    data:"",
                    cache:false,
                    success: function(data)
                    {
                            if(data.status == "success")
                            {
                                    $('#tab-company-details').html(data.html);
                            }
                            else
                            {

                            }
                    }
            });
	}
	
	function fnGetPaymentDetails()
	{
            $("#page_lable").html('Payment Details');
            $.ajax({ 
                    type: "GET",
                    url: strBaseUrl+"vendoraccount/getPaymenthtml",
                    dataType: 'json',
                    data:"",
                    cache:false,
                    success: function(data)
                    {
                            if(data.status == "success")
                            {
                                    $('#tab-payment-details').html(data.html);
                            }
                            else
                            {

                            }
                    }
            });
	
	}
        
        $(document).ready(function () {

	
	$("#UserEditForm").validationEngine();
	
	
});
</script>
<style>
    .page-content-wrapper .form-group {
        margin-bottom: 15px;
        overflow: visible;
        width: 100%;
        float: left;
    }
</style>