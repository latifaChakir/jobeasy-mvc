<?php

namespace App\Controllers;
use App\Models\JobModel; 

class SearchController {
    public $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function index() {
        if (isset($_GET) or isset($_POST)) {
            $searchTerm = isset($_POST['title']) ? $_POST['title'] : (isset($_POST['company']) ? $_POST['company'] : (isset($_POST['location']) ? $_POST['location'] : NULL));

            $offreQuery = new jobModel($this->conn);
            $allOffres = $offreQuery->search($searchTerm);
        }

        require(__DIR__ .'../../../view/search.php');
    }


}
