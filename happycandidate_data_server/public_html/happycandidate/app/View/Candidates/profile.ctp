<?php
echo $this->Html->script('cascade');
?>
<div class="container-fluid bg-lightest-grey">
    <div class="row">
        <div class="col-md-12 bg-lightest-grey">
            <!--
                                            <ul class="nav nav-pills tab-list">
                                                    <li class="<?php echo $type == '' ? 'active' : '' ?>">
                                                            <a href="#tab-profile" data-toggle="pill" id="js-profile">My Profile</a>
                                                    </li>
                                                    <li class="<?php echo $type == 'cv' ? 'active' : '' ?>">
                                                            <a href="#tab-resume" data-toggle="pill" id="js-resume">CV / Resume</a>
                                                    </li>
                                                    <li class="<?php echo $type == 'cover' ? 'active' : '' ?>">
                                                            <a href="#tab-coverletters" data-toggle="pill" id="js-coverletters">Cover Letters</a>
                                                    </li>
                                                    <li class="<?php echo $type == 'refrence' ? 'active' : '' ?>">
                                                            <a href="#tab-references" data-toggle="pill" id="js-references">References</a>
                                                    </li>
                                                    <li class="<?php echo $type == 'orders' ? 'active' : '' ?>">
                                                            <a href="#tab-orders" data-toggle="pill" id="js-orders">My Orders</a>
                                                    </li>
                                                    <li class="<?php echo $type == 'setting' ? 'active' : '' ?>">
                                                            <a href="#tab-settings" data-toggle="pill" id="js-settings">Settings</a>
                                                    </li>
                                            </ul>-->

            <div  class="tab-content">
                <div class="tab-pane fade <?php echo $type == '' ? 'in active' : '' ?>" id="tab-profile">
                    <h3>Personal Information</h3>
                    <div id="alertMessages"></div>
                    <!--<div class="alert alert-success">
                      <img alt="image description" src="<?php echo Router::url('/', true); ?>/images/icon-alert-success.png">
                      <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
                      All changes are saved.
                    </div>-->

                    <!--PERSONAL INFORMATION PILL DYN-->			
                    <div class="panel-slider" id="personal-info-panel-slider">

                        <!--submenu-->			
                        <div data-parent="#personal-info-panel-slider" id="personal-info" >
                            <div class="col-md-12 form-container edit-profile">
                                <?php
                                echo $this->element('editprofile');
                                ?>
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

<!-- Modal -->
<div id="show_video" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog delete_confirmation">
        <div class="modal-content confirmation-popup">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Title</h3>
            </div>
            <div class="modal-body delete_modal">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam interdum gravida tempus.</p>
                <div class="resource-detail-image-bg"></div>
            </div>
            <div class="modal-footer">
                <button id="theme_confirm_no" class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
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