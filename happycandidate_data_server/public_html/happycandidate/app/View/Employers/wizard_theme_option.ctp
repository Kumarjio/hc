<div class="page-content-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
	            <h1>Career Portal Wizard setup</h1>														
	        </div>
			<?php //echo '<pre>';print_r($arrEmployerWizardDetail);// exit();?>
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
                        <a href="<?php echo Router::url(array('controller'=>'employers','action'=>'wizard_setup_theme'),true); ?>" >
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
                       	<a href="<?php echo Router::url(array('controller'=>'employers','action'=>'wizard_theme_option'),true); ?>" class="active-icon">
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
			<div class="row search-content-section" id="search_area" >  
                <div class="col-lg-10" >
					<div class='search-content-output'>
					<h4>Create Your Portal</h4>
						<form action="" method="post" name="portalName" enctype="multipart/form-data" id="portalName">
							<div class="form-group">
								<label class="control-label col-xs-12 col-sm-12 col-md-3">Portal Name: <span class="form-required">*</span></label>
													 
								 <input type="text" placeholder="" name="portal_name"  value="<?php echo $intPortalDetails[0]['Portal']['career_portal_name'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
							</div>
							
							<?php //echo '<pre>'; print_r($intPortalDetails);
								if(count($intPortalDetails) == 0){ ?>
							<div class="form-group">
								<label class="control-label col-xs-12 col-sm-12 col-md-3">Portal Logo: <span class="form-required">*</span></label>
								<input type="file" class="col-xs-12 col-sm-12 col-md-9 validate[required]" name="portal_logo">
							</div>
							<div class="form-group">
								<div class="hidden-xs hidden-sm col-md-3"></div>
								<div class="col-xs-12 col-sm-12 col-md-9">
									<button class="btn btn-primary" type="submit" name="account_btn">Save Changes</button>
								</div>
							</div>
							<?php } else { ?>
							<div class="form-group">
							<label class="control-label col-xs-12 col-sm-12 col-md-3">Portal Logo: <span class="form-required">*</span></label>
							<div class="col-xs-12 col-sm-12 col-md-9">
								<img  style="height:80;width:165;"src="<?php echo Router::url('/', true);?>/userdata/portal/<?php echo $intPortalDetails[0]['Portal']['career_portal_thumb_logo'];?>" alt="<?php echo $intPortalDetails[0]['Portal']['career_portal_name'];?>" />
							<div>
							</div>
							<?php } ?>
						</form>	
					</div>
                </div>
            </div>
                    
                <p id="response_msg"></p>    
                    <div class="row search-content-section" id="selected">  
                    	
                    </div>		
			
		</div>
	</div>
</div>



