<?php 
class Task_Attachment{
	private $_data,
	        $_db,
	        $_count=0,
	        $_attachment;

	public function __construct()
	{
		$this->_db = Db::getInstance();
		$this->_attachment = new Attachment();

	}
	public function add($fields=array()){
		return $this->_db->insert('task_attachment', $fields);

	}
	public function get($where=array()){
		$this->_db->get('task_attachment',$where);
		if($this->_db->count()) {	
			$this->_count = $this->_db->count();
			foreach($this->_db->results() as $data) {
				if (!$this->_attachment->get(array('id','=',$data->attach_id))) {
					throw new Exception('there was an error');
				} else {
					$this->_attachment->get(array('id','=',$data->attach_id));
					$this->_data[] = $this->_attachment->data();
				}
			}
			return true;
		}
		return false;
	}

	public function remove($where= array())
	{
		return $this->_db->delete('task_attachment',$where);
	}

	public function count()
	{
		return $this->_count;
	}
	
	public function data()
	{
		return $this->_data;
	}
}