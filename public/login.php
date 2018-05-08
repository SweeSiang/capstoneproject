<?php
session_start();
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
	
	$response = $_POST["g-recaptcha-response"];
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array(
		'secret' => '6LfYh00UAAAAAB3Y1ueYqRqu6Iy6ZxctddrmghrZ', //localhost		data-sitekey="6LfYh00UAAAAAK0wgLKz_1WVLmJY59IqRFoW3HVf"
		//'secret' => '6LcYcE4UAAAAALTNyvc3L45w9i5BLQ2U-WsH8VQM', //202.73.44.87		data-sitekey="6LcYcE4UAAAAAEPVL47XPDJ17Iob9Kr6SrSopPFI"
		//'secret' => '6LfhK1AUAAAAAAeCI4Z8RFooa2iG7Hm-sjMmmiJ4', //projects.lithan.com		data-sitekey="6LfhK1AUAAAAAMJ4P2BG_bmgYyBgznuSGXz9wP1n"
		'response' => $_POST["g-recaptcha-response"]
	);
	$options = array(
		'http' => array (
			'method' => 'POST',
			'header' => 'Content-type: application/x-www-form-urlencoded',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$verify = file_get_contents($url, false, $context);
	$captcha_success=json_decode($verify);
	if ($captcha_success->success==false) {
		?><h5 align="center">
		<?php echo "<p>Please verify that you are not a bot!</p>";?>
		</h6>
		<?php
	} else if ($captcha_success->success==true) {
		//echo "<p>Welcome! Your session will automatically logout after 10 min of inactivity.<br>loading. . .</p>";
	
    $email=$_POST["email"];
    $password=$_POST["password"];
	
	//echo "$password<br>";
	$UM0=new UserManager();
	$existuser=$UM0->getUserByEmail($email);
	if(isset($existuser)){
		$salt=$existuser->salt;
		//echo "$salt<br>";
		$password_hashed = crypt("$password",'$5$rounds=5000$'."$salt");
		//echo "$password_hashed<br>";
		
	if($validate->check_password($password, $error_passwd))
	{
		$UM=new UserManager();
		
		$existuser=$UM->getUserByEmailPassword($email,$password_hashed);
		//echo "$password_hashed<br>";
		if(isset($existuser)){
			$_SESSION['email']=$email;
			$_SESSION['role']=$existuser->role;
			$_SESSION['id']=$existuser->id;
			$_SESSION['last_time']=time();
			echo '<meta http-equiv="Refresh" content="1; url=home.php">';
		}
		else{
			?><h5 align="center">
			<?php
			echo "Invalid User Name or Password";
			?>
			</h5>
			<?php
		}
	}
	}
	else{
		?><h5 align="center">
		<?php
		echo "Invalid email user";
		?>
		</h5>
		<?php
	}
	}
}

?>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href=".\css\pure-release-1.0.0\pure-min.css">
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<h1 align="center">Login</h1>
<form name="myForm" method="post" class="pure-form pure-form-stacked">
<table align="center" border='0' width="auto">
  <tr>    
    <td>Email:</td>
    <td><input type="email" name="email" value="<?=$email?>" pattern=".{1,}" required title="Cannot be empty field" size="50"></td>
	<td><?php echo $error_name?>
  </tr>
  <tr>    
    <td>Password:</td>
    <td><input type="password" name="password" value="<?=$password?>" required title="Cannot be empty field" size="50"></td>
	<td><?php echo $error_passwd?>
  </tr> 
  <tr>
	<th></th>
	<td><h6 text align = "right"><a href="./forgetpassword.php">Forget your password?</a></h6></td>
  </tr>
						
  <tr>
  <td></td>
    <td>
	<div class="captcha_wrapper">
	<div class="g-recaptcha" data-sitekey="6LfYh00UAAAAAK0wgLKz_1WVLmJY59IqRFoW3HVf"></div>
	</div>
	</td>
	</tr>
	<tr>
	<td></td>
    <td><br><input type="submit" name="submitted" value="Login" class="pure-button pure-button-primary" style="width:100%">
    </td>
    </td>
  </tr>
  <tr> <?php echo $formerror?></tr>
  <tr>
  <td></td>
    <td>
       <br>
	   <h5 p text align = "center"><a href="modules/user/register.php">Don't have an account?</a></h5>
    </td>
  </tr>   
</table>
</form>
</html>
<?php
include 'includes/footer.php';
?>