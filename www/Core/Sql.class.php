<?php

namespace App\Core;

use App\Core\MysqlBuilder as MysqlBuilder;

abstract class Sql
{
    protected static $pdo = null;
    protected $table;
    protected $builder;

    public function __construct()
    {
        //Se connecter à la bdd
        //il faudra mettre en place le singleton
        if (is_null(self::$pdo)) {
            try{
                self::$pdo = new \PDO( DBDRIVER.":host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME
                    ,DBUSER, DBPWD , [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);
            }catch (\Exception $e){
                die("Erreur SQL : ".$e->getMessage());
            }
        }

        //Si l'id n'est pas null alors on fait un update sinon on fait un insert
        $calledClassExploded = explode("\\",get_called_class());
        $this->table = strtolower(DBPREFIXE.end($calledClassExploded));
        $this->builder = new MysqlBuilder();
        $this->builder->init();

    }

    /**
     * @param int $id
     */
    public function checkId(?int $id): object
    {
        $sql = "SELECT * FROM ".$this->table." WHERE id=".$id;
        $query = self::$pdo->query($sql);
        return $query->fetchObject(get_called_class());
    }

    public function save()
    {

        $columns = get_object_vars($this);

        $columns = array_diff_key($columns, get_class_vars(get_class()));

        $is_insert = false;

        if($this->getId() == null){
            $unset = ["id", "created_at"];
            foreach ($columns as $key => $val) {
                if (in_array($key, $unset)) {
                    unset($columns[$key]);
                }
            } 
            $sql = "INSERT INTO ".$this->table." (".implode(",",array_keys($columns)).") 
            VALUES ( :".implode(",:",array_keys($columns)).")";

            $is_insert = true;
        }else{
            $update = [];
            foreach ($columns as $column=>$value)
            {
                if (!is_null($value)) {
                    $update[] = $column."=:".$column;
                } else {
                    unset($columns[$column]);
                }
            }
            $sql = "UPDATE ".$this->table." SET ".implode(",",$update)." WHERE id=".$this->getId() ;
        }
        
        $queryPrepared = self::$pdo->prepare($sql);
        $res = $queryPrepared->execute( $columns );

        if (!$is_insert) {
            return $res;
        }

        return self::$pdo->lastInsertId();
        
    }

    public function select($where=array(), $limit=null, $orders=null)
    {
        $this->builder->select($this->table, ["*"]);

        if (count($where)>0) {
            foreach ($where as $col => $val) {
                $this->builder->where($col, $this->table);
            }
        }

        if (!is_null($limit)) {
            $this->builder->limit($limit);
        }

        if (!is_null($orders)) {

            foreach ($orders as $order) {
                $this->builder->order($order);
            }
        }

        $sql = $this->builder->getQuery();

        $stmt = self::$pdo->prepare($sql);
        if(count($where)>0){
            $stmt->execute($where);
        } else {
            $stmt->execute();
        }
        
        return $stmt->fetchAll(self::$pdo::FETCH_CLASS, get_called_class());
    }

    public function getById($id, $col=['*'])
    {
        $this->builder->select($this->table, $col);
        $this->builder->where("id", $this->table);
        $sql = $this->builder->getQuery();
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute(["id"=>$id]);

        $stmt->setFetchMode(self::$pdo::FETCH_CLASS, get_called_class());

        $res = $stmt->fetch();
        return $res;

    }

    public function getUnique($col, $where)
    {
        $this->reset();
        $this->builder->select($this->table, $col);

        foreach ($where as $col => $val) {
            $this->builder->where($col, $this->table);
        }

        $sql = $this->builder->getQuery();
        
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($where);

        $stmt->setFetchMode(self::$pdo::FETCH_CLASS, get_called_class());

        $res = $stmt->fetch();
        return $res;
    }

    public function delete($where=array())
    {
        $this->builder->delete($this->table);

        if (count($where)==0) {
            $where = array(
                "id"=>$this->getId()
            );
        }

        foreach ($where as $col=>$val) {
            $this->builder->where($col, $this->table);
        }

        $sql = $this->builder->getQuery();

        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute($where);

    }

    public function execute($data=array(),$fetch=false, $obj=false)
    {

        if (is_array($data) && count($data)>0) {
            $stmt = self::$pdo->prepare($this->builder->getQuery());

            if (!$fetch) {
                return $stmt->execute($data);
            }
            $stmt->execute($data);
            
            if ($obj) {
                return $stmt->fetchAll(self::$pdo::FETCH_CLASS, get_called_class());
            }

            return $stmt->fetchAll(self::$pdo::FETCH_ASSOC);
        }

        $stmt = self::$pdo->query($this->builder->getQuery());

        if (!$fetch) {
            return $stmt->execute();
        }
        $stmt->execute();
        if($obj) {
            return $stmt->fetchAll(self::$pdo::FETCH_CLASS, get_called_class());
        }
        return $stmt->fetchAll(self::$pdo::FETCH_ASSOC);
    }

    public function getBuilder()
    {
        return $this->builder;
    }

    public function reset()
    {
        $this->builder->init();
    }

}
