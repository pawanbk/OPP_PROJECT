<?php 
require_once '../core/init.php';
include "{$config['path']['p2']}header.php";
$id = $_GET['m_id'];
$t->get(array('m_id','=',$id));
?>
<?php if (Session::exists('success'))
				{
					echo "<div class='alert alert-success alert-dismissible fade show'>"
					.Session::flash('success').
					"</div>";
				}?>
<div class="box">

	<div  class='addModal' id="addModal">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content"> 
				<div class="modal-header">
					<h5>Add Task</h5><span class="btn-close">&#x2715</span>
				</div>
				<div class="modal-body">
					<form  method="post" action='handle.php' id="form">
						<?php if (Session::exists('errors'))
						{
						echo "<div class='error-flash'><p>"
						.Session::flash('errors').
						"</p></div>";
						}?>
						<div class="form-group">
							<label>Task name</label>
							<input type="text" class="form-control" name="name" placeholder="Enter task name">
						</div>
						<div class="form-group">
							<label>Assignee</label>
							<input class="autoComplete1 form-control" name="user" type="text" autocomplete="off" placeholder="search and select user to assign...">
						</div>
						<div class='user-list form-group'></div>
						<div class="form-group">
							<div class="input-group">
								<label>Description</label>
								<textarea class="form-control" name="description" id="editor1"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label>Due date</label>
							<input type="date" class="form-control" id="date" name="date">
							</div>
							<div class="form-group">
							<input type="hidden" name="m_id" value="<?php echo $id?>">
							<input type="hidden" class='id' name='assignee'>
							<a class="btn-close btn btn-secondary ">close</a>
							<button type="submit" name='add' class="btn btn-info">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="btn-div">
		<button id='addbtn' class="btn btn-info mbr-5">ADD TASK</button>
	</div>
	<?php if($t->count()){?>
	<h5 align='center'>Task List</h5>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Description</th>
				<th>Due date</th>
				<th>Createdby</th>
				<th>Assignee</th>
				<th>Type</th>
				<th>status</th>
				<th>Priority level</th>
				<th>Attachments</th>
				<th>Completed</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$x=1;
		foreach($t->data() as $data)
		{?>
			<td><?php echo $x?></td>
			<td><?php echo $data->name;?></td>
			<td><?php echo $data->description;?></td>
			<td><?php echo $data->due_date?></td>
			<?php if($t->createdBy($data->id)){
			?>
			<td><?php echo ucfirst($t->data());}?></td>
			<td>
				<?php 
					$t->getAssignee($data->id);
				 	echo ucfirst($t->data())
				 	?>
			</td>
			<td>
				<select name='type' class="type form-select" data-task-id="<?php echo $data->id;?>">
					<option style="font-weight: bold;" value='0' <?php if($data->type== 0) echo "selected"?>>select</option>
					<?php 
					// TODO: fix this
					$a=1;
					$ty->get();
					if($ty->count()){
						foreach($ty->data() as $type){
					?>
						<option value='<?php echo $a?>' <?php if($data->type== $a) echo "selected"?>><?php echo $type->name?></option>
					<?php $a++;}}?>
				</select>
			</td>
			<td>
				<select name='status' class="status form-select" data-task-id="<?php echo $data->id;?>">
					<option style="font-weight: bold;" value='0' <?php if ($data->status== 0) echo "selected"?>>select</option>
					<?php
					$status = new Status();
					$status->get();
					if($status->count()){
						foreach($status->data() as $status){
					?>
						<option value="<?php echo $status->id; ?>" <?php if($data->status == $status->id) echo "selected"?>><?php echo $status->name?></option>
					<?php }
				} ?>
				</select>
			</td>
			<td>

				<select name='priority' class="priority form-select" data-task-id="<?php echo $data->id;?>">
					<option style="font-weight: bold;" value='0' <?php if($data->priority== 0) echo "selected"?>>select</option>
					<?php 
					// TODO: fix this
					$a=1;
					$pr->get();
					if($pr->count()){
						foreach($pr->data() as $priority){
					?>
						<option value='<?php echo $a?>' <?php if($data->priority== $a) echo "selected"?>><?php echo $priority->name?></option>
					<?php $a++;}}?>
				</select>
			</td>
			
			<td>
				<a href='../attachments/view.php?task_id=<?php echo $data->id?>' class="view btn btn-info btn-sm">View</a>
			</td>
			<td>
				<?php if($data->mark == 'complete'):?>
	          		<input type="checkbox" class="largerCheckbox" data-id="<?php echo $data->id?>" checked>
	          	<?php else:?>
	          		<input type="checkbox" class="largerCheckbox" data-id="<?php echo $data->id?>">
	          	<?php endif;?>   
			</td>
			<td>
				<a href="edit.php?edit=<?php echo $data->id?>&m_id=<?php echo $id?>" class="edit"><i class="material-icons">&#xE254;</i></a>
				<a data-delete-id="<?php echo $data->id?>" class="delete"><i class="material-icons">&#xE872;</i></a>
			</td>
		</tr> 
			
		<?php $x++;
			}
		?>
		</tbody>
	</table>
	<?php }
	else 
	{
		echo empty_div('Tasks','edit, delete','full-width');
	}
	?>
	<?php echo delete_modal();?>
	<script type="text/javascript"> 
		$.validator.addMethod('greaterThan',function(value,element){
			var today = new Date();
			return today < new Date(value);

		},'');
		$.validator.setDefaults({
			errorClass: 'text text-danger',
			highlight:function(element){
				$(element)
				.closest('.form-control')
				.addClass('border border-danger');
			},
			unhighlight:function(element){
				$(element)
				.closest('.form-control')
				.removeClass('border border-danger');
			}
		})
		$("#form").validate({
			rules:{
				name: "required",
				user: "required",
				description : "required",
				date: {
					required:true,
					greaterThan : ''
				}

			},
			messages:{
				name: "task name is required",
				user: "assignee is required",
				description : "description is required",
				date : {
					required:" due date is required",
					greaterThan: "select valid due date"
				}
			}
		})
		$('.priority').change(function()
		{
			var value = $('option:selected', this).val();
			var id = $(this).data('task-id');
			$.post('handle.php',{priority: value, id:id})
			.done(function() {
	    		location.reload();
	 		 })		
		});
		$('input[type="checkbox"]').click(function(){
			var id = $(this).data('id');
			if($(this).is(":checked")){
	                $.post('handle.php',{checked:id})
	                .done(function(){
	                	location.reload();
	                })
	            }
	            else if($(this).is(":not(:checked)")){
	                $.post('handle.php',{unchecked:id})
	                .done(function(){
	                	location.reload();
	                })
	            }
		});
		$('#addbtn').click(function(){
			$('#addModal').show();
		})
		$('.btn-close').click(function(){
				$('#addModal').hide();
			})
		
		$('.delete').click(function(){
			var id = $(this).data('delete-id');
			$('#Modal').show();
			$('#yes').click(function(){
				console.log(id);
				$.post('handle.php',{delete:id})
				.done(function(){
					location.reload();
				})
			})
			$('.btn-close').click(function(){
				$('#Modal').hide();
			})
		});

	</script>