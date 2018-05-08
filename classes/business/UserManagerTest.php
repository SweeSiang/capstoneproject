<?php
require "UserManager.php";
require "../entity/User.php";
require "../data/UserManagerDB.php";
require "../util/DBUtil.php";
require "../util/Config.php";

class UserManagerTest extends PHPUnit_Framework_TestCase
{	
	/**
	* Tests UserManager->getAllUsers()
	*/
	public function testgetAllUsers(){
		$UM=new classes\business\UserManager;
		$users=$UM->getAllUsers();
        $this->assertEquals(9, count($users));
    }
	
	/**
	* Tests UserManager->searchUsersByName()
	*/
	public function testsearchUsersByName(){
		$UM=new classes\business\UserManager;
		$users=$UM->searchUsersByName("Swee");
		$this->assertEquals(5, count($users));
    }
	
	/**
	* Tests UserManager->searchUsersByEmail()()
	*/
	public function testsearchUsersByEmail(){
		$UM=new classes\business\UserManager;
		$users=$UM->searchUsersByEmail("wong@hotmail.com");
		$this->assertEquals(2, count($users));
    }
}

?>