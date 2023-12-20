<?php

namespace App\Controllers;

use App\Models\jobModel;

class AddJobController {
    private $jobModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->jobModel = new JobModel($this->conn);
    }

    public function addJob() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['title']) && isset($_POST['description'])) {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $company = $_POST['company'];
                $location = $_POST['location'];
                $status = $_POST['status'];
                $date_created = $_POST['date_created'];
                $image_path = $_POST['image_path'];

                $newJob = new jobModel($this->conn);
                $newJob->setTitle($title);
                $newJob->setDescription($description);
                $newJob->setCompany($company);
                $newJob->setLocation($location);
                $newJob->setStatus($status);
                $newJob->setDateCreated($date_created);
                $newJob->setImagePath($image_path);
                $newJob->sauvegarder();
                header('Location: ?route=dashboard');
                exit();
            }
        }
    }
}
?>
