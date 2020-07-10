<?php

class Model
{
    public function __construct() {
        $this->db = Database_Mysql::create(DB_HOST, DB_USER, DB_PASS)->setCharset('utf8')->setDatabaseName(DB_NAME);
    }

    public function get_data() {}
}