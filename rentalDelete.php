<?php
session_start();
require_once "./header.php";
require_once "./config/config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the bicycle_id associated with the rental_info record being deleted
    $getBicycleId = $conn->prepare("SELECT bicycle_id FROM rental_info WHERE id = :id");
    $getBicycleId->execute([':id' => $id]);
    $bicycleId = $getBicycleId->fetchColumn();

    $delete = $conn->prepare("DELETE FROM rental_info WHERE id = :id");
    $delete->execute([':id' => $id]);

    if ($delete->rowCount() > 0) {
        // Update the status in the bicycle table
        $updateBicycleStatus = $conn->prepare("UPDATE bicycle SET status = 1 WHERE id = :bicycle_id");
        $updateBicycleStatus->execute([':bicycle_id' => $bicycleId]);

        $_SESSION['success_delete_message'] = "Record successfully deleted!";
    } else {
        $_SESSION['error_delete_message'] = "Error occurred while deleting the record.";
    }
}

header('Location: ./rentalList.php');
exit();
?>
