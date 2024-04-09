<?php 
session_start();

require_once "./headerLogin.php";
require_once "./config/config.php";
?>

<?php 

if(isset($_POST['submit'])){
	if(empty($_POST["username"]) OR (empty($_POST["password"]))) {
		echo "<script>alert('one or more fields are empty');</script>";
	} else {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
		
    $checkInfo = $conn->prepare("SELECT * FROM employee WHERE username = :username");
    $checkInfo->execute([':username' => $username]);

    $consistsInfo = $checkInfo->fetch(PDO::FETCH_ASSOC);
    if($checkInfo->rowCount() > 0) {
      
      if(password_verify($password, $consistsInfo['password'])) {  // true
        $_SESSION['user_id'] = $consistsInfo['id'];
        $_SESSION['user_type'] = 'employee';
        // echo "<script>alert('{$_SESSION['user_type']}Successfully Logged In!');</script>";
        echo "<script>alert('Successfully Logged In!');</script>";
        header('Location:./adminHomepage.php');
        exit();
      } else {
        echo "<script>alert('Wrong username or password!');</script>";
      }
    } else {
      echo "<script>alert('Wrong username or password!');</script>";
    }
    $checkInfo = $conn->prepare("SELECT * FROM admin WHERE username = :username");
    $checkInfo->execute([':username' => $username]);
    $consistsInfo = $checkInfo->fetch(PDO::FETCH_ASSOC);
    if($checkInfo->rowCount() > 0) {
      
      if(password_verify($password, $consistsInfo['password'])) {  // true
        $_SESSION['user_id'] = $consistsInfo['id'];
        $_SESSION['user_type'] = 'admin';
        // echo "<script>alert('{$_SESSION['user_type']}Successfully Logged In!');</script>";
        echo "<script>alert('Successfully Logged In!');</script>";
        header('Location:./adminHomepage.php');
        exit();
      } else {
        echo "<script>alert('Wrong username or password!');</script>";
      }
    } else {
      echo "<script>alert('Wrong username or password!');</script>";
    }
	}
}
?>
<section class="vh-100">
  <div class="container-fluid pt-5">
    <div class="row">
		<div class="col-sm-8 px-0 d-none d-sm-block">
        <img src="assets/Images/img1.jpg"
          alt="Login image" class="w-100 vh-100" style="object-fit:cover; object-position: left;">
      </div>

      <div class="col-sm-4 text-black my-auto">

        <div class="px-5 ms-xl-4">
        <i class="fas fa-person-biking fa-2x me-3 pt-2 mt-xl-4 mb-5" style="color: #709085;"></i>
          <!-- <i class="fas fa-crow fa-2x me-3 pt-2 mt-xl-4" style="color: #709085;"></i> -->
          <span class="h1 fw-bold">BICYCLE</span>
        </div>

        <div class="d-flex align-items-center px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5" style="height:500px;">

          <form style="width: 23rem;" method="POST" action="login.php">

            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; text-align:center;">Log in</h3>

            <div class="form-outline mb-4">
              <input type="text" id="username" name="username" class="form-control form-control-lg" required/>
              <label class="form-label" for="username">Username</label>
            </div>

            <div class="form-outline mb-4">
              <input type="password" id="password" name="password" class="form-control form-control-lg" required/>
              <label class="form-label" for="password">Password</label>
            </div>

            <div class="pt-1 mb-4">
              <button class="btn btn-info btn-lg btn-block" type="submit" name="submit">Login</button>
            </div>

          </form>

        </div>

      </div>
      
    </div>
  </div>
</section>
<?php 
require_once "./footer.php";
?>