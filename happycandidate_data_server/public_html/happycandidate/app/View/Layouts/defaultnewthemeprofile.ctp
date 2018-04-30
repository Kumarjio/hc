<?php $strRouter = Router::url('/',true);?>
<?php echo $this->element('newheader',array('strRouter'=>$strRouter)); ?>
<?php echo $this->element('profilestrip',array('strRouter'=>$strRouter)); ?>
<?php echo $this->fetch('content'); ?>
<?php 
		echo $this->element('socialshare');
?>
<?php echo $this->element('newfooter',array('strRouter'=>$strRouter)); ?>
