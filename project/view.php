<?php
$id = Session::get('user_id');
$p->getProjectByUser(array('user_id','=',$id));
$record = $p->count();
$per_page = 5;
$pagi = ceil($record/$per_page);
$page =0;
$current_page = 1;
if(isset($_GET['page']))
{
	$page = $_GET['page'];
	if($page<=0)
	{
		$page = 0;
		$current_page=1;
	}
	else
	{
		$current_page = $page;
		$page--;
		$page = $page*$per_page;	
	}

}
$p->getProjectByUser(array('user_id','=',$id),"order by proj_id DESC limit $page, $per_page");
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
			<form  method="post" action='project/handle.php'>
				<div class="form-title">
					<?php if($update == true):?>
						<h5>Update Project</h5>
					<?php else:?>
						<h5><span>Add</span> Project</h5>
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
						<button type="submit" name='update' class="btn btn-primary">UPDATE</button>
					<?php endif;?>
				</div>
		     </form>
 		</div>
	</div>

	<?php if($record>0){?>
	<div class="table-wrapper">
		<div class="table-title">
			<h5>Manage <span>Projects</span></h5>
		</div>
		<form id="frm">
			<div class="div-right mbr-5">
				<button class="btn btn-danger" onclick="delete_all()">Delete Records</button>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th><input type="checkbox" id="delete" onclick="select_all()"></th>
						<th>ID</th>
						<th>Project Name</th>
						<th>Due date</th>
						<th>Milestone</th>
						<th>Average progress</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
			<?php 
			if($p->count()){
				foreach($p->data() as $data)
				{?>
					<tr>
						<td><input type="checkbox" name = "checkbox[]" value="<?php echo $data->proj_id;?>"></td>
						<td><?php echo $data->proj_id;?></td>
						<td><?php echo ucfirst($data->proj_name);?></td>
						<td><?php echo $data->due_date;?></td>
						<td><a class="view btn btn-info btn-sm" href="milestone/view.php?proj_id=<?php echo $data->proj_id?>">view</a></td>
						<td>
							<div class="progress">
								<div class="progress-bar progress-bar-striped" style="width:<?php echo $p->getProgress($data->proj_id).'%';?>"><?php echo round($p->getProgress($data->proj_id),2).'%';?></div>
							</div>
						</td>
						<td class="toBeDisabled">
							<a href="?edit=<?php echo $data->proj_id?>" class="edit"><i class="material-icons">&#xE254;</i></a>
							<a class="delete" data-id="<?php echo $data->proj_id;?>"><i class="material-icons" title="Delete">&#xE872;</i></a>
						</td>
					</tr> 
					
				<?php
				 }
				}
				else
				{
					echo "<td><h4>No records found!!!!</h4></td>";
				}
				?>	
				</tbody>
			</table>
		</form>
		<?php if($pagi > 1){?>
		<div class="pagination-div">
			<nav class="mt-10">
				<ul class="pagination">
					<?php 
						for($i=1;$i<=$pagi;$i++){
							$class='';
							if($current_page == $i)
							{
								$class = 'active';
							}
					?>
						<li class="page-item <?php echo $class?>"><a class="page-link" href="?page=<?php echo $i?>"><?php echo $i?></a></li>
					<?php }?>
				</ul>
			</nav>
		</div>
	<?php } ?>
	</div>
	<?php }
	else 
	{
		echo empty_div('Projects','edit, delete and also view milestones');
	}
	?>
	<?php echo delete_modal();?>
</div>
<script type="text/javascript">
	$('.delete').click(function(){
		var id = $(this).data('id');
		$('#Modal').show();
		$('#yes').click(function(){
			$.post('project/handle.php',{delete:id})
			.done(function(){
				location.reload();
			})
		})
	});
	$('.btn-close').click(function(){
		$('#Modal').hide();
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
		$.post('project/handle.php',$('#frm').serialize());
	}
	
</script>