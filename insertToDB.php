<?php

require_once __DIR__ . '/api/vendor/autoload.php';
require_once __DIR__ . '/api/src/Helpers/LoadEnv.php';

load_env(__DIR__ . '/api/.env');

use Src\Config\DatabaseConn;
$conn = new DatabaseConn();

$mysqli = $conn->getConnection();
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} else {
    echo "Connected successfully\n";
}

$options = getopt('', ['json:', 'table:']);

if (!isset($options['json']) || !isset($options['table'])) {
    die("Please provide both --json and --table options.\n");
}

$jsonFile = $options['json'];
$tableName = $options['table'];

if (!file_exists($jsonFile)) {
    die("File not found: $jsonFile\n");
}

$jsonData = file_get_contents($jsonFile);
$dataArray = json_decode($jsonData, true);

if ($dataArray === null) {
    die("Error decoding JSON data: " . json_last_error_msg() . "\n");
}

if (isset($dataArray[0][$tableName]) && is_array($dataArray[0][$tableName])) {
    foreach ($dataArray[0][$tableName] as $category) {

        $fields = [];
        $values = [];

        foreach ($category as $key => $value) {
            $fields[] = $key;
            $values[] = is_null($value) ? "NULL" : "'" . $mysqli->real_escape_string($value) . "'";
        }

        $sql = "INSERT INTO $tableName (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $values) . ")";

        if ($mysqli->query($sql) === TRUE) {
            echo "Category inserted successfully.\n";
        } else {
            echo "Error inserting category: " . $mysqli->error . "\n";
        }

    }
} else {
    echo "No valid categories data found or table name is incorrect. Expected 'categories' data.\n";
}
$mysqli->close();

?>