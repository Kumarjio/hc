<?php /* Smarty version 2.6.26, created on 2015-10-21 16:35:04
         compiled from page_top_logo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'page_top_logo.tpl', 17, false),)), $this); ?>
<table border="0" cellspacing="0" cellpadding="0" class="table">
  <tr>
    <td>
      <div class="logo">
      	<a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
">
        	<img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
<?php echo $this->_tpl_vars['SITE_LOGO']; ?>
" width="150" alt="Site Logo" />
        </a>
        	<br /><strong><?php echo $this->_tpl_vars['SITE_SLOGAN']; ?>
</strong>
      </div>
    </td>

    <td valign="top">
    
    
    	<div class="top_menu">
        <?php echo $this->_tpl_vars['loggin_user']; ?>

            <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'home'), $this);?>
</a> | 
            <?php if (isset ( $_SESSION['user_id'] )): ?>
            <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
logout/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'logout'), $this);?>
</a> | 
            <?php else: ?>
            <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
login/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'login'), $this);?>
</a> |  
            <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
register/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'register'), $this);?>
</a> | 
            <?php endif; ?>
            <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
page/security/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'security'), $this);?>
</a> | 
            <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
page/help/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'help'), $this);?>
</a>
    	</div>
            
          <table width="100%">
           <tr>
            <td>
            <div class="banner_460_60">
                    <!-- Banner (468 x 60) -->
            </div>
            </td>
            <td>
            <div id="emp_link">
                <span><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'employer_site'), $this);?>
</span>
                <!-- Looking to hire?<br /> -->
                <br /><br /><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'employer'), $this);?>
 &raquo;</a>
            </div>
            </td>
          </tr>
        </table>        
    </td>
  </tr>

</table>