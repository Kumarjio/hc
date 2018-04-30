<?php
echo $this->Html->script('cascade');
?>
<div class="container-fluid bg-lightest-grey">
    <div class="row">
        <div class="col-md-12 bg-lightest-grey">
            <div  class="tab-content">
                <div class="tab-pane fade <?php echo $type == '' ? 'in active' : '' ?>" id="tab-profile">
                    <h3>Payment Details</h3>
                    <p>All career portal employers payments will be sent to you in US dollars.</p>
                    <?php
                    if ($strMssg) { ?>
                        <div id="flashMessage">
                            <div class="alert <?php echo $strMssgClass; ?>">
                                <img alt="image description" src="<?php echo Router::url('/', true); ?>/images/icon-alert-success.png">
                                <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
                                <?php echo $strMssg; ?>
                            </div>	
                        </div>
                        <?php
                    }
                    ?>
                    <!--PERSONAL INFORMATION PILL DYN-->			
                    <div class="panel-slider" id="personal-info-panel-slider">
                        <!--submenu-->			
                        <div data-parent="#personal-info-panel-slider" id="registrationContentDiv" >
                            <div class="col-md-12 form-container edit-profile">
                                <form id="payment_add_form" method="post">
                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-12 col-md-3">Make Payments To: <span class="form-required">*</span></label>
                                        <input type="text" name="payoutto" id="payoutto" value="<?php echo $arrEmployerDetail[0]['Employer']['payout_to']; ?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-12 col-md-3">Tax ID Number or Business Number: <span class="form-required">*</span></label>
                                        <input type="text" name="taxid" id="taxid"  value="<?php echo $arrEmployerDetail[0]['Employer']['tax_id']; ?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-12 col-md-3">Bank Account Number: <span class="form-required">*</span></label>

                                        <input type="text" name="bankaccountnumber" id="bankaccountnumber" value="<?php echo $arrEmployerDetail[0]['Employer']['bank_account_number']; ?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-12 col-md-3">Bank Routing Number: <span class="form-required">*</span></label>

                                        <input type="text" name="bankroutingnumber" id="bankroutingnumber" value="<?php echo $arrEmployerDetail[0]['Employer']['bank_routing_number']; ?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
                                    </div>

                                    <div class="form-group">
                                        <div class="hidden-xs hidden-sm col-md-3"></div>
                                        <div class="col-xs-12 col-sm-12 col-md-9">
                                            <input class="btn btn-primary" type="submit" name="submit" id="submit" onclick="return fnCheckEmployer();" Value="Submit"/>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <!--END OF PERSONAL INFORMATION PILL DYN-->		
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	function fnCheckEmployer()
	{
		var isValidated = $('#UserIndexForm').validationEngine('validate');
		if(isValidated == false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
</script>