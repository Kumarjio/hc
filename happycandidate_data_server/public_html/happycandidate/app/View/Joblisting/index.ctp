<script type="text/javascript">

	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
		$(".panel-body .user-title a").click(function(event) {
				
				$(this.getAttribute("href")).css('display', 'table-row');
				$(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
			});
		
	});

</script>

      <div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
					<span id="successmessage"></span>
	                    <div class="tab-header">
							<h3>All Jobs</h3>
							
								<div class="tab-search">
								
							<?php
			$strProductSearchUrl = Router::url(array('controller'=>'joblisting','action'=>'index'),true);
		?>
							<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>/" method="post" role="form">
								<input type="text" name="product_keyword" id="product_keyword" value="" name="search" placeholder="Search">
								<input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" />
								<button name="product_search" id="product_search" type="submit" class="btn btn-default btn-md">Search</button>
								</form>
							</div>
						</div>

					
						
						<div class="tab-row-container">
							<div class="panel panel-default hidden-xs hidden-sm">
							  	<div class="panel-heading admin-content">
									<table id="product_list">
										<tr>
											<th style="width:12%!important;">ID</th>
											<th class="selected">Job Title<span></span></th>
											<th>Listing Type</th>
											<th>Created On</th>
											<th>For Portal</th>
											<th>User</th>
											<th>Views</th>
											<th>App</th>
											<th>Status</th>
											<th>Approval Status</th>
											
										</tr>
									</table>
							  	</div>
							 	<div class="panel-body admin-content">
							 		<table >
									<?php
									
			if(is_array($jobs) && (count($jobs)>0))
			{
				$intContentCount = 0;
				foreach($jobs as $jobdetail)
				{
				//echo "<pre>";
				//print_r($jobdetail);
					$intContentCount++;
					$strProductEditUrl = Router::url(array('controller'=>'Joblisting','action'=>'edit',$jobdetail['Joblisting']['id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'portal','action'=>'getjobdetail',"5",$jobdetail['Joblisting']['id']),true);
					?>
										<tr id="product_list_<?php echo $jobdetail['Joblisting']['id'];?>">
											<td style="width:12%!important;">
												<?php echo $intContentCount; ?>
											</td>
											<td>
											 
												<div class="user-title">
													<a href="#str<?php echo $jobdetail['Joblisting']['id'];?>" id="task1" class="username-clickable"><?php echo stripslashes($jobdetail['Joblisting']['job_title']); ?></a>
												</div>
											</td>
											
											<td>
											<?php echo ($jobdetail['Joblisting']['spotlight'] == "Y")? "Spotlight Job" : "Standard Job";?>
											</td>
							<td >
											<?php echo date( 'd-M-Y', strtotime($jobdetail['Joblisting']['created_at']));?>
											</td>
											<td >
											<?php echo stripslashes($jobdetail['portal']['career_portal_name']); ?>
											</td>
											<td >
											<?php echo stripslashes($jobdetail['employer']['company_name']); ?>
											</td>
											
											<td><?php echo $jobdetail['Joblisting']['views_count']; ?></td>
											<td><?php echo $jobdetail['Joblisting']['apply_count']; ?></td>
												
											
											<td id="job_status_<?php echo $jobdetail['Joblisting']['id'];?>">
											<?php echo ($jobdetail['Joblisting']['is_active'] == "Y")? "Active" : "Not Active";?>
											</td>
											<td><?php echo $jobdetail['Joblisting']['job_status']; ?></td>
											
										</tr>
										<tr id="str<?php echo $jobdetail['Joblisting']['id'];?>" class="hide-str">
											<td></td>
											<td colspan="5">
												<div id="task1-options" class="user-options">
													<a href="<?php echo $strProductEditUrl; ?>" class="link-primary">Edit</a> |
													<a href="<?php echo $strPreviewUrl; ?>" class="link-primary">Preview</a> |
													<a href="javascript:void(0);" id="content_status_<?php echo $jobdetail['Joblisting']['id'];?>" onclick="return fnJobStatus(this);" class="link-primary"><?php echo ($jobdetail['Joblisting']['is_active'] == "Y")? "Active" : "Not Active";?></a> |
													<a href="javascript:void(0);" id="content_delete_<?php echo $jobdetail['Joblisting']['id'];?>" onclick="return fnDeleteJob(this);" class="link-warning">Delete</a>
													
												</div>
											</td>
										</tr>
									
									<?php
				}
			}
		?>
									</table>
							 	</div>
							 
							</div>

							<div class="panel panel-default hidden-md hidden-lg">
							  	<div class="panel-heading">
									<table>
										<tr>
											<th><input type="checkbox" value=""></th>
											<th>Title</th>
											<th class="disabled">Options</th>
										</tr>
									</table>
							  	</div>
							 	<div class="panel-body small-view">
							 		<table>
										<tr>
											<td><input class="small-view" type="checkbox" value=""></td>
											<td>
												<div class="user-title">
													<a class="username-clickable">Evaluate Your Attitude</a>
												</div>
											</td>
											<td>
												<div class="user-options visible">
													<a href="#" class="link-primary">Edit</a> |
													<a href="#" class="link-primary">Preview</a> |
													<a href="#" class="link-warning">Delete</a>
												</div>
											</td>
										</tr>
										<tr class="selected">
											<td><input class="small-view" type="checkbox" value="" checked></td>
											<td>
												<div class="user-title">
													<a class="username-clickable">Set Realistic Expectations</a>
												</div>
											</td>
											<td>
												<div class="user-options visible">
													<a href="#" class="link-primary">Edit</a> |
													<a href="#" class="link-primary">Preview</a> |
													<a href="#" class="link-warning">Delete</a>
												</div>
											</td>
										</tr>
										<tr>
											<td><input class="small-view" type="checkbox" value=""></td>
											<td>
												<div class="user-title">
													<a class="username-clickable">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi, maxime!</a>
												</div>
											</td>
											<td>
												<div class="user-options visible">
													<a href="#" class="link-primary">Edit</a> |
													<a href="#" class="link-primary">Preview</a> |
													<a href="#" class="link-warning">Delete</a>
												</div>
											</td>
										</tr>
										<tr>
											<td><input class="small-view" type="checkbox" value=""></td>
											<td>
												<div class="user-title">
													<a class="username-clickable">Determine Job Target Criteria</a>
												</div>
											</td>
											<td>
												<div class="user-options visible">
													<a href="#" class="link-primary">Edit</a> |
													<a href="#" class="link-primary">Preview</a> |
													<a href="#" class="link-warning">Delete</a>
												</div>
											</td>
										</tr>
										<tr>
											<td><input class="small-view" type="checkbox" value=""></td>
											<td>
												<div class="user-title">
													<a class="username-clickable">Identify Specific Target Companies</a>
												</div>
											</td>
											<td>
												<div class="user-options visible">
													<a href="#" class="link-primary">Edit</a> |
													<a href="#" class="link-primary">Preview</a> |
													<a href="#" class="link-warning">Delete</a>
												</div>
											</td>
										</tr>
									</table>
							 	</div>
							 	<div class="panel-footer">
							 		<table>
										<tr>
											<th><input type="checkbox" value=""></th>
											<th>Title</th>
											<th class="disabled">Options</th>
										</tr>
									</table>
							 	</div>
							</div>
						</div>
							<div class="pagination pagination-large">
					<ul class="pagination">
							<?php
								echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
								echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
								echo $this->Paginator->next(__('next'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
							?>
						</ul>
					</div>
						<!--<div class="tab-row-container">
							<div class="tab-controls-actions">
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
	                </div>
	            </div>
	        </div>