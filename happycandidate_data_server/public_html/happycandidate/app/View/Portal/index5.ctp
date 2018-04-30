<?php
	$strWebinarUrl = Router::url(array('controller'=>'candidates','action'=>'webinars',$intPortalId),true);
	$strLibraryUrl = Router::url(array('controller'=>'candidates','action'=>'library',$intPortalId),true);
	$strJobSearchTrackerUrl = Router::url(array('controller'=>'jstracker','action'=>'index',$intPortalId),true);
	$strLoginUrl = Router::url(array('controller'=>'portal','action'=>'login',$intPortalId),true);
?>

 		<div class="container-fluid top-bg-v6">
		<a href="#" class="logo-inverse">
			<img src="<?php echo Router::url('/',true);?>images/icon-search-grey.png" alt="logo description">
			HR Search
		</a>
		<a href="<?php echo $strLoginUrl;?>" class="link-inverse right-menu-v6">Login</a>
		
		<div id="panel" class="top-slider-v6">
			
			<h1>Find a Job of Your Dream</h1>
			<h2>Our &#35;1 goal is to help you identify opportunities that eventually lead you to choose a career.</h2>

			<form class="form-signin">
				
				<button class="btn btn-primary btn-facebook" type="submit">Register using Facebook</button>
				
				<div class="h-separator-v6">
					<hr>
					<span>or</span>
					<hr>
				</div>
				
				<label for="name">Your full name</label>
				<input type="text" name="name" class="form-control" placeholder="Your full name" required autofocus>
				
				<label for="email">Email</label>
				<input type="text" name="email" class="form-control" placeholder="john@hrsearchincsite.com" required>
				
				<button class="btn btn-attention btn-large-v6" type="submit">Register a Free Account Now</button>
			</form>
		</div>
		
		<div id="flip" class="expanded">
			<img id="arrup" src="<?php echo Router::url('/',true);?>images/arr-up.png" alt="image description">
			<img id="arrdown" src="<?php echo Router::url('/',true);?>images/arr-down.png" alt="image description">
		</div>
	</div>
	
	<div class="container-fluid">
		
		<div class="row">
			
			<div class="elements-container-v6">
				<div class="col-md-4">
					<img src="<?php echo Router::url('/',true);?>images/access-small.png" alt="image description">
					<h2>Access to more than 1,000 job boards</h2>
					<p>When you enter your search criteria during registration, our aggregate job board will now send you an email informing you of jobs that are possible matches.</p>
				</div>
				<div class="col-md-4">
					<img src="<?php echo Router::url('/',true);?>images/webinars-small.png" alt="image description">
					<h2>Weekly free job seeker webinars with Q&amp;A</h2>
					<p>Learn from top employment experts weekly, by participating in the Weekly FREE job Seeker Webinars. These sessions address topics most important to your search and allow time for you to ask questions.</p>
				</div>
				<div class="col-md-4">
					<img src="<?php echo Router::url('/',true);?>images/search-small.png" alt="image description">
					<h2>Access to valuable free job search resources</h2>
					<p>Some of the FREE resources currently offered include: Weekly Training Webinars, Resume Builder, Resume Review, Resume Cards, Assessment, Tools, Trade Publications, Education Information, and much more.</p>
				</div>
			</div>
			<div class="elements-container-v6">
				<div class="col-md-4">
					<img src="<?php echo Router::url('/',true);?>images/resume-small.png" alt="image description">
					<h2>Comprehensive resume review</h2>
					<p>If you are not scheduling interviews, it could be your resume. Let our team of experts review your resume and provide you with changes that will improve your results.</p>
				</div>
				<div class="col-md-4">
					<img src="<?php echo Router::url('/',true);?>images/resources-small.png" alt="image description">
					<h2>Leading experts and resources to advance your search</h2>
					<p>We have identified experts who can provide higher level services to you if you prefer to have someone else help progress your search process. We have only selected the "best" experts and services to guide you.</p>
				</div>
				<div class="col-md-4">
					<img src="<?php echo Router::url('/',true);?>images/library-small.png" alt="image description">
					<h2>Library filled with audios, articles and webinars</h2>
					<p>The comprehensive Library is filled with articles, videos, audios and Webinars all providing information that will advance your search. The Weekly Job Seeker Webinars are recorded and then placed in the Library Folders.</p>
				</div>
			</div>
		</div>
	</div>
    
    <div class="container-fluid no-padding">
		
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
		 
		  	<div class="carousel-inner carousel-light" role="listbox">
			
				<div class="item active">
					<div class="profiles-container-v6">
						
						<img src="<?php echo Router::url('/',true);?>images/stars.png" alt="image description">
						
						<p class="freelancer-info-comment-v6">"Thank you for creating this great search community. Keep up the excellent work, people are greteful and they do sit up and take notice!"</p>
						
						<img src="<?php echo Router::url('/',true);?>images/icon-freelancer.png" alt="image description">
						
						<p class="freelancer-info-name">John Snow</p>
						<p class="freelancer-info-role">Independent Interpreneur</p>
					</div>
				</div>
				<div class="item">
					<div class="profiles-container-v6">
						<img src="<?php echo Router::url('/',true);?>images/stars.png" alt="image description">
						<p class="freelancer-info-comment-v6">"Thank you for creating this great search community. Thank you for creating this great search community."</p>
						<img src="<?php echo Router::url('/',true);?>images/icon-freelancer.png" alt="image description">
						<p class="freelancer-info-name">John Snow 2</p>
						<p class="freelancer-info-role">Independent Interpreneur</p>
					</div>
				</div>
				<div class="item">
					<div class="profiles-container-v6">
						<img src="<?php echo Router::url('/',true);?>images/stars.png" alt="image description">
						<p class="freelancer-info-comment-v6">"Keep up the excellent work, people are greteful and they do sit up and take notice! Thank you for creating this great search community."</p>
						<img src="<?php echo Router::url('/',true);?>images/icon-freelancer.png" alt="image description">
						<p class="freelancer-info-name">John Snow 3</p>
						<p class="freelancer-info-role">Independent Interpreneur</p>
					</div>
				</div>
				<div class="item">
					<div class="profiles-container-v6">
						<img src="<?php echo Router::url('/',true);?>images/stars.png" alt="image description">
						<p class="freelancer-info-comment-v6">"Thank you for creating this great search community. Keep up the excellent work, people are greteful and they do sit up and take notice! Thank you for creating this great search community."</p>
						<img src="<?php echo Router::url('/',true);?>images/icon-freelancer.png" alt="image description">
						<p class="freelancer-info-name">John Snow 4</p>
						<p class="freelancer-info-role">Independent Interpreneur</p>
					</div>
				</div>
		  </div>
		  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			<span class="sr-only">Next</span>
		  </a>
		</div>
		<div class="bottom-content-container">
			<form>
				
				<button class="btn btn-primary btn-large" type="submit">Register a Free Account Now</button>
						
				<p>or 
					<a href="<?php echo $strLoginUrl;?>" class="link-primary">Login</a>
				</p>
			</form>
		</div>
    </div>
