<?php 
require_once '../core/init.php';
include "{$config['path']['p3']}header.php";
$id = $_GET['m_id'];
$task = new Task();
$task->get(array('m_id','=',$id));
$task_id='';
$name ='';
$description='';
$due_date ='';
$update =false;
if(isset($_GET['edit']))
{
	$update = true;
	$task->get(array('id','=',$_GET['edit']));
	foreach($task->data() as $data)
	{
		$task_id     = $data->id;
		$name        = $data->name;
		$description = $data->description;
		$due_date    = $data->due_date;
	}
}
?>
<?php if (Session::exists('success'))
				{
					echo "<div class='alert alert-success'>"
					.Session::flash('success').
					"</div>";
				}?>
<input type="hidden" name='m_id' value="<?php echo $id?>">
<div class="container">
	<div  class='addModal' id="addModal">
	  <div class="modal-dialog" >
	    <div class="modal-content">  
	      <div class="modal-body">
	      		<h4 align="center">Add Task</h4>
		          <span class="close" aria-hidden="true">&times;</span>
		        <form  method="post" action='handle.php'>
					<?php if (Session::exists('errors'))
						{
							echo "<div class='error-flash'><p>"
							.Session::flash('errors').
							"</p></div>";
						}?>
					<div class="form-group">
						<input type="text" class="form-control" name="name" placeholder="task name">
					</div>
					<div class="form-group">
						<input class="form-control" type="text" id="autoComplete" autocomplete="off" placeholder="search and select user to assign...">
					</div>
					<div class='form-group' id='user-list'></div>
					<div class="form-group">
						<div class="input-group">
							<input type="hidden" name="m_id" value="<?php echo $id?>">
					  		<textarea class="form-control" name="description" id="editor2"></textarea>
						</div>
					</div>
					<div class="form-group">
						<input type="date" class="form-control" name="date">
					</div>
				    <div class="form-group">
						<input type="hidden" id='id' name='assigned_user' >
						<button type="submit" name='add' class="btn btn-info">ADD</button>
					</div>
			    </form>
		   </div>
	    </div>
	  </div>
	</div>
	<button style='float:right' id='addbtn' class="btn btn-info">Add task</button>
<?php if($task->count()){?>
		<h3 align='center'>Task List</h3>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Description</th>
				<th>Due date</th>
				<th>Createdby</th>
				<th>Type</th>
				<th>status</th>
				<th>Assignee</th>
				<th>Attachments</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
	<?php 
		$x=1;
		foreach($task->data() as $data)
		{?>
			<td><?php echo $x?></td>
			<td><?php echo $data->name;?></td>
			<td><?php echo $data->description;?></td>
			<td><?php echo $data->due_date?></td>
			<?php if($task->createdBy($data->id)){
			?>
			<td><?php echo $task->data();}?></td>
			<td><?php echo $data->type?></td>
			<td>
				<form method="get" action="handle.php">
					<select name='status' class="status form-select" data-task-id="<?php echo $data->id;?>">
						<option value='0' <?php if($data->status== 0) echo "selected"?>>select status</option>
						<?php 
						$a=1;
						$status = new Status();
						$status->get();
						if($status->count()){
							foreach($status->data() as $status){
						?>
							<option value='<?php echo $a?>' <?php if($data->status== $a) echo "selected"?>><?php echo $status->name?></option>
						<?php $a++;}}?>
					</select>
				</form>
			</td>
			<td>
				<a class="view btn btn-info btn-sm" href="../assigned_users/view.php?id=<?php echo $data->id?>">view</a></td>
			</td>
			<td>
				<a href='../attachments/view.php?task_id=<?php echo $data->id?>' class="view btn btn-info btn-sm">View</a>
			</td>
			<td>
				<a href="edit.php?edit=<?php echo $data->id?>&m_id=<?php echo $id?>" class="edit"><i class="material-icons">&#xE254;</i></a>
				<a data-delete-id="<?php echo $data->id?>" class="delete"><i class="material-icons" title="Delete">&#xE872;</i></a>
			</td>
		</tr> 
			
		<?php $x++;
			}
		?>
			
		</tbody>
	</table>
</div>
<?php }else {?>
	<div style='margin:0;width:100%' class="empty-div"> 
		<h3>No tasks available!!</h3>
		<p>There are no tasks available for this particular milestone at this moment. Once you create tasks, they will be available in this section and you can set them according to the needs of project and milestone. Also, will be able to Edit, Delete tasks.</p>
	</div>
<?php }?>

<div class="modal" id="Modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 align="center"> Are you sure you want to delete this task?</h4>
        <div class="btn-group">
	        <a id="yes" class="btn btn-info">Yes</a>
	        <a href="" class='btn btn-danger'>No</a>
     	</div>
      </div>
      <div class='modal-footer'>
      	<p> Note: If you delete a task, all the users assigned to particular task will be deleted automatically.</p>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"> 
	$('#addbtn').click(function(){
		$('#addModal').show();
	})
	$('.close').click(function(){
			$('#addModal').hide();
		})
	
	$('.delete').click(function(){
		var id = $(this).data('delete-id');
		$('#Modal').show();
		$('#yes').click(function(){
			$.post('handle.php',{delete:id})
			.done(function(){
				location.reload();
			})
		})
		$('.close').click(function(){
			$('#Modal').hide();
		})
		$(window).click(function(){
			$('#Modal').hide();
		});
	});

</script>