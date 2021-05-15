<?php
session_start();
define('BASE_PATH',__DIR__);
include BASE_PATH.'/../functions/function.inc.php';
$config = include BASE_PATH.'/../classes/Config.php';
spl_autoload_register(function($class){
	include BASE_PATH.'/../classes/' . $class . '.php';
});
$v  = new Validate();
$u  = new User();
$p  = new Project();
$m  = new Milestone();
$a  = new Attachment();
$ta = new Task_Attachment();
$t  = new Task();
$s  = new Status();
$ty = new Type();
$c  = new Comment();
$pr = new Task_priority();
$timelog = new Timelog();

