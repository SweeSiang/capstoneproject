<?php
session_start();
require_once '../../includes/autoload.php';

use classes\business\UserManager;
use classes\entity\User;

ob_start();
include '../../includes/security.php';
include '../../includes/header.php';

$UM=new UserManager();
$users=$UM->getAllUsers();
$admin=$_SESSION["id"];

if(isset($users)){
    ?>
	<link rel="stylesheet" href="..\..\css\pure-release-1.0.0\pure-min.css">
    <br/><br/>Below is the list of Developers registered in community portal <br/><br/>
  
    <table class="pure-table pure-table-bordered" width="800">
            <tr>
			<thead>
               <th><b>Id</b></th>
               <th><b>First Name</b></th>
               <th><b>Last Name</b></th>
               <th><b>Email</b></th>
			   <th><b>Role</b></th>
			   <th align="center" colspan="3"><b>Operation</b></th>
			   </thead>
            </tr>    
    <?php 
    foreach ($users as $user){
        if($user!=null){
            ?>
            <tr>
				<td><?=$user->id?></td>
				<td><?=$user->firstName?></td>
				<td><?=$user->lastName?></td>
				<td><?=$user->email?></td>
				<td><?=$user->role?></td>
			<td>
			<?php
			if ($user->role != "SuperAdmin"){
				?>
				<a href='edituser.php?id=<?php echo $user->id ?>'>Edit</a>
				<?php
			}
			else echo "Denied";
			?>
			</td>
			<td>
			<?php
			if ($user->role != "SuperAdmin"){
				if ($admin != $user->id){
					?>
					<a href='deleteuser.php?id=<?php echo $user->id ?>'>Delete</a>
					<?php
				}
				else echo "Denied";
			}
			else echo "Denied";
			?>
			</td>
			
			<td>
			<?php
			if ($user->role != "SuperAdmin"){
				if ($admin != $user->id){
					//$userAdmin = "Admin";
					//$userUser = "User";
					if ($user->role != "Admin"){
						?>
						<a href='adminrequest.php?id=<?php echo $user->id ?>'>Upgrade</a>
						<?php
					}
					else if ($user->role != "User"){
						?>
						<a href='downgrade.php?id=<?php echo $user->id ?>'>Downgrade</a>
						<?php
					}
				}
				else echo "Denied";
			}
			else echo "Denied";
			?>
			</td>
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