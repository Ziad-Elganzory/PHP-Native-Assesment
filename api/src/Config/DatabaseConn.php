<?php

namespace Src\Config;

class DatabaseConn {
    private $mysqli;
    private $host;
    private $user;
    private $password;
    private $database;

    public function __construct() {
        $this->host = getenv('DB_HOST');
        $this->user = getenv('DB_USER');
        $this->password = getenv('DB_PASSWORD');
        $this->database = getenv('DB_NAME');

        $this->mysqli = new \mysqli($this->host, $this->user, $this->password, $this->database);

        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }
    }

    public function getConnection() {
        return $this->mysqli;
    }
    public function closeConnection() {
        $this->mysqli->close();
    }
    public function escapeString($string) {
        return $this->mysqli->real_escape_string($string);
    }
}
?>
