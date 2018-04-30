<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="page-header">
                <h2>Edit Vendor to Service</h2>
            </div>
            <!--message display here-->
            <div id="product_notification"></div> 
            <!--message display here-->
            <ul class="nav nav-pills tab-list">
                <li class="active">
                    <a href="#tab-vendor-panel" data-toggle="pill" id="js-vendor-panel">Vendors to Service Panel</a>
                </li>
                <li id="serviceproduct" style="display:none;">
                    <a href="#tab-serviceproduct-panel" data-toggle="pill" id="js-serviceproduct-panel">services to substeps Panel</a>
                </li>
            </ul>
            <div style="padding-top: 20px;" class="tab-content">
                <div class="tab-pane fade in active" id="tab-vendor-panel">
                    <?php
                    echo $this->element("vendorstoservice");
                    ?>
                </div>
                <div class="tab-pane fade" id="tab-serviceproduct-panel">
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo $this->element('assign_media_modal');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("a[data-toggle='pill']").click(function () {

            var strNewTab = $(this).attr('id');


            if (strNewTab == "js-serviceproduct-panel")
            {

                if ($('#js-serviceproduct-panel').length > 1)
                {
                    $('.tabloader').hide();
                } else
                {
                    var vendor_service_id = $('#vendor_service_id').val();
                    fnGetSubstepservices(vendor_service_id);
                }
            }
        });
    });
</script>

