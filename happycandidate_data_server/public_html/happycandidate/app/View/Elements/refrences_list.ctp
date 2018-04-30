
						<div class="tab-header">
							<h3>References</h3><!--
							--><button class="btn btn-primary btn-sm" onclick="fnLoadRefrenceAdder()" type="button">Add New</button>&nbsp;
							<button class="btn btn-primary btn-sm" onclick="fnGetReferenceView()" type="button">View References</button>
								<input type='hidden' name='portal_id' id='portal_id' value='<?php echo $intPortalId; ?>' />	
						</div>
<?php echo $this->Session->flash(); ?>
						<!--<div class="tab-row-container">
							<div class="tab-filters">
								<a class="active" href="#">All <span>(5)</span></a> |
								<a class="link-warning" href="#">Trashed <span>(4)</span></a> |
								<a class="link-primary" href="#">Drafted <span>(1)</span></a>
							</div>
							<div class="tab-search">
								<input type="text" placeholder="Search" name="search" value="">
								<button class="btn btn-default btn-md" type="button">Search</button>
							</div>
						</div> -->
						<!-- USER REFERENCES LETTERS TOP CONTROLS -->
						<!--<div class="tab-row-container">
								<div class="tab-controls-actions">
									<div class="form-group">
										<select title="Bulk Actions" name="bulk-actions">
											<option value="value1">Bulk Action1</option>
											<option value="value2">Bulk Action2</option>
											<option value="value3">Bulk Action3</option>
											<option value="value4">Bulk Action4</option>
										</select>
										<button class="btn btn-default btn-md" type="button">Apply</button>
									</div>
									<div class="form-group">
										<select title="Date Filter" name="date-filter">
											<option value="value1">Date Filter1</option>
											<option value="value2">Date Filter2</option>
											<option value="value3">Date Filter3</option>
											<option value="value4">Date Filter4</option>
										</select>
										<button class="btn btn-default btn-md" type="button">Filter</button>
									</div>
								</div>
								<div class="tab-controls-pagination">
									<button class="btn btn-default disabled items-counter" type="button"><span>5 items</span></button>
									<button class="btn btn-default disabled goto-beginning" type="button"><span></span></button>
									<button class="btn btn-default disabled goto-previous" type="button"><span></span></button>
									<input type="text" placeholder="1" name="input-page-number" value="">
									<button class="btn btn-default disabled pages-counter" type="button"><span>of 3</span></button>
									<button class="btn btn-default goto-next-active" type="button"><span></span></button>
									<button class="btn btn-default goto-end-active" type="button"><span></span></button>
								</div>
						</div>-->
						<!-- USER REFERENCES LETTERS CONTENT -->
						<div class="tab-row-container">
							<div class="panel panel-default hidden-xs hidden-sm">
							  	<div class="panel-heading user-references">
									<table>
										<tbody><tr>
											<th><input type="checkbox" value=""></th>
											<th>Name</th>
											<th class="selected">Company<span></span></th>
											<th>Job Title</th>
											<th>Email Address</th>
											<th>Phone #</th>
											<!--<th>Cell Phone #</th>-->
											<th>Date Added</th>
										</tr>
									</tbody></table>
							  	</div>
							 	<div class="panel-body user-references">
							 		<table>
										<tbody>
										<?php
	if(is_array($arrCandidateReferenceDetail) && (count($arrCandidateReferenceDetail)>0))
	{
		foreach($arrCandidateReferenceDetail as $arrRefDetail)
		{
			?>
										<tr id="ref_row_<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>">
											<td>
												<input type="checkbox" class="checkref" name="sport" value="<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>">
											</td>
									<td>
										<div class="user-title">
											<a href="#note<?php echo  $arrRefDetail['CandidateReferences']['candidate_reference_id'] ?>-options" id="note<?php echo  $arrRefDetail['CandidateReferences']['candidate_reference_id'] ?>" class="username-clickable"><?php echo  $arrRefDetail['CandidateReferences']['reference_name']; ?></a>
										</div>
										<div id="note<?php echo  $arrRefDetail['CandidateReferences']['candidate_reference_id'] ?>-options" class="user-options">
											<a href="#" class="link-primary">View</a> |
											<a href="#" id="contact_del_<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>" class="link-primary" onclick="fnGetRefrencesDetail(this,'0')">Quick Edit</a> |
											<a href="#" class="link-warning" id="appoint_delete_<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>" onclick="fnDeleteRefrence(this,'0')">Delete</a>
										</div>
									</td>
											<td id="ref_title_<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>"><?php echo $arrRefDetail['CandidateReferences']['reference_company_name'];?></td>
											<td id="ref_title_<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>"><?php echo $arrRefDetail['CandidateReferences']['reference_job_title'];?></td>
											<td id="ref_email_<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>"><?php echo $arrRefDetail['CandidateReferences']['reference_email_address'];?></td>
											<td id="ref_telenumber_<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>"><?php echo $arrRefDetail['CandidateReferences']['reference_tele_number'];?></td>
											<!--<td id="ref_phnumber_<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id'];?>"><?php echo $arrRefDetail['CandidateReferences']['reference_phone_number'];?></td>-->
											<td><?php echo date($productdateformatnew,strtotime($arrRefDetail['CandidateReferences']['reference_creation_data'])); ?></td>
											
											
											
					
				
										
										<?php
		}
			
	}
	else
	{?>
	
	<tr><td colspan="6">No Refrences added yet, Please create your reference list through above form</td></tr>
	<?php }?>
										
										
									</tbody></table>
							 	</div>
							 	<!--<div class="panel-footer user-references">
							 		<table>
										<tbody><tr>
											<th><input type="checkbox" value=""></th>
											<th>Name</th>
											<th class="selected">Company<span></span></th>
											<th>Job Title</th>
											<th>Email Address</th>
											<th>Phone #</th>
											<th>Cell Phone #</th>
											<th>Date Added</th>
										</tr>
									</tbody></table>
							 	</div>-->
							</div>

							<table class="table table-striped" >
		<tr>
			<td colspan='6' align='left'>
				<?php
					if($this->Paginator->hasPrev())
					{
						echo $this->Paginator->prev(' << ' . __('previous'), array(), null, array('class' => 'prev disabled'));
					}
				?>
				&nbsp;
				<?php 
					echo $this->Paginator->numbers(array('last' => 'Last page'));
				?>
				&nbsp;
				<?php
					if($this->Paginator->hasNext())
					{
						echo $this->Paginator->next(__('next').' >> ' , array(), null, array('class' => 'next disabled'));
					}
				?>
			</td>
		</tr>
	</table>
						</div>
				
				
<!--<div class="jop_search" id="jop_search">
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
					<td><a href="javascript:void(0);" onclick="fnRemoveRef('<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id']; ?>');">Remove</a>&nbsp;<a href="#create_ref_heading" onclick="fnEditRef('<?php echo $arrRefDetail['CandidateReferences']['candidate_reference_id']; ?>')">Edit</a>&nbsp;</td>
				</tr>
			<?php
		}
		?>
			<tr id="no_ref_row" style="display:none;">
				<td colspan="7"><label>No Refrences added yet, Please create your reference list through above form</label></td>
			</tr>
			<li id="no_ref_row" style="width:100%;margin-right:0px;text-align:center;"><label>No Refrences added yet, Please create your reference list through above form</label></li>
		<?php
	}
	else
	{
		
		?>
			<tr id="no_ref_row">
				<td colspan="7"><label>No Refrences added yet, Please create your reference list through above form</label></td>
			</tr>
			<li id="no_ref_row" style="width:100%;margin-right:0px;text-align:center;"><label>No Refrences added yet, Please create your reference list through above form</label></li>
		<?php
	}
?>
</tbody>
</table>
</div>-->

<script type="text/javascript">
	$(document).ready(function () {
		$('.username-clickable').click(function () {
			var strDestLoc = $(this).attr('href');
			//alert("hello");
			$(strDestLoc).toggle();
		});
	});
	
	function fnGetReferenceView()
	{
		var favorite = [];
		var isChecked = "0";
		$.each($("input[name='sport']:checked"), function(){            
			//alert($(this).val());
			favorite.push($(this).val());
			isChecked = "1";

		});
		
		if(isChecked == "1")
		{
			var strIds = favorite.join(",");
			var intPortalId = "<?php echo $intPortalId; ?>";
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
			$.ajax({ 
					type: "GET",
					url: strBaseUrl+"references/getreferencetemp/"+intPortalId+"/"+strIds,
					dataType: 'json',
					data:"",
					async:false,
					cache:false,
					success: function(data)
					{
						if(data.status == "success")
						{
							var strFname = data.filename;
							var strUrlTOpen = appBaseU+"candidate_refrences/"+strFname;
							window.open(strUrlTOpen);
						}
						else
						{
							alert(data.message);
						}
						
						$('.cms-bgloader-mask').hide();//show loader mask
						$('.cms-bgloader').hide(); //show loading image
					}
			});
		}
		else
		{
			alert("Please choose atleast one of the refrences from the list.");
		}
	}
	
	function fnLoadRefrenceAdder()
	{
		var intPortalId = "<?php echo $intPortalId; ?>";
		$.ajax({ 
				type: "GET",
				url: strBaseUrl+"references/getreferenceform/"+intPortalId,
				dataType: 'json',
				data:"",
				async:false,
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						$('.tabloader').hide();
						$('#tab-references').html(data.contactshtml);
					}
					else
					{
						alert("fail");
					}
				}
		});
	}
	</script>