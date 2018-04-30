<?php /* Smarty version 2.6.26, created on 2015-11-04 15:52:37
         compiled from add_cover_letter.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'add_cover_letter.tpl', 1, false),)), $this); ?>
<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'new_cl'), $this);?>
</div>

<?php if ($this->_tpl_vars['message'] != ""): ?> <br /> <?php echo $this->_tpl_vars['message']; ?>
 <br /> <?php endif; ?>

<form action="" method="post" enctype="multipart/form-data" >
    <div class="cl_upload_container">
     <label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cl_title'), $this);?>
 <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /> </label>
     <br /><input type="text" name="txt_name" size="35" value="<?php echo $_SESSION['cl']['title']; ?>
" />
     <br /><br /><textarea name="txt_letter" cols="70" rows="20"><?php echo $_SESSION['cl']['text']; ?>
</textarea>
      <p><input type="submit" name="bt_cl_add" class="button" value="<?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'save'), $this);?>
"  /></p>
    </div>
</form>