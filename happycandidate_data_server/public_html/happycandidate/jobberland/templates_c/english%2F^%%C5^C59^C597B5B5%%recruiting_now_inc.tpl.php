<?php /* Smarty version 2.6.26, created on 2017-06-27 16:01:20
         compiled from recruiting_now_inc.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'recruiting_now_inc.tpl', 3, false),)), $this); ?>
<?php if (is_array ( $this->_tpl_vars['recruiting_nows'] ) && $this->_tpl_vars['recruiting_nows'] != ""): ?>
<div class="left_item">
<h1 class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'recruiting_now'), $this);?>
</h1>
<table width="100%" class="tb_border">
    <?php $_from = $this->_tpl_vars['recruiting_nows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
    <tr>
        <td>
            <a href='<?php echo $this->_tpl_vars['BASE_URL']; ?>
company/<?php echo $this->_tpl_vars['i']['var_name']; ?>
/'>
              <img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
images/company_logo/<?php echo $this->_tpl_vars['i']['logo']; ?>
" alt="<?php echo $this->_tpl_vars['i']['name']; ?>
" class="companylogo" title="<?php echo $this->_tpl_vars['i']['name']; ?>
 (<?php echo $this->_tpl_vars['i']['total']; ?>
)" />
            </a>
        </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
</div>
<?php endif; ?>