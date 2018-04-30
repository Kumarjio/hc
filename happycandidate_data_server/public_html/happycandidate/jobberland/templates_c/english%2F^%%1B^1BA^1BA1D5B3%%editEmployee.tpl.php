<?php /* Smarty version 2.6.26, created on 2017-11-20 15:31:43
         compiled from admin/editEmployee.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'admin/editEmployee.tpl', 15, false),array('modifier', 'count', 'admin/editEmployee.tpl', 69, false),)), $this); ?>
<div class="header">Edit Job Seeker Details</div>

<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<br />
<form action="" method="post" name="account_form">
<div class="header">Personal details</div>

<table width="100%" class="small">
  
  <tr>
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td><span class="label">Title: </span></td>
    <td>
         <?php echo smarty_function_html_options(array('name' => 'title_txt','options' => $this->_tpl_vars['titles'],'selected' => $_SESSION['account']['title']), $this);?>

    </td>
  </tr>
  
  <tr>
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td><span class="label">First Name: </span></td>
    <td><input type="text" name="txt_fname" class="" value="<?php echo $this->_tpl_vars['fname']; ?>
" size="25" /> </td>
  </tr>
  
  <tr>
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td><span class="label">Surname / Last Name: </span></td>
    <td><input type="text" name="txt_sname" class="" value="<?php echo $this->_tpl_vars['sname']; ?>
" size="30" /></td>
  </tr>
  
  <tr>
    <td></td>
    <td><span class="label">Address Line1: </span></td>
    <td><input type="text" name="txt_address" class="" value="<?php echo $this->_tpl_vars['address']; ?>
" size="40" /></td>
  </tr>
  
  <tr>
    <td></td>
    <td><span class="label">Address Line2: </span></td>
    <td><input type="text" name="txt_address2" class="" value="<?php echo $this->_tpl_vars['address2']; ?>
" size="40" /></td>
  </tr>
  
  <tr>
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td><span class="label">Zip / Postal Code: </span></td>
    <td>
		<input type="text" onchange="fnGetLocationDetailFromZip()" id="txt_pcode" name="txt_pcode" class="" value="<?php echo $this->_tpl_vars['post_code']; ?>
" size="10" />
		&nbsp;<img style="display:none;" id="loader" name="loader" src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
images/loader.gif" />
	</td>
  </tr>

  <tr id="country">
	<td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
	<td><span class="label">Country: </span></td>
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
			<select class="select" id="txtstateprovince" name="txtstateprovince" onchange="javascript: cascadeState(this.value, this.form.txt_country.value,'txtcounty');" >
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['states'],'selected' => $_SESSION['loc']['stateprovince']), $this);?>

			</select>
		<?php else: ?>
			<input class="text_field required" id="txtstateprovince" name="txtstateprovince" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['loc']['stateprovince']; ?>
" />
	   <?php endif; ?>                
		</div>
	  </td>
  </tr>
  
  <tr id="locality" style="display:none;">
		<td></td>
		<td><span class="label">City / Town: </span></td>
		<td>
			<div id="city_auto">
			  <?php if (count($this->_tpl_vars['lang']['cities']) > 0): ?>
				<select class="select" id="localityval" name="localityval" >
				  <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['cities'],'selected' => $_SESSION['loc']['citycode']), $this);?>

				</select>
			  <?php else: ?>
				<input name="localityval" id="localityval" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['loc']['citycode']; ?>
" />
			  <?php endif; ?>

			</div>
		</td>
  </tr>

  <tr id="city" style="display:none;">
	<td></td>
	<td><span class="label">County / District: </span></td>
	<td>
		<div id="county_auto">

		  <?php if (count($this->_tpl_vars['lang']['counties']) > 0): ?>
			<select class="select" id="txtcounty" name="txtcounty" onchange="javascript: cascadeCounty(this.value,this.form.txt_country.value, this.form.txtstateprovince.value,'txtcity');" >
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
    <td><span class="label">Phone Number:</span></td>
    <td><input type="text" name="txt_phone_number" class="" value="<?php echo $this->_tpl_vars['phone_number']; ?>
" size="30" /></td>
  </tr>
  <tr>
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td><span class="label">Email Address:</span></td>
    <td>
      <input type="text" name="txt_email_address" class="" value="<?php echo $this->_tpl_vars['email_address']; ?>
" size="35" />
      <!-- <br /><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
account/update_email/">Update your email address</a> -->
      
    </td>
  </tr>
	<tr>
	<td>&nbsp;</td>
	<td><span class="label">Password: </span></td>
	<td>
	  <input type="password" name="txt_password" class="" value="" size="35" />&nbsp;
	  <input type="checkbox" name="send_password" id="send_password" value="1">Send Updated Password Notification?</input>
	  <!-- <br /><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
account/update_email/">Update your email address</a> -->
	  
	</td>
	</tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td></td>
    <td></td>
    <td><input type="submit" name="account_btn" value="Save my Profile" class="button" /></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
</table>

</form>