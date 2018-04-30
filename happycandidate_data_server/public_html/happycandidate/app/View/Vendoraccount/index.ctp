<?php
echo $this->Html->script('vendoraccount_index');
?>
<?php
$strLoginUrl = Router::url(array('controller' => 'vendoraccount', 'action' => 'login'), true);
$strLogOutUrl = Router::url(array('controller' => 'vendoraccount', 'action' => 'logout'), true);
?>
<div class="container-fluid">
    <div class="row">
        <div class="hidden-xs hidden-sm col-md-4"></div>
        
        <div class="col-xs-12 col-sm-12 col-md-4">
            <?php echo $this->Session->flash(); ?>
            <div class="admin-logo-container">
                <a class="navbar-brand" href="#">
                    <span>Vendor Login</span>
                </a>
            </div>
            <div class="form-container admin-form-login" >
                <div class="admin-form-header">
                    <h1>Login</h1>
                </div>
                <form role="form" id="UserLoginForm" name="UserLoginForm" method="post">
                    <div class="form-group">
                        <label class="control-label" for="email">Email:</label>
                        <input class="col-md-12 validate[required,custom[email]]" type="text" id="UserUserEmail" name="user_email" value="" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Password:</label>
                        <input class="col-md-12 validate[required]" type="password" id="UserPassword" name="password" value="" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-large"  onclick="return fnSubmitVendorForm('<?php echo $strLoginUrl; ?>', '<?php echo $strLogOutUrl; ?>')">Login</button>
                        <p>Forgot your password? 
                            <a href="#" class="link-primary">Reset it here</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        <div class="hidden-xs hidden-sm col-md-4"></div>
    </div>
</div>