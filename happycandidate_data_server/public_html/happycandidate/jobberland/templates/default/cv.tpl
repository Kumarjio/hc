
{strip}


	<div class="tab-row-container">
	
							<div class="panel panel-default hidden-xs hidden-sm">
							  	<div class="panel-heading user-references">
									<table>
										<tr>
											<th>&nbsp;</th>
											<th>{lang mkey='label' skey='name'}</th>
											<th >{lang mkey='label' skey='ac_status'}</th>
											<th>{lang mkey='label' skey='created'}</th>
											<th>{lang mkey='label' skey='last_modified'}</th>
											<th>{lang mkey='label' skey='total_views'}</th>
											<th>{lang mkey='label' skey='default_cv'}</th>
											<th>{lang mkey='label' skey='actions'}</th>
											
										</tr>
									</table>
							  	</div>
							 	<div class="panel-body user-references">
							 		<table>
									
									{foreach from=$my_cvs key=k item=i}
    <tr>
	<td></td>
        
		<td>
												<div class="user-title">
													<a href="#reference1-options{$i.id}" id="reference1" class="username-clickable">{$i.cv_title}</a>
												</div>
												<div id="reference1-options{$i.id}" class="user-options">
													<a href="{$BASE_URL}curriculum_vitae/rename/{$i.id}/?portid={$intPortId}" target="_self">{lang mkey='account' skey='link_rename'}</a> 
													
												<!--	<a href="{$BASE_URL}curriculum_vitae/copy/{$i.id}/?portid={$intPortId}" target="_self" 
                     onclick="return confirm_message('{lang mkey="copy_cv"}');">{lang mkey='account' skey='link_copy'}</a> |-->

					
					{if $i.default_cv == "N"}
					| <a href="{$BASE_URL}curriculum_vitae/default/{$i.id}/?portid={$intPortId}" >{lang mkey='account' skey='link_default'}</a> 
				  {/if}
				 <!-- <a href="{$BASE_URL}curriculum_vitae/resume/{$i.id}/review/?portid={$intPortId}">{lang mkey='account' skey='link_rv'}</a>-->
												</div>
											</td>
		
        <td>{$i.cv_status|upper}{*capitalize*}</td>
        <td>{$i.created_at}</td>
        <td>{$i.modified_at}</td>
        <td>{$i.no_views}</td>
        <td>{if $i.default_cv == "Y"}<img src="{$skin_images_path}tick.gif" alt="" />{/if}</td>
		<td><a href="{$BASE_URL}curriculum_vitae/download/{$i.id}/?portid={$intPortId}" target="_self">{lang mkey='account' skey='link_download'}</a> | 					 <a href="{$BASE_URL}curriculum_vitae/delete/{$i.id}/?portid={$intPortId}" 
                    onclick="return confirm_message('{lang mkey="deletecv"}');">{lang mkey='account' skey='link_delete'}</a> | <a href="{$BASE_URL}curriculum_vitae/resume/{$i.id}/change/?portid={$intPortId}">{lang mkey='account' skey='link_change_status'}</a></td>
		</td>
										<tr>
										{/foreach}
											
										
										
									
										
									</table>
							 	</div>
							 
							</div>

							
						</div>
					
<!--
<table width="100%" cellpadding="1" cellspacing="0" class="manage_cv" >

    
    <tr class="highlight_tr">
        <td>&nbsp;{lang mkey='label' skey='name'}</td>
        <td>{lang mkey='label' skey='ac_status'}</td>
        <td>{lang mkey='label' skey='created'}</td>
        <td>{lang mkey='label' skey='last_modified'}</td>
        <td>{lang mkey='label' skey='total_views'}</td>
        <td>{lang mkey='label' skey='default_cv'}</td>
        <td>{lang mkey='label' skey='actions'}</td>
    </tr>
    
{foreach from=$my_cvs key=k item=i}
    <tr>
        <td><a href="{$BASE_URL}curriculum_vitae/rename/{$i.id}/?portid={$intPortId}">{$i.cv_title}</a></td>
        <td>{$i.cv_status|upper}{*capitalize*}</td>
        <td>{$i.created_at}</td>
        <td>{$i.modified_at}</td>
        <td>{$i.no_views}</td>
        <td>{if $i.default_cv == "Y"}<img src="{$skin_images_path}tick.gif" alt="" />{/if}</td>
        <td>
          <div id="menu_nav">
            <ul>
              <li><a href="#">{lang mkey='label' skey='actions'}</a>
                <ul>
                  <li><a href="{$BASE_URL}curriculum_vitae/rename/{$i.id}/?portid={$intPortId}" target="_self">{lang mkey='account' skey='link_rename'}</a></li>
                  <li><a href="{$BASE_URL}curriculum_vitae/download/{$i.id}/?portid={$intPortId}" target="_self">{lang mkey='account' skey='link_download'}</a></li>
                  <li><a href="{$BASE_URL}curriculum_vitae/copy/{$i.id}/?portid={$intPortId}" target="_self" 
                     onclick="return confirm_message('{lang mkey="copy_cv"}');">{lang mkey='account' skey='link_copy'}</a></li>
                  <li><a href="{$BASE_URL}curriculum_vitae/delete/{$i.id}/?portid={$intPortId}" 
                    onclick="return confirm_message('{lang mkey="deletecv"}');">{lang mkey='account' skey='link_delete'}</a></li>
                  <li><a href="{$BASE_URL}curriculum_vitae/resume/{$i.id}/change/?portid={$intPortId}">{lang mkey='account' skey='link_change_status'}</a></li>
				  {if $i.default_cv == "N"}
					<li><a href="{$BASE_URL}curriculum_vitae/default/{$i.id}/?portid={$intPortId}" >{lang mkey='account' skey='link_default'}</a></li>
				  {/if}
                  <li><a href="{$BASE_URL}curriculum_vitae/resume/{$i.id}/review/?portid={$intPortId}">{lang mkey='account' skey='link_rv'}</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </td>
    </tr>
{/foreach}

</table>-->
<p>
<a href="{$BASE_URL}curriculum_vitae/add/?portid={$intPortId}">{lang mkey='account' skey='link_new_cv' }</a></p>
{/strip}

<script language="JavaScript" type="text/javascript">
{literal}
$(".panel-body .user-title a").click(function(event) {
				$(this.getAttribute("href")).css('display', 'inline-block');
			});
{/literal}
</script>