<?php 
$strReturnUrl = Router::url(array('controller' => 'candidates', 'action' => 'webinars', $intPortalId), true);
?>	



<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1><?php echo strip_tags($arrLibCatDetail[0]['Categories']['content_category_name']); ?></h1>
<!--                <div class="tab-row-container">
                    <p>&nbsp;</p>
                </div>-->
                <div class="tab-row-container">
                
                <?php
if (count($arrContentDetail) > 0) {
    ?>
                    <div class="col-lg-12">
                <div class="find-jobs-body">
                    <div class="col-md-12">
                        <div class="simple-container webinar">
                            <?php //  print_R($arrContentDetail); ?>
                            <h2><?php echo stripslashes($arrContentDetail[0]['Content']['content_title']); ?></h2>
                            <p class="subtitle">
                            </p>
                        </div>
                        <hr>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                        <div class="simple-container webinar body">
                            <p><?php
                                echo htmlspecialchars_decode(stripslashes($arrContentDetail[0]['Content']['content']));
                                ?>
                            </p>

                                    <!--<p>When: <span class="dark-bold"><?php //echo date($productdateformat,strtotime($arrContentDetail[0]['Content']['content_published_date']));          ?></span><!--<br>Duration: <span class="dark-bold">21 hour</span></p>-->
                        </div>
                    </div>

                    <!--<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <a href="<?php echo stripslashes($arrContentDetail[0]['Content']['webinarRegisterLink']); ?>"  target="_blank" class="btn btn-primary btn-large">Register Now <span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>-->
                </div>
                <hr>

            </div>
                    <?php
} else {
    ?>
    <div class="container-fluid bg-lightest-grey">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h1 class="error-main-heading">Not Found Article</h1>
            <p class="error-description">Aenean tempor congue scelerisque. Nam non nunc sit amet nulla lobortis rutrum sed ac justo. Sed sollicitudin volutpat ipsum. Nunc ut augue ligula. </p>
            <div class="goto-from-error">
                <button class="btn btn-primary btn-md" type="button"><span class="glyphicon glyphicon-chevron-left"></span> Back to the Home Page</button>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
<?php }
?>
                </div>

                
            </div>
        </div>
    </div>
</div>


<!--<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                <h1><?php echo strip_tags($arrLibCatDetail[0]['Categories']['content_category_name']); ?></h1>
                <div class="tab-row-container">
                    <p>&nbsp;</p>
                </div>
            </div>

            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <div class="tab-row-container">
                    <div class="library-container">
                        <?php
                        if (count($arrContentDetail) > 0) { ?>
                                <div class="library-element">
                                    <div class="library-element-head">
                                        <div class="webinar-left">
                                            <div class="webinar-image"></div>
                                        </div>
                                        <h3>
                                          <?php echo stripslashes($arrContentDetail[0]['Content']['content_title']); ?>
                                        </h3>

                                    </div>
                                    <p class="library-element-description">
                                        <?php echo htmlspecialchars_decode(stripslashes($arrContentDetail[0]['Content']['content']));?>
                                    </p>
                                </div>
                                <?php
                        } else {
                            ?>
                            <div class="library-element">
                                <div class="library-element-head">
                                    <h3>There are no Content to List.</h3>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-1"></div>
        </div>
    </div>
</div>

--><style>
/*    .library-element {
  border-bottom: 1px solid #ddd;
  margin-bottom: 0 !important;
  margin-top: 10px;
  overflow: auto;
  padding-left: 15px;
  padding-right: 15px;
}
.library-container {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 5px;
  overflow: auto;
  padding: 10px 12px 0;
  width: 100%;
}*/

.tab-row-container {
  margin-top: -48px !important;
  overflow: auto;
}

</style>