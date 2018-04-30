<?php /* Smarty version 2.6.26, created on 2016-02-01 13:12:53
         compiled from apply_suggestion.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'apply_suggestion.tpl', 5, false),)), $this); ?>
<div style="border:solid 1px #000; padding:5px;" class="round">

<br />
<div class="success">
  <span style="color:#F90; font-weight:bold; font-size:14px;"><?php echo smarty_function_lang(array('mkey' => 'success','skey' => 'apply_for'), $this);?>
</span><br /> 
  <span style="color:#003;"><?php echo $this->_tpl_vars['apply_for']; ?>
</span>
</div>

<br /><br />


<?php if ($this->_tpl_vars['job_suggestion'] && is_array ( $this->_tpl_vars['job_suggestion'] )): ?>

<h3><?php echo smarty_function_lang(array('mkey' => 'apply_suggestion','skey' => 'info'), $this);?>
::</h3>

<table width="100%" cellpadding="2" cellspacing="2">

<?php $_from = $this->_tpl_vars['job_suggestion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>

  <tr>
    <td></td>
    <td>
      <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
job/<?php echo $this->_tpl_vars['i']['var_name']; ?>
/"><?php echo $this->_tpl_vars['i']['job_title']; ?>
</a>
      <br /><?php echo $this->_tpl_vars['i']['company_name']; ?>

    </td>
    <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'posted'), $this);?>
: <?php echo $this->_tpl_vars['i']['created_at']; ?>
</td>
    <td><?php echo $this->_tpl_vars['i']['location']; ?>
</td>
  </tr>
  
<?php endforeach; endif; unset($_from); ?>

</table>

<br />

<?php endif; ?>

</div>