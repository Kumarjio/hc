	<div class="tab-header">
							<h3>Settings</h3>
							<div id="alertpassMessages"></div>
						</div>

						<!--USER SETTINGS - PASS PILL DYN-->			
						<div class="panel-slider" id="user-settings-panel-slider">
							<a data-parent="#user-settings-panel-slider" data-toggle="collapse" class="panel-slider-item" href="#user-settings">
								<div class="panel-slider-item-header">
									<h3>Change Password</h3>
									<span class="icon-indicator"></span>
								</div>
							</a>
							<!--submenu-->			
							<div data-parent="#user-settings-panel-slider" id="user-settings" class="collapse">
								<div class="col-md-12 form-container">
								<form name="frmchangepass" id="frmchangepass" method="post">
										<div class="form-group">
											<label for="old-pass" class="control-label col-xs-12 col-sm-12 col-md-3">Old Password: <span class="form-required">*</span></label>
											<input type="password" required="" placeholder="" value="" id="txt_old_pass" name="txt_old_pass" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										<div class="form-group">
											<label for="new-pass" class="control-label col-xs-12 col-sm-12 col-md-3">New Password: <span class="form-required">*</span></label>
											<input type="password" required="" placeholder="" value="" id="txt_new_pass" name="txt_new_pass" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										<div class="form-group">
											<label for="repeat-new-pass" class="control-label col-xs-12 col-sm-12 col-md-3">Repeat New Password: <span class="form-required">*</span></label>
											<input type="password" required="" placeholder="" value="" id="txt_new_pass_retry" name="txt_new_pass_retry" class="col-xs-12 col-sm-12 col-md-9 validate[required,equals[txt_new_pass]]">
										</div>
										<div class="form-group">
											<div class="hidden-xs hidden-sm col-md-3"></div>
											<div class="col-xs-12 col-sm-12 col-md-9">
												<button class="btn btn-primary" type="button" onClick="return fnupdatepassword('<?php echo $intPortalId?>');">Save Changes</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!--END OF USER SETTINGS - PASS PILL DYN-->		
<form role="form" name="CandidateSettings" id="CandidateSettings">
						<!--USER SETTINGS - NOTIFICATIONS PILL DYN-->			
						<div class="panel-slider" id="user-settings-notifications-panel-slider">
							<a data-parent="#user-settings-notifications-panel-slider" data-toggle="collapse" class="panel-slider-item" href="#user-settings-notifications">
								<div class="panel-slider-item-header">
									<h3>Emails Notifications</h3>
									<span class="icon-indicator" style="background: transparent url(&quot;images/job-search-tracker-overview-sort-sprite.png&quot;) no-repeat scroll left top;"></span>
								</div>
							</a>
							<!--submenu-->			
							<div data-parent="#user-settings-notifications-panel-slider" id="user-settings-notifications" class="collapse in" style="">
								<div class="col-md-12 form-container">
									
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Notifications:</label>
											<div class="radio col-xs-12 col-sm-12 col-md-9">
												<label><input type="radio" name="job_notifications" <?php if($arrCandidatesSettings[0]['CandidatesSettings']['is_job_notification']>0){echo "checked='checked'";}?>  class="jnotificaton" value="1"><span>Send me job listings that match my search criteria. <!--<a class="link-primary" href="#">Configure Search Criteria</a>--></span></label><br/>
												<label><input type="radio" name="job_notifications" <?php if($arrCandidatesSettings[0]['CandidatesSettings']['is_job_notification']==0){echo "checked='checked'";}?> class="jnotificaton" value="0"><span>Don't send me notifications.</span></label>
											</div>
										</div>

										<div class="form-group">
											<div class="hidden-xs hidden-sm col-md-3"></div>
											<div class="col-xs-12 col-sm-12 col-md-9">
												<button class="btn btn-primary" type="button" onClick="return fnSetCandidateNotification('<?php echo $intPortalId;?>');">Save Changes</button>
											</div>
										</div>

								</div>
							</div>
						</div>
						<!--END OF USER SETTINGS - NOTIFICATIONS PILL DYN-->	

						<!--USER SETTINGS - ACCOUNT PILL DYN-->			
						<div class="panel-slider" id="user-settings-account-panel-slider">
							<a data-parent="#user-settings-account-panel-slider" data-toggle="collapse" class="panel-slider-item collapsed" href="#user-settings-account">
								<div class="panel-slider-item-header">
									<h3>Cancel Account</h3>
									<span class="icon-indicator" style="background: transparent url(&quot;images/job-search-tracker-overview-sort-sprite.png&quot;) no-repeat scroll left top -50px;"></span>
								</div>
							</a>
							<!--submenu-->			
							<div data-parent="#user-settings-account-panel-slider" id="user-settings-account" class="collapse" style="height: 0px;">
								<div class="col-md-12 form-container">
									
										
										<div class="form-group">
											<label for="cancel-account" class="control-label col-xs-12 col-sm-12 col-md-3">I want to cancel my account:</label>
											<div class="account-settings col-xs-12 col-sm-12 col-md-9">
												
												<input type="checkbox" value="1"   class="rnotificaton" name="cancel_account" id="cancel_account" <?php echo $arrCandidatesSettings[0]['CandidatesSettings']['is_cancel_account']>0?"checked='checked'":"";?>>

												<span>If you decide to cancel your account, please understand that any Information you have added to your account including work done in the Resume Builder and Assessments will be lost. If you would prefer to keep your free account open for future job search activities, but wish to no longer receive any emails from thisSystem, please click to uncheck Latest Job Listings, Notifications, and System Emails.</span>
											</div>
										</div>
										<div class="form-group">
											<div class="hidden-xs hidden-sm col-md-3"></div>
											<div class="col-xs-12 col-sm-12 col-md-9">
												<button class="btn btn-default" type="button" id="cancel-account-inactive" onClick="return fnSetCandidateNotification('<?php echo $intPortalId;?>');">Cancel My Account</button>
												<button class="btn btn-warning hidden" type="button" id="cancel-account-active">Cancel My Account</button>
											</div>
										</div>
									
								</div>
							</div>
						</div>
						</form>
						<!--END OF USER ACCOUNT - NOTIFICATIONS PILL DYN-->	
