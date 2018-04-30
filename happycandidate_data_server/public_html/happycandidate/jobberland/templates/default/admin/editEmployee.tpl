<div class="header">Edit Job Seeker Details</div>

{if $message != "" } {$message} {/if}

<br />
<form action="" method="post" name="account_form">
<div class="header">Personal details</div>

<table width="100%" class="small">
  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">Title: </span></td>
    <td>
         {html_options name=title_txt options=$titles selected=$smarty.session.account.title}
    </td>
  </tr>
  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">First Name: </span></td>
    <td><input type="text" name="txt_fname" class="" value="{$fname}" size="25" /> </td>
  </tr>
  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">Surname / Last Name: </span></td>
    <td><input type="text" name="txt_sname" class="" value="{$sname}" size="30" /></td>
  </tr>
  
  <tr>
    <td></td>
    <td><span class="label">Address Line1: </span></td>
    <td><input type="text" name="txt_address" class="" value="{$address}" size="40" /></td>
  </tr>
  
  <tr>
    <td></td>
    <td><span class="label">Address Line2: </span></td>
    <td><input type="text" name="txt_address2" class="" value="{$address2}" size="40" /></td>
  </tr>
  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">Zip / Postal Code: </span></td>
    <td>
		<input type="text" onchange="fnGetLocationDetailFromZip()" id="txt_pcode" name="txt_pcode" class="" value="{$post_code}" size="10" />
		&nbsp;<img style="display:none;" id="loader" name="loader" src="{$BASE_URL}images/loader.gif" />
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
  
  <tr id="locality" style="display:none;">
		<td></td>
		<td><span class="label">City / Town: </span></td>
		<td>
			<div id="city_auto">
			  { if $lang.cities|@count > 0}
				<select class="select" id="localityval" name="localityval" >
				  {html_options options=$lang.cities selected=$smarty.session.loc.citycode}
				</select>
			  { else }
				<input name="localityval" id="localityval" type="text" size="30" maxlength="100" value="{$smarty.session.loc.citycode}" />
			  { /if}

			</div>
		</td>
  </tr>

  <tr id="city" style="display:none;">
	<td></td>
	<td><span class="label">County / District: </span></td>
	<td>
		<div id="county_auto">

		  { if $lang.counties|@count > 0}
			<select class="select" id="txtcounty" name="txtcounty" onchange="javascript: cascadeCounty(this.value,this.form.txt_country.value, this.form.txtstateprovince.value,'txtcity');" >
			{html_options options=$lang.counties selected=$smarty.session.loc.countycode}
			</select>
		  { else }
			<input name="txtcounty" id="txtcounty" type="text" size="30" maxlength="100" value="{$smarty.session.loc.countycode}" />
		  { /if}
		
		</div>
	</td>
  </tr>

  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">Phone Number:</span></td>
    <td><input type="text" name="txt_phone_number" class="" value="{$phone_number}" size="30" /></td>
  </tr>
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">Email Address:</span></td>
    <td>
      <input type="text" name="txt_email_address" class="" value="{$email_address}" size="35" />
      <!-- <br /><a href="{$BASE_URL}account/update_email/">Update your email address</a> -->
      
    </td>
  </tr>
	<tr>
	<td>&nbsp;</td>
	<td><span class="label">Password: </span></td>
	<td>
	  <input type="password" name="txt_password" class="" value="" size="35" />&nbsp;
	  <input type="checkbox" name="send_password" id="send_password" value="1">Send Updated Password Notification?</input>
	  <!-- <br /><a href="{$BASE_URL}account/update_email/">Update your email address</a> -->
	  
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