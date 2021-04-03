<?php 
class Project {
	private $_data =array(),
	        $_db,
	        $_count;

	public function __construct(){
		$this->_db = Db::getInstance();
		$this->getProjectByUser();

	}

	public function addProject($fields=array()){
		$this->_db->insert('project',$fields);
		return true;
	}
	public function getProjectByUser(){
		global $config;
		$where = array('user_id','=',Session::get($config['session']['session_id']));
		$data = $this->_db->get('project',$where);
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
			return true;
		}
		return false;

	}
	public function removeProject($where=array()){
    	return $this->_db->delete('project',$where);
	}
	public function editProject($id,$fields=array())
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