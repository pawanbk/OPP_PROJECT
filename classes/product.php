<?php
class Product{
	private $_db,
	        $_productData = array();
    
   public function __construct($product=null){
		$this->_db = Db::getInstance();
	     }

    public function addProduct($value=array())
    {
    	$this->_db->insert('products',$value);
    	return true;

    }
    public function getAllProducts(){
    	$product_data = $this->_db->getAll('products');
    	if($product_data->count()){
    		$this->_productData = $product_data->first();
    		return true;
    	}
    	return false;
    }
    public function productData(){
    	return $this->_productData;
    }
}
?>