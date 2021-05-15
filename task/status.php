<?php 
require '../core/init.php';
include '../components/header.php';
$s->get();
$update = false;
$id = '';
$name = '';

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

?>
<div class="box">
	<div class='box-wrapper'>
		<div class="form-box">
			<form  method="post" action="handle.php">
				<div class="form-title">
					<?php if($update == false):?>
						<h5>Create Status</h5>
					<?php else:?>
						<h5>Update</h5>
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
						<button type="submit" name= 'createStatus' class="btn btn-info">Create</button>
					<?php else:?>
						<input type="hidden" name= 'id' value="<?php echo $id ?>">
						<button type="submit" name= 'updateStatus' class="btn btn-primary">Update</button>
					<?php endif;?>
				</div>
			</form>
		</div>
	</div>
	<?php if($s->count()){?>
		<div class="table-wrapper">
			<table class='table'>
				<div class='table-title'>
					<h5>Status List</h5>
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
							<td><?php echo ucfirst($status->name)?></td>
							<td>
								<a href="handle.php?editStatus=<?php echo $status->id?>" class="edit"><i class="material-icons">&#xE254;</i></a>
								<a href="handle.php?deleteStatus=<?php echo $status->id?>" class="delete" data-toggle="modal"><i class="material-icons">&#xE872;</i></a>
							</td>
						</tr>
					<?php $x++;}?>
				</tbody>
			</table>
		</div>
	<?php }
	else 
	{
		echo empty_div('task status','edit and delete ');
	}
	?>
</div>