<?php

    namespace App\Controller;

    use App\Core\MysqlBuilder as MysqlBuilder;

    class TestSam extends MysqlBuilder
    {

        public function test()
        {

            $col = ["col1", "col2", "col3"];
            $this->init();
            $this->select('MaTable', $col);
            $this->where("col1", "val1", "=", "MaTable");
            $this->where("col2", "val2", "=", "MaTable");
            $this->limit(0, 1);

            echo '<pre>'.$this->getQuery();
        }



    }