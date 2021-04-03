<?php 
require_once 'core/init.php';
$project = new Project();

if (isset($_GET['delete']))
{
	$project->removeProject(array('proj_id','=',$_GET['delete']));
	Redirect::to('index.php');
}
?>
