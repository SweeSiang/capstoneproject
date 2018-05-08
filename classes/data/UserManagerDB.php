<?php
namespace classes\data;

use classes\entity\User;
use classes\util\DBUtil;

/**
 * Password UserManagerDB class
 */
class UserManagerDB
{
    public static function fillUser($row){
        $user=new User();
        $user->id=$row["id"];
        $user->firstName=$row["firstname"];
        $user->lastName=$row["lastname"];
        $user->email=$row["email"];
		$user->salt=$row["salt"];
        $user->password=$row["password"];
		$user->role=$row["role"];
        $user->account_creation_time = $row["account_creation_time"];
        $user->subscribe = $row["subscribe"];
        return $user;
    }
    public static function getUserByEmailPassword($email,$password){
        $user=NULL;
        $conn=DBUtil::getConnection();
        $email=mysqli_real_escape_string($conn,$email);
        $password=mysqli_real_escape_string($conn,$password);
        $sql="select * from tb_user where email='$email' and password='$password'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
            }
        }
        $conn->close();
        return $user;
    }
	
    public static function getUserByEmail($email){
        $user=NULL;
        $conn=DBUtil::getConnection();
        $email=mysqli_real_escape_string($conn,$email);
        $sql="select * from tb_user where Email='$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
            }
        }
        $conn->close();
        return $user;
    }
	
	public static function getUserById($id){
        $user=NULL;
        $conn=DBUtil::getConnection();
        $id=mysqli_real_escape_string($conn,$id);
        $sql="select * from tb_user where id='$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
            }
        }
        $conn->close();
        return $user;
    }
    public static function saveUser(User $user){

        $conn=DBUtil::getConnection();
        $sql="call procSaveUser(?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssssi", $user->id,$user->firstName, $user->lastName, $user->email, $user->password, $user->account_creation_time, $user->role, $user->salt, $user->subscribe); 
        $stmt->execute();
        if($stmt->errno!=0){
            printf("Error: %s.\n",$stmt->error);
        }
        $stmt->close();
        $conn->close();
    }
	
    public static function updatePassword($email,$salt,$password){
        $conn=DBUtil::getConnection();
        $sql="UPDATE tb_user SET salt='$salt', password='$password' WHERE email='$email'";
        $stmt = $conn->prepare($sql);
		if ($conn->query($sql) === TRUE) {
			//echo "Record updated successfully";
		} else {
			echo "Error updating record: " . $conn->error;
		}
		$conn->close();
    }
	
	
    public static function deleteAccount($id){
        $conn=DBUtil::getConnection();
        $sql="DELETE from tb_user WHERE id='$id';";
        $stmt = $conn->prepare($sql);
		if ($conn->query($sql) === TRUE) {
			echo "<script>alert(Record deleted successfully)</script>";
		} else {
			echo "Error updating record: " . $conn->error;
		}
		$conn->close();

    }		
    public static function getAllUsers(){
        $users[]=array();
        $conn=DBUtil::getConnection();
        $sql="select * from tb_user";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
                $users[]=$user;
            }
        }
        $conn->close();
        return $users;
    }
	
	public static function searchUsersByName($search){
        $users[]=array();
        $conn=DBUtil::getConnection();
        $sql="select * from tb_user where firstname like '%$search%' or lastname like '%$search%'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
                $users[]=$user;
            }
        }
        $conn->close();
        return $users;
    }
	
	public static function searchUsersByEmail($search){
        $users[]=array();
        $conn=DBUtil::getConnection();
        $sql="select * from tb_user where email like '%$search%'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
                $users[]=$user;
            }
        }
        $conn->close();
        return $users;
    }
	
	public static function upgradeAccount($id){
        $conn=DBUtil::getConnection();
        $sql="UPDATE tb_user SET role = 'Admin' WHERE id='$id'";
        $stmt = $conn->prepare($sql);
		if ($conn->query($sql) === TRUE) {
			echo "<script>alert(Record updated successfully)</script>";
		} else {
			echo "Error updating record: " . $conn->error;
		}
		$conn->close();
    }
	
	public static function downgradeAccount($id){
        $conn=DBUtil::getConnection();
        $sql="UPDATE tb_user SET role = 'User' WHERE id='$id'";
        $stmt = $conn->prepare($sql);
		if ($conn->query($sql) === TRUE) {
			echo "<script>alert(Record updated successfully)</script>";
		} else {
			echo "Error updating record: " . $conn->error;
		}
		$conn->close();
    }
	
	public static function pendAdmin($id){
        $conn=DBUtil::getConnection();
        $sql="UPDATE tb_user SET role = 'PendingAdmin' WHERE id='$id'";
        $stmt = $conn->prepare($sql);
		if ($conn->query($sql) === TRUE) {
			echo "<script>alert(Record updated successfully)</script>";
		} else {
			echo "Error updating record: " . $conn->error;
		}
		$conn->close();
    }

    public static function unsubscribe($email){
        $conn=DBUtil::getConnection();
        $sql="UPDATE tb_user SET subscribe = FALSE WHERE email='$email'";
        $stmt = $conn->prepare($sql);
		if ($conn->query($sql) === TRUE) {
			echo "<script>alert(Record updated successfully)</script>";
		} else {
			echo "Error updating record: " . $conn->error;
		}
		$conn->close();
    }
	
}

?>


