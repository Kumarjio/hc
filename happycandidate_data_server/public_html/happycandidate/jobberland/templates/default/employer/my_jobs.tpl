{if $message != "" } {$message} {/if}

{if $manage_list != '' }
{*<div class="page_header">{lang mkey='header' sey='my_jobs'}</div>*}<div class="page_header">Portal Jobs Details </div><br></br>
 <table width="100%" cellpadding="0" cellspacing="1" border="0" id="myjob">
    <colgroup>
        <col width="10%" />
        <col width="40%" />
        <col width="15%" />
        <col width="10%" />
        <col width="10%" />
        <col width="10%" />
    </colgroup>
    
   <tr class="myjob_header">
    <th class="left_black">{lang mkey='label' skey='JobId'}:</th>
    <th>{lang mkey='label' skey='job_title'}: </th>
	<th>Listing Type</th>
    <th>{lang mkey='label' skey='posted_on'}:</th>
    <th>{lang mkey='label' skey='NoofViews'}: </th>
    <th>{lang mkey='label' skey='NoofApp'}:</th>
    <th class="right_black">{lang mkey='label' skey='ApprovalStatus'}:</th>
  </tr>

{foreach from=$manage_list key=k item=i}
    <tr>
        <td ><strong> #{$i.id}</strong></td>
        <td>
            <a target="_blank" href="{$BASE_URL}job/{$i.var_name}/">{$i.job_title}</a>
            <br />            <br />
                <a class="tb_link" target="_blank" href="{$BASE_URL}job/{$i.id}/">{lang mkey='e_link' skey='view_details'}</a> | 
                <a class="tb_link" href="{$BASE_URL}employer/editjob/{$i.id}">{lang mkey='edit'}</a> | 
                <a class="tb_link" onclick="if ( !confirm('Are you sure you went to clone this job?\n\n'
                			 +' You currently have {if $i.spotlight == 'Y'} {$spotlight_credit} spotlight post {else} {$standard_credit} post {/if} credit(s)\n '
                			+'1 {if $i.spotlight == 'Y'} spotlight post {else} standard post {/if}credit will be used' ) ) return false;" 
                	href="?id={$i.id}&amp;action=clone">{lang mkey='e_link' skey='clone'}</a> | 
                {if $i.is_active == "Y" }
                <a class="tb_link" href="?id={$i.id}&amp;action=deactivate">{lang mkey='e_link' skey='deactivate'}</a> | 
                {else}
                 <a class="tb_link" href="?id={$i.id}&amp;action=activate">{lang mkey='e_link' skey='activate'}</a> |   
         		{/if}
                <a class="tb_link" onclick="if ( !confirm('Are you sure you went to delete this job?') ) return false;"
                    href="?id={$i.id}&amp;action=delete">{lang mkey="button" skey='delete'}</a> 
            <br />            <br />
        </td>
		<td>
			{if $i.spotlight eq "Y"}
				Spotlight Job
			{else}
				Standard Job
			{/if}
		</td>
        <td>{$i.created_at}</td>
        <td>{$i.views_count}</td>
        <td>{$i.apply_count}</td>
        <td>{$i.job_status}
        	<br />{$i.reason}
            {$i.admin_comments}
        </td>
    </tr>
{/foreach}
</table>
{else}
<div> {lang mkey='errormsg' skey=66} </div>
{/if}
