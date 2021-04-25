<?php
class Comment{
	private $_data= array(),
			$_db,
			$_count,
			$_user;

	public function __construct(){
		$this->_db = Db::getInstance();
		$this->_user = new User();
	}
	public function add($fields=array()){
		return $this->_db->insert('comment', $fields);
	}

	public function get($where=array()){
		$string = "ORDER BY id DESC";
		if (!$this->_db->get('comment',$where,$string))
		{
			throw new Exception('there was an error');
		}
		else{
			$data = $this->_db->get('comment',$where,$string);
			$this->_data = $data->results();
			$this->_count = $data->count();
			return true;
		}
		return false;

	}
	public function commentedBy($id)
	{
		$where = array('id','=',$id);
		if(!$this->_db->get('comment',$where))
		{
			throw new Exception('there was an error');
		}
		else
		{
			$data = $this->_db->get('comment',$where);
			$this->_data = $data->first();
			$user_id = $this->_data->user_id;
			if($this->_user->find($user_id))
			{
				if($this->_user->data())
				{
					$f_name = $this->_user->data()->f_name;
					$l_name = $this->_user->data()->l_name;
					$this->_data = $f_name.' '.$l_name;
				}
				
			}
			else
				{
					echo "no user";
				}
			return true;
		}
		return false;
	}
	
	public function remove($where= array()){
		return $this->_db->delete('comment',$where);
	}
	public function count(){
		return $this->_count;
	}
	public function data(){
		return $this->_data;
	}
	}