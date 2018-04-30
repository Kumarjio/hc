<?php $strRouter = Router::url('/',true);?>

<?php echo $this->element('previewheader',array('strRouter'=>$strRouter)); ?>


<?php  echo $this->fetch('content'); ?>

<?php echo $this->element('previewfooter',array('strRouter'=>$strRouter)); ?>
