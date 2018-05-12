<?php
session_start();
require_once '../../includes/autoload.php';

use classes\business\UserManager;
use classes\entity\User;

ob_start();
include '../../includes/security.php';
include '../../includes/header.php';

$checkbox="";
$UM=new UserManager();

if(isset($_POST["compose"])){
  if(!empty($_POST["checkbox"])){
      $checkbox = $_POST["checkbox"];
      $recipient = implode("; ", $checkbox);
    }
    //echo '<meta http-equiv="Refresh" content="1; url=compose.php">';
}

$users=$UM->getAllUsers();

if(isset($users)){
  ?>  
  <title>Send email</title>
  <link rel="stylesheet" href="..\..\css\pure-release-1.0.0\pure-min.css">
  </br>
  <form name="mail_list" method="post">
  <table>
      <thead>
      <tr>
        <td>Recipient: </td><td><input type="text" size="69" name="recipient" value="<?php if(isset($recipient)){echo $recipient;}?>" readonly></td>
      </tr>
      <tr>
        <td>Subject: </td><td><input type="text" size="69" name="subject" placeholder="Add a subject"></td>
      </tr>
      <tr>
        <td>Message: </td><td><textarea rows="7" cols="70" name="message" placeholder="Add a message here"></textarea></td>
        
      </tr>
      </thead>
  </table>

  <td><input type="submit" name="mail_list" value="Send" class="pure-button pure-button-primary"></td>
  <td><input type="reset" name="mail_list" value="Discard" class="pure-button pure-button-primary"></td>
  </form>


    <form name="compose" method="post">
    <tr>
	    <td><input type="submit" name="compose" value="Select all & Compose" class="pure-button pure-button-primary"></td>
    </tr></br></br>
    <table class="pure-table pure-table-bordered" width="800">

    <tr>
      <thead>
        <th><b>First Name</b></th>
        <th><b>Last Name</b></th>
        <th><b>Email</b></th>
        <th><b>Check recipient</b></th>
      </thead>
    </tr>
    <?php 
    foreach ($users as $user){
      if($user!=null){
        if ($user->subscribe != "0"){
        ?>
        <tr>
          <td><?=$user->firstName?></td>
          <td><?=$user->lastName?></td>
          <td><?=$user->email?></td>
			    <td><input type="checkbox" name="checkbox[]" value="<?=$user->email?>" checked></td>
        </tr>
        <?php
        }
        }
      }
      ?>
    </table><br/>
  </form>

  <?php 
}

if(isset($_POST["mail_list"])){
  if(!empty($_POST["recipient"]))
    {
      $recipientArray = explode('; ', $_POST["recipient"]);
      $subject = $_POST["subject"];
      $message = $_POST["message"];
      $SECRET_STRING = "594a4f2d559a9345d126f45a9bc3a7ec";

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
			$mail->Username = "8ba869b76e203e903305370b804965cf";
			$mail->Password = "469791668d76f8d91984e011fd1bdb20";
			//If SMTP requires TLS encryption then set it
			$mail->SMTPSecure = "tls";
			//Set TCP port to connect to
			//$mail->Port = 587;
			$mail->Port = 25;
			$mail->From = "ss85forbidden@gmail.com";
      $mail->FromName = "ABC Admin";

      foreach($recipientArray as $receipt){
      $mail->addBCC("$receipt");
      $hash = md5($receipt.$SECRET_STRING);
      $link = "http://localhost/abcjobs/public/modules/user/unsubscribe.php?email=$receipt&validation_hash=$hash";
			$mail->isHTML(true);
			$mail->Subject = ("$subject");
			$mail->Body = "<p>$message</p><br><br>If you do not want to receive such emails in the future, please <a href=$link>unsubscribe</a> here.";
      //$mail->AltBody = "This is the plain text version of the email content";
      
			if(!$mail->send())
			{
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else
			{
				echo "email has been sent successfully";
      }
      $mail->ClearAllRecipients( );
    }
    }
    //echo '<meta http-equiv="Refresh" content="1; url=compose.php">';
}
?>

<?php
include '../../includes/footer.php';
?>