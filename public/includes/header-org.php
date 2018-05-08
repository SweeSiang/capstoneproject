<!-- Navigation Bar -->
<?php 
   if(isset($_SESSION["role"]))
   {
	   if((time() - $_SESSION['last_time']) > 600)
	   {
		   header("Location:/abcjobs/public/logout.php");
	   }
	   else
	   {
		   $_SESSION['last_time'] = time();
		   
	   if($_SESSION["role"] == "SuperAdmin")
	   {
?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="w3-bar w3-black w3-large">
  <img src="http://localhost/abcjobs/public/images/logo.png" align="left" style="width:55px; height:35px">
  <a href="/abcjobs/public/home.php" class="w3-bar-item w3-button w3-mobile"><i class="fa fa-bed w3-margin-right"></i>Home</a>
  <a href="/abcjobs/public/modules/user/updateprofile.php" class="w3-bar-item w3-button w3-mobile">Update Profile</a>
  <a href="/abcjobs/public/modules/user/superadmin.php" class="w3-bar-item w3-button w3-mobile">Super Administrator</a>
  <a href="/abcjobs/public/modules/user/userlist.php" class="w3-bar-item w3-button w3-mobile">Search Users</a>
  <a href="/abcjobs/public/contactus.php" class="w3-bar-item w3-button w3-mobile">Contact</a>
  <a href="/abcjobs/public/logout.php" class="w3-bar-item w3-button w3-right w3-light-grey w3-mobile">Logout</a>
</div>
<?php 
   } else if($_SESSION["role"] == "Admin")
   {
?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="w3-bar w3-black w3-large">
  <img src="http://localhost/abcjobs/public/images/logo.png" align="left" style="width:55px; height:35px">
  <a href="/abcjobs/public/home.php" class="w3-bar-item w3-button w3-mobile"><i class="fa fa-bed w3-margin-right"></i>Home</a>
  <a href="/abcjobs/public/modules/user/updateprofile.php" class="w3-bar-item w3-button w3-mobile">Update Profile</a>
  <a href="/abcjobs/public/modules/user/userlistadmin.php" class="w3-bar-item w3-button w3-mobile">Administrator Update</a>
  <a href="/abcjobs/public/modules/user/userlist.php" class="w3-bar-item w3-button w3-mobile">Search Users</a>
  <a href="/abcjobs/public/contactus.php" class="w3-bar-item w3-button w3-mobile">Contact</a>
  <a href="/abcjobs/public/logout.php" class="w3-bar-item w3-button w3-right w3-light-grey w3-mobile">Logout</a>
</div>
<?php 
   } else
   {
?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="w3-bar w3-black w3-large">
  <img src="http://localhost/abcjobs/public/images/logo.png" align="left" style="width:55px; height:35px">
  <a href="/abcjobs/public/home.php" class="w3-bar-item w3-button w3-mobile"><i class="fa fa-bed w3-margin-right"></i>Home</a>
  <a href="/abcjobs/public/modules/user/updateprofile.php" class="w3-bar-item w3-button w3-mobile">Update Profile</a>
  <a href="/abcjobs/public/modules/user/userlist.php" class="w3-bar-item w3-button w3-mobile">Search Users</a>
  <a href="/abcjobs/public/contactus.php" class="w3-bar-item w3-button w3-mobile">Contact</a>
  <a href="/abcjobs/public/logout.php" class="w3-bar-item w3-button w3-right w3-light-grey w3-mobile">Logout</a>
</div>
<?php 
   } 
   }
   }else
   {
?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="w3-bar w3-black w3-large">
  <img src="http://localhost/abcjobs/public/images/logo.png" align="left" style="width:55px; height:35px">
  <a href="/abcjobs/public/home.php" class="w3-bar-item w3-button w3-mobile"><i class="fa fa-bed w3-margin-right"></i>Home</a>
  <a href="/abcjobs/public/aboutus.php" class="w3-bar-item w3-button w3-mobile"><i class="fa fa-bed w3-margin-right"></i>About Us</a>
  <a href="/abcjobs/public/contactus.php" class="w3-bar-item w3-button w3-mobile">Contact</a>
  <a href="/abcjobs/public/login.php" class="w3-bar-item w3-button w3-right w3-light-grey w3-mobile">Login</a>
</div>
<?php 
   }
?>