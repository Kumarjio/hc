<div class="tab-header">
	<h3>Notes</h3><!--
	--><button type="button" onclick="fnLoadNoteAdder()" class="btn btn-primary btn-sm">Add New</button>
	<input type='hidden' name='portal_id' id='portal_id' value='<?php echo $intPortalId; ?>' />	
</div>
<?php echo $this->Session->flash(); ?>

<div class="tab-row-container">
	<!--<div class="tab-filters">
		<a href="#" class="active">All <span>(5)</span></a> |
		<a href="#" class="link-primary">New <span>(1)</span></a> |
		<a href="#" class="link-warning">Trashed <span>(4)</span></a>
		
	</div>
	<div class="tab-search">
		<input type="text" value="" name="search" placeholder="Search">
		<button type="button" class="btn btn-default btn-md">Search</button>
	</div>-->
</div>
<!-- NOTES TOP CONTROLS -->
<div class="tab-row-container">
	<!-- <div class="tab-contacts-controls"> -->
		<!--<div class="tab-controls-actions">
			<div class="form-group">
				<select name="bulk-actions" title="Bulk Actions">
					<option value="value1">Bulk Action1</option>
					<option value="value2">Bulk Action2</option>
					<option value="value3">Bulk Action3</option>
					<option value="value4">Bulk Action4</option>
				</select>
				<button type="button" class="btn btn-default btn-md">Apply</button>
			</div>
			<div class="form-group">
				<select name="date-filter" title="Date Filter">
					<option value="value1">Date Filter1</option>
					<option value="value2">Date Filter2</option>
					<option value="value3">Date Filter3</option>
					<option value="value4">Date Filter4</option>
				</select>
				<button type="button" class="btn btn-default btn-md">Filter</button>
			</div>
		</div>
		<div class="tab-controls-pagination">
			<button type="button" class="btn btn-default disabled items-counter"><span>5 items</span></button>
			<button type="button" class="btn btn-default disabled goto-beginning"><span></span></button>
			<button type="button" class="btn btn-default disabled goto-previous"><span></span></button>
			<input type="text" value="" name="input-page-number" placeholder="1">
			<button type="button" class="btn btn-default disabled pages-counter"><span>of 3</span></button>
			<button type="button" class="btn btn-default goto-next-active"><span></span></button>
			<button type="button" class="btn btn-default goto-end-active"><span></span></button>
		</div>-->
	<!-- </div> -->
</div>
<!-- NOTES CONTENT -->
<div class="tab-row-container">
	<div class="panel panel-default hidden-xs hidden-sm">
		<div class="panel-heading notes">
			<table>
				<tr >
					<th><input type="checkbox" value=""></th>
					<th>Title</th>
					<th>Description</th>
					<th>Date created</th>
					<!--<th>Date modified</th>-->
				</tr>
			</table>
		</div>
		<div class="panel-body notes">
			<table>
				<?php
					if(is_array($arrAppointmentNoteList) && (count($arrAppointmentNoteList)>0))
					{
						//print("<pre>");
						//print_r($arrAppointmentList);
						//exit;
						
						foreach($arrAppointmentNoteList as $arrAppointmentNote)
						{
							?>
								<tr id="note_<?php echo $arrAppointmentNote['JstNotes']['jstnotes_id'];?>">
									<td><input type="checkbox" value=""></td>
									<td>
										<div class="user-title">
											<a href="#note<?php echo  $arrAppointmentNote['JstNotes']['jstnotes_id'] ?>-options" id="note<?php echo  $arrAppointmentNote['JstNotes']['jstnotes_id'] ?>" class="username-clickable"><?php echo  $arrAppointmentNote['JstNotes']['jstnotes_title']; ?></a>
										</div>
										<div id="note<?php echo  $arrAppointmentNote['JstNotes']['jstnotes_id'] ?>-options" class="user-options">
											<a href="#" class="link-primary">View</a> |
											<a href="#" id="contact_del_<?php echo $arrAppointmentNote['JstNotes']['jstnotes_id'];?>" class="link-primary" onclick="fnGetNoteDetail(this,'0')">Quick Edit</a> |
											<a href="#" class="link-warning" id="appoint_delete_<?php echo $arrAppointmentNote['JstNotes']['jstnotes_id'];?>" onclick="fnDeleteNoteNew(this,'0')">Delete</a>
										</div>
									</td>
									<td class="selected"><?php echo  htmlspecialchars_decode($arrAppointmentNote['JstNotes']['jstnotes_description']); ?><span></span></td>
									<td><a href="#" class="link-primary editable"><?php echo  date("M, d Y",strtotime($arrAppointmentNote['JstNotes']['jstnotes_start_date_time'])); ?></a></td>
								</tr>
							<?php
						}
					}
					else
					{
						?>
							<tr>
								<td colspan="6">There are no Notes recorded</td>
							</tr>
						<?php
					}
				?>
			</table>
		</div>
		<div class="panel-footer notes">
			<table>
				<tr>
					<th><input type="checkbox" value=""></th>
					<th>Title</th>
					<th>Description</th>
					<th>Date created</th>
					<!--<th>Date modified</th>-->
				</tr>
			</table>
		</div>
	</div>
</div>
<!-- CONTACTS BOTTOM CONTROLS -->
<div class="tab-row-container">
	<!-- <div class="tab-contacts-controls"> -->
		<!--<div class="tab-controls-actions">
			<div class="form-group">
				<select name="bulk-actions" title="Bulk Actions">
					<option value="value1">Bulk Action1</option>
					<option value="value2">Bulk Action2</option>
					<option value="value3">Bulk Action3</option>
					<option value="value4">Bulk Action4</option>
				</select>
				<button type="button" class="btn btn-default btn-md">Apply</button>
			</div>
			<div class="form-group">
				<select name="date-filter" title="Date Filter">
					<option value="value1">Date Filter1</option>
					<option value="value2">Date Filter2</option>
					<option value="value3">Date Filter3</option>
					<option value="value4">Date Filter4</option>
				</select>
				<button type="button" class="btn btn-default btn-md">Filter</button>
			</div>
		</div>
		<div class="tab-controls-pagination">
			<button type="button" class="btn btn-default disabled items-counter"><span>5 items</span></button>
			<button type="button" class="btn btn-default disabled goto-beginning"><span></span></button>
			<button type="button" class="btn btn-default disabled goto-previous"><span></span></button>
			<input type="text" value="" name="input-page-number" placeholder="1">
			<button type="button" class="btn btn-default disabled pages-counter"><span>of 3</span></button>
			<button type="button" class="btn btn-default goto-next-active"><span></span></button>
			<button type="button" class="btn btn-default goto-end-active"><span></span></button>
		</div>-->
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('.username-clickable').click(function () {
			var strDestLoc = $(this).attr('href');
			//alert("hello");
			$(strDestLoc).toggle();
		});
	});
	
	function fnLoadNoteAdder()
	{
		var intPortalId = "<?php echo $intPortalId; ?>";
		$.ajax({ 
				type: "GET",
				url: strBaseUrl+"jstnote/getnoteform/"+intPortalId,
				dataType: 'json',
				data:"",
				async:false,
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						$('.tabloader').hide();
						$('#tab-notes').html(data.contactshtml);
					}
					else
					{
						alert("fail");
					}
				}
		});
	}
</script>