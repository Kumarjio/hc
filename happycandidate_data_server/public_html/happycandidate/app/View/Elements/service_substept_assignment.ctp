<script type="text/javascript">
    $(document).ready(function () {
        $('#add_service').click(function () {
            fnSubmitAssignService();
            return false;
        });
    });
    function fnSubmitAssignService()
    {
        var strContentId = $('#content_added').val();
        if (strContentId == "")
        {
            $('#product_notification').html('');
            $('#product_notification').html('<div role="alert" class="alert-danger"><strong>Failed !</strong> You need to add content first</div>');
            return false;
        }
        var isValidated = $('#servicecategoryform').validationEngine('validate');
        //var isValidated = true;
        if (isValidated == false)
        {
            return false;
        } else
        {
            var pageurl = "<?php echo Router::url('/', true) . $this->params['controller'] . "/setsubstepservice"; ?>";
            var pagetype = "POST";
            var pageoptions = {
                beforeSubmit: function (formData, jqForm, options) {
                    $('#content_cat_form').hide();
//                    $('.tabloader').show();
                    $('.cms-bgloader-mask').show();//show loader mask
                    $('.cms-bgloader').show(); //show loading image
                },
                success: function (responseText, statusText, xhr, $form) {
                    //alert(responseText);
                    if (responseText.status == "success")
                    {
                        $('#content_cat_form').show();
                        $('.tabloader').hide();
                        $('#product_notification').html('');
                        $('#product_notification').html(responseText.message);
                        $('#product_notification').fadeIn('slow');
                    } else
                    {
                        $('#content_cat_form').show();
                        $('.tabloader').hide();
                        $('#product_notification').html('');
                        $('#product_notification').html(responseText.message);
                        $('#product_notification').fadeIn('slow');
                    }
                    $('.cms-bgloader-mask').hide();//show loader mask
                    $('.cms-bgloader').hide(); //show loading image

                },
                url: pageurl, // override for form's 'action' attribute 
                type: pagetype, // 'get' or 'post', override for form's 'method' attribute 
                dataType: 'json'        // 'xml', 'script', or 'json' (expected server response type) 
            }
            $('#servicecategoryform').ajaxSubmit(pageoptions);
            return false;
        }
    }
</script>
<style>
.nopadding {
    float: left;
    width: 100%;
}
.category{ float: left; }
</style>
<form id="servicecategoryform" name="servicecategoryform" action="" method="post" role="form">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-9">
                <div class="col-md-12"><strong>Choose Substep:</strong></div>
                <div class="col-md-12">
                    <p id="cat_loader"></p>
                    <div class="catcontainer" style="overflow: auto; height: 400px;">
                        <?php
                        if (is_array($arrVendorServiceDetail) && (count($arrVendorServiceDetail) > 0)) {
                            $content_category_id = array();
                            foreach ($arrVendorServiceAssigned as $arrVendorService) {
                                $content_category_id[] = $arrVendorService['substepProducts']['content_category_id'];
                            }
                            $content_category_id = array_unique($content_category_id);
                            foreach ($arrVendorServiceDetail as $arrVendorServicekey => $arrVendorServicevalue) {
                                //print_r($arrVendorServiceAssigned);
                                $product_name = $arrVendorServicevalue;
                                $productd_id = $arrVendorServicekey;
                                ?>
                                <div class="nopadding nomargin">
                                    <?php
                                    if (in_array($productd_id, $content_category_id)) {
                                        ?>
                                        <input type="checkbox" checked name="stepid[]" id="servicename" class="category" style="float: left;" value="<?php echo $productd_id; ?>" /> <?php echo $product_name; ?>
                                        <input type="hidden" name="vendor_service_id" id="vendor_service_id" value="<?php echo $vendor_service_id; ?>"/>
                                        <?php
                                    } else {
                                        ?>
                                        <input type="checkbox"  name="stepid[]" id="servicename" class="category" style="float: left;" value="<?php echo $productd_id; ?>" /> <?php echo $product_name; ?>
                                        <input type="hidden" name="vendor_service_id" id="vendor_service_id" value="<?php echo $vendor_service_id; ?>"/>


                                        <?php
                                    }
                                    ?>
                                </div>
                        
                                
                        
                        
                        
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" name="content_id" id="content_id"  value="<?php echo $strContentId; ?>" />

        </div>
        <div class="col-md-9"><input name="add_service" id="add_service" type="submit" value="Assign Services" class="btn btn-success"></input>&nbsp;<input name="cancel" class="btn btn-default" id="cancel" type="reset" onclick="window.location = '<?php echo $this->request->referer(); ?>'" value="Cancel"></input></div>
    </div>
</form>