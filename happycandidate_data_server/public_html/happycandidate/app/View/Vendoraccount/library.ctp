<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid bg-lightest-grey">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 bg-lightest-grey">

                <div class="page-header">
                    <h2>Library</h2>
                    <p>Welcome to your Career Portal Library.  The Library offers you the tools that will assist you in generating revenue while promoting your Career Portal.</p>
                </div>
                <div class="library-categories">
                    <?php
                    if (isset($arrLibCatDetail)) {
                        if (is_array($arrLibCatDetail) && (count($arrLibCatDetail) > 0)) {

                            foreach ($arrLibCatDetail as $arrAllMaterialDetailsKey => $arrLibCatDetailVal) {
                                $strlibCatDetailUrl = Router::url(array('controller' => 'vendoraccount', 'action' => 'libcatdetail', $arrLibCatDetailVal['Categories']['content_category_id']), true);
                                ?>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">

                                    <?php if ($arrLibCatDetailVal['Categories']['content_category_image'] != null && $arrLibCatDetailVal['Categories']['content_category_image'] != "") { ?>
                                        <img class="library-item" style="height: 70px;" src="<?php echo $this->webroot; ?>contentcat/<?php echo $arrLibCatDetailVal['Categories']['content_category_image']; ?>">
                                    <?php } else { ?>
                                        <div class="library-item" style="height: 70px;width: 70px;background-color: #e4d6d6;text-align: center;vertical-align: middle;padding: 13px;">No Icon</div>						<?php } ?>

                                    <h3><a href="<?php echo $strlibCatDetailUrl; ?>" style="font-size:inherit;"><?php echo $arrLibCatDetailVal['Categories']['content_category_name']; ?></a></h3>

                                </div>

                                <?php
                            }
                        }
                    }
                    ?>

                </div>	
            </div>

        </div>
        <div class="col-md-1"></div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.leftnavi').removeClass('active');
        $('#libnavi').addClass('active');
    });
</script>
<style>
.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
  padding-right: 0 !important;
}
</style>