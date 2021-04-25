<?php
class Status{
	private $_data =array(),
	        $_db,
	        $_count;

	public function __construct(){
		$this->_db = Db::getInstance();

	}
	public function add($fields=array()){
		return $this->_db->insert('status', $fields);

	}
	public function update($id,$fields=array()){
		return $this->_db->update('status',$id,$fields,'id');
	}

	public function get($where=array()){
		if (!$this->_db->get('status',$where))
		{
			throw new Exception('there was an error');
		}
		else{
			$data = $this->_db->get('status',$where);
			$this->_data = $data->results();
			$this->_count = $data->count();
			return true;
		}
		return false;

	}
	public function remove($where=array()){
		return $this->_db->delete('status',$where);
	}
	public function data(){
		return $this->_data;
	}
	public function count(){
		return $this->_count;
	}
}
