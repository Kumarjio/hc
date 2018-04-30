<?php $strRouter = Router::url('/',true);?>

<?php echo $this->element('newheader',array('strRouter'=>$strRouter)); ?>
<?php
	if($logged_in)
	{?>
<?php echo $this->element('headerstrip',array('strRouter'=>$strRouter)); ?>
<?php
}?>

<?php  echo $this->fetch('content'); ?>

<?php echo $this->element('newfooter',array('strRouter'=>$strRouter)); ?>
