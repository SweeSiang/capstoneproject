<?php
require_once '../../includes/autoload.php';
include '../../includes/header.php';
use classes\util\DBUtil;
use classes\business\UserManager;
use classes\entity\User;

$formerror="";

$firstName="";
$lastName="";
$email="";
$salt="";
$password="";
$subscribe="";

if(isset($_REQUEST["submitted"])){
    $firstName=$_REQUEST["firstName"];
    $lastName=$_REQUEST["lastName"];
    $email=$_REQUEST["email"];
    $password=$_REQUEST["password"];
    $subscribe=isset($_REQUEST["subscribe"]);

    
    if($firstName!='' && $lastName!='' && $email!='' && $password!=''){
        $UM=new UserManager();
        $user=new User();
        $user->firstName=$firstName;
        $user->lastName=$lastName;
        $user->email=$email;
		$salt=rand(0, 9999);
		$pwd_hash = crypt("$password",'$5$rounds=5000$'."$salt");
		$user->salt=$salt;
        $user->password=$pwd_hash;
        $user->role="User";
        $user->subscribe=$subscribe;
        $existuser=$UM->getUserByEmail($email);
    
        if(!isset($existuser)){
            // Save the Data to Database
            $UM->saveUser($user);
            #header("Location:registerthankyou.php");
			echo '<meta http-equiv="Refresh" content="1; url=./registerthankyou.php">';
        }
        else{
            $formerror="User Already Exist";
        }
    }else{
        $formerror="Please fill in the fields";
    }
}
?>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="..\..\css\pure-release-1.0.0\pure-min.css">
<form name="myForm" method="post" class="pure-form pure-form-stacked">
</head>

<h1 align="center">Registration Form</h1>
<div><?=$formerror?></div>
<table align="center" width="auto">
  <tr>
    <td>First Name</td>
    <td><input type="text" name="firstName" value="<?=$firstName?>" required title="Cannot be empty field" size="50"></td>
  </tr>
  <tr>
    <td>Last Name</td>
    <td><input type="text" name="lastName" value="<?=$lastName?>" required title="Cannot be empty field" size="50"></td>
  </tr>
  <tr>    
    <td>Email</td>
    <td><input type="text" name="email" value="<?=$email?>" required title="Cannot be empty field" size="50"></td>
  </tr>
  <tr>    
    <td>Password</td>
    <td><input type="password" name="password" value="<?=$password?>" required title="Cannot be empty field" size="50"></td>
  </tr>  
  <tr>    
    <td>Confirm Password</td>
    <td><input type="password" name="cpassword" value="<?=$password?>" required title="Cannot be empty field" size="50"></td>
  </tr>
  <tr>    
    <td>Subscribe to news letters</td>
    <td><input type="checkbox" name="subscribe" value="1"></td>
  </tr>
  <tr>
   <br>
   <td></td>
   <td>
       <input type="submit" name="submitted" value="Submit" class="pure-button pure-button-primary" style="width:100%"><br><br>
       <input type="reset" name="reset" value="Reset" class="pure-button pure-button-primary" style="width:100%">
   </td>
  </tr>
</table>
</form>

<?php
include '../../includes/footer.php';
?>