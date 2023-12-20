<?php

namespace App\Controllers;

use App\Models\jobModel;

class DeleteJobController {
    private $jobModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->jobModel = new JobModel($this->conn);
    }

    public function deleteJob() {
        if (isset($_GET['id'])) {
            $idSupprimer = $_GET['id'];
            $jobASupprimer = new jobModel($this->conn);
            $jobDetails = $jobASupprimer->getOffresById($idSupprimer);
        
            if ($jobDetails) {
                
                if (isset($jobDetails['title'])) {
                  
                    $jobASupprimer->supprimer();
                    header('Location: ?route=dashboard');
                    exit();
                } else {
                    echo "Error: 'title' is not set.";
                }
            } else {
                echo "Error: Job details not found.";
            }
        }
    }
}
?>
