<?php

namespace App\Controllers;

use App\Models\CandidatureModel;

class ApprovedController {
    private $jobModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->jobModel = new CandidatureModel($this->conn);
    }

    public function approvedStatus() {
        if (isset($_GET['id']) && isset($_GET['id_user'])) {
            $id = $_GET['id'];
            $user_id = $_GET['id_user'];
         
            $candidature = new CandidatureModel($this->conn);
            $candidature->updateStatus($id, $user_id, 'Approved');
        }
    }
}
?>
