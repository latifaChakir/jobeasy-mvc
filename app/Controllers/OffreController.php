<?php

namespace App\Controllers;

use App\Models\CandidatureModel;

class OffreController {
    private $jobModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->jobModel = new CandidatureModel($this->conn);
    }

    public function postuleroffre() {
        session_start();

        if (isset($_SESSION["id"])) {
            $user_id = $_SESSION["id"];
        }
        
        $id = $_GET['id'];
        
        $candidature = new CandidatureModel($this->conn);
        $candidature->saveApplication($id, $user_id);
    }
}
?>
