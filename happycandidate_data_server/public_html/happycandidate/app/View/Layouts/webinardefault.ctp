<?php $strRouter = Router::url('/',true);?>
<?php echo $this->element('newheader',array('strRouter'=>$strRouter)); ?>
<?php
	echo $this->element('reminder_pop_up');
	
?>
<?php
if($this->params['action']!='library')
{
 echo $this->element('webinarheaderstrip',array('strRouter'=>$strRouter)); 
}?>
<?php  echo $this->fetch('content'); ?>
<?php 
		echo $this->element('socialshare');
?>
<?php echo $this->element('newfooter',array('strRouter'=>$strRouter)); ?>



	
	