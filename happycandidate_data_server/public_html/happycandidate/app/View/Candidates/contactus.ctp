<?php
echo $this->Html->script('cascade');
?>
<div class="container-fluid bg-lightest-grey">
    <div class="row">
        <div class="col-md-12 bg-lightest-grey">
            <div  class="tab-content">
                <div class="tab-pane fade <?php echo $type == '' ? 'in active' : '' ?>" id="tab-profile">
                    <h3>Contact Us</h3>
                    <?php if($strMssg !=''){?>
                    <div id="alertMessages">
                        <div class="alert <?php echo $strMssgClass;?>">
                            <img alt="image description" src="<?php echo Router::url('/', true); ?>/images/icon-alert-success.png">
                            <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
                            <?php echo $strMssg; ?>
                        </div>
                    </div>
                    <?php } ?>
                    <!--PERSONAL INFORMATION PILL DYN-->			
                    <div class="panel-slider" id="personal-info-panel-slider">
                        <!--submenu-->			
                        <div data-parent="#personal-info-panel-slider" id="registrationContentDiv" >
                            <div class="col-md-12 form-container edit-profile">
                                <form id="UserIndexForm" method="post">
                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-12 col-md-3">Name: <span class="form-required">*</span></label>
                                        <input type="text" placeholder="Name" name="name" id="name" value="<?php echo $arrLoggedInUserDetail['username']; ?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-12 col-md-3">Email: <span class="form-required">*</span></label>
                                        <input type="text" placeholder="Email" name="email" id="email"  value="<?php echo $arrLoggedInUserDetail['email']; ?>" class="col-xs-12 col-sm-12 col-md-9 validate[custom[email],required]">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-12 col-md-3">Subject: <span class="form-required">*</span></label>

                                        <input type="text" name="subject" id="subject" placeholder="Subject" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-12 col-md-3">Comment: </label>
                                        <textarea name="message" id="message" style="width:22%;height: 135px;" placeholder="Comment" class="builder-textarea col-xs-12 col-sm-12 col-md-9 validate[required]"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <div class="hidden-xs hidden-sm col-md-3"></div>
                                        <div class="col-xs-12 col-sm-12 col-md-9">
                                            <input class="btn btn-primary" type="submit" name="submit" id="submit" onclick="return fnCheckEmployer();" Value="Submit"/> &nbsp; <input style="width:auto;" type="reset" name="reset" id="reset" Value="Reset"/>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <!--END OF PERSONAL INFORMATION PILL DYN-->		
                </div>
                <div class="tab-pane fade <?php echo $type == 'cv' ? 'in active' : '' ?>" id="tab-resume">
                </div>

                <div class="tab-pane fade <?php echo $type == 'cover' ? 'in active' : '' ?>" id="tab-coverletters">
                </div>

                <div class="tab-pane fade <?php echo $type == 'refrence' ? 'in active' : '' ?>" id="tab-references">
                </div>

                <div class="tab-pane fade <?php echo $type == 'orders' ? 'in active' : '' ?>" id="tab-orders">

                </div>

                <div class="tab-pane fade <?php echo $type == 'setting' ? 'in active' : '' ?>" id="tab-settings">

                </div>
                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	function fnCheckEmployer()
	{
		var isValidated = $('#UserIndexForm').validationEngine('validate');
		if(isValidated == false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

    $(document).ready(function () {
        var type = '<?php echo $type ?>';
        switch (type) {
            case 'cv':
                fnGetResume();
                break;
            case 'cover':
                fnGetCoverLetter();
                break;
            case 'refrence':
                fnGetRefrences();
                break;
            case 'orders':
                fnGetOrders();
                break;
            case 'setting':
                fnGetSettings();
                break;
        }

        $("a[data-toggle='pill']").click(function () {

            var strNewTab = $(this).attr('id');

            if (strNewTab == "js-resume")
            {
                fnGetResume();
            }

            if (strNewTab == "js-coverletters")
            {
                fnGetCoverLetter();
            }

            if (strNewTab == "js-references")
            {
                fnGetRefrences();
            }

            if (strNewTab == "js-orders")
            {
                fnGetOrders();
            }

            if (strNewTab == "js-settings")
            {
                fnGetSettings();
            }

        });

        var isshow = localStorage.getItem('isshow');
        if (isshow == null) {
            localStorage.setItem('isshow', 1);
            // Show popup here
            $('#show_video').modal('show');
        }
    });

    function fnGetResume()
    {
        var strContentId = "<?php echo $intPortalId; ?>";
        $.ajax({
            type: "GET",
            url: strBaseUrl + "candidates/getresumehtml/" + strContentId,
            dataType: 'json',
            data: "",
            cache: false,
            success: function (data)
            {
                if (data.status == "success")
                {
                    //alert(data.content)
                    $('#tab-resume').html(data.content);
                } else
                {

                }
            }
        });
    }

    function fnGetCoverLetter()
    {
        var strContentId = "<?php echo $intPortalId; ?>";
        $.ajax({
            type: "GET",
            url: strBaseUrl + "candidates/getCoverhtml/" + strContentId,
            dataType: 'json',
            data: "",
            cache: false,
            success: function (data)
            {
                if (data.status == "success")
                {
                    //alert(data.content)
                    $('#tab-coverletters').html(data.content);
                } else
                {

                }
            }
        });
    }

    function fnGetRefrences()
    {
        var strContentId = "<?php echo $intPortalId; ?>";
        $.ajax({
            type: "GET",
            url: strBaseUrl + "references/getRefrenceshtml/" + strContentId,
            dataType: 'json',
            data: "",
            cache: false,
            success: function (data)
            {
                if (data.status == "success")
                {

                    $('#tab-references').html(data.html);
                } else
                {

                }
            }
        });
    }

    function fnGetOrders()
    {
        var strContentId = "<?php echo $intPortalId; ?>";
        $('.cms-bgloader-mask').show();//show loader mask
        $('.cms-bgloader').show(); //show loading image
        $.ajax({
            type: "GET",
            url: strBaseUrl + "myorders/getOrdersHtml/" + strContentId,
            dataType: 'json',
            data: "",
            cache: false,
            success: function (data)
            {
                if (data.status == "success")
                {

                    $('#tab-orders').html(data.html);

                } else
                {

                }
                $('.cms-bgloader-mask').hide();//show loader mask
                $('.cms-bgloader').hide(); //show loading image
            }
        });
    }

    function fnGetSettings()
    {
        var strContentId = "<?php echo $intPortalId; ?>";
        $.ajax({
            type: "GET",
            url: strBaseUrl + "settings/getSettinghtml/" + strContentId,
            dataType: 'json',
            data: "",
            cache: false,
            success: function (data)
            {
                if (data.status == "success")
                {

                    $('#tab-settings').html(data.html);
                } else
                {

                }
            }
        });
    }
</script>
<style>
    .examples{
    margin-bottom:250px !important;
}
</style>