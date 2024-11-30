<?php

namespace Src\Models;

use Src\Config\DatabaseConn;

class BaseModel {
    protected $db;

    public function __construct() {
        $database = new DatabaseConn();
        $this->db = $database->getConnection();
    }

    public function __destruct() {
        if ($this->db) {
            $this->db->close();
        }
    }
}
