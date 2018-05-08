<?php
use classes\business\UserManager;
use classes\business\Validation;

require_once 'includes/autoload.php';
include 'includes/header.php';
$formerror="";

$email="";
$password="";
$error_auth="";
$error_name="";
$error_passwd="";
$error_email="";
$validate=new Validation();

if(isset($_POST["submitted"])){
    $email=$_POST["email"];
	$UM=new UserManager();
	$existuser=$UM->getUserByEmail($email);
	if(isset($existuser)){

			//generate new password
			$newpassword=$UM->randomPassword(8,1,"lower_case,upper_case,numbers");
			
			//CRYPT_SHA_256 with salt
			$salt=rand(0, 9999);

			$pwd_hash = crypt("$newpassword[0]",'$5$rounds=5000$'."$salt");
			
			$oldsalt=$existuser->salt;
			//echo "oldsalt: $oldsalt<br>";			
			//echo "newsalt: $salt<br>";		
			//echo " Your new password is: $newpassword[0]<br>";
			//echo " Your new password hash is: $pwd_hash";
			
			//update database with new password
			$UM->updatePassword($email,$salt,$pwd_hash);  
			//$formerror="Valid email user. password: ".$newpassword[0];
			//coding for sending email
			// do work here

			require_once "phpmailer/PHPMailerAutoload.php";
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
			//$mail->Username = "9003721276a81b2ecb91a5a40c55c735"; //hotmail
			//$mail->Password = "86a0e9ef29ec0a5417e322f308b73d54"; //hotmail
			$mail->Username = "8ba869b76e203e903305370b804965cf"; //gmail
			$mail->Password = "469791668d76f8d91984e011fd1bdb20"; //gmail
			//If SMTP requires TLS encryption then set it
			$mail->SMTPSecure = "tls";
			//Set TCP port to connect to
			//$mail->Port = 587;
			$mail->Port = 25;
			$mail->From = "ss85forbidden@gmail.com";
			$mail->FromName = "ABC Admin";
			$mail->addAddress("$email");
			$mail->isHTML(true);
			$mail->Subject = "Password Reset";
			$mail->Body = "<i>Your new password is: $newpassword[0]</i>";
			$mail->AltBody = "This is the plain text version of the email content";
			if(!$mail->send())
			{
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else
			{
				//echo "Message has been sent successfully";
			}
			?><h5 align="center">
			<?php
			echo "New password have been sent to ".$email;
			?>
			</h5>
			<?php
			//header("Location:home.php");
	}else{
			$formerror="Invalid email user";
	}
}

?>
<html>
<head>
<title>Forget Password</title>
<link rel="stylesheet" href=".\css\pure-release-1.0.0\pure-min.css">
</head>
<body>

<h1 align="center">Forget Password</h1>
<form name="myForm" method="post" class="pure-form pure-form-stacked">
<table align="center" border='0' width="auto">
  <tr>    
    <td>Email:</td>
    <td><input type="email" name="email" value="<?=$email?>" pattern=".{1,}"   required title="Cannot be empty field" size="50"></td>
	<td><?php echo $error_name?>
  </tr> 
  <tr>
    <td></td>
    <td><br><input type="submit" name="submitted" value="Submit" class="pure-button pure-button-primary" style="width:100%">
    </td>
  </tr>
  <tr><p style="color:red;"> <?php echo $formerror?></p></tr>
</table>
</form>
</body>
</html>
<?php
include 'includes/footer.php';
?>