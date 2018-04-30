<!--<p>-->
	<!--<h2><?php // echo $confirmationmessage; ?></h2>-->
<!--</p>-->
 
<div class="container-fluid">
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
                            <?php if($_SESSION['Message']['flash']['params']['class'] == 'success') { ?>
                            <h1 class="cta-title">Success!</h1>
                            <?php }else{?>
                            <h1 class="cta-title">Fail!</h1>
                            <?php }?>
                            <div class="cta-desc">
                                <?php if($_SESSION['Message']['flash']['params']['class'] == 'success') { ?>
                                    <div class="alert alert-success alert-dismissable msg-cls">
                                        <strong>Congratulations!</strong> <?php echo $_SESSION['Message']['flash']['message'];?>
                                    </div>
                                <?php }else{?>
                                    <div class="alert alert-danger alert-dismissable msg-cls">
                                        <strong>Fail!</strong> <?php echo $_SESSION['Message']['flash']['message'];?>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
<!--                        <div class="col-md-3 cta-button">
                            <a href="#" class="btn btn-lg btn-block btn-default">Go for It!</a>
                        </div>-->
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
    background-color: #fff;
    border-color: #ccc;
}

.bs-calltoaction.bs-calltoaction-primary .cta-button .btn,
.bs-calltoaction.bs-calltoaction-info .cta-button .btn,
.bs-calltoaction.bs-calltoaction-success .cta-button .btn,
.bs-calltoaction.bs-calltoaction-warning .cta-button .btn,
.bs-calltoaction.bs-calltoaction-danger .cta-button .btn{
    border-color:#fff;
}

.alert.alert-success.alert-dismissable.msg-cls {
  padding: 15px 0 16px 9px !important;
}
.col-sm-8.page-cls {
    margin-top: 94px;
}
</style>