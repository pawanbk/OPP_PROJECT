<?php 
class Project {
	private $_data,
	        $_db,
	        $_count,
	        $_milestone;

	public function __construct(){
		$this->_db = Db::getInstance();
		$this->_milestone = new Milestone();

	}

	public function addProject($fields=array()){
		$this->_db->insert('project',$fields);
		return true;
	}
	public function getProjectByUser($fields=array(),$string=''){
		$data = $this->_db->get('project',$fields, $string);
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
	public function getProgress($id){
		$this->_milestone->get(array('proj_id','=',$id));
		$total_count = $this->_milestone->count();
		if($this->_milestone->count())
		{
			$avg =0;
			foreach($this->_milestone->data() as $data)
			{
				$percent = $this->_milestone->getProgress($data->id);
				$avg += ($percent/$total_count);
			}
		}
		else
		{
			$avg =0;
		}
		return $avg;
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