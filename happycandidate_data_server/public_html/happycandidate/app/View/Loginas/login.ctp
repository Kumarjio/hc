<div class="index container-layout">	<?php		$strLoaderImageUrl = Router::url('/',true)."img/loader.gif";	?>	<span id="loginformloader" style="position:relative;top:15px;"><img src="<?php echo $strLoaderImageUrl; ?>" alt="loginloader" /></span></div><?php	$strLogOutUrl = Router::url(array('controller'=>'admins','action'=>'logout','loginas'),true);	$strUserSessionKey = $this->Session->read("1_".$current_user['id']."_sesskey");	$strUserEmail = $current_user['email'];		?><?php	if($intUserId && $intPortalId)	{		if(!$isLoggedOut)		{			?>				<script type="text/javascript">					$(document).ready(function () {						fnLogout('<?php echo $strLogOutUrl; ?>','<?php echo $strUserSessionKey; ?>','<?php echo $strUserEmail; ?>')					});				</script>			<?php		}		else		{			$strPortalLoginUrl = Router::url(array('controller'=>'portal','action'=>'login',$intPortalId),true);			$strPortalLogouUrl = Router::url(array('controller'=>'portal','action'=>'logout',$intPortalId),true);			$strUname = $arrActiveUserExists[0]['Candidate']['candidate_email'];			$strPass = $arrActiveUserExists[0]['Candidate']['candidate_password_decrypted'];						?>				<script type="text/javascript">					$(document).ready(function () {						fnLogCandidateLogInLoginAs('<?php echo $strPortalLoginUrl; ?>','<?php echo $strPortalLogouUrl; ?>','<?php echo $intPortalId; ?>','<?php echo $strUname; ?>','<?php echo $strPass; ?>')					});				</script>			<?php		}	}	else	{		if($intUserId && !($intPortalId))		{			if(!$isLoggedOut)			{				?>					<script type="text/javascript">						$(document).ready(function () {							fnLogout('<?php echo $strLogOutUrl; ?>','<?php echo $strUserSessionKey; ?>','<?php echo $strUserEmail; ?>')						});					</script>				<?php			}			else			{				$strLogInUrl = Router::url(array('controller'=>'users','action'=>'login','loginas'),true);				$strLogOutUrl = Router::url(array('controller'=>'users','action'=>'logout'),true);				$strUserEmail = $arrActiveUserExists[0]['User']['email'];				$strUserPass = $arrActiveUserExists[0]['User']['pass_dec'];				//print("<pre>");				//print_r($arrActiveUserExists);exit;								?>					<script type="text/javascript">						$(document).ready(function () {							fnLoginEmployerLoginAs('<?php echo $strLogInUrl; ?>','<?php echo $strLogOutUrl; ?>','<?php echo $strUserEmail; ?>','<?php echo $strUserPass; ?>');						});					</script>				<?php							}		}	}	?>