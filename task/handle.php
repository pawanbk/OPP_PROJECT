<?php
require_once '../core/init.php';

// add new task
if(isset($_POST['add']))
{
	if(Input::exists())
	{
		$v->check($_POST,
			array(
				'name' =>array(
					'required' =>true,
					'min'      => '2',
					'max'      => '20'
				),
			'description'=>array (
					'min' => '5' 
				),
				'date'  =>array(
					'required' => true
				),
				'assignee' => array(
					'required' => true
				)
			)
		);
		if($v->passed())
		{
			$t->add(array(
				'name' => Input::get('name'),
				'due_date' => date('Y-m-d', strtotime(Input::get('date'))),
				'description' => Input::get('description'),
				'status'   => '0',
				'type'     => 'not set',
				'created_by' => Session::get('user_id'),
				'm_id'     => Input::get('m_id'),
				'assignee' => Input::get('assignee')
				));
			Session::flash('success', 'A task is Created.');
			Redirect::to('view.php?m_id='.Input::get('m_id'));
		}
		else
		{
			foreach($v->getError() as $err)
			{
				echo $err.'<br>';
			}
		}
	}
}

// delete particular task
if(isset($_POST['delete']))
{
	$timelog->remove(array('task_id','=',$task_id));
	$ta->remove(array('task_id','=',$_POST['delete']));
	$c->remove(array('task_id','=', $_POST['delete']));
	$t->remove(array('id','=', $_POST['delete']));
	Session::flash('success', 'Task has been deleted.');	
}

// update particular task
if(isset($_POST['update']))
{
	$v->check($_POST,
		array(
			'name' =>array(
				'required' =>true,
				'min'      => '3',
				'max'      => '20'
			),
			'date'  =>array(
				'required' => true
			),
			'assignee' => array(
				'required' => true
			)
		)
	);
	if($v->passed())
	{
		$t->update(Input::get('task_id'),array(
			'name' => Input::get('name'),
			'due_date' => date('Y-m-d', strtotime(Input::get('date'))),
			'assignee' => Input::get('assignee')
			));
		Session::flash('success','Task has been updated.');
		Redirect::to('view.php?m_id='.Input::get('m_id'));

	}
	else
	{
		foreach($v->getError() as $error)
		{
			Session::put('errors',$error);
			Redirect::to('edit.php?edit='.Input::get('task_id').'&m_id='.Input::get('m_id'));

		}
	}
}

/* task type */
//create type
if(isset($_POST['createType']))
{
	$v->check($_POST, array(
		'name'=> array(
			'required' => true,
			'min'      => '2',
			'unique'   => 'type'

		)
	));
	if($v->passed())
	{
		$ty->add(array('name' => Input::get('name')));
		Redirect::to('type.php');
	}
}
//update type
if(isset($_POST['updateType']))
{
	$v->check($_POST, array(
		'name'=> array(
			'required' => true,
			'min'      => '2',
			'unique'   => 'status'

		)
	));
	if($v->passed())
	{
		$ty->update(Input::get('id'),array('name' => Input::get('name')));
		Redirect::to('type.php');
	}
}

// delete type
if(isset($_GET['deleteType']))
{
	if($_GET['deleteType'] != '')
	{
		$ty->remove(array('id','=',$_GET['deleteType']));
		Redirect::to('type.php');
	}
}
/* ----End----*/

/* task priority Level */
// create task priority level
if(isset($_POST['createPriorityLevel']))
{
	$v->check($_POST, array(
		'name'=> array(
			'required' => true,
			'min'      => '2',
			'unique'   => 'type'

		)
	));
	if($v->passed())
	{
		$pr->add(array('name' => Input::get('name')));
		Redirect::to('priority.php');
	}
}

// update task priority level
if(isset($_POST['updatePriorityLevel']))
{
	$v->check($_POST, array(
		'name'=> array(
			'required' => true,
			'min'      => '2',
			'unique'   => 'status'

		)
	));
	if($v->passed())
	{
		$pr->update(Input::get('id'),array('name' => Input::get('name')));
		Redirect::to('priority.php');
	}
}

//delete priority level
if(isset($_GET['deletePriorityLevel']))
{
	if($_GET['deletePriorityLevel'] != '')
	{
		$pr->remove(array('id','=',$_GET['deletePriorityLevel']));
		Redirect::to('priority.php');
	}
}
/* ----End----*/

/* task status */
// create task status

if(isset($_POST['createStatus']))
{
	$v->check($_POST, array(
		'name'=> array(
			'required' => true,
			'min'      => '2',
			'unique'   => 'status'

		)
	));
	if($v->passed())
	{
		$s->add(array('name' => Input::get('name')));
		Redirect::to('status.php');
	}
}

//update task status
if(isset($_POST['updateStatus']))
{
	$v->check($_POST, array(
		'name'=> array(
			'required' => true,
			'min'      => '2',
			'unique'   => 'status'

		)
	));
	if($v->passed())
	{
		$s->update(Input::get('id'),array('name' => Input::get('name')));
		Redirect::to('status.php');
	}
}
//delete task status
if(isset($_GET['deleteStatus']))
{
	if($_GET['deleteStatus'] != '')
	{
		$s->remove(array('id','=',$_GET['deleteStatus']));
		Redirect::to('status.php');
	}
}
/* ----End----*/

// set status of the task
if(isset($_POST['status']))
{
	 $t->update($_POST['id'],array('status' =>$_POST['status']),'id');
	 Session::flash('success','status of the task changed');
}

// set type of the task
if(isset($_POST['type']))
{
	 $t->update($_POST['id'],array('type' =>$_POST['type']),'id');
	 Session::flash('success','Task type has been changed successfully.');
}

// set priority level of the task
if(isset($_POST['priority']))
{
	 $t->update($_POST['id'],array('priority' =>$_POST['priority']),'id');
	 Session::flash('success','Priority level has been changed.');
}

// search assignee using autocomplete
if(isset($_POST['search']))
{
	$name = '%'.$_POST['search'].'%';
	$u->search(array('f_name','like',$name,'OR','l_name','like',$name));
	$result = '';
	if($u->count())
	{	
		$result = '<ul class="list-group">';
		foreach($u->data() as $data)
		{
			$f_name = $data->f_name;
			$l_name = $data->l_name;
			$fullname = ucfirst($f_name.' '. $l_name);
			$result .= "<li class='list-group-item' data-user-id='".$data->user_id."'>".$fullname."</li>";
		}
		$result .= '</ul>';
	}
	else 
		{
			$result = "<ul class='list-group'><li class='list-group-item'>no user found</li></ul>";
		}
		echo $result;
}

// add comment to the task
if(isset($_POST['addComment']))
{
	$c->add(array(
		'comments' => Input::get('comment'),
		'date'	   => curdatetime(),
		'task_id'  => Input::get('task_id'),
		'user_id'  => Session::get('user_id')
		
	));
	Redirect::to('edit.php?edit='.Input::get('task_id').'&&m_id='.Input::get('m_id'));
}

// mark task as complete or incomplete 
if(isset($_POST['checked']))
{
	$t->update($_POST['checked'],array('mark' => 'complete'));
}

if(isset($_POST['unchecked']))
{
	$t->update($_POST['unchecked'],array('mark' => ''));
}

// add time log manually
if(isset($_POST['addTimeLog']))
{
	$timelog->add(array(
		"task_id" => Input::get('task_id'),
		"assignee" => Input::get('assignee'),
		"start_datetime" => Input::get('start'),
		"end_datetime" => Input::get('end'),
		"hours" => Input::get('totalHours')
	));
	Redirect::to('edit.php?edit='.Input::get('task_id').'&&m_id='.Input::get('m_id'));
}