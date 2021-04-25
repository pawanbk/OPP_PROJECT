<?php
require_once '../core/init.php';
include "{$config['path']['p3']}header.php"; 
$proj_id = $_GET['proj_id'];
$m= new Milestone();
$m->get(array('proj_id','=', $proj_id));
$update = false;
$name     = '';
$due_date = '';
$id = '';
if(isset($_GET['edit']))
{
	$update = true;
	$m->get(array('id','=',$_GET['edit']));
	foreach($m->data() as $data)
	{
		$name     = $data->name;
		$due_date = $data->due_date;
		$id       = $data->id;
	}

}
?>
<?php if (Session::exists('success'))
				{
					echo "<div class='alert alert-success'>"
					.Session::flash('success').
					"</div>";
				}?>
<div class="container">
	<div class='box-wrapper'>
		<div class="form-box">
			<form  method="post" action="handle.php">
				<div class="form-title">
					<?php if($update == false):?>
						<h3>Create Milestone</h3>
					<?php else:?>
						<h3> Update Milestone</h3>
					<?php endif;?>
				</div>
				<?php if (Session::exists('errors'))
					{
						echo "<div class='error-flash'><p>"
						.Session::flash('errors').
						"</p></div>";
					}?>
				<div class="form-group">
					<label>Name</label>
					<input type="text" class="form-control" name="name" value="<?php echo $name?>">
				</div>
				<div class="form-group">
					<label>Due date</label>
					<input type="date" class="form-control" name="date" value="<?php echo $due_date?>">
				</div>
				<div class="form-group">
					<input type="hidden" name='proj_id' value="<?php echo $proj_id?>">
					<?php if($update == false):?>
						<button type="submit" name= 'add' class="btn btn-info">ADD</button>
					<?php else:?>
						<input type="hidden" name='id' value="<?php echo $id?>">
						<button type="submit" name= 'update' class="btn btn-primary">Update</button>
					<?php endif;?>
				</div>
			</form>
		</div>
	</div>
	<?php if($m->count()){?>
		<div class="table-wrapper">
			<div class="table-title">
				<h3>Milestone List</h3>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
					<th>#</th>
					<th>Name</th>
					<th>Due Date</th>
					<th>Task</th>
					<th>Status</th>
					<th>Action</th>
					</tr>
				</thead>
					<tbody>
					<?php 
					$x=1;
					foreach($m->data() as $data)
					{?>
					<tr>
						<td><?php echo $x?></td>
						<td><?php echo $data->name;?></td>
						<td><?php echo $data->due_date;?></td>
						<td><a class="view btn btn-info btn-sm" href="../task/view.php?m_id=<?php echo $data->id?>">view</a></td>
						<td>
						<?php 
						if($data->status == 1)
						{
						echo "<a style='color:white' class='btn btn-danger btn-sm' href='handle.php?type=status&operation=unset&id={$data->id}&proj_id={$proj_id}'>unset</a>";
						}
						else 
						{
						echo "<a style='color:white' class='btn btn-success btn-sm' href='handle.php?type=status&operation=set&id={$data->id}&proj_id={$proj_id}'>set</a>";
						}
						?>
						</td>
						<td>
							<a href="?edit=<?php echo $data->id?>&proj_id=<?php echo $proj_id?>" class="edit"><i class="material-icons">&#xE254;</i></a>
							<a data-delete-id='<?php echo $data->id?>' class="delete"><i class="material-icons" >&#xE872;</i></a>
						</td>
					</tr> 
					<?php
					$x++; }
					?>	
				</tbody>
			</table>
		</div>
	<?php }
	else {?>
		<div class="empty-div"> 
		<h3>No milestone available!!</h3>
		<p>There are no Milestone available for this project at this moment. Once you create milestone, they will be available in this Section and you can set them according to the needs of project. Also, will be able to Edit, Delete and View task related to this project.</p>
		</div>
	<?php }?>
	<div class="modal" id="Modal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <h4 align="center"> Are you sure you want to delete this Milestone?</h4>
	        <div class="btn-group">
		        <a id="yes" class="btn btn-info">Yes</a>
		        <a href="" class='btn btn-danger'>No</a>
	     	</div>
	      </div>
	      <div class='modal-footer'>
	      	<p> Note: If you delete a Milestone, all tasks related to that milestone will be deleted automatically.</p>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<script type="text/javascript">
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
	});
</script>