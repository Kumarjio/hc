<?php
//$strResumeListUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPortalId,'cv'),'true');
$strResumeListUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPortalId,'cv'),true);
?>

<div class="col-md-9 wizard-right-side-container wizard-step-v3 interview-advisor">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 interview-advisor-header"><a href="<?php echo $strResumeListUrl; ?>">&lt; Back to CV / Resumes</a></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 wizard-step-content-container wizard-step-v3">
                <div id="averageduration">
                    <?php
                            echo $averageduration;
                    ?>
                </div>
                <div id="numberduration">
                    <?php
                            echo $numberduration;
                    ?>
                </div>
                <div id="gapsduration">
                    <?php
                            echo $gapsduration;
                    ?>
		</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 wizard-step-aside-container wizard-step-v3 interview-advisor">
		<div class="wizard-aside-inside-container">
			<div class="wizard-aside-resources-container">
				<h3>Recommendations</h3>
				<ul class="resources-list">
					<li><a href="#">Dewey Color Assessment</a></li>
					<li><a href="#">DiSC Assessment Tools</a></li>
					<li><a href="#">Resume Review</a></li>
					<li><a href="#">Re-Think</a></li>
					<li><a href="#">Interview Best</a></li>
					<li><a href="#">Cogliano Courses</a></li>
				</ul>
			</div>
		</div>
	</div>

	</div>