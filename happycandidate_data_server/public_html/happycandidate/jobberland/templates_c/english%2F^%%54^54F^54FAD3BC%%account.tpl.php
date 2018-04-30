<?php /* Smarty version 2.6.26, created on 2016-01-12 15:34:47
         compiled from account.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'account.tpl', 1, false),array('function', 'html_options', 'account.tpl', 71, false),array('modifier', 'count', 'account.tpl', 77, false),)), $this); ?>
<!--<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'account_overview'), $this);?>
</div>-->

<!--<?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'info1'), $this);?>
-->

<p> 

	<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>
    
<br />
<div data-parent="#personal-info-panel-slider" id="personal-info" class="panel-slider" style="">
<div class="col-md-12 form-container edit-profile">
									<form action="" method="post" name="account_form" enctype="multipart/form-data" >
										
										<div class="form-group candidateimage">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Photo: <span class="form-required">*</span></label>
											<div class="col-xs-12 col-sm-12  col-md-9">
											
										<?php if ($this->_tpl_vars['candidate_picture'] != ""): ?>
										<img style="float:left;" class="thumbnail" src="<?php echo $this->_tpl_vars['baseurl']; ?>
/assets/candidateprofile/<?php echo $this->_tpl_vars['candidate_picture']; ?>
"  width="200px;"/>
										<?php endif; ?>
    
							
							<input id="profilePicture" name="profilePicture" type="file" style="display:none">
<div class="input-append ">
<div id="photoCover"></div>
<a class="btn btn-default" onclick="$('input[id=profilePicture]').click();">Upload Picture</a>
</div>
 <?php echo '
<script type="text/javascript">
$(\'input[id=profilePicture]\').change(function() {
$(\'#photoCover\').html($(this).val());
});
</script>
'; ?>



											</div>
										</div>

										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'firstname'), $this);?>
: <span class="form-required">*</span></label>
											 
											 <input type="text" placeholder="" name="txt_fname"  value="<?php echo $this->_tpl_vars['fname']; ?>
" class="col-xs-12 col-sm-12 col-md-9">
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Surname / Last Name: <span class="form-required">*</span></label>
											 
											 <input type="text" placeholder="" name="txt_sname"  value="<?php echo $this->_tpl_vars['sname']; ?>
" class="col-xs-12 col-sm-12 col-md-9">
										</div>
										
									
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Address Line1: <span class="form-required">*</span></label>
											 <input type="text" placeholder="" name="txt_address"  value="<?php echo $this->_tpl_vars['address']; ?>
" class="col-xs-12 col-sm-12 col-md-9">
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Address Line2: <span class="form-required">*</span></label>
											 <input type="text" placeholder="" name="txt_address"  value="<?php echo $this->_tpl_vars['address2']; ?>
" class="col-xs-12 col-sm-12 col-md-9">
										</div>
											<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Zip / Postal Code: <span class="form-required">*</span></label>
											 <input type="text" placeholder=""onchange="fnGetLocationDetailFromZipFront()" name="txt_post_code"  value="<?php echo $this->_tpl_vars['post_code']; ?>
" class="col-xs-12 col-sm-12 col-md-9">
										</div>
										
											<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'country'), $this);?>
 <span class="form-required">*</span></label>
										  <select name="txt_country" id="txt_country" onchange="javascript: cascadeCountry(this.value,'txtstateprovince');" >
												<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['country'],'selected' => $_SESSION['loc']['country']), $this);?>

										</select>
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">State / Province / Region: <span class="form-required">*</span></label>
											 <?php if (count($this->_tpl_vars['lang']['states']) > 0): ?>
                <select class="select" name="txtstateprovince" id="txtstateprovince" onchange="javascript: cascadeState(this.value, this.form.txt_country.value,'txtcounty');" >
                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['states'],'selected' => $_SESSION['loc']['stateprovince']), $this);?>

                </select>
            <?php else: ?>
                <input class="text_field required col-xs-12 col-sm-12 col-md-9" name="txtstateprovince" id="txtstateprovince" type="text" value="<?php echo $_SESSION['loc']['stateprovince']; ?>
" />
           <?php endif; ?> 
										</div>
										
										
											<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Mobile Telephone Number <span class="form-required">*</span></label>
											 <input type="text" placeholder="" name="txt_phone_number" value="<?php echo $this->_tpl_vars['phone_number']; ?>
" class="col-xs-12 col-sm-12 col-md-9">
										</div>
										<input type="hidden" name="txt_email_address" class="" value="<?php echo $this->_tpl_vars['email_address']; ?>
" size="35" disabled="disabled" />
										<div class="form-group">
											<div class="hidden-xs hidden-sm col-md-3"></div>
											<div class="col-xs-12 col-sm-12 col-md-9">
												<button class="btn btn-primary" type="submit" name="account_btn" value="<?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'save_my_profile'), $this);?>
">Save Changes</button>
												
											</div>
										</div>
									</form>
								</div>

</div>
