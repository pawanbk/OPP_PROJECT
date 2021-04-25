<?php
session_start();
$config = include '../classes/Config.php';
spl_autoload_register(function($class){
	include '../classes/' . $class . '.php';
});
$v = new Validate();
$u = new User();
$p = new Project();
$m = new Milestone();
$ut = new User_task();
$a = new Attachment();
$ta = new Task_Attachment();
$t=new Task();
$s = new Status();
$c = new Comment();
$time = new Time();

