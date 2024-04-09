<?php 
session_start();
require_once "./header.php";
require_once "./config/config.php";
?>

<?php 

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $select = $conn->prepare("SELECT * FROM employee WHERE id = :id");
    $select->execute([':id' => $id]);
    $user = $select->fetch(PDO::FETCH_OBJ);
}

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

		$checkUsernameQuery = $conn->prepare("SELECT username FROM employee WHERE username = :username");
		$checkUsernameQuery->execute([":username" => $username]);
		$checkEmailQuery = $conn->prepare("SELECT email FROM employee WHERE email = :email");
		$checkEmailQuery->execute([":email" => $email]);

		$usernameDuplicate = $checkUsernameQuery->fetch(PDO::FETCH_ASSOC);
		$emailDuplicate = $checkEmailQuery->fetch(PDO::FETCH_ASSOC);

		if($checkUsernameQuery->rowCount() > 2) {
			echo "<script>alert('Username is already taken. Please use another username.');</script>";
		} else if($checkEmailQuery->rowCount() > 2) {
			echo "<script>alert('Email is already taken. Please use another email.');</script>";
		} else {
				$update = $conn->prepare("UPDATE employee SET username=:username, password=:password, name=:name, phoneNo=:phoneNo, email=:email, remark=:remark WHERE id=:id");

				$update->execute([
          ":id" => $id,
					":username" => $username,
					":password" => password_hash($password, PASSWORD_DEFAULT),
					":name" => $name,
					":phoneNo" => $phoneNo,
					":email" => $email,
					":remark" => $remark,
				]);
        if ($update->rowCount() > 0) {
          $_SESSION['success_update_message'] = "New record successfully updated!";
        } else {
            $_SESSION['error_update_message'] = "Error occurred while updating the record.";
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
              <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Update Employee</p>
              <form action="employeeUpdate.php?id=<?php echo $id; ?>" class="px-5" method="POST">
                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
                    <input type="text" id="username" value="<?php echo $user->username; ?>" class="form-control active" name="username" required/>
                    <label class="form-label" for="username">Username</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
					<input type="password" id="password" class="form-control active" value="<?php echo $user->password; ?>" name="password" required/>
                    <label class="form-label" for="password">Password</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
									<!-- <i class="fas fa-user-tag fa-lg me-3"></i> -->
					<i class="far fa-circle-user fa-lg me-3"></i>
                  <div class="form-outline flex-fill mb-0">
                    <input type="text" id="name" value="<?php echo $user->name; ?>" class="form-control active" name="name" required/>
                    <label class="form-label" for="name">Name</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
									<i class="fas fa-phone fa-lg me-3"></i>
                  <div class="form-outline flex-fill mb-0">
                    <input type="number" id="phoneNo" value="<?php echo $user->phoneNo; ?>" class="form-control active" name="phoneNo" required/>
                    <label class="form-label" for="phoneNo">Phone Number</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
					<i class="fas fa-envelope-open-text fa-lg me-3"></i>
					<div class="form-outline flex-fill mb-0">
                    <input type="email" id="email" class="form-control active" value="<?php echo $user->email; ?>" name="email" required/>
                    <label class="form-label" for="email">Email</label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center mb-4">
					<i class="fas fa-pen fa-lg me-3"></i>                  
					<div class="form-outline flex-fill mb-0">
                    <input type="text" id="remark" value="<?php echo $user->remark; ?>" class="form-control active" name="remark"/>
                    <label class="form-label" for="remark">Remark</label>
                  </div>
                </div>
                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                  <button type="submit" name="submit" class="btn btn-primary btn-lg">Update</button>
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