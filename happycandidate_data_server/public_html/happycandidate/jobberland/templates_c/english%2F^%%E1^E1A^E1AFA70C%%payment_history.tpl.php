<?php /* Smarty version 2.6.26, created on 2013-11-01 07:05:26
         compiled from employer/payment_history.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'employer/payment_history.tpl', 3, false),)), $this); ?>
<?php if ($this->_tpl_vars['recent_orders']): ?>

<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'PaymentHistory'), $this);?>
</div>
<div class="noborder_div">

<table class="order_table" border="0" cellpadding="5" cellspacing="1">
 <tr>
   <td class="order_col_head"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'InvoiceDate'), $this);?>
</td>
   <td class="order_col_head"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'PaymentDate'), $this);?>
</td>
   <td class="order_col_head"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'id'), $this);?>
</td>
   <td class="order_col_head"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'Item'), $this);?>
</td>
   <td class="order_col_head"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'Description'), $this);?>
</td>
   <td class="order_col_head"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'Qty'), $this);?>
</td>
   <td class="order_col_head"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'PackageInclude'), $this);?>
</td>
   <td class="order_col_head"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'Status'), $this);?>
</td>
   <td class="order_col_head"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'Amount'), $this);?>
</td>
 </tr>
 <?php $_from = $this->_tpl_vars['recent_orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
 <tr>
   <td class="order_col_data"><?php echo $this->_tpl_vars['i']['invoice_date']; ?>
</td>
   <td class="order_col_data"><?php echo $this->_tpl_vars['i']['processed_date']; ?>
</td>
   <td class="order_col_data">#<?php echo $this->_tpl_vars['i']['id']; ?>
</td>
   <td class="order_col_data"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/invoice/<?php echo $this->_tpl_vars['i']['id']; ?>
/"><?php echo $this->_tpl_vars['i']['item_name']; ?>
</a></td>
   <td class="order_col_data"><?php echo $this->_tpl_vars['i']['package_desc']; ?>
</td>
   <td class="order_col_data">#<?php echo $this->_tpl_vars['i']['posts_quantity']; ?>
</td>
   <td class="order_col_data">

        <?php if ($this->_tpl_vars['i']['standard'] == 'Y'): ?> <img src='<?php echo $this->_tpl_vars['skin_images_path']; ?>
tick.gif' alt='' />
                <?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'Standardpost'), $this);?>
 <br /><?php endif; ?>
        <?php if ($this->_tpl_vars['i']['spotlight'] == 'Y'): ?> <img src='<?php echo $this->_tpl_vars['skin_images_path']; ?>
tick.gif' alt='' />
                <?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'Spotlightpost'), $this);?>
<br /> <?php endif; ?>
        <?php if ($this->_tpl_vars['i']['cv_views'] == 'Y'): ?> <img src='<?php echo $this->_tpl_vars['skin_images_path']; ?>
tick.gif' alt='' />
          <?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'CVView'), $this);?>
 <br /><?php endif; ?> 
      
   </td>
   
   
   
   <td class="order_col_data">
	<?php if ($this->_tpl_vars['i']['package_status'] == 'Confirmed' || $this->_tpl_vars['i']['package_status'] == 'Selected'): ?>
        <?php echo $this->_tpl_vars['i']['package_status']; ?>

        <br /><a href='<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/order/?action=post&amp;package_id=<?php echo $this->_tpl_vars['i']['package_id']; ?>
'> <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'confirm'), $this);?>
 </a>
        <?php else: ?>
        <?php echo $this->_tpl_vars['i']['package_status']; ?>

    <?php endif; ?>
   </td>
   <td class="order_col_data"><?php echo smarty_function_lang(array('skey' => 'currency_symbol','mkey' => 'select','ckey' => $this->_tpl_vars['CURRENCY_NAME']), $this);?>
 <?php echo $this->_tpl_vars['i']['amount']; ?>
 <?php echo $this->_tpl_vars['CURRENCY_NAME']; ?>
 </td>
 </tr>
 <?php endforeach; endif; unset($_from); ?>
</table>

</div>
<?php else: ?>
   no orders
<?php endif; ?>