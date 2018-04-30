<?php /* Smarty version 2.6.26, created on 2013-11-09 06:58:30
         compiled from admin/manage_pages.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'admin/manage_pages.tpl', 41, false),)), $this); ?>
<?php echo ' 
<script language="javascript" type="text/javascript">
  tinyMCE.init({
    theme : "advanced",
    mode: "exact",
    elements : "txt_page_text",
	skin : "o2k7",
    theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
    theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,"
							   +"justifyfull,fontselect,fontsizeselect,forecolor,backcolor",
	
	theme_advanced_buttons2 : "bullist, numlist, outdent, indent, |, cut,copy,paste,pastetext,"
							+ "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
	
	theme_advanced_buttons3 : "",
	
    height:"350px",
    width:"550px",
    file_browser_callback : \'myFileBrowser\'
  });

</script>
'; ?>
 

<div class="header">Page Management </div>

<?php if ($this->_tpl_vars['message'] != ""): ?> $message <?php endif; ?>

<form method="post" action="" name="frm1">
    <table width="100%" border="0" cellpadding="" cellspacing="" >
       <colgroup>
         <col width="45" />
         <col/>
       </colgroup>
        <tr>
          <td>Pages: </td>
          <td>
            <select name="id" onchange="javascript: document.frm1.submit();" >
            	<option value="">Add new Page</option> 
            	<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['list_page'],'selected' => $_POST['id']), $this);?>

            </select>
          </td>
        </tr>
    </table>
</form>
    

<form method="post" action="" name="frmPage">
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" />
	<table  width="100%" border="0" cellpadding="" cellspacing="" >
       <colgroup>
         <col width="45" />
         <col/>
       </colgroup>
    	<tr>
          <td>Title: </td>
          <td><input type="text" name="txt_title" size="30" value="<?php echo $this->_tpl_vars['title']; ?>
" /></td>
        </tr>
        
        <tr>
          <td>Key: </td>
          <td><input type="text" name="txt_key" size="20" value="<?php echo $this->_tpl_vars['key']; ?>
" />
          www.yourdomain.com/page/YOUR_KEY</td>
        </tr>
        
        <tr>
          <td colspan="2">
          	<textarea name="txt_page_text"><?php echo $this->_tpl_vars['page_text']; ?>
</textarea>
          </td>
        </tr>
        
        <tr>
          <td colspan="2">
          	<?php if ($this->_tpl_vars['id'] == ""): ?>
            	<input type="submit" name="bt_page" value="Add Page" class="button"  />
            <?php else: ?>
            	<input type="submit" name="bt_update_page" value="Modify Page" class="button"  />
            <?php endif; ?>
          </td>
        </tr>
        
    </table>
</form>