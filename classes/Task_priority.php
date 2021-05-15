<?php
class Task_priority{
	private $_data,
	        $_db,
	        $_count;

	public function __construct(){
		$this->_db = Db::getInstance();

	}
	public function add($fields=array()){
		return $this->_db->insert('task_priority', $fields);

	}
	public function update($id,$fields=array()){
		return $this->_db->update('task_priority',$id,$fields,'id');
	}

	public function get($where=array()){
		if (!$this->_db->get('task_priority',$where))
		{
			throw new Exception('there was an error');
		}
		else{
			$data = $this->_db->get('task_priority',$where);
			$this->_data = $data->results();
			$this->_count = $data->count();
			return true;
		}
		return false;

	}
	public function getById($id)
	{
		$where =array('id','=',$id);
		if (!$this->_db->get('task_priority',$where))
		{
			throw new Exception('there was an error');
		}
		else
		{
			$data = $this->_db->get('task_priority',$where);
			$this->_count = $data->count();
			foreach($data->results() as $d)
			{
				$this->_data = $d->name;
			}
			return true;
		}
		return false;
	}
	public function remove($where=array()){
		return $this->_db->delete('task_priority',$where);
	}
	public function data(){
		return $this->_data;
	}
	public function count(){
		return $this->_count;
	}
}
