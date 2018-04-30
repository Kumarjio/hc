<?php
session_start();

unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['access_level']);
unset($_SESSION['account_active']);
unset($_SESSION['portal_id']);
unset($_SESSION['hcuid']);

/*$_SESSION['user_id'] = "32";
$_SESSION['username'] = "rajendrakandpal";
$_SESSION['access_level'] = "Recuriter";
$_SESSION['account_active'] = "Y";*/

print("<pre>");
print_r($_SESSION);

?>