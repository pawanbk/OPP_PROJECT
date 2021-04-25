<?php 
require '../core/init.php';
include "{$config['path']['p3']}header.php";
$task_id='';
$name ='';
$description='';
$due_date ='';
$update =false;

if(isset($_GET['edit']))
{
	$update = true;
	$t->get(array('id','=',$_GET['edit']));
	foreach($t->data() as $data)
	{
		$task_id     = $data->id;
		$name        = $data->name;
		$description = $data->description;
		$due_date    = $data->due_date;
	}
}
$c->get(array('task_id','=',$task_id));

?>
<div class='container'>
	<div class='box-wrapper'>
		<div class='form-box'>
			<form method="post" action="handle.php">
				<div class='form-title'>
					<h3>Edit task</h3>
				</div>
				<div class="form-group">
					<label>Task name</label>
					<input type="text" class="form-control" name="name" value="<?php echo $name?>">
				</div>
				<div class="form-group">
					<label>Description</label>
					<div class="input-group">
						<input type="hidden" name="m_id" value="<?php echo $id?>">
				  		<textarea class="form-control" name="description" id='editor1' ></textarea>
					</div>
				</div>
				<div class="form-group">
					<label>Due date</label>
					<input type="date" class="form-control" name="date" value="<?php echo $due_date?>">
					<input type="hidden"  name='m_id' value='<?php echo $_GET["m_id"]?>'> 
					<input type="hidden"  name='task_id' value='<?php echo $task_id?>'>
					<button type="submit" name='update' class="btn btn-info btn-sm">Update</button>
				</div>
			</form>
		</div>
	</div>
	<?php if($c->count()){?>
		<div class='comment-wrapper'>
			<div class="section mt-5 mb-5">
				<div class="d-flex justify-content-center row">
					<div class="d-flex flex-column col-md-8">
						<div class="d-flex flex-row align-items-center text-left comment-top p-2 bg-white border-bottom px-4">
							<div class="d-flex flex-column ml-3">
								<div class="d-flex flex-row align-items-center align-content-center post-title">
									<h4 class="mr-2">Comments</h4>
								</div>
							</div>
						</div>
						<div class="coment-bottom bg-white p-2 px-4">
							<div class="d-flex flex-row add-comment-section mt-4 mb-4">
								<form method='post' action='handle.php'>
									<input type="text" name='comment' class="form-control mr-3" placeholder="Add comment">
									<input type="hidden"  name='task_id' value="<?php echo $_GET['edit']?>">
									<button class="btn btn-info" name='addComment' type="submit">Comment</button>
								</form>
							</div>
							<?php foreach($c->data() as $data){?>
							<div class="commented-section mt-2">
								<div class="d-flex flex-row align-items-center">
									<span style='font-size: 17px;font-family: bold;color:blue'class="mr-3">
										<?php if($c->commentedBy($data->id)){
										 echo '@'.ucfirst($c->data());}?>
									</span> <span class="dot mb-1"></span> <span class="mb-1 ml-2"><?php echo $time->getDateTimeDiff($data->date);?></span>
								</div>
								<div class="comment-text-sm">
									<p><?php echo $data->comments?></p>
								</div>
							</div>

						<?php }?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php }else{?>
		<div class="empty-div"> 
			<div class="d-flex flex-row add-comment-section mt-4 mb-4">
				<form method='post' action='handle.php'>
					<input type="text" name='comment' class="form-control mr-3" placeholder="Add comment">
					<input type="hidden"  name='task_id' value="<?php echo $_GET['edit']?>">
					<button class="btn btn-info" name='addComment' type="submit">Comment</button>
				</form>
			</div>
		<h3>No comments!!</h3>
		<p>There are no Milestone available for this project at this moment. Once you create milestone, they will be available in this Section and you can set them according to the needs of project. Also, will be able to Edit, Delete and View task related to this project.</p>
		</div>
	<?php } ?>
</div>
