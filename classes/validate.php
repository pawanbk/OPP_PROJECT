<?php 
class Validate {

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
					$this->addError("All * fields fields are required to be filled.");
				}
				else if(!empty($value)){
					switch($rule){
						case 'min':
						if(strlen($value) < $rule_value)
						{
							$this->addError("{$item} must be minimum of {$rule_value} character");
						}
						break;
						case 'max':
						if(strlen($value) > $rule_value)
						{
							$this->addError("{$item} must be maximum of {$rule_value} character");
						}
						break;
						case 'matches':
						if($value != $source[$rule_value])
						{
							$this->addError("{$item} must match {$rule_value}");
						}
						break;
						case 'contain':
						if($rule == 'contain')
						{
							if(!preg_match('#[0-9]+#',$value))
							{
								$this->addError("{$item} must include at least one number!.");
							}
							if(!preg_match("#[A-Z]+#",$value))
							{
								$this->addError("{$item} must include at least one CAPS!.");
							}
							if( !preg_match("#\W+#", $value ) ) 
							{
								$this->addError("Password must include at least one symbol!");
							}
						}
						break;
						case 'unique':
						$check = $this->_db->get($rule_value, array($item, '=', $value));
						if($check->count())
						{
							$this->addError("{$item} already taken. Choose unique {$item}.");
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