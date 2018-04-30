<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Find a Job of Your Dream</title>
	
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="<?php echo Router::url('/',true); ?>css/stylesheetlat.css"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
    	$(document).ready(function () {
    		//TOP MENU - NOTIFICATIONS
    		//NOTIFICATIONS
			$(".close-notification").click(function(event) {
				$(this.getAttribute("href")).css('display', 'none');
				$('#notify').on({
				    "shown.bs.dropdown": function() { this.closable = true; },
				    "click":             function() { this.closable = false; },
				    "hide.bs.dropdown":  function() { return this.closable; }
				});
			});

			//AFTER CLOSING NOTIFICATION - CLICK ON THE LINK INSIDE OR ON THE DROPDOWN LINK ITSELF
			$("#notify li:last-child a, #notify").click(function(event) {
				$('#notify').on({
				    "shown.bs.dropdown": function() { this.closable = false; },
				    "click":             function() { this.closable = true; },
				    "hide.bs.dropdown":  function() { return this.closable; }
				});
			});
			////AFTER CLOSING NOTIFICATION - CLICK OUTSIDE THE NOTIFICATION CONTAINER
			$("body").click(function(e) {
    			if (!$('li#notify').is(e.target) && $('li#notify').has(e.target).length === 0 && $('.open').has(e.target).length === 0) {
       				 $('li#notify').removeClass('open');
    			}
			});

 			//ADMIN - COLLAPSE MENU
		    $(".menu-toggle").click(function(e) {
		        e.preventDefault();
		        $(".admin-wrapper").toggleClass("toggled-2");
		        $('.admin-menu ul').hide();
		    });
		});
    </script>
  </head>

  <body>
	<div class="container-fluid top-menu-container">
		<nav class="navbar navbar-default top-menu">
			<div class="col-xs-12 col-md-2">
				<a class="navbar-brand" href="#" >
					<img src="<?php echo Router::url('/',true); ?>images/search-item.png" alt="logo description"><span>HR Search</span>
				</a>
			</div>
			<div class="col-xs-12 col-md-10">

				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="#" class="right-top-menu-item icon-questionmark">&nbsp;</a>
					</li>
					<li class="dropdown" id="notify">
						<a href="#" class="dropdown-toggle right-top-menu-item icon-notification" data-toggle="dropdown">&nbsp;</a>
						<ul class="dropdown-menu notification-block">
							<li>
								<a class="triangle-a">
									<img class="triangle-img" src="<?php echo Router::url('/',true); ?>images/tooltip-triangle.png" alt="">	
								</a>
							</li>
							<li id="notification1" class="notification-block-bordered">
								<a href="#" class="dropdown-item-notification">
									<p>Your password was changed.</p>
								</a>
								<a href="#notification1" class="close-notification">
									<img src="<?php echo Router::url('/',true); ?>images/icon-delete-notification.png" alt="">
								</a>
							</li>
							<li id="notification2" class="notification-block-bordered">
								<a href="#" class="dropdown-item-notification">
									<p>Your application for "Sales Manager" was declined.</p>
								</a>
								<a href="#notification2" class="close-notification">
									<img src="<?php echo Router::url('/',true); ?>images/icon-delete-notification.png" alt="">
								</a>
							</li>
							<li>
								<a href="#" class="right-top-menu-item">See all notifications</a>
							</li>
						</ul>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle right-top-menu-item icon-user" data-toggle="dropdown" >
							Hi Matthew!
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu xs-border" style="margin-top: 5px;">
							<li>
								<a class="triangle-a">
									<img class="triangle-img" src="<?php echo Router::url('/',true); ?>images/tooltip-triangle.png" alt="">	
								</a>
							</li>
							<li>
								<a href="#" class="right-top-menu-item dropdown-item">Edit my profile</a>
							</li>
							<li>
								<a href="#" class="right-top-menu-item dropdown-item">Change password</a>
							</li>
							<li>
								<a href="#" class="right-top-menu-item dropdown-item">Logout</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div>

	<div class="container-fluid">

		<div class="admin-wrapper">

	        <div class="admin-sidebar-wrapper">
	            <ul class="sidebar-nav nav-pills nav-stacked admin-menu">
	                <li class="active">
	                    <a href="#">
	                    	<span class="employer-menu-icon emp-icon-dashboard" aria-hidden="true"></span> 
	                    	Dashboard
	                    </a>
	                </li>
	                <li>
	                    <a href="#">
	                    	<span class="employer-menu-icon emp-icon-page" aria-hidden="true"></span> 
	                    	Pages
	                    </a>
	                </li>
	                <li>
	                    <a href="#">
	                    	<span class="employer-menu-icon emp-icon-tasks" aria-hidden="true"></span> 
	                    	Jobs
	                    </a>
	                </li>
	                <li>
	                    <a href="#">
	                    	<span class="employer-menu-icon emp-icon-candidates" aria-hidden="true"></span> 
	                    	Candidates
	                    </a>
	                </li>
	                <li>
	                    <a href="#">
	                    	<span class="employer-menu-icon emp-icon-applications" aria-hidden="true"></span> 
	                    	Applications
	                    </a>
	                </li>
	                <li>
	                    <a href="#">
	                    	<span class="employer-menu-icon emp-icon-events" aria-hidden="true"></span> 
	                    	Events
	                    </a>
	                </li>
	                <li>
	                    <a href="#">
	                    	<span class="employer-menu-icon emp-icon-reports" aria-hidden="true"></span> 
	                    	Reports
	                    </a>
	                </li>
	                <li>
	                    <a href="#">
	                    	<span class="employer-menu-icon emp-icon-library" aria-hidden="true"></span> 
	                    	Library
	                    </a>
	                </li>
	            </ul>
				<div class="toggle-buttons-container">
	                <button class="navbar-toggle collapse in menu-toggle" data-toggle="collapse">
	                	<span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> Collapse menu
	                </button>
	        	</div>
	        </div>
		
	        <div class="page-content-wrapper employers-type">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-lg-12">
	                        <h1>Dashboard</h1>

	                        <ul class="content-controls">
	                        	<li>
	                        		<a href="#" class="control-button">Today</a>
	                        	</li><!-- 
	                         --><li class="active">
	                        		<a href="#" class="control-button">Week</a>
	                        	</li><!-- 
	                         --><li>
	                        		<a href="#" class="control-button">Month</a>
	                        	</li><!-- 
	                         --><li>
	                        		<a href="#" class="control-button">All time</a>
	                        	</li>
	                        </ul>
	                        
	                        <div class="emp-stat-box-container">

	                        	<div class="emp-stat-box">
	                        		
	                        		<div class="left-side-container">
	                        		
		                        		<h4>2.789</h4>
		                        		<p>Unique Views</p>

	                        		</div><!-- 

	                        	 --><div class="right-side-container">
	                        		
		                        		<div class="dropdown">
			                        		<a href="#" class="diagr-popup dropdown-toggle" data-toggle="dropdown">
			                        			<img src="<?php echo Router::url('/',true); ?>images/emp-diagr.png" alt="">
			                        		</a>
			                        		<ul class="dropdown-menu xs-border" style="margin-top: 5px;">
												<li>
													<a class="triangle-a">
														<img class="triangle-img" src="<?php echo Router::url('/',true); ?>images/tooltip-triangle.png" alt="">	
													</a>
												</li>
												<li>
													<span class="indication indication-success"></span><!-- 
												 --><span class="point-title">Open Jobs</span><!-- 
												 --><span class="point-descr">589 (18%)</span>
												</li>
												<li>
													<span class="indication indication-warning"></span><!-- 
												 --><span class="point-title">Other pages</span><!-- 
												 --><span class="point-descr">2200 (82%)</span>
												</li>
											</ul>
										</div>
	                        		
	                        		</div>

	                        	</div><!-- 

	                         --><div class="emp-stat-box">
	                        		
	                        		<div class="left-side-container">
	                        		
		                        		<h4>58</h4>
		                        		<p>Registered Users</p>

	                        		</div><!-- 

	                        	 --><div class="right-side-container">
	                        		
		                        		<div class="dropdown">
			                        		<a href="#" class="diagr-popup dropdown-toggle" data-toggle="dropdown">
			                        			<img src="<?php echo Router::url('/',true); ?>images/emp-diagr2.png" alt="">
			                        		</a>
			                        		<ul class="dropdown-menu long xs-border" style="margin-top: 5px;">
												<li>
													<a class="triangle-a">
														<img class="triangle-img" src="<?php echo Router::url('/',true); ?>images/tooltip-triangle.png" alt="">	
													</a>
												</li>
												<li>
													<span class="indication indication-alert"></span><!-- 
												 --><span class="point-title">Not started wizard</span><!-- 
												 --><span class="point-descr">2 (4%)</span>
												</li>
												<li>
													<span class="indication indication-primary"></span><!-- 
												 --><span class="point-title">Started wizard</span><!-- 
												 --><span class="point-descr">32 (60%)</span>
												</li>
												<li>
													<span class="indication indication-success"></span><!-- 
												 --><span class="point-title">Purchased services</span><!-- 
												 --><span class="point-descr">10 (17%)</span>
												</li>
												<li>
													<span class="indication indication-featured"></span><!-- 
												 --><span class="point-title">Wizard completed</span><!-- 
												 --><span class="point-descr">14 (19%)</span>
												</li>
											</ul>
										</div>
	                        		
	                        		</div>

	                        	</div><!-- 

	                         --><div class="emp-stat-box">
	                        		
	                        		<div class="left-side-container">
	                        		
		                        		<h4 class="box-success">$21,459</h4>
		                        		<p>Revenue Earned</p>

	                        		</div>

	                        	</div><!-- 

	                         --><div class="emp-stat-box">
	                        		
	                        		<div class="left-side-container">
	                        		
		                        		<h4 class="box-alert">$300</h4>
		                        		<p>Refunds Issued</p>

	                        		</div>

	                        	</div>
	                        </div>

	                        <div class="emp-stat-graph-container">
	                        	
	                        	<div class="emp-stat-graph">
	                        		
	                        		<h4>Views this week</h4>

	                        	</div><!-- 

	                         --><div class="emp-stat-graph">
	                        		
	                        		<h4>Sales this week</h4>

	                        	</div>

	                        </div>

	                        <div class="panel panel-default hidden-xs hidden-sm">
							  	<div class="panel-heading emp-category">
									<h4>Registered users</h4>
							  	</div>
							 	<div class="panel-body emp-category">
							 		<table>
							 			<thead>
							 				<tr>
												<th>First name</th>
												<th class="selected">Last name<span></span></th>
												<th>Email</th>
												<th class="no-filter">Phone number</th>
												<th class="no-filter">Resume</th>
												<th>Registration Date</th>
											</tr>
							 			</thead>
							 			<tbody>
											<tr>
												<td>John</td>
												<td>Doe</td>
												<td>john.doe@companyname.com</td>
												<td>(555) 555 - 555 - 55</td>
												<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
												<td>Aug 23, 2015</td>
											</tr>
											<tr>
												<td>John</td>
												<td>Doe</td>
												<td>john.doe@companyname.com</td>
												<td>(555) 555 - 555 - 55</td>
												<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
												<td>Aug 23, 2015</td>
											</tr>
											<tr>
												<td>John</td>
												<td>Doe</td>
												<td>john.doe@companyname.com</td>
												<td>(555) 555 - 555 - 55</td>
												<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
												<td>Aug 23, 2015</td>
											</tr>
											<tr>
												<td>John</td>
												<td>Doe</td>
												<td>john.doe@companyname.com</td>
												<td>(555) 555 - 555 - 55</td>
												<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
												<td>Aug 23, 2015</td>
											</tr>
											<tr>
												<td>John</td>
												<td>Doe</td>
												<td>john.doe@companyname.com</td>
												<td>(555) 555 - 555 - 55</td>
												<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
												<td>Aug 23, 2015</td>
											</tr>
											<tr>
												<td>John</td>
												<td>Doe</td>
												<td>john.doe@companyname.com</td>
												<td>(555) 555 - 555 - 55</td>
												<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
												<td>Aug 23, 2015</td>
											</tr>
											<tr>
												<td>John</td>
												<td>Doe</td>
												<td>john.doe@companyname.com</td>
												<td>(555) 555 - 555 - 55</td>
												<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
												<td>Aug 23, 2015</td>
											</tr>
											<tr>
												<td>John</td>
												<td>Doe</td>
												<td>john.doe@companyname.com</td>
												<td>(555) 555 - 555 - 55</td>
												<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
												<td>Aug 23, 2015</td>
											</tr>
											<tr>
												<td>John</td>
												<td>Doe</td>
												<td>john.doe@companyname.com</td>
												<td>(555) 555 - 555 - 55</td>
												<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
												<td>Aug 23, 2015</td>
											</tr>
											<tr>
												<td>John</td>
												<td>Doe</td>
												<td>john.doe@companyname.com</td>
												<td>(555) 555 - 555 - 55</td>
												<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
												<td>Aug 23, 2015</td>
											</tr>
										</tbody>
									</table>
							 	</div>
							 	<div class="panel-footer emp-category">
							 		<a href="#" class="link-primary">Load More</a>
							 	</div>
							</div>
							<!-- SMALL TABLE -->
							<div class="panel panel-default hidden-md hidden-lg">
							  	<div class="panel-heading emp-category">
									<h4>Registered users</h4>
							  	</div>
							 	<div class="panel-body emp-category small-view">
							 		<table>
							 			<tr>
							 				<td>First name</td>
							 				<td>John</td>
							 			</tr>
							 			<tr>
							 				<td>Last name</td>
							 				<td>Doe</td>
							 			</tr>
							 			<tr>
							 				<td>Email</td>
							 				<td>john.doe@companyname.com</td>
							 			</tr>
							 			<tr>
							 				<td>Phone number</td>
							 				<td>(555) 555 - 555 - 55</td>
							 			</tr>
							 			<tr>
							 				<td>Resume</td>
							 				<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
							 			</tr>
							 			<tr>
							 				<td>Registration Date</td>
							 				<td>Aug 23, 2015</td>
							 			</tr>
									</table>
							 	</div>
							 	<div class="panel-footer emp-category">
							 		<a href="#" class="link-primary">Load More</a>
							 	</div>
							</div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

  </body>
</html>
