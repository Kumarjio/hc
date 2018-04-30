<?php
if($logged_in)
	{?>
<div class="container-fluid footer-wizard">
	<footer>
			<div class="left-nav">
				<a class="osr13 text-middle-blue" href="#">Privacy Policy</a>
				<a class="osr13 text-middle-blue" href="#">Contact Us</a>
			</div>
			<div class="right-nav">
				<p class="osr13 text-middle-dark-grey">&copy; 2015 HR Search, Inc.</p>
				<img src="<?php echo $strRouter;?>images/app-store.png" alt="img description" />
				<img src="<?php echo $strRouter;?>images/google-play.png" alt="img description" />
			</div>
	</footer>
</div>
<?php
}
else
{
?>
<div class="container-fluid index-footer-v3">
		<footer>
			<div class="index-footer-left">
				<a href="#" class="navbar-brand">
					<img alt="logo description" src="<?php echo $strRouter;?>images/search-item.png"><span>HR Search</span>
				</a>
				<p>&copy; 2015 HR Search, Inc. All rights reserved.</p>
			</div>
			<div class="index-footer-right">
				<a class="link-default" href="#">About</a>
				<a class="link-default" href="#">Contact Us</a>
				<a class="link-default" href="#">Privacy Policy</a>
			</div>
		</footer>
	</div>
<?php
}?>

<?php echo $this->element('sql_dump'); ?>
</body>
</html>