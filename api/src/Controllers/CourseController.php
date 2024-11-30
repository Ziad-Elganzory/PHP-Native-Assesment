<?php

namespace Src\Controllers;

use Src\Models\CourseModel;

class CourseController {
    private $model;

    public function __construct() {
        header("Content-Type: application/json");
        $this->model = new CourseModel();
    }

    public function index() {
        $courses = $this->model->getAllCourses();
        echo json_encode($courses);
    }

    public function show($id) {
        $course = $this->model->getCourseById($id);

        if (!$course) {
            echo "Course not found.";
            return;
        }

        echo json_encode($course);
    }
}
?>