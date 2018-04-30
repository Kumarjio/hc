$(document).ready(function () {
	
	fnInitializeTinyMce('#main_content');
	fnInitializeTinyMce('#intro_content');
	fnInitializeTinyMce('#left_content');
	fnInitializeTinyMce('#right_content');
	
	var editor1_visual = '.tinymce-tabs .visual.editor1';
	var editor1_html = '.tinymce-tabs .html.editor1';
	
	
	// Enforce initial active selection
	$(editor1_visual).addClass('active');
	$(editor1_html).removeClass('active');
	
	// Activate the visual tab
	$(editor1_visual).click(function() {
		activateTinyMCETab('visual', editor1_visual, editor1_html, 'main_content');
	});
	
	// Activate the html tab
	$(editor1_html).click(function() {
		activateTinyMCETab('html', editor1_visual, editor1_html, 'main_content');
	});
	
	//alert($('#featured_loaded').val());
	
	var editor2_visual = '.tinymce-tabs .visual.editor2';
	var editor2_html = '.tinymce-tabs .html.editor2';
	
	
	// Enforce initial active selection
	$(editor2_visual).addClass('active');
	$(editor2_html).removeClass('active');
	
	// Activate the visual tab
	$(editor2_visual).click(function() {
		activateTinyMCETab('visual', editor2_visual, editor2_html, 'intro_content');
	});
	
	// Activate the html tab
	$(editor2_html).click(function() {
		activateTinyMCETab('html', editor2_visual, editor2_html, 'intro_content');
	});
	
	var editor3_visual = '.tinymce-tabs .visual.editor3';
	var editor3_html = '.tinymce-tabs .html.editor3';
	
	
	// Enforce initial active selection
	$(editor3_visual).addClass('active');
	$(editor3_html).removeClass('active');
	
	// Activate the visual tab
	$(editor3_visual).click(function() {
		activateTinyMCETab('visual', editor3_visual, editor3_html, 'left_content');
	});
	
	// Activate the html tab
	$(editor3_html).click(function() {
		activateTinyMCETab('html', editor3_visual, editor3_html, 'left_content');
	});
	
	var editor4_visual = '.tinymce-tabs .visual.editor4';
	var editor4_html = '.tinymce-tabs .html.editor4';
	
	
	// Enforce initial active selection
	$(editor4_visual).addClass('active');
	$(editor4_html).removeClass('active');
	
	// Activate the visual tab
	$(editor4_visual).click(function() {
		activateTinyMCETab('visual', editor4_visual, editor4_html, 'right_content');
	});
	
	// Activate the html tab
	$(editor4_html).click(function() {
		activateTinyMCETab('html', editor4_visual, editor4_html, 'right_content');
	});
	
	$('#content_layout_style').change(function () {
		var strSelectedLayout = $(this).val();
		if(strSelectedLayout == "singlecolumn")
		{
			$('#right_content_section').fadeOut('slow');
			$('#left_content_section').fadeOut('slow');
		}
		
		if(strSelectedLayout == "twocolumnleft")
		{
			$('#left_content_section').fadeIn('slow');
			$('#right_content_section').fadeOut('slow');
		}
		if(strSelectedLayout == "twocolumnright")
		{
			$('#right_content_section').fadeIn('slow');
			$('#left_content_section').fadeOut('slow');
		}
		
		if(strSelectedLayout == "threecolumn")
		{
			$('#right_content_section').fadeIn('slow');
			$('#left_content_section').fadeIn('slow');
		}
	});
});