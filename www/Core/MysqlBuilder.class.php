<?php 

    namespace App\Core;

    interface QueryBuilder {

        public function insert (string $table, array $values): QueryBuilder;

        public function select (string $table, array $columns): QueryBuilder;

        public function where (string $column, string $value, string $operator='=', string $table=''): QueryBuilder;

        public function limit (int $from, int $offset): QueryBuilder;

        public function getQuery ();

    }

    class MySqlBuilder implements QueryBuilder {

        private $query;

        public function init() {
            $this->query = new \StdClass;
        }

        public function insert (string $table, array $values) : QueryBuilder {
            return $this;
        }

        public function select (string $table, array $columns): QueryBuilder {
            $this->init();

            $tmp_str = "SELECT ";

            foreach ($columns as $col) {
                $tmp_str .= " " . $table . "." . $col . ", ";
            }

            $tmp_str = trim($tmp_str, ", ")." FROM ".$table;

            $this->query->base = $tmp_str;
            return $this;
        }

        public function where (string $column, string $value, string $operator = '=', string $table=''): QueryBuilder {
            $tmp_str = "";

            if ($table!="") {
                $tmp_str = ' ' . $table . ".";
            }

            $tmp_str .= $column . $operator . "'" . $value . "'";

            $this->query->where[] = $tmp_str;
            return $this;
        }

        public function limit (int $from, int $offset): QueryBuilder {
            $this->query->limit = ' LIMIT ' . $from . ', ' . $offset; 
            return $this;
        }

        public function getQuery () {

            $sql = $this->query->base;

            if(!empty($this->query->where)) {
                $sql .= " WHERE " . implode(" AND ",$this->query->where);
            }

            if(isset($this->query->limit)) {
                $sql .= " " . $this->query->limit;
            }

            $sql .= ';';

            return $sql;
            
        }

    }