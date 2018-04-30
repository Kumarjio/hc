<?php $strRouter = Router::url('/',true);?>

<?php echo $this->element('demoheader',array('strRouter'=>$strRouter)); ?>


<?php  echo $this->fetch('content'); ?>

<?php echo $this->element('newfooter',array('strRouter'=>$strRouter)); ?>
