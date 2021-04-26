<?php
require '../core/init.php';
if(isset($_POST['add']))
{
	if(Input::exists())
	{
		$v->check($_POST,
			array(
				'name' =>array(
					'required' =>true,
					'min'      => '3',
					'max'      => '20'
				),
				'description'=>array (
					'min' => '5' 
				),
				'date'  =>array(
					'required' => true
				),
				'assigned_user' => array(
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
				'm_id'     => Input::get('m_id')
				));
			$t->lastInserted();
			foreach ($t->data() as $data)
			{
				$task_id = $data->id;
			}
			$ut->add(array('task_id'=> $task_id, 'user_id'=> Input::get('assigned_user')));
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


if(isset($_POST['status']))
{
	 $t->update($_POST['id'],array('status' =>$_POST['status']),'id');
	 Session::flash('success','status of the task changed');
}

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
			$result = '<ul class="user-list"><li>no user found</li></ul>';
		}
		echo $result;
}


if(isset($_POST['delete']))
{
	$ut->remove(array('task_id','=',$_POST['delete']));
	$ta->remove(array('task_id','=',$_POST['delete']));
	$c->remove(array('task_id','=', $_POST['delete']));
	$t->remove(array('id','=', $_POST['delete']));
	Session::flash('success', 'Task has been deleted.');	
}

if(isset($_POST['update']))
{
	$v->check($_POST,
		array(
			'name' =>array(
				'required' =>true,
				'min'      => '3',
				'max'      => '20'
			),
			'description'=>array (
				'min' => '5' 
			),
			'date'  =>array(
				'required' => true
			)
			)
	);
	if($v->passed())
	{
		$t->update(Input::get('task_id'),array(
			'name' => Input::get('name'),
			'due_date' => date('Y-m-d', strtotime(Input::get('date'))),
			'description' => Input::get('description')
			));
		Session::flash('success','Task has been updated.');
		Redirect::to('view.php?m_id='.Input::get('m_id'));

	}
}
if(isset($_POST['addComment']))
{
	$v->check($_POST, array(
			'comment' => array(
				'required'=> true
			)
	));
	if($v->passed())
	{
		$c->add(array(
			'comments' => Input::get('comment'),
			'date'	   => $time->curdatetime(),
			'task_id'  => Input::get('task_id'),
			'user_id'  => Session::get('user_id')
			
		));
		Redirect::to('edit.php?edit='.Input::get('task_id'));
	}
}
