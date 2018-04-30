<?php $strRouter = Router::url('/',true);?>
<?php echo $this->element('newheader',array('strRouter'=>$strRouter)); ?>

<?php echo $this->fetch('content'); ?>
<?php echo $this->element('sql_dump'); ?>
</body>
</html>