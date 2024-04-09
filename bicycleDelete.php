<?php 
session_start();
require_once "./header.php";
require_once "./config/config.php";
?>

<?php 

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $delete = $conn->prepare("DELETE FROM bicycle WHERE id = :id");
    $delete->execute([':id' => $id]);
    if ($delete->rowCount() > 0) {
        $_SESSION['success_delete_message'] = "Record successfully deleted!";
    } else {
          $_SESSION['error_delete_message'] = "Error occurred while deleting the record.";
    }
      header('Location:./bicycleList.php');
      exit();
}
?>