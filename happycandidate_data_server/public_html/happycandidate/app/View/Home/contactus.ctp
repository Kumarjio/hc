<?php
echo $this->Html->script('employer_index');
?>
<div class="wrapper">
    <!--<div style="float:left;width:20%;height:auto;margin-left:36%;margin-top:25px;margin-bottom:25px;padding-top:45px;padding-bottom:45px;display:block;"></div>-->
    <div style='width:100%;height:50%;float:left;'>

        <div id="rightDiv" style="width:100%;float:right;">
            <div id="registrationDiv" style="width:900px;" class="widget-box visible login-box ">
                <div class="widget-main" style="padding-bottom:22px;">
                    <div id="registrationHeader">
                        <h4 class="header blue lighter bigger">Contact Us</h2>
                            If you have questions, need assistance or have a comment regarding your Happy Candidates Career Portal, please fill out the form below.  Your feedback is always appreciated and will be reviewed by our staff.  Our goal is to address your issue within a 24 hour timeframe.
                    </div>
                    <div>&nbsp;</div>
                    <div id="registrationContentDiv" style="width:100%;">
                        <form id="UserIndexForm" method="post">
                            <div><input type="text" class="validate[required]" name="name" id="name" placeholder="Name" /></div>
                            <div><input type="text" class="validate[custom[email],required]" name="email" id="email" placeholder="Email" /></div>
                            <div><input type="text" class="validate[required]" name="subject" id="subject" placeholder="Subject" /></div>
                            <div><textarea name="message" class="validate[required]" id="message" placeholder="Comment"></textarea></div>
                            <div class="col-md-12">
                            <div class="col-md-6">
                                <?php echo $this->Html->image($this->Html->url(array('controller' => 'home', 'action' => 'captcha'), true), array('id' => 'img-captcha', 'vspace' => 2)); ?>
                            </div>
                            <div class="col-md-6">
                                <input class="col-md-12 validate[required]" type="text" id="captcha" name="captcha">
                            </div>
                            </div>
                            <div><input type="submit" name="submit" id="submit" Value="Submit"/> &nbsp; <input style="width:auto;" type="reset" name="reset" id="reset" Value="Reset"/></div>
                        </form>
                    </div>
                </div>
                <div class="toolbar clearfix">
                    <div>
                        <a href="<?php echo Router::url(array('controller' => 'home', 'action' => 'index'), true); ?>" class="forgot-password-link">
                            <i class="icon-arrow-left"></i>
                            Go to Home page
                        </a>
                    </div>
                </div>	
            </div>
        </div>
        </form>
    </div>
    
    <style>
        .formError{
            left: 765.2px !important;
        }
        .formError .formErrorArrow {
            margin: -18px 0 0 -7px !important;
            position: relative !important;
            width: 37px !important;
        }
    </style>