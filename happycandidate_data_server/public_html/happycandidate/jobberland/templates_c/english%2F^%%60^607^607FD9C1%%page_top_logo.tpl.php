<?php /* Smarty version 2.6.26, created on 2013-11-01 06:51:38
         compiled from employer/page_top_logo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'employer/page_top_logo.tpl', 20, false),)), $this); ?>
<table border="0" cellspacing="0" cellpadding="0" class="table">
  <tr>
    <td>
      <div class="logo">
        <?php if ($this->_tpl_vars['SITE_LOGO'] != ''): ?>
      	<a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
">
        	<img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
<?php echo $this->_tpl_vars['SITE_LOGO']; ?>
" width="150" alt="Site Logo" />
        </a>
        <?php else: ?>
            <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
"><?php echo $this->_tpl_vars['SITE_NAME']; ?>
</a>
        <?php endif; ?>
        
        	<br /><strong><?php echo $this->_tpl_vars['SITE_SLOGAN']; ?>
</strong>
      </div>
    </td>

    <td valign="top" align="right">    
    	<div class="top_menu">
        <?php echo $this->_tpl_vars['loggin_user']; ?>

            <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'home'), $this);?>
</a> | 
            <?php if (isset ( $_SESSION['user_id'] )): ?>
            <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
logout/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'logout'), $this);?>
</a> | 
            <?php else: ?>
            <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/login/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'login'), $this);?>
</a> |  
            <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/register/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'register'), $this);?>
</a> | 
            <?php endif; ?>
            <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/page/security/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'security'), $this);?>
</a> | 
            <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/page/help/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'help'), $this);?>
</a>
    	</div>
            
          <table width="100%">
           <tr>
            <td>
            <div class="banner_460_60">
                        </div>
            </td>
            <td>&nbsp;</td>
          </tr>
        </table>        
    </td>
  </tr>
</table>
<br />