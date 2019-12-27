<?php
class DB{
    private static  $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count=0;
    private function __construct(){
        try{
            $this->_pdo = new PDO('mysql:dbname='.Config::get('mysql/db').';host='.Config::get('mysql/host'),
            Config::get('mysql/username'),Config::get('mysql/password'));
            $this->_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            //echo 'Connected';
        }catch(PDOException $e){
            die($e->getMessage());
        }

    }
    public static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance=new DB();

        }
        return self::$_instance;
    }
    public function query($sql,$params = array()){
       
        
        $this->_error=false;
        //$testSql = "SELECT * from xbs.account;";
        if($this->_query = $this->_pdo->prepare($sql)){
            $x=1;
            //echo '<br>'. $sql;
            
            if(count($params))
                foreach($params as $param){
                    $this->_query->bindValue($x,$param);
                    $x++;
                    //echo 'bind!';
                }
            
                //echo '<br>'. $this->_query;
               
                
            if($this->_query->execute()){
                echo 'enter execute! <br>';
                try{
                    $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);//FETCH_OBJ may be broken on update n insert
                    
                }catch(PDOException $E){
                    //echo $E->getMessage();
                }
                $this->_count=$this->_query->rowCount();
                //echo print_r($this->results);//.'results'
    
            }else{
                $this->_error = true;
                echo 'fail exec.<br>';
            }
           
        }
        
        return  $this;
    }
    public function action($action,$table,$where=array()){
        if(count($where)===3){
            $operators = array('=','>','<','>=','<=');

            $field      = $where[0];
            $operator   = $where[1];
            $value      = $where[2];
            //echo $field.'<br>';
            if(in_array($operator,$operators)){
                $sql ="{$action} FROM {$table} WHERE {$field} {$operator} ?"; 
                //$sql='SELECT * FROM xbs.account WHERE ID = ?';
                //echo $sql;
                if(!$this->query($sql,array($value))->error()){
                    return $this;
                }
                //echo 'error ='.$this->error();
            }
        }
        return false;//$this
    }
    public function get($table,$where){
        return $this->action('SELECT *',$table,$where);

    }
    public function delete($table,$where){
        return $this->action('DELETE',$table,$where);
    }
    public function results(){
        //echo $this->results->__toString();
        return $this->_results;
    }
    public function error(){
        return $this->_error;
    }
    public function count(){
        return $this->_count;
    }
    public function first(){
        return $this->results()[0];
    }
    public function insert($table,$fields = array()){
        if(count($fields)){
            $keys = array_keys($fields);
            $values = '';//null
            $x= 1;
            foreach($fields as $field){
                $values .= '?';
                if($x< count($fields)){
                    $values .= ', ';
                }
                $x++;
            }
            //die($values);
            $sql = "INSERT INTO {$table} (`" . implode('`, `',$keys) . "`) VALUES {$values}";
            //$sql="INSE(`" . impolde('', $keys) . "`)"
            echo $sql;
            if(!$this->query($sql,$fields)->error()){
                return true;
            }
        }
        return false;
    }
    public function update($table,$id ,$fields){
        $set ='';
        $x =1;
        foreach($fields as $name => $value){
            $set .= "{$name} = ?";
            if($x< count($fields)){
                $set .= ', ';
            }
            $x++;
        }
        //die($set);
        $sql="UPDATE {$table} SET {$set} WHERE id = {$id}";
        echo $sql."<br>";
        if(!$this->query($sql,$fields)->error()){
            return true;
        }
        return false;
    }
}
        