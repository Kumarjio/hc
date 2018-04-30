<!--<div class="header">{lang mkey='header' skey='account_overview'}</div>-->

<!--{lang mkey='account' skey='info1'}-->

<p> 

	{if $message != "" } {$message} {/if}
    
<br />
<div data-parent="#personal-info-panel-slider" id="personal-info" class="panel-slider" style="">
<div class="col-md-12 form-container edit-profile">
									<form action="" method="post" name="account_form" enctype="multipart/form-data" >
										
										<div class="form-group candidateimage">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Photo: <span class="form-required">*</span></label>
											<div class="col-xs-12 col-sm-12  col-md-9">
											
										{if $candidate_picture !="" }
										<img style="float:left;" class="thumbnail" src="{$baseurl}/assets/candidateprofile/{$candidate_picture}"  width="200px;"/>
										{/if}
    
							
							<input id="profilePicture" name="profilePicture" type="file" style="display:none">
<div class="input-append ">
<div id="photoCover"></div>
<a class="btn btn-default" onclick="$('input[id=profilePicture]').click();">Upload Picture</a>
</div>
 {literal}
<script type="text/javascript">
$('input[id=profilePicture]').change(function() {
$('#photoCover').html($(this).val());
});
</script>
{/literal}


											</div>
										</div>

										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">{lang mkey='label' skey='firstname'}: <span class="form-required">*</span></label>
											 
											 <input type="text" placeholder="" name="txt_fname"  value="{$fname}" class="col-xs-12 col-sm-12 col-md-9">
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Surname / Last Name: <span class="form-required">*</span></label>
											 
											 <input type="text" placeholder="" name="txt_sname"  value="{$sname}" class="col-xs-12 col-sm-12 col-md-9">
										</div>
										
									
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Address Line1: <span class="form-required">*</span></label>
											 <input type="text" placeholder="" name="txt_address"  value="{$address}" class="col-xs-12 col-sm-12 col-md-9">
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Address Line2: <span class="form-required">*</span></label>
											 <input type="text" placeholder="" name="txt_address"  value="{$address2}" class="col-xs-12 col-sm-12 col-md-9">
										</div>
											<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Zip / Postal Code: <span class="form-required">*</span></label>
											 <input type="text" placeholder=""onchange="fnGetLocationDetailFromZipFront()" name="txt_post_code"  value="{$post_code}" class="col-xs-12 col-sm-12 col-md-9">
										</div>
										
											<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">{lang mkey='label' skey='country'} <span class="form-required">*</span></label>
										  <select name="txt_country" id="txt_country" onchange="javascript: cascadeCountry(this.value,'txtstateprovince');" >
												{html_options options=$country selected=$smarty.session.loc.country}
										</select>
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">State / Province / Region: <span class="form-required">*</span></label>
											 {if $lang.states|@count > 0}
                <select class="select" name="txtstateprovince" id="txtstateprovince" onchange="javascript: cascadeState(this.value, this.form.txt_country.value,'txtcounty');" >
                {html_options options=$lang.states selected=$smarty.session.loc.stateprovince}
                </select>
            { else }
                <input class="text_field required col-xs-12 col-sm-12 col-md-9" name="txtstateprovince" id="txtstateprovince" type="text" value="{$smarty.session.loc.stateprovince}" />
           { /if} 
										</div>
										
										
											<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Mobile Telephone Number <span class="form-required">*</span></label>
											 <input type="text" placeholder="" name="txt_phone_number" value="{$phone_number}" class="col-xs-12 col-sm-12 col-md-9">
										</div>
										<input type="hidden" name="txt_email_address" class="" value="{$email_address}" size="35" disabled="disabled" />
										<div class="form-group">
											<div class="hidden-xs hidden-sm col-md-3"></div>
											<div class="col-xs-12 col-sm-12 col-md-9">
												<button class="btn btn-primary" type="submit" name="account_btn" value="{lang mkey='button' skey='save_my_profile'}">Save Changes</button>
												
											</div>
										</div>
									</form>
								</div>

</div>

