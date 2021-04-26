<?php
require '../core/init.php';
$status ='';
if(isset($_POST['add']))
{
	$date = $_POST['date'];
	$date_format = date('Y-m-d', strtotime($date));
	if(Input::exists())
	{
		$v->check($_POST,array(
			'name' => array (
				'required' => true,
				'min'      => '3',
				'max'      => '20'
			),
			'date' => array(
				'required' => true,
			)
		));
		if($v->passed())
		{
			if($time->diffDate($date_format) == false)
			{
				Session::flash('errors', 'Please select valid due date');
				Redirect::to('view.php?proj_id='.$_POST['proj_id']);
			}

			else
			{
				$fields = array(
				'name'     => Input::get('name'),
				'user_id'  => Session::get('user_id'),
				'due_date' => $date_format,
				'proj_id'  => Input::get('proj_id')
			 	);
			 	if($m->add($fields))
			 	{
			 		Session::flash('success','Milestone has been created.');
			 		Redirect::to('view.php?proj_id='.$_POST['proj_id']);
			 	}
			}
		}
		else
		{
			foreach($v->getError() as $err)
			{
				Session::put('errors',$err);
				Redirect::to('view.php?proj_id='.$_POST['proj_id']);
			}
		}
	}
	
}

if(isset($_GET['type']) && $_GET['type'] !='')
{
	$type = trim($_GET['type']);
	if($type == 'status')
	{
		$operation = trim($_GET['operation']);
		$id        = trim($_GET['id']);
		if($operation == 'set')
		{
			$status ='1';
		}
		else
		{
			$status = '0';
		}

		$m->update($id, array('proj_id'=>$_GET['proj_id'],'status' => $status), 'id');
		Redirect::to('view.php?proj_id='.$_GET['proj_id']);
	}
}

if(isset($_POST['update']))
{
	$date = Input::get('date');
	$date_format = date('Y-m-d',strtotime($date));
	if(Input::exists())
	{
		$v->check($_POST,array(
			'name' => array (
				'required' => true,
				'min'      => '3',
				'max'      => '20'
			),
			'date' => array(
				'required' => true
			)
		));
		if($v->passed())
		{
			if($time->diffDate($date_format))
			{
				$m->update(Input::get('m_id'), array('name'=> Input::get('name'), 'due_date' => $date_format));
				Session::flash('success','Milestone has been updated.');
				Redirect::to('view.php?proj_id='.Input::get('proj_id'));
			}
			else
			{
				Session::put('errors', "Please select valid due date.");
				Redirect::to('view.php?proj_id='.Input::get('proj_id'));
			}
			
		}
		else
		{
			foreach($v->getError() as $err)
			{
				Session::put('errors', $err);
				Redirect::to('view.php?proj_id='.Input::get('proj_id'));
			}
			
		}

	}
}

if(isset($_POST['delete']))
{	
	$t->get(array('m_id','=',$_POST['delete']));
	if($t->count())
	{
		foreach($t->data() as $data)
		{
			$task_id = $data->id;
			$ut->remove(array('task_id','=',$task_id));
			$ta->remove(array('task_id','=',$task_id));
			$c->remove(array('task_id','=',$task_id));
		}
		$c->remove(array('m_id','=',$_POST['delete']));
		$t->remove(array('m_id','=',$_POST['delete']));
		$m->remove(array('id','=',$_POST['delete']));
		Session::flash('success','Milestone has been removed.');
	}
	else
	{	
		$c->remove(array('m_id','=',$_POST['delete']));
		$m->remove(array('id','=',$_POST['delete']));
		Session::flash('success','Milestone has been removed.');
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
			'm_id'  => Input::get('m_id'),
			'user_id'  => Session::get('user_id')
			
		));
		Redirect::to('edit.php?edit='.Input::get('m_id'));
	}
}