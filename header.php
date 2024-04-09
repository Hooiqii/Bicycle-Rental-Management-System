<?php
// session_start();
// echo $_SERVER['REQUEST_URI'];
require_once "config/config.php";

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
  // echo "<script>alert('isAdmin: " . ($isAdmin ? "true" : "false") . "\\nisEmployee: " . ($isEmployee ? "true" : "false") . "');</script>";

} else {
  $isAdmin = false;
  $isEmployee = false;
}
?>

<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/4f3985551e.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="assets/css/style.css">
  <link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css"
  rel="stylesheet"
  />
  <script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"
></script>
<title>The Right Bike Store</title>
</head>

<body>

<nav class="navbar navbar-expand-lg bg-black fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand text-white" href="adminHomepage.php">
    <?php
        if ($isAdmin) {
            echo "The Right Bike Store - Admin";
        } 
        else {
            echo "The Right Bike Store - User";
        }
    ?>
    </a>
    <button class="navbar-toggler bg-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse navbar-hover" id="navbarText">
      <ul class="navbar-nav ms-auto mb-lg-0">
        <li class="nav-item">
        <a class="nav-link text-white <?php echo ($_SERVER['PHP_SELF'] == '/database_project/adminHomepage.php') ? 'active' : ''; ?>" href="adminHomepage.php" style="padding:12px;">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white <?php echo ($_SERVER['PHP_SELF'] == '/database_project/bicycleList.php') ? 'active' : ''; ?>" href="bicycleList.php" style="padding:12px;">Bicycle</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white <?php echo ($_SERVER['PHP_SELF'] == '/database_project/rentalList.php') ? 'active' : ''; ?>" href="rentalList.php" style="padding:12px;">Rental</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white <?php echo ($_SERVER['PHP_SELF'] == '/database_project/employeeList.php') ? 'active' : ''; ?> <?php if (!$isAdmin) echo 'disabled'; ?>" href="employeeList.php" style="padding:12px;">Employee</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white <?php echo ($_SERVER['PHP_SELF'] == '/database_project/salesList.php') ? 'active' : ''; ?> <?php if (!$isAdmin) echo 'disabled'; ?>" href="salesList.php" style="padding:12px;">Sales</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white <?php echo ($_SERVER['PHP_SELF'] == '/database_project/login.php') ? 'active' : ''; ?>" href="login.php" style="padding:12px;">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
</body>
</html>