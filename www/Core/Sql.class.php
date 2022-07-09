<?php

    namespace App\Core;

<<<<<<< HEAD
    use App\Core\MysqlBuilder as MysqlBuilder;
=======
use App\Core\MysqlBuilder as MysqlBuilder;

abstract class Sql
{
    private $pdo;
    private $table;
    private $builder;
>>>>>>> 19752dae2c190f36969ac2558fbc7ba5b7380d00

    abstract class Sql
    {
        private $pdo;
        private $table;
        private $builder;

        public function __construct()
        {
            //Se connecter à la bdd
            //il faudra mettre en place le singleton
            try{
                $this->pdo = new \PDO( DBDRIVER.":host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME
                    ,DBUSER, DBPWD , [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);
            }catch (\Exception $e){
                die("Erreur SQL : ".$e->getMessage());
            }

            //Si l'id n'est pas null alors on fait un update sinon on fait un insert
            $calledClassExploded = explode("\\",get_called_class());
            $this->table = strtolower(DBPREFIXE.end($calledClassExploded));
            $this->builder = new MysqlBuilder();
            $this->builder->init();

        }

<<<<<<< HEAD
        /**
         * @param int $id
         */
        public function checkId(?int $id): object
        {
            $sql = "SELECT * FROM ".$this->table." WHERE id=".$id;
            $query = $this->pdo->query($sql);
            return $query->fetchObject(get_called_class());
        }
=======
        //Si l'id n'est pas null alors on fait un update sinon on fait un insert
        $calledClassExploded = explode("\\",get_called_class());
        $this->table = strtolower(DBPREFIXE.end($calledClassExploded));
        $this->builder = new MysqlBuilder();
        $this->builder->init();
>>>>>>> 19752dae2c190f36969ac2558fbc7ba5b7380d00

        public function save()
        {

<<<<<<< HEAD
            $columns = get_object_vars($this);
            $columns = array_diff_key($columns, get_class_vars(get_class()));
=======
    /**
     * @param int $id
     */
    public function checkId(?int $id): object
    {
        $sql = "SELECT * FROM ".$this->table." WHERE id=".$id;
        $query = $this->pdo->query($sql);
        return $query->fetchObject(get_called_class());
    }
>>>>>>> 19752dae2c190f36969ac2558fbc7ba5b7380d00

            if($this->getId() == null){
                $sql = "INSERT INTO ".$this->table." (".implode(",",array_keys($columns)).") 
                VALUES ( :".implode(",:",array_keys($columns)).")";
            }else{
                $update = [];
                foreach ($columns as $column=>$value)
                {
                    $update[] = $column."=:".$column;
                }
                $sql = "UPDATE ".$this->table." SET ".implode(",",$update)." WHERE id=".$this->getId() ;
            }
            //echo $sql;
            //die();
            $queryPrepared = $this->pdo->prepare($sql);
            var_dump($queryPrepared);
            $queryPrepared->execute( $columns );

        }

        public function select($where, $limit=null)
        {
            $this->builder->select($this->table, ["*"]);

            foreach ($where as $col => $val) {
                $this->builder->where($col, $this->table);
            }

            if (!is_null($limit)) {
                $this->builder->limit($limit);
            }
    
            $sql = $this->builder->getQuery();
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($where);
            return $stmt->fetchAll($this->pdo::FETCH_ASSOC);
        }

        public function delete($where)
        {
            $this->builder->delete($this->table);

            foreach ($where as $col=>$val) {
                $this->builder->where($col, $this->table);
            }

<<<<<<< HEAD
            $sql = $this->builder->getQuery();
=======
    public function select($where, $limit=null)
    {
        $this->builder->select($this->table, ["*"]);

        foreach ($where as $col => $val) {
            $this->builder->where($col, $this->table);
        }

        if (!is_null($limit)) {
            $this->builder->limit($limit);
        }

        $sql = $this->builder->getQuery();

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($where);
        return $stmt->fetchAll($this->pdo::FETCH_ASSOC);
    }

    public function delete($where)
    {
        $this->builder->delete($this->table);

        foreach ($where as $col=>$val) {
            $this->builder->where($col, $this->table);
        }

        $sql = $this->builder->getQuery();

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($where);

    }
>>>>>>> 19752dae2c190f36969ac2558fbc7ba5b7380d00

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($where);

        }


    }
