<div class="header"></div>

{if $message != "" } {$message} {/if}

<div data-parent="#personal-info-panel-slider" id="personal-info" class="panel-slider" style=""><div class="col-md-12 form-container edit-profile"><h3>{lang mkey='header' skey='newcv'}</h3>									<form action="" method="post" name="account_form" enctype="multipart/form-data" >																				<div class="form-group candidateimage">											<label class="control-label col-xs-12 col-sm-12 col-md-3">Resume: <span class="form-required">*</span></label>											<div class="col-xs-12 col-sm-12  col-md-9">																					    														<input id="txt_file_cv" name="txt_file_cv" type="file" style="display:none"><div class="input-append " ><div id="photoCover"></div><a class="btn btn-default" onclick="$('input[id=txt_file_cv]').click();" style="margin-top:9px;">Upload Resume</a><small style="margin-left:10px;">{lang mkey='max_file_size'} {lang mkey='max'} {$ALLOWED_FILETYPES_DOC} {lang mkey='files_only'}</small></div> {literal}<script type="text/javascript">$('input[id=txt_file_cv]').change(function() {$('#photoCover').html($(this).val());});</script>{/literal}											</div>										</div>																				<div class="form-group">											<label class="control-label col-xs-12 col-sm-12 col-md-3">{lang mkey='label' skey='name_cv' }: <span class="form-required">*</span></label>											 {lang mkey='info' skey='cv_name'} 											 <input type="text" placeholder="" name="txt_title" value="{$smarty.session.addcv.name}" class="col-xs-12 col-sm-12 col-md-9">										</div>										<div class="form-group">											<label class="control-label col-xs-12 col-sm-12 col-md-3">{lang mkey='label' skey='desc_cv'} <span class="form-required">*</span></label>											    {lang mkey='info' skey='cv_desc'}											 <textarea  placeholder="" name="txt_desc"   class="col-xs-12 col-sm-12 col-md-9">{$smarty.session.addcv.desc}</textarea>										</div>																													<div class="form-group">											<div class="hidden-xs hidden-sm col-md-3"></div>											<div class="col-xs-12 col-sm-12 col-md-9">												<button class="btn btn-primary" type="submit" name="bt_cv_add" class="button" value="{lang mkey='button' skey='saveandcontinue'}">Save Changes</button>																							</div>										</div>									</form>								</div></div>
<!--
<form action="" method="post" enctype="multipart/form-data" >
  <div class="cv_upload_container">
    <label class="label">{lang mkey='label' skey='select_cv'} <img src="{$skin_images_path}required.gif" alt="" /></label>
    <br /><input type="file" name="txt_file_cv" id="" />
    <br /><i>{lang mkey='max_file_size'} {lang mkey='max'} 
        {$ALLOWED_FILETYPES_DOC} {lang mkey='files_only'}</i>
    
   <p> 
    <label class="label">{lang mkey='label' skey='name_cv' } <img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />{lang mkey='info' skey='cv_name'} 
    <br /><input type="text" name="txt_title" value="{$smarty.session.addcv.name}" />
   </p>
   <p> 
    <label class="label">{lang mkey='label' skey='desc_cv'}</label>
    <br />{lang mkey='info' skey='cv_desc'}
    <br /><textarea name="txt_desc" rows="5" cols="60">{$smarty.session.addcv.desc}</textarea>
   </p>
   <p>
        <input type="submit" name="bt_cv_add" class="button" value="{lang mkey='button' skey='saveandcontinue'}"  />
   </p> 
  </div>
</form>
-->