<?php
	$strWebinarUrl = Router::url(array('controller'=>'candidates','action'=>'webinars',$intPortalId),true);
	$strLibraryUrl = Router::url(array('controller'=>'candidates','action'=>'library',$intPortalId),true);
	$strJobSearchTrackerUrl = Router::url(array('controller'=>'jstracker','action'=>'index',$intPortalId),true);
	$strLoginUrl = Router::url(array('controller'=>'portal','action'=>'login',$intPortalId),true);
?>

 <div class="container-fluid">

    	<div class="col-md-1"></div>

			<div class="col-md-10">
				
				<div class="page-header-main">
					<h1>Find a Job of Your Dream</h1>
					<p>Our &#35;1 goal is to help you identify opportunities that eventually lead you to choose a career.</p>
				</div>
				
				<div class="col-md-8 index-content-container-v2">
					<h2>Get Started With Your Job Portal</h2>
					<ul class="v4-list">
						<li>Access to more than 1,000 job boards</li>
						<li>Weekly free job seeker webinars with Q&amp;A</li>
						<li>Access to valuable free job search resources</li>
						<li>Comprehensive resume review</li>
						<li>Leading experts and resources to advance your search</li>
						<li>Library filled with audios, articles and webinars</li>
					</ul>
					<div class="freelancer-info-container-v2">
						<img src="<?php echo Router::url('/',true);?>images/stars.png" alt="image description" />
						<p class="freelancer-info-comment">"Thank you for creating this great search community. Keep up the excellent work, people are greteful and they do sit up and take notice!"</p>
						<p class="freelancer-info-name">John Snow</p>
						<p class="freelancer-info-role">Independent Interpreneur</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="index-form-container-v2">
						<form class="form-signin">
							<button class="btn btn-primary btn-facebook" type="submit">Register using Facebook</button>
						
							<div class="h-separator-v4">
								<hr>
								<span>or</span>
							</div>

							<label for="name">Your full name</label>
							<input type="text" name="name" class="form-control" placeholder="Your full name" required autofocus>
							
							<label for="email" class="open-txt">Email</label>
							<input type="email" name="email" class="form-control" placeholder="john@hrsearchincsite.com" required>
							
							<button class="btn btn-warning btn-large-v2" type="submit">Register a Free Account Now</button>
							
							<p>Already have an account? 
								<a href="<?php echo $strLoginUrl;?>" class="link-primary">Login</a>
							</p>
						</form>
					</div>
				</div>
			</div>
		
		<div class="col-md-1"></div>
		
    </div>
	
	
	
