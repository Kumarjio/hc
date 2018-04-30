<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php 
			echo "Happy Candidates"; 
		?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('hometheme/style');
		echo $this->Html->css('hometheme/reset');
		echo $this->Html->css('hometheme/slider');
		echo $this->Html->css('hometheme/jquery.jscrollpane');

		/*echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
		echo $this->Html->script('jquery/jquery');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en');
		echo $this->Html->script('jquery/validationplugin/validationengine/js/jquery.validationEngine');
		echo $this->Html->script('common');
		
		echo $this->Html->css('jqueryvalidationplugin/validationEngine.jquery');*/
	?>
<style>
	.madatsym
	{
		color:#EE3322;
	}
	
	#header-candy img {
		display:none;
	}
</style>
</head>
<body>
	<!--Start top Nav 1-->
	<div id="top-nav">
		<div class="wrapper">
			<?php
				if($logged_in)
				{
					?>
						<span class="nav-1 fright"><a href="javascript:void()" class="selected">My Profile</a>	   |	<a href="javascript:void()">Conacts Us</a>	    |	<?php echo $this->Html->link('Logout',array('controller'=>'users','action'=>'logout')); ?></span>
					<?php
				}
				else
				{
					?>
					<span class="nav-1 fright">
					<?php
						if($this->params['controller'] != "home")
						{
							?>
								<?php echo $this->Html->link("Home",array('controller'=>'home','action'=>'index'));?> 
							<?php
						}
						
						if($this->params['controller'] != "Employers")
						{
							?>
								<?php echo $this->Html->link("Employer's Zone",array('controller'=>'employers','action'=>'index'));?> 
							<?php
						}
					?>
					</span>
					<?php

				}
			?>
		</div>
	</div>
	<!--Start main Nav 2-->
	<div class="main-nav-panel padding-top-5">
			<div class="wrapper">
				<span class="fleft"><img src="<?php echo Router::url('/', true); ?>img/hometheme/img/logo.png" alt="logo"/></span>
                                <?php $strEmployersContactUsUrl = Router::url(array('controller' => 'home', 'action' => 'contactus'),true);?>
				<ul>
					<li><a href="javascript:void(0);" class="home-icon">Home</a></li>
					<li><a href="javascript:void(0);">About us</a></li>
					<li><a href="javascript:void(0);">Jobs</a></li>
                                        <li><a href="<?php echo $strEmployersContactUsUrl; ?>">Contact us</a></li>
				</ul>
			</div>
	</div>
	<!--Start Header -->
	<!--<div id="header-candy">
		<img src="<?php echo Router::url('/', true); ?>img/hometheme/img/header-img.jpg" alt="" />
	</div>-->
	<!--Start Search -->
	<div id="jop_search" class="jop_search">
		<div class="wrapper">
			<h2>Search</h2>
			<ul class="panel-2 margin-top-5">
				<li><label>Keywords, Skills, Designation</label>
				<input type="text" placeholder="Keywords"/>
				</li>
				<li><label>Location</label>
				<input type="text" placeholder="Location"/>
				</li>
				<li><label>Job Category</label>
				<input type="text" placeholder="Category"/>
				</li>
				<li><label>Exp.</label>
				<select>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
				</select>
				</li>
				<li><label>Salary Expectation</label>
				<select>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
				</select>
				</li>
				<li>
					<input type="submit" value="Search"/>
				</li>
			</ul>
		</div>
	</div>
	<!--Start latest job -->
	<div class="latest-jobs">
		<div class="wrapper">
			<h2>Latest Jobs</h2>
		<div id="ca-container" class="ca-container">
					<div class="ca-wrapper">
						<div class="ca-item ca-item-1">
							<div class="ca-item-main">
								<div class="ca-icon"></div>
								<h3>Product Software</h3>
								<em>BPO Jobs </em>
									<a href="javascript:void(0);" class="ca-more">Post Date: <label>21 sep. - 30 Dec.</label> >></a>
							</div>
							<div class="ca-content-wrapper">
								<div class="ca-content">
									<h6>Jobs Complete Details</h6>
									<a href="javascript:void(0);" class="ca-close">close</a>
									<div class="ca-content-text">
										<p>I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now.</p>
										
									</div>
									<ul>
										<li><a href="javascript:void(0);">Share this</a></li>
										<li><a href="javascript:void(0);">Become a member</a></li>
										<li><a href="javascript:void(0);">Donate</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="ca-item ca-item-2">
							<div class="ca-item-main">
								<div class="ca-icon"></div>
								<h3>Product Software</h3>
								<em>BPO Jobs </em>
									<a href="javascript:void(0);" class="ca-more">Post Date: <label>21 sep. - 30 Dec.</label> >></a>
							</div>
							<div class="ca-content-wrapper">
								<div class="ca-content">
									<h6>Jobs Complete Details</h6>
									<a href="javascript:void(0);" class="ca-close">close</a>
									<div class="ca-content-text">
										<p>I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now.</p>
										
									</div>
									<ul>
										<li><a href="javascript:void(0);">Share this</a></li>
										<li><a href="javascript:void(0);">Become a member</a></li>
										<li><a href="javascript:void(0);">Donate</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="ca-item ca-item-3">
							<div class="ca-item-main">
								<div class="ca-icon"></div>
								<h3>Product Software</h3>
								<em>BPO Jobs </em>
									<a href="javascript:void(0);" class="ca-more">Post Date: <label>21 sep. - 30 Dec.</label> >></a>
							</div>
							<div class="ca-content-wrapper">
								<div class="ca-content">
									<h6>Jobs Complete Details</h6>
									<a href="javascript:void(0);" class="ca-close">close</a>
									<div class="ca-content-text">
										<p>I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now.</p>
										
									</div>
									<ul>
										<li><a href="javascript:void(0);">Share this</a></li>
										<li><a href="javascript:void(0);">Become a member</a></li>
										<li><a href="javascript:void(0);">Donate</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="ca-item ca-item-4">
							<div class="ca-item-main">
								<div class="ca-icon"></div>
								<h3>Product Software</h3>
								<em>BPO Jobs </em>
									<a href="javascript:void(0);" class="ca-more">Post Date: <label>21 sep. - 30 Dec.</label> >></a>
							</div>
							<div class="ca-content-wrapper">
								<div class="ca-content">
									<h6>Jobs Complete Details</h6>
									<a href="javascript:void(0);" class="ca-close">close</a>
									<div class="ca-content-text">
										<p>I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now.</p>
										
									</div>
									<ul>
										<li><a href="javascript:void(0);">Share this</a></li>
										<li><a href="javascript:void(0);">Become a member</a></li>
										<li><a href="javascript:void(0);">Donate</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="ca-item ca-item-5">
							<div class="ca-item-main">
								<div class="ca-icon"></div>
								<h3>Product Software</h3>
								<em>BPO Jobs </em>
									<a href="javascript:void(0);" class="ca-more">Post Date: <label>21 sep. - 30 Dec.</label> >></a>
							</div>
							<div class="ca-content-wrapper">
								<div class="ca-content">
									<h6>Jobs Complete Details</h6>
									<a href="javascript:void(0);" class="ca-close">close</a>
									<div class="ca-content-text">
										<p>I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now.</p>
										
									</div>
									<ul>
										<li><a href="javascript:void(0);">Share this</a></li>
										<li><a href="javascript:void(0);">Become a member</a></li>
										<li><a href="javascript:void(0);">Donate</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
		</div>
	</div>
	<!--Start content Part -->
	<div class="content-info">
		<div class="wrapper">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth'); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<br class="clear"/>
	</div>
	<!--Start footer -->

	<div id="footer">
		<div class="wrapper">
			<ul>
				<li>Employers</li>
				<li><a href="javascript:void(0);">Post Jobs Access </a></li>
				<li><a href="javascript:void(0);">Database Manage  </a></li>
				<li><a href="javascript:void(0);">Responses Buy </a></li>
				<li><a href="javascript:void(0);">Online Report A </a></li>
				<li><a href="javascript:void(0);">Contact Us FAQs  </a></li>
				<li><a href="javascript:void(0);">With Us Site Map  </a></li>
			</ul>
			<ul>
				<li>Information About Us </li>
				<li><a href="javascript:void(0);">Post Jobs Access </a></li>
				<li><a href="javascript:void(0);">Database Manage  </a></li>
				<li><a href="javascript:void(0);">Responses Buy </a></li>
				<li><a href="javascript:void(0);">Online Report A </a></li>
				<li><a href="javascript:void(0);">Contact Us FAQs  </a></li>
				<li><a href="javascript:void(0);">With Us Site Map  </a></li>
			</ul>
			<ul>
				<li>FastForward Resume</li>
				<li><a href="javascript:void(0);">Post Jobs Access </a></li>
				<li><a href="javascript:void(0);">Database Manage  </a></li>
				<li><a href="javascript:void(0);">Responses Buy </a></li>
				<li><a href="javascript:void(0);">Online Report A </a></li>
				<li><a href="javascript:void(0);">Contact Us FAQs  </a></li>
				<li><a href="javascript:void(0);">With Us Site Map  </a></li>
			</ul>
		</div>
	</div>


	<div class="copyright">All rights reserved © 2013 Ltd. </div>
	<?php echo $this->element('sql_dump'); ?>
	<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>-->
	<?php
		echo $this->Html->script('jquery/jquery-1.6.2.min');
	?>
	<?php
			echo $this->Html->script('hometheme/jquery/jquery.easing.1.3');
	?>
	<!-- the jScrollPane script -->
	<?php
			echo $this->Html->script('hometheme/jquery/jquery.mousewheel');
	?>
	<?php
			echo $this->Html->script('hometheme/jquery/jquery.contentcarousel');
	?>
	<script type="text/javascript">
		$('#ca-container').contentcarousel();
	</script>
</body>
</html>
