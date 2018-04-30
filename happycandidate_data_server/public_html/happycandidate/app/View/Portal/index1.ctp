<?php
$strLoginUrl = Router::url(array('controller'=>'portal','action'=>'login',$intPortalId),true);
?>
<div class="container-fluid">

		<div class="row">
			<div class="col-md-1"></div>

			<div class="col-md-10">
				
				<div class="page-header-main">
					<div class="item-logotype"></div>
					<h1>Find a Job of Your Dream</h1>
					<p>Our &#35;1 goal is to help you identify opportunities that eventually lead you to choose a career.</p>
				</div>

				<div class="index-content-container">
					<form class="form-signin">
						
						<button class="btn btn-primary btn-facebook" type="submit">Register using Facebook</button>
						
						<div class="h-separator">
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
			<div class="element-container">
				<div class="col-md-6">
					<img src="<?php echo Router::url('/',true);?>images/access.png" alt="image description">
				</div>
				<div class="col-md-6">
					<h2>Access to more than 1,000 job boards</h2>
					<p>When you enter your search criteria during registration, our aggregate job board will now send you an email informing you of jobs that are possible matches.</p>
				</div>
			</div>
			<div class="element-container">
				<div class="col-md-6">
					<h2>Weekly free job seeker webinars with Q&amp;A</h2>
					<p>Learn from top employment experts weekly, by participating in the Weekly FREE job Seeker Webinars. These sessions address topics most important to your search and allow time for you to ask questions.</p>
				</div>
				<div class="col-md-6">
					<img src="<?php echo Router::url('/',true);?>images/webinars.png" alt="image description">
				</div>
			</div>
			<div class="element-container">
				<div class="col-md-6">
					<img src="<?php echo Router::url('/',true);?>images/search.png" alt="image description">
				</div>
				<div class="col-md-6">
					<h2>Access to valuable free job search resources</h2>
					<p>Some of the FREE resources currently offered include: Weekly Training Webinars, Resume Builder, Resume Review, Resume Cards, Assessment, Tools, Trade Publications, Education Information, and much more.</p>
				</div>
			</div>
			<div class="element-container">
				<div class="col-md-6">
					<h2>Comprehensive resume review</h2>
					<p>If you are not scheduling interviews, it could be your resume. Let our team of experts review your resume and provide you with changes that will improve your results.</p>
				</div>
				<div class="col-md-6">
					<img src="<?php echo Router::url('/',true);?>images/resume.png" alt="image description">
				</div>
			</div>
			<div class="element-container">
				<div class="col-md-6">
					<img src="<?php echo Router::url('/',true);?>images/resources.png" alt="image description">
				</div>
				<div class="col-md-6">
					<h2>Leading experts and resources to advance your search</h2>
					<p>We have identified experts who can provide higher level services to you if you prefer to have someone else help progress your search process. We have only selected the "best" experts and services to guide you.</p>
				</div>
			</div>
			<div class="element-container">
				<div class="col-md-6">
					<h2>Library filled with audios, articles and webinars</h2>
					<p>The comprehensive Library is filled with articles, videos, audios and Webinars all providing information that will advance your search. The Weekly Job Seeker Webinars are recorded and then placed in the Library Folders.</p>
				</div>
				<div class="col-md-6">
					<img src="<?php echo Router::url('/',true);?>images/library.png" alt="image description">
				</div>
			</div>
		</div>
		
		<div class="bottom-content-container">
			<form>
				
				<button class="btn btn-primary btn-large" type="submit">Register a Free Account Now</button>
						
				<p>or 
					<a href="#" class="link-primary">Login</a>
				</p>
			</form>
		</div>
	</div>
