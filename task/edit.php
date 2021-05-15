<?php 
require_once '../core/init.php';
include_once "{$config['path']['p2']}header.php";
$task_id='';
$name ='';
$description='';
$due_date ='';
$timer_start = false;
if(isset($_GET['edit']))
{
	$db = Db::getInstance();
	$result = $db->get('timelog', array(
		'task_id', '=', $_GET['edit'], 'AND', 'end_datetime', '=', '',
	));
	if ($result->count()) {
		$timer_start = true;
		$row = $result->first();
		$date = strtotime($row->start_datetime);
		$startedTime = $date;
	}
}

if(isset($_GET['edit']))
{
	$t->get(array('id','=',$_GET['edit']));
	foreach($t->data() as $data)
	{
		$task_id     = $data->id;
		$name        = $data->name;
		$description = $data->description;
		$due_date    = $data->due_date;
		$user_id     = $data->assignee;
	}
}
$c->get(array('task_id','=',$task_id));
?>
<div class='box'>
	<div style="width:45%;" class="box-wrapper">
		<div class="form-box">
			<form method="post" action="handle.php">
				<div class='form-title'>
					<h5>Edit task</h5>
				</div>
				<?php if (Session::exists('errors'))
						{
							echo "<div class='error-flash'><p>"
							.Session::flash('errors').
							"</p></div>";
						}?>
				<div class="form-group">
					<label>Task name</label>
					<input type="text" class="form-control" name="name" value="<?php echo $name?>">
				</div>
				<div class="form-group">
					<label>Assignee</label>
				   <?php $t->getAssignee($task_id);?>
					<input class="autoComplete1 form-control" type="text" autocomplete="off" value="<?php echo ucfirst($t->data())?>">
				</div>
				<div class='user-list form-group'></div>
				<div class="form-group">
					<label>Due date</label>
					<input type="date" class="form-control" name="date" value="<?php echo $due_date?>">
					<input type="hidden"  name='m_id' value='<?php echo $_GET["m_id"]?>'> 
					<input type="hidden"  name='task_id' value='<?php echo $task_id?>'>
					<input type="hidden" class='id' name='assignee' value="<?php echo $user_id?>">
					<button type="submit" name='update' class="btn btn-info">Update</button>
				</div>
			</form>
		</div>
	</div>
	<div style="width:50%;" class="table-wrapper scrollable">
		<?php if($user_id === Session::get('user_id')){?>
		<div class="right-button">
				<?php if($timer_start == false):?>
					<button name="start" class="btn btn-success btn-sm"><span class="material-icons">timer</span>
					</button>
				<?php else:?>
					<button name="stop" class="btn btn-danger btn-sm"><span class="material-icons">timer</span></button>
				<?php endif;?><button type="button" class="btn btn-primary" id="openModal">
					  Add time log
					</button>
		</div>
		<?php }?>
		<div class="row">
			<div class="col-12"><h5 align="center">Time log<h5></div>
			<div class="col-12"><h2 align="center" id="current-time">00:00:00<h2></div>
			<div class="col-12"> <div class="row">
				<div class="col-6"><a href="#" id="start-time" data-task-id="<?php echo $_GET['edit']; ?>" class="btn btn-success btn-block <?php echo $timer_start ? 'disabled' : '' ?>">Start Task</a></div>
				<div class="col-6"><a href="#" id="end-time" class="btn btn-danger btn-block <?php echo $timer_start ? '' : 'disabled' ?>">End Task</a></div>
			</div></div>
		</div>
		<div style="margin-top:30px">
			<h5 align="center">Time logs<h5>
		</div>
		<?php 
		$timelog->getData(array('task_id','=',$task_id));
		if($timelog->count()){?>
			<table class="table caption-top">
				<thead>
					<tr>
						<th>#</th>
						<th>Assignee</th>
						<th>Start</th>
						<th>End</th>
						<th>Total Hours</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$x = 1;
					foreach($timelog->data() as $data)
					{
					?>
						<tr>
							<td><?php echo $x;?></td>
							<td><?php $timelog->getAssignee($task_id); echo ucfirst($timelog->data())?></td>
							<td><?php echo $data->start_datetime?></td>
							<td><?php echo $data->end_datetime?></td>
							<td><?php echo $data->hours?></td>
							<td>
								<?php if($user_id === Session::get('user_id')){
									echo "<a href='' class='edit'><i class='material-icons'>&#xE254;</i>
									</a>";
								}
								else{
									echo "<a href='' class='edit disabled'><i class='material-icons' disabled>&#xE254;</i>
										</a>";
								}?>				
							</td>
						</tr>
					<?php $x++;}?>

				</tbody>
			</table>
		<?php } else {echo "<h5 class='ml-10'>'No records found !!!'</h5>";}?>
	</div>
	<div class="log-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Time log(Manually)</h5>
					<span class="btn-close">&#x2715</span>
				</div>
				<form id="myform" method="post" action="handle.php">
					<div class="modal-body">
						<div class="form-group">
							<label>start</label>
							<input type="datetime-local" name="start" id="start" class="form-control">
						</div>
						<div class="form-group">
							<label>End</label>
							<input type="datetime-local" name="end" id="end" class="form-control">
						</div>
						<div class="form-group">
							<label>Total Hours</label>
							<input type="text" name="totalHours" id="totalHours" class="form-control" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden"  name='m_id' value='<?php echo $_GET["m_id"]?>'> 
						<input type="hidden"  name='task_id' value='<?php echo $task_id?>'>
						<input type="hidden" class='id' name='assignee' value="<?php echo Session::get('user_id')?>">
						<button type="submit" class="btn btn-primary" name="addTimeLog">ADD</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="comment-section">
	<div class="mt-10 ml-10 title">
		<h5>Comments (0)</h5> 
	</div>
	<div class="content">
		<div class="form">
			<form id="addComment" method='post' action='handle.php'>
                <div class="form-group">
                	<label>write a comment</label>
                    <textarea name='comment' class="form-control mr-3" rows='2' placeholder="leave a comment.."></textarea>
                    <input type="hidden" name="task_id" value="<?php echo $task_id?>">
                    <input type="hidden" name="m_id" value="<?php echo $_GET['m_id']?>">
                    <button class="btn btn-info" name='addComment' type="submit">Comment</button>
                </div>
            </form>
		</div>
		<?php 
		if($c->count()){
			foreach($c->data() as $data){?>
				<div class="comment-list">
					<div class="comment-head">
						<h5 class="user_name text text-info">
							<?php $c->commentedBy($data->id);
							echo ucfirst($c->data());?>
						</h5>
						 <span class="time"><span class="dot"></span><?php echo getDateTimeDiff($data->date);?></span>
					</div>
					<div class="comment-body">
						<p><?php echo $data->comments?></p>
					</div>
				</div>
		<?php }}?>
	</div>
</div>
<script type="text/javascript">
	$("input#totalHours").focus(function(){
		var start = Date.parse($('input#start').val());
		var end  = Date.parse($('input#end').val());
		if(start<end)
		{
			totalHours = (end - start) / 1000 / 60 / 60;
			$(this).val(totalHours.toFixed(2));
		}
		else
		{
			$(this).val('0');
		}
		
	});
	$.validator.addMethod('greaterThan',function(value,element){
		var start = Date.parse($('input#start').val());
		return start < Date.parse(value);
	},"");

	$.validator.setDefaults({
		errorClass: 'warning',
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
	$('#myform').validate({
		rules:{
			start : "required",
			totalHours: "required",
			end: {
				required: true,
				greaterThan: "#start"
			}
		},
		messages:{
			start : "Please select start date and time",
			totalHours : "This section is required. Though it is calculated automatically you need to hover in input field to see value.",
			end : {
				required:"Please select end date and time",
				greaterThan: "End date time must be after start date time"
			}
		},
		submitHandler:function(form){
			form.submit();
		}
	});
	$('#addComment').validate({
		rules:{
			comment:"required"
		},
		messages:{
			comment: "Please write something."
		}

	});

	$('#openModal').click(function(){
		$('.log-modal').show();
	});
	$(".btn-close").click(function(){
		$(".log-modal").hide();
	});
	function secondsToHms(d) {
	    d = Number(d);
	    var h = Math.floor(d / 3600);
	    var m = Math.floor(d % 3600 / 60);
	    var s = Math.floor(d % 3600 % 60);
	    return getWithZero(h) + ":" + getWithZero(m) + ":" + getWithZero(s); 
	}
	function getWithZero(n) {
		return n < 9 ? "0"+n : n;
	}
	<?php if($timer_start) { ?>
		var diff = 0;
		$(document).ready(function(){
			var startedTime = '<?php echo $startedTime; ?>';
			var now = Math.floor(Date.now() / 1000);
			diff = now - startedTime;
			$('#current-time').html(secondsToHms(diff));
		});
		setInterval(function(){
			diff += 1;
			$('#current-time').html(secondsToHms(diff));
		}, 1000);
	<?php } ?>
</script>
