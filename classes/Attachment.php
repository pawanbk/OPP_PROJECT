<?php
class Attachment
{
	private $_data= array(),
			$_db,
			$_count;

	public function __construct()
	{
		$this->_db = Db::getInstance();
	}

	public function add($fields=array())
	{
		return $this->_db->insert('attachment', $fields);
	}

	public function get($where=array())
	{
		if (!$this->_db->get('attachment',$where)) {
			throw new Exception('there was an error');
		} else {
			$data = $this->_db->get('attachment',$where);
			$this->_data = $data->first();
			$this->_count = $data->count();
			return true;
		}

		return false;
	}

	public function lastInserted($where=array())
	{
		$string= "ORDER BY id DESC LIMIT 1";
		if (!$this->_db->get('attachment',$where,$string))
		{
			throw new Exception('there was an error');
		}
		else{
			$data = $this->_db->get('attachment',$where,$string);
			$this->_data = $data->results();
			$this->_count = $data->count();
			return true;
		}
		return false;
	}

	public function remove($where= array())
	{
		return $this->_db->delete('attachment',$where);
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