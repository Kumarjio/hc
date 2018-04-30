<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="page-header">
                <h2>Upload Images</h2>
            </div>
            <div id="product_notification"></div>
            <ul class="nav nav-pills tab-list">
                <li class="active">
                    <a href="#js-vendor-panel" data-toggle="pill" id="js-vendor-panel">Services Image Panel</a>
                </li>
            </ul>
            <div style="padding-top: 20px;" class="tab-content">
                <div class="tab-pane fade in active" id="tab-vendor-panel">
                    <?php
                    echo $this->element("serviceimages");
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo $this->element('assign_media_modal');
?>

<style>
    .nav.nav-pills li a {
        width: 200px !important;
    }
</style>