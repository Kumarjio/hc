{literal} 
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
    file_browser_callback : 'myFileBrowser'
  });

</script>
{/literal} 

<h1 class="header"> Edit Owner Details </h1>

<div class="border">
  <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="username_txt" value="{$username}" />
    <table width="100%">
        <colgroup>
          <col width="2%" />
          <col width="20%" />
          <col width="60%" />
        </colgroup>
        <tr>
            <td colspan="3">
                
                {if $message != "" } <br />{$message}<br /> {/if}
               
                Fields marked with an asterisk (<img src="{$skin_images_path}required.gif" alt="" />) are mandatory
            </td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td><div class='td_width'><span class="label">Username:</span></div></td>
            <td><input type="text" name="txt_username" size="35"  class="text_field required"  value="{$username}" disabled="disabled" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
            	<span class="label">Email Address:</span>
            </td>
            <td><input type="text" name="txt_email" size="35"  class="text_field required"  value="{$email}" />
                <!-- <br /><a href="{$BASE_URL}employer/account/update_email/">Update your email address</a> -->
            </td>
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td><span class="label">Password:</span></td>
			<td>
			  <input type="password" name="txt_password" class="" value="" size="35" />&nbsp;
			  <input type="checkbox" name="send_password" id="send_password" value="1">Send Updated Password Notification?</input>
			  <!-- <br /><a href="{$BASE_URL}account/update_email/">Update your email address</a> -->
			  
			</td>
		</tr>
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">Company Name: </span></td>
            <td><input type="text" name="txt_company_name" size="35"  class="text_field required"  value="{$company_name}" /></td>
        </tr>
        <!--<tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">Contact Name: </span></td>
            <td><input type="text" id="txt_contact_name" name="txt_contact_name" size="25" class="text_field" value="{$contact_name}" /></td>
        </tr>-->
		
		<tr>
			<td><img src="{$skin_images_path}required.gif" alt="" /></td>
			<td><span class="label">First name: </span></td>
			<td><input type="text" name="txt_fname" class="" value="{$fname}" size="25" /> </td>
		</tr>
		  
		<tr>
			<td><img src="{$skin_images_path}required.gif" alt="" /></td>
			<td><span class="label">Surname / Last Name: </span></td>
			<td><input type="text" name="txt_sname" class="" value="{$sname}" size="30" /></td>
		</tr>
        
        <!--<tr>
            <td>&nbsp;</td>
            <td><span class="label">Web Site: </span></td>
            <td><input type="text" id="txt_site" name="txt_site" size="20" class="text_field"  value="{$site}" /></td>
        </tr>-->
        
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">Address Line1: </span></td>
            <td><input type="text" id="txt_address" name="txt_address" size="25" class="text_field"  value="{$address}" /></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td><span class="label">Address Line2: </span></td>
            <td><input type="text" id="txt_address2" name="txt_address2" size="30" class="text_field"  value="{$address2}" /></td>
        </tr>
	 <tr>
		<td><img src="{$skin_images_path}required.gif" alt="" /></td>
		<td><span class="label">Zip / Postal Code: </span></td>
		<td><input type="text" onchange="fnGetLocationDetailFromZip()" id="txt_pcode" name="txt_pcode" size="10" class="text_field"  value="{$pcode}" />&nbsp;<img style="display:none;" id="loader" name="loader" src="{$BASE_URL}images/loader.gif" />
		</td>
	</tr>

    <tr id="country">
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td><span class="label">Country: </span></td>
        <td>
        
        <select name="txt_country" id="txt_country" onchange="javascript: cascadeCountry(this.value,'txtstateprovince');" >
            {html_options options=$country selected=$smarty.session.loc.country}
        </select>
         </td>
    </tr>

    <tr id="state">
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td><span class="label">State / Province / Region: </span></td>
        <td>
            <div id="stateprovince_auto">
            
            {if $lang.states|@count > 0}
                <select class="select" id="txtstateprovince" name="txtstateprovince" onchange="javascript: cascadeState(this.value, this.form.txt_country.value,'txtcounty');" >
                {html_options options=$lang.states selected=$smarty.session.loc.stateprovince}
                </select>
            { else }
                <input class="text_field required" id="txtstateprovince" name="txtstateprovince" type="text" size="30" maxlength="100" value="{$smarty.session.loc.stateprovince}" />
           { /if}                
            </div>
          </td>
    </tr>
	
	<tr id="city" style="display:none;">
        <td></td>
        <td><span class="label">City / Town: </span></td>
        <td>
            <div id="city_auto">
              { if $lang.cities|@count > 0}
                <select class="select" id="localityval" name="localityval" >
                  {html_options options=$lang.cities selected=$smarty.session.loc.citycode}
                </select>
              { else }
                <input id="localityval" name="localityval" type="text" size="30" maxlength="100" value="{$smarty.session.loc.citycode}" />
              { /if}

            </div>
        </td>
    </tr>

    <tr id="locality" style="display:none;">
        <td></td>
        <td><span class="label">County / District: </span></td>
        <td>
            <div id="county_auto">

              { if $lang.counties|@count > 0}
                <select class="select" id="txtcounty" name="txtcounty" onchange="javascript: cascadeCounty(this.value,this.form.txt_country.value, this.form.txtstateprovince.value,'txtcity');" >
                {html_options options=$lang.counties selected=$smarty.session.loc.countycode}
                </select>
              { else }
                <input id="txtcounty" name="txtcounty" type="text" size="30" maxlength="100" value="{$smarty.session.loc.countycode}" />
              { /if}
            
            </div>
        </td>
    </tr>
        
       
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">Phone Number:</span></td>
            <td><input type="text" id="txt_tele" name="txt_tele" size="20" class="text_field"  value="{$tele}" /></td>
        </tr>
        <!--<tr>
            <td>&nbsp;</td>
            <td><span class="label">Logo: </span></td>
            <td>
            {if $company_logo != '' && isset($company_logo) }
            <img src="{$BASE_URL}images/company_logo/{$company_logo}" /> 
                <a href="?id={$id}&amp;action=delete_logo"> Delete Logo </a>
                <br /><br />
            {/if}
                <input type="file" id="txt_logo" name="txt_logo" class="text_field"  /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><span class="label">Company Description: </span></td>
            <td><textarea name="txt_company_desc" id="txt_company_desc" cols="5" rows="20" class="text_field" >{$company_desc}</textarea></td>
        </tr>-->

        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        
        <tr>
            <td></td>
            <td></td>
            <td><input type="submit" id="bt_update" name="bt_update" class="button update" value=" Update &raquo;" /></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        
    </table>
  </form>
</div>
