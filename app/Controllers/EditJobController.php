<?php

namespace App\Controllers;

use App\Models\jobModel;

class EditJobController {
    private $jobModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->jobModel = new JobModel($this->conn);
    }

    public function editJob() {
        $jobDetails = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idModifier = $_GET['id'];
            $jobModifier = new jobModel($this->conn);
        
            $jobDetails = $jobModifier->getOffresById($idModifier);
            if ($jobDetails) {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $company = $_POST['company'];
                $location = $_POST['location'];
                $status = $_POST['status'];
                $date_created = $_POST['date_created'];
                $image_path = $_FILES['image_path']['name'];
        
                $jobModifier->setTitle($title);
                $jobModifier->setDescription($description);
                $jobModifier->setCompany($company);
                $jobModifier->setLocation($location);
                $jobModifier->setStatus($status);
                $jobModifier->setDateCreated($date_created);
                $jobModifier->setImagePath($image_path);
        
                $jobModifier->sauvegarder();
                header('Location: ?route=dashboard');
                exit();
            }
        } elseif (isset($_GET['id'])) {
            $idModifier = $_GET['id'];
            $jobModifier = new jobModel($this->conn);
            $jobDetails = $jobModifier->getOffresById($idModifier);
            
        }
        require(__DIR__ . '/../../view/admin/edit.php');

    }
}
?>
