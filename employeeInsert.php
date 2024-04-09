<?php 
session_start();
require_once "./header.php";
require_once "./config/config.php";
?>

<?php 
if(isset($_POST['submit'])){
	if(empty($_POST["username"]) OR (empty($_POST["password"])) OR (empty($_POST["name"])) OR (empty($_POST["phoneNo"])) OR (empty($_POST["email"]))) {
		echo "<script>alert('one or more fields are empty');</script>";
	} else {
		$username = htmlspecialchars($_POST["username"]);
		$password = htmlspecialchars($_POST["password"]);
		$name = htmlspecialchars($_POST["name"]);
		$phoneNo = htmlspecialchars($_POST["phoneNo"]);
		$email = htmlspecialchars($_POST["email"]);
		$remark = htmlspecialchars($_POST["remark"]);

    $currentAdminID = $_SESSION['user_id'];   // retrieve the current logged in user id

		$checkUsernameQuery = $conn->prepare("SELECT username FROM employee WHERE username = :username");
		$checkUsernameQuery->execute([":username" => $username]);
		$checkEmailQuery = $conn->prepare("SELECT email FROM employee WHERE email = :email");
		$checkEmailQuery->execute([":email" => $email]);

		$usernameDuplicate = $checkUsernameQuery->fetch(PDO::FETCH_ASSOC);
		$emailDuplicate = $checkEmailQuery->fetch(PDO::FETCH_ASSOC);

		if($usernameDuplicate) {
			echo "<script>alert('Username is already taken. Please use another username.');</script>";
		} else if($emailDuplicate) {
			echo "<script>alert('Email is already taken. Please use another email.');</script>";
		} else {
				$insert = $conn->prepare("INSERT INTO employee(username, password, name, phoneNo, email, remark, created_by_admin)
				VALUES(:username, :password, :name, :phoneNo, :email, :remark, :created_by_admin)");

				$insert->execute([
					":username" => $username,
					":password" => password_hash($password, PASSWORD_DEFAULT),
					":name" => $name,
					":phoneNo" => $phoneNo,
					":email" => $email,
					":remark" => $remark,
          ':created_by_admin' => $currentAdminID,
				]);
        if ($insert->rowCount() > 0) {
          $_SESSION['success_insert_message'] = "New record successfully inserted!";
        } else {
            $_SESSION['error_insert_message'] = "Error occurred while inserting the record.";
        }
        header('Location:./employeeList.php');
        exit();
		}	
	}
}
?>

<div class="back mt-5">
  <br>
  <a href="employeeList.php"><i class="fa-solid fa-angle-left"></i>Back</a>
</div>
<div class="container-fluid mb-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card text-black" style="border-radius: 25px;">
        <div class="card-body p-md-5">
          <div class="row justify-content-center">
            <!-- <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1"> -->
              <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Add Employee</p>
              <form action="employeeInsert.php" class="px-5" method="POST">
                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
                    <input type="text" id="username" class="form-control" name="username" required/>
                    <label class="form-label" for="username">Username</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
									<input type="password" id="password" class="form-control" name="password" required/>
                    <label class="form-label" for="password">Password</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
									<!-- <i class="fas fa-user-tag fa-lg me-3"></i> -->
									<i class="far fa-circle-user fa-lg me-3"></i>
                  <div class="form-outline flex-fill mb-0">
                    <input type="text" id="name" class="form-control" name="name" required/>
                    <label class="form-label" for="name">Name</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
									<i class="fas fa-phone fa-lg me-3"></i>
                  <div class="form-outline flex-fill mb-0">
                    <input type="number" id="phoneNo" class="form-control" name="phoneNo" required/>
                    <label class="form-label" for="phoneNo">Phone Number</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
										<i class="fas fa-envelope-open-text fa-lg me-3"></i>
										<div class="form-outline flex-fill mb-0">
                    <input type="email" id="email" class="form-control" name="email" required/>
                    <label class="form-label" for="email">Email</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
									<i class="fas fa-pen fa-lg me-3"></i>                  
									<div class="form-outline flex-fill mb-0">
                    <input type="text" id="remark" class="form-control" name="remark"/>
                    <label class="form-label" for="remark">Remark</label>
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