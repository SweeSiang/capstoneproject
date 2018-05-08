<?php
session_start();
require_once '../../includes/autoload.php';

use classes\business\UserManager;
use classes\entity\User;

ob_start();
include '../../includes/security.php';
include '../../includes/header.php';

$search="";
$UM=new UserManager();

if(isset($_POST["submitname"])){
    $search=$_POST["search"];
	if($_POST["search"]!=NULL)
	{
		$users=$UM->searchUsersByName($search);
	}
}

else if(isset($_POST["submitemail"])){
    $search=$_POST["email_input"];
	if($_POST["email_input"]!=NULL)
	{
		$users=$UM->searchUsersByEmail($search);
	}
}

else if(isset($_POST["submitall"])){
	$users=$UM->getAllUsers();
}
?>
	<title>Search User</title>
	<link rel="stylesheet" href="..\..\css\pure-release-1.0.0\pure-min.css">
	<p><h4>Search for users by:</h4></p>
	<form name="searchForm" method="post">
	<tr>
		<td><input type="submit" name="submitall" value="View all user" class="pure-button pure-button-primary"></td>
	</tr>
	</form><br>
    <form name="searchForm" method="post">
	<tr>
      <td><input type="search" placeholder="Search.." name="search" required title="Please enter name to begin searching.."></td>
	  <td><input type="submit" name="submitname" value="Search by name" class="pure-button pure-button-primary"></td>
	</tr>
    </form><br>
	<form name="searchForm" method="post">
	<tr>
	  <td><input type="email" placeholder="Email.." name="email_input" pattern=".{1,}" required title="Please enter email to begin searching.." size="30"></td>
	  <td><input type="submit" name="submitemail" value="Search by email" class="pure-button pure-button-primary"></td>
	</tr>
	</form>
	<?php

if(isset($users)){
    ?>
	<link rel="stylesheet" href="..\..\css\pure-release-1.0.0\pure-min.css">
    <br/>Below is the list of Developers registered in community portal <br/><br/>
  
    <table class="pure-table pure-table-bordered" width="800">
            <tr>
			<thead>
               <th><b>First Name</b></th>
               <th><b>Last Name</b></th>
               <th><b>Email</b></th>
			   <th><b>Role</b></th>
			   </thead>
            </tr>    
    <?php 
    foreach ($users as $user) {
        if($user!=null){
            ?>
            <tr>
               <td><?=$user->firstName?></td>
               <td><?=$user->lastName?></td>
               <td><?=$user->email?></td>
			   <td><?=$user->role?></td>
            </tr>
            <?php 
        }
    }
    ?>
    </table><br/><br/>
    <?php 
}
?>

<?php
include '../../includes/footer.php';
?>