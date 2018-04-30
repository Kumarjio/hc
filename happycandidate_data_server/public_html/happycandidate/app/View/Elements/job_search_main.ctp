<script type="text/javascript">
	$(document).ready(function () {
		$('#advance_search').click(function () {
			$('.advance_search').fadeToggle('slow');
			$('#advance_search').fadeToggle('slow');
			$('#short_search').fadeToggle('slow');
			$('#adv_search').val('1');
		});
		
		$('#short_search').click(function () {
			$('.advance_search').fadeToggle('slow');
			$('#advance_search').fadeToggle('slow');
			$('#short_search').fadeToggle('slow');
			$('#adv_search').val('0');
		});
		
		$("#portal_search").validationEngine();
	});
	
	function checkStrLength(field, rules, i, options)
	{
		var strField = field.val();
		strField = strField.replace(/\+/g, ""); 
		strField = strField.replace(/\"/g, ""); 
		strField = strField.replace(/\-/g, ""); 
		strField = strField.replace(/\~/g, ""); 
		strField = strField.replace(/\*/g, "");
		
		var intLength = parseInt(strField.length);
		if(intLength<4)
		{
			return "You Need to Provide atleast 4 Characters in your Keyword";
		}
		
		/*if (field.val() != "HELLO") 
		{
			// this allows the use of i18 for the error msgs
			return options.allrules.validate2fields.alertText;
		}*/
	}
</script>
<?php
	echo $this->Html->script('search_add');
?>
<!--Start Search -->
<?php
	if(isset($strHidden))
	{
		?>
			<div id="jop_search" class="jop_search" style="display:none;">
		<?php
	}
	else
	{
		?>
			<div id="jop_search" class="jop_search">
		<?php
	}
?>
	<div class="wrapper">
		<h2>Search</h2>
		<?php
			$strPortalSearchUrl = Router::url(array('controller'=>'portal','action'=>'jobsearch',$intPortalId),true);
		?>
		<form name="portal_search" id="portal_search" method="post" action="<?php echo $strPortalSearchUrl; ?>">
		<ul class="panel-2 margin-top-5">
			<li><label>Job Title, Keywords</label>
			<input type="text" class="validate[funcCall[checkStrLength]]" name="keywords" id="keywords" placeholder="Salesperson, Accountant, Nurse" value="<?php echo $strKeywords; ?>" />
			<!--<input type="hidden" name="txt_country" id="txt_country"  value="IN" />-->
			</li>
			<li class="advance_search" style="display:none;"><label>Search Type</label>
				<!--<input type="radio" name="search_type" id="search_type_all" value="All Words" /> All Words&nbsp;
				<input type="radio" name="search_type" id="search_type_any" value="Any Words" /> Any Words&nbsp;
				<input type="radio" name="search_type" id="search_type_exact" value="Exact Phrase" /> Exact Phrase-->
				<?php 
					$arrSearchType = array();
					$arrSearchType['0'] = 'Default';
					$arrSearchType['1'] = 'Any Words';
					$arrSearchType['2'] = 'Exact Phrase';
					$arrSearchType['3'] = 'All Words';
					echo $this->Form->input('search_type',array('label'=>false,'div'=>false,'id'=>'type','options'=>$arrSearchType,'selected'=>'0'));
				?>
				<input type="hidden" name="adv_search" id="adv_search" value="0" />
			</li>
			<li class="advance_search" style="display:none;"><label>Location</label>
			<input type="text" name="location" id="location" placeholder="City Name" value="<?php echo $strlocation; ?>" />
			</li>
			<li class="advance_search" style="display:none;"><label>Country</label>
				<?php 
					echo $this->Form->input('txt_country',array('label'=>false,'div'=>false,'id'=>'txt_country','options'=>$arrJcountry,'selected'=>'IN'));
				?>
			</li>
			<li class="advance_search" style="display:none;"><label>Job Category</label>
			<?php 
				echo $this->Form->input('category',array('label'=>false,'div'=>false,'id'=>'category','options'=>$arrJcategories,'selected'=>'0'));
			?>
			</li>
			<li class="advance_search" style="display:none;"><label>Exp.</label>
			<?php 
				echo $this->Form->input('experience',array('label'=>false,'div'=>false,'id'=>'experience','options'=>$arrJobExperience,'selected'=>'0'));
			?>
			</li>
			<li class="advance_search" style="display:none;"><label>Job Type</label>
			<?php 
				$arrType = array();
				$arrType['0'] = 'Select Type';
				$arrType['1'] = 'Full-Time';
				$arrType['2'] = 'Part-Time';
				$arrType['3'] = 'Per Day';
				echo $this->Form->input('job_type',array('label'=>false,'div'=>false,'id'=>'type','options'=>$arrType,'selected'=>'0'));
			?>
			</li>
			<!--<li><label>Salary Expectation</label>
			<select>
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
			</select>
			</li>-->
			<li style="width:auto;">
				<input type="submit" value="Search"/>
			</li>
			<li id="advance_search" style="width:auto;">
				<a href="javascript:void(0);">Advance Search</a>
			</li>
			<li id="short_search" style="display:none;width:auto;">
				<a href="javascript:void(0);">Basic Search</a>
			</li>
		</ul>
		</form>
	</div>
</div>