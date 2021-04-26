<?php
$id = Session::get('user_id');
$p->getProjectByUser(array('user_id','=',$id));
$update = false;
$proj_id   = '';
$proj_name = '';
$proj_date = '';

if(isset($_GET['edit']))
{
	if ($_GET['edit'] != '')
	{

		$p->getProjectById(array('proj_id', '=', $_GET['edit']));

		if($p->count())
		{
			$update = true;
			foreach ($p->data() as $data)
			{
				$proj_id   = $data->proj_id;
				$proj_name = $data->proj_name;
				$proj_date = $data->due_date;
			}
		}
		
	}	
}
?>
<?php if (Session::exists('success'))
				{
					echo "<div class='msg-flash alert alert-success'><p>"
					.Session::flash('success').
					"</p></div>";
				}?>

<div class="box">
	<div class='box-wrapper'>
		<div class="form-box">
			<form  method="post" action='../project/handle.php'>
				<div class="form-title">
					<?php if($update == true):?>
						<h3>Update Project</h3>
					<?php else:?>
						<h3>Add Project</h3>
					<?php endif?>
				</div>
				<?php if (Session::exists('errors'))
					{
						echo "<div class='error-flash'><p>"
						.Session::flash('errors').
						"</p></div>";
					}?>
				<div class="form-group">
					<label>Project name</label>
					<input type="text" class="form-control" name="proj_name" value="<?php echo $proj_name;?>">
				</div>
				<div class="form-group">
					<label>Due date</label>
					<input type="date" class="form-control" name="due_date" value="<?php echo $proj_date;?>">
				</div>
				<div class="form-group">
					<?php if($update == false):?>
						<input type="hidden" name='id' value="<?php echo $id?>">
						<button type="submit" name='add' class="btn btn-info">ADD</button>
					<?php else:?>
						<input type="hidden" name='id' value="<?php echo $proj_id?>">
						<button type="submit" name='update' class="btn btn-primary">Update</button>
					<?php endif;?>
				</div>
		     </form>
 		</div>
	</div>

	<?php if($p->count()){?>
	<div class="table-wrapper">
		<div class="table-title">
			<h3>Manage Projects</h3>
		</div>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Project Name</th>
					<th>Budget</th>
					<th>Milestone</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
		<?php 
			$x=1;
			foreach($p->data() as $data)
			{?>
				<tr>
					<td><?php echo $x?></td>
					<td><?php echo $data->proj_name;?></td>
					<td><?php echo $data->due_date;?></td>
					<td><a class="view btn btn-info btn-sm" href="../milestone/view.php?proj_id=<?php echo $data->proj_id?>">view</a></td>
					<td>
					<a href="?edit=<?php echo $data->proj_id?>" class="edit"><i class="material-icons">&#xE254;</i></a>
					<a class="delete" data-id="<?php echo $data->proj_id;?>"><i class="material-icons" title="Delete">&#xE872;</i></a>
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
			<div class="content">
				<h3>No Projects available!!</h3>
				<p>There are no projects available at this moment. Once you create Project, they will be available in this section and you can create and set Milestone according to the needs of each project. Also, will be able to Edit, Delete projects.</p>
			</div>
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
	        <h4 align="center"> Are you sure you want to delete this project?</h4>
	        <div class="btn-group">
		        <a id="yes" class="btn btn-info">Yes</a>
		        <a href="" class='btn btn-danger'>No</a>
	     	</div>
	      </div>
	      <div class='modal-footer'>
	      	<p> Note: If you delete a project, all the milestones and task related to that project will be deleted automatically.</p>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<script type="text/javascript">
	$('.delete').click(function(){
		var id = $(this).data('id');
		$('#Modal').show();
		$('#yes').click(function(){
			$.post('../project/handle.php',{delete:id})
			.done(function(){
				location.reload();
			})
		})
	});
	$('.close').click(function(){
		$('#Modal').hide();
	});
</script>