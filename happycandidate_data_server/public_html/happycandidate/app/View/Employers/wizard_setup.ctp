<div class="page-content-wrapper">
    <div class="container-fluid">
        <div id="product_notification"></div>
        <div class="row">
            <div class="col-lg-12">
                <h1>Career Portal Wizard</h1>
                <p id="selectedPortal"></p>
            </div>

            <div class="row"> 
                <div class="col-lg-2">
                    <div class="dashboard-theme-icon">
                       	<a href="<?php echo Router::url(array('controller' => 'employers', 'action' => 'wizard_setup'), true); ?>" class="active-icon">
                            <i class="glyphicon glyphicon-globe"></i>
                            <span>Select Domain</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="dashboard-theme-icon">
                        <?php if ($arrEmployerPortalDetail[0]['Portal']['career_portal_name'] != '') { ?>
                        <a id="themeTab" href="<?php echo Router::url(array('controller' => 'employers', 'action' => 'wizard_setup_theme'), true); ?>" >
                                <i class="glyphicon glyphicon-th"></i>
                                <span>Select Theme</span>
                            </a>
                        <?php } else { ?>
                            <a href="javascript:void();" >
                                <i class="glyphicon glyphicon-th"></i>
                                <span>Select Theme</span>
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <!--  <div class="col-lg-2">
                          <div class="dashboard-theme-icon">
                          <a href="#" >
                                  <i class="glyphicon glyphicon-list"></i>
                                  <span>Career Portal Content</span>
                          </a>
                      </div>
                  </div>
                  <div class="col-lg-2">
                          <div class="dashboard-theme-icon">
                          <a href="<?php echo Router::url(array('controller' => 'employers', 'action' => 'wizard_theme_option'), true); ?>">
                                                          <i class="glyphicon glyphicon-cog"></i>
                              <span>Career Portal Options</span>
                          </a>
                      </div>
                  </div>-->
                <div class="col-lg-2">
                    <div class="dashboard-theme-icon">
                        <?php if ($arrEmployerPortalDetail[0]['Portal']['career_portal_name'] != '') { ?>
                            <a href="<?php echo Router::url(array('controller' => 'employers', 'action' => 'wizard_setup_publish'), true); ?>">
                                <i class="glyphicon glyphicon-file"></i>
                                <span>Review</span>
                            </a>
                        <?php } else { ?>
                            <a href="javascript:void();">
                                <i class="glyphicon glyphicon-file"></i>
                                <span>Review</span>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <p></p>
            <p>Welcome to the Career Portal Wizard Setup.  Your first step is to select a domain name for your Career Portal.  The domain name is the web address of your custom Career Portal website. This is where you will send your job seekers. We will generate a list of available domain names using the key words you type into the field below.  Click the Add tab.  Then click on the Search Domain tab. If you do not see a domain you prefer, you have the opportunity to search for other domain names using the keyword search field.</p>

            <div class="row search-content-section" id="set_portal_area">  
                <div class="col-lg-10">
                    <form id="portalForm" name="portalForm" method="post" role="form">
                        <div class="search-content-wrapper">
                            <label style="float:left;margin-bottom:10px">Domain Name :</label><div class="clearfix"></div>
                            <input type="text" class="search-input validate[required]" placeholder="Enter your portal name" name="portalname" id="portalname" value="<?php echo stripslashes($arrEmployerDetail[0]['Employer']['employer_company_name']);?>" style="color: #000;">
                            <button type="button" class="btn btn-primary btn-md-pad col-md-3 search-input-bt" id="add_portal">Add</button> 
                            <div class="clear"></div>    
                        </div>
                    </form>
                </div>
            </div>

            <?php if ($arrEmployerPortalDetail[0]['Portal']['career_portal_name'] != '') { ?>
                <div class="row search-content-section" id="search_area" style="display:none;">  
                    <div class="col-lg-10">
                        <div class="search-content-wrapper"> 
                            <label style="float:left;margin-bottom:10px">Keyword Search :</label><div class="clearfix"></div>
                            <input type="text" class="search-input" placeholder="Find your perfect domain name" id="c_fname"  value="<?php echo isset($arrEmployerPortalDetail[0]['Portal']['career_portal_name']) ? $arrEmployerPortalDetail[0]['Portal']['career_portal_name'] : ''?>" style="color: #000;">
                            <button type="button" class="btn btn-primary btn-md-pad col-md-3 search-input-bt" id="domain_search">Search Domain</button> 
                            <div class="clear"></div>    
                        </div>
                    </div>
                </div>
                <div id="selectedText">
                    <p>When you have decided on a domain name, click on Select Now.</p>
                    <p>IMPORTANT: Once you select a domain name, this cannot be easily changed so please select carefully.  There will be a fee associated with changing your domain name.  After you have completed this, we will ask you to:  Select Theme.</p>	
                </div>
            <?php } ?>
<!--<p id="response_msg"></p>--> 

            <div class="row search-content-section" id="selected">  

            </div>		

        </div>
    </div>
</div>
<style>
    .page-content-wrapper h1{
        font-size: 24px;
        margin-bottom: 12px !important;
        margin-top: 30px;
    }
</style>

<script type="text/javascript">
    $(document).ready(function ()
    {
        <?php if ($arrEmployerPortalDetail[0]['Portal']['career_portal_name'] == '') { ?>
        $('#domain_search').trigger('click');
        <?php } ?>
        var portalName = '<?php echo stripslashes($arrEmployerPortalDetail[0]['Portal']['career_portal_name']); ?>'
        if (portalName != '') {
            $("#set_portal_area").hide();
            var toAppend = "";
            $("#selectedPortal").show();
            toAppend = "Your Portal Name :- " + portalName;
            $("#selectedPortal").html(toAppend);
        } else {
            $("#selectedPortal").hide();
            $("#set_portal_area").show();
        }

        $.ajax({
            type: "GET",
            url: "<?php echo Router::url(array('controller' => 'employers', 'action' => 'purchased_domain'), true); ?>",
            success: function (body)
            {
                if (body == null || body == '')
                {
                    $("#search_area").show();
                } else
                {
                    var test = $.parseJSON(body);
                    var toAppend = "";
                    $("#selected").show();
                    toAppend += "<div class='col-lg-10'><div class='search-content-output'><h4>Your Purchased Domain </h4>";
                    toAppend += "<div class='search-output-cols'><div class='search-output-title' style='width:80%;'>" + test.Employerdomain.domain_name + "</div></div>";
                    toAppend += "<div class='clear'></div></div></div>";
                    $("#selected").html(toAppend);
                }
            }
        });
    });

    $("#domain_search").click(function (event) {
        $('.cms-bgloader-mask').show();//show loader mask
        $('.cms-bgloader').show(); //show loading image
        $("#selectedText").show();
//        $("#selected").show();
        $("#selected").html('');
        var c_fname = $("#c_fname").val();
        $.ajax({
            type: "GET",
            url: "<?php echo Router::url(array('controller' => 'employers', 'action' => 'availabledomain'), true); ?>",
            type: "POST",
            dataType: 'json',
            data: 'domain=' + c_fname,
            success: function (body)
            {
                $('.cms-bgloader-mask').hide();//show loader mask
                $('.cms-bgloader').hide(); //show loading image 
                var i = 1;
                var toAppend = "";
                toAppend += "<div class='col-lg-10'><div class='search-content-output'><h4>Selected Domain </h4>";
                $.each(body, function (key, value) {
                    toAppend += "<div class='search-output-cols'><div class='search-output-title' style='width:80%;'>" + value.domain + "</div>";
                    toAppend += "<div class='search-output-buy-now'><button type='button' name='buynow' onclick='buy_domain(\"" + value.domain + "\")' class='btn btn-primary buy-now'>SELECT NOW</button></div></div>";
                    i++;
                });

                toAppend += "</div></div>";
                $("#selected").append(toAppend);
            }
        });
        //event.preventDefault();
    });

    $("#add_portal").click(function (event) {

        var isValidated = $('#portalForm').validationEngine('validate');
        //var isValidated = true;
        if (isValidated == false)
        {
            return false;
        } else
        {
            $('.cms-bgloader-mask').show(); //show loader mask
            $('.cms-bgloader').show(); //show loading image
            var portalname = $("#portalname").val();
            $.ajax({
                type: "GET",
                url: "<?php echo Router::url(array('controller' => 'employers', 'action' => 'addportal'), true); ?>",
                type: "POST",
                dataType: 'json',
                data: 'portalname=' + portalname,
                success: function (res)
                {
                    if (res.type == 'success')
                    {
                        location.reload();
                        $('.cms-bgloader-mask').hide(); //show loader mask
                        $('.cms-bgloader').hide(); //show loading image
                        $("#product_notification").html(res.message);

                    } else {
                        $("#product_notification").html(res.message);
                        $('.cms-bgloader-mask').hide(); //show loader mask
                        $('.cms-bgloader').hide(); //show loading image
                    }
                }
            });
        }
    });

    function buy_domain(ass) {
        var message = confirm('Are you sure want to purchase domain?');
        if (message == true) {

            $('.cms-bgloader-mask').show();//show loader mask
            $('.cms-bgloader').show(); //show loading image 
            $("#response_msg").html('');
            $.ajax({
                url: "<?php echo Router::url(array('controller' => 'employers', 'action' => 'purchase'), true); ?>",
                type: "POST",
                dataType: 'json',
                data: 'domain=' + ass,
                success: function (body)
                {
                    if (body.orderId == 'undefined' || body.orderId == '')
                    {
                        $('.cms-bgloader-mask').hide();//show loader mask
                        $('.cms-bgloader').hide(); //show loading image 
                        $("#product_notification").html(body.message);
                        setTimeout(function(){
                           window.location = '<?php echo Router::url(array('controller' => 'employers', 'action' => 'wizard_setup_theme'), true); ?>';
                        }, 2000);
                        
//				$("#response_msg").text(body.message);
                    } else
                    {
                        $('.cms-bgloader-mask').hide();//show loader mask
                        $('.cms-bgloader').hide(); //show loading image 
                        location.reload();
//				$("#response_msg").text("You have Purchased '"+ass+"' domain successfully, Order-Id is "+body.orderId);
                        $("#product_notification").html(body.message);
//				$("#response_msg").text(body.message);
                        $("#search_area").hide();
                        $("#selected").hide();
                        $("#domain_search").hide();
                        $("#selectedText").hide();

                    }

                }
            });
        }
    }

//    $(document).ready(function(){
//        var domainName = '<?php echo $arrEmployerDomainDetail['PortalDomain']['career_portal_domain_name']?>';
//        if(domainName == ''){
//            $('.dashboard-theme-icon').addClass('active-icon');
//            window.location = '<?php echo Router::url(array('controller' => 'employers', 'action' => 'wizard_setup'), true); ?>';
//        }else{
//            $('.dashboard-theme-icon').addClass('active-icon');
//            window.location = '<?php echo Router::url(array('controller' => 'employers', 'action' => 'wizard_setup_theme'), true); ?>';
//        }
//    });


</script>
