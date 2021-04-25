<?php 
class User_task {
	private $_data =array(),
	        $_db,
	        $_count,
	        $user;

	public function __construct(){
		$this->_db = Db::getInstance();

	}
	public function add($fields=array()){
		return $this->_db->insert('user_task', $fields);

	}
	public function get($where=array()){
		if (!$this->_db->get('user_task',$where))
		{
			throw new Exception('there was an error');
		}
		else{
			$data = $this->_db->get('user_task',$where);
			$this->_data = $data->results();
			$this->_count = $data->count();
			return true;
		}
		return false;

	}
	public function remove($where= array()){
		return $this->_db->delete('user_task',$where);
	}
	public function count(){
		return $this->_count;
	}
	public function data(){
		return $this->_data;
	}
}