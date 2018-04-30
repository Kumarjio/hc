<?php echo $this->Html->script('admin_edit'); ?>
<div class="page-content-wrapper">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h3>Contact Us</h3>
            <ul class="nav nav-pills tab-list-long">
                        <li class="<?php echo $type == '' ? 'active' : '' ?>">
                            <a id="vendor-profile" data-toggle="pill" href="#tab-profile">Contact Us</a>
                        </li>
                    </ul>
            <div  class="tab-content">
                <div class="tab-pane fade <?php echo $type == '' ? 'in active' : '' ?>" id="tab-profile">
                    
                    <?php if($strMssg !=''){?>
                    <div id="alertMessages">
                        <div class="alert <?php echo $strMssgClass;?>">
                            <img alt="image description" src="<?php echo Router::url('/', true); ?>/images/icon-alert-success.png">
                            <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
                            <?php echo $strMssg; ?>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <!--PERSONAL INFORMATION PILL DYN-->			
                    <div class="panel-slider" id="personal-info-panel-slider">
                        <!--submenu-->			
                        <div data-parent="#personal-info-panel-slider" id="registrationContentDiv" >
                            <div class="col-md-12 form-container edit-profile">
                                <form id="UserIndexForm" method="post">
                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-12 col-md-3">Name: <span class="form-required">*</span></label>
                                        <input type="text" placeholder="Name" name="name" id="name" value="<?php echo $arrLoggedInUserDetail['username']; ?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-12 col-md-3">Email: <span class="form-required">*</span></label>
                                        <input type="text" placeholder="Email" name="email" id="email"  value="<?php echo $arrLoggedInUserDetail['email']; ?>" class="col-xs-12 col-sm-12 col-md-9 validate[custom[email],required]">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-12 col-md-3">Subject: <span class="form-required">*</span></label>

                                        <input type="text" name="subject" id="subject" placeholder="Subject" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-12 col-md-3">Comment: </label>
                                        <textarea name="message" id="message" style="width:22%;height: 135px;" placeholder="Comment" class="builder-textarea col-xs-12 col-sm-12 col-md-9"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <div class="hidden-xs hidden-sm col-md-3"></div>
                                        <div class="col-xs-12 col-sm-12 col-md-7 text-center">
                                            <!--<input class="btn btn-primary" type="submit" name="submit" id="submit" onclick="return fnCheckEmployer();" Value="Submit"/> <br><input style="width:auto;" type="reset" name="reset" id="reset" Value="Reset"/>-->
                                            <button class="btn btn-primary" type="submit" name="submit" id="submit" onclick="return fnCheckEmployer();" Value="Submit"/>Submit</button>
                                            <button class="btn btn-default" type="reset" name="reset" id="reset" Value="Reset"/>Reset</button>
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
<style>
    .examples{
    margin-bottom:250px !important;
}
</style>
<style>
.page-content-wrapper input {
  width: 53% !important;
}
.page-content-wrapper textArea {
  width: 53% !important;
}
</style>