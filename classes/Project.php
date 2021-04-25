<?php 
class Project {
	private $_data =array(),
	        $_db,
	        $_count;

	public function __construct(){
		$this->_db = Db::getInstance();

	}

	public function addProject($fields=array()){
		$this->_db->insert('project',$fields);
		return true;
	}
	public function getProjectByUser($fields=array()){
		$data = $this->_db->get('project',$fields);
		$this->_data = $data->results();
		$this->_count = $data->count();
	}
	public function getProjectById($where = array()){
		if (!$this->_db->get('project',$where))
		{
			throw new Exception('there was an error');
		}
		else{
			$data = $this->_db->get('project',$where);
			$this->_data = $data->results();
			$this->_count = $data->count();
			return true;
		}
		return false;

	}
	public function remove($where=array()){
    	return $this->_db->delete('project',$where);
	}
	public function update($id,$fields=array())
	{
		if (!$this->_db->update('project',$id,$fields,'proj_id'))
		{
			throw new Exception('there was an error');
		}
	}
	public function data(){
		return $this->_data;
	}
	public function count(){
		return $this->_count;
	}
}