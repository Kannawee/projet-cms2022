<?php

namespace App\Core;

include('./MyInterface/QueryBuilder.php');

use App\MyInterface\QueryBuilder;

class MySqlBuilder implements QueryBuilder {

    private $query;

    /**
	 * @return void
	**/
    public function init():void
    {
        $this->query = new \StdClass;
    }

    /**
	 * @param string $table
     * @param array $values
	 * @return QueryBuilder
	**/
    public function insert (string $table, array $values) : QueryBuilder 
    {
        $this->query->base = "INSERT INTO ".$table." (".implode(",",array_keys($values)).") VALUES ( :".implode(",:",array_keys($values)).")";
        return $this;
    }

    /**
	 * @param string $login
     * @param array $columns
	 * @return QueryBuilder
	**/
    public function select (string $table, array $columns): QueryBuilder 
    {
        $tmp_str = "SELECT ";

        foreach ($columns as $col) {
            $tmp_str .= " " . $col . ", ";
        }

        $tmp_str = trim($tmp_str, ", ")." FROM ".$table;

        $this->query->base = $tmp_str;
        return $this;
    }

    /**
	 * @param string $login
     * @param string $table
     * @param string $operator
	 * @return QueryBuilder
	**/
    public function where (string $column, string $table, string $operator = '='): QueryBuilder
    {
        $tmp_str = $table . ".";

        if ($operator=="NOT IN") {
            $tmp_str .= $column . " " . $operator . "(?)";
        } else {
            $tmp_str .= $column . $operator . ":" . $column;
        }

        $this->query->where[] = $tmp_str;
        return $this;
    }

    /**
	 * @param string $table
	 * @return QueryBuilder
	**/
    public function delete(string $table): QueryBuilder
    {
        $this->query->base = "DELETE FROM $table";
        return $this;
    }

    /**
	 * @param int $from
     * @param int $offset
	 * @return QueryBuilder
	**/
    public function limit (int $from, int $offset=0): QueryBuilder {
        $this->query->limit = 'LIMIT ' . $from;
        if ($offset!=0) {
            $this->query->limit .= ', ' . $offset;
        }
        return $this;
    }

    /**
	 * @param string $table1
     * @param string $table2
     * @param string $on1
     * @param string $on2
     * @param string $type
	 * @return QueryBuilder
	**/
    public function join(string $table1, string $table2, string $on1, string $on2, string $type=""): QueryBuilder
    {
        $this->query->join[] = " $type JOIN ".$table1." ON($table1.$on1=$table2.$on2)";
        return $this;
    }

    /**
	 * @param string $table
     * @param array $data
	 * @return QueryBuilder
	**/
    public function update(string $table, array $data): QueryBuilder
    {
        $this->query->base = "UPDATE $table SET ";

        foreach ($data as $col => $val) {
            $this->query->base .= $col."=:".$col.", ";
        }

        $this->query->base = trim($this->query->base, ", ");

        return $this;
    }

    /**
	 * @param string $order
	 * @return QueryBuilder
	**/
    public function order(string $order): QueryBuilder
    {
        $this->query->order[] = $order;
        return $this;
    }

    /**
	 * @return string
	**/
    public function getQuery (): string
    {

        $sql = $this->query->base;

        if (!empty($this->query->join)) {
            $sql .= implode(" ", $this->query->join);
        }

        if(!empty($this->query->where)) {
            $sql .= " WHERE " . implode(" AND ",$this->query->where);
        }

        if(isset($this->query->limit)) {
            $sql .= " " . $this->query->limit;
        }

        $tmp_order = "";
        if(isset($this->query->order) && count($this->query->order)>0) {
            $tmp_order = " ORDER BY";
            foreach ($this->query->order as $ord) {
                $tmp_order .= " ".$ord.",";
            }
            $tmp_order = trim($tmp_order,",");
        }
        $sql.= $tmp_order;

        $sql .= ';';

        return $sql;

    }



}
