<?php
namespace Src\Models;

class CourseModel extends BaseModel {
    private $table = 'courses';

    public function getAllCourses() {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->db->query($sql);

        if ($result === false) {
            die("Database error: " . $this->db->error);
        }

        $courses = [];
        while ($row = $result->fetch_assoc()) {
            $courses[] = $row;
        }

        return $courses;
    }

    public function getCourseById($id) {
        $id = $this->db->real_escape_string($id);
        $sql = "SELECT * FROM {$this->table} WHERE course_id = '$id' LIMIT 1";
        $result = $this->db->query($sql);

        if ($result === false) {
            die("Database error: " . $this->db->error);
        }

        return $result->fetch_assoc();
    }
}
?>