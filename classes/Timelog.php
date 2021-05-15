<?php
class Timelog{
	private $_data,
			$_db,
			$_count,
			$_user;

	public function __construct()
	{
		$this->_db = Db::getInstance();
		$this->_user = new User();
	}

	public function add($fields=array())
	{
		return $this->_db->insert('timelog',$fields);
	}

	public function getData($where=array())
	{
		if(!$this->_db->get('timelog',$where))
		{
			throw new Exception("Error Processing Request", 1);
			
		}
		else
		{
			$data = $this->_db->get('timelog',$where);
			$this->_data = $data->results();
			$this->_count = $data->count();
			return true;
		}
		return false;
	}
	public function getAssignee($id){
		$where = array('task_id','=',$id);
		if(!$this->_db->get('timelog',$where))
		{
			throw new Exception('there was an error');
		}
		else
		{
			$data = $this->_db->get('timelog',$where);
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
		return $this->_db->delete('timelog',$where);
	}
	public function count(){
		return $this->_count;
	}
	public function data(){
		return $this->_data;
	}
}
