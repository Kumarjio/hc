<?php /* Smarty version 2.6.26, created on 2016-01-12 16:04:50
         compiled from addcv.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'addcv.tpl', 5, false),)), $this); ?>
<div class="header"></div>

<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<div data-parent="#personal-info-panel-slider" id="personal-info" class="panel-slider" style=""><div class="col-md-12 form-container edit-profile"><h3><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'newcv'), $this);?>
</h3>									<form action="" method="post" name="account_form" enctype="multipart/form-data" >																				<div class="form-group candidateimage">											<label class="control-label col-xs-12 col-sm-12 col-md-3">Resume: <span class="form-required">*</span></label>											<div class="col-xs-12 col-sm-12  col-md-9">																					    														<input id="txt_file_cv" name="txt_file_cv" type="file" style="display:none"><div class="input-append " ><div id="photoCover"></div><a class="btn btn-default" onclick="$('input[id=txt_file_cv]').click();" style="margin-top:9px;">Upload Resume</a><small style="margin-left:10px;"><?php echo smarty_function_lang(array('mkey' => 'max_file_size'), $this);?>
 <?php echo smarty_function_lang(array('mkey' => 'max'), $this);?>
 <?php echo $this->_tpl_vars['ALLOWED_FILETYPES_DOC']; ?>
 <?php echo smarty_function_lang(array('mkey' => 'files_only'), $this);?>
</small></div> <?php echo '<script type="text/javascript">$(\'input[id=txt_file_cv]\').change(function() {$(\'#photoCover\').html($(this).val());});</script>'; ?>
											</div>										</div>																				<div class="form-group">											<label class="control-label col-xs-12 col-sm-12 col-md-3"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'name_cv'), $this);?>
: <span class="form-required">*</span></label>											 <?php echo smarty_function_lang(array('mkey' => 'info','skey' => 'cv_name'), $this);?>
 											 <input type="text" placeholder="" name="txt_title" value="<?php echo $_SESSION['addcv']['name']; ?>
" class="col-xs-12 col-sm-12 col-md-9">										</div>										<div class="form-group">											<label class="control-label col-xs-12 col-sm-12 col-md-3"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'desc_cv'), $this);?>
 <span class="form-required">*</span></label>											    <?php echo smarty_function_lang(array('mkey' => 'info','skey' => 'cv_desc'), $this);?>
											 <textarea  placeholder="" name="txt_desc"   class="col-xs-12 col-sm-12 col-md-9"><?php echo $_SESSION['addcv']['desc']; ?>
</textarea>										</div>																													<div class="form-group">											<div class="hidden-xs hidden-sm col-md-3"></div>											<div class="col-xs-12 col-sm-12 col-md-9">												<button class="btn btn-primary" type="submit" name="bt_cv_add" class="button" value="<?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'saveandcontinue'), $this);?>
">Save Changes</button>																							</div>										</div>									</form>								</div></div>
<!--
<form action="" method="post" enctype="multipart/form-data" >
  <div class="cv_upload_container">
    <label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'select_cv'), $this);?>
 <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></label>
    <br /><input type="file" name="txt_file_cv" id="" />
    <br /><i><?php echo smarty_function_lang(array('mkey' => 'max_file_size'), $this);?>
 <?php echo smarty_function_lang(array('mkey' => 'max'), $this);?>
 
        <?php echo $this->_tpl_vars['ALLOWED_FILETYPES_DOC']; ?>
 <?php echo smarty_function_lang(array('mkey' => 'files_only'), $this);?>
</i>
    
   <p> 
    <label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'name_cv'), $this);?>
 <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></label>
    <br /><?php echo smarty_function_lang(array('mkey' => 'info','skey' => 'cv_name'), $this);?>
 
    <br /><input type="text" name="txt_title" value="<?php echo $_SESSION['addcv']['name']; ?>
" />
   </p>
   <p> 
    <label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'desc_cv'), $this);?>
</label>
    <br /><?php echo smarty_function_lang(array('mkey' => 'info','skey' => 'cv_desc'), $this);?>

    <br /><textarea name="txt_desc" rows="5" cols="60"><?php echo $_SESSION['addcv']['desc']; ?>
</textarea>
   </p>
   <p>
        <input type="submit" name="bt_cv_add" class="button" value="<?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'saveandcontinue'), $this);?>
"  />
   </p> 
  </div>
</form>
-->