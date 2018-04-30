<script type="text/javascript">
    var strContTy = "<?php echo $arrProductContent[0]['content']['content_type']; ?>";
    var strContU = "<?php echo $arrProductContent[0]['content']['content_for_user']; ?>";
    $(document).ready(function () {
        if (strContTy)
        {
            $('#content_type').val(strContTy);
        }

        if (strContU)
        {
            $('#content_user').val(strContU);
        }

        $('#content_uploadhtml_file').click(function () {
            fnGetContentFileUploader();
            $('.files').html('');
        });

        $('#add').click(function () {
            var strFormSubmitStatus = fnSubmitContent();
            return false;
        });

        $('#add_publish').click(function () {
            var strFormSubmitStatus = fnSubmitContent("1");
            return false;
        });

        $('#banner_image_remover').click(function () {
            $('#banner_image_id').val('');
            $('#banner_image_thumb').hide();
            $('#banner_image_remover').hide();
        });

    });

    $(document).ready(function () {

        var arrProductContent = '<?php echo count($arrProductContent); ?>';

        $('#content_pub_date').datepicker({
            format: "mm/dd/yyyy",
            endDate: '0',
            autoclose: true
        });

        if (arrProductContent.length > 0) {
            $('#serviceproduct').css('display', 'block');
        } else {
            $('#serviceproduct').css('display', 'none');
        }

    });

    function fnGetContentFileUploader()
    {
        if ($('#contentfileuploadcont').length > 0)
        {
            $('.tabloader').hide();
        } else
        {
            $.ajax({
                type: "GET",
                url: strBaseUrl + "products/htmlfileuploader/forcontent",
                dataType: 'json',
                data: "",
                async: false,
                cache: false,
                success: function (data)
                {
                    if (data.status == "success")
                    {
                        //alert(data.content)
                        $('.tabloader').hide();
                        $('#contentfileuploadercontainer').html(data.content);
                    } else
                    {
                        alert("fail");
                    }
                }
            });
        }
    }

    function fnSubmitContent(isToBePublished)
    {
        var isValidated = $('#contentform').validationEngine('validate');
        //var isValidated = true;

        if (isValidated == false)
        {
            return false;
        } else
        {
            var strCurrentLocation = window.location.href;
            var arrCurrentLocationDetail = strCurrentLocation.split("/");

            var pageurl = "<?php echo Router::url('/', true) . "vendorservices/add/"; ?>";
            var pagetype = "POST";
            var pageoptions = {
                beforeSubmit: function (formData, jqForm, options) {
                    $('.cms-bgloader-mask').show();//show loader mask
                    $('.cms-bgloader').show(); //show loading image
                    formData.push({name: 'content_edit_id', value: $('#content_edit_id').val()});
                    if (isToBePublished == "1")
                    {
                        formData.push({name: 'to_publish', value: "1"});
                    }
                },
                success: function (responseText, statusText, xhr, $form) {
                    if (responseText.status == "success")
                    {
                        $('.tabloader').hide();
                        $('#content_html').show();
                        $('#product_notification').html('');
                        $('#product_notification').html(responseText.message);
                        $('#product_notification').fadeIn('slow');
                        $('#serviceproduct').css('display', 'block');
                        $('#vendor_service_id').val(responseText.createdid);
                    } else
                    {
                        $('.tabloader').hide();
                        $('#content_html').show();
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
            $('#contentform').ajaxSubmit(pageoptions);
            return false;
        }
    }
</script>

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="form-container">
                    <form id="contentform" name="contentform" action="" method="post" role="form">
                        <input value="<?php echo $arrProductContent['0']['Vendorservice']['vendor_service_id']; ?>" id="content_edit_id" name="content_edit_id" type="hidden" class="form-control">
                        <input type="hidden" name="content_request_for" id="content_request_for" value="" />
                        <input type="hidden" name="vendor_service_id" id="vendor_service_id" value="<?php echo $arrProductContent['0']['Vendorservice']['vendor_service_id']; ?>" />

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-12 col-md-4" for="name">Type: <span class="form-required">*</span></label>
                            <select id="product_type" name="product_type" onchange="fnLoadProductVendors();fnUserType(this.value);" class="col-xs-12 col-sm-12 col-md-8">
                                <?php $vendor_service_type = $arrProductContent['0']['Vendorservice']['vendor_service_type']; ?>
                                <option value="Services" <?php
                                if ($vendor_service_type == "Services") {
                                    echo "selected='selected'";
                                }
                                ?> >Services</option>
                                <option value="Product" <?php
                                if ($vendor_service_type == "Product") {
                                    echo "selected='selected'";
                                }
                                ?>>Product</option>
                                <option value="Course" <?php
                                if ($vendor_service_type == "Course") {
                                    echo "selected='selected'";
                                }
                                ?>>Course</option>
                            </select>
                        </div>


                        <div id="product_venddors">
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="name">Vendor Name: <span class="form-required">*</span></label>
                                <select id="vendor" name="vendor" class="col-xs-12 col-sm-12 col-md-8">
                                    <option value="">--Choose Vendor--</option>
                                    <?php
                                    $vendor_id = $arrProductContent['0']['Vendorservice']['vendor_id'];

                                    if (is_array($arrVendorServiceDetail['Vendors']) && (count($arrVendorServiceDetail['Vendors']) > 0)) {
                                        foreach ($arrVendorServiceDetail['Vendors'] as $arrVendor) {

                                            if ($arrVendor['Vendors']['vendor_first_name'] != '') {
                                                ?>
                                                <option value="<?php echo $arrVendor['Vendors']['vendor_id']; ?>" <?php
                                                if ($vendor_id == $arrVendor['Vendors']['vendor_id']) {
                                                    echo "selected='selected'";
                                                }
                                                ?>><?php echo $arrVendor['Vendors']['vendor_first_name'] . " " . $arrVendor['Vendors']['vendor_last_name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                </select>
                            </div>
                            <?php // echo '<pre>';print_r($arrVendorServiceDetail);die;?>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="name">Service Name: <span class="form-required">*</span></label>
                                <select id="service" class="col-xs-12 col-sm-12 col-md-8" name="service" onchange="fnGetServiceDetails();">
                                    <option value="">--Choose Service--</option>
                                    <?php
                                    $service_id = $arrProductContent['0']['Vendorservice']['service_id'];

                                    if (is_array($arrVendorServiceDetail['Services']) && (count($arrVendorServiceDetail['Services']) > 0)) {
                                        foreach ($arrVendorServiceDetail['Services'] as $arrResource) {
                                            ?>
                                            <option value="<?php echo $arrResource['Resources']['productd_id']; ?>" <?php
                                            if ($service_id == $arrResource['Resources']['productd_id']) {
                                                echo "selected='selected'";
                                            }
                                            ?>><?php echo $arrResource['Resources']['product_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                </select>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-12 col-md-4" for="name">Portal: <span class="form-required">*</span></label>
                            <select id="portal" name="portal" class="col-xs-12 col-sm-12 col-md-8" multiple="" size="20">
                                <option onclick="selectall();" value="">All</option>
                                <?php foreach ($arrPortalVendors as $portalVendors) {?>
                                    <option onclick="selectsingle();" value="<?php echo $portalVendors['Portal']['career_portal_id']; ?>"><?php echo $portalVendors['Portal']['career_portal_name']; ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="portalId" id="portalId">
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Service Cost : </label>
                            <?php
                            $strPubDateToshow = date($strDateFormat);
                            //$strPubDateToshow = date('Y-m-d');
                            if (isset($arrProductContent[0]['Vendorservice']['service_cost'])) {
                                ?>
                                <input value="<?php
                                if ($arrProductContent['0']['Vendorservice']['discount_cost'] == '') {
                                    echo stripslashes($arrProductContent['0']['Vendorservice']['service_cost']);
                                } else {
                                    echo stripslashes($arrProductContent['0']['Vendorservice']['discount_cost']);
                                }
                                ?>" id="service_cost" name="service_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter service cost here">
                                       <?php
                                   } else {
                                       ?>
                                <input value="" id="service_cost" name="service_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter service cost here"/> 
                                <?php
                            }
                            ?>

                        </div>
                        <div id="vendorCostInp">
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Vendor Cost : </label>
                                <?php
                                $strPubDateToshow = date($strDateFormat);
                                //$strPubDateToshow = date('Y-m-d');
                                if (isset($arrProductContent[0]['Vendorservice']['vendor_cost'])) {
                                    ?>
                                    <input value="<?php echo stripslashes($arrProductContent['0']['Vendorservice']['vendor_cost']); ?>" id="vendor_cost" name="vendor_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter vendor cost here">
                                    <?php
                                } else {
                                    ?>
                                    <input value="" id="vendor_cost" name="vendor_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter vendor cost here"> 
                                    <?php
                                }
                                ?>

                            </div>
                        </div>

                        <div class="form-group" style="display:none;">
                            <label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Merchant Cost Type : </label>
                            <select id="merchant_cost_type" name="merchant_cost_type" class="col-xs-12 col-sm-12 col-md-8" >
                                <option value="per" selected="selected">Percentage</option>
                                <option value="flat">Flat</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Merchant Cost(%) : </label>
                            <?php
                            $strPubDateToshow = date($strDateFormat);
                            //$strPubDateToshow = date('Y-m-d');
                            if (isset($arrProductContent['0']['Vendorservice']['merchant_cost'])) {
                                ?>
                                <input value="<?php echo stripslashes($arrProductContent['0']['Vendorservice']['merchant_cost']); ?>" id="merchant_cost" name="merchant_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter merchant cost here">
                                <?php
                            } else {
                                ?>
                                <input value="" id="merchant_cost" name="merchant_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter merchant cost here">
                                <?php
                            }
                            ?>
                        </div>

                        <div class="form-group" style="display:none;">
                            <label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Portal Owner Cost Type: </label>
                            <select id="portalowner_cost_type" name="portalowner_cost_type">
                                <option value="per" selected="selected">Percentage</option>
                                <option value="flat">Flat</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Portal Owner Revenue Share(%): </label>
                            <?php
                            $strPubDateToshow = date($strDateFormat);
                            if (isset($arrProductContent['0']['Vendorservice']['portal_cost'])) {
                                ?>
                                <input value="<?php echo stripslashes($arrProductContent['0']['Vendorservice']['portal_cost']); ?>" id="portal_cost" name="portal_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter portal owner share here">
                                <?php
                            } else {
                                ?>
                                <input value="" id="portal_cost" name="portal_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter portal owner share here">
                                <?php
                            }
                            ?>
                        </div>

                        <div class="form-group" style="display:none;">
                            <label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">HC Cost Type: </label>
                            <select id="hc_cost_type" name="hc_cost_type">
                                <option value="per" selected="selected">Percentage</option>
                                <option value="flat">Flat</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">HC Revenue Share(%): </label>
                            <?php
                            $strPubDateToshow = date($strDateFormat);
//$strPubDateToshow = date('Y-m-d');
                            if (isset($arrProductContent['0']['Vendorservice']['hc_cost'])) {
                                ?>
                                <input value="<?php echo stripslashes($arrProductContent['0']['Vendorservice']['hc_cost']); ?>" id="hc_cost" name="hc_cost" type="text" class="form-control validate[required]" placeholder="Enter HC share here">
                                <?php
                            } else {
                                ?>
                                <input value="" id="hc_cost" name="hc_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter HC share here">
                                <?php
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <div class="hidden-xs hidden-sm col-md-4"></div>
                            <div class="col-xs-12 col-sm-12 col-md-8 page-content-wrapper-buttons">
                                <button  class="btn btn-primary" name="add_publish" id="add_publish" type="submit">Save Changes</button>
                                <button type="button" class="btn btn-default" onclick="window.history.back();">Cancel</button>
                                <!--<button type="button" class="btn btn-default" onclick="window.location = '<?php echo $this->Session->read('strCancelUrl'); ?>'">Cancel</button>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    function selectall() {
        $('#portal option').prop('selected', true);

            var selected = $("#portal option:selected");
            var message = "";
            selected.each(function () {
                message += $(this).val() + ",";
            });
            
        $("#portalId").val(message);
    }

    function selectsingle() {
    var selected = $("#portal option:selected");
        var message = "";
        selected.each(function () {
            message += $(this).val() + ",";
        });
        $("#portalId").val(message);
    }

    function fnLoadProductVendors()
    {
        var strUserType = $('#user_type').val();
        var strProductType = $('#product_type').val();
        var strProductId = $('#content_edit_id').val();
        var strDataStr = "type=" + strProductType + "&product_id=" + strProductId + "&user_type=" + strUserType;
        $('.cms-bgloader-mask').show();//show loader mask
        $('.cms-bgloader').show(); //show loading image
        $.ajax({
            type: "POST",
            url: appBaseU + "vendorservices/gettypevendorproducts/",
            data: strDataStr,
            cache: false,
            dataType: "json",
            success: function (data)
            {
                if (data.status == "success")
                {
                    $('#product_venddors').html(data.html);
                } else
                {
                    $('#product_notification').html(data.message);
                }

                $('.cms-bgloader-mask').hide();//show loader mask
                $('.cms-bgloader').hide(); //show loading image
            }
        });
    }

    $(document).ready(function () {
        fnLoadProductVendors();
        var type = '<?php echo $vendor_service_type; ?>';
        if (type == "Product")
        {
            $("#userTypeDrp").show();
            $('select[name^="user_type"] option[value="Portal owner"]').attr("selected", "selected");
        } else {
            $("#userTypeDrp").hide();
            $('select[name^="user_type"] option[value="Vendor"]').attr("selected", "selected");
        }
    });

    function fnUserType(type) {
        if (type == "Product")
        {
            fnLoadProductVendors();
            $("#userTypeDrp").show();

        } else {
            $("#userTypeDrp").hide();
        }
    }
</script>

<style>
   select[multiple], select[size] {
    min-height: 250px !important;
}
</style>