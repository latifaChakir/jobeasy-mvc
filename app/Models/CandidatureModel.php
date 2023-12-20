<?php
namespace App\Models;

require_once __DIR__ . '/../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CandidatureModel
{

    public $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function saveApplication($jobId, $userId)
    {
        $status = null;
        $checkSql = "SELECT candidature_status FROM candidature WHERE job_id = ? AND user_id = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bind_param("ii", $jobId, $userId);
        $checkStmt->execute();
        $checkStmt->bind_result($status);




        if ($checkStmt->fetch()) {
            if ($status === 'Rejected') {
                $this->redirectAndExit("You have already applied for this job and it has been rejected.");
            } elseif ($status === 'Approved') {
                $this->redirectAndExit("You have already applied for this job and it has been approved.");
            } elseif ($status === 'Pending') {
                $this->redirectAndExit("You have already applied for this job and it is still pending.");
            }
        } else {
            $checkStmt->close();

            // L'utilisateur n'a pas encore postulé
            $insertSql = "INSERT INTO candidature (job_id, user_id, candidature_status) VALUES (?, ?, 'Pending')";
            $insertStmt = $this->conn->prepare($insertSql);

            if ($insertStmt->execute([$jobId, $userId])) {
                $this->redirectAndExit("You have successfully applied to this job!");
            } else {
                echo '<script>alert("Failed to apply. Please try again.");</script>';
            }
        }
    }


    public function getOffresPostuler()
    {
        $offres = array();
        $req = "SELECT * 
        FROM candidature 
        JOIN jobs ON candidature.job_id = jobs.job_id 
        JOIN users ON candidature.user_id = users.id;
        ";
        $result = $this->conn->query($req);
        while ($array = $result->fetch_array()) {
            $offres[] = $array;
        }
        return $offres;
    }


    private function redirectAndExit($message)
    {
        echo '<script>';
        echo 'alert("' . $message . '");';
        echo 'window.location.href = "?route=home";';
        echo '</script>';
        exit();
    }

    public function updateStatus($jobId, $userId, $status, $senderEmail)
    {
        $jobTitle = $this->getJobTitle($jobId, $userId);

        if (!$jobTitle) {
            echo '<script>alert("Failed to retrieve job title. Please try again.");</script>';
            return;
        }

        if (!$this->executeUpdateStatus($status, $jobId, $userId)) {
            echo '<script>alert("Failed to update candidature status. Please try again.");</script>';
            return;
        }

        $this->sendEmailNotification($jobTitle, $status, $senderEmail);
        $this->insertNotification($userId, $jobTitle, $status);

        echo '<script>';
        echo 'alert("Candidature status updated successfully!");';
        echo 'window.location.href = "?route=offre";';
        echo '</script>';
    }

    private function getJobTitle($jobId, $userId)
    {
        $getJobTitleSql = "SELECT jobs.title FROM candidature
                           JOIN jobs ON candidature.job_id = jobs.job_id
                           WHERE candidature.job_id = ? AND candidature.user_id = ?";
        $getJobTitleStmt = $this->conn->prepare($getJobTitleSql);
        $getJobTitleStmt->execute([$jobId, $userId]);
        $jobTitleResult = $getJobTitleStmt->get_result();

        if ($jobTitleRow = $jobTitleResult->fetch_assoc()) {
            return $jobTitleRow['title'];
        }

        return null;
    }

    private function executeUpdateStatus($status, $jobId, $userId)
    {
        $updateSql = "UPDATE candidature SET candidature_status = ? WHERE job_id = ? AND user_id = ?";
        $updateStmt = $this->conn->prepare($updateSql);

        return $updateStmt->execute([$status, $jobId, $userId]);
    }

    private function sendEmailNotification($jobTitle, $status, $senderEmail)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'chakirlatifa2001@gmail.com';
            $mail->Password = 'kynp noql jqit xfhv';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('chakirlatifa2001@gmail.com', 'Latifa Chakir');
            $mail->addAddress($senderEmail);


            $mail->isHTML(true);
            $mail->Subject = 'Mise à jour du statut de candidature';
            $mail->Body = "Le statut de votre candidature pour l'offre \"$jobTitle\" a été mis à jour: $status";

            $mail->send();
            echo 'E-mail envoyé avec succès';
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
        }
    }

    private function insertNotification($userId, $jobTitle, $status)
    {
        $notificationMessage = "Le statut de votre candidature pour l'offre \"$jobTitle\" a été mis à jour: $status ";
        $insertNotificationSql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        $insertNotificationStmt = $this->conn->prepare($insertNotificationSql);

        if (!$insertNotificationStmt->execute([$userId, $notificationMessage])) {
            echo '<script>alert("Failed to insert notification. Please try again.");</script>';
            return;
        }
    }

    public function getNotificationsForUser($userId)
    {
        $notifications = array();

        $selectNotificationsSql = "SELECT * FROM notifications WHERE user_id = ?";
        $selectNotificationsStmt = $this->conn->prepare($selectNotificationsSql);
        $selectNotificationsStmt->bind_param("i", $userId);

        if ($selectNotificationsStmt->execute()) {
            $result = $selectNotificationsStmt->get_result();

            while ($array = $result->fetch_assoc()) {
                $notifications[] = $array;
            }

            $selectNotificationsStmt->close();
        } else {
            echo '<script>alert("Failed to retrieve notifications. Please try again.");</script>';
        }

        return $notifications;
    }


}



?>