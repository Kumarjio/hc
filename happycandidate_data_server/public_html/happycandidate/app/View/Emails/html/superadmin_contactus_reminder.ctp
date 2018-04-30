<?php
	$strPortalUrl = Router::url(array('controller'=>'portal','action'=>'index',ucfirst($portal_name)),true);
?>
<p> Hello There,</p>
<p align="justify"> Visitior <?php echo $visitor_name;?> has made a contact form request from portal <?php echo $portal_name;?>.</p>
<p>Following is the Portal detail.</p>
<p align="justify"> Portal Name - <a href="<?php echo $strPortalUrl;?>" target="_blank"><?php echo $portal_name;?></a></p>
<p align="justify"> Portal Owner - <?php echo $portalowner_uname;?> </p>
<p align="justify"> Portal Owner Email Address- <?php echo $portalowner_email;?> </p>
<p>&nbsp;</p>
<p>Following is the Visitor Request detail.</p>
<p align="justify"> Visitior Name - <?php echo $visitor_name;?> </p>
<p> Visitor Email - <?php echo $visitor_email;?> </p>
<p> Visitor Subject - <?php echo $visitor_subject;?> </p>
<p> Visitor Message - <?php echo $visitor_message;?> </p>
<p><b>Thanks</b></p>
<p><b><?php echo $portal_name; ?> Admin.</b></p>