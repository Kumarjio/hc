<?php
$strLoginUrl = Router::url(array('controller' => 'users', 'action' => 'login'), true);
$strLogOutUrl = Router::url(array('controller' => 'users', 'action' => 'logout'), true);
$strForgotPasswordUrl = Router::url(array('controller' => 'users', 'action' => 'forgotpassword'), true);
//echo '<pre>';print_r($_SESSION);die;
?>
<div class="container-fluid">
    <div id="product_notification"></div>
    
    <?php 
//    echo $message;die;
    if ($message != '') { ?>
        <div class='<?php echo $class; ?>'><img alt='image description' src='<?php echo Router::url('/', true); ?>images/<?php echo $icon; ?>'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> <?php echo $message; ?></div>
    <?php } ?>
    <div class="row">
        <div class="hidden-xs hidden-sm col-md-4"></div>
        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="admin-logo-container">
                <a href="<?php echo Router::url('/',true); ?>portal/index/5" class="navbar-brand">
                    <img alt="logo description" src="<?php echo Router::url('/',true); ?>images/search-item.png"><span>HR Search</span>
                </a>
            </div>
            <div class="form-container admin-form-login">
                <div class="admin-form-header">
                    <h1>Login</h1>
                </div>
                <form role="form" id="UserIndexForm" name="UserIndexForm" method="post" onsubmit="return fnLoginEmployer('<?php echo $strLoginUrl; ?>', '<?php echo $strLogOutUrl; ?>')">
                    <div class="form-group">
                        <label class="control-label" for="email">Email:</label>
                        <input  class="col-md-12 validate[required,custom[email]]" type="text" name="UserUserEmail" id="UserUserEmail" value="<?php echo $_SESSION['infu_email'];?>" required>
                        <input  type="hidden" name="UserUType" id="UserUType" value="2" >
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Password:</label>
                        <input class="col-md-12 validate[required]" type="password" id="UserPassword" name="password" value="<?php echo $_SESSION['infu_pass']?>" required>
                    </div>
                    <div class="form-group">
                        <?php
                        $strHomePageUrl = Router::url(array('controller' => 'employers', 'action' => 'register'), true);
                        ?>
                        <button type="Submit" class="btn btn-primary btn-large" id="logInButton">Login</button>
                        <p>
                            <a href="<?php echo $strForgotPasswordUrl; ?>" class="link-primary">Forgot Password?</a>
                        </p>
                        <p>Don't Have account? 
                            <a href="https://vh118.infusionsoft.com/app/orderForms/HC-Yearly-Test-Order" class="link-primary">Register with us</a>
                            <!--<a href="<?php echo $strHomePageUrl; ?>" class="link-primary">Register with us</a>-->
                        </p>
                        
                    </div>
                </form>
            </div>
        </div>
        <div class="hidden-xs hidden-sm col-md-4"></div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var UserUserEmail = $("#UserUserEmail").val();
        var UserPassword = $("#UserPassword").val();
        if(UserUserEmail != '' || UserPassword != ''){
            fnLoginEmployer('<?php echo $strLoginUrl; ?>', '<?php echo $strLogOutUrl; ?>');
        }
        $('#register_btn').focus();
    });
</script>