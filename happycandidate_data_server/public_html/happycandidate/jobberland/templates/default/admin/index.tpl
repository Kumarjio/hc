{include file="admin/page_header.tpl"}
{strip}

<body dir="{lang mkey='DIRECTION'}"><div id="main_table"><div id="page-title">	<h3>{$pagetitle}</h3></div>
<table id="main_tb" width="100%">

    <colgroup>
        <col width="20%;" />
        <col />
    </colgroup>

  {*<tr>
    <td colspan="2">{include file="admin/index_top.tpl"}</td>
  </tr>*}
  
  <tr>
  	{if isset($leftmenu)}
		<td valign="top"> 	<div class="main_left_col">
			{$leftmenu}
			{*{if isset($smarty.session.access_level) && $smarty.session.access_level == 'Admin' && $smarty.session.user_id != '' && isset($smarty.session.user_id) }
			{include file="admin/left_menu.tpl"}
			{/if}*}
			</div>
		</td>
	{/if}
    <td valign="top">		
       {$rendered_page}
    </td>
  </tr>

  {*<tr>
    <td colspan="2">

		<div>&nbsp;</div>
		<div id="Poweredby" align="center"><a href="http://jobberland.com/" target="_blank" >Powered by Jobberland &copy; 
		{$smarty.now|date_format:'%Y'}
		</a></div>
		<div>&nbsp;</div>

    </td>
  </tr>*}
</table></div>
<script language="javascript" type="text/javascript" src="{$HCJQUERYPATH}jquery-1.7.2.min.js"></script>
<script language="javascript" type="text/javascript" src="{$HCJSPATH}common.js"></script>
<script language="javascript" type="text/javascript" src="{$DOC_ROOT}javascript/cascade.js"></script>
</body>
</html>
{/strip}