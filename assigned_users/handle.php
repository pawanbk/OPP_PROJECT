<?php 
require '../core/init.php';
if(isset($_POST['assign']))
{
	$v->check($_POST,
		array(
			'user_id'=>array(
				'required' => true,
				'unique'   => 'user_task'
			)
		));
	if($v->passed())
	{
		$ut = new User_task();
		$ut->add(array('task_id'=>Input::get('task_id'),'user_id'=>Input::get('user_id')));
		Redirect::to('view.php?id='.Input::get('task_id'));
	}
	else
	{
		print_r($v->getError());
	}
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
if(isset($_GET['action']))
{
	$action = trim($_GET['action']);
	if( $action = 'delete')
	{	
		$ut->remove(array('user_id','=',$_GET['user_id']));
		Redirect::to('view.php?id='.$_GET['task_id']);
		
	}

}
