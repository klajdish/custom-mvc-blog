<?php

namespace Core;
use PDOException;
use PDO;


class Model{

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname =DB_NAME;


    public $dbh;
    public $stmt;
    public $error;
    protected $tableName;
    protected $primaryKey;
    protected $name;


    public function __construct(){

    }

    public function getDbh()
    {
        if(is_null($this->dbh)) {
            $dsn = 'mysql:host='. $this->host.';dbname='. $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            //Create PDO instance
            $this->dbh=new PDO($dsn, $this->user,$this->pass,$options);
        }
        return $this->dbh;
    }
    
    public function getAll()
    {
        $sql = 'Select * From ' .$this->tableName.' ORDER BY created_at desc';
        $this->query($sql);

        if($this->execute()){
            return $result = $this->resultSet();
        }

        return false;
    }

    public function getSingle($id){
        $sql = 'Select * From ' .$this->tableName. ' WHERE ' . $this->primaryKey.'=:'.$this->primaryKey;
        $this->query($sql);
        $this->bind(':'.$this->primaryKey, $id);

        if($this->execute()){
            return $this->single();
        }

        return false;
    }

    public function getWithCondition($params=null,$limit=null,$offset = null,$like = null){

        $values ='';

        if(!is_null($params)){
            foreach($params as $key =>$param){
                $values =  $values .' '.$key. '=:'.$key.' AND ';
            }
    
            $values = rtrim($values, " AND ");
        }

        $sql = "SELECT * FROM ". $this->tableName." ";

        if(!is_null($params) && !is_null($like)){
            $sql = $sql. ' WHERE ' . $values.  ' AND '. $this->name . ' LIKE :' . $like;
        }

        if(!is_null($params) && is_null($like)){
            $sql = $sql. ' WHERE ' . $values; 
        }

        if(is_null($params) && !is_null($like)){
            $sql = $sql. ' WHERE '. $this->name . ' LIKE :' . $like;
        }

        $sql = $sql. ' ORDER BY created_at DESC';

        if(!is_null($limit) && !is_null($offset)){
            $sql = $sql. ' LIMIT ' . $limit . ' OFFSET '. $offset; 
        }elseif(!is_null($limit)){
            $sql = $sql. ' LIMIT ' . $limit;
        }

        $this->query($sql);

        if(!is_null($like)){
            $this->bind($like, "%$like%");
        }

        if(!is_null($params)){

            foreach($params as $key =>$param){
                $this->bind(':'.$key, $param);
            }
        }

        return $this->resultSet();
    }


    public function getAllLike($params){

        $firstKey = array_key_first($params);
        $sql = "SELECT * FROM ". $this->tableName. " WHERE ".$this->name." LIKE :".$firstKey;

        $this->query($sql);
        $search_value = $params['q'];
        $this->bind($firstKey, "%$search_value%");

        return $this->resultSet();
    }

    public function deleteRow($params){

        $values ='';

        foreach($params as $key =>$param){
            $values =  $values .' '.$key. '=:'.$key.' AND ';
        }

        $values = rtrim($values, " AND ");
        $sql = 'DELETE FROM ' . $this->tableName.' WHERE ' . $values;
        $this->query($sql);

        foreach($params as $key =>$param){
            $this->bind(':'.$key, $param);
        }

        if($this->execute()){
            return true;
        }

        return false;
    }

    public function createRow($params){
        
        $part1='';
        $part2='';

        foreach($params as $key =>$param){
            $part1=$part1. ' '. $key. ', ';
            $part2= $part2. ' :'.$key.', ';
        }

        $part1 = rtrim($part1, ", ");
        $part2 = rtrim($part2, ", ");

        
        $sql = "INSERT INTO ". $this->tableName. "(".$part1.") VALUES (".$part2.")";
        $this->query($sql);

        foreach($params as $key =>$param){

            if($key =='password'){
                $param = password_hash($param, PASSWORD_DEFAULT);
                $this->bind(':'.$key, $param);
            }
        $this->bind(':'.$key, $param);
        }


        if($this->execute()){
            return true;
        }

        return false;
    }


    public function updateRow($id,$params){

        
        $values ='';
        foreach($params as $key =>$param){
            $values =  $values .' '.$key. '=:'.$key.', ';
        }

        $values = rtrim($values, ", ");
        $sql = "UPDATE ". $this->tableName." SET ".$values." WHERE " . $this->primaryKey."=:id";

        $this->query($sql);

        foreach($params as $key =>$param){
            if($key =='password'){
                $param = password_hash($param, PASSWORD_DEFAULT);
                $this->bind(':'.$key, $param);
            }

            $this->bind(':'.$key, $param);
        }
        $this->bind(':id', $id);

        if($this->execute()){
            return true;
        }
        return false;
    }


    public function query($sql){
        $dbh = $this->getDbh();
        $this->stmt = $dbh->prepare($sql);
    } 

    public function bind($param,$value,$type=null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param,$value,$type);
    }

    public function execute(){
        return $this->stmt->execute();
    }

    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount(){
        return $this->stmt->rowCount();
    }


}