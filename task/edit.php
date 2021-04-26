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
<div class='box'>
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
		<div class='table-wrapper'>
			<div class="container">
			    <div class="row">
			        <div class="col-md-8">
			            <div class="page-header">
			                <h1><small class="pull-right"><?php echo $c->count()?> comments</small> Comments </h1>
			            </div>
			            <div class='form'> 
				            <form method='post' action='handle.php'>
				                <div class="form-group">
				                    <textarea name='comment' class="form-control mr-3" rows='2' placeholder="leave a comment.."></textarea>
				                    <input type="hidden"  name='task_id' value="<?php echo $_GET['edit']?>">
				                    <button class="btn btn-info" name='addComment' type="submit">Comment</button>
				                </div>
				            </form>
				        </div>
			            <?php foreach($c->data() as $data){?>
				            <div class="comments-list">
				                <div class="media">
				                    <p class="pull-right"><small><?php echo $time->getDateTimeDiff($data->date);?></small></p>
				                    <div class="media-body">
				                        <h4 class="media-heading user_name"><?php if($c->commentedBy($data->id)){
											 echo ucfirst($c->data());}?></h4>
				                        <?php echo $data->comments?>
				                        <p><small><a href="">Like</a> - <a href="">Share</a></small></p>
				                    </div>
				                </div>
				            </div>
			        	<?php }?>
			        </div>
			    </div>
			</div>
		</div>
	<?php }else{?>
		<div class="empty-div"> 
			<div class="content">
				<h3>No comments!!</h3>
				<p>There are no Milestone available for this project at this moment. Once you create milestone, they will be available in this Section and you can set them according to the needs of project. Also, will be able to Edit, Delete and View task related to this project.</p>
				<form method='post' action='handle.php'>
	                <div class="form-group">
	                    <textarea name='comment' class="form-control mr-3" rows='2' placeholder="leave a comment.."></textarea>
	                    <input type="hidden"  name='task_id' value="<?php echo $_GET['edit']?>">
	                    <button class="btn btn-info" name='addComment' type="submit">Comment</button>
	                </div>
	            </form>
			</div>
		</div>
	<?php } ?>
</div>
