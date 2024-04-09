<?php 
session_start();
require_once "./header.php";
require_once "./config/config.php";
?>

<?php 

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $select = $conn->prepare("SELECT * FROM rental_info WHERE id = :id");
    $select->execute([':id' => $id]);
    $customer = $select->fetch(PDO::FETCH_OBJ);

    $selectBicycles = $conn->prepare("SELECT * FROM bicycle WHERE status = 1 OR (status = 0 AND id = :bicycle_id)");
    $selectBicycles->execute([':bicycle_id' => $customer->bicycle_id]);
    $allBicycle = $selectBicycles->fetchAll(PDO::FETCH_ASSOC);

}

if(isset($_POST['submit'])){

  $rental_start_day = new DateTime($_POST["rental_start_day"]);
	$rental_end_day = new DateTime($_POST["rental_end_day"]);

	$rental_time = $rental_start_day->diff($rental_end_day);

	if(empty($_POST["name"]) OR (empty($_POST["matricNo"])) OR (empty($_POST["phoneNo"])) OR (empty($_POST["rental_start_day"])) OR (empty($_POST["rental_end_day"])) OR (empty($_POST["bicycle_id"]))) {
		echo "<script>alert('one or more fields are empty');</script>";
	} else {
		$name = htmlspecialchars($_POST["name"]);
		$matricNo = htmlspecialchars($_POST["matricNo"]);
		$phoneNo = htmlspecialchars($_POST["phoneNo"]);
		$damage = htmlspecialchars($_POST["damage"]);
		$fine = htmlspecialchars($_POST["fine"]);
		$rental_start_day = htmlspecialchars($_POST["rental_start_day"]);
		$rental_end_day = htmlspecialchars($_POST["rental_end_day"]);
		$bicycle_id = htmlspecialchars($_POST["bicycle_id"]);

        if($_SESSION['user_type'] === 'admin') {
            $currentAdminID = $_SESSION['user_id'];   // retrieve the current logged in user id
            $currentUserID = null;
        } else if($_SESSION['user_type'] === 'employee') {
            $currentUserID = $_SESSION['user_id'];   // retrieve the current logged in user id
            $currentAdminID = null;
        }

        // Get the current bicycle ID
        $currentBicycleID = $customer->bicycle_id;

        // Update the previous bicycle status to 1
        $updatePreviousBicycle = $conn->prepare("UPDATE bicycle SET status = 1 WHERE id = :currentBicycleID");
        $updatePreviousBicycle->execute([':currentBicycleID' => $currentBicycleID]);

        // Get the selected bicycle ID from the form submission
        $newBicycleID = $_POST['bicycle_id'];

        // Update the selected bicycle status to 0
        $updateSelectedBicycle = $conn->prepare("UPDATE bicycle SET status = 0 WHERE id = :newBicycleID");
        $updateSelectedBicycle->execute([':newBicycleID' => $newBicycleID]);
        
        if ($rental_time->days >= 7) {
          $rental_fee = (ceil($rental_time->days / 7) * 10) + $damage + $fine;
        } else {
            $rental_fee = (($rental_time->days * 24 + $rental_time->h) * 3) + $damage + $fine;
        }
        
        $update = $conn->prepare("UPDATE rental_info SET name=:name, matric_no=:matricNo, phoneNo=:phoneNo, damage=:damage, fine=:fine, rental_start_day=:rental_start_day, rental_end_day=:rental_end_day, rental_fee=:rental_fee, bicycle_id=:bicycle_id, updated_by_employee=:updated_by_employee, updated_by_admin=:updated_by_admin WHERE id = :id");
		$update->execute([
            ":name" => $name,
            ":matricNo" => $matricNo,
            ":phoneNo" => $phoneNo,
            ":damage" => $damage,
            ":fine" => $fine,
            ":rental_start_day" => $rental_start_day,
            ":rental_end_day" => $rental_end_day,
            ":rental_fee" => $rental_fee,
            ":bicycle_id" => $bicycle_id,
            ":updated_by_employee" => $currentUserID,
            ":updated_by_admin" => $currentAdminID,
            ":id" => $id,
            ]);
        if ($update->rowCount() > 0) {
          $_SESSION['success_update_message'] = "New record successfully updated!";
        } else {
            $_SESSION['error_update_message'] = "Error occurred while updating the record.";
        }
        header('Location:./rentalList.php');
        exit();
		}	
	}
?>

<div class="back" style="padding-top:60px">
  <a href="rentalList.php"><i class="fa-solid fa-angle-left"></i>Back</a>
</div>
<div class="container-fluid">
  <div class="row justify-content-center p-5 pt-1">
    <div class="col-lg-6">
      <div class="card text-black" style="border-radius: 25px;">
        <div class="card-body p-md-5 p-lg-1">
          <div class="row justify-content-center">
            <!-- <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1"> -->
              <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Update Rental Info</p>
              <form action="rentalUpdate.php?id=<?php echo $id; ?>" class="px-5" method="POST">
                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-tag fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
                    <input type="text" id="name" class="form-control active" name="name" value="<?php echo $customer->name; ?>" required/>
                    <label class="form-label" for="name">Name</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-money-check-dollar fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
                    <input type="text" id="matricNo" class="form-control active" name="matricNo" value="<?php echo $customer->matric_no; ?>" required/>
                    <label class="form-label" for="matricNo">Matric No</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-money-check-dollar fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
                    <input type="number" id="phoneNo" class="form-control active" name="phoneNo" value="<?php echo $customer->phoneNo; ?>" required/>
                    <label class="form-label" for="phoneNo">Phone No</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-money-check-dollar fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
                    <input type="number" id="damage" class="form-control active" name="damage" value="<?php echo $customer->damage; ?>" required/>
                    <label class="form-label" for="damage">Damage</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-money-check-dollar fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
                    <input type="number" id="fine" class="form-control active" name="fine" value="<?php echo $customer->fine; ?>" required/>
                    <label class="form-label" for="fine">Fine</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-money-check-dollar fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
					<label class="form-label" style="padding-left:12px; margin-bottom:0; margin-right: 10px;" for="rentalStartDay">Rental Start Date</label>
					<input type="datetime-local" id="rentalStartDay" name="rental_start_day" value="<?php echo $customer->rental_start_day; ?>"> 
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-money-check-dollar fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
					<label class="form-label" style="padding-left:12px; margin-bottom:0; margin-right: 10px;" for="rentalEndDay">Rental End Date</label>
				    <input type="datetime-local" id="rentalEndDay" name="rental_end_day"  value="<?php echo $customer->rental_end_day; ?>">                  
					</div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-money-check-dollar fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                    <label class="form-label" style="padding-left:12px; margin-bottom:0; margin-right: 10px;" for="bicycleId">Bicycle Type</label>
                    <select class="select" name="bicycle_id" required>
                    <?php foreach ($allBicycle as $bicycle): ?>
                        <?php $selected = ($bicycle['id'] == $customer->bicycle_id) ? 'selected' : ''; ?>
                        <option value="<?php echo $bicycle['id']; ?>" <?php echo $selected; ?>><?php echo $bicycle['type']; ?></option>
                    <?php endforeach; ?>
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