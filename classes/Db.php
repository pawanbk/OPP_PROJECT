<?php
class Db {

    public static $_instance = null;

    private $_conn, 
            $_query,
            $_results,
            $_count=0,
            $_error=false;

    private function  __construct(){ 
        global $config;
        try{

            $this->_conn = new PDO('mysql:host='.$config['db']['host'].';dbname='.$config['db']['dbname'], $config['db']['user'],$config['db']['pass']);

        }
        catch(PDOException $e) {
            die($e->getMessage());

        }
    }

    public static function getInstance(){
        if (!isset(self::$_instance)) {
            self::$_instance= new Db();
        }
        return self::$_instance;
    }

    public function query($sql,$params=array()){
            $this->_error = false;
            if ($this->_query = $this->_conn->prepare($sql))
            {
                $x=1;

                if (count($params))
                {
                    foreach($params as $param){
                        $this->_query->bindValue($x,$param);
                        $x++;
                    }
                }
                if ($this->_query->execute())
                {
                    $this->_results=$this->_query->fetchAll(PDO::FETCH_OBJ);
                    $this->_count = $this->_query->rowCount();

                } 

                else {

                    $this->_error = true;
                }
            }

            return $this;
    }

    public function action($action,$table,$where=array(), $string = ''){
        if (count($where) === 3)
        {
            $field    = $where[0];
            $operator = $where[1];
            $value    = $where[2];
            $operators = array('<', '>', '=', '<=', '>=','like');

            if (in_array($operator, $operators))
            {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                 if($string !='')
                {
                    $sql .= ' '.$string;
                }
                if (!$this->query($sql,array($value))->error())
                {
                    return $this;
                }

            }
            
        }
        else if(count($where)===7)
        {
            $field1    = $where[0];
            $operator1 = $where[1];
            $value1    = $where[2];
            $cat       = $where[3];
            $field2    = $where[4];
            $operator2 = $where[5];
            $value2    = $where[6];
            $operators = array('<', '>', '=', '<=', '>=','like');

            if (in_array($operator1, $operators))
            {
                $sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? {$cat} {$field2} {$operator2} ?  ";
                 if($string !='')
                {
                    $sql .= ' '.$string;
                }
                if (!$this->query($sql,array($value1,$value2))->error())
                {
                    return $this;
                }

            }
        }

        else {
            $sql = "{$action} FROM {$table}";
            if($string !='')
            {
                $sql .= ' '.$string;
            }
            if (!$this->query($sql,$where)->error())
            {
                return $this;
            }

        }
        return false;

    }

    public function get($table, $where=array(),$string=''){
        return $this->action('SELECT *',$table, $where, $string);
    }

    public function delete($table, $where)
    {
        return $this->action('Delete', $table, $where);
    }

    public function update ($table,$id,$fields=array(),$attr){
        $set = '';
        $x = 1;
        foreach ($fields as $name => $value){
            $set .= "{$name} = ? ";
            if ($x < count($fields))
            {
                $set .=', ';
            }
            $x++;
        }
        $sql = "UPDATE {$table} SET {$set} WHERE {$attr} = {$id}";
        if (!$this->query($sql, $fields)->error())
        {
            return true;
        }

        return false;

    }

    public function insert($table, $fields=array())
    {
        if (count($fields))
        {
            $keys = array_keys($fields);
            $values = '';
            $x=1;
            foreach ($fields as $field){
                $values .= '?';

                if ($x < count($fields)){
                    $values .= ',';

                }
                $x++;
            }

            $sql= "INSERT INTO {$table} (`" . implode('`,`',$keys). "`) VALUES ({$values})";

            if (!$this->query($sql,$fields)->error()){
                return true;
            }
        }
        return false;
    }

    public function error(){
        return $this->_error ;
    }
    public function count(){
        return $this->_count;
    }
    public function results(){
        return $this->_results;
    }
    public function first(){
        return $this->results()[0];
    }


}
?>
