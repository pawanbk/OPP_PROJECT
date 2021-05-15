<?php 
class Task {
	private $_data,
	        $_db,
	        $_count,
	        $_user;

	public function __construct(){
		$this->_db = Db::getInstance();
		$this->_user = new User();

	}

	public function add($fields=array()){
		return $this->_db->insert('task', $fields);
			
	}
	
	public function update($id,$fields=array()){
		return $this->_db->update('task',$id,$fields,'id');
	}

	public function get($where=array()){
		if (!$this->_db->get('task',$where))
		{
			throw new Exception('there was an error');
		}
		else{
			$data = $this->_db->get('task',$where);
			$this->_data = $data->results();
			$this->_count = $data->count();
			return true;
		}
		return false;

	}
	public function lastInserted($where=array())
	{
		$string= "ORDER BY id DESC LIMIT 1";
		if (!$this->_db->get('task',$where,$string))
		{
			throw new Exception('there was an error');
		}
		else{
			$data = $this->_db->get('task',$where,$string);
			$this->_data = $data->results();
			$this->_count = $data->count();
			return true;
		}
		return false;
	}
	public function createdBy($id)
	{
		$where = array('id','=',$id);
		if(!$this->_db->get('task',$where))
		{
			throw new Exception('there was an error');
		}
		else
		{
			$data = $this->_db->get('task',$where);
			$this->_data = $data->first();
			$user_id = $this->_data->created_by;
			if($this->_user->find($user_id))
			{
				if($this->_user->data())
				{
					$f_name = $this->_user->data()->f_name;
					$l_name = $this->_user->data()->l_name;
					$this->_data = $f_name.' '.$l_name;
				}
				
			}
			else
				{
					echo "no user";
				}
			return true;
		}
		return false;
	}
	public function getAssignee($id){
		$where = array('id','=',$id);
		if(!$this->_db->get('task',$where))
		{
			throw new Exception('there was an error');
		}
		else
		{
			$data = $this->_db->get('task',$where);
			$this->_data = $data->first();
			$user_id = $this->_data->assignee;
			if($this->_user->find($user_id))
			{
				if($this->_user->data())
				{
					$f_name = $this->_user->data()->f_name;
					$l_name = $this->_user->data()->l_name;
					$this->_data = $f_name.' '.$l_name;
				}
				
			}
			else
				{
					$this->_data = "no user assigned";
				}
			return $this->_data;
		}
		return false;
	}
	public function remove($where=array()){
		return $this->_db->delete('task',$where);
	}
	public function data(){
		return $this->_data;
	}
	public function count(){
		return $this->_count;
	}
}