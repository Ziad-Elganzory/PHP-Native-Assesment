<?php

namespace Src\Controllers;

use Src\Models\CategoryModel;

class CategoryController {
    private $model;

    public function __construct() {
        header("Content-Type: application/json");
        $this->model = new CategoryModel();
    }

    public function index() {
        $categories = $this->model->getAllCategories();
        echo json_encode($categories);
    }

    public function show($id) {
        $category = $this->model->getCategoryById($id);

        if (!$category) {
            echo "Category not found.";
            return;
        }

        echo json_encode($category);
    }
}
