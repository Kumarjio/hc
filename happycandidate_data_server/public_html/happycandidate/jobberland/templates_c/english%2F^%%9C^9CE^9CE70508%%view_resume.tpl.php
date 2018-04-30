<?php /* Smarty version 2.6.26, created on 2015-12-09 18:09:52
         compiled from view_resume.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'view_resume.tpl', 1, false),)), $this); ?>
<h1 class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'cv_visibility'), $this);?>
</h1>

<div><p><?php echo smarty_function_lang(array('mkey' => 'cv','skey' => 'cv_r_info'), $this);?>
</p></div>

<p>

<input type="button" name="bt_change" value="<?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_change_status'), $this);?>
" onclick="redirect_to('<?php echo $this->_tpl_vars['BASE_URL']; ?>
curriculum_vitae/resume/<?php echo $this->_tpl_vars['id']; ?>
/change/');" />

</p>

<div class="cv_header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'cv_1'), $this);?>
</div>
<div class="cv_contain">
<br />
<?php if ($_SESSION['resume']['status'] == 'private'): ?>
	<?php echo smarty_function_lang(array('mkey' => 'cv','skey' => 'cv_info_1'), $this);?>

<?php else: ?>
	<?php echo smarty_function_lang(array('mkey' => 'cv','skey' => 'cv_info_2'), $this);?>

<?php endif; ?>

<br /><br />
</div>

<br /><br />

<div class="cv_header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'cv_2'), $this);?>
</div>
<div class="cv_contain">

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_1'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['exper']; ?>

<hr />

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_2'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['educ']; ?>

<hr />

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_3'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['salary']; ?>

<hr />

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_4'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['availabe']; ?>

<hr />

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_5'), $this);?>
</label>
<br />
	<?php echo $this->_tpl_vars['str_date']; ?>

<hr />

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_6'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['position']; ?>

<br /><br /> 
</div>

<br /><br />

<div class="cv_header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'cv_3'), $this);?>
</div>
<div class="cv_contain">

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_7'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['rjt']; ?>

<hr />

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_8'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['re']; ?>

<hr />

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_9'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['riw']; ?>

<hr />

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_10'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['careers']; ?>

<br /><br />
</div>

<br /><br />

<div class="cv_header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'cv_4'), $this);?>
</div>
<div class="cv_contain">
<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_11'), $this);?>
</label>

<br /><?php echo $this->_tpl_vars['ljt']; ?>

<br /><?php echo $this->_tpl_vars['ljt2']; ?>

<hr />

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_12'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['li']; ?>

<hr />

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_13'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['job_type']; ?>


<hr />

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_18'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['ljs']; ?>


<br /><br />
</div>

<br /><br />

<div class="cv_header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'cv_5'), $this);?>
</div>
<div class="cv_contain">
<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_14'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['city']; ?>
, <?php echo $this->_tpl_vars['county']; ?>
, <?php echo $this->_tpl_vars['state']; ?>
, <?php echo $this->_tpl_vars['country']; ?>

<hr />

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_15'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['aya']; ?>

<hr />

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_16'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['wtr']; ?>

<hr />

<label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_17'), $this);?>
</label>
<br />
<?php echo $this->_tpl_vars['wtt']; ?>

<br /><br />
</div>

<br /><br />

<div class="cv_header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'cv_6'), $this);?>
</div>
<div class="cv_contain">
	<?php echo $this->_tpl_vars['notes']; ?>

<br /><br />
</div>

<br />

<input type="button" name="bt_change" value="<?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_change_status'), $this);?>
" onclick="redirect_to('<?php echo $this->_tpl_vars['BASE_URL']; ?>
curriculum_vitae/resume/<?php echo $this->_tpl_vars['id']; ?>
/change/');" />

<br /><br />