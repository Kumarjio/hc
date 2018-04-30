<script type="text/javascript">
	$(document).ready(function() {
	
		$('#add_reference').click(function () {
			var isFormValidated = $("#reference_add_edit").validationEngine('validate');			
			if(isFormValidated == false)
			{
				return false;
			}
			else
			{
				$('#loader').show();
				var strRefName = $('#reference_name').val();
				var strRefJobTitle = $('#job_title').val();
				var strRefCompanyName = $('#company_name').val();
				var strRefTeleNumber = $('#tele_number').val();
				var strRefCellNumber = $('#cell_number').val();
				var strRefEmailAdd = $('#email_address').val();
				var strEditModeId = $('#edit_reference_id').val();
				
				var referenceformurl = "<?php echo Router::url('/', true).$this->params['controller']."/modify/".$this->params['pass']['0'];?>";
				var referenceformtype = "POST";
				var referenceformoptions = { 
					beforeSubmit:  function(formData, jqForm, options) {
					},
					success:function(responseText, statusText, xhr, $form) {
						//alert(responseText);
						if(responseText.status == "success")
						{
							$('#loader').hide();
							if(strEditModeId != "")
							{
								$('#ref_name_'+strEditModeId).html(strRefName);
								$('#ref_title_'+strEditModeId).html(strRefJobTitle);
								$('#ref_cname_'+strEditModeId).html(strRefCompanyName);
								$('#ref_telenumber_'+strEditModeId).html(strRefTeleNumber);
								$('#ref_phnumber_'+strEditModeId).html(strRefCellNumber);
								$('#ref_email_'+strEditModeId).html(strRefEmailAdd);
							}
							else
							{
								var strRowElementName = "<td id='ref_name_"+responseText.createdid+"'>"+strRefName+"</td>";
								var strRowElementJobTitle = "<td style='display:none;' id='ref_title_"+responseText.createdid+"'>"+strRefJobTitle+"</td>";
								var strRowElementCompanyName = "<td style='display:none;' id='ref_cname_"+responseText.createdid+"'>"+strRefCompanyName+"</td>";
								var strRowElementTeleNumber = "<td id='ref_telenumber_"+responseText.createdid+"'>"+strRefTeleNumber+"</td>";
								var strRowElementCellNumber = "<td id='ref_phnumber_"+responseText.createdid+"'>"+strRefCellNumber+"</td>";
								var strRowElementEmailAdd = "<td id='ref_email_"+responseText.createdid+"'>"+strRefEmailAdd+"</td>";
								
								//var strRefRow = "<tr>"+strRowElementName+strRowElementJobTitle+strRowElementCompanyName+strRowElementTeleNumber+strRowElementCellNumber+strRowElementEmailAdd+"</tr>";
								var strRefRow = "<tr id='ref_row_"+responseText.createdid+"'>"+strRowElementName+strRowElementJobTitle+strRowElementCompanyName+strRowElementEmailAdd+strRowElementTeleNumber+strRowElementCellNumber+"<td><a href='javascript:void(0);' onclick=fnRemoveRef('"+responseText.createdid+"')>Remove</a>&nbsp;<a href='#create_ref_heading' onclick=fnEditRef('"+responseText.createdid+"')>Edit</a></td>"+"</tr>";
								
								$('#reference_rows').append(strRefRow).fadeIn('slow');
							}
							
							$('#reference_operation_message').css('color','green');
							$('#reference_operation_message').html(responseText.message);
							$('#reference_operation_message').fadeIn('slow');
							
							$('#no_ref_row').fadeOut('slow');
							
							$('#reference_name').val('');
							$('#job_title').val('');
							$('#company_name').val('');
							$('#tele_number').val('');
							$('#cell_number').val('');
							$('#email_address').val('');
							$('#edit_reference_id').val('');
						}
						else
						{
							
							$('#reference_operation_message').css('color','red');
							$('#reference_operation_message').html(responseText.message);
							$('#reference_operation_message').fadeIn('slow');
						}
						
					},								
					url:       referenceformurl,         // override for form's 'action' attribute 
					type:      referenceformtype,        // 'get' or 'post', override for form's 'method' attribute 
					dataType:  'json'        			// 'xml', 'script', or 'json' (expected server response type) 
				}
				$('#reference_add_edit').ajaxSubmit(referenceformoptions);
				return false;
			}
		});
	});
	
	function fnEditRef(refid)
	{
		var strRefName = $('#ref_name_'+refid).html();
		var strReJTitle = $('#ref_title_'+refid).html();
		var strReCname = $('#ref_cname_'+refid).html();
		var strReTeleNumber = $('#ref_telenumber_'+refid).html();
		var strReCellNumber = $('#ref_phnumber_'+refid).html();
		var strReEmailAdd = $('#ref_email_'+refid).html();
		
		
		$('#reference_name').val(strRefName);
		$('#job_title').val(strReJTitle);
		$('#company_name').val(strReCname);
		$('#tele_number').val(strReTeleNumber);
		$('#cell_number').val(strReCellNumber);
		$('#email_address').val(strReEmailAdd);
		
		$('#add_reference').val('Edit Reference');
		$('#edit_reference_id').val(refid);
		//alert("HI");
	}
	
	function fnRemoveRef(refid)
	{
		var cand_ref_id = refid;
		var datastr = 'can_ref_id='+cand_ref_id;
		var cand_ref_del_url = '<?php echo Router::url(array('controller'=>'references','action'=>'removeref',$intPortalId),true); ?>'
		$.ajax({ 
				type: "POST",
				url: cand_ref_del_url,
				data: datastr,
				cache: false,
				dataType: 'json',
				success: function(data)
				{
					
					if(data.delstatus == "success")
					{
						$('#ref_row_'+cand_ref_id).remove();
						$('#reference_operation_message').css('color','green');
						$('#reference_operation_message').html('');
						$('#reference_operation_message').html(data.message);
						$('#reference_operation_message').fadeIn('slow');
						
						if(data.remainingref == "0")
						{
							$('#no_ref_row').fadeIn();
						}
					}
					else
					{
						$('#reference_operation_message').css('color','red');
						$('#reference_operation_message').html(data.message);
						$('#reference_operation_message').fadeIn('slow');
					}
				}
		});
	}
</script>

<div class="jop_search" id="jop_search">
<h2 id="create_ref_heading" style="background:none;padding:0;">Create Reference</h2>
<?php
	$strPortalSearchUrl = Router::url(array('controller'=>'portal','action'=>'jobsearch',$intPortalId),true);
?>
<form name="reference_add_edit" id="reference_add_edit"">
<ul class="panel-2 margin-top-5">
	<li><label>Name:</label>
		<input type="text" class="validate[custom[onlyLetterSp]]" name="reference_name" id="reference_name" placeholder="Refrence Name" value="" />
		<input type="hidden" name="edit_reference_id" id="edit_reference_id" value="" />
	</li>
	<li class="advance_search"><label>Job Title:</label>
		<input type="text" class="validate[custom[onlyLetterSp]]" name="job_title" id="job_title" value="" />
	</li>
	<li class="advance_search"><label>Company Name:</label>
		<input type="text" class="validate[custom[onlyLetterSp]]" name="company_name" id="company_name" value="" />
	</li>
	<li class="advance_search"><label>Telephone Number:</label>
		<input type="text" class="validate[custom[number]]" name="tele_number" id="tele_number" value="" />
	</li>
	<li class="advance_search"><label>Cell Phone Number:</label>
		<input type="text" class="validate[custom[number]]" name="cell_number" id="cell_number" value="" />
	</li>
	<li class="advance_search"><label>Email Address:</label>
		<input type="text" class="validate[custom[email]]" name="email_address" id="email_address" value="" />
	</li>
	<li style="width:auto;">
		<input type="submit" id="add_reference" value="Add Reference"/>
	</li>
	<li style="width:auto;">
		<input type="reset"  class="button_class" value="Reset"/>
	</li>
	<li style="width:auto;display:none;" id="loader">
		<img src="<?php echo Router::url('/',true);?>/img/loader.gif" alt="Loader" title="Loader" />
	</li>
</ul>
</form>
</div>
<div>&nbsp;</div>
<div id="reference_operation_message" style="display:none;">Reference Created Successfully!</div>
<div>&nbsp;</div>
<div class="jop_search" id="jop_search">
<h2 style="background:none;padding:0;">Reference List</h2>
<table class="panel-2 margin-top-5">
	<tr>
		<th><label>Name</label></th>
		<th><label>Email Address</label></th>
		<th style="display:none;"><label>Job Title</label></th>
		<th style="display:none;"><label>Company Name</label></th>
		<th><label>Telephone Number</label></th>
		<th><label>Cell Number</label></th>
		<th><label>Action</label></th>
	</tr>
	<tr>
		<th colspan="7">&nbsp;</th>
	</tr>
	<tbody id="reference_rows">
<?php
	if(is_array($arrCandidateReferenceDetail) && (count($arrCandidateReferenceDetail)>0))
	{
		foreach($arrCandidateReferenceDetail as $arrRefDetail)
		{
			?>
				<tr id="ref_row_<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>">
					<td id="ref_name_<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>"><?php echo $arrRefDetail['CandidateReferences']['reference_name'];?></td>
					<td style="display:none;" id="ref_title_<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>"><?php echo $arrRefDetail['CandidateReferences']['reference_job_title'];?></td>
					<td style="display:none;" id="ref_cname_<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>"><?php echo $arrRefDetail['CandidateReferences']['reference_company_name'];?></td>
					<td id="ref_email_<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>"><?php echo $arrRefDetail['CandidateReferences']['reference_email_address'];?></td>
					<td id="ref_telenumber_<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>"><?php echo $arrRefDetail['CandidateReferences']['reference_tele_number'];?></td>
					<td id="ref_phnumber_<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>"><?php echo $arrRefDetail['CandidateReferences']['reference_phone_number'];?></td>
					<td><a href="javascript:void(0);" onclick="fnRemoveRef('<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id']; ?>');">Remove</a>&nbsp;<a href="#create_ref_heading" onclick="fnEditRef('<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id']; ?>')">Edit</a>&nbsp;<!--<span id="inline_loader"><img src="<?php echo Router::url('/',true);?>/img/loadernew.gif" alt="Loader" title="Loader" /></span>--></td>
				</tr>
			<?php
		}
		?>
			<tr id="no_ref_row" style="display:none;">
				<td colspan="7"><label>No Refrences added yet, Please create your reference list through above form</label></td>
			</tr>
			<!--<li id="no_ref_row" style="width:100%;margin-right:0px;text-align:center;"><label>No Refrences added yet, Please create your reference list through above form</label></li>-->
		<?php
	}
	else
	{
		
		?>
			<tr id="no_ref_row">
				<td colspan="7"><label>No Refrences added yet, Please create your reference list through above form</label></td>
			</tr>
			<!--<li id="no_ref_row" style="width:100%;margin-right:0px;text-align:center;"><label>No Refrences added yet, Please create your reference list through above form</label></li>-->
		<?php
	}
?>
</tbody>
</table>
</div>