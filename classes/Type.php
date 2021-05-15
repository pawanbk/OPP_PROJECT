<?php
class Type{
	private $_data,
	        $_db,
	        $_count;

	public function __construct(){
		$this->_db = Db::getInstance();

	}
	public function add($fields=array()){
		return $this->_db->insert('type', $fields);

	}
	public function update($id,$fields=array()){
		return $this->_db->update('type',$id,$fields,'id');
	}

	public function get($where=array()){
		if (!$this->_db->get('type',$where))
		{
			throw new Exception('there was an error');
		}
		else{
			$data = $this->_db->get('type',$where);
			$this->_data = $data->results();
			$this->_count = $data->count();
			return true;
		}
		return false;

	}
	public function remove($where=array()){
		return $this->_db->delete('type',$where);
	}
	public function data(){
		return $this->_data;
	}
	public function count(){
		return $this->_count;
	}
}
