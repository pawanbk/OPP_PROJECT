<?php 
require_once '../core/init.php';
include '../components/header.php';
$ty->get();
$update = false;
$id = '';
$name = '';
if(isset($_GET['edit']))
{
	if($_GET['edit'] != '')
	{
		$update = true;
		$ty->get(array('id','=',$_GET['edit']));
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
						<h5>Create Type</h5>
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
					<label>Type Name</label>
					<input type="text" class="form-control" name="name" value="<?php echo $name?>">
				</div>
				<div class="form-group">
					<?php if($update == false):?>
						<button type="submit" name= 'createType' class="btn btn-info">Create</button>
					<?php else:?>
						<input type="hidden" name= 'id' value="<?php echo $id ?>">
						<button type="submit" name= 'updateType' class="btn btn-primary">Update</button>
					<?php endif;?>
				</div>
			</form>
		</div>
	</div>
	<?php if($ty->count()){?>
		<div class="table-wrapper">
			<table class='table'>
				<div class='table-title'>
					<h5>Type List</h5>
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
					foreach($ty->data() as $type){?>
						<tr>
							<td><?php echo $x?></td>
							<td><?php echo ucfirst($type->name)?></td>
							<td>
								<a href="handle.php?editType=<?php echo $type->id?>" class="edit"><i class="material-icons">&#xE254;</i></a>
								<a href="handle.php?deleteType=<?php echo $type->id?>" class="delete" data-toggle="modal"><i class="material-icons">&#xE872;</i></a>
							</td>
						</tr>
					<?php $x++;}?>
				</tbody>
			</table>
		</div>
	<?php }
	else 
	{
		echo empty_div('task type','edit and delete ');
	}
	?>
</div>