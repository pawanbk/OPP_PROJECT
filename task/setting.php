<?php 
require '../core/init.php';
include '../components/header.php';
$s->get();
$update = false;
$id = '';
$name = '';

if(isset($_POST['create']))
{
	$v->check($_POST, array(
		'name'=> array(
			'required' => true,
			'min'      => '2',
			'unique'   => 'status'

		)
	));
	if($v->passed())
	{
		$s->add(array('name' => Input::get('name')));
		Redirect::to('setting.php');
	}
}
if(isset($_POST['Update']))
{
	$v->check($_POST, array(
		'name'=> array(
			'required' => true,
			'min'      => '2',
			'unique'   => 'status'

		)
	));
	if($v->passed())
	{
		$s->update(Input::get('id'),array('name' => Input::get('name')));
		Redirect::to('setting.php');
	}
}
if(isset($_GET['edit']))
{
	if($_GET['edit'] != '')
	{
		$update = true;
		$s->get(array('id','=',$_GET['edit']));
		foreach($s->data() as $data)
		{
			$id = $data->id;
			$name = $data->name;
		}
	}
}
if(isset($_GET['delete']))
{
	if($_GET['delete'] != '')
	{
		$s->remove(array('id','=',$_GET['delete']));
		Redirect::to('setting.php');
	}
}
?>
<div class="container">
	<div class='box-wrapper'>
		<div class="form-box">
			<form  method="post" action="">
				<div class="form-title">
					<?php if($update == false):?>
						<h3>Create Status</h3>
					<?php else:?>
						<h3>Update</h3>
					<?php endif;?>
				</div>
				<?php if (Session::exists('error'))
				{
					echo "<p style='color:red'>"
					.Session::flash('error')."</p>";
				}?>
				<div class="form-group">
					<label>Status Name</label>
					<input type="text" class="form-control" name="name" value="<?php echo $name?>">
				</div>
				<div class="form-group">
					<?php if($update == false):?>
						<button type="submit" name= 'create' class="btn btn-info">Create</button>
					<?php else:?>
						<input type="hidden" name= 'id' value="<?php echo $id ?>">
						<button type="submit" name= 'Update' class="btn btn-primary">Update</button>
					<?php endif;?>
				</div>
			</form>
		</div>
	</div>
	<?php if($s->count()):?>
		<div class="table-wrapper">
			<table class='table'>
				<div class='table-title'>
					<h3>Status List</h3>
				</div>
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $x=1; 
					foreach($s->data() as $status){?>
						<tr>
							<td><?php echo $x?></td>
							<td><?php echo $status->name?></td>
							<td>
								<a href="?edit=<?php echo $status->id?>" class="edit"><i class="material-icons">&#xE254;</i></a>
								<a href="?delete=<?php echo $status->id?>" class="delete" data-toggle="modal"><i class="material-icons">&#xE872;</i></a>
							</td>
						</tr>
					<?php $x++;}?>
				</tbody>
			</table>
		</div>
	<?php else:?>
		<div class="empty-div"> 
			<h3>No status created for task!!</h3>
			<p>There are no projects available at this moment. Once you create Project, they will be available in this section and you can create and set Milestone according to the needs of each project. Also, will be able to Edit, Delete projects.</p>
		</div>
	<?php endif;?>
</div>