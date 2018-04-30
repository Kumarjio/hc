<?php /* Smarty version 2.6.26, created on 2015-10-22 18:46:01
         compiled from employer/left_side.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'employer/left_side.tpl', 4, false),)), $this); ?>
<?php if ($this->_tpl_vars['all_package']): ?>
 
<br />
	<h3><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'PackageOffer'), $this);?>
</h3>
<br />
 <?php $_from = $this->_tpl_vars['all_package']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
<div>
    <div class="solution-option">
        <div class="list-desc">
            <h3><?php echo $this->_tpl_vars['i']['package_name']; ?>
</h3>
            <p>
                <?php echo $this->_tpl_vars['i']['package_desc']; ?>

            </p>
            
           <div class="list-action-box" style="float:left;">
                <strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'packageInclude'), $this);?>
:</strong><br />
                
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
                  	            
				<br />
                
                <div class="price">
                    <?php echo smarty_function_lang(array('skey' => 'currency_symbol','mkey' => 'select','ckey' => $this->_tpl_vars['CURRENCY_NAME']), $this);?>
 <?php echo $this->_tpl_vars['i']['package_price']; ?>
 <?php echo $this->_tpl_vars['CURRENCY_NAME']; ?>

                </div>
                    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/order/?action=post&amp;package_id=<?php echo $this->_tpl_vars['i']['id']; ?>
" 
                    title="Buy Now" ><br/></a>
            </div>
            
        </div>
        <div class="clear"></div>
    </div>

</div>    
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>