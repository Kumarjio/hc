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
        if (strContTy == 2)
        {
            $('#webinarregister').css('display', 'block');
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

    function fnSubmitContent(isToBePublished)
    {
        var isValidated = $('#contentform').validationEngine('validate');

        //var isValidated = true;

        if (isValidated == false)
        {
            return false;
        } else
        {
            var strIntroContentEditorType = $('.html.editor2.active').text();


            var strMainContentEditorType = $('.html.editor1.active').text();
            if (strMainContentEditorType == "Text")
            {
                var strMainContent = $('#main_content').val();
            } else
            {
                var strMainContent = tinyMCE.get('main_content').getContent();

            }

            var strCurrentLocation = window.location.href;
            var arrCurrentLocationDetail = strCurrentLocation.split("/");

            var pageurl = "<?php echo Router::url('/', true) . "email/add/"; ?>";
            var pagetype = "POST";
            var pageoptions = {
                beforeSubmit: function (formData, jqForm, options) {
                    $('.cms-bgloader-mask').show();//show loader mask
                    $('.cms-bgloader').show(); //show loading image
                    $('#content_html').hide();
                    formData.push({name: 'main_content', value: strMainContent});

                    formData.push({name: 'content_edit_id', value: $('#content_edit_id').val()});
                    if (isToBePublished == "1")
                    {
                        formData.push({name: 'to_publish', value: "1"});
                    }

                },
                success: function (responseText, statusText, xhr, $form) {

                    if (responseText.status == "success")
                    {

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
                        if ($('#content_request_for_id').length > 0)
                        {
                            if ($('#content_request_for_id').val() == "99")
                            {
                                $('.page-header h1').text('Edit Page');
                            } else
                            {
                                $('.page-header h1').text('Edit Content');
                            }
                        } else
                        {
                            $('.page-header h1').text('Edit Content');
                        }
                        $('#cat').show();

                        //$('#contentparent').show();
                        $('#jbsearchcat').show();

                        //var strTobeReturned = $("#dialog-add-page-form").data('returnvalue');
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

<?php
// echo '<pre>';print_r($arrEmailContent);die;
if (count($arrEmailContent) > 0) {
    $template_key = $arrEmailContent['Email']['template_key'];
    $templateid = $arrEmailContent['Email']['id'];
    $disablecss = "disabled='disabled'";
} else {
    $template_key = '';
    $templateid = 0;
    $disablecss = '';
}
?>
<div id="product_notification" ></div>
<form id="contentform" name="contentform"  method="post" role="form">
    <div class="form-group"  >
        <label class="control-label col-xs-12 col-sm-12 col-md-4">Template Name:</label>
        <input type="text" name="template_name" id="template_name" class="form-control" value="<?php echo stripslashes($arrEmailContent['Email']['template_name']); ?>"/>
        <input type="hidden" name="templateid" id="templateid" class="form-control" value="<?php echo $templateid; ?>"/>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-12 col-md-4">Template Type:</label>	
        <select name="template_type" id="template_type" class="form-control col-xs-12 col-sm-12 col-md-8">
            <option value="">--Select Type--</option>
            <option <?php if ($arrEmailContent['Email']['template_type'] == "seekers") { echo 'selected=selected'; } ?> value="seekers">Job Seekers</option>
            <option <?php if ($arrEmailContent['Email']['template_type'] == "vendors") { echo 'selected=selected';}?> value="vendors">Vendors</option>
            <option <?php if ($arrEmailContent['Email']['template_type'] == "owners") { echo 'selected=selected'; }?> value="owners">Owners</option>
            <option <?php if ($arrEmailContent['Email']['template_type'] == "search") { echo 'selected=selected';}?> value="search">Job Search Tracker Tool</option>
        </select>
    </div>

    <div class="form-group" id="jobseekerdrop" style="display:none;">
        <label class="control-label col-xs-12 col-sm-12 col-md-4">Template For:</label>	
        <select name="template_for_seeker" id="template_for_seeker" class="form-control col-xs-12 col-sm-12 col-md-8">
            <option value="">--Select Option--</option>
            <option <?php
            if ($arrEmailContent['Email']['template_key'] == "seeker new registration") {
                echo 'selected=selected';
            }
            ?> value="seeker new registration">New Registration</option>
            <option <?php
            if ($arrEmailContent['Email']['template_key'] == "seeker forgot password") {
                echo 'selected=selected';
            }
            ?> value="seeker forgot password">Job Seeker forgets password</option>
            <option <?php
            if ($arrEmailContent['Email']['template_key'] == "seeker forgot username") {
                echo 'selected=selected';
            }
            ?> value="seeker forgot username">Job Seeker forgets username</option>
            <option <?php
            if ($arrEmailContent['Email']['template_key'] == "seeker new orders") {
                echo 'selected=selected';
            }
            ?> value="seeker new orders">Job Seeker orders new service, product or course</option>
            <option <?php
            if ($arrEmailContent['Email']['template_key'] == "seeker orders") {
                echo 'selected=selected';
            }
            ?> value="seeker orders">Job Seeker orders products, services, or courses</option>
            <option <?php
            if ($arrEmailContent['Email']['template_key'] == "seeker cancel") {
                echo 'selected=selected';
            }
            ?> value="seeker cancel">Job Seeker Cancels or Inactivates their account</option>
            <option <?php
            if ($arrEmailContent['Email']['template_key'] == "seeker about site") {
                echo 'selected=selected';
            }
            ?> value="seeker about site">Allows Job Seekers to tell friends about their site</option>
        </select>
    </div>

    <div class="form-group" id="vendorsdrop" style="display:none;">
        <label class="control-label col-xs-12 col-sm-12 col-md-4">Template For:</label>	
        <select name="template_for_vendor" id="template_for_vendor" class="form-control col-xs-12 col-sm-12 col-md-8">
            <option value="">--Select Option--</option>
            <option <?php
            if ($arrEmailContent['Email']['template_type'] == "vendor new registration") {
                echo 'selected=selected';
            }
            ?> value="vendor new registration">Vendor New Registration</option>
            <option <?php
            if ($arrEmailContent['Email']['template_type'] == "vendor forgot password") {
                echo 'selected=selected';
            }
            ?> value="vendor forgot password">Vendor forgets password</option>
            <option <?php
            if ($arrEmailContent['Email']['template_type'] == "vendor forgot username") {
                echo 'selected=selected';
            }
            ?> value="vendor forgot username">Vendor  forgets username</option>
            <option <?php
            if ($arrEmailContent['Email']['template_type'] == "vendor purchase") {
                echo 'selected=selected';
            }
            ?> value="vendor purchase">Vendor product, service or course was purchased</option>
            <option <?php
            if ($arrEmailContent['Email']['template_type'] == "completes purchase") {
                echo 'selected=selected';
            }
            ?> value="completes purchase">Vendor completes purchase</option>
        </select>
    </div>

    <div class="form-group" id="ownersdrop" style="display:none;">
        <label class="control-label col-xs-12 col-sm-12 col-md-4">Template For:</label>	
        <select name="template_for_owner" id="template_for_owner" class="form-control col-xs-12 col-sm-12 col-md-8">
            <option value="">--Select Option--</option>
            <option <?php
            if ($arrEmailContent['Email']['template_type'] == "new purchase owner") {
                echo 'selected=selected';
            }
            ?> value="new purchase owner">New Purchase welcoming Owner</option>
            <option <?php
            if ($arrEmailContent['Email']['template_type'] == "owner forgot password") {
                echo 'selected=selected';
            }
            ?> value="owner forgot password">Owner forgets password</option>
            <option <?php
            if ($arrEmailContent['Email']['template_type'] == "owner forgot username") {
                echo 'selected=selected';
            }
            ?> value="owner forgot username">Owner forgets username</option>
            <option <?php
            if ($arrEmailContent['Email']['template_type'] == "seeker applies job") {
                echo 'selected=selected';
            }
            ?> value="seeker applies job">Job Seeker applies for open job posted by career portal owner</option>
            <option <?php
            if ($arrEmailContent['Email']['template_type'] == "owner cancels") {
                echo 'selected=selected';
            }
            ?> value="owner cancels">Owner Cancels or Inactivates their account – admin must </option>
            <option <?php
            if ($arrEmailContent['Email']['template_type'] == "receive notice") {
                echo 'selected=selected';
            }
            ?> value="receive notice">Receive notice of this somehow</option>
        </select>
    </div>

    <div class="form-group" id="searchdrop" style="display:none;">
        <label class="control-label col-xs-12 col-sm-12 col-md-4">Template For:</label>	
        <select name="template_for_search" id="template_for_search" class="form-control col-xs-12 col-sm-12 col-md-8">
            <option value="">--Select Option--</option>
            <option <?php
            if ($arrEmailContent['Email']['template_type'] == "seeker task") {
                echo 'selected=selected';
            }
            ?> value="seeker task">Job Seeker has a task</option>
            <option <?php
            if ($arrEmailContent['Email']['template_type'] == "seeker calendar") {
                echo 'selected=selected';
            }
            ?> value="seeker calendar">Job Seeker has an item on their calendar</option>
        </select>
    </div>


    <!--    <div class="form-group">
            <label class="control-label col-xs-12 col-sm-12 col-md-4">Template For:</label>	
            <select name="template_for" id="template_for" class="form-control col-xs-12 col-sm-12 col-md-8" <?php echo $disablecss; ?>>
                <option value="0">--Select Option--</option>
                <option value="registration">Registration Template</option>
                <option value="forgot">Forgot Password Template</option>
                <option value="order">Order Template</option>
            </select>
        </div>-->

    <div class="form-group"  >
        <label class="control-label col-xs-12 col-sm-12 col-md-4">From Email:</label><!--
        -->	
        <input type="text" name="from_email" id="from_email" class="form-control" value="<?php echo stripslashes($arrEmailContent['Email']['from_email']); ?>"/>
    </div>

    <div class="form-group"  >
        <label class="control-label col-xs-12 col-sm-12 col-md-4">From Name:</label><!--
        -->	
        <input type="text" name="from_name" id="from_name" class="form-control" value="<?php echo stripslashes($arrEmailContent['Email']['from_name']); ?>"/>
    </div>

    <div class="form-group"  >
        <label class="control-label col-xs-12 col-sm-12 col-md-4">Email Subject:</label><!--
        -->	
        <input type="text" name="email_subject" id="email_subject" class="form-control" value="<?php echo stripslashes($arrEmailContent['Email']['email_subject']); ?>"/>
    </div>


    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2">Main Content:</label><!--
        -->

    </div>
    <?php
    if (isset($arrEmailContent) && ($arrEmailContent['Email']['email_text'])) {
        ?>
        <textarea class="form-control" id="main_content" name="main_content" rows="5"><?php echo stripslashes($arrEmailContent['Email']['email_text']); ?></textarea>
        <?php
    } else {
        ?>
        <textarea class="form-control" id="main_content" name="main_content" rows="5"></textarea>
        <?php
    }
    ?>



</div>
<div class="col-md-12 submit-container">
    <div class="col-md-6">
        <div class="form-group">
            <div class="hidden-xs hidden-sm col-md-4"></div>
            <div class="col-xs-12 col-sm-12 col-md-8">
                <button type="button" class="btn btn-primary" onclick="return fnSubmitContent();" type="button">Save Changes</button>
                <button class="btn btn-warning" type="button">Cancel</button>
            </div></div>
    </div>
</div>
</form>




<?php
echo $this->Html->script('content_form');
?>
<?php
//echo $this->element('contentfile_uploader_modal');
?>
<script>
    $('#template_for').val('<?php echo $template_key; ?>');
    $('#content_type').change(function ()
    {
        var textselected = $("#content_type :selected").text();
        if (textselected == "Webinars")
        {
            $('#webinarregister').css('display', 'block');
        } else
        {
            $('#webinarregister').css('display', 'none');
        }
    })

    $('#template_type').change(function ()
    {
        var template_type = $('#template_type').val();
        if (template_type == 'seekers') {
            $('#jobseekerdrop').show();
            $('#vendorsdrop').hide();
            $('#ownersdrop').hide();
            $('#searchdrop').hide();
        } else if (template_type == 'vendors') {
            $('#vendorsdrop').show();
            $('#jobseekerdrop').hide();
            $('#ownersdrop').hide();
            $('#searchdrop').hide();
        } else if (template_type == 'owners') {
            $('#ownersdrop').show();
            $('#jobseekerdrop').hide();
            $('#vendorsdrop').hide();
            $('#searchdrop').hide();
        } else {
            $('#searchdrop').show();
            $('#vendorsdrop').hide();
            $('#ownersdrop').hide();
            $('#jobseekerdrop').hide();
        }
    });

    $(document).ready(function () {
        var template_type = '<?php echo $arrEmailContent['Email']['template_type'] ?>';

        if (template_type == 'seekers') {
            $('#jobseekerdrop').show();
            $('#vendorsdrop').hide();
            $('#ownersdrop').hide();
            $('#searchdrop').hide();
        } else if (template_type == 'vendors') {
            $('#vendorsdrop').show();
            $('#jobseekerdrop').hide();
            $('#ownersdrop').hide();
            $('#searchdrop').hide();
        } else if (template_type == 'owners') {
            $('#ownersdrop').show();
            $('#jobseekerdrop').hide();
            $('#vendorsdrop').hide();
            $('#searchdrop').hide();
        } else {
            $('#searchdrop').show();
            $('#vendorsdrop').hide();
            $('#ownersdrop').hide();
            $('#jobseekerdrop').hide();
        }
    });

</script>