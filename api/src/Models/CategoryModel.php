<?php

namespace Src\Models;

class CategoryModel extends BaseModel {
    private $table = 'categories';

    public function getAllCategories() {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->db->query($sql);

        if ($result === false) {
            die("Database error: " . $this->db->error);
        }

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }

        return $categories;
    }

    public function getCategoryById($id) {
        $id = $this->db->real_escape_string($id);
        $sql = "SELECT * FROM {$this->table} WHERE id = '$id' LIMIT 1";
        $result = $this->db->query($sql);

        if ($result === false) {
            die("Database error: " . $this->db->error);
        }

        return $result->fetch_assoc();
    }
}
