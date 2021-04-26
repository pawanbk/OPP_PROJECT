<?php 
require '../core/init.php';

if(isset($_POST['add']))
{
	if(Input::exists())
	{
		$validation = $v->check($_POST,
			array(
				'proj_name' => array(
					'required' => true,
					'min'      => '2',
					'max'	   => '20'
				 ),
				'due_date' =>array(
					'required' => true
				)
			));

		if ($validation->passed())
		{	

			$date_formated = date('Y-m-d', strtotime(Input::get('due_date')));
			if($time->diffDate($date_formated)==true)
			{
				 $p->addProject(
	    		array(
	    			'proj_name'   => Input::get('proj_name'),
	    			'user_id'     => Input::get('id'),
	    			'due_date' => $date_formated
	    		));
	         Session::flash('success', 'Project has been created.');
	         Redirect::to($config['path']['p1']);
			}
			else
			{
				Session::flash('errors', 'Select valid due date.');
	        	Redirect::to($config['path']['p1']);
			}
	       
		}
		else 
		{
			foreach($validation->getError() as $err)
			{
				Session::put('errors',$err);
				Redirect::to($config['path']['p1']);
			}
			
		}
	}
}

if (isset($_POST['delete']))
{
	$m->get(array('proj_id','=',$_POST['delete']));
	if($m->count())
	{
		foreach($m->data() as $data)
		{
			$m_id = $data->id;
			$t->get(array('m_id','=',$m_id));
			if($t->count())
			{
				foreach($t->data() as $d)
				{
					$task_id = $d->id;
					$ut->remove(array('task_id','=',$task_id));
					$ta->remove(array('task_id','=',$task_id));
					$c->remove(array('task_id','=',$task_id));
				}
				$c->remove(array('m_id','=',$m_id));
				$t->remove(array('m_id','=',$m_id));
			    $m->remove(array('proj_id','=',$_POST['delete']));
			    $p->remove(array('proj_id','=',$_POST['delete']));
				Session::flash('success','Project has been removed.');
			}
			else
			{	
				$c->remove(array('m_id','=',$m_id));
			    $m->remove(array('proj_id','=',$_POST['delete']));
			    $p->remove(array('proj_id','=',$_POST['delete']));
				Session::flash('success','Project has been removed.');
				
			}
		}
		
	}
	
	else
	{
		$p->remove(array('proj_id','=',$_POST['delete']));
		Session::flash('success','Project has been removed.');
	}
}

if(isset($_POST['update']))
{
	if(Input::exists())
	{
		$validation = $v->check($_POST,
		array(
			'proj_name' => array(
				'required' => true
			 ),
			'due_date' =>array(
				'required' => true
			)));

		if ($validation->passed())
		{
	         $p->update(Input::get('id'),
	    		array(
	    			'proj_name'   => Input::get('proj_name'),
	    			'due_date' => Input::get('due_date')
	    		));
	         Session::flash('success', 'Project has been updated.');
	         Redirect::to($config['path']['p1']);
		}
		else
		{
			foreach($v->getError() as $err)
			{
				Session::put('errors', $err);
				Redirect::to('view.php?proj_id='.Input::get('id'));
			}
			
		}
	}
}

?>
