<?php /* Smarty version 2.6.26, created on 2016-01-07 12:24:20
         compiled from cover_letter.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'cover_letter.tpl', 1, false),)), $this); ?>
<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'manage_my_cl'), $this);?>
</div>

<?php if ($this->_tpl_vars['message'] != ""): ?> <br /> <?php echo $this->_tpl_vars['message']; ?>
 <br /><?php endif; ?>

<p>
    <?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'info5'), $this);?>
 <?php echo $this->_tpl_vars['total_max_cl']; ?>
 <?php echo smarty_function_lang(array('mkey' => 'of'), $this);?>
 <?php echo $this->_tpl_vars['MAX_COVER_LETTER']; ?>
 
    <?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'info6'), $this);?>

</p>

<table width="100%" cellpadding="0" cellspacing="0" class="manage_cv" >
    <colgroup>
     <col />
     <col />
     <col />
     <col />
     <col width="100" />
    </colgroup>
    <tr class="highlight_tr">
        <td>&nbsp;<?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'name'), $this);?>
</td>
        <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'created'), $this);?>
</td>
        <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'last_modified'), $this);?>
</td>
        <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'default_cv'), $this);?>
</td>
        <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'actions'), $this);?>
</td>

    </tr>

<?php $_from = $this->_tpl_vars['my_letters']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>

    <tr>
        <td><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
covering_letter/edit/<?php echo $this->_tpl_vars['i']['id']; ?>
/?portid=<?php echo $this->_tpl_vars['port_id']; ?>
"><?php echo $this->_tpl_vars['i']['cl_title']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['i']['created_at']; ?>
</td>
        <td><?php echo $this->_tpl_vars['i']['modified_at']; ?>
</td>
        <td><?php if ($this->_tpl_vars['i']['is_defult'] == 'Y'): ?> <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
tick.gif" alt="" /><?php endif; ?></td>
        <td>
            <div id="menu_nav">
              <ul>
                <li>
                 <a href="#" target="_self"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'actions'), $this);?>
<img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
tab_divider1.gif" alt="" /></a>
                 <ul>
                   <li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
covering_letter/edit/<?php echo $this->_tpl_vars['i']['id']; ?>
/?portid=<?php echo $this->_tpl_vars['port_id']; ?>
" target="_self"><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_edit'), $this);?>
</a></li>
              <!-- <li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
covering_letter/download/<?php echo $this->_tpl_vars['i']['id']; ?>
/?portid=<?php echo $this->_tpl_vars['port_id']; ?>
" target="_self">Download</a></li>
                   <li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
covering_letter/copy/<?php echo $this->_tpl_vars['i']['id']; ?>
/?portid=<?php echo $this->_tpl_vars['port_id']; ?>
" target="_self">Copy</a></li>
              -->
                   <li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
covering_letter/delete/<?php echo $this->_tpl_vars['i']['id']; ?>
/?portid=<?php echo $this->_tpl_vars['port_id']; ?>
" onclick="return delete_cv();"><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_delete'), $this);?>
</a></li>
				   <?php if ($this->_tpl_vars['i']['is_defult'] == 'N'): ?>
					<li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
covering_letter/default/<?php echo $this->_tpl_vars['i']['id']; ?>
/?portid=<?php echo $this->_tpl_vars['port_id']; ?>
" ><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_default'), $this);?>
</a></li>
				   <?php endif; ?>
                 </ul>
                </li>
              </ul>
            </div>
        </td>
    </tr>
    
  <?php endforeach; endif; unset($_from); ?>
</table>

<p><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
covering_letter/add/?portid=<?php echo $this->_tpl_vars['port_id']; ?>
"><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_new_cl'), $this);?>
 </a></p>