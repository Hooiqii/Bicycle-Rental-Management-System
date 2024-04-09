<?php 
session_start();
require_once "./header.php";
require_once "./config/config.php";
?>

<?php 
if(isset($_POST['submit'])){
	if(!isset($_POST["type"]) OR (!isset($_POST["price"])) OR (!isset($_POST["status"]))) {
		echo "<script>alert('one or more fields are empty');</script>";
	} else {
		$type = htmlspecialchars($_POST["type"]);
		$price = htmlspecialchars($_POST["price"]);
		$status = htmlspecialchars($_POST["status"]);

        if($_SESSION['user_type'] === 'admin') {
            $currentAdminID = $_SESSION['user_id'];   // retrieve the current logged in user id
            $currentUserID = null;
        } else if($_SESSION['user_type'] === 'employee') {
            $currentUserID = $_SESSION['user_id'];   // retrieve the current logged in user id
            $currentAdminID = null;
        }

		$insert = $conn->prepare("INSERT INTO bicycle(type, price, status, created_by_employee, created_by_admin)
		VALUES(:type, :price, :status, :created_by_employee, :created_by_admin)");

		$insert->execute([
		":type" => $type,
		":price" => $price,
		":status" => $status,
        ":created_by_employee" => $currentUserID,
        ":created_by_admin" => $currentAdminID,
		]);
        if ($insert->rowCount() > 0) {
          $_SESSION['success_insert_message'] = "New record successfully inserted!";
        } else {
            $_SESSION['error_insert_message'] = "Error occurred while inserting the record.";
        }
        header('Location:./bicycleList.php');
        exit();
		}	
}
?>

<div class="back mt-5">
  <br>
  <a href="bicycleList.php"><i class="fa-solid fa-angle-left"></i>Back</a>
</div>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card text-black" style="border-radius: 25px;">
        <div class="card-body p-md-5">
          <div class="row justify-content-center">
            <!-- <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1"> -->
              <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Add Bicycle</p>
              <form action="bicycleInsert.php" class="px-5" method="POST">
                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-tag fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
                  <label class="form-label" style="padding-left:12px" for="type">Type</label>
					          <select class="select" name="type" required>
                        <option value="with basket">with basket</option>
                        <option value="with seat">with seat</option>
                        <option value="with basket and seat">with basket and seat</option>
                        <option value="none">none</option>
                    </select>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-money-check-dollar fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
                    <input type="text" pattern="[0-9]+([,.][0-9]+)?" id="price" class="form-control" name="price" required/>
                    <label class="form-label" for="price">Price</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-square-pen fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
					<!-- <input type="text" id="status" class="form-control" name="status" required/> -->
                    <label class="form-label" style="padding-left:12px" for="status">Status</label>
					          <select class="select" name="status" required>
                        <option value="0">0</option>
                        <option value="1">1</option>
                    </select>
                </div>
                </div>
                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                  <button type="submit" name="submit" class="btn btn-primary btn-lg">Add</button>
                </div>
              </form>
            <!-- </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php 
require_once "./footer.php";
?>