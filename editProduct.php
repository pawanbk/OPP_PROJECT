<?php
require_once 'core/init.php';
include 'header.php';
$id = $_GET['edit'];
$proj_name ='';
$budget ='';
$project = new Project();
if($project->getProjectById(array('proj_id','=',$id)))
{
	foreach($project->data() as $data){
		$proj_name = $data->proj_name;
		$budget    = $data->proj_budget;
	}
}


if(Input::exists())
{
	$validate= new Validate();
	$validation = $validate->check($_POST,
		array(
			'proj_name' => array(
				'required' => true,
				'min'      => '3',
				'max'      =>'20'
			),
			'budget' => array(
				'required' => true,
				'min'      => '3',
				'max'      =>'20'
			),

		));
	if ($validation->passed())
	{
		try{
			$project->editProject(Input::get('proj_id'),
			array('proj_name'=>Input::get('proj_name') ,'proj_budget'=>Input::get('budget')));
			Session::flash('success', 'project detail has been updated');
			Redirect::to('index.php');
		}
		catch(Exception $e){
			die($e.getMessage());
		}
	}
	else
	{
		foreach ($validation->getError() as $err){
			echo $err .'<br>';

		}
	}
}
?>
<div class="wrapper">
	<form method="post">
		<div class="form-title">
			<h2>Update <b>Project </b></h2>
		</div>
		<div class="form-group">
			<label>Project name</label>
			<input type="text" class="form-control" name="proj_name" value="<?php echo $proj_name;?>">
		</div>
		<div class="form-group">
			<label>Budget</label>
			<input type="text" class="form-control" name="budget" value="<?php echo $budget;?>">
			<input type="hidden" class="form-control" name="proj_id" value=<?php echo $_GET['edit'];?>>
		</div>
		<div class="form-group">
			<a href="index.php" class= 'btn btn-danger btn-lg'>cancel</a>
			<button type="submit" class="btn btn-success btn-lg">Update</button>
		</div>
	</form>
</div>