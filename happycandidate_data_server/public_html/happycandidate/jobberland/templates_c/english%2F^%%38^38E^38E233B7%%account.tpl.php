<?php /* Smarty version 2.6.26, created on 2015-10-22 18:46:23
         compiled from employer/account.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'employer/account.tpl', 26, false),array('function', 'html_options', 'employer/account.tpl', 111, false),array('modifier', 'count', 'employer/account.tpl', 122, false),)), $this); ?>
<?php echo ' 
<script language="javascript" type="text/javascript">
  tinyMCE.init({
    theme : "advanced",
    mode: "exact",
    elements : "txt_company_desc",
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
 

<h1 class="header"> <?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'my_account'), $this);?>
 </h1>

<div class="border">
  <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="username_txt" value="<?php echo $this->_tpl_vars['username']; ?>
" />
    <table width="100%">
        <colgroup>
          <col width="2%" />
          <col width="20%" />
          <col width="60%" />
        </colgroup>
        <tr>
            <td colspan="3">
                
                <?php if ($this->_tpl_vars['message'] != ""): ?> <br /><?php echo $this->_tpl_vars['message']; ?>
<br /> <?php endif; ?>
               
                <?php echo smarty_function_lang(array('mkey' => 'required_info_indication'), $this);?>

            </td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td><div class='td_width'><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'username'), $this);?>
:</span></div></td>
            <td><?php echo $this->_tpl_vars['username']; ?>
</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
            	<span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'email_address'), $this);?>
:</span>
            </td>
            <td><?php echo $this->_tpl_vars['email']; ?>

                <br /><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/account/update_email/"><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_update_email'), $this);?>
</a>
            </td>
        </tr>
		<tr>
            <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
            <td><span class="label">First Name: </span></td>
            <td><input type="text" id="txt_first_name" name="txt_first_name" size="25" class="text_field" value="<?php echo $this->_tpl_vars['fname']; ?>
" /></td>
        </tr>
		 <tr>
           <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
            <td><span class="label">Last Name: </span></td>
            <td><input type="text" id="txt_last_name" name="txt_last_name" size="25" class="text_field" value="<?php echo $this->_tpl_vars['lname']; ?>
" /></td>
        </tr>
        <tr>
            <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
            <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'company_name'), $this);?>
: </span></td>
            <td><input type="text" name="txt_company_name" size="35"  class="text_field required"  value="<?php echo $this->_tpl_vars['company_name']; ?>
" /></td>
        </tr>
        <!--<tr>
            <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
            <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'company_contact_name'), $this);?>
: </span></td>
            <td><input type="text" id="txt_contact_name" name="txt_contact_name" size="25" class="text_field" value="<?php echo $this->_tpl_vars['contact_name']; ?>
" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'WebSite'), $this);?>
: </span></td>
            <td><input type="text" id="txt_site" name="txt_site" size="20" class="text_field"  value="<?php echo $this->_tpl_vars['site']; ?>
" /></td>
        </tr>-->
        
        <tr>
            <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
           <!--<td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'address'), $this);?>
: </span></td>-->
            <td><span class="label">Address Line1: </span></td>
            <td><input type="text" id="txt_address" name="txt_address" size="25" class="text_field"  value="<?php echo $this->_tpl_vars['address']; ?>
" /></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <!--<td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'address2'), $this);?>
: </span></td>-->
            <td><span class="label">Address Line2: </span></td>
            <td><input type="text" id="txt_address2" name="txt_address2" size="30" class="text_field"  value="<?php echo $this->_tpl_vars['address2']; ?>
" /></td>
        </tr>
		<tr>
			<td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
			<td><span class="label">Zip / Postal Code: </span></td>
			<td><input type="text" onchange="fnGetLocationDetailFromZip()" id="txt_pcode" name="txt_pcode" size="10" class="text_field"  value="<?php echo $this->_tpl_vars['pcode']; ?>
" />&nbsp;<img style="display:none;" id="loader" name="loader" src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
images/loader.gif" /></td>
		</tr>

		<tr id="country">
			<td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
			<td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'country'), $this);?>
: </span></td>
			<td>
			
			<select name="txt_country" id="txt_country" onchange="javascript: cascadeCountry(this.value,'txtstateprovince');" >
				<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['country'],'selected' => $_SESSION['loc']['country']), $this);?>

			</select>
			 </td>
		</tr>

		<tr id="state">
			<td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
			<td><span class="label">State / Province / Region: </span></td>
			<td>
				<div id="stateprovince_auto">
				
				<?php if (count($this->_tpl_vars['lang']['states']) > 0): ?>
					<select class="select" name="txtstateprovince" id="txtstateprovince" onchange="javascript: cascadeState(this.value, this.form.txt_country.value,'txtcounty');" >
					<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['states'],'selected' => $_SESSION['loc']['stateprovince']), $this);?>

					</select>
				<?php else: ?>
					<input class="text_field required" name="txtstateprovince" id="txtstateprovince" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['loc']['stateprovince']; ?>
" />
			   <?php endif; ?>                
				</div>
			  </td>
		</tr>

		<tr id="locality" style="display:none;">
			<td>&nbsp;</td>
			<td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'city'), $this);?>
: </span></td>
			<td>
				<div id="city_auto">
				  <?php if (count($this->_tpl_vars['lang']['cities']) > 0): ?>
					<select class="select" name="txtcity" id="localityval" >
					  <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['cities'],'selected' => $_SESSION['loc']['citycode']), $this);?>

					</select>
				  <?php else: ?>
					<input name="txtcity" id="localityval" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['loc']['citycode']; ?>
" />
				  <?php endif; ?>

				</div>
			</td>
		</tr>
		
		<tr id="city" style="display:none;">
			<td>&nbsp;</td>
			<td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'county'), $this);?>
: </span></td>
			<td>
				<div id="county_auto">

				  <?php if (count($this->_tpl_vars['lang']['counties']) > 0): ?>
					<select class="select" name="txtcounty"  id="txtcounty" onchange="javascript: cascadeCounty(this.value,this.form.txt_country.value, this.form.txtstateprovince.value,'txtcity');" >
					<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['counties'],'selected' => $_SESSION['loc']['countycode']), $this);?>

					</select>
				  <?php else: ?>
					<input name="txtcounty" id="txtcounty" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['loc']['countycode']; ?>
" />
				  <?php endif; ?>
				
				</div>
			</td>
		</tr>

		
        <tr>
            <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
            <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'PhoneNumber'), $this);?>
:</span></td>
            <td><input type="text" id="txt_tele" name="txt_tele" size="20" class="text_field"  value="<?php echo $this->_tpl_vars['tele']; ?>
" /></td>
        </tr>
        <!--<tr>
            <td>&nbsp;</td>
            <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'Logo'), $this);?>
: </span></td>
            <td>
            <?php if ($this->_tpl_vars['company_logo'] != '' && isset ( $this->_tpl_vars['company_logo'] )): ?>
            <img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
images/company_logo/<?php echo $this->_tpl_vars['company_logo']; ?>
" /> 
                <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/account/delete_logo/"> <?php echo smarty_function_lang(array('mkey' => 'e_link','skey' => 'delete_logo'), $this);?>
 </a>
                <br /><br />
            <?php endif; ?>
                <input type="file" id="txt_logo" name="txt_logo" class="text_field"  /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'CompanyDesc'), $this);?>
: </span></td>
            <td><textarea name="txt_company_desc" id="txt_company_desc" cols="5" rows="20" class="text_field" ><?php echo $this->_tpl_vars['company_desc']; ?>
</textarea></td>
        </tr>-->

        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        
        <tr>
            <td></td>
            <td></td>
            <td><input type="submit" id="bt_update" name="bt_update" class="button update" value=" <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'update'), $this);?>
 &raquo;" /></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        
    </table>
  </form>
</div>