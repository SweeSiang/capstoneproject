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
$firstName="";
$lastName="";
$email="";
$password="";
$upgradeflag=false;

if(isset($_POST["submitted"])){
  if(isset($_GET["id"])){
       $UM=new UserManager();
       $existuser=$UM->pendAdmin($_GET["id"]);
	   //$users=$UM->getUserById($_GET["id"]);
        $formerror="An email has been sent to Super Admin for approval.";
		$upgradeflag=true;
		
		/*require_once "phpmailer/PHPMailerAutoload.php";
		$mail = new PHPMailer;
		//Enable SMTP debugging.
		$mail->SMTPDebug = 0;
		//Set PHPMailer to use SMTP.
		$mail->isSMTP();
		//Set SMTP host name
		$mail->Host = " in-v3.mailjet.com";
		//Set this to true if SMTP host requires authentication
		$mail->SMTPAuth = true;
		//Provide username and password
		$mail->Username = "8ba869b76e203e903305370b804965cf"; //gmail
		$mail->Password = "469791668d76f8d91984e011fd1bdb20"; //gmail
		//If SMTP requires TLS encryption then set it
		$mail->SMTPSecure = "tls";
		//Set TCP port to connect to
		//$mail->Port = 587;
		$mail->Port = 25;
		$mail->From = "$email";
		$mail->FromName = "$firstName"." "."$lastName";
		$mail->addAddress("ss85forbidden@gmail.com");
		$mail->isHTML(true);
		$mail->Subject = "For approval";
		$mail->Body = "<i>$firstName"." "."$lastName has requested </i>";
		$mail->AltBody = "This is the plain text version of the email content";
		if(!$mail->send())
		{
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
		else
		{
			//echo "Message has been sent successfully";
		}*/
		
	}
}else if(isset($_POST["cancelled"])){
	header("Location:../../home.php");
}else{
	if(isset($_GET["id"]))
	{
	  $UM=new UserManager();
	  $existuser=$UM->getUserById($_GET["id"]);
	  $firstName=$existuser->firstName;
	  $lastName=$existuser->lastName;
	  $email=$existuser->email;
	  $password=$existuser->password;
	}
}
?>
<link rel="stylesheet" href="..\..\css\pure-release-1.0.0\pure-min.css">
<form name="Upgrade" method="post" class="pure-form pure-form-stacked">
<h1>Upgrading to Admin role</h1>
<div><?=$formerror?></div>
<?php
if (!$upgradeflag)
{
?>
<table width="800">
  <tr>
    <td>Are you sure that you want to upgrade <?php echo "$firstName "."$lastName";?> to Admin role?<br>
	An email will be sent to Super Admin for approval.</td>
  </tr>
  <tr>
	<td></td>
    <td><input type="submit" name="submitted" value="Upgrade" class="pure-button pure-button-primary">
    <input type="submit" name="cancelled" value="Cancel" class="pure-button pure-button-primary"></td>
    </td>
  </tr>
</table>
<?php
}
?>
</form>


<?php
include '../../includes/footer.php';
?>