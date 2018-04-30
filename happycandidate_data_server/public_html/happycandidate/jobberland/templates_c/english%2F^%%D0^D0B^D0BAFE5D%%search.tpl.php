<?php /* Smarty version 2.6.26, created on 2015-10-27 11:35:35
         compiled from search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'search.tpl', 18, false),)), $this); ?>
<a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
save_search/?action=save&name=<?php echo $this->_tpl_vars['save_reference_name']; ?>
&reference=<?php echo $this->_tpl_vars['save_reference']; ?>
&portid=<?php echo $this->_tpl_vars['port_id']; ?>
&set_default_search=1">Make Default Search</a>
&nbsp;<a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
save_search/?action=save&name=<?php echo $this->_tpl_vars['save_reference_name']; ?>
&reference=<?php echo $this->_tpl_vars['save_reference']; ?>
&portid=<?php echo $this->_tpl_vars['port_id']; ?>
">Save Search</a>


<?php if (is_array ( $this->_tpl_vars['list_jobs'] ) && $this->_tpl_vars['list_jobs'] != ""): ?>
<table width="100%" border="0" id="search_tb" cellpadding="0" cellspacing="0">
<colgroup>
    <col width="11.8%" />
    <col width="51%" />
    <col width="8%" />
    <col width="12%" />
    <col />
</colgroup>

  <tr>
    <td colspan="5">
    <div class="result">
        <strong><?php echo $this->_tpl_vars['total_count']; ?>
 <?php echo smarty_function_lang(array('mkey' => 'results_found'), $this);?>
</strong>
        <br />
        <?php echo smarty_function_lang(array('mkey' => 'you_are_viewing'), $this);?>
 <?php echo $this->_tpl_vars['offset']+1; ?>
 <?php echo smarty_function_lang(array('mkey' => 'to'), $this);?>
 <?php echo $this->_tpl_vars['offset']+$this->_tpl_vars['per_page']; ?>
 
        <br />
    </div>
    
    <div class="page_num">
     <?php if ($this->_tpl_vars['total_pages'] > 1): ?>
        <?php if ($this->_tpl_vars['has_previous_page']): ?> 
            <a href="?<?php if ($this->_tpl_vars['query'] != ''): ?><?php echo $this->_tpl_vars['query']; ?>
&amp;<?php endif; ?>page=<?php echo $this->_tpl_vars['previous_page']; ?>
">&laquo; <?php echo smarty_function_lang(array('mkey' => 'previous'), $this);?>
</a> 
        <?php else: ?>
        	    &laquo; <?php echo smarty_function_lang(array('mkey' => 'previous'), $this);?>

        <?php endif; ?>
        <?php unset($this->_sections['page']);
$this->_sections['page']['name'] = 'page';
$this->_sections['page']['start'] = (int)1;
$this->_sections['page']['loop'] = is_array($_loop=$this->_tpl_vars['total_pages']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['page']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['page']['show'] = true;
$this->_sections['page']['max'] = $this->_sections['page']['loop'];
if ($this->_sections['page']['start'] < 0)
    $this->_sections['page']['start'] = max($this->_sections['page']['step'] > 0 ? 0 : -1, $this->_sections['page']['loop'] + $this->_sections['page']['start']);
else
    $this->_sections['page']['start'] = min($this->_sections['page']['start'], $this->_sections['page']['step'] > 0 ? $this->_sections['page']['loop'] : $this->_sections['page']['loop']-1);
if ($this->_sections['page']['show']) {
    $this->_sections['page']['total'] = min(ceil(($this->_sections['page']['step'] > 0 ? $this->_sections['page']['loop'] - $this->_sections['page']['start'] : $this->_sections['page']['start']+1)/abs($this->_sections['page']['step'])), $this->_sections['page']['max']);
    if ($this->_sections['page']['total'] == 0)
        $this->_sections['page']['show'] = false;
} else
    $this->_sections['page']['total'] = 0;
if ($this->_sections['page']['show']):

            for ($this->_sections['page']['index'] = $this->_sections['page']['start'], $this->_sections['page']['iteration'] = 1;
                 $this->_sections['page']['iteration'] <= $this->_sections['page']['total'];
                 $this->_sections['page']['index'] += $this->_sections['page']['step'], $this->_sections['page']['iteration']++):
$this->_sections['page']['rownum'] = $this->_sections['page']['iteration'];
$this->_sections['page']['index_prev'] = $this->_sections['page']['index'] - $this->_sections['page']['step'];
$this->_sections['page']['index_next'] = $this->_sections['page']['index'] + $this->_sections['page']['step'];
$this->_sections['page']['first']      = ($this->_sections['page']['iteration'] == 1);
$this->_sections['page']['last']       = ($this->_sections['page']['iteration'] == $this->_sections['page']['total']);
?>
            <?php if ($this->_sections['page']['index'] == $this->_tpl_vars['page']): ?>
                <span class="selected"><?php echo $this->_sections['page']['index']; ?>
</span>
            <?php else: ?>
                <a href="?<?php if ($this->_tpl_vars['query'] != ''): ?><?php echo $this->_tpl_vars['query']; ?>
&amp;<?php endif; ?>page=<?php echo $this->_sections['page']['index']; ?>
"><?php echo $this->_sections['page']['index']; ?>
</a> 
            <?php endif; ?>
        <?php endfor; endif; ?>
        
        <?php if ($this->_tpl_vars['has_next_page']): ?> 
            <a href="?<?php if ($this->_tpl_vars['query'] != ''): ?><?php echo $this->_tpl_vars['query']; ?>
&amp;<?php endif; ?>page=<?php echo $this->_tpl_vars['next_page']; ?>
"><?php echo smarty_function_lang(array('mkey' => 'next'), $this);?>
 &raquo;</a> 
        <?php else: ?> <?php echo smarty_function_lang(array('mkey' => 'next'), $this);?>
 &raquo;<?php endif; ?>
    <?php endif; ?>

     <br /><br />
    </div>
    
    </td>
  </tr>

  <tr class="search_header" style="color:#FFF;">
    <th class="left_black">&nbsp;&nbsp;<?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'date_posted'), $this);?>
</th>
    <th><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'job_details_pre'), $this);?>
</th>
    <th><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'job_type'), $this);?>
</th>
    <th><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'salary'), $this);?>
</th>
    <th class="right_black"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'location'), $this);?>
</th>
  </tr>

<?php $_from = $this->_tpl_vars['list_jobs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>

  <tr>
    <td><label title="<?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'created_at'), $this);?>
 <?php echo $this->_tpl_vars['i']['created_at']; ?>
"><?php echo $this->_tpl_vars['i']['created_at']; ?>
</label>
    </td>
    <td>
				<a href="javascript:void(0);"><?php echo $this->_tpl_vars['i']['job_title']; ?>
</a>
        <br /><br />
        <?php echo $this->_tpl_vars['i']['job_description']; ?>

        
        &nbsp;&nbsp;&nbsp;
                
        <br /><br />
            <?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'advertise_by'), $this);?>

                        <a href="javascript:void(0);"><?php echo $this->_tpl_vars['i']['company_name']; ?>
</a>
        <br />
    </td>
    <td><?php echo $this->_tpl_vars['i']['type_name']; ?>
</td>
    <td><?php echo $this->_tpl_vars['i']['salary']; ?>
</td>
    <td>
				<a href="javascript:void(0);"><?php echo $this->_tpl_vars['i']['location']; ?>
</a>
         <br /><br />
          <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
save_job/?id=<?php echo $this->_tpl_vars['i']['id']; ?>
&action=save_job&portid=<?php echo $this->_tpl_vars['port_id']; ?>
"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'save_job'), $this);?>
</a>
    </td>
  </tr>
  
  <tr class="divider">
    <td colspan="5">
      <div class="hr-dotted"><hr /></div>
    </td>
  </tr>

  <?php endforeach; endif; unset($_from); ?>
  

  <tr>
    <td colspan="5">
    <div class="result">&nbsp;</div>
    
    <div class="page_num">

     <?php if ($this->_tpl_vars['total_pages'] > 1): ?>
        <?php if ($this->_tpl_vars['has_previous_page']): ?> 
            <a href="?<?php if ($this->_tpl_vars['query'] != ''): ?><?php echo $this->_tpl_vars['query']; ?>
&amp;<?php endif; ?>page=<?php echo $this->_tpl_vars['previous_page']; ?>
">&laquo; <?php echo smarty_function_lang(array('mkey' => 'previous'), $this);?>
</a> 
        <?php else: ?>
        	    &laquo; <?php echo smarty_function_lang(array('mkey' => 'previous'), $this);?>

        <?php endif; ?>
        <?php unset($this->_sections['page']);
$this->_sections['page']['name'] = 'page';
$this->_sections['page']['start'] = (int)1;
$this->_sections['page']['loop'] = is_array($_loop=$this->_tpl_vars['total_pages']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['page']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['page']['show'] = true;
$this->_sections['page']['max'] = $this->_sections['page']['loop'];
if ($this->_sections['page']['start'] < 0)
    $this->_sections['page']['start'] = max($this->_sections['page']['step'] > 0 ? 0 : -1, $this->_sections['page']['loop'] + $this->_sections['page']['start']);
else
    $this->_sections['page']['start'] = min($this->_sections['page']['start'], $this->_sections['page']['step'] > 0 ? $this->_sections['page']['loop'] : $this->_sections['page']['loop']-1);
if ($this->_sections['page']['show']) {
    $this->_sections['page']['total'] = min(ceil(($this->_sections['page']['step'] > 0 ? $this->_sections['page']['loop'] - $this->_sections['page']['start'] : $this->_sections['page']['start']+1)/abs($this->_sections['page']['step'])), $this->_sections['page']['max']);
    if ($this->_sections['page']['total'] == 0)
        $this->_sections['page']['show'] = false;
} else
    $this->_sections['page']['total'] = 0;
if ($this->_sections['page']['show']):

            for ($this->_sections['page']['index'] = $this->_sections['page']['start'], $this->_sections['page']['iteration'] = 1;
                 $this->_sections['page']['iteration'] <= $this->_sections['page']['total'];
                 $this->_sections['page']['index'] += $this->_sections['page']['step'], $this->_sections['page']['iteration']++):
$this->_sections['page']['rownum'] = $this->_sections['page']['iteration'];
$this->_sections['page']['index_prev'] = $this->_sections['page']['index'] - $this->_sections['page']['step'];
$this->_sections['page']['index_next'] = $this->_sections['page']['index'] + $this->_sections['page']['step'];
$this->_sections['page']['first']      = ($this->_sections['page']['iteration'] == 1);
$this->_sections['page']['last']       = ($this->_sections['page']['iteration'] == $this->_sections['page']['total']);
?>
            <?php if ($this->_sections['page']['index'] == $this->_tpl_vars['page']): ?>
                <span class="selected"><?php echo $this->_sections['page']['index']; ?>
</span>
            <?php else: ?>
                <a href="?<?php if ($this->_tpl_vars['query'] != ''): ?><?php echo $this->_tpl_vars['query']; ?>
&amp;<?php endif; ?>page=<?php echo $this->_sections['page']['index']; ?>
"><?php echo $this->_sections['page']['index']; ?>
</a> 
            <?php endif; ?>
        <?php endfor; endif; ?>
        
        <?php if ($this->_tpl_vars['has_next_page']): ?> 
            <a href="?<?php if ($this->_tpl_vars['query'] != ''): ?><?php echo $this->_tpl_vars['query']; ?>
&amp;<?php endif; ?>page=<?php echo $this->_tpl_vars['next_page']; ?>
"><?php echo smarty_function_lang(array('mkey' => 'next'), $this);?>
 &raquo;</a> 
        <?php else: ?> <?php echo smarty_function_lang(array('mkey' => 'next'), $this);?>
 &raquo;<?php endif; ?>
    <?php endif; ?>

	<p>&nbsp;</p>
    
    </div>
    </td>
  </tr>
  
</table>
<?php else: ?>
<br />
<div class='error'>
<p><?php echo smarty_function_lang(array('mkey' => 'errormsg','skey' => 01), $this);?>
</p>
    <ul>
        <li><?php echo smarty_function_lang(array('mkey' => 'errormsg','skey' => 02), $this);?>
</li>
        <li><?php echo smarty_function_lang(array('mkey' => 'errormsg','skey' => 03), $this);?>
.</li>
        <!-- <li>Expand your job location radius.</li> -->
        <li><?php echo smarty_function_lang(array('mkey' => 'errormsg','skey' => 04), $this);?>
.</li>
    </ul>
</div>
<br />

<?php endif; ?>