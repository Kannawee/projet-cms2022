<?php 

    namespace App\Controller;

    use App\Core\QueryBuilder;

    class MySqlBuilder implements QueryBuilder {

        private $query;

        public function init() {
            $this->query = new \StdClass;
        }

        public function insert (string $table, array $values) : QueryBuilder {
            return true;
        }

        public function select (string $table, array $columns): QueryBuilder {
            $this->init();

            $this->query->base = "SELECT " . implode(',', $columns) . " FROM ".$table;
            return $this;
        }

        public function where (string $column, string $value, string $operator = '='): QueryBuilder {

            $this->query->where[] = ' ' . $column . $operator . "'" . $value . "'" ;
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