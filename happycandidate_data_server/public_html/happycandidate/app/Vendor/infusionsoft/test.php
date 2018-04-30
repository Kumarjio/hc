<?php
echo $_GET["Contact0FirstName"];
echo $_GET["Contact0Email"];



?>
<form accept-charset="UTF-8" action="https://cy210.infusionsoft.com/app/form/process/f765dbf7f5b7b43d8d78fcdf11f02671" class="infusion-form" method="POST">
    <input name="inf_form_xid" type="hidden" value="f765dbf7f5b7b43d8d78fcdf11f02671" />
    <input name="inf_form_name" type="hidden" value="oneclick upsell montly" />
    <input name="infusionsoft_version" type="hidden" value="1.36.0.45" />
    <div class="infusion-field">
        
        <input class="infusion-field-input-container" id="inf_field_FirstName" 
		name="inf_field_FirstName" type="hidden"  value="<?php
echo $_GET["Contact0FirstName"];?>"/>
    </div>
    <div class="infusion-field">
       
        <input class="infusion-field-input-container" id="inf_field_Email" 
		name="inf_field_Email" type="hidden"  value="<?php echo $_GET["Contact0Email"];?>"/>
    </div>
    <div class="infusion-submit">
        
		<input type="image" src="images/large-registernow.png" alt="Submit Form" />
    </div>
</form>
<script type="text/javascript" src="https://cy210.infusionsoft.com/app/webTracking/getTrackingCode?trackingId=4e497643f63b3ef67acfdbc4b3a90793"></script>


