<div class="col-md-12 form-container edit-profile">
<h3>Creating a CV / Resume Never Been Easier</h3>	
<div id="alertcvMessages"></div>	
							<form id="renamecv_form" action="" method="post" name="renamecv_form" enctype="multipart/form-data" >
									
							<div class="form-group">	
							<label class="control-label col-xs-12 col-sm-12 col-md-3">Name your CV / Resume: <span class="form-required">*</span></label>		
							
							<input type="hidden" placeholder="" name="cvid" id="cvid" value="<?php echo $intCvDetail['CandidateCvDetail']['id'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">	
							<input type="text" placeholder="" name="txt_title" value="<?php echo $intCvDetail['CandidateCvDetail']['cv_title'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">										</div>			
							<div class="form-group">	
							<label class="control-label col-xs-12 col-sm-12 col-md-3 ">Add a description (optional) <span class="form-required">*</span></label>	
							
							<textarea  placeholder="" name="txt_desc"   class="col-xs-12 col-sm-12 col-md-9 validate[required]"><?php echo $intCvDetail['CandidateCvDetail']['cv_description'];?></textarea>						
							</div>	
							<div class="form-group">		
							<div class="hidden-xs hidden-sm col-md-3"></div>	
							<div class="col-xs-12 col-sm-12 col-md-9">		
							<button class="btn btn-primary" type="button" onclick="return fnRenameCV('<?php echo $intPortalId?>');" name="bt_cv_add" class="button" value="submit">Save Changes</button>		
							</div>										</div>									</form>							
	</div>
	
	