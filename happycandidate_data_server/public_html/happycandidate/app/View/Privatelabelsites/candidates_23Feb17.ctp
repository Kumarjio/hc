<div class="page-content-wrapper employers-type" style="min-height:500px;">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="tab-row-container">
								<h1>Candidates</h1>
								<p>Listed are all registrants in your Career Portal</p>
								<!--<div class="tab-search emp-dashboard-search emp-dashboard-app-form" >
									<input type="text" value="" name="search" placeholder="Search">
									<button type="button" class="btn btn-default btn-md">Search</button>
								</div>-->
							</div>
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
								//print("<pre>");
								//print_r($arrPortalJobs);
								//exit;
								
								if(is_array($arrCandidate) && (count($arrCandidate)>0))
								{
									?>
										<div class="tab-row-container">
											<div class="panel panel-default hidden-xs hidden-sm">
												<div class="panel-body emp-dashboard-app">
												<table id="product_list" class="tablesorter">
													<thead>
													<tr>
														<!--<th><input type="checkbox" value=""></th>-->
														<th>First Name</th>
														<th>Last Name<span></span></th>
														<th>Email</th>
														<th>Phone Number</th>
														<th>Type of Job</th>
														<!--<th class="no-filter">Resume</th>-->
														<th>Date added</th>
													</tr>
													<thead>
													<tbody class="panel-body emp-dashboard-jobs">
													<?php
														foreach($arrCandidate as $arrJob)
														{
															//echo "<pre>"; print_r($arrJob);
															$intJId = $arrJob['Candidate']['candidate_id'];
															$strViewDetail = Router::url(array('controller'=>'privatelabelsites','action'=>'candidatedetail',$intJId),true);
															?>
																<tr id="product_list_<?php echo $intJId;?>">
																	<!--<td>
																		<input type="checkbox" value="">
																	</td>-->
																	<td>
																		<div class="user-title">
																			<a href="#str<?php echo $intJId;?>" id="task1" class="username-clickable"><?php echo $arrJob['Candidate']['candidate_first_name']; ?></a>
																		</div>
																	</td>
																	<td><?php echo $arrJob['Candidate']['candidate_last_name']; ?></td>
																	<td><?php echo $arrJob['Candidate']['candidate_email']; ?></td>
																	<td><?php echo $arrJob['Candidate']['candidate_phone_number']; ?></td>
																	<td>-</td>
																	<!--<td><a href="javascript:void(0);" class="link-primary editable">resume-title.pdf</a></td>-->
																	<td><?php echo date("M d, Y",strtotime($arrJob['Candidate']['candidate_creation_date'])) ; ?></td>
																</tr>
																<tr id="str<?php echo $intJId;?>" class="hide-str">
																	<td></td>
																	<td colspan="5">
																		<div id="task1-options" class="user-options">
																			<a href="<?php echo $strViewDetail; ?>" class="link-primary">View</a>
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
							<div class="tab-controls-pagination">
								<div class="pagination pagination-large">
								<ul class="pagination">
									<?php
										echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
										echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
										echo $this->Paginator->next(__('next'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
									?>
								</ul>
							</div>
						</div>
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
	$(document).ready(function()
	{
		$("#product_list").tablesorter({
			// pass the headers argument and assing a object
			headers: {
				// assign the secound column (we start counting zero)
				0: {
					// disable it by setting the property sorter to false
					sorter: false
				},
				// assign the third column (we start counting zero)
				3: {
					// disable it by setting the property sorter to false
					sorter: false
				},
				// assign the third column (we start counting zero)
				4: {
					// disable it by setting the property sorter to false
					sorter: false
				},
				// assign the third column (we start counting zero)
				5: {
					// disable it by setting the property sorter to false
					sorter: false
				}
				
			}
		});
	}
	);
</script>
<script type="text/javascript">
	$(document).ready(function () {
		$('.leftnavi').removeClass('active');
		$('#candnavi').addClass('active');
		
		 //TABS - CLICKING ON THE USERS
		$(".panel-body.emp-dashboard-jobs .user-title a").click(function(event) {
			
			$(this.getAttribute("href")).css('display', 'table-row');
			$(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
		});
	});
</script>