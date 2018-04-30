<div class="col-md-3 sidebar-container wizard-step-v3">
	<div class="interview-advisor-header"><a href="javascript:void(0);">Interview Advisor</a><!--<span class="arrow"></span>--></div>
	<div class="container-fluid sidebar-main-menu-container wizard-version"> 
            <a href="javascript:void(0)" onclick="displayParticularSection('average_employment');">
			<div class="left-side-bar-element">
				<h3>CAREER ADVISOR – Average Employment</h3>
				<p><?php echo $averagedurationyear; ?></p>
			</div>
		</a>
		<a class="act ive" href="javascript:void(0)" onclick="displayParticularSection('number_of_years_of_employment');">
			<div class="left-side-bar-element">
				<h3>CAREER ADVISOR – Number of Years of Employment</h3>
				<p><?php echo $averagedurationnumber; ?></p>
			</div>
		</a>
		<a href="#" href="javascript:void(0)" onclick="displayParticularSection('gaps_in_employment');">
			<div class="left-side-bar-element">
				<h3>CAREER ADVISOR – Gaps In Employment</h3>
				<p><?php echo $averagedurationgaps; ?></p>
			</div>
		</a>
		<!--<a href="#">
			<div class="left-side-bar-element">
				<h3>Last Time You Worked</h3>
				<p>Less than 1 year ago</p>
			</div>
		</a>-->
	</div>
</div>

<script type="text/javascript">
   function displayParticularSection(sectionName){
        if(sectionName == 'average_employment'){
            $('#averageduration').show();
            $('#numberduration').hide();
            $('#gapsduration').hide();
            $('html, body').animate({
                scrollTop: $("#averageduration").offset().top
            }, 2000);
        }else if(sectionName == 'number_of_years_of_employment'){
            $('#numberduration').show();
            $('#averageduration').hide();
            $('#gapsduration').hide();
            $('html, body').animate({
                scrollTop: $("#numberduration").offset().top
            }, 2000);
        }else if(sectionName == 'gaps_in_employment'){
            $('#gapsduration').show();
            $('#averageduration').hide();
            $('#numberduration').hide();
           $('html, body').animate({
                scrollTop: $("#gapsduration").offset().top
            }, 2000);
        }else{
            $('#averageduration').show();
            $('#numberduration').hide();
            $('#gapsduration').hide();
            $('html, body').animate({
                scrollTop: $("#numberduration").offset().top
            }, 2000);
        }
    }
    
    $(document).ready(function(){
        $('#averageduration').show();
        $('#numberduration').hide();
        $('#gapsduration').hide();
        $('html, body').animate({
                scrollTop: $("#numberduration").offset().top
            }, 2000);
    });
</script>