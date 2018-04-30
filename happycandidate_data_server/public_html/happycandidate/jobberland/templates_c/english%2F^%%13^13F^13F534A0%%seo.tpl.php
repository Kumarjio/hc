<?php /* Smarty version 2.6.26, created on 2013-11-09 07:00:18
         compiled from admin/seo.tpl */ ?>
<div class="header">Search Engine Optimisation </div>
<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<p>
	<strong>Description: </strong>
	<?php echo $this->_tpl_vars['cat_description']; ?>

</p>
<br />

<form action="" method="post" >
    <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> <strong><?php echo $this->_tpl_vars['title']; ?>
: </strong></td>
    <td><input type="text" value="<?php echo $this->_tpl_vars['title_value']; ?>
" size="100" maxlength="255" name="setting[PAGE_TITLE]" />
    	<br /><?php echo $this->_tpl_vars['title_desc']; ?>

    </td>
    </tr>
  <tr>
    <td><strong><?php echo $this->_tpl_vars['keyword_title']; ?>
: </strong> </td>
    <td><textarea name="setting[META_KEYWORDS]" cols="80" rows="5"><?php echo $this->_tpl_vars['keyword_value']; ?>
</textarea>
    <br /><?php echo $this->_tpl_vars['keyword_desc']; ?>

    </td>
    </tr>
  <tr>
    <td><strong><?php echo $this->_tpl_vars['desc_title']; ?>
: </strong> </td>
    <td><textarea name="setting[META_DESCRIPTION]" cols="80" rows="5"><?php echo $this->_tpl_vars['desc_value']; ?>
</textarea>
    <br /><?php echo $this->_tpl_vars['desc_desc']; ?>

    </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="add" value=" Update " /></td>
    </tr>
</table>


</form>