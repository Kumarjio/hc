<script type="text/javascript">
    function fnTakeToSubscription()
    {
        var strSubsLink = $('#subs_link').val();
        var strOEmail = $('#owner_email').val();
        strSubsLink = strSubsLink + "?oemail=" + strOEmail;
        window.location = strSubsLink;
    }
</script>
<?php
$strEmployerlogoPath = Router::url('/img/hometheme/img/logo.png', true);
//echo '<pre>';print_r($_SESSION['Message']['flash']['message']);die;
//[params][class]
?>


<div class="container-fluid">
    <?php if($_SESSION['Message']['flash']['params']['class'] == 'success') {?>
    <div class="col-md-12">
        <div class="alert alert-success alert-dismissible msg-cls" role="alert">
            <strong>Success!</strong> <?php echo $_SESSION['Message']['flash']['message'];?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <?php } ?>
    <div class="col-md-2"></div>
            <div class="col-sm-8 page-cls">
                <?php 
                $strlogoPath = Router::url('/images/search-item.png', true);
                $strHomePath = Router::url(array('controller' => 'portal', 'action' => 'index','5'), true);
                ?>
                <div class="admin-logo-container">
                    <a href="<?php echo $strHomePath;?>" class="navbar-brand">
                        <img alt="logo description" src="<?php echo $strlogoPath;?>"><span>HR Search</span>
                    </a>
                </div>
                <div class="bs-calltoaction bs-calltoaction-default">
                    <div class="row">
                        <div class="col-md-12 cta-contents">
                            <h4 class="header-title">Owner Subcription Activation</h4><hr>
                            <?php
                if (is_array($arrUserDetail) && (count($arrUserDetail) > 0)) {
                    $strUserActive = trim($arrUserDetail['0']['User']['is_active']);

                    if ($strUserActive) {
                        $strLoginUrl = Router::url(array('controller' => 'employer', 'action' => 'index'), true);
                        ?>
                        <p>Your account subscription is already active</p>
                        <p>Please click <a href='<?php echo $strLoginUrl; ?>'>here</a> to login.</p>
                        <?php
                    } else {
                        ?>
                        <p>Your current default plan is by: <?php echo ucfirst($arrUserDetail[0]['User']['owner_chosen_subscription_plan']); ?></p>
                        <p>Your Subscription Purchase amount is: <b><?php echo $arrSubscriptioDetail['sprice']; ?></b></p>
                        <div class="submit" style="float: right">
                                <input type="hidden" name="owner_email" id="owner_email" value="<?php echo $arrUserDetail['0']['User']['email']; ?>">
                                <?php
                                if (is_array($arrSubscriptioDetail) && (count($arrSubscriptioDetail) > 0)) {
                                    ?>
                                    <input type="hidden" name="subs_link" id="subs_link" value="<?php echo $arrSubscriptioDetail['slink']; ?>">
                                    <?php
                                }
                                ?>
                                <input class="btn btn-primary" type="submit" onclick="return fnTakeToSubscription();
                                        false;" value="Buy this Subcription">
                            </div>				
                        <?php
                    }
                } else {
                    if ($strMessage) {
                        ?>
                        <p><?php echo $strMessage; ?></p>

                        <?php
                    } else {
                        $strRegistrationUrl = Router::url(array('controller' => 'employers', 'action' => 'index'), true);
                        ?>
                        <p>There is no such owner registered with us</p>
                        <p>Please click <a href='<?php echo $strRegistrationUrl; ?>'>here</a> to initate the registration process first.</p>
                        <?php
                    }
                }
                ?>
                        </div>
                        
                     </div>
                </div>
            </div>
    <div class="col-md-2"></div>
    
        </div>

<style>
    .bs-calltoaction{
    position: relative;
    width:auto;
    padding: 15px 25px;
    border: 1px solid black;
    margin-top: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
}

    .bs-calltoaction > .row{
        display:table;
        width: calc(100% + 30px);
    }
     
        .bs-calltoaction > .row > [class^="col-"],
        .bs-calltoaction > .row > [class*=" col-"]{
            float:none;
            display:table-cell;
            vertical-align:middle;
        }

            .cta-contents{
                padding-top: 10px;
                padding-bottom: 10px;
            }

                .cta-title{
                    margin: 0 auto 15px;
                    padding: 0;
                }

                .cta-desc{
                    padding: 0;
                }

                .cta-desc p:last-child{
                    margin-bottom: 0;
                }

            .cta-button{
                padding-top: 10px;
                padding-bottom: 10px;
            }

@media (max-width: 991px){
    .bs-calltoaction > .row{
        display:block;
        width: auto;
    }

        .bs-calltoaction > .row > [class^="col-"],
        .bs-calltoaction > .row > [class*=" col-"]{
            float:none;
            display:block;
            vertical-align:middle;
            position: relative;
        }

        .cta-contents{
            text-align: center;
        }
}



.bs-calltoaction.bs-calltoaction-default{
    color: #333;
    background-color: #fbfbfb;
    border-color: #ccc;
}

.bs-calltoaction.bs-calltoaction-primary .cta-button .btn,
.bs-calltoaction.bs-calltoaction-info .cta-button .btn,
.bs-calltoaction.bs-calltoaction-success .cta-button .btn,
.bs-calltoaction.bs-calltoaction-warning .cta-button .btn,
.bs-calltoaction.bs-calltoaction-danger .cta-button .btn{
    border-color:#fff;
}

.msg-cls {
  padding: 15px 0 16px 9px !important;
}
.col-sm-8.page-cls {
    margin-top: 94px;
}
.header-title{
   margin-bottom:5px; 
   color: skyblue;
}
</style>