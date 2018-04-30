<?php
//echo "--".$arrProductContent[0]['content']['content_for_user'];exit;
?>
<script type="text/javascript">
    var strContTy = "<?php echo $arrProductContent[0]['content']['content_type']; ?>";
    var strContU = "<?php echo $arrProductContent[0]['content']['content_for_user']; ?>";
    $(document).ready(function () {
        $('.tabloader').hide();

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

        /*$('#content_pub_date').datepicker({
         format: "mm/dd/yyyy",
         endDate:'0',
         autoclose: true
         });*/
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
        if (isValidated == false)
        {
            return false;
        } else
        {
            $('.cms-bgloader-mask').show();//show loader mask
            $('.cms-bgloader').show(); //show loading image

            var strIntroContentEditorType = $('.html.editor2.active').text();
            if (strIntroContentEditorType == "Text")
            {
                var strIntroContent = $('#intro_content').val();
            } else
            {
                var strIntroContent = tinyMCE.get('intro_content').getContent();

            }

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

            var pageurl = "<?php echo Router::url('/', true) . "resource/add/"; ?>";
            var pagetype = "POST";
            var pageoptions = {
                beforeSubmit: function (formData, jqForm, options) {
                    $('#content_html').hide();

                    formData.push({name: 'main_content', value: strMainContent});
                    formData.push({name: 'intro_content', value: strIntroContent});
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
                        $('#cat').show();
                        //$('#contentparent').show();
                        $('#jbsearchcat').show();

                        //var strTobeReturned = $("#dialog-add-page-form").data('returnvalue');
                    } else
                    {
                        $('.cms-bgloader-mask').hide();//show loader mask
                        $('.cms-bgloader').hide(); //show loading image
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
//print("<pre>");
//print_r($arrProductContent);
?>
<div data-parent="#edit-contact-panel-slider" id="edit-contact" class="collapse in" style="">
<div class="col-md-12 form-container edit-contact">
    <div class="tabloader"></div>
    <form id="contentform" name="contentform" action="" method="post" role="form">
        <div class="col-md-12">
            <div id="product_notification"></div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="first-name">Name: <span class="form-required">*</span></label>
                <input type="text" placeholder="Matthew" value="<?php echo stripslashes($arrProductContent['0']['Resources']['product_name']); ?>" id="service_name" name="service_name" type="text"  class="col-xs-12 col-sm-12 col-md-8 validate[required]">
                <input value="<?php echo $arrProductContent['0']['Resources']['productd_id']; ?>" id="content_edit_id" name="content_edit_id" type="hidden" class="form-control">
                <input type="hidden" name="content_request_for" id="content_request_for" value="" />
                <input type="hidden" name="content_request_for_id" id="content_request_for_id" value="" />
                <input type="hidden" name="external_service_id" id="external_service_id" value="<?php echo $arrProductContent['0']['Resources']['external_content_id']; ?>" />
            </div>
            
            
            
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="company-name"> Type: <span class="form-required">*</span></label>
                <select class="form-control validate[required]" name="service_type" id="service_type" onchange="fnCheckType(this.value);">
                    <option value="">--Choose Type--</option>
                    <option <?php
                    if ($arrProductContent[0]['Resources']['product_type'] == 'Services') {
                        echo 'selected=selected';
                    }
                    ?> value="Services">Services</option>
                    <option <?php
                    if ($arrProductContent[0]['Resources']['product_type'] == 'Product') {
                        echo 'selected=selected';
                    }
                    ?> value="Product">Product</option>
                    <option <?php
                    if ($arrProductContent[0]['Resources']['product_type'] == 'SkillSoftcourse') {
                        echo 'selected=selected';
                    }
                    ?> value="SkillSoftcourse">SkillSoftcourse</option>
                </select>												
            </div>
            
            <div class="form-group" id="servicesName">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="name">Parent Service: </label>
                <select id="service" class="col-xs-12 col-sm-12 col-md-8" name="service">
                    <option value="">--Choose Service--</option>
                    <?php
                    $service_id = $arrProductContent['0']['Resources']['product_parent'];
                    if (is_array($arrServicesDetails) && (count($arrServicesDetails) > 0)) {
                        foreach ($arrServicesDetails as $arrservices) {
                            ?>
                            <option value="<?php echo $arrservices['Resources']['productd_id']; ?>" <?php
                            if ($service_id == $arrservices['Resources']['productd_id']) {
                                echo "selected='selected'";
                            }
                            ?>><?php echo $arrservices['Resources']['product_name']; ?>
                            </option>
                                    <?php
                                }
                            }
                            ?>
                </select>

            </div>
            
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="company-name"> Product Access Link:</label>
                <input value="<?php echo stripslashes($arrProductContent['0']['Resources']['product_access_link']); ?>" id="service_access_link" name="service_access_link" type="text" class="form-control" placeholder="Enter product access link here" />											
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="company-name"> Regular Cost: <span class="form-required">*</span></label>
                <input value="<?php echo stripslashes($arrProductContent['0']['Resources']['product_cost']); ?>" id="service_cost" name="service_cost" type="text" class="form-control validate[required]" placeholder="Enter your service cost here">
            </div>
            
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="company-name"> Discount Cost:</label>
                <input <?php if($arrProductContent['0']['Resources']['discount_cost'] !='' || $arrProductContent['0']['Resources']['discount_cost'] !='0.00'){ ?> value="<?php if($arrProductContent['0']['Resources']['discount_cost'] !='0.00') { echo stripslashes($arrProductContent['0']['Resources']['discount_cost']);} ?>" <?php }?>id="discount_cost" name="discount_cost" type="text" class="form-control" placeholder="Enter your service discount cost here">
            </div>
            
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="job-title">Content Title:</label>
                <input type="text" placeholder="Content Title" value="<?php echo stripslashes($arrProductContent['0']['Content']['content_title']); ?>" id="content_title" name="content_title" class="col-xs-12 col-sm-12 col-md-8">

            </div>

            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="address">Title Alias:</label>
                <input type="text" placeholder="Title Alias" value="<?php echo stripslashes($arrProductContent['0']['Content']['content_title_alias']); ?>" id="content_title_alias" name="content_title_alias" class="col-xs-12 col-sm-12 col-md-8">
            </div>

            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="Product File">Product File:</label>
                <input type="file" id="product_file" name="product_file" class="col-xs-12 col-sm-12 col-md-8">
            </div>
            <?php if($arrProductContent['0']['Resources']['product_file'] !=''){?>
            <div class="form-group file-cls">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="Product File">&nbsp;</label>
                <a href="<?php echo Router::url('/',true).'productfiles/'.$arrProductContent['0']['Resources']['product_file'];?>" target="_blank">
                    <img src="<?php echo Router::url('/',true).'img/zip_icon.png';?>" width="100px" height="100px" alt="<?php echo $arrProductContent['0']['Resources']['product_file'];?>" class="img-responsive" title="<?php echo $arrProductContent['0']['Resources']['product_file']; ?>"> 
                </a>
            </div>  
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2"></label>
                <input data-toggle="modal" data-target="#mediaModal" name="add_media_main_content" id="add_media" class="content_media_button" type="button" value="Add Media"></input>
            </div>
            <!--<div class="form-group">
    
            
                    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2">Content Intro Text:</label><!--
                    -->
            <!--<div name="reference-description" class="col-xs-12 col-sm-12 col-md-8 app-area-container">
            <textarea id="txtEditor" name="intro_content" ><?php //echo stripslashes($arrProductContent['0']['Content']['content_intro_text']);          ?></textarea> 
        </div>
    </div>-->

            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2">Content Intro Text:</label><!--
                <div class="tinymce-tabs nopadding nomargin">
                        <a class="html editor2">Text</a>
                        <a class="visual editor2" class="active">Visual</a>
                        <div style="clear: both;"></div>
                </div>
                -->
                <?php
                if (isset($arrProductContent) && ($arrProductContent['0']['Content']['content_intro_text'])) {
                    ?>
                    <textarea class="form-control" id="intro_content" name="intro_content" rows="5"><?php echo stripslashes($arrProductContent['0']['Content']['content_intro_text']); ?></textarea>
                    <?php
                } else {
                    ?>
                    <textarea class="form-control" id="intro_content" name="intro_content" rows="5"></textarea>
                    <?php
                }
                ?>

                <?php /* <div name="reference-description" class="col-xs-12 col-sm-12 col-md-8 app-area-container">
                  <textarea id="txtEditor" name="intro_content" ><?php echo stripslashes($arrProductContent['0']['Content']['content_intro_text']); ?></textarea>
                  </div> */ ?>
            </div>

            <!--<div class="form-group">
                    <label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2">Main Content:</label><!--
                    -->
            <!--<div name="reference-description" class="col-xs-12 col-sm-12 col-md-8 app-area-container">
            <textarea id="txtEditorContent" name="main_content" ><?php //echo //stripslashes($arrProductContent['0']['Content']['content']);         ?></textarea> 
        </div>
            
    </div>-->

            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2">Main Content:</label><!--
                -->
                <div class="tinymce-tabs nopadding nomargin" style="float:right;">
                    <!--<a class="html editor2">Text</a>
                    <a class="visual editor2" class="active">Visual</a>
                    <div style="clear: both;"></div>-->
                </div>
                <?php
                if (isset($arrProductContent) && ($arrProductContent['0']['Content']['content'])) {
                    ?>
                    <textarea class="form-control" id="main_content" name="main_content" rows="5"><?php echo stripslashes($arrProductContent['0']['Content']['content']); ?></textarea>
                    <?php
                } else {
                    ?>
                    <textarea class="form-control" id="main_content" name="main_content" rows="5"></textarea>
                    <?php
                }
                ?>

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
</div>
<?php
echo $this->Html->script('content_form');
?>
<style>
.form-group.file-cls {
    margin: -30px 475px 14px 284px;
}
</style>
<script>
    $(document).ready(function(){
        var strType = '<?php echo $arrProductContent[0]['Resources']['product_type'];?>';
        var type = $("#services_type").val();
       if (strType == "Services" || type == "Services")
        {
            $("#servicesName").show();
        } else {
            $("#servicesName").hide();
        } 
    });
        function fnCheckType(type) {
        if (type == "Services")
        {
            $("#servicesName").show();
        } else {
            $("#servicesName").hide();
        }
    }
</script>