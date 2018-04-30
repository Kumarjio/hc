{if $message != "" } {$message} {/if}

{if !$jobs}
	<div class="error"> {lang mkey='error' skey='job_not_found' }</div>
	
{else}

<div id="job_details">
<div id="job">
	<fieldset class="round ref_code">
      <div style="min-height:10px; padding:5px;">
        <div style="float:left;"><label><strong>{lang mkey='label' skey='ref_code'} </strong></label> {$job_ref|strip_tags}</div>
        {if !$user_applied}
			<div style="float:right;">
			  <input name="bt_apply_online" type="button" id="bt_cmd" value=" {lang mkey='button' skey='apply'} "  class="button" 
					  onclick="javascript:window.location = '{$BASE_URL}apply/{$var_name}/?portid={$intPortId}';" />
			</div>
		<br />
		{else}
			<div style="float:right;">
				<div style="float:left;width:auto;">
				  <input disabled="disabled" name="bt_apply_online" type="button" id="bt_cmd" value=" {lang mkey='button' skey='apply'} "  class="button" 
						  onclick="javascript:window.location = '{$BASE_URL}apply/{$var_name}';" />
				</div>
				<div>&nbsp;&nbsp;&nbsp;</div>
				<div style="float:left;width:auto;">
				  <input onClick="fnShowSetReminderForm();" name="set_interview_schedule" type="button" id="set_interview_schedule" value="Note Interview & Set Reminder"  class="button" />
				</div>
			</div>
			<br />
		{/if}
      </div>
    </fieldset>
    
    <div class="clear">&nbsp;</div>
    <div>
        
        <div id="job_title">{$job_title|strip_tags}</div>
        <div class="application app">
            {if $apply_count == 0 }0{else} {$apply_count} {/if}
                <p>{lang mkey='label' skey='applicants' }</p>
        </div>
        <div class="views_count app">{$views_count}
            <p>{lang mkey='label' skey='views'}</p>
        </div>
    </div>

    <div class="clear">&nbsp;</div>

    <div style="float:right;">
       <img src="{$BASE_URL}images/company_logo/{$company_logo}" alt="" class="companylogo" />
    </div>
    <div>{$job_description}</div>

    <div class="clear">&nbsp;</div>

{if $job_requirenment != ""}
	<div class="sub_header">Job Minimum Requirements</div>
	<div class="border_around">
	<table width="100%" >
		<tr>
			<td colspan="4">
				{$job_requirenment}
			</td>
		</tr>

	</table>
	</div>	
{/if}

<div class="clear">&nbsp;</div>
 
<div class="sub_header">{lang mkey='header' skey='additional_info'}</div>
<div class="border_around">
<table width="100%" >
    <tr>
        <td><strong>{lang mkey='label' skey='location'}</strong></td>
        <td>
        	{*<a href="{$BASE_URL}location/{$country_url}">{$country}</a> |
            <a href="{$BASE_URL}location/{$state_url}">{$state}</a> |
            <a href="{$BASE_URL}location/{$county_url}">{$county}</a> |
            <a href="{$BASE_URL}location/{$city_url}">{$city}</a>*}
			
			<a href="javascript:void(0);">{$country}</a> |
            <a href="javascript:void(0);">{$state}</a> |
            <a href="javascript:void(0);">{$county}</a> |
            <a href="javascript:void(0);">{$city}</a>
        </td>
        <td><strong>{lang mkey='label' skey='start_date'}</strong> </td>
        <td>{$start_date}</td>
    </tr>

    <tr>
        <td><strong>{lang mkey='label' skey='job_type'}</strong></td>
        <td> 
        {foreach from=$jobtype item=i key=k}
            {*<a href="{$BASE_URL}search_result/?job_type={$i.var_name}">{$i.name}</a><br />*}
            <a href="javascript:void(0);">{$i.name}</a><br />
        {/foreach}
        </td>
        <td><strong>{lang mkey='label' skey='salary'} </strong></td>
        <td>{$job_salary}</td>
    </tr>

    <tr>
        <td><strong>{lang mkey='label' skey='career_level'} </strong></td>
        <td>
        	{if $careers != '' }
        	  {*<a href="{$BASE_URL}search_result/?career={$career_var_name}">{$career}</a>*}
        	  <a href="javascript:void(0);">{$career}</a>
        	{else}
            	{$career}
            {/if}
        </td>
        <td><strong>{lang mkey='label' skey='work_experience'} </strong></td>
        <td>
        	{if $experiences != '' }
            	{*<a href="{$BASE_URL}search_result/?experience={$experience_var_name}">{$experience}</a>*}
            	<a href="javascript:void(0);">{$experience}</a>
            {else}
            	{$experience}
            {/if}
         </td>
    </tr>

    <tr>
        <td><strong>{lang mkey='label' skey='education_level'} </strong></td>
        <td>
          {if $educations != '' }
            {*<a href="{$BASE_URL}search_result/?education={$education_var_name}">{$education}</a>*}
            <a href="javascript:void(0);">{$education}</a>
          {else}
            {$education}
          {/if}
        </td>
        <td><strong>{lang mkey='label' skey='created_at'}</strong></td>
        <td>{$created_at}</td>
    </tr>

</table>
</div>

<br /><br />

<div class="sub_header">{lang mkey='header' skey='contact_information'}</div>
<div class="border_around">
<table width="100%">
    <tr>
        <td><strong>{lang mkey='label' skey='company_name'}</strong></td>
        <td>
			{*<a href="{$BASE_URL}company/{$employer_var_name}/">{$company_name}</a>*}
			<a href="javascript:void(0);">{$company_name}</a>
		</td>
        <td><strong>{lang mkey='label' skey='company_tel_no'}</strong></td>
        <td>{$contact_telephone}</td>
    </tr>
    
    <tr>
        <td><strong>{lang mkey='label' skey='company_contact_name'}</strong></td>
        <td>{$contact_name}</td>
        <td><strong>{lang mkey='label' skey='company_site_link'}</strong></td>
        <td>{$site_link}</td>
    </tr>

    <tr>
        <td colspan="4" class="bottom_additional">&nbsp;</td>
    </tr>

</table>
</div>
</div>
</div>

<br />
<div>
<input name="bt_share" type="button" id="bt_cmd" value=" {lang mkey='button' skey='share_with_friends'} "  class="button" onclick="redirect_to( '{$BASE_URL}share/{$var_name}/?portid={$intPortId}');" /> &nbsp; &nbsp; &nbsp; &nbsp;
{if $user_id}
	<input name="bt_share_fb" type="button" id="bt_cmd" value="Share on Facebook"  onclick="fnShareOnFb();" class="button" /> &nbsp; &nbsp; &nbsp; &nbsp;
	<input name="bt_share_tw" type="button" id="bt_cmd" value="Tweet on Twitter"  onclick="fnTweetOnTwitter();" class="button" /> &nbsp; &nbsp; &nbsp; &nbsp;
	<input name="bt_share_li" type="button" id="bt_cmd" value="Share on LinkedIn"  onclick="fnShareOnLinkedIn();" class="button" /> &nbsp; &nbsp; &nbsp; &nbsp;
{/if}
{if !$user_applied}
	<input name="bt_apply_online" type="button" id="bt_cmd" value=" {lang mkey='button' skey='apply_online'}"  class="button" onclick="redirect_to( '{$BASE_URL}apply/{$var_name}/?portid={$intPortId}');" /> &nbsp; &nbsp; &nbsp; &nbsp;
{else}
	<input disabled="disabled" name="bt_apply_online" type="button" id="bt_cmd" value=" {lang mkey='button' skey='apply_online'}"  class="button" onclick="redirect_to( '{$BASE_URL}apply/{$var_name}/?portid={$intPortId}');" /> &nbsp; &nbsp; &nbsp; &nbsp;
	<input onClick="fnShowSetReminderForm();" name="set_interview_schedule" type="button" id="set_interview_schedule" value="Note Interview & Set Reminder"  class="button" /> &nbsp; &nbsp; &nbsp; &nbsp;
{/if}

<input name="bt_print" type="button" id="bt_cmd" value=" {lang mkey='button' skey='print_this_job'} "  class="button" onclick="print_job('job_details');" />

</div>
 <br />
 {$interview_popup}
{/if}

{literal}
<script type="text/javascript">
	function fnShareOnFb()
	{
		var strFbLibBaseUrl = '{/literal}{$BASE_URL}{literal}check_get_set_user_details.php?page=job&pageid={/literal}{$intJobId}{literal}&portid={/literal}{$intPortId}{literal}';
		//alert(strFbLibBaseUrl);
		window.open(strFbLibBaseUrl,'Login','width=500,height=500');
	}
	
	function fnTweetOnTwitter()
	{
		var strTwillterLibBaseUrl = '{/literal}{$BASE_URL}{literal}twitter_job_sharerer.php?page=job&pageid={/literal}{$intJobId}{literal}&portid={/literal}{$intPortId}{literal}';
		//alert(strTwillterLibBaseUrl);
		//return false;
		window.open(strTwillterLibBaseUrl,'Login','width=500,height=500');
	}
	
	function fnShareOnLinkedIn()
	{
		var strLinkedInBaseUrl = '{/literal}{$BASE_URL}{literal}linkedin_job_sharerer.php?page=job&pageid={/literal}{$intJobId}{literal}&portid={/literal}{$intPortId}{literal}';
		//alert(strTwillterLibBaseUrl);
		//return false;
		window.open(strLinkedInBaseUrl,'Login','width=500,height=500');
	}
	
</script>
{/literal}

