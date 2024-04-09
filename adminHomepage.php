<?php
session_start();
require_once "./header.php";
require_once "./config/config.php";
// echo $_SERVER['REQUEST_URI'];

// Check if the user is logged in and retrieve their user ID
if (isset($_SESSION['user_id'])) {
  $currentUserId = $_SESSION['user_id'];

  // Check if the user exists in the admin table
  $queryAdmin = $conn->prepare("SELECT * FROM admin WHERE id = :user_id");
  $queryAdmin->execute(['user_id' => $currentUserId]);
  $isAdmin = $queryAdmin->rowCount() > 0;
// If the user is not an admin, check if they exist in the employee table
  if (!$isAdmin) {
    $queryEmployee = $conn->prepare("SELECT * FROM employee WHERE id = :user_id");
    $queryEmployee->execute(['user_id' => $currentUserId]);
    $isEmployee = $queryEmployee->rowCount() > 0;
  } else {
    $isEmployee = false;
  }
  echo "<script>alert('isAdmin: " . ($isAdmin ? "true" : "false") . "\\nisEmployee: " . ($isEmployee ? "true" : "false") . "');</script>";

} else {
  $isAdmin = false;
  $isEmployee = false;
}
?>


<div class="row" style="padding-top:100px;">
  <div class="col-sm-6">
    <div class="card" style="background-color: #B2EDFF;margin-left: 30px;margin-right:30px;">
      <div class="card-body px-5">
        <h5 class="card-title fw-bold"><i class="fas fa-bicycle me-4 fa-lg"></i>Bicycle</h5>
        <a href="bicycleList.php" class="btn btn-primary px-5 py-3 float-end">Manage</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card" style="background-color: #FFFB8F; margin-left: 30px;margin-right:30px;">
      <div class="card-body px-5">
        <h5 class="card-title fw-bold"><i class="fas fa-users me-4 fa-lg"></i>Rental</h5>
        <a href="rentalList.php" class="btn btn-primary px-5 py-3 float-end">Manage</a>
      </div>
    </div>
  </div>
</div>

<div class="row" style="padding-top:10px;">
  <div class="col-sm-6">
    <div class="card" style="background-color: #FFD4F6;margin-left: 30px;margin-right:30px;">
      <div class="card-body px-5">
        <h5 class="card-title fw-bold"><i class="fas fa-chart-column me-4 fa-lg"></i>Sales</h5>
        <a href="salesList.php" class="btn btn-primary px-5 py-3 float-end <?php if (!$isAdmin) echo 'disabled'; ?>">Manage</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card" style="background-color: #B3FFD6;margin-left: 30px;margin-right:30px;">
      <div class="card-body px-5">
        <h5 class="card-title fw-bold"><i class="fas fa-people-carry-box me-4 fa-lg"></i>Employee</h5>
        <a href="employeeList.php" class="btn btn-primary px-5 py-3 float-end <?php if (!$isAdmin) echo 'disabled'; ?>">Manage</a>
      </div>
    </div>
  </div>
</div>

<div id="carouselExampleAutoplaying" style="padding:15px;width: 600px;height: 450px;" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="assets/Images/bicycle1.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="assets/Images/bicycle2.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="assets/Images/bicycle3.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="assets/Images/bicycle4.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="assets/Images/bicycle5.png" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<?php
require_once "footer.php";
?>