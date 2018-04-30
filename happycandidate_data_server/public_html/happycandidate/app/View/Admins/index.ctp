<?php
echo $this->Html->script('admin_index');

$strLoginUrl = Router::url(array('controller' => 'users', 'action' => 'login'), true);
$strLogOutUrl = Router::url(array('controller' => 'users', 'action' => 'logout'), true);
?>
<div class="container-fluid">
    <div class="row">
        <div class="hidden-xs hidden-sm col-md-4"></div>
        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="admin-logo-container">
                <a class="navbar-brand" href="#">
                    <img src="<?php echo Router::url('/', true); ?>images/hc-logo.png" alt="logo description" width="100%" height="100%"/>
                </a>
            </div>
            <div class="form-container admin-form-login">
                <div class="admin-form-header">
                    <h1>Login</h1>
                </div>
                <form role="form" id="UserLoginForm" name="UserLoginForm" method="post">
                    <div class="form-group">
                        <label class="control-label" for="email">Email:</label>
                        <input  class="col-md-12 validate[required,custom[email]]" type="text" name="user_email" id="UserUserEmail" value="" required>
                        <input   type="hidden" name="u_type" id="UserUType" value="1" >
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Password:</label>
                        <input class="col-md-12 validate[required]" type="password" id="UserPassword" name="password" value="" required>
                    </div>
                    <div class="form-group">
                        <?php
                        $strHomePageUrl = Router::url(array('controller' => 'home', 'action' => 'index'), true);
                        ?>
                        <button type="button" class="btn btn-primary btn-large" id="log_btn" onclick="return fnSubmitTheForm('<?php echo $strLoginUrl; ?>', '<?php echo $strLogOutUrl; ?>')">Login</button>
                        <p>Forgot your password? 
                            <a onclick="show_box('forgot-box'); return false;" href="<?php echo $strHomePageUrl; ?>" class="link-primary">Reset it here</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        <div class="hidden-xs hidden-sm col-md-4"></div>
    </div>
</div>

<script>
     $('#log_btn').focus();

//    $( "#log_btn" ).click(function() {
//        var email = 'arjun.gunjal@redorangetechnologies.com';
//                var password = 'AG@08071989';
//        
//                $.ajax({
//                    type: "POST",
//                    url: "http://www.rothrsolutions.com/sendy_new/includes/login/main.php",
//                    data: 'email=' + email + "&password=" + password,
//                    cache: false,
//                    dataType: "json",
//                    success: function (data)
//                    {
//                        if (data.status == "success")
//                        {
//                            if (data.file != "")
//                            {
//                                $('.cms-bgloader-mask').hide();//show loader mask
//                                $('.cms-bgloader').hide(); //show loading image
//                            }
//                        } else
//                        {
//                            alert(data.message);
//                        }
//                        $('.cms-bgloader-mask').hide();//show loader mask
//                        $('.cms-bgloader').hide(); //show loading image
//                    }
//                });
//    });
</script>

<!--<div class="login-container">
        <div class="widget-box visible login-box ">
                <div class="widget-main">
                <h4 class="header blue lighter bigger"> Please Enter Your Admin's Details</h4>
                <div>
<?php
$strLoginUrl = Router::url(array('controller' => 'users', 'action' => 'login'), true);
$strLogOutUrl = Router::url(array('controller' => 'users', 'action' => 'logout'), true);
echo $this->Form->create('User', array('action' => 'login', 'onSubmit' => 'return fnSubmitTheForm("' . $strLoginUrl . '","' . $strLogOutUrl . '")'));
echo $this->Form->input('user_email', array('class' => 'validate[required,custom[email]]', 'label' => false, 'placeholder' => 'Email', 'class' => 'form-control'));
echo $this->Form->input('password', array('type' => 'password', 'label' => false, 'placeholder' => 'Password', 'class' => 'form-control validate[required]'));
echo $this->Form->hidden('u_type', array('value' => '1'));
echo $this->Form->end('Login');
?>
                </div>
        </div>
        <div class="toolbar clearfix">
        <div>
<?php
$strHomePageUrl = Router::url(array('controller' => 'home', 'action' => 'index'), true);
?>
                <a class="forgot-password-link" onclick="show_box('forgot-box'); return false;" href="<?php echo $strHomePageUrl; ?>">
                        <i class="icon-arrow-left"></i>
                        Go to Home page
                </a>
        </div>

        
</div>
        </div>
</div>-->

