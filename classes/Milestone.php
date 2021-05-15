<?php 
class Milestone {
	private $_data,
	        $_db,
	        $_count,
	        $_task;

	public function __construct(){
		$this->_db = Db::getInstance();
		$this->_task = new Task();

	}
	public function add($fields=array()){
		return $this->_db->insert('milestone', $fields);

	}
	public function update($id,$fields=array()){
		return $this->_db->update('milestone',$id,$fields,'id');
	}

	public function get($where=array(),$string=''){
		if (!$this->_db->get('milestone',$where,$string))
		{
			throw new Exception('there was an error');
		}
		else{
			$data = $this->_db->get('milestone',$where,$string);
			$this->_data = $data->results();
			$this->_count = $data->count();
			return true;
		}
		return false;

	}
	public function getProgress($id){
		$this->_task->get(array('m_id','=',$id));
		$total_task = $this->_task->count();
		if($this->_task->count()){
			foreach($this->_task->data() as $data)
			{	
				$this->_task->get(array('mark','=','complete','and','m_id','=',$id));
				if($this->_task->count())
				{
					$percent = round($this->_task->count()/$total_task*100,1);
				}
				else
				{
					$percent = 0;
				}
				
			}
		}
		else
		{
			$percent =0;
		}
		return $percent;
	}
	public function remove($where=array()){
		return $this->_db->delete('milestone',$where);
	}
	public function data(){
		return $this->_data;
	}
	public function count(){
		return $this->_count;
	}
}