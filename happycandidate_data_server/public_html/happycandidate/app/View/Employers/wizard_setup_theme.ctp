<?php
$rooturl = "http://www.rothrsolutions.com";
echo $this->element('themeapply_confirmation');
?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Career Portal Wizard setup</h1>	
                <?php if($arrEmployerPortalDetail[0]['Portal']['career_portal_name'] !='') { ?>
                <p id="selectedPortal">Your Portal Name : - <?php echo stripslashes($arrEmployerPortalDetail[0]['Portal']['career_portal_name']); ?></p>	
                <?php } ?>
            </div>
            <?php //echo '<pre>';print_r($arrEmployerDetail);// exit();?>
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
                        <a href="<?php echo Router::url(array('controller' => 'employers', 'action' => 'wizard_setup_theme'), true); ?>" class="active-icon">
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
                                </div>
                                <div class="col-lg-2">
                                        <div class="dashboard-theme-icon">
                                        <a href="#">
                                                                        <i class="glyphicon glyphicon-cog"></i>
                                            <span>Career Portal Options</span>
                                        </a>
                                    </div>
                                </div>-->
                <div class="col-lg-2">
                    <div class="dashboard-theme-icon">
                        <?php if ($arrThemeDetail["Wiztheme"]["theme_name"] != '' && $arrThemeDetail["Wiztheme"]["theme_color"] != '') { ?>
                            <a href="<?php echo Router::url(array('controller' => 'employers', 'action' => 'wizard_setup_publish'), true); ?>">
                                <i class="glyphicon glyphicon-file"></i>
                                <span>Review</span>
                            </a>
                        <?php } else { ?>
                            <a href="#">
                                <i class="glyphicon glyphicon-file"></i>
                                <span>Review</span>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <p style="margin-top:20px">Congratulations!  You have selected your Career Portal URL.  Next, you will select your Career Portal theme.  Your theme is the look and feel of your Career Portal site.  To select a theme, click on the Select Now tab directly below the theme picture.</p>
            <p><b>Note:</b> You may change your theme at any time</p>
            <p>Once you select a theme, you will be able to customize your Career Portal by uploading your Company Logo and editing the Contact Us; About Us and Welcome pages.</p>
            <div class="row theme-content-section">
                <div class="col-lg-10">
                    <div class="theme-content-wrapper theme-design-wrap">
                        <h1 class="theme-design-title">Theme Design #1 </h1>	
                        <?php
                        $portalId = $intPortalDetails[0]['Portal']['career_portal_id'];
                        $themeName = $arrThemeDetail["Wiztheme"]["theme_name"];
                        $themeColor = $arrThemeDetail["Wiztheme"]["theme_color"];
//									echo "<pre>"; print_r($portalId);
                        ?>
                        <div class="col-lg-3 <?php
                        if ($themeName == "THEME-DESIGN-1" && $themeColor == "BLUE") {
                            echo "selected-theme";
                        }
                        ?>" id="selectedtheme1"> 
                            <div class="theme-box">
                                <div class="theme-title">Blue Theme</div>
                                <div class="theme-img"><img src="<?php echo Router:: url('/', true); ?>images/theme-img/theme-img-blue.jpg"></div>
                                                                    <!--<a target="_blank" href="<?php //echo Router::url(array('controller'=>'employers','action'=>'theme_selection','?' => array('theme_name'=>'THEME-DESIGN-1','theme_color'=>'BLUE','portal_id'=>$portalId)));    ?>">Selected</a>-->
                                <a id="selectedtheme1@<?php echo $rooturl; ?><?php echo Router::url(array('controller' => 'employers', 'action' => 'theme_selection', '?' => array('theme_name' => 'THEME-DESIGN-1', 'theme_color' => 'BLUE', 'portal_id' => $portalId))); ?>" href="javascript:void(0);" onClick="themeapplyconf(this)"><?php
                                    if ($themeName == "THEME-DESIGN-1" && $themeColor == "BLUE") {
                                        echo "Selected";
                                    } else {
                                        echo "Select Now";
                                    }
                                    ?></a>
                            </div>
                        </div>

                        <div class="col-lg-3 <?php
                        if ($themeName == "THEME-DESIGN-1" && $themeColor == "RED") {
                            echo "selected-theme";
                        }
                        ?>" id="selectedtheme2"> 
                            <div class="theme-box">
                                <div class="theme-title">Red Theme</div>
                                <div class="theme-img"><img src="<?php echo Router:: url('/', true); ?>images/theme-img/theme-img-red.jpg"></div>
                                                                    <!--<a  target="_blank" href="<?php //echo Router::url(array('controller'=>'employers','action'=>'theme_selection','?' => array('theme_name'=>'THEME-DESIGN-1','theme_color'=>'RED','portal_id'=>$portalId)));     ?>">Selected</a>-->
                                <a id="selectedtheme2@<?php echo $rooturl; ?><?php echo Router::url(array('controller' => 'employers', 'action' => 'theme_selection', '?' => array('theme_name' => 'THEME-DESIGN-1', 'theme_color' => 'RED', 'portal_id' => $portalId))); ?>" href="javascript:void(0);" onClick="themeapplyconf(this)"><?php
                                    if ($themeName == "THEME-DESIGN-1" && $themeColor == "RED") {
                                        echo "Selected";
                                    } else {
                                        echo "Select Now";
                                    }
                                    ?></a>
                            </div>
                        </div>

                        <div class="col-lg-3 <?php
                        if ($themeName == "THEME-DESIGN-1" && $themeColor == "PURPLE") {
                            echo "selected-theme";
                        }
                        ?>" id="selectedtheme3"> 
                            <div class="theme-box">
                                <div class="theme-title">Purple Theme</div>
                                <div class="theme-img"><img src="<?php echo Router:: url('/', true); ?>images/theme-img/theme-img-purpel.jpg"></div>
                               <!--<a target="_blank" href="<?php //echo Router::url(array('controller'=>'employers','action'=>'theme_selection','?' => array('theme_name'=>'THEME-DESIGN-1','theme_color'=>'PURPLE','portal_id'=>$portalId)));    ?>" >Selected</a>-->
                                <a id="selectedtheme3@<?php echo $rooturl; ?><?php echo Router::url(array('controller' => 'employers', 'action' => 'theme_selection', '?' => array('theme_name' => 'THEME-DESIGN-1', 'theme_color' => 'PURPLE', 'portal_id' => $portalId))); ?>" href="javascript:void(0);" onClick="themeapplyconf(this)"><?php
                                    if ($themeName == "THEME-DESIGN-1" && $themeColor == "PURPLE") {
                                        echo "Selected";
                                    } else {
                                        echo "Select Now";
                                    }
                                    ?></a>
                            </div>
                        </div>

                        <div class="col-lg-3 <?php
                        if ($themeName == "THEME-DESIGN-1" && $themeColor == "YELLOW") {
                            echo "selected-theme";
                        }
                        ?>" id="selectedtheme4"> 
                            <div class="theme-box">
                                <div class="theme-title">Yellow Theme</div>
                                <div class="theme-img"><img src="<?php echo Router:: url('/', true); ?>images/theme-img/theme-img-yellow.jpg"></div>
                               <!--<a target="_blank" href="<?php //echo Router::url(array('controller'=>'employers','action'=>'theme_selection','?' => array('theme_name'=>'THEME-DESIGN-1','theme_color'=>'YELLOW','portal_id'=>$portalId)));     ?>">Selected</a>-->
                                <a id="selectedtheme4@<?php echo $rooturl; ?><?php echo Router::url(array('controller' => 'employers', 'action' => 'theme_selection', '?' => array('theme_name' => 'THEME-DESIGN-1', 'theme_color' => 'YELLOW', 'portal_id' => $portalId))); ?>" href="javascript:void(0);" onClick="themeapplyconf(this)"><?php
                                    if ($themeName == "THEME-DESIGN-1" && $themeColor == "YELLOW") {
                                        echo "Selected";
                                    } else {
                                        echo "Select Now";
                                    }
                                    ?></a>
                            </div>
                        </div>

                        <div class="clear"></div>    
                    </div>
                </div>
            </div>




            <div class="row theme-content-section">
                <div class="col-lg-10">
                    <div class="theme-content-wrapper theme-design-wrap">

                        <h1 class="theme-design-title">Theme Design #2</h1>	

                        <div class="col-lg-3 <?php
                        if ($themeName == "THEME-DESIGN-2" && $themeColor == "BLUE") {
                            echo "selected-theme";
                        }
                        ?>" id="selectedtheme11"> 
                            <div class="theme-box">
                                <div class="theme-title">Blue Theme</div>
                                <div class="theme-img"><img src="<?php echo Router:: url('/', true); ?>images/theme-img/theme-img-blue-1.jpg"></div>
                                <!--<a target="_blank" href="<?php //echo Router::url(array('controller'=>'employers','action'=>'theme_selection','?' => array('theme_name'=>'THEME-DESIGN-2','theme_color'=>'BLUE','portal_id'=>$portalId)));    ?>">Select Now</a>-->
                                <a id="selectedtheme11@<?php echo $rooturl; ?><?php echo Router::url(array('controller' => 'employers', 'action' => 'theme_selection', '?' => array('theme_name' => 'THEME-DESIGN-2', 'theme_color' => 'BLUE', 'portal_id' => $portalId))); ?>" href="javascript:void(0);" onClick="themeapplyconf(this)"><?php
                                    if ($themeName == "THEME-DESIGN-2" && $themeColor == "BLUE") {
                                        echo "Selected";
                                    } else {
                                        echo "Select Now";
                                    }
                                    ?></a>
                            </div>
                        </div>

                        <div class="col-lg-3 <?php
                        if ($themeName == "THEME-DESIGN-2" && $themeColor == "RED") {
                            echo "selected-theme";
                        }
                        ?>" id="selectedtheme12"> 
                            <div class="theme-box">
                                <div class="theme-title">Red Theme</div>
                                <div class="theme-img"><img src="<?php echo Router:: url('/', true); ?>images/theme-img/theme-img-red-1.jpg"></div>
                                <!--<a target="_blank" href="<?php //echo Router::url(array('controller'=>'employers','action'=>'theme_selection','?' => array('theme_name'=>'THEME-DESIGN-2','theme_color'=>'RED','portal_id'=>$portalId)));     ?>">Selected</a>-->
                                <a id="selectedtheme12@<?php echo $rooturl; ?><?php echo Router::url(array('controller' => 'employers', 'action' => 'theme_selection', '?' => array('theme_name' => 'THEME-DESIGN-2', 'theme_color' => 'RED', 'portal_id' => $portalId))); ?>" href="javascript:void(0);" onClick="themeapplyconf(this)"><?php
                                    if ($themeName == "THEME-DESIGN-2" && $themeColor == "RED") {
                                        echo "Selected";
                                    } else {
                                        echo "Select Now";
                                    }
                                    ?></a>
                            </div>
                        </div>

                        <div class="col-lg-3 <?php
                        if ($themeName == "THEME-DESIGN-2" && $themeColor == "GREEN") {
                            echo "selected-theme";
                        }
                        ?>" id="selectedtheme13"> 
                            <div class="theme-box">
                                <div class="theme-title">Green Theme</div>
                                <div class="theme-img"><img src="<?php echo Router:: url('/', true); ?>images/theme-img/theme-img-green.jpg"></div>
                                <!--<a target="_blank" href="<?php //echo Router::url(array('controller'=>'employers','action'=>'theme_selection','?' => array('theme_name'=>'THEME-DESIGN-2','theme_color'=>'GREEN','portal_id'=>$portalId)));     ?>">Select Now</a>-->
                                <a id="selectedtheme13@<?php echo $rooturl; ?><?php echo Router::url(array('controller' => 'employers', 'action' => 'theme_selection', '?' => array('theme_name' => 'THEME-DESIGN-2', 'theme_color' => 'GREEN', 'portal_id' => $portalId))); ?>" href="javascript:void(0);" onClick="themeapplyconf(this)"><?php
                                    if ($themeName == "THEME-DESIGN-2" && $themeColor == "GREEN") {
                                        echo "Selected";
                                    } else {
                                        echo "Select Now";
                                    }
                                    ?></a>
                            </div>
                        </div>

                        <div class="col-lg-3 <?php
                        if ($themeName == "THEME-DESIGN-2" && $themeColor == "YELLOW") {
                            echo "selected-theme";
                        }
                        ?>" id="selectedtheme14"> 
                            <div class="theme-box">
                                <div class="theme-title">Purple Theme</div>
                                <div class="theme-img"><img src="<?php echo Router:: url('/', true); ?>images/theme-img/theme-img-yellow-1.jpg"></div>
                                <!--<a target="_blank" href="<?php //echo Router::url(array('controller'=>'employers','action'=>'theme_selection','?' => array('theme_name'=>'THEME-DESIGN-2','theme_color'=>'YELLOW','portal_id'=>$portalId)));    ?>">Select Now</a>-->
                                <a id="selectedtheme14@<?php echo $rooturl; ?><?php echo Router::url(array('controller' => 'employers', 'action' => 'theme_selection', '?' => array('theme_name' => 'THEME-DESIGN-2', 'theme_color' => 'YELLOW', 'portal_id' => $portalId))); ?>" href="javascript:void(0);" onClick="themeapplyconf(this)"><?php
                                    if ($themeName == "THEME-DESIGN-2" && $themeColor == "YELLOW") {
                                        echo "Selected";
                                    } else {
                                        echo "Select Now";
                                    }
                                    ?></a>
                            </div>
                        </div>

                        <div class="clear"></div>    
                    </div>
                </div>
            </div>



            <div class="row theme-content-section">
                <div class="col-lg-10">
                    <div class="theme-content-wrapper theme-design-wrap">

                        <h1 class="theme-design-title">Theme Design #3</h1>	

                        <div class="col-lg-3 <?php
                        if ($themeName == "THEME-DESIGN-3" && $themeColor == "BLUE") {
                            echo "selected-theme";
                        }
                        ?>" id="selectedtheme21"> 
                            <div class="theme-box">
                                <div class="theme-title">Blue Theme</div>
                                <div class="theme-img"><img src="<?php echo Router:: url('/', true); ?>images/theme-img/theme-img-blue-2.jpg"></div>
                                <!--<a target="_blank" href="<?php //echo Router::url(array('controller'=>'employers','action'=>'theme_selection','?' => array('theme_name'=>'THEME-DESIGN-3','theme_color'=>'BLUE','portal_id'=>$portalId)));   ?>">Select Now</a>-->
                                <a id="selectedtheme21@<?php echo $rooturl; ?><?php echo Router::url(array('controller' => 'employers', 'action' => 'theme_selection', '?' => array('theme_name' => 'THEME-DESIGN-3', 'theme_color' => 'BLUE', 'portal_id' => $portalId))); ?>" href="javascript:void(0);" onClick="themeapplyconf(this)"><?php
                                    if ($themeName == "THEME-DESIGN-3" && $themeColor == "BLUE") {
                                        echo "Selected";
                                    } else {
                                        echo "Select Now";
                                    }
                                    ?></a>
                            </div>
                        </div>

                        <div class="col-lg-3 <?php
                        if ($themeName == "THEME-DESIGN-3" && $themeColor == "RED") {
                            echo "selected-theme";
                        }
                        ?>" id="selectedtheme22"> 
                            <div class="theme-box">
                                <div class="theme-title">Red Theme</div>
                                <div class="theme-img"><img src="<?php echo Router:: url('/', true); ?>images/theme-img/theme-img-red-2.jpg"></div>
                                <!--<a target="_blank" href="<?php //echo Router::url(array('controller'=>'employers','action'=>'theme_selection','?' => array('theme_name'=>'THEME-DESIGN-3','theme_color'=>'RED','portal_id'=>$portalId)));    ?>">Selected</a>-->
                                <a id="selectedtheme22@<?php echo $rooturl; ?><?php echo Router::url(array('controller' => 'employers', 'action' => 'theme_selection', '?' => array('theme_name' => 'THEME-DESIGN-3', 'theme_color' => 'RED', 'portal_id' => $portalId))); ?>" href="javascript:void(0);" onClick="themeapplyconf(this)"><?php
                                    if ($themeName == "THEME-DESIGN-3" && $themeColor == "RED") {
                                        echo "Selected";
                                    } else {
                                        echo "Select Now";
                                    }
                                    ?></a>
                            </div>
                        </div>

                        <div class="col-lg-3 <?php
                        if ($themeName == "THEME-DESIGN-3" && $themeColor == "GREEN") {
                            echo "selected-theme";
                        }
                        ?>" id="selectedtheme23"> 
                            <div class="theme-box">
                                <div class="theme-title">Green Theme</div>
                                <div class="theme-img"><img src="<?php echo Router:: url('/', true); ?>images/theme-img/theme-img-green-2.jpg"></div>
                                <!--<a target="_blank" href="<?php //echo Router::url(array('controller'=>'employers','action'=>'theme_selection','?' => array('theme_name'=>'THEME-DESIGN-3','theme_color'=>'GREEN','portal_id'=>$portalId)));    ?>">Select Now</a>-->
                                <a id="selectedtheme23@<?php echo $rooturl; ?><?php echo Router::url(array('controller' => 'employers', 'action' => 'theme_selection', '?' => array('theme_name' => 'THEME-DESIGN-3', 'theme_color' => 'GREEN', 'portal_id' => $portalId))); ?>" href="javascript:void(0);" onClick="themeapplyconf(this)"><?php
                                    if ($themeName == "THEME-DESIGN-3" && $themeColor == "GREEN") {
                                        echo "Selected";
                                    } else {
                                        echo "Select Now";
                                    }
                                    ?></a>
                            </div>
                        </div>


                        <div class="clear"></div>    
                    </div>
                </div>
            </div>		

        </div>
    </div>
</div>

<?php /* <div class="index page-header row">
  <h1>Create Services</h1>
  <!--<p class="lead">Here are the list of added contents</p>-->
  </div>
  <div>&nbsp;</div>
  <div id="product_notification" class="index row"><?php echo $strMessage;?></div>
  <div class="index row nopadding" id="tabs">
  <input type="hidden" name="content_added" id="content_added" value="" />
  <ul>
  <li><a href="#contentpart">Services Panel</a></li>
  <!--<li id="cat" style="display:none;"><a href="#contentcatpart">Content Categories</a></li>-->
  </ul>
  <div id="contentpart">
  <p class="tabloader" style="display:none;"></p>
  <div id="content_html">
  <?php
  //echo "Hello";
  echo $this->element("services");
  ?>
  </div>
  </div>
  <!--<div id="contentcatpart">
  <p class="tabloader" style="display:none;"></p>
  <div id="content_cat_form"></div>
  </div>-->
  </div> */ ?>
<?php
echo $this->element('assign_media_modal');
?>
<style>
    .page-content-wrapper h1{
        font-size: 24px;
        margin-bottom: 12px !important;
        margin-top: 30px;
    }
    
</style>
<script type="text/javascript">

    function themeapplyconf(ele) {
        //alert("Hi this is modal");
        var strElementId = $(ele).attr('id');
        $('#pass_for').val(strElementId);
        $("#theme_confirm").modal('show');
    }

    $(document).ready(function () {

        $("#txtEditor").Editor();
        $("#txtEditorContent").Editor();

        /*$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
         $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );*/

        $("#tabs").tabs({
            beforeActivate: function (event, ui) {
                var strNewTab = ui.newTab.attr('id');
                if (strNewTab == "cat")
                {
                    $('.tabloader').show();
                    $('#content_jsp_cat_form').html('');
                    fnGetContentCategoryForm('0');
                    /*if($('#contentcategoryform').length>0)
                     {
                     $('.tabloader').hide();
                     }
                     else
                     {
                     fnGetContentCategoryForm();
                     }*/
                }

                if (strNewTab == "jbsearchcat")
                {
                    $('.tabloader').show();
                    $('#content_cat_form').html('');
                    fnGetContentCategoryForm("1");
                    /*if($('#contentcategoryform').length>0)
                     {
                     $('.tabloader').hide();
                     }
                     else
                     {
                     fnGetContentCategoryForm();
                     }*/
                }

                if (strNewTab == "contentparent")
                {
                    if ($('#contentparentform').length > 0)
                    {
                        $('.tabloader').hide();
                    } else
                    {
                        fnGetParentContentForm();
                    }
                }
            }
        });
    });
    
    $("#theme_confirm_yes").click(function () {
//        setTimeout(function(){
            window.location = '<?php echo Router::url(array('controller' => 'employers', 'action' => 'wizard_setup_publish'), true); ?>';
//        }, 2000);
    });
//    
</script>

