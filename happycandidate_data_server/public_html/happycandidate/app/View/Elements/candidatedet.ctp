
<form action="<?php echo $strSeekerProfileUrl?>" method="post" name="account_form" enctype="multipart/form-data" id="account_form">
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Firstname:</label>
											 
											 <label><?php echo $arrCandidate[0]['Candidate']['candidate_first_name']; ?></label>
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Surname / Last Name:</label>
											 
											 <label><?php echo $arrCandidate[0]['Candidate']['candidate_last_name']; ?></label>
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Email:</label>
											 
											 <label><?php echo $arrCandidate[0]['Candidate']['candidate_email']; ?></label>
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Phone Number:</label>
											 
											 <label><?php echo $arrCandidate[0]['Candidate']['cand_phone_number']; ?></label>
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Address: </label>
											 <label><?php echo $arrCandidate[0]['Candidate']['candidate_address']; ?></label>
										</div>
										<?php
											$arrCvs = $arrCandidate[0]['Candidate']['cvs'];
											//print("<pre>");
											//print_r($arrCvs);
											
											if(is_array($arrCvs) && (count($arrCvs)>0))
											{
												?>
													<div class="form-group">
														<label class="control-label col-xs-12 col-sm-12 col-md-3">Resume | CV: </label>
														<div class="col-md-9">
															<?php
																foreach($arrCvs as $arrCv)
																{
																	$intPortalId = $strCurrentUser['portal_id'];
																	$seekerid = $arrCandidate[0]['Candidate']['candidate_id'];
																	$cv_id = $arrCv['Candidate_Cv']['candidatecv_id'];
																	?>
																		<div class="col-md-12"><a onclick="submitToResumeViewList('<?php echo $intPortalId?>','<?php echo $seekerid?>','<?php echo $cv_id;?>');" href="javascript:void(0);"><?php echo $arrCv['Candidate_Cv']['resume_title']; ?></a></div>
																	<?php
																}
															?>
														</div>
													</div>
												<?php
											}
										?>
									</form>							