<?php 
class validate {
	
	private $_passed = false,
	        $_error  = array(),
	        $_db     = null;
	        public function __construct()
	        {
	        	$this->_db = Db::getInstance();
	        }

	 public function check($source, $items=array())
	 {
	 	foreach($items as $item => $rules){
	 		foreach ($rules as $rule => $rule_value){
	 			
	 			$value = trim($source[$item]);
	 			
	 			if($rule == 'required' && empty($value)){
                     $this->addError("{$item} is required.");
	 			}
	 			else if(!empty($value)){
	 				switch($rule){
	 					case 'min':
	 					   if(strlen($value) < $rule_value){
	 					   	$this->addError("{$item} must be minimum of {$rule_value} character");
	 					   }
	 					break;
	 					case 'max':
	 					if(strlen($value) > $rule_value){
	 					   	$this->addError("{$item} must be maximum of {$rule_value} character");
	 					   }
	 					break;
	 					case 'matches':
	 					   if($value != $source[$rule_value]){
	 					   	$this->addError("{$item} must match {$rule_value}");
	 					   }
	 					break;
	 					case 'unique':
	 					  $check = $this->_db->get($rule_value, array($item, '=', $value));
	 					  	if($check->count()){
	 					  		$this->addError("username already taken. Choose unique username.");
	 					  	}
	 					break;
	 					
	 				}
	 			}
	 		}
	 	}
	 		if(empty($this->_errors))
	 		{
	 			$this->_passed = true;
	 		}
	 	
	 	return $this;
	 }

	 private function addError($errors){
	 	$this->_errors[] = $errors;
	 }
	 public function getError(){
	 	return $this->_errors;
	 }
	 public function passed(){
	 	return $this->_passed;
	 }
}
?>