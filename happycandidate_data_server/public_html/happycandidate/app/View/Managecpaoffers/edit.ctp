<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="page-header">
                <h2>Edit CPA Offer</h2>
            </div>
            <!--message display here-->
            <div id="product_notification"></div> 
            <!--message display here-->
            <div style="padding-top: 20px;" class="tab-content">
                <div class="tab-pane fade in active" id="tab-vendor-panel">
                    <div class="page-content-wrapper">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-container">
                                        <form id="offersform" name="offersform" action="" method="post" role="form">
                                            
                                            <div class="form-group">
                                                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Offer Id : </label>
                                                    <input id="pf_offer_id" name="pf_offer_id" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter offer Id here" value="<?php echo stripslashes($arrOfferDetails['pf_offer_id'])?>"> 
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Offer Name : </label>
                                                <input id="offer_name" name="offer_name" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter offer name here" value="<?php echo stripslashes($arrOfferDetails['offer_name'])?>"> 
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Offer Url : </label>
                                                    <input id="offer_url" name="offer_url" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter offer url here" value="<?php echo stripslashes($arrOfferDetails['offer_url'])?>"> 
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">HC Revenue Share(%): </label>
                                                    <input id="hc_cost" name="hc_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter HC share here" value="<?php echo stripslashes($arrOfferDetails['hc_cost'])?>"> 
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Portal Owner Revenue Share(%): </label>
                                                    <input id="portal_cost" name="portal_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter portal owner share here" value="<?php echo stripslashes($arrOfferDetails['portal_cost'])?>"> 
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="email">Offer Description : </label>
                                                <textarea id="intro_content" name="intro_content" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter offer description here"><?php echo stripslashes($arrOfferDetails['offer_description'])?></textarea> 
                                                <input name="offer_description" id="offer_description" class="content_media_button" type="hidden">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2">Offer Image : </label>
                                                <input name="offer_image" id="offer_image" class="content_media_button" type="file">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-xs-12 col-sm-12 col-md-4" for="address2">&nbsp;</label>
                                                <img src="<?php echo Router::url('/', true); ?>offer-images/<?php echo $arrOfferDetails['offer_image'];?>" height="100px" width="100px">
                                            </div>

                                            <div class="form-group">
                                                <div class="hidden-xs hidden-sm col-md-4"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-8 page-content-wrapper-buttons">
                                                    <input name="offer_id" id="offer_image" class="content_media_button" type="hidden" value="<?php echo $offer_id;?>">
                                                    <button  class="btn btn-primary" name="edit_offer" id="edit_offer" type="button">Save Changes</button>
                                                    <button type="button" class="btn btn-default" onclick="window.history.back();">Cancel</button>
                                                </div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo $this->Html->script('content_form');
?>
<style>
    .content_media_button{
        border: none;
    }
</style>
<script type="text/javascript">
    
    $('#edit_offer').click(function () {
        var strIntroContent =  tinyMCE.get('intro_content').getContent();
        $("#offer_description").val(strIntroContent);
        var isValidated = $('#offersform').validationEngine('validate');
       
        if (isValidated == false)
        {
            return false;
        } else
        {
            
            var pageurl = "<?php echo Router::url('/', true) . "managecpaoffers/editAction"; ?>";
            var pagetype = "POST";
            var pageoptions = {
                beforeSubmit: function (formData, jqForm, options) {
                    $('.cms-bgloader-mask').show();//show loader mask
                    $('.cms-bgloader').show(); //show loading image
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
            $('#offersform').ajaxSubmit(pageoptions);
            return false;
        }
    });
</script>

