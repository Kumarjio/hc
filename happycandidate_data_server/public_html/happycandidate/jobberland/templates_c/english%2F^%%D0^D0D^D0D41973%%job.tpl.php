<?php /* Smarty version 2.6.26, created on 2015-11-23 18:06:46
         compiled from job.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'job.tpl', 4, false),array('modifier', 'strip_tags', 'job.tpl', 12, false),)), $this); ?>
<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<?php if (! $this->_tpl_vars['jobs']): ?>
	<div class="error"> <?php echo smarty_function_lang(array('mkey' => 'error','skey' => 'job_not_found'), $this);?>
</div>
	
<?php else: ?>

<div id="job_details">
<div id="job">
	<fieldset class="round ref_code">
      <div style="min-height:10px; padding:5px;">
        <div style="float:left;"><label><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'ref_code'), $this);?>
 </strong></label> <?php echo ((is_array($_tmp=$this->_tpl_vars['job_ref'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</div>
        <?php if (! $this->_tpl_vars['user_applied']): ?>
			<div style="float:right;">
			  <input name="bt_apply_online" type="button" id="bt_cmd" value=" <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'apply'), $this);?>
 "  class="button" 
					  onclick="javascript:window.location = '<?php echo $this->_tpl_vars['BASE_URL']; ?>
apply/<?php echo $this->_tpl_vars['var_name']; ?>
/?portid=<?php echo $this->_tpl_vars['intPortId']; ?>
';" />
			</div>
		<br />
		<?php else: ?>
			<div style="float:right;">
				<div style="float:left;width:auto;">
				  <input disabled="disabled" name="bt_apply_online" type="button" id="bt_cmd" value=" <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'apply'), $this);?>
 "  class="button" 
						  onclick="javascript:window.location = '<?php echo $this->_tpl_vars['BASE_URL']; ?>
apply/<?php echo $this->_tpl_vars['var_name']; ?>
';" />
				</div>
				<div>&nbsp;&nbsp;&nbsp;</div>
				<div style="float:left;width:auto;">
				  <input onClick="fnShowSetReminderForm();" name="set_interview_schedule" type="button" id="set_interview_schedule" value="Note Interview & Set Reminder"  class="button" />
				</div>
			</div>
			<br />
		<?php endif; ?>
      </div>
    </fieldset>
    
    <div class="clear">&nbsp;</div>
    <div>
        
        <div id="job_title"><?php echo ((is_array($_tmp=$this->_tpl_vars['job_title'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</div>
        <div class="application app">
            <?php if ($this->_tpl_vars['apply_count'] == 0): ?>0<?php else: ?> <?php echo $this->_tpl_vars['apply_count']; ?>
 <?php endif; ?>
                <p><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'applicants'), $this);?>
</p>
        </div>
        <div class="views_count app"><?php echo $this->_tpl_vars['views_count']; ?>

            <p><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'views'), $this);?>
</p>
        </div>
    </div>

    <div class="clear">&nbsp;</div>

    <div style="float:right;">
       <img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
images/company_logo/<?php echo $this->_tpl_vars['company_logo']; ?>
" alt="" class="companylogo" />
    </div>
    <div><?php echo $this->_tpl_vars['job_description']; ?>
</div>

    <div class="clear">&nbsp;</div>

<?php if ($this->_tpl_vars['job_requirenment'] != ""): ?>
	<div class="sub_header">Job Minimum Requirements</div>
	<div class="border_around">
	<table width="100%" >
		<tr>
			<td colspan="4">
				<?php echo $this->_tpl_vars['job_requirenment']; ?>

			</td>
		</tr>

	</table>
	</div>	
<?php endif; ?>

<div class="clear">&nbsp;</div>
 
<div class="sub_header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'additional_info'), $this);?>
</div>
<div class="border_around">
<table width="100%" >
    <tr>
        <td><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'location'), $this);?>
</strong></td>
        <td>
        				
			<a href="javascript:void(0);"><?php echo $this->_tpl_vars['country']; ?>
</a> |
            <a href="javascript:void(0);"><?php echo $this->_tpl_vars['state']; ?>
</a> |
            <a href="javascript:void(0);"><?php echo $this->_tpl_vars['county']; ?>
</a> |
            <a href="javascript:void(0);"><?php echo $this->_tpl_vars['city']; ?>
</a>
        </td>
        <td><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'start_date'), $this);?>
</strong> </td>
        <td><?php echo $this->_tpl_vars['start_date']; ?>
</td>
    </tr>

    <tr>
        <td><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'job_type'), $this);?>
</strong></td>
        <td> 
        <?php $_from = $this->_tpl_vars['jobtype']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
                        <a href="javascript:void(0);"><?php echo $this->_tpl_vars['i']['name']; ?>
</a><br />
        <?php endforeach; endif; unset($_from); ?>
        </td>
        <td><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'salary'), $this);?>
 </strong></td>
        <td><?php echo $this->_tpl_vars['job_salary']; ?>
</td>
    </tr>

    <tr>
        <td><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'career_level'), $this);?>
 </strong></td>
        <td>
        	<?php if ($this->_tpl_vars['careers'] != ''): ?>
        	          	  <a href="javascript:void(0);"><?php echo $this->_tpl_vars['career']; ?>
</a>
        	<?php else: ?>
            	<?php echo $this->_tpl_vars['career']; ?>

            <?php endif; ?>
        </td>
        <td><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'work_experience'), $this);?>
 </strong></td>
        <td>
        	<?php if ($this->_tpl_vars['experiences'] != ''): ?>
            	            	<a href="javascript:void(0);"><?php echo $this->_tpl_vars['experience']; ?>
</a>
            <?php else: ?>
            	<?php echo $this->_tpl_vars['experience']; ?>

            <?php endif; ?>
         </td>
    </tr>

    <tr>
        <td><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'education_level'), $this);?>
 </strong></td>
        <td>
          <?php if ($this->_tpl_vars['educations'] != ''): ?>
                        <a href="javascript:void(0);"><?php echo $this->_tpl_vars['education']; ?>
</a>
          <?php else: ?>
            <?php echo $this->_tpl_vars['education']; ?>

          <?php endif; ?>
        </td>
        <td><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'created_at'), $this);?>
</strong></td>
        <td><?php echo $this->_tpl_vars['created_at']; ?>
</td>
    </tr>

</table>
</div>

<br /><br />

<div class="sub_header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'contact_information'), $this);?>
</div>
<div class="border_around">
<table width="100%">
    <tr>
        <td><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'company_name'), $this);?>
</strong></td>
        <td>
						<a href="javascript:void(0);"><?php echo $this->_tpl_vars['company_name']; ?>
</a>
		</td>
        <td><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'company_tel_no'), $this);?>
</strong></td>
        <td><?php echo $this->_tpl_vars['contact_telephone']; ?>
</td>
    </tr>
    
    <tr>
        <td><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'company_contact_name'), $this);?>
</strong></td>
        <td><?php echo $this->_tpl_vars['contact_name']; ?>
</td>
        <td><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'company_site_link'), $this);?>
</strong></td>
        <td><?php echo $this->_tpl_vars['site_link']; ?>
</td>
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
<input name="bt_share" type="button" id="bt_cmd" value=" <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'share_with_friends'), $this);?>
 "  class="button" onclick="redirect_to( '<?php echo $this->_tpl_vars['BASE_URL']; ?>
share/<?php echo $this->_tpl_vars['var_name']; ?>
/?portid=<?php echo $this->_tpl_vars['intPortId']; ?>
');" /> &nbsp; &nbsp; &nbsp; &nbsp;
<?php if ($this->_tpl_vars['user_id']): ?>
	<input name="bt_share_fb" type="button" id="bt_cmd" value="Share on Facebook"  onclick="fnShareOnFb();" class="button" /> &nbsp; &nbsp; &nbsp; &nbsp;
	<input name="bt_share_tw" type="button" id="bt_cmd" value="Tweet on Twitter"  onclick="fnTweetOnTwitter();" class="button" /> &nbsp; &nbsp; &nbsp; &nbsp;
	<input name="bt_share_li" type="button" id="bt_cmd" value="Share on LinkedIn"  onclick="fnShareOnLinkedIn();" class="button" /> &nbsp; &nbsp; &nbsp; &nbsp;
<?php endif; ?>
<?php if (! $this->_tpl_vars['user_applied']): ?>
	<input name="bt_apply_online" type="button" id="bt_cmd" value=" <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'apply_online'), $this);?>
"  class="button" onclick="redirect_to( '<?php echo $this->_tpl_vars['BASE_URL']; ?>
apply/<?php echo $this->_tpl_vars['var_name']; ?>
/?portid=<?php echo $this->_tpl_vars['intPortId']; ?>
');" /> &nbsp; &nbsp; &nbsp; &nbsp;
<?php else: ?>
	<input disabled="disabled" name="bt_apply_online" type="button" id="bt_cmd" value=" <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'apply_online'), $this);?>
"  class="button" onclick="redirect_to( '<?php echo $this->_tpl_vars['BASE_URL']; ?>
apply/<?php echo $this->_tpl_vars['var_name']; ?>
/?portid=<?php echo $this->_tpl_vars['intPortId']; ?>
');" /> &nbsp; &nbsp; &nbsp; &nbsp;
	<input onClick="fnShowSetReminderForm();" name="set_interview_schedule" type="button" id="set_interview_schedule" value="Note Interview & Set Reminder"  class="button" /> &nbsp; &nbsp; &nbsp; &nbsp;
<?php endif; ?>

<input name="bt_print" type="button" id="bt_cmd" value=" <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'print_this_job'), $this);?>
 "  class="button" onclick="print_job('job_details');" />

</div>
 <br />
 <?php echo $this->_tpl_vars['interview_popup']; ?>

<?php endif; ?>

<?php echo '
<script type="text/javascript">
	function fnShareOnFb()
	{
		var strFbLibBaseUrl = \''; ?>
<?php echo $this->_tpl_vars['BASE_URL']; ?>
<?php echo 'check_get_set_user_details.php?page=job&pageid='; ?>
<?php echo $this->_tpl_vars['intJobId']; ?>
<?php echo '&portid='; ?>
<?php echo $this->_tpl_vars['intPortId']; ?>
<?php echo '\';
		//alert(strFbLibBaseUrl);
		window.open(strFbLibBaseUrl,\'Login\',\'width=500,height=500\');
	}
	
	function fnTweetOnTwitter()
	{
		var strTwillterLibBaseUrl = \''; ?>
<?php echo $this->_tpl_vars['BASE_URL']; ?>
<?php echo 'twitter_job_sharerer.php?page=job&pageid='; ?>
<?php echo $this->_tpl_vars['intJobId']; ?>
<?php echo '&portid='; ?>
<?php echo $this->_tpl_vars['intPortId']; ?>
<?php echo '\';
		//alert(strTwillterLibBaseUrl);
		//return false;
		window.open(strTwillterLibBaseUrl,\'Login\',\'width=500,height=500\');
	}
	
	function fnShareOnLinkedIn()
	{
		var strLinkedInBaseUrl = \''; ?>
<?php echo $this->_tpl_vars['BASE_URL']; ?>
<?php echo 'linkedin_job_sharerer.php?page=job&pageid='; ?>
<?php echo $this->_tpl_vars['intJobId']; ?>
<?php echo '&portid='; ?>
<?php echo $this->_tpl_vars['intPortId']; ?>
<?php echo '\';
		//alert(strTwillterLibBaseUrl);
		//return false;
		window.open(strLinkedInBaseUrl,\'Login\',\'width=500,height=500\');
	}
	
</script>
'; ?>

