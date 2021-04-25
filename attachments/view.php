<?php 
require '../core/init.php';
include '../components/header.php';
$task_attach = new Task_Attachment();
$attach  = new Attachment();
$task_id = $_GET['task_id'];
$task_attach->get(array('task_id','=',$task_id)); 
?>

<div class='container'>
	<div class='box-wrapper'>
		<div class='form-box'>
			<form class='form' action='handle.php' method='post' enctype='multipart/form-data'>
				<div class='form-title'>
					<h3>Add Attachments</h3>
				</div>
				<?php if(Session::exists('error')){
					echo "<div class='msg-error'>".Session::flash('error')."</div>";
				}?>
				<div class='form-group'>
					<input type="hidden" name= "task_id" value="<?php echo $task_id?>">
					<input type='file' placeholder='select file to attach..' name='file[]' class='form-control' multiple>
					<button type='submit' name='attach' class='btn btn-info'>Attach</button>
				</div>
				</div>
			</form>
		</div>
	</div>										
	<div class="table-wrapper">
		<div class="table-title">
			<h4>Attachments Lists</h4>
			<table class='table'>
				<thead>
					<tr>
						<th>#</th>
						<th>Attachment</th>
						<th>Uploaded On</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if($task_attach->count())
					{
						$x=1;
						foreach($task_attach->data() as $data)
						{
							$attach->get(array('id','=',$data->attach_id));
							if($attach->count())
							{
								
								foreach($attach->data() as $a)
								{				
					?>
									<tr>
										<td><?php echo ($x)?></td>
										<td><a href="<?php echo $a->attachment?>"><?php echo $a->attachment?></a></td>
										<td><?php echo $a->uploaded_on?></td>
										<td><a href='handle.php?delete=<?php echo $a->id?>&task_id=<?php echo $task_id?>' class="delete"><i class="material-icons" title="Delete">&#xE872;</i></a>
									</tr>
					<?php       }
							}
						$x++;
						}
					}?>
				</tbody>
			</table>
		</div>
	</div>		
	<!-- <div class="empty-div">   
		<h3>No Attachments available!!</h3>
		<p>There are no attachments available for this particular task at this moment. Once you upload attachments, they will be available in this section. Also, you will be able to remove attachments.</p>
	</div>	-->						
</div>