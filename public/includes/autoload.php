<?php
spl_autoload_register(function ($class_name) {
    include $_SERVER['DOCUMENT_ROOT'] . "/abcjobs/" .$class_name . '.php';
	//include $_SERVER['DOCUMENT_ROOT'] . "/students/m1/run8/sstan/abcjobs/" .$class_name . '.php';
	
});
?>