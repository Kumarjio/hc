<?php
	$strWebinarUrl = Router::url(array('controller'=>'candidates','action'=>'webinars',$intPortalId),true);
	$strLibraryUrl = Router::url(array('controller'=>'candidates','action'=>'library',$intPortalId),true);
	$strJobSearchTrackerUrl = Router::url(array('controller'=>'jstracker','action'=>'index',$intPortalId),true);
	$strLoginUrl = Router::url(array('controller'=>'portal','action'=>'login',$intPortalId),true);
?>

 <div class="container-fluid">

		<div class="row">
			<div class="col-md-1"></div>

			<div class="col-md-10">
				
				<div class="page-header-main">
					<h1>Find a Job of Your Dream</h1>
					<p>Our &#35;1 goal is to help you identify opportunities that eventually lead you to choose a career.</p>
				</div>

				<div class="index-content-container">
					<form class="form-signin">
						
						<button class="btn btn-primary btn-facebook" type="submit">Register using Facebook</button>
						
						<div class="h-separator-v3">
							<hr>
							<span>or</span>
						</div>
						
						<label for="name">Your full name</label>
						<input type="text" name="name" class="form-control" placeholder="Your full name" required autofocus>
						
						<label for="email" class="open-txt">Email</label>
						<input type="email" name="email" class="form-control" placeholder="john@hrsearchincsite.com" required>
						
						<button class="btn btn-primary btn-large" type="submit">Register a Free Account Now</button>
						
						<p>or 
							<a href="<?php echo $strLoginUrl;?>" class="link-primary">Login</a>
						</p>
					</form>
				</div>
			</div>

			<div class="col-md-1"></div>
		</div>

		<div class="row">
			<div class="index-data-container">
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="index-data-element-container">
						<h3><img src="<?php echo Router::url('/',true);?>images/gr-check.png" alt="image_description">Access to more than 1,000 job boards dfsdfs dsfsdfs sdfsdfs</h3>
						<p>When you enter your search criteria during registration, our aggregate job board will now send you an email informing you of jobs that are possible matches.</p>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="index-data-element-container">
						<h3><img src="<?php echo Router::url('/',true);?>images/gr-check.png" alt="image_description">Weekly free job seeker webinars with Q&amp;A</h3>
						<p>Learn from top employment experts weekly, by participating in the Weekly FREE Job Seeker Webinars. These sessions address topics most important to your search and allow time for you to ask questions.</p>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="index-data-element-container">
						<h3><img src="<?php echo Router::url('/',true);?>images/gr-check.png" alt="image_description">Access to valuable free job search resources</h3>
						<p>Some of the FREE resources currently offered include: Weekly Training Webinars, Resume Builder, Resume Review, Resume Cards, Assessment, Tools, Trade Publications, Education Information, and much more.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="index-data-container">
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="index-data-element-container">
						<h3><img src="<?php echo Router::url('/',true);?>images/gr-check.png" alt="image_description">Comprehensive resume review</h3>
						<p>If you are not scheduling interviews, it could be your resume. Let our team of experts review your resume and provide you with changes that will improve your results.</p>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="index-data-element-container">
						<h3><img src="<?php echo Router::url('/',true);?>images/gr-check.png" alt="image_description">Leading experts and resources to advance your search</h3>
						<p>We have identified experts who can provide higher level services to you if you prefer to have someone else help progress your search process. We have only selected the "best" experts and services to guide you.</p>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="index-data-element-container">
						<h3><img src="<?php echo Router::url('/',true);?>images/gr-check.png" alt="image_description">Library filled with audios, articles and webinars</h3>
						<p>The comprehensive Library is filled with articles, videos, audios and Webinars all providing information that will advance your search. The Weekly Job Seeker Webinars are recorded and then placed in the Library Folders.</p>
					</div>
				</div>
			</div>
		
		</div>
	</div>
	<div class="container-fluid">
		<div id="myCarousel" class="carousel slide" data-ride="carousel">

		  	<div class="carousel-inner" role="listbox">
				<div class="item active">
					<div class="profiles-container-v3">
						<img src="<?php echo Router::url('/',true);?>images/stars.png" alt="image description" />
						<p class="freelancer-info-comment-v3">"Thank you for creating this great search community. Keep up the excellent work, people are greteful and they do sit up and take notice!"</p>
						<img src="<?php echo Router::url('/',true);?>images/icon-freelancer.png" alt="image description" />
						<p class="freelancer-info-name-v3">John Snow</p>
						<p class="freelancer-info-role">Independent Interpreneur</p>
					</div>
				</div>
				<div class="item">
					<div class="profiles-container-v3">
						<img src="<?php echo Router::url('/',true);?>images/stars.png" alt="image description" />
						<p class="freelancer-info-comment-v3">"Thank you for creating this great search community. Thank you for creating this great search community."</p>
						<img src="<?php echo Router::url('/',true);?>images/icon-freelancer.png" alt="image description" />
						<p class="freelancer-info-name-v3">John Snow 2</p>
						<p class="freelancer-info-role">Independent Interpreneur</p>
					</div>
				</div>
				<div class="item">
					<div class="profiles-container-v3">
						<img src="<?php echo Router::url('/',true);?>images/stars.png" alt="image description" />
						<p class="freelancer-info-comment-v3">"Keep up the excellent work, people are greteful and they do sit up and take notice! Thank you for creating this great search community."</p>
						<img src="<?php echo Router::url('/',true);?>images/icon-freelancer.png" alt="image description" />
						<p class="freelancer-info-name-v3">John Snow 3</p>
						<p class="freelancer-info-role">Independent Interpreneur</p>
					</div>
				</div>
				<div class="item">
					<div class="profiles-container-v3">
						<img src="<?php echo Router::url('/',true);?>images/stars.png" alt="image description" />
						<p class="freelancer-info-comment-v3">"Thank you for creating this great search community. Keep up the excellent work, people are greteful and they do sit up and take notice! Thank you for creating this great search community."</p>
						<img src="<?php echo Router::url('/',true);?>images/icon-freelancer.png" alt="image description" />
						<p class="freelancer-info-name-v3">John Snow 4</p>
						<p class="freelancer-info-role">Independent Interpreneur</p>
					</div>
				</div>
		  	</div>
			<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
				<!-- <span aria-hidden="true"></span> -->
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
				<span aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>

		<!-- <div class="bottom-content-container">
			<form>
				
				<button class="btn btn-primary btn-large" type="submit">Register a Free Account Now</button>
						
				<p>or 
					<a href="#" class="link-primary">Login</a>
				</p>
			</form>
		</div> -->
	</div>
