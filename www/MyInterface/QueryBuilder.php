<?php

namespace App\MyInterface;

interface QueryBuilder {

    public function insert (string $table, array $values): QueryBuilder;

    public function select (string $table, array $columns): QueryBuilder;

    public function where (string $column, string $table, string $operator='='): QueryBuilder;

    public function limit (int $from, int $offset): QueryBuilder;

    public function getQuery ();

}