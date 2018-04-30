<?php /* Smarty version 2.6.26, created on 2013-10-30 07:41:39
         compiled from admin/new_employee.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'admin/new_employee.tpl', 65, false),array('modifier', 'count', 'admin/new_employee.tpl', 76, false),)), $this); ?>
<table width="100%">
 <tr>
  <td valign="top">

<strong>Add New Employee</strong>

<!-- RIGESTER -->
  <form action="" method="post" id="frm_register" name="frm_register" >
    <table width="100%">        
        <tr>
            <td colspan="3"> <?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?> </td>
        </tr>
        <tr>
            <td colspan="3"> Fields marked with an asterisk (<img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" />) are mandatory  </td>
        </tr>
        
        <tr>
            <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
            <td><span class="label">Username:</span></td>
            <td><input type="text" id="reg_username" name="reg_username" size="25" 
                class="text_field required" value="<?php echo $_SESSION['reg']['username']; ?>
" /></td>
        </tr>
        <tr>
            <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
            <td><span class="label">Email Address:</span></td>
            <td><input type="text" id="reg_email" name="reg_email" size="30" class="text_field required" 
                value="<?php echo $_SESSION['reg']['email']; ?>
" />
                <br /><i>Please provide valid email address</i>
            </td>
        </tr>
        <tr>
            <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
            <td><span class="label">Password: </span></td>
            <td><input type="password" id="reg_pass" name="reg_pass" size="20" 
                class="text_field required" value="<?php echo $_SESSION['reg']['pass']; ?>
" />
                <br /><i>Password must be between 6 - 20 characters </i>
            </td>
        </tr>
        <tr>
            <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
            <td><span class="label">Confirm Password: </span></td>
            <td><input type="password" id="reg_confirm_pass" name="reg_confirm_pass" size="20" 
                class="text_field required" value="" /></td>
        </tr>
        <tr>
            <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
            <td><span class="label">Firstname: </span></td>
            <td><input type="text" id="reg_fname" name="reg_fname" size="25" class="text_field required" 
                value="<?php echo $_SESSION['reg']['fname']; ?>
" /></td>
        </tr>
        
        <tr>
            <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
            <td><span class="label">Surname: </span></td>
            <td><input type="text" id="reg_sname" name="reg_sname" size="20" class="text_field required" 
                value="<?php echo $_SESSION['reg']['sname']; ?>
" /></td>
        </tr>
        
    <tr>
        <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
        <td><span class="label">Country: </span></td>
        <td>
        
        <select name="txt_country" id="txt_country" onchange="javascript: cascadeCountry(this.value,'txtstateprovince');" >
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['country'],'selected' => $_SESSION['loc']['country']), $this);?>

        </select>
         </td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td><span class="label">State / Province: </span></td>
        <td>
            <div id="stateprovince_auto">
            
            <?php if (count($this->_tpl_vars['lang']['states']) > 0): ?>
                <select class="select" name="txtstateprovince" onchange="javascript: cascadeState(this.value, this.form.txt_country.value,'txtcounty');" >
                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['states'],'selected' => $_SESSION['loc']['stateprovince']), $this);?>

                </select>
            <?php else: ?>
                <input class="text_field required" name="txtstateprovince" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['loc']['stateprovince']; ?>
" />
           <?php endif; ?>                
            </div>
          </td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td><span class="label">County / District: </span></td>
        <td>
            <div id="county_auto">

              <?php if (count($this->_tpl_vars['lang']['counties']) > 0): ?>
                <select class="select" name="txtcounty" onchange="javascript: cascadeCounty(this.value,this.form.txt_country.value, this.form.txtstateprovince.value,'txtcity');" >
                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['counties'],'selected' => $_SESSION['loc']['countycode']), $this);?>

                </select>
              <?php else: ?>
                <input name="txtcounty" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['loc']['countycode']; ?>
" />
              <?php endif; ?>
            
            </div>
        </td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td><span class="label">City / Locality: </span></td>
        <td>
            <div id="city_auto">
              <?php if (count($this->_tpl_vars['lang']['cities']) > 0): ?>
                <select class="select" name="txtcity" >
                  <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['cities'],'selected' => $_SESSION['loc']['citycode']), $this);?>

                </select>
              <?php else: ?>
                <input name="txtcity" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['loc']['citycode']; ?>
" />
              <?php endif; ?>

            </div>
        </td>
    </tr>

        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="submit" id="bt_register" name="bt_register" class="button register" value=" Register &raquo;" /></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        
    </table>
  </form>
  </td>
 </tr>
</table>
  