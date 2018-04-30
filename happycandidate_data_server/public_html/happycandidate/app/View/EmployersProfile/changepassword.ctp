<?php
echo $this->Html->script('changepassword');
?>
<div class="container-fluid bg-lightest-grey">
    <div class="row">
        <div class="col-md-12 bg-lightest-grey">
            <div  class="tab-content">
                <div class="tab-pane fade <?php echo $type == '' ? 'in active' : '' ?>" id="tab-profile">
                    <h3>Change Password</h3>
                    <?php
                        echo $this->Form->create('User', array('inputDefaults' => array(
                                'label' => false,
                                'div' => false
                            )
                        ));
                    ?>
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
                                <form id="UserIndexForm" method="post">
                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-12 col-md-3">Old Password: <span class="form-required">*</span></label>
                                        <?php echo $this->Form->input('old_pass', array('type' => 'password', 'class' => 'validate[required]', 'style' => 'width:50%;font-size:90%;')); ?>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-12 col-md-3">New Password: <span class="form-required">*</span></label>
                                        <?php
                                            echo $this->Form->input('new_password', array('type' => 'password', 'class' => 'validate[required]', 'style' => 'width:50%;font-size:90%;'));
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-12 col-md-3">Type New Password Again: <span class="form-required">*</span></label>
                                        <?php
                                            echo $this->Form->input('new_password_again', array('type' => 'password', 'class' => 'validate[required,equals[UserNewPassword]]', 'style' => 'width:50%;font-size:90%;'));
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <div class="hidden-xs hidden-sm col-md-3"></div>
                                        <div class="col-xs-12 col-sm-12 col-md-9">
                                            <?php $options = array( 'label' => 'Change','name' => 'change',);echo $this->Form->end($options); ?>
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