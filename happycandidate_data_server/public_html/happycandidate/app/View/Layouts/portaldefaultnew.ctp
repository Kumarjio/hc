<?php $strRouter = Router::url('/',true);?>
<?php echo $this->element('candidateheader',array('strRouter'=>$strRouter)); ?>


<?php  echo $this->fetch('content'); ?>
<?php // echo  $this->element('candidatefooter',array('strRouter'=>$strRouter)); ?>



	
	