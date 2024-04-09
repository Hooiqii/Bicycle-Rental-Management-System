<?php 
session_start();
require_once "./header.php";
require_once "./config/config.php";
?>

<?php 
$user = $conn->query("SELECT * FROM employee");
$user->execute();

$allUsers = $user->fetchAll(PDO::FETCH_OBJ);

// for updating echo
if (isset($_SESSION['success_update_message'])) {
  echo "<script>alert('{$_SESSION['success_update_message']}');</script>";
  unset($_SESSION['success_update_message']);
}

if (isset($_SESSION['error_update_message'])) {
  echo "<script>alert('{$_SESSION['error_update_message']}');</script>";
  unset($_SESSION['error_update_message']);
}

// for inserting echo
if (isset($_SESSION['success_insert_message'])) {
  echo "<script>alert('{$_SESSION['success_insert_message']}');</script>";
  unset($_SESSION['success_insert_message']);
}

if (isset($_SESSION['error_insert_message'])) {
  echo "<script>alert('{$_SESSION['error_insert_message']}');</script>";
  unset($_SESSION['error_insert_message']);
}

// for deleting echo
if (isset($_SESSION['success_delete_message'])) {
  echo "<script>alert('{$_SESSION['success_delete_message']}');</script>";
  unset($_SESSION['success_delete_message']);
}

if (isset($_SESSION['error_delete_message'])) {
  echo "<script>alert('{$_SESSION['error_delete_message']}');</script>";
  unset($_SESSION['error_delete_message']);
}

?>

<div class="container-fluid">
    <div class="row mt-5 mb-5">
        <div class="col mt-5">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title mb-4 d-inline fw-bold">Employee List</h3><br>
             	<a  href="employeeInsert.php" class="btn btn-success ms-3 mt-4 p-2 px-4 text-center float-right">Create</a>
              <table class="table table-striped ms-auto">
                <thead>
                  <tr>
                    <th scope="col" class="fw-bold">#</th>
                    <th scope="col" class="fw-bold">Id</th>
                    <th scope="col" class="fw-bold">Username</th>
                    <th scope="col" class="fw-bold">Name</th>
                    <th scope="col" class="fw-bold">Phone No.</th>
                    <th scope="col" class="fw-bold">Email</th>
                    <th scope="col" class="fw-bold">Remark</th>
                    <th scope="col" class="fw-bold">Update</th>
                    <th scope="col" class="fw-bold">Delete</th>
                  </tr>
                </thead>
                <tbody>
                <?php if (empty($allUsers)): ?>
                  <tr>
                    <td colspan="9">No data found.</td>
                  </tr>
                <?php else: ?>
                <?php $rowNumber = 1; ?>
									<?php foreach($allUsers as $user) : ?>
                  <tr>
                    <th scope="row"><?php echo $rowNumber++; ?></th>
                    <td><?php echo $user->id; ?></td>
                    <td><?php echo $user->username; ?></td>
                    <td><?php echo $user->name; ?></td>
                    <td><?php echo $user->phoneNo; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td><?php echo $user->remark; ?></td>
                    <td><a  href="employeeUpdate.php?id=<?php echo $user->id; ?>" class="btn btn-warning text-white text-center ">Update </a></td>
                    <td><a href="employeeDelete.php?id=<?php echo $user->id; ?>" class="btn btn-danger  text-center ">Delete </a></td>
                  </tr>
									<?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
            </table> 
          </div>
         </div>
    </div>
</div>

<?php 
require_once "./footer.php";
?>