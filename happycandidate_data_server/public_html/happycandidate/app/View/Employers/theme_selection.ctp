<div class="page-content-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
	            <h1>Career Portal Wizard setup</h1>														
	        </div>
			<?php echo '<pre>';print_r($arrThemeDetail);// exit();?>
			<div class="row"> 
				<div class="col-lg-2">
                   	<div class="dashboard-theme-icon">
                       	<a href="<?php echo Router::url(array('controller'=>'employers','action'=>'wizard_setup'),true); ?>" >
							<i class="glyphicon glyphicon-globe"></i>
                           	<span>Select Domain</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
                   	<div class="dashboard-theme-icon">
                        <a href="<?php echo Router::url(array('controller'=>'employers','action'=>'wizard_setup_theme'),true); ?>" class="active-icon">
                        	<i class="glyphicon glyphicon-th"></i>
                           	<span>Select Theme</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
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
                </div>
                <div class="col-lg-2">
                   	<div class="dashboard-theme-icon">
                       	<a href="#">
                      		<i class="glyphicon glyphicon-file"></i>
                            <span>Review</span>
                        </a>
                    </div>
                </div>
            </div>
			<div class="row theme-content-section">
                    	<div class="col-lg-10">
                        	<div class="theme-content-wrapper theme-design-wrap">
                            
                            	<h1 class="theme-design-title">Theme Design #1</h1>	
                                
                                <div class="col-lg-3"> 
                                <div class="theme-box">
                                	<div class="theme-title">Blue Theme</div>
                                    <div target="_blank" class="theme-img"><img src="<?php echo Router:: url('/',true); ?>images/theme-img/theme-img-blue.jpg"></div>
                                    <a href="#">Select Now</a>
                                </div>
                                </div>
                                
                               <div class="col-lg-3 selected-theme"> 
                               <div class="theme-box">
                                	<div class="theme-title">Red Theme</div>
                                    <div class="theme-img"><img src="<?php echo Router:: url('/',true); ?>images/theme-img/theme-img-red.jpg"></div>
                                    <a target="_blank" href="<?php echo Router::url(array('controller'=>'employers','action'=>'theme_selection','?' => array('theme_name'=>'THEME-DESIGN-1','theme_color'=>'RED'))); ?>">Selected</a>
                                </div>
                                </div>
                                
                                <div class="col-lg-3"> 
                                <div class="theme-box">
                                	<div class="theme-title">Purpel Theme</div>
                                    <div class="theme-img"><img src="<?php echo Router:: url('/',true); ?>images/theme-img/theme-img-purpel.jpg"></div>
                                    <a href="#">Select Now</a>
                                </div>
                                </div>
                                
                                <div class="col-lg-3"> 
                                <div class="theme-box">
                                	<div class="theme-title">Yellow Theme</div>
                                    <div class="theme-img"><img src="<?php echo Router:: url('/',true); ?>images/theme-img/theme-img-yellow.jpg"></div>
                                    <a href="#">Select Now</a>
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
                                
                                <div class="col-lg-3"> 
                                <div class="theme-box">
                                	<div class="theme-title">Blue Theme</div>
                                    <div class="theme-img"><img src="<?php echo Router:: url('/',true); ?>images/theme-img/theme-img-blue-1.jpg"></div>
                                    <a href="#">Select Now</a>
                                </div>
                                </div>
                                
                               <div class="col-lg-3"> 
                               <div class="theme-box">
                                	<div class="theme-title">Red Theme</div>
                                    <div class="theme-img"><img src="<?php echo Router:: url('/',true); ?>images/theme-img/theme-img-red-1.jpg"></div>
                                    <a href="#">Selected</a>
                                </div>
                                </div>
                                
                                <div class="col-lg-3"> 
                                <div class="theme-box">
                                	<div class="theme-title">Green Theme</div>
                                    <div class="theme-img"><img src="<?php echo Router:: url('/',true); ?>images/theme-img/theme-img-green.jpg"></div>
                                    <a href="#">Select Now</a>
                                </div>
                                </div>
                                
                                <div class="col-lg-3"> 
                                <div class="theme-box">
                                	<div class="theme-title">Yellow Theme</div>
                                    <div class="theme-img"><img src="<?php echo Router:: url('/',true); ?>images/theme-img/theme-img-yellow-1.jpg"></div>
                                    <a href="#">Select Now</a>
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
                                
                                <div class="col-lg-3"> 
                                <div class="theme-box">
                                	<div class="theme-title">Blue Theme</div>
                                    <div class="theme-img"><img src="<?php echo Router:: url('/',true); ?>images/theme-img/theme-img-blue-2.jpg"></div>
                                    <a href="#">Select Now</a>
                                </div>
                                </div>
                                
                               <div class="col-lg-3"> 
                               <div class="theme-box">
                                	<div class="theme-title">Red Theme</div>
                                    <div class="theme-img"><img src="<?php echo Router:: url('/',true); ?>images/theme-img/theme-img-red-2.jpg"></div>
                                    <a href="#">Selected</a>
                                </div>
                                </div>
                                
                                <div class="col-lg-3"> 
                                <div class="theme-box">
                                	<div class="theme-title">Green Theme</div>
                                    <div class="theme-img"><img src="<?php echo Router:: url('/',true); ?>images/theme-img/theme-img-green-2.jpg"></div>
                                    <a href="#">Select Now</a>
                                </div>
                                </div>
                                
                                
                            <div class="clear"></div>    
                            </div>
                        </div>
                    </div>		
			
		</div>
	</div>
</div>

<?php /*<div class="index page-header row">
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
</div>*/?>
<?php
	echo $this->element('assign_media_modal');
?>
<script type="text/javascript">
	$(document).ready(function () {
	
    		$("#txtEditor").Editor(); 
			$("#txtEditorContent").Editor();
			
		/*$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );*/
		
		$( "#tabs" ).tabs({
			beforeActivate: function( event, ui ) {
				var strNewTab = ui.newTab.attr('id');
				if(strNewTab == "cat")
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
				
				if(strNewTab == "jbsearchcat")
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
				
				if(strNewTab == "contentparent")
				{
					if($('#contentparentform').length>0)
					{
						$('.tabloader').hide();
					}
					else
					{
						fnGetParentContentForm();
					}
				}
			}
		});
	});
</script>

