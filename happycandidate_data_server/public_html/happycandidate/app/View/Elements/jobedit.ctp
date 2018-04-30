		<div class="col-md-12 ">
									<form id="contentform" name="contentform"  method="post" role="form">
							<div class="col-md-12">
							<div class="header">Contact Information</div>
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4" for="phone1">Contact Name: </label><!--
												-->
												<input name="txt_contact_name" type="text" class="form-control col-xs-12 col-sm-12 col-md-8" id="txt_contact_name" size="35" value="" />
											
											</div>
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4">Contact Telephone No: </label><!--
												-->
												 <input name="txt_telephone"  type="text" class="form-control col-xs-12 col-sm-12 col-md-8" id="txt_telephone" size="15" maxlength="13" value="" />
											</div>
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4">Email Address: </label><!--
												-->
											
												 <input name="txt_email"  type="text" class="form-control col-xs-12 col-sm-12 col-md-8" id="txt_email" size="15" maxlength="13" value="" />
												 <br /><i>Email will not be shown, it is used to send Application </i>
											</div>
											
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4">Site Link: </label><!--
												-->
												
												http://<input name="txt_site_link" type="text" class="form-control col-xs-12 col-sm-12 col-md-8" id="txt_site_link" size="50" value="" />
											
											</div>
											
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4">Company Name </label><!--
												-->
												  <input name="txt_cname" type="text" class="form-control col-xs-12 col-sm-12 col-md-8" size="80" id="txt_cname" value="{$smarty.session.add_job.compname}" />

	 <br /><i>(Your Staffing or Recruiting Firm Name)</i>
											</div>
										
											<div class="header">Job Information</div>
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4">Reference code: </label><!--
												-->
												 <input name="txt_ref_code" type="text" class="form-control col-xs-12 col-sm-12 col-md-8" id="txt_ref_code" size="40" value="" />
												
											</div>
											
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4">Job Title: </label><!--
												-->
												<input name="txt_job_title" type="text" class="form-control col-xs-12 col-sm-12 col-md-8" id="txt_job_title" size="40" maxlength="100" value="" />
												  <br />(e.g. "Web Developer", "Graphic Artist")
											</div>
											
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4">Job Description: </label><!--
												-->
												<textarea name="txt_job_desc" id="txt_job_desc" cols="5" rows="20" class="form-control col-xs-12 col-sm-12 col-md-8" ></textarea>
												<br />1000 characters allowed. 
											</div>
											
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4">Job Description: </label><!--
												-->
												<textarea name="txt_job_req" id="txt_job_req" cols="5" rows="20" class="form-control col-xs-12 col-sm-12 col-md-8" ></textarea>
												<br />1000 characters allowed. 
											</div>
											
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4">Number of Positions Available: </label><!--
												-->
												<input name="txt_position" type="text" class="form-control col-xs-12 col-sm-12 col-md-8" id="txt_position"  size="40" value="" />
											</div>
											
										<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4"> Target Start Date: </label><!--
												-->
												<input name="txt_start_date" type="text" class="form-control col-xs-12 col-sm-12 col-md-8" id="txt_start_date" maxlength="50" size="40" value="" />
												<br /><i> e.g. ASAP,  </i>
											</div>	
											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-12 col-md-4"> Job Type: </label><!--
												-->
												<input name="txt_start_date" type="text" class="form-control col-xs-12 col-sm-12 col-md-8" id="txt_start_date" maxlength="50" size="40" value="" />
												<br /><i> e.g. ASAP,  </i>
											</div>	
											
											
										</div>
										<div class="col-md-12 submit-container">
											<div class="col-md-6">
											<div class="form-group">
												<div class="hidden-xs hidden-sm col-md-4"></div>
												<div class="col-xs-12 col-sm-12 col-md-8">
													<button type="button" class="btn btn-primary" onclick="return fnSubmitContent();" type="button">Save Changes</button>
													<button class="btn btn-warning" type="button">Cancel</button>
												</div></div>
											</div>
										</div>
									</form>
							</div>
					