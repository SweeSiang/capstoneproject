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
				<a href='edituser.php?id=<?php echo $user->id ?>'>Edit</a>
			</td>
			<td>
			<?php
			if ($admin != $user->id){
				?>
				<a href='deleteuser.php?id=<?php echo $user->id ?>'>Delete</a>
				<?php
			}
			else echo "Denied";
			?>
			</td>
			
			<td>
			<?php
			if ($admin != $user->id){
				$userAdmin = "Admin";
				$userUser = "User";
				$role = "PendingAdmin";
				if ($user->role != "$userAdmin"){
					if ($user->role != "$role"){
						?>
						<a href='upgrade.php?id=<?php echo $user->id ?>'>Upgrade</a>
						<?php
						}
						else if ($user->role = "$role"){
							?>
							<a href='upgrade.php?id=<?php echo $user->id ?>'><font color="red">Approve</font></a>
							<?php
						}
				}
				else if ($user->role != "$userUser"){
					?>
					<a href='downgrade.php?id=<?php echo $user->id ?>'>Downgrade</a>
					<?php
				}
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

<title>SuperAdmin</title>

<?php
include '../../includes/footer.php';
?>