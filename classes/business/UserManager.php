<?php
namespace classes\business;

use classes\entity\User;
use classes\data\UserManagerDB;

	/**
	 * Business tier
	 */
class UserManager
{
	/**
	 * Returns all users as array of user objects
	 */
    public static function getAllUsers(){
        return UserManagerDB::getAllUsers();
    }
	
	/**
	 * Returns some users as array of user objects based on search parameters
	 * @param string $firstName User's first name
	 * @param string $lastName User's last name
	 * @param string $email User's email
	 * @param string $role User's role
	 */
	 
	public static function searchUsersByName($search){
        return UserManagerDB::searchUsersByName($search);
    }
	
	/**
	 * Returns some users as array of user objects based on search parameters
	 * @param string $firstName User's first name
	 * @param string $lastName User's last name
	 * @param string $email User's email
	 */
	public static function searchUsersByEmail($search){
        return UserManagerDB::searchUsersByEmail($search);
    }
	
	/**
	 * Returns a user object instance based on his email address and password
	 * @param string $email User's email address
	 * @param string $password_hashed User's password
	 */
    public function getUserByEmailPassword($email,$password_hashed){
        return UserManagerDB::getUserByEmailPassword($email,$password_hashed);
    }
	
	/**
	 * Returns a user object instance based on his email address
	 * @param string $email User's email address
	 */
    public function getUserByEmail($email){
        return UserManagerDB::getUserByEmail($email);
    }
	
	/**
	 * Returns a user object instance based on his id
	 * @param string $id User's ID
	 */
    public function getUserById($id){
        return UserManagerDB::getUserById($id);
    }
	
	/**
	 * Saves user to database
	 */
    public function saveUser(User $user){
        UserManagerDB::saveUser($user);
    }
	
	/**
	 * Updates a user's password
	 * @param string $email User's email address
	 * @param string $salt system's generated salt
	 * @param string $password User's password
	 */
	public function updatePassword($email,$salt,$password){
        UserManagerDB::updatePassword($email,$salt,$password);
    }
	
	/**
	 * Deletes a user account given his ID
	 * @param string $id User's ID
	 */
	public function deleteAccount($id){
        UserManagerDB::deleteAccount($id);
    }
	
	/**
	 * Upgrade a user role given his ID
	 * @param string $id User's ID
	 */
	public function upgradeAccount($id){
        UserManagerDB::upgradeAccount($id);
    }
	
	/**
	 * Downgrade a user role given his ID
	 * @param string $id User's ID
	 */
	public function downgradeAccount($id){
        UserManagerDB::downgradeAccount($id);
    }
	
	/**
	 * Update a user role for pending given his ID
	 * @param string $id User's ID
	 */
	public function pendAdmin($id){
        UserManagerDB::pendAdmin($id);
	}
	
	public function unsubscribe($email){
        UserManagerDB::unsubscribe($email);
    }
	
	/**
	 * Generates a random password
	 * @param string $length the length of the generated password
	 * @param string $count number of passwords to be generated
	 * @param string $characters types of characters to be used in the password
	 */	
	public function randomPassword($length,$count, $characters) 
	{
		// $length - the length of the generated password
		// $count - number of passwords to be generated
		// $characters - types of characters to be used in the password
		 
		// define variables used within the function    
		$symbols = array();
		$passwords = array();
		$used_symbols = '';
		$pass = '';
 
		// an array of different character types    
		$symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
		$symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$symbols["numbers"] = '1234567890';
		$symbols["special_symbols"] = '!?~@#-_+<>[]{}';
 
		$characters = explode(",",$characters); // get characters types to be used for the passsword
		foreach ($characters as $key=>$value) {
			$used_symbols .= $symbols[$value]; // build a string with all characters
		}
		$symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1
		 
		for ($p = 0; $p < $count; $p++) {
			$pass = '';
			for ($i = 0; $i < $length; $i++) {
				$n = rand(0, $symbols_length); // get a random character from the string with all characters
				$pass .= $used_symbols[$n]; // add the character to the password string
			}
			$passwords[] = $pass;
		}
		return $passwords; // return the generated password
	} //end of generate random password function
	

}

?>