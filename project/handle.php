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
			if(diffDate($date_formated)==true)
			{
				 $p->addProject(
	    		array(
	    			'proj_name'   => Input::get('proj_name'),
	    			'user_id'     => Input::get('id'),
	    			'due_date' => $date_formated
	    		));
	         Session::flash('success', 'Project has been created.');
	         Redirect::to($config['base_url'].'index.php') ;
			}
			else
			{
				Session::flash('errors', 'Please select valid due date.');
	        	Redirect::to($config['base_url'].'index.php');
			}
	       
		}
		else 
		{
			foreach($validation->getError() as $err)
			{
				Session::put('errors',$err);
				Redirect::to($config['base_url'].'index.php');
			}
			
		}
	}
}

function delete_project($proj_id)
{
	global  $m,
			$t,
			$ta,
			$c,
			$timelog,
			$p;

	$m->get(array('proj_id','=',$proj_id));
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
					$ta->remove(array('task_id','=',$task_id));
					$c->remove(array('task_id','=',$task_id));
					$timelog->remove(array('task_id','=',$task_id));
				}
				$c->remove(array('m_id','=',$m_id));
				$t->remove(array('m_id','=',$m_id));
			    $m->remove(array('proj_id','=',$proj_id));
			    $p->remove(array('proj_id','=',$proj_id));
				Session::flash('success','Deleted successfully !!!');
			}
			else
			{	
				$c->remove(array('m_id','=',$m_id));
			    $m->remove(array('proj_id','=',$proj_id));
			    $p->remove(array('proj_id','=',$proj_id));
				Session::flash('success','Deleted successfully !!!');
				
			}
		}
		
	}
	
	else
	{
		$p->remove(array('proj_id','=',$proj_id));
		Session::flash('success','Deleted successfully !!!');
	}
}

if (isset($_POST['delete']))
{
	delete_project($_POST['delete']);
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
	         Redirect::to($config['base_url'].'index.php');
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

if(isset($_POST['checkbox'][0]))
{
	foreach($_POST['checkbox'] as $id)
	{
		delete_project($id);
	}
}
?>
