<?php 
require '../core/init.php';
include "{$config['path']['p2']}header.php";
$task_attach = new Task_Attachment();
$task_id = $_GET['task_id'];
$task_attach->get(array('task_id','=',$task_id)); 
?>

<div class='box'>
	<div class='box-wrapper'>
		<div class='form-box'>
			<form class='form' action='handle.php' method='post' enctype='multipart/form-data'>
				<div class='form-title'>
					<h5>ADD</h5>
				</div>
				<?php if(Session::exists('error')){
					echo "<div class='error-flash'>".Session::flash('error')."</div>";
				}?>
				<div class='form-group'>
					<input type="hidden" name= "task_id" value="<?php echo $task_id?>">
					<input type='file' placeholder='select file to attach..' name='file[]' class='form-control' multiple>
					<button type='submit' name='attach' class='btn btn-info'>Attach</button>
				</div>
			</form>
		</div>
	</div>	
	<?php if($task_attach->count()){?>							
		<div class="table-wrapper">
			<div class="table-title">
				<h5>Attachments Lists</h5>
			</div>
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
					$x=1;
					foreach($task_attach->data() as $a)
					{				
					?>
						<tr>
							<td><?php echo $x?></td>
							<td><a href="<?php echo $config['base_url'].$a->attachment?>"><?php echo $config['base_url'].$a->attachment?></a></td>
							<td><?php echo $a->uploaded_on?></td>
							<td><a href='handle.php?delete=<?php echo $a->id?>&task_id=<?php echo $task_id?>' class="delete"><i class="material-icons" title="Delete">&#xE872;</i></a></td>
						</tr>
					<?php $x++; }?>
				</tbody>
			</table>
		</div>
		<?php }else{
			echo empty_div('Attachments','delete');
		}?>
</div>								