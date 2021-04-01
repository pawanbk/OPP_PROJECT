<?php
session_start();
$config = include 'classes/config.php';
spl_autoload_register(function($class){
	include 'classes/' . $class . '.php';

});
?>