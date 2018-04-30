<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Add User</h1>
                <div id="product_notification" style="color:#49C24F;"><?php echo $strForMessage; ?></div>
                <div id="messageshow"></div>
                <ul class="nav nav-pills tab-list-long">
                    <li class="<?php echo $type == '' ? 'active' : '' ?>">
                        <a id="vendor-profile" data-toggle="pill" href="#tab-profile">User Detail</a>
                    </li>
                    <!--<li class="<?php echo $type == 'company' ? 'active' : '' ?>">
                            <a id="vendor-company-details" data-toggle="pill" href="#tab-company-details">Company Details</a>
                    </li>
                    <li class="<?php echo $type == 'payout' ? 'active' : '' ?>">
                            <a id="vendor-payment-details" data-toggle="pill" href="#tab-payment-details">Payment Details</a>
                    </li>-->
                </ul>
                <div class="tab-content" >

                    <div id="tab-profile" class="tab-pane fade <?php echo $type == '' ? 'in active' : '' ?>">
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
                                    <label class="control-label" for="first-name">First Name: <span class="form-required">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <input type="text" name="vfname" id="vfname" class="validate[required]" value="" />

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <label class="control-label" for="last-name">Last Name: <span class="form-required">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <input type="text" name="vlname" id="vlname" class="validate[required]" value="" />

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <label class="control-label" for="email">Email Address(Username): <span class="form-required">*</span></label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <input type="text" name="vemail" id="vemail" class="validate[required,custom[email]]" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <label class="control-label" for="phone">Phone:</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <input type="text" name="vphone" id="vphone" class="validate[required]" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <label class="control-label" for="password">Password:</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <input type="password" name="vpass" id="vpass" class="validate[required]" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <label class="control-label" for="confirm-password">Confirm Password:</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <input type="password" name="vcpass" id="vcpass" class="validate[required,equals[vpass]]" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-3"></div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <?php
                                    $options = array(
                                        'label' => 'Add',
                                        'name' => 'save',
                                        'onclick' => 'return fnValidateForm();',
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



        var type = '<?php echo $type ?>';
        switch (type) {
            case 'company':
                fnGetCompanyDetails();
                break;
            case 'payout':
                fnGetPaymentDetails();
                break;
        }
        $("a[data-toggle='pill']").click(function () {

            var strNewTab = $(this).attr('id');
            if (strNewTab == "vendor-company-details")
            {
                fnGetCompanyDetails();
            } else if (strNewTab == "vendor-payment-details")
            {
                fnGetPaymentDetails();
            }

        });
    });

    function fnGetCompanyDetails()
    {
        $.ajax({
            type: "GET",
            url: strBaseUrl + "vendoraccount/getcompanyhtml",
            dataType: 'json',
            data: "",
            cache: false,
            success: function (data)
            {
                if (data.status == "success")
                {
                    //alert(data.content)
                    $('#tab-company-details').html(data.html);
                } else
                {

                }
            }
        });

    }

    function fnGetPaymentDetails()
    {
        $.ajax({
            type: "GET",
            url: strBaseUrl + "vendoraccount/getPaymenthtml",
            dataType: 'json',
            data: "",
            cache: false,
            success: function (data)
            {
                if (data.status == "success")
                {
                    //alert(data.content)
                    $('#tab-payment-details').html(data.html);
                } else
                {

                }
            }
        });

    }

    function fnValidateForm()
    {
        var strResult = $("#UserAdduserForm").validationEngine('validate');
        return strResult;
    }
</script>

<style>
    .page-content-wrapper .form-group {
        margin-bottom: 15px;
        overflow: visible;
        width: 100%;
        float: left;
    }
</style>