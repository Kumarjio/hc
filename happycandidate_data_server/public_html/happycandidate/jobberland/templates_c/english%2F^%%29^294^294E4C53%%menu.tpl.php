<?php /* Smarty version 2.6.26, created on 2013-11-01 06:51:38
         compiled from employer/menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'employer/menu.tpl', 5, false),)), $this); ?>
<div class="menu bubplastic horizontal gray" id="menu_bar">

<ul id="navigation">
  <li><span class="menu_r"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/" target="_self">
    <span class="menu_ar"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'home'), $this);?>
</span></a></span></li>
 
<?php if ($this->_tpl_vars['employer_logged_in'] != '' && isset ( $this->_tpl_vars['employer_logged_in'] )): ?>
    <li><span class="menu_r"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
logout/" target="_self">
       <span class="menu_ar"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'logout'), $this);?>
</span></a></span></li>
    <li><span class="menu_r"><a href="#" target="_self">
       <span class="menu_ar"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'PostManagejob'), $this);?>
<img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
tab_divider1.gif" alt="" /></span></a></span>
        <ul class="horizontal_sub">
            <li><span class="menu_r2"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/addjob/" target="_self">
               <span class="menu_ar2"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'Postnewjob'), $this);?>
</span></a></span></li>
            <li><span class="menu_r2"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/addjob/spotlight/" target="_self">
               <span class="menu_ar2"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'PostnewSpotlightjob'), $this);?>
</span></a></span></li>
            <li><span class="menu_r2"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/myjobs/" target="_self">
               <span class="menu_ar2"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'Managejob'), $this);?>
</span></a></span></li>
            <li><span class="menu_r2"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/search/" target="_self">
               <span class="menu_ar2"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'SearchCV'), $this);?>
</span></a></span></li>
        </ul>
    </li>
    
    <li><span class="menu_r"><a href="#" target="_self">
      <span class="menu_ar"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'my_account'), $this);?>
<img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
tab_divider1.gif" alt="" /></span></a></span>
        <ul class="horizontal_sub">
            <li><span class="menu_r2"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/account/" target="_self">
              <span class="menu_ar2"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'my_details'), $this);?>
</span></a></span></li>
            <li><span class="menu_r2"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/account/change_password/" target="_self">
              <span class="menu_ar2"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'change_passeword'), $this);?>
</span></a></span></li>
            <li><span class="menu_r2"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/payment_history/" target="_self">
              <span class="menu_ar2"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'payment_history'), $this);?>
</span></a></span></li>
        </ul>
    </li>
    <li><span class="menu_r"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/credits/" target="_self"><span class="menu_ar">Buy Credits</li>
<?php else: ?>

    <li><span class="menu_r"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/login/" target="_self">
       <span class="menu_ar"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'login'), $this);?>
</span></a></span></li>
    <li><span class="menu_r"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/register/" target="_self">
       <span class="menu_ar"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'register'), $this);?>
</span></a></span></li>
<?php endif; ?>
        
    <li><span class="menu_r"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/services/" target="_self">
       <span class="menu_ar"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'products'), $this);?>
</span></a></span></li>
    <li><span class="menu_r"><a href="#" target="_self">
       <span class="menu_ar"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'help'), $this);?>
<img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
tab_divider1.gif" alt="" /></span></a></span>
        <ul class="horizontal_sub">	
            <li><span class="menu_r2"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/page/faq/" target="_self">
              <span class="menu_ar2"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'faq'), $this);?>
</span></a></span></li>
            <!-- <li><span class="menu_r2"><a href="#" target="_self">
               <span class="menu_ar2"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'feedback'), $this);?>
</span></a></span></li> -->
            <!-- <li><span class="menu_r2"><a href="#" target="_self">
               <span class="menu_ar2"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'contact_us'), $this);?>
</span></a></span></li> -->
        </ul>
    </li>
</ul>
<br class="clearit" />
</div>