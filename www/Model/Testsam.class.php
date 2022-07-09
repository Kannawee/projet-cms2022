<?php
    namespace App\Model;

    use App\Core\Sql;

    class Testsam extends Sql
    {

        public static $table = "NomTableTest";

        public function __construct()
        {
            parent::__construct();
        }

    }