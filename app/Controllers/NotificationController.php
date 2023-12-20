<?php

namespace App\Controllers;

use App\Models\CandidatureModel;

class NotificationController
{
    private $jobModel;
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->jobModel = new CandidatureModel($this->conn);
    }

    public function notificationForoffre()
    {
        session_start();
        if (isset($_SESSION["id"])) {
            $user_id = $_SESSION["id"];
        }

        $notifications = new CandidatureModel($this->conn);
        $notificationsArray = $notifications->getNotificationsForUser($user_id);
        require(__DIR__ .'../../../view/notification.php');
    }
}
?>