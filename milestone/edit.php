<?php 
require_once '../core/init.php';
include "{$config['path']['p2']}header.php"; 
$update   = false;
$name     = '';
$due_date = '';
$id 	  = '';
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
$c->get(array('m_id','=',$_GET['edit']));
?>
<div class='box'>
	<div style="width:50%" class='box-wrapper'>
		<div class='form-box'>
			<form method="post" action="handle.php">
				<div class='form-title'>
					<h3>Edit Milestone</h3>
				</div>
				<div class="form-group">
					<label>Milestone name</label>
					<input type="text" class="form-control" name="name" value="<?php echo $name?>">
				</div>
				<div class="form-group">
					<label>Due date</label>
					<input type="date" class="form-control" name="date" value="<?php echo $due_date?>">
					<input type="hidden"  name='m_id' value='<?php echo $_GET["edit"]?>'> 
					<input type="hidden"  name='proj_id' value='<?php echo $_GET["proj_id"]?>'> 
					<button type="submit" name='update' class="btn btn-info btn-sm">Update</button>
				</div>
			</form>
		</div>
	</div>
	<section class='comment'>
		<div class="title">
			<h5>Comments ( <?php echo $c->count()?> )</h5> 
		</div>
		<div class="content">
			<div class="form">
				<form method='post' action='handle.php'>
	                <div class="form-group">
	                	<label>write a comment</label>
	                    <textarea name='comment' class="form-control mr-3" rows='2' placeholder="leave a comment.."></textarea>
	                    <input type="hidden" name='m_id' value="<?php echo $id?>">
	                    <input type="hidden" name='proj_id' value="<?php echo $_GET['proj_id']?>">
	                    <button class="btn btn-info" name='addComment' type="submit">Comment</button>
	                </div>
	            </form>
			</div>
			<?php foreach ($c->data() as $data){?>
				<div class="comment-list">
					<div class="comment-head">
						<h5 class="user_name text text-info">
							<?php if($c->commentedBy($data->id)){
							 echo ucfirst($c->data());}?>
						</h5>
						 <span class="time"><span class="dot"></span><?php echo getDateTimeDiff($data->date);?></span>
					</div>
					<div class="comment-body">
						<p><?php echo $data->comments?></p>
					</div>
				</div>
			<?php }?>
		</div>
	 </section>
</div>