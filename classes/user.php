<?php 
class user {
	private $_db,
	        $_data ,
	        $_sessionName='users',
	        $_isLoggedIn = false;
	     
	public function __construct($user=null){
		$this->_db = Db::getInstance();

		if(!$user)
		{
			if(Session::exists($this->_sessionName)){
				$user = Session::get($this->_sessionName);
				if($this->find($user)){
					$this->_isLoggedIn=true;
				}
				else{
					//process logout
				}
			}
	     }
	     else{
	     	$this->find($user);
	     }
		}

	public function find($user=null){
		if($user){
			$field = (is_numeric($user)) ? 'user_id' : 'username';
			$data = $this->_db->get('users',array($field,'=',$user));
			if($data->count()){
				$this->_data = $data->first();
				return true;
               }
			
		
		}
		return false;
		
	}     

	public function create($fields=array()){  
                 
                $this->_db->insert('users',$fields);
               	return true;

              }
                 
   

	public function login($email=null, $pass=null){
	
           $user = $this->find($email);
           if($user){
           	if($this->data()->user_pass === Hash::make($pass))
           	{
           		Session::put($this->_sessionName, $this->data()->user_id);
           		return true;
           	}
           	
           }
           return false;
	
	}

	public function update($fields = array(), $id=null)
	
	{
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->user_id;
		}
		if(!$this->_db->update('users',$id,$fields)){
			throw new Exeption('There was an error updating');
		}
	}

	public function logout(){
     return Session::delete($this->_sessionName);
	}

	public function data(){
		return $this->_data;
	}

	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}


	
}