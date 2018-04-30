<?php
	//echo $this->Html->script('portal_contactus.js');
	/*print("<pre>");
	print_r($arrContactFormDetail);*/
	
	if(isset($strHidden))
	{
		?>
			<div id="contactus-<?php echo $portal_id."_".$widget_id."_".$theme_id; ?>" class="contact_us" style="display:none;cursor:move;">
		<?php
	}
	else
	{
		?>
			<div id="contactus-<?php echo $portal_id."_".$widget_id."_".$theme_id; ?>" class="contact_us" style="cursor:move;">
		<?php
	}
?>
	<div class="wrapper">
		<div>
			&nbsp;
			<!--<span style="font-size: 10px;position: relative;top:0px;display:none;cursor:pointer;vertical-align:top;" id="contact_us_manage" onclick="fnShowContactCustomizer();">Manage</span>-->
			<h2>Contact Us</h2>
			<?php 
				$strContactUsUrl = Router::url(array('controller'=>'portal','action'=>'contactus',$portal_id),true);
			?>
			<form style="margin-left:-34px;" name="contactusformg" id="contactusformf"  method="POST" action="<?php echo $strContactUsUrl; ?>">
                                <ul class="panel-2 margin-top-5">
                                    <label id="contact_field_6_label" for="name">Your Name
                                    <span id="madatsym_6" class="madatsym">*</span></label>
                                    <input class="form-control" required pattern="[A-Za-z]+\s[A-Za-z]+" title="Firstname Lastname" name="name" id="name" type="text">

                                    <label id="contact_field_3_label" for="email">Your Email
                                    <span id="madatsym_3" class="madatsym">*</span></label>
                                    <input class="form-control" required name="email" id="email" type="email">

                                    <label id="contact_field_7_label" for="message">Your Message
                                    <span id="madatsym_7" class="madatsym">*</span></label>
                                    <textarea style="color: black;" class="basiceditor form-control"  required rows="5" cols="55" name="message" id="message"></textarea>
                                    <input name="data[portal_id]" value="<?php echo $portal_id ?>" id="portal_id" type="hidden">
                                    <input name="data[contact_form_id]" value="<?php echo $arrContactFormDetail[0]['PortalContactForm']['career_portal_contact_us_form_id'] ?>" id="contact_form_id" type="hidden">
                                    <input class="btn register-btn" name="Submit" value="Submit" type="submit">			
				</ul>
			</form>
			
		</div>
	</div>
</div>
<?php
	echo $this->element("contactus_form_customizer");
?>

    <style>
        .btn-contactUs {
            background-color: #fff;
            border-color: #fff;
            color: #108bd9;
        }
        .btn-contactUs.btn.focus, .btn:focus, .btn:hover {
            color: #108bd9;
            text-decoration: none;
        }
    </style>