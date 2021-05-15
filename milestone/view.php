<?php
require_once '../core/init.php';
include "{$config['path']['p2']}header.php"; 
$proj_id = $_GET['proj_id'];
$m->get(array('proj_id','=', $proj_id));
?>
<div class="box">
	<?php 
		if (Session::exists('success'))
		{
			echo "<div class='alert alert-success'><p>"
			.Session::flash('success').
			"</p></div>";
		}
		?>
	<div class='box-wrapper'>
		<div class="form-box">
			<form  method="post" action="handle.php">
				<div class="form-title">
					<h5>Create Milestone</h5>
				</div>
				<?php if (Session::exists('errors'))
					{
						echo "<div class='error-flash'><p>"
						.Session::flash('errors').
						"</p></div>";
					}?>
				<div class="form-group">
					<label>Name</label>
					<input type="text" class="form-control" name="name">
				</div>
				<div class="form-group">
					<label>Due date</label>
					<input type="date" class="form-control" name="date" >
				</div>
				<div class="form-group">
					<input type="hidden" name="proj_id" value="<?php echo $proj_id?>">
					<button type="submit" name= 'add' class="btn btn-info">ADD</button>
				</div>
			</form>
		</div>
	</div>
	<?php if($m->count()){?>
		<div class="table-wrapper scrollable">
			<div class="table-title">
				<h5>Milestone List</h5>
			</div>
			<div class="div-right mbr-5">
				<button class="btn btn-danger" onclick="delete_all()">Delete Records</button>
			</div>
			<form id="frm">
				<table class="table">
					<thead>
						<tr>
							<th><input type="checkbox" id="delete" onclick="select_all()"></th>
							<th>ID</th>
							<th>Name</th>
							<th>Due Date</th>
							<th>Task</th>
							<th>Status</th>
							<th>Progress Bar</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$x=1;
						foreach($m->data() as $data)
						{?>
						<tr>
							<td><input type="checkbox" name = "checkbox[]" value="<?php echo $data->id;?>"></td>
							<td><?php echo $data->id;?></td>
							<td><?php echo $data->name;?></td>
							<td><?php echo $data->due_date;?></td>
							<td><a class="view btn btn-info btn-sm" href="<?php echo $config['base_url']?>task/view.php?m_id=<?php echo $data->id?>">view</a></td>
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
								<div class="progress">
									<div class="progress-bar" style="width:<?php echo $m->getProgress($data->id).'%';?>"><?php echo $m->getProgress($data->id).'%';?>	
									</div>
								</div>
							</td>
							<td class="toBeDisabled">
								<a href="edit.php?edit=<?php echo $data->id?>&proj_id=<?php echo $proj_id?>" class="edit"><i class="material-icons">&#xE254;</i></a>
								<a data-delete-id='<?php echo $data->id?>' class="delete"><i class="material-icons" >&#xE872;</i></a>
							</td>
						</tr> 
						<?php
						$x++; }
						?>	
					</tbody>
				</table>
			</form>
		</div>
	<?php }
	else 
	{
		echo empty_div('Milestones','edit, delete and also view tasks');
	}
	?>
	<?php echo delete_modal();?>
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
		$('.btn-close').click(function(){
			$('#Modal').hide();
		})
	});
	function select_all()
	{
		if($('#delete').prop('checked'))
		{
			$('input[type=checkbox]').each(function(){
				$(this).prop('checked',true);
			});
			
		}
		else
		{
			$('input[type=checkbox]').each(function(){
				$(this).prop('checked',false);
			})
			
		}
		
		
	}
	$("input[type='checkbox']").click(function(){
			if($(this).is(':checked'))
			{
				$('.div-right').show();
				$('.toBeDisabled').addClass('disabled-td');
			}
			else if($(this).is(':unchecked'))
			{
				$('.div-right').hide();
				$('.toBeDisabled').removeClass('disabled-td')
			}
		});
	function delete_all(){
		$.post('handle.php',$('#frm').serialize())
		.done(function(){
			location.reload();
		})
	}
</script>