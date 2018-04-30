<div class="page-content-wrapper employers-type" style="min-height:500px;">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h1>Applications</h1>
				<!--<div class="tab-row-container">
					<div class="tab-filters">
						<a href="#" class="active">All <span>(7)</span></a> |
						<a href="#" class="link-primary">Unread <span>(4)</span></a> |
						<a href="#" class="link-primary">Archived <span>(1)</span></a>
					</div>
					<div class="tab-search emp-dashboard-app-form">
						<input type="text" value="" name="search" placeholder="Search">
						<button type="button" class="btn btn-default btn-md">Search</button>
					</div>
				</div>-->
				<!--<div class="tab-row-container">
					<div class="tab-controls-actions">
						<div class="form-group emp-dashboard-app-form">
							<select name="bulk-actions" title="Bulk Actions">
								<option value="value1">Bulk Actions</option>
								<option value="value2">Bulk Action2</option>
								<option value="value3">Bulk Action3</option>
								<option value="value4">Bulk Action4</option>
							</select>
							<button type="button" class="btn btn-default btn-md">Apply</button>
						</div>
						<div class="form-group emp-dashboard-app-form">
							<select name="date-filter" title="All Dates">
								<option value="value1">All Dates</option>
								<option value="value2">All Dates2</option>
								<option value="value3">All Dates3</option>
								<option value="value4">All Dates4</option>
							</select>
							<button type="button" class="btn btn-default btn-md">Filter</button>
						</div>
					</div>
					<div class="tab-controls-pagination">
						<button type="button" class="btn btn-default disabled items-counter"><span>5 of 17 items</span></button>
						<button type="button" class="btn btn-default disabled goto-beginning"><span></span></button>
						<button type="button" class="btn btn-default disabled goto-previous"><span></span></button>
						<input type="text" value="" name="input-page-number" placeholder="1">
						<button type="button" class="btn btn-default disabled pages-counter"><span>of 3</span></button>
						<button type="button" class="btn btn-default goto-next-active"><span></span></button>
						<button type="button" class="btn btn-default goto-end-active"><span></span></button>
					</div>
				</div>-->
				<?php
					print("<pre>");
					print_r($arrApplications);
					//exit;
					
					if(is_array($arrApplications) && (count($arrApplications)>0))
					{
						?>
						<div class="tab-row-container">
							<div class="panel panel-default hidden-xs hidden-sm">
								<div class="panel-body emp-dashboard-app">
								<table id="product_list" class="tablesorter">
									<thead>
									<tr>
										<th><input type="checkbox" value=""></th>
										<th>Title</th>
										<th class="selected">Candidate<span></span></th>
										<th>Email</th>
										<th>Phone Number</th>
										<th class="no-filter">Resume</th>
										<th>Application date</th>
									</tr>
									<thead>
									<tbody class="panel-body emp-dashboard-jobs">
									<?php
										foreach($arrCandidate as $arrJob)
										{
											$arrJobD = $arrJob['JobsApplied']['jobdetail'];
											$arrCandD = $arrJob['JobsApplied']['candtail'];
											$arrCVD = $arrJob['JobsApplied']['candcvdetail'];
											$intJId = $arrJob['JobsApplied']['job_application_id'];
											
											?>
												<tr id="product_list_<?php echo $intJId;?>">
													<td>
														<input type="checkbox" value="">
													</td>
													<td>
														<div class="user-title">
															<a href="#str" id="task1" class="username-clickable"><?php $arrJobD[0]['Job']['job_title']; ?></a>
														</div>
													</td>
													<td><a href="#str" class="username-clickable"><?php echo $arrJobD[0]['Candidate']['candidate_first_name']. ".$arrJobD[0]['Candidate']['candidate_last_name']; ?></a></td>
													<td><?php echo $arrJobD[0]['Candidate']['candidate_first_name']; ?></td>
													<td><?php echo $arrJobD[0]['Candidate_Cv']['homePhone']; ?></td>
													<td><a href="#" class="link-primary editable"><?php echo $arrJobD[0]['Candidate_Cv']['resume_title']; ?></a></td>
													<td>Aug 23, 2015</td>
												</tr>
												<tr id="str<?php echo $intJId;?>" class="hide-str">
													<td></td>
													<td colspan="6">
														<div id="task1-options" class="user-options">
															<a href="#" class="link-primary">View</a>
														</div>
													</td>
												</tr>
											<?php
										}
									?>
									</tbody>
								</table>
							</div>
						</div>
					<?php
									
					}
				?>
				

				<!--<div class="tab-row-container">
					<div class="tab-controls-actions">
						<div class="form-group emp-dashboard-app-form">
							<select name="bulk-actions" title="Bulk Actions">
								<option value="value1">Bulk Actions</option>
								<option value="value2">Bulk Action2</option>
								<option value="value3">Bulk Action3</option>
								<option value="value4">Bulk Action4</option>
							</select>
							<button type="button" class="btn btn-default btn-md">Apply</button>
						</div>
						<div class="form-group emp-dashboard-app-form">
							<select name="date-filter" title="All Dates">
								<option value="value1">All Dates</option>
								<option value="value2">All Dates2</option>
								<option value="value3">All Dates3</option>
								<option value="value4">All Dates4</option>
							</select>
							<button type="button" class="btn btn-default btn-md">Filter</button>
						</div>
					</div>
					<div class="tab-controls-pagination">
						<button type="button" class="btn btn-default disabled items-counter"><span>5 of 17 items</span></button>
						<button type="button" class="btn btn-default disabled goto-beginning"><span></span></button>
						<button type="button" class="btn btn-default disabled goto-previous"><span></span></button>
						<input type="text" value="" name="input-page-number" placeholder="1">
						<button type="button" class="btn btn-default disabled pages-counter"><span>of 3</span></button>
						<button type="button" class="btn btn-default goto-next-active"><span></span></button>
						<button type="button" class="btn btn-default goto-end-active"><span></span></button>
					</div>
				</div>-->
				<!-- del -->
				
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('.leftnavi').removeClass('active');
		$('#appnavi').addClass('active');
	});
</script>