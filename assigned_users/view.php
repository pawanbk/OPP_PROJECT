<?php
require '../core/init.php';
include '../components/header.php';
$user = new User();
$task_id = $_GET['id'];
$ut = new User_task();
$ut->get(array('task_id', '=',$task_id));
?>
<div class="container">
	<?php if (Session::exists('success'))
	{
	echo "<div class='msg-flash alert alert-success'><p>"
	.Session::flash('success').
	"</p></div>";
	}?>

	<div class='box-wrapper'>
		<div class="form-box">
			<form  method="post" action="handle.php">
				<div class="form-title">
					<h3>Assign user</h3>
				</div>
				<?php if (Session::exists('error'))
				{
					echo "<p style='color:red'>"
					.Session::flash('error')."</p>";
				}?>
				<div class="form-group">
					<label>Assign user</label>
					<input class="form-control" type="text" id="autoComplete" placeholder="search...">
				</div>
				<div class='lists' id='user-list'></div>
				<div class="form-group">
					<input type="hidden" id='id' name='user_id'>
					<input type="hidden" name='task_id' value="<?php echo $task_id?>">
					<button type='submit' name="assign" class="btn btn-info">Assign</button>
				</div>
			</form>
		</div>
	</div>
<?php if($ut->count())
	{?>
	<div class="table-wrapper">
		<table class='table'>
			<div class="table-title">
				<h3> Assigned User List</h3>
			</div>
			<thead>
				<tr>
					<th>#</th>
					<th>First name </th>
					<th>Last name</th>
					<th>Email</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>	
				<?php 
				$x=1;
				foreach($ut->data() as $data)
				{
					$userId = $data->user_id;
					$user->find($userId);			
				?>
					<tr>
						<td><?php echo $x?></td>
						<td><?php print_r($user->data()->f_name);?></td>
						<td><?php print_r($user->data()->l_name);?></td>
						<td><?php print_r($user->data()->email);?></td>
						<td>
							<a href="handle.php?action=delete&user_id=<?php echo $data->user_id;?>&task_id=<?php echo $task_id?>" class="delete" data-toggle="modal"><i class="material-icons" title="Delete">&#xE872;</i></a>
						</td>
					</tr>
				<?php $x++;}?>
			</tbody>
		</table>
	</div>
		
<?php }?>
</div>
