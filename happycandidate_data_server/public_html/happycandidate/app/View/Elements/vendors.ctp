<?php
//echo "--".$arrProductContent[0]['content']['content_for_user'];exit;
?>
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

        $('#content_pub_date').datepicker({
            format: "mm/dd/yyyy",
            endDate: '0',
            autoclose: true
        });
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

            var pageurl = "<?php echo Router::url('/', true) . "vendors/add/"; ?>";
            var pagetype = "POST";
            var pageoptions = {
                beforeSubmit: function (formData, jqForm, options) {
                    $('#content_html').hide();
                    $('.cms-bgloader-mask').show();//show loader mask
                    $('.cms-bgloader').show(); //show loading image

                    //$('.tabloader').show();
                    formData.push({name: 'content_edit_id', value: $('#content_edit_id').val()});
                    if (isToBePublished == "1")
                    {
                        formData.push({name: 'to_publish', value: "1"});
                    }

                },
                success: function (responseText, statusText, xhr, $form) {
                    if (responseText.status == "success")
                    {
                        //$('.tabloader').hide();
                        $('.cms-bgloader-mask').hide();//show loader mask
                        $('.cms-bgloader').hide(); //show loading image

                        $('#content_html').show();
                        $('#product_notification').html('');
                        $('#product_notification').html(responseText.message);
                        $('#product_notification').fadeIn('slow');
                        if ($('#content_edit_id').val() != "")
                        {
                            $('#content_edit_id').val($('#content_edit_id').val());
                            $('#content_added').val($('#content_edit_id').val());
                        } else
                        {
                            $('#content_edit_id').val(responseText.createdid);
                            $('#content_added').val(responseText.createdid);
                        }
                        $('#js-content-panel').show();
                        $('#tab-content-panel').addClass('tab-pane fade in active');

                    } else
                    {
                        $('.tabloader').hide();
                        $('#content_html').show();
                        $('#product_notification').html('');
                        $('#product_notification').html(responseText.message);
                        $('#product_notification').fadeIn('slow');
                    }

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
<div class="col-md-12 form-container edit-contact">
    <form role="form" id="contentform" name="contentform" action="" method="post">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="first-name">First Name: <span class="form-required">*</span></label>
                <input type="text" placeholder="Matthew" value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_first_name']); ?>"  id="vendor_f_name" name="vendor_f_name" type="text"  class="col-xs-12 col-sm-12 col-md-8 validate[required]">
                <input value="<?php echo $arrProductContent['0']['Vendors']['vendor_id']; ?>" id="content_edit_id" name="content_edit_id" type="hidden" class="form-control">
                <input type="hidden" name="content_request_for" id="content_request_for" value="" />
                <input type="hidden" name="content_request_for_id" id="content_request_for_id" value="" />
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="last-name">Last Name: <span class="form-required">*</span></label>
                <input type="text" placeholder="Connely" value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_last_name']); ?>" id="vendor_last_name" name="vendor_last_name" class="col-xs-12 col-sm-12 col-md-8">
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="company-name"> Name: <span class="form-required">*</span></label> 
                <input type="text"  placeholder="Matrix Marketing" value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_name']); ?>" name="vendor_name" id="vendor_name" class="col-xs-12 col-sm-12 col-md-8">
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="job-title">Email:</label>
                <input type="text" placeholder="Matrix Marketing" value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_email']); ?>" id="vendor_email" name="vendor_email" class="col-xs-12 col-sm-12 col-md-8">
            </div>

            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="address">Phone:</label>
                <input type="text" placeholder="Phone" value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_phone']); ?>" name="vendor_phone" class="col-xs-12 col-sm-12 col-md-8">
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2">Password:</label>
                <input type="password"  id="vendor_pass" name="vendor_pass"  placeholder="Password" value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_password']); ?>" class="col-xs-12 col-sm-12 col-md-8">
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="city">Confirm Password:</label>
                <input type="password" value="<?php echo stripslashes($arrProductContent['0']['Vendors']['vendor_password']); ?>" id="vendor_conf_pass" name="vendor_conf_pass" placeholder="Confirm Password" class="col-xs-12 col-sm-12 col-md-8">
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="state">Vendor Type:</label>
                <select name="vendor_type" id="vendor_type" class="form-control col-xs-12 col-sm-12 col-md-8">
                    <option value="Services">Services Vendor</option>
                    <option value="Course">Course Vendor</option>
                    <option value="Product">Product Vendor</option>
                </select>

            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="state">Notify Account Details:</label>
                <select name="notify" id="notify">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="city">Product Access Link:</label>
                <input type="text" value="<?php echo stripslashes($arrProductContent['0']['Vendors']['product_access_link']); ?>" id="vendor_product_access_link"  name="vendor_product_access_link" placeholder="Product Access Link" class="col-xs-12 col-sm-12 col-md-8">
            </div>
        </div>
        <div class="col-md-12 submit-container">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="hidden-xs hidden-sm col-md-4"></div>
                    <div class="col-xs-12 col-sm-12 col-md-8">
                        <button name="add_publish" id="add_publish" type="submit"  class="btn btn-primary" >Save Changes</button>
                        <button class="btn btn-warning" type="button">Cancel</button>
                    </div></div>
            </div>
        </div>
    </form>
</div>