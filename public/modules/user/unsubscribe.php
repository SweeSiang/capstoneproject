<?php
session_start();
require_once '../../includes/autoload.php';

use classes\business\UserManager;
use classes\entity\User;

ob_start();
include '../../includes/security.php';
include '../../includes/header.php';
?>

<?php

$formerror="";
//$unsubscribeflag=false;

if(isset($_POST["submitted"])){
  $SECRET_STRING = "594a4f2d559a9345d126f45a9bc3a7ec";
  $expected = md5($_GET["email"].$SECRET_STRING);
    if($_GET["validation_hash"] = $expected){
       $UM=new UserManager();
       $existuser=$UM->unsubscribe($_GET["email"]);
        $formerror="Unsubscribe successfully";
        //$unsubscribeflag=true;
        
        header("Location:../../home.php");
	}
}
?>
<title>Unsubscribe</title>
<link rel="stylesheet" href="..\..\css\pure-release-1.0.0\pure-min.css">
<form name="Unsubscribe" method="post" class="pure-form pure-form-stacked">
<h1>Confirm unsubscribe?</h1>
<div><?=$formerror?></div>
<input type="submit" name="submitted" value="Submit" class="pure-button pure-button-primary">
</form>

<?php
include '../../includes/footer.php';
?>