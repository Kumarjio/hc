<?php /* Smarty version 2.6.26, created on 2016-01-11 18:50:44
         compiled from rename_cv_name.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'rename_cv_name.tpl', 4, false),)), $this); ?>


<?php if ($this->_tpl_vars['message'] != ""): ?> <br /><?php echo $this->_tpl_vars['message']; ?>
<br /> <?php endif; ?>
<div class="panel-slider" id="user-settings-panel-slider"><h3><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'rename_cv'), $this);?>
</h3>
<div class="col-md-12 form-container">									<form action="" method="post" enctype="multipart/form-data" >										<div class="form-group">											<label for="old-pass" class="control-label col-xs-12 col-sm-12 col-md-3"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'name_cv'), $this);?>
  <span class="form-required">*</span></label>											<?php echo smarty_function_lang(array('mkey' => 'info','skey' => 'cv_name'), $this);?>
 											<input type="text" required="" placeholder="" value="<?php echo $this->_tpl_vars['name']; ?>
" id="txt_title" name="txt_title" class="col-xs-12 col-sm-12 col-md-9">										</div>										<div class="form-group">											<label for="new-pass" class="control-label col-xs-12 col-sm-12 col-md-3"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'desc_cv'), $this);?>
 <span class="form-required">*</span></label>											<?php echo smarty_function_lang(array('mkey' => 'info','skey' => 'cv_desc'), $this);?>
											<textarea  placeholder=""  name="txt_desc" id="txt_desc" class="col-xs-12 col-sm-12 col-md-9"><?php echo $this->_tpl_vars['notes']; ?>
</textarea>										</div>																			<div class="form-group">											<div class="hidden-xs hidden-sm col-md-3"></div>											<div class="col-xs-12 col-sm-12 col-md-9">												<button class="btn btn-primary" name="bt_save" value=" <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'save'), $this);?>
 "  type="submit">Save Changes</button>											</div>										</div>									</form>								</div></div><!--
<form action="" method="post" enctype="multipart/form-data" >
  <div class="cv_upload_container">
   <p> 
    <label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'name_cv'), $this);?>
 <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></label>
    <br /><?php echo smarty_function_lang(array('mkey' => 'info','skey' => 'cv_name'), $this);?>
 
    <br /><input type="text" name="txt_title" value="<?php echo $this->_tpl_vars['name']; ?>
" />
   </p>
   
   <p> 
    <label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'desc_cv'), $this);?>
</label>
    <br /><?php echo smarty_function_lang(array('mkey' => 'info','skey' => 'cv_desc'), $this);?>

    <br /><textarea name="txt_desc" rows="5" cols="60"><?php echo $this->_tpl_vars['notes']; ?>
</textarea>
   </p>
   
   <p>
        <input type="submit" name="bt_save" class="button" value=" <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'save'), $this);?>
 "  />
   </p> 
  </div>
</form>-->