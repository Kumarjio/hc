<?php $strRouter = Router::url('/',true);?>
<?php echo $this->element('newheader',array('strRouter'=>$strRouter)); ?>
<?php
	echo $this->element('reminder_pop_up');
	
?>
<?php // echo $this->Session->flash(); ?>
<?php //echo $this->Session->flash('auth'); ?>
<?php echo $this->fetch('content'); ?>
<?php 
		echo $this->element('socialshare');
?>
<?php echo $this->element('newfooter',array('strRouter'=>$strRouter)); ?>
