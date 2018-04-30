<div class="container-fluid wizard-content-container wizard-step-v3 main-mobile-menu-hidden interview-advisor">
	<div class="row  main-mobile-menu">
		<?php
			echo $this->element('advisor_left_facts');
		?>
		<?php
			echo $this->element('advisor_content');
		?>
	</div>
</div>
	<script type="text/javascript">
	$(document).ready(function () {

		var header_height = $('.top-menu-container.wizard-step-v3').height();
		var footer_height = $('footer').height();
		var interview_advisor_header_heigth = $('.interview-advisor-header').height();
		$('footer').css("position", "fixed");
		$('footer').css("bottom", 0);
		$('footer').css("width", "100%");

		var current_window_height = $( window ).height() - header_height - footer_height;
		$('.sidebar-container.wizard-step-v3, .wizard-step-aside-container.wizard-step-v3, .wizard-right-side-container.wizard-step-v3').css("top", header_height + "px");

		$('.sidebar-container.wizard-step-v3, .wizard-step-aside-container.wizard-step-v3, .wizard-step-content-container.wizard-step-v3').css("height", (current_window_height - 51) + "px");
	});
	</script>