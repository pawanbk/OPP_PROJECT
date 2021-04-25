<?php
require '../core/init.php';
if(isset($_POST['attach']))
{

   if(!empty($_FILES['file']['name']))
   {	
   		$count = count($_FILES['file']['name']);
	   	for($i=0;$i<$count;$i++)
		{
			$file_name = $_FILES['file']['name'][$i];
			echo $file_name;
			$file_type = $_FILES['file']['type'][$i];
			$file_tmp = $_FILES['file']['tmp_name'][$i];
			$file_ext = explode('.', $file_name);
			$file_act_ext = strtolower(end($file_ext));
			$format = ['jpg','jpeg','png','pdf'];
			$path = 'upload';
			if(in_array($file_act_ext,$format))
			{
				$file_des = $path .'/'. $file_name;
				$path_to_be_store = 'http://localhost/OOP_PROJECT/'.$file_des;
				$move = move_uploaded_file($file_tmp, '../'.$file_des);
				if(!$move)
				{
					echo('sorry cannot upload file');
				}
				else
				{
					$a->add(array('attachment' => $path_to_be_store,'uploaded_on'=>$time->currentdate()));
					$a->lastInserted();
					if($a->count())
					{
						foreach($a->data() as $data)
						{
							$ta->add(array(
								'attach_id'=>$data->id, 
								'task_id'=>Input::get('task_id')));
						}
					}	
				}
			}
			else
			{
				Session::flash('error', 'select at least one file/choose only .jpg, .jpeg, .png, .pdf files');
				Redirect::to('view.php?task_id='.Input::get('task_id'));
			}
		}
		Redirect::to('view.php?task_id='.Input::get('task_id'));
	}
}
if(isset($_GET['delete']))
{
	$attach_id = $_GET['delete'];
	$ta->remove(array('attach_id','=',$attach_id));
	$a->remove(array('id','=',$attach_id));
	Redirect::to('view.php?task_id='.$_GET['task_id']);

}