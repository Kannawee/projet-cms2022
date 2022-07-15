<?php

namespace App\Core;

interface QueryBuilder {

    public function insert (string $table, array $values): QueryBuilder;

    public function select (string $table, array $columns): QueryBuilder;

    public function where (string $column, string $table, string $operator='='): QueryBuilder;

    public function limit (int $from, int $offset): QueryBuilder;

    public function getQuery ();

}

class MySqlBuilder implements QueryBuilder {

    private $query;

    public function init() {
        $this->query = new \StdClass;
    }

    public function insert (string $table, array $values) : QueryBuilder {
        $this->query->base = "INSERT INTO ".$table." (".implode(",",array_keys($values)).") VALUES ( :".implode(",:",array_keys($values)).")";
        return $this;
    }

    public function select (string $table, array $columns): QueryBuilder {
        $tmp_str = "SELECT ";

        foreach ($columns as $col) {
            $tmp_str .= " " . $col . ", ";
        }

        $tmp_str = trim($tmp_str, ", ")." FROM ".$table;

        $this->query->base = $tmp_str;
        return $this;
    }

    public function where (string $column, string $table, string $operator = '=', $ind=null): QueryBuilder
    {
        $tmp_str = $table . ".";

        if ($operator=="NOT IN") {
            $tmp_str .= $column . " " . $operator . "(?)";
        } else {
            $tmp = (!is_null($ind))?$ind:"";
            $tmp_str .= $column . $operator . ":" . $column . $tmp;
        }

        $this->query->where[] = $tmp_str;
        return $this;
    }

    public function delete($table): QueryBuilder
    {
        $this->query->base = "DELETE FROM $table";
        return $this;
    }

    public function limit (int $from, int $offset=0): QueryBuilder {
        $this->query->limit = 'LIMIT ' . $from;
        if ($offset!=0) {
            $this->query->limit .= ', ' . $offset;
        }
        return $this;
    }

    public function join($table1, $table2, $on1, $on2, $type="")
    {
        $this->query->join[] = " $type JOIN ".$table1." ON($table1.$on1=$table2.$on2)";
        return $this;
    }

    public function update($table, $data)
    {
        $this->query->base = "UPDATE $table SET ";

        foreach ($data as $col => $val) {
            $this->query->base .= $col."=:".$col.", ";
        }

        $this->query->base = trim($this->query->base, ", ");
    }

    public function order($order)
    {
        $this->query->order[] = $order;
    }

    public function getQuery () {

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
