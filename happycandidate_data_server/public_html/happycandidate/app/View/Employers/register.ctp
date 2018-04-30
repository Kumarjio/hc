<?php
$strLoginUrl = Router::url(array('controller' => 'users', 'action' => 'login'), true);
$strLogOutUrl = Router::url(array('controller' => 'users', 'action' => 'logout'), true);
$strTermsUrl = Router::url(array('controller' => 'employers', 'action' => 'termsandprivacy'), true);
?>
<div class="container-fluid">
    <div class="row">
        <div class="hidden-xs hidden-sm col-md-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-8">
            <?php if ($message != '') { ?>
                <div class='<?php echo $class; ?>'><img alt='image description' src='<?php echo Router::url('/', true); ?>images/<?php echo $icon; ?>'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> <?php echo $message; ?></div>
            <?php } ?>
            <?php //  echo $this->Session->flash('Message'); ?>
            <div id="messageshow"></div>
        </div>
        <div class="hidden-xs hidden-sm col-md-2"></div>
        <div class="hidden-xs hidden-sm col-md-4"></div>
        <div class="col-xs-12 col-sm-12 col-md-4">
            
            <div class="admin-logo-container">
                <a href="<?php echo Router::url('/', true); ?>portal/index/5" class="navbar-brand">
                    <img alt="logo description" src="<?php echo Router::url('/', true); ?>images/search-item.png"><span>HR Search</span>
                </a>
            </div>
            <div class="form-container admin-form-login">
                <div class="admin-form-header">
                    <h1>Register</h1>
                </div>
                <form role="form" id="UserIndexForm" method="post" accept-charset="utf-8">
                    <div class="form-group">
                        <label class="control-label" for="email">Username:</label>
                        <input  class="col-md-12 validate[required,custom[email]]" type="text" name="user_name" id="user_name" required>

                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email">Email:</label>
                        <input  class="col-md-12 validate[required,custom[email]]" type="text" name="user_email" id="user_email" required>
                        <input  type="hidden" name="u_type" id="u_type" value="2" >
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Password:</label>
                        <input class="col-md-12 validate[required]" type="password" id="user_pass" name="user_pass"  required>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Captcha:</label>
                        <?php echo $this->Html->image($this->Html->url(array('controller' => 'employers', 'action' => 'captcha'), true), array('id' => 'img-captcha', 'vspace' => 2)); ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Above Security Code:</label>
                        <input class="col-md-12 validate[required]" type="text" id="captcha" name="captcha"  required>
                    </div>

                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input validate[required]" required="" type="checkbox" id="agree" name="agree" value="option1"> <a class="agree-link" href="<?php echo $strTermsUrl; ?>" class="link-primary" target="_blank">Terms & Condition</a>
                        </label>
                    </div>

                    <div class="form-group">
                        <?php
                        $strHomePageUrl = Router::url(array('controller' => 'employers', 'action' => 'index'), true);
                        ?>
                        <button type="Submit" class="btn btn-primary btn-large">Sign Up</button>
                        <p>Have account? 
                            <a href="<?php echo $strHomePageUrl; ?>" class="link-primary">Login here</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        <div class="hidden-xs hidden-sm col-md-4"></div>
    </div>
</div>

<style>
    .form-check-label input {
        width: 7% !important;
        height: 16px !important;
    }
    .form-check-label {
        font-family: OpenSansRegular,Georgia,serif !important;
        font-size: 14px !important;
        font-weight: normal !important;
    }

    .form-signin label{
        width: 67% !important;
    }
</style>

<script>
    $(document).ready(function () {
        $('#register_btn').focus();
    });
</script>


<!--<?php
//echo $this->Html->script('employer_index');
$strEmployerlogoPath = Router::url('/img/hometheme/img/logo.png', true);
?>
<div class="wrapper">
<div style="float:left;width;20%;height:auto;margin-left:36%;margin-top:25px;margin-bottom:25px;padding-top:45px;padding-bottom:45px;display:block;"><img src="<?php echo $strEmployerlogoPath; ?>" alt="EmployerLogo" title="EmployerLogo" /></div>
<div style="float:left;width:100%;heigth:20%;margin-bottom:30px;color:#fff;display:none;" id="mssg"></div>
<div style='width:100%;height:50%;float:left;'>
        <div id="leftDiv" class="widget-box visible login-box ">
                <div id="loginDiv" class="widget-main">
                        <div id="loginHeader">
                                <h4 class="header blue lighter bigger">Owner's Login</h4>
                        </div>

                        <div id="loginContentDiv" style="width:100%;">
<?php
/* $strLoginUrl = Router::url(array('controller' => 'users', 'action' => 'login'),true);
  $strLogOutUrl = Router::url(array('controller' => 'users', 'action' => 'logout'),true);
  echo $this->Form->create('User',array('onsubmit'=>'return fnLoginEmployer("'.$strLoginUrl.'","'.$strLogOutUrl.'")'));
  echo $this->Form->input('user_email',array('class'=>'validate[required,custom[email]]','label'=>false,'placeholder'=>'Email'));
  echo $this->Form->input('password',array('type'=>'password','label'=>false,'placeholder'=>'Password','class'=>'validate[required]'));
  echo $this->Form->hidden('u_type',array('value'=>'2')); */
?>
                                <div class="submit">
<?php
echo $this->Form->submit('Login');
?>
                                </div>
                        
                                        <div class="submit">
                                                
                                        </div>
                        
                                
                                        <div>
<?php
$strLoaderImageUrl = Router::url('/', true) . "img/loader.gif";
?>
                                                <span id="loginformloader" style="position:relative;top:15px;display:none;"><img src="<?php echo $strLoaderImageUrl; ?>" alt="loginloader" /></span>
                                        </div>
                                
<?php
echo $this->Form->end();
?>
                        </div>
                <div class="clear"></div>
                </div>
        <div class="toolbar clearfix">
                <div>
<?php
echo $this->Html->link('Forgot Password?', array('controller' => 'users', 'action' => 'forgotpassword'));
?>
        </div>
        </div>	
        </div>
        </div>

<div id="rightDiv" style="width:50%;float:right;">
                <div id="registrationDiv" class="widget-box visible login-box ">
                        <div class="widget-main" style="padding-bottom:22px;">
                        <div id="registrationHeader">
                                <h4 class="header blue lighter bigger">Owner's Sign Up!</h2>
                        </div>

                        <div id="registrationContentDiv" style="width:100%;">
<?php
/* 	echo $this->Form->create('User',array('action' => 'register'));
  echo $this->Form->input('user_name',array('class'=>'validate[required]','label'=>false,'placeholder'=>'Username'));
  echo $this->Form->input('user_email',array('class'=>'validate[required,custom[email]]','label'=>false,'placeholder'=>'Email'));
  echo $this->Form->input('user_pass',array('type'=>'password','label'=>false,'placeholder'=>'Password','class'=>'validate[required]'));
  //echo $this->Form->input('password_confirm',array('type'=>'password','label'=>'Confirm Password'));
  echo $this->Html->image($this->Html->url(array('controller'=>'employers', 'action'=>'captcha'), true),array('id'=>'img-captcha','vspace'=>2));
  echo $this->Form->input('captcha',array('type'=>'text','label'=>false,'placeholder'=>'Above Security Code','class'=>'validate[required]'));
  echo $this->Form->hidden('u_type',array('value'=>'2'));
  echo $this->Form->end('Sign Up'); */
?>
                        </div>
                        </div>
                <div class="toolbar clearfix">
                <div>
<?php
$strHcMainUrl = Router::url('/', true);
?>
                        <a href="<?php echo $strHcMainUrl; ?>" class="forgot-password-link">
                                <i class="icon-arrow-left"></i>
                                Go to Home page
                        </a>
                </div>
                </div>	
                </div>
        </div>
</form>
</div>-->