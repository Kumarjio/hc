

{if $message != "" } <br />{$message}<br /> {/if}
<div class="panel-slider" id="user-settings-panel-slider"><h3>{lang mkey='header' skey='rename_cv'}</h3>
<div class="col-md-12 form-container">									<form action="" method="post" enctype="multipart/form-data" >										<div class="form-group">											<label for="old-pass" class="control-label col-xs-12 col-sm-12 col-md-3">{lang mkey='label' skey='name_cv' }  <span class="form-required">*</span></label>											{lang mkey='info' skey='cv_name'} 											<input type="text" required="" placeholder="" value="{$name}" id="txt_title" name="txt_title" class="col-xs-12 col-sm-12 col-md-9">										</div>										<div class="form-group">											<label for="new-pass" class="control-label col-xs-12 col-sm-12 col-md-3">{lang mkey='label' skey='desc_cv'} <span class="form-required">*</span></label>											{lang mkey='info' skey='cv_desc'}											<textarea  placeholder=""  name="txt_desc" id="txt_desc" class="col-xs-12 col-sm-12 col-md-9">{$notes}</textarea>										</div>																			<div class="form-group">											<div class="hidden-xs hidden-sm col-md-3"></div>											<div class="col-xs-12 col-sm-12 col-md-9">												<button class="btn btn-primary" name="bt_save" value=" {lang mkey='button' skey='save'} "  type="submit">Save Changes</button>											</div>										</div>									</form>								</div></div><!--
<form action="" method="post" enctype="multipart/form-data" >
  <div class="cv_upload_container">
   <p> 
    <label class="label">{lang mkey='label' skey='name_cv' } <img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />{lang mkey='info' skey='cv_name'} 
    <br /><input type="text" name="txt_title" value="{$name}" />
   </p>
   
   <p> 
    <label class="label">{lang mkey='label' skey='desc_cv'}</label>
    <br />{lang mkey='info' skey='cv_desc'}
    <br /><textarea name="txt_desc" rows="5" cols="60">{$notes}</textarea>
   </p>
   
   <p>
        <input type="submit" name="bt_save" class="button" value=" {lang mkey='button' skey='save'} "  />
   </p> 
  </div>
</form>-->