<?php 
class Task_Attachment{
	private $_data =array(),
	        $_db,
	        $_count;

	public function __construct(){
		$this->_db = Db::getInstance();

	}
	public function add($fields=array()){
		return $this->_db->insert('task_attachment', $fields);

	}
	public function get($where=array()){
		if (!$this->_db->get('Task_Attachment',$where))
		{
			throw new Exception('there was an error');
		}
		else{
			$data = $this->_db->get('task_attachment',$where);
			$this->_data = $data->results();
			$this->_count = $data->count();
			return true;
		}
		return false;

	}
	public function remove($where= array()){
		return $this->_db->delete('task_attachment',$where);
	}
	public function count(){
		return $this->_count;
	}
	public function data(){
		return $this->_data;
	}
}