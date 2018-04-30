<?php 
$portalPreviewLink =  Router::url(array('controller' => 'portalpreview', 'action' => 'index', strtolower($arrEmployerPortalName['Portal']['career_portal_name'])), true); ?>

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div id="product_notification"></div>
        <div class="row">
            <div class="col-lg-12">
                <h1>Career Portal Wizard setup</h1>	
                <?php if($arrEmployerPortalDetail[0]['Portal']['career_portal_name'] !='') { ?>
                <p id="selectedPortal">Your Portal Name : -<?php echo stripslashes($arrEmployerPortalDetail[0]['Portal']['career_portal_name']); ?></p>	
                <?php } ?>
            </div>
            <div class="row"> 
                <div class="col-lg-2">
                    <div class="dashboard-theme-icon">
                       	<a href="<?php echo Router::url(array('controller' => 'employers', 'action' => 'wizard_setup'), true); ?>" >
                            <i class="glyphicon glyphicon-globe"></i>
                            <span>Select Domain</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="dashboard-theme-icon">
                        <a href="<?php echo Router::url(array('controller' => 'employers', 'action' => 'wizard_setup_theme'), true); ?>" >
                            <i class="glyphicon glyphicon-th"></i>
                            <span>Select Theme</span>
                        </a>
                    </div>
                </div>
<!--                <div class="col-lg-2">
                    <div class="dashboard-theme-icon">
                        <a href="#" >
                            <i class="glyphicon glyphicon-list"></i>
                            <span>Career Portal Content</span>
                        </a>
                    </div>
                </div>-->
<!--                <div class="col-lg-2">
                    <div class="dashboard-theme-icon">
                       	<a href="<?php echo Router::url(array('controller' => 'employers', 'action' => 'wizard_theme_option'), true); ?>" class="active-icon">
                            <i class="glyphicon glyphicon-cog"></i>
                            <span>Career Portal Options</span>
                        </a>
                    </div>
                </div>-->
                <div class="col-lg-2">
                    <div class="dashboard-theme-icon">
                       	<a href="<?php echo Router::url(array('controller' => 'employers', 'action' => 'wizard_setup_publish'), true); ?>" class="active-icon">
                            <i class="glyphicon glyphicon-file"></i>
                            <span>Review</span>
                        </a>
                    </div>
                </div>
            </div>
            <p></p>
            <p>Welcome to the Career Portal Wizard Setup.  Your first step is to select a domain name for your Career Portal.  The domain name is the web address of your custom Career Portal website. This is where you will send job seekers.  We will generate a list of available domain names using the company name you provided at registration.  Click the Search Domain tab. If you do not see a domain you prefer, you have the opportunity to search for other domain names using the Keyword Search Field.</p>
                       
            <div class="row search-content-section" id="search_area" >  
                <div class="col-lg-10" >
                    <div class='search-content-output'>
                        <h4>Publish Wizard Setup</h4>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-9 button-css">
                                <div id="buttons_append"></div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <div id="publish_confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog delete_confirmation">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Confirmation</h3>
                    </div>
                    <div class="modal-body delete_modal">
                        <input type="hidden" name="status_value" id="status_value"/>
                        <span id="set_message"> Are you sure, you want to apply this theme? </sapn>
                       
                    </div>
                    <div class="modal-footer">
                        <button id="publish_confirm_no" class="btn" data-dismiss="modal" aria-hidden="true">No</button>
                        <button class="btn btn-primary" id="publish_confirm_yes">Yes</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        
        <!-- Modal -->
        <div id="publish_error" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog delete_confirmation">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Publish Domain Error</h3>
                    </div>
                    <div class="modal-body delete_modal">
                        <input type="hidden" name="status_value" id="status_value" value=""/>
                        <span id="set_error_message"> Are you sure, you want to apply this theme? </sapn>
                       
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div>
</div>
<script>
function wizardConf(type){
    var diff = '<?php echo round($hourdiff);?>';
    var days = '<?php echo round($days);?>';
    var hours = '<?php echo round($hours);?>';

    if(type == 'publish'){
        if(diff <= 48){
            $("#publish_error").modal('show');
            var message = 'Unable to publish domain,because your domain will be activated in '+ days +' days '+ hours +' hours';
            $("#set_error_message").html(message);
        }else{
            $("#publish_confirm").modal('show');
            $("#status_value").val('1');
            var message = 'Are you sure, you want to publish this wizard setup?';
            $("#set_message").html(message);
        }
    }else if(type == 'draft'){
        $("#publish_confirm").modal('show');
        $("#status_value").val('0');
        var message = 'Are you sure, you want to save to draft this wizard setup?';
        $("#set_message").html(message);
    }else if(type == 'unpublish'){
        $("#publish_confirm").modal('show');
        $("#status_value").val('0');
        var message = 'Are you sure, you want to unpublish this wizard setup?';
        $("#set_message").html(message);
    }
}
    $('#publish_confirm_yes').click(function () {
        var status = $("#status_value").val();
        $.ajax({
        url: "<?php echo Router::url(array('controller' => 'employers', 'action' => 'update_wizard_publish_status'), true); ?>",
        type: "POST",
        data: 'status='+status,	
        dataType: 'json',
        success: function(res) 
            {
             $("#publish_confirm").modal('hide');
            var str = "";
            var publish = "publish";
            var draft = "draft";
            var unpublish = "unpublish";
            var url = '<?php echo $portalPreviewLink;?>';
               if(res.type == 'unpublish'){
                    str += "<button class='btn btn-success apply_button' type='button' name='publish_btn' id='publish_btn' onclick=wizardConf('"+publish+"')>Publish Now</button><button class='btn btn-primary apply_button' type='button' name='draft_btn' id='draft_btn' onclick=wizardConf('"+draft+"')>Save To Draft</button>"; 
                    $("#buttons_append").html(str);
               } else{
                    str +="<button class='btn btn-danger apply_button' type='button' name='unpublish_btn' id='unpublish_btn' onclick=wizardConf('"+unpublish+"')>Unpublish</button>&nbsp;&nbsp;<a style='height:40px;padding:10px' class='btn btn-primary apply_button' href='"+url+"' target='_blank'>Preview Portal</a>";
                    $("#buttons_append").html(str);
               }
            }
        });
    });
    $('#publish_confirm_no').click(function () {
        $("#publish_confirm").modal('hide');
    });
    
    $(document).ready(function(){
        var type = '<?php echo $arrEmployerPortalName['Portal']['career_portal_published'];?>';
        var publish = '<?php echo "publish";?>';
        var unpublish = '<?php echo "unpublish";?>';
        var draft = '<?php echo "draft";?>';
        var url = '<?php echo $portalPreviewLink;?>';
        var str = '';
        if(type == '0'){
             str += "<button class='btn btn-success apply_button' type='button' name='publish_btn' id='publish_btn' onclick=wizardConf('"+publish+"')>Publish Now</button><button class='btn btn-primary apply_button' type='button' name='draft_btn' id='draft_btn' onclick=wizardConf('"+draft+"')>Save To Draft</button>"; 
            $("#buttons_append").html(str);
        } else{
             str +="<button class='btn btn-danger apply_button' type='button' name='unpublish_btn' id='unpublish_btn' onclick=wizardConf('"+unpublish+"')>Unpublish</button>&nbsp;&nbsp;<a style='height:40px;padding:10px' class='btn btn-primary apply_button' href='"+url+"' target='_blank'>Preview Portal</a>";
            $("#buttons_append").html(str);
        } 
        
        
    });
</script>

<style>
button.apply_button {
  border-radius: 5px;
  display: inline-block;
  font-family: OpenSansRegular,Georgia,serif;
  font-size: 15px;
  font-weight: normal;
  height: 40px;
  margin-left: 16px !important;
  outline: medium none;
  padding-left: 15px;
  padding-right: 15px;
}
.page-content-wrapper h1{
  font-size: 24px;
  margin-bottom: 12px !important;
  margin-top: 30px;
}
</style>

