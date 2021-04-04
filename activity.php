<?php
$id = $config['session']['session_id'];
$project = new Project();
if(Input::exists())
{
	$validate = new Validate();
	$validation = $validate->check($_POST,
		array(
			'proj_name' => array(
				'required' => true,
				'unique'  => 'project'
			 ),
			'budget' =>array(
				'required' => true
			)

	));

	if ($validation->passed())
	{
         $project->addProject(
    		array(
    			'proj_name'   => Input::get('proj_name'),
    			'user_id'     => Session::get($id),
    			'proj_budget' => Input::get('budget')
    		));
         Redirect::to('index.php');
	}
	else 
	{
		foreach ($validation->getError() as $err)

		{
			echo $err .'<br>';
		}
	}
}


?>

<div class="container">
	<form  method="post">
		<div class="form-title">
			<h2>Add <b>Project </b></h2>
		</div>
		<div class="form-group">
			<label>Project name</label>
			<input type="text" class="form-control" name="proj_name">
		</div>
		<div class="form-group">
			<label>Budget</label>
			<input type="text" class="form-control" name="budget">
		</div>
		<div class="form-group">
		 	<button type="submit" class="btn btn-success btn-lg">Add Project</button>
	    </div>
	</form>

	<div class="table-wrapper">
		<?php if($project->count()){?>
		<div class="table-title">
			<div class="row">
				<h2>Manage <b>Projects</b></h2>
			</div>
		</div>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Sn.</th>
					<th>Project Name</th>
					<th>Budget</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
		<?php 
			for ($x = 0;$x<$project->count();$x++)
			{?>
				<tr>
					<td><?php echo ($x+1);?></td>
					<td><?php echo $project->data()[$x]->proj_name;?></td>
					<td><?php echo $project->data()[$x]->proj_budget;?></td>
					<td>
					<a href="editProduct.php?edit=<?php echo $project->data()[$x]->proj_id;?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
					<a href="deleteProject.php?delete=<?php echo $project->data()[$x]->proj_id;?>" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
					</td>
				</tr> 
				
			<?php }?>
				
			</tbody>
		</table>
	<?php }?>
	</div>
</div>