<?php
session_start();
require_once "./header.php";
require_once "./config/config.php";
?>

<?php
$bicycle = $conn->query("SELECT id, type FROM bicycle WHERE status = 1 ORDER BY type ASC");
$bicycle->execute();

$allBicycle = $bicycle->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST["name"]);
    $matricNo = htmlspecialchars($_POST["matricNo"]);
    $phoneNo = htmlspecialchars($_POST["phoneNo"]);
    $damage = htmlspecialchars($_POST["damage"]);
    $fine = htmlspecialchars($_POST["fine"]);
    $rental_start_day = new DateTime($_POST["rental_start_day"]);
    $rental_end_day = new DateTime($_POST["rental_end_day"]);

    $rental_time = $rental_start_day->diff($rental_end_day);

    if ($rental_time->days >= 7) {
        $rental_fee = (ceil($rental_time->days / 7) * 10) + $damage + $fine;
    } else {
        $rental_fee = (($rental_time->days * 24 + $rental_time->h) * 3) + $damage + $fine;
    }

    if (empty($name) || empty($matricNo) || empty($phoneNo) || empty($rental_start_day) || empty($rental_end_day) || empty($_POST["bicycle_id"])) {
        echo "<script>alert('one or more fields are empty');</script>";
    } else {
        $bicycle_id = htmlspecialchars($_POST["bicycle_id"]);

        $updateBicycleStatus = $conn->prepare("UPDATE bicycle SET status = 0 WHERE id = :bicycle_id");
        $updateBicycleStatus->execute([":bicycle_id" => $bicycle_id]);

        if ($_SESSION['user_type'] === 'admin') {
            $currentAdminID = $_SESSION['user_id'];   // retrieve the current logged in user id
            $currentUserID = null;
        } else if ($_SESSION['user_type'] === 'employee') {
            $currentUserID = $_SESSION['user_id'];   // retrieve the current logged in user id
            $currentAdminID = null;
        }

        $insert = $conn->prepare("INSERT INTO rental_info(name, matric_no, phoneNo, damage, fine, rental_start_day, rental_end_day, rental_fee, bicycle_id, created_by_employee, created_by_admin)
        VALUES(:name, :matricNo, :phoneNo, :damage, :fine, :rental_start_day, :rental_end_day, :rental_fee, :bicycle_id, :created_by_employee, :created_by_admin)");

        $insert->execute([
            ":name" => $name,
            ":matricNo" => $matricNo,
            ":phoneNo" => $phoneNo,
            ":damage" => $damage,
            ":fine" => $fine,
            ":rental_start_day" => $rental_start_day->format('Y-m-d H:i:s'),
            ":rental_end_day" => $rental_end_day->format('Y-m-d H:i:s'),
            ":rental_fee" => $rental_fee,
            ":bicycle_id" => $bicycle_id,
            ":created_by_employee" => $currentUserID,
            ":created_by_admin" => $currentAdminID,
        ]);

        if ($insert->rowCount() > 0) {
            $_SESSION['success_insert_message'] = "New record successfully inserted!";
        } else {
            $_SESSION['error_insert_message'] = "Error occurred while inserting the record.";
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
            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Add Rental Info</p>
            <form action="rentalInsert.php" class="px-5" method="POST">
              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-tag fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                  <input type="text" id="name" class="form-control" name="name" required/>
                  <label class="form-label" for="name">Name</label>
                </div>
              </div>
              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-money-check-dollar fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                  <input type="text" id="matricNo" class="form-control" name="matricNo" required/>
                  <label class="form-label" for="matricNo">Matric No</label>
                </div>
              </div>
              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-money-check-dollar fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                  <input type="number" id="phoneNo" class="form-control" name="phoneNo" required/>
                  <label class="form-label" for="phoneNo">Phone No</label>
                </div>
              </div>
              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-money-check-dollar fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                  <input type="number" id="damage" class="form-control" name="damage" required/>
                  <label class="form-label" for="damage">Damage</label>
                </div>
              </div>
              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-money-check-dollar fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                  <input type="number" id="fine" pattern="[0-9]+([,.][0-9]+)?" class="form-control" name="fine" required/>
                  <label class="form-label" for="fine">Fine</label>
                </div>
              </div>
              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-money-check-dollar fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                  <label class="form-label" style="padding-left:12px; margin-bottom:0; margin-right: 10px;" for="rentalStartDay">Rental Start Date</label>
                  <input type="datetime-local" id="rentalStartDay" name="rental_start_day"> 
                </div>
              </div>
              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-money-check-dollar fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                  <label class="form-label" style="padding-left:12px; margin-bottom:0; margin-right: 10px;" for="rentalEndDay">Rental End Date</label>
                  <input type="datetime-local" id="rentalEndDay" name="rental_end_day">                  
                </div>
              </div>
              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-money-check-dollar fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                  <label class="form-label" style="padding-left:12px; margin-bottom:0; margin-right: 10px;" for="bicycleId">Bicycle Type</label>
                  <select class="select" name="bicycle_id" required>
                    <?php foreach ($allBicycle as $bicycle): ?>
                      <option value="<?php echo $bicycle['id']; ?>"><?php echo $bicycle['type']; ?></option>
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
