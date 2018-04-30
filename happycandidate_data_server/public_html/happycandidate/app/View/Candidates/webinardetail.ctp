<?php
			$strReturnUrl = Router::url(array('controller'=>'candidates','action'=>'webinars',$intPortalId),true);
			$strHomeReturnUrl = Router::url(array('controller'=>'portal','action'=>'index',$intPortalId),true);
		?>	
		<?php 
		if(count($arrContentDetail)>0)
		{
		?>
	<div class="container-fluid bg-lightest-grey">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10 bg-lightest-grey">
				
				<div class="find-jobs-body">
					
					<div class="col-md-12">
						<div class="simple-container webinar">
						<?php //  print_R($arrContentDetail);?>
							<h2><?php echo stripslashes($arrContentDetail[0]['Content']['content_title']); ?></h2>
							<p class="subtitle">
						</p>
						</div>
						<hr>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
						<div class="simple-container webinar body">
<p><?php
							echo htmlspecialchars_decode(stripslashes($arrContentDetail[0]['Content']['content']));
						?></p>
							
							<!--<p>When: <span class="dark-bold"><?php //echo date($productdateformat,strtotime($arrContentDetail[0]['Content']['content_published_date'])); ?></span><!--<br>Duration: <span class="dark-bold">21 hour</span></p>-->
						</div>
					</div>

					<!--<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
						<a href="<?php echo stripslashes($arrContentDetail[0]['Content']['webinarRegisterLink']); ?>"  target="_blank" class="btn btn-primary btn-large">Register Now <span class="glyphicon glyphicon-chevron-right"></span></a>
					</div>-->
				</div>
				<hr>
				<div id="myCarousel" class="carousel slide carousel-clearfix" data-ride="carousel">
		 
				  	<div class="carousel-inner carousel-grey" role="listbox">
					
						<div class="item active">
							<div class="web-container">
								
								<!--<img src="<?php echo Router::url('/',true);?>images/webinar-author-1.png" alt="image description">
							<img src="<?php echo Router::url('/',true);?>images/webinar-author-2.png" class="other-author" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-3.png" class="other-author" alt="image description">
								 <img src="<?php echo Router::url('/',true);?>images/webinar-author-4.png" class="other-author" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-5.png" class="other-author" alt="image description"> -->
								
								<p class="webinar-description">I know we haven't spoken in 4 years - but I wanted to let you in on how you have helped me.  I think all your missives are great. Straight to the point, helpful, pragmatic --and even inspirational for those who are out seeking new positions. My daughter just graduated from college in May 2015.</p>
								<p class="webinar-description">She is pursuing a teaching career.I saved some old stuff I had from you and your company  - and gave it to her when she began looking for work.   she had been dragging her butt-and not really accomplishing anything. </p>
								<p class="webinar-description">It's a great town which many people would give their right  and left arms to have a job with.   So - hope you are well, and keep up the good work !  We'll speak again someday. </p>
							
								
							
								
								<p class="web-author-name">Chris F.</p>
							</div>
						</div>
						<div class="item">
							<div class="web-container">
								
								<!-- <img src="<?php echo Router::url('/',true);?>images/webinar-author-1.png" class="other-author" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-2.png" alt="image description">
								 <img src="<?php echo Router::url('/',true);?>images/webinar-author-3.png" class="other-author" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-4.png" class="other-author" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-5.png" class="other-author" alt="image description">-->
								
								<p class="webinar-description">Hello,</p>
								 <p class="webinar-description">I am excited to share the GREAT NEWS that I have received and accepted an offer with a company. I started last week.  I'll be working at a medical device company.</p>
								 <p class="webinar-description">Thank you so much for your support and answers to my live and online questions. I listened to many of the webinars several times a week, so the messages and themes sunk in.  I followed most of the 16 step process and directly contacted my target companies. I was averaging about 2-3 interviews per week at different companies.  When a company said no, I said next.  I lived your motto, each month, I declared that phase complete, and started fresh. </p>
								 <p class="webinar-description">For this position, my resume was given to a networking contact, who sent it directly to the president and I interviewed with her and her staff.  The position was created for me, after my successful rounds of interviews. Although my job search was only 4 months long, I had no emergency fund. I was extremely motivated to find a position quickly to provide for my family.  </p>
								<p class="webinar-description">Thanks again for everything. I really appreciated your listening, patience and encouragement.  
Regards,</p>
								<p class="web-author-name">Pamela B.</p>
							</div>
						</div>
						<div class="item">
							<div class="web-container">
								
								<!-- <img src="<?php echo Router::url('/',true);?>images/webinar-author-1.png" class="other-author" alt="image description">
								 <img src="<?php echo Router::url('/',true);?>images/webinar-author-2.png" class="other-author" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-3.png" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-4.png" class="other-author" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-5.png" class="other-author" alt="image description"> -->
								
								<p class="webinar-description">After nearly 18 months of job searching, I finally landed a job with my dream company. Many of the things I learned about my job search came from your awesome webinars.</p>
								 <p class="webinar-description">Often times I would attend one when I was feeling down and just the energy of the speaker would re-energize me.</p>
								 <p class="webinar-description">Now I am helping a handful of friends with their job searches hopefully so they don't have to go through what I went through.  
One quote that helped me through tough times was</p>
<p class="webinar-description">"The key is to stay focused on where you are going and not the fact that you haven’t arrived yet."</p>
<p class="webinar-description">I can't thank you enough for the extremely useful information in your webinars and for giving me hope when I was down.</p>

								
								<p class="web-author-name">Dawn W.</p>
							</div>
						</div>
						<div class="item">
							<div class="web-container">
								
								<!-- <img src="<?php echo Router::url('/',true);?>images/webinar-author-1.png" class="other-author" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-2.png" class="other-author" alt="image description"> 
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-3.png" class="other-author" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-4.png" alt="image description">
								 <img src="<?php echo Router::url('/',true);?>images/webinar-author-5.png" class="other-author" alt="image description">-->
								
								<p class="webinar-description">I just wanted to say thank you for the "Career Advisor" and your website. I used the resources quite a bit in the last few months during my job search. The webinars and other materials were great. </p>
								 <p class="webinar-description">I recently accepted an offer from a Community College. I'll be the new Director of Adult Basic Education/Transition to College & Careers.</p>
								 <p class="webinar-description">exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
								
								<p class="web-author-name">Marie T.<span class="light">, Ph.D.</span></p>
							</div>
						</div>
						<div class="item">
							<div class="web-container">
								
								<!--<img src="<?php echo Router::url('/',true);?>images/webinar-author-1.png" class="other-author" alt="image description">
							<img src="<?php echo Router::url('/',true);?>images/webinar-author-2.png" class="other-author" alt="image description"> 
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-3.png" class="other-author" alt="image description"> 
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-4.png" class="other-author" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-5.png" alt="image description"> -->
								
								 <p class="webinar-description">After a 13-month job search to change career tracks, I got two offers in one week!  Both were through networking contacts, and the role I accepted is within the group of a networking relationship that I cultivated for four months. </p>
								 <p class="webinar-description">I think that positive perseverance was the most critical part to being successful in my search. Knowing that it would happen, keeping at it, and sharing that optimism with anyone who inquired about my search. Who wants to help a Debbie downer?  </p>
								 <p class="webinar-description">Early in my search, I heard one of the webinars that mentioned a positivity toolbox. From that day forward, I kept a positivity log on my refrigerator that grew in pages and kept me focused on what was going well, both in the actual search and also in terms of the other opportunities that a flexible schedule presented. </p>
								<p class="webinar-description">Thanks for the wisdom and resources!</p>
								<p class="webinar-description">Best wishes as you assist more people,</p>
								<p class="web-author-name">Molly C.</p>
							</div>
						</div>
							<div class="item">
							<div class="web-container">
								
								<!-- <img src="<?php echo Router::url('/',true);?>images/webinar-author-1.png" class="other-author" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-2.png" class="other-author" alt="image description"><!-- 
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-3.png" class="other-author" alt="image description"><!-- 
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-4.png" class="other-author" alt="image description"><!-- 
								 <img src="<?php echo Router::url('/',true);?>images/webinar-author-5.png" alt="image description">-->
								
								 <p class="webinar-description">Very concise and informative with a Step-by-Step approach. </p>
								 <p class="webinar-description">In addition to instructions ... I felt honest concern and effective coaching.</p>
								 <p class="webinar-description">I will attend others by this speaker because the speaker kept me interested and delivered facts with comfortable momentum. </p>
								
								<p class="web-author-name">Lisette P.</p>
							</div>
						</div>
						
							<div class="item">
							<div class="web-container">
								
								<!-- <img src="<?php echo Router::url('/',true);?>images/webinar-author-1.png" class="other-author" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-2.png" class="other-author" alt="image description"><!-- 
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-3.png" class="other-author" alt="image description"><!-- 
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-4.png" class="other-author" alt="image description"><!-- 
								 <img src="<?php echo Router::url('/',true);?>images/webinar-author-5.png" alt="image description">-->
								
								 <p class="webinar-description">I observed this seminar “Don’t Interview, Audition” and thought it provided valuable information: </p>
								 <p class="webinar-description">She spoke to multiple levels of audience – new and savvy interviewers</p>
								 <p class="webinar-description">She gave me a few unique tools to use in my job search and interviews </p>
								 <p class="webinar-description">  I already used one, `I feel positions I have had until now have been stepping stones preparing me for this position` in an interview already.</p>
								
								<p class="web-author-name">Martha C.<span class="light">, B.Sc. (Food Science), M.Sc. (Biochemistry)
</span></p>
							</div>
						</div>
						
						<div class="item">
							<div class="web-container">
								
								<!-- <img src="<?php echo Router::url('/',true);?>images/webinar-author-1.png" class="other-author" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-2.png" class="other-author" alt="image description"><!-- 
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-3.png" class="other-author" alt="image description"><!-- 
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-4.png" class="other-author" alt="image description"><!-- 
								 <img src="<?php echo Router::url('/',true);?>images/webinar-author-5.png" alt="image description">-->
								
								 <p class="webinar-description">Thank you VERY much for answering my email.  As it turns out, I was on the Webinar from 4 to 4:12, then again from 4:32 to the end.  It was great as usual -- look forward to hearing the bit I missed when posted.</p>
								 <p class="webinar-description">Great advice below.  I was always under the impression that companies could not find out from your previous company how much you made, but guess that is different in today's internet world.  I probably would lose sleep over fibbing anyway as that is not my first instinct.</p>
								 <p class="webinar-description">I realize I left out that I am an Executive Assistant -- which means I can work in any industry, just had the good fortune in my past to work in high-paying industries in NYC.  So was not a financial person in the "true" sense (if that makes any difference).
Thanks again and have a great day! </p>
								 <p class="webinar-description"> Looking forward to your next webinar as I truly appreciate your no-nonsense, smart advice.</p>
								
								<p class="web-author-name">Bethany<span class="light">
</span></p>
							</div>
						</div>
						
						<div class="item">
							<div class="web-container">
								
								<!-- <img src="<?php echo Router::url('/',true);?>images/webinar-author-1.png" class="other-author" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-2.png" class="other-author" alt="image description"><!-- 
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-3.png" class="other-author" alt="image description"><!-- 
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-4.png" class="other-author" alt="image description"><!-- 
								 <img src="<?php echo Router::url('/',true);?>images/webinar-author-5.png" alt="image description">-->
								
								 <p class="webinar-description">Thanks for providing this great opportunity. I am happy I signed up, I found the webinar very beneficial and inspiring.</p>
								
							
								<p class="web-author-name">Miriam B.<span class="light">
</span></p>
							</div>
						</div>
						
							<div class="item">
							<div class="web-container">
								
								<!-- <img src="<?php echo Router::url('/',true);?>images/webinar-author-1.png" class="other-author" alt="image description">
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-2.png" class="other-author" alt="image description"><!-- 
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-3.png" class="other-author" alt="image description"><!-- 
								<img src="<?php echo Router::url('/',true);?>images/webinar-author-4.png" class="other-author" alt="image description"><!-- 
								 <img src="<?php echo Router::url('/',true);?>images/webinar-author-5.png" alt="image description">-->
								
								 <p class="webinar-description">Hello Team!</p>
								  <p class="webinar-description">I truly enjoyed the Informative "Resume Myths" Webinar. I feel that I received a lot of great information that will help me land in a successful job.</p>
								
							<p class="webinar-description">I will definitely return to the website to gain more information.</p>
							<p class="webinar-description">I really felt that I received personal help as all my questions were answered professionally - Thank You so much!</p>

								<p class="web-author-name">Isabelle L.<span class="light">
</span></p>
							</div>
						</div>
						
				    </div>
				    <a class="webinar left carousel-control" href="#myCarousel" role="button" data-slide="prev">
						<span class="sr-only">Previous</span>
				    </a>
				    <a class="webinar right carousel-control" href="#myCarousel" role="button" data-slide="next">
						<span class="sr-only">Next</span>
				    </a>
				</div>

			</div>
			<div class="col-md-1"></div>
		</div>
	</div>
	
	<?php }
	else
	{

	?>
	<div class="container-fluid bg-lightest-grey">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<h1 class="error-main-heading">Not Found Webinar</h1>
			<p class="error-description">Aenean tempor congue scelerisque. Nam non nunc sit amet nulla lobortis rutrum sed ac justo. Sed sollicitudin volutpat ipsum. Nunc ut augue ligula. </p>
			<div class="goto-from-error">
                            <a class="btn btn-primary btn-md" href="<?php echo $strHomeReturnUrl;?>"><span class="glyphicon glyphicon-chevron-left"></span> Back to the Home Page</a>
			</div>
		</div>
		<div class="col-md-3"></div>
	</div>
	<?php
	
	}?>
	<!--	
<div class="container-fluid bg-lightest-grey">

		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10 bg-lightest-grey">
				
				<div class="page-header">
					<a class="link-default" href="<?php echo $strReturnUrl;?>"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
				</div>
				<div class="find-jobs-body">
					<div class="col-md-9">
						<div class="webinar-container">
							<h3><?php echo stripslashes($arrContentDetail[0]['Content']['content_title']); ?></h3>
							<p class="webinar-subheader"><?php echo date('M j, Y ',strtotime($arrContentDetail[0]['content']['created_date'])); ?></p>
							<p><?php
							echo htmlspecialchars_decode(stripslashes($arrContentDetail[0]['Content']['content']));
						?></p>
							
							
						</div>
					</div>

				<!--	<div class="col-md-3">
						<button class="btn btn-primary btn-large" type="button">Register Now <span class="glyphicon glyphicon-chevron-right"></span></button><br>
						<button class="btn btn-default btn-large" type="button"><span class="glyphicon glyphicon-heart"></span> Save Webinar</button>

						<div class="job-search-options-container">
							
							<form role="form">
								<div class="form-group">
									<label for="category">Category</label>
									<select title="category" class="form-control" name="category">
										<option value="value1">All</option>
										<option value="value1">Graphic Design</option>
										<option value="value2">HTML</option>
										<option value="value3">CSS</option>
										<option value="value4">Java Script</option>
									</select>
								</div>
							</form>

							<div class="webinar-description">
								<h3>Start this month</h3>
								<p>How to Get a Job of Your Dream</p>
								<p class="webinar-subparagraph">Oct 2, 2015 - Start: 12:00 (EST)</p>
								<p class="par-primary">Create Stunning Resume</p>
								<p class="webinar-subparagraph">Oct 15, 2015 - Start: 15:00 (EST)</p>
								<p>Prepare to Your First Interview</p>
								<p class="webinar-subparagraph">Oct 18, 2015 - Start: 10:00 (EST)</p>
							</div>

						</div>
					</div>-->

					
				</div>
				<!--<div class="webinars-bottom">
					<h3>Related Webinars</h3>
					<div class="col-md-3">
							<div class="webinar-container">
								<div class="webinar-image"></div>
								<h4 class="heading-primary">Is Your LinkedIn Profile Replacing Your Resume or CV? 
									<span class="ellipsis">
							            …
							        </span>
							        <span class="fill"></span>
        						</h4>
								<p class="webinar-element-subheader">Oct 2, 2015 - Start: 12:00 (EST)</p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="webinar-container">
								<div class="webinar-image"></div>
								<h4>How to Get a Job of Your Dream
									<span class="ellipsis">
							            …
							        </span>
							        <span class="fill"></span>
								</h4>
								<p class="webinar-element-subheader">Oct 2, 2015 - Start: 12:00 (EST)</p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="webinar-container">
								<div class="webinar-image"></div>
								<h4>Prepare to Your First Intreview: Useful Tips
									<span class="ellipsis">
							            …
							        </span>
							        <span class="fill"></span>
								</h4>
								<p class="webinar-element-subheader">Oct 2, 2015 - Start: 12:00 (EST)</p>
							</div>
						</div>
				</div>
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>-->